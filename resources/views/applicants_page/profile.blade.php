@extends('applicants_page.layouts.master')
@section('content')

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
         {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif


<div>
    <div class="card">
        <div class="card-body">
            <div class="d-flex align-items-center flex-sm-row flex-column">
                <div class="me-3">
                    <img class="rounded-circle" width="110px" src="{{ asset('assets/no_profile.jpg') }}" alt="" >
                </div>
                <div class="">
                    <p class="fs-2">{{ $applicant->name }}</p>
                    <p>{{ $applicant->profile }}</p>
                </div>

            </div>
        </div>
    </div>

    <div class="card mt-3">
        <div class="card-body">
            <h3>Personal Information</h3>
            <div class="row">
                <div class="col-md-6">
                    <p class="fw-bold fs-6 m-0 p-0" style="color: #800">Nama</p>
                    <p class="m-0 p-0">{{ $applicant->name }}</p>
                </div>
                <div class="col-md-6">
                    <p class="fw-bold fs-6 m-0 p-0" style="color: #800">Email</p>
                    <p class="m-0 p-0">{{ $applicant->email }}</p>
                </div>
                <div class="col-md-6">
                    <p class="fw-bold fs-6 m-0 p-0" style="color: #800">Phone</p>
                    <p class="m-0 p-0">{{ $applicant->number }}</p>
                </div>
                <div class="col-md-6">
                    <p class="fw-bold fs-6 m-0 p-0" style="color: #800">Alamat</p>
                    <p class="m-0 p-0">{{ $applicant->address }}</p>
                </div>
                {{-- <div class="col-md-6">
                    <p class="fw-bold fs-6 m-0 p-0" style="color: #800">Nama</p>
                    <p class="m-0 p-0">{{ $applicant->name }}</p>
                </div>
                <div class="col-md-6">
                    <p class="fw-bold fs-6 m-0 p-0" style="color: #800">Nama</p>
                    <p class="m-0 p-0">{{ $applicant->name }}</p>
                </div> --}}
            </div>
            <div class="mt-4">
                <a class="btn btn-outline-danger" href="{{ route('applicant_page.edit') }}">Edit Your CV</a>
                <a class="btn btn-outline-danger" href="{{ route('applicant_page.download') }}">Download Your CV</a>
                {{-- <a class="btn btn-outline-danger" href="{{ route('applicant_page.cvsection') }}">CV section</a> --}}
            </div>
        </div>
    </div>

    <div class="card mt-4 mb-5">
            <div class="card-body p-4">
                <div>
                     <div>
                        <h3 class="text-center">Your Application</h3>
                        <hr>
                    </div>
                    @if($job)

                    <div class="atas row">
                        <div class="col-2">
                            <div class="d-flex justify-content-center align-items-center h-100 w-100">
                                <img width="70px" src="{{ asset('assets/ISOLOGO2.png') }}" alt="">
                            </div>
                        </div>
                        <div class="col-9 ps-4 ps-md-0">
                            <div class="d-flex justify-content-between">
                                <p class="fw-bold fs-6">PT Isolutions Indonesia</p>
                                <div>
                                    {{-- <a class="btn btn-outline-danger" href="{{ route('applicant_page.jobs') }}">Change Job</a> --}}
                                    <a class="btn btn-outline-danger" href="{{ route('applicant_page.jobs.unapply', $job->id) }}">Delete Application</a>
                                </div>
                            </div>
                            <a href="#" style="text-decoration: none">
                                <h4 class="text-black" >{{ $job->job_name }}</h4>
                            </a>

                            <div>
                                <div class="badge text-bg-success">{{ $job->employment_type }}</div>
                                <span><strong> | Status : </strong></span>
                                <div class="badge text-bg-success">{{ ucfirst($applicant->status) }}</div>
                            </div>

                            <div class="{{ !in_array($applicant->status, ['applied', 'interview', 'offer', 'accepted']) ? 'd-none' : '' }}">
                                <div class="container mt-5">
                                    <h5 class="mb-4 fw-semibold">Application Progress</h5>

                                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center position-relative">
                                        <!-- Garis di belakang -->
                                        <div class="position-absolute top-50 start-0 w-100 translate-middle-y bg-secondary" style="height: 4px; z-index: 1;"></div>

                                        <!-- Step 1 -->
                                        <div class="text-center position-relative" style="z-index: 2;">
                                        <div class="rounded-circle {{ in_array($applicant->status, ['applied', 'interview', 'offer', 'accepted']) ? 'bg-success' : 'bg-secondary' }} text-white d-inline-flex justify-content-center align-items-center"
                                            style="width: 40px; height: 40px;">
                                            1
                                        </div>
                                        <div class="mt-2 {{ in_array($applicant->status, ['applied', 'interview', 'offer', 'accepted']) ? 'text-success fw-bolder' : '' }}">Applied</div>
                                        </div>

                                        <!-- Step 2 -->
                                        <div class="text-center position-relative" style="z-index: 2;">
                                        <div class="rounded-circle {{ in_array($applicant->status, ['interview', 'offer', 'accepted']) ? 'bg-success' : 'bg-secondary' }} text-white d-inline-flex justify-content-center align-items-center"
                                            style="width: 40px; height: 40px;">
                                            2
                                        </div>
                                        <div class="mt-2 {{ in_array($applicant->status, ['interview', 'offer', 'accepted']) ? 'text-success fw-bolder' : ''  }}">Interview</div>
                                        </div>

                                        <!-- Step 3 -->
                                        <div class="text-center position-relative" style="z-index: 2;">
                                        <div class="rounded-circle {{ in_array($applicant->status, ['offer', 'accepted']) ? 'bg-success' : 'bg-secondary' }} text-white d-inline-flex justify-content-center align-items-center"
                                            style="width: 40px; height: 40px;">
                                            3
                                        </div>
                                        <div class="mt-2 {{ in_array($applicant->status, ['offer', 'accepted']) ? 'text-success fw-bolder' : ''  }}">Offer</div>
                                        </div>

                                        <!-- Step 4 -->
                                        <div class="text-center position-relative" style="z-index: 2;">
                                        <div class="rounded-circle {{ in_array($applicant->status, ['accepted']) ? 'bg-success' : 'bg-secondary' }} text-white d-inline-flex justify-content-center align-items-center"
                                            style="width: 40px; height: 40px;">
                                            4
                                        </div>
                                        <div class="mt-2 {{ in_array($applicant->status, ['accepted']) ? 'text-success fw-bolder' : ''  }}">Accepted</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    @endif

                    @if(!$job)
                        <div class="">
                           <div class="card">
                            <div class="card-body bg-light">
                                <h4 class="text-center">You Dont Have any Application</h4>
                            </div>
                           </div>
                            {{-- <a href="{{ route('applicant_page.jobs') }}" class="btn btn-outline-danger">Apply Job</a> --}}
                        </div>
                    @endif

                </div>
            </div>
        </div>


</div>
@stop
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function test(){
        Swal.fire("SweetAlert2 is working!");
    }
</script>
