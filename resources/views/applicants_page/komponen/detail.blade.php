<head>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<style>
    body {
        font-family: 'Poppins', sans-serif;
    }
    .text {
    font-size: 14px;
    line-height: 1.5;
}
.job-name1 {
    font-size: 24px;
    font-weight: 600;
    margin: 0;
}
.title {
    font-size: 18px;
    line-height: 1.5;
}

.shadow {
    box-shadow: 0 5px 10px rgba(0, 0, 255, 0.2);
    padding: 25px;
    border-radius: 8px;
}

.flexbox-back{
    display: none;
}

#back_button{
    font-style: none;
    color: black;
    text-decoration: none;
}

@media(max-width: 750px){
    .flexbox-back{
        display: block;
        display: flex;
        justify-content: end;
    }
}

</style>

<body>


<div class="shadow">
<div class="title mt-4 d-flex justify-content-between">

     <div class="flexbox-back" style="">
        <a id="back_button" href="{{route('list')}}">
            <i class="fa fa-arrow-left" aria-hidden="true"></i> Back
        </a>
    </div>
    <div>
        <h1 class="job-name1">{{ $job->job_name }}</h1>
    </div>
    <div class="apply">
            @if(Auth::check())
                <a href="{{ route('applicant_page.jobs.apply', $job->id) }}" class="btn text-white {{ Auth::user()->applicant->job_id != null ? 'disabled' : '' }}" style="background: #800">Apply Now</a>
            @endif
        <!--<a href="{{ route('vacancy_form', $job->id) }}" class="btn btn-primary btn-sm">Apply Now</a>-->
        {{-- <a href="{{ route('applicant_page.jobs.apply', $job->id) }}" class="{{ !Auth::check() ? 'd-none' : '' }} btn text-white" style="background: #800">Apply Now</a> --}}
        <button class="btn text-white {{ Auth::check() ? 'd-none' : '' }} " style="background: #800" data-bs-toggle="modal" data-bs-target="#exampleModal">Apply Now</button>
    </div>
</div>

    <!-- Employment Type and Work Location -->
    <div class="title mt-3 mb-4">
        <div class="job-detail">
            <i class="fas fa-briefcase"></i>
            <span>Employment Type: {{ $job->employment_type }}</span>
        </div>
        <div class="job-detail">
            <i class="fas fa-map-pin"></i>
            <span>Work Location: {{ $job->workLocation->location }}</span>
        </div>
    </div>
    
    @if(Auth::check())
        @if(Auth::user()->applicant->job_id != null)
            <div>
                <p style="color: red">**Anda hanya dapat melamar satu posisi hingga lamaran Anda selesai diproses.</p>
            </div>
        @endif
    @endif


</div>
 <br>


<div class="row">
    <div class="col-md-12 responsibilty">
        <div class="title">Responsibilities</div>
        <div class="text">
            {!! $job->responsibilities ?? 'No responsibilities provided.' !!}
        </div>
    </div>
    <div class="col-md-12 requirements">
        <div class="title">Requirements</div>
        <div class="text">{!! $job->requirements ?? 'No requirements provided.' !!}</div>
    </div>
    <div class="col-md-12 benefit">
        <div class="title">Benefit</div>
        <div class="text">{!! $job->benefit !!} </div>
</div>
</div>

{{-- POPUP MODALS --}}

<!-- modal informasi -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-body">
         <div class="modal-header">
            <h5 class="modal-title"></h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div>
            <H3 class="text-center">Sepertinya kamu belum punya akun</H3>
            <p class="text-center">Registrasi terlebih dahulu sebelum mendaftar</p>
        </div>
        <div class="d-flex flex-column justify-content-center">
            <button class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#registerModal">Registrasi untuk membuat akun</button>
            <p class="text-center">Atau</p>
            <button class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#modalLogin" >Login jika sudah punya akun </button>
        </div>
      </div>
    </div>
  </div>
</div>


<!-- Modal login -->
<div class="modal fade" id="modalLogin" tabindex="-1" aria-labelledby="modalLoginLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-body">
        <div class="modal-header">
            <div>
                <img width="150px" src="{{ asset('assets/ISOLOGO.png') }}" alt="">
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

        </div>
        <form action="{{ route('login') }}" method="post">
            @csrf
            <div>
                <div class="form-group">
                    <label class="form-label" for="email">Email</label>
                    <input class="form-control" name="email" type="email">
                </div>
                <div class="form-group">
                    <label class="form-label" for="password">Password</label>
                    <input class="form-control" name="password" type="password">
                </div>
            </div>
            <div class="mt-5 d-flex flex-column justify-content-center">
                <Button type="submit" class="btn btn-outline-danger btn-lg">Login</Button>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>


</body>
