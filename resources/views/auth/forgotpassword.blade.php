
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
            <h1 class="mb-1">Mot de passe oublie ?</h1>
            <p class="mb-0 text-secondary">
              Entrez votre numero de telephone, nous vous enverrons un code de verification.
            </p>
          </div>
        </div>
      </div>

      <div class="row justify-content-center">
        <div class="col-xl-5 col-lg-6 col-md-8 col-12">
          <div class="card card-lg mb-6">
            <div class="card-body p-6">

              {{-- Message de succes --}}
              @if(session('success'))
                <div class="alert alert-success mb-4">{{ session('success') }}</div>
              @endif

              {{-- Erreurs --}}
              @if($errors->any())
                <div class="alert alert-danger mb-4">
                  <ul class="mb-0">
                    @foreach($errors->all() as $error)
                      <li>{{ $error }}</li>
                    @endforeach
                  </ul>
                </div>
              @endif

              <form method="POST" action="{{ route('forgot.password') }}" class="needs-validation mb-5" novalidate>
                @csrf

                <div class="mb-4">
                  <label for="telephone" class="form-label">
                    Numero de telephone <span class="text-danger">*</span>
                  </label>
                  <input type="tel"
                         class="form-control @error('telephone') is-invalid @enderror"
                         id="telephone" name="telephone"
                         value="{{ old('telephone') }}"
                         placeholder="Ex: 70000000"
                         required />
                  @error('telephone')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @else
                    <div class="invalid-feedback">Veuillez saisir votre numero.</div>
                  @enderror
                </div>

                <div class="d-grid">
                  <button class="btn btn-primary" type="submit">
                    Envoyer le code OTP
                  </button>
                </div>
              </form>

              <div class="text-center">
                <a href="{{ route('login.form') }}" class="text-secondary small">
                  &larr; Retour a la connexion
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
