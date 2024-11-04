<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{asset('css/layouts.css')}}">
    <link rel="canonical" href="https://getbootstrap.com/docs/5.3/examples/sign-in/">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@docsearch/css@3">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    
    <div class="side-bar sidebar-content">
        <div class="d-flex flex-column flex-shrink-0 p-3 text-bg-dark">
            <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                <span class="fs-4">Panel de control</span>
            </a>
            <hr>

            <ul class="nav nav-pills flex-column mb-auto">
                <li class="nav-item">
                    <a href="#" class="nav-link active" aria-current="page">Estadisticas</a>
                </li>
                <li>
                    <a href="/Ajedres" class="nav-link text-white">Ajedres</a>
                </li>
                <li>
                    <a href="/Molino" class="nav-link text-white">Molino</a>
                </li>

                <!-- Opciones visibles solo para usuarios autenticados -->
                    <!-- Accesible para Usuario Registrado (role_id 4) y roles superiores -->
                        <li><a href="/figuras" class="nav-link text-white">Figuras</a></li>
                        <li><a href="/Calculadora" class="nav-link text-white">Calculadora</a></li>
                        <li><a href="/Multiplicacion" class="nav-link text-white">Tablas de multiplicar</a></li>
                        <li><a href="/sumatoria" class="nav-link text-white">Sumatoria</a></li>
                        <li><a href="/factorial" class="nav-link text-white">Factorial</a></li>
                        <li><a href="/fibonaci" class="nav-link text-white">Fibonachi</a></li>

                    <!-- Accesible para Administrador, Moderador y Marketing (role_id 1, 2, 3) -->
                        <li><a href="/personas" class="nav-link text-white">Lista de personas</a></li>

                    <!-- Exclusivo para Administrador (role_id 1) -->
                        <li><a href="/personas/create" class="nav-link text-white">Crear personas, Actualizar, Eliminar</a></li>
            </ul>

            <hr>

            <div class="dropdown">
                <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="https://github.com/mdo.png" alt="" width="32" height="32" class="rounded-circle me-2">
                </a>
                <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
                    <li><a class="dropdown-item" href="#">New project...</a></li>
                    <li><a class="dropdown-item" href="#">Settings</a></li>
                    <li><a class="dropdown-item" href="#">Profile</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="#" id="logoutLink">Sign out</a></li>
                </ul>
            </div>
        </div>
    </div>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
