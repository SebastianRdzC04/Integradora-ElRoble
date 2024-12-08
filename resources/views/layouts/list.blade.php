<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('css/globalstyles.css') }}">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        .selected-row {
            background-color: #d1ecf1; /* Cambia a tu color preferido */
        }
    </style>
</head>

<body class="bg-light">

    <div class="container mt-5">
        <h2 class="text-center mb-4">@yield('tabletitle')</h2>

        <!-- Botones de acción -->
        <div class="mb-3">
            <button id="delete" type="button" class="btn btn-outline-danger" data-toggle="modal" data-target="#confirmModal" disabled>
                Eliminar
            </button>
            <a href="#" id="editLink" class="btn btn-success disabled" aria-disabled="true">Editar</a>
        </div>

        <!-- Modal para confirmar eliminación -->
        <div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmModalLabel">Confirmar Eliminación</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        ¿Estás seguro de que deseas eliminar este registro? Esta acción no se puede deshacer.
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Eliminar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Formulario para eliminar (invisible) -->
        <form id="deleteForm" method="POST" style="display: none;">
            @csrf
            @method('DELETE')
        </form>

        <!-- Comienza la tabla -->
        <div class="table-responsive">
            <table class="table table-striped">
                @yield('columns')
            </table>
        </div>
    </div>

    <script>
        let selectedRowId = null;

        // Selección de fila
        document.querySelectorAll('.selectable-row').forEach(row => {
            row.addEventListener('click', function() {
                // Remueve la clase de fila seleccionada de cualquier otra fila
                document.querySelectorAll('.selectable-row').forEach(r => r.classList.remove('selected-row'));

                // Marca la fila actual como seleccionada
                this.classList.add('selected-row');
                
                // Habilita el botón de eliminar y el enlace de edición, actualizando sus enlaces
                selectedRowId = this.getAttribute('data-id');
                document.getElementById('delete').disabled = false;
                document.getElementById('editLink').classList.remove('disabled');
                document.getElementById('editLink').setAttribute('href', "{{ url('person/update') }}/" + selectedRowId);
            });
        });

        // Acción de eliminar
        document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
            if (selectedRowId) {
                document.getElementById('deleteForm').action = "{{ url('list/persondestroy') }}/" + selectedRowId;
                document.getElementById('deleteForm').submit();
            }
        });

        // Desactiva el botón de Eliminar hasta que haya una fila seleccionada
        document.getElementById('delete').addEventListener('click', function() {
            if (!selectedRowId) {
                alert('Por favor, selecciona una fila primero.');
            }
        });
    </script>
</body>
</html>
