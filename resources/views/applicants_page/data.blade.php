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

    @stop
