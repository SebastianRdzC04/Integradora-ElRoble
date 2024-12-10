@extends('layouts.dashboardAdmin')

@section('title', 'Users')

@section('styles')

@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="table-responsive">
                <table class="table shadow table-striped" id="users-table">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>Email</th>
                            <th>Telefono</th>
                            <th>Género</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td> {{ $user->person->first_name }} </td>
                                <td> {{ $user->person->last_name }} </td>
                                <td> {{ $user->email }} </td>
                                <td> {{ $user->person->phone }} </td>
                                <td> {{ $user->person->gender }} </td>
                                <td> {{ $user->is_On ? 'Activo' : 'Inactivo' }} </td>
                                <th>
                                    <select name="" id="" class="form-select alv">
                                        <option value="">Selecciona una opcion</option>
                                        <option data-bs-toggle="modal" data-bs-target="#statusUser{{ $user->id }}"
                                            value="">Cambiar Estado</option>
                                        <option data-bs-toggle="modal" data-bs-target="#permisos{{$user->id}}" value="">Modificar Rol</option>
                                    </select>
                                    <div class="modal fade" id="permisos{{ $user->id }}">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h3>Editar Permisos</h3>
                                                </div>
                                                <form action="{{route('dashboard.user.change.rol', $user->id)}}" method="POST">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label for="rol">Rol</label>
                                                            <select name="rol" id="rol" class="form-select">
                                                                <option value="">Selecciona un rol</option>
                                                                <option value="1"
                                                                    {{ $user->roles->contains('id', 1) ? 'selected' : '' }}>
                                                                    Super Administrador</option>
                                                                <option value="2"
                                                                    {{ !$user->roles->contains('id', 1) && $user->roles->contains('id', 2) ? 'selected' : '' }}>
                                                                    Administrador</option>
                                                                    @if ($user->roles->contains('id', 2))
                                                                        <option value="3">Eliminar Privilegios</option>
                                                                        
                                                                    @endif
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button class="btn btn-primary">Aceptar</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal fade" id="statusUser{{ $user->id }}">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h3>Modificar Estado</h3>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Seguro que quieres cambiar el estado del usuario?</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <form action="{{ route('dashboard.change.status.user', $user->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        <button class="btn btn-primary">Aceptar</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </th>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('scripts')

    @if (session('success'))
        <script>
            toastr.success('{{ session('success') }}');
        </script>
    @endif

    @if (session('error'))
        <script>
            toastr.error('{{ session('error') }}');
        </script>
    @endif

    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <script>
                toastr.error('{{ $error }}');
            </script>
        @endforeach
    @endif
    <script>
        const selects = document.querySelectorAll('.alv');

        selects.forEach(select => {
            select.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const optionValue = selectedOption.value;

                if (optionValue && optionValue.includes('dashboard/event')) {
                    window.location.href = optionValue;
                    return;
                }

                if (selectedOption.value === 'editar') {

                }
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

    <script src="{{ asset('js/dashboard/users.js') }}"></script>
@endsection
