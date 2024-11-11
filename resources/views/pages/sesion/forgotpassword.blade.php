@extends('layouts.formslogin')

@section('title form') 
Recuperacion de cuenta</h5>
@endsection

@section('subtitles form')
Introduce tu email para enviarte un correo de verificacion
@endsection
                
@section('form')
                <form id="loginForm" action="{{ route('password.email') }}" method="post">
                    @csrf

                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                        </div>
                    @elseif ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @else

                    <div class="form-floating mb-3">
                        <input type="text" id="email" name="email" class="form-control" placeholder="name@example.com" required>
                        <label for="email">Correo Electrónico</label>
                    </div>
                    @endif
                    
                    <div class="d-grid mb-3">
                        <button type="submit" class="btn" style="background-color: #af6400b3;">Siguiente</button>
                    </div>

                </form>
@endsection
@section('script')
    <script>
        document.getElementById('loginForm').onsubmit = function(event) {
            const input = document.getElementById('email').value;
            const email = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            let isValid = false;

                isValid = email.test(input);


            if (!isValid) {
                event.preventDefault();
                document.getElementById('email').classList.add('is-invalid');
            } else {
                document.getElementById('email').classList.remove('is-invalid');
                this.action = this.action.replace('PLACEHOLDER', encodeURIComponent(input));
            }
        };
    </script>
@endsection
