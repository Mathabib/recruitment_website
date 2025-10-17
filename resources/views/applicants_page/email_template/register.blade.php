<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registrasi Berhasil</title>
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #f9f9f9;
      color: #333;
      padding: 20px;
    }
    .container {
      max-width: 600px;
      margin: auto;
      background-color: #ffffff;
      border-radius: 8px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.05);
      padding: 30px;
    }
    .header {
      text-align: center;
      border-bottom: 2px solid #800;
      padding-bottom: 10px;
      margin-bottom: 20px;
    }
    .header h2 {
      color: #800;
    }
    .content {
      font-size: 15px;
      line-height: 1.6;
    }
    .button {
      display: inline-block;
      background-color: #800;
      color: white !important;
      text-decoration: none;
      padding: 10px 20px;
      border-radius: 5px;
      margin-top: 20px;
    }
    .footer {
      font-size: 13px;
      color: #777;
      text-align: center;
      margin-top: 30px;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="header">
      <h2>Selamat Datang di Recuritment Isolutions</h2>
    </div>

    <div class="content">
      <p>Halo <strong>{{ $user->name }}</strong>,</p>

      <p>Terima kasih telah melakukan registrasi di <strong>Recruitment Isolutions</strong>.</p>

      <p>Akun Anda telah berhasil dibuat dan sekarang Anda dapat login ke sistem kami menggunakan email dan password yang telah Anda daftarkan.</p>

      <p>Silakan klik tombol di bawah ini untuk masuk ke akun Anda:</p>

      <p style="text-align: center;">
        <a href="{{ url('/login') }}" class="button">Masuk ke Akun</a>
      </p>

      <p>Jika Anda tidak merasa melakukan registrasi ini, abaikan email ini.</p>
    </div>

    <div class="footer">
      <p>Email ini dikirim otomatis oleh sistem. Mohon tidak membalas email ini.</p>
      <p>&copy; {{ date('Y') }} Recruitment Isolutions. All rights reserved.</p>
    </div>
  </div>
</body>
</html>
