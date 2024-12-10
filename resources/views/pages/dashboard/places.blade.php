@extends('layouts.dashboardAdmin')

@section('title', 'Luagres')

@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.css">

@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="table-responsive">
                    <table class="table table-striped" id="table-places">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Descripcion</th>
                                <th>Afore Max.</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($places as $place)
                                <tr>
                                    <td>{{ $place->name }}</td>
                                    <td>{{ $place->description }}</td>
                                    <td>{{ $place->max_guest }}</td>
                                    <td class="text-center">
                                        <a href="" data-bs-toggle="modal" data-bs-target="#editar{{ $place->id }}"
                                            class="btn btn-light">Editar</a>

                                        <div>
                                            <div class="modal fade" id="editar{{$place->id}}">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">

                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="{{ route('dashboard.place.edit', $place->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                <div class="mb-3">
                                                                    <label for="nombre" class="form-label">Nombre</label>
                                                                    <input type="text" class="form-control" name="nombre"
                                                                        value="{{ $place->name }}">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="afore" class="form-label">Maximo de
                                                                        Personas</label>
                                                                    <input type="number" class="form-control" name="afore"
                                                                        value="{{ $place->max_guest }}">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="descripcion" class="form-label">Descripcion</label>
                                                                    <textarea name="descripcion" id="" cols="30" rows="5"
                                                                        class="form-control">{{ $place->description }}</textarea>
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
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-12">
                <h2 class="text-center">Imagenes</h2>
            </div>
            @foreach ($places as $place)
                <div class="col-4">
                    <div class="card">
                        <img src="{{ $place->image_path }}" alt="Imagen{{ $place->name }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $place->name }}</h5>
                            <a href="" data-bs-toggle="modal" data-bs-target="#editarImagen{{ $place->id }}"
                                class="btn btn-primary">Editar</a>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="editarImagen{{ $place->id }}" tabindex="-1"
                    aria-labelledby="editarImagenLabel{{ $place->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="editarImagenLabel{{ $place->id }}">Editar Imagen</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('dashboard.place.edit.image', $place->id) }}" method="POST"
                                    class="fotosEdit" enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="imageInput{{ $place->id }}" class="form-label">Sube la Imagen del
                                            lugar aquí</label>
                                        <input type="file" class="form-control" id="imageInput{{ $place->id }}"
                                            name="imagen" accept="image/*">
                                    </div>
                                    <div class="mb-3">
                                        <div class="image-preview-container" style="max-width: 100%;">
                                            <img id="preview{{ $place->id }}" style="max-width: 100%; display: none;">
                                        </div>
                                    </div>
                                    <div class="mb-3 d-flex justify-content-end gap-2">
                                        <button type="button" class="btn btn-secondary"
                                            id="cancelButton{{ $place->id }}" style="display: none;">Cancelar</button>
                                        <button type="button" class="btn btn-primary" id="cropButton{{ $place->id }}"
                                            style="display: none;">Recortar Imagen</button>
                                    </div>
                                    <div class="mb-3 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary">Confirmar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.js"></script>
    <script>
        let fotosForm = document.querySelectorAll('.fotosEdit');

        fotosForm.forEach(form => {
            let imageInput = form.querySelector('input[type="file"]');
            let preview = form.querySelector('img');
            let cropButton = form.querySelector('button[type="button"].btn-primary'); // Cambiar selector
            let cancelButton = form.querySelector('button[type="button"].btn-secondary'); // Cambiar selector

            if (imageInput && preview && cropButton && cancelButton) {
                const resetImage = () => {
                    imageInput.value = '';
                    preview.src = '';
                    preview.style.display = 'none';
                    cropButton.style.display = 'none';
                    cancelButton.style.display = 'none';
                    if (window.cropper) {
                        window.cropper.destroy();
                        window.cropper = null;
                    }
                };

                cancelButton.addEventListener('click', resetImage);

                imageInput.addEventListener('change', () => {
                    let file = imageInput.files[0];
                    if (file) {
                        let reader = new FileReader();

                        reader.onload = (e) => {
                            preview.src = e.target.result;
                            preview.style.display = 'block';
                            cropButton.style.display = 'block';
                            cancelButton.style.display = 'block';

                            if (window.cropper) {
                                window.cropper.destroy();
                            }

                            window.cropper = new Cropper(preview, {
                                aspectRatio: 4 / 3,
                                viewMode: 1,
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

                cropButton.addEventListener('click', () => {
                    if (window.cropper) {
                        const canvas = window.cropper.getCroppedCanvas();
                        const croppedImage = canvas.toDataURL('image/jpeg');

                        // Add hidden input with cropped image data
                        const hiddenInput = document.createElement('input');
                        hiddenInput.type = 'hidden';
                        hiddenInput.name = 'croppedImage';
                        hiddenInput.value = croppedImage;
                        form.appendChild(hiddenInput);

                        // Update preview
                        preview.src = croppedImage;
                        window.cropper.destroy();
                        window.cropper = null;

                        toastr.success('Imagen recortada exitosamente');
                    }
                });
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

    <script src="{{ asset('js/dashboard/places.js') }}"></script>

@endsection
