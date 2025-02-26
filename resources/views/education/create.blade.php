@extends('adminlte::page')
@section('title', 'Create Education')
@section('content_header')
    <h1 class="m-0 text-dark">Create Education</h1>
@stop
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('education.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="name_education">Education</label>
                        <input type="text" class="form-control" id="name_education" name="name_education" placeholder="fill in the education" required>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{ route('education.index') }}" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@stop
