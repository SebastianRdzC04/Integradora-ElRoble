@php
    use Carbon\Carbon;
    use Illuminate\Support\Facades\Auth;

    $timeToStart = '00:00:00';

@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.bootstrap5.css">


    <!-- FullCalendar CSS -->
    <script src='https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.15/index.global.min.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/@fullcalendar/web-component@6.1.15/index.global.min.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@6.1.15/index.global.min.js'></script>

    @yield('styles')

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');

        ::after,
        ::before {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        a {
            text-decoration: none;
        }

        li {
            list-style: none;
        }

        h1 {
            font-weight: 600;
            font-size: 1.5rem;
        }

        body {
            font-family: 'Poppins', sans-serif;
        }

        .wrapper {
            display: flex;
        }

        .main {
            min-height: 100vh;
            width: 100%;
            overflow: hidden;
            transition: all 0.35s ease-in-out;
            background-color: #fafbfe;
        }

        #sidebar {
            width: 70px;
            min-width: 70px;
            z-index: 1000;
            transition: all .25s ease-in-out;
            background-image: url("{{ asset('images/imagen4.jpg') }}");
            background-size: cover;
            display: flex;
            flex-direction: column;
        }

        #sidebar.expand {
            width: 260px;
            min-width: 260px;
        }

        .toggle-btn {
            background-color: transparent;
            cursor: pointer;
            border: 0;
            padding: 1rem 1.5rem;
        }

        .toggle-btn i {
            font-size: 1.5rem;
            color: #FFF;
        }

        .sidebar-logo {
            margin: auto 0;
        }

        .sidebar-logo a {
            color: #FFF;
            font-size: 1.15rem;
            font-weight: 600;
        }

        #sidebar:not(.expand) .sidebar-logo,
        #sidebar:not(.expand) a.sidebar-link span {
            display: none;
        }

        .sidebar-nav {
            padding: 2rem 0;
            flex: 1 1 auto;
        }

        a.sidebar-link {
            padding: .625rem 1.625rem;
            color: #FFF;
            display: block;
            font-size: 0.9rem;
            white-space: nowrap;
            border-left: 3px solid transparent;
        }

        .sidebar-link i {
            font-size: 1.1rem;
            margin-right: .75rem;
        }

        a.sidebar-link:hover {
            background-color: rgba(255, 255, 255, .075);
            border-left: 3px solid #3b7ddd;
        }

        .sidebar-item {
            position: relative;
        }

        #sidebar:not(.expand) .sidebar-item .sidebar-dropdown {
            position: absolute;
            top: 0;
            left: 70px;
            background-color: #0e2238;
            padding: 0;
            min-width: 15rem;
            display: none;
        }

        #sidebar:not(.expand) .sidebar-item:hover .has-dropdown+.sidebar-dropdown {
            display: block;
            max-height: 15em;
            width: 100%;
            opacity: 1;
        }

        #sidebar.expand .sidebar-link[data-bs-toggle="collapse"]::after {
            border: solid;
            border-width: 0 .075rem .075rem 0;
            content: "";
            display: inline-block;
            padding: 2px;
            position: absolute;
            right: 1.5rem;
            top: 1.4rem;
            transform: rotate(-135deg);
            transition: all .2s ease-out;
        }

        #sidebar.expand .sidebar-link[data-bs-toggle="collapse"].collapsed::after {
            transform: rotate(45deg);
            transition: all .2s ease-out;
        }

        .avatar-icon {
            height: 25px;
            border-radius: 50%;
            object-fit: cover;
            margin: -3px;
            margin-right: 10px;
            border: 2px solid #fff;
        }

        .line-separator {
            border-bottom: 1px solid #ccc;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <div style="width: 70px; min-width: 70px;"></div>
        <aside id="sidebar" style="position:fixed" class="min-vh-100">
            <div class="d-flex line-separator">
                <button class="toggle-btn" type="button">
                    <i class="lni lni-grid-alt"></i>
                </button>
                <div class="sidebar-logo">
                    <a href="{{ route('dashboard') }}">Inicio</a>
                </div>
            </div>
            <div style="resize: none; width: 100%; max-height: 85vh; overflow-x:hidden; overflow-y: auto;">
                <ul class="sidebar-nav line-separator">
                    <li class="sidebar-item">
                        <a href="#" class="sidebar-link">
                            <img src="https://lh3.googleusercontent.com/a/ACg8ocL87_YvuvpyJQMCkj8DgnlG9qKUx4z4O0z-uaLGRd8z7eiyqA=s96-c"
                                alt="Avatar" class="avatar-icon">
                            <span>Perfil</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="{{ route('dashboard.graphics') }}" class="sidebar-link">
                            <i class="lni lni-agenda"></i>
                            <span>Graficos</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse"
                            data-bs-target="#auth" aria-expanded="false" aria-controls="auth">
                            <i class="lni lni-protection"></i>
                            <span>Inventario</span>
                        </a>
                        <ul id="auth" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                            <li class="sidebar-item">
                                <a href="{{ route('dashboard.consumables') }}" class="sidebar-link">Insumos</a>
                            </li>
                            <li class="sidebar-item">
                                <a href="{{ route('dashboard.inventory') }}" class="sidebar-link">Equipamiento</a>
                            </li>
                        </ul>
                    </li>
                    <li class="sidebar-item">
                        <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse"
                            data-bs-target="#multi" aria-expanded="false" aria-controls="multi">
                            <i class="lni lni-layout"></i>
                            <span>Formularios</span>
                        </a>
                        <ul id="multi" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                            <li class="sidebar-item">
                                <a href="{{ route('dashboard.records') }}" class="sidebar-link">Records</a>
                            </li>
                            <li class="sidebar-item">
                                <a href="{{ route('dashboard.packages') }}" class="sidebar-link">Paquetes</a>
                            </li>
                            <li class="sidebar-item">
                                <a href="{{ route('dashboard.services') }}" class="sidebar-link">Servicios</a>
                            </li>
                            <li class="sidebar-item">
                                <a href="{{ route('dashboard.events') }}" class="sidebar-link">Eventos</a>
                            </li>
                            <li class="sidebar-item">
                                <a href="{{ route('dashboard.quotes') }}" class="sidebar-link">Cotizaciones</a>
                            </li>
                        </ul>
                    </li>
                    <li class="sidebar-item">
                        <a href="#" class="sidebar-link">
                            <i class="lni lni-popup"></i>
                            <span>Notificaciones</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="#" class="sidebar-link">
                            <i class="lni lni-cog"></i>
                            <span>Configuracion</span>
                        </a>
                    </li>
                </ul>
                <div class="sidebar-footer">
                    <form id="myForm" action="{{ route('logout') }}" method="POST">
                        @csrf
                        <a href="#" onclick="document.getElementById('myForm').submit(); return false;"
                            class="sidebar-link">
                            <i class="lni lni-exit"></i>
                            <span>Logout</span>
                        </a>
                    </form>
                </div>
            </div>
        </aside>
        <div class="main p-3">
            <div class="text-center">

                @yield('content')

            </div>
        </div>
    </div>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.bootstrap5.js"></script>
    <script src="script.js"></script>

    <script>
        const hamBurger = document.querySelector(".toggle-btn");

        hamBurger.addEventListener("click", function() {
            document.querySelector("#sidebar").classList.toggle("expand");
        });
    </script>
    @yield('scripts')
</body>

</html>
