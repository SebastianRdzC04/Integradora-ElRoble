<!-- resources/views/crearserviciosadmin.blade.php -->
@extends('layouts.appaxel')

@section('title', 'Crear Servicio - El Roble')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/stylescotizacionesclientes.css') }}">
    <style>
        .container {
            max-width: 80%;
            margin-bottom: 20px;
        }
        #crearServicio {
            background-color: rgba(18, 58, 18, 0.76);
            padding: 20px;
            border-radius: 8px;
            color: white;
            margin: 5px;
            border: 2px solid rgb(255, 255, 255);
        }
        #previstaServicio {
            display: flex;
            flex-direction: column;
            align-items: center;
            background-color: rgba(18, 58, 18, 0.76);
            padding: 20px;
            margin: 5px;
            border-radius: 8px;
            color: #ffffff;
            border: 2px solid rgb(255, 255, 255);
        }
        .prevista-imagen-container {
            position: relative;
            width: 80%;
            max-width: 320px;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 20px;
            border-radius: 3%;
            border: 2px solid rgb(255, 255, 255);
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
        #category-label {
            display: inline-block;
            background-color: #ffffff;
            color: black;
            border-radius: 20px;
            padding: 5px 10px;
            margin-bottom: 10px;
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
        .fade-out {
            opacity: 0;
            transform: translateY(-10px);
        }
        #crearPaqueteBoton {
            background-color: #2b1a06; 
            padding: 10px;
            border-radius: 100px;
            color: white;
            margin-top: 20px;
            margin-bottom: 20px;
            border: 1px solid rgba(255, 255, 255, 0.904);
        }
    </style>
@endsection

@section('content')
    <div class="container mt-4">
        <div class="row">
            @if(session('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @endif
    
            <div class="col-md-6" id="crearServicio">
                <h3>Crear Nuevo Servicio</h3>
                <form id="formCrearServicio" action="{{ route('servicios.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
    
                    <div class="mb-3">
                        <label for="category" class="form-label">Categoría de Servicio</label>
                        <select id="category" name="category" class="form-select @error('category') is-invalid @enderror">
                            <option value="">Selecciona una categoría</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->name }}">{{ $category->name }}</option>
                            @endforeach
                            <option value="Otro">Otro</option>
                        </select>
                        @error('category')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        
                        <input type="text" id="newCategory" name="new_category" class="form-control mt-2 @error('new_category') is-invalid @enderror" placeholder="Nueva categoría" style="display: none;">
                        @error('new_category')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
    
                    <div class="mb-3">
                        <label for="serviceName" class="form-label">Nombre</label>
                        <input type="text" id="serviceName" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Ej. Servicio VIP">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
    
                    <div class="mb-3">
                        <label for="description" class="form-label">Descripción</label>
                        <textarea id="description" name="description" class="form-control @error('description') is-invalid @enderror" rows="3" placeholder="Ej. Servicio personalizado"></textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
    
                    <div class="mb-3">
                        <label for="estimatedPrice" class="form-label">Precio Estimado</label>
                        <input type="number" id="estimatedPrice" name="price_estimate" class="form-control @error('price_estimate') is-invalid @enderror" placeholder="Ej. $500 - $1000" min="0" max="99999">
                        @error('price_estimate')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
    
                    <div class="mb-3">
                        <label for="quantity" class="form-label">Cantidad de Personas</label>
                        <input type="number" id="quantity" name="quantity" class="form-control @error('quantity') is-invalid @enderror" placeholder="Ej. 10" min="1" max="500">
                        @error('quantity')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="imageUpload" class="form-label">Subir Imagen del Servicio</label>
                        <input type="file" id="imageUpload" name="image" class="form-control" accept="image/*">
                    </div>

                    <div class="mb-3">
                        <label for="quantifiable" class="form-label">¿Es Cuantificable?</label>
                        <input type="checkbox" id="quantifiable" name="quantifiable" class="form-check-input">
                        <i class="bi bi-info-circle-fill text-white" data-bs-toggle="tooltip" data-bs-placement="right" title="Un servicio cuantificable es aquel al que se le puede pedir una cantidad específica. Por ejemplo, 'Tacos de Canasta' es cuantificable porque puedes pedir una cantidad específica de tacos. En cambio, 'Música en Vivo' no es cuantificable porque no se puede pedir una cantidad específica."></i>
                    </div>
                </form>
            </div>
    
            <div class="col-md-5 d-flex justify-content-center align-items-center" id="previstaServicio">
                <h2>Prevista del Servicio</h2>
                <div id="category-label" style="display: none;">Categoría</div>
                <div class="prevista-imagen-container">
                    <img src="/images/imagen6.jpg" id="previstaImagen" class="prevista-imagen" alt="Vista Previa">
                    <div class="prevista-caption">
                        <h5 id="previewTitle">Nombre del Servicio</h5>
                        <p id="previewDescription">Descripción del servicio.</p>
                        <p id="previewPrice">Precio Estimado</p>
                        <p id="previewQuantity">Cantidad de Personas: <span id="quantityPreview">0</span></p>
                    </div>
                </div>
                <div class="d-flex justify-content-center">
                    <button type="button" class="btn btn-warning mt-3" id="crearPaqueteBoton">Crear Servicio</button>
                </div>
            </div>
        </div>
    </div>    
@endsection

@section('scripts')
    <script>

    showLoader();
    hideLoader();
    
    document.addEventListener('DOMContentLoaded', function() {
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });

            const categorySelect = document.getElementById('category');
            const newCategoryInput = document.getElementById('newCategory');
            const categoryLabel = document.getElementById('category-label');
            const quantityInput = document.getElementById('quantity');
            const quantityPreview = document.getElementById('quantityPreview');
            const formCrearServicio = document.getElementById('formCrearServicio');
            const estimatedPriceInput = document.getElementById('estimatedPrice');
            const serviceNameInput = document.getElementById('serviceName');
            const descriptionInput = document.getElementById('description');
            const imageUploadInput = document.getElementById('imageUpload');
            const previewImage = document.getElementById('previstaImagen');
        
            function removeInvalidClassOnInput(element) {
                element.addEventListener('input', function() {
                    const invalidFeedback = this.nextElementSibling;
                    if (this.value.trim()) {
                        this.classList.remove('is-invalid');
                        if (invalidFeedback && invalidFeedback.classList.contains('invalid-feedback')) {
                            invalidFeedback.style.transition = "opacity 0.5s ease, transform 0.5s ease";
                            invalidFeedback.style.opacity = "0";
                            invalidFeedback.style.transform = "translateY(-10px)";
                            setTimeout(() => invalidFeedback.style.display = "none", 500);
                        }
                    }
                });
            }
        
            [serviceNameInput, descriptionInput, estimatedPriceInput].forEach(removeInvalidClassOnInput);
        
            categorySelect.addEventListener('change', function() {
                if (this.value) {
                    this.classList.remove('is-invalid');
                    const invalidFeedback = this.nextElementSibling;
                    if (invalidFeedback && invalidFeedback.classList.contains('invalid-feedback')) {
                        invalidFeedback.style.transition = "opacity 0.5s ease, transform 0.5s ease";
                        invalidFeedback.style.opacity = "0";
                        invalidFeedback.style.transform = "translateY(-10px)";
                        setTimeout(() => invalidFeedback.style.display = "none", 500);
                    }
                }
                if (this.value === "Otro") {
                    newCategoryInput.style.display = "block";
                } else {
                    newCategoryInput.style.display = "none";
                }
                categoryLabel.style.display = this.value ? "inline-block" : "none";
                categoryLabel.textContent = this.value;
            });
        
            serviceNameInput.addEventListener('input', function() {
                document.getElementById('previewTitle').textContent = this.value || "Nombre del Servicio";
            });
        
            descriptionInput.addEventListener('input', function() {
                document.getElementById('previewDescription').textContent = this.value || "Descripción del servicio.";
            });
        
            estimatedPriceInput.addEventListener('input', function() {
                document.getElementById('previewPrice').textContent = `Precio Estimado: $${this.value || "0"}`;
            });
        
            quantityInput.addEventListener('input', function() {
                quantityPreview.textContent = this.value || "0";
            });
        
            document.getElementById('crearPaqueteBoton').addEventListener('click', function() {
                formCrearServicio.submit();
            });

            imageUploadInput.addEventListener('change', function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewImage.src = e.target.result;
                    }
                    reader.readAsDataURL(file);
                } else {
                    previewImage.src = '/images/imagen6.jpg';
                }
            });
        });
    </script>
@endsection