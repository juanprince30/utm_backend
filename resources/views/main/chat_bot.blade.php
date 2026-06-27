@extends('main.index')

@section('content')

{{-- ═══════════════════════════════════════════════
     CHATBOT — Assistant de recherche ArtisanFaso
     Front uniquement. Brancher l'API FastAPI dans
     le bloc JS (constante CHATBOT_API_URL).
═══════════════════════════════════════════════ --}}

<div class="chat-wrapper">
    <div class="chat-shell shadow-lg">

        {{-- ── En-tête de l'assistant ───────────────────── --}}
        <div class="chat-header">
            <div class="d-flex align-items-center gap-3">
                <div class="chat-bot-avatar">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24"
                         fill="none" stroke="currentColor" stroke-width="1.7"
                         stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M8 9h8" /><path d="M8 13h6" />
                        <path d="M9 18l-1 3l-3 -3h-1a3 3 0 0 1 -3 -3v-8a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v8a3 3 0 0 1 -3 3h-7z" />
                    </svg>
                    <span class="chat-status-dot"></span>
                </div>
                <div>
                    <h2 class="chat-bot-name mb-0">Faso Assistant</h2>
                    <span class="chat-bot-sub">
                        <span class="chat-online-dot"></span> En ligne · Trouve le commerce &amp; le produit qu'il vous faut
                    </span>
                </div>
            </div>
            <button type="button" class="btn btn-sm chat-reset-btn" id="chatReset" title="Nouvelle conversation">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="1.7"
                     stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M20 11a8.1 8.1 0 0 0 -15.5 -2m-.5 -4v4h4" />
                    <path d="M4 13a8.1 8.1 0 0 0 15.5 2m.5 4v-4h-4" />
                </svg>
            </button>
        </div>

        {{-- ── Fil de conversation ──────────────────────── --}}
        <div class="chat-body" id="chatBody">

            {{-- Message d'accueil --}}
            <div class="chat-row bot">
                <div class="chat-mini-avatar">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                         fill="none" stroke="currentColor" stroke-width="1.8"
                         stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M8 9h8" /><path d="M8 13h6" />
                        <path d="M9 18l-1 3l-3 -3h-1a3 3 0 0 1 -3 -3v-8a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v8a3 3 0 0 1 -3 3h-7z" />
                    </svg>
                </div>
                <div class="chat-bubble">
                    <p class="mb-2 fw-semibold">👋 Bonjour{{ Auth::check() ? ', '.Auth::user()->prenom : '' }} !</p>
                    <p class="mb-0">
                        Je suis votre assistant de recherche. Décrivez ce que vous cherchez
                        (un produit, un service, un artisan) — ou
                        <strong>envoyez la photo d'un produit</strong> 📷 et je retrouve le commerce qui le propose.
                    </p>
                </div>
            </div>

            {{-- Suggestions rapides --}}
            <div class="chat-suggestions" id="chatSuggestions">
                <span class="chat-suggestion-label">Essayez :</span>
                <button class="chat-chip" data-prompt="Je cherche un menuisier pour des meubles sur mesure">🪵 Meubles sur mesure</button>
                <button class="chat-chip" data-prompt="Trouve un mécanicien auto proche de moi">🔧 Mécanicien auto</button>
                <button class="chat-chip" data-prompt="Je veux des portes en bois de qualité">🚪 Portes en bois</button>
                <button class="chat-chip" data-prompt="Quel artisan pour de la sculpture et taille de pierre ?">⚒️ Taille de pierre</button>
                <button class="chat-chip" id="chatChipImage" type="button">📷 Rechercher par image</button>
            </div>

        </div>

        {{-- ── Indicateur de saisie (caché par défaut) ──── --}}
        <div class="chat-typing" id="chatTyping" hidden>
            <div class="chat-mini-avatar">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="1.8"
                     stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M8 9h8" /><path d="M8 13h6" />
                    <path d="M9 18l-1 3l-3 -3h-1a3 3 0 0 1 -3 -3v-8a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v8a3 3 0 0 1 -3 3h-7z" />
                </svg>
            </div>
            <div class="chat-bubble chat-typing-bubble">
                <span class="chat-dot"></span><span class="chat-dot"></span><span class="chat-dot"></span>
            </div>
        </div>

        {{-- ── Aperçu de l'image sélectionnée ──────────── --}}
        <div class="chat-image-preview" id="chatImagePreview" hidden>
            <img id="chatPreviewImg" src="" alt="Aperçu">
            <div class="chat-preview-info">
                <span class="chat-preview-name" id="chatPreviewName">image.jpg</span>
                <span class="chat-preview-hint">Recherche du produit par image</span>
            </div>
            <button type="button" class="chat-preview-remove" id="chatPreviewRemove" aria-label="Retirer l'image">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M18 6l-12 12"/><path d="M6 6l12 12"/>
                </svg>
            </button>
        </div>

        {{-- ── Zone de saisie ───────────────────────────── --}}
        <form class="chat-input-bar" id="chatForm" autocomplete="off">
            <input type="file" id="chatFile" accept="image/*" hidden>
            <button type="button" class="chat-attach-btn" id="chatAttach" aria-label="Joindre une image"
                    title="Rechercher un produit par image">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="1.7"
                     stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M15 8h.01" />
                    <path d="M3 6a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v12a3 3 0 0 1 -3 3h-12a3 3 0 0 1 -3 -3v-12z" />
                    <path d="M3 16l5 -5c.928 -.893 2.072 -.893 3 0l5 5" />
                    <path d="M14 14l1 -1c.928 -.893 2.072 -.893 3 0l3 3" />
                </svg>
            </button>
            <div class="chat-input-field">
                <textarea id="chatInput" rows="1" placeholder="Décrivez le produit, ou joignez une photo…"></textarea>
            </div>
            <button type="submit" class="chat-send-btn" id="chatSend" aria-label="Envoyer">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="1.8"
                     stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M10 14l11 -11" />
                    <path d="M21 3l-6.5 18a.55 .55 0 0 1 -1 0l-3.5 -7l-7 -3.5a.55 .55 0 0 1 0 -1l18 -6.5" />
                </svg>
            </button>
        </form>

    </div>

    <p class="chat-footnote">
        Faso Assistant peut faire des suggestions basées sur les commerces référencés. Vérifiez les informations avant de contacter.
    </p>
</div>


{{-- ═══════════════════════════════════════════════
     STYLES
═══════════════════════════════════════════════ --}}
<style>
    :root {
        --chat-primary: #4f46e5;
        --chat-primary-soft: rgba(79, 70, 229, .12);
        --chat-radius: 22px;
    }

    .chat-wrapper {
        max-width: 920px;
        margin: 0 auto;
        padding: 32px 16px 48px;
    }

    .chat-shell {
        display: flex;
        flex-direction: column;
        height: calc(100vh - 150px);
        min-height: 560px;
        background: var(--bs-body-bg, #fff);
        border: 1px solid var(--bs-border-color, #e5e7eb);
        border-radius: var(--chat-radius);
        overflow: hidden;
    }

    /* ── Header ── */
    .chat-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 16px 22px;
        background: linear-gradient(120deg, var(--chat-primary) 0%,rgb(58, 237, 103) 100%);
        color: #fff;
    }
    .chat-bot-avatar {
        position: relative;
        width: 46px; height: 46px;
        display: flex; align-items: center; justify-content: center;
        background: rgba(255,255,255,.18);
        border-radius: 14px;
        backdrop-filter: blur(6px);
    }
    .chat-status-dot {
        position: absolute; bottom: -2px; right: -2px;
        width: 13px; height: 13px;
        background: #22c55e;
        border: 2px solid #fff;
        border-radius: 50%;
    }
    .chat-bot-name { font-size: 1.05rem; font-weight: 700; letter-spacing: .2px; }
    .chat-bot-sub {
        font-size: .76rem; opacity: .9;
        display: inline-flex; align-items: center; gap: 6px;
    }
    .chat-online-dot {
        width: 7px; height: 7px; border-radius: 50%;
        background: #4ade80; display: inline-block;
        animation: chat-pulse 1.6s ease-in-out infinite;
    }
    .chat-reset-btn {
        color: #fff;
        background: rgba(255,255,255,.16);
        border: none; border-radius: 12px;
        width: 38px; height: 38px;
        display: flex; align-items: center; justify-content: center;
        transition: background .2s ease, transform .2s ease;
    }
    .chat-reset-btn:hover { background: rgba(255,255,255,.3); color: #fff; transform: rotate(-25deg); }

    /* ── Body ── */
    .chat-body {
        flex: 1;
        overflow-y: auto;
        padding: 24px 22px;
        display: flex;
        flex-direction: column;
        gap: 18px;
        background:
            radial-gradient(circle at 12% 8%, rgba(124,58,237,.05), transparent 38%),
            radial-gradient(circle at 92% 92%, rgba(79,70,229,.05), transparent 36%);
        scroll-behavior: smooth;
    }
    .chat-body::-webkit-scrollbar { width: 7px; }
    .chat-body::-webkit-scrollbar-thumb { background: rgba(120,120,120,.28); border-radius: 10px; }

    .chat-row { display: flex; align-items: flex-end; gap: 10px; max-width: 86%; }
    .chat-row.user { margin-left: auto; flex-direction: row-reverse; }

    .chat-mini-avatar {
        flex: 0 0 auto;
        width: 30px; height: 30px;
        display: flex; align-items: center; justify-content: center;
        background: var(--chat-primary-soft);
        color: var(--chat-primary);
        border-radius: 10px;
    }

    .chat-bubble {
        padding: 12px 16px;
        border-radius: 18px;
        font-size: .92rem;
        line-height: 1.55;
        background: var(--bs-secondary-bg, #f3f4f6);
        color: var(--bs-body-color, #1f2937);
        border-bottom-left-radius: 6px;
        box-shadow: 0 1px 2px rgba(0,0,0,.04);
        animation: chat-pop .25s ease;
    }
    .chat-row.user .chat-bubble {
        background: linear-gradient(120deg, var(--chat-primary) 0%,rgb(44, 218, 117) 100%);
        color: #fff;
        border-bottom-left-radius: 18px;
        border-bottom-right-radius: 6px;
    }
    .chat-bubble p:last-child { margin-bottom: 0; }

    /* ── Suggestions ── */
    .chat-suggestions { display: flex; flex-wrap: wrap; align-items: center; gap: 8px; padding-left: 40px; }
    .chat-suggestion-label { font-size: .78rem; color: var(--bs-secondary-color, #6b7280); }
    .chat-chip {
        border: 1px solid var(--bs-border-color, #e5e7eb);
        background: var(--bs-body-bg, #fff);
        color: var(--bs-body-color, #374151);
        font-size: .82rem;
        padding: 7px 14px;
        border-radius: 999px;
        cursor: pointer;
        transition: all .18s ease;
    }
    .chat-chip:hover {
        border-color: var(--chat-primary);
        color: var(--chat-primary);
        background: var(--chat-primary-soft);
        transform: translateY(-1px);
    }

    /* ── Typing ── */
    .chat-typing { display: flex; align-items: flex-end; gap: 10px; padding: 0 22px 6px; }
    .chat-typing-bubble { display: flex; gap: 5px; align-items: center; padding: 14px 16px; }
    .chat-dot {
        width: 7px; height: 7px; border-radius: 50%;
        background: var(--bs-secondary-color, #9ca3af);
        animation: chat-bounce 1.3s infinite ease-in-out;
    }
    .chat-dot:nth-child(2) { animation-delay: .18s; }
    .chat-dot:nth-child(3) { animation-delay: .36s; }

    /* ── Result cards ── */
    .chat-results { display: flex; flex-direction: column; gap: 12px; width: 100%; }
    .chat-result-intro { font-size: .82rem; color: var(--bs-secondary-color, #6b7280); padding-left: 2px; }
    .chat-card {
        display: flex;
        gap: 14px;
        background: var(--bs-body-bg, #fff);
        border: 1px solid var(--bs-border-color, #e5e7eb);
        border-radius: 16px;
        padding: 12px;
        text-decoration: none;
        color: inherit;
        transition: transform .2s ease, box-shadow .2s ease, border-color .2s ease;
        animation: chat-pop .3s ease;
    }
    .chat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 30px rgba(0,0,0,.10);
        border-color: var(--chat-primary);
    }
    .chat-card-img {
        flex: 0 0 auto;
        width: 92px; height: 92px;
        object-fit: cover;
        border-radius: 12px;
    }
    .chat-card-body { flex: 1; min-width: 0; display: flex; flex-direction: column; }
    .chat-card-cat {
        font-size: .68rem; font-weight: 600; text-transform: uppercase; letter-spacing: .05em;
        color: var(--chat-primary);
        background: var(--chat-primary-soft);
        padding: 2px 9px; border-radius: 999px; align-self: flex-start; margin-bottom: 5px;
    }
    .chat-card-title { font-size: .96rem; font-weight: 700; margin: 0 0 2px; }
    .chat-card-product { font-size: .82rem; color: var(--bs-body-color); margin: 0 0 6px; }
    .chat-card-meta { display: flex; flex-wrap: wrap; align-items: center; gap: 12px; margin-top: auto; }
    .chat-card-meta span { font-size: .76rem; color: var(--bs-secondary-color, #6b7280); display: inline-flex; align-items: center; gap: 4px; }
    .chat-card-price { font-weight: 700; color: #059669 !important; }
    .chat-card-cta {
        align-self: center;
        flex: 0 0 auto;
        font-size: .8rem; font-weight: 600;
        color: var(--chat-primary);
        display: inline-flex; align-items: center; gap: 4px;
    }

    /* ── Input bar ── */
    .chat-input-bar {
        display: flex; align-items: flex-end; gap: 10px;
        padding: 14px 18px;
        border-top: 1px solid var(--bs-border-color, #e5e7eb);
        background: var(--bs-body-bg, #fff);
    }
    .chat-input-field {
        flex: 1;
        background: var(--bs-secondary-bg, #f3f4f6);
        border: 1px solid transparent;
        border-radius: 16px;
        padding: 10px 16px;
        transition: border-color .2s ease, background .2s ease;
    }
    .chat-input-field:focus-within { border-color: var(--chat-primary); background: var(--bs-body-bg, #fff); }
    .chat-input-field textarea {
        width: 100%;
        border: none; outline: none; resize: none;
        background: transparent;
        color: var(--bs-body-color);
        font-size: .92rem; line-height: 1.5;
        max-height: 120px;
    }
    .chat-send-btn {
        flex: 0 0 auto;
        width: 46px; height: 46px;
        border: none; border-radius: 14px;
        background: linear-gradient(120deg, var(--chat-primary) 0%,rgb(31, 220, 116) 100%);
        color: #fff;
        display: flex; align-items: center; justify-content: center;
        cursor: pointer;
        transition: transform .15s ease, opacity .2s ease, box-shadow .2s ease;
        box-shadow: 0 6px 16px rgba(57, 225, 124, 0.35);
    }
    .chat-send-btn:hover { transform: translateY(-1px) scale(1.04); }
    .chat-send-btn:active { transform: scale(.96); }
    .chat-send-btn:disabled { opacity: .5; cursor: not-allowed; box-shadow: none; transform: none; }

    /* ── Bouton joindre image ── */
    .chat-attach-btn {
        flex: 0 0 auto;
        width: 46px; height: 46px;
        border: 1px solid var(--bs-border-color, #e5e7eb);
        border-radius: 14px;
        background: var(--bs-body-bg, #fff);
        color: var(--bs-secondary-color, #6b7280);
        display: flex; align-items: center; justify-content: center;
        cursor: pointer;
        transition: all .18s ease;
    }
    .chat-attach-btn:hover {
        color: var(--chat-primary);
        border-color: var(--chat-primary);
        background: var(--chat-primary-soft);
    }

    /* ── Aperçu image avant envoi ── */
    .chat-image-preview {
        display: flex; align-items: center; gap: 12px;
        margin: 0 18px;
        padding: 10px 12px;
        background: var(--chat-primary-soft);
        border: 1px dashed var(--chat-primary);
        border-radius: 14px;
        animation: chat-pop .25s ease;
    }
    .chat-image-preview img {
        width: 48px; height: 48px; object-fit: cover; border-radius: 10px; flex: 0 0 auto;
    }
    .chat-preview-info { flex: 1; min-width: 0; display: flex; flex-direction: column; }
    .chat-preview-name {
        font-size: .84rem; font-weight: 600; color: var(--bs-body-color);
        white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
    }
    .chat-preview-hint { font-size: .72rem; color: var(--chat-primary); }
    .chat-preview-remove {
        flex: 0 0 auto;
        width: 30px; height: 30px;
        border: none; border-radius: 9px;
        background: rgba(0,0,0,.06);
        color: var(--bs-body-color);
        display: flex; align-items: center; justify-content: center;
        cursor: pointer; transition: background .18s ease;
    }
    .chat-preview-remove:hover { background: rgba(239,68,68,.15); color: #ef4444; }

    /* ── Image envoyée dans une bulle ── */
    .chat-sent-image {
        max-width: 220px; width: 100%;
        border-radius: 12px;
        display: block;
        margin-bottom: 6px;
    }
    .chat-row.user .chat-bubble:has(.chat-sent-image) { padding: 6px; }

    .chat-footnote {
        text-align: center;
        font-size: .74rem;
        color: var(--bs-secondary-color, #9ca3af);
        margin: 14px auto 0;
        max-width: 560px;
    }

    /* ── Animations ── */
    @keyframes chat-pop { from { opacity: 0; transform: translateY(8px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes chat-bounce { 0%, 60%, 100% { transform: translateY(0); opacity: .5; } 30% { transform: translateY(-5px); opacity: 1; } }
    @keyframes chat-pulse { 0%, 100% { transform: scale(1); opacity: 1; } 50% { transform: scale(1.5); opacity: .4; } }

    @media (max-width: 575.98px) {
        .chat-wrapper { padding: 12px 8px 24px; }
        .chat-shell { height: calc(100vh - 90px); border-radius: 18px; }
        .chat-row { max-width: 94%; }
        .chat-suggestions { padding-left: 0; }
        .chat-card-img { width: 70px; height: 70px; }
        .chat-card-cta span { display: none; }
    }
</style>


{{-- ═══════════════════════════════════════════════
     SCRIPT — Logique du chat (démo + branchement API)
═══════════════════════════════════════════════ --}}
<script>
(function () {
    "use strict";

    // ────────────────────────────────────────────────
    // ⚙️  Branchement FastAPI : renseignez l'URL de votre
    //     endpoint puis passez USE_API à true.
    //     Réponse attendue (JSON) :
    //     { reply: "texte", results: [ { name, category, product,
    //       ville, price, rating, image, url } ] }
    // ────────────────────────────────────────────────
    const CHATBOT_API_URL = "/api/chatbot";   // ex: https://votre-fastapi/chat
    const USE_API = false;                     // true => appelle l'API réelle

    const ASSET = "{{ asset('') }}";

    const body          = document.getElementById('chatBody');
    const form          = document.getElementById('chatForm');
    const input         = document.getElementById('chatInput');
    const sendBtn       = document.getElementById('chatSend');
    const typing        = document.getElementById('chatTyping');
    const suggestions   = document.getElementById('chatSuggestions');
    const resetBtn      = document.getElementById('chatReset');
    const fileInput     = document.getElementById('chatFile');
    const attachBtn     = document.getElementById('chatAttach');
    const preview       = document.getElementById('chatImagePreview');
    const previewImg    = document.getElementById('chatPreviewImg');
    const previewName   = document.getElementById('chatPreviewName');
    const previewRemove = document.getElementById('chatPreviewRemove');

    // Image en attente d'envoi : { file: File, dataUrl: string }
    let pendingImage = null;

    const botIconSvg = `<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
        fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
        <path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8 9h8"/><path d="M8 13h6"/>
        <path d="M9 18l-1 3l-3 -3h-1a3 3 0 0 1 -3 -3v-8a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v8a3 3 0 0 1 -3 3h-7z"/></svg>`;

    function escapeHtml(str) {
        return String(str).replace(/[&<>"']/g, s => (
            { '&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;' }[s]
        ));
    }

    function scrollDown() { body.scrollTop = body.scrollHeight; }

    function addUserMessage(text, imageDataUrl) {
        const row = document.createElement('div');
        row.className = 'chat-row user';
        const imgHtml = imageDataUrl
            ? `<img class="chat-sent-image" src="${imageDataUrl}" alt="Image envoyée">` : '';
        const txtHtml = text ? escapeHtml(text) : '';
        row.innerHTML = `<div class="chat-bubble">${imgHtml}${txtHtml}</div>`;
        body.appendChild(row);
        scrollDown();
    }

    function addBotMessage(html) {
        const row = document.createElement('div');
        row.className = 'chat-row bot';
        row.innerHTML = `<div class="chat-mini-avatar">${botIconSvg}</div>
                         <div class="chat-bubble">${html}</div>`;
        body.appendChild(row);
        scrollDown();
    }

    function ratingStars(rating) {
        const full = Math.round(rating || 0);
        let s = '';
        for (let i = 0; i < 5; i++) {
            s += `<span style="color:${i < full ? '#f59e0b' : '#d1d5db'}">★</span>`;
        }
        return s;
    }

    function addResults(intro, results) {
        const row = document.createElement('div');
        row.className = 'chat-row bot';

        let cards = '';
        results.forEach(r => {
            const img = r.image ? (r.image.startsWith('http') ? r.image : ASSET + r.image) : '';
            const href = r.url || '#';
            cards += `
                <a class="chat-card" href="${escapeHtml(href)}">
                    ${img ? `<img class="chat-card-img" src="${escapeHtml(img)}" alt="${escapeHtml(r.name)}">` : ''}
                    <div class="chat-card-body">
                        <span class="chat-card-cat">${escapeHtml(r.category || 'Commerce')}</span>
                        <p class="chat-card-title">${escapeHtml(r.name)}</p>
                        ${r.product ? `<p class="chat-card-product">${escapeHtml(r.product)}</p>` : ''}
                        <div class="chat-card-meta">
                            ${r.ville ? `<span>📍 ${escapeHtml(r.ville)}</span>` : ''}
                            ${r.rating ? `<span>${ratingStars(r.rating)} ${escapeHtml(String(r.rating))}</span>` : ''}
                            ${r.price ? `<span class="chat-card-price">${escapeHtml(String(r.price))}</span>` : ''}
                        </div>
                    </div>
                    <span class="chat-card-cta">
                        Voir
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 6l6 6l-6 6"/></svg>
                    </span>
                </a>`;
        });

        row.innerHTML = `<div class="chat-mini-avatar">${botIconSvg}</div>
            <div style="flex:1;min-width:0;">
                <div class="chat-bubble" style="margin-bottom:10px;">${escapeHtml(intro)}</div>
                <div class="chat-results">${cards}</div>
            </div>`;
        body.appendChild(row);
        scrollDown();
    }

    function showTyping(on) {
        typing.hidden = !on;
        if (on) { body.appendChild(typing); typing.style.display = 'flex'; scrollDown(); }
        else { typing.style.display = 'none'; }
    }

    // ── Jeu de données DÉMO (remplacé par la réponse FastAPI) ──
    const DEMO = [
        { kw: ['menuis', 'meuble', 'bois', 'porte', 'parquet'],
          intro: "J'ai trouvé ces artisans du bois qui correspondent à votre besoin :",
          results: [
            { name: 'Atelier Bois Sahel', category: 'Menuiserie', product: 'Meubles & portes sur mesure',
              ville: 'Ouagadougou', rating: 5.0, price: 'dès 45 000 F',
              image: 'freepik/carpenter-cutting-mdf-board-inside-workshop.jpg', url: '#' },
            { name: 'Découpe & Fabrication Faso', category: 'Menuiserie', product: 'Charpentes & mobilier',
              ville: 'Bobo-Dioulasso', rating: 4.9, price: 'dès 30 000 F',
              image: 'freepik/medium-shot-man-working-with-hand-saw.jpg', url: '#' },
        ]},
        { kw: ['meca', 'méca', 'auto', 'voiture', 'garage', 'moteur'],
          intro: "Voici un mécanicien certifié proche de vous :",
          results: [
            { name: 'Garage Auto Pro', category: 'Mécanique', product: 'Diagnostic & réparation tous véhicules',
              ville: 'Ouagadougou', rating: 4.8, price: 'devis gratuit',
              image: 'freepik/bipoc-specialist-car-service-using-professional-mechanical-tool-repair-broken-ignition-system-licensed-specialist-garage-fixing-client-automobile-ensuring-optimal-automotive-performance.jpg', url: '#' },
        ]},
        { kw: ['pierre', 'sculpt', 'precis', 'précis', 'taille'],
          intro: "Cet artisan est spécialisé dans la taille de précision :",
          results: [
            { name: 'Précision & Sécurité', category: 'Travaux manuels', product: 'Taille de pierre & sculpture',
              ville: 'Koudougou', rating: 4.7, price: 'sur devis',
              image: 'freepik/man-wears-safety-goggles-while-using-chisel-hammer-avoid-injury.jpg', url: '#' },
        ]},
    ];

    function demoResponse(text) {
        const q = text.toLowerCase();
        const match = DEMO.find(d => d.kw.some(k => q.includes(k)));
        if (match) return { reply: match.intro, results: match.results };
        return {
            reply: "Je n'ai pas encore de commerce exact pour cette demande, mais voici une suggestion populaire. Précisez le produit ou la ville pour affiner.",
            results: DEMO[0].results.slice(0, 1)
        };
    }

    // Réponse démo pour la recherche PAR IMAGE (remplacée par la réponse FastAPI)
    function demoImageResponse() {
        const pick = DEMO[Math.floor(Math.random() * DEMO.length)];
        return {
            reply: "J'ai analysé votre image et identifié ce produit. Voici le commerce qui le propose :",
            results: pick.results.slice(0, 2)
        };
    }

    async function fetchFromApi(text, imageFile) {
        const headers = {
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
        };
        let bodyPayload;

        if (imageFile) {
            // Recherche par image -> multipart/form-data (le navigateur fixe le Content-Type)
            const fd = new FormData();
            fd.append('image', imageFile);
            if (text) fd.append('message', text);
            bodyPayload = fd;
        } else {
            headers['Content-Type'] = 'application/json';
            bodyPayload = JSON.stringify({ message: text });
        }

        const res = await fetch(CHATBOT_API_URL, { method: 'POST', headers, body: bodyPayload });
        if (!res.ok) throw new Error('API error ' + res.status);
        return res.json();
    }

    async function handleResponse(text, imageFile) {
        showTyping(true);
        let data;
        try {
            if (USE_API) {
                data = await fetchFromApi(text, imageFile);
            } else {
                const demo = imageFile ? demoImageResponse() : demoResponse(text);
                data = await new Promise(r => setTimeout(() => r(demo), imageFile ? 1400 : 900));
            }
        } catch (e) {
            data = { reply: "Désolé, le service de recherche est momentanément indisponible. Réessayez dans un instant.", results: [] };
        }
        showTyping(false);

        if (data.reply && (!data.results || !data.results.length)) {
            addBotMessage(escapeHtml(data.reply));
        } else if (data.results && data.results.length) {
            addResults(data.reply || 'Voici ce que j\'ai trouvé :', data.results);
        } else {
            addBotMessage("Je n'ai rien trouvé pour cette recherche.");
        }
    }

    function send(text) {
        text = (text || '').trim();
        const image = pendingImage;
        if (!text && !image) return;

        if (suggestions) suggestions.style.display = 'none';
        addUserMessage(text, image ? image.dataUrl : null);

        input.value = '';
        autoGrow();
        clearImage();

        handleResponse(text, image ? image.file : null);
    }

    // ── Auto-grow textarea ──
    function autoGrow() {
        input.style.height = 'auto';
        input.style.height = Math.min(input.scrollHeight, 120) + 'px';
    }

    // ── Gestion de l'image ──
    function clearImage() {
        pendingImage = null;
        fileInput.value = '';
        preview.hidden = true;
        previewImg.src = '';
    }

    function handleFile(file) {
        if (!file) return;
        if (!file.type.startsWith('image/')) {
            addBotMessage("Format non supporté. Merci d'envoyer une image (JPG, PNG, WEBP…).");
            return;
        }
        if (file.size > 5 * 1024 * 1024) {
            addBotMessage("Image trop lourde (max 5 Mo). Choisissez une photo plus légère.");
            return;
        }
        const reader = new FileReader();
        reader.onload = e => {
            pendingImage = { file, dataUrl: e.target.result };
            previewImg.src = e.target.result;
            previewName.textContent = file.name;
            preview.hidden = false;
            input.focus();
        };
        reader.readAsDataURL(file);
    }

    // ── Events ──
    form.addEventListener('submit', e => { e.preventDefault(); send(input.value); });

    input.addEventListener('input', autoGrow);
    input.addEventListener('keydown', e => {
        if (e.key === 'Enter' && !e.shiftKey) { e.preventDefault(); send(input.value); }
    });

    attachBtn.addEventListener('click', () => fileInput.click());
    fileInput.addEventListener('change', e => handleFile(e.target.files[0]));
    previewRemove.addEventListener('click', clearImage);

    // Coller une image depuis le presse-papier
    input.addEventListener('paste', e => {
        const item = [...(e.clipboardData?.items || [])].find(i => i.type.startsWith('image/'));
        if (item) { e.preventDefault(); handleFile(item.getAsFile()); }
    });

    document.querySelectorAll('.chat-chip').forEach(chip => {
        if (chip.id === 'chatChipImage') {
            chip.addEventListener('click', () => fileInput.click());
        } else {
            chip.addEventListener('click', () => send(chip.dataset.prompt));
        }
    });

    resetBtn.addEventListener('click', () => {
        body.querySelectorAll('.chat-row, .chat-results').forEach((el, i) => { if (i > 0) el.remove(); });
        if (suggestions) suggestions.style.display = 'flex';
        body.appendChild(suggestions);
        clearImage();
        input.focus();
    });

    input.focus();
})();
</script>

@endsection

@include('main.navbar')
