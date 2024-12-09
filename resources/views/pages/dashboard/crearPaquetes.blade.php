@extends('layouts.dashboardAdmin')

@section('title', 'Agregar Paquete')

@section('styles')

@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-8">
                <div class="form">
                    <form action="{{ route('dashboard.create.package') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="lugar">Lugar</label>
                            <select name="lugar" class="form-select" id="">
                                <option value="">Selecciona una opcion</option>
                                @foreach ($places as $place)
                                    <option value="{{ $place->id }}">{{ $place->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" name="nombre">
                        </div>
                        <div class="mb-3">
                            <label for="precio" class="form-label">Precio</label>
                            <input type="number" class="form-control" name="precio">
                        </div>
                        <div class="mb-3">
                            <label for="afore">Maximo de Personas</label>
                            <input type="number" class="form-control" name="afore">
                        </div>
                        <div class="mb-3 d-flex">
                            <div class="col-6">
                                <label for="fechaInicio" class="form-label">Fecha de Inicio</label>
                                <input type="date" class="form-control" name="fechaInicio">
                            </div>
                            <div class="col-6">
                                <label for="fechaFin" class="form-label">Fecha de Fin</label>
                                <input type="date" class="form-control" name="fechaFin">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripcion</label>
                            <textarea name="descripcion" id="" cols="30" rows="7" class="form-control"></textarea>
                        </div>
                        <div class="mb-3 d-flex justify-content-end">
                            <button class="btn btn-primary">Enviar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')

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

@endsection
