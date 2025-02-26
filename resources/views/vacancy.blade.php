<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="icon" href="{{ asset('favicons/ISOLOGO.png') }}">
   <link rel="stylesheet" href="{{asset('css/vacancy.index.css')}}">
     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<style>
    /* Style untuk modal pop-up */
    .modal {
        display: none;
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.6); 
        padding-top: 100px; 
        animation: fadeIn 0.5s ease-in-out;
    }

   
    @keyframes fadeIn {
        0% {
            opacity: 0;
        }
        100% {
            opacity: 1;
        }
    }

    .modal-content {
        background-color: #c7f3a9;
        margin: 0 auto;
        padding: 30px;
        border-radius: 10px;
        width: 60%;
        box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.3);
        text-align: center;
        animation: slideIn 0.5s ease-out; /* Animasi masuk */
    }

    /* Animasi untuk konten modal */
    @keyframes slideIn {
        0% {
            transform: translateY(-50px);
            opacity: 0;
        }
        100% {
            transform: translateY(0);
            opacity: 1;
        }
    }

    
    .close {
        color: #aaa;
        font-size: 28px;
        font-weight: bold;
        position: absolute;
        right: 10px;
        top: 10px;
        cursor: pointer;
    }

    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
    }

    
    .modal p {
        font-size: 18px;
        color: #333;
    }
</style>
    <title>Vacancy Flyer</title>
</head>
<body>
   <div class="kontener">
        <div class="header" style="background-image: url({{asset('assets/bg.jpg')}}); background-repeat: no-repeat; background-size: cover">
            {{-- <div>
                <img src="{{asset('assets/bg.jpg')}}" width="40%" alt="">
            </div> --}}
            
            <div class="overley p-3 d-flex justify-items-end align-items-center">
                <div class="logo flex-lg">
                    <img src="{{asset('assets/ISOLOGO.png')}}" id="logo" alt="">
                </div>
            
            </div>
            {{-- <div class="title mt-4 mb-4 "><h1>Open Hiring</h1></div> --}}
        </div>

        <div class="middle" >

            <div class="top mb-3"> 
                <div class="title mt-4 d-flex justify-content-between">
                    <h1 class="">{{ $jobs->job_name}}</h1>
                    <div class="apply">
                        <a href="{{route('vacancy_form', $jobs->id)}}"  class="btn btn-warning btn-md-lg align-self-start">Apply Now</a>
                    </div>
                </div>
                <div class="title mt-1 mb-1"><h3>Employment Type : {{ $jobs->employment_type}}</h3></div>
                <div class="title mt-1 mb-1"><h3>Work Location : {{ (Str::lower($work_location) == 'company') ? $jobs->spesifikasi : $work_location }}</h3></div>
            </div>
            <div class="">
                {{-- <div class="col-6 konten">
                    
                </div> --}}
    
                <div class="responsibilty">
                    <div class="title d-flex justify-content-between align-items-center mb-3">
                        <h3>Responsibilities</h3>
                        <div class="apply2">
                            <a href="{{route('vacancy_form', $jobs->id)}}"  class="btn btn-warning btn-md-lg align-self-start">Apply Now</a>
                        </div>
                        </div>
                    <div class="text">
                        {!!$jobs->responsibilities !!}
                    </div>
                </div>
                <div class="requirements">
                    <div class="title"><h3>Requirements</h3></div>
                    <div class="text">
                        {!!$jobs->requirements !!}
                    </div>
                </div>
                <div class="konten">
                    <div class="benefit">
                        <div class="title"><h3>Benefit</h3></div>
                        <div class="text">
                            {!!$jobs->benefit !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- <div class="middle" >

            <div class=""> 
                <div class="title">
                    <h1 class="">{{ $jobs->job_name}}</h1>
                    <div class="apply">
                        <a href="{{route('vacancy_form', $jobs->id)}}"  class="btn btn-warning btn-md-lg align-self-start">Apply Now</a>
                    </div>
                </div>
                <div class="title"><h3>Employment Type : {{ $jobs->employment_type}}</h3></div>
                <div class="title"><h3>Work Location : {{ (Str::lower($work_location) == 'company') ? $jobs->spesifikasi : $work_location }}</h3></div>
            </div>
            <div class="">           
                <div class="responsibilty">
                    <div class="title"><h3>Responsibilities</h3></div>
                    <div class="text">
                        {!!$jobs->responsibilities !!}
                    </div>
                </div>
                <div class="requirements">
                    <div class="title"><h3>Requirements</h3></div>
                    <div class="text">
                        {!!$jobs->requirements !!}
                    </div>
                </div>
                <div class="konten">
                    <div class="benefit">
                        <div class="title"><h3>Benefit</h3></div>
                        <div class="text">
                            {!!$jobs->benefit !!}
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}


        {{-- <div class="footer"></div> --}}
        <div class="footer d-flex">
            <div class="kiri col-3 d-flex justify-content-center align-items-center">
                <div class="d-flex">
                    <img src="{{ asset('assets/QR.png') }}" alt="Barcode" id="barcode"/>              
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
{{-- 
   <div class="header"></div>
   <div class="middle"></div>
   <div class="footer"></div> --}}
   
   <!-- Modal Pop-up -->
    <div id="popupModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <p id="modalMessage"></p>
        </div>
    </div>

    <!-- Flash Message Script -->
    @if (session('success'))
        <script>
            window.onload = function() {
                var modal = document.getElementById('popupModal');
                var message = document.getElementById('modalMessage');
                message.textContent = "{{ session('success') }}";
                modal.style.display = "block";
            };

            function closeModal() {
                document.getElementById('popupModal').style.display = "none";
            }
        </script>
    @endif
    
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>