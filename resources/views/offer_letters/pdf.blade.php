<!-- resources/views/offer_letters/pdf.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Offering Letter</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; line-height: 1.6; }
        .header-table { width: 100%; }
        .header-table td { vertical-align: top; }
        .company-logo { width: 150px; }
        .letter-number { text-align: left; }
        .letter-date { text-align: right; }
        h3.title { text-align: center; text-decoration: underline; margin: 20px 0; }
        .content { margin-top: 10px; text-align: justify; }
        table.remunerasi { width: 100%; border-collapse: collapse; margin: 15px 0; }
        table.remunerasi th, table.remunerasi td {
            border: 1px solid #000;
            padding: 6px;
            text-align: left;
        }
        .signature { margin-top: 50px; }
        .signature td { vertical-align: top; text-align: center; }
    </style>
</head>
<body>

    <!-- Header -->
    <table class="header-table">
        <tr>
            <td class="company-logo">
                <img src="{{ public_path('images/logo.png') }}" alt="Logo" width="120">
            </td>
            <td class="letter-number">
                <p>No: {{ $offer->letter_number ?? 'IMG-20001/ADM-LNJ/00001/V/2025' }}</p>
                <p>Kepada : {{ $offer->applicant->name }}</p>
                <p>Alamat : {{ $offer->applicant->address ?? '-' }}</p>
            </td>
            <td class="letter-date">
                <p>{{ $offer->job->workLocation->city ?? 'Bekasi' }}, 
                   {{ \Carbon\Carbon::parse($offer->offer_date)->translatedFormat('d F Y') }}</p>
            </td>
        </tr>
    </table>

    <!-- Judul -->
    <h3 class="title">Surat Penawaran Pekerjaan</h3>

    <!-- Isi -->
    <div class="content">
        <p><strong>SELAMAT!</strong></p>
        <p>Kami dengan senang hati mengkonfirmasi bahwa Anda telah terpilih untuk bekerja di 
           <strong>PT. Intra Multi Global Solusi (I-Solutions)</strong> 
           serta memberikan tawaran posisi pekerjaan di bawah ini.</p>

        <p>Posisi yang ditawarkan adalah <strong>{{ $offer->job->job_name }}</strong>. 
           Waktu kerja mulai pukul 08.00 – 17.00, Senin sampai Jumat, bertempat di kantor pusat {{ $offer->job->workLocation->city ?? 'Bekasi' }}.
           Penawaran ini berlaku untuk kontrak kerja {{ $offer->contract_duration ?? 12 }} bulan.</p>

        <p>Remunerasi bagi posisi ini:</p>

        <table class="remunerasi">
            <tr>
                <th>Uraian</th>
                <th>Jumlah (Rp)</th>
            </tr>
            <tr>
                <td>Gaji Pokok / Basic Salary</td>
                <td>Rp. {{ number_format($offer->basic_salary, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Tunjangan / Allowance</td>
                <td>Rp. {{ number_format($offer->allowance, 0, ',', '.') }}</td>
            </tr>
         @if(!empty($offer->responsibility_allowance) && $offer->responsibility_allowance > 0)
            <tr>
                <td>Upah Responsibility</td>
                <td>Rp. {{ number_format($offer->responsibility_allowance, 0, ',', '.') }}</td>
            </tr>
            @endif

            <tr>
                <th>Total Remunerasi</th>
                <th>Rp. {{ number_format($offer->total_salary, 0, ',', '.') }}</th>
            </tr>
        </table>

        <p>Keterangan: Perhitungan gaji di atas adalah pendapatan bersih tanpa dikurangi potongan, sudah termasuk BPJS Ketenagakerjaan dan BPJS Kesehatan.</p>

        <p>Kami ingin Anda mulai bekerja pada <strong>{{ \Carbon\Carbon::parse($offer->join_date)->translatedFormat('d F Y') }}</strong> pukul 08.00 WIB di kantor pusat Bekasi. 
           Mohon memberikan laporan kepada HR Department untuk pendokumentasian dan orientasi.</p>

        <p>Harap tanda tangani salinan surat ini dan kembalikan kepada kami paling lambat {{ \Carbon\Carbon::parse($offer->offer_date)->addDays(2)->translatedFormat('d F Y') }} 
           untuk menunjukkan penerimaan Anda atas tawaran ini.</p>
    </div>

    <!-- Tanda Tangan -->
    <table class="signature" width="100%">
        <tr>
            <td>
                Hormat Kami,<br><br><br>
                <strong>Indah Nursandi</strong><br>
                Direktur Utama
            </td>
            <td>
                Saya menerima tawaran sebagaimana diuraikan di atas<br><br><br>
                ({{ $offer->applicant->name }})<br>
                Tanggal: ___________
            </td>
        </tr>
    </table>

</body>
</html>
