@extends('layouts.appHotel')

@section('content')
    <div class="container mt-5 mb-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('pagos.reserva_exito') }}</div>

                    <div class="card-body">
                        <div class="text-center">
                            <img class="logo" src="{{ asset('images/logos/logoFenecCirculo.jpg') }}" alt="Logo"
                                style="height: 110px;">
                        </div>


                        <hr>

                        <div class="row">
                            <div class="col-md-12">
                                <p>
                                    {{ __('pagos.gracias') }}
                                </p>
                            </div>
                        </div>

                        @if (isset($tipoCabana))
                            <div class="row">
                                <div class="col-md-6">
                                    <h6>{{ __('pagos.fecha_entrada') }}:
                                        {{ \Carbon\Carbon::parse($reserva->fecha_entrada)->format('d/m/Y') }}</h6>
                                </div>
                                <div class="col-md-6">
                                    <h6>{{ __('pagos.fecha_salida') }}:
                                        {{ \Carbon\Carbon::parse($reserva->fecha_salida)->format('d/m/Y') }}</h6>
                                </div>
                            </div>

                            <hr>

                            <div class="row">
                                <div class="col-md-6">
                                    <h6>{{ __('pagos.cabaña_reservada') }}: {{ $tipoCabana }}</h6>
                                </div>
                                <div class="col-md-6">
                                    <h6>{{ __('pagos.numero_huespedes') }}: {{ $reserva->n_huespedes }}</h6>
                                </div>
                            </div>

                            <hr>

                            <div class="row">
                                <div class="col-md-6">
                                    <h6>{{ __('pagos.precio_cabaña_dia') }}: {{ $reserva->precio_habitacion }}€</h6>
                                </div>
                                <div class="col-md-6">
                                    <h6>{{ __('pagos.precio_media_pension') }}: {{ $reserva->media_pension }}€</h6>
                                </div>
                            </div>
                        @else
                            @php
                                $horaInicio = \Carbon\Carbon::parse($reserva->hora_inicio);
                                $horaFin = \Carbon\Carbon::parse($reserva->hora_fin);
                                $diferenciaHoras = $horaInicio->diffInHours($horaFin);
                            @endphp
                            <div class="row">
                                <div class="col-md-4">
                                    <h6>{{ __('pagos.fecha_evento') }}:
                                        {{ \Carbon\Carbon::parse($reserva->fecha_evento)->format('d/m/Y') }}
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
                                    <h6>{{ __('pagos.tipo_evento') }}: {{ $reserva->tipo_evento }}</h6>
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
                                    <p>{{ $reserva->mensaje }}</p>
                                </div>
                            </div>
                        @endif



                        <hr>

                        <div class="row">
                            <div class="col-md-6">
                                <h5><b>{{ __('pagos.precio_total') }}</b>: {{ $reserva->precio_final }}€</h5>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <p>{{ __('pagos.verFactura') }}</p>
                            </div>
                            <div class="col-md-6" id="factura">
                                @if (isset($tipoCabana))
                                    <a href="{{route('reservaCabanas.factura',['idReservaCabana' => $reserva->id])}}"
                                        class="btn btn-info " data-toggle="tooltip" data-placement="top"
                                        title="Generar Factura PDF">
                                        {{ __('pagos.factura') }}
                                    </a>
                                @else
                                    <a href="{{route('reservaSalons.factura',['idReservaSalon' => $reserva->id])}}"
                                        class="btn btn-info " data-toggle="tooltip" data-placement="top"
                                        title="Generar Factura PDF">
                                        {{ __('pagos.factura') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                        <hr>

                        <div class="row">
                            <div class="col-md-12">
                                <p>{{ __('pagos.verReserva') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <a href="{{route('inicio')}}" class="mt-3 btn btn-outline-secondary">
                    <i class="fas fa-arrow-left"></i>{{ __('pagos.volver_inicio') }}
                </a>
            </div>
        </div>
    </div>
@endsection

@push('css')
    <style>
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

        #factura .btn {
            background-color: wheat !important;
            color: #474242 !important;
            border: none !important;
            transition: transform 0.3s ease !important;
        }

        #factura .btn:hover {
            transform: scale(1.1);
        }
    </style>
@endpush
