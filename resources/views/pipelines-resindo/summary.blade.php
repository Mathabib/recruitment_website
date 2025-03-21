<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        *{
            /* border: 1px solid red; */
        }
        body {
            font-family: 'Arial', sans-serif;
            margin: 0px;
            padding: 0;
            padding-top: 100px;
            background-color: white;
            color: #333;
            padding-bottom: 50px;
            /* Memberikan ruang untuk footer */
        }
        .bar{
            background: black;
            color: white;
            margin: 0px;
            display: flex;
            align-content: center;
            justify-content: center;
            width: 100%;
        }
        header{
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            width: 100%;
            z-index: 999
        }
        .header-name{
            padding-left: 20px;
        }
        .header-name h1{
            font-size: 40px;
            height: 30px;
        }
        .content-summary{
            padding-left: 10px;
        }
        
        .foto{
            position: fixed;
            top: 120px;            
            right: 30px;
            z-index: 999;
        }
        .biodata-table{
            padding-right: 270px;
        }
        .biodata-table table tr:nth-child(even){
            background-color: rgb(220, 220, 220)
        }
        .biodata-table table tr{
            border: 1px solid black;
        }
        .font-paragraph{
            margin: 0px;
            font-size: 18px;

        }

        .information-detail{
            display: flex;
            flex-direction: column;
        }
        .sub-tittle{
            font-size: 20px;
            text-decoration: underline;
            margin: 0px;
        }
        .unordered-list{
            margin: 0px;
        }
        .information-detail table{
            width: 100%;
        }
        .information-detail table tr .left{
            width: 70%;
            vertical-align: top;
        }
        .information-detail table tr .right{
            width: 30%;
            padding-top: 50px;
            vertical-align: top;            
        }
        .skills, .country-works, .language, .education, .experience-record, .selected-projects{
            margin-bottom: 20px;
        }
        /* .information-detail tr, td{
            border: 1px solid red;
        } */

        @page {
            padding-top:0mm;
            margin: 0mm;
        }

        .kontener{
            display: table;

            
        }
        footer{
            position: fixed;
            bottom: 0px;
            width: 100%;

        }                
        
    </style>
</head>
<body>
    <header>
        <div class="bar">
            <table style="width: 100%">
                <tr>
                    <td class="header-name">
                        <h1>{{ $applicant->name }}</h1>
                    </td>
                </tr>
            </table>
        </div>
        <div class="foto"><img style="border-radius: 5%" height="250px" src="{{ public_path('storage/' . $applicant->photo_pass) }}" alt=""></div>
    </header>

    <footer>
        <table style="width: 100%">
            <tr>
                <td style="width: 15%; text-align: center">
                    <img height="50px;" src="{{ public_path('assets/barcode_resindo.jpg') }}" alt="">
                </td>
                <td style="width: 70%; text-align: center">
                    <div style="width: 100%">
                        <table style="width: 100%">
                            <tr>                                
                                <td style="width: 33%">
                                    <table>
                                        <tr>
                                            <td>
                                                <img style="height: 30px" src="{{ public_path('assets/icon_youtube.png') }}" alt="">
                                            </td>
                                            <td>
                                                <p>@RESINDOGroup</p>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                                <td style="width: 33%">
                                    <table>
                                        <tr>
                                            <td>
                                                <img style="height: 30px" src="{{ public_path('assets/icon_linkdin.png') }}" alt="">
                                            </td>
                                            <td>
                                                <p>pt-resindo-group</p>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                                <td style="width: 33%">
                                    <table>
                                        <tr>
                                            <td>
                                                <img style="height: 30px" src="{{ public_path('assets/icon_website.png') }}" alt="">
                                            </td>
                                            <td>
                                                <p>www.resindori.com</p>
                                            </td>
                                        </tr>
                                    </table>    
                                </td>                                
                            </tr>
                        </table>
                    </div>
                </td>
                <td style="width: 15%; text-align: center">
                    <img height="50px;" src="{{ public_path('assets/logo-resindo.jpg') }}" alt="">
                </td>
            </tr>
        </table>
    </footer>

    <div class="content-summary">
        <div class="biodata-table">
            <table style="width: 100%">
                <tr>
                    <td><strong><p class="font-paragraph">Position / Title</p></strong></td>
                    <td><strong><p class="font-paragraph">{{ $applicant->job->job_name }}</p></strong></td>
                </tr>
                <tr>
                    <td><p class="font-paragraph">Total Working Experiences</p></td>
                    <td><p class="font-paragraph">{{ $applicant->experience_period }}</p></td>
                </tr>
                <tr>
                    <td><p class="font-paragraph">Citizenship</p></td>
                    <td><p class="font-paragraph">{{ $applicant->Citizenship }}</p></td>
                </tr>
                <tr>
                    <td><p class="font-paragraph">Education</p></td>
                    <td><p class="font-paragraph">{{ $applicant->jurusan->name_jurusan }}</p></td>
                </tr>
            </table>
        </div>

        <div class="information-detail">

            <div class="education">
                <strong><p class="sub-tittle">Educations</p></strong>
                <ul class="unordered-list">
                    <li><p class="font-paragraph">{{ $applicant->jurusan->name_jurusan }}</p></li>                                
                </ul>                            
            </div>

            <div class="experience-record">
                <strong><p class="sub-tittle">Experience Record (Indonesian eng based since 2005)</p></strong>
                <ul class="unordered-list">
                    @foreach($applicant->workExperiences as $experience)
                        <li><p class="font-paragraph">{{ $experience->name_company }}</p></li>
                    @endforeach
                </ul>                            
            </div>

            <div class="selected-projects">
                <strong><p class="sub-tittle">Selected Projects</p></strong>
                <ul class="unordered-list">
                    @foreach($applicant->projects as $project)
                        <li><p class="font-paragraph">{{ $project->project_name }}</p></li>
                    @endforeach
                </ul>                            
            </div>

            <div class="skills">
                <strong><p class="sub-tittle">Skills</p></strong>
                <ul class="unordered-list">
                    @foreach(explode('|', $applicant->skills) as $skill)
                        <li><p class="font-paragraph">{{ trim($skill) }}</p></li>                                
                    @endforeach
                </ul>
            </div>
            
            <div class="language">
                <strong><p class="sub-tittle">Language</p></strong>
                <ul class="unordered-list">
                    
                    @foreach ($applicant->Languages as $item)
                        <li><p class="font-paragraph">{{ $item->language }}</p></li>    
                    @endforeach
                                                                                    
                </ul>
            </div>

            <table>
                <tr>
                    <td class="left">
                        
                    </td>

                    <td class="right">
                        
                    </td>

                </tr>                
            </table>
        </div>

        {{-- <div class="kontener">
            <div class="kotak"></div>
            <div class="kotak"></div>
        </div> --}}
    </div>
</body>
</html>