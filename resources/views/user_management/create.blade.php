@extends('adminlte::page')

@section('title', 'Create New User')

@section('content_header')
<h2>Create New User</h2>
@stop
@section('content')
<div class="card">
    <div class="card-body">
        
         <form action="{{ route('management.user.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('POST')
                
                <div class="card-body">
                    {{-- Name --}}
                    <div class="form-group">
                        <label for="name">Full Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="" >
                        @error('name')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input 
                            type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="" >
                        @error('email')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="role"></label>
                        <select class="form-control" name="role" id="">
                            <option value="">Choose Role</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->name }}">{{ $role->name }}</option>
                            @endforeach
                            {{-- <option value="admin">Admin</option>
                            <option value="super_admin">Super Admin</option> --}}
                        </select>
                    </div>

                    {{-- Profile Image --}}
                    <div class="form-group">
                        <label for="image">Profile Image</label>                        
                        <input type="file" class="form-control-file @error('image') is-invalid @enderror" id="image" name="image">
                        @error('image')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <div class="form-group">
                            <label class="form-label" for="password">New Password</label>
                            <input class="form-control" name="password" type="password" placeholder="Enter a new password if you want to change it.">
                        </div>                        
                    </div>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Add User</button>
                </div>
            </form>
    </div>
</div>
@stop