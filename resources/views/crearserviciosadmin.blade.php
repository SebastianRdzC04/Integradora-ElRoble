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
        #crearBoton {
            margin-top: 10px;
        }
    </style>
</head>
<body>

<div class="container mt-4">
    <div class="row">
        <!-- Formulario de Creación de Servicio -->
        <div class="col-md-6" id="crearServicio">
            <h3>Crear Nuevo Servicio</h3>
            <form>
                <div class="mb-3">
                    <label for="category" class="form-label">Categoría de Servicio</label>
                    <select id="category" class="form-select">
                        <option value="Meseros">Meseros</option>
                        <option value="Servicio de Comida">Servicio de Comida</option>
                        <option value="Salas Lounge">Salas Lounge</option>
                        <option value="Otro">Otro</option>
                    </select>
                    <input type="text" id="newCategory" class="form-control mt-2" placeholder="Nueva categoría" style="display: none;" oninput="actualizarCategoria()">
                </div>
                <div class="mb-3">
                    <label for="serviceName" class="form-label">Nombre</label>
                    <input type="text" id="serviceName" class="form-control" placeholder="Ej. Servicio VIP" oninput="actualizarPrevista()">
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Descripción</label>
                    <textarea id="description" class="form-control" rows="3" placeholder="Ej. Servicio personalizado" oninput="actualizarPrevista()"></textarea>
                </div>
                <div class="mb-3">
                    <label for="estimatedPrice" class="form-label">Precio Estimado</label>
                    <input type="text" id="estimatedPrice" class="form-control" placeholder="Ej. $500 - $1000" oninput="actualizarPrevista()">
                </div>
                <div class="mb-3">
                    <label for="imageUpload" class="form-label">Subir Imagen del Servicio</label>
                    <input type="file" id="imageUpload" class="form-control" onchange="actualizarImagen()">
                </div>
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
            <div id="crearBoton">
                <button type="button" class="btn btn-warning">Crear Servicio</button>
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
            actualizarCategoria();
        } else {
            newCategoryInput.style.display = 'none';
            categoryLabel.style.display = 'inline-block';
            categoryLabel.innerText = this.options[this.selectedIndex].text;
        }
    });

    function actualizarCategoria() {
        if (categorySelect.value === 'Otro' && newCategoryInput.value.trim() !== '') {
            categoryLabel.style.display = 'inline-block';
            categoryLabel.innerText = newCategoryInput.value;
        } else {
            categoryLabel.style.display = 'none';
        }
    }

    function actualizarPrevista() {
        document.getElementById("previewTitle").innerText = document.getElementById("serviceName").value || "Nombre del Servicio";
        document.getElementById("previewDescription").innerText = document.getElementById("description").value || "Descripción del servicio.";
        document.getElementById("previewPrice").innerText = "Precio Estimado: " + (document.getElementById("estimatedPrice").value || "Precio");
    }

    function actualizarImagen() {
        // Aquí puedes agregar funcionalidad para actualizar la imagen
    }
</script>

</body>
</html>
