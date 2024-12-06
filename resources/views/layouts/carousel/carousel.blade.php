<!-- resources/views/partials/carousel.blade.php -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>

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
