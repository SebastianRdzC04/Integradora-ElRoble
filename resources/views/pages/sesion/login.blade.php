@extends('layouts.formslogin')

@section('title')
    Inicio de sesión
@endsection

@section('title form')
    Iniciar sesión o crear cuenta
@endsection

@section('subtitle form')
    <h7>Para poder enviar tus cotizaciones</h7>
@endsection

@section('form')
    <form id="loginForm" action="{{ route('login.password', ['phoneoremail' => 'PLACEHOLDER']) }}" method="get">
        @csrf
        @if (session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <div class="form-floating mb-3">
            <input type="text" id="email" name="phoneoremail" class="form-control" placeholder="name@example.com" required>
            <label for="email">Correo Electrónico o Teléfono</label>
        </div>

        <div class="d-grid mb-3">
            <button type="submit" class="btn" style="background-color: #af6400b3;">Siguiente</button>
        </div>
    </form>
@endsection

@section('script')
    <script>
        document.getElementById('loginForm').onsubmit = function(event) {
            const input = document.getElementById('email').value;
            const email = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            const phone = /^\d{10,14}$/;
            let isValid = false;

            if (/[a-zA-Z]/.test(input)) {
                isValid = email.test(input);
            } else {
                isValid = phone.test(input);
            }

            if (!isValid) {
                event.preventDefault();
                document.getElementById('email').classList.add('is-invalid');
            } else {
                document.getElementById('email').classList.remove('is-invalid');
                this.action = this.action.replace('PLACEHOLDER', encodeURIComponent(input));
            }
        };
    </script>
@endsection


