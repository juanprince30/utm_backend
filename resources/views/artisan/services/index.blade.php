@include('artisan.sidebarArtisan')

@extends('main.index')

@section('content')
<div>
  <div class="custom-container py-6">

    <div class="d-flex align-items-center justify-content-between mb-6">
      <div>
        <h2 class="fw-bold mb-1">Mes Services</h2>
        <p class="text-secondary mb-0 small">{{ $services->total() }} service(s) au total</p>
      </div>
      <a href="{{ route('artisan.services.create') }}" class="btn btn-primary rounded-pill px-4">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor"
             stroke-width="2" viewBox="0 0 24 24" class="me-1">
          <path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14"/><path d="M5 12l14 0"/>
        </svg>
        Ajouter un service
      </a>
    </div>

    @if(session('success'))
      <div class="alert alert-success alert-dismissible fade show mb-4">
        {{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    @endif

    @if($services->isEmpty())
      <div class="card border-0 shadow-sm">
        <div class="card-body text-center py-6">
          <div class="icon-shape icon-xl bg-primary-subtle text-primary rounded-circle mx-auto mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="none" stroke="currentColor"
                 stroke-width="1.5" viewBox="0 0 24 24">
              <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
              <path d="M12 3l8 4v10l-8 4l-8 -4v-10z"/>
              <path d="M12 3v18"/><path d="M4 7l8 4l8 -4"/>
            </svg>
          </div>
          <h5 class="fw-semibold mb-2">Aucun service pour l'instant</h5>
          <p class="text-secondary mb-4">Ajoutez des services a vos commerces pour attirer plus de clients.</p>
          <a href="{{ route('artisan.services.create') }}" class="btn btn-primary rounded-pill px-5">Creer mon premier service</a>
        </div>
      </div>
    @else
      <div class="row g-4">
        @foreach($services as $s)
        <div class="col-xl-4 col-md-6">
          <div class="card border-0 shadow-sm h-100">

            {{-- Photo --}}
            @if($s->photo)
              <img src="{{ asset('storage/' . $s->photo) }}"
                   class="card-img-top object-fit-cover" style="height:160px;" alt="{{ $s->nomService }}">
            @else
              <div class="bg-light d-flex align-items-center justify-content-center" style="height:160px;">
                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="none" stroke="#ccc"
                     stroke-width="1" viewBox="0 0 24 24">
                  <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                  <path d="M15 8h.01"/>
                  <path d="M3 6a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v12a3 3 0 0 1 -3 3h-12a3 3 0 0 1 -3 -3v-12z"/>
                  <path d="M3 16l5 -5c.928 -.893 2.072 -.893 3 0l4 4"/>
                  <path d="M14 14l1 -1c.928 -.893 2.072 -.893 3 0l3 3"/>
                </svg>
              </div>
            @endif

            <div class="card-body">
              <div class="d-flex justify-content-between align-items-start mb-2">
                <h6 class="card-title fw-semibold mb-0">{{ $s->nomService }}</h6>
                @if($s->etatPublication === 'publie')
                  <span class="badge bg-success-subtle text-success rounded-pill">Publie</span>
                @elseif($s->etatPublication === 'retire')
                  <span class="badge bg-danger-subtle text-danger rounded-pill">Retire</span>
                @else
                  <span class="badge bg-warning-subtle text-warning rounded-pill">Brouillon</span>
                @endif
              </div>

              @if($s->description)
                <p class="text-secondary small mb-2" style="line-clamp:2;">{{ Str::limit($s->description, 80) }}</p>
              @endif

              <div class="d-flex justify-content-between align-items-center mb-3">
                <span class="fw-bold text-primary">{{ number_format($s->prixService, 0, ',', ' ') }} FCFA</span>
                <span class="text-secondary small">{{ $s->commerce?->nomCormmercial }}</span>
              </div>

              {{-- Actions de statut --}}
              <div class="d-flex gap-2 mb-3 flex-wrap">
                @if($s->etatPublication !== 'publie')
                  <form method="POST" action="{{ route('artisan.services.status', $s) }}">
                    @csrf @method('PATCH')
                    <input type="hidden" name="etat" value="publie">
                    <button type="submit" class="btn btn-sm btn-success rounded-pill px-3">Publier</button>
                  </form>
                @endif
                @if($s->etatPublication !== 'draft')
                  <form method="POST" action="{{ route('artisan.services.status', $s) }}">
                    @csrf @method('PATCH')
                    <input type="hidden" name="etat" value="draft">
                    <button type="submit" class="btn btn-sm btn-warning rounded-pill px-3">Brouillon</button>
                  </form>
                @endif
                @if($s->etatPublication !== 'retire')
                  <form method="POST" action="{{ route('artisan.services.status', $s) }}">
                    @csrf @method('PATCH')
                    <input type="hidden" name="etat" value="retire">
                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3">Retirer</button>
                  </form>
                @endif
              </div>

              {{-- Actions CRUD --}}
              <div class="d-flex gap-2">
                <a href="{{ route('artisan.services.edit', $s) }}"
                   class="btn btn-sm btn-outline-primary rounded-pill px-3 flex-grow-1">Modifier</a>
                <form method="POST" action="{{ route('artisan.services.destroy', $s) }}"
                      onsubmit="return confirm('Supprimer ce service ?')">
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

          </div>
        </div>
        @endforeach
      </div>

      @if($services->hasPages())
        <div class="d-flex justify-content-center mt-5">
          {{ $services->links() }}
        </div>
      @endif
    @endif

  </div>
</div>
@endsection

@include('main.navbarWithsidebar')
