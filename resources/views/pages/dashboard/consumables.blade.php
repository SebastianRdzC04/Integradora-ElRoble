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
                <a href="{{ route('consumables.create') }}" class="btn btn-primary">Agregar</a>
            </div>
            <div class="col-6 d-flex justify-content-end">
                <a href="" type="button" class="btn btn-primary text-end" data-bs-toggle="modal"
                    data-bs-target="#modalPredeterminados">Ver predeterminados</a>
            </div>
            <div class="modal fade" id="modalPredeterminados" aria-labelledby="modalLabel1" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4>Predeterminados por evento</h4>
                        </div>
                        <div class="modal-content">
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
                                                    <form
                                                        action="{{ route('dashboard.delete.consumable.default', $item->id) }}"
                                                        method="POST">
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
                                        <div class="d-flex">
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
                                            <a class="btn btn-outline-primary p-1 m-0" href="" data-bs-toggle="modal" data-bs-target="#editModal{{$item->id}}"><i
                                                    class="bi bi-pencil-square"></i></a>
                                            <div class="modal fade" id="editModal{{$item->id}}">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4>Editar Consumible</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="{{route('dashboard.consumable.edit', $item->id)}}" method="POST">
                                                                @csrf
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="nombre">Editar Nombre</label>
                                                                    <input class="form-control" type="text" name="nombre_edit" id="nombre" value="{{$item->name}}">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="nombre">Editar Descripcion</label>
                                                                    <input class="form-control" type="text" name="descripcion_edit" id="descripcion_edit" value="{{$item->description}}">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="nombre">Editar Unidades</label>
                                                                    <input class="form-control" type="text" name="unidad_edit" id="unidad_edit" value="{{$item->unit}}">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="nombre">Editar Stock Minimo</label>
                                                                    <input class="form-control" type="text" name="stock_min_edit" id="stock_min_edit" value="{{$item->minimum_stock}}">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="nombre">Editar Stock Maximo</label>
                                                                    <input class="form-control" type="text" name="stock_max_edit" id="stock_max_edit" value="{{$item->maximum_stock}}">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <button class="btn btn-primary">Enviar</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <form action="{{ route('dashboard.consumable.delete', $item->id) }}" method="POST">
                                                @csrf
                                                <button class="btn btn-outline-danger p-1 m-0">
                                                    <i class="bi bi-trash3"></i></button>
                                            </form>
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
