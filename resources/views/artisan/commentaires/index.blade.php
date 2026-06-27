@include('artisan.sidebarArtisan')

@extends('main.index')

@section('content')
<div>
  <div class="custom-container py-6">

    <div class="d-flex align-items-center justify-content-between mb-6">
      <div>
        <h2 class="fw-bold mb-1">Mes Commentaires</h2>
        <p class="text-secondary mb-0 small">{{ $commentaires->total() }} commentaire(s) au total sur vos commerces et services</p>
      </div>
    </div>

    @if(session('success'))
      <div class="alert alert-success alert-dismissible fade show mb-4">
        {{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    @endif

    <div class="row g-4">

      {{-- Colonne gauche : liste de tous les commentaires --}}
      <div class="col-xl-8">
        <div class="card border-0 shadow-sm">
          <div class="card-header bg-white py-3 px-4">
            <h6 class="mb-0 fw-semibold">Tous les commentaires recus</h6>
          </div>
          <div class="card-body p-0">

            @forelse($commentaires as $com)
            <div class="d-flex gap-3 p-4 border-bottom">
              {{-- Avatar --}}
              <div class="flex-shrink-0">
                @if($com->user && $com->user->photo)
                  <img src="{{ asset('storage/' . $com->user->photo) }}"
                       class="rounded-circle" style="width:40px;height:40px;object-fit:cover;" alt="">
                @else
                  <div class="rounded-circle bg-primary-subtle text-primary d-flex align-items-center justify-content-center fw-bold"
                       style="width:40px;height:40px;font-size:.85rem;">
                    {{ strtoupper(substr($com->user?->prenom ?? '?', 0, 1)) }}{{ strtoupper(substr($com->user?->name ?? '', 0, 1)) }}
                  </div>
                @endif
              </div>

              {{-- Contenu --}}
              <div class="flex-grow-1">
                <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
                  <div>
                    <span class="fw-semibold small">{{ $com->user?->prenom }} {{ $com->user?->name }}</span>
                    <span class="text-secondary ms-2" style="font-size:.75rem;">{{ $com->created_at->diffForHumans() }}</span>
                  </div>
                  <div class="d-flex align-items-center gap-2 flex-wrap">
                    {{-- Commerce ou service concerné --}}
                    @if($com->service)
                      <span class="badge bg-success-subtle text-success rounded-pill" style="font-size:.7rem;">
                        Service : {{ $com->service->nomService }}
                      </span>
                    @endif
                    <span class="badge bg-info-subtle text-info rounded-pill" style="font-size:.7rem;">
                      {{ $com->commerce?->nomCormmercial }}
                    </span>
                  </div>
                </div>
                <p class="mb-0 small mt-1" style="line-height:1.6;">{{ $com->body }}</p>
              </div>
            </div>
            @empty
            <div class="text-center py-6 text-secondary">
              Aucun commentaire recu pour le moment.
            </div>
            @endforelse

          </div>
          @if($commentaires->hasPages())
          <div class="card-footer bg-white d-flex justify-content-center py-3">
            {{ $commentaires->links() }}
          </div>
          @endif
        </div>
      </div>

      {{-- Colonne droite : par commerce --}}
      <div class="col-xl-4">
        <div class="card border-0 shadow-sm">
          <div class="card-header bg-white py-3 px-4">
            <h6 class="mb-0 fw-semibold">Par commerce</h6>
          </div>
          <div class="list-group list-group-flush" id="commerceAccordion">

            @forelse($commerces as $c)
            <div>
              {{-- En-tête commerce (cliquable) --}}
              <button class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-3 px-4 border-0 text-start w-100 bg-transparent"
                      type="button"
                      data-bs-toggle="collapse"
                      data-bs-target="#commerce-{{ $c->id }}"
                      aria-expanded="false">
                <div>
                  <p class="fw-semibold small mb-0">{{ $c->nomCormmercial }}</p>
                  <span class="text-secondary" style="font-size:.75rem;">{{ $c->ville }} · {{ $c->categorie }}</span>
                </div>
                <div class="d-flex align-items-center gap-2">
                  <span class="badge bg-primary-subtle text-primary rounded-pill">{{ $c->commentaires_count }}</span>
                  <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" stroke="currentColor"
                       stroke-width="2" viewBox="0 0 24 24" class="text-secondary">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M6 9l6 6l6 -6"/>
                  </svg>
                </div>
              </button>

              {{-- Commentaires du commerce --}}
              <div id="commerce-{{ $c->id }}" class="collapse">
                @php
                  $coms = $c->commentaires()->with('user', 'service')->latest()->get();
                @endphp
                @if($coms->isEmpty())
                  <p class="text-secondary small px-4 py-2 mb-0">Aucun commentaire.</p>
                @else
                  @foreach($coms as $com)
                  <div class="px-4 py-3 bg-light border-top">
                    <div class="d-flex gap-2 align-items-start">
                      <div class="flex-shrink-0">
                        <div class="rounded-circle bg-secondary-subtle text-secondary d-flex align-items-center justify-content-center fw-bold"
                             style="width:32px;height:32px;font-size:.75rem;">
                          {{ strtoupper(substr($com->user?->prenom ?? '?', 0, 1)) }}
                        </div>
                      </div>
                      <div class="flex-grow-1">
                        <div class="d-flex justify-content-between align-items-center">
                          <span class="fw-semibold" style="font-size:.8rem;">{{ $com->user?->prenom }} {{ $com->user?->name }}</span>
                          <span class="text-secondary" style="font-size:.72rem;">{{ $com->created_at->format('d/m/Y') }}</span>
                        </div>
                        @if($com->service)
                          <span class="badge bg-success-subtle text-success rounded-pill mb-1" style="font-size:.65rem;">
                            {{ $com->service->nomService }}
                          </span>
                        @endif
                        <p class="mb-0 small">{{ $com->body }}</p>
                      </div>
                    </div>
                  </div>
                  @endforeach
                @endif

                {{-- Lien voir le commerce --}}
                <div class="px-4 py-2 border-top">
                  <a href="{{ route('commerces.show', $c) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3" style="font-size:.78rem;">
                    Voir le commerce public
                  </a>
                </div>
              </div>
            </div>
            @empty
            <div class="p-4 text-secondary small">Aucun commerce.</div>
            @endforelse

          </div>
        </div>
      </div>

    </div>

  </div>
</div>
@endsection

@include('main.navbarWithsidebar')
