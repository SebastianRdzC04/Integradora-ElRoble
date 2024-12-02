@extends('layouts.dashboardAdmin')

@section('title', 'Users')

@section('styles')

@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="table-responsive">
                <table class="table shadow" id="users-table">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>Email</th>
                            <th>Telefono</th>
                            <th>Genero</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td> {{ $user->person->first_name }} </td>
                                <td> {{ $user->person->last_name }} </td>
                                <td> {{ $user->email }} </td>
                                <td> {{ $user->person->phone }} </td>
                                <td> {{ $user->person->gender }} </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/dashboard/users.js') }}"></script>
@endsection
