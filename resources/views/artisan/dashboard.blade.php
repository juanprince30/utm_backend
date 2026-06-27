@include('artisan.sidebarArtisan')

@extends('main.index')

@section('content')
<div>

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
        <h2 class="fw-bold mb-1">Bonjour, {{ Auth::user()->prenom }} !</h2>
        <p class="text-secondary mb-0 small">Voici un apercu de votre espace artisan</p>
      </div>
      <div class="d-flex gap-2">
        <a href="{{ route('artisan.commerces.create') }}" class="btn btn-primary rounded-pill px-4">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor"
               stroke-width="2" viewBox="0 0 24 24" class="me-1">
            <path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14"/><path d="M5 12l14 0"/>
          </svg>
          Nouveau Commerce
        </a>
        <a href="{{ route('artisan.services.create') }}" class="btn btn-outline-primary rounded-pill px-4">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor"
               stroke-width="2" viewBox="0 0 24 24" class="me-1">
            <path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14"/><path d="M5 12l14 0"/>
          </svg>
          Nouveau Service
        </a>
      </div>
    </div>

    {{-- Cartes statistiques --}}
    <div class="row g-4 mb-6">
      <div class="col-xl-3 col-md-6">
        <div class="card border-0 shadow-sm h-100">
          <div class="card-body d-flex align-items-center gap-4 p-4">
            <div class="icon-shape icon-lg bg-warning-subtle text-warning rounded-circle flex-shrink-0">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor"
                   stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                <path d="M3 21l18 0"/>
                <path d="M3 7v1a3 3 0 0 0 6 0v-1m0 1a3 3 0 0 0 6 0v-1m0 1a3 3 0 0 0 6 0v-1h-18l2 -4h14l2 4"/>
                <path d="M5 21l0 -10.15"/><path d="M19 21l0 -10.15"/>
                <path d="M9 21v-4a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v4"/>
              </svg>
            </div>
            <div>
              <p class="text-secondary mb-1 small">Commerces</p>
              <h3 class="fw-bold mb-0">{{ $stats['total_commerces'] }}</h3>
              <small class="text-success">{{ $stats['commerces_publies'] }} publie(s)</small>
            </div>
          </div>
        </div>
      </div>

      <div class="col-xl-3 col-md-6">
        <div class="card border-0 shadow-sm h-100">
          <div class="card-body d-flex align-items-center gap-4 p-4">
            <div class="icon-shape icon-lg bg-success-subtle text-success rounded-circle flex-shrink-0">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor"
                   stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                <path d="M12 3l8 4v10l-8 4l-8 -4v-10z"/>
                <path d="M12 3v18"/><path d="M4 7l8 4l8 -4"/>
              </svg>
            </div>
            <div>
              <p class="text-secondary mb-1 small">Services</p>
              <h3 class="fw-bold mb-0">{{ $stats['total_services'] }}</h3>
              <small class="text-success">{{ $stats['services_publies'] }} publie(s)</small>
            </div>
          </div>
        </div>
      </div>

      <div class="col-xl-3 col-md-6">
        <div class="card border-0 shadow-sm h-100">
          <div class="card-body d-flex align-items-center gap-4 p-4">
            <div class="icon-shape icon-lg bg-secondary-subtle text-secondary rounded-circle flex-shrink-0">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor"
                   stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                <path d="M4 6h16"/><path d="M4 12h16"/><path d="M4 18h16"/>
              </svg>
            </div>
            <div>
              <p class="text-secondary mb-1 small">En brouillon</p>
              <h3 class="fw-bold mb-0">{{ $stats['commerces_draft'] }}</h3>
              <small class="text-secondary">commerce(s)</small>
            </div>
          </div>
        </div>
      </div>

      <div class="col-xl-3 col-md-6">
        <div class="card border-0 shadow-sm h-100">
          <div class="card-body d-flex align-items-center gap-4 p-4">
            <div class="icon-shape icon-lg bg-danger-subtle text-danger rounded-circle flex-shrink-0">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor"
                   stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0"/>
                <path d="M9 12l6 0"/>
              </svg>
            </div>
            <div>
              <p class="text-secondary mb-1 small">Retires</p>
              <h3 class="fw-bold mb-0">{{ $stats['commerces_retires'] }}</h3>
              <small class="text-secondary">commerce(s)</small>
            </div>
          </div>
        </div>
      </div>
    </div>

    {{-- Derniers commerces --}}
    <div class="card border-0 shadow-sm">
      <div class="card-header d-flex justify-content-between align-items-center bg-white py-3 px-4">
        <h6 class="mb-0 fw-semibold">Mes derniers commerces</h6>
        <a href="{{ route('artisan.commerces') }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">Voir tout</a>
      </div>
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table table-hover mb-0 align-middle">
            <thead class="table-light">
              <tr>
                <th>Commerce</th>
                <th>Ville</th>
                <th>Categorie</th>
                <th>Services</th>
                <th>Statut</th>
                <th class="text-end">Actions</th>
              </tr>
            </thead>
            <tbody>
              @forelse($recent_commerces as $c)
              <tr>
                <td class="fw-semibold">{{ $c->nomCormmercial }}</td>
                <td class="text-secondary small">{{ $c->ville }}</td>
                <td><span class="badge bg-info-subtle text-info rounded-pill">{{ $c->categorie }}</span></td>
                <td class="text-secondary small">{{ $c->services->count() }}</td>
                <td>
                  @if($c->etatPublication === 'publie')
                    <span class="badge bg-success-subtle text-success rounded-pill">Publie</span>
                  @elseif($c->etatPublication === 'retire')
                    <span class="badge bg-danger-subtle text-danger rounded-pill">Retire</span>
                  @else
                    <span class="badge bg-warning-subtle text-warning rounded-pill">Brouillon</span>
                  @endif
                </td>
                <td class="text-end">
                  <a href="{{ route('artisan.commerces.edit', $c) }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3">Modifier</a>
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="6" class="text-center text-secondary py-5">
                  Aucun commerce.
                  <a href="{{ route('artisan.commerces.create') }}" class="d-block mt-2 btn btn-sm btn-primary rounded-pill px-4">
                    Creer mon premier commerce
                  </a>
                </td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>

  </div>
</div>
@endsection

@include('main.navbarWithsidebar')
