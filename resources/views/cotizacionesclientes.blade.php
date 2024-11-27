<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>El Roble - Cotización</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/stylespaquetes.css') }}">
</head>
<body>
    <div class="container mt-4">
        <div class="row">
            @if(session('success'))
            <div class="alert alert-success" role="alert" style="background-color: rgb(30, 78, 21); color: white;">
                {{ session('success') }}
            </div>
            @elseif ($errors->has('general'))
            <div class="alert alert-danger" role="alert" style="background-color: rgb(189, 18, 18); color: white;">
                {{ $errors->first('general') }}
            </div>
            @endif
            <div class="col-md-7" id="crearPaquete">
                <h3> <strong>Solicitar Cotización</strong> </h3>
                <div class="row">
                    <!-- Carrusel de Paquetes y Campo de Lugar en una fila -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div id="packageCarousel" class="carousel slide" data-bs-ride="carousel">
                                <div class="carousel-inner">
                                    @foreach($packages as $index => $package)
                                        <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                            <div id="card-carousel" class="card">
                                                <div class="card-body">
                                                    <h5 style="color:white;" class="card-title">{{ $package->name }}</h5>
                                                    <p style="color:white;" class="card-text"><strong>Espacio:</strong> {{ $package->place->name }}</p>
                                                    <p style="color:white;" class="card-text"><strong>Máximo de personas:</strong> {{ $package->max_people }}</p>
                                                    <p style="color:white;" class="card-text"><strong>Costo:</strong> ${{ $package->price }}</p>
                                                    <p style="color:white;" class="card-text"><strong>Servicios incluidos:</strong></p>
                                                    <ul>
                                                        @foreach($package->services as $service)
                                                            <li style="color:white;">{{ $service->name }}</li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <button class="carousel-control-prev" type="button" data-bs-target="#packageCarousel" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#packageCarousel" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            </div>
                        </div>
                        <!-- Campo de Lugar con Radio Buttons -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="place_id" class="form-label">Lugar</label>
                                <div>
                                    @foreach($places as $place)
                                        <div class="form-check">
                                            <input class="form-check-input @error('place_id') is-invalid @enderror" type="radio" name="place_id" id="place_{{ $place->id }}" value="{{ $place->id }}" {{ old('place_id') == $place->id ? 'checked' : '' }} required>
                                            <label class="form-check-label" for="place_{{ $place->id }}">
                                                {{ $place->name }}
                                            </label>
                                        </div>
                                    @endforeach
                                    @error('place_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Resto del formulario -->
                    <form action="{{ route('cotizacionesclientes.store') }}" method="POST" id="cotizacionForm">
                        @csrf
                        <div class="mb-3 row">
                            <div class="col-md-6">
                                <label for="date" class="form-label">Fecha</label>
                                <input type="date" name="date" id="date" class="form-control @error('date') is-invalid @enderror" oninput="updatePreview()" value="{{ old('date') }}" required>
                                @error('date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <label for="start_time" class="form-label">Hora de Inicio</label>
                                <input type="time" name="start_time" id="start_time" class="form-control @error('start_time') is-invalid @enderror" min="12:00" max="23:59" step="1800" oninput="updatePreview()" value="{{ old('start_time') }}" required>
                                @error('start_time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <label for="end_time" class="form-label">Hora de Final</label>
                                <input type="time" name="end_time" id="end_time" class="form-control @error('end_time') is-invalid @enderror" min="12:00" max="23:59" step="1800" oninput="updatePreview()" value="{{ old('end_time') }}" required>
                                @error('end_time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <div class="col-md-6">
                                <label for="guest_count" class="form-label">Cantidad de Invitados</label>
                                <input type="number" name="guest_count" id="guest_count" class="form-control @error('guest_count') is-invalid @enderror" oninput="updatePreview()" value="{{ old('guest_count') }}" required>
                                @error('guest_count')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="type_event" class="form-label">Tipo de Evento</label>
                                <select name="type_event" id="type_event" class="form-control @error('type_event') is-invalid @enderror" onchange="toggleOtroTipoEvento()" required>
                                    <option value="">Selecciona el tipo de evento</option>
                                    <option value="XV's" {{ old('type_event') == "XV's" ? 'selected' : '' }}>XV's</option>
                                    <option value="Cumpleaños" {{ old('type_event') == "Cumpleaños" ? 'selected' : '' }}>Cumpleaños</option>
                                    <option value="Graduación" {{ old('type_event') == "Graduación" ? 'selected' : '' }}>Graduación</option>
                                    <option value="Posada" {{ old('type_event') == "Posada" ? 'selected' : '' }}>Posada</option>
                                    <option value="Boda" {{ old('type_event') == "Boda" ? 'selected' : '' }}>Boda</option>
                                    <option value="Baby Shower" {{ old('type_event') == "Baby Shower" ? 'selected' : '' }}>Baby Shower</option>
                                    <option value="Otro" {{ old('type_event') == "Otro" ? 'selected' : '' }}>Otro</option>
                                </select>
                                @error('type_event')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3" id="otro_tipo_evento_div" style="display: none;">
                            <label for="otro_tipo_evento" class="form-label">Especificar Tipo de Evento</label>
                            <input type="text" name="otro_tipo_evento" id="otro_tipo_evento" class="form-control @error('otro_tipo_evento') is-invalid @enderror" value="{{ old('otro_tipo_evento') }}">
                            @error('otro_tipo_evento')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 row">
                            <div class="col-md-6">
                                <label for="owner_name" class="form-label">Nombre</label>
                                <input type="text" name="owner_name" id="owner_name" class="form-control @error('owner_name') is-invalid @enderror" oninput="updatePreview()" value="{{ old('owner_name') }}" required>
                                @error('owner_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="owner_phone" class="form-label">Teléfono</label>
                                <input type="number" name="owner_phone" id="owner_phone" class="form-control @error('owner_phone') is-invalid @enderror" oninput="updatePreview()" value="{{ old('owner_phone') }}" required>
                                @error('owner_phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Servicios -->
                        <h4 class="mt-4">Seleccionar Servicios</h4>
                        <div class="row">
                            @foreach($categories as $category)
                                <div class="col-md-4 mb-3 equal-height">
                                    <div class="card category-card" onclick="toggleServices('{{ $category->id }}')">
                                        <div class="card-body text-center">
                                            <h6 class="card-title">{{ $category->name }}</h6>
                                        </div>
                                    </div>
                                </div>
                                <div id="services-{{ $category->id }}" class="service-item" style="display: none;">
                                    <div class="row">
                                        @foreach($category->services as $service)
                                            <div id="service-details-{{ $service->id }}" class="col-md-4 mb-3">
                                                <div class="card service-card">
                                                    <img src="{{ asset('images/imagen6.jpg') }}" class="card-img-top" alt="{{ $service->name }}">
                                                    <div class="card-body">
                                                        <h5 class="card-title">{{ $service->name }}</h5>
                                                        <p class="card-text" style="font-weight: bold">Precio Aprox: ${{ $service->price }}</p>
                                                        <p class="card-text">Descripción: {{ $service->description }}</p>
                                                        <input type="checkbox" name="services[{{ $service->id }}]" value="{{ $service->id }}" class="form-check-input" onchange="selectService(this, '{{ $category->id }}')">
                                                        <input type="number" name="services[{{ $service->id }}][quantity]" placeholder="Cantidad" class="form-control mt-2" min="1" style="display:none;">
                                                        <button type="button" id="confirm-btn-{{ $service->id }}" class="btn btn-primary mt-2" style="display:none;" disabled onclick="confirmService('{{ $service->id }}')">Confirmar</button>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Vista Previa -->
        <div class="col-md-5" id="previstaServicio">
            <div class="prevista-imagen-container">
                <img id="prevista-imagen" class="prevista-imagen" src="{{ asset('images/imagen1.jpg') }}" alt="Vista previa">
                <div class="prevista-caption">
                    <h5 id="prevista-nombre">Nombre</h5>
                    <p id="prevista-fecha">Fecha: -</p>
                    <p id="prevista-horario">Hora: -</p>
                    <p id="prevista-invitados">Invitados: -</p>
                </div>
            </div>
            <p id="prevista-servicios">Servicios seleccionados:</p>
            <div id="vista-previa-servicios" class="vista-previa mt-3">No hay servicios confirmados aún.</div>
            <button type="button" class="btn btn-success mt-3" id="crearPaqueteBoton" onclick="crearPaquete()">Enviar Cotización</button>
        </div>
    </div>

    <script>
        // Declaración de Variables de Almacenamiento
        let confirmedServices = {};
        let selectedServices = {};
    
        // Declarando Servicios
        const services = @json($services);
    
        // Ejecución de Funciones al Ejecutar Vista
        window.addEventListener('load', ajustarAlturaCategorias);
        window.addEventListener('resize', ajustarAlturaCategorias);
    
        // Funciones Bárbaras
        function confirmarServicio(serviceId, categoryId) {
            const serviceCard = document.getElementById(`service-details-${serviceId}`);
            const quantityInput = serviceCard.querySelector(`input[name="services[${serviceId}][quantity]"]`);
            const confirmButton = serviceCard.querySelector(`#confirm-btn-${serviceId}`);
    
            if (!quantityInput || quantityInput.value.trim() === "") {
                alert('Por favor, ingresa una cantidad válida.');
                return;
            }
    
            if (confirmButton && confirmButton.disabled === false) {
                confirmedServices[serviceId] = { categoryId, quantity: quantityInput.value.trim(), isConfirmed: true };
    
                serviceCard.classList.add('service-disabled');
                serviceCard.classList.remove('service-enabled');
                const checkbox = serviceCard.querySelector('input[type="checkbox"]');
                if (checkbox) checkbox.disabled = true;
    
                confirmButton.disabled = true;
    
                actualizarVistaServicios();
            } else {
                console.log('No se puede confirmar el servicio aún.');
            }
        }
    
        function getServiceName(serviceId) {
            return services[serviceId] ? services[serviceId].name : "Servicio desconocido";
        }
    
        function actualizarVistaServicios() {
            const vistaPrevia = document.getElementById('vista-previa-servicios');
            vistaPrevia.innerHTML = '';
    
            const serviciosConfirmados = Object.entries(confirmedServices).filter(
                ([, serviceData]) => serviceData.isConfirmed
            );
    
            if (serviciosConfirmados.length === 0) {
                vistaPrevia.innerHTML = '<p>No hay servicios confirmados aún.</p>';
                return;
            }
    
            const listaServicios = document.createElement('ul');
            listaServicios.className = 'lista-servicios-confirmados';
    
            for (const [serviceId, serviceData] of serviciosConfirmados) {
                const serviceItem = document.createElement('li');
                serviceItem.className = 'service-item';
                serviceItem.innerHTML = `
                    <div class="service-info">
                        <h4 class="service-name">${getServiceName(serviceId)}</h4>
                        <p style="color: black;" class="service-quantity">Cantidad: ${serviceData.quantity || 'No especificada'}</p>
                        <button class="btn btn-danger btn-sm" onclick="confirmarEliminacionServicio('${serviceId}')">Eliminar</button>
                    </div>
                `;
                listaServicios.appendChild(serviceItem);
            }
    
            vistaPrevia.appendChild(listaServicios);
        }
    
        function confirmarEliminacionServicio(serviceId) {
            const modalHtml = `
                <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 style="color: black;" class="modal-title" id="confirmDeleteModalLabel">Confirmar Eliminación</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div style="color: black;" class="modal-body">
                                ¿Estás seguro de que deseas eliminar este servicio?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                <button type="button" class="btn btn-danger" onclick="eliminarServicio('${serviceId}')">Eliminar</button>
                            </div>
                        </div>
                    </div>
                </div>
            `;
    
            document.body.insertAdjacentHTML('beforeend', modalHtml);
            const confirmDeleteModal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));
            confirmDeleteModal.show();
    
            confirmDeleteModal._element.addEventListener('hidden.bs.modal', function () {
                document.getElementById('confirmDeleteModal').remove();
            });
        }
    
    function eliminarServicio(serviceId) {
        delete confirmedServices[serviceId];
        actualizarVistaServicios();

        const serviceCard = document.getElementById(`service-details-${serviceId}`);
        serviceCard.classList.remove('service-disabled');
        serviceCard.classList.add('service-enabled');
        serviceCard.style.opacity = 1;
        serviceCard.style.pointerEvents = "auto";

        const checkbox = serviceCard.querySelector('input[type="checkbox"]');
        if (checkbox) {
            checkbox.disabled = false;
            checkbox.checked = false;
        }

        const confirmButton = serviceCard.querySelector(`#confirm-btn-${serviceId}`);
        if (confirmButton) {
            confirmButton.style.display = 'none';
            confirmButton.disabled = true;
        }

        const quantityInput = serviceCard.querySelector(`input[name="services[${serviceId}][quantity]"]`);
        if (quantityInput) {
            quantityInput.style.display = 'none';
            quantityInput.value = '';
        }

        const confirmDeleteModal = bootstrap.Modal.getInstance(document.getElementById('confirmDeleteModal'));
        confirmDeleteModal.hide();
    }
    
        function toggleServices(categoryId) {
            const servicesDiv = document.getElementById(`services-${categoryId}`);
            servicesDiv.style.display = servicesDiv.style.display === 'block' ? 'none' : 'block';
        } 
    
        function selectService(checkbox, categoryId) {
            const selectedServiceId = checkbox.value;
            const isSelected = checkbox.checked;
            const serviceCard = checkbox.closest('.service-card');
            const serviceQuantityInput = serviceCard.querySelector(`input[name="services[${selectedServiceId}][quantity]"]`);
            const confirmButton = serviceCard.querySelector(`#confirm-btn-${selectedServiceId}`);
    
            if (isSelected) {
                selectedServices[selectedServiceId] = { categoryId, isSelected: true };
    
                serviceQuantityInput.style.display = 'block';
                confirmButton.style.display = 'block';
                serviceQuantityInput.focus();
    
                serviceQuantityInput.addEventListener('input', () => {
                    confirmButton.disabled = !serviceQuantityInput.value.trim();
                });
    
                confirmButton.addEventListener('click', () => confirmarServicio(selectedServiceId, categoryId));
            } else {
                delete selectedServices[selectedServiceId];
                delete confirmedServices[selectedServiceId];
    
                serviceQuantityInput.style.display = 'none';
                serviceQuantityInput.value = '';
                confirmButton.style.display = 'none';
                confirmButton.disabled = true;
            }
        }
    
        function confirmService(serviceId) {
            const serviceCard = document.getElementById(`service-details-${serviceId}`);
            const quantityInput = serviceCard.querySelector(`input[name="services[${serviceId}][quantity]"]`);
            const confirmButton = document.getElementById(`confirm-btn-${serviceId}`);
    
            if (!confirmedServices[serviceId]) {
                confirmedServices[serviceId] = {
                    isConfirmed: false,
                    quantity: ''
                };
            }
    
            if (!quantityInput.value || quantityInput.value < 1) {
                alert("Por favor, ingresa una cantidad válida.");
            return;
            }
    
            confirmButton.addEventListener('click', function () {
                if (quantityInput.value >= 1) {
                    confirmedServices[serviceId] = {
                        isConfirmed: true,
                        quantity: quantityInput.value.trim()
                    };
    
                    actualizarVistaServicios();
    
                    serviceCard.style.opacity = 0.5;
                    serviceCard.style.pointerEvents = "none";
    
                    confirmButton.style.display = "none";
                    quantityInput.style.display = "none";
                }
            });
        }
    
        function toggleBotonCrearPaquete() {
            const botonCrearPaquete = document.getElementById('crearPaqueteBoton');
            botonCrearPaquete.disabled = !checkIfAllServicesConfirmed();
        }
    
        function ajustarAlturaCategorias() {
            const categoryCards = document.querySelectorAll('.category-card');
    
            if (categoryCards.length === 0) return;
    
            let maxAltura = 0;
    
            categoryCards.forEach(card => {
                const alturaActual = card.offsetHeight;
                if (alturaActual > maxAltura) {
                    maxAltura = alturaActual;
                }
            });
    
            categoryCards.forEach(card => {
                card.style.height = maxAltura + 'px';
                card.style.display = 'flex';
                card.style.justifyContent = 'center';
                card.style.alignItems = 'center';
                card.style.textAlign = 'center';
            });
        }
    
        function crearPaquete() {
            const form = document.getElementById('cotizacionForm');
            document.querySelectorAll('.service-hidden-input').forEach(input => input.remove());

            const date = document.getElementById('date').value;
            const startInput = document.getElementById('start_time');
            const endInput = document.getElementById('end_time');
            const startTime = startInput.value;
            const endTime = endInput.value;

            const typeEventElement = document.getElementById('type_event');
            const typeEventValue = typeEventElement ? String(typeEventElement.value) : '';

            const placeId = document.querySelector('input[name="place_id"]:checked');
            if (!placeId) {
                alert("Por favor, selecciona un lugar.");
                return;
            }

            if (!date || !startTime || !endTime) {
                alert("Por favor, selecciona la fecha y las horas de inicio y fin del evento.");
                return;
            }

            if (!validarHoraEnRango()) {
                return;
            }

            const startDateTime = `${date} ${startTime.slice(0, 5)}`;
            let endDateTime = `${date} ${endTime.slice(0, 5)}`;
            const endHour = parseInt(endTime.split(':')[0], 10);
            if (endHour >= 0 && endHour <= 3) {
                const dateObj = new Date(`${date}T${endTime}:00`);
                dateObj.setDate(dateObj.getDate() + 1);
                const endDate = dateObj.toISOString().slice(0, 10);
                endDateTime = `${endDate} ${endTime.slice(0, 5)}`;
            }

            form.appendChild(generarInputOculto('start_time', startDateTime));
            form.appendChild(generarInputOculto('end_time', endDateTime));
            form.appendChild(generarInputOculto('type_event', typeEventValue));
            form.appendChild(generarInputOculto('place_id', placeId.value));

            let anyServiceConfirmed = false;
            for (let serviceId in confirmedServices) {
                const service = confirmedServices[serviceId];

                if (service.isConfirmed && service.quantity.trim() !== "") {
                    console.log(`Confirmando servicio ${serviceId} con cantidad: ${service.quantity}`);

                    form.appendChild(generarInputOculto(`services[${serviceId}][quantity]`, service.quantity));
                    form.appendChild(generarInputOculto(`services[${serviceId}][confirmed]`, true));
                } else {
                    console.log(`Servicio ${serviceId} no confirmado o sin cantidad válida. Se omite.`);
                }
            }

            if (!anyServiceConfirmed) {
                console.log("No se seleccionaron servicios confirmados. Enviando formulario sin información de servicios.");
            }

            console.log("Servicios seleccionados:", selectedServices);
            console.log("Servicios confirmados:", confirmedServices);

            form.submit();
        }
    
        function esHoraValida(hora) {
            const regex = /^(?:[01]\d|2[0-3]):(00|30)$/;
            return typeof hora === 'string' && regex.test(hora);
        }
    
        function generarInputOculto(nombre, valor) {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = nombre;
            input.value = valor;
            return input;
        }
    
        window.onscroll = function() {
            const vistaPrevia = document.getElementById('previstaServicio');
            const offset = Math.min(window.scrollY + 320, window.innerHeight - 300);
            vistaPrevia.style.top = offset + 'px';
        };
    
        function validarHoraEnRango() {
            const startInput = document.getElementById('start_time');
            const endInput = document.getElementById('end_time');
            const startTime = startInput.value;
            const endTime = endInput.value;

            const startHour = parseInt(startTime.split(':')[0], 10);
            const endHour = parseInt(endTime.split(':')[0], 10);

            const startValid = startHour >= 12 && startHour <= 23;
            const endValid = (endHour >= 0 && endHour <= 3) || (endHour >= 12 && endHour <= 23);

            if (!startValid || !endValid) {
                alert('Las horas deben estar entre las 12:00 PM y las 3:00 AM del día siguiente.');
                return false;
            }

            const startDateTime = new Date(`1970-01-01T${startTime}:00`);
            let endDateTime = new Date(`1970-01-01T${endTime}:00`);
            if (endHour >= 0 && endHour <= 3) {
                endDateTime.setDate(endDateTime.getDate() + 1);
            }

            if (endDateTime <= startDateTime) {
                alert('La hora de finalización debe ser posterior a la hora de inicio.');
                return false;
            }

            return true;
        }
    
        document.getElementById('start_time').setAttribute('step', '1800');
        document.getElementById('end_time').setAttribute('step', '1800');
    
        function establecerHorasDisponibles() {
            let horaInicioSelect = document.getElementById('start_time');
            let horaFinSelect = document.getElementById('end_time');
    
            for (let i = 0; i < 24; i++) {
                for (let j = 0; j < 60; j += 30) {
                    let hora = (i < 10 ? '0' : '') + i + ':' + (j === 0 ? '00' : '30');
    
                    let horaObj = new Date('1970-01-01T' + hora + ':00');
                    let horaInicioLimite = new Date('1970-01-01T11:00:00');
                    let horaFinLimite = new Date('1970-01-02T03:00:00');
    
                    if (horaObj >= horaInicioLimite && horaObj <= horaFinLimite) {
                        let optionInicio = new Option(hora, hora);
                        let optionFin = new Option(hora, hora);
                        horaInicioSelect.append(optionInicio);
                        horaFinSelect.append(optionFin);
                    }
                }
            }
        }
    
        window.onload = function() {
            establecerHorasDisponibles();
        };
    
        function toggleOtroTipoEvento() {
            const tipoEvento = document.getElementById('type_event').value;
            const otroTipoDiv = document.getElementById('otro_tipo_evento_div');
            const otroTipoInput = document.getElementById('otro_tipo_evento');
    
            if (tipoEvento === 'Otro') {
                otroTipoDiv.style.display = 'block';
                otroTipoInput.required = true;
            } else {
                otroTipoDiv.style.display = 'none';
                otroTipoInput.required = false;
            }
        }
    
        document.addEventListener('DOMContentLoaded', function() {
            const fieldsToWatch = ['place_id', 'date', 'start_time', 'end_time', 'guest_count', 'type_event', 'owner_name', 'owner_phone'];
    
            fieldsToWatch.forEach(fieldId => {
                const field = document.getElementById(fieldId);
                if (field) {
                    field.addEventListener('input', updatePreview);
                }
            });
    
            function updatePreview() {
                const name = document.getElementById('owner_name').value || 'Nombre';
                const date = document.getElementById('date').value || '-';
                const startTime = document.getElementById('start_time').value || '-';
                const endTime = document.getElementById('end_time').value || '-';
                const guests = document.getElementById('guest_count').value || '-';
                const typeEvent = document.getElementById('type_event').value || 'Evento';
    
                document.getElementById('prevista-nombre').innerText = name;
                document.getElementById('prevista-fecha').innerText = `Fecha: ${date}`;
                document.getElementById('prevista-horario').innerText = `Hora: ${startTime} - ${endTime}`;
                document.getElementById('prevista-invitados').innerText = `Invitados: ${guests}`;
                document.getElementById('prevista-tipo-evento').innerText = `Tipo de Evento: ${typeEvent}`;
            }

        const phoneInput = document.getElementById('owner_phone');
        phoneInput.addEventListener('input', limitPhoneNumberLength);

        function limitPhoneNumberLength() {
            if (this.value.length > 10) {
                this.value = this.value.slice(0, 10);
            }
        }
    
        });
    
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js"></script>
    
</body>
</html>
