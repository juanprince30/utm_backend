@include('admin.sidebarAdmin')

@extends('main.index')

@section('content')
<div>
  <div class="custom-container py-6">

    <div class="d-flex align-items-center justify-content-between mb-6">
      <div>
        <h2 class="fw-bold mb-1">Gestion des services</h2>
        <p class="text-secondary mb-0 small">{{ $services->total() }} service(s) au total</p>
      </div>
    </div>

    @if(session('success'))
      <div class="alert alert-success alert-dismissible fade show mb-4">
        {{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    @endif

    {{-- Filtres --}}
    <div class="card border-0 shadow-sm mb-4">
      <div class="card-body py-3 px-4">
        <form method="GET" action="{{ route('admin.services') }}" class="d-flex gap-3 flex-wrap align-items-center">
          <input type="text" name="search" class="form-control form-control-sm" style="max-width:280px;"
                 placeholder="Nom du service..." value="{{ request('search') }}">
          <select name="dispo" class="form-select form-select-sm" style="max-width:180px;">
            <option value="">Toutes disponibilites</option>
            <option value="1" {{ request('dispo') === '1' ? 'selected' : '' }}>Disponibles</option>
            <option value="0" {{ request('dispo') === '0' ? 'selected' : '' }}>Indisponibles</option>
          </select>
          <button type="submit" class="btn btn-sm btn-primary rounded-pill px-4">Filtrer</button>
          <a href="{{ route('admin.services') }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3">Reset</a>
        </form>
      </div>
    </div>

    <div class="card border-0 shadow-sm">
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
              <tr>
                <th>#</th>
                <th>Service</th>
                <th>Commerce</th>
                <th>Prix</th>
                <th>Scoring</th>
                <th>Disponibilite</th>
                <th class="text-end">Actions</th>
              </tr>
            </thead>
            <tbody>
              @forelse($services as $s)
              <tr>
                <td class="text-secondary small">{{ $s->id }}</td>
                <td>
                  <p class="mb-0 fw-semibold small">{{ $s->nomService }}</p>
                  <p class="mb-0 text-secondary" style="font-size:.75rem;">{{ Str::limit($s->description, 50) }}</p>
                </td>
                <td class="text-secondary small">{{ $s->commerce?->nomCormmercial ?? '—' }}</td>
                <td class="fw-semibold">{{ number_format($s->prixService, 0, ',', ' ') }} FCFA</td>
                <td>
                  <div class="d-flex align-items-center gap-1">
                    <span class="fw-semibold">{{ $s->scoringService }}</span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="#f59e0b" viewBox="0 0 16 16">
                      <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                    </svg>
                  </div>
                </td>
                <td>
                  <form method="POST" action="{{ route('admin.services.disponibilite', $s) }}">
                    @csrf @method('PATCH')
                    <button type="submit" class="btn btn-sm rounded-pill px-3 {{ $s->isAvaillable ? 'btn-success' : 'btn-outline-secondary' }}">
                      {{ $s->isAvaillable ? 'Disponible' : 'Indisponible' }}
                    </button>
                  </form>
                </td>
                <td class="text-end">
                  <div class="d-flex gap-2 justify-content-end">
                    <a href="{{ route('admin.services.show', $s) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">Voir</a>
                    <form method="POST" action="{{ route('admin.services.destroy', $s) }}"
                          onsubmit="return confirm('Supprimer ce service ?')">
                      @csrf @method('DELETE')
                      <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3">Suppr.</button>
                    </form>
                  </div>
                </td>
              </tr>
              @empty
              <tr><td colspan="7" class="text-center text-secondary py-5">Aucun service trouve.</td></tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
      @if($services->hasPages())
      <div class="card-footer bg-white border-top d-flex justify-content-center py-3">
        {{ $services->links() }}
      </div>
      @endif
    </div>

  </div>
</div>
@endsection
@include('main.navbarWithsidebar')
