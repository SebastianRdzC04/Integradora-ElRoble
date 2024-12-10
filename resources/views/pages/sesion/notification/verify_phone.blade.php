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
        <div class="form-floating mb-3">
            <div class="row d-flex pe-3 justify-content-center">
                @for ($i = 1; $i <= 6; $i++)
                    <div class="col-2">
                        <input type="text" name="code{{ $i }}" id="code{{ $i }}" 
                               class="form-control code-input" maxlength="1" required 
                               autocomplete="off" inputmode="numeric">
                    </div>
                @endfor
            </div>
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
    const inputs = document.querySelectorAll('.code-input');
    const waitTime = 60; // Tiempo de espera en segundos
    const resendButton = document.getElementById('resendButton');
    const countdownText = document.getElementById('countdownText');
    const resendForm = document.getElementById('resendForm');
    let countdownInterval;
    let savedEndTime = localStorage.getItem('phoneTimerEndTime');

    inputs.forEach((input, index) => {
        input.addEventListener('input', (e) => {
            const value = e.target.value.replace(/[^0-9]/g, ''); 
            e.target.value = value.slice(0, 1);

            if (value && index < inputs.length - 1) {
                inputs[index + 1].focus(); 
            }
        });

        input.addEventListener('keydown', (e) => {
            if (e.key === 'Backspace' && input.value === '' && index > 0) {
                inputs[index - 1].focus(); 
            }
        });

        input.addEventListener('paste', (e) => {
            e.preventDefault();
            const pasteData = e.clipboardData.getData('text').replace(/[^0-9]/g, '').slice(0, inputs.length);
            for (let i = 0; i < pasteData.length; i++) {
                if (inputs[index + i]) {
                    inputs[index + i].value = pasteData[i];
                }
            }

            const nextInput = inputs[index + pasteData.length];
            if (nextInput) {
                nextInput.focus();
            }
        });
    });

    function startTimer() {
        const endTime = Date.now() + waitTime * 1000;
        localStorage.setItem('phoneTimerEndTime', endTime);
        savedEndTime = endTime;
        updateCountdown();
    }

    function updateCountdown() {
        const now = Date.now();
        const timeLeft = Math.max(0, Math.floor((savedEndTime - now) / 1000));

        if (timeLeft > 0) {
            resendButton.disabled = true;
            countdownText.textContent = `Siguiente reenvío en (${Math.floor(timeLeft / 60)}:${String(timeLeft % 60).padStart(2, '0')})`;
        } else {
            clearInterval(countdownInterval);
            resendButton.disabled = false;
            countdownText.textContent = 'Reenviar código de verificación';
            localStorage.removeItem('phoneTimerEndTime');
        }
    }

    resendButton.addEventListener('click', (event) => {
        if (!resendButton.disabled) {
            startTimer();
            resendForm.submit();
        }
    });

    if (savedEndTime) {
        updateCountdown();
        countdownInterval = setInterval(updateCountdown, 1000);
    } else {
        countdownText.textContent = 'Reenviar código de verificación';
    }
});
</script>
@endsection
