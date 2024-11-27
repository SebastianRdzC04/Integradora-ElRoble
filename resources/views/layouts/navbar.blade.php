<!-- resources/views/layouts/navbar.blade.php -->
<style>
    #IniciarSesionBoton {
        background-color: #2b1a06;
        padding: 10px;
        border-radius: 100px;
        color: white;
        margin-top: 20px;
        margin-bottom: 20px;
        border: 1px solid rgba(255, 255, 255, 0.904);
        box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.3);
        text-decoration: none;
    }

    .navbar {
        background-color: #000000a1 !important;
    }

    .navbar-brand,
    .nav-link {
        color: white !important;
    }

    .navbar-toggler-icon {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba(255, 255, 255, 0.75)' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e") !important;
    }

    .navbar-toggler {
        border-color: rgba(255, 255, 255, 0.5) !important;
    }
</style>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="/">
            <img src="{{ asset('images/logobranding.png') }}" width="170" height="45"
                class="d-inline-block align-top" style="margin-right: 10px" alt="">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="/">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/cotizaciones">Cotizaciones</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/historial">Historial</a>
                </li>
                <li>
                    <a class="nav-link" href=""></a>
                </li>
                @if (auth()->check())
                    @if (auth()->user()->roles->contains('id', 3))
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('dashboard')}}">Dashboard</a>
                        </li>
                    @endif

                @endif
            </ul>
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a href="/login" id="IniciarSesionBoton">Iniciar Sesión / Registrarse</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
