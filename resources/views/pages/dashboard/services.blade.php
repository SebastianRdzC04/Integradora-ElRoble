@extends('layouts.dashboardAdmin')

@section('styles')

    <link rel="stylesheet" href="{{ asset('css/dashboard/services.css') }}">

@endsection

@section('title', 'Services')

@section('content')

    <div class="container">
        <div class="d-flex justify-content-end mb-1">
            <a href="{{ route('dashboard.crear.servicios') }}" class="btn btn-primary">Crear Servicio</a>
        </div>
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="table-responsive">
                    <table class="table mb-0 shadow" id="servicios-table">
                        <thead>
                            <tr>
                                <th class="text-center">Nombre</th>
                                <th class="text-center">Descripcion</th>
                                <th class="text-center">Categoria</th>
                                <th class="text-center">Precio aprox</th>
                                <th class="text-center">N.Personas aprox</th>
                                <th class="text-center">Costo</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($services as $service)
                                <tr>
                                    <td>{{ $service->name }}</td>
                                    <td>{{ $service->description }}</td>
                                    <td>{{ $service->serviceCategory->name }}</td>
                                    <td class="text-center">{{ $service->price }}</td>
                                    <td class="text-center">{{ $service->people_quantity }}</td>
                                    <td class="text-center">{{ $service->coast }}</td>
                                    <td>
                                        <select name="" id="" class="form-select noca">
                                            <option value="">Opciones</option>
                                            <option data-bs-toggle="modal" data-bs-target="#editService{{ $service->id }}"
                                                value="">Editar Servicio</option>
                                            <option value="">Eliminar Servicio</option>
                                        </select>
                                        <div class="modal fade" id="editService{{ $service->id }}">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h3>Editar Servicio</h3>
                                                    </div>
                                                    <form action="{{ route('dashboard.service.edit', $service->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        <div class="modal-body">
                                                            <div class="mb-3 d-flex">
                                                                <div class="col-8">
                                                                    <div>
                                                                        <label for="categoria">Categoria del
                                                                            servicio</label>
                                                                        <select name="categoria" id=""
                                                                            class="form-select">
                                                                            @foreach ($serviceCategories as $category)
                                                                                @if ($category->name == $service->serviceCategory->name)
                                                                                    <option value="{{ $category->name }}"
                                                                                        selected>
                                                                                        {{ $category->name }}</option>
                                                                                @endif
                                                                                <option value="{{ $category->name }}">
                                                                                    {{ $category->name }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-4 mt-auto">

                                                                </div>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="nombre" class="form-label">Nombre</label>
                                                                <input name="nombre" type="text" class="form-control"
                                                                    value="{{ $service->name }}">
                                                            </div>
                                                            <div class="mb-3 d-flex">
                                                                <div class="col-6 me-2">
                                                                    <label for="descripcion"
                                                                        class="form-label">Descripcion</label>
                                                                    <textarea name="descripcion" id="" cols="30" rows="7" class="form-control">{{ $service->description }}</textarea>
                                                                </div>
                                                                <div class="col-6">
                                                                    <div class="">
                                                                        <label for="precio"
                                                                            class="form-label">Precio</label>
                                                                        <input name="precio" type="number"
                                                                            class="form-control"
                                                                            value="{{ $service->price }}">
                                                                    </div>
                                                                    <div>
                                                                        <label for="costo"
                                                                            class="form-label">Costo</label>
                                                                        <input name="costo" type="number"
                                                                            class="form-control"
                                                                            value="{{ $service->coast }}">
                                                                    </div>
                                                                    <div>
                                                                        <label for="afore">Promedio de personas</label>
                                                                        <input name="afore" type="number"
                                                                            class="form-control"
                                                                            value="{{ $service->people_quantity }}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button class="btn btn-primary">Enviar</button>
                                                        </div>
                                                    </form>
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

    @if ($errors->any())
        <script>
            @foreach ($errors->all() as $error)
                toastr.error('{{ $error }}');
            @endforeach
        </script>
    @endif

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

    <script>
        const selects = document.querySelectorAll('.noca');

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
    @if ($errors->any())
        <script>
            @foreach ($errors->all() as $error)
                toastr.error('{{ $error }}');
            @endforeach
        </script>
    @endif

    @if (session('success'))
        <script>
            toastr.success('{{ session('success') }}');
        </script>
    @endif

    <script src="{{ asset('js/dashboard/services.js') }}"></script>

@endsection
