@extends('layouts.dashboardAdmin')

@section('title', 'Agregar Consumible')

@section('styles')

@endsection

@section('content')
    <aside>
        <a href="{{ route('dashboard.consumables') }}" class="btn btn-primary">Volver a Consumibles</a>
    </aside>

    <body>
        <div class="modal fade" id="agregarCategoriaModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3>Registra una nueva categoria</h3>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('dashboard.consumable.category.create') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="category_name" class="form-label">Nombre de la categoría</label>
                                <input type="text" class="form-control" id="category_name" name="nombre" required
                                    maxlength="50">
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Agregar Categoría</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="container mt-2 ">
            <div class="row justify-content-center mb-4">
                <div class="col-md-8 border shadow pt-4">
                    <h2 class="text-center mb-3">Agregar Consumible</h2>
                    <form action="{{ route('consumables.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="name" name="name" required
                                maxlength="50">
                        </div>
                        <div class="mb-3">
                            <label for="stock" class="form-label">Stock</label>
                            <input type="number" class="form-control" id="stock" name="stock" required
                                min="0">
                        </div>
                        <div class="mb-3">
                            <label for="minimum_stock" class="form-label">Stock Mínimo</label>
                            <input type="number" class="form-control" id="minimum_stock" name="minimum_stock" required
                                min="0">
                        </div>
                        <div class="mb-3">
                            <label for="maximum_stock" class="form-label">Stock Maximo</label>
                            <input type="number" class="form-control" id="maximum_stock" name="maximum_stock" required
                                min="0">
                        </div>
                        <div class="mb-3">
                            <label for="unit" class="form-label">Unidad</label>
                            <input type="text" class="form-control" id="unit" name="unit" required
                                maxlength="10">
                        </div>
                        <div class="mb-3 d-flex">
                            <div>
                                <label for="category_id" class="form-label">Categoría</label>
                                <select class="form-select" id="category_id" name="category_id" required>
                                    <option selected disabled>Selecciona una categoría</option>
                                    <!-- Ejemplo: las opciones de categorías pueden cargarse desde el backend -->
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="ms-auto align-content-center pt-4 mt-2">
                                <a class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#agregarCategoriaModal">agregar categorioa</a>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Descripción</label>
                            <textarea class="form-control" id="description" name="description" rows="3" maxlength="100"></textarea>
                        </div>
                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-primary">Agregar Consumible</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </body>
@endsection

@section('scripts')

    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <script>
                toastr.error('{{ $error }}');
            </script>
        @endforeach
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

@endsection
