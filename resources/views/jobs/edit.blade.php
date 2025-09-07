@extends('adminlte::page')

@section('title', 'Edit Job')

@section('content_header')
    <h1 class="m-0 text-dark">Edit Job</h1>
@stop

@section('content')
<form action="{{ route('jobs.update', $job->id) }}" method="post">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <div class="row">
                        <!-- Kolom Kiri -->
                        <div class="col-md-6">
                            <!-- Job Name -->
                            <div class="form-group">
                                <label for="job_name">Job Name</label>
                                <input type="text" class="form-control @error('job_name') is-invalid @enderror"
                                    id="job_name" placeholder="fill in the job name" name="job_name"
                                    value="{{ old('job_name', $job->job_name) }}">
                                @error('job_name')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Work Location -->
                            <div class="form-group">
                                <label for="work_location_id">Work Location</label>
                                <select class="form-control @error('work_location_id') is-invalid @enderror" id="work_location_id" name="work_location_id">
                                    <option value="">Select Work Location</option>
                                    @foreach( $work_locations as $location)
                                    <option value="{{ $location->id }}" {{ old('work_location_id', $job->work_location_id) == $location->id ? 'selected' : '' }}>
                                        {{ $location->location }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('work_location_id')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Company Name -->
                            <div class="form-group">
                                <label for="spesifikasi">Company Name</label>
                                <input type="text" class="form-control @error('spesifikasi') is-invalid @enderror"
                                    id="spesifikasi" placeholder="fill in the company name" name="spesifikasi"
                                    value="{{ old('spesifikasi', $job->spesifikasi) }}">
                                @error('spesifikasi')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Minimum Salary -->
                            <div class="form-group">
                                <label for="minimum_salary">Minimum Salary</label>
                                <input type="text" class="form-control @error('minimum_salary') is-invalid @enderror salary_formatted"
                                    id="minimum_salary" placeholder="Minimum Salary" name="minimum_salary"
                                    value="{{ old('minimum_salary', $minimum_salary) }}">
                                @error('minimum_salary')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Kolom Kanan -->
                        <div class="col-md-6">
                            <!-- Employment Type -->
                            <div class="form-group">
                                <label for="employment_type">Employment Type</label>
                                <select class="form-control @error('employment_type') is-invalid @enderror" id="employment_type" name="employment_type">
                                    <option value="">Select Job Type</option>
                                    <option value="Permanent" {{ old('employment_type', $job->employment_type) == 'Permanent' ? 'selected' : '' }}>Permanent</option>
                                    <option value="Contract" {{ old('employment_type', $job->employment_type) == 'Contract' ? 'selected' : '' }}>Contract</option>
                                </select>
                                @error('employment_type')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Department -->
                            <div class="form-group">
                                <label for="department">Department</label>
                                <select class="form-control @error('department') is-invalid @enderror"
                                    id="department" name="department">
                                    <option value="">Select Department</option>
                                    @foreach($departments as $departement)
                                    <option value="{{ $departement->id }}" {{ old('department', $job->department) == $departement->id ? 'selected' : '' }}>
                                        {{ $departement->dep_name }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('department')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Maximum Salary -->
                            <div class="form-group">
                                <label for="maximum_salary">Maximum Salary</label>
                                <input type="text" class="form-control @error('maximum_salary') is-invalid @enderror salary_formatted"
                                    id="maximum_salary" placeholder="Maximum Salary" name="maximum_salary"
                                    value="{{ old('maximum_salary', $maximum_salary) }}">
                                @error('maximum_salary')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Benefit -->
                    <div class="form-group">
                        <label for="benefit">Benefit</label>
                        <input class="trix-editor" id="benefit" type="hidden" name="benefit" value="{{ old('benefit', $job->benefit) }}">
                        <trix-editor input="benefit"></trix-editor>
                        @error('benefit')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Responsibilities -->
                    <div class="form-group">
                        <label for="responsibilities">Responsibilities</label>
                        <input class="trix-editor" id="responsibilities" type="hidden" name="responsibilities" value="{{ old('responsibilities', $job->responsibilities) }}">
                        <trix-editor input="responsibilities"></trix-editor>
                        @error('responsibilities')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Requirements -->
                    <div class="form-group">
                        <label for="requirements">Requirements</label>
                        <input class="trix-editor" id="requirements" type="hidden" name="requirements" value="{{ old('requirements', $job->requirements) }}">
                        <trix-editor input="requirements"></trix-editor>
                        @error('requirements')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('jobs.index') }}" class="btn btn-default">Batal</a>
                </div>
            </div>
        </div>
    </div>
</form>
@stop

@push('css')
<link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.8/dist/trix.css">
@endpush

@push('js')
<script type="text/javascript" src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>

<script>
    document.querySelectorAll('.salary_formatted').forEach(function(input) {
        input.addEventListener('input', function(e) {
            let value = this.value.replace(/\D/g, ""); // hanya angka
            this.value = new Intl.NumberFormat('id-ID').format(value); // format ribuan
        });
    });
</script>
@endpush
