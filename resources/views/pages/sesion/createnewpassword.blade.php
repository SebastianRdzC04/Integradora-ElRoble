@extends('layouts.formslogin')

@section('title form')
    Restablecimiento de contraseña
@endsection

@section('subtitle form')
    Escribe la nueva contraseña de tu cuenta
@endsection
    
@section('form')
                <form id="loginForm" action="{{ route('password.update') }}" method="post">
                    @csrf
                    
                    <input type="hidden" name="token" value="{{ request()->route('token') }}">
                    
                    <div class="form-floating mb-3">
                        <input type="text" id="email" name="email" class="form-control" placeholder="name@example.com" required value="{{session('email')}}" readonly>
                        <label for="email">Correo Electrónico</label>
                    </div>
                    
                    <div class="form-floating mb-3">
                        <input type="password" id="password" name="password" class="form-control" placeholder="name@example.com" required>
                        <label for="password">Nueva Contraseña</label>
                    </div>
                    
                    <div class="form-floating mb-3">
                        <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="Confirma tu contraseña" required>
                        <label for="password_confirmation">Confirma tu contraseña</label>
                    </div>
                    
                    <div class="d-grid mb-3">
                        <button type="submit" class="btn" style="background-color: #af6400b3;">Restablecer Contraseña</button>
                    </div>
                </form>
                    
@endsection

@section('script')
    <script>
        document.getElementById('loginForm').onsubmit = function(event) {
            const input = document.getElementById('email').value;
            const email = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            let isValid = false;

                isValid = email.test(input);


            if (!isValid) {
                event.preventDefault();
                document.getElementById('email').classList.add('is-invalid');
            } else {
                document.getElementById('email').classList.remove('is-invalid');
            }
        };
    </script>
@endsection
