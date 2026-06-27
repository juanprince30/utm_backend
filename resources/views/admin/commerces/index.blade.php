@include('admin.sidebarAdmin')

@extends('main.index')

@section('content')
<div>
  <div class="custom-container py-6">

    <div class="d-flex align-items-center justify-content-between mb-6">
      <div>
        <h2 class="fw-bold mb-1">Gestion des commerces</h2>
        <p class="text-secondary mb-0 small">{{ $commerces->total() }} commerce(s) au total</p>
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
        <form method="GET" action="{{ route('admin.commerces') }}" class="d-flex gap-3 flex-wrap align-items-center">
          <input type="text" name="search" class="form-control form-control-sm" style="max-width:280px;"
                 placeholder="Nom, ville, categorie..." value="{{ request('search') }}">
          <select name="etat" class="form-select form-select-sm" style="max-width:180px;">
            <option value="">Tous les etats</option>
            <option value="1" {{ request('etat') === '1' ? 'selected' : '' }}>Publies</option>
            <option value="0" {{ request('etat') === '0' ? 'selected' : '' }}>En attente</option>
          </select>
          <button type="submit" class="btn btn-sm btn-primary rounded-pill px-4">Filtrer</button>
          <a href="{{ route('admin.commerces') }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3">Reset</a>
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
                <th>Commerce</th>
                <th>Categorie</th>
                <th>Ville</th>
                <th>Proprietaire</th>
                <th>Publication</th>
                <th class="text-end">Actions</th>
              </tr>
            </thead>
            <tbody>
              @forelse($commerces as $c)
              <tr>
                <td class="text-secondary small">{{ $c->id }}</td>
                <td class="fw-semibold">{{ $c->nomCormmercial }}</td>
                <td><span class="badge bg-info-subtle text-info rounded-pill">{{ $c->categorie }}</span></td>
                <td class="text-secondary small">{{ $c->ville }}</td>
                <td class="text-secondary small">{{ $c->user?->prenom }} {{ $c->user?->name }}</td>
                <td>
                  <form method="POST" action="{{ route('admin.commerces.publication', $c) }}">
                    @csrf @method('PATCH')
                    <button type="submit" class="btn btn-sm rounded-pill px-3 {{ $c->etatPublication ? 'btn-success' : 'btn-outline-secondary' }}">
                      {{ $c->etatPublication ? 'Publie' : 'En attente' }}
                    </button>
                  </form>
                </td>
                <td class="text-end">
                  <div class="d-flex gap-2 justify-content-end">
                    <a href="{{ route('admin.commerces.show', $c) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">Voir</a>
                    <form method="POST" action="{{ route('admin.commerces.destroy', $c) }}"
                          onsubmit="return confirm('Supprimer ce commerce ?')">
                      @csrf @method('DELETE')
                      <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3">Suppr.</button>
                    </form>
                  </div>
                </td>
              </tr>
              @empty
              <tr><td colspan="7" class="text-center text-secondary py-5">Aucun commerce trouve.</td></tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
      @if($commerces->hasPages())
      <div class="card-footer bg-white border-top d-flex justify-content-center py-3">
        {{ $commerces->links() }}
      </div>
      @endif
    </div>

  </div>
</div>
@endsection
@include('main.navbarWithsidebar')
