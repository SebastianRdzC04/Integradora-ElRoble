<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{asset('css/bootstrap.css')}}">
    <link rel="stylesheet" href="{{asset('css/globalstyles.css')}}">
    <link rel="stylesheet" href="{{asset('css/loginstyles.css')}}">
    <!--libreria para mostrar errores es toastr-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
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
    <script>
    // Configuración de Toastr
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": true,
        "progressBar": true,
        "positionClass": "toast-top-right", // Cambia la posición si lo necesitas
        "preventDuplicates": true,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000", // Duración de la notificación
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "slideDown",
        "hideMethod": "fadeOut"
    };
</script>
</head>
<body class="d-flex align-items-center justify-content-center" style="margin: 0;height: 100vh; overflow: hidden; min-height: 100vh;">

<script>
        // Verifica si hay errores de validación
        @if ($errors->any())
            // Itera sobre todos los errores y muestra un mensaje de Toastr
            @foreach ($errors->all() as $error)
                toastr.error("{{ $error }}", "Error", {
                    "closeButton": true,
                    "progressBar": true,
                    "positionClass": "toast-top-center",
                    "timeOut": "5000",
                });
            @endforeach
        @endif
</script>

@if(session('error'))
    <script>
        toastr.error("{{ session('error') }}");
    </script>
@endif

    <div class="background-image"></div>
    <div id="Container3" class="container d-flex justify-content-center content" style="min-width: 300px">
        <div id="LoginContainer" class="card shadow-lg border-0 rounded" style="min-width: 300px">
            <div id="LoginContainer2" class="card-body">
                
                <div class="d-flex justify-content-center mb-3">
                    
                    <img src="{{asset('images/logo sin letras.png') }}" class="img-login" alt="Descripción de la imagen">
                    
                </div>


                <div class="text-center mb-4">
                    <h5 style="color: aliceblue;">@yield('title form')</h5>
                    <h7 style="color: aliceblue;">@yield('subtitle form')</h7>
                </div>

                @yield('form')
            </div>
        </div>
    </div>
    <!--para la libreria de toastr es para sus animaciones de entrada-->
    <script src="https://www.google.com/recaptcha/api.js?render={{ config('services.recaptcha.site_key') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <!--esto es para configurar lo la notificacion que salta con cualquier error o mensaje de regreso como notificaion-->
    <script src="{{asset('js/bootstrap.min.js')}}"></script>
    @yield('script')
</body>

