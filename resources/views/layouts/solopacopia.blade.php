@extends('layouts.formslogin')

@section('title')
    Verificación de correo
@endsection

@section('title form')
    Verifica tu Email
@endsection

@section('subtitle form')
        <p>Te hemos enviado un enlace de verificación a tu correo electrónico. Por favor, revisa tu bandeja de entrada.</p>
@endsection

@section('form')
    <a href="/">Verificar más tarde</a>
    
    <form id="resendForm" action="{{ route('verification.send') }}" method="POST">
        @csrf
        
        <div class="d-flex col mb-3">
            <div class="col-6">
                <button class="btn">Verificar numero de telefono</button>
            </div>
            <div class="col-6">
                <button type="submit" class="btn" id="resendButton" style="background-color: #af6400b3;">
                    <span id="countdownText">Reenviar enlace de verificación</span>
                </button>
            </div>
        </div>

        <div class="form-group">
            <label for="recaptcha">Verificación de reCAPTCHA</label>
            <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.site_key') }}"></div>
        </div>

    </form>
    
@endsection

@section('script')
    <script>
        const waitTime = 60;
        const countdownText = document.getElementById('countdownText');
        const resendForm = document.getElementById('resendForm');
        const resendButton = document.getElementById('resendButton');

        const endTime = localStorage.getItem('endTime') || (Date.now() + waitTime * 1000);
        localStorage.setItem('endTime', endTime);

        function updateCountdown() {
            const now = Date.now();
            const timeLeft = Math.max(0, Math.floor((endTime - now) / 1000));

            if (timeLeft > 0) {
                resendButton.disabled = true;
                countdownText.textContent = `Siguiente reenvio... (${Math.floor(timeLeft / 60)}:${String(timeLeft % 60).padStart(2, '0')})`;
            } else {
                clearInterval(countdownInterval);
                localStorage.removeItem('endTime');
                resendButton.disabled = false;
                countdownText.textContent = 'Reenviar enlace de verificación';
            }
        }

        // Actualizar el contador cada segundo
        const countdownInterval = setInterval(updateCountdown, 1000);
        updateCountdown();
    </script>
@endsection
