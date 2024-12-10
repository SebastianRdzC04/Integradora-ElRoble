@extends('layouts.formslogin')

@section('title')
    Verificación de teléfono
@endsection

@section('link')
    <style>
        /* Estilos personalizados */
        .code-input {
            width: 50px;
            height: 50px;
            text-align: center;
            font-size: 1.5rem;
            margin-right: 5px;
            border: 1px solid #ccc;
            border-radius: 8px;
        }

        input[type="number"]::-webkit-inner-spin-button,
        input[type="number"]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        input[type="number"] {
            -moz-appearance: textfield;
            appearance: textfield;
        }

        .d-flex {
            display: flex;
        }

        .btn-custom {
            padding: 12px 20px;
            border: none;
            color: #fff;
            font-weight: bold;
            border-radius: 5px;
            text-align: center;
            transition: background-color 0.3s;
        }

        .btn-primary-custom {
            background-color: #6a4d1b;
        }

        .btn-primary-custom:hover {
            background-color: #5c4116;
        }

        .btn-secondary-custom {
            background-color: #af6400b3;
        }

        .btn-secondary-custom:hover {
            background-color: #9a5800;
        }

        .resend-section {
            margin-top: 10px;
            text-align: center;
        }
    </style>
@endsection

@section('title form')
    Verifica tu teléfono
@endsection

@section('subtitle form')
    <p>Te hemos enviado un código de verificación a tu número de teléfono. Por favor, revisa tu bandeja de entrada.</p>
@endsection

@section('form')
    <div class="text-center mb-3">
        <a href="/" class="text-decoration-none">Verificar más tarde</a>
    </div>

    <label for="code" class="form-label">Código de verificación:</label>

    <form method="POST" id="verificarotp" action="{{ route('verify.otp') }}">
        @csrf
        <div class="d-flex justify-content-center mb-3">
            @for ($i = 1; $i <= 6; $i++)
                <input type="number" name="code{{ $i }}" id="code{{ $i }}" 
                       class="code-input" maxlength="1" required autocomplete="off" inputmode="numeric">
            @endfor
        </div>

        <div class="d-flex justify-content-center mb-3">
            <button id="btnverifyotp" class="btn-custom btn-primary-custom">
                Verificar Código
            </button>
        </div>
    </form>

    <div class="resend-section">
        <form id="resendForm" action="{{ route('send.otp') }}" method="POST">
            @csrf
            <button type="button" id="resendButton" class="btn-custom btn-secondary-custom">
                <span id="countdownText">Reenviar código de verificación</span>
            </button>
        </form>
    </div>

    <div class="text-center mt-3">
        <a href="javascript:window.history.back();" class="text-decoration-none">Verificar con email</a>
    </div>
@endsection

@section('script')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const waitTime = 60; // Segundos de espera
    const resendButton = document.getElementById('resendButton');
    const countdownText = document.getElementById('countdownText');
    const resendForm = document.getElementById('resendForm');
    let countdownInterval;
    let savedEndTime = localStorage.getItem('phoneTimerEndTime');

    // Iniciar temporizador
    function startTimer() {
        const endTime = Date.now() + waitTime * 1000; // Tiempo final en milisegundos
        localStorage.setItem('phoneTimerEndTime', endTime); // Guardar el tiempo final en localStorage
        savedEndTime = endTime;
        updateCountdown(); // Actualizar contador inmediatamente
    }

    // Actualizar la cuenta regresiva
    function updateCountdown() {
        const now = Date.now();
        const timeLeft = Math.max(0, Math.floor((savedEndTime - now) / 1000)); // Calcular segundos restantes

        if (timeLeft > 0) {
            resendButton.disabled = true; // Desactivar botón de reenviar
            countdownText.textContent = `Siguiente reenvío en (${Math.floor(timeLeft / 60)}:${String(timeLeft % 60).padStart(2, '0')})`; // Mostrar tiempo restante
        } else {
            clearInterval(countdownInterval); // Detener el intervalo del temporizador
            resendButton.disabled = false; // Habilitar botón de reenviar
            countdownText.textContent = 'Reenviar código de verificación'; // Restablecer el texto
            localStorage.removeItem('phoneTimerEndTime'); // Limpiar el tiempo guardado
        }
    }

    // Evento para reenviar el código
    resendButton.addEventListener('click', (event) => {
        if (!resendButton.disabled) { // Solo enviar si el botón no está deshabilitado
            startTimer(); // Iniciar el temporizador
            resendForm.submit(); // Enviar el formulario para reenviar el código
        }
    });

    // Si hay un temporizador activo (tiempo guardado en localStorage), se inicia automáticamente
    if (savedEndTime) {
        updateCountdown(); // Iniciar la cuenta regresiva inmediatamente al cargar la página
        countdownInterval = setInterval(updateCountdown, 1000); // Actualizar cada segundo
    } else {
        countdownText.textContent = 'Reenviar código de verificación'; // Texto por defecto cuando no hay temporizador activo
    }
});

</script>
@endsection
