<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Consumible</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Agregar Consumible</h2>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <form action="{{ route('consumables.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="name" name="name" required maxlength="50">
                    </div>
                    <div class="mb-3">
                        <label for="stock" class="form-label">Stock</label>
                        <input type="number" class="form-control" id="stock" name="stock" required min="0">
                    </div>
                    <div class="mb-3">
                        <label for="minimum_stock" class="form-label">Stock Mínimo</label>
                        <input type="number" class="form-control" id="minimum_stock" name="minimum_stock" required min="0">
                    </div>
                    <div class="mb-3">
                        <label for="maximum_stock" class="form-label">Stock Maximo</label>
                        <input type="number" class="form-control" id="maximum_stock" name="maximum_stock" required min="0">
                    </div>
                    <div class="mb-3">
                        <label for="unit" class="form-label">Unidad</label>
                        <input type="text" class="form-control" id="unit" name="unit" required maxlength="10">
                    </div>
                    <div class="mb-3">
                        <label for="category_id" class="form-label">Categoría</label>
                        <select class="form-select" id="category_id" name="category_id" required>
                            <option selected disabled>Selecciona una categoría</option>
                            <!-- Ejemplo: las opciones de categorías pueden cargarse desde el backend -->
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Descripción</label>
                        <textarea class="form-control" id="description" name="description" rows="3" maxlength="100"></textarea>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Agregar Consumible</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
