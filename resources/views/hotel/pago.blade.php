@extends('layouts.appHotel')

@section('content')
    <div class="container mt-5 mb-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('pagos.resumen_reserva') }}</div>

                    <div class="card-body">
                        <div class="text-center">
                            <img class="logo" src="{{ asset('images/logos/logoFenecCirculo.jpg') }}" alt="Logo"
                                style="height: 110px;">
                        </div>


                        <hr>

                        @if (isset($tipoCabana))
                            <div class="row">
                                <div class="col-md-6">
                                    <h6>{{ __('pagos.fecha_entrada') }}:
                                        {{ \Carbon\Carbon::parse($data['fecha_entrada'])->format('d/m/Y') }}
                                    </h6>
                                </div>
                                <div class="col-md-6">
                                    <h6>{{ __('pagos.fecha_salida') }}:
                                        {{ \Carbon\Carbon::parse($data['fecha_salida'])->format('d/m/Y') }}
                                    </h6>
                                </div>
                            </div>

                            <hr>

                            <div class="row">
                                <div class="col-md-6">
                                    <h6>{{ __('pagos.cabaña_reservada') }}: {{ $tipoCabana->nombre }}</h6>
                                </div>
                                <div class="col-md-6">
                                    <h6>{{ __('pagos.numero_huespedes') }}: {{ $data['n_huespedes'] }}</h6>
                                </div>
                            </div>

                            <hr>

                            <div class="row">
                                <div class="col-md-6">
                                    <h6>{{ __('pagos.precio_cabaña_dia') }}: {{ $data['precio_habitacion'] }}€</h6>
                                </div>

                                <div class="col-md-6">
                                    <h6>{{ __('pagos.precio_sinDescuento') }}: {{ $data['precio_total'] }}€</h6>
                                </div>
                            </div>



                            <div class="row">
                                <div class="col-md-6">
                                    <h6>{{ __('pagos.precio_media_pension') }}: {{ $data['media_pension'] }}€</h6>
                                </div>
                                <div class="col-md-6">
                                    <h6>{{ __('pagos.descuento') }}: {{ $data['descuento'] }}€</h6>
                                </div>
                            </div>



                            <hr>
                        @else
                            @php
                                $horaInicio = \Carbon\Carbon::parse($data['hora_inicio']);
                                $horaFin = \Carbon\Carbon::parse($data['hora_fin']);
                                $diferenciaHoras = $horaInicio->diffInHours($horaFin);
                            @endphp
                            <div class="row">
                                <div class="col-md-4">
                                    <h6>{{ __('pagos.fecha_evento') }}:
                                        {{ \Carbon\Carbon::parse($data['fecha_evento'])->format('d/m/Y') }}
                                    </h6>
                                </div>
                                <div class="col-md-4">
                                    <h6>{{ __('pagos.hora_inicio') }}:
                                        {{ $horaInicio->format('H:i') }}
                                    </h6>
                                </div>
                                <div class="col-md-4">
                                    <h6>{{ __('pagos.hora_fin') }}:
                                        {{ $horaFin->format('H:i') }}
                                    </h6>
                                </div>
                            </div>

                            <hr>


                            <div class="row">
                                <div class="col-md-6">
                                    <h6>{{ __('pagos.salon_reservado') }}: {{ $salon }}</h6>
                                </div>
                                <div class="col-md-6">
                                    <h6>{{ __('pagos.tipo_evento') }}: {{ $data['tipo_evento'] }}</h6>
                                </div>
                            </div>

                            <hr>

                            <div class="row">
                                <div class="col-md-6">
                                    <h6>{{ __('pagos.precio_salon_hora') }}: {{ $precioHora }}€</h6>
                                </div>
                                <div class="col-md-6">
                                    <h6>{{ __('pagos.numero_horas') }}: {{ $diferenciaHoras }}</h6>
                                </div>
                            </div>

                            <hr>

                            <div class="row">
                                <div class="col-md-12">
                                    <h6>{{ __('pagos.mensaje') }}: </h6>
                                    <p>{{ $data['mensaje'] }}</p>
                                </div>
                            </div>
                        @endif

                        <div class="row">
                            <div class="col-md-6">
                                <h5><b>{{ __('pagos.precio_total') }}</b>: {{ $data['precio_final'] }}€</h5>
                            </div>
                        </div>

                        <hr>


                        <form id="payment-form" action="{{ isset($tipoCabana) ? route('reservaCabanas.pagado') : route('reservaSalons.pagado') }}"
                            method="POST">
                            @method('POST')
                            @csrf
                            <!-- Input oculto para enviar los datos de la reserva -->
                            <input type="hidden" name="data" value="{{ json_encode($data) }}">
                            <input type="hidden" name="email" value="{{ auth()->user()->email }}">

                            @if (isset($tipoCabana))
                                <input type="hidden" name="tipoCabana" value="{{ $tipoCabana->id }}">
                            @else
                                <input type="hidden" name="salon" value="{{ $salon }}">
                                <input type="hidden" name="precioHora" value="{{ $precioHora }}">
                            @endif


                            <div class="form-group">
                                <label for="card-element">{{ __('pagos.introducir_tarjeta') }}</label>
                                <div id="card-element" class="form-control"></div>
                            </div>

                            <div id="card-errors" role="alert"></div>

                            <button class="btn btn-primary btn-block">{{ __('pagos.pagar') }}</button>
                        </form>
                    </div>
                </div>
                <a href="{{route('inicio')}}" class="mt-3 btn btn-outline-secondary">
                    <i class="fas fa-arrow-left"></i> {{ __('pagos.volver_inicio') }}
                </a>
            </div>
        </div>
    </div>
    <div class="overlay" id="loading-overlay">
        <div class="spinner-container">
            <div class="spinner"></div>
        </div>
    </div>
@endsection

@push('css')
    <style>
        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            /* Fondo semi-transparente */
            display: none;
            /* Por defecto, el overlay estará oculto */
            z-index: 9999;
            /* Asegura que el overlay esté en la parte superior */
        }

        .spinner-container {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .spinner {
            border: 4px solid rgba(0, 0, 0, 0.1);
            border-left-color: #333;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spinner 0.8s linear infinite;
        }

        @keyframes spinner {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .card {
            box-shadow: 5px 5px 5px #474242
        }

        #card-element {
            height: 40px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        #card-errors {
            color: red;
            margin-top: 10px;
        }

        .card-header {
            background-color: #474242 !important;
            color: wheat !important;
        }

        #payment-form .btn {
            background-color: wheat !important;
            color: #474242 !important;
            border: none !important;
            transition: transform 0.3s ease !important;
        }

        #payment-form .btn:hover {
            transform: scale(1.1);
        }
    </style>
@endpush

@push('js')
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        var stripe = Stripe('{{ env('STRIPE_KEY') }}');
        var elements = stripe.elements();

        var cardElement = elements.create('card');
        cardElement.mount('#card-element');

        cardElement.on('change', function(event) {
            var displayError = document.getElementById('card-errors');
            if (event.error) {
                displayError.textContent = event.error.message;
            } else {
                displayError.textContent = '';
            }
        });

        var form = document.getElementById('payment-form');
        form.addEventListener('submit', function(event) {
            event.preventDefault();

            // Mostrar el overlay y el spinner de carga
            document.getElementById('loading-overlay').style.display = 'block';

            stripe.createToken(cardElement).then(function(result) {
                if (result.error) {
                    var errorElement = document.getElementById('card-errors');
                    errorElement.textContent = result.error.message;

                    // Ocultar el overlay y el spinner de carga si hay un error
                    document.getElementById('loading-overlay').style.display = 'none';
                } else {
                    stripeTokenHandler(result.token);
                }
            });
        });

        function stripeTokenHandler(token) {
            var form = document.getElementById('payment-form');
            var hiddenInput = document.createElement('input');
            hiddenInput.setAttribute('type', 'hidden');
            hiddenInput.setAttribute('name', 'stripeToken');
            hiddenInput.setAttribute('value', token.id);
            form.appendChild(hiddenInput);
            form.submit();
        }
    </script>
@endpush
