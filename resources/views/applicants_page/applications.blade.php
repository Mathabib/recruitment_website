@extends('applicants_page.layouts.master')
@section('content')
<div>
    <p class="fs-3 fw-bold" style="color: #800">Your Applications</p>
    <div class="d-flex flex-column gap-3 mb-5">
        @foreach ($applications as $job)
            <div class="card">
                <div class="card-body p-4">
                    <div>
                        <div class="atas row">
                            <div class="col-2">
                                <div class="d-flex justify-content-center align-items-center h-100 w-100">
                                    <img width="70px" src="{{ asset('assets/ISOLOGO2.PNG') }}" alt="">
                                </div>
                            </div>
                            <div class="col-9 ps-4 ps-md-0">
                                <p class="fw-bold fs-6">PT Isolutions Indonesia</p>
                                <a href="#" style="text-decoration: none">
                                    <h4 class="text-black" >{{ $job->job_name }}</h4>
                                </a>
                                <p>Apply : {{ \Carbon\Carbon::parse($job->pivot->created_at)->format('d-M-Y') }}</p>
                                <div>
                                    <div class="badge text-bg-success">{{ $job->employment_type }}</div>
                                    <span><strong> | Status : </strong></span>
                                    <div class="badge text-bg-success">Applied</div>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@stop
