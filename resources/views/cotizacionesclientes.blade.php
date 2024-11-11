<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cotización</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="stylespaquetes.css">
</head>
<body>
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-7">
                <h3>Crear Nueva Cotización</h3>
                <form id="cotizacionForm">
                    <!-- Lugar -->
                    <div class="mb-3">
                        <label for="place_id" class="form-label">Lugar</label>
                        <select id="place_id" class="form-control">
                            <option value="">Selecciona un lugar</option>
                            <!-- Opciones de lugares se agregarán dinámicamente -->
                        </select>
                    </div>

                    <!-- Fecha del evento -->
                    <div class="mb-3">
                        <label for="event_date" class="form-label">Fecha del Evento</label>
                        <input type="date" id="event_date" class="form-control" oninput="updatePreview()">
                    </div>

                    <!-- Hora de inicio -->
                    <div class="mb-3">
                        <label for="start_time" class="form-label">Hora de Inicio</label>
                        <input type="time" id="start_time" class="form-control" oninput="updatePreview()">
                    </div>

                    <!-- Hora de finalización -->
                    <div class="mb-3">
                        <label for="end_time" class="form-label">Hora de Finalización</label>
                        <input type="time" id="end_time" class="form-control" oninput="updatePreview()">
                    </div>

                    <!-- Tipo de Evento -->
                    <div class="mb-3">
                        <label for="event_type" class="form-label">Tipo de Evento</label>
                        <select id="event_type" class="form-control" onchange="toggleEventTypeField()">
                            <option value="">Selecciona un tipo</option>
                            <option value="boda">Boda</option>
                            <option value="cumpleaños">Cumpleaños</option>
                            <option value="corporativo">Corporativo</option>
                            <option value="otro">Otro</option>
                        </select>
                    </div>

                    <!-- Campo adicional para "Otro" tipo de evento -->
                    <div class="mb-3" id="other_event_type" style="display: none;">
                        <label for="other_event" class="form-label">Especifica el Tipo de Evento</label>
                        <input type="text" id="other_event" class="form-control">
                    </div>

                    <!-- Información de contacto -->
                    <div class="mb-3">
                        <label for="contact_name" class="form-label">Nombre</label>
                        <input type="text" id="contact_name" class="form-control" placeholder="Tu nombre">
                    </div>
                    <div class="mb-3">
                        <label for="contact_phone" class="form-label">Teléfono</label>
                        <input type="tel" id="contact_phone" class="form-control" placeholder="Tu teléfono">
                    </div>

                    <!-- Servicios -->
                    <h4 class="mt-4">Servicios</h4>
                    <div class="row" id="services-container">
                        <!-- Servicios se agregarán dinámicamente -->
                    </div>

                    <button type="submit" class="btn btn-primary mt-3">Generar Cotización</button>
                </form>
            </div>

            <!-- Carrusel de imágenes con textos -->
            <div class="col-md-5">
                <h4>Paquetes o Servicios</h4>
                <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="images/imagen1.jpg" class="d-block w-100" alt="Paquete 1">
                            <div class="carousel-caption d-none d-md-block">
                                <h5>Paquete Boda</h5>
                                <p>Todo lo que necesitas para una boda memorable.</p>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <img src="images/imagen2.jpg" class="d-block w-100" alt="Paquete 2">
                            <div class="carousel-caption d-none d-md-block">
                                <h5>Paquete Cumpleaños</h5>
                                <p>Celebra tu cumpleaños con los mejores servicios.</p>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <img src="images/imagen3.jpg" class="d-block w-100" alt="Paquete 3">
                            <div class="carousel-caption d-none d-md-block">
                                <h5>Paquete Corporativo</h5>
                                <p>Organiza tu evento corporativo de manera profesional.</p>
                            </div>
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Datos simulados de lugares y servicios
        const places = [
            { id: 1, name: "Lugar 1" },
            { id: 2, name: "Lugar 2" },
            { id: 3, name: "Lugar 3" }
        ];

        const services = [
            { id: 1, name: "Catering", description: "Servicio de comida", price: 200 },
            { id: 2, name: "DJ", description: "Música y sonido", price: 150 },
            { id: 3, name: "Decoración", description: "Decoración de evento", price: 100 }
        ];

        // Función para cargar los lugares en el dropdown
        function loadPlaces() {
            const placeSelect = document.getElementById('place_id');
            places.forEach(place => {
                const option = document.createElement('option');
                option.value = place.id;
                option.textContent = place.name;
                placeSelect.appendChild(option);
            });
        }

        // Función para cargar los servicios en el formulario
        function loadServices() {
            const servicesContainer = document.getElementById('services-container');
            services.forEach(service => {
                const serviceDiv = document.createElement('div');
                serviceDiv.classList.add('col-md-4');
                serviceDiv.classList.add('mb-3');
                serviceDiv.innerHTML = `
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">${service.name}</h5>
                            <p class="card-text">${service.description}</p>
                            <p class="card-text">Precio: $${service.price}</p>
                            <input type="checkbox" class="form-check-input" id="service-${service.id}" onchange="updatePreview()"> Seleccionar
                        </div>
                    </div>
                `;
                servicesContainer.appendChild(serviceDiv);
            });
        }

        // Función para mostrar el campo de tipo de evento "Otro"
        function toggleEventTypeField() {
            const eventType = document.getElementById('event_type').value;
            const otherEventTypeField = document.getElementById('other_event_type');
            if (eventType === 'otro') {
                otherEventTypeField.style.display = 'block';
            } else {
                otherEventTypeField.style.display = 'none';
            }
        }

        // Cargar los lugares y servicios al cargar la página
        window.onload = function() {
            loadPlaces();
            loadServices();
        };
    </script>
</body>
</html>
