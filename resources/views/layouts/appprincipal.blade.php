<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>El Roble</title>
</head>
<body>
    @include('layouts.navbar')

    <main style="min-height: 200vh;">
    <div class="custom-bg back-image" style="background-image: url('{{ asset('js/images/El Roble principal image.jpg') }}');">
        <!--dentro de aqui debe de ir el texto-->
    </div>
    <!--dentro de aqui debe de ir todo el contenido de la pagina-->
    @include('layouts.carousel.carousel')


</div>

    </main>


</body>
</html>
