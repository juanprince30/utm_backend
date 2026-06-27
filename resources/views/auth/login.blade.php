
@extends('main.index')

@section('content')

<main class="d-flex flex-column justify-content-center vh-100">
  <section>
    <div class="container">

      {{-- Logo --}}
      <div class="row mb-8">
        <div class="col-xl-4 offset-xl-4 col-md-12 col-12">
          <div class="text-center">
            <a href="{{ route('main') }}" class="fs-2 fw-bold d-flex align-items-center gap-2 justify-content-center mb-6">
              <span>ArtisanFaso</span>
            </a>
            <h1 class="mb-1">Bon retour !</h1>
            <p class="mb-0">
              Pas encore de compte ?
              <a href="{{ route('register.form') }}" class="text-primary">S'inscrire ici</a>
            </p>
          </div>
        </div>
      </div>

      {{-- Formulaire --}}
      <div class="row justify-content-center">
        <div class="col-xl-5 col-lg-6 col-md-8 col-12">
          <div class="card card-lg mb-6">
            <div class="card-body p-6">

              @if(session('success'))
                <div class="alert alert-success mb-4">{{ session('success') }}</div>
              @endif

              @if ($errors->any())
                <div class="alert alert-danger mb-4">
                  <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                    @endforeach
                  </ul>
                </div>
              @endif

              <form method="POST" action="{{ route('login') }}" class="needs-validation mb-6" novalidate>
                @csrf

                {{-- Numero de telephone --}}
                <div class="mb-3">
                  <label for="numero" class="form-label">
                    Numero de telephone <span class="text-danger">*</span>
                  </label>
                  <input type="tel"
                         class="form-control @error('numero') is-invalid @enderror"
                         id="numero" name="numero"
                         value="{{ old('numero') }}"
                         placeholder="Ex: 70000000"
                         required />
                  @error('numero')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @else
                    <div class="invalid-feedback">Veuillez saisir votre numero.</div>
                  @enderror
                </div>

                {{-- Mot de passe --}}
                <div class="mb-3">
                  <label for="password" class="form-label">
                    Mot de passe <span class="text-danger">*</span>
                  </label>
                  <div class="password-field position-relative">
                    <input type="password"
                           class="form-control fakePassword @error('password') is-invalid @enderror"
                           id="password" name="password"
                           required />
                    <span><i class="ti ti-eye-off passwordToggler"></i></span>
                    @error('password')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @else
                      <div class="invalid-feedback">Veuillez saisir votre mot de passe.</div>
                    @enderror
                  </div>
                </div>

                {{-- Liens utiles --}}
                <div class="mb-4 d-flex align-items-center justify-content-end">
                  <a href="{{ route('forgotpassword.form') }}" class="text-primary small">
                    Mot de passe oublie ?
                  </a>
                </div>

                <div class="d-grid">
                  <button class="btn btn-primary" type="submit">Se connecter</button>
                </div>

              </form>

              <span class="text-secondary small">Ou connectez-vous via :</span>
              <div class="mt-3 d-flex gap-2 justify-content-between">
                <a href="#" class="btn btn-google w-100">
                  <span class="me-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                      <path d="M15.545 6.558a9.42 9.42 0 0 1 .139 1.626c0 2.434-.87 4.492-2.384 5.885h.002C11.978 15.292 10.158 16 8 16A8 8 0 1 1 8 0a7.689 7.689 0 0 1 5.352 2.082l-2.284 2.284A4.347 4.347 0 0 0 8 3.166c-2.087 0-3.86 1.408-4.492 3.304a4.792 4.792 0 0 0 0 3.063h.003c.635 1.893 2.405 3.301 4.492 3.301 1.078 0 2.004-.276 2.722-.764h-.003a3.702 3.702 0 0 0 1.599-2.431H8v-3.08h7.545z"/>
                    </svg>
                  </span>
                  Google
                </a>
                <a href="#" class="btn btn-facebook w-100">
                  <span class="me-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                      <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951z"/>
                    </svg>
                  </span>
                  Facebook
                </a>
              </div>

            </div>
          </div>
        </div>
      </div>

    </div>
  </section>
</main>

@endsection
