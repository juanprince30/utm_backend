@include('admin.sidebarAdmin')

@extends('main.index')

@section('content')
<div>
  <div class="custom-container py-6">

    {{-- En-tête --}}
    <div class="d-flex align-items-center gap-3 mb-6">
      <a href="{{ route('admin.users') }}" class="btn btn-ghost btn-icon rounded-circle">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l14 0"/><path d="M5 12l6 6"/><path d="M5 12l6 -6"/></svg>
      </a>
      <div>
        <h2 class="fw-bold mb-0">{{ $user->prenom }} {{ $user->name }}</h2>
        <p class="text-secondary mb-0 small">Profil utilisateur #{{ $user->id }}</p>
      </div>
    </div>

    @if(session('success'))
      <div class="alert alert-success alert-dismissible fade show mb-4">{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
    @endif

    <div class="row g-4">

      {{-- Infos utilisateur --}}
      <div class="col-xl-4">

        <div class="card border-0 shadow-sm mb-4">
          <div class="card-body p-4 text-center">
            @if($user->photo)
              <img src="{{ asset('storage/' . $user->photo) }}" class="rounded-circle mb-3 object-fit-cover" style="width:80px;height:80px;" alt="">
            @else
              <div class="rounded-circle bg-primary-subtle text-primary d-flex align-items-center justify-content-center fw-bold mx-auto mb-3" style="width:80px;height:80px;font-size:1.5rem;">
                {{ strtoupper(substr($user->prenom, 0, 1)) }}{{ strtoupper(substr($user->name, 0, 1)) }}
              </div>
            @endif
            <h5 class="fw-bold mb-1">{{ $user->prenom }} {{ $user->name }}</h5>
            <span class="badge rounded-pill {{ $user->role === 'admin' ? 'bg-danger-subtle text-danger' : 'bg-secondary-subtle text-secondary' }} mb-3">{{ $user->role }}</span>

            <div class="d-flex justify-content-center gap-2 flex-wrap">
              @if($user->isActif)
                <span class="badge bg-success-subtle text-success rounded-pill">Actif</span>
              @else
                <span class="badge bg-danger-subtle text-danger rounded-pill">Inactif</span>
              @endif
              @if($user->isCertified)
                <span class="badge rounded-pill" style="background:linear-gradient(135deg,#f59e0b,#d97706);color:#fff;">✓ Certifie</span>
              @endif
              @if($user->canCormmerce)
                <span class="badge bg-info-subtle text-info rounded-pill">Peut commercer</span>
              @endif
            </div>
          </div>
        </div>

        <div class="card border-0 shadow-sm mb-4">
          <div class="card-header bg-white py-3 px-4"><h6 class="mb-0 fw-semibold">Informations</h6></div>
          <div class="card-body p-0">
            <ul class="list-group list-group-flush small">
              <li class="list-group-item d-flex justify-content-between px-4 py-3">
                <span class="text-secondary">Telephone</span><span class="fw-semibold">{{ $user->telephone }}</span>
              </li>
              <li class="list-group-item d-flex justify-content-between px-4 py-3">
                <span class="text-secondary">Email</span><span>{{ $user->email ?? '—' }}</span>
              </li>
              <li class="list-group-item d-flex justify-content-between px-4 py-3">
                <span class="text-secondary">Adresse</span><span>{{ $user->addresse ?? '—' }}</span>
              </li>
              <li class="list-group-item d-flex justify-content-between px-4 py-3">
                <span class="text-secondary">Score artisan</span>
                <span>
                  @if($user->scoringArtisant > 0)
                    <span class="text-warning fw-semibold">★ {{ number_format($user->scoringArtisant, 1) }}/5</span>
                  @else
                    <span class="text-secondary">—</span>
                  @endif
                </span>
              </li>
              <li class="list-group-item d-flex justify-content-between px-4 py-3">
                <span class="text-secondary">Inscrit le</span><span>{{ $user->created_at->format('d/m/Y') }}</span>
              </li>
            </ul>
          </div>
        </div>

        {{-- Actions rapides --}}
        <div class="card border-0 shadow-sm">
          <div class="card-header bg-white py-3 px-4"><h6 class="mb-0 fw-semibold">Actions</h6></div>
          <div class="card-body p-3 d-grid gap-2">
            <form method="POST" action="{{ route('admin.users.actif', $user) }}">
              @csrf @method('PATCH')
              <button type="submit" class="btn btn-sm w-100 rounded-pill {{ $user->isActif ? 'btn-outline-danger' : 'btn-outline-success' }}">
                {{ $user->isActif ? 'Desactiver le compte' : 'Activer le compte' }}
              </button>
            </form>
            <form method="POST" action="{{ route('admin.users.commerce', $user) }}">
              @csrf @method('PATCH')
              <button type="submit" class="btn btn-sm w-100 rounded-pill {{ $user->canCormmerce ? 'btn-outline-warning' : 'btn-outline-info' }}">
                {{ $user->canCormmerce ? 'Retirer permission commerce' : 'Accorder permission commerce' }}
              </button>
            </form>
            <form method="POST" action="{{ route('admin.users.certified', $user) }}">
              @csrf @method('PATCH')
              <button type="submit" class="btn btn-sm w-100 rounded-pill {{ $user->isCertified ? 'btn-outline-secondary' : 'btn-outline-primary' }}">
                {{ $user->isCertified ? 'Retirer certification' : 'Certifier l\'artisan' }}
              </button>
            </form>
            <form method="POST" action="{{ route('admin.users.destroy', $user) }}"
                  onsubmit="return confirm('Supprimer cet utilisateur ?')">
              @csrf @method('DELETE')
              <button type="submit" class="btn btn-sm btn-outline-danger w-100 rounded-pill">Supprimer le compte</button>
            </form>
          </div>
        </div>

      </div>

      {{-- Colonne droite --}}
      <div class="col-xl-8">

        {{-- Commerces --}}
        <div class="card border-0 shadow-sm mb-4">
          <div class="card-header bg-white py-3 px-4 d-flex justify-content-between align-items-center">
            <h6 class="mb-0 fw-semibold">Commerces ({{ $user->commerces->count() }})</h6>
          </div>
          <div class="card-body p-0">
            @forelse($user->commerces as $c)
            <div class="p-4 border-bottom">
              <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
                <div>
                  <p class="fw-semibold mb-1">{{ $c->nomCormmercial }}</p>
                  <div class="d-flex gap-2 flex-wrap">
                    <span class="badge bg-info-subtle text-info rounded-pill" style="font-size:.7rem;">{{ $c->categorie }}</span>
                    <span class="text-secondary small">{{ $c->ville }}</span>
                    @if($c->etatPublication === 'publie')
                      <span class="badge bg-success-subtle text-success rounded-pill" style="font-size:.7rem;">Publie</span>
                    @elseif($c->etatPublication === 'retire')
                      <span class="badge bg-danger-subtle text-danger rounded-pill" style="font-size:.7rem;">Retire</span>
                    @else
                      <span class="badge bg-warning-subtle text-warning rounded-pill" style="font-size:.7rem;">Draft</span>
                    @endif
                  </div>
                </div>
                <div class="d-flex gap-2">
                  <a href="{{ route('admin.commerces.show', $c) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">Voir</a>
                </div>
              </div>
              @if($c->services->isNotEmpty())
              <div class="mt-2 d-flex flex-wrap gap-2">
                @foreach($c->services as $s)
                  <span class="badge bg-light text-dark border" style="font-size:.72rem;">{{ $s->nomService }} — {{ number_format($s->prixService, 0, ',', ' ') }} FCFA</span>
                @endforeach
              </div>
              @endif
            </div>
            @empty
            <p class="text-secondary small p-4 mb-0">Aucun commerce.</p>
            @endforelse
          </div>
        </div>

        {{-- Commentaires --}}
        <div class="card border-0 shadow-sm">
          <div class="card-header bg-white py-3 px-4">
            <h6 class="mb-0 fw-semibold">Commentaires laisses ({{ $user->commentaires->count() }})</h6>
          </div>
          <div class="card-body p-0">
            @forelse($user->commentaires->take(10) as $com)
            <div class="p-4 border-bottom">
              <div class="d-flex justify-content-between align-items-start">
                <div class="flex-grow-1">
                  <p class="small mb-1" style="line-height:1.6;">{{ $com->body }}</p>
                  <span class="text-secondary" style="font-size:.75rem;">
                    Sur : {{ $com->commerce?->nomCormmercial ?? '—' }}
                    @if($com->service) → {{ $com->service?->nomService }} @endif
                    · {{ $com->created_at->format('d/m/Y') }}
                  </span>
                </div>
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
