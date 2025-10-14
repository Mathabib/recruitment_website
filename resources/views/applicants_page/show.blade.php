@extends('applicants_page.layouts.master')
@section('content')


@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
<div>
    <div class="row">
        <h2 class="fw-bold">{{ $job->job_name }}</h2>
        <div class="m-4">
            <a class="btn btn-outline-danger" href="{{ route('applicant_page.jobs.apply', $job->id) }}"><span class="fs-2"><i class="fas fa-briefcase"></i>Apply</span></a>
            {{-- <button class="btn btn-outline-danger"><span class="fs-2"><i class="fas fa-briefcase"></i>Apply</span></button> --}}
        </div>
    </div>
    <div class="row">
        <div class="card col-md-9 row">
            <div class="card-body">
                <div>
                    <h4>Responsibilities</h4>
                    <div>
                        {!! $job->responsibilities !!}
                    </div>
                </div>
                <div>
                    <h4>Requirement</h4>
                    <div>
                        {!! $job->requirements !!}
                    </div>
                </div>
                <div>
                    <h4>Benefit</h4>
                    <div>
                        {!! $job->benefit !!}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 row d-flex-md justify-content-center">

        </div>
    </div>
</div>
@stop
