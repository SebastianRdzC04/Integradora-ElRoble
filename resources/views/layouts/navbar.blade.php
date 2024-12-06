<link rel="stylesheet" href="{{ asset('css/app.css') }}">
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

<header class="header">
    <a href="#" class="logo">Logo</a>
    <nav class="navbar" style="text-align: center;">
            <a href="#">Inicio</a>
            <a href="#">Haz tu <br>cotización</a>
            <a href="#">¿Comó Llegar?</a>
            <a href="#" style="text-align: center;">Paquetes <br>y<br> servicios</a>
        <a href="#" id="smalllogin">Iniciar Sesion o crear cuenta</a>
    </nav>

    <nav class="navbar">
        <a href="#" style="text-align: center;">Iniciar Sesion <br>o<br> crear cuenta</a>
    </nav>
    
    <i class='bx bx-menu' id="menu-icon"></i>
</header>
<div class="nav-bg"></div>

<script>
const menuIcon = document.querySelector('#menu-icon');
const navbar = document.querySelector('.navbar');
const navbg = document.querySelector('.nav-bg');
menuIcon.addEventListener('click', () => {
    menuIcon.classList.toggle('bx-x');
    navbar.classList.toggle('active');
    navbg.classList.toggle('active');
});
//para la animacion de cambio de color del navbar
window.addEventListener('scroll', function () {
    var header =document.querySelector('header');
    header.classList.toggle('down',window.scrollY>0);
});


const header = document.querySelector('.header');
let lastScrollY = 0;

window.addEventListener('scroll', () => {
  const currentScrollY = window.scrollY;

  if (currentScrollY > lastScrollY) {
    // Scrolleando hacia abajo
    const maxOffset = parseFloat(getComputedStyle(header).getPropertyValue('--nav-height')) - 20; // Ajustar para dejar visible
    const offset = Math.min(currentScrollY, maxOffset) + 20;
    header.style.transform = `translateY(-${offset}px)`;
  } else {
    // Scrolleando hacia arriba
    header.style.transform = `translateY(0)`;
  }

  lastScrollY = currentScrollY;
});
</script>
