@extends('layouts.dashboardAdmin')

@section('styles')

    <link rel="stylesheet" href="{{ asset('css/dashboard/inventory.css') }}">

@endsection

@section('title', 'Inventory')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="d-flex justify-content-end">
                    <a href="{{ route('inventory') }}" class="btn btn-primary">Agregar Inventario</a>
                </div>
            </div>
            <div class="col-12">
                <div class="table-resposive">
                    <table class="table shadow" id="inventory-table">
                        <thead>
                            <tr>
                                <th class="text-center">No.Serie</th>
                                <th class="text-center">Descripcion</th>
                                <th class="text-center">Estado</th>
                                <th class="text-center">Precio</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($inventory as $item)
                                <tr>
                                    <td class="text-center">{{ $item->SerialType->code }}-{{ $item->number }}</td>
                                    <td class="text-center"> {{ $item->description }} </td>
                                    <td class="text-center"> {{ $item->status }} </td>
                                    <td class="text-center">${{ $item->price }}</td>
                                    <td>
                                        <select class="form-select alv" name="select" id="">
                                            <option value="">Opciones</option>
                                            <option data-bs-toggle="modal" data-bs-target="#editModal{{ $item->id }}"
                                                value="">Editar</option>
                                            <option data-bs-toggle="modal" data-bs-target="#deleteModal{{ $item->id }}"
                                                value="">Eliminar</option>
                                        </select>
                                        <div class="modal fade" id="editModal{{ $item->id }}">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h3>Aqui vas a editar el modal</h3>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <form
                                                                    action="{{ route('dashboard.inventory.edit', $item->id) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    <div class="mb-3">
                                                                        <label for="description"
                                                                            class="form-label">Descripcion</label>
                                                                        <input type="text" class="form-control"
                                                                            value="{{ $item->description }}"
                                                                            name="description" required maxlength="50">
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="status"
                                                                            class="form-label">Estado</label>
                                                                        <select class="form-select" name="status">
                                                                            <option value="disponible"
                                                                                {{ $item->status == 'disponible' ? 'selected' : '' }}>
                                                                                disponible
                                                                            </option>
                                                                            <option value="no disponible"
                                                                                {{ $item->status == 'no disponible' ? 'selected' : '' }}>
                                                                                no disponible
                                                                            </option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="mb-3 d-flex justify-content-end">
                                                                        <button class="btn btn-primary">Enviar</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal fade" id="deleteModal{{ $item->id }}">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h3>¿Estas seguro de eliminar este elemento?</h3>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div>
                                                            <h6>Una vez eliminado no podra volver atras</h6>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <div class="d-flex justify-content-end">
                                                            <form action="{{route('dashboard.inventory.delete', $item->id)}}" method="POST" class="eliminar-elemento">
                                                                @csrf
                                                                <button class="text-end btn btn-danger">Eliminar</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        const selects = document.querySelectorAll('.alv');

        selects.forEach(select => {
            select.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const modalId = selectedOption.getAttribute('data-bs-target');

                if (modalId) {
                    const modal = new bootstrap.Modal(document.querySelector(modalId));
                    modal.show();
                }

                // Resetear el select después de abrir el modal
                this.selectedIndex = 0;
            });
        });
    </script>
    <script src="{{ asset('js/dashboard/inventory.js') }}"></script>

@endsection
