@extends('layouts.dashboardAdmin')

@section('title', 'Profile')

@section('styles')

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.css">

@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-5">
                <div class="card">
                    <img src="{{ auth()->user()->avatar }}" alt="">
                    <form action="{{route('profile.update', auth()->user()->id)}}" method="POST" enctype="multipart/form-data">
                        <div class="card-body">
                            @csrf
                            <div class="mb-3">
                                <label for="imagen">Cambiar Foto de perfil</label>
                                <input type="file" class="form-control" id="imagen" name="imagen">
                            </div>
                            <div class="mb-3">
                                <label for="first_name" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="first_name" name="first_name"
                                    value="{{ auth()->user()->person->first_name }}">
                            </div>
                            <div class="mb-3">
                                <label for="last_name" class="form-label">Apellidos</label>
                                <input type="text" class="form-control" id="last_name" name="last_name"
                                    value="{{ auth()->user()->person->last_name }}">
                            </div>
                        </div>
                        <input type="hidden" id="croppedImage" name="croppedImage">
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="cropImageModal" tabindex="-1" aria-labelledby="cropImageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cropImageModalLabel">Recortar Imagen</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="img-container">
                        <img id="imageToCrop" src="" alt="Imagen a recortar">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="cropButton">Recortar y Guardar</button>
                </div>
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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.js"></script>

    <script>
        var image = document.getElementById('imageToCrop');
        var input = document.getElementById('imagen');
        var cropper;
        var modal = new bootstrap.Modal(document.getElementById('cropImageModal'));

        input.addEventListener('change', function(e) {
            var files = e.target.files;
            var done = function(url) {
                input.value = '';
                image.src = url;
                modal.show();
            };
            var reader;
            var file;
            var url;

            if (files && files.length > 0) {
                file = files[0];

                if (URL) {
                    done(URL.createObjectURL(file));
                } else if (FileReader) {
                    reader = new FileReader();
                    reader.onload = function(e) {
                        done(reader.result);
                    };
                    reader.readAsDataURL(file);
                }
            }
        });

        modal._element.addEventListener('shown.bs.modal', function() {
            cropper = new Cropper(image, {
                aspectRatio: 1,
                viewMode: 3,
            });
        });

        modal._element.addEventListener('hidden.bs.modal', function() {
            cropper.destroy();
            cropper = null;
        });

        document.getElementById('cropButton').addEventListener('click', function() {
            var canvas;

            if (cropper) {
                canvas = cropper.getCroppedCanvas({
                    width: 300,
                    height: 300,
                });

                canvas.toBlob(function(blob) {
                    var url = URL.createObjectURL(blob);
                    var reader = new FileReader();
                    reader.readAsDataURL(blob);
                    reader.onloadend = function() {
                        var base64data = reader.result;
                        document.getElementById('croppedImage').value = base64data;
                        modal.hide();
                        toastr.success('Imagen recortada correctamente');
                    };
                    reader.onerror = function() {
                        toastr.error('Ocurrió un error al recortar la imagen');
                    };
                } , 'image/png');
            } else {
                toastr.error('No se pudo recortar la imagen');
            }
        });
    </script>

@endsection
