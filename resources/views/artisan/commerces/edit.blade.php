@include('artisan.sidebarArtisan')

@extends('main.index')

@push('head')
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
@endpush

@section('content')
<div>
  <div class="custom-container py-6">

    <div class="d-flex align-items-center gap-3 mb-6">
      <a href="{{ route('artisan.commerces') }}" class="btn btn-ghost btn-icon rounded-circle">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor"
             stroke-width="2" viewBox="0 0 24 24">
          <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
          <path d="M5 12l14 0"/><path d="M5 12l6 6"/><path d="M5 12l6 -6"/>
        </svg>
      </a>
      <div>
        <h2 class="fw-bold mb-0">Modifier : {{ $commerce->nomCormmercial }}</h2>
        <p class="text-secondary mb-0 small">Mettez a jour les informations de votre commerce</p>
      </div>
    </div>

    @if($errors->any())
      <div class="alert alert-danger alert-dismissible fade show mb-4">
        <ul class="mb-0">
          @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    @endif

    @if(session('success'))
      <div class="alert alert-success alert-dismissible fade show mb-4">
        {{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    @endif

    <form method="POST" action="{{ route('artisan.commerces.update', $commerce) }}" enctype="multipart/form-data" id="commerceForm">
      @csrf @method('PUT')

      @php
        $position = json_decode($commerce->position, true);
        $lat = $position['lat'] ?? 12.3647;
        $lng = $position['lng'] ?? -1.5338;
      @endphp

      <div class="row g-4">

        <div class="col-xl-8">

          <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3 px-4">
              <h6 class="mb-0 fw-semibold">Informations generales</h6>
            </div>
            <div class="card-body p-4">
              <div class="row g-3">
                <div class="col-md-6">
                  <label class="form-label fw-medium">Nom commercial <span class="text-danger">*</span></label>
                  <input type="text" name="nomCormmercial" class="form-control @error('nomCormmercial') is-invalid @enderror"
                         value="{{ old('nomCormmercial', $commerce->nomCormmercial) }}">
                  @error('nomCormmercial')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                  <label class="form-label fw-medium">Categorie <span class="text-danger">*</span></label>
                  <select name="categorie" class="form-select @error('categorie') is-invalid @enderror">
                    @foreach(['Alimentation','Artisanat','Beaute & Bien-etre','Batiment & Construction','Commerce General',
                               'Couture & Textile','Electronique','Immobilier','Mecanique & Auto','Restauration',
                               'Sante','Transport','Autre'] as $cat)
                      <option value="{{ $cat }}" {{ old('categorie', $commerce->categorie) === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                    @endforeach
                  </select>
                  @error('categorie')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                  <label class="form-label fw-medium">Ville <span class="text-danger">*</span></label>
                  <input type="text" name="ville" class="form-control @error('ville') is-invalid @enderror"
                         value="{{ old('ville', $commerce->ville) }}">
                  @error('ville')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                  <label class="form-label fw-medium">Contact responsable <span class="text-danger">*</span></label>
                  <input type="tel" name="conctactResponsable" class="form-control @error('conctactResponsable') is-invalid @enderror"
                         value="{{ old('conctactResponsable', $commerce->conctactResponsable) }}">
                  @error('conctactResponsable')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                  <label class="form-label fw-medium">Email du commerce</label>
                  <input type="email" name="emailCommerce" class="form-control @error('emailCommerce') is-invalid @enderror"
                         value="{{ old('emailCommerce', $commerce->emailCommerce) }}">
                  @error('emailCommerce')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                  <label class="form-label fw-medium">Site web / lien</label>
                  <input type="url" name="lienCommerce" class="form-control @error('lienCommerce') is-invalid @enderror"
                         value="{{ old('lienCommerce', $commerce->lienCommerce) }}">
                  @error('lienCommerce')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
              </div>
            </div>
          </div>

          {{-- Description du local (verifiee par l'IA) --}}
          <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3 px-4 d-flex align-items-center justify-content-between">
              <div>
                <h6 class="mb-0 fw-semibold">Description du local <span class="text-danger">*</span></h6>
                <p class="text-secondary small mb-0 mt-1">
                  Decrivez votre local et votre activite. Notre assistant verifie que la description est exhaustive.
                </p>
              </div>
              <span class="badge rounded-pill bg-primary-subtle text-primary d-inline-flex align-items-center gap-1">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                  <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                  <path d="M12 3l1.9 5.8a2 2 0 0 0 1.3 1.3l5.8 1.9l-5.8 1.9a2 2 0 0 0 -1.3 1.3l-1.9 5.8l-1.9 -5.8a2 2 0 0 0 -1.3 -1.3l-5.8 -1.9l5.8 -1.9a2 2 0 0 0 1.3 -1.3z"/>
                </svg>
                Verifie par IA
              </span>
            </div>
            <div class="card-body p-4">
              <textarea name="description" id="description" rows="6"
                        class="form-control @error('description') is-invalid @enderror"
                        placeholder="Decrivez votre local : activite, produits/services, localisation, atouts, contact...">{{ old('description', $commerce->description) }}</textarea>
              <div class="d-flex justify-content-between mt-1">
                <small class="text-secondary">Minimum 40 caracteres. Soyez precis : activite, produits/services, localisation, atouts, contact.</small>
                <small class="text-secondary"><span id="descCount">0</span> caracteres</small>
              </div>
              @error('description')<div class="text-danger small mt-1">{{ $message }}</div>@enderror

              <div id="aiFeedback" class="mt-3" hidden>
                <div class="alert d-flex gap-3 mb-0" id="aiFeedbackAlert" role="alert">
                  <div id="aiFeedbackIcon" class="flex-shrink-0"></div>
                  <div class="flex-grow-1">
                    <p class="fw-semibold mb-1" id="aiFeedbackTitle"></p>
                    <p class="mb-2 small" id="aiFeedbackMessage"></p>
                    <div id="aiSuggestionsWrap" class="mb-2" hidden>
                      <span class="small fw-semibold d-block mb-1">A preciser :</span>
                      <ul class="small mb-0" id="aiSuggestions"></ul>
                    </div>
                    <div id="aiExampleWrap" hidden>
                      <span class="small fw-semibold d-block mb-1">Exemple de description complete :</span>
                      <div class="border rounded-3 p-3 bg-body-tertiary small" id="aiExample"></div>
                      <button type="button" class="btn btn-sm btn-outline-primary rounded-pill mt-2" id="aiUseExample">
                        Utiliser cet exemple comme base
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          {{-- Carte --}}
          <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3 px-4">
              <h6 class="mb-0 fw-semibold">Localisation</h6>
              <p class="text-secondary small mb-0 mt-1">Cliquez sur la carte pour ajuster la position</p>
            </div>
            <div class="card-body p-4">
              <div id="map" style="height:380px; border-radius:12px; border:1px solid #dee2e6;"></div>
              <input type="hidden" name="position_lat" id="position_lat" value="{{ old('position_lat', $lat) }}">
              <input type="hidden" name="position_lng" id="position_lng" value="{{ old('position_lng', $lng) }}">
              <p class="text-secondary small mt-2 mb-0">
                Position : <span id="pos_lat">{{ $lat }}</span>, <span id="pos_lng">{{ $lng }}</span>
              </p>
            </div>
          </div>

          {{-- Photos actuelles --}}
          @if(!empty($commerce->photos))
          <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3 px-4">
              <h6 class="mb-0 fw-semibold">Photos actuelles</h6>
              <p class="text-secondary small mb-0 mt-1">Cochez les photos a supprimer</p>
            </div>
            <div class="card-body p-4">
              <div class="d-flex flex-wrap gap-3">
                @foreach($commerce->photos as $idx => $photo)
                <div class="position-relative">
                  <img src="{{ asset('storage/' . $photo) }}"
                       style="width:120px;height:120px;object-fit:cover;border-radius:8px;border:1px solid #dee2e6;"
                       alt="Photo {{ $idx + 1 }}">
                  <div class="position-absolute top-0 end-0 m-1">
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox"
                             name="delete_photos[]" value="{{ $idx }}"
                             id="del_photo_{{ $idx }}">
                      <label class="form-check-label" for="del_photo_{{ $idx }}">
                        <span class="badge bg-danger" style="font-size:.65rem;">Suppr.</span>
                      </label>
                    </div>
                  </div>
                </div>
                @endforeach
              </div>
            </div>
          </div>
          @endif

          {{-- Nouvelles photos --}}
          <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3 px-4">
              <h6 class="mb-0 fw-semibold">Ajouter de nouvelles photos</h6>
              <p class="text-secondary small mb-0 mt-1">JPEG, PNG, WebP — max 3 Mo par photo</p>
            </div>
            <div class="card-body p-4">
              <input type="file" name="new_photos[]" id="new_photos" class="form-control"
                     multiple accept="image/*" onchange="previewNewPhotos(this)">
              <div id="newPhotoPreview" class="d-flex flex-wrap gap-3 mt-3"></div>
            </div>
          </div>

        </div>

        {{-- Colonne droite : horaires + statut --}}
        <div class="col-xl-4">

          {{-- Statut --}}
          <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3 px-4">
              <h6 class="mb-0 fw-semibold">Statut de publication</h6>
            </div>
            <div class="card-body p-4 d-grid gap-2">
              <form method="POST" action="{{ route('artisan.commerces.status', $commerce) }}">
                @csrf @method('PATCH')
                <input type="hidden" name="etat" value="publie">
                <button type="submit" class="btn w-100 rounded-pill {{ $commerce->etatPublication === 'publie' ? 'btn-success' : 'btn-outline-success' }}">
                  Publier
                </button>
              </form>
              <form method="POST" action="{{ route('artisan.commerces.status', $commerce) }}">
                @csrf @method('PATCH')
                <input type="hidden" name="etat" value="draft">
                <button type="submit" class="btn w-100 rounded-pill {{ $commerce->etatPublication === 'draft' ? 'btn-warning' : 'btn-outline-warning' }}">
                  Brouillon
                </button>
              </form>
              <form method="POST" action="{{ route('artisan.commerces.status', $commerce) }}">
                @csrf @method('PATCH')
                <input type="hidden" name="etat" value="retire">
                <button type="submit" class="btn w-100 rounded-pill {{ $commerce->etatPublication === 'retire' ? 'btn-danger' : 'btn-outline-danger' }}">
                  Retirer
                </button>
              </form>
            </div>
          </div>

          {{-- Horaires --}}
          <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3 px-4">
              <h6 class="mb-0 fw-semibold">Horaires d'ouverture</h6>
            </div>
            <div class="card-body p-4">
              @php $jours = ['Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi','Dimanche']; @endphp
              @foreach($jours as $jour)
              @php
                $horJour   = $commerce->horaire[$jour] ?? [];
                $oldFerme  = old('horaire.' . $jour . '.ferme');
                $savedFerme = $horJour['ferme'] ?? false;
                $fermeCheck = $oldFerme !== null ? $oldFerme === '1' : (bool)$savedFerme;
              @endphp
              <div class="mb-3">
                <div class="d-flex justify-content-between align-items-center mb-1">
                  <label class="form-label fw-medium small mb-0">{{ $jour }}</label>
                  <div class="form-check form-switch mb-0">
                    <input class="form-check-input" type="checkbox"
                           name="horaire[{{ $jour }}][ferme]" value="1"
                           id="ferme_{{ $jour }}"
                           {{ $fermeCheck ? 'checked' : '' }}
                           onchange="toggleHoraire(this, '{{ $jour }}')">
                    <label class="form-check-label text-secondary small" for="ferme_{{ $jour }}">Ferme</label>
                  </div>
                </div>
                <div class="d-flex gap-2 align-items-center" id="heures_{{ $jour }}" style="{{ $fermeCheck ? 'display:none!important' : '' }}">
                  <input type="time" name="horaire[{{ $jour }}][ouverture]" class="form-control form-control-sm"
                         value="{{ old('horaire.'.$jour.'.ouverture', $horJour['ouverture'] ?? '08:00') }}">
                  <span class="text-secondary small">—</span>
                  <input type="time" name="horaire[{{ $jour }}][fermeture]" class="form-control form-control-sm"
                         value="{{ old('horaire.'.$jour.'.fermeture', $horJour['fermeture'] ?? '18:00') }}">
                </div>
                <p class="text-secondary small mb-0 mt-1 {{ $fermeCheck ? '' : 'd-none' }}" id="label_ferme_{{ $jour }}">Ferme ce jour</p>
              </div>
              @endforeach
            </div>
            <div class="card-footer bg-white border-top p-4 d-grid gap-2">
              <button type="submit" class="btn btn-primary rounded-pill" id="submitBtn">
                <span id="submitLabel">Verifier &amp; enregistrer</span>
                <span id="submitSpinner" class="spinner-border spinner-border-sm ms-1" hidden></span>
              </button>
              <a href="#" class="btn btn-link btn-sm text-secondary" id="skipAiBtn" hidden>Enregistrer sans corriger</a>
              <a href="{{ route('artisan.commerces') }}" class="btn btn-outline-secondary rounded-pill">Annuler</a>
            </div>
          </div>

        </div>
      </div>
    </form>

  </div>
</div>
@endsection

@include('main.navbarWithsidebar')

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
  const initLat = {{ $lat }};
  const initLng = {{ $lng }};

  const map = L.map('map').setView([initLat, initLng], 14);
  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '© OpenStreetMap contributors'
  }).addTo(map);

  let marker = L.marker([initLat, initLng], { draggable: true }).addTo(map);
  marker.bindPopup('Position du commerce').openPopup();

  function updatePosition(lat, lng) {
    document.getElementById('position_lat').value = lat.toFixed(6);
    document.getElementById('position_lng').value = lng.toFixed(6);
    document.getElementById('pos_lat').textContent = lat.toFixed(6);
    document.getElementById('pos_lng').textContent = lng.toFixed(6);
  }

  map.on('click', function(e) {
    marker.setLatLng(e.latlng);
    updatePosition(e.latlng.lat, e.latlng.lng);
  });

  marker.on('dragend', function() {
    const pos = marker.getLatLng();
    updatePosition(pos.lat, pos.lng);
  });

  function toggleHoraire(checkbox, jour) {
    const heures = document.getElementById('heures_' + jour);
    const label  = document.getElementById('label_ferme_' + jour);
    if (checkbox.checked) {
      heures.style.display = 'none';
      label.classList.remove('d-none');
    } else {
      heures.style.display = '';
      label.classList.add('d-none');
    }
  }

  function previewNewPhotos(input) {
    const preview = document.getElementById('newPhotoPreview');
    preview.innerHTML = '';
    Array.from(input.files).slice(0, 6).forEach(file => {
      const reader = new FileReader();
      reader.onload = e => {
        const img = document.createElement('img');
        img.src = e.target.result;
        img.style.cssText = 'width:100px;height:100px;object-fit:cover;border-radius:8px;border:1px solid #dee2e6;';
        preview.appendChild(img);
      };
      reader.readAsDataURL(file);
    });
  }

  // ════════════════════════════════════════════════
  //  Vérification IA de la description du local
  // ════════════════════════════════════════════════
  (function () {
    const form        = document.getElementById('commerceForm');
    const desc        = document.getElementById('description');
    const counter     = document.getElementById('descCount');
    const submitBtn   = document.getElementById('submitBtn');
    const submitLabel = document.getElementById('submitLabel');
    const spinner     = document.getElementById('submitSpinner');
    const skipBtn     = document.getElementById('skipAiBtn');

    const fb          = document.getElementById('aiFeedback');
    const fbAlert     = document.getElementById('aiFeedbackAlert');
    const fbIcon      = document.getElementById('aiFeedbackIcon');
    const fbTitle     = document.getElementById('aiFeedbackTitle');
    const fbMessage   = document.getElementById('aiFeedbackMessage');
    const sugWrap     = document.getElementById('aiSuggestionsWrap');
    const sugList     = document.getElementById('aiSuggestions');
    const exWrap      = document.getElementById('aiExampleWrap');
    const exBox       = document.getElementById('aiExample');
    const useExample  = document.getElementById('aiUseExample');

    const VERIFY_URL  = "{{ route('artisan.commerces.verify') }}";
    const CSRF        = document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}';

    let aiValidated = false;
    let forceSubmit = false;

    function updateCount() { counter.textContent = desc.value.trim().length; }
    desc.addEventListener('input', () => { updateCount(); aiValidated = false; fb.hidden = true; });
    updateCount();

    const ICON_OK   = `<svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l5 5l10 -10"/></svg>`;
    const ICON_WARN = `<svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 9v4"/><path d="M10.363 3.591l-8.106 13.534a1.914 1.914 0 0 0 1.636 2.871h16.214a1.914 1.914 0 0 0 1.636 -2.87l-8.106 -13.536a1.914 1.914 0 0 0 -3.274 0z"/><path d="M12 16h.01"/></svg>`;

    function setLoading(on) {
      submitBtn.disabled = on;
      spinner.hidden = !on;
      submitLabel.textContent = on ? 'Verification…' : 'Verifier & enregistrer';
    }

    function escapeHtml(s) {
      return String(s).replace(/[&<>"']/g, c => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c]));
    }

    function showFeedback(data) {
      fb.hidden = false;
      if (data.ok) {
        fbAlert.className = 'alert alert-success d-flex gap-3 mb-0';
        fbIcon.innerHTML = ICON_OK;
        fbTitle.textContent = 'Description validee';
        sugWrap.hidden = true; exWrap.hidden = true; skipBtn.hidden = true;
      } else {
        fbAlert.className = 'alert alert-warning d-flex gap-3 mb-0';
        fbIcon.innerHTML = ICON_WARN;
        fbTitle.textContent = 'Description a completer';
        if (data.suggestions && data.suggestions.length) {
          sugList.innerHTML = data.suggestions.map(s => `<li>${escapeHtml(s)}</li>`).join('');
          sugWrap.hidden = false;
        } else { sugWrap.hidden = true; }
        if (data.example) { exBox.textContent = data.example; exWrap.hidden = false; }
        else { exWrap.hidden = true; }
        skipBtn.hidden = false;
      }
      fbMessage.textContent = data.message || '';
      fb.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }

    async function verify() {
      const payload = {
        description: desc.value,
        nom:        form.querySelector('[name=nomCormmercial]')?.value || '',
        categorie:  form.querySelector('[name=categorie]')?.value || '',
        ville:      form.querySelector('[name=ville]')?.value || '',
      };
      const res = await fetch(VERIFY_URL, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF },
        body: JSON.stringify(payload),
      });
      if (!res.ok) throw new Error('verify failed');
      return res.json();
    }

    form.addEventListener('submit', async (e) => {
      if (aiValidated || forceSubmit) return;
      e.preventDefault();

      if (desc.value.trim().length < 40) {
        showFeedback({ ok: false, message: "La description est trop courte (40 caracteres minimum). Detaillez votre local pour continuer.", suggestions: [], example: '' });
        desc.focus();
        return;
      }

      setLoading(true);
      try {
        const data = await verify();
        setLoading(false);
        showFeedback(data);
        if (data.ok) {
          aiValidated = true;
          submitLabel.textContent = 'Enregistrer les modifications';
          setTimeout(() => form.submit(), 600);
        }
      } catch (err) {
        setLoading(false);
        forceSubmit = true;
        form.submit();
      }
    });

    skipBtn.addEventListener('click', (e) => { e.preventDefault(); forceSubmit = true; form.submit(); });
    useExample.addEventListener('click', () => { desc.value = exBox.textContent; updateCount(); aiValidated = false; desc.focus(); });
  })();
</script>
@endpush
