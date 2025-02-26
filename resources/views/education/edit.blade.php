@extends('adminlte::page')
@section('title', 'Edit education')
@section('content_header')
    <h1 class="m-0 text-dark">Edit Education</h1>
@stop
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('education.update', $education->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="name_education">Education</label>
                        <input type="text" class="form-control" id="name_education" name="name_education" value="{{ $education->name_education }}" required>
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
