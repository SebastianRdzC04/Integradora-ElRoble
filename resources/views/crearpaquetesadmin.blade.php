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
                <form action="{{ route('paquetes.store') }}" method="POST" id="paqueteForm">
                    @csrf
                    <div class="mb-3">
                        <label for="place_id" class="form-label">Lugar</label>
                        <select name="place_id" id="place_id" class="form-control">
                            <option value="">Selecciona un lugar</option>
                            @foreach($places as $place)
                                <option value="{{ $place->id }}">{{ $place->name }}</option>
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
                            <input type="date" name="start_date" id="start_date" class="form-control" oninput="updatePreview()">
                            @error('start_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="end_date" class="form-label">Fecha de Finalización</label>
                            <input type="date" name="end_date" id="end_date" class="form-control" oninput="updatePreview()">
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
                                <div class="row">  <!-- Contenedor row aquí -->
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
                                            <!-- Detalles del servicio -->
                                            <div id="service-details-{{ $service->id }}" class="service-input-details" style="display: none;">
                                                <input type="number" name="services[{{ $service->id }}][quantity]" placeholder="Cantidad" class="form-control mb-2" oninput="updateServicePreview('{{ $service->id }}')">
                                                <input type="number" name="services[{{ $service->id }}][price]" placeholder="Precio" class="form-control mb-2" oninput="updateServicePreview('{{ $service->id }}')">
                                                <input type="text" name="services[{{ $service->id }}][description]" placeholder="Descripción" class="form-control mb-2">
                                                <textarea name="services[{{ $service->id }}][additional_details]" placeholder="Detalles Adicionales" class="form-control mb-2"></textarea>
                                                <button class="btn btn-primary mb-2" onclick="confirmService('{{ $service->id }}', '{{ $category->id }}')">Confirmar</button> <!-- Botón de confirmar -->
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
                    <div id="servicios-lista"></div> <!-- Contenedor para mostrar los servicios seleccionados -->
                </div>
                <button class="btn btn-success mt-3" id="crearPaquete" onclick="crearPaquete()">Crear Paquete</button>
            </div>
        </div>
    </div>

    <script>
            let selectedServices = {}; // Objeto para almacenar servicios seleccionados

        function updateServicePreview(serviceId) {
            const serviceQuantityInput = document.querySelector(`input[name="services[${serviceId}][quantity]"]`);
            const servicePriceInput = document.querySelector(`input[name="services[${serviceId}][price]"]`);

            const serviceQuantity = serviceQuantityInput ? serviceQuantityInput.value : 0;
            const servicePrice = servicePriceInput ? servicePriceInput.value : 0;

            const serviciosLista = document.getElementById('servicios-lista');

            // Limpiar el contenedor de servicios seleccionados
            serviciosLista.innerHTML = '';

            // Mostrar la información actualizada en la vista previa
            if (serviceQuantity > 0 || servicePrice > 0) {
                const serviceName = document.querySelector(`input[value="${serviceId}"]`).closest('.service-card').querySelector('.card-title').innerText;
                serviciosLista.innerHTML += `<p><strong>Servicio:</strong> ${serviceName} (Cant. ${serviceQuantity}, $${servicePrice})</p>`;
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
    const isSelected = checkbox.checked; // Verifica si está seleccionado
    const serviciosLista = document.getElementById('servicios-lista');

    // Obtener el contenedor de detalles del servicio
    const serviceCard = checkbox.closest('.service-card');
    const serviceName = serviceCard.querySelector('.card-title').innerText; // Obtener el nombre del servicio
    const serviceQuantityInput = serviceCard.querySelector(`input[name="services[${selectedServiceId}][quantity]"]`);
    const servicePriceInput = serviceCard.querySelector(`input[name="services[${selectedServiceId}][price]"]`);

    const serviceQuantity = serviceQuantityInput ? serviceQuantityInput.value : 0; // Obtener la cantidad
    const servicePrice = servicePriceInput ? servicePriceInput.value : 0; // Obtener el precio

    // Limpiar el contenedor de servicios seleccionados, pero no eliminar lo existente
    if (isSelected) {
        // Agregar la información del servicio seleccionado
        serviciosLista.innerHTML += `<p><strong>${categoryId}</strong>: ${serviceName} (Cant. ${serviceQuantity}, $${servicePrice}) <button class="btn btn-primary btn-sm" onclick="confirmService('${selectedServiceId}', '${categoryId}')">Confirmar</button></p>`;
    } else {
        // Si el servicio es deseleccionado, eliminarlo de la lista
        serviciosLista.innerHTML = serviciosLista.innerHTML.split('<p>').filter(p => !p.includes(selectedServiceId)).join('<p>');
    }

    // Ocultar todos los contenedores de detalles de servicio
    document.querySelectorAll('.service-input-details').forEach(container => {
        container.style.display = 'none';
    });

    // Mostrar el contenedor de detalles para el servicio seleccionado
    const detailsContainer = document.getElementById(`service-details-${selectedServiceId}`);
    if (detailsContainer) {
        detailsContainer.style.display = isSelected ? 'block' : 'none'; // Solo mostrar si está seleccionado
    }

    // Ocultar otros servicios de la misma categoría
    const allServices = document.querySelectorAll(`input[name="services[${categoryId}][id]"]`);
    allServices.forEach(service => {
        const serviceCard = service.closest('.service-card');
        if (serviceCard) {
            if (service.value !== selectedServiceId) {
                serviceCard.style.visibility = isSelected ? 'hidden' : 'visible';
                serviceCard.style.height = isSelected ? '0' : ''; // Ajustar altura
                serviceCard.style.overflow = 'hidden';
            } else {
                // Si es el servicio seleccionado, dejar visible
                serviceCard.style.visibility = 'visible';
                serviceCard.style.height = ''; // Restaurar altura
            }
        }
    });
}

function confirmService(serviceId, categoryId) {
    // Ocultar todos los servicios de la categoría
    const servicesDiv = document.getElementById(`services-${categoryId}`);
    const allServices = document.querySelectorAll(`input[name="services[${categoryId}][id]"]`);

    allServices.forEach(service => {
        const serviceCard = service.closest('.service-card');
        serviceCard.style.display = 'none'; // Ocultar el servicio
    });

    // Ocultar el contenedor de detalles del servicio
    const detailsContainer = document.getElementById(`service-details-${serviceId}`);
    if (detailsContainer) {
        detailsContainer.style.display = 'none'; // Ocultar detalles
    }

    // Actualizar la vista previa después de confirmar
    updatePreview();
}

        function changeService(categoryId) {
            const servicesDiv = document.getElementById(`services-${categoryId}`);
            const allServices = document.querySelectorAll(`input[name="services[${categoryId}][id]"]`);

            // Mostrar todos los servicios de nuevo
            allServices.forEach(service => {
                const serviceItem = service.closest('.service-details');
                serviceItem.style.display = 'block';
            });

            const changeButton = document.getElementById(`changeButton-${categoryId}`);
            changeButton.style.display = 'none';
            updatePreview();
        }
        function crearPaquete() {
            document.getElementById('paqueteForm').submit();
        }
        // Función de desplazamiento suave para la vista previa
        window.onscroll = function() {
            const prevista = document.getElementById('previstaServicio');
            const scrollY = window.scrollY || window.pageYOffset;
            const offset = Math.min(scrollY + 280, window.innerHeight - 300); // Ajuste de posición
            prevista.style.top = offset + 'px';
        };
    </script>
</body>
</html>
