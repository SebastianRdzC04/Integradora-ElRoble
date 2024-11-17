@extends('layouts.dashboardAdmin')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/dashboard/graphs.css') }}">
@endsection

@section('title', 'Graficos')


@section('content')
    <div>
        <h3>Aqui iran los graficos</h3>
    </div>
    <div id="grafico1"></div>

    <div id="grafico2"></div>
@endsection

@php
    use Carbon\Carbon;

    $datos = [];

    foreach ($places as $place) {
        $datos[] = [
            'name' => $place->name,
            'value' => $place->quotes->count(),
        ];
    }
    

    /*
    {
    data: [120, 200, 150, 80, 70, 110, 130],
    type: 'bar',
    stack: 'a',
    name: 'a'
  }, 
    */

    

@endphp


@section('scripts')

    <script src="https://cdn.jsdelivr.net/npm/echarts@5.5.1/dist/echarts.min.js"></script>

    <script>
        let datos = @json($datos);
        let datos2 = @json($datos2);
        console.log(datos2);
    </script>

    <script src="{{ asset('js/dashboard/graphs.js') }}"></script>
@endsection
