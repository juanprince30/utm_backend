@extends('main.index')

@push('head')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
@endpush

@push('styles')
<style>
.commerce-card { transition: box-shadow .25s, transform .2s; cursor:pointer; }
.commerce-card:hover { box-shadow:0 12px 40px rgba(0,0,0,.12)!important; transform:translateY(-3px); }
.commerce-card img { transition: transform .4s; }
.commerce-card:hover img { transform: scale(1.05); }
.star-filled { color:#f59e0b; }
.star-empty  { color:#e5e7eb; }
.cert-badge  { background:linear-gradient(135deg,#f59e0b,#d97706); color:#fff; font-size:.7rem; padding:2px 8px; border-radius:999px; }
</style>
@endpush

@section('content')
<div class="pt-12 px-10">

    {{-- HERO --}}
    <div class="row mb-6">
        <div class="col-12">
            <div class="position-relative overflow-hidden rounded-4 shadow" style="height:420px;">
                <video id="artisanVideo" class="w-100 h-100 d-block" style="object-fit:cover;" autoplay muted playsinline src="{{ asset('freepik/video4.mp4') }}"></video>
                <div style="position:absolute;inset:0;background:linear-gradient(135deg,rgba(0,0,0,.65) 0%,rgba(0,0,0,.35) 100%);z-index:1;"></div>
                <div class="position-absolute w-100 h-100 d-flex flex-column justify-content-center px-5 px-lg-6" style="top:0;left:0;z-index:2;">
                    <span class="badge rounded-pill mb-3 px-3 py-2 align-self-start" style="backdrop-filter:blur(6px);color:#fff;font-size:.78rem;letter-spacing:.06em;">Plateforme d'artisans</span>
                    <h1 class="text-white fw-bold mb-3" style="font-size:clamp(1.6rem,4vw,2.4rem);line-height:1.25;">Bienvenue sur <span class="text-primary">ArtisanFaso</span></h1>
                    <p class="text-white mb-4" style="opacity:.85;max-width:540px;">Nous facilitons le contact entre des artisans qualifies et des personnes a la recherche de services fiables.</p>
                    <div class="d-flex gap-3 flex-wrap">
                        <a href="{{ route('commerces.index') }}" class="btn btn-primary fw-semibold rounded-pill px-4">Voir les commerces</a>
                        <a href="{{ route('services.index') }}"  class="btn btn-outline-light fw-semibold rounded-pill px-4">Voir les services</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @auth
        {{-- Bandeau localisation --}}
    <div id="geoAlert" class="alert alert-info alert-dismissible d-none mb-4" role="alert">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" class="me-2"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 11m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0"/><path d="M17.657 16.657l-4.243 4.243a2 2 0 0 1 -2.827 0l-4.244 -4.243a8 8 0 1 1 11.314 0z"/></svg>
        Activez la geolocalisation pour voir les commerces les plus proches de vous.
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>

    @if(session('error'))
    <div class="alert alert-warning alert-dismissible fade show mb-4">
        {{ session('error') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    {{-- Catalogue --}}
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h2 class="fw-bold mb-1" style="font-size:1.4rem;">
                @if($lat)Commerces a proximite @else Derniers commerces @endif
            </h2>
            <p class="text-secondary mb-0 small">Cliquez sur un commerce pour voir ses details et services</p>
        </div>
        <a href="{{ route('commerces.index', request()->only(['lat','lng'])) }}" class="btn btn-outline-primary btn-sm rounded-pill px-4">Voir tout</a>
    </div>

    @if($commerces->isEmpty())
    <div class="text-center py-6 text-secondary">Aucun commerce publie pour l'instant.</div>
    @else
    <div class="row g-4 mb-6">
        @foreach($commerces as $c)
        <div class="col-xl-3 col-md-6">
            <a href="{{ route('commerces.show', array_merge(['commerce' => $c->id], array_filter(['lat'=>$lat,'lng'=>$lng]))) }}" class="text-decoration-none">
            <div class="card border-0 shadow-sm h-100 overflow-hidden rounded-4 commerce-card">
                <div class="position-relative overflow-hidden" style="height:180px;">
                    @if(!empty($c->photos[0]))
                        <img src="{{ asset('storage/'.$c->photos[0]) }}" class="w-100 h-100" style="object-fit:cover;" alt="{{ $c->nomCormmercial }}">
                    @else
                        <div class="bg-light w-100 h-100 d-flex align-items-center justify-content-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="none" stroke="#ccc" stroke-width="1" viewBox="0 0 24 24"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 21l18 0"/><path d="M3 7v1a3 3 0 0 0 6 0v-1m0 1a3 3 0 0 0 6 0v-1m0 1a3 3 0 0 0 6 0v-1h-18l2 -4h14l2 4"/><path d="M5 21l0 -10.15"/><path d="M19 21l0 -10.15"/><path d="M9 21v-4a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v4"/></svg>
                        </div>
                    @endif
                    <div class="position-absolute top-0 start-0 m-2 d-flex gap-1 flex-wrap">
                        <span class="badge bg-info-subtle text-info rounded-pill" style="font-size:.72rem;">{{ $c->categorie }}</span>
                        @if($c->user && $c->user->isCertified)
                            <span class="cert-badge">✓ Certifie</span>
                        @endif
                    </div>
                    @if(isset($c->distance))
                        <span class="position-absolute bottom-0 end-0 m-2 badge bg-dark bg-opacity-75 text-white" style="font-size:.7rem;">{{ $c->distance }} km</span>
                    @endif
                </div>
                <div class="card-body p-3">
                    <h6 class="fw-semibold mb-1 fw-bold">{{ $c->nomCormmercial }}</h6>
                    <p class="text-secondary small mb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" class="me-1"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 11m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0"/><path d="M17.657 16.657l-4.243 4.243a2 2 0 0 1 -2.827 0l-4.244 -4.243a8 8 0 1 1 11.314 0z"/></svg>
                        {{ $c->ville }}
                    </p>
                    @if($c->scoringCommerce > 0)
                    <div class="d-flex align-items-center gap-1">
                        @foreach(range(1,5) as $i)
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 16 16" fill="{{ $i <= $c->scoringCommerce ? '#f59e0b' : '#e5e7eb' }}"><path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/></svg>
                        @endforeach
                        <span class="text-secondary ms-1" style="font-size:.72rem;">{{ number_format($c->scoringCommerce, 1) }}/5</span>
                    </div>
                    @endif
                </div>
            </div>
            </a>
        </div>
        @endforeach
    </div>
    @endif
    @endauth

    {{-- CTA --}}
    <div class="row mb-6">
        <div class="col-12">
            <div class="rounded-4 p-6 text-center text-white bg-primary">
                <h3 class="fw-bold mb-2">Vous etes artisan ?</h3>
                <p class="mb-4 opacity-75">Rejoignez notre communaute et developpez votre clientele des aujourd'hui.</p>
                <div class="d-flex gap-3 justify-content-center flex-wrap">
                    @guest
                        <a href="{{ route('login.form') }}" class="btn btn-secondary fw-semibold px-5 rounded-pill">Creer mon profil</a>
                    @endguest
                    @auth
                        @if(Auth::user()->canCormmerce)
                            <a href="{{ route('artisan.dashboard') }}" class="btn btn-secondary fw-semibold px-5 rounded-pill">Espace Artisan</a>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@include('main.navbar')

@push('scripts')
<script>
(function () {
    const videos = [
        "{{ asset('freepik/video1.mp4') }}","{{ asset('freepik/video2.mp4') }}",
        "{{ asset('freepik/video3.mp4') }}","{{ asset('freepik/video4.mp4') }}"
    ];
    let idx = 0;
    function init() {
        const v = document.getElementById('artisanVideo');
        if (!v) return;
        v.addEventListener('ended', () => { idx = (idx+1)%videos.length; v.src=videos[idx]; v.play().catch(()=>{}); });
        v.play().catch(()=>{});
    }
    document.readyState==='loading' ? document.addEventListener('DOMContentLoaded',init) : init();

    // Géolocalisation
    const hasPos = new URLSearchParams(location.search).has('lat');
    if (!hasPos && navigator.geolocation) {
        document.getElementById('geoAlert')?.classList.remove('d-none');
        navigator.geolocation.getCurrentPosition(pos => {
            const p = new URLSearchParams(location.search);
            p.set('lat', pos.coords.latitude.toFixed(6));
            p.set('lng', pos.coords.longitude.toFixed(6));
            window.location.search = p.toString();
        });
    }
})();
</script>
@endpush
