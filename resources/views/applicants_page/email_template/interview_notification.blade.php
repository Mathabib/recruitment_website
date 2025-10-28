<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Notifikasi Interview - Recruitment Isolutions</title>
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #f4f4f4;
      color: #333;
      padding: 20px;
      line-height: 1.6;
    }
    .container {
      max-width: 600px;
      margin: auto;
      background-color: #ffffff;
      border-radius: 8px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
      padding: 30px;
    }
    .header {
      text-align: center;
      border-bottom: 3px solid #800;
      padding-bottom: 15px;
      margin-bottom: 25px;
    }
    .header h2 {
      color: #800;
      margin: 0;
      font-size: 22px;
      letter-spacing: 0.5px;
    }
    .content {
      font-size: 15px;
      color: #333;
    }
    .highlight {
      background-color: #fef6f6;
      border-left: 4px solid #800;
      padding: 10px 15px;
      margin: 20px 0;
      border-radius: 5px;
    }
    .button {
      display: inline-block;
      background-color: #800;
      color: #fff !important;
      text-decoration: none;
      padding: 10px 20px;
      border-radius: 6px;
      font-weight: bold;
      margin-top: 25px;
    }
    .footer {
      font-size: 13px;
      color: #777;
      text-align: center;
      margin-top: 40px;
      border-top: 1px solid #eee;
      padding-top: 15px;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="header">
      <h2>Recruitment Isolutions</h2>
    </div>

    <div class="content">
      <h3 style="color:#800; margin-bottom:10px;">Pemberitahuan Tahap Interview</h3>

      <p>Halo <strong>Kandidat</strong>,</p>

      <p>
        Terima kasih telah berpartisipasi dalam proses rekrutmen di <strong>Isolutions</strong>.
        Berdasarkan hasil seleksi sebelumnya, kami dengan senang hati menginformasikan bahwa Anda telah <strong>lolos ke tahap wawancara (interview)</strong>.
      </p>

      <div class="highlight">
        {!! $email_notes !!}
      </div>

      <p>
        Mohon agar Anda dapat menyesuaikan waktu dan mempersiapkan diri dengan baik sesuai dengan informasi yang tercantum di atas.
        Jika terdapat kendala atau perubahan jadwal, silakan menghubungi tim rekrutmen kami melalui alamat email atau kontak yang telah diberikan.
      </p>

      <p>Terima kasih atas perhatian dan kerja samanya.</p>
      <p>Salam hangat,</p>
      <p><strong>Tim Recruitment Isolutions</strong></p>
    </div>

    <div class="footer">
      <p>Email ini dikirim secara otomatis oleh sistem. Mohon tidak membalas email ini.</p>
      <p>&copy; {{ date('Y') }} Recruitment Isolutions. All rights reserved.</p>
    </div>
  </div>
</body>
</html>
