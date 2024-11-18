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
            @elseif(session('error'))
            <div class="alert alert-success" role="alert" style="background-color: rgb(175, 46, 46); color: white;">
                {{ session('error') }}
            </div>
            @endif
            <div class="col-md-7" id="crearPaquete">
                <h3>Solicitar Cotización</h3>
                <form action="{{ route('cotizacionesclientes.store') }}" method="POST" id="cotizacionForm">
                    @csrf
                    <div class="mb-3">
                        <label for="place_id" class="form-label">Lugar</label>
                        <select name="place_id" id="place_id" class="form-control @error('place_id') is-invalid @enderror" required>
                            <option value="">Selecciona un lugar</option>
                            @foreach($places as $place)
                                <option value="{{ $place->id }}" {{ old('place_id') == $place->id ? 'selected' : '' }}>{{ $place->name }}</option>
                            @endforeach
                        </select>
                        @error('place_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
        
                    <!-- Campo de Fecha -->
                    <div class="mb-3 row">
                        <div class="col-md-6">
                            <label for="date" class="form-label">Fecha</label>
                            <input type="date" name="date" id="date" class="form-control @error('date') is-invalid @enderror" oninput="updatePreview()" value="{{ old('date') }}" required>
                            @error('date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Campos de Hora de Inicio y Fin -->
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

                    <div class="mb-3 form-check">
                        <input type="checkbox" id="day_after_checkbox" class="form-check-input" onchange="toggleEndTimeRange()">
                        <label for="day_after_checkbox" class="form-check-label">¿El evento finalizará al día siguiente?</label>
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
                            <input type="number" name="owner_phone" id="owner_phone" class="form-control @error('owner_phone') is-invalid @enderror" oninput="updatePreview()" value="{{ old('owner_phone') }}"required>
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
                                                    <input type="text" name="services[{{ $service->id }}][description]" placeholder="Descripción" class="form-control mt-2" style="display:none;">
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
                <div id="vista-previa-servicios" class="vista-previa mt-3"></div>
                <button type="button" class="btn btn-success mt-3" id="crearPaqueteBoton" onclick="crearPaquete()">Enviar Cotización</button>
            </div>
        </div>
    </div>

    <script>
        // Declaración de Variables de Almacenamiento
        let confirmedServices = {};
        let selectedServices = {};

        // Ejecución de Funciones al Ejecutar Vista
        window.addEventListener('load', ajustarAlturaCategorias);
        window.addEventListener('resize', ajustarAlturaCategorias);
    
        // Funciones Bárbaras
        function confirmarServicio(serviceId, categoryId) {
            const serviceCard = document.getElementById(`service-details-${serviceId}`);
            const description = document.querySelector(`input[name="services[${serviceId}][description]"]`)?.value;
            const confirmButton = serviceCard.querySelector(`#confirm-btn-${serviceId}`);

            if (!description || description.trim() === "") {
                alert('Por favor, ingresa una descripción válida.');
                return;
            }

            if (confirmButton && confirmButton.disabled === false) {
                confirmedServices[serviceId] = { categoryId, description, isConfirmed: true };

                serviceCard.classList.add('service-disabled');
                const checkbox = serviceCard.querySelector('input[type="checkbox"]');
                if (checkbox) checkbox.disabled = true;

                confirmButton.disabled = true;

                actualizarVistaServicios();
            } else {
                alert('Por favor, presiona el botón de confirmar para añadir el servicio.');
            }
        }

        function getServiceName(serviceId) {
            return services[serviceId] ? services[serviceId].name : "Servicio desconocido";
        }

        function actualizarVistaServicios() {
            const vistaPrevia = document.getElementById('vista-previa-servicios');
            vistaPrevia.innerHTML = '';

            if (Object.keys(confirmedServices).length === 0) {
                vistaPrevia.innerHTML = '<p>No hay servicios confirmados aún.</p>';
                return;
            }

            for (const [serviceId, serviceData] of Object.entries(confirmedServices)) {
                if (serviceData.isConfirmed) {
                    const serviceElement = document.createElement('div');
                    serviceElement.className = 'service-preview';
                    serviceElement.innerHTML = `
                        <p><strong>Servicio:</strong> ${getServiceName(serviceId)}</p>
                        <p><strong>Descripción:</strong> ${serviceData.description}</p>
                    `;
                    vistaPrevia.appendChild(serviceElement);
                }
            }
        }

        function toggleServices(categoryId) {
            const servicesDiv = document.getElementById(`services-${categoryId}`);
            servicesDiv.style.display = servicesDiv.style.display === 'block' ? 'none' : 'block';
        } 
    
        function selectService(checkbox, categoryId) {
            const selectedServiceId = checkbox.value;
            const isSelected = checkbox.checked;
            const serviceCard = checkbox.closest('.service-card');
            const serviceDescriptionInput = serviceCard.querySelector(`input[name="services[${selectedServiceId}][description]"]`);
            const confirmButton = serviceCard.querySelector(`#confirm-btn-${selectedServiceId}`);

            if (isSelected) {
                selectedServices[selectedServiceId] = { categoryId, isSelected: true };

                serviceDescriptionInput.style.display = 'block';
                confirmButton.style.display = 'block';
                serviceDescriptionInput.focus();

                serviceDescriptionInput.addEventListener('input', () => {
                    confirmButton.disabled = !serviceDescriptionInput.value.trim();
                });

                confirmButton.addEventListener('click', () => confirmarServicio(selectedServiceId, categoryId));
            } else {
                delete selectedServices[selectedServiceId];
                delete confirmedServices[selectedServiceId];

                serviceDescriptionInput.style.display = 'none';
                serviceDescriptionInput.value = '';
                confirmButton.style.display = 'none';
                confirmButton.disabled = true;
            }
        }

        function confirmService(serviceId) {
            const serviceCard = document.getElementById(`service-details-${serviceId}`);
            const descriptionInput = serviceCard.querySelector(`input[name="services[${serviceId}][description]"]`);
            const confirmButton = document.getElementById(`confirm-btn-${serviceId}`);

            if (!confirmedServices[serviceId]) {
                confirmedServices[serviceId] = {
                    isConfirmed: false,
                    description: ''
                };
            }

            if (!descriptionInput.value.trim()) {
                alert("Por favor, ingresa una descripción válida.");
                return;
            }

            confirmButton.addEventListener('click', function () {
                if (descriptionInput.value.trim()) {
                    confirmedServices[serviceId] = {
                        isConfirmed: true,
                        description: descriptionInput.value.trim()
                    };

                    actualizarVistaServicios();

                    serviceCard.style.opacity = 0.5;
                    serviceCard.style.pointerEvents = "none";

                    confirmButton.style.display = "none";
                    descriptionInput.style.display = "none";

                    alert("Servicio confirmado correctamente.");
                }
            });
        }

        function toggleConfirmButton(quantityInput) {
            const confirmButton = quantityInput.closest('.service-card').querySelector(`#confirm-btn-${quantityInput.name.match(/\d+/)[0]}`);
            confirmButton.disabled = !quantityInput.value;
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

        function updatePreview() {
            const name = document.getElementById('name').value;
            const description = document.getElementById('description').value;
            const startDate = document.getElementById('start_date').value;
            const endDate = document.getElementById('end_date').value;
            const price = document.getElementById('price').value;
    
            document.getElementById('prevista-nombre').innerText = name || "Nombre del Paquete";
            document.getElementById('prevista-descripcion').innerText = description || "Descripción del paquete";
            document.getElementById('prevista-fechas').innerText = `Fecha de Inicio: ${startDate} - Fecha de Finalización: ${endDate}`;
            document.getElementById('prevista-precio').innerText = `Precio: $${price || "0"}`;
        }
    
        function crearPaquete() {
            const form = document.getElementById('cotizacionForm');
            document.querySelectorAll('.service-hidden-input').forEach(input => input.remove());

            const date = document.getElementById('date').value;
            const startTime = document.getElementById('start_time').value;
            const endTime = document.getElementById('end_time').value;
            const dayAfterCheckbox = document.getElementById('day_after_checkbox').checked;

            const typeEventElement = document.getElementById('type_event');
            const typeEventValue = typeEventElement ? String(typeEventElement.value) : '';

            if (!date || !startTime || !endTime) {
                alert("Por favor, selecciona la fecha y las horas de inicio y fin del evento.");
                return;
            }

            const startDateTime = `${date} ${startTime.slice(0, 5)}`;
            let endDateTime = `${date} ${endTime.slice(0, 5)}`;
            if (dayAfterCheckbox) {
                const dateObj = new Date(`${date}T${endTime}:00`);
                dateObj.setDate(dateObj.getDate() + 1);
                const endDate = dateObj.toISOString().slice(0, 10);
                endDateTime = `${endDate} ${endTime.slice(0, 5)}`;
            }

            const startHour = parseInt(startTime.split(':')[0], 10);
            const endHour = parseInt(endTime.split(':')[0], 10);
            const endMinutes = parseInt(endTime.split(':')[1], 10);
            if (startHour < 12 || (endHour >= 3 && endMinutes > 0)) {
                alert("El evento debe comenzar después de las 12:00 pm y finalizar antes de las 03:00 am del día siguiente.");
                return;
            }

            form.appendChild(generarInputOculto('start_time', startDateTime));
            form.appendChild(generarInputOculto('end_time', endDateTime));
            form.appendChild(generarInputOculto('type_event', typeEventValue));

            console.log("Información del formulario:");
            console.log({
                date,
                startTime,
                endTime,
                startDateTime,
                endDateTime,
                typeEventValue,
                dayAfterCheckbox
            });

            let anyServiceConfirmed = false;
            for (let serviceId in confirmedServices) {
            const service = confirmedServices[serviceId];

            console.log(`Procesando servicio ${serviceId}:`, service);

            if (service.isConfirmed && service.description.trim() !== "") {
                console.log(`Confirmando servicio ${serviceId} con descripción: ${service.description}`);

                form.appendChild(generarInputOculto(`services[${serviceId}][description]`, service.description));
                form.appendChild(generarInputOculto(`services[${serviceId}][confirmed]`, true));
            } else {
                console.log(`Servicio ${serviceId} no confirmado o sin descripción válida. Se omite.`);
            }
            }

            if (!anyServiceConfirmed) {
                console.log("No se seleccionaron servicios confirmados. Enviando formulario sin información de servicios.");
            }

            console.log("Servicios seleccionados:", selectedServices);
            console.log("Servicios confirmados:", confirmedServices);

            form.submit();
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
            const offset = Math.min(window.scrollY + 280, window.innerHeight - 300);
            vistaPrevia.style.top = offset + 'px';
        };

    document.getElementById('start_time').addEventListener('input', function() {
        validarHora(this);
    });

    function validarHora(input) {
        let hora = input.value;
        let horaObj = new Date('1970-01-01T' + hora + ':00');
        let horaInicioLimite = new Date('1970-01-01T11:00:00');
        let horaFinLimite = new Date('1970-01-02T03:00:00');

        if (horaObj < horaInicioLimite || horaObj > horaFinLimite) {
            input.setCustomValidity('La hora debe estar entre las 11:00 AM y las 3:00 AM.');
        } else {
            input.setCustomValidity('');
        }
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

    });

    </script>
    
</body>
</html>
