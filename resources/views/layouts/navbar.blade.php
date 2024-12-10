<link rel="stylesheet" href="{{ asset('css/app.css') }}">
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="{{asset('js/app.js')}}"></script>
    <script> 
        document.getElementById('logout').addEventListener('click', (event)=>{
            event.preventDefault();
            document.getElementById('outlog').submit();
        })
    </script>