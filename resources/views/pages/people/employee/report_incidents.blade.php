<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reportar Incidencia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h2>Reportar Incidencia</h2>
        <form id="incidentForm" enctype="multipart/form-data">
            
            <!-- Título de la incidencia -->
            <div class="form-floating mb-3">
                <input type="text" name="title" id="title" class="form-control" placeholder="Título de la incidencia" maxlength="100">
                <label for="title">Título</label>
            </div>

            <!-- Descripción de la incidencia -->
            <div class="form-floating">
                <textarea name="description" maxlength="100" id="description" class="form-control" placeholder="Descripción de la incidencia" style="height: 100px;" required></textarea>
                <label for="description">Descripción </label>
            </div>

            <!-- Botón para agregar número de serie -->
            
            <div class="d-flex">

                <div class="mb-3">
                    <button type="button" id="addSerialButton" class="btn btn-primary mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                            <path fill="white" d="M19 12.998h-6v6h-2v-6H5v-2h6v-6h2v6h6z"/>
                        </svg>
                    </button>
                </div>
                    

                <div class="mb-3">
                    <button type="button" id="removeSerialButton" class="btn btn-danger mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                            <path fill="none" stroke="white" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7h16m-10 4v6m4-6v6M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2l1-12M9 7V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v3"/>
                        </svg>
                    </button>
                </div>

            </div>

            <div id="serialContainer" class="mb-3"></div>

            <div class="mb-3">
                <label for="images" class="form-label">Subir Imágenes</label>
                <div id="dropzone" class="border p-4 text-center">
                    <p>Arrastra y suelta tus imágenes aquí o haz clic para seleccionar archivos.</p>
                    <input type="file" name="images[]" id="images" class="form-control" multiple accept="image/*" style="display: none;">
                </div>
            </div>

            <!-- Botón para enviar el formulario -->
            <button type="submit" class="btn btn-primary w-100">Enviar Incidencia</button>
        </form>
    </div>

    <!-- Script para manejar el arrastrar y soltar y el límite de números de serie -->
     
    <script>
        const dropzone = document.getElementById('dropzone');
        const fileInput = document.getElementById('images');
        const addSerialButton = document.getElementById('addSerialButton');
        const serialContainer = document.getElementById('serialContainer');
        let serialCount = 0;
        const maxSerials = 15;

        // Manejar arrastrar y soltar
        dropzone.addEventListener('click', () => fileInput.click());
        dropzone.addEventListener('dragover', (event) => {
            event.preventDefault();
            dropzone.classList.add('bg-light');
        });
        dropzone.addEventListener('dragleave', () => dropzone.classList.remove('bg-light'));
        dropzone.addEventListener('drop', (event) => {
            event.preventDefault();
            dropzone.classList.remove('bg-light');
            fileInput.files = event.dataTransfer.files;
        });

        // Añadir número de serie y descripción
        addSerialButton.addEventListener('click', () => {
            if (serialCount < maxSerials) {
                serialCount++;

                const serialGroup = document.createElement('div');
                serialGroup.classList.add('mb-3');

                // Campo para el número de serie
                const serialInput = document.createElement('input');
                serialInput.type = 'text';
                serialInput.name = `serial_${serialCount}`;
                serialInput.classList.add('form-control', 'mb-2');
                serialInput.placeholder = `Número de Serie #${serialCount}`;
                serialInput.maxLength = 10;

                // Campo para la descripción del número de serie
                const serialDescription = document.createElement('textarea');
                serialDescription.name = `description_${serialCount}`;
                serialDescription.classList.add('form-control');
                serialDescription.placeholder = `Descripción para el Número de Serie #${serialCount}`;
                serialDescription.style.height = '60px';

                // Agregar los campos al contenedor
                serialGroup.appendChild(serialInput);
                serialGroup.appendChild(serialDescription);
                serialContainer.appendChild(serialGroup);
            } else {
                alert(`Solo puedes agregar un máximo de ${maxSerials} números de serie.`);
            }
        });



        //el btn de eliminar
        const removeSerialButton = document.getElementById('removeSerialButton');

removeSerialButton.addEventListener('click', () => {
    if (serialCount > 0) {
        // Selecciona el último grupo de campos y lo elimina
        const lastSerialGroup = serialContainer.lastElementChild;
        serialContainer.removeChild(lastSerialGroup);

        // Decrementa el contador
        serialCount--;

        // Muestra un mensaje opcional si se ha eliminado un campo
        console.log(`Número de serie #${serialCount + 1} eliminado.`);
    } else {
        alert("No hay campos para eliminar.");
    }
        });

    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
