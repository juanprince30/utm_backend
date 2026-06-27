@include('artisan.sidebarArtisan')

@extends('main.index')

@section('content')
<div>
  <div class="custom-container py-6">

    <div class="d-flex align-items-center justify-content-between mb-6">
      <div>
        <h2 class="fw-bold mb-1">Mes Commerces</h2>
        <p class="text-secondary mb-0 small">{{ $commerces->total() }} commerce(s) au total</p>
      </div>
      <a href="{{ route('artisan.commerces.create') }}" class="btn btn-primary rounded-pill px-4">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor"
             stroke-width="2" viewBox="0 0 24 24" class="me-1">
          <path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14"/><path d="M5 12l14 0"/>
        </svg>
        Ajouter un commerce
      </a>
    </div>

    @if(session('success'))
      <div class="alert alert-success alert-dismissible fade show mb-4">
        {{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    @endif

    @if($commerces->isEmpty())
      <div class="card border-0 shadow-sm">
        <div class="card-body text-center py-6">
          <div class="icon-shape icon-xl bg-primary-subtle text-primary rounded-circle mx-auto mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="none" stroke="currentColor"
                 stroke-width="1.5" viewBox="0 0 24 24">
              <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
              <path d="M3 21l18 0"/>
              <path d="M3 7v1a3 3 0 0 0 6 0v-1m0 1a3 3 0 0 0 6 0v-1m0 1a3 3 0 0 0 6 0v-1h-18l2 -4h14l2 4"/>
              <path d="M5 21l0 -10.15"/><path d="M19 21l0 -10.15"/>
              <path d="M9 21v-4a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v4"/>
            </svg>
          </div>
          <h5 class="fw-semibold mb-2">Aucun commerce pour l'instant</h5>
          <p class="text-secondary mb-4">Creez votre premier commerce pour le faire connaitre.</p>
          <a href="{{ route('artisan.commerces.create') }}" class="btn btn-primary rounded-pill px-5">Creer mon premier commerce</a>
        </div>
      </div>
    @else
      <div class="row g-4">
        @foreach($commerces as $c)
        <div class="col-xl-4 col-md-6">
          <div class="card border-0 shadow-sm h-100">

            {{-- Photo principale --}}
            @if(!empty($c->photos[0]))
              <img src="{{ asset('storage/' . $c->photos[0]) }}"
                   class="card-img-top object-fit-cover" style="height:180px;" alt="{{ $c->nomCormmercial }}">
            @else
              <div class="bg-light d-flex align-items-center justify-content-center" style="height:180px;">
                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="none" stroke="#ccc"
                     stroke-width="1" viewBox="0 0 24 24">
                  <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                  <path d="M15 8h.01"/><path d="M3 6a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v12a3 3 0 0 1 -3 3h-12a3 3 0 0 1 -3 -3v-12z"/>
                  <path d="M3 16l5 -5c.928 -.893 2.072 -.893 3 0l4 4"/>
                  <path d="M14 14l1 -1c.928 -.893 2.072 -.893 3 0l3 3"/>
                </svg>
              </div>
            @endif

            <div class="card-body">
              <div class="d-flex justify-content-between align-items-start mb-2">
                <h6 class="card-title fw-semibold mb-0">{{ $c->nomCormmercial }}</h6>
                @if($c->etatPublication === 'publie')
                  <span class="badge bg-success-subtle text-success rounded-pill">Publie</span>
                @elseif($c->etatPublication === 'retire')
                  <span class="badge bg-danger-subtle text-danger rounded-pill">Retire</span>
                @else
                  <span class="badge bg-warning-subtle text-warning rounded-pill">Brouillon</span>
                @endif
              </div>
              <p class="text-secondary small mb-1">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" stroke="currentColor"
                     stroke-width="2" viewBox="0 0 24 24" class="me-1">
                  <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                  <path d="M12 11m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0"/>
                  <path d="M17.657 16.657l-4.243 4.243a2 2 0 0 1 -2.827 0l-4.244 -4.243a8 8 0 1 1 11.314 0z"/>
                </svg>
                {{ $c->ville }}
              </p>
              <p class="text-secondary small mb-3">
                <span class="badge bg-info-subtle text-info rounded-pill">{{ $c->categorie }}</span>
                &nbsp;{{ $c->services_count ?? 0 }} service(s)
              </p>

              {{-- Actions de statut --}}
              <div class="d-flex gap-2 mb-3 flex-wrap">
                @if($c->etatPublication !== 'publie')
                  <form method="POST" action="{{ route('artisan.commerces.status', $c) }}">
                    @csrf @method('PATCH')
                    <input type="hidden" name="etat" value="publie">
                    <button type="submit" class="btn btn-sm btn-success rounded-pill px-3">Publier</button>
                  </form>
                @endif
                @if($c->etatPublication !== 'draft')
                  <form method="POST" action="{{ route('artisan.commerces.status', $c) }}">
                    @csrf @method('PATCH')
                    <input type="hidden" name="etat" value="draft">
                    <button type="submit" class="btn btn-sm btn-warning rounded-pill px-3">Brouillon</button>
                  </form>
                @endif
                @if($c->etatPublication !== 'retire')
                  <form method="POST" action="{{ route('artisan.commerces.status', $c) }}">
                    @csrf @method('PATCH')
                    <input type="hidden" name="etat" value="retire">
                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3">Retirer</button>
                  </form>
                @endif
              </div>

              {{-- Actions CRUD --}}
              <div class="d-flex gap-2">
                <a href="{{ route('artisan.commerces.edit', $c) }}"
                   class="btn btn-sm btn-outline-primary rounded-pill px-3 flex-grow-1">Modifier</a>
                <form method="POST" action="{{ route('artisan.commerces.destroy', $c) }}"
                      onsubmit="return confirm('Supprimer ce commerce et tous ses services ?')">
                  @csrf @method('DELETE')
                  <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" stroke="currentColor"
                         stroke-width="2" viewBox="0 0 24 24">
                      <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                      <path d="M4 7l16 0"/><path d="M10 11l0 6"/><path d="M14 11l0 6"/>
                      <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"/>
                      <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"/>
                    </svg>
                  </button>
                </form>
              </div>
            </div>

            @if(!empty($c->photos) && count($c->photos) > 1)
            <div class="card-footer bg-white border-top py-2 px-3">
              <small class="text-secondary">{{ count($c->photos) }} photo(s)</small>
            </div>
            @endif

          </div>
        </div>
        @endforeach
      </div>

      @if($commerces->hasPages())
        <div class="d-flex justify-content-center mt-5">
          {{ $commerces->links() }}
        </div>
      @endif
    @endif

  </div>
</div>
@endsection

@include('main.navbarWithsidebar')
