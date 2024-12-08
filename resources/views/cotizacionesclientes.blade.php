@extends('layouts.appaxel')

@section('title', 'El Roble - Cotización')

@section('styles')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/stylespaquetes.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
@endsection

@section('content')
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
                    <!-- Carrusel de Paquetes -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6>Paquetes Disponibles:</h6>
                            <div id="packageCarousel" class="carousel slide" data-bs-ride="carousel">
                                <div class="carousel-inner">
                                    @foreach($packages as $index => $package)
                                    @php
                                        $imageUrl = '';
                                        switch ($package->place->id) {
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
                                    @endphp
                                    <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                        <div id="card-carousel" class="card">
                                            <div class="card-body">
                                                <div class="prevista-imagen-container">
                                                    <img src="{{ $imageUrl }}" class="prevista-imagen" alt="Imagen del paquete">
                                                    <div class="carousel-caption">
                                                        <h5 class="card-title">{{ $package->name }}</h5>
                                                        <p class="card-text"><i class="bi bi-geo-alt-fill"></i> {{ $package->place->name }}</p>
                                                        <p class="card-text"> Máx. de <i class="bi bi-people-fill"></i>: {{ $package->max_people }}</p>
                                                        <p class="card-text"><i class="bi bi-currency-dollar"></i>{{ $package->price }}</p>
                                                    </div>
                                                </div>
                                                <p style="color: white;" class="card-text text-center"><strong>Servicios incluidos:</strong></p>
                                                <ul class="text-center">
                                                    @foreach($package->services as $service)
                                                        <li>{{ $service->name }}</li>
                                                    @endforeach
                                                </ul>
                                                <button class="btn btn-primary" id="SolicitarPaqueteBoton" onclick="openPackageModal({{ $package->id }})">Solicitar Paquete</button>
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
                        <div class="col-md-6">
                            <h6>Selecciona un Espacio</h6>
                            <!-- Cards de Lugar -->
                            <div class="row mb-4">
                                <div class="col-4 col-sm-4 col-md-12 col-lg-6">
                                    <div class="card lugar-card" onclick="selectPlace(1)">
                                        <img src="/images/imagen2.jpg" class="card-img-top" alt="Lugar 1">
                                        <div class="card-body text-center">
                                            <h5 class="card-title">Quinta</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4 col-sm-4 col-md-12 col-lg-6">
                                    <div class="card lugar-card" onclick="selectPlace(2)">
                                        <img src="/images/imagen7.jpg" class="card-img-top" alt="Lugar 2">
                                        <div class="card-body text-center">
                                            <h5 class="card-title">Salón</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4 col-sm-4 col-md-12 col-lg-6">
                                    <div class="card lugar-card" onclick="selectPlace(3)">
                                        <img src="/images/imagen8.jpg" class="card-img-top" alt="Lugar 3">
                                        <div class="card-body text-center">
                                            <h5 class="card-title">Quinta y Salón</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="place_id" id="place_id" value="{{ old('place_id') }}" required>
                            <div class="alert alert-danger d-none" id="placeError" role="alert" style="background-color:rgb(189, 18, 18); color: white;">
                                Por favor, selecciona un lugar.
                            </div>
                            @error('place_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <form action="{{ route('cotizacionesclientes.store') }}" method="POST" id="cotizacionForm">
                        @csrf
                        <div class="mb-3 row">
                            <div class="col-md-6">
                                <button id="escogerFechaBoton" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#calendarModal">
                                    Selecciona una Fecha
                                </button>
                                <input type="hidden" name="date" id="selectedDate">
                                <span class="selected-date" oninput="updatePreview()"></span>
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
                                <input type="number" name="guest_count" id="guest_count" class="form-control @error('guest_count') is-invalid @enderror" oninput="updatePreview()" value="{{ old('guest_count') }}" max="80" required>
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
                        <input type="hidden" name="owner_name" id="owner_name" value="{{ $user->name }}">
                        <input type="hidden" name="owner_phone" id="owner_phone" value="{{ $user->phone }}">
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
                                                        <input type="checkbox" name="services[{{ $service->id }}]" value="{{ $service->id }}" class="form-check-input" onchange="selectService(this, '{{ $category->id }}', {{ $service->quantifiable }})">
                                                        @if($service->quantifiable)
                                                            <input type="number" name="services[{{ $service->id }}][quantity]" placeholder="Cantidad" class="form-control mt-2" min="1" style="display:none;">
                                                        @endif
                                                        <button type="button" id="confirm-btn-{{ $service->id }}" class="btn btn-primary mt-2" style="display:none;" disabled onclick="confirmService('{{ $service->id }}')">Confirmar</button>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <button type="submit" class="d-none" id="hiddenSubmitButton" onclick="crearPaquete()">Enviar Cotización</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Vista Previa -->
        <div class="col-md-5" id="previstaServicio">
            <div class="prevista-imagen-container">
                <img id="prevista-imagen" class="prevista-imagen" src="{{ asset('images/imagen1.jpg') }}" alt="Vista previa" style="border: 2px solid rgba(255, 255, 255, 0.904)">
                <div class="prevista-caption-previa">
                    <p id="prevista-fecha">Fecha: -</p>
                    <p id="prevista-horario">Hora: -</p>
                    <p id="prevista-invitados">Invitados: -</p>
                    <p id="prevista-tipo-evento">Tipo de Evento: -</p>
                </div>
            </div>
            <button id="SolicitarPaqueteBoton" type="button" class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#servicesModal"><strong>Ver Servicios Confirmados</strong></button>
            <button type="button" class="btn btn-success mt-3" id="crearPaqueteBoton" onclick="document.getElementById('hiddenSubmitButton').click()"><strong>Enviar Cotización</strong></button>
        </div>
    </div>

<!-- Modal del calendario -->
<div class="modal fade" id="calendarModal" tabindex="-1" aria-labelledby="calendarModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="background-color: rgb(27, 59, 23); border: 3px solid rgb(255, 255, 255);">
            <div class="modal-header">
                <h5 class="modal-title" id="calendarModalLabel">Selecciona una Fecha</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="background-color: white;"></button>
            </div>
            <div class="modal-body">
                <div id="calendar-controls" class="d-flex justify-content-between mb-2">
                    <button id="prevMonth" class="btn btn-secondary">&lt; Anterior</button>
                    <h6 id="calendarMonthYear"></h6>
                    <button id="nextMonth" class="btn btn-secondary">Siguiente &gt;</button>
                </div>
                <div id="calendar"></div>
                <div class="mt-3">
                    <p><span class="badge bg-success">Verde</span> - Disponible</p>
                    <p><span class="badge bg-warning">Amarillo</span> - Más personas cotizando por la misma fecha</p>
                    <p><span class="badge bg-danger">Rojo</span> - No Disponible</p>
                    <p><span class="badge bg-secondary">Gris</span> - Fecha Inaccesible</p>
                </div>
                <button id="regresarPaqueteBoton" type="button" class="btn btn-primary mt-3 d-none" onclick="regresarAPaquete()">Regresar a Paquete</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Servicios Confirmados -->
<div class="modal fade" id="servicesModal" tabindex="-1" aria-labelledby="servicesModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="background-color: rgb(27, 59, 23); border: 3px solid rgb(255, 255, 255);">
            <div class="modal-header">
                <h5 class="modal-title" id="servicesModalLabel">Servicios Confirmados</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="background-color: white;"></button>
            </div>
            <div class="modal-body">
                <div id="modal-services-list" class="list-group">
                    <!-- Los servicios confirmados se agregarán aquí dinámicamente -->
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Paquetes -->
<div class="modal fade" id="packageModal" tabindex="-1" aria-labelledby="packageModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="background-color: rgb(27, 59, 23); border: 3px solid rgb(255, 255, 255);">
            <div class="modal-header">
                <h5 class="modal-title" id="packageModalLabel">Solicitar Cotización de Paquete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="background-color: white;"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 col-lg-6">
                        <div class="prevista-imagen-container">
                            <img id="packageImage" class="prevista-imagen w-100" src="/images/imagen1.jpg" alt="Vista previa">
                            <div class="prevista-caption-previa">
                                <h5 id="packageName">Nombre</h5>
                                <p id="packageDescription">Descripción: -</p>
                                <p id="packagePrice">Precio: -</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6 d-flex flex-column align-items-center">
                        <p id="packageServices"><strong>Servicios incluidos:</strong></p>
                        <ul id="packageServicesList" class="text-center"></ul>
                        <p id="packageEndDate" class="mt-3">Fecha de Finalización: -</p>
                    </div>
                </div>
                <form id="packageForm" action="{{ route('cotizacionesclientes.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="package_id" id="packageId">
                    <input type="hidden" name="place_id" id="modal_place_id">
                    <input type="hidden" id="modal_max_people">
                    <input type="hidden" name="start_time" id="modal_start_time">
                    <input type="hidden" name="end_time" id="modal_end_time">
                    <input type="hidden" name="services" id="modal_services_input">
                    <div class="mb-3 row">
                        <div class="col-md-6">
                            <button id="crearPaqueteBoton" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#calendarModal" onclick="setCalendarModalContext('package')">
                                Selecciona una Fecha
                            </button>
                            <input type="hidden" name="date" id="modal_selectedDate">
                            <span id="modal_selectedDateText" class="selected-date"></span>
                        </div>
                        <div class="col-md-3">
                            <label for="modal_start_time_input" class="form-label">Hora de Inicio</label>
                            <input type="time" id="modal_start_time_input" class="form-control" required>
                        </div>
                        <div class="col-md-3">
                            <label for="modal_end_time_input" class="form-label">Hora de Final</label>
                            <input type="time" id="modal_end_time_input" class="form-control" required>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <div class="col-md-6">
                            <label for="modal_guest_count" class="form-label">Cantidad de Invitados</label>
                            <input type="number" name="guest_count" id="modal_guest_count" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="modal_type_event" class="form-label">Tipo de Evento</label>
                            <select name="type_event" id="modal_type_event" class="form-control" onchange="toggleModalOtroTipoEvento()" required>
                                <option value="">Selecciona el tipo de evento</option>
                                <option value="XV's">XV's</option>
                                <option value="Cumpleaños">Cumpleaños</option>
                                <option value="Graduación">Graduación</option>
                                <option value="Posada">Posada</option>
                                <option value="Boda">Boda</option>
                                <option value="Baby Shower">Baby Shower</option>
                                <option value="Otro">Otro</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3" id="modal_otro_tipo_evento_div" style="display: none;">
                        <label for="modal_otro_tipo_evento" class="form-label">Especificar Tipo de Evento</label>
                        <input type="text" name="otro_tipo_evento" id="modal_otro_tipo_evento" class="form-control">
                    </div>
                    <!-- Agregar estos campos ocultos en el modal -->
                    <input type="hidden" name="owner_name" id="modal_owner_name" value="{{ $user->name }}">
                    <input type="hidden" name="owner_phone" id="modal_owner_phone" value="{{ $user->phone }}">
                    <button type="submit" class="btn btn-success" id="crearCotizacionModalBoton"><strong>Enviar Cotización</strong></button>
                </form>
            </div>
        </div>
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
        
            if (quantityInput && !quantityInput.value.trim()) {
                alert('Por favor, ingresa una cantidad válida.');
                return;
            }

            confirmedServices[serviceId] = {
                categoryId,
                quantity: quantityInput ? quantityInput.value.trim() : null,
                isConfirmed: true
            };

            serviceCard.classList.add('service-disabled');
            confirmButton.style.display = 'none';
            if (quantityInput) {
                quantityInput.style.display = 'none';
            }

            actualizarVistaServicios();
        }

        let calendarModalContext = 'main';

        function setCalendarModalContext(context) {
            calendarModalContext = context;
            const regresarPaqueteBoton = document.getElementById('regresarPaqueteBoton');
            if (context === 'package') {
                regresarPaqueteBoton.classList.remove('d-none');
            } else {
                regresarPaqueteBoton.classList.add('d-none');
            }
        }

        function regresarAPaquete() {
            const calendarModal = bootstrap.Modal.getInstance(document.getElementById('calendarModal'));
            calendarModal.hide();

            const packageModal = new bootstrap.Modal(document.getElementById('packageModal'));
            packageModal.show();
        }

        function getPackageImageUrl(placeId) {
            switch (placeId) {
                case 1:
                    return '/images/imagen2.jpg';
                case 2:
                    return '/images/imagen7.jpg';
                case 3:
                    return '/images/imagen8.jpg';
                default:
                    return '/images/imagen1.jpg';
            }
        }
    
        function getServiceName(serviceId) {
            return services[serviceId] ? services[serviceId].name : "Servicio desconocido";
        }

        function selectPlace(placeId) {
            document.querySelectorAll('.lugar-card').forEach(card => {
                card.classList.remove('selected');
            });

            const selectedCard = document.querySelector(`.lugar-card[onclick="selectPlace(${placeId})"]`);
            if (selectedCard) {
                selectedCard.classList.add('selected');
            }

            document.getElementById('place_id').value = placeId;
        }

        document.getElementById('cotizacionForm').addEventListener('submit', function(event) {
            const placeId = document.getElementById('place_id').value;
            const placeError = document.getElementById('placeError');

            if (!placeId) {
                event.preventDefault();
                placeError.classList.remove('d-none');
                placeError.scrollIntoView({ behavior: 'smooth' });
            } else {
                placeError.classList.add('d-none');
            }
        });
    
        function openPackageModal(packageId) {
    const package = @json($packages).find(pkg => pkg.id === packageId);
    if (!package) return;

    document.getElementById('packageId').value = package.id;
    document.getElementById('modal_place_id').value = package.place.id;
    document.getElementById('modal_max_people').value = package.max_people;
    document.getElementById('packageName').innerText = package.name;
    document.getElementById('packageDescription').innerText = `Descripción: ${package.description}`;
    document.getElementById('packagePrice').innerText = `Precio: $${package.price}`;

    // Formatear la fecha de finalización
    const endDate = new Date(package.end_date).toISOString().split('T')[0];
    const today = new Date();
    const endDateObj = new Date(endDate);
    const packageEndDateElement = document.getElementById('packageEndDate');

    packageEndDateElement.innerText = `Fecha de Finalización: ${endDate}`;

    if (endDateObj <= today) {
        packageEndDateElement.style.color = 'red';
        packageEndDateElement.style.fontWeight = 'bold';
    } else {
        packageEndDateElement.style.color = 'white';
        packageEndDateElement.style.fontWeight = 'normal';
    }

    let packageImage;
    switch (package.place.id) {
        case 1:
            packageImage = '/images/imagen2.jpg';
            break;
        case 2:
            packageImage = '/images/imagen7.jpg';
            break;
        case 3:
            packageImage = '/images/imagen8.jpg';
            break;
        default:
            packageImage = '/images/imagen1.jpg';
    }
    document.getElementById('packageImage').src = packageImage;

    const servicesList = document.getElementById('packageServicesList');
    servicesList.innerHTML = '';
    package.services.forEach(service => {
        const li = document.createElement('li');
        li.innerText = service.name;
        servicesList.appendChild(li);
    });

    const packageModal = new bootstrap.Modal(document.getElementById('packageModal'));
    packageModal.show();
}

        function validateGuestCount() {
            const maxPeopleInput = document.getElementById('modal_max_people');
            const guestCountInput = document.getElementById('modal_guest_count');

            if (!maxPeopleInput || !guestCountInput) {
                console.error('Elementos no encontrados:', {
                    maxPeopleInput: !!maxPeopleInput,
                    guestCountInput: !!guestCountInput
                });
                return false;
            }

            const maxPeople = parseInt(maxPeopleInput.value);
            const guestCount = parseInt(guestCountInput.value);

            console.log('Validando invitados:', { maxPeople, guestCount });

            if (isNaN(maxPeople) || isNaN(guestCount)) {
                alert('Por favor ingrese números válidos');
                return false;
            }

            if (guestCount > maxPeople) {
                alert(`La cantidad de invitados no puede ser mayor a ${maxPeople} personas.`);
                guestCountInput.value = maxPeople;
                return false;
            }
            return true;
        }

        document.getElementById('packageForm').onsubmit = function(e) {
    e.preventDefault();
    console.log('Formulario enviado');

    if (!validateGuestCount()) {
        return false;
    }

    const date = document.getElementById('modal_selectedDate');
    const startTime = document.getElementById('modal_start_time_input');
    const endTime = document.getElementById('modal_end_time_input');
    const startDateTime = `${date.value} ${startTime.value}`;
    let endDateTime = `${date.value} ${endTime.value}`;

    const endHour = parseInt(endTime.value.split(':')[0], 10);
    if (endHour >= 0 && endHour <= 3) {
        const dateObj = new Date(`${date.value}T${endTime.value}`);
        dateObj.setDate(dateObj.getDate() + 1);
        const endDate = dateObj.toISOString().slice(0, 10);
        endDateTime = `${endDate} ${endTime.value}`;
    }

    const modalStartTime = document.getElementById('modal_start_time');
    const modalEndTime = document.getElementById('modal_end_time');
    const packageId = document.getElementById('packageId');
    const modalPlaceId = document.getElementById('modal_place_id');
    const modalServicesInput = document.getElementById('modal_services_input');
    const modalGuestCount = document.getElementById('modal_guest_count');
    const modalTypeEvent = document.getElementById('modal_type_event');

    if (!date || !startTime || !endTime || !modalStartTime || !modalEndTime || !packageId || !modalPlaceId || !modalServicesInput || !modalGuestCount || !modalTypeEvent) {
        console.error('Elementos no encontrados:', {
            date: !!date,
            startTime: !!startTime,
            endTime: !!endTime,
            modalStartTime: !!modalStartTime,
            modalEndTime: !!modalEndTime,
            packageId: !!packageId,
            modalPlaceId: !!modalPlaceId,
            modalServicesInput: !!modalServicesInput,
            modalGuestCount: !!modalGuestCount,
            modalTypeEvent: !!modalTypeEvent
        });
        return false;
    }

    modalStartTime.value = startDateTime;
    modalEndTime.value = endDateTime;

    const package = @json($packages).find(pkg => pkg.id === packageId.value);
    if (package && package.services) {
        const servicesData = {};
        package.services.forEach(service => {
            servicesData[service.id] = {
                quantity: null
            };
        });

        modalServicesInput.value = JSON.stringify(servicesData);
    }

    console.log('Datos a enviar:', {
        package_id: packageId.value,
        place_id: modalPlaceId.value,
        start_time: startDateTime,
        end_time: endDateTime,
        date: date.value,
        guest_count: modalGuestCount.value,
        type_event: modalTypeEvent.value,
        services: modalServicesInput.value ? JSON.parse(modalServicesInput.value) : {}
    });

    this.submit();
};

        function toggleModalOtroTipoEvento() {
            const tipoEvento = document.getElementById('modal_type_event').value;
            const otroTipoDiv = document.getElementById('modal_otro_tipo_evento_div');
            const otroTipoInput = document.getElementById('modal_otro_tipo_evento');

            if (tipoEvento === 'Otro') {
                otroTipoDiv.style.display = 'block';
                otroTipoInput.required = true;
            } else {
                otroTipoDiv.style.display = 'none';
                otroTipoInput.value = '';
                otroTipoInput.required = false;
            }
        }

        function actualizarVistaServicios() {
    const modalServicesList = document.getElementById('modal-services-list');
    modalServicesList.innerHTML = '';

    const serviciosConfirmados = Object.entries(confirmedServices).filter(
        ([, serviceData]) => serviceData.isConfirmed
    );

    if (serviciosConfirmados.length === 0) {
        modalServicesList.innerHTML = '<p>No hay servicios confirmados aún.</p>';
        return;
    }

    for (const [serviceId, serviceData] of serviciosConfirmados) {
        const serviceItem = document.createElement('div');
        serviceItem.className = 'list-group-item list-group-item-action';
        serviceItem.innerHTML = `
            <div class="d-flex w-100 justify-content-between">
                <h5 class="mb-1">${getServiceName(serviceId)}</h5>
                <button class="btn btn-danger btn-sm" onclick="confirmarEliminacionServicio('${serviceId}')">Eliminar</button>
            </div>
            <p class="mb-1">Cantidad: ${serviceData.quantity || 'No especificada'}</p>
        `;
        modalServicesList.appendChild(serviceItem);
    }
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
    
        function selectService(checkbox, categoryId, isQuantifiable) {
            const selectedServiceId = checkbox.value;
            const isSelected = checkbox.checked;
            const serviceCard = checkbox.closest('.service-card');
            const serviceQuantityInput = serviceCard.querySelector(`input[name="services[${selectedServiceId}][quantity]"]`);
            const confirmButton = serviceCard.querySelector(`#confirm-btn-${selectedServiceId}`);
    
            if (isSelected) {
                selectedServices[selectedServiceId] = { categoryId, isSelected: true };
    
                if (isQuantifiable) {
                    serviceQuantityInput.style.display = 'block';
                    confirmButton.style.display = 'block';
                    serviceQuantityInput.focus();

                    serviceQuantityInput.addEventListener('input', () => {
                    confirmButton.disabled = !serviceQuantityInput.value.trim();
                });
            } else {
                confirmButton.style.display = 'block';
                confirmButton.disabled = false;
            }

                confirmButton.addEventListener('click', () => confirmarServicio(selectedServiceId, categoryId));
            } else {
                delete selectedServices[selectedServiceId];
                delete confirmedServices[selectedServiceId];

                if (isQuantifiable) {
                    serviceQuantityInput.style.display = 'none';
                    serviceQuantityInput.value = '';
                }
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

            const date = document.getElementById('selectedDate').value;
            const startInput = document.getElementById('start_time');
            const endInput = document.getElementById('end_time');
            const startTime = startInput.value;
            const endTime = endInput.value;

            const typeEventElement = document.getElementById('type_event');
            const typeEventValue = typeEventElement ? String(typeEventElement.value) : '';

            const placeId = document.getElementById('place_id').value;
            if (!placeId) {
                alert("Por favor, llena todos los campos requeridos.");
                return;
            }

            if (!date || !startTime || !endTime) {
                alert("Por favor, llena todos los campos requeridos.");
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
            form.appendChild(generarInputOculto('place_id', placeId));

            const ownerName = document.getElementById('owner_name').value;
            const ownerPhone = document.getElementById('owner_phone').value;
            form.appendChild(generarInputOculto('owner_name', ownerName));
            form.appendChild(generarInputOculto('owner_phone', ownerPhone));

            let anyServiceConfirmed = false;
            for (let serviceId in confirmedServices) {
                const service = confirmedServices[serviceId];

                if (service.isConfirmed && service.quantity.trim() !== "") {
                    console.log(`Confirmando servicio ${serviceId} con cantidad: ${service.quantity}`);

                    form.appendChild(generarInputOculto(`services[${serviceId}][quantity]`, service.quantity));
                    form.appendChild(generarInputOculto(`services[${serviceId}][confirmed]`, true));
                    anyServiceConfirmed = true;
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
            const offset = Math.min(window.scrollY + 400, window.innerHeight - 400);
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


            const guestCountInput = document.getElementById('guest_count');
            guestCountInput.addEventListener('input', limitGuestCount);

            function limitGuestCount() {
                this.value = this.value.replace(/\D/g, '');
                if (this.value.length > 2) {
                    this.value = this.value.slice(0, 2);
                }
                if (parseInt(this.value) > 80) {
                    this.value = '80';
                }
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
    const calendar = document.getElementById('calendar');
    const selectedDateInput = document.getElementById('selectedDate');
    const calendarMonthYear = document.getElementById('calendarMonthYear');
    const prevMonthButton = document.getElementById('prevMonth');
    const nextMonthButton = document.getElementById('nextMonth');
    const today = new Date();
    let currentDate = new Date(today.getFullYear(), today.getMonth(), 1);
    const csrfToken = '{{ csrf_token() }}';

    prevMonthButton.addEventListener('click', () => changeMonth(-1));
    nextMonthButton.addEventListener('click', () => changeMonth(1));

    function changeMonth(offset) {
        currentDate.setMonth(currentDate.getMonth() + offset);
        generateCalendar();
    }

    function generateCalendar() {
        calendar.innerHTML = '';
        calendarMonthYear.innerText = currentDate.toLocaleString('default', { month: 'long', year: 'numeric' });

        // Deshabilitar botones de navegación según las restricciones
        const minDate = new Date(today.getFullYear(), today.getMonth(), 1);
        const maxDate = new Date(today.getFullYear(), today.getMonth() + 2, 1);

        prevMonthButton.disabled = currentDate <= minDate;
        nextMonthButton.disabled = currentDate >= maxDate;

        const daysOfWeek = ['Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb'];
        const daysHeader = document.createElement('div');
        daysHeader.classList.add('days-header', 'd-flex', 'justify-content-between');
        daysOfWeek.forEach(day => {
            const dayElement = document.createElement('div');
            dayElement.classList.add('day-header');
            dayElement.innerText = day;
            daysHeader.appendChild(dayElement);
        });
        calendar.appendChild(daysHeader);

        const firstDayOfMonth = new Date(currentDate.getFullYear(), currentDate.getMonth(), 1).getDay();
        const daysInMonth = new Date(currentDate.getFullYear(), currentDate.getMonth() + 1, 0).getDate();

        let day = 1;
        let row = document.createElement('div');
        row.classList.add('days-row', 'd-flex', 'justify-content-between');

        for (let i = 0; i < firstDayOfMonth; i++) {
            const emptyCell = document.createElement('div');
            emptyCell.classList.add('day', 'empty');
            row.appendChild(emptyCell);
        }

        while (day <= daysInMonth) {
            if (row.children.length === 7) {
                calendar.appendChild(row);
                row = document.createElement('div');
                row.classList.add('days-row', 'd-flex', 'justify-content-between');
            }

            const dayButton = document.createElement('button');
            dayButton.classList.add('day');
            dayButton.innerText = day;
            const date = new Date(currentDate.getFullYear(), currentDate.getMonth(), day);
            dayButton.dataset.date = date.toISOString().split('T')[0];

            if (date < today) {
                dayButton.classList.add('bg-secondary');
            } else {
                dayButton.classList.add('bg-success');
                dayButton.addEventListener('click', function() {
                    if (!dayButton.classList.contains('bg-danger')) {
                        if (calendarModalContext === 'main') {
                            selectedDateInput.value = this.dataset.date;
                            document.querySelector('.selected-date').innerText = this.dataset.date;
                        } else if (calendarModalContext === 'package') {
                            document.getElementById('modal_selectedDate').value = this.dataset.date;
                            document.getElementById('modal_selectedDateText').innerText = this.dataset.date;
                        }

                        // Remove bg-primary from all buttons
                        document.querySelectorAll('.day.bg-primary').forEach(btn => {
                            btn.classList.remove('bg-primary');
                            btn.classList.add('bg-success');
                        });

                        // Add bg-primary to the clicked button
                        dayButton.classList.remove('bg-success', 'bg-warning', 'bg-danger');
                        dayButton.classList.add('bg-primary');
                    }
                });
            }

            row.appendChild(dayButton);
            day++;
        }

        while (row.children.length < 7) {
            const emptyCell = document.createElement('div');
            emptyCell.classList.add('day', 'empty');
            row.appendChild(emptyCell);
        }

        calendar.appendChild(row);
        fetchCotizations();
    }

    function fetchCotizations() {
        fetch('/api/cotizations', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({ start_date: new Date(currentDate.getFullYear(), currentDate.getMonth(), 1).toISOString().split('T')[0] })
        })
        .then(response => response.json())
        .then(data => {
            data.forEach(cotization => {
                const dateButton = document.querySelector(`button[data-date="${cotization.date}"]`);
                if (dateButton) {
                    if (cotization.status === 'pagada' || cotization.count >= 3) {
                        dateButton.classList.remove('bg-success', 'bg-warning');
                        dateButton.classList.add('bg-danger');
                        dateButton.disabled = true;
                    } else if (cotization.count >= 1) {
                        dateButton.classList.remove('bg-success');
                        dateButton.classList.add('bg-warning');
                    }
                }
            });
        });
    }

    generateCalendar();
});
    
function updatePreview() {
    const date = document.getElementById('selectedDate').value || '-';
    const startTime = document.getElementById('start_time').value || '-';
    const endTime = document.getElementById('end_time').value || '-';
    const guests = document.getElementById('guest_count').value || '-';
    const typeEvent = document.getElementById('type_event').value || 'Evento';

    document.getElementById('prevista-fecha').innerText = `Fecha: ${date}`;
    document.getElementById('prevista-horario').innerText = `Hora: ${startTime} - ${endTime}`;
    document.getElementById('prevista-invitados').innerText = `Invitados: ${guests}`;
    document.getElementById('prevista-tipo-evento').innerText = `Tipo de Evento: ${typeEvent}`;

    const serviciosConfirmados = Object.entries(confirmedServices).filter(
        ([, serviceData]) => serviceData.isConfirmed
    );

    const vistaPreviaServicios = document.getElementById('vista-previa-servicios');
    vistaPreviaServicios.innerHTML = '';

    if (serviciosConfirmados.length === 0) {
        vistaPreviaServicios.innerHTML = '<p>No hay servicios confirmados aún.</p>';
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

    vistaPreviaServicios.appendChild(listaServicios);
}

    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js"></script>
@endsection