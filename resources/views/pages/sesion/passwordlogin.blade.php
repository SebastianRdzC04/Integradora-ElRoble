@extends('layouts.formslogin')
                
@section('title form') 
Iniciar Sesión 
@endsection
                
@section('form')
                <form action="{{route('login.store')}}" method="post">
                    @csrf
                    <div class="form-floating mb-3">
                        <input type="email" id="email" name="email" value="{{$input}}" class="form-control" readonly>
                        <label for="email">Correo Electronico:</label>
                    </div>

                    <div class="input-group">
                        <div class="form-floating mb-3" id="passwordField" style="display:true;">
                            <input type="password" name="password" id="password" class="form-control" required minlength="8" autocomplete="new-password">
                            <label for="password">Escribe tu contraseña</label>
                        </div>
                        <button class="input-group-text mb-3" type="button" id="butoneye">
                            <svg id="eyeclose" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                <g fill="none" stroke="black" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                                    <path d="M15 12a3 3 0 1 1-6 0a3 3 0 0 1 6 0"/>
                                    <path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7s-8.268-2.943-9.542-7"/>
                                </g>
                            </svg>
                            <svg id="eyeopen" style="display: none;" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                <path fill="none" stroke="black" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                d="M3 10a13.4 13.4 0 0 0 3 2.685M21 10a13.4 13.4 0 0 1-3 2.685m-8 1.624L9.5 16.5m.5-2.19a10.6 10.6 0 0 0 4 0m-4 0a11.3 11.3 0 0 1-4-1.625m8 1.624l.5 2.191m-.5-2.19a11.3 11.3 0 0 0 4-1.625m0 0l1.5 1.815M6 12.685L4.5 14.5"/>
                            </svg>
                        </button>
                    </div>

                    <div class="form-floating d-flex mb-3">
                        <input type="checkbox" id="remember" name="remember">
                        <p for="remember">Recuerdame</p>
                    </div>

                    <a href="{{route('password.request')}}">¿Olvidaste la contraseña?</a>

                    <div class="d-grid mb-3">
                        <button type="submit" class="btn" style="background-color: #af6400b3;">Iniciar Sesion</button>
                    </div>
                </form>
@endsection

@section('script')
<script>
        document.getElementById('butoneye').addEventListener('click', function() {
            var eyeClose = document.getElementById('eyeclose');
            var eyeOpen = document.getElementById('eyeopen');
            
    // Alternar la visibilidad de los iconos
    if (eyeClose.style.display === 'none') {
        eyeClose.style.display = 'block';
        eyeOpen.style.display = 'none';
    } else {
        eyeClose.style.display = 'none';
        eyeOpen.style.display = 'block';
    }
    

    //ocultar y mostrar la contrasena
    var passwordField = document.getElementById('password');
    if (passwordField.type === 'password') {
        passwordField.type = 'text'; 
    } else {
        passwordField.type = 'password';
        
    }
});

    </script>    
@endsection

