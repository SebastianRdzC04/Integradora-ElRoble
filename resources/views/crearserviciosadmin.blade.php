<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Servicio - El Roble</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/stylescotizacionesclientes.css') }}">
    <style>
        .container {
            max-width: 80%;
            margin-bottom: 20px;
        }
        #crearServicio {
            background-color: rgba(34, 52, 34, 0.8);
            padding: 20px;
            border-radius: 8px;
            color: white;
        }
        #previstaServicio {
            display: flex;
            flex-direction: column;
            align-items: center;
            background-color: rgba(34, 52, 34, 0.8);
            padding: 20px;
            border-radius: 8px;
            color: #FFD700;
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
        #category-label {
            display: inline-block;
            background-color: #FFD700;
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
        }
    </style>
</head>
<body>

    <div class="container mt-4">
        <div class="row">
            <!-- Mensaje de éxito -->
            @if(session('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @endif
    
            <!-- Formulario de Creación de Servicio -->
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
                        <input type="number" id="estimatedPrice" name="price_estimate" class="form-control @error('price_estimate') is-invalid @enderror" placeholder="Ej. $500 - $1000">
                        @error('price_estimate')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
    
                    <div class="mb-3">
                        <label for="imageUpload" class="form-label">Subir Imagen del Servicio</label>
                        <input type="file" id="imageUpload" name="image" class="form-control" accept="image/*">
                    </div>
    
                    <!-- Botón de Crear Servicio -->
                    <button type="submit" class="btn btn-warning mt-3" form="formCrearServicio">Crear Servicio</button>
                </form>
            </div>
    
            <!-- Prevista de Servicio -->
            <div class="col-md-6 d-flex justify-content-center align-items-center" id="previstaServicio">
                <h2>Prevista del Servicio</h2>
                <div id="category-label" style="display: none;">Categoría</div>
                <div class="prevista-imagen-container">
                    <img src="/images/imagen6.jpg" id="previstaImagen" class="prevista-imagen" alt="Vista Previa">
                    <div class="prevista-caption">
                        <h5 id="previewTitle">Nombre del Servicio</h5>
                        <p id="previewDescription">Descripción del servicio.</p>
                        <p id="previewPrice">Precio Estimado</p>
                    </div>
                </div>
            </div>
        </div>
    </div>    

<script>
    const categorySelect = document.getElementById('category');
    const newCategoryInput = document.getElementById('newCategory');
    const categoryLabel = document.getElementById('category-label');

    categorySelect.addEventListener('change', function() {
        if (this.value === 'Otro') {
            newCategoryInput.style.display = 'block';
        } else {
            newCategoryInput.style.display = 'none';
            categoryLabel.style.display = 'inline-block';
            categoryLabel.innerText = this.options[this.selectedIndex].text;
        }
    });

    // Actualiza la vista previa con los datos del formulario
    function actualizarPrevista() {
        document.getElementById("previewTitle").innerText = document.getElementById("serviceName").value || "Nombre del Servicio";
        document.getElementById("previewDescription").innerText = document.getElementById("description").value || "Descripción del servicio.";
        document.getElementById("previewPrice").innerText = "Precio Estimado: " + (document.getElementById("estimatedPrice").value || "Precio");
    }

    // Actualiza la imagen de vista previa si se agrega una nueva
    function actualizarImagen() {
        // Aquí puedes agregar funcionalidad para actualizar la imagen
    }

    // Espera que el DOM esté cargado para ejecutar el script
    document.addEventListener('DOMContentLoaded', function () {
        // Verifica si hay un mensaje de éxito en la sesión
        @if(session('success'))
            // Muestra el modal de éxito
            var myModal = new bootstrap.Modal(document.getElementById('successModal'));
            myModal.show();
        @endif
    });
</script>

</body>
</html>
