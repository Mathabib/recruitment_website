{{-- @extends('adminlte::page')

@section('title', 'Applicant Page')

@section('content_header')
<h2>Applicant Page</h2>
@stop --}}
@extends('applicants_page.layouts.master')
@section('content')
{{-- <a class="btn btn-success" href="{{ route('applicant_page.edit', $user->email) }}">Edit Data</a> --}}
<div class="action_container">
    <div class="">
       <form action="">
        <div class="row">
            <div class="mb-3 col-10">
                <input type="text" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1">
            </div>
            <div class="col-2">
                <button class="text-black btn btn-secondary"><i class="fas fa-search"></i> Search</button>
            </div>
        </div>
       </form>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
         {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="container">
    <div class="row">
        @foreach ($jobs as $job)
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-body p-4">
                        <div>
                            <div class="atas row">
                                <div class="col-2">
                                    <img width="50px" src="{{ asset('assets/ISOLOGO2.PNG') }}" alt="">
                                </div>
                                <div class="col-10">
                                    <p class="fw-bold fs-6">PT Isolutions Indonesia</p>
                                    <a href="{{ route('applicant_page.jobs.show', $job->id) }}" style="text-decoration: none">
                                        <h4 class="text-black" >{{ $job->job_name }}</h4>
                                    </a>
                                </div>
                            </div>
                            <div>
                                <div class="badge text-bg-success">{{ $job->employment_type }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="d-flex justify-content-center">
        {{ $jobs->links('pagination::bootstrap-4', ['class' => 'pagination-sm']) }}
    </div>
</div>
@stop
