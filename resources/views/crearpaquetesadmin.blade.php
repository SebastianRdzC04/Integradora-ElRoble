<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>El Roble - Crear Paquete</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/stylespaquetes.css') }}">
    <style>
        .prevista-imagen {
            width: 100%;
            height: auto;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-7" id="crearPaquete">
                <h3>Crear Nuevo Paquete</h3>
                <form action="{{ route('paquetes.store') }}" method="POST" enctype="multipart/form-data" id="paqueteForm">
                    @csrf
                    <div class="mb-3">
                        <label for="place_id" class="form-label">Lugar</label>
                        <select name="place_id" id="place_id" class="form-control">
                            <option value="">Selecciona un lugar</option>
                            @foreach($places as $place)
                                <option value="{{ $place->id }}" {{ old('place_id') == $place->id ? 'selected' : '' }}>{{ $place->name }}</option>
                            @endforeach
                        </select>
                        @error('place_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Nombre del Paquete</label>
                        <input type="text" name="name" id="name" class="form-control" maxlength="50" placeholder="Ej. Paquete Conmemorativo" value="{{ old('name') }}" oninput="updatePreview()">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Descripción (máx. 60 caracteres)</label>
                        <input type="text" name="description" id="description" class="form-control" maxlength="60" placeholder="Ej. Lo esencial para un evento inolvidable..." value="{{ old('description') }}" oninput="updatePreview()">
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="max_people" class="form-label">Máximo de Personas</label>
                        <input type="number" name="max_people" id="max_people" class="form-control" placeholder="Ej. 50" value="{{ old('max_people') }}" oninput="updatePreview()">
                        @error('max_people')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">Precio del Paquete</label>
                        <input type="number" name="price" id="price" class="form-control" placeholder="Ej. $5000" value="{{ old('price') }}" oninput="updatePreview()">
                        @error('price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3 row">
                        <div class="col-md-6">
                            <label for="start_date" class="form-label">Fecha de Inicio</label>
                            <input type="date" name="start_date" id="start_date" class="form-control" value="{{ old('start_date') ? \Carbon\Carbon::parse(old('start_date'))->format('Y-m-d') : '' }}" oninput="updatePreview()">
                            @error('start_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="end_date" class="form-label">Fecha de Finalización</label>
                            <input type="date" name="end_date" id="end_date" class="form-control" value="{{ old('end_date') ? \Carbon\Carbon::parse(old('end_date'))->format('Y-m-d') : '' }}" oninput="updatePreview()">
                            @error('end_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>                    
                    <div class="mb-3">
                        <label for="file_upload" class="form-label">Seleccionar Archivo</label>
                        <input type="file" name="file_upload" id="file_upload" class="form-control">
                    </div>
                    <h4 class="mt-4">Categorías de Servicios</h4>
                    <div class="row">
                        @foreach($categories as $category)
                            <div class="col-md-4 mb-3 equal-height">
                                <div class="card category-card" onclick="toggleServices('{{ $category->id }}')">
                                    <div class="card-body text-center">
                                        <h5 class="card-title">{{ $category->name }}</h5>
                                    </div>
                                </div>
                            </div>
                            <div id="services-{{ $category->id }}" class="service-item" style="display: none;">
                                <div class="row">
                                    @foreach($category->services as $service)
                                        <div class="col-md-4 mb-3">
                                            <div class="card service-card">
                                                <img src="{{ asset('images/imagen6.jpg') }}" class="card-img-top" alt="{{ $service->name }}">
                                                <div class="card-body">
                                                    <h5 class="card-title">{{ $service->name }}</h5>
                                                    <p class="card-text">{{ $service->description }}</p>
                                                    <p class="card-text">Precio: ${{ $service->price }}</p>
                                                    <input type="checkbox" name="services[{{ $category->id }}][id]" value="{{ $service->id }}" class="form-check-input" onchange="selectService(this, '{{ $category->id }}')">
                                                </div>
                                            </div>
                                            <div id="service-details-{{ $service->id }}" class="service-input-details" style="display: none;">
                                                <input type="number" name="services[{{ $service->id }}][quantity]" placeholder="Cantidad" class="form-control mb-2" oninput="validateAndShowConfirm('{{ $service->id }}')">
                                                <input type="number" name="services[{{ $service->id }}][price]" placeholder="Precio" class="form-control mb-2" oninput="validateAndShowConfirm('{{ $service->id }}')">
                                                <input type="text" name="services[{{ $service->id }}][description]" placeholder="Descripción" class="form-control mb-2" oninput="validateAndShowConfirm('{{ $service->id }}')">
                                                <button type="button" class="btn btn-primary mb-2" id="confirmButton-{{ $service->id }}" onclick="confirmService('{{ $service->id }}', '{{ $category->id }}')" disabled>Confirmar</button>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </form>
            </div>
            <div class="col-md-5" id="previstaServicio">
                <div class="prevista-imagen-container">
                    <img id="prevista-imagen" class="prevista-imagen" src="{{ asset('images/imagen1.jpg') }}" alt="Vista previa">
                    <div class="prevista-caption">
                        <h5 id="prevista-nombre">Nombre del Paquete</h5>
                        <p id="prevista-descripcion">Descripción del paquete</p>
                        <p id="prevista-fechas">Fecha de Inicio - Fecha de Finalización</p>
                        <p id="prevista-precio">Precio: $0</p>
                    </div>
                </div>
                <div id="servicios-seleccionados" class="mt-3">
                    <h6><strong>Servicios:</strong></h6>
                    <div id="servicios-lista"></div>
                </div>
                <button type="button" class="btn btn-success mt-3" id="crearPaquete" onclick="submitForm()">Crear Paquete</button>
            </div>
        </div>
    </div>    
    

    <script>

        let confirmedServices = {};
        let selectedServices = {};

        function submitForm() {
    // Solo enviar el formulario si todos los servicios están confirmados
    if (Object.values(confirmedServices).every(service => service.isConfirmed)) {
        document.getElementById('paqueteForm').submit();
    } else {
        alert('Por favor, confirma todos los servicios antes de crear el paquete.');
    }
}

        function confirmarServicio() {
            // Captura los datos del formulario emergente del servicio
            let cantidad = document.getElementById('cantidad').value;
            let precio = document.getElementById('precio').value;
            let descripcion = document.getElementById('descripcion').value;

            // Valida los campos para asegurarse de que todos están completos
            if (!cantidad || !precio || !descripcion) {
                alert('Por favor, completa todos los campos.');
                return;
            }

            // Muestra los datos confirmados en la vista previa
            document.getElementById('vistaPrevia').innerHTML += `
                <p>Servicio: ${descripcion}, Cantidad: ${cantidad}, Precio: ${precio}</p>
            `;

            // Cierra el modal después de confirmar (opcional)
            $('#modalServicio').modal('hide');
        }

        function validateAndShowConfirm(serviceId) {
            const quantity = document.querySelector(`input[name="services[${serviceId}][quantity]"]`).value;
            const price = document.querySelector(`input[name="services[${serviceId}][price]"]`).value;
            const description = document.querySelector(`input[name="services[${serviceId}][description]"]`).value;

            // Activa el botón de confirmación solo si todos los campos están completos
            const confirmButton = document.getElementById(`confirmButton-${serviceId}`);
            confirmButton.disabled = !(quantity && price && description);
        }


        function confirmService(serviceId, categoryId) {
    const quantity = document.querySelector(`input[name="services[${serviceId}][quantity]"]`).value;
    const price = document.querySelector(`input[name="services[${serviceId}][price]"]`).value;
    const description = document.querySelector(`input[name="services[${serviceId}][description]"]`).value;

    // Almacena los detalles sin enviar el formulario, marcando el servicio como confirmado
    confirmedServices[serviceId] = {
        categoryId,
        quantity,
        price,
        description,
        isConfirmed: true // Marca el servicio como confirmado
    };

    // Actualiza la vista previa
    updateServicePreview();
    document.getElementById(`service-details-${serviceId}`).style.display = 'none';

    // Revisa si todos los servicios están confirmados y actualiza el estado del botón
    toggleCreatePackageButton();
}


        function updateServicePreview() {
    const serviciosLista = document.getElementById('servicios-lista');
    serviciosLista.innerHTML = '';

    // Muestra todos los servicios confirmados en la vista previa
    for (let serviceId in confirmedServices) {
        const service = confirmedServices[serviceId];
        const serviceName = document.querySelector(`input[value="${serviceId}"]`).closest('.service-card').querySelector('.card-title').innerText;

        // Agrega el texto de confirmación (sin confirmar o confirmado)
        const confirmationText = service.isConfirmed ? "" : " <span style='color: red;'>(Sin confirmar)</span>";

        serviciosLista.innerHTML += `<p><strong>Servicio:</strong> ${serviceName} (Cant. ${service.quantity}, $${service.price}, ${service.description})${confirmationText}</p>`;
    }
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

        function toggleServices(categoryId) {
            const servicesDiv = document.getElementById(`services-${categoryId}`);
            const isVisible = servicesDiv.style.display === 'block';
            servicesDiv.style.display = isVisible ? 'none' : 'block';
        }

        function selectService(checkbox, categoryId) {
            const selectedServiceId = checkbox.value;
            const isSelected = checkbox.checked;
            const serviciosLista = document.getElementById('servicios-lista');

            const serviceCard = checkbox.closest('.service-card');
            const serviceName = serviceCard.querySelector('.card-title').innerText;
            const serviceQuantityInput = serviceCard.querySelector(`input[name="services[${selectedServiceId}][quantity]"]`);
            const servicePriceInput = serviceCard.querySelector(`input[name="services[${selectedServiceId}][price]"]`);

            const serviceQuantity = serviceQuantityInput ? serviceQuantityInput.value : 0;
            const servicePrice = servicePriceInput ? servicePriceInput.value : 0;

            if (isSelected) {
                // Agregar texto "(Sin confirmar)" si no está confirmado
                serviciosLista.innerHTML += `<p><strong>${categoryId}</strong>: ${serviceName} (Cant. ${serviceQuantity}, $${servicePrice}) ${confirmedServices[selectedServiceId] && !confirmedServices[selectedServiceId].isConfirmed ? "<span style='color: red;'>(Sin confirmar)</span>" : ""}</p>`;
            } else {
                serviciosLista.innerHTML = serviciosLista.innerHTML.split('<p>').filter(p => !p.includes(selectedServiceId)).join('<p>');
            }

            document.querySelectorAll('.service-input-details').forEach(container => {
                container.style.display = 'none';
            });

            const detailsContainer = document.getElementById(`service-details-${selectedServiceId}`);
            if (detailsContainer) {
                detailsContainer.style.display = isSelected ? 'block' : 'none';
            }

            const allServices = document.querySelectorAll(`input[name="services[${categoryId}][id]"]`);
            allServices.forEach(service => {
                const serviceCard = service.closest('.service-card');
                if (serviceCard) {
                    if (service.value !== selectedServiceId) {
                        serviceCard.style.visibility = isSelected ? 'hidden' : 'visible';
                        serviceCard.style.height = isSelected ? '0' : '';
                        serviceCard.style.overflow = 'hidden';
                    } else {
                        serviceCard.style.visibility = 'visible';
                        serviceCard.style.height = '';
                    }
                }
            });
        }

        function checkIfAllServicesConfirmed() {
    // Verifica si todos los servicios han sido confirmados
    return Object.values(confirmedServices).every(service => service.isConfirmed);
}

function toggleCreatePackageButton() {
    const createButton = document.getElementById('crearPaqueteButton');
    createButton.disabled = !checkIfAllServicesConfirmed();  // Deshabilita si no todos los servicios están confirmados
}

        function changeService(categoryId) {
            const servicesDiv = document.getElementById(`services-${categoryId}`);
            const allServices = document.querySelectorAll(`input[name="services[${categoryId}][id]"]`);

            allServices.forEach(service => {
                const serviceItem = service.closest('.service-details');
                serviceItem.style.display = 'block';
            });

            const changeButton = document.getElementById(`changeButton-${categoryId}`);
            changeButton.style.display = 'none';
            updatePreview();
        }
        
        function crearPaquete() {
    // Verificar si hay servicios sin confirmar
    const unconfirmedServices = Object.values(confirmedServices).some(service => !service.isConfirmed);

    if (unconfirmedServices) {
        // Mostrar el mensaje de confirmación
        if (confirm("El paquete se creará sin los servicios que no se han confirmado, ¿estás seguro de continuar?")) {
            const form = document.getElementById('paqueteForm');

            // Eliminar los servicios previos para evitar duplicados
            document.querySelectorAll('.service-hidden-input').forEach(input => input.remove());

            // Agregar cada servicio confirmado como campos ocultos en el formulario
            for (let serviceId in confirmedServices) {
                const service = confirmedServices[serviceId];

                // Solo añadir servicios confirmados
                if (service.isConfirmed) {
                    const serviceInput = document.createElement('input');
                    serviceInput.type = 'hidden';
                    serviceInput.name = `services[${serviceId}]`;
                    serviceInput.value = JSON.stringify(service);
                    serviceInput.classList.add('service-hidden-input');

                    form.appendChild(serviceInput);
                }
            }

            // Enviar el formulario
            form.submit();
        }
    } else {
        // Si todos los servicios están confirmados, simplemente crea el paquete
        const form = document.getElementById('paqueteForm');
        document.querySelectorAll('.service-hidden-input').forEach(input => input.remove());

        for (let serviceId in confirmedServices) {
            const service = confirmedServices[serviceId];

            const serviceInput = document.createElement('input');
            serviceInput.type = 'hidden';
            serviceInput.name = `services[${serviceId}]`;
            serviceInput.value = JSON.stringify(service);
            serviceInput.classList.add('service-hidden-input');

            form.appendChild(serviceInput);
        }

        form.submit();
    }
}

        window.onscroll = function() {
            const prevista = document.getElementById('previstaServicio');
            const scrollY = window.scrollY || window.pageYOffset;
            const offset = Math.min(scrollY + 280, window.innerHeight - 300);
            prevista.style.top = offset + 'px';
        };
    </script>
</body>
</html>
