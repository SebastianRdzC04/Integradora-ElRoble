
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Agregar nuevo inventario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

    <style>
        body {
            min-height: 100dvh;
            overflow-x: hidden;
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
    <script>
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": true,
        "progressBar": true,
        "positionClass": "toast-top-right", // Cambia la posición si lo necesitas
        "preventDuplicates": true,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000", // Duración de la notificación
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "slideDown",
        "hideMethod": "fadeOut"
    };
    </script>

</head>
<body>


<!-- Mensaje de éxito -->
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<script>
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                toastr.error("{{ $error }}", "Error", {
                    "closeButton": true,
                    "progressBar": true,
                    "positionClass": "toast-top-center",
                    "timeOut": "5000",
                });
            @endforeach
        @endif
</script>

@if(session('error'))
    <script>
        toastr.error("{{ session('error') }}");
    </script>
@endif


<!-- formulario incidente globlal -->
 
    

<div class="container mt-4">
    <h2>Agregar Inventario Nuevo</h2>
        <div class="modal fade" id="inventoryModal" tabindex="-1" aria-labelledby="inventoryModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="inventoryModalLabel">Inventario Afectado</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h6>Seleccione Categorías Afectadas:</h6>
                    <div class="d-grid gap-2" style="overflow-y: auto; resize: none; height: 124px;">
                        <!-- Cambié los botones por checkboxes para permitir múltiples selecciones -->
                         <!-- Esto se rellana con ajax -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="createCategory" class="btn btn-primary">Crear Categoria</button>
                </div>
                <div class="modal-footer">
                    <button type="button" id="nextModalButton" class="btn btn-primary">Siguiente</button>
                </div>
            </div>
        </div>
    </div>
</div>

    

    <!-- modal 2 -->
    <div class="modal fade" id="formModal" tabindex="-1" aria-labelledby="formModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" style="min-width: 90%;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="formModalLabel">Rellenar Información del Inventario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <!-- izquierda -->
                        <div class="col-md-5">
                            <div class="mb-3">
                                <label for="serialListBox" class="form-label">Serial</label>
                                        <div class="col-6 col-md-8">
                                            <input type="text" id="categorynew" class="form-control col-md-8" minlength="3" placeholder="Sillas" required disabled>
                                        </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <button id="addItemButton" class="btn btn-primary">Cancelar</button>
                                </div>
                                <div class="col">
                                    <button id="updateInventory" class="btn btn-primary" disabled>Crear</button>
                                </div>
                            </div>
                        </div>
                        
                        <!-- derecha -->
                        <div class="col-md-7" style="overflow-y:scroll;">
                            <h6>Agregar Serie</h6>
                                <div class="row">
                                        <div class="col-6 col-md-8">
                                            <input type="text" id="serialNew" class="form-control col-md-8" minlength="3" placeholder="JH" required disabled>
                                        </div>
                                        <div class="col-6 col-md-8">
                                            <input type="text" id="serialname" class="form-control col-md-8" minlength="3" placeholder="Sillas" required disabled>
                                        </div>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>        
    

    <script>
    const fileInput = document.getElementById('images');

    const dropzone = document.getElementById('dropzone');


    const preview = document.getElementById('preview');

    
    dropzone.addEventListener('dragover', (e) => {
        e.preventDefault();
        dropzone.style.backgroundColor = '#f0f0f0';
    });

    dropzone.addEventListener('dragleave', () => {
        dropzone.style.backgroundColor = '#fff';
    });

    dropzone.addEventListener('click', () => {
        fileInput.click();
    });

    fileInput.addEventListener('change', (e) => {
        const files = e.target.files;
        //limpiar imagenes cache
        preview.innerHTML = ''; 

        for (let i = 0; i < files.length; i++) {
            const file = files[i];
            const reader = new FileReader();

            reader.onload = function(event) {
                const image = document.createElement('img');
                image.src = event.target.result;
                image.style.width = '100px';
                image.style.height = '100px';
                image.style.objectFit = 'cover';
                image.style.margin = '5px';
                preview.appendChild(image);
            };

            reader.readAsDataURL(file);
        }
    });

    dropzone.addEventListener('drop', (e) => {
        e.preventDefault();
        dropzone.style.backgroundColor = '#fff';
        const files = e.dataTransfer.files;
        fileInput.files = files; 
        const event = new Event('change');
        fileInput.dispatchEvent(event);
    });
    </script>

    <script>

//utilizare AJAX con JQuery para filtrar, entender su sintaxis y el funcionamiento 

//para el modal 2
const description = document.getElementById('description');
const numberInput = document.getElementById('numberInput');
const selectsn = document.getElementById("serialListBox");
const statusListBox = document.getElementById('statusListBox');
const serialList = document.getElementById('serialList');

// para los button de los modales
const addSerialButton = document.getElementById('addSerialButton');
const nextModalButton = document.getElementById('nextModalButton');
const addItemButton = document.getElementById('addItemButton');
const updateInventoryButton = document.getElementById('updateInventory');

// arreglo que almacena los items
let items = [];

// modal 1 es abierto
addSerialButton.addEventListener('click', () => {
    new bootstrap.Modal(document.getElementById('inventoryModal')).show();
});

// aqui se llena el serial 2 con ajax
nextModalButton.addEventListener('click', function () {
    const selectedCategories = $("input[name='categories[]']:checked")
        .map(function () {
            return $(this).val().toUpperCase();
        }).get();

    if (selectedCategories.length === 0) {
        toastr.error('Selecciona al menos un elemento de la lista');
        return;
    }

    $.ajax({
        url: "{{Route('filterselectedcategories.employee')}}",
        type: "GET",
        data: {
            categories: selectedCategories.join(","),
        },
        dataType: "json",
        success: function (response) {
            $("#serialListBox").html('<option value="">Seleccione un Serial</option>');
            $.each(response, function (index, serial) {
                $("#serialListBox").append(`<option value="${serial.code}">${serial.code}</option>`);
            });
            bootstrap.Modal.getInstance(document.getElementById('inventoryModal')).hide();
            new bootstrap.Modal(document.getElementById('formModal')).show();

        },
        error: function (xhr, status, error) {
            console.error("Error al obtener los números de serie", error);
            toastr.error("Hubo un error. Intenta nuevamente.");
        },
    });
});

//agrega item al array
addItemButton.addEventListener('click', () => {
    const status = statusListBox.value;
    const serial = selectsn.value;
    const number = parseInt(numberInput.value, 10);
    const descriptionText = description.value;

    if (number && descriptionText) {

        // crea el JSON para almacenar en el front
        const item = {
            serial: serial,
            number: number,
            description: descriptionText,
            status: status
        };

        updateInventoryButton.disabled = false;

        // lo metemos al arreglo
        items.push(item);

        // mostramos el item en modal
        const listItem = document.createElement('li');
        listItem.classList.add('list-group-item');
        listItem.textContent = `${serial}-${number}: ${descriptionText} - ${status}`;
        serialList.appendChild(listItem);

        // se reincian los campos
        numberInput.value = '';
        description.value = '';
        selectsn.selectedIndex = 0;
        statusListBox.value = 'disponible';

        // desactivamos campos
        numberInput.disabled = true;
        description.disabled = true;
        statusListBox.disabled = true;
    } else {
        toastr.error('Por favor, completa el número y la descripción.');
    }
});

// para habilitar campos
selectsn.addEventListener('change', () => {
    numberInput.disabled = !selectsn.value;
});

numberInput.addEventListener('input', () => {
    description.disabled = !numberInput.value;
    statusListBox.disabled = !numberInput.value;
});

//solo números sean aceptados, sin - ni +
numberInput.addEventListener('input', (e) => {
    let value = e.target.value;
    value = value.replace(/[-+]/g, '');
    e.target.value = value;
});

// btn de enviar datos al backend para su validacion
updateInventoryButton.addEventListener('click', () => {
    // ver si el item tiene datos
    if (items.length > 0) {
        // lo enviamos dentro de un objeto 
        $.ajax({
            url: "{{ route('saveItems') }}",
            type: "POST",
            contentType: "application/json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: JSON.stringify({ items: items }),
            success: function (response) {
                if (response.success) {
                    $('#formModal').modal('hide'); 
                } else {
                    console.log('Error al actualizar los items. ' + response.error);
                    toastr.error('Error al actualizar los items. Intente nuevamente');
                }
            },
            error: function (xhr, status, error) {
                console.log("verificar", JSON.stringify({ items: items }));
                console.error("Error al enviar los datos", error);
                toastr.error('Hubo un error al intentar actualizar los items.');
            }
        });
    } else {
        toastr.error('No hay items para actualizar.');
    }
});


</script>

<script>
    let categoriesCached = null; 

$('#addSerialButton').on('click', function () {
    if (categoriesCached) {
        populateCategories(categoriesCached); 
        return;
    }

    $.ajax({
        url: "{{route('getCategories')}}", 
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            categoriesCached = data; 
            console.log(data);
            populateCategories(data); 
        },
        error: function (xhr, status, error) {
            console.error('Error al obtener las categorías:', error);
            toastr.error('No se pudieron cargar las categorías. Intenta nuevamente.');
        }
    });
});

function populateCategories(categories) {
    const container = $('.modal-body .d-grid');
    container.empty(); // Limpia el contenido actual.

    categories.forEach(category => {
        const formCheck = `
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="categories[]" value="${category.name}" id="checkbox${category.id}">
                <label class="form-check-label" for="checkbox${category.id}">${category.name}</label>
            </div>
        `;
        container.append(formCheck); // Añade cada categoría.
    });
}

</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>
</html>