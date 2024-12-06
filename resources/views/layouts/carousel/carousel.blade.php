<!-- resources/views/partials/carousel.blade.php -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
<style>
    .carousel {
        height: 500px; /* Ajusta la altura del carrusel */
    }
    .carousel-item img {
        width: 100%; /* Ajusta el ancho de las imágenes */
        height: 100%; /* Asegúrate de que las imágenes llenen el contenedor */
        object-fit: cover; /* Evita distorsión */
    }
    .carousel-item img {
        max-width: 100%; /* Permite que las imágenes llenen el espacio */
        max-height: 500px; /* Ajusta la altura máxima */
        object-fit: cover; /* Recorta las imágenes para evitar distorsión */
    }
</style>

<div class="carousel">
    <a href="#one" class="carousel-item">
        <img src="{{ asset('images/imagen1.jpg') }}">
    </a>
    <a href="#two" class="carousel-item">
        <img src="{{ asset('images/imagen2.jpg') }}">
    </a>
    <a href="#three" class="carousel-item">
        <img src="{{ asset('images/imagen3.jpg') }}">
    </a>
    <a href="#four" class="carousel-item">
        <img src="{{ asset('images/imagen7.jpg') }}">
    </a>
    <a href="#five" class="carousel-item">
        <img src="{{ asset('images/imagen8.jpg') }}">
    </a>
</div>

<script>
    $(document).ready(function(){
        $('.carousel').carousel({
            indicators: true
        });
    });
</script>
