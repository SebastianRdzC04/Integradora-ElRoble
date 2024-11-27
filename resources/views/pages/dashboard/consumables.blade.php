@extends('layouts.dashboardAdmin')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/dashboard/consumables.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap5.min.css">
@endsection

@section('title', 'Consumables')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-6">

            </div>
            <div class="col-6">
                <h4>Predeterminados por evento</h4>
                <div class="table-responsive">
                    <table class="table shadow">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Cantidad</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($consumablesDefault as $item)
                                <tr>
                                    <td>{{ $item->consumable->name }}</td>
                                    <td>{{ $item->quantity }}{{ $item->consumable->unit }}</td>
                                    <td>
                                        <form action="{{route('dashboard.delete.consumable.default', $item->id)}}" method="POST">
                                            @csrf
                                            <button class="btn btn-outline-danger p-1 m-0" type="submit"><i
                                                    class="bi bi-trash3"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-10">
                <div class="table-resposive">
                    <table class="table shadow" id="consumables-table">
                        <thead>
                            <tr>
                                <th class="text-center">Nombre</th>
                                <th class="text-center">Descripcion</th>
                                <th class="text-center">Stock Minimo</th>
                                <th class="text-center">Stock Actual</th>
                                <th class="text-center">Stock Maximo</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($consumables as $item)
                                <tr>
                                    <td class="text-center">{{ $item->name }}</td>
                                    <td class="text-center"> {{ $item->description }} </td>
                                    <td class="text-center"> {{ $item->minimum_stock }}{{ $item->unit }} </td>
                                    <td class="text-center"> {{ $item->stock }}{{ $item->unit }} </td>
                                    <td class="text-center"> {{ $item->maximum_stock }}{{ $item->unit }} </td>
                                    <td class="text-center">
                                        <div>
                                            <button class="btn btn-outline-primary p-1 m-0" data-bs-toggle="modal"
                                                data-bs-target="#agregarModal{{ $item->id }}">
                                                <i class="bi bi-plus-circle-fill"></i>
                                            </button>
                                            <div class="modal fade" id="agregarModal{{ $item->id }}">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h3>Agregar stock</h3>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form
                                                                action="{{ route('dashboard.consumable.add.stock', $item->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                <div class="mb-3">
                                                                    <label class="form-label"
                                                                        for="cantidad">Cantidad</label>
                                                                    <input class="form-control" type="number"
                                                                        name="cantidad" id="cantidad">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="precio">Precio</label>
                                                                    <input class="form-control" type="number"
                                                                        name="precio" id="precio">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <button class="btn btn-primary">Enviar</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <a class="btn btn-outline-primary p-1 m-0" href=""><i
                                                    class="bi bi-pencil-square"></i></a>
                                            <a class="btn btn-outline-danger p-1 m-0" href=""><i
                                                    class="bi bi-trash3"></i></a>
                                            @if (!$item->consumableEventDefault)
                                                <button class="btn btn-outline-success p-1 m-0" data-bs-toggle="modal"
                                                    data-bs-target="#predModal{{ $item->id }}"><i
                                                        class="bi bi-star"></i></button>
                                            @endif


                                            <div class="modal fade" id="predModal{{ $item->id }}">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h3>Agregar a predeterminados</h3>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="{{ route('dashboard.add.consumable.default') }}"
                                                                method="POST">
                                                                @csrf
                                                                <input type="hidden" name="consumable_id"
                                                                    value="{{ $item->id }}">
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="cantidad">Ingresa la
                                                                        cantidad</label>
                                                                    <input class="form-control" type="number"
                                                                        name="cantidad" id="cantidad">
                                                                </div>
                                                                <div>
                                                                    <button class="btn btn-primary">Confirmar</button>
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
    </div>


@endsection

@section('scripts')

    <script src="{{ asset('js/dashboard/consumables.js') }}"></script>
@endsection
