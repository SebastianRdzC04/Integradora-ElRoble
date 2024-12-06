<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>El Roble</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    @include('layouts.navbar')

    <main>
    <div id="generalcontent">
    <div class="custom-bg" style="width: 100%; height: 100vh; background-image: url('{{ asset('js/images/El Roble principal image.jpg') }}'); background-size: cover; background-position: center; background-repeat: no-repeat;">
        <!-- Aquí va el contenido de la página -->
    </div>
</div>

    </main>

<script>
const menuIcon = document.querySelector('#menu-icon');
const navbar = document.querySelector('.navbar');
const navbg = document.querySelector('.nav-bg');
menuIcon.addEventListener('click', () => {
    menuIcon.classList.toggle('bx-x');
    navbar.classList.toggle('active');
    navbg.classList.toggle('active');
});
</script>
</body>
</html>
