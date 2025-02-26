@extends('adminlte::page')
@section('title', 'Edit Major')
@section('content_header')
    <h1 class="m-0 text-dark">Edit Major</h1>
@stop
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('jurusan.update', $jurusan->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="education">Education</label>
                        <select class="form-control @error('education_id') is-invalid @enderror"
                                id="education" name="education_id" required>
                            <option value="">Select education</option>
                            @foreach($education as $edu)
                                <option value="{{ $edu->id }}" {{ $jurusan->education_id == $edu->id ? 'selected' : '' }}>
                                    {{ $edu->name_education }}
                                </option>
                            @endforeach
                        </select>
                        @error('education_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="name_jurusan">Major</label>
                        <input type="text" class="form-control @error('name_jurusan') is-invalid @enderror" 
                               id="name_jurusan" name="name_jurusan" 
                               value="{{ old('name_jurusan', $jurusan->name_jurusan) }}" required>
                        @error('name_jurusan')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Update</button>
                        <a href="{{ route('jurusan.index') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@stop
