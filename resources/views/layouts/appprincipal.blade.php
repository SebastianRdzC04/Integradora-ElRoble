<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=0.9">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
    <title>El Roble</title>
    <!--el app esta en el blade del navbar para optimizar espacio hay esta el script del navbar-->
</head>
<body style="background-color: antiquewhite; overflow-x:hidden;">
<!--importando el blade del navbar-->
    @include('layouts.navbar')

    <main style="min-height: 200vh;">
        
        <section id="inicio">        
            @include('startblades.animatedimages')
        </section>

        <!--importando el blade del carousel-->
        <section id="servicios">
            @include('startblades.carousel')
        </section>

        <section id="paquetes">
            @include('startblades.carousel2')
        </section>

        <section id="formulario">
            <div style="height:500px">
                aqui va el formulario
            </div>
        </section>

        <section id="googlemaps">
            <div class="container mb-5">
                <h2 class="text-center">Visítanos</h2>
                <div id="map" style="height: 400px; border: 2px solid white; border-radius: 10px;"></div>
            </div>
        </section>

        <section id="imagenes">
            @include('startblades.owlimages')
        </section>
        
    </main>
        <br>
        <br>
    <footer style="background-color: rgba(21, 58, 21, 0.87); color: white;" class="py-4">

        <div class="container d-flex justify-content-between align-items-center">
            <div>
                <h5 class="mb-2">El Roble</h5>
                <p class="mb-0">¡Tus eventos, nuestros mejores momentos!</p>
                <small>© 2024 El Roble. Todos los derechos reservados.</small>
            </div>
            <div>
                <img src="/images/logo.png" alt="Logo El Roble" class="img-fluid" style="max-height: 120px;">
            </div>
        </div>
    </footer>
    <script>
        function initMap() {
                const location = { lat: 25.497935161704735, lng: -103.39312323421343 }; // Coordenadas de "El Roble"
                const map = new google.maps.Map(document.getElementById('map'), {
                    zoom: 15,
                    center: location,
                });
                new google.maps.Marker({
                    position: location,
                    map: map,
                });
            }
    </script>
    <script src="https://unpkg.com/@dotlottie/player-component@2.7.12/dist/dotlottie-player.mjs" type="module"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCx4NNBGSBnu0ypvno3X4OSfXzVHRQbj1Y&callback=initMap" async defer></script>
</body>
</html>
i