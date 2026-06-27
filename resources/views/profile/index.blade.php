@extends('main.index')

@section('content')
<div id="content" class="main-content">
  <div class="custom-container py-6">

    {{-- En-tête --}}
    <div class="d-flex align-items-center justify-content-between mb-6">
      <div>
        <h2 class="fw-bold mb-1">Mon profil</h2>
        <p class="text-secondary mb-0 small">Modifiez vos informations personnelles</p>
      </div>
      <a href="{{ route('main') }}" class="btn btn-outline-secondary rounded-pill px-4 btn-sm">
        &larr; Retour
      </a>
    </div>

    {{-- Flash --}}
    @if(session('success'))
      <div class="alert alert-success alert-dismissible fade show mb-5" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    @endif

    @if($errors->any())
      <div class="alert alert-danger alert-dismissible fade show mb-5">
        <ul class="mb-0">
          @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    @endif

    <div class="row g-5">

      {{-- Colonne gauche : avatar --}}
      <div class="col-xl-3 col-lg-4">
        <div class="card border-0 shadow-sm text-center p-5">

          {{-- Photo actuelle --}}
          <div class="position-relative d-inline-block mx-auto mb-4">
            @if($user->photo)
              <img src="{{ asset('storage/' . $user->photo) }}"
                   alt="Photo de profil"
                   class="rounded-circle object-fit-cover"
                   style="width:100px;height:100px;object-fit:cover;">
            @else
              <div class="rounded-circle bg-primary-subtle text-primary d-flex align-items-center justify-content-center mx-auto fw-bold"
                   style="width:100px;height:100px;font-size:2rem;">
                {{ strtoupper(substr($user->prenom, 0, 1)) }}{{ strtoupper(substr($user->name, 0, 1)) }}
              </div>
            @endif
          </div>

          <h5 class="fw-bold mb-1">{{ $user->prenom }} {{ $user->name }}</h5>
          <p class="text-secondary small mb-3">{{ $user->telephone }}</p>

          {{-- Badges --}}
          <div class="d-flex flex-wrap gap-2 justify-content-center mb-3">
            <span class="badge rounded-pill {{ $user->role === 'admin' ? 'bg-danger-subtle text-danger' : 'bg-secondary-subtle text-secondary' }}">
              {{ $user->role }}
            </span>
            @if($user->isActif)
              <span class="badge rounded-pill bg-success-subtle text-success">Actif</span>
            @else
              <span class="badge rounded-pill bg-danger-subtle text-danger">Inactif</span>
            @endif
            @if($user->isCertified)
              <span class="badge rounded-pill bg-warning-subtle text-warning">
                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                  <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                  <path d="M5 7.2a2.2 2.2 0 0 1 2.2 -2.2h1a2.2 2.2 0 0 0 1.55 -.64l.7 -.7a2.2 2.2 0 0 1 3.12 0l.7 .7c.412 .41 .97 .64 1.55 .64h1a2.2 2.2 0 0 1 2.2 2.2v1c0 .58 .23 1.138 .64 1.55l.7 .7a2.2 2.2 0 0 1 0 3.12l-.7 .7a2.2 2.2 0 0 0 -.64 1.55v1a2.2 2.2 0 0 1 -2.2 2.2h-1a2.2 2.2 0 0 0 -1.55 .64l-.7 .7a2.2 2.2 0 0 1 -3.12 0l-.7 -.7a2.2 2.2 0 0 0 -1.55 -.64h-1a2.2 2.2 0 0 1 -2.2 -2.2v-1a2.2 2.2 0 0 0 -.64 -1.55l-.7 -.7a2.2 2.2 0 0 1 0 -3.12l.7 -.7a2.2 2.2 0 0 0 .64 -1.55v-1"/>
                  <path d="M9 12l2 2l4 -4"/>
                </svg>
                Certifie
              </span>
            @endif
          </div>

          <p class="text-secondary" style="font-size:.78rem;">
            Membre depuis {{ $user->created_at->format('d/m/Y') }}
          </p>
        </div>
      </div>

      {{-- Colonne droite : formulaire --}}
      <div class="col-xl-9 col-lg-8">
        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
          @csrf

          {{-- Informations de base --}}
          <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3 px-4 border-bottom">
              <h6 class="mb-0 fw-semibold">Informations personnelles</h6>
            </div>
            <div class="card-body p-4">
              <div class="row g-4">

                <div class="col-md-6">
                  <label for="name" class="form-label small fw-semibold">Nom <span class="text-danger">*</span></label>
                  <input type="text" id="name" name="name"
                         class="form-control @error('name') is-invalid @enderror"
                         value="{{ old('name', $user->name) }}" required>
                  @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                  <label for="prenom" class="form-label small fw-semibold">Prenom <span class="text-danger">*</span></label>
                  <input type="text" id="prenom" name="prenom"
                         class="form-control @error('prenom') is-invalid @enderror"
                         value="{{ old('prenom', $user->prenom) }}" required>
                  @error('prenom')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                  <label for="telephone" class="form-label small fw-semibold">Telephone <span class="text-danger">*</span></label>
                  <input type="tel" id="telephone" name="telephone"
                         class="form-control @error('telephone') is-invalid @enderror"
                         value="{{ old('telephone', $user->telephone) }}" required>
                  @error('telephone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                  <label for="email" class="form-label small fw-semibold">
                    Email <span class="text-secondary small fw-normal">(optionnel)</span>
                  </label>
                  <input type="email" id="email" name="email"
                         class="form-control @error('email') is-invalid @enderror"
                         value="{{ old('email', $user->email) }}"
                         placeholder="votre@email.com">
                  @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-12">
                  <label for="addresse" class="form-label small fw-semibold">
                    Adresse <span class="text-secondary small fw-normal">(optionnel)</span>
                  </label>
                  <input type="text" id="addresse" name="addresse"
                         class="form-control @error('addresse') is-invalid @enderror"
                         value="{{ old('addresse', $user->addresse) }}"
                         placeholder="Votre adresse">
                  @error('addresse')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

              </div>
            </div>
          </div>

          {{-- Photo de profil --}}
          <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3 px-4 border-bottom">
              <h6 class="mb-0 fw-semibold">Photo de profil</h6>
            </div>
            <div class="card-body p-4">
              <div class="d-flex align-items-center gap-4 flex-wrap">

                {{-- Apercu actuel --}}
                <div id="photoPreviewWrapper">
                  @if($user->photo)
                    <img id="photoPreview"
                         src="{{ asset('storage/' . $user->photo) }}"
                         class="rounded-circle object-fit-cover"
                         style="width:80px;height:80px;object-fit:cover;">
                  @else
                    <div id="photoPreview" class="rounded-circle bg-primary-subtle text-primary d-flex align-items-center justify-content-center fw-bold"
                         style="width:80px;height:80px;font-size:1.5rem;">
                      {{ strtoupper(substr($user->prenom, 0, 1)) }}{{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                  @endif
                </div>

                <div class="flex-fill">
                  <label for="photo" class="form-label small fw-semibold d-block">
                    Changer la photo
                  </label>
                  <input type="file" id="photo" name="photo"
                         class="form-control @error('photo') is-invalid @enderror"
                         accept="image/jpg,image/jpeg,image/png,image/webp"
                         onchange="previewPhoto(this)">
                  <div class="form-text">JPG, PNG ou WEBP. Max 2 Mo.</div>
                  @error('photo')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                </div>

              </div>
            </div>
          </div>

          {{-- Changer mot de passe --}}
          <div class="card border-0 shadow-sm mb-5">
            <div class="card-header bg-white py-3 px-4 border-bottom">
              <h6 class="mb-0 fw-semibold">
                Changer le mot de passe
                <span class="text-secondary small fw-normal ms-1">(laisser vide pour ne pas changer)</span>
              </h6>
            </div>
            <div class="card-body p-4">
              <div class="row g-4">

                <div class="col-md-6">
                  <label for="password" class="form-label small fw-semibold">Nouveau mot de passe</label>
                  <div class="password-field position-relative">
                    <input type="password" id="password" name="password"
                           class="form-control fakePassword @error('password') is-invalid @enderror"
                           placeholder="Minimum 8 caracteres">
                    <span><i class="ti ti-eye-off passwordToggler"></i></span>
                    @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                  </div>
                </div>

                <div class="col-md-6">
                  <label for="password_confirmation" class="form-label small fw-semibold">Confirmer le mot de passe</label>
                  <div class="password-field position-relative">
                    <input type="password" id="password_confirmation" name="password_confirmation"
                           class="form-control fakePassword"
                           placeholder="Repetez le nouveau mot de passe">
                    <span><i class="ti ti-eye-off passwordToggler"></i></span>
                  </div>
                </div>

              </div>
            </div>
          </div>

          {{-- Bouton enregistrer --}}
          <div class="d-flex justify-content-end gap-3">
            <a href="{{ route('main') }}" class="btn btn-outline-secondary rounded-pill px-5">Annuler</a>
            <button type="submit" class="btn btn-primary rounded-pill px-5">
              Enregistrer les modifications
            </button>
          </div>

        </form>
      </div>

    </div>
  </div>
</div>

@push('scripts')
<script>
function previewPhoto(input) {
    if (!input.files || !input.files[0]) return;
    const reader = new FileReader();
    reader.onload = function (e) {
        const wrapper = document.getElementById('photoPreviewWrapper');
        wrapper.innerHTML = '<img src="' + e.target.result + '" class="rounded-circle" style="width:80px;height:80px;object-fit:cover;">';
    };
    reader.readAsDataURL(input.files[0]);
}
</script>
@endpush

@endsection

@include('main.navbar')
