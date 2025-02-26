<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="{{asset('css/vacancy.index.css')}}">
    <link rel="icon" href="{{ asset('favicons/ISOLOGO.png') }}">
    <script src="https://kit.fontawesome.com/93bcf242b7.js" crossorigin="anonymous"></script>
    <title>vacancy flyer</title>
</head>
<body>
    

<div class="container">
    <div class="header d-flex flex-lg-row flex-sm-column justify-content-between" style="background-image: url({{asset('assets/bg.jpg')}}); background-repeat: no-repeat; background-size: cover">
        {{-- <div>
            <img src="{{asset('assets/bg.jpg')}}" width="40%" alt="">
        </div> --}}
        
        <div class="overley p-5 d-flex justify-content-between align-items-center">
            <div class="logo flex-lg">
                <img src="{{asset('assets/ISOLOGO.png')}}" width="200px" alt="">
            </div>
           
        </div>
        {{-- <div class="title mt-4 mb-4 "><h1>Open Hiring</h1></div> --}}
    </div>
    
    <div class="kontainer_vacancy" >

        <div class="top mb-3"> 
            <div class="title mt-4 row">
                <h1 class="col-6">{{ $jobs->job_name}}</h1>
                <div class="apply col-6 d-flex justify-content-end">
                    <a href="{{route('vacancy_form', $jobs->id)}}"  class="btn btn-warning btn-md-lg align-self-start">Apply Now</a>
                </div>
            </div>
            <div class="title mt-1 mb-1"><h3>Employment Type : {{ $jobs->employment_type}}</h3></div>
            <div class="title mt-1 mb-1"><h3>Work Location : {{ (Str::lower($work_location) == 'company') ? $jobs->spesifikasi : $work_location }}</h3></div>
        </div>
        <div class="row">
            {{-- <div class="col-6 konten">
                
            </div> --}}

            <div class="col-md-6 responsibilty">
                <div class="title"><h3>Responsibilities</h3></div>
                <div class="text">
                    {!!$jobs->responsibilities !!}
                </div>
            </div>
            <div class="col-md-6 requirements">
                <div class="title"><h3>Requirements</h3></div>
                <div class="text">
                    {!!$jobs->requirements !!}
                </div>
            </div>
            <div class="col-md-6 konten">
                <div class="benefit">
                    <div class="title"><h3>Benefit</h3></div>
                    <div class="text">
                        {!!$jobs->benefit !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="footer row align-items-end justify-content-evenly">


        <!--barcode-->
        <div class="kiri col-3 d-flex justify-content-center align-items-center">
            <div class="d-flex">
                <img src="{{ asset('assets/QR.png') }}" alt="Barcode" id="barcode"/>
                {{-- <div class="icon me-3 d-flex align-items-center">
                    <img src="{{ asset('assets/QR.png') }}" alt="Barcode" id="barcode"/>
                </div> --}}
            </div>
        </div>
        
        <div class="kanan col-8 row-sm d-flex align-items-center justify-content-center">
            <div class="alamat">
                <p id="alamat">
                    <strong>PT INTRA MULTI GLOBAL SOLUSI</strong> (I-Solutions Indonesia)<br>
                    Grand Galaxy City Jl. Cordova 3 Blok RGC3 No.58<br>
                    Jaka Setia – Bekasi Selatan – Jawa Barat 17147<br>
                    Phone : +62 (21) 8275 70 33<br>
                    Call Centre / Whatsapp : (62) 813 2000 9319 or http://wa.me/6281320009319
                </p>
            </div>
        </div>        
        
    </div>

</div>
    
    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="background-color: #d1e7dd">
            <div class="modal-header">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <h3>Your Application successfully submited</h3>
            </div>
        </div>
        </div>
    </div>

    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <script>
        @if(session('success'))

        $(document).ready(function(){
            $('#successModal').modal('show');
        })

        @endif

        // $(document).ready(function(){
        //     $('#successModal').modal('show');
        // })

    </script>
</body>
</html>