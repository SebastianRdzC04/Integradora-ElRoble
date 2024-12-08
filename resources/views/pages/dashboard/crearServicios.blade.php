@extends('layouts.dashboardAdmin')

@section('title', 'Agregar Servicios')

@section('styles')

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.css">

@endsection

@section('content')
    <div class="container">
        <div class="modal fade" id="agregarCategoriaModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3>Registra una nueva categoria</h3>
                    </div>
                    <form action="{{ route('dashboard.crear.categoria.servicios') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <label for="nombreCategoria">Nombre</label>
                            <input type="text" class="form-control" name="nombreCategoria">
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-primary">Enviar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-7">
                <div class="form">
                    <form action="">
                        <div class="mb-3 d-flex">
                            <div class="col-8">
                                <div>
                                    <label for="categoria">Categoria del servicio</label>
                                    <select name="categoria" id="" class="form-select">
                                        <option value="">Selecciona una Categoria</option>
                                        @foreach ($serviceCategories as $category)
                                            <option value="{{ $category->name }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-4 mt-auto">
                                <div class="ms-5">
                                    <a type="button" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#agregarCategoriaModal">Agregar Categoria</a>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="mb-3 d-flex">
                            <div class="col-6 me-2">
                                <label for="descripcion" class="form-label">Descripcion</label>
                                <textarea name="descripcion" id="" cols="30" rows="7" class="form-control"></textarea>
                            </div>
                            <div class="col-6">
                                <div class="">
                                    <label for="precio" class="form-label">Precio</label>
                                    <input type="number" class="form-control">
                                </div>
                                <div>
                                    <label for="costo" class="form-label">Costo</label>
                                    <input type="number" class="form-control">
                                </div>
                                <div>
                                    <label for="afore">Promedio de personas</label>
                                    <input type="text" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="imagen">Sube la Imagen del servicio aqui</label>
                            <input type="file" class="form-control" id="imageInput" name="imagen" accept="image/*">
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-5 d-flex justify-content-center">
                <div class="">
                    <div class="mb-3">
                        <button type="button" class="btn btn-primary" id="cropButton" style="display: none;">
                            Recortar Imagen
                        </button>
                    </div>
                    <div class="image-preview-container" style="max-width: 300px;">
                        <img id="preview" style="max-width: 100%; display: none;">
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.js"></script>

    <script>
        let cropper;
        const imageInput = document.getElementById('imageInput');
        const preview = document.getElementById('preview');
        const cropButton = document.getElementById('cropButton');

        imageInput.addEventListener('change', function(e) {
            const file = e.target.files[0];

            if (file) {
                // Validate file type
                if (!file.type.startsWith('image/')) {
                    toastr.error('Por favor selecciona solo archivos de imagen');
                    imageInput.value = '';
                    return;
                }

                const reader = new FileReader();

                reader.onload = function(event) {
                    preview.src = event.target.result;
                    preview.style.display = 'block';
                    cropButton.style.display = 'block';

                    if (cropper) {
                        cropper.destroy();
                    }

                    cropper = new Cropper(preview, {
                        aspectRatio: 4/3, // 1:1 ratio
                        viewMode: 2,
                        dragMode: 'move',
                        autoCropArea: 1,
                        restore: false,
                        guides: true,
                        center: true,
                        highlight: false,
                        cropBoxMovable: true,
                        cropBoxResizable: true,
                        toggleDragModeOnDblclick: false,
                    });
                };

                reader.readAsDataURL(file);
            }
        });

        cropButton.addEventListener('click', function() {
            if (cropper) {
                const canvas = cropper.getCroppedCanvas();
                const croppedImage = canvas.toDataURL('image/jpeg');

                // Add hidden input with cropped image data
                const hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = 'croppedImage';
                hiddenInput.value = croppedImage;
                imageInput.parentElement.appendChild(hiddenInput);

                // Update preview
                preview.src = croppedImage;
                cropper.destroy();
                cropper = null;

                toastr.success('Imagen recortada exitosamente');
            }
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

@endsection
