<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
    <title>El Roble</title>
    <!--el app esta en el blade del navbar para optimizar espacio hay esta el script del navbar-->
</head>
<body>
<!--importando el blade del navbar-->
    @include('layouts.navbar')

    <main style="min-height: 200vh;">
    <div class="custom-bg custom-back-image align-content-center" style="background-image: url('{{ asset('js/images/El Roble principal image.jpg') }}');">
        
        <div class="d-flex justify-content-center text-bg-info">
            <div>
                <p class="text-image-front p-3">Este es el texto de muestra</p>
            </div>
        </div>
    </div>
    <!--dentro de aqui debe de ir todo el contenido de la pagina-->

<!--importando el blade del carousel-->
    @include('layouts.carousel.carousel')

  </main>

</body>
</html>
i