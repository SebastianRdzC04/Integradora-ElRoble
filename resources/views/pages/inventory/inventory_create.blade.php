@extends('layouts.dashboardAdmin')
    @section('meta')
        
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @endsection
    @section('title')
    Agregar Nuevo Inventario
    @endsection
    @section('styles')
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
    @endsection
@section('content')
    

<div class="container mt-4 d-flex justify-content-center">
    <div class="card" style="width: 40rem; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);">
        <div class="card-body">
            <h2 class="card-title text-center mb-4">Agregar Inventario Nuevo</h2>
            
            <!-- Selección de Categorías -->
            <h6>Seleccione Categorías:</h6>
            <button type="button" id="btnAbrirModalFormulario" class="btn btn-primary mb-3">Crear Categoría</button>
            <button type="button" id="btnAbrirModalCodigoserial" class="btn btn-primary mb-3">Añadir Series</button>
            
            <div class="d-grid gap-2 overflow-auto p-1" style="max-height: 124px;">
                @foreach ($categories as $category)
                <div class="form-check">
                    <input maxlength="255" class="form-check-input" type="checkbox" name="categories[]" value="{{$category->name}}" id="checkbox{{$category->id}}">
                    <label class="form-check-label" for="checkbox{{$category->id}}">{{$category->name}}</label>
                </div>
                @endforeach
            </div>
            
            <div class="mt-3 text-center">
                <button type="button" id="btnAbrirModalInventario" class="btn btn-success">Agregar Inventario</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Agregar Códigos de serial -->
<div class="modal fade" id="modalAddCodeOfSerial" tabindex="-1" aria-labelledby="modalAddCodeOfSerialLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="min-width: 80%;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalAddCodeOfSerialLabel">Agregar Nueva serial</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body row justify-content-between">
                    <div class="row col-md-4">
                        <!-- Columna izquierda -->
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="selectCategory" class="form-label">Categoria</label>
                                <div class="col-auto">
                                    <select type="text" id="selectCategory" class="form-control col-md-8" placeholder="Sillas" required>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="d-flex">
                                    <button id="btnCancelSerial" class="btn btn-primary me-2">Cancelar</button>
                                    <button id="btnCreateSerial" class="btn btnCreateInventory btn-primary w-100" disabled>Crear</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Columna derecha -->
                    <div class="col-md-7">
                        <div class="row mb-2">
                            <div class="col-6 d-flex">
                                <div class="fs-6 d-grid" style="align-content: center;">Codigos Agregados</div>
                            </div>
                            <div class="col-6 d-flex justify-content-end">
                                <button class="btn btnDeleteSerial me-2" id="btnDeleteSerialCode">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                        <path fill="none" stroke="black" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                                <button id="btnAddSerialCode" class="btn align-baseline">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                        <path fill="none" stroke="black" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v14m-7-7h14" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <div id="serialCodeContainer" class="overflow-y-auto overflow-x-hidden" style="max-height: 130px;">
                            <!-- Fila inicial de inputs -->
                            <div class="row mb-2">
                                <div class="col-4">
                                    <input type="text" name="addnewcode[]" class="form-control inputCode" minlength="3" maxlength="10" placeholder="CG" required>
                                </div>
                                <div class="col-8">
                                    <input type="text" name="addnewname[]" class="form-control inputNameCode" minlength="3" maxlength="50" placeholder="Carro con Globos" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
</div>

<!-- Modal para Crear Categorías -->
<div class="modal fade" id="modalCreateCategories" tabindex="-1" aria-labelledby="modalCreateCategoriesLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="min-width: 80%;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCreateCategoriesLabel">Crear Categorías</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body row justify-content-between">
                <div class="row col-md-4">
                    <!-- Columna izquierda -->
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="inputCategoryNew" class="form-label">Nueva Categoría</label>
                            <div class="col-auto">
                                <input type="text" id="inputCategoryNew" name="newcategory" class="form-control col-md-8" minlength="4" maxlength="50" placeholder="Sillas" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="d-flex">
                                <button id="btnCancelCategory" class="btn btn-primary me-2">Cancelar</button>
                                <button id="btnCreateCategory" type="submit" class="btn btnCreateInventory btn-primary w-100" disabled>Crear</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Columna derecha -->
                <div class="col-md-7">
                    <div class="row mb-2">
                        <div class="col-6 d-flex">
                            <div class="fs-6 d-grid" style="align-content: center;">Agregar Categoría</div>
                        </div>
                        <div class="col-6 d-flex justify-content-end">
                            <button class="btn btnDeleteSerial me-2" id="btnDeleteCategoryRow">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                    <path fill="none" stroke="black" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                            <button id="btnAddCategoryRow" class="btn align-baseline">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                    <path fill="none" stroke="black" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v14m-7-7h14" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div id="categoriesContainer" class="overflow-y-auto overflow-x-hidden" style="max-height: 130px;">
                        <!-- Fila inicial de inputs -->
                        <div class="row mb-2">
                            <div class="col-4">
                                <input type="text" title="Por favor, ingresa entre 10 y 2 caracteres." name="newcode[0]" class="form-control inputCode" minlength="2" maxlength="10"  placeholder="CG" required>
                            </div>
                            <div class="col-8">
                                <input type="text" title="Por favor, ingresa solo letras y al menos 2 caracteres." name="newname[0]" class="form-control inputNameCode" minlength="2" maxlength="50" placeholder="Carro con Globos" required>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Agregar Inventario ----------------------------------------------------------------->
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
                                        <input type="tel" name="price" id="price" class="form-control" placeholder="10" aria-label="Input group example" aria-describedby="basic-addon1" maxlength="4" pattern="[0-9]{1,4}" inputmode="numeric" oninput="this.value=this.value.replace(/[^0-9]/g,'');" disabled>
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
@endsection
<!-- Scripts -->
 @section('scripts')
     
 
 
 <script>
 document.getElementById('btnCreateSerial').addEventListener('click', function () {
 
     const csrfToken = $('meta[name="csrf-token"]').attr('content'); // Obtenemos el token CSRF
 
     const principalCategory = document.getElementById('selectCategory').value;
     const modal = document.getElementById('modalAddCodeOfSerial');
     const code = modal.querySelectorAll('.inputCode');
     const namecode = modal.querySelectorAll('.inputNameCode');
 
     const categoryData = [];
 
     for (let i = 0; i < code.length; i++) {
         const serialValue = code[i].value;
         const nameSerialValue = namecode[i].value;
 
         if (serialValue && nameSerialValue) {
             categoryData.push({
                 code: serialValue,
                 namecode: nameSerialValue
             });
         }
     }
 
     const finalJson = {
         category: parseInt(principalCategory),
         codeinf: categoryData
     };
 
     console.log(JSON.stringify(finalJson));
     $.ajax({
         url: '{{route('codeadd.store')}}',
         method: 'POST',
         headers: {
             'X-CSRF-TOKEN': csrfToken 
         },
         contentType: 'application/json',
         data: JSON.stringify(finalJson),
         success: function (response) {
             location.reload();
             toastr.success('Codigos agregados exitosamente.');
         },
         error: function (xhr) {
             const errors = xhr.responseJSON.errors;
             for (let key in errors) {
                 errors[key].forEach(msg => toastr.error(msg));
             }
         }
     });
 });
 
 
 </script>
 
 <script>
     document.getElementById('btnCreateCategory').addEventListener('click', function () {
 
     const csrfToken = $('meta[name="csrf-token"]').attr('content'); // Obtenemos el token CSRF
 
     const principalCategory = document.getElementById('inputCategoryNew').value;
     const modal = document.getElementById('modalCreateCategories');
     const serials = modal.querySelectorAll('.inputCode');
     const nameSerials = modal.querySelectorAll('.inputNameCode');
 
     if (!principalCategory || principalCategory.length < 3) {
         toastr.error('Por favor, ingresa una categoría válida.');
         return;
     }
 
     const categoryData = [];
     
     for (let i = 0; i < serials.length; i++) {
         const serialValue = serials[i].value;
         const nameSerialValue = nameSerials[i].value;
 
         if (serialValue && nameSerialValue) {
             categoryData.push({
                 code: serialValue,
                 namecode: nameSerialValue
             });
         }
     }
 
     const finalJson = {
         category: principalCategory,
         codes: categoryData
     };
 
     console.log(JSON.stringify(finalJson));
     $.ajax({
         url: '{{route('newcategory.store')}}',
         method: 'POST',
         headers: {
             'X-CSRF-TOKEN': csrfToken 
         },
         contentType: 'application/json',
         data: JSON.stringify(finalJson),
         success: function (response) {
             //console.log('Respuesta del servidor:', response);
             location.reload();
             toastr.success('Categoría enviada exitosamente.');
         },
         error: function (xhr, status, error) {
             const errors = xhr.responseJSON.errors;
             for (let key in errors) 
             {
                 errors[key].forEach(msg => toastr.error(msg));
             }
         }
     });
 });
 
 
 </script>
 <!-- script para el funcionamiento del modal para agregar codigo de serial -->
 <script>

     const serials = @json($categories);
 
     document.getElementById('btnAbrirModalCodigoserial').addEventListener('click', function () {
         const modalAddCodeOfSerial = new bootstrap.Modal(document.getElementById('modalAddCodeOfSerial'));
         modalAddCodeOfSerial.show();
         
         const select = document.getElementById('selectCategory');
         select.innerHTML = '';
 
         serials.forEach((serial) => {
             const option = document.createElement('option');
             option.value = serial.id; 
             option.textContent = serial.name; 
             select.appendChild(option);
         });
 
         checkFormValidation('modalAddCodeOfSerial'); 
     });
 
     
     document.getElementById('btnAbrirModalFormulario').addEventListener('click', function () {
             const modalFormularioInventario = new bootstrap.Modal(document.getElementById('modalCreateCategories'));
             modalFormularioInventario.show();
 
             checkFormValidation('modalCreateCategories');
     });
     let count = 0;
 
     function addNewSerialRow(containerId, modalnowid) {
     const container = document.getElementById(containerId);
 
     
     const inputs = container.querySelectorAll('input');
     for (let input of inputs) {
         if (!input.value.trim()) {
             toastr.error('Completa todos los campos antes de agregar una nueva fila.');
             return;
         }
     }
 
     if (container.children.length < 10) {
         const row = document.createElement('div');
         row.classList.add('row', 'mb-2');
         count++; 
 
         let nameserial = "";
         let nameCode = "";
         
     
         if (modalnowid === "modalAddCodeOfSerial") {
             nameserial = `addnewcode[${count}]`;  
             nameCode = `addnewname[${count}]`; 
         } else if (modalnowid === "modalCreateCategories") {
             nameserial = `newcode[${count}]`;  
             nameCode = `newname[${count}]`; 
         }
 
         row.innerHTML = `
             <div class="col-4">
                 <input type="text" class="form-control title="Por favor, ingresa entre 10 y 2 caracteres." inputCode" minlength="3" maxlength="10" placeholder="CG" name="${nameserial}" required>
             </div>
             <div class="col-8">
                 <input type="text" class="form-control inputNameCode" minlength="3" maxlength="50" placeholder="Carro con Globos" name="${nameCode}" required>
             </div>
         `;
         container.appendChild(row);
 
         
         row.querySelectorAll('input').forEach(input => {
             input.addEventListener('input', () => checkFormValidation(modalnowid));
         });
     }
 }
 
     function deleteLastSerialRow(containerId) {
     const container = document.getElementById(containerId);
     if (container.children.length > 1) {
         container.lastElementChild.remove();
         count--;
     }
 }
 
     function checkFormValidation(modalId) {
     const modal = document.getElementById(modalId);
     const inputserials = modal.querySelectorAll('.inputCode');
     const inputNombres = modal.querySelectorAll('.inputNameCode');
     const btnCreateInventory = modal.querySelector('.btnCreateInventory');
     let valid = true;
     
     inputserials.forEach(input => {
         if (input.value.trim().length < 2) { 
             valid = false; 
         }
     });
     
     if (valid) { 
         inputNombres.forEach(input => {
             if (!input.value.trim()) { 
                 valid = false;
             }
         });
     }
 
     btnCreateInventory.disabled = !valid;
 }
 
     document.getElementById('btnAddSerialCode').addEventListener('click', () => {
     addNewSerialRow('serialCodeContainer', 'modalAddCodeOfSerial');
     disableConfirmButton('modalAddCodeOfSerial'); 
 });
     document.getElementById('btnDeleteSerialCode').addEventListener('click', () => {deleteLastSerialRow('serialCodeContainer');
         checkFormValidation('modalAddCodeOfSerial');
     });
 
     document.getElementById('btnAddCategoryRow').addEventListener('click', () => {
     addNewSerialRow('categoriesContainer', 'modalCreateCategories');
     disableConfirmButton('modalCreateCategories'); 
 });
     document.getElementById('btnDeleteCategoryRow').addEventListener('click', () => {deleteLastSerialRow('categoriesContainer');
         checkFormValidation('modalCreateCategories');
     });
 
     function disableConfirmButton(modalId) {
     const modal = document.getElementById(modalId);
     const btnConfirm = modal.querySelector('.btnCreateInventory'); 
     btnConfirm.disabled = true; 
     
 }
     
     document.querySelectorAll('.inputCode, .inputNameCode').forEach(input => {
         input.addEventListener('input', function () {
             const modalVisible = document.querySelector('.modal.show');
             if (modalVisible) {
                 checkFormValidation(modalVisible.id);
             }
         });
     });
 
     
 function resetModal(modalId, containerId) {
     const modal = document.getElementById(modalId);
     const container = document.getElementById(containerId);
     const inputs = modal.querySelectorAll('input');
     const buttons = modal.querySelectorAll('button');
     count = 0;
 
     inputs.forEach(input => {
         input.value = '';  
     });
     
     const btnCreate = modal.querySelector('.btnCreateInventory');
 
     container.innerHTML = ''; 
     
     if (containerId === 'serialCodeContainer') {
         container.innerHTML = `
             <div class="row mb-2">
                 <div class="col-4">
                     <input type="text" name="addnewcode[]" class="form-control inputCode" minlength="3" placeholder="CG" required>
                 </div>
                 <div class="col-8">
                     <input type="text" name="addnewname[]" class="form-control inputNameCode" minlength="3" placeholder="Carro con Globos" required>
                 </div>
             </div>`;
     } else if (containerId === 'categoriesContainer') {
         container.innerHTML = `
             <div class="row mb-2">
                 <div class="col-4">
                     <input type="text" name="newcode[0]" class="form-control inputCode" minlength="3" placeholder="CG" required>
                 </div>
                 <div class="col-8">
                     <input type="text" name="newname[0]" class="form-control inputNameCode" minlength="3" placeholder="Carro con Globos" required>
                 </div>
             </div>`;
     }
 
     container.querySelectorAll('.inputCode, .inputNameCode').forEach(input => {
         input.addEventListener('input', function () {
             checkFormValidation(modalId);
         });
     });
 
     btnCreate.disabled = true;
 }
 
 document.getElementById('modalAddCodeOfSerial').addEventListener('hidden.bs.modal', function () {
     resetModal('modalAddCodeOfSerial', 'serialCodeContainer');
 });
 
 document.getElementById('modalCreateCategories').addEventListener('hidden.bs.modal', function () {
     resetModal('modalCreateCategories', 'categoriesContainer');
 });
 
 
 </script>
 
 <script>
     //modal de agregar inventario --------------------------------------------------------------------------
     const serialMap = {}; 
     const usedSerialNumbers = {}; 
     const inventoryData = []; 
 
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
                 //console.log("Respuesta del servidor: ", response);
                 $("#serialListBox").html('<option value="">Seleccione un Serial</option>');
                 Object.keys(serialMap).forEach(key => delete serialMap[key]);
                 Object.keys(usedSerialNumbers).forEach(key => delete usedSerialNumbers[key]);
 
                 $.each(response, function (index, serial) {
                     $("#serialListBox").append(
                         `<option value="${serial.id}">${serial.code} - ${serial.name}</option>`
                     );
 
                     serialMap[serial.id] = serial.next_number; 
                     usedSerialNumbers[serial.id] = []; 
                 });
 
                 bootstrap.Modal.getInstance(document.getElementById('inventoryModal')).hide();
                 new bootstrap.Modal(document.getElementById('formModal')).show();
             },
             error: function (xhr, status, error) {
                // console.error("Error al obtener los números de serial", error);
                 toastr.error("Hubo un error. Intenta nuevamente.");
             },
         });
     });
 
 document.getElementById('serialListBox').addEventListener('change', function () {
     const selectedId = this.value; 
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
 
         usedSerialNumbers[serialId].push(nextNumber); 
         serialMap[serialId] = nextNumber + 1;
 
         
         const serialCode = $("option:selected", serialListBox).text().split(" ")[0]; 
 
         const item = {
             id: serialId, 
             number: nextNumber,
             description: descriptionText,
             price: inventoryPrice
         };
         inventoryData.push(item); 
 
         const listItem = document.createElement('li');
         listItem.classList.add('list-group-item');
         listItem.textContent = `${serialCode}-${nextNumber} $${inventoryPrice}: ${descriptionText}`; // Mostrar el código
         serialList.appendChild(listItem);
 
         confirmInventoryButton.disabled = false;
 
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
 
 document.getElementById('updateInventory').addEventListener('click', () => {
     if (inventoryData.length > 0) {
         const inventoryJson = JSON.stringify({
             items: inventoryData.map(item => ({
                 id: item.id,  // Enviar el id en lugar del código
                 number: item.number,
                 description: item.description,
                 price: item.price
             }))
         });
         console.log('Inventario JSON a enviar:', inventoryJson);
         
         $.ajax({
             url: '{{route('inventoryadd.store')}}',  // Reemplaza esto con la URL de tu controlador
             type: 'POST',
             headers: {
                 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') // Añade el token CSRF en el encabezado
             },
             contentType: 'application/json',  
             data: inventoryJson, 
             success: function(response) {
                 //console.log('Respuesta del servidor:', response);
 
                 resetModalData();
                 bootstrap.Modal.getInstance(document.getElementById('formModal')).hide();
                 toastr.success('Inventario confirmado correctamente.');
             },
             error: function(xhr, status, error) {
                 //console.log("Response Text:", xhr.responseText);
                 toastr.error('Hubo un problema al confirmar el inventario. Intenta nuevamente.');
             }
         });
     } else {
         toastr.error('No hay ítems en el inventario para confirmar.');
     }
 });
 
 
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
 
     document.addEventListener('DOMContentLoaded', function () {
         const formModal = document.getElementById('formModal');
         if (formModal) {
             formModal.addEventListener('hidden.bs.modal', resetModalData);
         }
     });
 </script>
 @endsection

