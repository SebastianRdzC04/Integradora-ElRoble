<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>El Roble - Crear Paquete</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/stylescotizacionesclientes.css') }}">
    <style>
        .container { max-width: 80%; }
        .category-card { 
            cursor: pointer; 
            transition: transform 0.2s; 
            background-color: #D2B48C; 
            color: white; 
        }
        .category-card:hover { transform: scale(1.05); }
        #crearPaquete {
            background-color: rgba(34, 52, 34, 0.8);
            padding: 20px;
            border-radius: 8px;
            color: white;
            margin-top: 20px;
            margin-bottom: 20px;
        }
        #previstaServicio {
            display: flex;
            flex-direction: column;
            align-items: center;
            background-color: rgba(34, 52, 34, 0.8);
            padding: 20px;
            border-radius: 8px;
            color: #FFD700;
            position: fixed; 
            right: 20px; 
            top: 50%; 
            transform: translateY(-50%); 
            z-index: 1000; 
            transition: top 0.5s ease; 
        }
        .prevista-imagen-container {
            position: relative;
            width: 80%;
            max-width: 320px;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 20px;
        }
        .prevista-imagen {
            width: 100%;
            border-radius: 3%;
            max-height: 250px;
            object-fit: cover;
        }
        .prevista-caption {
            position: absolute;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            width: 85%;
            height: 80%;
            background-color: rgba(0, 0, 0, 0.5);
            border-radius: 5px;
            color: white;
            text-align: center;
        }
        .service-details {
            border: 2px solid yellow; 
            border-radius: 8px;
            padding: 10px;
            margin-top: 10px; 
        }
        .service-item {
            margin-bottom: 15px; 
        }
        .text-danger {
            font-size: 0.875em; 
        }
        .invalid-feedback {
            display: block;
            background-color: rgba(255, 0, 0, 0.3);
            border: 1px solid red;
            border-radius: 5px;
            padding: 10px;
            margin-top: 5px;
            color: rgb(218, 189, 189);
            font-weight: bold;
            transition: opacity 0.3s, transform 0.3s;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-6" id="crearPaquete">
                <h3>Crear Nuevo Paquete</h3>
                <form action="{{ route('paquetes.store') }}" method="POST" id="paqueteForm">
                    @csrf
                    <div class="mb-3">
                        <label for="place_id" class="form-label">Lugar</label>
                        <select name="place_id" id="place_id" class="form-control" required>
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
                        <input type="text" name="name" id="name" class="form-control" maxlength="50" required value="{{ old('name') }}">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Descripción</label>
                        <input type="text" name="description" id="description" class="form-control" maxlength="255" required value="{{ old('description') }}">
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="max_people" class="form-label">Máximo de Personas</label>
                        <input type="number" name="max_people" id="max_people" class="form-control" required value="{{ old('max_people') }}">
                        @error('max_people')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">Precio del Paquete</label>
                        <input type="number" name="price" id="price" class="form-control" required value="{{ old('price') }}">
                        @error('price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <h4 class="mt-4">Categorías de Servicios</h4>
                    <div class="row">
                        @foreach($categories as $category)
                        <div class="col-md-4 mb-3">
                            <div class="card category-card" onclick="toggleServices('{{ $category->id }}')">
                                <div class="card-body text-center">
                                    <h5 class="card-title">{{ $category->name }}</h5>
                                </div>
                            </div>
                        </div>
                        <div id="services-{{ $category->id }}" class="service-item mt-2 ms-4" style="display: none;">
                            <ul class="list-group list-group-flush">
                                @foreach($category->services as $service)
                                <li class="list-group-item service-details">
                                    <div class="form-check">
                                        <input type="checkbox" name="services[{{ $service->id }}][id]" value="{{ $service->id }}" class="form-check-input">
                                        <label class="form-check-label">{{ $service->name }} - ${{ $service->price }}</label>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-md-3">
                                            <input type="number" name="services[{{ $service->id }}][quantity]" placeholder="Cantidad" class="form-control">
                                        </div>
                                        <div class="col-md-3">
                                            <input type="number" name="services[{{ $service->id }}][price]" placeholder="Precio" class="form-control">
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" name="services[{{ $service->id }}][description]" placeholder="Descripción" class="form-control">
                                        </div>
                                        <div class="col-md-12 mt-2">
                                            <textarea name="services[{{ $service->id }}][details_dj]" placeholder="Detalles adicionales" class="form-control"></textarea>
                                        </div>
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                        @endforeach
                    </div>
                </form>
            </div>
            <div class="col-md-5 d-flex justify-content-center align-items-center" id="previstaServicio">
                <h2>Prevista del Paquete</h2>
                <div id="category-label" style="display: none;">Categoría</div>
                <div class="prevista-imagen-container">
                    <img src="{{ asset('images/imagen1.jpg') }}" alt="Imagen de Vista Previa" class="prevista-imagen">
                    <div class="prevista-caption">
                        <h4 id="previewTitle">Nombre del Paquete</h4>
                        <p id="previewDescription">Descripción del paquete.</p>
                        <p id="previewPrice">$0.00</p>
                    </div>
                </div>
                <button type="button" class="btn btn-warning" id="crearPaqueteBtn">Crear Paquete</button>
            </div>
        </div>
    </div>

    <script>
        function toggleServices(categoryId) {
            const serviceList = document.getElementById(`services-${categoryId}`);
            serviceList.style.display = serviceList.style.display === 'none' ? 'block' : 'none';
        }

        function updatePreview() {
            const name = document.getElementById('name').value;
            const description = document.getElementById('description').value;
            const price = document.getElementById('price').value;

            document.getElementById('previewTitle').innerText = name || "Nombre del Paquete";
            document.getElementById('previewDescription').innerText = description || "Descripción del paquete.";
            document.getElementById('previewPrice').innerText = price ? `$${parseFloat(price).toFixed(2)}` : "$0.00";
        }

        document.getElementById('paqueteForm').addEventListener('input', updatePreview);
        
        window.addEventListener('scroll', function() {
            const vistaPrevia = document.getElementById('previstaServicio');
            const offset = window.scrollY + (window.innerHeight / 2) - (vistaPrevia.offsetHeight / 2);
            const upperLimit = window.innerHeight * 0.4;
            const lowerLimit = window.innerHeight * 0.6;
            vistaPrevia.style.top = `${Math.min(lowerLimit, Math.max(upperLimit, offset))}px`;
        });

        document.getElementById('crearPaqueteBtn').addEventListener('click', function() {
            document.getElementById('paqueteForm').submit();
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
