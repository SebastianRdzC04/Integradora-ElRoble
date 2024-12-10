@extends('layouts.appaxel')

@section('styles')
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
                    <button style="font-size: 1.6rem; padding: 5px; margin: 4px;" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalServicios{{ $quote->id }}">
                        Ver Servicios
                    </button>
                    @if($quote->status == 'pendiente')
                    <form action="{{ route('pagar') }}" method="POST" id="form-pago-total-{{ $quote->id }}">
                        @csrf
                        <input type="hidden" name="quote_id" value="{{ $quote->id }}">
                        <input type="hidden" name="amount" value="{{ $quote->estimated_price }}">
                        <input type="hidden" name="stripeToken" id="stripeToken-{{ $quote->id }}">
                        <button style="font-size: 1.6rem; padding: 5px; margin: 4px;" type="button" class="btn btn-success" onclick="payWithStripe({{ $quote->estimated_price }}, 'Pago de Cotización #{{ $quote->id }}', {{ $quote->id }})">Pagar Precio Total</button>
                    </form>
                    <form action="{{ route('pagar') }}" method="POST" id="form-pago-anticipo-{{ $quote->id }}">
                        @csrf
                        <input type="hidden" name="quote_id" value="{{ $quote->id }}">
                        <input type="hidden" name="amount" value="{{ $quote->espected_advance }}">
                        <input type="hidden" name="stripeToken" id="stripeToken-{{ $quote->id }}">
                        <button style="font-size: 1.6rem; padding: 5px; margin: 4px;" type="button" class="btn btn-warning" onclick="payWithStripe({{ $quote->espected_advance }}, 'Pago de Adelanto Cotización #{{ $quote->id }}', {{ $quote->id }})">Pagar Anticipo</button>
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
                        <h5 style="font-size: 1.9rem;" class="modal-title" id="modalServiciosLabel{{ $quote->id }}">Servicios de la Cotización #{{ $quote->id }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            @foreach($quote->services as $service)
                            <div class="col-12 col-sm-6 col-md-4 mb-4">
                                <div class="card h-100">
                                    <img src="{{ $service->image_path ?? $service->serviceCategory->image_path ?? asset('images/imagen6.jpg') }}" class="card-img-top" alt="{{ $service->name }}">
                                    <div class="card-body">
                                        <p style="font-size: 1.8rem;" class="card-title text-center"><strong>{{ $service->name }}</strong></p>
                                        <p class="card-text">{{ $service->description }}</p>
                                        <p class="card-text"><strong>Precio:</strong> ${{ $service->price }}</p>
                                        <p class="card-text"><strong>Detalles Especificados:</strong> {{ $service->pivot->description }}</p>
                                    </div>
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

<script src="https://checkout.stripe.com/checkout.js"></script>
<script>
    function payWithStripe(amount, description, quoteId) {
        var handler = StripeCheckout.configure({
            key: '{{ env('STRIPE_KEY') }}',
            locale: 'auto',
            token: function(token) {
                document.getElementById('stripeToken-' + quoteId).value = token.id;
                document.getElementById('form-pago-total-' + quoteId).submit();
            }
        });

        handler.open({
            name: 'Pago de Cotización',
            description: description,
            amount: amount * 100,
            currency: 'mxn'
        });
    }
</script>
@endsection