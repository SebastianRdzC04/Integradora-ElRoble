<!-- navbar_new.blade.php -->
<style>
    :root {
        --nav-height: 80px;
        --nav-bg-transparent: rgba(0, 0, 0, 0.22);
        --nav-bg-solid: rgba(255, 255, 255, 0.9);
        --nav-text-light: #fff;
        --nav-text-dark: #000;
        --nav-hover-color: #f00;
    }

    .custom-header {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: var(--nav-height);
        background: rgb(0 0 0 / 22%);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 4%;
        transition: all 0.3s ease-in-out;
        z-index: 1000;
    }

    .custom-header.scrolled {
        background: var(--nav-bg-solid);
    }

    .custom-logo {
        display: block;
        width: 100px;
        height: 100px;
        background-size: contain;
        background-repeat: no-repeat;
        background-position: center;
        transition: transform 0.3s ease;
    }

    .custom-logo:hover {
        transform: scale(1.05);
    }

    .custom-navbar {
        display: flex;
        align-items: center;
    }

    .custom-navbar a {
        color: var(--nav-text-light);
        font-size: 18px;
        text-decoration: none;
        margin-left: 20px;
        transition: 0.3s;
        text-align: center;
    }

    .custom-navbar a:hover {
        color: var(--nav-hover-color);
    }

    .custom-header.scrolled .custom-navbar a {
        color: var(--nav-text-dark);
    }

    #menu-icon {
        font-size: 36px;
        color: var(--nav-text-light);
        cursor: pointer;
        display: none;
    }

    .custom-header.scrolled #menu-icon {
        color: var(--nav-text-dark);
    }

    .checando {
        align-items: center;
    }

    .checando a {
        color: var(--nav-text-light);
        font-size: 18px;
        text-decoration: none;
        transition: 0.3s;
        text-align: center;
    }

    .checando a:hover {
        color: var(--nav-hover-color);
    }

    @media (max-width: 992px) {
        .custom-navbar {
            position: fixed;
            top: var(--nav-height);
            left: -100%;
            width: 100%;
            padding: 10px 4%;
            background: var(--nav-bg-solid);
            flex-direction: column;
            align-items: flex-start;
            transition: 0.3s;
        }

        .custom-navbar.active {
            left: 0;
        }

        .custom-navbar a {
            display: block;
            margin: 10px 0;
            color: var(--nav-text-dark);
        }

        #menu-icon {
            display: block;
        }

        .nav-item {
            position: relative;
            overflow: hidden;
        }

        .nav-item::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 2px;
            background-color: var(--nav-hover-color);
            transform: translateX(-100%);
            transition: transform 0.3s ease;
        }

        .nav-item:hover::after {
            transform: translateX(0);
        }
    }
</style>

<header class="custom-header">
    <a href="{{ url('/') }}" class="custom-logo" style="background-image: url('{{ asset('images/logo.png') }}');"></a>
    <nav class="custom-navbar">
        <a href="#imagenes" class="nav-item">Fotos</a>
        
        @if(auth()->user() && auth()->user()->roles->contains('id', 1))
            <a href="{{ route('cotizaciones.nuevaAdmin') }}" class="nav-item">Haz tu cotización</a>
        @else
            <a href="{{ route('cotizaciones.nueva') }}" class="nav-item">Haz tu cotización</a>
        @endif

        <a href="#googlemaps" class="nav-item">¿Cómo Llegar?</a>
        <a href="#servicios" class="nav-item">Paquetes y servicios</a>

        @if (!auth()->user())
            <a href="{{route('login')}}" class="nav-item">Iniciar Sesión o Crear Cuenta</a>
            </nav>
            <i class='bx bx-menu' id="menu-icon"><a href="#inicio"></a></i>
        @else
            </nav>
            <div class="checando d-flex">
                <a href="#" class="d-flex align-items-center justify-content-center p-3 link-body-emphasis text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="{{auth()->user()->avatar}}" alt="mdo" width="40" height="40" class="rounded-circle">
                </a>
                <ul class="dropdown-menu text-small shadow" style="background: rgb(0 0 0 / 60%);">
                    <li><a class="dropdown-item nav-item" href="#">Historial</a></li>
                    @if (auth()->user()->roles->contains('id', 2))
                    <li><a class="dropdown-item nav-item" href="{{route('dashboard')}}">Dashboard</a></li>
                    @endif
                    <li><a class="dropdown-item nav-item" href="#">Configuracion</a></li>
                    <li><a class="dropdown-item nav-item" href="#">Perfil</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a id="logout" class="dropdown-item nav-item" href="#">Cerrar Sesion</a></li>
                </ul>
                <i class='bx bx-menu' id="menu-icon"></i>
            </div>

            <form method="POST" id="outlog" style="display: none;" action="{{route('logout')}}">
                @csrf
            </form>
        @endif
</header>

<script>
    document.getElementById('logout').addEventListener('click', (event)=>{
        event.preventDefault();
        document.getElementById('outlog').submit();
    })
</script>