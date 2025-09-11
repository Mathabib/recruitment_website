@extends('adminlte::page')

@section('title', 'Create Role')

@section('content_header')

@stop
@section('content')

<div class="card mt-5">
    <div class="card-header">
       <h2>Create Role</h2>
    </div>
    <div class="card-body">
        <form action="{{ route('management.role.store') }}" method="POST">
            @csrf
            @method('POST')
            <div class="form-group">
                <label class="form-label" for="role">Role</label>
                <input class="form-control" type="text" name="name">
            </div>

            <div>
                <button class="btn btn-success">Submit</button>
            </div>
        </form>
    </div>
</div>


@stop