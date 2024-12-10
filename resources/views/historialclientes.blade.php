<!-- historialclientes.blade.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Historial de Cotizaciones</title>
    
    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://js.stripe.com/v3/"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"/>
    <script>
        // Set your publishable key
        Stripe.setPublishableKey('{{ config('services.stripe.key') }}');
    </script>
</head>
<body>
    @include('layouts.navbar_new')

    <div style="margin-top: 100px;" class="container">
        <!-- Alertas -->
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

        <!-- Sección de Cotizaciones -->
        <h2 style="color: black;" class="text-center mb-4">Cotizaciones</h2>
        <div class="row">
            @foreach($quotes as $quote)
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-body">
                        <h3 class="card-title">Cotización #{{ $quote->id }}</h3>
                        <p><strong>Fecha:</strong> {{ $quote->date }}</p>
                        <p><strong>Lugar:</strong> {{ $quote->place->name }}</p>
                        <p><strong>Estado:</strong> {{ $quote->status }}</p>
                        @if(in_array($quote->status, ['pendiente', 'cancelada', 'pagada']))
                            <p><strong>Precio Total:</strong> ${{ number_format($quote->estimated_price, 2) }}</p>
                            <p><strong>
                                @if($quote->status == 'pagada')
                                    Anticipo Brindado:
                                @else
                                    Anticipo Requerido:
                                @endif
                            </strong> ${{ number_format($quote->espected_advance, 2) }}</p>
                        @endif
                        <p><strong>Tipo de Evento:</strong> {{ $quote->type_event }}</p>
                        <p><strong>Invitados:</strong> {{ $quote->guest_count }}</p>
                        <button type="button" class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#modalServicios{{ $quote->id }}">
                            Ver Servicios
                        </button>
                        @if($quote->status == 'pendiente')
                        <form action="{{ route('pagar') }}" method="POST" class="mb-2">
                            @csrf
                            <input type="hidden" name="quote_id" value="{{ $quote->id }}">
                            <input type="hidden" name="amount" value="{{ $quote->estimated_price }}">
                            <script
                                src="https://checkout.stripe.com/checkout.js" 
                                class="stripe-button"
                                data-key="{{ config('services.stripe.key') }}"
                                data-amount="{{ $quote->estimated_price * 100 }}"
                                data-name="Pago Total"
                                data-description="Cotización #{{ $quote->id }}"
                                data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
                                data-locale="es"
                                data-label="Pagar Total"
                                data-currency="mxn">
                            </script>
                        </form>
                    
                        <form action="{{ route('pagar') }}" method="POST">
                            @csrf
                            <input type="hidden" name="quote_id" value="{{ $quote->id }}">
                            <input type="hidden" name="amount" value="{{ $quote->espected_advance }}">
                            <script
                                src="https://checkout.stripe.com/checkout.js" 
                                class="stripe-button"
                                data-key="{{ config('services.stripe.key') }}"
                                data-amount="{{ $quote->espected_advance * 100 }}"
                                data-name="Pago de Anticipo"
                                data-description="Anticipo Cotización #{{ $quote->id }}"
                                data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
                                data-locale="es"
                                data-label="Pagar Anticipo"
                                data-currency="mxn">
                            </script>
                        </form>
                    @endif
                    </div>
                </div>
            </div>
            
            <!-- Modal de Servicios -->
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
                                            <p class="card-text"><strong>Precio:</strong> ${{ number_format($service->pivot->price, 2) }}</p>
                                            <p class="card-text"><strong>Detalles:</strong> {{ $service->pivot->description }}</p>
                                            @if($service->pivot->quantity)
                                                <p class="card-text"><strong>Cantidad:</strong> {{ $service->pivot->quantity }}</p>
                                            @endif
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
        <div class="pagination justify-content-center mb-5">
            {{ $quotes->links('pagination::bootstrap-5') }}
        </div>

        <!-- Sección de Eventos -->
        <h2 style="color: black;" class="text-center mb-4">Eventos</h2>
        <div class="row">
            @foreach($events as $event)
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-body">
                        <h3 class="card-title">Evento #{{ $event->id }}</h3>
                        <p><strong>Fecha:</strong> {{ $event->quote->date }}</p>
                        <p><strong>Lugar:</strong> {{ $event->quote->place->name }}</p>
                        <p><strong>Estado:</strong> {{ $event->status }}</p>
                        <p><strong>Tipo de Evento:</strong> {{ $event->quote->type_event }}</p>
                        <p><strong>Invitados:</strong> {{ $event->quote->guest_count }}</p>
                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalEventoServicios{{ $event->id }}">
                            Ver Servicios del Evento
                        </button>
                    </div>
                </div>
            </div>

            <!-- Modal de Servicios de Evento -->
            <div class="modal fade" id="modalEventoServicios{{ $event->id }}" tabindex="-1" aria-labelledby="modalEventoServiciosLabel{{ $event->id }}" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalEventoServiciosLabel{{ $event->id }}">Servicios del Evento #{{ $event->id }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                @foreach($event->quote->services as $service)
                                <div class="col-md-4">
                                    <div class="card mb-4">
                                        <img src="{{ $service->image_path ?? $service->serviceCategory->image_path ?? asset('images/imagen6.jpg') }}" class="card-img-top" alt="{{ $service->name }}">
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $service->name }}</h5>
                                            <p class="card-text">{{ $service->description }}</p>
                                            <p class="card-text"><strong>Precio:</strong> ${{ $service->pivot->price }}</p>
                                            <p class="card-text"><strong>Detalles:</strong> {{ $service->pivot->description }}</p>
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
            {{ $events->links('pagination::bootstrap-5') }}
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://js.stripe.com/v3/"></script>
</body>
</html>