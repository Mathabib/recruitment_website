@extends('adminlte::page')

@section('title', 'User List')

@section('content_header')
<h2>User List</h2>
@stop
@section('content')
<div class="card">
    <div class="card-body">
        
         <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('POST')

                <div class="card-body">
                    {{-- Name --}}
                    <div class="form-group">
                        <label for="name">Full Name</label>
                        <input 
                            type="text" 
                            class="form-control @error('name') is-invalid @enderror" 
                            id="name" 
                            name="name" 
                            value="{{ old('name', $user->name) }}" 
                            >
                        @error('name')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input 
                            type="email" 
                            class="form-control @error('email') is-invalid @enderror" 
                            id="email" 
                            name="email" 
                            value="{{ old('email', $user->email) }}" 
                            disabled>
                        @error('email')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Profile Image --}}
                    <div class="form-group">
                        <label for="image">Profile Image</label>
                        <div class="mb-2">
                            @if($user->image)
                                <img src="{{ asset('storage/'.$user->image) }}" 
                                     alt="Profile" 
                                     class="img-thumbnail" 
                                     width="120">
                            @else
                                <img src="https://via.placeholder.com/120" 
                                     alt="Profile" 
                                     class="img-thumbnail">
                            @endif
                        </div>
                        <input 
                            type="file" 
                            class="form-control-file @error('image') is-invalid @enderror" 
                            id="image" 
                            name="image">
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
                    <button type="submit" class="btn btn-primary">Update Profile</button>
                </div>
            </form>

    </div>
</div>
@stop