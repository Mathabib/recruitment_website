@extends('adminlte::page')

@section('title', 'Permission List')

@section('content_header')
<h2>Role List</h2>
@stop
@section('content')

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-0" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

<div class="card mt-5">
    <div class="card-header">
        <div>
            <a class="btn btn-success" href="{{ route('management.role.create') }}">
                <i class="fas fa-plus"></i>
                Add Role
            </a>
        </div>
    </div>
    <div class="card-body">
        <div>
            <table class="table  table-bordered">
                <thead class="table-primary">
                    <tr>
                        <th style="width: 5%">No.</th>
                        <th>Role</th>                    
                        <th style="width: 10%">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($roles as $index => $role)
                        <tr>
                            <td>{{ $index }}</td>
                            <td>{{ $role->name }}</td>
                            <td>
                                <div>
                                    <a href="#">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <a href="{{ route('management.role.delete', $role->id) }}" onclick="return confirm('Are you sure you want to delete this user?')">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    
                </tbody>
            </table>
        </div>
    </div>
</div>


@stop