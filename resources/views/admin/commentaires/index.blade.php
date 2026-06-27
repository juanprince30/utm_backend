@include('admin.sidebarAdmin')

@extends('main.index')

@section('content')
<div>
  <div class="custom-container py-6">

    <div class="d-flex align-items-center justify-content-between mb-6">
      <div>
        <h2 class="fw-bold mb-1">Gestion des Commentaires</h2>
        <p class="text-secondary mb-0 small">{{ $commentaires->total() }} commentaire(s) au total</p>
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
        <form method="GET" action="{{ route('admin.commentaires') }}" class="d-flex gap-3 flex-wrap align-items-center">
          <input type="text" name="search" class="form-control form-control-sm" style="max-width:280px;"
                 placeholder="Rechercher dans le texte..." value="{{ request('search') }}">
          <select name="commerce" class="form-select form-select-sm" style="max-width:240px;">
            <option value="">Tous les commerces</option>
            @foreach($commerces as $c)
              <option value="{{ $c->id }}" {{ request('commerce') == $c->id ? 'selected' : '' }}>
                {{ $c->nomCormmercial }}
              </option>
            @endforeach
          </select>
          <button type="submit" class="btn btn-sm btn-primary rounded-pill px-4">Filtrer</button>
          <a href="{{ route('admin.commentaires') }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3">Reset</a>
        </form>
      </div>
    </div>

    <div class="card border-0 shadow-sm">
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
              <tr>
                <th style="width:40px;">#</th>
                <th>Auteur</th>
                <th>Commentaire</th>
                <th>Commerce</th>
                <th>Service</th>
                <th>Date</th>
                <th class="text-end">Action</th>
              </tr>
            </thead>
            <tbody>
              @forelse($commentaires as $com)
              <tr>
                <td class="text-secondary small">{{ $com->id }}</td>

                {{-- Auteur --}}
                <td>
                  <div class="d-flex align-items-center gap-2">
                    @if($com->user && $com->user->photo)
                      <img src="{{ asset('storage/' . $com->user->photo) }}"
                           class="rounded-circle" style="width:32px;height:32px;object-fit:cover;" alt="">
                    @else
                      <div class="rounded-circle bg-primary-subtle text-primary d-flex align-items-center justify-content-center fw-bold"
                           style="width:32px;height:32px;font-size:.75rem;">
                        {{ strtoupper(substr($com->user?->prenom ?? '?', 0, 1)) }}
                      </div>
                    @endif
                    <div>
                      <p class="mb-0 small fw-semibold">{{ $com->user?->prenom }} {{ $com->user?->name }}</p>
                      <p class="mb-0 text-secondary" style="font-size:.72rem;">{{ $com->user?->telephone }}</p>
                    </div>
                  </div>
                </td>

                {{-- Texte --}}
                <td style="max-width:300px;">
                  <p class="mb-0 small" style="line-height:1.5;white-space:pre-wrap;">{{ Str::limit($com->body, 120) }}</p>
                </td>

                {{-- Commerce --}}
                <td class="small text-secondary">{{ $com->commerce?->nomCormmercial ?? '—' }}</td>

                {{-- Service --}}
                <td class="small text-secondary">{{ $com->service?->nomService ?? '—' }}</td>

                {{-- Date --}}
                <td class="small text-secondary text-nowrap">{{ $com->created_at->format('d/m/Y H:i') }}</td>

                {{-- Action suppression --}}
                <td class="text-end">
                  <form method="POST" action="{{ route('admin.commentaires.destroy', $com) }}"
                        onsubmit="return confirm('Supprimer ce commentaire ?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3"
                            title="Supprimer (langage inapproprie)">
                      <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" stroke="currentColor"
                           stroke-width="2" viewBox="0 0 24 24">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M4 7l16 0"/>
                        <path d="M10 11l0 6"/>
                        <path d="M14 11l0 6"/>
                        <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"/>
                        <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"/>
                      </svg>
                    </button>
                  </form>
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="7" class="text-center text-secondary py-5">Aucun commentaire trouve.</td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>

      @if($commentaires->hasPages())
      <div class="card-footer bg-white border-top d-flex justify-content-center py-3">
        {{ $commentaires->links() }}
      </div>
      @endif
    </div>

  </div>
</div>
@endsection

@include('main.navbarWithsidebar')
