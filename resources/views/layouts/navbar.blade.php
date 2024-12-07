<link rel="stylesheet" href="{{ asset('css/app.css') }}">
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

<header class="custom-header">
    <a href="#" class="custom-logo">Logo</a>
    <div class="custom-navbar" style="text-align: center;">
        <a href="#">Inicio</a>
        <a href="#">Haz tu <br>cotización</a>
        <a href="#">¿Comó Llegar?</a>
        <a href="#" style="text-align: center;">Paquetes <br>y<br> servicios</a>
        <a href="#" id="smalllogin">Iniciar Sesión o Crear Cuenta</a>
        <div class="custom-nav-bg"></div>
    </div>

    <div class="custom-navbar">
        <a href="#" style="text-align: center;">Iniciar Sesión <br>o<br> Crear Cuenta</a>
    </div>
    
    <i class='bx bx-menu' id="menu-icon"></i>
</header>

<script>
    const menuIcon = document.querySelector('#menu-icon');
    const navbar = document.querySelector('.custom-navbar');
    const navbg = document.querySelector('.custom-nav-bg');
    menuIcon.addEventListener('click', () => {
        menuIcon.classList.toggle('bx-x');
        navbar.classList.toggle('active');
        navbg.classList.toggle('active');
    });

    // Para la animación de cambio de color del navbar
    window.addEventListener('scroll', function () {
        const header = document.querySelector('.custom-header');
        header.classList.toggle('down', window.scrollY > 0);
    });

    const header = document.querySelector('.custom-header');
    let lastScrollY = 0;

    window.addEventListener('scroll', () => {
        const currentScrollY = window.scrollY;

        if (currentScrollY > lastScrollY) {
            // Scrolleando hacia abajo
            const maxOffset = parseFloat(getComputedStyle(header).getPropertyValue('--nav-height')) - 20; // Ajustar para dejar visible
            const offset = Math.min(currentScrollY, maxOffset) + 20;
            document.querySelector('.custom-navbar').classList.remove('active');
            document.querySelector('.custom-nav-bg').classList.remove('active');
            document.getElementById('menu-icon').classList.remove('bx-x');
            header.style.transform = `translateY(-${offset}px)`;
        } else {
            // Scrolleando hacia arriba
            header.style.transform = `translateY(0)`;
        }

        lastScrollY = currentScrollY;
    });
</script>
