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
        <h2 class="fw-bold mb-0">Ajouter un Commerce</h2>
        <p class="text-secondary mb-0 small">Remplissez les informations de votre commerce</p>
      </div>
    </div>

    @if($errors->any())
      <div class="alert alert-danger alert-dismissible fade show mb-4">
        <ul class="mb-0">
          @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    @endif

    <form method="POST" action="{{ route('artisan.commerces.store') }}" enctype="multipart/form-data">
      @csrf

      <div class="row g-4">

        {{-- Colonne gauche : infos générales --}}
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
                         value="{{ old('nomCormmercial') }}" placeholder="Ex: Boulangerie du Soleil">
                  @error('nomCormmercial')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                  <label class="form-label fw-medium">Categorie <span class="text-danger">*</span></label>
                  <select name="categorie" class="form-select @error('categorie') is-invalid @enderror">
                    <option value="">-- Choisir --</option>
                    @foreach(['Alimentation','Artisanat','Beaute & Bien-etre','Batiment & Construction','Commerce General',
                               'Couture & Textile','Electronique','Immobilier','Mecanique & Auto','Restauration',
                               'Sante','Transport','Autre'] as $cat)
                      <option value="{{ $cat }}" {{ old('categorie') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                    @endforeach
                  </select>
                  @error('categorie')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                  <label class="form-label fw-medium">Ville <span class="text-danger">*</span></label>
                  <input type="text" name="ville" class="form-control @error('ville') is-invalid @enderror"
                         value="{{ old('ville') }}" placeholder="Ex: Ouagadougou">
                  @error('ville')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                  <label class="form-label fw-medium">Contact responsable <span class="text-danger">*</span></label>
                  <input type="tel" name="conctactResponsable" class="form-control @error('conctactResponsable') is-invalid @enderror"
                         value="{{ old('conctactResponsable') }}" placeholder="Ex: 70000000">
                  @error('conctactResponsable')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                  <label class="form-label fw-medium">Email du commerce</label>
                  <input type="email" name="emailCommerce" class="form-control @error('emailCommerce') is-invalid @enderror"
                         value="{{ old('emailCommerce') }}" placeholder="commerce@exemple.com">
                  @error('emailCommerce')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                  <label class="form-label fw-medium">Site web / lien</label>
                  <input type="url" name="lienCommerce" class="form-control @error('lienCommerce') is-invalid @enderror"
                         value="{{ old('lienCommerce') }}" placeholder="https://...">
                  @error('lienCommerce')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
              </div>
            </div>
          </div>

          {{-- Carte interactive --}}
          <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3 px-4">
              <h6 class="mb-0 fw-semibold">Localisation approximative</h6>
              <p class="text-secondary small mb-0 mt-1">Cliquez sur la carte pour indiquer la position de votre commerce</p>
            </div>
            <div class="card-body p-4">
              <div id="map" style="height:380px; border-radius:12px; border:1px solid #dee2e6;"></div>
              <input type="hidden" name="position_lat" id="position_lat" value="{{ old('position_lat', '12.3647') }}">
              <input type="hidden" name="position_lng" id="position_lng" value="{{ old('position_lng', '-1.5338') }}">
              <p class="text-secondary small mt-2 mb-0" id="position_display">
                Position : <span id="pos_lat">{{ old('position_lat', '12.3647') }}</span>,
                <span id="pos_lng">{{ old('position_lng', '-1.5338') }}</span>
              </p>
              @error('position_lat')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
            </div>
          </div>

          {{-- Photos --}}
          <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3 px-4">
              <h6 class="mb-0 fw-semibold">Photos du commerce <span class="text-danger">*</span></h6>
              <p class="text-secondary small mb-0 mt-1">1 a 6 photos (JPEG, PNG, WebP — max 3 Mo chacune)</p>
            </div>
            <div class="card-body p-4">
              <input type="file" name="photos[]" id="photos" class="form-control @error('photos') is-invalid @enderror @error('photos.*') is-invalid @enderror"
                     multiple accept="image/*" onchange="previewPhotos(this)">
              @error('photos')<div class="invalid-feedback">{{ $message }}</div>@enderror
              @error('photos.*')<div class="invalid-feedback">{{ $message }}</div>@enderror
              <div id="photoPreview" class="d-flex flex-wrap gap-3 mt-3"></div>
            </div>
          </div>

        </div>

        {{-- Colonne droite : horaires --}}
        <div class="col-xl-4">
          <div class="card border-0 shadow-sm sticky-top" style="top:80px;">
            <div class="card-header bg-white py-3 px-4">
              <h6 class="mb-0 fw-semibold">Horaires d'ouverture</h6>
            </div>
            <div class="card-body p-4">
              @php
                $jours = ['Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi','Dimanche'];
                $fermeParDefaut = ['Dimanche'];
              @endphp
              @foreach($jours as $jour)
              @php
                $isFerme = in_array($jour, $fermeParDefaut);
                $oldFerme = old('horaire.' . $jour . '.ferme');
                $fermeCheck = $oldFerme === '1' || ($oldFerme === null && $isFerme);
              @endphp
              <div class="mb-3" x-data="{ ferme: {{ $fermeCheck ? 'true' : 'false' }} }">
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
                  <input type="time" name="horaire[{{ $jour }}][ouverture]"
                         class="form-control form-control-sm"
                         value="{{ old('horaire.' . $jour . '.ouverture', '08:00') }}">
                  <span class="text-secondary small">—</span>
                  <input type="time" name="horaire[{{ $jour }}][fermeture]"
                         class="form-control form-control-sm"
                         value="{{ old('horaire.' . $jour . '.fermeture', '18:00') }}">
                </div>
                @if($fermeCheck)
                  <p class="text-secondary small mb-0 mt-1" id="label_ferme_{{ $jour }}">Ferme ce jour</p>
                @else
                  <p class="text-secondary small mb-0 mt-1 d-none" id="label_ferme_{{ $jour }}">Ferme ce jour</p>
                @endif
              </div>
              @endforeach
            </div>
            <div class="card-footer bg-white border-top p-4 d-grid gap-2">
              <button type="submit" class="btn btn-primary rounded-pill">Enregistrer en brouillon</button>
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
  // Carte Leaflet centrée sur Ouagadougou
  const initLat = parseFloat(document.getElementById('position_lat').value) || 12.3647;
  const initLng = parseFloat(document.getElementById('position_lng').value) || -1.5338;

  const map = L.map('map').setView([initLat, initLng], 13);
  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '© OpenStreetMap contributors'
  }).addTo(map);

  let marker = L.marker([initLat, initLng], { draggable: true }).addTo(map);
  marker.bindPopup('Position de votre commerce').openPopup();

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

  // Prévisualisation des photos
  function previewPhotos(input) {
    const preview = document.getElementById('photoPreview');
    preview.innerHTML = '';
    const files = Array.from(input.files).slice(0, 6);
    files.forEach(file => {
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
</script>
@endpush
