@extends('layouts.appaxel')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/stylesinicio.css') }}">
@endsection

@section('content')
<div class="container">
    <h1>Historial de Cotizaciones y Eventos</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row">
        @foreach($quotes as $quote)
        <div class="col-md-4">
            <div class="quote-card {{ str_replace(' ', '-', strtolower($quote->status)) }}">
                <h3>Cotización #{{ $quote->id }}</h3>
                <p><strong>Fecha:</strong> {{ $quote->date }}</p>
                <p><strong>Lugar:</strong> {{ $quote->place->name }}</p>
                <p><strong>Estado:</strong> {{ $quote->status }}</p>
                <p><strong>Precio Estimado:</strong> ${{ $quote->estimated_price }}</p>
                <p><strong>Nombre del Propietario:</strong> {{ $quote->owner_name }}</p>
                <p><strong>Teléfono del Propietario:</strong> {{ $quote->owner_phone }}</p>
                <p><strong>Tipo de Evento:</strong> {{ $quote->type_event }}</p>
                <p><strong>Invitados:</strong> {{ $quote->guest_count }}</p>
                @if($quote->status == 'pendiente')
                <form action="{{ route('pagar') }}" method="POST">
                    @csrf
                    <input type="hidden" name="quote_id" value="{{ $quote->id }}">
                    <input type="hidden" name="amount" value="{{ $quote->estimated_price }}">
                    <script
                        src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                        data-key="{{ env('STRIPE_KEY') }}"
                        data-amount="{{ $quote->estimated_price * 100 }}"
                        data-name="Pago de Cotización"
                        data-description="Cotización #{{ $quote->id }}"
                        data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
                        data-locale="auto"
                        data-currency="mxn">
                    </script>
                </form>
                @endif
            </div>
        </div>
        @endforeach
    </div>
    <div class="pagination">
        {{ $quotes->links() }}
    </div>
</div>
@endsection