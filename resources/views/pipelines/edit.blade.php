@extends('adminlte::page')

@section('title', 'Edit Applicant')

@section('content_header')
<h1 class="m-0 text-dark">Edit Applicant</h1>
<link rel="stylesheet" href="{{asset('css/vacancy.form.css')}}">
<script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
@stop

@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Form Edit Applicant</h3>
            </div>

            <div class="card-body">
                <form action="{{ route('pipelines.update', $applicant->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="bagian_atas row g-5">
                        <div class="kiri col-md-6">
                            <!-- Name -->
                            <div class="form-group row">
                                <label for="name">Name</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $applicant->name) }}" placeholder="Nama Applicant" required>
                                @error('name')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div> 

                            <!-- Address -->
                            <div class="form-group row">
                                <label for="address">domicile</label>
                                <input class="form-control @error('address') is-invalid @enderror" id="address" name="address" value="{{ old('address', $applicant->address) }}" placeholder="Domicile" required>
                                @error('address')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="form-group row">
                                <label for="email">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $applicant->email) }}" placeholder="Email" required>
                                @error('email')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="education row">

                                <!-- pendidikan -->
                            <div class="form-group col-md-3">
                                <label for="education" class="form-label" >Last Education</label>
                                <select id="education" name="education" class="form-control">
                                    <option value="">Choose Education</option>
                                    @foreach ($educations as $education)
                                    <option value="{{ $education->id }}" {{ $applicant->education_id == $education->id ? 'selected' : ''}}>
                                        {{ $education->name_education }}</option>
                                    @endforeach
                                </select>
                            </div>


                            <div class="form-group">
                                <label for="jurusan">Major</label>
                                <input type="text" class="form-control @error('jurusan') is-invalid @enderror" 
                                id="jurusan" name="jurusan" 
                                value="{{ old('jurusan', $applicant->jurusan->name_jurusan ?? '') }}" 
                                placeholder="Enter Major" required>

                                @error('jurusan')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            </div>

                            <!--jurusan -->
                            
                   

                            <!-- Photo Pass -->
                            <div class="form-group row">
                                <label for="photo_pass" class="form-label">Upload Photo</label>
                                <input type="file" class="form-control @error('photo_pass') is-invalid @enderror" id="photo_pass" name="photo_pass">
                                @error('photo_pass')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                                @if ($applicant->photo_pass)
                                <img src="{{ asset('storage/' . $applicant->photo_pass) }}" alt="Applicant Photo" class="img-thumbnail mt-2" style="width: 100px;">
                                @endif
                            </div>

                            <!-- Salary Expectation -->
                            <div class="form-group">
                                <label for="salary_expectation">Salary Expectation</label>
                                <input type="number" class="form-control @error('salary_expectation') is-invalid @enderror" id="salary_expectation" name="salary_expectation" value="{{ old('salary_expectation', $applicant->salary_expectation) }}" placeholder="Ekspektasi Gaji" required>
                                @error('salary_expectation')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Profile -->
                            <div class="form-group">
                                <label for="profile">Profile</label>
                                <textarea class="form-control @error('profile') is-invalid @enderror" id="profile" name="profile" placeholder="Profil Diri">{{ old('profile', $applicant->profile) }}</textarea>
                                @error('profile')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                        </div>

                        <div class="kanan col-md-5">
                            
                            <!-- Job Selection -->
                            <div class="form-group row">
                                <label for="job_id">Choose Job</label>
                                <select class="form-control @error('job_id') is-invalid @enderror" id="job_id" name="job_id">
                                    <option value="">Choose Job</option>
                                    @foreach ($jobs as $job)
                                    <option value="{{ $job->id }}" {{ old('job_id', $applicant->job_id) == $job->id ? 'selected' : '' }}>
                                        {{ $job->job_name }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('job_id')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Number -->
                            <div class="form-group row">
                                <label for="number">Phone Number</label>
                                <input type="text" class="form-control @error('number') is-invalid @enderror" id="number" name="number" value="{{ old('number', $applicant->number) }}" placeholder="Phone Number" required>
                                @error('number')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- LinkedIn Profile -->
                            <div class="form-group row">
                                <label for="profil_linkedin">Link Profile LinkedIn</label>
                                <input type="url" class="form-control @error('profil_linkedin') is-invalid @enderror" id="profil_linkedin" name="profil_linkedin" value="{{ old('profil_linkedin', $applicant->profil_linkedin) }}" placeholder="Link Profile LinkedIn">
                                @error('profil_linkedin')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
  

                            <!-- Experience Period -->
                            <div class="form-group row">
                                <label for="experience_period">Work Experience (Periode)</label>
                                <input type="text" class="form-control @error('experience_period') is-invalid @enderror" id="experience_period" name="experience_period" value="{{ old('experience_period', $applicant->experience_period) }}" placeholder="Pengalaman Kerja">
                                @error('experience_period')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Languages -->
                            <div class="form-group">
                                <label for="languages">Languages</label>
                                <input type="text" class="form-control @error('languages') is-invalid @enderror" id="languages" name="languages" value="{{ old('languages', $applicant->languages) }}" placeholder="Bahasa yang dikuasai">
                                @error('languages')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="row col-md-6">
                                <div class="col-md-6">
                                    <!-- MBTI -->
                                    <div class="form-group">
                                    <label for="mbti">MBTI</label>
                                    <select class="form-control @error('mbti') is-invalid @enderror" id="mbti" name="mbti">
                                        <option value="" disabled {{ old('mbti', $applicant->mbti) ? '' : 'selected' }}>Select MBTI</option>
                                        <option value="ISTJ" {{ old('mbti', $applicant->mbti) == 'ISTJ' ? 'selected' : '' }}>ISTJ - Inspector</option>
                                        <option value="ISFJ" {{ old('mbti', $applicant->mbti) == 'ISFJ' ? 'selected' : '' }}>ISFJ - Defender</option>
                                        <option value="INFJ" {{ old('mbti', $applicant->mbti) == 'INFJ' ? 'selected' : '' }}>INFJ - Advocate</option>
                                        <option value="INTJ" {{ old('mbti', $applicant->mbti) == 'INTJ' ? 'selected' : '' }}>INTJ - Architect</option>
                                        <option value="ISTP" {{ old('mbti', $applicant->mbti) == 'ISTP' ? 'selected' : '' }}>ISTP - Virtuoso</option>
                                        <option value="ISFP" {{ old('mbti', $applicant->mbti) == 'ISFP' ? 'selected' : '' }}>ISFP - Adventurer</option>
                                        <option value="INFP" {{ old('mbti', $applicant->mbti) == 'INFP' ? 'selected' : '' }}>INFP - Mediator</option>
                                        <option value="INTP" {{ old('mbti', $applicant->mbti) == 'INTP' ? 'selected' : '' }}>INTP - Logician</option>
                                        <option value="ESTP" {{ old('mbti', $applicant->mbti) == 'ESTP' ? 'selected' : '' }}>ESTP - Entrepeneur</option>
                                        <option value="ESFP" {{ old('mbti', $applicant->mbti) == 'ESFP' ? 'selected' : '' }}>ESFP - Entertainer</option>
                                        <option value="ENFP" {{ old('mbti', $applicant->mbti) == 'ENFP' ? 'selected' : '' }}>ENFP - Campaigner</option>
                                        <option value="ENTP" {{ old('mbti', $applicant->mbti) == 'ENTP' ? 'selected' : '' }}>ENTP - Debater</option>
                                        <option value="ESTJ" {{ old('mbti', $applicant->mbti) == 'ESTJ' ? 'selected' : '' }}>ESTJ - Executive</option>
                                        <option value="ESFJ" {{ old('mbti', $applicant->mbti) == 'ESFJ' ? 'selected' : '' }}>ESFJ - Consul</option>
                                        <option value="ENFJ" {{ old('mbti', $applicant->mbti) == 'ENFJ' ? 'selected' : '' }}>ENFJ - Protagonist</option>
                                        <option value="ENTJ" {{ old('mbti', $applicant->mbti) == 'ENTJ' ? 'selected' : '' }}>ENTJ - Commander</option>
                                    </select>
                                    @error('mbti')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                </div>
        
                                <div class="col-md-6">
                                    <!-- IQ -->
                                    <div class="form-group">
                                        <label for="iq">IQ</label>
                                        <input type="text" class="form-control @error('iq') is-invalid @enderror" id="iq" name="iq" value="{{ old('iq', $applicant->iq) }}" placeholder="IQ">
                                        @error('iq')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
        
                    <div class="mulitple-section" id="app">
                            <div class="tengah">

                                <label for="skills" class="mb-1">Skills</label>
                                <div class="keahlian d-flex flex-grow-* row mb-3">
                                    <div v-for="(skill, index) in skills" :key='index' class="input skills d-flex flex-grow-* col-md-3 row-sm-10">
                                        <input type="text" class="form-control @error('skills.*') is-invalid @enderror" id="skills" name="skills[]" :placeholder="'skills' + (index + 1)" v-model="skills[index]">
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
                                            <input type="text" class="form-control @error('achievement.*') is-invalid @enderror" id="achievement" name="achievements[]" placeholder="Prestasi" v-model="achievements[index]">
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
                                        <div v-for="(certificate, index) in certificates" :key='index' class="input certificates d-flex flex-grow-* col-md-6 row-sm-10">
                                            <input type="text" class="form-control @error('certificates.*') is-invalid @enderror" id="certificates" name="certificates[]"  placeholder="Certificate" v-model="certificates[index]">
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

                            <h1>Work Experience</h1>
                            <div  id="work_experience" class="work_experience" v-for='(experience, index) in experiences' :key='index'>
                                <div class="">
                                    <input type="hidden" name="experience_id" v-model="experience.id">
                                    <input type="hidden" name="applicant_id" value="{{$applicant->id}}">
                                </div>
                                <div class="input company_name">
                                    <label class="form-label" for="name_company[]">Company Name @{{index + 1}}</label>
                                    <input class="form-control" name="name_company[]" type="text" v-model="experience.name_company">
                                    @error('role_name')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="input role_name">
                                    <label class="form-label" for="role[]">Position Name @{{index + 1}}</label>
                                    <input class="form-control" name="role[]" type="text" v-model="experience.role">
                                    @error('role.*')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="input date_kontainer">
                                    <div class="date work_start">
                                        <label class="form-label" for="mulai[]">Start</label>
                                        <input class="form-control" type="date" name="mulai[]" v-model="experience.mulai">
                                        @error('mulai.*')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                
                                    <div class="date work_end">
                                        <label class="form-label" for="selesai[]">End</label>
                                        <input class="form-control" type="date" name="selesai[]" v-model="experience.selesai">
                                        @error('selesai.*')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="input job_description">
                                    <label class="form-label" for="desc_kerja[]">Job Description @{{index + 1}}</label>
                                    <textarea class="form-control @error('desc_kerja.*') is-invalid @enderror" name="desc_kerja[]" placeholder="Deskripsi Pekerjaan" required v-model="experience.desc_kerja"></textarea>
                                    {{-- <input class="trix-editor" :id="'desc_kerja' + (index + 1)" name="desc_kerja[]" type="hidden">
                                    <trix-editor :input="'desc_kerja' + (index + 1)"></trix-editor> --}}
                                    @error('desc_kerja')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <button type="button" class="btn btn-danger" @click="removeInput1(index)">Delete</button>
                            </div>
                            <button type="button" class="btn btn-secondary mb-5 ms-4" @click="addInput1" >Add</button> 
                
                        
                        <!-- Project Section -->


                        <h1 style="margin-top: 30px">Project</h1>
                        
                        <div id="Project" class="Project" v-for='(project, index) in projects' :key='index'>
                            <div class="">
                                <input type="hidden" name="project_id" v-model="project.id">
                                <input type="hidden" name="applicant_id" value="{{$applicant->id}}">
                            </div>
                            <div class="input Project_name">
                                <label class="form-label" for="project_name[]" >Project Name @{{index + 1}}</label>
                                <input class="form-control" name="project_name[]" type="text" v-model="project.project_name">
                                @error('project_name.*')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="input client_name">
                                <label class="form-label" for="client[]">Client @{{index + 1}}</label>
                                <input class="form-control" name="client[]" type="text" v-model="project.client">
                                @error('client.*')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- <div class="input date_kontainer">
                                <div class="date project_start">
                                    <label class="form-label" for="mulai_project[]">Start</label>
                                    <input class="form-control" type="date" name="mulai_project[]" v-model="project.mulai_project">
                                    @error('mulai_project.*')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
            
                                <div class="date project_end">
                                    <label class="form-label" for="selesai_project[]">End</label>
                                    <input class="form-control" type="date" name="selesai_project[]" v-model="project.selesai_project">
                                    @error('selesai_project.*')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                            </div> --}}

                            <div class="input project_description">
                                <label class="form-label" for="desc_project[]">Project Description @{{index + 1}}</label>
                                <textarea class="form-control @error('desc_project.*') is-invalid @enderror" :id="'desc_project' + (index + 1)"  name="desc_project[]" v-model="project.desc_project"></textarea>
                                {{-- <input class="trix-editor" :id="'desc_project' + (index + 1)"  name="desc_project[]" type="hidden">
                                <trix-editor :input="'desc_project' + (index +1)"></trix-editor> --}}
                            </div>

                            <button type="button" class="btn btn-danger" @click="removeInput2(index)">Delete</button>
                        </div>
                            <button type="button" class="btn btn-secondary ms-4" @click="addInput2" >Add</button> 

                        
                        <!-- Reference Section -->


                        <h1>Contact References</h1>
                        <div class="references_kontainer">
                            <div class="references" v-for="(reference, index) in references">
                                <div class="">
                                    <input type="hidden" name="reference_id" v-model="reference.id">
                                    <input type="hidden" name="applicant_id" value="{{$applicant->id}}">
                                </div>
                                <div class="input references_name" >
                                    <label class="form-label" for="name_ref[]">Reference Name</label>
                                    <input class="form-control" type="text" name="name_ref[]" id="name_ref[]" v-model="reference.name_ref">
                                    @error('name_ref.*')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="input references_email">
                                    <label for="email_ref[]" class="form-label">Email</label>
                                    <input type="email" name="email_ref[]" id="email_ref[]" class="form-control" v-model="reference.email_ref">
                                    @error('reference_mail')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="input references_number">
                                    <label for="phone[]" class="form-label">Mobile Number</label>
                                    <input type="text" class="form-control" name="phone[]" v-model="reference.phone">
                                    @error('phone.*')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <button type="button" class="btn btn-danger" @click="removeInput3(index)">Delete</button>
                            </div>
                        </div>

                        <button type="button" class="btn btn-secondary mb-5 ms-4" @click="addInput3" >Add</button> 



                    </div>

                    

                    <button type="submit" class="btn btn-primary">Simpan Applicant</button>
                    <a href="{{ route('pipelines.index') }}" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </div>
</div>

@stop

@section('js')

<script>
    const {createApp} = Vue
    createApp({
        data(){
            return {
                experiences : [
                    {
                        id: '',
                        applicant_id: '',
                        role: '',
                        name_company: '',
                        desc_kerja: '',
                        mulai: '',
                        selesai: ''
                    }
                ],
                projects : [
                    {
                        id: '',
                        applicant_id: '',
                        project_name: '',
                        desc_project: '',
                        client: '',
                        mulai_project: '',
                        selesai_project: '',  
                    }
                ],
                references : [
                    {
                        id: '',
                        applicant_id: '',
                        name_ref: '',
                        phone: '',
                        email_ref: ''
                    }
                ],
                skills : [
                    ''
                ],
                achievements : [
                    ''
                ],
                certificates : [
                    ''
                ]
            }
        },
        mounted() {
            this.fetchData();
        },
        methods: {

            fetchData() {
                fetch('{{route('edit_api', ['id' => $applicant->id ])}}')
                .then(response => response.json())
                .then(data => {
                    this.experiences = data.work_experiences;
                    this.projects = data.projects;
                    this.references = data.references;
                    this.skills = data.skills.split("|");
                    this.achievements = data.achievement.split("|");
                    this.certificates = data.certificates.split("|");
                    console.log(this.skills);
                    console.log(this.achievements);
                    console.log(this.experiences);
                    console.log(this.projects);
                    console.log(this.references);
                })
            },
            addInput1() {
                this.experiences.push(
                    {
                        id: '',
                        applicant_id: '',
                        role: '',
                        name_company: '',
                        desc_kerja: '',
                        mulai: '',
                        selesai: ''
                }   
            )
            console.log(this.experiences);
        
        },
            removeInput1(index) {
                this.experiences.splice(index, 1);
            },
            addInput2() {
                this.projects.push(
                    {
                        id: '',
                        applicant_id: '',
                        project_name: '',
                        desc_project: '',
                        client: '',
                        mulai_project: '',
                        selesai_project: '',                        
                }
            )},
            removeInput2(index) {
                this.projects.splice(index, 1);
            },
            addInput3() {
                this.references.push(
                    {
                        id: '',
                        applicant_id: '',
                        name_ref: '',
                        phone: '',
                        email_ref: ''
                }
            )},
            removeInput3(index) {
                this.references.splice(index, 1);
            },
            addInput4() {
                this.skills.push('');
                console.log(this.skills);
            },
            removeInput4(index) {
                this.skills.splice(index, 1);
            },
            addInput5() {
                this.achievements.push('');
            },
            removeInput5(index) {
                this.achievements.splice(index, 1);
            },
            addInput6() {
                this.certificates.push('');
            },
            removeInput6(index) {
                this.certificates.splice(index, 1);
            }
        }
    }).mount('#app')


      function updateEducationId(select) {
        document.getElementById('education_id').value = select.value;
    }
</script>


@stop