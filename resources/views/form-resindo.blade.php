<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="{{asset('css/form-resindo.css')}}">
    <link rel="icon" src="{{asset('assets/ISOLOGO.png')}}">
    <script src="{{asset('js/vue.global.js')}}"></script>
    <title>Form - Resindo</title>
</head>

<body>

    @if($_POST)
    @dump($_POST);

    @endif

    <div class="container">
        <div class="header d-flex flex-lg-row flex-sm-column justify-content-between mb-5" style="background-image: url({{asset('assets/resindo-bg.png')}}); background-repeat: no-repeat; background-size: cover">
            <div class="overley p-5 d-flex justify-content-between align-items-center">
                <div class="logo flex-lg">
                    <img src="{{asset('assets/logo-resindo.jpg')}}" width="150px" alt="">
                </div>
          
            </div>
        </div>
        
      


        <form id="myForm" action="{{ route('kirimresindo') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="hidden_input">
               
                {{-- <input type="hidden" name="status" value="Applicant"> --}}
            </div>
            <div class="form_kontainer">
                <div class="row mb-5">
                    <div class="kiri col-md-7">
                        <div class="input">
                            <label for="name">Name<span class="important_input"> *</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" placeholder="Applicant Name" required>
                            @error('name')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="input">
                            <label for="email">Email<span class="important_input"> *</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" placeholder="Email" required>
                            @error('email')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="input">
                            <label for="number">Phone Number<span class="important_input"> *</span></label>
                            <input type="text" class="form-control @error('number') is-invalid @enderror" id="number" name="number" value="{{ old('number') }}" placeholder="Phone Number" required>
                            @error('number')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="input">
                            <label for="address">Citizenship<span class="important_input"> *</span></label>
                            <input class="form-control @error('address') is-invalid @enderror" id="address" name="address" value="{{ old('address') }}" placeholder="Domicile" required>
                            @error('address')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="input row">
                            <div class="pendidikan col-md-3">
                                <label for="education" class="form-label">Last Education<span class="important_input"> *</span></label>
                                <select id="education" name="education" class="form-control" onchange="updateEducationId(this)">
                                    <option value="">Choose Education</option>
                                    @foreach ($educations as $education)
                                    <option value="{{ $education->id }}">{{ $education->name_education }}</option>
                                    @endforeach
                                </select>
                                @error('education')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="jurusan col-md-9">
                                <div class="input">
                                    <label for="jurusan" class="form-label">Major<span class="important_input"> *</span></label>
                                    <input type="text" id="jurusan" name="jurusan" class="form-control" placeholder="Enter Major" required>
                                    <input type="hidden" id="education_id" name="education_id">
                                </div>
                            </div>
                        </div>



                        <div class="input">
                            <label for="profile">Profile<span class="important_input"> *</span></label>
                            <textarea class="form-control @error('profile') is-invalid @enderror" id="profile" name="profile" placeholder="describe yourself">{{ old('profile') }}</textarea>
                            @error('profile')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>


                    </div>
                    <div class="kanan col-md-5">

                        <div class="input">
                            <label for="profil_linkedin">LinkedIn Profile Link</label>
                            <input type="url" class="form-control @error('profil_linkedin') is-invalid @enderror" id="profil_linkedin" name="profil_linkedin" value="{{ old('profil_linkedin') }}" placeholder="Link Profile LinkedIn">
                            @error('profil_linkedin')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="input">
                            <label for="photo_pass" class="form-label">Upload Photo<span class="important_input"> *</span></label>
                            <input type="file" class="form-control @error('photo_pass') is-invalid @enderror" id="photo_pass" name="photo_pass" required>
                            @error('photo_pass')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="input row">
                            <div class="mbti col-md-6">
                                <label for="mbti">MBTI</label>
                                <select class="form-control @error('mbti') is-invalid @enderror" id="mbti" name="mbti">
                                    <option value="" disabled selected>Select MBTI</option>
                                    <option value="ISTJ">ISTJ -  Inspector</option>
                                    <option value="ISFJ">ISFJ -  Defender</option>
                                    <option value="INFJ">INFJ -  Advocate</option>
                                    <option value="INTJ">INTJ -  Architect</option>
                                    <option value="ISTP">ISTP -  Virtuoso</option>
                                    <option value="ISFP">ISFP -  Adventurer</option>
                                    <option value="INFP">INFP -  Mediator</option>
                                    <option value="INTP">INTP -  Logician</option>
                                    <option value="ESTP">ESTP -  Entrepeneur</option>
                                    <option value="ESFP">ESFP -  Entertainer</option>
                                    <option value="ENFP">ENFP -  Campaigner</option>
                                    <option value="ENTP">ENTP -  Debater</option>
                                    <option value="ESTJ">ESTJ -  Executive</option>
                                    <option value="ESFJ">ESFJ -  Consul</option>
                                    <option value="ENFJ">ENFJ -  Protagonist</option>
                                    <option value="ENTJ">ENTJ -  Commander</option>
                                </select>
                                @error('mbti')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>


                            <div class="iq col-md-6">
                                <label for="iq">IQ</label>
                                <input type="text" class="form-control @error('iq') is-invalid @enderror" id="iq" name="iq" value="{{ old('iq') }}" placeholder="IQ">
                                @error('iq')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="input">
                            <label for="experience_period">Work Experience Period<span class="important_input"> *</span></label>
                            <input type="text" class="form-control @error('experience_period') is-invalid @enderror" id="experience_period" name="experience_period" value="{{ old('experience_period') }}" placeholder="based on year">
                            @error('experience_period')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="input">
                            <label for="salary_expectation">Salary Expectation<span class="important_input"></span></label>
                            <input type="number" class="form-control @error('salary_expectation') is-invalid @enderror" id="salary_expectation" name="salary_expectation" value="{{ old('salary_expectation') }}" placeholder="Ex. 15000000">
                            @error('salary_expectation')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                       
                        <div class="input row">

                       
                        </div>



                    </div>
                </div>
                <div id="app" class="mt-5">

                    <div class="tengah">

                        <label for="skills" class="mb-1">Skills</label>
                        <div class="keahlian d-flex flex-grow-* row mb-3">

                            <div v-for="(skill, index) in skills" :key='index' class="input skills d-flex flex-grow-* col-md-3 row-sm-10">
                                <input type="text" class="form-control @error('skills.*') is-invalid @enderror" id="skills" name="skills[]" :placeholder="'skills ' + (index + 1)">
                                {{-- <textarea >{{ old('skills') }}</textarea> --}}
                                @error('skills.*')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                                <button @click="removeInput4(index)" class="btn  btn-danger">-</button>
                            </div>

                            <div class="button ms-1 col-md-1">
                                <button @click="addInput4" type="button" class="btn btn-secondary">+</button>
                            </div>

                        </div>


                        <div class="input achievement">

                            <label for="achievement" class="mb-1">Achievement</label>
                            <div class="achievement d-flex flex-grow-* row">
                                <div v-for="(achievement, index) in achievements" :key='index' class="input achievements d-flex flex-grow-* col-md-6 row-sm-10">
                                    <input type="text" class="form-control @error('achievement.*') is-invalid @enderror" id="achievement" name="achievements[]" :placeholder="'achievement ' + (index + 1)">
                                    @error('achievement.*')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    <button @click="removeInput5(index)" class="btn  btn-danger">-</button>
                                </div>
                                <div class="button ms-1 col">
                                    <button @click="addInput5" type="button" class="btn btn-secondary">+</button>
                                </div>
                            </div>

                        </div>

                        <div class="input certificate">
                            <label for="certificates">Certificate</label>
                            <div class="certificates d-flex flex-grow-* row">
                                <div v-for="(certificates, index) in certificates" :key='index' class="input certificatess d-flex flex-grow-* col-md-6 row-sm-10">
                                    <input type="text" class="form-control @error('certificates.*') is-invalid @enderror" id="certificates" name="certificates[]" :placeholder="'certificate ' + (index + 1)">
                                    @error('certificates.*')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    <button @click="removeInput6(index)" class="btn  btn-danger">-</button>
                                </div>
                                <div class="button ms-1 col">
                                    <button @click="addInput6" type="button" class="btn btn-secondary">+</button>
                                </div>
                            </div>
                        </div>

                    </div>


                    <div class="bawah">
                    <h1 style="margin-top: 30px">Languages Skills</h1>
                        <div class="language_kontainer">
                            <div class="language" v-for="(language, index) in language">
                                <div class="input language_name">
                                    <label class="form-label" for="language[]">Language</label>
                                    <input class="form-control" type="text" name="language[]" id="language[]">
                                    @error('language.*')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="input language_verbal">
                                    <label for="verbal[]" class="form-label">Verbal</label>
                                    <input type="verbal" name="verbal[]" id="verbal[]" class="form-control">
                                    @error('verbal.*')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="input language_writen">
                                    <label for="writen[]" class="form-label">Written</label>
                                    <input type="text" class="form-control" name="writen[]">
                                    @error('writen.*')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <button type="button" class="btn btn-danger" @click="removeInput7(index)">Delete</button>
                            </div>
                        </div>

                        <button type="button" class="btn btn-secondary mb-5 ms-4" @click="addInput7">Add</button>
                    </div>
                    
                        <h1>Work Experience <span class="important_input"> *</span></h1>
                        <div id="work_experience" class="work_experience" v-for='(experience, index) in experiences' :key='index'>

                            <div class="input company_name">
                                <label class="form-label" for="name_company[]">Company Name @{{index + 1}}</label>
                                <input class="form-control" name="name_company[]" type="text">
                                @error('role_name')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="input role_name">
                                <label class="form-label" for="role[]">Position Name @{{index + 1}}</label>
                                <input class="form-control" name="role[]" type="text">
                                @error('role.*')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="input date_kontainer">
                                <div class="date work_start">
                                    <label class="form-label" for="mulai[]">Start</label>
                                    <input class="form-control" type="date" name="mulai[]">
                                    @error('mulai.*')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="date work_end">
                                    <label class="form-label" for="selesai[]">End</label>
                                    <input class="form-control" type="date" name="selesai[]">
                                    @error('selesai.*')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="input job_description">
                                <label class="form-label" for="desc_kerja[]">Job Description @{{index + 1}}</label>
                                <textarea class="form-control @error('desc_kerja.*') is-invalid @enderror" name="desc_kerja[]" placeholder="Job Description" required></textarea>
                                @error('desc_kerja')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <button type="button" class="btn btn-danger" @click="removeInput1(index)">Delete</button>
                        </div>
                        <button type="button" class="btn btn-secondary mb-5 ms-4" @click="addInput1">Add</button>

                        <h1 style="margin-top: 30px">Project</h1>

                        <div id="Project" class="Project" v-for='(project, index) in projects' :key='index'>

                            <div class="input Project_name">
                                <label class="form-label" for="project_name[]">Project Name @{{index + 1}}</label>
                                <input class="form-control" name="project_name[]" type="text">
                                @error('project_name.*')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="input client_name">
                                <label class="form-label" for="client[]">Client @{{index + 1}}</label>
                                <input class="form-control" name="client[]" type="text">
                                @error('client.*')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="input date_kontainer">
                                <div class="date project_start">
                                    <label class="form-label" for="mulai_project[]">Start</label>
                                    <input class="form-control" type="date" name="mulai_project[]">
                                    @error('mulai_project.*')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="date project_end">
                                    <label class="form-label" for="selesai_project[]">End</label>
                                    <input class="form-control" type="date" name="selesai_project[]">
                                    @error('selesai_project.*')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                            </div>

                            <div class="input project_description">
                                <label class="form-label" for="desc_project[]">Project Description @{{index + 1}}</label>
                                <textarea class="form-control @error('desc_project.*') is-invalid @enderror" :id="'desc_project' + (index + 1)" name="desc_project[]" placeholder="Project Description"></textarea>
                            </div>

                            <button type="button" class="btn btn-danger" @click="removeInput2(index)">Delete</button>
                        </div>
                        <button type="button" class="btn btn-secondary ms-4" @click="addInput2">Add</button>

                        <h1 style="margin-top: 30px">Contacts References</h1>
                        <div class="references_kontainer">
                            <div class="references" v-for="(reference, index) in references">
                                <div class="input references_name">
                                    <label class="form-label" for="name_ref[]">Reference Name</label>
                                    <input class="form-control" type="text" name="name_ref[]" id="name_ref[]">
                                    @error('name_ref.*')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="input references_email">
                                    <label for="email_ref[]" class="form-label">Email</label>
                                    <input type="email" name="email_ref[]" id="email_ref[]" class="form-control">
                                    @error('reference_mail')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="input references_number">
                                    <label for="phone[]" class="form-label">Mobile Number</label>
                                    <input type="text" class="form-control" name="phone[]">
                                    @error('phone.*')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <button type="button" class="btn btn-danger" @click="removeInput3(index)">Delete</button>
                            </div>
                        </div>

                        <button type="button" class="btn btn-secondary mb-5 ms-4" @click="addInput3">Add</button>
                    </div>

                </div>

                <div class="submit_button mb-5 mt-5 ">
                    <button id="tombolSubmit" class="btn btn-success btn-lg" type="submit">
                        <p id="tulisanSubmit" style="margin: 0px">Submit</p>
                        <div id="loading" style="display: none">
                            <span class="spinner-border spinner-border-sm" aria-hidden="true"></span>
                            <span role="status">Loading...</span>
                        </div>
                    </button>
                </div>
            </div>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        const {
            createApp
        } = Vue
        createApp({
            data() {
                return {
                    experiences: [{
                        value: ''
                    }],
                    projects: [{
                        value: ''
                    }],
                    references: [{
                        value: ''
                    }],
                    skills: [{
                        value: ''
                    }],
                    achievements: [{
                        value: ''
                    }],
                    certificates: [{
                        value: ''
                    }],
                    language: [{
                        value: ''
                    }],

                }
            },
            methods: {
                addInput1() {
                    this.experiences.push({
                        value: ''
                    });
                },
                removeInput1(index) {
                    this.experiences.splice(index, 1);
                },

                addInput2() {
                    this.projects.push({
                        value: ''
                    });
                },
                removeInput2(index) {
                    this.projects.splice(index, 1);
                },

                addInput3() {
                    this.references.push({
                        value: ''
                    });
                },
                removeInput3(index) {
                    this.references.splice(index, 1);
                },
                addInput4() {
                    this.skills.push({
                        value: ''
                    });
                },
                removeInput4(index) {
                    this.skills.splice(index, 1);
                },
                addInput5() {
                    this.achievements.push({
                        value: ''
                    });
                },
                removeInput5(index) {
                    this.achievements.splice(index, 1);
                },
                addInput6() {
                    this.certificates.push({
                        value: ''
                    });
                },
                removeInput6(index) {
                    this.certificates.splice(index, 1);
                },
                addInput7() {
                    this.language.push({
                        value: ''
                    });
                },
                removeInput7(index) {
                    this.language.splice(index, 1);
                }
            }
        }).mount('#app')


        $(document).ready(function() {
            //fungsi loading di tombol submit
            $('#myForm').on('submit', function() {

                $('#tulisanSubmit').hide();
                $('#loading').show();
                $('#tombolSubmit').prop('disabled', true);
            })
            //=============================================

            $('#education').on('change', function() {
                var educationId = $(this).val();
                if (educationId) {
                    $.ajax({
                        url: '/get-jurusan/' + educationId,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $('#jurusan').empty();
                            $('#jurusan').append('<option value="">Pilih Jurusan</option>');
                            $.each(data, function(key, value) {
                                $('#jurusan').append('<option value="' + value.id + '">' + value.name_jurusan + '</option>');
                            });
                        }
                    });
                } else {
                    $('#jurusan').empty();
                    $('#jurusan').append('<option value="">Pilih Jurusan</option>');
                }
            });
        });
    </script>
    
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.8/dist/trix.css"> {{-- library untuk text editor --}}
    <script type="text/javascript" src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script> {{-- library untuk text editor --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>


</body>

</html>