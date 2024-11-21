@php
    use Carbon\Carbon;
    use Illuminate\Support\Facades\Auth;

    $timeToStart = '00:00:00';

@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- Bootstrap CSS -->

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
    <title>@yield('title')</title>
    <style>

        
        body {
            background-color: #f8f6f5;
        }

        main {
            display: grid;
            grid-template-columns: 2fr 15fr;
        }

        .sidebar {
            height: 100%;
        }

        #barra-lateral {
            background: radial-gradient(circle,#3a2012, #351a0c, #412415 );
            background-size: cover;
            color: white;
        }
    </style>
</head>

<body>
    <main>
        <div class="container-fluid sidebar" id="barra-lateral">
            <div class="row flex-nowrap sidebar">
                <div class="col-12 px-sm-2 px-0">
                    <div
                        class="sidebar d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 text-white min-vh-100">
                        <a href="/"
                            class="d-flex align-items-center pb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                            <span class="fs-5 d-none d-sm-inline">Menu</span>

                            <div class="dropdown pb-4">
                                <a href="#"
                                    class="d-flex align-items-center text-white text-decoration-none dropdown-toggle"
                                    id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                                    <img src="{{Auth::user()->avatar ? Auth::user()->avatar : ''}}" alt="hugenerd" width="30" height="30"
                                        class="rounded-circle">
                                    <span class="d-none d-sm-inline mx-1">{{Auth::user()->person->firstName}}</span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
                                    <li><a class="dropdown-item" href="#">New project...</a></li>
                                    <li><a class="dropdown-item" href="#">Settings</a></li>
                                    <li><a class="dropdown-item" href="#">Profile</a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item" href="#">Sign out</a></li>
                                </ul>
                            </div>
                        </a>
                        <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start"
                            id="menu">
                            <li class="nav-item">
                                <a href="#" class="nav-link align-middle px-0">
                                    <i class="fs-4 bi-house text-white"></i> <span
                                        class="ms-1 text-white d-none d-sm-inline">Home</span>
                                </a>
                            </li>
                            <li>
                                <a href="#submenu1" data-bs-toggle="collapse" class="nav-link px-0 align-middle">
                                    <i class="fs-4 bi-speedometer2 text-white"></i> <span
                                        class="text-white ms-1 d-none d-sm-inline">Dashboard</span> </a>
                                <ul class="collapse nav flex-column ms-1" id="submenu1" data-bs-parent="#menu">
                                    <li class="w-100">
                                        <a href="{{ route('dashboard') }}" class="nav-link px-0"> <span
                                                class="d-none d-sm-inline text-white">Inicio</span> </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('dashboard.graphics') }}" class="nav-link px-0"> <span
                                                class="d-none d-sm-inline text-white">Graficos</span> </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('dashboard.records') }}" class="nav-link px-0"> <span
                                                class="d-none d-sm-inline text-white">Registro</span> </a>
                                    </li>

                                </ul>
                            </li>
                            <li>
                                <a href="#submenu2" data-bs-toggle="collapse" class="nav-link px-0 align-middle">
                                    <i class="fs-4 bi bi-table text-white"></i> <span
                                        class="ms-1 d-none d-sm-inline text-white">Registros</span>
                                </a>
                                <ul class="collapse nav flex-column ms-1" id="submenu2" data-bs-parent="#menu">
                                    <li class="w-100">
                                        <a href="{{ route('dashboard.packages') }}" class="nav-link px-0"> <span
                                                class="d-none d-sm-inline text-white">Paquetes</span> </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('dashboard.services') }}" class="nav-link px-0"> <span
                                                class="d-none d-sm-inline text-white">Servicios</span> </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('dashboard.events') }}" class="nav-link px-0"> <span
                                                class="d-none d-sm-inline text-white">Eventos</span> </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('dashboard.quotes') }}" class="nav-link px-0"> <span
                                                class="d-none d-sm-inline text-white">Cotizaciones</span> </a>
                                    </li>

                                </ul>
                            </li>
                            <li>
                                <a href="#submenu3" data-bs-toggle="collapse" class="nav-link px-0 align-middle">
                                    <i class="fs-4 bi bi-archive text-white"></i> <span
                                        class="ms-1 d-none d-sm-inline text-white">Inventario</span> </a>
                                <ul class="collapse nav flex-column ms-1" id="submenu3" data-bs-parent="#menu">
                                    <li class="w-100">
                                        <a href="{{ route('dashboard.consumables') }}" class="nav-link px-0"> <span
                                                class="d-none d-sm-inline text-white">Insumos</span> </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('dashboard.inventory') }}" class="nav-link px-0"> <span
                                                class="d-none d-sm-inline text-white">Equipamiento</span> </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>


                    </div>
                </div>
            </div>
        </div>
        <div class="contenido">
            @yield('content')
        </div>
    </main>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.bootstrap5.js"></script>

    @yield('scripts')
</body>

</html>
