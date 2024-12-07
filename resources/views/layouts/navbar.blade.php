    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <header class="custom-header">
        <a href="{{ url('/') }}" class="custom-logo" style="background-image: url('{{ asset('images/logo.png') }}');"></a>
        <nav class="custom-navbar">
            <a href="#" class="nav-item">Fotos</a>
            <a href="#form" class="nav-item">Haz tu cotización</a>
            <a href="#googlemaps" class="nav-item">¿Cómo Llegar?</a>
            <a href="#tranding" class="nav-item">Paquetes y servicios</a>

            @if (auth()->user())
                <a href="{{route('login')}}" class="nav-item">Iniciar Sesión o Crear Cuenta</a>
                </nav>
                <i class='bx bx-menu' id="menu-icon"></i>

            @else
                </nav>
                <div class="checando d-flex">
                    <a href="#" class="d-flex align-items-center justify-content-center p-3 link-body-emphasis text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="https://github.com/mdo.png" alt="mdo" width="24" height="24" class="rounded-circle">
                    </a>
                    <ul class="dropdown-menu text-small shadow" style="background: rgb(0 0 0 / 60%);">
                        <li><a class="dropdown-item nav-item" href="#">New project...</a></li>
                        <li><a class="dropdown-item nav-item" href="#">Settings</a></li>
                        <li><a class="dropdown-item nav-item" href="#">Profile</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item nav-item" href="{{route('logout')}}">Cerrar Sesion</a></li>
                    </ul>
                    <i class='bx bx-menu' id="menu-icon"></i>
                </div>

            @endif
        
    </header>
    <script>
        const header = document.querySelector('.custom-header');
        const menuIcon = document.querySelector('#menu-icon');
        const navbar = document.querySelector('.custom-navbar');
        let lastScrollY = 0;
        let isNavVisible = true;

        menuIcon.addEventListener('click', () => {
            menuIcon.classList.toggle('bx-x');
            navbar.classList.toggle('active');
        });

        window.addEventListener('scroll', () => {
            const currentScrollY = window.scrollY;

            // Cambiar color del navbar
            if (currentScrollY > 50) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }

            // Ocultar/mostrar navbar
            if (currentScrollY > lastScrollY && isNavVisible) {
                header.style.transform = `translateY(-${header.offsetHeight}px)`;
                isNavVisible = false;
            } else if (currentScrollY < lastScrollY && !isNavVisible) {
                header.style.transform = 'translateY(0)';
                isNavVisible = true;
            }

            lastScrollY = currentScrollY;
        });

        // Cerrar menú al hacer clic en un enlace (para móviles)
        document.querySelectorAll('.custom-navbar a').forEach(link => {
            link.addEventListener('click', () => {
                navbar.classList.remove('active');
                menuIcon.classList.remove('bx-x');
            });
        });
    </script>