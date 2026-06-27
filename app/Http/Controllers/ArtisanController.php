<?php

namespace App\Http\Controllers;

use App\Models\Commerce;
use App\Models\Commentaire;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ArtisanController extends Controller
{
    // ═══════════════════════════════════════════════
    // DASHBOARD
    // ═══════════════════════════════════════════════

    public function dashboard()
    {
        $user = Auth::user();
        $commerces = Commerce::where('IdUser', $user->id)->with('services')->get();

        $stats = [
            'total_commerces'    => $commerces->count(),
            'commerces_publies'  => $commerces->where('etatPublication', 'publie')->count(),
            'commerces_draft'    => $commerces->where('etatPublication', 'draft')->count(),
            'commerces_retires'  => $commerces->where('etatPublication', 'retire')->count(),
            'total_services'     => $commerces->sum(fn($c) => $c->services->count()),
            'services_publies'   => $commerces->sum(fn($c) => $c->services->where('etatPublication', 'publie')->count()),
        ];

        $recent_commerces = Commerce::where('IdUser', $user->id)->latest()->take(5)->get();

        return view('artisan.dashboard', compact('stats', 'recent_commerces', 'user'));
    }

    // ═══════════════════════════════════════════════
    // COMMERCES
    // ═══════════════════════════════════════════════

    public function commerces_index()
    {
        $commerces = Commerce::where('IdUser', Auth::id())
            ->withCount('services')
            ->latest()
            ->paginate(12);

        return view('artisan.commerces.index', compact('commerces'));
    }

    public function commerces_create()
    {
        return view('artisan.commerces.create');
    }

    public function commerces_store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nomCormmercial'      => 'required|string|max:255',
            'categorie'           => 'required|string|max:255',
            'ville'               => 'required|string|max:255',
            'description'         => 'required|string|min:40|max:2000',
            'position_lat'        => 'required|numeric',
            'position_lng'        => 'required|numeric',
            'emailCommerce'       => 'nullable|email',
            'conctactResponsable' => 'required|numeric',
            'lienCommerce'        => 'nullable|url|max:255',
            'photos'              => 'required|array|min:1|max:6',
            'photos.*'            => 'image|mimes:jpeg,png,jpg,webp|max:3072',
            'horaire'             => 'nullable|array',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $photosPaths = [];
        foreach ($request->file('photos') as $photo) {
            $photosPaths[] = $photo->store('commerces', 'public');
        }

        $position = json_encode([
            'lat' => (float) $request->position_lat,
            'lng' => (float) $request->position_lng,
        ]);

        $horaire = $request->horaire ?? [];

        Commerce::create([
            'nomCormmercial'      => $request->nomCormmercial,
            'categorie'           => $request->categorie,
            'position'            => $position,
            'ville'               => $request->ville,
            'description'         => $request->description,
            'horaire'             => $horaire,
            'emailCommerce'       => $request->emailCommerce,
            'conctactResponsable' => $request->conctactResponsable,
            'etatPublication'     => 'draft',
            'lienCommerce'        => $request->lienCommerce,
            'scoringCommerce'     => 0,
            'photos'              => $photosPaths,
            'IdUser'              => Auth::id(),
        ]);

        return redirect()->route('artisan.commerces')->with('success', 'Commerce cree avec succes. Il est en brouillon.');
    }

    // ═══════════════════════════════════════════════
    // VERIFICATION IA DE LA DESCRIPTION DU LOCAL
    // Appele en AJAX avant l'enregistrement.
    // Retourne : { ok, message, example, suggestions[] }
    // ═══════════════════════════════════════════════

    public function commerces_verify_description(Request $request)
    {
        $request->validate([
            'description' => 'nullable|string|max:2000',
            'nom'         => 'nullable|string|max:255',
            'categorie'   => 'nullable|string|max:255',
            'ville'       => 'nullable|string|max:255',
        ]);

        $description = trim((string) $request->description);
        $nom         = trim((string) $request->nom);
        $categorie   = trim((string) $request->categorie);
        $ville       = trim((string) $request->ville);

        // 1) Si une IA externe est configuree (FastAPI / LLM), on la sollicite.
        $aiUrl = config('services.description_ai.url');
        if ($aiUrl) {
            try {
                $resp = Http::timeout(15)->acceptJson()->post($aiUrl, [
                    'description' => $description,
                    'nom'         => $nom,
                    'categorie'   => $categorie,
                    'ville'       => $ville,
                ]);

                if ($resp->successful()) {
                    $data = $resp->json();
                    return response()->json([
                        'ok'          => (bool) ($data['ok'] ?? false),
                        'message'     => $data['message'] ?? '',
                        'example'     => $data['example'] ?? '',
                        'suggestions' => $data['suggestions'] ?? [],
                    ]);
                }
            } catch (\Throwable $e) {
                // En cas d'echec on bascule sur l'analyse locale ci-dessous.
            }
        }

        // 2) Repli : analyse heuristique locale de l'exhaustivite.
        return response()->json($this->evaluateDescription($description, $nom, $categorie, $ville));
    }

    /**
     * Analyse locale d'une description de local.
     * Verifie la longueur et la presence d'elements cles
     * (activite, produits/services, localisation, atouts, contact).
     */
    private function evaluateDescription(string $description, string $nom, string $categorie, string $ville): array
    {
        $text  = mb_strtolower($description);
        $words = preg_split('/\s+/', trim($text), -1, PREG_SPLIT_NO_EMPTY);
        $wordCount = count($words);

        $checks = [
            'activite'     => ['label' => "l'activite principale du commerce",
                               'kw' => ['vend', 'propos', 'specialis', 'offre', 'fabriqu', 'repar', 'service', 'produit', 'activit']],
            'localisation' => ['label' => "la localisation precise (quartier, rue, reperes)",
                               'kw' => ['quartier', 'rue', 'avenue', 'secteur', 'pres de', 'à côté', 'a cote', 'situe', 'situé', 'face', 'marche', 'marché', 'zone']],
            'offre'        => ['label' => "les produits ou services proposes",
                               'kw' => ['produit', 'service', 'gamme', 'modele', 'modèle', 'article', 'plat', 'menu', 'piece', 'pièce', 'reparation', 'réparation', 'sur mesure']],
            'atouts'       => ['label' => "vos atouts (qualite, experience, prix, garantie)",
                               'kw' => ['qualit', 'experience', 'expérience', 'an ', 'ans', 'garanti', 'prix', 'rapide', 'livraison', 'certifi', 'professionnel', 'savoir-faire']],
            'contact'      => ['label' => "les modalites de contact ou horaires",
                               'kw' => ['horaire', 'ouvert', 'contact', 'telephone', 'téléphone', 'appel', 'whatsapp', 'rendez-vous', 'commande']],
        ];

        $missing = [];
        foreach ($checks as $item) {
            $found = false;
            foreach ($item['kw'] as $kw) {
                if (str_contains($text, $kw)) { $found = true; break; }
            }
            if (!$found) {
                $missing[] = $item['label'];
            }
        }

        $tooShort = $wordCount < 25;
        $ok = !$tooShort && count($missing) <= 1;

        if ($ok) {
            return [
                'ok'          => true,
                'message'     => 'Votre description est claire et suffisamment complete. Vous pouvez enregistrer.',
                'example'     => '',
                'suggestions' => [],
            ];
        }

        $message = $tooShort
            ? "Votre description est trop courte et n'est pas assez exhaustive. Detaillez davantage votre local pour aider les clients (et notre moteur de recherche) a le trouver."
            : "Votre description manque de details importants. Pour etre exhaustive, pensez a preciser : " . implode(', ', $missing) . '.';

        return [
            'ok'          => false,
            'message'     => $message,
            'example'     => $this->buildExampleDescription($nom, $categorie, $ville),
            'suggestions' => $missing,
        ];
    }

    /**
     * Construit un exemple de description exhaustive a partir
     * des informations deja saisies dans le formulaire.
     */
    private function buildExampleDescription(string $nom, string $categorie, string $ville): string
    {
        $nom       = $nom !== '' ? $nom : 'Notre établissement';
        $categorie = $categorie !== '' ? mb_strtolower($categorie) : 'commerce';
        $ville     = $ville !== '' ? $ville : 'votre ville';

        return "{$nom} est un commerce spécialisé en {$categorie}, situé à {$ville}, dans le quartier "
            . "(précisez le quartier et un repère connu, ex : non loin du grand marché). "
            . "Nous proposons (listez vos principaux produits ou services, ex : articles, modèles, prestations sur mesure). "
            . "Nos atouts : (ex : plus de 5 ans d'expérience, produits de qualité, prix accessibles, livraison rapide, garantie). "
            . "Nous sommes ouverts du lundi au samedi de 08h à 18h. "
            . "Pour toute commande ou information, contactez-nous par téléphone / WhatsApp.";
    }

    public function commerces_edit(Commerce $commerce)
    {
        $this->authorizeCommerce($commerce);
        return view('artisan.commerces.edit', compact('commerce'));
    }

    public function commerces_update(Request $request, Commerce $commerce)
    {
        $this->authorizeCommerce($commerce);

        $validator = Validator::make($request->all(), [
            'nomCormmercial'      => 'required|string|max:255',
            'categorie'           => 'required|string|max:255',
            'ville'               => 'required|string|max:255',
            'description'         => 'required|string|min:40|max:2000',
            'position_lat'        => 'required|numeric',
            'position_lng'        => 'required|numeric',
            'emailCommerce'       => 'nullable|email',
            'conctactResponsable' => 'required|numeric',
            'lienCommerce'        => 'nullable|url|max:255',
            'new_photos'          => 'nullable|array|max:6',
            'new_photos.*'        => 'image|mimes:jpeg,png,jpg,webp|max:3072',
            'horaire'             => 'nullable|array',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $photosPaths = $commerce->photos ?? [];

        // Supprimer les photos cochées
        if ($request->filled('delete_photos')) {
            foreach ($request->delete_photos as $idx) {
                if (isset($photosPaths[$idx])) {
                    Storage::disk('public')->delete($photosPaths[$idx]);
                    unset($photosPaths[$idx]);
                }
            }
            $photosPaths = array_values($photosPaths);
        }

        // Ajouter les nouvelles photos
        if ($request->hasFile('new_photos')) {
            foreach ($request->file('new_photos') as $photo) {
                $photosPaths[] = $photo->store('commerces', 'public');
            }
        }

        $position = json_encode([
            'lat' => (float) $request->position_lat,
            'lng' => (float) $request->position_lng,
        ]);

        $commerce->update([
            'nomCormmercial'      => $request->nomCormmercial,
            'categorie'           => $request->categorie,
            'position'            => $position,
            'ville'               => $request->ville,
            'description'         => $request->description,
            'horaire'             => $request->horaire ?? [],
            'emailCommerce'       => $request->emailCommerce,
            'conctactResponsable' => $request->conctactResponsable,
            'lienCommerce'        => $request->lienCommerce,
            'photos'              => $photosPaths,
        ]);

        return redirect()->route('artisan.commerces')->with('success', 'Commerce mis a jour.');
    }

    public function commerces_status(Request $request, Commerce $commerce)
    {
        $this->authorizeCommerce($commerce);

        $request->validate(['etat' => 'required|in:publie,draft,retire']);

        $commerce->update(['etatPublication' => $request->etat]);

        $labels = ['publie' => 'publie', 'draft' => 'mis en brouillon', 'retire' => 'retire'];
        return back()->with('success', 'Commerce ' . $labels[$request->etat] . '.');
    }

    public function commerces_destroy(Commerce $commerce)
    {
        $this->authorizeCommerce($commerce);

        foreach ($commerce->photos ?? [] as $photo) {
            Storage::disk('public')->delete($photo);
        }

        $commerce->delete();
        return redirect()->route('artisan.commerces')->with('success', 'Commerce supprime.');
    }

    // ═══════════════════════════════════════════════
    // SERVICES
    // ═══════════════════════════════════════════════

    public function services_index()
    {
        $commerceIds = Commerce::where('IdUser', Auth::id())->pluck('id');
        $services = Service::whereIn('idCommerce', $commerceIds)
            ->with('commerce')
            ->latest()
            ->paginate(12);

        return view('artisan.services.index', compact('services'));
    }

    public function services_create()
    {
        $commerces = Commerce::where('IdUser', Auth::id())->get();
        return view('artisan.services.create', compact('commerces'));
    }

    public function services_store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nomService'   => 'required|string|max:255',
            'description'  => 'nullable|string|max:255',
            'prixService'  => 'required|numeric|min:0',
            'photo'        => 'required|image|mimes:jpeg,png,jpg,webp|max:3072',
            'idCommerce'   => 'required|exists:commerces,id',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Vérifier que le commerce appartient à l'artisan
        $commerce = Commerce::where('id', $request->idCommerce)
            ->where('IdUser', Auth::id())
            ->firstOrFail();

        $photoPath = $request->file('photo')->store('services', 'public');

        Service::create([
            'nomService'      => $request->nomService,
            'description'     => $request->description,
            'prixService'     => $request->prixService,
            'isAvaillable'    => true,
            'photo'           => $photoPath,
            'scoringService'  => 0,
            'idCommerce'      => $commerce->id,
            'etatPublication' => 'draft',
        ]);

        return redirect()->route('artisan.services')->with('success', 'Service cree avec succes. Il est en brouillon.');
    }

    public function services_edit(Service $service)
    {
        $this->authorizeService($service);
        $commerces = Commerce::where('IdUser', Auth::id())->get();
        return view('artisan.services.edit', compact('service', 'commerces'));
    }

    public function services_update(Request $request, Service $service)
    {
        $this->authorizeService($service);

        $validator = Validator::make($request->all(), [
            'nomService'   => 'required|string|max:255',
            'description'  => 'nullable|string|max:255',
            'prixService'  => 'required|numeric|min:0',
            'photo'        => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
            'idCommerce'   => 'required|exists:commerces,id',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        Commerce::where('id', $request->idCommerce)
            ->where('IdUser', Auth::id())
            ->firstOrFail();

        $photoPath = $service->photo;
        if ($request->hasFile('photo')) {
            Storage::disk('public')->delete($photoPath);
            $photoPath = $request->file('photo')->store('services', 'public');
        }

        $service->update([
            'nomService'   => $request->nomService,
            'description'  => $request->description,
            'prixService'  => $request->prixService,
            'photo'        => $photoPath,
            'idCommerce'   => $request->idCommerce,
        ]);

        return redirect()->route('artisan.services')->with('success', 'Service mis a jour.');
    }

    public function services_status(Request $request, Service $service)
    {
        $this->authorizeService($service);

        $request->validate(['etat' => 'required|in:publie,draft,retire']);

        $service->update(['etatPublication' => $request->etat]);

        $labels = ['publie' => 'publie', 'draft' => 'mis en brouillon', 'retire' => 'retire'];
        return back()->with('success', 'Service ' . $labels[$request->etat] . '.');
    }

    public function services_destroy(Service $service)
    {
        $this->authorizeService($service);

        Storage::disk('public')->delete($service->photo);
        $service->delete();

        return redirect()->route('artisan.services')->with('success', 'Service supprime.');
    }

    // ═══════════════════════════════════════════════
    // COMMENTAIRES
    // ═══════════════════════════════════════════════

    public function commentaires_index()
    {
        $commerceIds = Commerce::where('IdUser', Auth::id())->pluck('id');

        $commentaires = Commentaire::with(['user', 'commerce', 'service'])
            ->whereIn('idCommerce', $commerceIds)
            ->latest()
            ->paginate(20);

        $commerces = Commerce::where('IdUser', Auth::id())
            ->withCount('commentaires')
            ->with(['commentaires.user' => fn($q) => $q->latest()])
            ->get();

        return view('artisan.commentaires.index', compact('commentaires', 'commerces'));
    }

    // ═══════════════════════════════════════════════
    // HELPERS
    // ═══════════════════════════════════════════════

    private function authorizeCommerce(Commerce $commerce): void
    {
        if ($commerce->IdUser !== Auth::id()) {
            abort(403);
        }
    }

    private function authorizeService(Service $service): void
    {
        $ownerIds = Commerce::where('IdUser', Auth::id())->pluck('id');
        if (!$ownerIds->contains($service->idCommerce)) {
            abort(403);
        }
    }
}
