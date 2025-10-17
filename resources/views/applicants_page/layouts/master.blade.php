<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Recruitment Isolutions</title>
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous"> --}}
    <link rel="stylesheet" href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    @yield('content_header')

  </head>
  <body>

    <header>
            <div class="fixed-top">
                <nav class="navbar navbar-dark navbar-expand-lg bg-body-tertiary " style="z-index: 1030">
                    <div class="container-fluid" style="background: #800">
                        <a class="navbar-brand" href="#">
                            <div class="bg-white p-1 m-2" style="border-radius: 10px">
                                <img width="150px" src="{{ asset('assets/ISOLOGO.png') }}" alt="">
                            </div>
                        </a>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class=" navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            {{-- <li class="nav-item mx-2">
                            <a class="nav-link text-white" aria-current="page" href="{{ route('applicant_page.index') }}">Home</a>
                            </li> --}}
                            <li class="nav-item mx-2">
                            <a class="nav-link text-white" href="{{ route('applicant_page.jobs') }}"><i class="fas fa-briefcase"></i> Job vacancy</a>
                            </li>
                            @if(!Auth::check())
                                <li class="nav-item mx-2 d-block d-md-none">
                                <a class="nav-link text-white" aria-current="page" href="{{ route('login') }}">Login</a>
                                </li>
                                <li class="nav-item mx-2 d-block d-md-none">
                                <a class="nav-link text-white" aria-current="page" href="#" data-bs-toggle="modal" data-bs-target="#registerModal">Register</a>
                                </li>
                            @endif
                            @if(Auth::check())
                                <li class="nav-item mx-2">
                                <a class="nav-link text-white" href="{{ route('applicant_page.profile') }}"><i class="fas fa-user-alt"></i> Profile</a>
                                </li>
                                {{-- <li class="nav-item mx-2">
                                <a class="nav-link text-white" href="{{ route('applicant_page.jobs.applications') }}"><i class="far fa-file"></i> Your Application</a>
                                </li> --}}
                                <li class="nav-item mx-2 d-block d-md-none">
                                    <a class="nav-link text-white" href="#"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                    >
                                    <i class="fas fa-sign-out-alt"></i> Log out
                                    </a>
                                </li>
                            @endif
                        </ul>
                        </div>
                        @if(Auth::check())
                            <div class="p-2 bg-white rounded-3 d-none d-md-block">
                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        {{ Auth::user()->name }}
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="{{ route('applicant_page.profile') }}">Profile</a></li>
                                        {{-- <li><a class="dropdown-item" href="{{ route('applicant_page.jobs.applications') }}">Your Application</a></li> --}}
                                        <li><a class="dropdown-item" href="#"
                                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                            >Log out</a>
                                        </li>
                                    </ul>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </div>
                        @endif
                        @if(!Auth::check())
                            <div class="d-none d-md-block">
                                <div class="collapse navbar-collapse" id="navbarSupportedContent2">
                                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                                        <li class="nav-item mx-2">
                                        <a class="nav-link text-white border" aria-current="page" href="{{ route('login') }}">Login</a>
                                        </li>
                                        <li class="nav-item mx-2">
                                        <a class="nav-link text-white border" aria-current="page" href="#" data-bs-toggle="modal" data-bs-target="#registerModal">Register</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        @endif
                    </div>

                </nav>
            </div>
    </header>

     <!-- Modal -->
        <div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <form action="{{ route('applicant_page.register') }}" method="post">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="registerLabel" style="color: #800">Register</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div>
                                <div class="mb-3">
                                    <label for="name" class="form-label fw-bold" style="color: #800">Name</label>
                                    <input required type="text" class="form-control" value="{{ old('name') }}" name="name">
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label fw-bold" style="color: #800">Email</label>
                                    <input required type="email" class="form-control" value="{{ old('email') }}" name="email">
                                    @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="phone" class="form-label fw-bold" style="color: #800">Phone Number</label>
                                    <input required type="text" class="form-control" value="{{ old('phone') }}" name="phone">
                                    @error('phone')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="address" class="form-label fw-bold" style="color: #800" >Address</label>
                                    <textarea class="form-control" name="address" id=""  rows="2" required></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label fw-bold" style="color: #800" >Password</label>
                                    <input required type="password" class="form-control" value="{{ old('password') }}" name="password">
                                    @error('password')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="password_confirmation" class="form-label fw-bold" style="color: #800" >Confirm Password</label>
                                    <input required type="password" class="form-control" name="password_confirmation">
                                    @error('password_confirmation')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                            </div>
                        </div>
                        <div class="modal-footer d-flex justify-content-center">
                            <button type="submit" class="btn w-100 text-white fw-bold" style="background: #800">Sign Up</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <main>

        <div class="container" style="margin-top: 150px">
            @yield('content')
        </div>
    </main>

    <footer>

    </footer>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            @if ($errors->any())
                var registerModal = new bootstrap.Modal(document.getElementById('registerModal'));
                registerModal.show();
            @endif
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    @yield('js')
  </body>
</html>
