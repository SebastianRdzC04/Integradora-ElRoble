@extends('layouts.list')
@include('layouts.sidebar')
@section('title') Lista de Personas Registradas @endsection

@section('tabletitle') Lista de Personas Registradas @endsection

@section('columns')
    <thead class="thead-dark">
        <tr>
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
            <tr class="selectable-row" data-id="{{ $person->id }}">
                <td>{{ $person->id }}</td>
                <td>{{ $person->firstName }}</td>
                <td>{{ $person->lastName }}</td>
                <td>{{ $person->birthdate }}</td>
                <td>{{ $person->gender }}</td>
                <td>{{ $person->phone }}</td>
                <td>{{ $person->age }}</td>
                <td>{{ $person->created_at }}</td>
            </tr>
        @endforeach
    </tbody>
@endsection

@section('script')
<script>
    document.querySelectorAll('.selectable-row').forEach(row => {
        row.addEventListener('click', function() {
            currentDeleteId = this.getAttribute('data-id'); // Obtiene el ID del registro
            $('#confirmModal').modal('show'); // Muestra el modal
        });
    });
</script>
@endsection
