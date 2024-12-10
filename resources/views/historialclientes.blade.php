@extends('layouts.appaxel')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/stylesinicio.css') }}">
@endsection

@section('content')
<div style="margin-top: 100px;" class="container">
    <h1 style="color: black;" class="text-center">Historial de Cotizaciones y Eventos</h1>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        @foreach($quotes as $quote)
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-body">
                    <h3 class="card-title">Cotización #{{ $quote->id }}</h3>
                    <p><strong>Fecha:</strong> {{ $quote->date }}</p>
                    <p><strong>Lugar:</strong> {{ $quote->place->name }}</p>
                    <p><strong>Estado:</strong> {{ $quote->status }}</p>
                    <p><strong>Precio Estimado:</strong> ${{ $quote->estimated_price }}</p>
                    <p><strong>Tipo de Evento:</strong> {{ $quote->type_event }}</p>
                    <p><strong>Invitados:</strong> {{ $quote->guest_count }}</p>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalServicios{{ $quote->id }}">
                        Ver Servicios
                    </button>
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
                    <form action="{{ route('pagar') }}" method="POST">
                        @csrf
                        <input type="hidden" name="quote_id" value="{{ $quote->id }}">
                        <input type="hidden" name="amount" value="{{ $quote->espected_advance }}">
                        <script
                            src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                            data-key="{{ env('STRIPE_KEY') }}"
                            data-amount="{{ $quote->espected_advance * 100 }}"
                            data-name="Pago de Adelanto"
                            data-description="Adelanto Cotización #{{ $quote->id }}"
                            data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
                            data-locale="auto"
                            data-currency="mxn">
                        </script>
                    </form>
                    @endif
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="modalServicios{{ $quote->id }}" tabindex="-1" aria-labelledby="modalServiciosLabel{{ $quote->id }}" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalServiciosLabel{{ $quote->id }}">Servicios de la Cotización #{{ $quote->id }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            @foreach($quote->services as $service)
                            <div class="col-md-4">
                                <div class="card mb-4">
                                    <img src="{{ $service->image_path ?? $service->serviceCategory->image_path ?? asset('images/imagen6.jpg') }}" class="card-img-top" alt="{{ $service->name }}">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $service->name }}</h5>
                                        <p class="card-text">{{ $service->description }}</p>
                                        <p class="card-text"><strong>Precio:</strong> ${{ $service->price }}</p>
                                        <p class="card-text"><strong>Detalles Especificados:</strong> {{ $service->pivot->description }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <div class="pagination justify-content-center">
        {{ $quotes->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection