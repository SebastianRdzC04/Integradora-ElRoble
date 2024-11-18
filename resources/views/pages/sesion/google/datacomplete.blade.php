@extends('layouts.formslogin')

@section('title')
    Inicio de sesión
@endsection

@section('title form')

    Hola {{$user->user["given_name"]}} Completa tus datos para iniciar sesion
@endsection

@section('subtitle form')
    <h7>Esto es usado para enviar tus cotizaciones</h7>
@endsection

@section('form')
    <form method="POST" action="{{Route('registergoogle.store',['user' => $user])}}">
        <div class="form-floating mb-3">
            <input type="text" name="phone" id="phone" class="form-control" maxlength="10" pattern="\d{10}" title="Ingresa un número de 10 dígitos" required>
            <label for="phone">Ingresa tu Telefono</label>
        </div>
        
        <div class="form-floating mb-3">
            <input type="date" name="birthdate" id="birthdate" class="form-control" required>
            <label for="birthdate">Fecha de Nacimiento</label>
        </div>
        
        <div class="form-floating mb-3">
            <select name="gender" id="gender" class="form-control">
                <option value="Otro">Otro</option>
                <option value="Masculino">Masculino</option>
                <option value="Femenino">Femenino</option>
            </select>
            <label for="gender">Género</label>
        </div>

        <button type="submit" class="btn btn-success w-100">Registrar</button>

    </form>
@endsection