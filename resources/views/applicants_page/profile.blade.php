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
            </div>
        </div>
    </div>

   

</div>
@stop
