<!-- resources/views/inicio.blade.php -->
@extends('layouts.appaxel')

@section('title', 'Inicio - El Roble')

@section('styles')
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/stylesinicio.css') }}">
    <style>
        .package-card {
            position: relative;
            background-color: rgba(21, 58, 21, 0.89);
            border: 2px solid white;
            border-radius: 10px;
            padding: 15px;
            margin: 13px;
        }
        .package-card img {
            width: 100%;
            height: auto;
            border-radius: 3%;
            border: 2px solid rgb(77, 160, 74);
        }
        .carousel-control-prev, .carousel-control-next {
            width: 5%;
        }
        #solicitacotizacionBoton {
            background-color: #2b1a06;
            padding: 10px;
            border-radius: 100px;
            color: white;
            margin-top: 20px;
            margin-bottom: 20px;
            border: 1px solid rgba(255, 255, 255, 0.904);
            box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.3);
        }
        .modal-img {
            width: 100%;
            max-width: 300px;
            height: auto;
            border-radius: 10px;
            display: block;
            margin-left: auto;
            margin-right: auto;
            max-height: 200px;
            object-fit: cover;
        }
        .star-rating {
            color: #ffc107;
        }
        .star-rating .bi-star {
            color: #e4e5e9;
        }
        @media (max-width: 576px) {
            .testimonial-card, .cta {
                flex: 0 0 100%;
                max-width: 100%;
            }
        }
    </style>
@endsection

@section('content')
    <!-- Carrusel -->
    <div id="carouselExample" style="border-radius: 5%" class="carousel slide mb-7" data-bs-ride="carousel">
        <div style="border-radius: 1.2%; box-sizing: border-box; box-shadow: 0 0 10px 4px rgb(0, 0, 0);" class="carousel-inner">
            <div id="oscurecido" class="carousel-item active">
                <img src="images/imagen1.jpg" alt="Imagen 1" class="d-block w-100">
                <div class="carousel-caption text-center">
                    <h3>¡Conmemora esos especiales momentos con Nosotros!</h3>
                    <p>Haz de tus recuerdos algo inolvidable. Atte: El Roble.</p>
                </div>
            </div>
            <div id="oscurecido" class="carousel-item">
                <img src="images/imagen2.jpg" alt="Imagen 2" class="d-block w-100">
                <div class="carousel-caption text-center">
                    <h3>El lugar ideal para tus celebraciones</h3>
                    <p>Ofrecemos experiencias únicas para cada ocasión.</p>
                </div>
            </div>
            <div id="oscurecido" class="carousel-item">
                <img src="images/imagen3.jpg" alt="Imagen 3" class="d-block w-100">
                <div class="carousel-caption text-center">
                    <h3>Confía en nosotros para tus eventos más importantes</h3>
                    <p>¡Hacemos tus sueños realidad!</p>
                </div>
            </div>
        </div>
        <img src="/images/logo sin letras.png" alt="Logo El Roble" class="carousel-logo">
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
        <div id="packageCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                @foreach($packages->chunk(4) as $chunk)
                    <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                        <div class="row">
                            @foreach($chunk as $package)
                                @php
                                    $imageUrl = $package->image_path ?: '';
                                    if (!$imageUrl) {
                                        switch ($package->place_id) {
                                            case 1:
                                                $imageUrl = '/images/imagen2.jpg';
                                                break;
                                            case 2:
                                                $imageUrl = '/images/imagen7.jpg';
                                                break;
                                            case 3:
                                                $imageUrl = '/images/imagen8.jpg';
                                                break;
                                            default:
                                                $imageUrl = '/images/imagen1.jpg';
                                        }
                                    }
                                @endphp
                                <div class="col-lg-3 col-md-6 col-sm-6 col-6">
                                    <div class="package-card">
                                        <img src="{{ $imageUrl }}" alt="Paquete {{ $package->name }}">
                                        <h3>{{ $package->name }}</h3>
                                        <button id="detallesBoton" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#packageModal{{ $package->id }}">
                                            <span class="full-text">Ver Detalles</span>
                                            <span class="short-text">Ver</span>
                                        </button>
                                    </div>
                                </div>

                                <!-- Modal -->
                                <div class="modal fade" id="packageModal{{ $package->id }}" tabindex="-1" aria-labelledby="packageModalLabel{{ $package->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content" style="background-color: #1b3b17; border: 2px solid white;">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="packageModalLabel{{ $package->id }}">{{ $package->name }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <img src="{{ $imageUrl }}" alt="Paquete {{ $package->name }}" class="modal-img mb-3" style="border: 2px solid white;">
                                                <p>{{ $package->description }}</p>
                                                <p>Máximo de personas: {{ $package->max_people }}</p>
                                                <p>Precio: ${{ $package->price }}</p>
                                                <p>Vigencia: {{ $package->start_date->format('d/m/Y') }} - {{ $package->end_date->format('d/m/Y') }}</p>
                                            </div>
                                            <div class="modal-footer">
                                                <a href="{{ route('cotizaciones.create') }}" id="solicitacotizacionBoton" class="btn">Solicita tu Cotización</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#packageCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#packageCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
            </button>
        </div>
    </div>

    <!-- Comentarios y Anuncio -->
    <div class="container mb-5">
        <div class="row">
            <div class="col-lg-3 col-md-12">
                <div id="testimonialCarousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        @foreach($comments as $comment)
                            <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                                <div class="testimonial-card">
                                    <img style="filter: brightness(100%);" src="images/fotoperfil.jpg" alt="Usuario">
                                    <h5>{{ $comment->anonymous ? 'Anónimo' : $comment->user->person->first_name . ' ' . $comment->user->person->last_name }}</h5>
                                    <p>"{{ $comment->comment }}"</p>
                                    <div class="star-rating">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <i class="bi bi-star{{ $i <= $comment->rating ? '-fill' : '' }}"></i>
                                        @endfor
                                    </div>
                                    <small>Puntuación: {{ $comment->rating }}/5</small>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon"></span>
                    </button>
                </div>
            </div>
            <div class="col-lg-9 col-md-12">
                <div class="cta text-center py-5 mb-3">
                    <h2>Haz Tu Cotización</h2>
                    <p>Organiza tu evento con nosotros. ¡Hacemos tus sueños realidad!</p>
                    <a id="crearPaqueteBoton" href="{{ route('cotizaciones.create') }}" class="btn">Cotizar Ahora</a>
                </div>
            </div>
        </div>
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
@endsection

@section('scripts')
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
@endsection