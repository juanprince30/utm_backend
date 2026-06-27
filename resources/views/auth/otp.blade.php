
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
            <h1 class="mb-1">Verification OTP</h1>
            <p class="mb-0 text-secondary">
              Entrez le code a 4 chiffres envoye sur votre telephone.
            </p>
          </div>
        </div>
      </div>

      <div class="row justify-content-center">
        <div class="col-xl-4 col-lg-5 col-md-8 col-12">
          <div class="card card-lg mb-6">
            <div class="card-body p-6">

              {{-- Confirmation envoi email --}}
              @if(session('info'))
                <div class="alert alert-success mb-4 d-flex align-items-center gap-2">
                  <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none"
                       stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                       viewBox="0 0 24 24">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M3 7a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v10a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-10z"/>
                    <path d="M3 7l9 6l9 -6"/>
                  </svg>
                  <span>{{ session('info') }}</span>
                </div>
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

              <form method="POST" action="{{ route('verify.otp') }}" id="otpForm">
                @csrf

                {{-- Input cache qui recoit le code assemble --}}
                <input type="hidden" name="otp" id="otpHidden" />

                {{-- 4 cases visuelles --}}
                <div class="d-flex gap-3 justify-content-center mb-5">
                  <input type="text" class="form-control text-center fs-4 fw-bold otp-input"
                         maxlength="1" inputmode="numeric" pattern="[0-9]"
                         style="width:60px;height:60px;" />
                  <input type="text" class="form-control text-center fs-4 fw-bold otp-input"
                         maxlength="1" inputmode="numeric" pattern="[0-9]"
                         style="width:60px;height:60px;" />
                  <input type="text" class="form-control text-center fs-4 fw-bold otp-input"
                         maxlength="1" inputmode="numeric" pattern="[0-9]"
                         style="width:60px;height:60px;" />
                  <input type="text" class="form-control text-center fs-4 fw-bold otp-input"
                         maxlength="1" inputmode="numeric" pattern="[0-9]"
                         style="width:60px;height:60px;" />
                </div>

                <div class="d-grid mb-4">
                  <button class="btn btn-primary" type="submit">Verifier le code</button>
                </div>

                <div class="text-center mb-3">
                  <span class="text-secondary small">
                    Code non recu ?
                    <a href="{{ route('forgotpassword.form') }}" class="text-primary">
                      Renvoyer le code
                    </a>
                  </span>
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
    const inputs = document.querySelectorAll('.otp-input');
    const hidden = document.getElementById('otpHidden');
    const form   = document.getElementById('otpForm');

    inputs.forEach(function (input, i) {
        // Avance auto apres saisie
        input.addEventListener('input', function () {
            this.value = this.value.replace(/[^0-9]/g, '');
            if (this.value && i < inputs.length - 1) {
                inputs[i + 1].focus();
            }
        });

        // Retour arriere
        input.addEventListener('keydown', function (e) {
            if (e.key === 'Backspace' && !this.value && i > 0) {
                inputs[i - 1].focus();
            }
        });

        // Coller un code complet d'un coup
        input.addEventListener('paste', function (e) {
            e.preventDefault();
            const pasted = (e.clipboardData || window.clipboardData).getData('text').replace(/\D/g, '');
            pasted.split('').forEach(function (char, idx) {
                if (inputs[idx]) inputs[idx].value = char;
            });
            if (inputs[pasted.length - 1]) inputs[pasted.length - 1].focus();
        });
    });

    // Assemble les 4 chiffres dans le champ cache avant soumission
    form.addEventListener('submit', function (e) {
        const code = Array.from(inputs).map(function (i) { return i.value; }).join('');
        if (code.length !== 4) {
            e.preventDefault();
            inputs[0].classList.add('is-invalid');
            return;
        }
        hidden.value = code;
    });
})();
</script>
@endpush

@endsection
