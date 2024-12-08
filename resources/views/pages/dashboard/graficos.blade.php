@php
    use Carbon\Carbon;
@endphp

@extends('layouts.dashboardAdmin')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/dashboard/graphs.css') }}">
@endsection

@section('title', 'Graficos')


@section('content')

    <div class="container">
        <div class="row">
            <div class="col-12 border">
                <div class="d-flex align-items-center">
                    <h1 class="ms-auto">Ingresos Mensuales</h1>
                    <div class="ms-auto">
                        <form id="profitsYear" action="{{route('dashboard.graphics.profits')}}" method="GET" onsubmit="updateGraph3Form(this); return false;">
                            <select name="year" id="year" class="form-select">
                                <option value="{{ Carbon::now()->year + 1 }}">{{ Carbon::now()->year + 1 }}</option>
                                @for ($i = Carbon::now()->year; $i >= Carbon::now()->year - 5; $i--)
                                    <option value="{{ $i }}" {{ Carbon::now()->year == $i ? 'selected' : '' }}>
                                        {{ $i }}</option>
                                @endfor
                            </select>
                        </form>
                    </div>
                </div>
                <div class="d-flex justify-content-center">
                    <div id="grafico1"></div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-6 border">
                <h1 class="text-center">Lugar por cotizacion</h1>
                <div class="d-flex justify-content-center">
                    <div id="grafico2"></div>
                </div>
            </div>
            <div class="col-6 border">
                <h1 class="text-center">Renta de paquetes</h1>
                <div class="d-flex justify-content-center">
                    <div id="grafico3"></div>
                </div>
            </div>
        </div>
    </div>


@endsection

@php

    $datos = [];


    foreach ($places as $place) {
        $datos[] = [
            'name' => $place->name,
            'value' => $place->quotes->count() ,
        ];
    }
@endphp


@section('scripts')

    <script src="https://cdn.jsdelivr.net/npm/echarts@5.5.1/dist/echarts.min.js"></script>

    <script>
        let datos = @json($datos);
        let datos2 = @json($datos2);
        let datos3 = @json($ingresosPorMes);
    </script>

    <script src="{{ asset('js/dashboard/graphs.js') }}"></script>
@endsection
