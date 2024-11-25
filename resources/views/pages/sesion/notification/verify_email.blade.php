@extends('layouts.formslogin')

@section('title')
    Verificación de correo
@endsection

@section('title form')
    Verifica tu Email
@endsection

@section('subtitle form')
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @else
        <p>Te hemos enviado un enlace de verificación a tu correo electrónico. Por favor, revisa tu bandeja de entrada.</p>
    @endif
@endsection

@section('form')
    <div id="countdownContainer">
        <p id="countdownText">Puedes reenviar el enlace en: <span id="countdown"></span></p>
    </div>

    <a href="/">Verificar mas tarde</a>
    
    <form id="resendForm" action="{{ route('verification.send') }}" method="POST" style="display: none;">
        @csrf
        
        <div class="d-grid mb-3">
            <button type="submit" class="btn" id="resendButton" style="background-color: #af6400b3;">Reenviar enlace de verificación</button>
        </div>
    </form>
@endsection

@section('script')
    <script>
        const waitTime = {{ session('waitTime') ?? 120 }}; // Tiempo de espera en segundos (por defecto 120 segundos)
        const countdownText = document.getElementById('countdown');
        const resendForm = document.getElementById('resendForm');
        const resendButton = document.getElementById('resendButton');

        // Obtener el tiempo de finalización del contador desde localStorage o calcularlo
        const endTime = localStorage.getItem('endTime') || (Date.now() + waitTime * 1000);
        localStorage.setItem('endTime', endTime);

        function updateCountdown() {
            const now = Date.now();
            const timeLeft = Math.max(0, Math.floor((endTime - now) / 1000));

            // Mostrar el tiempo restante
            countdownText.textContent = `${Math.floor(timeLeft / 60)}:${String(timeLeft % 60).padStart(2, '0')}`;

            // Habilitar el botón cuando el tiempo haya terminado
            if (timeLeft <= 0) {
                clearInterval(countdownInterval);
                localStorage.removeItem('endTime');
                resendForm.style.display = 'block';
                countdownText.textContent = 'Ya puedes reenviar el enlace de verificación.';
            }
        }

        // Actualizar el contador cada segundo
        const countdownInterval = setInterval(updateCountdown, 1000);
        updateCountdown();
    </script>
@endsection