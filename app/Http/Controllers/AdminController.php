<?php

namespace App\Http\Controllers;

use App\Models\Commentaire;
use App\Models\Commerce;

use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    // ═══════════════════════════════════════════════
    // DASHBOARD
    // ═══════════════════════════════════════════════

    public function dashboard()
    {
        $stats = [
            'total_users'        => User::count(),
            'users_actifs'       => User::where('isActif', true)->count(),
            'users_inactifs'     => User::where('isActif', false)->count(),
            'users_certifies'    => User::where('isCertified', true)->count(),
            'total_commerces'    => Commerce::count(),
            'commerces_publies'  => Commerce::where('etatPublication', 'publie')->count(),
            'total_services'     => Service::count(),
            'services_dispos'    => Service::where('isAvaillable', true)->count(),
            'total_commentaires' => Commentaire::count(),
        ];

        $recent_users     = User::latest()->take(5)->get();
        $recent_commerces = Commerce::with('user')->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recent_users', 'recent_commerces'));
    }

    // ═══════════════════════════════════════════════
    // GESTION UTILISATEURS
    // ═══════════════════════════════════════════════

    public function users_index(Request $request)
    {
        $query = User::query();

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('name', 'ilike', "%$s%")
                  ->orWhere('prenom', 'ilike', "%$s%")
                  ->orWhere('telephone', 'like', "%$s%")
                  ->orWhere('email', 'ilike', "%$s%");
            });
        }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        $users = $query->latest()->paginate(15)->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    public function users_show(User $user)
    {
        $user->load('commerces.services', 'commentaires');
        return view('admin.users.show', compact('user'));
    }

    public function users_store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'      => 'required|string|max:255',
            'prenom'    => 'required|string|max:255',
            'telephone' => 'required|numeric|unique:users,telephone',
            'email'     => 'nullable|email|unique:users,email',
            'role'      => 'required|in:user,admin',
            'password'  => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        User::create([
            'name'      => $request->name,
            'prenom'    => $request->prenom,
            'telephone' => $request->telephone,
            'email'     => $request->email,
            'role'      => $request->role,
            'password'  => Hash::make($request->password),
        ]);

        return redirect()->route('admin.users')->with('success', 'Utilisateur cree avec succes.');
    }

    public function users_update(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'name'      => 'required|string|max:255',
            'prenom'    => 'required|string|max:255',
            'telephone' => 'required|numeric|unique:users,telephone,' . $user->id,
            'email'     => 'nullable|email|unique:users,email,' . $user->id,
            'role'      => 'required|in:user,admin',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $data = $request->only(['name', 'prenom', 'telephone', 'email', 'role', 'addresse']);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.users')->with('success', 'Utilisateur mis a jour.');
    }

    public function users_destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users')->with('success', 'Utilisateur supprime.');
    }

    public function users_toggle_actif(User $user)
    {
        $user->update(['isActif' => !$user->isActif]);
        $msg = $user->isActif ? 'Utilisateur active.' : 'Utilisateur desactive.';
        return back()->with('success', $msg);
    }

    public function users_toggle_commerce(User $user)
    {
        $user->update(['canCormmerce' => !$user->canCormmerce]);
        $msg = $user->canCormmerce ? 'Permission commerce accordee.' : 'Permission commerce retiree.';
        return back()->with('success', $msg);
    }

    public function users_toggle_certified(User $user)
    {
        $user->update(['isCertified' => !$user->isCertified]);
        $msg = $user->isCertified ? 'Utilisateur certifie.' : 'Certification retiree.';
        return back()->with('success', $msg);
    }

    // ═══════════════════════════════════════════════
    // GESTION COMMERCES
    // ═══════════════════════════════════════════════

    public function commerces_index(Request $request)
    {
        $query = Commerce::with('user');

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('nomCormmercial', 'ilike', "%$s%")
                  ->orWhere('ville', 'ilike', "%$s%")
                  ->orWhere('categorie', 'ilike', "%$s%");
            });
        }

        if ($request->filled('etat')) {
            $query->where('etatPublication', $request->etat);
        }

        $commerces = $query->latest()->paginate(15)->withQueryString();

        return view('admin.commerces.index', compact('commerces'));
    }

    public function commerces_show(Commerce $commerce)
    {
        $commerce->load('user', 'services', 'commentaires.user');
        return view('admin.commerces.show', compact('commerce'));
    }

    public function commerces_toggle_publication(Commerce $commerce)
    {
        $newEtat = $commerce->etatPublication === 'publie' ? 'draft' : 'publie';
        $commerce->update(['etatPublication' => $newEtat]);
        $msg = $newEtat === 'publie' ? 'Commerce publie.' : 'Commerce depublie (draft).';
        return back()->with('success', $msg);
    }

    public function commerces_destroy(Commerce $commerce)
    {
        $commerce->delete();
        return redirect()->route('admin.commerces')->with('success', 'Commerce supprime.');
    }

    // ═══════════════════════════════════════════════
    // GESTION SERVICES
    // ═══════════════════════════════════════════════

    public function services_index(Request $request)
    {
        $query = Service::with('commerce.user');

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('nomService', 'ilike', "%$s%")
                  ->orWhere('description', 'ilike', "%$s%");
            });
        }

        if ($request->filled('dispo')) {
            $query->where('isAvaillable', $request->dispo === '1');
        }

        $services = $query->latest()->paginate(15)->withQueryString();

        return view('admin.services.index', compact('services'));
    }

    public function services_show(Service $service)
    {
        $service->load('commerce.user', 'commentaires.user');
        return view('admin.services.show', compact('service'));
    }

    public function services_toggle_disponibilite(Service $service)
    {
        $service->update(['isAvaillable' => !$service->isAvaillable]);
        $msg = $service->isAvaillable ? 'Service disponible.' : 'Service indisponible.';
        return back()->with('success', $msg);
    }

    public function services_destroy(Service $service)
    {
        $service->delete();
        return redirect()->route('admin.services')->with('success', 'Service supprime.');
    }

    // ═══════════════════════════════════════════════
    // GESTION COMMENTAIRES
    // ═══════════════════════════════════════════════

    public function commentaires_index(Request $request)
    {
        $query = Commentaire::with(['user', 'commerce', 'service'])
            ->latest();

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where('body', 'ilike', "%$s%");
        }

        if ($request->filled('commerce')) {
            $query->where('idCommerce', $request->commerce);
        }

        $commentaires = $query->paginate(20)->withQueryString();
        $commerces    = Commerce::orderBy('nomCormmercial')->get(['id', 'nomCormmercial']);

        return view('admin.commentaires.index', compact('commentaires', 'commerces'));
    }

    public function commentaires_destroy(Commentaire $commentaire)
    {
        $commentaire->delete();
        return back()->with('success', 'Commentaire supprime.');
    }
}
