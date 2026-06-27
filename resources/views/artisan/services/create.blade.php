@include('artisan.sidebarArtisan')

@extends('main.index')

@section('content')
<div>
  <div class="custom-container py-6">

    <div class="d-flex align-items-center gap-3 mb-6">
      <a href="{{ route('artisan.services') }}" class="btn btn-ghost btn-icon rounded-circle">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor"
             stroke-width="2" viewBox="0 0 24 24">
          <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
          <path d="M5 12l14 0"/><path d="M5 12l6 6"/><path d="M5 12l6 -6"/>
        </svg>
      </a>
      <div>
        <h2 class="fw-bold mb-0">Ajouter un Service</h2>
        <p class="text-secondary mb-0 small">Remplissez les informations du service</p>
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

    @if($commerces->isEmpty())
      <div class="alert alert-warning">
        Vous n'avez pas encore de commerce.
        <a href="{{ route('artisan.commerces.create') }}" class="alert-link">Creer un commerce d'abord</a>.
      </div>
    @else

    <form method="POST" action="{{ route('artisan.services.store') }}" enctype="multipart/form-data">
      @csrf

      <div class="row g-4 justify-content-center">
        <div class="col-xl-7">

          <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3 px-4">
              <h6 class="mb-0 fw-semibold">Informations du service</h6>
            </div>
            <div class="card-body p-4">
              <div class="row g-3">

                <div class="col-12">
                  <label class="form-label fw-medium">Commerce associe <span class="text-danger">*</span></label>
                  <select name="idCommerce" class="form-select @error('idCommerce') is-invalid @enderror">
                    <option value="">-- Choisir un commerce --</option>
                    @foreach($commerces as $c)
                      <option value="{{ $c->id }}" {{ old('idCommerce') == $c->id ? 'selected' : '' }}>
                        {{ $c->nomCormmercial }} — {{ $c->ville }}
                      </option>
                    @endforeach
                  </select>
                  @error('idCommerce')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-12">
                  <label class="form-label fw-medium">Nom du service <span class="text-danger">*</span></label>
                  <input type="text" name="nomService" class="form-control @error('nomService') is-invalid @enderror"
                         value="{{ old('nomService') }}" placeholder="Ex: Coupe homme, Livraison express...">
                  @error('nomService')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-12">
                  <label class="form-label fw-medium">Description</label>
                  <textarea name="description" class="form-control @error('description') is-invalid @enderror"
                            rows="3" placeholder="Decrivez brievement ce service...">{{ old('description') }}</textarea>
                  @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                  <label class="form-label fw-medium">Prix (FCFA) <span class="text-danger">*</span></label>
                  <div class="input-group">
                    <input type="number" name="prixService" class="form-control @error('prixService') is-invalid @enderror"
                           value="{{ old('prixService') }}" placeholder="0" min="0" step="50">
                    <span class="input-group-text">FCFA</span>
                  </div>
                  @error('prixService')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                </div>

                <div class="col-12">
                  <label class="form-label fw-medium">Photo du service <span class="text-danger">*</span></label>
                  <input type="file" name="photo" id="photoService"
                         class="form-control @error('photo') is-invalid @enderror"
                         accept="image/*" onchange="previewPhoto(this)">
                  @error('photo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                  <div id="photoPreview" class="mt-3"></div>
                </div>

              </div>
            </div>
            <div class="card-footer bg-white border-top p-4 d-flex gap-3">
              <button type="submit" class="btn btn-primary rounded-pill px-5">Enregistrer en brouillon</button>
              <a href="{{ route('artisan.services') }}" class="btn btn-outline-secondary rounded-pill px-4">Annuler</a>
            </div>
          </div>

        </div>
      </div>
    </form>

    @endif

  </div>
</div>
@endsection

@include('main.navbarWithsidebar')

@push('scripts')
<script>
  function previewPhoto(input) {
    const preview = document.getElementById('photoPreview');
    if (input.files && input.files[0]) {
      const reader = new FileReader();
      reader.onload = e => {
        preview.innerHTML = `<img src="${e.target.result}"
          style="width:150px;height:150px;object-fit:cover;border-radius:10px;border:1px solid #dee2e6;">`;
      };
      reader.readAsDataURL(input.files[0]);
    }
  }
</script>
@endpush
