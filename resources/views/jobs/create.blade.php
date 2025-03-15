@extends('adminlte::page')

@section('title', 'Create Job')

@section('content_header')
<h1 class="m-0 text-dark">Create Job</h1>
@stop

@section('content')
<form action="{{ route('jobs.store') }}" method="post">
    @csrf
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
                                    value="{{ old('job_name') }}">
                                @error('job_name')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Work Location -->
                            <!--<div class="form-group">-->
                            <!--    <label for="work_location_id">Work Location</label>-->
                            <!--    <select class="form-control @error('work_location_id') is-invalid @enderror" id="work_location_id" name="work_location_id">-->
                            <!--        <option value="">Select Work Location</option>-->
                            <!--        @foreach($workLocations as $location)-->
                            <!--        <option value="{{ $location->id }}" {{ old('work_location_id') == $location->id ? 'selected' : '' }}>-->
                            <!--            {{ $location->location }}-->
                            <!--        </option>-->
                            <!--        @endforeach-->
                            <!--    </select>-->
                            <!--    @error('work_location_id')-->
                            <!--    <span class="text-danger">{{ $message }}</span>-->
                            <!--    @enderror-->
                            <!--</div>-->


                            <!-- Spesifikasi -->
                            <!--<div class="form-group">-->
                            <!--    <label for="spesifikasi">Company Name</label>-->
                            <!--    <input type="text" class="form-control @error('spesifikasi') is-invalid @enderror"-->
                            <!--        id="spesifikasi" placeholder="fill in the company name" name="spesifikasi"-->
                            <!--        value="{{ old('spesifikasi') }}">-->
                            <!--    @error('spesifikasi')-->
                            <!--    <span class="text-danger">{{ $message }}</span>-->
                            <!--    @enderror-->
                            <!--</div>-->

                            <!-- Minimum Salary -->
                            
                            
                            
                    <div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="work_location_id">Work Location</label>
            <select class="form-control @error('work_location_id') is-invalid @enderror" id="work_location_id" name="work_location_id">
                <option value="">Select Work Location</option>
                @foreach($workLocations as $location)
                    <option value="{{ $location->id }}" {{ old('work_location_id') == $location->id ? 'selected' : '' }}>
                        {{ $location->location }}
                    </option>
                @endforeach
            </select>
            @error('work_location_id')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-md-6">
        <!-- Spesifikasi -->
        <div class="form-group">
            <label for="spesifikasi">Location Detail</label>
            <input type="text" class="form-control @error('spesifikasi') is-invalid @enderror" id="spesifikasi" placeholder="fill in the location detail" name="spesifikasi" value="{{ old('spesifikasi') }}">
            @error('spesifikasi')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>

                            <!-- Minimum Salary -->
                            
                        </div>

                        <!-- Kolom Kanan -->
                        <div class="col-md-6">
                            <!-- Employment Type -->
                            <div class="form-group">
                                <label for="employment_type">Employment Type</label>
                                <select class="form-control @error('employment_type') is-invalid @enderror" id="employment_type" name="employment_type">
                                    <option value="">Select Job Type</option>
                                    <option value="Permanent" {{ old('employment_type') == 'Permanent' ? 'selected' : '' }}>Permanent</option>
                                    <option value="Contract" {{ old('employment_type') == 'Contract' ? 'selected' : '' }}>Contract</option>
                                    <option value="Freelance" {{ old('employment_type') == 'Freelance' ? 'selected' : '' }}>Freelance</option>

                                </select>
                                @error('employment_type')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Department -->
                            <div class="form-group">
                                <label for="department">Department</label>
                                <select class="form-control @error('department') is-invalid @enderror"
                                    id="department" name="department" required>
                                    <option value="">Select Department</option>
                                    @foreach($departements as $departement)
                                    <option value="{{ $departement->id }}" {{ old('department') == $departement->id ? 'selected' : '' }}>
                                        {{ $departement->dep_name }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('department')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Maximum Salary -->
                            <div class="form-group row">
                                
                                <div class="col">
                                    <label for="minimum_salary">Minimum Salary</label>
                                    <input type="number" class="form-control @error('minimum_salary') is-invalid @enderror"
                                        id="minimum_salary" placeholder="Minimum salary" name="minimum_salary"
                                        value="{{ old('minimum_salary') }}">
                                    @error('minimum_salary')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col">
                                    <label for="maximum_salary">Maximum Salary</label>
                                    <input type="number" class="form-control @error('maximum_salary') is-invalid @enderror"
                                        id="maximum_salary" placeholder="Maximum Salary" name="maximum_salary"
                                        value="{{ old('maximum_salary') }}">
                                    @error('maximum_salary')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Benefit -->
                    <div class="form-group">
                        <label for="benefit">Benefit</label>
                        <input class="trix-editor" id="benefit" type="hidden" name="benefit" value="{{ old('benefit') }}">
                        <trix-editor input="benefit"></trix-editor>
                        @error('benefit')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Responsibilities -->
                    <div class="form-group">
                        <label for="responsibilities">Responsibilities</label>
                        <input class="trix-editor" id="responsibilities" type="hidden" name="responsibilities" value="{{ old('responsibilities') }}">
                        <trix-editor input="responsibilities"></trix-editor>
                        @error('responsibilities')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Requirements -->
                    <div class="form-group">
                        <label for="requirements">Requirements</label>
                        <input class="trix-editor" id="requirements" type="hidden" name="requirements" value="{{ old('requirements') }}">
                        <trix-editor input="requirements"></trix-editor>
                        @error('requirements')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Status Published (Hidden Input) -->
                    <div class="form-group d-none">
                        <input type="hidden" name="status_published" value="0">
                        @error('status_published')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('jobs.index') }}" class="btn btn-default">Batal</a>
                </div>
            </div>
        </div>
    </div>
</form>


<link rel="stylesheet" type="text/css" href="{{ asset('css/jobs.create.css') }}"> {{-- library untuk text editor --}}

@push('js')
<link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.8/dist/trix.css"> {{-- library untuk text editor --}}
@endpush

<script type="text/javascript" src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script> {{-- library untuk text editor --}}

@stop