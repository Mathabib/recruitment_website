@extends('applicants_page.layouts.master')
@section('content')

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
         {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif


<div>
    <div class="card position-relative">
        <div class="card-body">
            <div class="d-flex align-items-center flex-sm-row flex-column">
                <div class="me-3">
                    <img class="rounded-circle" width="110px" height="110px" src="{{ asset('storage/'.$applicant->photo_pass) }}" alt="" >
                </div>
                <div class="">
                    <p class="fs-2">{{ $applicant->name }}</p>
                    <p>{{ $applicant->profile }}</p>
                </div>

            </div>
            <div data-bs-toggle="modal" data-bs-target="#profilesection1" class="border rounded p-2 bg-danger-subtle" style="cursor: pointer; position: absolute; top: 10px; right: 10px;">
                <i class="fas fa-pen"></i>
            </div>
        </div>
    </div>

    <div class="card mt-5 ">
        <div class="card-body">
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                    <button class="nav-link  active" data-bs-toggle="tab" data-bs-target="#Profile" type="button" role="tab" >Personal Data</button>
                </li>
                <li class="nav-item">
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#Experience" type="button" role="tab" id="experience_nav_button">Experience</button>
                </li>
                <li class="nav-item">
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#Project" type="button" role="tab" id="project_nav_button">Project</button>
                </li>
                <li class="nav-item">
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#Reference" type="button" role="tab" id="reference_nav_button">Contact Reference</button>
                </li>
            </ul>
        </div>

        <div class="tab-content">
            <div role="tabpanel" class="p-4 tab-pane fade show  active" id="Profile">
                <div class="position-relative">
                    <div class="row">
                        <div class="col-md-4">
                            <p class="fw-bold fs-6 m-0 p-0" style="color: #800">Name</p>
                            <p class="m-0 p-0">{{ $applicant->name }}</p>
                        </div>
                        <div class="col-md-4">
                            <p class="fw-bold fs-6 m-0 p-0" style="color: #800">Email</p>
                            <p class="m-0 p-0">{{ $applicant->email }}</p>
                        </div>
                        <div class="col-md-4">
                            <p class="fw-bold fs-6 m-0 p-0" style="color: #800">Phone</p>
                            <p class="m-0 p-0">{{ $applicant->number }}</p>
                        </div>
                        <div class="col-md-4">
                            <p class="fw-bold fs-6 m-0 p-0" style="color: #800">Address</p>
                            <p class="m-0 p-0">{{ $applicant->address }}</p>
                        </div>
                        <div class="col-md-4">
                            <p class="fw-bold fs-6 m-0 p-0" style="color: #800">Profil Linkdin</p>
                            <p class="m-0 p-0">{{ $applicant->profil_linkedin }}</p>
                        </div>
                        <div class="col-md-4">
                            <p class="fw-bold fs-6 m-0 p-0" style="color: #800">Experience Period</p>
                            <p class="m-0 p-0">{{ $applicant->experience_period }}</p>
                        </div>
                        <div class="col-md-4">
                            <p class="fw-bold fs-6 m-0 p-0" style="color: #800">Language</p>
                            <p class="m-0 p-0">{{ $applicant->languages }}</p>
                        </div>
                        <div class="col-md-4">
                            <p class="fw-bold fs-6 m-0 p-0" style="color: #800">MBTI</p>
                            <p class="m-0 p-0">{{ $applicant->mbti }}</p>
                        </div>
                        <div class="col-md-4">
                            <p class="fw-bold fs-6 m-0 p-0" style="color: #800">IQ</p>
                            <p class="m-0 p-0">{{ $applicant->iq }}</p>
                        </div>
                        <div class="col-md-4">
                            <p class="fw-bold fs-6 m-0 p-0" style="color: #800">Salary Expectation</p>
                            <p class="m-0 p-0">{{ $salary_expectation }}</p>
                        </div>
                        <div class="col-md-4">
                            <p class="fw-bold fs-6 m-0 p-0" style="color: #800">Salary Current</p>
                            <p class="m-0 p-0">{{ $salary_current }}</p>
                        </div>
                    </div>
                    <div data-bs-toggle="modal" data-bs-target="#profilesection2" class="border rounded p-2 bg-danger-subtle" style="cursor: pointer; position: absolute; top: 0px; right: 0px;">
                        <i class="fas fa-pen"></i>
                    </div>
                </div>
                <hr>
                <div>
                    <div class="d-flex justify-content-between">
                        <h3>Skills</h3>
                        <div data-bs-toggle="modal" data-bs-target="#profilesection3" class="border rounded p-2 bg-danger-subtle" style="cursor: pointer">
                            <i class="fas fa-pen"></i>
                        </div>
                    </div>
                    <div d-flex>
                        @foreach ($skills as $skill)
                            {{-- <div class="badge rounded-pill" style="background: #800"><h5>{{ $skill }}</h5></div> --}}
                            <p class="badge rounded-pill fw-bolder fs-6" style="background: #800;">{{ $skill }}</p>
                        @endforeach
                    </div>

                    <hr>
                   <div>
                        <div class="d-flex justify-content-between mb-3">
                            <h3>Achievement :</h3>
                            <div id="add-achievement-btn" class="border rounded p-2 bg-success-subtle" style="cursor: pointer;">
                            <i class="fas fa-plus"></i>
                            </div>
                        </div>

                        <!-- Daftar Achievement -->
                        <ul id="achievement-list" class="list-unstyled">
                            @foreach ($achievements as $achievement)
                            <li>
                                <div class="alert alert-danger d-flex justify-content-between align-items-center" role="alert">
                                <span class="achievement-text">{{ $achievement }}</span>
                                <div class="d-flex gap-2">
                                    <i class="fas fa-pen edit-achievement" style="cursor: pointer;"></i>
                                    <i class="fas fa-trash-alt delete-achievement" style="cursor: pointer;"></i>
                                </div>
                                </div>
                            </li>
                            @endforeach
                        </ul>

                        <!-- Hidden input untuk dikirim -->
                        <form action="{{ route('applicant_page.cvsection.profiledata4') }}" method="POST">
                            @csrf
                            <input type="hidden" name="achievement" id="achievement" value="{{ implode('|', $achievements ?? []) }}">
                            <button type="submit" class="btn btn-danger mt-3">Save Changes</button>
                        </form>
                    </div>


                    <hr>
                    <div>
                        <div class="d-flex justify-content-between mb-3">
                            <h3>Certificate :</h3>
                            <div id="add-certificate-btn" class="border rounded p-2 bg-success-subtle" style="cursor: pointer;">
                            <i class="fas fa-plus"></i>
                            </div>
                        </div>

                        <!-- Daftar Certificate -->
                        <ul id="certificate-list" class="list-unstyled">
                            @foreach ($certificates as $certificate)
                            <li>
                                <div class="alert alert-danger d-flex justify-content-between align-items-center" role="alert">
                                <span class="certificate-text">{{ $certificate }}</span>
                                <div class="d-flex gap-2">
                                    <i class="fas fa-pen edit-certificate" style="cursor: pointer;"></i>
                                    <i class="fas fa-trash-alt delete-certificate" style="cursor: pointer;"></i>
                                </div>
                                </div>
                            </li>
                            @endforeach
                        </ul>

                        <!-- Hidden input untuk dikirim ke server -->
                        <form action="{{ route('applicant_page.cvsection.profiledata5') }}" method="POST">
                            @csrf
                            <input type="hidden" name="certificates" id="certificates" value="{{ implode('|', $certificates ?? []) }}">
                            <button type="submit" class="btn btn-danger mt-3">Save Changes</button>
                        </form>
                    </div>

                </div>
            </div>

            {{-- EXPERIENCE ======= --}}
            <div role="tabpanel" class="p-4 tab-pane fade show" id="Experience">
                {{-- <h1>Applicant Experience</h1> --}}
                <div class="">
                   <div class="d-flex justify-content-between mb-3">
                        <div></div>
                        <div data-bs-toggle="modal" data-bs-target="#addExperience" id="add-certificate-btn" class="border rounded p-2 bg-success-subtle" style="cursor: pointer;">
                            <i class="fas fa-plus"></i>
                        </div>
                   </div>

                    @foreach ($experiences as $experience)
                    <div class="card mt-3 border-danger-subtle">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <p style="color: #800" class="fw-bolder fs-4">
                                    {{ $experience->role }}
                                </p>
                                <div class="d-flex gap-1" style="">
                                    <div style="height: 40px; width: 40px" id="add-certificate-btn" class="border rounded p-2 bg-warning-subtle d-flex align-items-center justify-content-center" style="cursor: pointer;">
                                        <i class="fas fa-pen edit-certificate experienceEdit" data-bs-toggle="modal" data-bs-target="#experiencemodal" style="cursor: pointer;" data-url="{{ route('applicant_page.cvsection.projectEdit') }}" onclick="getExperience({{ json_encode($experience) }})" ></i></span>
                                    </div>
                                    <div style="height: 40px; width: 40px" id="add-certificate-btn" class="border rounded p-2 bg-danger-subtle d-flex align-items-center justify-content-center" style="cursor: pointer;">
                                        <a onclick="return confirm('are you sure want delete ?')" class="text-dark" href="{{ route('applicant_page.cvsection.experienceDelete', $experience->id) }}"><i class="fas fa-trash-alt delete-certificate" style="cursor: pointer;"></i></a>
                                    </div>
                                </div>
                            </div>

                            <p style="color: #800" class="fw-bolder fs-5">
                                {{ $experience->name_company }}
                            </p>
                            <div>
                                <p>{{ \Carbon\Carbon::parse($experience->mulai)->format('M Y') }} -
                                    {{ $experience->present == 'present' ? 'Present' : \Carbon\Carbon::parse($experience->selesai)->format('M Y')}}
                                </p>
                            </div>
                            <button class="btn btn-outline-danger mb-3" type="button" data-bs-toggle="collapse" data-bs-target="#experience{{ $experience->id }}" aria-expanded="false" aria-controls="collapseExample">
                                Description
                            </button>
                            <div class="collapse" id="experience{{ $experience->id }}">
                                <div class="card card-body">
                                    {!! $experience->desc_kerja !!}
                                </div>
                            </div>
                        </div>

                    </div>
                    @endforeach
                </div>
            </div>

            {{-- PROJECT ====== --}}
            <div role="tabpanel" class="p-4 tab-pane fade show" id="Project">
                {{-- <h1>Applicant Project</h1> --}}
                <div class="d-flex justify-content-between mb-3">
                    <div></div>
                    <div onclick="addProject()" data-url="{{ route('applicant_page.cvsection.projectAdd') }}" data-bs-toggle="modal" data-bs-target="#editProject" id="add-project-btn" class="border rounded p-2 bg-success-subtle" style="cursor: pointer;">
                        <i class="fas fa-plus"></i>
                    </div>
                </div>
                <div>
                    @foreach ($projects as $project)
                        <div class="card mt-3 border-danger-subtle">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <p style="color: #800" class="fw-bolder fs-4">{{ $project->project_name }}</p>
                                    <div class="d-flex gap-1" style="">
                                        <div style="height: 40px; width: 40px" id="edit_project_btn" data-url="{{ route('applicant_page.cvsection.projectEdit') }}" class="border rounded p-2 bg-warning-subtle d-flex align-items-center justify-content-center" style="cursor: pointer;">
                                            <i class="fas fa-pen edit-certificate projectEdit project_edit_btn" data-bs-toggle="modal" data-bs-target="#editProject" style="cursor: pointer;" onclick="getProject({{ json_encode($project) }})" ></i>
                                        </div>
                                        <div style="height: 40px; width: 40px" id="" class="border rounded p-2 bg-danger-subtle d-flex align-items-center justify-content-center" style="cursor: pointer;">
                                            <a class="text-dark" onclick="return confirm('are you sure want delete this ? ')" href="{{ route('applicant_page.cvsection.projectDelete', $project->id) }}"><i class="fas fa-trash-alt delete-certificate" style="cursor: pointer;"></i></a>
                                        </div>
                                    </div>
                                </div>

                                <p style="color: #800" class="fw-bolder">{{ $project->client }}</p>

                                <button class="btn btn-outline-danger mb-3" type="button" data-bs-toggle="collapse" data-bs-target="#project{{ $project->id }}" aria-expanded="false" aria-controls="collapseExample">
                                    Description
                                </button>
                                <div class="collapse" id="project{{ $project->id }}">
                                    <div class="card card-body">
                                        {!! $project->desc_project !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- REFERENCE ========== --}}
            <div role="tabpanel" class="p-4 tab-pane fade show" id="Reference">
                <div>
                    <div class="d-flex justify-content-between mb-3">
                        <div></div>
                        <div onclick="addReference()" id="add-reference-btn" data-url="{{ route('applicant_page.cvsection.referenceAdd') }}" data-bs-toggle="modal" data-bs-target="#referenceModal"  class="border rounded p-2 bg-success-subtle" style="cursor: pointer;">
                            <i class="fas fa-plus"></i>
                        </div>
                    </div>
                    @foreach ($references as $reference)
                        <div class="card mt-4">
                            <div class="card-body position-relative">
                                <div class="d-flex gap-1" style="position: absolute; top: 10px; right: 10px;">
                                    <div style="height: 40px; width: 40px" id="edit-reference-btn" data-url="{{ route('applicant_page.cvsection.referenceEdit') }}" class="border rounded p-2 bg-warning-subtle d-flex align-items-center justify-content-center" style="cursor: pointer;">
                                        <i class="fas fa-pen edit-certificate referenceEdit reference_edit_btn" data-bs-toggle="modal" data-bs-target="#referenceModal" style="cursor: pointer;" onclick="getReference({{ json_encode($reference) }})" ></i>
                                    </div>
                                    <div style="height: 40px; width: 40px" id="" class="border rounded p-2 bg-danger-subtle d-flex align-items-center justify-content-center" style="cursor: pointer;">
                                        <a class="text-dark" onclick="return confirm('are you sure want delete this ? ')" href="{{ route('applicant_page.cvsection.referenceDelete', $reference->id) }}"><i class="fas fa-trash-alt delete-certificate" style="cursor: pointer;"></i></a>
                                    </div>
                                </div>
                                <table>
                                    <tr>
                                        <td class="fw-bolder" style="color: #800">Name  </td>
                                        <td>: </td>
                                        <td>{{ $reference->name_ref }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bolder" style="color: #800">Email </td>
                                        <td>: </td>
                                        <td>{{ $reference->email_ref }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bolder" style="color: #800">Phone </td>
                                        <td>: </td>
                                        <td>{{ $reference->phone }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

    </div>

</div>

{{-- ===================== --}}
{{-- ====== MODALSS ====== --}}
{{-- ===================== --}}

{{-- ===========PROFILE============== --}}

{{-- ==1== --}}
<div class="modal fade" id="profilesection1" tabindex="-1" aria-labelledby="profilesection1Label" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
    <form action="{{ route("applicant_page.cvsection.profiledata1") }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="modal-body">
            <input type="hidden" name="applicant_id" value="{{ $applicant->id }}">
            <div>
                <label class="form-label" for="name">Name</label>
                <input class="form-control" type="text" name="name" value="{{ old('name', $applicant->name) }}">
            </div>
            <div>
                <label class="form-label" for="photo_pass">Photo</label>
                <input class="form-control" type="file" name="photo_pass">
            </div>
            <div>
                <label class="form-label" for="profile">Headline</label>
                <textarea class="form-control" name="profile" id="" rows="5">
                    {{ old('profile', $applicant->profile) }}
                </textarea>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-danger">Save changes</button>
        </div>
      </form>
    </div>
  </div>
</div>

{{-- ===2== --}}
<div class="modal fade" id="profilesection2" tabindex="-1" aria-labelledby="profilesection2Label" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
    <form action="{{ route("applicant_page.cvsection.profiledata2") }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="modal-body">
            <input type="hidden" name="applicant_id" value="{{ $applicant->id }}">
            <div>
                <label class="form-label" for="name">Name</label>
                <input class="form-control" type="text" name="name" value="{{ old('name', $applicant->name) }}">
            </div>
            <div>
                <label class="form-label" for="email">Email</label>
                <input class="form-control" type="text" name="email" value="{{ old('email', $applicant->email) }}">
            </div>
            <div>
                <label class="form-label" for="number">Phone</label>
                <input class="form-control" type="text" name="number" value="{{ old('number', $applicant->number) }}">
            </div>
            <div>
                <label class="form-label" for="address">Address</label>
                <textarea class="form-control" name="address" id="" rows="2">{{ old('address', $applicant->address) }}</textarea>
            </div>
            <div>
                <label class="form-label" for="profil_linkedin">Linkedin Profile</label>
                <input class="form-control" type="text" name="profil_linkedin" value="{{ old('profil_linkedin', $applicant->profil_linkedin) }}">
            </div>
            <div>
                <label class="form-label" for="experience_period">Experience Period</label>
                <input class="form-control" type="text" name="experience_period" value="{{ old('name', $applicant->experience_period) }}">
            </div>
            <div>
                <label class="form-label" for="languages">Language</label>
                <input class="form-control" type="text" name="languages" value="{{ old('languages', $applicant->languages) }}">
            </div>
            <div>
                <label class="form-label" for="mbti">MBTI</label>
                <input class="form-control" type="text" name="mbti" value="{{ old('mbti', $applicant->mbti) }}">
            </div>
            <div>
                <label class="form-label" for="iq">IQ</label>
                <input class="form-control" type="text" name="iq" value="{{ old('iq', $applicant->iq) }}">
            </div>
            <div>
                <label class="form-label" for="salary_expectation" >Salary Expectation</label>
                <input class="form-control" id="salary_expectation" type="text" name="salary_expectation" value="{{ old('salary_expectation', $salary_expectation) }}">
            </div>
            <div>
                <label class="form-label" for="salary_current">Salary Current</label>
                <input class="form-control" id="salary_current" type="text" name="salary_current" value="{{ old('salary_current', $salary_current) }}">
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-danger">Save changes</button>
        </div>
      </form>
    </div>
  </div>
</div>

{{-- ===3=== --}}
<div class="modal fade" id="profilesection3" tabindex="-1" aria-labelledby="profilesection3Label" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form action="{{ route('applicant_page.cvsection.profiledata3') }}" method="post" enctype="multipart/form-data">
        @csrf

        <div class="modal-body">
          <input type="hidden" id="skills" name="skills" value="{{ implode('|', $skills ?? []) }}">

          <!-- Input untuk menambah skill baru -->
          <div class="mb-3">
            <label for="new-skill" class="form-label fw-bold">Add Skill</label>
            <div class="input-group">
              <input type="text" id="new-skill" class="form-control" placeholder="Type a skill...">
              <button type="button" id="add-skill-btn" class="btn btn-danger">Add</button>
            </div>
          </div>

          <!-- Tempat kumpulan badge -->
          <div id="skill-list" class="d-flex flex-wrap gap-2">
            @foreach ($skills as $index => $skill)
              <span class="badge d-flex align-items-center gap-2 px-3 py-2 rounded-pill text-white fw-semibold" style="background-color: #800;">
                <span class="fs-6">{{ $skill }}</span>
                <i class="far fa-times-circle fs-5 remove-skill" style="cursor: pointer;"></i>
              </span>
            @endforeach
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-danger">Save changes</button>
        </div>
      </form>
    </div>
  </div>
</div>


{{-- ======EXPERIENCE MODAL ======== --}}

<div class="modal fade" id="experiencemodal" tabindex="-1" aria-labelledby="experienceLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
    <form action="{{ route("applicant_page.cvsection.experienceEdit") }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="modal-body">
            <input type="hidden" name="experience_id" >
            <div id="work_experience" class="work_experience">

                <div class="input company_name">
                    <label class="form-label" for="name_company">Company Name</label>
                    <input class="form-control" name="name_company" type="text">
                </div>
                <div class="input role_name mt-3">
                    <label class="form-label" for="role">Position Name</label>
                    <input class="form-control" name="role" type="text" value="">
                </div>

                <div class="input date_kontainer row mt-4 mb-4">
                    <div class="date work_start col-4">
                        <label class="form-label" for="mulai">Start</label>
                        <input class="form-control" type="date" name="mulai">
                    </div>

                    <div class="col-4" style="display: flex; align-items:flex-end">
                        <select class="form-control status-select" name="present" id="">
                            <option selected value="end_date">Input End Date</option>
                            <option value="present">Present</option>
                        </select>
                    </div>

                    <div class="date work_end col-4" id="work_end">
                        <label class="form-label" for="selesai">End</label>
                        <input class="form-control" type="date" name="selesai">
                    </div>

                    <div>

                    </div>

                </div>

                <div class="input job_description">
                    <label class="form-label" for="desc_kerja">Job Description</label>
                    <main>
                        {{-- <trix-toolbar id="my_toolbar"></trix-toolbar> --}}
                        <div class="more-stuff-inbetween"></div>
                        <trix-toolbar id="my_toolbar"></trix-toolbar>
                        <input type="hidden" id="my_input" name="desc_kerja" value="">
                        <trix-editor toolbar="my_toolbar" input="my_input"></trix-editor>
                    </main>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-danger">Save changes</button>
        </div>
      </form>
    </div>
  </div>
</div>


<div class="modal fade" id="addExperience" tabindex="-1" aria-labelledby="addExperience" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
    <form action="{{ route("applicant_page.cvsection.experienceAdd") }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="modal-body">
            <input type="hidden" name="experience_id" >
            <div id="work_experience" class="work_experience">

                <div class="input company_name">
                    <label class="form-label" for="name_company">Company Name</label>
                    <input class="form-control" name="name_company" type="text">
                </div>
                <div class="input role_name mt-3">
                    <label class="form-label" for="role">Position Name</label>
                    <input class="form-control" name="role" type="text" value="">
                </div>

                <div class="input date_kontainer row mt-4 mb-4">
                    <div class="date work_start col-4">
                        <label class="form-label" for="mulai">Start</label>
                        <input class="form-control" type="date" name="mulai">
                    </div>

                    <div class="col-4" style="display: flex; align-items:flex-end">
                        <select class="form-control status-select" name="present" id="">
                            <option selected value="end_date">Input End Date</option>
                            <option value="present">Present</option>
                        </select>
                    </div>

                    <div class="date work_end col-4" id="work_end">
                        <label class="form-label" for="selesai">End</label>
                        <input class="form-control" type="date" name="selesai">
                    </div>

                    <div>

                    </div>

                </div>

                <div class="input job_description">
                    <label class="form-label" for="desc_kerja">Job Description</label>
                    <main>
                        {{-- <trix-toolbar id="my_toolbar"></trix-toolbar> --}}
                        <div class="more-stuff-inbetween"></div>
                        <trix-toolbar id="my_toolbar2"></trix-toolbar>
                        <input type="hidden" id="my_input2" name="desc_kerja" value="">
                        <trix-editor toolbar="my_toolbar2" input="my_input2"></trix-editor>
                    </main>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-danger">Save changes</button>
        </div>
      </form>
    </div>
  </div>
</div>

{{-- =========================================================
=====================PROJECT MODAL=======================
========================================================= --}}


<div class="modal fade" id="editProject" tabindex="-1" aria-labelledby="editProject" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
    <form action="{{ route("applicant_page.cvsection.projectEdit") }}" method="post" enctype="multipart/form-data">
        @csrf

        <div class="modal-body">
            <input type="hidden" name="project_id">
            <div class="input Project_name">
                <label class="form-label" for="project_name">Project Name</label>
                <input class="form-control" name="project_name" type="text">
            </div>
            <div class="input client_name">
                <label class="form-label" for="client">Client</label>
                <input class="form-control" name="client" type="text">
            </div>

            <div class="input project_description">
                <label class="form-label" for="desc_project">Project Description</label>
                <textarea class="form-control" name="desc_project"  placeholder="Project Description"></textarea>
            </div>
        </div>


        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-danger">Save changes</button>
        </div>
      </form>
    </div>
  </div>
</div>


{{-- =========================================================
=====================REFERENCE MODAL=======================
========================================================= --}}


<div class="modal fade" id="referenceModal" tabindex="-1" aria-labelledby="referenceModal" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
    <form action="{{ route("applicant_page.cvsection.referenceEdit") }}" method="post" enctype="multipart/form-data">
        @csrf

        <div class="modal-body">
            <input type="hidden" name="reference_id">
            <div class="input reference_name">
                <label class="form-label" for="reference_name">Reference Name</label>
                <input class="form-control" name="reference_name" type="text">
            </div>
            <div class="input reference_email">
                <label class="form-label" for="reference_email">Reference Email</label>
                <input class="form-control" name="reference_email" type="text">
            </div>

            <div class="input reference_number">
                <label class="form-label" for="reference_number">Reference Number</label>
                <input class="form-control" name="reference_number" type="text">
            </div>
        </div>


        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-danger">Save changes</button>
        </div>
      </form>
    </div>
  </div>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>

    function changeSection(){
    // Ambil URL saat ini
    const urlParams = new URLSearchParams(window.location.search);

    // Ambil nilai parameter "datasection"
    const datasection = urlParams.get('datasection');
    if(datasection == 'profile'){
        console.log('profile paneeeee')
    }
    if(datasection == 'experience'){
        console.log('EXPERIENCE paneeeee')
        const nav_section = document.querySelectorAll('.nav-link');
        nav_section.forEach(element => {
            element.classList.remove('active')
        });
        document.querySelector('#experience_nav_button').classList.add('active')

        const tab_pane = document.querySelectorAll('.tab-pane');
        tab_pane.forEach(element => {
            element.classList.remove('active');
        })
        document.querySelector('#Experience').classList.add('active');
    }

    if(datasection == 'project'){
        console.log('PROJECT paneeeee');
        const nav_section = document.querySelectorAll('.nav-link');
        nav_section.forEach(element => {
            element.classList.remove('active')
        });
        document.querySelector('#project_nav_button').classList.add('active')

        const tab_pane = document.querySelectorAll('.tab-pane');
        tab_pane.forEach(element => {
            element.classList.remove('active');
        })
        document.querySelector('#Project').classList.add('active');
    }

    if(datasection == 'reference'){
        console.log('REFERENCE paneeeee')
        const nav_section = document.querySelectorAll('.nav-link');
        nav_section.forEach(element => {
            element.classList.remove('active')
        });
        document.querySelector('#reference_nav_button').classList.add('active')
        const tab_pane = document.querySelectorAll('.tab-pane');
        tab_pane.forEach(element => {
            element.classList.remove('active')
        })
        document.querySelector('#Reference').classList.add('active')

    }
    console.log(datasection); // hasil: "profile"
    // const nav_section = document.querySelectorAll('.nav-link');
    // nav_section.forEach(element => {
    //     element.classList.remove('active')
    // });
    // profile_pane = document.querySelector('#Profile_pane')
    // profile_pane.classList.add('profile_pane');
    // const tab_pane = document.querySelectorAll('tab-pane')
}
changeSection()
      // ============untuk angka expected salary================
    document.getElementById('salary_expectation').addEventListener('input', function(e) {
    let value = this.value.replace(/\D/g, ""); // hanya angka
    this.value = new Intl.NumberFormat('id-ID').format(value); // format ribuan
});

    document.getElementById('salary_current').addEventListener('input', function(e) {
    let value = this.value.replace(/\D/g, ""); // hanya angka
    this.value = new Intl.NumberFormat('id-ID').format(value); // format ribuan
});
  // ambil semua elemen dengan class .nav-link
//   const navLinks = document.querySelectorAll('.nav-link');

//   navLinks.forEach(link => {
//     link.addEventListener('click', function (event) {

//         event.preventDefault(); // supaya tidak reload (opsional)

//         // hapus class 'active' dari semua nav-link
//         navLinks.forEach(l => l.classList.remove('active'));
//         // tambahkan class 'active' pada yang diklik
//         this.classList.add('active');

//         const sectionKontainers = document.querySelectorAll('.section');
//         sectionKontainers.forEach(sectionKontainer => {
//             sectionKontainer.classList.remove('d-none')
//         })
//         sectionKontainers.forEach(sectionKontainer => {
//             sectionKontainer.classList.add('d-none')
//         })
//         let komponen = this.dataset.section;
//         let section = document.getElementById(komponen);
//         section.classList.remove('d-none');

//     });
//   });

// ==BADGE===
document.addEventListener('DOMContentLoaded', function () {
  const skillsInput = document.getElementById('skills');
  const skillList = document.getElementById('skill-list');
  const newSkillInput = document.getElementById('new-skill');
  const addSkillBtn = document.getElementById('add-skill-btn');

  // Fungsi untuk update nilai input hidden
  function updateHiddenInput() {
    const skills = Array.from(skillList.querySelectorAll('span span'))
      .map(span => span.textContent.trim());
    skillsInput.value = skills.join('|');
  }

  // Tambah skill baru
  addSkillBtn.addEventListener('click', function () {
    const newSkill = newSkillInput.value.trim();
    if (!newSkill) return;

    // Cegah duplikat
    const existingSkills = Array.from(skillList.querySelectorAll('span span'))
      .map(span => span.textContent.trim().toLowerCase());
    if (existingSkills.includes(newSkill.toLowerCase())) {
      alert('Skill already exists!');
      return;
    }

    // Buat elemen badge baru
    const badge = document.createElement('span');
    badge.className = 'badge d-flex align-items-center gap-2 px-3 py-2 rounded-pill text-white fw-semibold';
    badge.style.backgroundColor = '#800';
    badge.innerHTML = `
      <span class="fs-6">${newSkill}</span>
      <i class="far fa-times-circle fs-5 remove-skill" style="cursor: pointer;"></i>
    `;

    // Tambahkan ke daftar
    skillList.appendChild(badge);
    newSkillInput.value = '';

    updateHiddenInput();
  });

  // Hapus skill (delegasi event)
  skillList.addEventListener('click', function (e) {
    if (e.target.classList.contains('remove-skill')) {
      e.target.closest('.badge').remove();
      updateHiddenInput();
    }
  });
});

// ======ACHIEVEMENT======

document.addEventListener('DOMContentLoaded', function () {
  const list = document.getElementById('achievement-list');
  const addBtn = document.getElementById('add-achievement-btn');
  const hiddenInput = document.getElementById('achievement');

  // Fungsi update nilai input hidden
  function updateHiddenInput() {
    const values = Array.from(list.querySelectorAll('.achievement-text'))
      .map(item => item.textContent.trim());
    hiddenInput.value = values.join('|');
  }

  // Tambah achievement
  addBtn.addEventListener('click', function () {
    const text = prompt('Enter new achievement:');
    if (!text) return;

    const li = document.createElement('li');
    li.innerHTML = `
      <div class="alert alert-danger d-flex justify-content-between align-items-center" role="alert">
        <span class="achievement-text">${text}</span>
        <div class="d-flex gap-2">
          <i class="fas fa-pen edit-achievement" style="cursor: pointer;"></i>
          <i class="fas fa-trash-alt delete-achievement" style="cursor: pointer;"></i>
        </div>
      </div>
    `;
    list.appendChild(li);
    updateHiddenInput();
  });

  // Delegasi event untuk edit dan delete
  list.addEventListener('click', function (e) {
    const target = e.target;

    // Hapus achievement
    if (target.classList.contains('delete-achievement')) {
      target.closest('li').remove();
      updateHiddenInput();
    }

    // Edit achievement
    if (target.classList.contains('edit-achievement')) {
      const textEl = target.closest('li').querySelector('.achievement-text');
      const currentText = textEl.textContent.trim();
      const newText = prompt('Edit achievement:', currentText);
      if (newText !== null && newText.trim() !== '') {
        textEl.textContent = newText.trim();
        updateHiddenInput();
      }
    }
  });
});


// ======CERTIFICATE===========


document.addEventListener('DOMContentLoaded', function () {
  const list = document.getElementById('certificate-list');
  const addBtn = document.getElementById('add-certificate-btn');
  const hiddenInput = document.getElementById('certificates');

  // Fungsi untuk update nilai input hidden
  function updateHiddenInput() {
    const values = Array.from(list.querySelectorAll('.certificate-text'))
      .map(item => item.textContent.trim());
    hiddenInput.value = values.join('|');
  }

  // Tambah certificate baru
  addBtn.addEventListener('click', function () {
    const text = prompt('Enter new certificate:');
    if (!text) return;

    const li = document.createElement('li');
    li.innerHTML = `
      <div class="alert alert-danger d-flex justify-content-between align-items-center" role="alert">
        <span class="certificate-text">${text}</span>
        <div class="d-flex gap-2">
          <i class="fas fa-pen edit-certificate" style="cursor: pointer;"></i>
          <i class="fas fa-trash-alt delete-certificate" style="cursor: pointer;"></i>
        </div>
      </div>
    `;
    list.appendChild(li);
    updateHiddenInput();
  });

  // Delegasi event untuk edit dan delete
  list.addEventListener('click', function (e) {
    const target = e.target;

    // Hapus certificate
    if (target.classList.contains('delete-certificate')) {
      target.closest('li').remove();
      updateHiddenInput();
    }

    // Edit certificate
    if (target.classList.contains('edit-certificate')) {
      const textEl = target.closest('li').querySelector('.certificate-text');
      const currentText = textEl.textContent.trim();
      const newText = prompt('Edit certificate:', currentText);
      if (newText !== null && newText.trim() !== '') {
        textEl.textContent = newText.trim();
        updateHiddenInput();
      }
    }
  });
});

//=======EXPERIENCE==========
function getExperience(data) {

    console.log("Experience data:", data);

    // 1️⃣ Bersihkan semua input di modal terlebih dahulu
    const modal = document.querySelector("#experiencemodal");

    modal.querySelector('input[name="experience_id"]').value = "";
    modal.querySelector('input[name="name_company"]').value = "";
    modal.querySelector('input[name="role"]').value = "";
    modal.querySelector('input[name="mulai"]').value = "";
    modal.querySelector('input[name="selesai"]').value = "";
    modal.querySelector('select[name="present"]').value = "end_date";
    modal.querySelector('input[name="desc_kerja"]').value = "";

    // Jika kamu menggunakan Trix Editor, perlu direset manual juga:
    const trixEditor = modal.querySelector("trix-editor");
    if (trixEditor) trixEditor.editor.loadHTML("");

    // 2️⃣ Isi input berdasarkan data yang diterima
    if (data) {
        modal.querySelector('input[name="experience_id"]').value = data.id ?? "";
        modal.querySelector('input[name="name_company"]').value = data.name_company ?? "";
        modal.querySelector('input[name="role"]').value = data.role ?? "";
        modal.querySelector('input[name="mulai"]').value = data.mulai ?? "";
        modal.querySelector('input[name="selesai"]').value = data.selesai ?? "";
        modal.querySelector('select[name="present"]').value = data.present ?? "end_date";


        // Jika ada deskripsi kerja dan pakai Trix:
        modal.querySelector('input[name="desc_kerja"]').value = data.desc_kerja ?? "";
        if (trixEditor && data.desc_kerja) {
            trixEditor.editor.loadHTML(data.desc_kerja);
        }
    }
    $(`#work_end`).show();
     $(document).on('change', '.status-select', function () {
            let dataId = $(this).data('id');
            let status = $(this).val();
            console.log("Data ID:", dataId);
            console.log("Status:", status);
            if(status == 'present'){
                $(`#work_end`).hide();
            } else {
                $(`#work_end`).show();
            }
        });
}


function getProject(data){
    console.log(data)

    modal = document.querySelector('#editProject');
    url = document.querySelector('#edit_project_btn').getAttribute('data-url');
    modal.querySelector('form').action=url;
    modal.querySelector('input[name="project_id"]').value = "";
    modal.querySelector('input[name="project_name"]').value = "";
    modal.querySelector('input[name="client"]').value = "";
    modal.querySelector('textarea[name="desc_project"]').value = "";


    modal = document.querySelector('#editProject');
    modal.querySelector('input[name="project_id"]').value = data.id;
    modal.querySelector('input[name="project_name"]').value = data.project_name;
    modal.querySelector('input[name="client"]').value = data.client;
    modal.querySelector('textarea[name="desc_project"]').value = data.desc_project;

}

function addProject(){

    modal = document.querySelector('#editProject');
    url = document.querySelector('#add-project-btn').getAttribute('data-url');
    modal.querySelector('form').action=url;
    modal.querySelector('input[name="project_id"]').value = "";
    modal.querySelector('input[name="project_name"]').value = "";
    modal.querySelector('input[name="client"]').value = "";
    modal.querySelector('textarea[name="desc_project"]').value = "";
}


function getReference(data){
    console.log(data);
    modal = document.querySelector('#referenceModal');
    url = document.querySelector('#edit-reference-btn').getAttribute('data-url');
    console.log(url)
    modal.querySelector('form').action=url;
    modal.querySelector('input[name="reference_id"]').value = "";
    modal.querySelector('input[name="reference_name"]').value = "";
    modal.querySelector('input[name="reference_email"]').value = "";
    modal.querySelector('input[name="reference_number"]').value = "";

    modal.querySelector('input[name="reference_id"]').value = data.id;
    modal.querySelector('input[name="reference_name"]').value = data.name_ref;
    modal.querySelector('input[name="reference_email"]').value = data.email_ref;
    modal.querySelector('input[name="reference_number"]').value = data.phone;
}

function addReference(){
    modal = document.querySelector('#referenceModal');
    url = document.querySelector('#add-reference-btn').getAttribute('data-url');
    console.log(url);
    modal.querySelector('form').action = url;
    modal.querySelector('input[name="reference_id"]').value = "";
    modal.querySelector('input[name="reference_name"]').value = "";
    modal.querySelector('input[name="reference_email"]').value = "";
    modal.querySelector('input[name="reference_number"]').value = "";

}


</script>

<link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.8/dist/trix.css"> {{-- library untuk text editor --}}
<script type="text/javascript" src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script> {{-- library untuk text editor --}}



@stop


