<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>El Roble - Cotizaciones</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/stylescotizacionesclientes.css') }}">
</head>
<body>

    <div class="container mt-4">
        <div class="row">
            <!-- Sección de Solicitud de Cotización -->
            <div class="col-md-6" id="solicitudCotizacion">
                <h3>Solicita tu Cotización</h3>
                <p>
                    Para solicitar la cotización de tu evento, es necesario que llenes todos los datos del siguiente formulario.
                    Nuestro equipo estará atendiendo personalmente tu solicitud a la brevedad posible.
                    <br><br>
                    Atte: Equipo de El Roble
                </p>
                <img src="/images/imagen5.png" alt="Imagen adicional">
            </div>
            
            <!-- Carrusel de Paquetes -->
            <div class="col-md-6">
                <div id="paquetesCarousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="/images/imagen1.jpg" class="d-block w-100" alt="Conmemorativo">
                            <div class="carousel-caption">
                                <h5>Paquete Conmemorativo</h5>
                                <p>Pasa un momento Alegre y Emblemático con música en vivo y comida elegante.</p>
                                <ul>
                                    <li>Quinta</li>
                                    <li>Música En Vivo</li>
                                    <li>Comida Preparada</li>
                                    <li>Servicio de Meseros</li>
                                </ul>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <img src="/images/imagen2.jpg" class="d-block w-100" alt="Minimalista">
                            <div class="carousel-caption">
                                <h5>Paquete Minimalista</h5>
                                <p>Lo justo y necesario para un momento especial y único.</p>
                                <ul>
                                    <li>Quinta</li>
                                    <li>Comida Preparada</li>
                                </ul>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <img src="/images/imagen3.jpg" class="d-block w-100" alt="Comfort">
                            <div class="carousel-caption">
                                <h5>Paquete Comfort</h5>
                                <p>Todos nuestros servicios a tu disposición para una experiencia reconfortante.</p>
                                <ul>
                                    <li>Quinta y Salón</li>
                                    <li>Música En Vivo</li>
                                    <li>Comida Preparada</li>
                                    <li>Servicio de Meseros</li>
                                    <li>Salas Lounge</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#paquetesCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#paquetesCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Sección de Información -->
        <div class="row mt-4" id="informacionEvento">
            <h2>Información:</h2>
            <form>
                <div class="row">
                    <div class="col-md-6">
                        <label for="tipoEvento">Tipo de Evento:</label>
                        <select class="form-select" id="tipoEvento">
                            <option>Cumpleaños</option>
                            <option>Boda</option>
                            <option>XV's</option>
                            <option>Bautizo</option>
                            <option>Graduación</option>
                            <option>Despedida de Solter@</option>
                            <option>Otro</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="inicioEvento">Inicio del Evento:</label>
                        <input type="time" class="form-control" id="inicioEvento">
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-6">
                        <label for="fechaEvento">Fecha del Evento:</label>
                        <input type="date" class="form-control" id="fechaEvento" min="{{ date('Y-m-d') }}">
                    </div>
                    <div class="col-md-6">
                        <label for="finEvento">Final del Evento:</label>
                        <input type="time" class="form-control" id="finEvento">
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-6">
                        <label for="invitados">Cantidad de Invitados Aproximada:</label>
                        <input type="number" class="form-control" id="invitados" placeholder="50">
                    </div>
                    <div class="col-md-6">
                        <label for="espacio">Espacio:</label>
                        <select class="form-select" id="espacio">
                            <option>Quinta</option>
                            <option>Salón de Eventos</option>
                            <option>Quinta y Salón de Eventos</option>
                        </select>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-6">
                        <label for="nombreCotizacion">A nombre de:</label>
                        <input type="text" class="form-control" id="nombreCotizacion" placeholder="Nombre de la persona">
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col text-center">
                        <button type="submit" class="btn btn-warning">Solicitar Cotización</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
