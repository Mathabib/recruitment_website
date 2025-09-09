@extends('adminlte::page')

@section('title', 'User List')

@section('content_header')
<h2>User List</h2>
@stop
@section('content')

<div class="card mt-5">
    <div class="card-body">
        <div>
            <table class="table  table-bordered">
                <thead class="table-primary">
                    <tr>
                        <th style="width: 5%">No.</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th style="width: 10%">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $index => $user)
                        <tr>
                            <td>{{ $index }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->role }}</td>
                            <td>
                                <div>
                                    <a href="{{ route('management.user.edit', $user->id) }}">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <a href="#">
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