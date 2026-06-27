@include('admin.sidebarAdmin')

@extends('main.index')

@section('content')
<div>
  <div class="custom-container py-6">

    {{-- En-tête --}}
    <div class="d-flex align-items-center gap-3 mb-6">
      <a href="{{ route('admin.services') }}" class="btn btn-ghost btn-icon rounded-circle">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l14 0"/><path d="M5 12l6 6"/><path d="M5 12l6 -6"/></svg>
      </a>
      <div>
        <h2 class="fw-bold mb-0">{{ $service->nomService }}</h2>
        <p class="text-secondary mb-0 small">Service #{{ $service->id }}</p>
      </div>
    </div>

    @if(session('success'))
      <div class="alert alert-success alert-dismissible fade show mb-4">{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
    @endif

    <div class="row g-4">

      {{-- Colonne gauche --}}
      <div class="col-xl-4">

        {{-- Photo --}}
        @if($service->photo)
        <div class="card border-0 shadow-sm mb-4 overflow-hidden">
          <img src="{{ asset('storage/' . $service->photo) }}" class="w-100" style="height:220px;object-fit:cover;" alt="{{ $service->nomService }}">
        </div>
        @endif

        {{-- Actions --}}
        <div class="card border-0 shadow-sm mb-4">
          <div class="card-header bg-white py-3 px-4"><h6 class="mb-0 fw-semibold">Statut & Actions</h6></div>
          <div class="card-body p-3 d-grid gap-2">
            <div class="d-flex align-items-center justify-content-between p-2">
              <span class="small text-secondary">Publication</span>
              @if($service->etatPublication === 'publie')
                <span class="badge bg-success-subtle text-success rounded-pill">Publie</span>
              @elseif($service->etatPublication === 'retire')
                <span class="badge bg-danger-subtle text-danger rounded-pill">Retire</span>
              @else
                <span class="badge bg-warning-subtle text-warning rounded-pill">Draft</span>
              @endif
            </div>
            <div class="d-flex align-items-center justify-content-between p-2">
              <span class="small text-secondary">Disponibilite</span>
              <form method="POST" action="{{ route('admin.services.disponibilite', $service) }}">
                @csrf @method('PATCH')
                <button type="submit" class="btn btn-sm rounded-pill {{ $service->isAvaillable ? 'btn-success' : 'btn-outline-secondary' }}">
                  {{ $service->isAvaillable ? 'Disponible' : 'Indisponible' }}
                </button>
              </form>
            </div>
            <form method="POST" action="{{ route('admin.services.destroy', $service) }}"
                  onsubmit="return confirm('Supprimer ce service ?')">
              @csrf @method('DELETE')
              <button type="submit" class="btn btn-sm btn-outline-danger w-100 rounded-pill">Supprimer</button>
            </form>
          </div>
        </div>

        {{-- Fiche --}}
        <div class="card border-0 shadow-sm">
          <div class="card-header bg-white py-3 px-4"><h6 class="mb-0 fw-semibold">Fiche</h6></div>
          <div class="card-body p-0">
            <ul class="list-group list-group-flush small">
              <li class="list-group-item d-flex justify-content-between px-4 py-3">
                <span class="text-secondary">Prix</span>
                <span class="fw-bold text-primary">{{ number_format($service->prixService, 0, ',', ' ') }} FCFA</span>
              </li>
              <li class="list-group-item d-flex justify-content-between px-4 py-3">
                <span class="text-secondary">Score</span>
                <span>
                  @if($service->scoringService > 0)
                    <span class="text-warning fw-semibold">★ {{ number_format($service->scoringService, 1) }}/5</span>
                  @else
                    <span class="text-secondary">—</span>
                  @endif
                </span>
              </li>
              <li class="list-group-item px-4 py-3">
                <span class="text-secondary d-block mb-1">Commerce</span>
                @if($service->commerce)
                  <a href="{{ route('admin.commerces.show', $service->commerce) }}" class="fw-semibold text-decoration-none small">
                    {{ $service->commerce->nomCormmercial }}
                  </a>
                  <span class="text-secondary small ms-1">— {{ $service->commerce->ville }}</span>
                @else
                  <span class="text-secondary">—</span>
                @endif
              </li>
              <li class="list-group-item px-4 py-3">
                <span class="text-secondary d-block mb-1">Proprietaire</span>
                @if($service->commerce?->user)
                  <a href="{{ route('admin.users.show', $service->commerce->user) }}" class="fw-semibold text-decoration-none small">
                    {{ $service->commerce->user->prenom }} {{ $service->commerce->user->name }}
                  </a>
                @else
                  <span class="text-secondary">—</span>
                @endif
              </li>
              <li class="list-group-item d-flex justify-content-between px-4 py-3">
                <span class="text-secondary">Cree le</span><span>{{ $service->created_at->format('d/m/Y') }}</span>
              </li>
            </ul>
          </div>
        </div>

      </div>

      {{-- Colonne droite : description + commentaires --}}
      <div class="col-xl-8">

        {{-- Description --}}
        @if($service->description)
        <div class="card border-0 shadow-sm mb-4">
          <div class="card-header bg-white py-3 px-4"><h6 class="mb-0 fw-semibold">Description</h6></div>
          <div class="card-body p-4">
            <p class="mb-0 small" style="line-height:1.7;">{{ $service->description }}</p>
          </div>
        </div>
        @endif

        {{-- Commentaires --}}
        <div class="card border-0 shadow-sm">
          <div class="card-header bg-white py-3 px-4">
            <h6 class="mb-0 fw-semibold">Commentaires ({{ $service->commentaires->count() }})</h6>
          </div>
          <div class="card-body p-0">
            @forelse($service->commentaires as $com)
            <div class="d-flex gap-3 p-4 border-bottom">
              <div class="flex-shrink-0">
                @if($com->user && $com->user->photo)
                  <img src="{{ asset('storage/' . $com->user->photo) }}" class="rounded-circle" style="width:36px;height:36px;object-fit:cover;" alt="">
                @else
                  <div class="rounded-circle bg-secondary-subtle text-secondary d-flex align-items-center justify-content-center fw-bold" style="width:36px;height:36px;font-size:.78rem;">
                    {{ strtoupper(substr($com->user?->prenom ?? '?', 0, 1)) }}
                  </div>
                @endif
              </div>
              <div class="flex-grow-1">
                <div class="d-flex justify-content-between align-items-center mb-1 flex-wrap gap-1">
                  <span class="fw-semibold small">{{ $com->user?->prenom }} {{ $com->user?->name }}</span>
                  <span class="text-secondary" style="font-size:.75rem;">{{ $com->created_at->format('d/m/Y H:i') }}</span>
                </div>
                <p class="mb-1 small" style="line-height:1.6;">{{ $com->body }}</p>
                <form method="POST" action="{{ route('admin.commentaires.destroy', $com) }}"
                      onsubmit="return confirm('Supprimer ce commentaire ?')" class="d-inline">
                  @csrf @method('DELETE')
                  <button type="submit" class="btn btn-link p-0 text-danger" style="font-size:.75rem;">Supprimer</button>
                </form>
              </div>
            </div>
            @empty
            <p class="text-secondary small p-4 mb-0">Aucun commentaire.</p>
            @endforelse
          </div>
        </div>

      </div>
    </div>

  </div>
</div>
@endsection

@include('main.navbarWithsidebar')
