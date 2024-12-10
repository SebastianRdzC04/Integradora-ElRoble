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

    <a href="/">Verificar más tarde</a>
    
    <form id="resendForm" action="{{ route('verification.send') }}" method="POST">
        @csrf

        <div class="d-flex col justify-content-between mb-3">
            <div class="col-5">
                <button id="btnVerifyPhone" style="background-color: #6a4d1b;" class="btn">Verificar con teléfono</button>
            </div>
            <div class="col-5">
                <button type="submit" class="btn" id="resendButton" style="background-color: #af6400b3;">
                    <span id="countdownText">Reenviar código de verificación</span>
                </button>
            </div>
        </div>
    </form>

@endsection

@section('script')
<script>
    const waitTime = 60;

    const resendButton = document.getElementById('resendButton');
    const countdownText = document.getElementById('countdownText');

    let savedEndTime = localStorage.getItem('emailTimerEndTime');

    function startTimer() {
        const endTime = Date.now() + waitTime * 1000;
        localStorage.setItem('emailTimerEndTime', endTime);
        savedEndTime = endTime;
        updateCountdown();
    }

    function updateCountdown() {
        const now = Date.now();
        const timeLeft = Math.max(0, Math.floor((savedEndTime - now) / 1000));

        if (timeLeft > 0) {
            resendButton.disabled = true;
            countdownText.textContent = `Siguiente reenvío... (${Math.floor(timeLeft / 60)}:${String(timeLeft % 60).padStart(2, '0')})`;
        } else {
            clearInterval(countdownInterval);
            resendButton.disabled = false;
            countdownText.textContent = 'Reenviar código de verificación';
            localStorage.removeItem('emailTimerEndTime');
        }
    }

    resendButton.addEventListener('click', (event) => {
        event.preventDefault();
        if (!localStorage.getItem('emailTimerEndTime')) {
            startTimer();
        } else {
            console.log("Temporizador ya activo, espera a que termine.");
        }
        document.getElementById('resendForm').submit();
    });

    if (savedEndTime) {
        updateCountdown();
    } else {
        countdownText.textContent = 'Reenviar código de verificación';
    }

    const countdownInterval = setInterval(updateCountdown, 1000);
</script>
@endsection
