@extends('adminlte::page')

@section('title', 'Jobs')

@section('content_header')
<h1 class="m-0 text-dark"></h1>
@stop

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0 "><b style="color: white;">Jobs List</b></h5>
                <div class="ms-auto d-flex">
                    <!-- Form Search Job dengan tampilan modern -->
                    <div class="search-bar me-3">
                        <form action="{{ route('jobs.index') }}" method="GET">
                            <input type="text" name="search" placeholder="Search jobs..." value="{{ request()->get('search') }}">
                            <button type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </form>
                    </div>
                    <a href="{{ route('jobs.create') }}" class="btn btn-primary btn-extended">
                        <i class="fa fa-plus"></i> Create Job
                    </a>
                </div>
            </div>
            <div class="card-body">
                <table class="table">
                    @forelse ($jobs as $job)
                    <tr>
                        <td>
                            <div class="kontainer_name_location" data-bs-toggle="modal" data-bs-target="#jobModal" data-job="{{ json_encode($job) }}">
                                <p class="job_name" style="font-weight: bold;">{{ $job->job_name }}</p>
                                <p class="text-muted">{{ $job->workLocation->location }} - <span>{{ $job->spesifikasi }} </span></p>

                            </div>
                        </td>
                        @foreach (['applied', 'interview', 'offer', 'accepted', 'bankcv'] as $status)
                        <td class="pipeline_stage">
                            <a href="{{ route('pipelines.index', ['status' => $status, 'job_id' => $job->id]) }}" class="stage-link">
                                <div>
                                    <p class="amount">{{ $job->applicants->where('status', $status)->count() }}</p>
                                    <small>{{ ($status == 'bankcv') ? 'Bank CV' :  ucfirst($status) }}</small>
                                </div>
                            </a>
                        </td>
                        @endforeach

                        <!-- Options button -->
                        <td class="options">
                            <div class="dropdown">
                                <button class="btn btn-warning dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Options
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="{{ route('jobs.edit', $job->id) }}">Edit</a></li>
                                    <li>
                                        <form action="{{ route('jobs.destroy', $job->id) }}" method="POST" style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item" onclick="return confirm('Yakin ingin menghapus job ini?')">Hapus</button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </td>
                        <td>
                            <form action="{{ route('jobs.updateStatus', $job->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <div style="width: 150px">
                                    <select class="form-select" name="status_published" onchange="this.form.submit()">
                                        <option value="0" {{ $job->status_published == 0 ? 'selected' : '' }}>Unpublish</option>
                                        <option value="1" {{ $job->status_published == 1 ? 'selected' : '' }}>Publish</option>
                                    </select>
                                <div>
                            </form>
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">
                            <div class="alert alert-warning">Belum ada data job yang tersedia.</div>
                        </td>
                    </tr>
                    @endforelse
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Job Details Modal -->
<div class="modal fade" id="jobModal" tabindex="-1" role="dialog" aria-labelledby="jobModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="jobModalLabel">Job Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h3 id="modal-job-name"></h3>
                <table class="mt-5">
                    {{-- <tr>
                        <td>
                            <p><strong>Location</strong></p>
                        </td>
                        <td>
                            <p>: <span id="modal-job-location"></span></p>
                        </td>
                    </tr> --}}
                    <tr>
                        <td>
                            <p><strong>Minimum Salary</strong></p>
                        </td>
                        <td>
                            <p>: <span id="modal-minimum-salary"></span></p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p><strong>Maximum Salary</strong></p>
                        </td>
                        <td>
                            <p>: <span id="modal-maximum-salary"></span></p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p><strong>Employment Type</strong></p>
                        </td>
                        <td>
                            <p>: <span id="modal-employment-type"></span></p>
                        </td>
                    </tr>
                </table>
                <p><strong>Benefit:</strong> <span id="modal-benefit"></span></p>
                <p><strong>Responsibilities:</strong> <span id="modal-responsibilities"></span></p>
                <p><strong>Requirements:</strong> <span id="modal-requirements"></span></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Styles and Scripts -->
<link rel="stylesheet" href="{{ asset('css/jobs.index.css') }}">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

@stop



@push('js')
<script>
    $(document).ready(function() {
        // Job details modal
        $('.kontainer_name_location').on('click', function() {
            var job = $(this).data('job');
            $('#modal-job-name').text(job.job_name);

            $('#modal-minimum-salary').text(job.minimum_salary);
            $('#modal-maximum-salary').text(job.maximum_salary);
            $('#modal-employment-type').text(job.employment_type);
            $('#modal-benefit').html(job.benefit);
            $('#modal-responsibilities').html(job.responsibilities);
            $('#modal-requirements').html(job.requirements);
        });
    });
</script>
@endpush