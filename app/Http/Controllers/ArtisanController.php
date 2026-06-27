<?php

namespace App\Http\Controllers;

use App\Models\Commerce;
use App\Models\Commentaire;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
