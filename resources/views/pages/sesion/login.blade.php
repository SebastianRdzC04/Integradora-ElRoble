<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    
    <form action="{{route('login')}}" method="post">
        @csrf
        <label for="email">Correo Electronico: </label>
        <input type="text" id="email" name="email">
        <label for="password">Contraseña:</label>
        <input type="text" id="password" name="password">
        <a href="{{route('registerperson.create')}}">Registrate!!!!!!!!!!</a>
        <button type="submit">Iniciar Sesion</button>
    </form>
</body>
</html>
