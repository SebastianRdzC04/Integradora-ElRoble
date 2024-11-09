
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="{{asset('css/bootstrap.css')}}">
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
                        <input type="email" id="email" name="email" value="{{$email}}" class="form-control" readonly>
                        <label for="email">Correo Electronico:</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="password" id="password" name="password" class="form-control" placeholder="contraseña" required>
                        <label for="password">Contraseña:</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="checkbox" id="remember" name="remember">
                        <label for="remember">Recuerdame</label>
                    </div>

                    <a href="{{route('password.request')}}">¿Olvidate la contraseña?</a>

                    <div class="d-grid mb-3">
                        <button type="submit" class="btn" style="background-color: #af6400b3;">Iniciar Sesion</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="{{asset('js/bootstrap.min.js')}}"></script>
</body>
</html>
