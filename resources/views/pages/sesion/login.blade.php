<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="{{asset('css/bootstrap.css')}}">
    <link rel="stylesheet" href="{{asset('css/globalstyles.css')}}">
    <style>
        
        .background-image {
            position: fixed; 
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url("{{ asset('js/images/El roble photo1.jpg') }}");
            background-size: cover;  
            background-position: center; 
            background-repeat: no-repeat; 
            filter: blur(8px); 
            z-index: -1; 
        }

        
    </style>
</head>
<body class="d-flex align-items-center justify-content-center" style="margin: 0;height: 100vh; overflow: hidden; min-height: 100vh;">
    <div class="background-image"></div>
    <div class="container d-flex justify-content-center content">
        <div class="card shadow-lg border-0 rounded" style="width: 100%; max-width: 400px; background-color: #3a3822f7;">
            <div class="card-body">

                <div class="d-flex justify-content-center mb-3">
                    
                    <img src="{{asset('js\images\El roble.jpg') }}" class="img-login" alt="Descripción de la imagen">
                    
                </div>

                <div class="text-center mb-4">
                    <h5>Iniciar sesion o crear cuenta</h5>
                    <h7>Para poder enviar tus cotizaciones</h7>
                </div>
                
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
            </div>
        </div>
    </div>

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
    
    <script src="{{asset('js/bootstrap.min.js')}}"></script>
</body>
</html>
