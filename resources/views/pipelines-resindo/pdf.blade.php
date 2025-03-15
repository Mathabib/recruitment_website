<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0px;
            padding: 0;
            background-color: white;
            color: #333;
            padding-top: 100px;
            /* Memberikan ruang untuk footer */
        }
        header{
            display: flex;
            align-content: flex-end;
            justify-content: space-between;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            padding: 10px;
            width: 100%;
            z-index: 999;
        }
        footer{
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
        .title, hr{
            margin: 0px;
        }
        .header1{
            width: 100%;
        }
        .photo_frame{
            border: 2px solid black;
            padding: 5px;
        }
        .staff_photo{
            height: 10px;
        }
        .td1{
            width: 85%
        }
        .td2{
            width: 15%;
        }
        .justify_text{
            text-align: justify;
        }
        .font_paragraph{
            font-size: 15px;
            margin: 0px;
        }
        .responsibilities{
            text-align: justify;
            margin-left: 30px
        }
        .projects_section{
            margin-left: 30px;
        }
        .experience_content, .projects_content{
            margin: 30px;
        }

        .hide{
            display: none;
        }
        /* .font_strong{
            font-weight: 500;
        } */
        /* td, tr{
            border: 1px solid red
        } */
    </style>
        
</head>
<body>
    
    <table class="header1">
        <tr>
            <td class="td1">
                <div>
                    <h2 class="title">{{ $applicant->name }}</h2>
                    <hr>
                    <h4 class="title">Senior Document Controller</h4>
                </div>
            </td>
            <td class="td2">
                <div class="photo_frame">
                    @if($applicant->photo_pass)
                    <img height="130px" src="{{ public_path('storage/' . $applicant->photo_pass) }}" alt="Applicant Photo">
                    @else
                    <img src="https://via.placeholder.com/100" alt="Default Photo">
                    @endif
                </div>
            </td>
        </tr>
    </table>
    <div class="career_summary">
        <h3 class="title">Career Summary</h3>
        <hr>
        <p class="justify_text font_paragraph">{{ $applicant->profile }}</p>
    </div>

    <div class="Education">
        <h3 class="title">Education</h3>
        <hr>
        <ul>
            <li>
                <p class="font_paragraph">
                    {{ $applicant->education->name_education }}
                </p>
            </li>
        </ul>
    </div>

    <div class="Training_and_certification">
        <h3 class="title">Training and Certification</h3>
        <hr>
        <ul>
            @foreach (explode('|', $applicant->certificates) as $certificate)
                <li>{{ trim($certificate) }}</li>
            @endforeach
        </ul>
    </div>

    <div class="Language">
        <h3 class="title">Language</h3>
        <hr>
        <table style="width: 100%">
            <tr>
                <th style="33%">
                    Language
                </th>
                <th style="33%">
                    Verbal
                </th>
                <th style="33%">
                    Writen
                </th>
            </tr>

            <tr>
                <td style="width: 33%"><p style="text-align: center">{{ $applicant->languages}}</p></td>
                <td style="width: 33%"><p style="text-align: center">advance</p></td>
                <td style="width: 33%"><p style="text-align: center">advance</p></td>
            </tr>

        </table>
    </div>

    <div class="experience">
        <h3 class="title">Experience</h3>
        <hr>
        <div>
            @if($applicant->workExperiences->isNotEmpty())
            @foreach($applicant->workExperiences as $experience)
                <div class="experience_content">
                    <table>
                    
                        <tr>
                            <td><strong><p class="font_paragraph">Date</p></strong></td>
                            <td>: <strong>{{ $experience->mulai }} - {{ $experience->selesai }}</strong></td>
                        </tr>
                        <tr>
                            <td><strong><p class="font_paragraph">Company</p></strong></td>
                            <td>: <strong>{{ $experience->name_company }}</strong></td>
                        </tr>
                        <tr>
                            <td><strong><p class="font_paragraph">Position</p></strong></td>
                            <td>: <strong>{{ $experience->role }}</strong></td>
                        </tr>
                        <tr>
                            <td><strong><p class="font_paragraph">Responsibilities</p></strong></td>
                            <td></td>
                        </tr>
                    
                    </table>
                    <div class="responsibilities">
                        <p class="font_paragraph description">{{ $experience->desc_kerja }}</p>
                    </div>
                </div>
            @endforeach
            @else
            <p>No work experience available.</p>
            @endif
            
        </div>
    </div>

    <div class="Projects">
        <h3 class="title">Projects</h3>
        <hr>
        <div class="projects_section">
            @if($applicant->Projects->isNotEmpty())
            @foreach($applicant->projects as $project)
                <table class="projects_content">
                    <tr>
                        <td><strong><p class="font_paragraph">Project</p></strong></td>
                        <td><p class="font_paragraph">: {{ $project->project_name }}</p></td>
                    </tr>
                    <tr class="hide">
                        <td><strong><p class="font_paragraph">Position</p></strong></td>
                        <td><p class="font_paragraph">: </p></td>
                    </tr>
                    <tr>
                        <td><strong><p class="font_paragraph">Period</p></strong></td>
                        <td><p class="font_paragraph">: {{ $project->mulai_project }} - {{ $project->selesai_project }}</p></td>
                    </tr>
                    <tr class="hide">
                        <td><strong><p class="font_paragraph">Location</p></strong></td>
                        <td><p class="font_paragraph">: </p></td>
                    </tr>
                    <tr>
                        <td><strong><p class="font_paragraph">Client</p></strong></td>
                        <td><p class="font_paragraph">: {{ $project->client }}</p></td>
                    </tr>
                </table>
            @endforeach
            @endif
        </div>
        
    </div>
    <footer>
        <hr>
    </footer>
    <header>
        <table class="header1">
            <tr>
                <td class="td1">
                    <div>
                        <h2 class="title">{{ $applicant->name }}</h2>
                        <hr>
                        <h4 class="title">Senior Document Controller</h4>
                    </div>
                </td>
                <td class="td2">
                    <div class="">                        
                        <img height="50px" src="{{ public_path('assets/logo-resindo.jpg') }}" alt="Applicant Photo">                                    
                    </div>
                </td>
            </tr>
        </table>
    </header>
    
</body>
</html>