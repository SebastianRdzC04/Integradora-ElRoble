<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>El Roble - Inicio</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/stylesinicio.css') }}">
</head>
<body>
  <!-- Carrusel -->
  <div id="carouselExample" class="carousel slide mb-7" data-bs-ride="carousel">
    <div class="carousel-inner">
      <div class="carousel-item active">
        <img src="images/imagen1.jpg" alt="Imagen 1" class="d-block w-100">
        <div class="carousel-caption text-center">
          <h3>¡Conmemora esos especiales momentos con Nosotros!</h3>
          <p>Haz de tus recuerdos algo inolvidable. Atte: El Roble.</p>
        </div>
      </div>
      <div class="carousel-item">
        <img src="images/imagen2.jpg" alt="Imagen 2" class="d-block w-100">
        <div class="carousel-caption text-center">
          <h3>El lugar ideal para tus celebraciones</h3>
          <p>Ofrecemos experiencias únicas para cada ocasión.</p>
        </div>
      </div>
      <div class="carousel-item">
        <img src="images/imagen3.jpg" alt="Imagen 3" class="d-block w-100">
        <div class="carousel-caption text-center">
          <h3>Confía en nosotros para tus eventos más importantes</h3>
          <p>¡Hacemos tus sueños realidad!</p>
        </div>
      </div>
    </div>
    <img src="/images/logo.png" alt="Logo El Roble" class="carousel-logo">
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
      <span class="carousel-control-prev-icon"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
      <span class="carousel-control-next-icon"></span>
    </button>
  </div>

  <!-- Paquetes -->
  <div style="margin-top: 15px" class="container mb-5">
    <h2 class="text-center">Nuestros Paquetes</h2>
    <div class="row">
      @for($i = 1; $i <= 5; $i++)
      <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
        <div class="package-card">
          <img src="/images/imagen2.jpg" alt="Paquete {{ $i }}">
          <h3>Paquete {{ $i }}</h3>
          <p>Descripción del paquete {{ $i }}. Incluye servicios destacados.</p>
          <small>Válido: 01/12/2024 - 31/12/2024</small>
        </div>
      </div>
      @endfor
    </div>
  </div>
  

  <!-- Comentarios -->
  <div class="container mb-5">
    <h2 class="text-center">Comentarios de Nuestros Clientes</h2>
    <div id="testimonialCarousel" class="carousel slide" data-bs-ride="carousel">
      <div class="carousel-inner">
        <div class="carousel-item active">
          <div class="row">
            <div class="col-md-4">
              <div class="testimonial-card">
                <img style="filter: brightness(100%);" src="images/fotoperfil.jpg" alt="Usuario">
                <h5>Axel Espinoza</h5>
                <p>"El evento fue increíble, gracias a El Roble por hacerlo posible."</p>
                <small>Puntuación: 4.5/5</small>
              </div>
            </div>
            <div class="col-md-4">
              <div class="testimonial-card">
                <img style="filter: brightness(100%);" src="images/fotoperfil.jpg" alt="Usuario">
                <h5>Jesús Villareal</h5>
                <p>"Todo salió perfecto, la atención fue excelente."</p>
                <small>Puntuación: 5/5</small>
              </div>
            </div>
            <div class="col-md-4">
              <div class="testimonial-card">
                <img style="filter: brightness(100%);" src="images/fotoperfil.jpg" alt="Usuario">
                <h5>Sebastián Contreras</h5>
                <p>"Sin duda los volvería a contratar para mi próximo evento."</p>
                <small>Puntuación: 4.8/5</small>
              </div>
            </div>
          </div>
        </div>
        <!-- Más comentarios aquí -->
      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
      </button>
    </div>
  </div>

  <!-- Anuncio -->
  <div class="cta text-center py-5 mb-3">
    <h2>Haz Tu Cotización</h2>
    <p>Organiza tu evento con nosotros. ¡Hacemos tus sueños realidad!</p>
    <a  id="crearPaqueteBoton" href="{{ route('cotizaciones.create') }}" class="btn">Cotizar Ahora</a>
  </div>

  <!-- Google Maps -->
  <div class="container mb-5">
    <h2 class="text-center">Visítanos</h2>
    <div id="map" style="height: 400px; border: 2px solid white; border-radius: 10px;"></div>
  </div>

    <!-- Footer -->
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
    

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    function initMap() {
      const location = { lat: 25.540078, lng: -103.403014 }; // Coordenadas de "El Roble"
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

  <!-- <dotlottie-player src="https://lottie.host/ef753341-ded4-4585-8a02-e5d047155c12/2yGpFhNmWB.json" background="transparent" speed="1" style="width: 300px; height: 300px;" loop autoplay></dotlottie-player> -->
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCx4NNBGSBnu0ypvno3X4OSfXzVHRQbj1Y&callback=initMap" async defer></script>
</body>
</html>
