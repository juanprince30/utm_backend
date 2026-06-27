@include('admin.sidebarAdmin')

@extends('main.index')

@section('content')
<div>
  <div class="custom-container py-6">

    {{-- Header --}}
    <div class="d-flex align-items-center justify-content-between mb-6">
      <div>
        <h2 class="fw-bold mb-1">Gestion des utilisateurs</h2>
        <p class="text-secondary mb-0 small">{{ $users->total() }} utilisateur(s) au total</p>
      </div>
      <button class="btn btn-primary rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#modalCreateUser">
        + Nouvel utilisateur
      </button>
    </div>

    {{-- Flash --}}
    @if(session('success'))
      <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
        {{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    @endif

    {{-- Filtres --}}
    <div class="card border-0 shadow-sm mb-4">
      <div class="card-body py-3 px-4">
        <form method="GET" action="{{ route('admin.users') }}" class="d-flex gap-3 align-items-center flex-wrap">
          <input type="text" name="search" class="form-control form-control-sm" style="max-width:280px;"
                 placeholder="Rechercher nom, prenom, telephone..." value="{{ request('search') }}">
          <select name="role" class="form-select form-select-sm" style="max-width:160px;">
            <option value="">Tous les roles</option>
            <option value="user"  {{ request('role') === 'user'  ? 'selected' : '' }}>Utilisateur</option>
            <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
          </select>
          <button type="submit" class="btn btn-sm btn-primary rounded-pill px-4">Filtrer</button>
          <a href="{{ route('admin.users') }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3">Reset</a>
        </form>
      </div>
    </div>

    {{-- Tableau --}}
    <div class="card border-0 shadow-sm">
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
              <tr>
                <th>#</th>
                <th>Utilisateur</th>
                <th>Telephone</th>
                <th>Role</th>
                <th>Actif</th>
                <th>Commerce</th>
                <th>Certifie</th>
                <th class="text-end">Actions</th>
              </tr>
            </thead>
            <tbody>
              @forelse($users as $u)
              <tr>
                <td class="text-secondary small">{{ $u->id }}</td>
                <td>
                  <div class="d-flex align-items-center gap-3">
                    <div class="avatar avatar-sm bg-primary-subtle rounded-circle d-flex align-items-center justify-content-center fw-bold text-primary" style="width:34px;height:34px;font-size:.8rem;">
                      {{ strtoupper(substr($u->prenom, 0, 1)) }}{{ strtoupper(substr($u->name, 0, 1)) }}
                    </div>
                    <div>
                      <p class="mb-0 fw-semibold small">{{ $u->prenom }} {{ $u->name }}</p>
                      <p class="mb-0 text-secondary" style="font-size:.75rem;">{{ $u->email ?? '—' }}</p>
                    </div>
                  </div>
                </td>
                <td class="text-secondary small">{{ $u->telephone }}</td>
                <td>
                  <span class="badge rounded-pill {{ $u->role === 'admin' ? 'bg-danger-subtle text-danger' : 'bg-secondary-subtle text-secondary' }}">
                    {{ $u->role }}
                  </span>
                </td>
                <td>
                  <form method="POST" action="{{ route('admin.users.actif', $u) }}">
                    @csrf @method('PATCH')
                    <button type="submit" class="btn btn-sm rounded-pill px-3 {{ $u->isActif ? 'btn-success' : 'btn-outline-secondary' }}">
                      {{ $u->isActif ? 'Actif' : 'Inactif' }}
                    </button>
                  </form>
                </td>
                <td>
                  <form method="POST" action="{{ route('admin.users.commerce', $u) }}">
                    @csrf @method('PATCH')
                    <button type="submit" class="btn btn-sm rounded-pill px-3 {{ $u->canCormmerce ? 'btn-primary' : 'btn-outline-secondary' }}">
                      {{ $u->canCormmerce ? 'Oui' : 'Non' }}
                    </button>
                  </form>
                </td>
                <td>
                  <form method="POST" action="{{ route('admin.users.certified', $u) }}">
                    @csrf @method('PATCH')
                    <button type="submit" class="btn btn-sm rounded-pill px-3 {{ $u->isCertified ? 'btn-warning' : 'btn-outline-secondary' }}">
                      {{ $u->isCertified ? 'Certifie' : 'Non certifie' }}
                    </button>
                  </form>
                </td>
                <td class="text-end">
                  <div class="d-flex gap-2 justify-content-end">
                    <a href="{{ route('admin.users.show', $u) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">Voir</a>
                    <button class="btn btn-sm btn-outline-secondary rounded-pill px-3"
                            data-bs-toggle="modal" data-bs-target="#modalEditUser{{ $u->id }}">
                      Editer
                    </button>
                    <form method="POST" action="{{ route('admin.users.destroy', $u) }}"
                          onsubmit="return confirm('Supprimer cet utilisateur ?')">
                      @csrf @method('DELETE')
                      <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3">Suppr.</button>
                    </form>
                  </div>
                </td>
              </tr>

              {{-- Modal édition --}}
              <div class="modal fade" id="modalEditUser{{ $u->id }}" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title">Modifier {{ $u->prenom }} {{ $u->name }}</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form method="POST" action="{{ route('admin.users.update', $u) }}">
                      @csrf @method('PUT')
                      <div class="modal-body">
                        <div class="row g-3">
                          <div class="col-6">
                            <label class="form-label small">Nom</label>
                            <input type="text" name="name" class="form-control form-control-sm" value="{{ $u->name }}" required>
                          </div>
                          <div class="col-6">
                            <label class="form-label small">Prenom</label>
                            <input type="text" name="prenom" class="form-control form-control-sm" value="{{ $u->prenom }}" required>
                          </div>
                          <div class="col-6">
                            <label class="form-label small">Telephone</label>
                            <input type="tel" name="telephone" class="form-control form-control-sm" value="{{ $u->telephone }}" required>
                          </div>
                          <div class="col-6">
                            <label class="form-label small">Email</label>
                            <input type="email" name="email" class="form-control form-control-sm" value="{{ $u->email }}">
                          </div>
                          <div class="col-6">
                            <label class="form-label small">Role</label>
                            <select name="role" class="form-select form-select-sm">
                              <option value="user"  {{ $u->role === 'user'  ? 'selected' : '' }}>Utilisateur</option>
                              <option value="admin" {{ $u->role === 'admin' ? 'selected' : '' }}>Admin</option>
                            </select>
                          </div>
                          <div class="col-6">
                            <label class="form-label small">Nouveau mot de passe</label>
                            <input type="password" name="password" class="form-control form-control-sm" placeholder="Laisser vide pour ne pas changer">
                          </div>
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-sm btn-primary">Enregistrer</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>

              @empty
              <tr><td colspan="8" class="text-center text-secondary py-5">Aucun utilisateur trouve.</td></tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
      @if($users->hasPages())
      <div class="card-footer bg-white border-top d-flex justify-content-center py-3">
        {{ $users->links() }}
      </div>
      @endif
    </div>

  </div>
</div>

{{-- Modal création utilisateur --}}
<div class="modal fade" id="modalCreateUser" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Nouvel utilisateur</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form method="POST" action="{{ route('admin.users.store') }}">
        @csrf
        <div class="modal-body">
          @if($errors->any())
            <div class="alert alert-danger mb-3"><ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
          @endif
          <div class="row g-3">
            <div class="col-6">
              <label class="form-label small">Nom <span class="text-danger">*</span></label>
              <input type="text" name="name" class="form-control form-control-sm" value="{{ old('name') }}" required>
            </div>
            <div class="col-6">
              <label class="form-label small">Prenom <span class="text-danger">*</span></label>
              <input type="text" name="prenom" class="form-control form-control-sm" value="{{ old('prenom') }}" required>
            </div>
            <div class="col-6">
              <label class="form-label small">Telephone <span class="text-danger">*</span></label>
              <input type="tel" name="telephone" class="form-control form-control-sm" value="{{ old('telephone') }}" required>
            </div>
            <div class="col-6">
              <label class="form-label small">Email</label>
              <input type="email" name="email" class="form-control form-control-sm" value="{{ old('email') }}">
            </div>
            <div class="col-6">
              <label class="form-label small">Role <span class="text-danger">*</span></label>
              <select name="role" class="form-select form-select-sm">
                <option value="user">Utilisateur</option>
                <option value="admin">Admin</option>
              </select>
            </div>
            <div class="col-6">
              <label class="form-label small">Mot de passe <span class="text-danger">*</span></label>
              <input type="password" name="password" class="form-control form-control-sm" required>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal">Annuler</button>
          <button type="submit" class="btn btn-sm btn-primary">Creer</button>
        </div>
      </form>
    </div>
  </div>
</div>

@endsection
@include('main.navbarWithsidebar')
