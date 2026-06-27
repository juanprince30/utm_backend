@include('admin.sidebarAdmin')

@extends('main.index')

@section('content')
<div>

    {{-- Flash messages --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mx-4 mt-4" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="custom-container py-6">

        {{-- En-tête --}}
        <div class="d-flex align-items-center justify-content-between mb-6">
            <div>
                <h2 class="fw-bold mb-1">Tableau de bord</h2>
                <p class="text-secondary mb-0 small">Vue d'ensemble de la plateforme ArtisanFaso</p>
            </div>
            <span class="text-secondary small">{{ now()->format('d/m/Y') }}</span>
        </div>

        {{-- Cartes statistiques ligne 1 --}}
        <div class="row g-4 mb-6">
            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex align-items-center gap-4 p-4">
                        <div class="icon-shape icon-lg bg-primary-subtle text-primary rounded-circle flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0"/><path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"/></svg>
                        </div>
                        <div>
                            <p class="text-secondary mb-1 small">Utilisateurs</p>
                            <h3 class="fw-bold mb-0">{{ $stats['total_users'] }}</h3>
                            <small class="text-success">{{ $stats['users_actifs'] }} actifs</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex align-items-center gap-4 p-4">
                        <div class="icon-shape icon-lg bg-warning-subtle text-warning rounded-circle flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 21l18 0"/><path d="M3 7v1a3 3 0 0 0 6 0v-1m0 1a3 3 0 0 0 6 0v-1m0 1a3 3 0 0 0 6 0v-1h-18l2 -4h14l2 4"/><path d="M5 21l0 -10.15"/><path d="M19 21l0 -10.15"/><path d="M9 21v-4a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v4"/></svg>
                        </div>
                        <div>
                            <p class="text-secondary mb-1 small">Commerces</p>
                            <h3 class="fw-bold mb-0">{{ $stats['total_commerces'] }}</h3>
                            <small class="text-success">{{ $stats['commerces_publies'] }} publies</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex align-items-center gap-4 p-4">
                        <div class="icon-shape icon-lg bg-success-subtle text-success rounded-circle flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14 3v4a1 1 0 0 0 1 1h4"/><path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z"/></svg>
                        </div>
                        <div>
                            <p class="text-secondary mb-1 small">Services</p>
                            <h3 class="fw-bold mb-0">{{ $stats['total_services'] }}</h3>
                            <small class="text-success">{{ $stats['services_dispos'] }} disponibles</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex align-items-center gap-4 p-4">
                        <div class="icon-shape icon-lg bg-info-subtle text-info rounded-circle flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8 9h8"/><path d="M8 13h6"/><path d="M18 4a3 3 0 0 1 3 3v8a3 3 0 0 1 -3 3h-5l-5 3v-3h-2a3 3 0 0 1 -3 -3v-8a3 3 0 0 1 3 -3h12z"/></svg>
                        </div>
                        <div>
                            <p class="text-secondary mb-1 small">Commentaires</p>
                            <h3 class="fw-bold mb-0">{{ $stats['total_commentaires'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Cartes statistiques ligne 2 --}}
        <div class="row g-4 mb-6">
            <div class="col-xl-4 col-md-6">
                <div class="card border-0 shadow-sm p-4">
                    <p class="text-secondary small mb-3 fw-semibold text-uppercase" style="letter-spacing:.06em;">Utilisateurs</p>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="small">Actifs</span>
                        <span class="badge bg-success-subtle text-success rounded-pill">{{ $stats['users_actifs'] }}</span>
                    </div>
                    <div class="progress mb-3" style="height:6px;">
                        <div class="progress-bar bg-success" style="width:{{ $stats['total_users'] > 0 ? round($stats['users_actifs'] / $stats['total_users'] * 100) : 0 }}%"></div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="small">Certifies</span>
                        <span class="badge bg-primary-subtle text-primary rounded-pill">{{ $stats['users_certifies'] }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="small">Inactifs</span>
                        <span class="badge bg-danger-subtle text-danger rounded-pill">{{ $stats['users_inactifs'] }}</span>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6">
                <div class="card border-0 shadow-sm p-4">
                    <p class="text-secondary small mb-3 fw-semibold text-uppercase" style="letter-spacing:.06em;">Commerces</p>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="small">Publies</span>
                        <span class="badge bg-success-subtle text-success rounded-pill">{{ $stats['commerces_publies'] }}</span>
                    </div>
                    <div class="progress mb-3" style="height:6px;">
                        <div class="progress-bar bg-warning" style="width:{{ $stats['total_commerces'] > 0 ? round($stats['commerces_publies'] / $stats['total_commerces'] * 100) : 0 }}%"></div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="small">En attente</span>
                        <span class="badge bg-warning-subtle text-warning rounded-pill">{{ $stats['total_commerces'] - $stats['commerces_publies'] }}</span>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6">
                <div class="card border-0 shadow-sm p-4">
                    <p class="text-secondary small mb-3 fw-semibold text-uppercase" style="letter-spacing:.06em;">Services</p>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="small">Disponibles</span>
                        <span class="badge bg-success-subtle text-success rounded-pill">{{ $stats['services_dispos'] }}</span>
                    </div>
                    <div class="progress mb-3" style="height:6px;">
                        <div class="progress-bar bg-success" style="width:{{ $stats['total_services'] > 0 ? round($stats['services_dispos'] / $stats['total_services'] * 100) : 0 }}%"></div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="small">Indisponibles</span>
                        <span class="badge bg-danger-subtle text-danger rounded-pill">{{ $stats['total_services'] - $stats['services_dispos'] }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tableaux récents --}}
        <div class="row g-4">
            {{-- Derniers utilisateurs --}}
            <div class="col-xl-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-header d-flex justify-content-between align-items-center bg-white py-3 px-4">
                        <h6 class="mb-0 fw-semibold">Derniers utilisateurs</h6>
                        <a href="{{ route('admin.users') }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">Voir tout</a>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Nom</th>
                                        <th>Telephone</th>
                                        <th>Role</th>
                                        <th>Statut</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recent_users as $u)
                                    <tr>
                                        <td>
                                            <a href="{{ route('admin.users.show', $u) }}" class="fw-semibold text-decoration-none">
                                                {{ $u->prenom }} {{ $u->name }}
                                            </a>
                                        </td>
                                        <td class="text-secondary small">{{ $u->telephone }}</td>
                                        <td>
                                            <span class="badge rounded-pill {{ $u->role === 'admin' ? 'bg-danger-subtle text-danger' : 'bg-secondary-subtle text-secondary' }}">
                                                {{ $u->role }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($u->isActif)
                                                <span class="badge bg-success-subtle text-success rounded-pill">Actif</span>
                                            @else
                                                <span class="badge bg-danger-subtle text-danger rounded-pill">Inactif</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @empty
                                    <tr><td colspan="4" class="text-center text-secondary py-4">Aucun utilisateur.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Derniers commerces --}}
            <div class="col-xl-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-header d-flex justify-content-between align-items-center bg-white py-3 px-4">
                        <h6 class="mb-0 fw-semibold">Derniers commerces</h6>
                        <a href="{{ route('admin.commerces') }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">Voir tout</a>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Commerce</th>
                                        <th>Ville</th>
                                        <th>Proprietaire</th>
                                        <th>Statut</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recent_commerces as $c)
                                    <tr>
                                        <td>
                                            <a href="{{ route('admin.commerces.show', $c) }}" class="fw-semibold text-decoration-none">
                                                {{ $c->nomCormmercial }}
                                            </a>
                                        </td>
                                        <td class="text-secondary small">{{ $c->ville }}</td>
                                        <td class="text-secondary small">{{ $c->user?->prenom }} {{ $c->user?->name }}</td>
                                        <td>
                                            @if($c->etatPublication)
                                                <span class="badge bg-success-subtle text-success rounded-pill">Publie</span>
                                            @else
                                                <span class="badge bg-warning-subtle text-warning rounded-pill">En attente</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @empty
                                    <tr><td colspan="4" class="text-center text-secondary py-4">Aucun commerce.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

@include('main.navbarWithsidebar')
