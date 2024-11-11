@extends('layouts.formslogin')
                
@section('title form') 
Iniciar Sesión 
@endsection
                
@section('form')
                <form action="{{route('login.store')}}" method="post">
                    @csrf
                    <div class="form-floating mb-3">
                        <input type="email" id="email" name="email" value="{{$email}}" class="form-control" readonly>
                        <label for="email">Correo Electronico:</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="password" id="password" name="password" class="form-control" placeholder="contraseña" required>
                        <label for="password">Contraseña:</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="checkbox" id="remember" name="remember">
                        <label for="remember">Recuerdame</label>
                    </div>

                    <a href="{{route('password.request')}}">¿Olvidate la contraseña?</a>

                    <div class="d-grid mb-3">
                        <button type="submit" class="btn" style="background-color: #af6400b3;">Iniciar Sesion</button>
                    </div>
                </form>
@endsection

