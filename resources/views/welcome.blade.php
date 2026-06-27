
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

    @if(Auth::check())
        {{-- ═══════════════════════════════════════════════
         SECTION IMAGES — Galerie artisans
    ═══════════════════════════════════════════════ --}}
    <div class="row mt-5 mb-2 px-10">
        <div class="col-12">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <div>
                    <h2 class="fw-bold mb-1" style="font-size:1.4rem;">
                        Découvrez nos métiers
                    </h2>
                    <p class="text-secondary mb-0 small">
                        Des professionnels qualifiés à votre service dans toute la région
                    </p>
                </div>
                <a href="#!" class="btn btn-outline-primary btn-sm rounded-pill px-4">
                    Voir tous les artisans
                </a>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-6 px-10">

        {{-- Carte 1 — Mécanique auto --}}
        <div class="col-xl-6 col-lg-6 col-md-6 col-12">
            <div class="card border-0 shadow-sm h-100 overflow-hidden rounded-4 artisan-card">
                <div class="position-relative overflow-hidden" style="height:260px;">
                    <img src="{{ asset('freepik/bipoc-specialist-car-service-using-professional-mechanical-tool-repair-broken-ignition-system-licensed-specialist-garage-fixing-client-automobile-ensuring-optimal-automotive-performance.jpg') }}"
                         alt="Mécanicien automobile"
                         class="w-100 h-100 artisan-img"
                         style="object-fit:cover;transition:transform .5s ease;">
                    <div class="position-absolute inset-0 w-100 h-100"
                         style="background:linear-gradient(to top,rgba(0,0,0,.65) 0%,transparent 60%);top:0;left:0;">
                    </div>
                    <div class="position-absolute bottom-0 start-0 p-4">
                        <span class="badge rounded-pill px-3 py-2"
                              style="background:rgba(99,102,241,0.9);font-size:.75rem;">
                            🔧 Mécanique
                        </span>
                    </div>
                </div>
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-2">Service Automobile Professionnel</h5>
                    <p class="text-secondary mb-3" style="font-size:.88rem;line-height:1.6;">
                        Nos mécaniciens certifiés diagnostiquent et réparent tous types de véhicules.
                        Expertise reconnue, équipements de pointe et garantie sur chaque intervention.
                    </p>
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="#f59e0b" viewBox="0 0 16 16">
                                <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="#f59e0b" viewBox="0 0 16 16">
                                <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="#f59e0b" viewBox="0 0 16 16">
                                <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="#f59e0b" viewBox="0 0 16 16">
                                <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="#e5e7eb" viewBox="0 0 16 16">
                                <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                            </svg>
                            <span class="text-secondary ms-1" style="font-size:.78rem;">4.8 (124 avis)</span>
                        </div>
                        <a href="#!" class="btn btn-primary btn-sm rounded-pill px-3">Contacter</a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Carte 2 — Menuiserie --}}
        <div class="col-xl-6 col-lg-6 col-md-6 col-12">
            <div class="card border-0 shadow-sm h-100 overflow-hidden rounded-4 artisan-card">
                <div class="position-relative overflow-hidden" style="height:260px;">
                    <img src="{{ asset('freepik/carpenter-cutting-mdf-board-inside-workshop.jpg') }}"
                         alt="Menuisier en atelier"
                         class="w-100 h-100 artisan-img"
                         style="object-fit:cover;transition:transform .5s ease;">
                    <div class="position-absolute inset-0 w-100 h-100"
                         style="background:linear-gradient(to top,rgba(0,0,0,.65) 0%,transparent 60%);top:0;left:0;">
                    </div>
                    <div class="position-absolute bottom-0 start-0 p-4">
                        <span class="badge rounded-pill px-3 py-2"
                              style="background:rgba(217,119,6,0.9);font-size:.75rem;">
                            🪵 Menuiserie
                        </span>
                    </div>
                </div>
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-2">Menuiserie & Travaux sur Bois</h5>
                    <p class="text-secondary mb-3" style="font-size:.88rem;line-height:1.6;">
                        Fabrication sur mesure de meubles, parquets, portes et aménagements intérieurs.
                        Chaque pièce est travaillée avec passion et souci du détail.
                    </p>
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="#f59e0b" viewBox="0 0 16 16">
                                <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="#f59e0b" viewBox="0 0 16 16">
                                <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="#f59e0b" viewBox="0 0 16 16">
                                <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="#f59e0b" viewBox="0 0 16 16">
                                <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="#f59e0b" viewBox="0 0 16 16">
                                <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                            </svg>
                            <span class="text-secondary ms-1" style="font-size:.78rem;">5.0 (87 avis)</span>
                        </div>
                        <a href="#!" class="btn btn-primary btn-sm rounded-pill px-3">Contacter</a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Carte 3 — Travaux de précision --}}
        <div class="col-xl-6 col-lg-6 col-md-6 col-12">
            <div class="card border-0 shadow-sm h-100 overflow-hidden rounded-4 artisan-card">
                <div class="position-relative overflow-hidden" style="height:260px;">
                    <img src="{{ asset('freepik/man-wears-safety-goggles-while-using-chisel-hammer-avoid-injury.jpg') }}"
                         alt="Artisan avec outils de précision"
                         class="w-100 h-100 artisan-img"
                         style="object-fit:cover;transition:transform .5s ease;">
                    <div class="position-absolute inset-0 w-100 h-100"
                         style="background:linear-gradient(to top,rgba(0,0,0,.65) 0%,transparent 60%);top:0;left:0;">
                    </div>
                    <div class="position-absolute bottom-0 start-0 p-4">
                        <span class="badge rounded-pill px-3 py-2"
                              style="background:rgba(5,150,105,0.9);font-size:.75rem;">
                            ⚒️ Travaux manuels
                        </span>
                    </div>
                </div>
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-2">Travaux de Précision & Sécurité</h5>
                    <p class="text-secondary mb-3" style="font-size:.88rem;line-height:1.6;">
                        Taille de pierre, sculpture et travaux de précision réalisés dans le respect
                        des normes de sécurité. Un artisanat exigeant pour des résultats impeccables.
                    </p>
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="#f59e0b" viewBox="0 0 16 16">
                                <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="#f59e0b" viewBox="0 0 16 16">
                                <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="#f59e0b" viewBox="0 0 16 16">
                                <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="#f59e0b" viewBox="0 0 16 16">
                                <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="#e5e7eb" viewBox="0 0 16 16">
                                <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                            </svg>
                            <span class="text-secondary ms-1" style="font-size:.78rem;">4.7 (56 avis)</span>
                        </div>
                        <a href="#!" class="btn btn-primary btn-sm rounded-pill px-3">Contacter</a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Carte 4 — Fabrication bois --}}
        <div class="col-xl-6 col-lg-6 col-md-6 col-12">
            <div class="card border-0 shadow-sm h-100 overflow-hidden rounded-4 artisan-card">
                <div class="position-relative overflow-hidden" style="height:260px;">
                    <img src="{{ asset('freepik/medium-shot-man-working-with-hand-saw.jpg') }}"
                         alt="Artisan scie à main"
                         class="w-100 h-100 artisan-img"
                         style="object-fit:cover;transition:transform .5s ease;">
                    <div class="position-absolute inset-0 w-100 h-100"
                         style="background:linear-gradient(to top,rgba(0,0,0,.65) 0%,transparent 60%);top:0;left:0;">
                    </div>
                    <div class="position-absolute bottom-0 start-0 p-4">
                        <span class="badge rounded-pill px-3 py-2"
                              style="background:rgba(124,58,237,0.9);font-size:.75rem;">
                            🪚 Découpe & Fabrication
                        </span>
                    </div>
                </div>
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-2">Découpe & Fabrication sur Mesure</h5>
                    <p class="text-secondary mb-3" style="font-size:.88rem;line-height:1.6;">
                        Réalisation de structures bois, charpentes et mobilier personnalisé.
                        Du plan à la livraison, votre artisan vous accompagne à chaque étape du projet.
                    </p>
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="#f59e0b" viewBox="0 0 16 16">
                                <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="#f59e0b" viewBox="0 0 16 16">
                                <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="#f59e0b" viewBox="0 0 16 16">
                                <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="#f59e0b" viewBox="0 0 16 16">
                                <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="#f59e0b" viewBox="0 0 16 16">
                                <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                            </svg>
                            <span class="text-secondary ms-1" style="font-size:.78rem;">4.9 (203 avis)</span>
                        </div>
                        <a href="#!" class="btn btn-primary btn-sm rounded-pill px-3">Contacter</a>
                    </div>
                </div>
            </div>
        </div>

    </div>

    @endif

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