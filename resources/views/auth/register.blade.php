
@extends('main.index')

@section('content')

<main class="d-flex flex-column justify-content-center py-8">
  <section>
    <div class="container">

      {{-- Logo --}}
      <div class="row mb-6">
        <div class="col-xl-4 offset-xl-4 col-md-12 col-12">
          <div class="text-center">
            <a href="{{ route('main') }}" class="fs-2 fw-bold d-flex align-items-center gap-2 justify-content-center mb-4">
              <span>ArtisanFaso</span>
            </a>
            <h1 class="mb-1">Creer un compte</h1>
            <p class="mb-0">
              Deja inscrit ?
              <a href="{{ route('login.form') }}" class="text-primary">Se connecter ici</a>
            </p>
          </div>
        </div>
      </div>

      {{-- Formulaire --}}
      <div class="row justify-content-center">
        <div class="col-xl-5 col-lg-6 col-md-8 col-12">
          <div class="card shadow-sm mb-4">
            <div class="card-body p-6">

              @if ($errors->any())
                <div class="alert alert-danger mb-4">
                  <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                    @endforeach
                  </ul>
                </div>
              @endif

              <form method="POST" action="{{ route('register') }}" class="needs-validation" novalidate>
                @csrf

                {{-- Nom --}}
                <div class="mb-3">
                  <label for="name" class="form-label">Nom <span class="text-danger">*</span></label>
                  <input type="text"
                         class="form-control @error('name') is-invalid @enderror"
                         id="name" name="name"
                         value="{{ old('name') }}"
                         placeholder="Votre nom de famille"
                         required />
                  @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @else
                    <div class="invalid-feedback">Veuillez saisir votre nom.</div>
                  @enderror
                </div>

                {{-- Prenom --}}
                <div class="mb-3">
                  <label for="prenom" class="form-label">Prenom <span class="text-danger">*</span></label>
                  <input type="text"
                         class="form-control @error('prenom') is-invalid @enderror"
                         id="prenom" name="prenom"
                         value="{{ old('prenom') }}"
                         placeholder="Votre prenom"
                         required />
                  @error('prenom')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @else
                    <div class="invalid-feedback">Veuillez saisir votre prenom.</div>
                  @enderror
                </div>

                {{-- Telephone --}}
                <div class="mb-3">
                  <label for="telephone" class="form-label">Telephone <span class="text-danger">*</span></label>
                  <input type="tel"
                         class="form-control @error('telephone') is-invalid @enderror"
                         id="telephone" name="telephone"
                         value="{{ old('telephone') }}"
                         placeholder="Ex: 70000000"
                         required />
                  @error('telephone')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @else
                    <div class="invalid-feedback">Veuillez saisir un numero valide.</div>
                  @enderror
                </div>

                {{-- Email (optionnel) --}}
                <div class="mb-3">
                  <label for="email" class="form-label">Email <span class="text-secondary small">(optionnel)</span></label>
                  <input type="email"
                         class="form-control @error('email') is-invalid @enderror"
                         id="email" name="email"
                         value="{{ old('email') }}"
                         placeholder="votre@email.com" />
                  @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                {{-- Adresse (optionnel) --}}
                <div class="mb-3">
                  <label for="addresse" class="form-label">Adresse <span class="text-secondary small">(optionnel)</span></label>
                  <input type="text"
                         class="form-control @error('addresse') is-invalid @enderror"
                         id="addresse" name="addresse"
                         value="{{ old('addresse') }}"
                         placeholder="Votre adresse" />
                  @error('addresse')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                {{-- Mot de passe --}}
                <div class="mb-3">
                  <label for="password" class="form-label">Mot de passe <span class="text-danger">*</span></label>
                  <div class="password-field position-relative">
                    <input type="password"
                           class="form-control fakePassword @error('password') is-invalid @enderror"
                           id="password" name="password"
                           placeholder="Minimum 8 caracteres"
                           required />
                    <span><i class="ti ti-eye-off passwordToggler"></i></span>
                    @error('password')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @else
                      <div class="invalid-feedback">Veuillez saisir un mot de passe.</div>
                    @enderror
                  </div>
                </div>

                {{-- Confirmation mot de passe --}}
                <div class="mb-4">
                  <label for="password_confirmation" class="form-label">Confirmer le mot de passe <span class="text-danger">*</span></label>
                  <div class="password-field position-relative">
                    <input type="password"
                           class="form-control fakePassword"
                           id="password_confirmation" name="password_confirmation"
                           placeholder="Repetez votre mot de passe"
                           required />
                    <span><i class="ti ti-eye-off passwordToggler"></i></span>
                    <div class="invalid-feedback">Les mots de passe ne correspondent pas.</div>
                  </div>
                </div>

                <div class="d-grid">
                  <button class="btn btn-primary" type="submit">S'inscrire</button>
                </div>

              </form>

            </div>
          </div>
        </div>
      </div>

    </div>
  </section>
</main>

@endsection
