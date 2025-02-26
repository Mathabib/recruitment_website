@extends('adminlte::page')
@section('title', 'Edit Departemen')
@section('content_header')
    <h1 class="m-0 text-dark">Edit Departemen</h1>
@stop
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('departements.update', $departement->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="dep_name">Department Name</label>
                        <input type="text" class="form-control" id="dep_name" name="dep_name" value="{{ $departement->dep_name }}" required>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{ route('departements.index') }}" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@stop
