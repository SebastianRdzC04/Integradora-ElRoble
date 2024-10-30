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
                <h3 class="text-center mb-4">Iniciar Sesión</h3>
                
                <form action="{{route('login')}}" method="post">
                    @csrf

                    <div class="form-floating mb-3">
                        <input type="email" id="email" name="email" class="form-control" placeholder="name@example.com" required>
                        <label for="email">Correo Electrónico</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="password" id="password" name="password" class="form-control" placeholder="Contraseña" required>
                        <label for="password">Contraseña</label>
                    </div>

                    <div class="d-grid mb-3">
                        <button type="submit" class="btn" style="background-color: #af6400b3;">Iniciar Sesión</button>
                    </div>

                    <div class="text-center">
                        <a href="{{route('registerperson.create')}}" class="text-decoration-none">¿No tienes cuenta? ¡Regístrate aquí!</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="{{asset('js/bootstrap.min.js')}}"></script>
</body>
</html>
