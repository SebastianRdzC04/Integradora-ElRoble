<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{asset('css/bootstrap.css')}}">
    <link rel="stylesheet" href="{{asset('css/globalstyles.css')}}">
    <link rel="stylesheet" href="{{asset('css/loginstyles.css')}}">
    @yield('link')
    @yield('style')
    <style>
        .background-image {
            position: fixed; 
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url("{{ asset('js/images/El roble photo1.jpg') }}");
            background-size: cover;  
            background-position: center; 
            background-repeat: no-repeat; 
            filter: blur(8px); 
            z-index: -1; 
        }
    </style>
</head>
<body class="d-flex align-items-center justify-content-center" style="margin: 0;height: 100vh; overflow: hidden; min-height: 100vh;">
    <div class="background-image"></div>
    <div id="Container3" class="container d-flex justify-content-center content" style="min-width: 300px">
        <div id="LoginContainer" class="card shadow-lg border-0 rounded" style="min-width: 300px">
            <div id="LoginContainer2" class="card-body">
                
                <div class="d-flex justify-content-center mb-3">
                    
                    <img src="{{asset('images/logo sin letras.png') }}" class="img-login" alt="Descripción de la imagen">
                    
                </div>


                <div class="text-center mb-4">
                    <h5>@yield('title form')</h5>
                    <h7>@yield('subtitle form')</h7>
                </div>

                @yield('form')
            </div>
        </div>
    </div>
    @yield('script')
    <script src="{{asset('js/bootstrap.min.js')}}"></script>
</body>

