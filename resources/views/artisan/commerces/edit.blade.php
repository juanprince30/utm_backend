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

    <form method="POST" action="{{ route('artisan.commerces.update', $commerce) }}" enctype="multipart/form-data">
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
              <button type="submit" class="btn btn-primary rounded-pill">Enregistrer les modifications</button>
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
</script>
@endpush
