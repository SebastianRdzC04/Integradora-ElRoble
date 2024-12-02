<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Agregar Nuevo Inventario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <style>
        input[type="number"]::-webkit-inner-spin-button,
input[type="number"]::-webkit-outer-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

/* Para Firefox */
input[type="number"] {
    -moz-appearance: textfield;
}
    </style>
</head>
<body>
<div class="container mt-4 d-flex justify-content-center">
    <div class="card" style="width: 40rem; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);">
        <div class="card-body">
            <h2 class="card-title text-center mb-4">Agregar Inventario Nuevo</h2>
            
            <!-- Selección de Categorías -->
            <h6>Seleccione Categorías:</h6>
            <button type="button" id="btnAbrirModalFormulario" class="btn btn-primary mb-3">Crear Categoría</button>
            
            <div class="d-grid gap-2 overflow-auto" style="max-height: 124px;">
                @foreach ($serials as $serial)
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="categories[]" value="{{$serial->name}}" id="checkbox{{$serial->id}}">
                    <label class="form-check-label" for="checkbox{{$serial->id}}">{{$serial->name}}</label>
                </div>
                @endforeach
            </div>
            
            <div class="mt-3 text-center">
                <button type="button" id="btnAbrirModalInventario" class="btn btn-success">Agregar Inventario</button>
            </div>
        </div>
    </div>
</div>


<!-- Modal para crear categorias y asignar un numero alfanumerio -->
<div class="modal fade" id="modalFormularioInventario" tabindex="-1" aria-labelledby="modalFormularioInventarioLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="min-width: 80%;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalFormularioInventarioLabel">Rellenar Información del Inventario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body row justify-content-between">
                <div class="row col-md-4">
                    <!-- Columna izquierda -->
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="serialListBox" class="form-label">Serie</label>
                            <div class="col-auto">
                                <input type="text" id="inputCategoriaNueva" class="form-control col-md-8" minlength="3" placeholder="Sillas" required disabled>
                            </div>
                        </div>
                        <div class="row">
                            <div class="d-flex">
                                <button id="btnCancelarFormulario" class="btn btn-primary me-2">Cancelar</button>
                                <button id="btnCrearInventario" class="btn btn-primary w-100" disabled>Crear</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Columna derecha -->
                <div class="col-md-7">
                    <div class="row mb-2">
                        <div class="col-6 d-flex">
                            <div class="fs-6 d-grid" style="align-content: center;">
                                Agregar Serie
                            </div>
                        </div>
                        <div class="col-6 d-flex justify-content-end">
                            <button class="btn btnEliminarSerie me-2" id="btnDeleteSerial">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                    <path fill="none" stroke="black" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                            <button id="btnAgregarSerie" class="btn align-baseline">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                    <path fill="none" stroke="black" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v14m-7-7h14"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div id="seriesContainer" class="overflow-y-auto overflow-x-hidden" style="max-height: 130px;">
                        <!-- Fila inicial de inputs -->
                        <div class="row mb-2">
                            <div class="col-4">
                                <input type="text" class="form-control inputSerie" minlength="3" placeholder="CG" required>
                            </div>
                            <div class="col-8">
                                <input type="text" class="form-control inputNombreSerie" minlength="3" placeholder="Carro con Globos" required>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Modal Agregar Inventario -->
<div class="modal fade" id="formModal" tabindex="-1" aria-labelledby="formModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="max-width: 600px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="formModalLabel">Agregar Inventario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <!-- Columna Izquierda -->
                    <div class="col-md-5">
                        <div class="mb-3">
                            <label for="serialListBox" class="form-label">Serial</label>
                            <div class="row">
                                <div class="col-6">
                                    <select id="serialListBox" class="form-select mb-3" style="max-height: 200px; overflow-y: auto;">
                                        <!-- Datos a rellenar dinámicamente -->
                                    </select>
                                </div>
                                <div class="col-6">
                                    <div class="input-group">
                                        <span class="input-group-text p-0" id="basic-addon1">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-currency-dollar" viewBox="0 0 16 16">
                                                <path d="M4 10.781c.148 1.667 1.513 2.85 3.591 3.003V15h1.043v-1.216c2.27-.179 3.678-1.438 3.678-3.3 0-1.59-.947-2.51-2.956-3.028l-.722-.187V3.467c1.122.11 1.879.714 2.07 1.616h1.47c-.166-1.6-1.54-2.748-3.54-2.875V1H7.591v1.233c-1.939.23-3.27 1.472-3.27 3.156 0 1.454.966 2.483 2.661 2.917l.61.162v4.031c-1.149-.17-1.94-.8-2.131-1.718zm3.391-3.836c-1.043-.263-1.6-.825-1.6-1.616 0-.944.704-1.641 1.8-1.828v3.495l-.2-.05zm1.591 1.872c1.287.323 1.852.859 1.852 1.769 0 1.097-.826 1.828-2.2 1.939V8.73z"></path>
                                            </svg>
                                        </span>
                                        <input type="number" name="price" id="price" class="form-control" placeholder="10" aria-label="Input group example" aria-describedby="basic-addon1" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6 col-md-5" id="spanNumber" style="display:none;">
                                    <div class="fs-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30"><path fill="none" stroke="black" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 17V7l7 10V7m4 10h5m-5-7a2.5 3 0 1 0 5 0a2.5 3 0 1 0-5 0"/></svg>
                                        <span id="lastNumber"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <textarea id="description" class="form-control mb-3" maxlength="100" placeholder="Silla chica de color rojo" disabled></textarea>
                            <div class="row">
                                <div class="col-6">
                                    <button id="addItemButton" class="btn btn-primary w-100 mb-2">Añadir</button>
                                </div>
                                <div class="col-6">
                                    <button id="updateInventory" class="btn btn-warning w-100" disabled>Confirmar</button>
                                </div>
                            </div>
                    </div>
                    <!-- Columna Derecha -->
                    <div class="col-md-7">
                        <h6>Inventario Agregado</h6>
                        <ul id="serialList" class="list-group overflow-auto" style="max-height: 250px; word-wrap: break-word;">

                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Abrir el modal de Crear Categoría
    document.getElementById('btnAbrirModalFormulario').addEventListener('click', function () {
        const modalFormularioInventario = new bootstrap.Modal(document.getElementById('modalFormularioInventario'));
        modalFormularioInventario.show();
    });

    // Abrir el modal de Agregar Inventario
    document.getElementById('btnAbrirModalInventario').addEventListener('click', function () {
        const formModal = new bootstrap.Modal(document.getElementById('formModal'));
        formModal.show();
    });

    // Controlar dinámicamente filas en el modal de Crear Categoría
    document.addEventListener('DOMContentLoaded', function () {
        const seriesContainer = document.getElementById('seriesContainer');
        const btnAgregarSerie = document.getElementById('btnAgregarSerie');
        const btnDeleteSerial = document.getElementById('btnDeleteSerial');
        const btnCrearInventario = document.getElementById('btnCrearInventario');

        btnAgregarSerie.addEventListener('click', function () {
            if (seriesContainer.children.length < 10) {
                const newRow = document.createElement('div');
                newRow.classList.add('row', 'mb-2');
                newRow.innerHTML = `
                    <div class="col-4">
                        <input type="text" class="form-control inputSerie" minlength="3" placeholder="CG" required>
                    </div>
                    <div class="col-8">
                        <input type="text" class="form-control inputNombreSerie" minlength="3" placeholder="Carro con Globos" required>
                    </div>
                `;
                seriesContainer.appendChild(newRow);
                checkFormValidation();
            }
        });

        btnDeleteSerial.addEventListener('click', function () {
            if (seriesContainer.children.length > 1) {
                seriesContainer.lastElementChild.remove();
                checkFormValidation();
            }
        });

        function checkFormValidation() {
            const inputSeries = document.querySelectorAll('.inputSerie');
            const inputNombres = document.querySelectorAll('.inputNombreSerie');
            let valid = true;

            inputSeries.forEach(input => {
                if (!input.value) valid = false;
            });
            inputNombres.forEach(input => {
                if (!input.value) valid = false;
            });

            btnCrearInventario.disabled = !valid;
        }

        checkFormValidation();
    });
</script>

<!--script para rellenar el select de seriales-->

<script>
    // Estructuras globales
    const serialMap = {}; // Mapea los códigos y su próximo número
    const usedSerialNumbers = {}; // Rastrea los números usados por cada código
    const inventoryData = []; // Almacena los datos de inventario en formato JSON

    // Evento al abrir el modal de inventario
    document.getElementById('btnAbrirModalInventario').addEventListener('click', function () {
        const selectedCategories = $("input[name='categories[]']:checked")
            .map(function () {
                return $(this).val().toUpperCase();
            }).get();

        if (selectedCategories.length === 0) {
            toastr.error('Selecciona al menos un elemento de la lista');
            return;
        }

        $.ajax({
            url: "{{Route('filtertest')}}",
            type: "GET",
            data: {
                categories: selectedCategories.join(","),
            },
            dataType: "json",
            success: function (response) {
                console.log("Respuesta del servidor: ", response);
                // Limpia el select y las estructuras globales
                $("#serialListBox").html('<option value="">Seleccione un Serial</option>');
                Object.keys(serialMap).forEach(key => delete serialMap[key]);
                Object.keys(usedSerialNumbers).forEach(key => delete usedSerialNumbers[key]);

                // Llena el select y actualiza el mapa asociativo
                $.each(response, function (index, serial) {
                    $("#serialListBox").append(
                        `<option value="${serial.id}">${serial.code} - ${serial.name}</option>`
                    );

                    serialMap[serial.id] = serial.next_number; // Almacena el próximo número
                    usedSerialNumbers[serial.id] = []; // Inicializa números usados
                });

                // Cambiar de modal
                bootstrap.Modal.getInstance(document.getElementById('inventoryModal')).hide();
                new bootstrap.Modal(document.getElementById('formModal')).show();
            },
            error: function (xhr, status, error) {
                console.error("Error al obtener los números de serie", error);
                toastr.error("Hubo un error. Intenta nuevamente.");
            },
        });
    });

    // Evento de cambio en el select
document.getElementById('serialListBox').addEventListener('change', function () {
    const selectedId = this.value;  // Ahora capturamos el id
    const numberInfo = document.getElementById('lastNumber');
    const inventoryDescription = document.getElementById('description');
    const priceInput = document.getElementById('price');
    const spandiv = document.getElementById('spanNumber');

    if (selectedId && serialMap[selectedId] !== undefined) {
        let nextNumber = serialMap[selectedId];
        while (usedSerialNumbers[selectedId].includes(nextNumber)) {
            nextNumber++;
        }

        spandiv.style.display = 'block';
        numberInfo.textContent = nextNumber;
        inventoryDescription.disabled = false;
        priceInput.disabled = false;
    } else {
        numberInfo.textContent = "";
        spandiv.style.display = 'none';
        inventoryDescription.disabled = true;
        priceInput.disabled = true;
    }
});

// Evento para añadir un ítem
document.getElementById('addItemButton').addEventListener('click', () => {
    const serialListBox = document.getElementById('serialListBox');
    const description = document.getElementById('description');
    const serialList = document.getElementById('serialList');
    const confirmInventoryButton = document.getElementById('updateInventory');
    const priceInput = document.getElementById('price');
    const spandiv = document.getElementById('spanNumber');

    const serialId = serialListBox.value; // Ahora obtenemos el id
    const descriptionText = description.value.trim();
    const inventoryPrice = parseInt(priceInput.value);

    if (serialId && descriptionText) {
        let nextNumber = serialMap[serialId];
        while (usedSerialNumbers[serialId].includes(nextNumber)) {
            nextNumber++;
        }

        usedSerialNumbers[serialId].push(nextNumber); // Agregar a usados
        serialMap[serialId] = nextNumber + 1; // Actualizar próximo número

        // Obtener el código para mostrar en la lista
        const serialCode = $("option:selected", serialListBox).text().split(" ")[0]; // Extrae el código

        // Agregar el ítem al inventario
        const item = {
            id: serialId,  // Enviar el id al backend
            number: nextNumber,
            description: descriptionText,
            price: inventoryPrice
        };
        inventoryData.push(item); // Guardar en el arreglo JSON

        const listItem = document.createElement('li');
        listItem.classList.add('list-group-item');
        listItem.textContent = `${serialCode}-${nextNumber} $${inventoryPrice}: ${descriptionText}`; // Mostrar el código
        serialList.appendChild(listItem);

        confirmInventoryButton.disabled = false;

        // Limpiar y resetear los campos
        serialListBox.selectedIndex = 0;
        description.value = '';
        spandiv.style.display = 'none';
        description.disabled = true;
        priceInput.disabled = true;
        priceInput.value = '';

        console.log('Ítem añadido:', item);
        toastr.success('Ítem añadido al inventario.');
    } else {
        toastr.error('Por favor, selecciona un serial y completa la descripción.');
    }
});

// Botón de confirmar inventario
document.getElementById('updateInventory').addEventListener('click', () => {
    if (inventoryData.length > 0) {
        // Convertir el inventario en JSON
        const inventoryJson = JSON.stringify({
            items: inventoryData.map(item => ({
                id: item.id,  // Enviar el id en lugar del código
                number: item.number,
                description: item.description,
                price: item.price
            }))
        });
        console.log('Inventario JSON a enviar:', inventoryJson);
        
        // Enviar una solicitud POST con AJAX
        $.ajax({
            url: '{{route('inventoryadd.store')}}',  // Reemplaza esto con la URL de tu controlador
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') // Añade el token CSRF en el encabezado
            },
            contentType: 'application/json',  // Establecer que el tipo de contenido es JSON
            data: inventoryJson,  // El cuerpo de la solicitud es el inventario en formato JSON
            success: function(response) {
                console.log('Respuesta del servidor:', response);
                // Si la respuesta es exitosa
                toastr.success('Inventario confirmado correctamente.');
                resetModalData();
                bootstrap.Modal.getInstance(document.getElementById('formModal')).hide();
            },
            error: function(xhr, status, error) {
                console.error('Error al enviar los datos:', error);
                toastr.error('Hubo un problema al confirmar el inventario. Intenta nuevamente.');
            }
        });
    } else {
        toastr.error('No hay ítems en el inventario para confirmar.');
    }
});


    // Resetea el modal
    function resetModalData() {
        const serialListBox = document.getElementById('serialListBox');
        const description = document.getElementById('description');
        const lastNumber = document.getElementById('lastNumber');
        const serialList = document.getElementById('serialList');
        const priceInput = document.getElementById('price');
        const confirmInventoryButton = document.getElementById('updateInventory');
        const spandiv = document.getElementById('spanNumber');

        if (serialListBox) serialListBox.selectedIndex = 0;
        if (description) {
            description.value = '';
            description.disabled = true;
        }
        if (priceInput) {
            priceInput.value = '';
            priceInput.disabled = true;
        }
        if (lastNumber) lastNumber.textContent = '';
        if (serialList) serialList.innerHTML = '';
        if (confirmInventoryButton) confirmInventoryButton.disabled = true;

        inventoryData.length = 0;
        spandiv.style.display = 'none';
        Object.keys(serialMap).forEach(key => delete serialMap[key]);
        Object.keys(usedSerialNumbers).forEach(key => delete usedSerialNumbers[key]);
    }

    // Evento para limpiar el modal al cerrarlo
    document.addEventListener('DOMContentLoaded', function () {
        const formModal = document.getElementById('formModal');
        if (formModal) {
            formModal.addEventListener('hidden.bs.modal', resetModalData);
        }
    });
</script>



</body>
</html>
