@extends('layouts.list')

@section('title')Lista de personas Registradas
@endsection
@section('head')
<script>addEventListener()</script>
@endsection

@section('columns')
<div class="container mt-5">
    <h2 class="text-center mb-4">Lista de Personas Registradas</h2>

    <div class="table-responsive text-break">
        <table class="table table-striped table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>A</th>
                    <th>Folio</th>
                    <th>Nombre</th>
                    <th>Apellidos</th>
                    <th>Cumpleaños</th>
                    <th>Género</th>
                    <th>Teléfono</th>
                    <th>Edad</th>
                    <th>Fecha de Registro</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($people as $person)
                    <tr>
                        <td><button type="button" class="btn btn-outline-danger">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
                    <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47M8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5"></path>
                </svg>
                        Button</button>
                        </td>
                        <td>{{$person->id}}</td>
                        <td>{{$person->firstName}}</td>
                        <td>{{$person->lastName}}</td>
                        <td>{{$person->birthdate}}</td>
                        <td>{{$person->gender}}</td>
                        <td>{{$person->phone}}</td>
                        <td>{{$person->age}}</td>
                        <td>{{$person->created_at}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>


