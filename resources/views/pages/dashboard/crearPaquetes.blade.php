@extends('layouts.dashboardAdmin')

@section('title', 'Agregar Paquete')

@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.css">

@endsection

@section('content')
    <aside>
        <a href="{{ route('dashboard.packages') }}" class="btn btn-primary">Ver Paquetes</a>
    </aside>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-6">
                <div class="form">
                    <form action="{{ route('dashboard.create.package') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="lugar" class="form-label">Lugar</label>
                            <select name="lugar" id="" class="form-select">
                                <option value="">Selecciona un lugar</option>
                                @foreach ($places as $place)
                                    <option value="{{ $place->id }}">{{ $place->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombree</label>
                            <input type="text" class="form-control" name="nombre">
                        </div>
                        <div class="d-flex">
                            <div class="mb-3 col-6">
                                <label for="fechaInicio" class="form-label">Fecha de Inicio</label>
                                <input type="date" class="form-control" name="fechaInicio">
                            </div>

                            <div class="mb-3 col-6">
                                <label for="fechaFin" class="form-label">Fecha de Fin</label>
                                <input type="date" class="form-control" name="fechaFin">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripcion</label>
                            <textarea name="descripcion" id="" cols="30" rows="7" class="form-control"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="precio" class="form-label">Precio</label>
                            <input type="number" class="form-control" name="precio">
                        </div>
                        <div class="mb-3">
                            <label for="afore" class="form-label">Maximo de Personas para el paquete</label>
                            <input type="number" class="form-control" name="afore">
                        </div>
                        <div class="mb-3">
                            <label for="imagen">Sube la Imagen del paquete aquí</label>
                            <input type="file" class="form-control" id="imageInput" name="imagen" accept="image/*">
                        </div>
                        <div class="mb-3 d-flex justify-content-end">
                            <button class="btn btn-primary">Enviar</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-6 d-flex justify-content-center">
                <div class="">
                    <div class="mb-3">
                        <button type="button" class="btn btn-primary" id="cropButton" style="display: none;">
                            Recortar Imagen
                        </button>
                    </div>
                    <div class="image-preview-container">
                        <img id="preview" style="max-height: 500px; width: auto;">
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.js"></script>


    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <script>
                toastr.error("{{ $error }}");
            </script>
        @endforeach

    @endif

    @if (session('success'))
        <script>
            toastr.success("{{ session('success') }}");
        </script>
    @endif

    @if (session('error'))
        <script>
            toastr.success("{{ session('error') }}");
        </script>
    @endif
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
                        aspectRatio: 4 / 3, // 4:3 ratio
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

@endsection
