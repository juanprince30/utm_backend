@extends('main.index')

@push('head')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
@endpush

@push('styles')
<style>
.cert-badge{background:linear-gradient(135deg,#f59e0b,#d97706);color:#fff;font-size:.75rem;padding:3px 10px;border-radius:999px;}
.service-card{transition:box-shadow .2s;border:1px solid #e5e7eb;}
.service-card:hover{box-shadow:0 6px 20px rgba(0,0,0,.08);}
</style>
@endpush

@section('content')
<div class="custom-container py-6  pt-12 px-10">

    @if(session('success'))<div class="alert alert-success alert-dismissible fade show mb-4">{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>@endif
    @if(session('error'))<div class="alert alert-warning alert-dismissible fade show mb-4">{{ session('error') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>@endif
    @if($errors->any())<div class="alert alert-danger alert-dismissible fade show mb-4"><ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>@endif

    {{-- Retour --}}
    <div class="mb-4">
        <a href="{{ route('commerces.index', array_filter(['lat'=>$lat,'lng'=>$lng])) }}" class="btn btn-ghost btn-sm rounded-pill text-secondary">
            ← Retour aux commerces
        </a>
    </div>

    <div class="row g-5">

        {{-- Colonne gauche --}}
        <div class="col-xl-8">

            {{-- Photos --}}
            @if(!empty($commerce->photos))
            <div class="mb-5">
                <div class="row g-2">
                    @foreach($commerce->photos as $idx => $photo)
                    <div class="{{ $idx === 0 ? 'col-12' : 'col-4' }}">
                        <img src="{{ asset('storage/'.$photo) }}"
                             class="w-100 rounded-3"
                             style="height:{{ $idx===0?'340px':'110px' }};object-fit:cover;"
                             alt="Photo {{ $idx+1 }}">
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Header --}}
            <div class="d-flex align-items-start justify-content-between mb-4 flex-wrap gap-3">
                <div>
                    <div class="d-flex align-items-center gap-2 mb-1 flex-wrap">
                        <h1 class="fw-bold mb-0" style="font-size:1.6rem;">{{ $commerce->nomCormmercial }}</h1>
                        @if($commerce->user && $commerce->user->isCertified)<span class="cert-badge">✓ Artisan Certifie</span>@endif
                    </div>
                    <div class="d-flex gap-2 flex-wrap align-items-center">
                        <span class="badge bg-info-subtle text-info rounded-pill">{{ $commerce->categorie }}</span>
                        <span class="text-secondary small"><svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" class="me-1"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 11m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0"/><path d="M17.657 16.657l-4.243 4.243a2 2 0 0 1 -2.827 0l-4.244 -4.243a8 8 0 1 1 11.314 0z"/></svg>{{ $commerce->ville }}</span>
                        @if($commerce->scoringCommerce > 0)
                        <div class="d-flex align-items-center gap-1">
                            @foreach(range(1,5) as $i)
                                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 16 16" fill="{{ $i <= $commerce->scoringCommerce ? '#f59e0b' : '#e5e7eb' }}"><path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/></svg>
                            @endforeach
                            <span class="text-secondary ms-1 small">{{ number_format($commerce->scoringCommerce,1) }}/5</span>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="d-flex gap-2 flex-wrap">
                    @if($commerce->lienCommerce)<a href="{{ $commerce->lienCommerce }}" target="_blank" class="btn btn-outline-primary btn-sm rounded-pill px-3">Site web</a>@endif
                </div>
            </div>

            {{-- Infos contact --}}
            <div class="card border-0 shadow-sm mb-5">
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <p class="text-secondary small mb-1 fw-semibold text-uppercase" style="font-size:.7rem;letter-spacing:.05em;">Telephone</p>
                            <p class="mb-0 fw-semibold">{{ $commerce->conctactResponsable }}</p>
                        </div>
                        @if($commerce->emailCommerce)
                        <div class="col-md-4">
                            <p class="text-secondary small mb-1 fw-semibold text-uppercase" style="font-size:.7rem;letter-spacing:.05em;">Email</p>
                            <p class="mb-0">{{ $commerce->emailCommerce }}</p>
                        </div>
                        @endif
                        @if($commerce->user)
                        <div class="col-md-4">
                            <p class="text-secondary small mb-1 fw-semibold text-uppercase" style="font-size:.7rem;letter-spacing:.05em;">Proprietaire</p>
                            <p class="mb-0">{{ $commerce->user->prenom }} {{ $commerce->user->name }}
                                @if($commerce->user->scoringArtisant > 0)
                                <span class="text-warning ms-1">★ {{ number_format($commerce->user->scoringArtisant,1) }}</span>
                                @endif
                            </p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Services --}}
            @if($commerce->services->isNotEmpty())
            <div class="mb-5">
                <h4 class="fw-semibold mb-4">Services proposes ({{ $commerce->services->count() }})</h4>
                <div class="row g-3">
                    @foreach($commerce->services as $s)
                    <div class="col-md-6">
                        <div class="card service-card rounded-3 h-100">
                            <div class="d-flex gap-3 p-3 align-items-start">
                                @if($s->photo)
                                    <img src="{{ asset('storage/'.$s->photo) }}" style="width:70px;height:70px;object-fit:cover;border-radius:8px;flex-shrink:0;" alt="{{ $s->nomService }}">
                                @else
                                    <div class="bg-light d-flex align-items-center justify-content-center flex-shrink-0" style="width:70px;height:70px;border-radius:8px;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="none" stroke="#ccc" stroke-width="1.5" viewBox="0 0 24 24"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 3l8 4v10l-8 4l-8 -4v-10z"/></svg>
                                    </div>
                                @endif
                                <div class="flex-grow-1 min-width-0">
                                    <h6 class="fw-semibold mb-1 small">{{ $s->nomService }}</h6>
                                    @if($s->description)<p class="text-secondary mb-1" style="font-size:.8rem;line-clamp:2;">{{ Str::limit($s->description, 70) }}</p>@endif
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="fw-bold text-primary small">{{ number_format($s->prixService, 0, ',', ' ') }} FCFA</span>
                                        @if($s->scoringService > 0)
                                        <div class="d-flex align-items-center gap-1">
                                            @foreach(range(1,5) as $i)
                                                <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 16 16" fill="{{ $i <= $s->scoringService ? '#f59e0b' : '#e5e7eb' }}"><path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/></svg>
                                            @endforeach
                                            <span class="text-secondary" style="font-size:.68rem;">{{ number_format($s->scoringService,1) }}</span>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Commentaires --}}
            <div class="mb-5">
                <h4 class="fw-semibold mb-4">Commentaires ({{ $commerce->commentaires->count() }})</h4>
                @auth
                    @if(Auth::id() !== $commerce->IdUser)
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body p-4">
                            <form method="POST" action="{{ route('commerces.comment', $commerce) }}">
                                @csrf
                                <label class="form-label fw-medium small">Votre commentaire</label>
                                <textarea name="body" class="form-control mb-3" rows="3" maxlength="500" placeholder="Partagez votre experience...">{{ old('body') }}</textarea>
                                <button type="submit" class="btn btn-primary rounded-pill px-4 btn-sm">Publier</button>
                            </form>
                        </div>
                    </div>
                    @else
                    <div class="alert alert-info small mb-4">Vous ne pouvez pas commenter votre propre commerce.</div>
                    @endif
                @else
                <div class="alert alert-light border mb-4 small">
                    <a href="{{ route('login.form') }}" class="fw-semibold">Connectez-vous</a> pour laisser un commentaire.
                </div>
                @endauth

                @forelse($commerce->commentaires as $com)
                <div class="d-flex gap-3 mb-4">
                    <div class="flex-shrink-0">
                        @if($com->user && $com->user->photo)
                            <img src="{{ asset('storage/'.$com->user->photo) }}" class="rounded-circle" style="width:40px;height:40px;object-fit:cover;" alt="">
                        @else
                            <div class="rounded-circle bg-primary-subtle text-primary d-flex align-items-center justify-content-center fw-bold" style="width:40px;height:40px;font-size:.85rem;">
                                {{ strtoupper(substr($com->user?->prenom ?? '?', 0, 1)) }}{{ strtoupper(substr($com->user?->name ?? '', 0, 1)) }}
                            </div>
                        @endif
                    </div>
                    <div class="flex-grow-1">
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <span class="fw-semibold small">{{ $com->user?->prenom }} {{ $com->user?->name }}</span>
                            <span class="text-secondary" style="font-size:.75rem;">{{ $com->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="mb-0 small" style="line-height:1.6;">{{ $com->body }}</p>
                    </div>
                </div>
                @empty
                <p class="text-secondary small">Aucun commentaire pour le moment. Soyez le premier !</p>
                @endforelse
            </div>

        </div>

        {{-- Colonne droite --}}
        <div class="col-xl-4">

            {{-- Carte --}}
            @if(isset($pos['lat'], $pos['lng']))
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3 px-4"><h6 class="mb-0 fw-semibold">Localisation</h6></div>
                <div class="card-body p-0">
                    <div id="miniMap" style="height:220px;border-radius:0 0 8px 8px;"></div>
                </div>
            </div>
            @endif

            {{-- Horaires --}}
            @if(!empty($commerce->horaire))
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3 px-4"><h6 class="mb-0 fw-semibold">Horaires</h6></div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush small">
                        @foreach($commerce->horaire as $jour => $h)
                        <li class="list-group-item d-flex justify-content-between px-4 py-2">
                            <span class="fw-medium">{{ $jour }}</span>
                            @if(!empty($h['ferme']) && $h['ferme'])
                                <span class="text-danger">Ferme</span>
                            @else
                                <span class="text-secondary">{{ $h['ouverture'] ?? '' }} – {{ $h['fermeture'] ?? '' }}</span>
                            @endif
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif

        </div>

    </div>

</div>
@endsection

@include('main.navbar')

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
@if(isset($pos['lat'], $pos['lng']))
(function () {
    const map = L.map('miniMap', { zoomControl: true, scrollWheelZoom: false })
                 .setView([{{ $pos['lat'] }}, {{ $pos['lng'] }}], 15);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap'
    }).addTo(map);
    L.marker([{{ $pos['lat'] }}, {{ $pos['lng'] }}])
     .addTo(map)
     .bindPopup('{{ addslashes($commerce->nomCormmercial) }}')
     .openPopup();
})();
@endif
</script>
@endpush
