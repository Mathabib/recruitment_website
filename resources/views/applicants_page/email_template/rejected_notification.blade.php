<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pemberitahuan Hasil Seleksi - Recruitment Isolutions</title>
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
    .highlight {
      background-color: #f8f8f8;
      border-left: 4px solid #800;
      padding: 12px 16px;
      border-radius: 6px;
      margin-top: 10px;
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
      <h1>PEMBERITAHUAN HASIL SELEKSI</h1>

      <p>Halo <strong>{{ $applicant_name ?? 'Pelamar' }}</strong>,</p>

      <p>
        Terima kasih telah berpartisipasi dalam proses rekrutmen di <strong>Isolutions</strong> dan telah meluangkan waktu serta usaha untuk mengikuti seluruh tahapan seleksi yang kami selenggarakan.
      </p>

      <p>
        Setelah mempertimbangkan berbagai aspek, kami informasikan bahwa saat ini Anda <strong>belum dapat kami lanjutkan ke tahap berikutnya</strong>.
        Keputusan ini tidak mencerminkan kurangnya kemampuan Anda, namun lebih karena adanya kecocokan yang lebih sesuai dengan kebutuhan posisi yang sedang kami buka.
      </p>

      @if(!empty(trim($email_notes ?? '')))
        <p><strong>Catatan tambahan:</strong></p>
        <div class="highlight">
          {!! $email_notes !!}
        </div>
      @endif

      <p>
        Kami sangat mengapresiasi ketertarikan Anda untuk bergabung bersama kami, dan kami berharap tetap dapat berkesempatan bekerja sama di masa mendatang.
        Anda dipersilakan untuk kembali melamar apabila terdapat posisi yang sesuai dengan minat dan kompetensi Anda di kemudian hari.
      </p>

      <p>
        Sekali lagi, terima kasih atas waktu dan dedikasi Anda selama proses rekrutmen berlangsung.
      </p>

      <p>Salam hangat,<br><strong>Tim Recruitment Isolutions</strong></p>
    </div>

    <div class="footer">
      <p>Email ini dikirim secara otomatis oleh sistem. Mohon tidak membalas email ini.</p>
      <p>&copy; {{ date('Y') }} Recruitment Isolutions. All rights reserved.</p>
    </div>
  </div>
</body>
</html>
