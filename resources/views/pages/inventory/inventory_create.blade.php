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
    <div class="container mt-5">
        <h2 class="text-center mb-4">Agregar Inventario</h2>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <form action="{{ route('consumables.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="description" class="form-label">Descripción</label>
                        <textarea class="form-control" id="description" name="description" rows="3" maxlength="100"></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label for="maximum_stock" class="form-label">precio</label>
                        <input type="number" class="form-control" id="maximum_stock" name="price" required
                            min="0">
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