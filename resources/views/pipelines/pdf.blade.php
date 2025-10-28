<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>CV for {{ $applicant->name }}</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0px;
            padding: 0;
            background-color: white;
            color: #333;
            padding-bottom: 50px;
            /* Memberikan ruang untuk footer */
        }

        .container {
            width: 100%;
            max-width: 800px;
            margin: 0px auto;
            padding: 0px;
            border-radius: 8px;
        }

        .header {
            margin-top: -20px;
            text-align: center;
            margin-bottom: 15px;
            /* Menghapus margin bawah */
        }

        .header img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #10375C;
            margin: 0;
            /* Menghapus margin di gambar */
        }

        h1 {
            font-size: 17px;
            margin: 0;
            /* Menghapus margin di h1 */
            color: #10375C;
        }




        .section {
            margin-top: 0;
            /* Mengurangi jarak atas */
            margin-bottom: 10px;
            padding: 8px;
            border: 1px solid #e0e0e0;
            border-radius: 6px;
            background-color: white;
        }


        .section p {
            word-wrap: break-word;
            overflow-wrap: break-word;
            margin: 0;
            max-width: 100%;
        }

        h2 {
            font-size: 12px;
            margin-top: 0px;
            margin-bottom: 8px;
            color: #10375C;
            border-bottom: 2px solid #10375C;
            padding-bottom: 3px;
        }

        h3 {
            font-size: 11px;
            margin-bottom: 3px;
            color: #0056b3;
        }

        p {
            margin: 3px 0;
            line-height: 1.4;
            font-size: 10px;
        }

        /* Styles for skills, certificates, and achievements */





         .skills-list {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    justify-content: flex-start;
    margin: 0;
    padding: 0;
}

.skills-list li {
    background-color: #cce5ff;
    border-radius: 25px;
    padding: 5px 20px;
    font-size: 10px;
    color: #004085;
    white-space: nowrap;
    display: inline-block;
    text-align: center;
     margin-left: 1px;
    margin-right: 1px;
    margin-top: 1px;
    border: 1px solid #004085;

}


/* certificate */
.certificates-list {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    justify-content: flex-start;
    margin: 0;
    padding: 0;
}

.certificates-list li {
    background-color: #fff3cd;
    border-radius: 25px;
    padding: 5px 20px;
    font-size: 10px;
    color: #856404;
    white-space: nowrap;
    display: inline-block;
    text-align: center;
     margin-left: 1px;
    margin-right: 1px;
    margin-top: 1px;
    border: 1px solid #856404;

}

/* achievement */
.achievement-list {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    justify-content: flex-start;
    margin: 0;
    padding: 0;
}

.achievement-list li {
    background-color: #d4edda;
    border-radius: 25px;
    padding: 5px 20px;
    font-size: 10px;
    color: #155724;
    white-space: nowrap;
    display: inline-block;
    text-align: center;
     margin-left: 1px;
    margin-right: 1px;
    margin-top: 1px;
    border: 1px solid #155724;
}

        .section ul {
            margin-top: 10px;
        }

        footer {
            display: flex;
            align-content: flex-end;
            justify-content: space-between;
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 10px;
            width: 100%;
            z-index: 999;
        }

        .footer .logo {
            position: absolute;
            left: 5px;
            top: -2px;
            width: 50%;
        }

        .footer .address {
            font-size: 10px;
            text-align: center;
            width: 100%;
        }

        .footer .qr-code {
            position: absolute;
            right: 10px;
            top: -10px;
            width: 80px;
            height: 80px;
        }

        .page-break {
            page-break-before: always;
        }

        .table-content-cv{
            border-spacing: 7px 0px;
        }

        .content-cv{
            text-align: justify;
        }
        .tr-content-cv{
            margin: 10px;
        }
        .tr-content-cv td{
            vertical-align: top;
        }

        @page {
            margin: 12mm;
            font-size: 10px;
        }
    </style>

</head>

<body>

    <footer class="footer">
        <div class="logo">
            <img src="{{ public_path('assets/ISOLOGO.png') }}" alt="Logo" class="logo">
        </div>
        <div class="address">
            Grand Galaxy City Jl. Cordova 3 Blok RGC3 No.58 <br>
            Jaka Setia – Bekasi Selatan – Jawa Barat 17147 <br>
            &copy; {{ date('F Y') }} I-solutions Indonesia. All rights reserved.
        </div>
        <div class="qr-code">
            <img src="{{ public_path('assets/QR.png') }}" alt="QR Code" class="qr-code">
        </div>
    </footer>

    <div class="container">

        <div class="header">

            @if($applicant->photo_pass)
            <img src="{{ public_path('storage/' . $applicant->photo_pass) }}" alt="Applicant Photo">
            @else
            <img src="https://via.placeholder.com/100" alt="Default Photo">
            @endif
            <h1>{{ $applicant->name }}</h1>

        </div>


        <div class="section">
            <h2>Profile</h2>
            <p>{{ $applicant->profile }}</p>
        </div>

        <div class="section">
            <h2>Education</h2>
            <table class="table-content-cv">
                <tr class="tr-content-cv">
                    <td><strong>Education</strong></td>
                    <td>:</td>
                    <td>{{ optional($applicant->education)->name_education }}</td>
                </tr>
                <tr class="tr-content-cv">
                    <td><strong>Major</strong></td>
                    <td>:</td>
                    <td>{{ optional($applicant->jurusan)->name_jurusan }}</td>
                </tr>
            </table>

        </div>

        @if($applicant->certificates)
        <div class="section">
            <h2>Certificates</h2>
            <ul class="certificates-list">
                @foreach(explode('|', $applicant->certificates) as $certificate)
                <li>{{ trim($certificate) }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        @if($applicant->skills)
        <div class="section">
            <h2>Skills</h2>
            <ul class="skills-list">
                @foreach(explode('|', $applicant->skills) as $skill)
                <li>{{ trim($skill) }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="section">
            <h2>Work Experience</h2>
            @if($applicant->workExperiences->isNotEmpty())
            @foreach($applicant->workExperiences as $experience)
            <h3>{{ $experience->role }}</h3>
            <table class="table-content-cv">
                <tr class="tr-content-cv">
                    <td class="title-content-cv"><strong>Company</strong></td> <td>:</td> <td class="content-cv">{{ $experience->name_company }}</td>
                </tr>
                <tr class="tr-content-cv">
                    <td class="title-content-cv"><strong>Description</strong></td> <td>:</td> <td class="content-cv">{!! $experience->desc_kerja !!}</td>
                    {{-- <td class="title-content-cv"><strong>Description</strong></td> <td>:</td> <td class="content-cv">{{ $experience->desc_kerja }}</td> --}}
                </tr>
                <tr class="tr-content-cv">
                    <td class="title-content-cv"><strong>Period</strong></td> <td>:</td> <td>{{ $experience->mulai }} - {{ ($experience->present == 'present' ? 'present' : $experience->selesai) }}</td>
                </tr>
            </table>

            @endforeach
            @else
            <p>No work experience available.</p>
            @endif
        </div>


        @if($applicant->Projects->isNotEmpty())
        <div class="section">
            <h2>Projects</h2>
            @foreach($applicant->projects as $project)

            <h3>{{ $project->project_name }}</h3>
            <table class="table-content-cv">
                <tr class="tr-content-cv">
                    <td class="title-content-cv"><strong>Client</strong></td> <td>:</td> <td class="content-cv"> {{ $project->client }}</td>
                </tr>
                <tr class="tr-content-cv">
                    <td class="title-content-cv"><strong>Description</strong></td> <td>:</td> <td class="content-cv">{{ $project->desc_project }}</td>
                </tr>
                {{-- <tr class="tr-content-cv">
                    <td class="title-content-cv"><strong>Period</strong></td> <td>:</td> <td class="content-cv">{{ $project->mulai_project }} - {{ $project->selesai_project }}</td>
                </tr> --}}
            </table>

            @endforeach
        </div>
        @endif

        @if($applicant->achievement)
        <div class="section">
            <h2>Achievements</h2>
            <ul class="achievement-list">
                @foreach(explode('|', $applicant->achievement) as $achievement)
                <li>{{ trim($achievement) }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="section">
            <h2>Languages</h2>
            <p>{{ $applicant->languages}}</p>
        </div>

        <div class="section">
            <h2>Additional Information</h2>
            <table class="table-content-cv">
                <tr class="tr-content-cv">
                    <td class="title-content-cv"><strong>MBTI</strong></td> <td>:</td> <td class="content-cv">{{ $applicant->mbti ?? 'none' }}</td>
                </tr>
                <tr class="tr-content-cv">
                    <td class="title-content-cv"><strong>IQ</strong></td> <td>:</td> <td class="content-cv">{{ $applicant->iq ?? 'none' }}</td>
                </tr>
            </table>
        </div>


        @if($applicant->references->isNotEmpty())
        <div class="section">
            <h2>References</h2>
            @foreach($applicant->references as $reference)
            <h3>{{ $reference->name_ref }}</h3>
            <table class="table-content-cv">
                <tr class="tr-content-cv">
                    <td class="title-content-cv"><strong>Phone Number</strong></td> <td>:</td> <td class="content-cv">{{ $reference->phone }}</td>
                </tr>
                <tr class="tr-content-cv">
                    <td class="title-content-cv"><strong>Email</strong></td> <td>:</td> <td class="content-cv">{{ $reference->email_ref }}</td>
                </tr>
            </table>
            @endforeach
        </div>
        @endif


         <footer class="footer">
            <div class="logo">
                <img src="{{ public_path('assets/ISOLOGO.png') }}" alt="Logo" class="logo">
            </div>
            <div class="address">
                Grand Galaxy City Jl. Cordova 3 Blok RGC3 No.58 <br>
                Jaka Setia – Bekasi Selatan – Jawa Barat 17147 <br>
                &copy; {{ date('F Y') }} I-solutions Indonesia. All rights reserved.
            </div>
            <div class="qr-code">
                <img src="{{ public_path('assets/QR.png') }}" alt="QR Code" class="qr-code">
            </div>
        </footer>



    </div>

</body>

</html>
