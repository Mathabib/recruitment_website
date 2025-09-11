@extends('adminlte::page')

@section('title', 'Edit Role')

@section('content_header')

@stop
@section('content')

<div class="card mt-5">
    <div class="card-header">
       <h2>Edit Role</h2>
    </div>
    <div class="card-body">
        <form action="{{ route('management.role.update') }}" method="POST">
            @csrf
            @method('POST')
            <div class="form-group">
                <input type="hidden" name="id" value="{{ $role->id }}">
                <label class="form-label" for="role">Role</label>
                <input class="form-control" type="text" name="name" value="{{ old('name', $role->name) }}">
            </div>

            <div class="table">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th style="width: 5%">No</th>
                            <th>Permission</th>
                            <th style="width: 5%">Check</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($permissions as $index => $permission)
                        <tr>
                            <td>{{ $index }}</td>
                            <td>{{ $permission->name }}</td>
                            <td>
                                <div>
                                    <input type="checkbox" name="permission[]" value="{{ $permission->name }}" {{ $role->hasPermissionTo($permission->name) ? 'checked' : '' }} id="" >
                                    {{-- <input type="checkbox" name="permission_{{ $index }}" value="{{ $permission->name }}" id=""> --}}
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div>
                <button class="btn btn-success">Submit</button>
            </div>
        </form>
    </div>
</div>


@stop