
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
            <h1 class="mb-1">Nouveau mot de passe</h1>
            <p class="mb-0 text-secondary">
              Choisissez un mot de passe securise d'au moins 8 caracteres.
            </p>
          </div>
        </div>
      </div>

      <div class="row justify-content-center">
        <div class="col-xl-5 col-lg-6 col-md-8 col-12">
          <div class="card card-lg mb-6">
            <div class="card-body p-6">

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

              <form method="POST" action="{{ route('reset.password') }}" class="needs-validation" novalidate>
                @csrf

                {{-- Nouveau mot de passe --}}
                <div class="mb-3">
                  <label for="password" class="form-label">
                    Nouveau mot de passe <span class="text-danger">*</span>
                  </label>
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

                {{-- Confirmation --}}
                <div class="mb-4">
                  <label for="password_confirmation" class="form-label">
                    Confirmer le mot de passe <span class="text-danger">*</span>
                  </label>
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

                {{-- Indicateur de force --}}
                <div class="mb-4">
                  <div class="d-flex gap-1 mb-1">
                    <div class="flex-fill rounded" id="str1" style="height:4px;background:#e5e7eb;"></div>
                    <div class="flex-fill rounded" id="str2" style="height:4px;background:#e5e7eb;"></div>
                    <div class="flex-fill rounded" id="str3" style="height:4px;background:#e5e7eb;"></div>
                    <div class="flex-fill rounded" id="str4" style="height:4px;background:#e5e7eb;"></div>
                  </div>
                  <small id="strLabel" class="text-secondary"></small>
                </div>

                <div class="d-grid mb-4">
                  <button class="btn btn-primary" type="submit">
                    Reinitialiser le mot de passe
                  </button>
                </div>

                <div class="text-center">
                  <a href="{{ route('login.form') }}" class="text-secondary small">
                    &larr; Retour a la connexion
                  </a>
                </div>

              </form>

            </div>
          </div>
        </div>
      </div>

    </div>
  </section>
</main>

@push('scripts')
<script>
(function () {
    const pwd    = document.getElementById('password');
    const bars   = [1,2,3,4].map(function(i){ return document.getElementById('str' + i); });
    const label  = document.getElementById('strLabel');
    const colors = ['#ef4444','#f97316','#eab308','#22c55e'];
    const labels = ['Tres faible','Faible','Correct','Fort'];

    pwd.addEventListener('input', function () {
        const v = this.value;
        let score = 0;
        if (v.length >= 8)           score++;
        if (/[A-Z]/.test(v))         score++;
        if (/[0-9]/.test(v))         score++;
        if (/[^A-Za-z0-9]/.test(v))  score++;

        bars.forEach(function (b, i) {
            b.style.background = i < score ? colors[score - 1] : '#e5e7eb';
        });
        label.textContent  = v.length ? labels[score - 1] || '' : '';
        label.style.color  = score > 0 ? colors[score - 1] : '';
    });
})();
</script>
@endpush

@endsection
