@extends('adminlte::page')
@section('title', 'Create Major')
@section('content_header')
    <h1 class="m-0 text-dark">Create Major {{isset($educationFilter) ? 'for '.$educationFilter->name_education : ''}}</h1>
@stop
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('jurusan.store') }}" method="POST">
                    @csrf

                    @if(isset($educationFilter))
                    
                        {{-- =================== yang spesifik ============================== --}}
                        <input type="hidden" name="education_id" id="education" value="{{$educationFilter->id}}">
                        <input type="hidden" name="education_id_page" id="education" value="{{$educationFilter->id}}">
                    
                        <div class="form-group">
                            <label for="name_jurusan">Major</label>
                            <input type="text" class="form-control @error('name_jurusan') is-invalid @enderror" 
                                id="name_jurusan" name="name_jurusan" 
                                placeholder="Fill in the Major" value="{{ old('name_jurusan') }}" required>
                            @error('name_jurusan')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- ========================= yang umum ===================================== --}}
                        @else
                        <div class="form-group">
                            <label for="education">Education</label>
                            <select class="form-control @error('education_id') is-invalid @enderror"
                                    id="education" name="education_id" required>
                                <option value="">Select education</option>
                                @foreach($education as $edu)
                                    <option value="{{ $edu->id }}" {{ old('education_id') == $edu->id ? 'selected' : '' }}>
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
                                placeholder="Fill in the Major" value="{{ old('name_jurusan') }}" required>
                            @error('name_jurusan')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    @endif
                    
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{ route('jurusan.index') }}" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@stop
