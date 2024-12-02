<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'El Roble')</title>
    <link rel="icon" type="image/x-icon" href="@yield('icon', asset('favicon.ico'))">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css" rel="stylesheet">

    <!-- Lottie Player -->
    <script src="https://unpkg.com/@dotlottie/player-component@2.7.12/dist/dotlottie-player.mjs" type="module"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.10.2/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.min.js"></script>

    <style>
        #loader-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.9);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }
    </style>

    <!-- Custom CSS -->
    @yield('styles')
</head>
<body>
    <!-- Loader Overlay -->
    <div id="loader-overlay">
        <dotlottie-player 
            src="https://lottie.host/8f702d16-1b8c-4fd1-865f-8da29de7211b/QsqCFtbcCb.lottie" 
            background="transparent" 
            speed="1" 
            style="width: 300px; height: 300px" 
            loop 
            autoplay>
        </dotlottie-player>
    </div>

    @include('layouts.navbar')

    <div class="container mt-4">
        @yield('content')
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Loader Control -->
    <script>
        window.showLoader = function() {
            document.getElementById('loader-overlay').style.display = 'flex';
        }
        
        window.hideLoader = function() {
            document.getElementById('loader-overlay').style.display = 'none';
        }
    </script>

    <!-- Custom Scripts -->
    @yield('scripts')
</body>
</html>