<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/globalstyles.css')}}">
</head>
<body class="bg-light d-flex align-items-center justify-content-center" style="min-height: 100vh;">

    <div class="container d-flex justify-content-center">
        <div class="card shadow-lg border-0 rounded" style="width: 100%; max-width: 400px; background-color: #0821036b;">
            <div class="card-body">

                <h3 class="text-center mb-4">Iniciar Sesión o Registrarse</h3>
                
                <form id="loginForm" action="{{ route('login.password', ['phoneoremail' => 'PLACEHOLDER']) }}" method="get">
                    @csrf

                    <div class="form-floating mb-3">
                        <input type="text" id="email" name="phoneoremail" class="form-control" placeholder="name@example.com" required>
                        <label for="email">Correo Electrónico o Teléfono</label>
                    </div>
                    
                    <div class="d-grid mb-3">
                        <button type="submit" class="btn" style="background-color: #af6400b3;">Siguiente</button>
                    </div>

                    <div class="text-center">
                        <a href="{{route('registerperson.create')}}" class="text-decoration-none">¿No tienes cuenta? ¡Regístrate aquí!</a>
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

            // Validación de correo electrónico
            if (/[a-zA-Z]/.test(input)) {
                // Si contiene letras, debe ser un correo electrónico válido
                isValid = email.test(input);
            } else {
                // Si no contiene letras, debe ser un número de teléfono con un largo máximo de 14
                isValid = phone.test(input);
            }

            if (!isValid) {
                event.preventDefault();
                document.getElementById('email').classList.add('is-invalid');
            } else {
                document.getElementById('email').classList.remove('is-invalid');
                // Reemplaza 'PLACEHOLDER' en la URL con el valor ingresado
                this.action = this.action.replace('PLACEHOLDER', encodeURIComponent(input));
            }
        };
    </script>
    
    <script src="{{asset('js/bootstrap.min.js')}}"></script>
</body>
</html>
