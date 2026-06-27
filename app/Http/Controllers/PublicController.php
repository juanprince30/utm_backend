<?php

namespace App\Http\Controllers;

use App\Models\Commerce;
use App\Models\Commentaire;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PublicController extends Controller
{
    private function haversine(float $lat1, float $lng1, float $lat2, float $lng2): float
    {
        $R    = 6371;
        $dLat = deg2rad($lat2 - $lat1);
        $dLng = deg2rad($lng2 - $lng1);
        $a    = sin($dLat / 2) ** 2 + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLng / 2) ** 2;
        return $R * 2 * atan2(sqrt($a), sqrt(1 - $a));
    }

    private function sortByDistance(\Illuminate\Support\Collection $items, ?float $lat, ?float $lng): \Illuminate\Support\Collection
    {
        if ($lat === null || $lng === null) {
            return $items;
        }
        return $items->sortBy(function ($c) use ($lat, $lng) {
            $pos = is_array($c->position) ? $c->position : json_decode($c->position, true);
            if (!isset($pos['lat'], $pos['lng'])) return PHP_INT_MAX;
            return $this->haversine($lat, $lng, (float)$pos['lat'], (float)$pos['lng']);
        })->values();
    }

    private function withDistance(\Illuminate\Support\Collection $items, ?float $lat, ?float $lng): \Illuminate\Support\Collection
    {
        if ($lat === null || $lng === null) return $items;
        return $items->map(function ($c) use ($lat, $lng) {
            $pos = is_array($c->position) ? $c->position : json_decode($c->position, true);
            if (isset($pos['lat'], $pos['lng'])) {
                $c->distance = round($this->haversine($lat, $lng, (float)$pos['lat'], (float)$pos['lng']), 1);
            }
            return $c;
        });
    }

    // ─── Welcome page catalogue ───────────────────────────────────
    public function welcome(Request $request)
    {
        $lat = $request->filled('lat') ? (float)$request->lat : null;
        $lng = $request->filled('lng') ? (float)$request->lng : null;

        $commerces = Commerce::with('user')
            ->where('etatPublication', 'publie')
            ->get();

        $commerces = $this->withDistance($commerces, $lat, $lng);
        $commerces = $this->sortByDistance($commerces, $lat, $lng)->take(8);

        return view('welcome', compact('commerces', 'lat', 'lng'));
    }

    // ─── Commerces index ─────────────────────────────────────────
    public function commerces_index(Request $request)
    {
        $lat       = $request->filled('lat') ? (float)$request->lat : null;
        $lng       = $request->filled('lng') ? (float)$request->lng : null;
        $search    = $request->input('search');
        $categorie = $request->input('categorie');
        $tri       = $request->input('tri', 'proximite');

        $query = Commerce::with('user')
            ->where('etatPublication', 'publie');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nomCormmercial', 'ilike', "%$search%")
                  ->orWhere('ville', 'ilike', "%$search%")
                  ->orWhere('categorie', 'ilike', "%$search%");
            });
        }
        if ($categorie) {
            $query->where('categorie', $categorie);
        }

        $commerces = $query->get();
        $commerces = $this->withDistance($commerces, $lat, $lng);

        if ($tri === 'proximite' && $lat !== null) {
            $commerces = $this->sortByDistance($commerces, $lat, $lng);
        } elseif ($tri === 'score') {
            $commerces = $commerces->sortByDesc('scoringCommerce')->values();
        } else {
            $commerces = $commerces->sortByDesc('created_at')->values();
        }

        $categories = Commerce::where('etatPublication', 'publie')
            ->distinct()->pluck('categorie')->sort()->values();

        return view('public.commerces.index', compact('commerces', 'categories', 'lat', 'lng'));
    }

    // ─── Commerce detail ─────────────────────────────────────────
    public function commerces_show(Request $request, Commerce $commerce)
    {
        if ($commerce->etatPublication !== 'publie') {
            abort(404);
        }

        $commerce->load(['user', 'services' => function ($q) {
            $q->where('etatPublication', 'publie');
        }, 'commentaires.user']);

        $lat = $request->filled('lat') ? (float)$request->lat : null;
        $lng = $request->filled('lng') ? (float)$request->lng : null;

        $pos = json_decode($commerce->position, true);

        return view('public.commerces.show', compact('commerce', 'pos', 'lat', 'lng'));
    }

    // ─── Poster commentaire sur un commerce ──────────────────────
    public function commerce_comment(Request $request, Commerce $commerce)
    {
        if ($commerce->etatPublication !== 'publie') abort(404);
        if ($commerce->IdUser === Auth::id()) {
            return back()->with('error', 'Vous ne pouvez pas commenter votre propre commerce.');
        }

        $request->validate(['body' => 'required|string|max:500']);

        Commentaire::create([
            'body'       => $request->body,
            'idCommerce' => $commerce->id,
            'IdUser'     => Auth::id(),
        ]);

        return back()->with('success', 'Commentaire ajoute.');
    }

    // ─── Services index ──────────────────────────────────────────
    public function services_index(Request $request)
    {
        $lat       = $request->filled('lat') ? (float)$request->lat : null;
        $lng       = $request->filled('lng') ? (float)$request->lng : null;
        $search    = $request->input('search');
        $categorie = $request->input('categorie');
        $tri       = $request->input('tri', 'proximite');

        $query = Service::with(['commerce.user'])
            ->where('etatPublication', 'publie')
            ->whereHas('commerce', fn($q) => $q->where('etatPublication', 'publie'));

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nomService', 'ilike', "%$search%")
                  ->orWhere('description', 'ilike', "%$search%");
            });
        }

        $services = $query->get();

        // Attach distance via commerce position
        if ($lat !== null) {
            $services = $services->map(function ($s) use ($lat, $lng) {
                $pos = json_decode($s->commerce?->position ?? '{}', true);
                if (isset($pos['lat'], $pos['lng'])) {
                    $s->distance = round($this->haversine($lat, $lng, (float)$pos['lat'], (float)$pos['lng']), 1);
                }
                return $s;
            });
        }

        if ($tri === 'proximite' && $lat !== null) {
            $services = $services->sortBy(fn($s) => $s->distance ?? PHP_INT_MAX)->values();
        } elseif ($tri === 'score') {
            $services = $services->sortByDesc('scoringService')->values();
        } elseif ($tri === 'prix_asc') {
            $services = $services->sortBy('prixService')->values();
        } elseif ($tri === 'prix_desc') {
            $services = $services->sortByDesc('prixService')->values();
        } else {
            $services = $services->sortByDesc('created_at')->values();
        }

        $categories = Commerce::where('etatPublication', 'publie')
            ->distinct()->pluck('categorie')->sort()->values();

        return view('public.services.index', compact('services', 'categories', 'lat', 'lng'));
    }
}
