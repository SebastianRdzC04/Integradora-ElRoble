 // Abrir modal para agregar códigos de serie
 document.getElementById('btnAbrirModalCodigoSerie').addEventListener('click', function () {
    const modalAgregarCodigosDeSerie = new bootstrap.Modal(document.getElementById('modalAgregarCodigosDeSerie'));
    modalAgregarCodigosDeSerie.show();

    // Referencia al select dentro del modal
    const select = document.getElementById('inputCategoriaSerie');
    select.innerHTML = ''; // Limpia opciones previas

    // Rellenar el select con los datos de serials
    serials.forEach((serial) => {
        const option = document.createElement('option');
        option.value = serial.id; // Usa serial.id como valor
        option.textContent = serial.name; // Usa serial.name como texto
        select.appendChild(option);
    });
});

// Limpiar lista de nuevas categorías cuando se selecciona algo en el input
document.getElementById('inputCategoriaNueva').addEventListener('input', function () {
    const newcodeslist = document.getElementById('newcodeslist');
    if (newcodeslist) {
        newcodeslist.innerHTML = ''; // Limpia la lista
    }
});

// Abrir modal de Crear Categoría
document.getElementById('btnAbrirModalFormulario').addEventListener('click', function () {
    const selectedCategories = Array.from(document.querySelectorAll("input[name='categories[]']:checked"))
        .map(input => input.value.toUpperCase());

    if (selectedCategories.length === 0) {
        toastr.error('Selecciona al menos un elemento de la lista');
    } else {
        const modalFormularioInventario = new bootstrap.Modal(document.getElementById('modalCrearCategorias'));
        modalFormularioInventario.show();
    }
});

// Agregar fila de inputs dinámicamente
function addNewSerialRow(containerId) {
    const container = document.getElementById(containerId);
    if (container.children.length < 10) {
        const row = document.createElement('div');
        row.classList.add('row', 'mb-2');
        row.innerHTML = `
            <div class="col-4">
                <input type="text" class="form-control inputSerie" minlength="3" placeholder="CG" required>
            </div>
            <div class="col-8">
                <input type="text" class="form-control inputNombreSerie" minlength="3" placeholder="Carro con Globos" required>
            </div>`;
        container.appendChild(row);
    }
}

// Eliminar última fila de inputs
function deleteLastSerialRow(containerId) {
    const container = document.getElementById(containerId);
    if (container.children.length > 1) {
        container.lastElementChild.remove();
    }
}

// Botones de agregar/eliminar filas en modales
document.getElementById('btnAgregarSerieCodigo').addEventListener('click', () => addNewSerialRow('seriesContainerCodigo'));
document.getElementById('btnEliminarSerieCodigo').addEventListener('click', () => deleteLastSerialRow('seriesContainerCodigo'));

document.getElementById('btnAgregarCategoriaFila').addEventListener('click', () => addNewSerialRow('categoriesContainer'));
document.getElementById('btnEliminarCategoriaFila').addEventListener('click', () => deleteLastSerialRow('categoriesContainer'));

// Validación del formulario antes de habilitar el botón de crear
function checkFormValidation() {
    const inputSeries = document.querySelectorAll('.inputSerie');
    const inputNombres = document.querySelectorAll('.inputNombreSerie');
    const btnCrearInventario = document.getElementById('btnCrearInventario');
    let valid = true;

    inputSeries.forEach(input => {
        if (!input.value.trim()) valid = false;
    });
    inputNombres.forEach(input => {
        if (!input.value.trim()) valid = false;
    });

    btnCrearInventario.disabled = !valid; // Habilitar o deshabilitar botón
}

// Eventos de validación en tiempo real
document.querySelectorAll('.inputSerie, .inputNombreSerie').forEach(input => {
    input.addEventListener('input', checkFormValidation);
});






//modal de agregar inventario --------------------------------------------------------------------------
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

    const modalAddInventory = new bootstrap.Modal(document.getElementById('formModal'));
    modalAddInventory.show();
    
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
