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
            @if(session('success'))
            <div class="alert alert-success" role="alert" style="background-color: rgb(30, 78, 21); color: white;">
                {{ session('success') }}
            </div>
            @endif
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
                    <div class="mb-3 row">
                        <div class="col-md-6">
                            <label for="max_people" class="form-label">Máximo de Personas</label>
                            <input type="number" name="max_people" id="max_people" class="form-control" placeholder="Ej. 50" value="{{ old('max_people') }}" oninput="updatePreview()">
                            @error('max_people')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="price" class="form-label">Precio del Paquete</label>
                            <input type="number" name="price" id="price" class="form-control" placeholder="Ej. $5000" value="{{ old('price') }}" oninput="updatePreview()">
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
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
                        <label for="image" class="form-label">Subir Imagen del Paquete</label>
                        <input type="file" name="image" id="image" class="form-control" accept="image/*" onchange="previewImage(event)">
                    </div>
                    <h4 class="mt-4">Categorías de Servicios</h4>
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
                                        <div class="col-md-4 mb-3">
                                            <div class="card service-card">
                                                <img src="{{ $service->image_path ? asset('storage/' . $service->image_path) : asset('images/imagen6.jpg') }}" class="card-img-top" alt="{{ $service->name }}">
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
                    <img id="prevista-imagen" class="prevista-imagen" src="{{ asset('images/imagen1.jpg') }}" alt="Vista previa" style="border: 2px solid rgb(255, 255, 255);">
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
                <button type="button" class="btn btn-success mt-3" id="crearPaqueteBoton" onclick="crearPaquete()">Crear Paquete</button>
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
        function confirmarServicio() {
            let cantidad = document.getElementById('cantidad').value;
            let precio = document.getElementById('precio').value;
            let descripcion = document.getElementById('descripcion').value;

            if (!cantidad || !precio || !descripcion) {
                alert('Por favor, completa todos los campos.');
                return;
            }

            document.getElementById('vistaPrevia').innerHTML += `
                <p>Servicio: ${descripcion}, Cantidad: ${cantidad}, Precio: ${precio}</p>
            `;

            $('#modalServicio').modal('hide');
        }

        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function() {
                const output = document.getElementById('prevista-imagen');
                output.src = reader.result;
            }
            reader.readAsDataURL(event.target.files[0]);
        }

        function validateAndShowConfirm(serviceId) {
            const quantity = document.querySelector(`input[name="services[${serviceId}][quantity]"]`).value;
            const price = document.querySelector(`input[name="services[${serviceId}][price]"]`).value;
            const description = document.querySelector(`input[name="services[${serviceId}][description]"]`).value;

            const confirmButton = document.getElementById(`confirmButton-${serviceId}`);
            confirmButton.disabled = !(quantity && price && description);
        }

        function confirmService(serviceId, categoryId) {
            const serviceCard = document.getElementById(`service-details-${serviceId}`);
            const quantityInput = serviceCard.querySelector(`input[name="services[${serviceId}][quantity]"]`);
            const priceInput = serviceCard.querySelector(`input[name="services[${serviceId}][price]"]`);
            const descriptionInput = serviceCard.querySelector(`input[name="services[${serviceId}][description]"]`);
            const confirmButton = document.getElementById(`confirmButton-${serviceId}`);

            if (quantityInput.value && priceInput.value && descriptionInput.value) {
                confirmedServices[serviceId] = {
                    categoryId,
                    quantity: quantityInput.value,
                    price: priceInput.value,
                    description: descriptionInput.value,
                    isConfirmed: true
                };

                delete selectedServices[serviceId];

                serviceCard.classList.add('service-disabled');
                serviceCard.classList.remove('service-enabled');
                const checkbox = serviceCard.querySelector('input[type="checkbox"]');
                if (checkbox) checkbox.disabled = true;

                confirmButton.disabled = true;

                updateServicePreview();
            } else {
                alert('Por favor, completa todos los campos del servicio.');
            }
        }

        function eliminarServicio(serviceId) {
            delete confirmedServices[serviceId];
            updateServicePreview();

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

            const confirmButton = serviceCard.querySelector(`#confirmButton-${serviceId}`);
            if (confirmButton) {
                confirmButton.style.display = 'none';
                confirmButton.disabled = true;
            }

            const quantityInput = serviceCard.querySelector(`input[name="services[${serviceId}][quantity]"]`);
            if (quantityInput) {
                quantityInput.style.display = 'none';
                quantityInput.value = '';
            }

            const priceInput = serviceCard.querySelector(`input[name="services[${serviceId}][price]"]`);
            if (priceInput) {
                priceInput.style.display = 'none';
                priceInput.value = '';
            }

            const descriptionInput = serviceCard.querySelector(`input[name="services[${serviceId}][description]"]`);
            if (descriptionInput) {
                descriptionInput.style.display = 'none';
                descriptionInput.value = '';
            }

            const confirmDeleteModal = bootstrap.Modal.getInstance(document.getElementById('confirmDeleteModal'));
            confirmDeleteModal.hide();
        }

        function confirmarEliminacionServicio(serviceId) {
            const modalHtml = `
                <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="confirmDeleteModalLabel">Confirmar Eliminación</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
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

        function updateServicePreview() {
            const serviciosLista = document.getElementById('servicios-lista');
            serviciosLista.innerHTML = '';

            for (let serviceId in confirmedServices) {
                const service = confirmedServices[serviceId];
                const serviceName = document.querySelector(`input[value="${serviceId}"]`).closest('.service-card').querySelector('.card-title').innerText;
                serviciosLista.innerHTML += `
                    <p>
                        <strong>Servicio:</strong> ${serviceName} (Cant. ${service.quantity}, $${service.price}, ${service.description})
                        <button class="btn btn-danger btn-sm" onclick="confirmarEliminacionServicio('${serviceId}')">Eliminar</button>
                    </p>
                `;
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
            const serviceCard = checkbox.closest('.service-card');
            const serviceName = serviceCard.querySelector('.card-title').innerText;

            const serviceQuantityInput = serviceCard.querySelector(`input[name="services[${selectedServiceId}][quantity]"]`);
            const servicePriceInput = serviceCard.querySelector(`input[name="services[${selectedServiceId}][price]"]`);
            const serviceDescriptionInput = serviceCard.querySelector(`input[name="services[${selectedServiceId}][description]"]`);

            if (isSelected) {
                const detailsContainer = document.getElementById(`service-details-${selectedServiceId}`);
                if (detailsContainer) {
                    detailsContainer.style.display = 'block';
                }

                if (serviceQuantityInput.value && servicePriceInput.value && serviceDescriptionInput.value) {
                    selectedServices[selectedServiceId] = {
                        categoryId,
                        serviceName,
                        quantity: serviceQuantityInput.value,
                        price: servicePriceInput.value,
                        description: serviceDescriptionInput.value
                    };
                }
            } else {
                delete selectedServices[selectedServiceId];
                delete confirmedServices[selectedServiceId];

                updateServicePreview();

                const detailsContainer = document.getElementById(`service-details-${selectedServiceId}`);
                if (detailsContainer) {
                    detailsContainer.style.display = 'none';
                }
            }
            updateServicePreview();
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

        function updateServicePreview() {
            const serviciosLista = document.getElementById('servicios-lista');
            serviciosLista.innerHTML = '';

            for (let serviceId in confirmedServices) {
                const service = confirmedServices[serviceId];
                const serviceName = document.querySelector(`input[value="${serviceId}"]`).closest('.service-card').querySelector('.card-title').innerText;
                serviciosLista.innerHTML += `<p><strong>Servicio:</strong> ${serviceName} (Cant. ${service.quantity}, $${service.price}, ${service.description})</p>`;
            }
        }       


        function checkIfAllServicesConfirmed() {
            return Object.values(confirmedServices).every(service => service.isConfirmed);
        }

        function toggleCreatePackageButton() {
            const createButton = document.getElementById('crearPaqueteButton');
        createButton.disabled = !checkIfAllServicesConfirmed();
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
            const form = document.getElementById('paqueteForm');

            document.querySelectorAll('.service-hidden-input').forEach(input => input.remove());

            for (let serviceId in confirmedServices) {
                const service = confirmedServices[serviceId];

                if (service.isConfirmed && service.quantity && service.price && service.description) {
                    const serviceQuantityInput = document.createElement('input');
                    serviceQuantityInput.type = 'hidden';
                    serviceQuantityInput.name = `services[${serviceId}][quantity]`;
                    serviceQuantityInput.value = service.quantity;
                    form.appendChild(serviceQuantityInput);

                    const servicePriceInput = document.createElement('input');
                    servicePriceInput.type = 'hidden';
                    servicePriceInput.name = `services[${serviceId}][price]`;
                    servicePriceInput.value = service.price;
                    form.appendChild(servicePriceInput);

                    const serviceDescriptionInput = document.createElement('input');
                    serviceDescriptionInput.type = 'hidden';
                    serviceDescriptionInput.name = `services[${serviceId}][description]`;
                    serviceDescriptionInput.value = service.description;
                    form.appendChild(serviceDescriptionInput);

                    const serviceIdInput = document.createElement('input');
                    serviceIdInput.type = 'hidden';
                    serviceIdInput.name = `services[${serviceId}][id]`;
                    serviceIdInput.value = serviceId;
                    form.appendChild(serviceIdInput);
                }
            }
            console.log(new FormData(form));
            form.submit();
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
