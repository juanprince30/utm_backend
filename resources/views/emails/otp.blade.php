<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Code OTP - ArtisanFaso</title>
  <style>
    body { margin:0; padding:0; background:#f3f4f6; font-family:'Segoe UI',Arial,sans-serif; }
    .wrapper { max-width:520px; margin:40px auto; background:#fff; border-radius:12px; overflow:hidden; box-shadow:0 4px 20px rgba(0,0,0,.08); }
    .header  { background:linear-gradient(135deg,#4f46e5,#7c3aed); padding:32px 40px; text-align:center; }
    .header h1 { color:#fff; margin:0; font-size:22px; font-weight:700; letter-spacing:.5px; }
    .header p  { color:rgba(255,255,255,.8); margin:6px 0 0; font-size:13px; }
    .body    { padding:36px 40px; }
    .body p  { color:#374151; font-size:15px; line-height:1.6; margin:0 0 16px; }
    .otp-box { text-align:center; background:#f5f3ff; border:2px dashed #7c3aed; border-radius:10px; padding:24px 16px; margin:24px 0; }
    .otp-code { display:inline-block; font-size:40px; font-weight:800; letter-spacing:14px; color:#4f46e5; font-family:'Courier New',monospace; }
    .expire  { text-align:center; color:#6b7280; font-size:13px; margin:0 0 24px; }
    .expire span { color:#ef4444; font-weight:600; }
    .footer  { background:#f9fafb; border-top:1px solid #e5e7eb; padding:20px 40px; text-align:center; }
    .footer p { color:#9ca3af; font-size:12px; margin:0; line-height:1.6; }
  </style>
</head>
<body>
  <div class="wrapper">

    <div class="header">
      <h1>ArtisanFaso</h1>
      <p>Reinitialisation de mot de passe</p>
    </div>

    <div class="body">
      <p>Bonjour,</p>
      <p>
        Vous avez demande la reinitialisation de votre mot de passe.
        Voici votre code de verification :
      </p>

      <div class="otp-box">
        <span class="otp-code">{{ $otp }}</span>
      </div>

      <p class="expire">
        Ce code est valable pendant <span>10 minutes</span>.
      </p>

      <p>
        Si vous n'avez pas fait cette demande, ignorez cet email.
        Votre mot de passe ne sera pas modifie.
      </p>
    </div>

    <div class="footer">
      <p>
        Cet email a ete envoye automatiquement par ArtisanFaso.<br>
        Ne pas repondre a cet email.
      </p>
    </div>

  </div>
</body>
</html>
