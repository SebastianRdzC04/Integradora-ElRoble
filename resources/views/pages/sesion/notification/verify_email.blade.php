@extends('layouts.formslogin')

@section('title')
verificación de correo
@endsection

@section('title form')
Verifica tu Email
@endsection

@section('subtitle form')
Te hemos enviado un enlace de verificación a tu correo electrónico. Por favor, revisa tu bandeja de entrada.
@endsection

@section('form')
    <form action="{{ route('verification.send') }}" method="POST">
        @csrf
        <div class="d-grid mb-3">
            <button type="submit" class="btn" style="background-color: #af6400b3;">Reenviar enlace de verificación</button>
        </div>
    </form>
@endsection