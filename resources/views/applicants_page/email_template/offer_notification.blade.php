<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pemberitahuan Offering - Recruitment Isolutions</title>
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #f5f6fa;
      color: #333;
      padding: 20px;
    }
    .container {
      max-width: 620px;
      margin: auto;
      background-color: #ffffff;
      border-radius: 10px;
      box-shadow: 0 3px 10px rgba(0,0,0,0.08);
      padding: 35px;
    }
    .header {
      text-align: center;
      border-bottom: 2px solid #800;
      padding-bottom: 15px;
      margin-bottom: 25px;
    }
    .header h2 {
      color: #800;
      margin: 0;
    }
    .content {
      font-size: 15px;
      line-height: 1.7;
    }
    h1 {
      font-size: 20px;
      color: #800;
      text-align: center;
      margin-bottom: 25px;
    }
    .button {
      display: inline-block;
      background-color: #800;
      color: white !important;
      text-decoration: none;
      padding: 12px 24px;
      border-radius: 6px;
      margin-top: 20px;
      font-weight: 500;
    }
    .footer {
      font-size: 13px;
      color: #777;
      text-align: center;
      margin-top: 35px;
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
      <h1>PEMBERITAHUAN OFFERING</h1>

      <p>Halo <strong>{{ $applicant_name ?? 'Pelamar' }}</strong>,</p>

      <p>
        Kami dengan senang hati menginformasikan bahwa Anda telah <strong>lulus tahap seleksi</strong> dan
        dinyatakan <strong>terpilih untuk melanjutkan ke tahap offering</strong> di <strong>Isolutions</strong>.
      </p>

      {{-- <p>
        Melalui tahap ini, kami akan menyampaikan detail terkait <strong>penawaran kerja</strong>, termasuk
        posisi, kompensasi, dan ketentuan lainnya. Mohon untuk memeriksa dengan seksama dan menyiapkan
        dokumen atau konfirmasi yang diperlukan sesuai petunjuk berikut.
      </p> --}}

    @if($email_notes)
        <p><strong>Catatan tambahan:</strong></p>
        <div style="background-color:#f8f8f8; border-left:4px solid #800; padding:10px 15px; border-radius:6px;">
            {!! $email_notes !!}
        </div>
    @endif

      <p>
        Apabila Anda memiliki pertanyaan atau klarifikasi, silakan hubungi tim HR kami melalui alamat email
        resmi yang tertera pada catatan di atas.
      </p>

      <p>Terima kasih atas waktu dan kerja sama Anda. Kami berharap Anda dapat segera bergabung bersama tim kami.</p>

      <p>Salam hangat,<br><strong>Tim Recruitment Isolutions</strong></p>
    </div>

    <div class="footer">
      <p>Email ini dikirim secara otomatis oleh sistem. Mohon tidak membalas email ini.</p>
      <p>&copy; {{ date('Y') }} Recruitment Isolutions. All rights reserved.</p>
    </div>
  </div>
</body>
</html>
