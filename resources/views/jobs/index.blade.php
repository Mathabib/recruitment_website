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
                <!-- Total Jobs -->
               <h5 class="mb-0">
                <b style="color: white;">Total Jobs : {{ $totalJobs }}</b>
            </h5>

            </div>
            

            <!-- Filter Bar -->
            <div class="card-body border-bottom">
                <form action="{{ route('jobs.index') }}" method="GET" class="row g-2 align-items-center">

                    <!-- Search -->
                    <div class="col-md-4">
                        <input type="text"
                               name="search"
                               class="form-control"
                               placeholder="Search jobs..."
                               value="{{ request()->get('search') }}">
                    </div>

                    <!-- Sort -->
                    <div class="col-md-3">
                        <select name="sort" class="form-select">
                            <option value="">Sort By</option>
                            <option value="asc" {{ request()->input('sort') == 'asc' ? 'selected' : '' }}>A - Z</option>
                            <option value="desc" {{ request()->input('sort') == 'desc' ? 'selected' : '' }}>Z - A</option>
                            <option value="date_desc" {{ request()->input('sort') == 'date_desc' ? 'selected' : '' }}>Newest</option>
                            <option value="date_asc" {{ request()->input('sort') == 'date_asc' ? 'selected' : '' }}>Oldest</option>
                        </select>
                    </div>

                    <!-- Status Published -->
                   <div class="col-md-3">
                        <select name="status_published" class="form-select">
                            <option value="">All Status</option>
                            <option value="1" {{ request()->input('status_published') == '1' ? 'selected' : '' }}>Published</option>
                            <option value="0" {{ request()->input('status_published') == '0' ? 'selected' : '' }}>Unpublished</option>
                        </select>
                    </div>


                    <!-- Submit -->
                    <div class="col-md-2 d-grid">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-filter"></i> Filter
                        </button>
                    </div>
                </form>

               <!-- Show per page selector -->
    <div class="mt-3 d-flex justify-content-between">
        <div>
            @can('create jobs')
            <a class="btn btn-success" href="{{ route('jobs.create') }}">
                <i class="fas fa-plus"></i>
                Create Jobs
            </a>
            @endcan
        </div>
        <form action="{{ route('jobs.index') }}" method="GET" class="d-flex align-items-center">
            @foreach(request()->except('perPage') as $key => $value)
                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
            @endforeach

            <label for="perPage" class="me-2 mb-0">Show</label>
            <select name="perPage" id="perPage" class="form-select form-select-sm w-auto"
                    onchange="this.form.submit()">
                <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10</option>
                <option value="20" {{ $perPage == 20 ? 'selected' : '' }}>20</option>
                <option value="25" {{ $perPage == 25 ? 'selected' : '' }}>25</option>
                <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50</option>
                <option value="100" {{ $perPage == 100 ? 'selected' : '' }}>100</option>
                <option value="all" {{ $perPage == 'all' ? 'selected' : '' }}>All</option>
            </select>
            <span class="ms-2">entries</span>
        </form>
    </div>
            </div>

        </div>
    </div>
</div>


@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-0" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

            <div class="card-body">
                <table class="table">
                    @forelse ($jobs as $job)
                    <tr>
                        <td style="width: 40%">
                            <div class="d-flex justify-content-between kontainer_name_location" data-bs-toggle="modal" data-bs-target="#jobModal" data-job="{{ json_encode($job) }}">
                                <div class="">
                                    <p class="job_name" style="font-weight: bold;">{{ $job->job_name }}</p>
                                    <p class="text-muted">{{ $job->workLocation->location }} - <span>{{ $job->spesifikasi }} </span></p>
                                </div>
                                <div class="d-flex flex-column align-items-end">
                                    <p class="text-muted">{{ $job->created_at->translatedFormat('d-m-Y') }}</p>
                                    <p class="text-muted">{{ $job->created_at->translatedFormat('H:i') }}</p>
                                </div>
                            </div>
                        </td>
                        @foreach (['applied', 'interview', 'offer', 'accepted', 'bankcv'] as $status)
                        <td class="pipeline_stage">
                            <a href="{{ route('pipelines.index', ['status' => $status, 'job_id' => $job->id]) }}" class="stage-link">
                                <div>
                                    <p class="amount">{{ $job->applicants->where('status', $status)->where('type', '!=', 'resindo')->count() }}</p>
                                    <small>{{ ($status == 'bankcv') ? 'Bank CV' :  ucfirst($status) }}</small>
                                </div>
                            </a>
                        </td>
                        @endforeach
                        @can('jobs options')
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
                        @endcan
                        @can('jobs publish')
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
                        @endcan
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
                            <p>: Rp <span id="modal-minimum-salary"></span></p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p><strong>Maximum Salary</strong></p>
                        </td>
                        <td>
                            <p>: Rp <span id="modal-maximum-salary"></span></p>
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
              let formatted_minimum_salary = new Intl.NumberFormat('id-ID').format(job.minimum_salary);
        let formatted_maximum_salary = new Intl.NumberFormat('id-ID').format(job.maximum_salary);
            $('#modal-job-name').text(job.job_name);

            $('#modal-minimum-salary').text(formatted_minimum_salary);
            $('#modal-maximum-salary').text(formatted_maximum_salary);
            $('#modal-employment-type').text(job.employment_type);
            $('#modal-benefit').html(job.benefit);
            $('#modal-responsibilities').html(job.responsibilities);
            $('#modal-requirements').html(job.requirements);
        });
    });
</script>
@endpush