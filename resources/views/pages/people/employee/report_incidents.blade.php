<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reportar Incidencia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Estilos personalizados */
        body {
            min-height: 100dvh;
            overflow-x: hidden;
        }

        #sidebar {
            width: 280px;
            max-width: 80%;
            height: 100%;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #343a40;
            color: white;
            z-index: 1050;
            transform: translateX(-100%);
            transition: transform 0.3s ease;
        }

        #sidebar.open {
            transform: translateX(0);
        }

        #closeSidebarBtn {
            position: absolute;
            top: 10px;
            right: 10px;
            color: white;
            font-size: 1.5rem;
            cursor: pointer;
        }

        #openSidebarBtn {
            position: fixed;
            top: 10px;
            left: 10px;
            z-index: 1100;
            background-color: #007bff;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
        }

        @media (max-width: 767px) {
            #dropzone {
                padding: 15px;
            }

            .modal-dialog {
                max-width: 100%;
            }
        }
    </style>
</head>
<body>

<!-- Botón para abrir el menú -->
<button id="openSidebarBtn"></button>

<!-- Menú lateral (sidebar) -->
<div id="sidebar" class="d-flex flex-column p-3">
    <span id="closeSidebarBtn">&times;</span>
    <a href="/" class="d-flex align-items-center mb-3 text-white text-decoration-none">
        <span class="fs-4">Jesus Alberto</span>
    </a>
    <hr>
    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item">
            <a href="#" class="nav-link active text-white">Inicio</a>
        </li>
        <li>
            <a href="#" class="nav-link text-white">Evento</a>
        </li>
        <li>
            <a href="#" class="nav-link text-white">Eventos proximos</a>
        </li>
        <li>
            <a href="#" class="nav-link text-white">Registro de incidencia</a>
        </li>
        <li>
            <a href="#" class="nav-link text-white">Incidencias reportadas</a>
        </li>
    </ul>
</div>

<!-- Contenido principal -->
<div class="container mt-4">
    <h2>Reportar Incidencia</h2>
    <form id="incidentForm">
        <div class="form-floating mb-3">
            <input type="text" id="title" class="form-control" placeholder="Título de la incidencia" maxlength="100">
            <label for="title">Título</label>
        </div>
        <div class="d-flex mb-3">
            <div class="form-floating flex-grow-1 me-2">
                <textarea id="description" class="form-control" placeholder="Descripción" style="height: 100px;"></textarea>
                <label for="description">Descripción</label>
            </div>
            <button type="button" id="addSerialButton" class="btn btn-primary align-self-end">Inventario Afectado</button>
        </div>
        <div class="mb-3">
            <label for="images" class="form-label">Subir Imágenes</label>
            <div id="dropzone" class="border p-4 text-center">
                <p>Arrastra y suelta tus imágenes aquí o haz clic para seleccionar archivos.</p>
                <input type="file" id="images" class="form-control" multiple accept="image/*" style="display: none;">
            </div>
        </div>
    </form>
</div>

    <!-- Modal 1: Selección de Inventario Afectado -->
    <div class="modal fade" id="inventoryModal" tabindex="-1" aria-labelledby="inventoryModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="inventoryModalLabel">Inventario Afectado</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h6>Seleccione Categorías Afectadas:</h6>
                    <div class="d-grid gap-2">
                        <!-- Cambié los botones por checkboxes para permitir múltiples selecciones -->
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="categories[]" value="Sillas" id="checkboxSillas">
                            <label class="form-check-label" for="checkboxSillas">Sillas</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="categories[]" value="Mesas" id="checkboxMesas">
                            <label class="form-check-label" for="checkboxMesas">Mesas</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="categories[]" value="Hieleras" id="checkboxHieleras">
                            <label class="form-check-label" for="checkboxHieleras">Hieleras</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="nextModalButton" class="btn btn-primary">Siguiente</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal 2: Formulario y Tabla de Números de Serie -->
    <div class="modal fade" id="formModal" tabindex="-1" aria-labelledby="formModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="formModalLabel">Rellenar Información del Inventario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <!-- Columna Izquierda: Formulario -->
                        <div class="col-md-6">
                        <div class="mb-3">
    <label for="serialListBox" class="form-label">Serial</label>
    <select id="serialListBox" class="form-select" style="max-height: 200px; overflow-y: auto; width: 100%;">
        
    </select>
</div>
                            <div class="mb-3">
                                <input type="text" id="serialInput" class="form-control" placeholder="Descripción del Serial" disabled>
                            </div>
                            <div class="mb-3">
                                <select id="statusListBox" class="form-select" style="max-height: 50%; overflow-y: auto">
                                    <option value="disponible">Disponible</option>
                                    <option value="no_disponible">No Disponible</option>
                                </select>
                            </div>
                            <button id="addItemButton" class="btn btn-primary">Agregar</button>
                        </div>

                        <!-- Columna Derecha: Tabla de Números de Serie -->
                        <div class="col-md-6">
                            <h6>Números de Serie Ingresados</h6>
                            <ul id="serialList" class="list-group"></ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>

    //estos jason son para filtrar los valores que saldran en el listbox del segundo modal
    // Datos que vienen desde el backend
    const serialNumbers = @json($sn);
    const categories = @json($categories);

    // Función para obtener las categorías seleccionadas
    function getSelectedCategories() {
        const checkboxes = document.querySelectorAll('input[name="categories[]"]:checked');
        const selectedCategories = Array.from(checkboxes).map(checkbox => checkbox.value);
        console.log('Selected Categories:', selectedCategories);
        return selectedCategories;
    }

    // Evento al presionar el botón "Siguiente"
    document.getElementById('nextModalButton').addEventListener('click', () => {
        const selectedCategories = getSelectedCategories();

        // Filtrar los seriales según las categorías seleccionadas
        const filteredSerials = serialNumbers.filter(serial =>
            selectedCategories.includes(
                categories.find(cat => cat.id === serial.category_id)?.name
            )
        );

        // Llenar el ListBox con los seriales filtrados
        const serialListBox = document.getElementById('serialListBox');
        serialListBox.innerHTML = '<option value="">Seleccione un Serial</option>'; // Resetear opciones

        filteredSerials.forEach(serial => {
            const option = document.createElement('option');
            option.value = serial.code;
            option.text = serial.code;
            serialListBox.appendChild(option);
        });

        // Mostrar el siguiente modal
        const formModal = new bootstrap.Modal(document.getElementById('formModal'));
        formModal.show();
    });
    
    //esto es para la animacion del side bar -------------------------------------------------------------
    const sidebar = document.getElementById('sidebar');
    const openSidebarBtn = document.getElementById('openSidebarBtn');
    const closeSidebarBtn = document.getElementById('closeSidebarBtn');

    openSidebarBtn.addEventListener('click', () => {
        sidebar.classList.add('open');
    });

    closeSidebarBtn.addEventListener('click', () => {
        sidebar.classList.remove('open');
    });


        // Abrir primer modal
        document.getElementById('addSerialButton').addEventListener('click', () => {
            new bootstrap.Modal(document.getElementById('inventoryModal')).show();
        });

        // Pasar al segundo modal
        document.getElementById('nextModalButton').addEventListener('click', () => {
            bootstrap.Modal.getInstance(document.getElementById('inventoryModal')).hide();
            new bootstrap.Modal(document.getElementById('formModal')).show();
        });

        // Manejar el formulario del segundo modal
        document.getElementById('addItemButton').addEventListener('click', () => {
            const serialInput = document.getElementById('serialInput').value;
            const status = document.getElementById('statusListBox').value;

            if (serialInput) {
                const listItem = document.createElement('li');
                listItem.classList.add('list-group-item');
                listItem.textContent = `${serialInput} - ${status}`;
                document.getElementById('serialList').appendChild(listItem);

                // Limpiar campos
                document.getElementById('serialInput').value = '';
                document.getElementById('statusListBox').value = 'disponible';
            }
        });

        // Habilitar campo de texto cuando se selecciona un serial
        document.getElementById('serialListBox').addEventListener('change', (e) => {
            const serialInput = document.getElementById('serialInput');
            serialInput.disabled = !e.target.value;
        });

        // Mostrar el dropzone cuando se hace clic en el área
        document.getElementById('dropzone').addEventListener('click', () => {
            document.getElementById('images').click();
        });

        // Seleccionar archivo desde el input file
        document.getElementById('images').addEventListener('change', (e) => {
            const files = e.target.files;
            const fileList = document.getElementById('dropzone');
            fileList.innerHTML = `<p>Archivos seleccionados:</p>`;
            for (let file of files) {
                fileList.innerHTML += `<p>${file.name}</p>`;
            }
        });
    </script>
</body>
</html>
