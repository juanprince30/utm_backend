
@extends('main.index')

@section('content')

<!-- container -->
<div class="pt-12 px-10">
    {{-- HERO : Video en fond + texte par-dessus --}}
    <div class="row">
        <div class="col-12">
            <div class="position-relative overflow-hidden rounded-4 shadow"
                 style="height:420px;">

                {{-- Video background - playlist auto --}}
                <video id="artisanVideo"
                    class="w-100 h-100 d-block"
                    style="object-fit:cover;"
                    autoplay muted playsinline
                    src="{{ asset('freepik/video4.mp4') }}">
                </video>

                {{-- Overlay sombre --}}
                <div style="position:absolute;inset:0;background:linear-gradient(135deg,rgba(0,0,0,.65) 0%,rgba(0,0,0,.35) 100%);z-index:1;"></div>

                {{-- Texte par-dessus la video --}}
                <div class="position-absolute w-100 h-100 d-flex flex-column justify-content-center px-5 px-lg-6"
                     style="top:0;left:0;z-index:2;">
                    <span class="badge rounded-pill mb-3 px-3 py-2 align-self-start"
                          style="backdrop-filter:blur(6px);color:#fff;font-size:.78rem;letter-spacing:.06em;"
                          class="bg-secondary">
                        Plateforme d'artisans
                    </span>
                    <h1 class="text-white fw-bold mb-3" style="font-size:clamp(1.6rem,4vw,2.4rem);line-height:1.25;">
                        Bienvenue sur <span class="text-primary">ArtisanFaso</span>
                    </h1>
                    <p class="text-white mb-1" style="opacity:.85;max-width:540px;font-size:1rem;line-height:1.65;">
                        Nous facilitons le contact entre des artisans qualifies et des personnes a la recherche de services fiables.
                    </p>
                    <p class="text-white mb-4" style="opacity:.7;max-width:480px;font-size:.92rem;">
                        Publiez vos besoins ou proposez vos services en toute simplicite.
                    </p>
                    <div class="d-flex gap-3 flex-wrap">
                        <a href="#!" class="btn btn-primary fw-semibold rounded-pill px-4">
                            Voir les commerces
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>

    
    {{-- ═══════════════════════════════════════════════
         CTA Banner final
    ═══════════════════════════════════════════════ --}}
    <div class="row mb-6">
        <div class="col-12">
            <div class="rounded-4 p-6 text-center text-white"
                 class="bg-primary">
                <h3 class="fw-bold mb-2">Vous êtes artisan ?</h3>
                <p class="mb-4 opacity-75">
                    Rejoignez notre communauté et développez votre clientèle dès aujourd'hui.
                </p>
                <div class="d-flex gap-3 justify-content-center flex-wrap">
                    <a href="#!" class="btn btn-secondary fw-semibold px-5 rounded-pill">
                        Créer mon profil
                    </a>
                    <a href="#!" class="btn fw-semibold px-5 rounded-pill btn-info">
                        En savoir plus
                    </a>
                </div>
            </div>
        </div>
    </div>

</div>

{{-- ═══════════════════════════════════════════════
     STYLES & SCRIPTS
═══════════════════════════════════════════════ --}}
@push('styles')
<style>
    .artisan-card:hover .artisan-img { transform: scale(1.06); }
    .artisan-card { transition: box-shadow .3s ease, transform .2s ease; }
    .artisan-card:hover { box-shadow: 0 12px 40px rgba(0,0,0,.12) !important; transform: translateY(-3px); }
    .active-video-btn {
        background: rgba(255,255,255,0.25) !important;
        border-color: rgba(255,255,255,0.6) !important;
        color: #fff !important;
    }
    @keyframes pulse-green {
        0%, 100% { opacity: 1; transform: scale(1); }
        50% { opacity: .5; transform: scale(1.4); }
    }
</style>
@endpush


@push('scripts')
<script>
(function () {
    const videos = [
        "{{ asset('freepik/video1.mp4') }}",
        "{{ asset('freepik/video2.mp4') }}",
        "{{ asset('freepik/video3.mp4') }}",
        "{{ asset('freepik/video4.mp4') }}"
    ];

    let currentIndex = 0;

    function init() {
        const videoEl    = document.getElementById('artisanVideo');
        const progressEl = document.getElementById('videoProgress');
        const counterEl  = document.getElementById('videoCounter');

        if (!videoEl) return;

        function loadAndPlay(index) {
            currentIndex = index;
            progressEl.style.width = '0%';
            counterEl.textContent  = (index + 1) + ' / ' + videos.length;
            videoEl.src = videos[index];
            videoEl.load();
            videoEl.play().catch(function() {
                // autoplay bloque -> on attend un clic
                document.addEventListener('click', function tryPlay() {
                    videoEl.play().catch(function(){});
                    document.removeEventListener('click', tryPlay);
                }, { once: true });
            });
        }

        videoEl.addEventListener('timeupdate', function () {
            if (videoEl.duration) {
                progressEl.style.width = (videoEl.currentTime / videoEl.duration * 100) + '%';
            }
        });

        videoEl.addEventListener('ended', function () {
            loadAndPlay((currentIndex + 1) % videos.length);
        });

        videoEl.addEventListener('error', function () {
            loadAndPlay((currentIndex + 1) % videos.length);
        });

        loadAndPlay(0);
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
</script>
@endpush


@endsection

@include('main.navbar')