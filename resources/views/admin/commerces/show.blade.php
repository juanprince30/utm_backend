@include('admin.sidebarAdmin')

@extends('main.index')

@section('content')
<div>
  <div class="custom-container py-6">

    {{-- En-tête --}}
    <div class="d-flex align-items-center gap-3 mb-6">
      <a href="{{ route('admin.commerces') }}" class="btn btn-ghost btn-icon rounded-circle">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l14 0"/><path d="M5 12l6 6"/><path d="M5 12l6 -6"/></svg>
      </a>
      <div>
        <h2 class="fw-bold mb-0">{{ $commerce->nomCormmercial }}</h2>
        <p class="text-secondary mb-0 small">Commerce #{{ $commerce->id }}</p>
      </div>
    </div>

    @if(session('success'))
      <div class="alert alert-success alert-dismissible fade show mb-4">{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
    @endif

    <div class="row g-4">

      {{-- Colonne gauche : infos + actions --}}
      <div class="col-xl-4">

        {{-- Photos --}}
        @if(!empty($commerce->photos))
        <div class="card border-0 shadow-sm mb-4 overflow-hidden">
          <div class="row g-1 p-2">
            @foreach($commerce->photos as $idx => $photo)
            <div class="{{ $idx === 0 ? 'col-12' : 'col-6' }}">
              <img src="{{ asset('storage/' . $photo) }}"
                   class="w-100 rounded-2"
                   style="height:{{ $idx === 0 ? '180px' : '80px' }};object-fit:cover;"
                   alt="Photo {{ $idx+1 }}">
            </div>
            @endforeach
          </div>
        </div>
        @endif

        {{-- Statut + actions --}}
        <div class="card border-0 shadow-sm mb-4">
          <div class="card-header bg-white py-3 px-4"><h6 class="mb-0 fw-semibold">Statut & Actions</h6></div>
          <div class="card-body p-3 d-grid gap-2">
            <div class="d-flex align-items-center justify-content-between p-2">
              <span class="small text-secondary">Publication</span>
              @if($commerce->etatPublication === 'publie')
                <span class="badge bg-success-subtle text-success rounded-pill">Publie</span>
              @elseif($commerce->etatPublication === 'retire')
                <span class="badge bg-danger-subtle text-danger rounded-pill">Retire</span>
              @else
                <span class="badge bg-warning-subtle text-warning rounded-pill">Draft</span>
              @endif
            </div>
            <form method="POST" action="{{ route('admin.commerces.publication', $commerce) }}">
              @csrf @method('PATCH')
              <button type="submit" class="btn btn-sm w-100 rounded-pill {{ $commerce->etatPublication === 'publie' ? 'btn-outline-warning' : 'btn-outline-success' }}">
                {{ $commerce->etatPublication === 'publie' ? 'Depublier (draft)' : 'Publier' }}
              </button>
            </form>
            <a href="{{ route('commerces.show', $commerce) }}" target="_blank" class="btn btn-sm btn-outline-primary rounded-pill">
              Voir page publique
            </a>
            <form method="POST" action="{{ route('admin.commerces.destroy', $commerce) }}"
                  onsubmit="return confirm('Supprimer ce commerce et tous ses services ?')">
              @csrf @method('DELETE')
              <button type="submit" class="btn btn-sm btn-outline-danger w-100 rounded-pill">Supprimer</button>
            </form>
          </div>
        </div>

        {{-- Fiche détaillée --}}
        <div class="card border-0 shadow-sm">
          <div class="card-header bg-white py-3 px-4"><h6 class="mb-0 fw-semibold">Fiche</h6></div>
          <div class="card-body p-0">
            <ul class="list-group list-group-flush small">
              <li class="list-group-item d-flex justify-content-between px-4 py-3">
                <span class="text-secondary">Categorie</span>
                <span class="badge bg-info-subtle text-info rounded-pill">{{ $commerce->categorie }}</span>
              </li>
              <li class="list-group-item d-flex justify-content-between px-4 py-3">
                <span class="text-secondary">Ville</span><span>{{ $commerce->ville }}</span>
              </li>
              <li class="list-group-item d-flex justify-content-between px-4 py-3">
                <span class="text-secondary">Telephone</span><span>{{ $commerce->conctactResponsable }}</span>
              </li>
              <li class="list-group-item d-flex justify-content-between px-4 py-3">
                <span class="text-secondary">Email</span><span>{{ $commerce->emailCommerce ?? '—' }}</span>
              </li>
              @if($commerce->lienCommerce)
              <li class="list-group-item px-4 py-3">
                <span class="text-secondary d-block mb-1">Site web</span>
                <a href="{{ $commerce->lienCommerce }}" target="_blank" class="small text-primary text-truncate d-block">{{ $commerce->lienCommerce }}</a>
              </li>
              @endif
              <li class="list-group-item d-flex justify-content-between px-4 py-3">
                <span class="text-secondary">Score</span>
                <span>
                  @if($commerce->scoringCommerce > 0)
                    <span class="text-warning fw-semibold">★ {{ number_format($commerce->scoringCommerce, 1) }}/5</span>
                  @else
                    <span class="text-secondary">—</span>
                  @endif
                </span>
              </li>
              <li class="list-group-item px-4 py-3">
                <span class="text-secondary d-block mb-1">Proprietaire</span>
                @if($commerce->user)
                  <a href="{{ route('admin.users.show', $commerce->user) }}" class="fw-semibold text-decoration-none small">
                    {{ $commerce->user->prenom }} {{ $commerce->user->name }}
                  </a>
                  @if($commerce->user->isCertified)
                    <span class="ms-1 badge rounded-pill" style="background:linear-gradient(135deg,#f59e0b,#d97706);color:#fff;font-size:.65rem;">✓ Certifie</span>
                  @endif
                @else
                  <span class="text-secondary">—</span>
                @endif
              </li>
              <li class="list-group-item d-flex justify-content-between px-4 py-3">
                <span class="text-secondary">Cree le</span><span>{{ $commerce->created_at->format('d/m/Y') }}</span>
              </li>
            </ul>
          </div>
        </div>

      </div>

      {{-- Colonne droite : services + commentaires --}}
      <div class="col-xl-8">

        {{-- Services --}}
        <div class="card border-0 shadow-sm mb-4">
          <div class="card-header bg-white py-3 px-4 d-flex justify-content-between align-items-center">
            <h6 class="mb-0 fw-semibold">Services ({{ $commerce->services->count() }})</h6>
          </div>
          <div class="card-body p-0">
            @forelse($commerce->services as $s)
            <div class="d-flex gap-3 p-4 border-bottom align-items-start">
              @if($s->photo)
                <img src="{{ asset('storage/' . $s->photo) }}" style="width:56px;height:56px;object-fit:cover;border-radius:8px;flex-shrink:0;" alt="">
              @else
                <div class="bg-light d-flex align-items-center justify-content-center flex-shrink-0" style="width:56px;height:56px;border-radius:8px;">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="#ccc" stroke-width="1.5" viewBox="0 0 24 24"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 3l8 4v10l-8 4l-8 -4v-10z"/></svg>
                </div>
              @endif
              <div class="flex-grow-1">
                <div class="d-flex justify-content-between align-items-start flex-wrap gap-1">
                  <div>
                    <p class="fw-semibold small mb-1">{{ $s->nomService }}</p>
                    @if($s->description)<p class="text-secondary mb-1" style="font-size:.8rem;">{{ Str::limit($s->description, 80) }}</p>@endif
                    <div class="d-flex gap-2 align-items-center flex-wrap">
                      <span class="fw-bold text-primary small">{{ number_format($s->prixService, 0, ',', ' ') }} FCFA</span>
                      @if($s->etatPublication === 'publie')
                        <span class="badge bg-success-subtle text-success rounded-pill" style="font-size:.68rem;">Publie</span>
                      @elseif($s->etatPublication === 'retire')
                        <span class="badge bg-danger-subtle text-danger rounded-pill" style="font-size:.68rem;">Retire</span>
                      @else
                        <span class="badge bg-warning-subtle text-warning rounded-pill" style="font-size:.68rem;">Draft</span>
                      @endif
                      @if($s->scoringService > 0)
                        <span class="text-warning small">★ {{ number_format($s->scoringService, 1) }}</span>
                      @endif
                    </div>
                  </div>
                  <a href="{{ route('admin.services.show', $s) }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3">Voir</a>
                </div>
              </div>
            </div>
            @empty
            <p class="text-secondary small p-4 mb-0">Aucun service pour ce commerce.</p>
            @endforelse
          </div>
        </div>

        {{-- Commentaires --}}
        <div class="card border-0 shadow-sm">
          <div class="card-header bg-white py-3 px-4">
            <h6 class="mb-0 fw-semibold">Commentaires ({{ $commerce->commentaires->count() }})</h6>
          </div>
          <div class="card-body p-0">
            @forelse($commerce->commentaires as $com)
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
