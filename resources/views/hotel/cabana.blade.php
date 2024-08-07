@extends('layouts.appHotel')

@section('content')
    <div id="cabana" class="container mb-5">
        <h1 class="mt-5">{{ __('cabanas.cabana') }} {{ ucwords($cabana->nombre) }}</h1>
        <div class="row mt-5">
            <div class="col-md-7 texto">
                <p>{{ __('cabanas.precio2') }} {{ $cabana->precio }}€ {{ __('cabanas.precio3') }}</p>
                <ul>
                    <li>{{ __('cabanas.capacidad') }}: {{ $cabana->capacidad }}</li>
                    <li>{{ __('cabanas.servicios') }}:
                        <ul>
                            @php
                                $servicios = explode(';', $cabana->servicios);
                            @endphp
                            @foreach ($servicios as $servicio)
                                <li>{{ $servicio }}</li>
                            @endforeach
                        </ul>
                    </li>
                    <li>{{ __('cabanas.precioMediaPension') }}: {{ $cabana->precio_media_pension }}€</li>
                    <li>{{ __('cabanas.diasCancelacion1') }} {{ $cabana->dias_cancelacion }}
                        {{ __('cabanas.diasCancelacion2') }}</li>
                    <li>{{ __('cabanas.especificaciones') }}: {{ $cabana->especificaciones }}</li>
                </ul>
                <a href="{{ route('home') }}#anclaFormulario" class="texto mt-5 mb-4 p-3 btn btn-primary">{{ __('inicio.cardReserva') }}</a>
            </div>
            <div class="col-md-5">
                @if (!$cabanas->isEmpty())
                    <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            @foreach ($cabana->imagenCabanas as $imagen)
                                @php
                                    $url = 'images/imagenes_cabanas/' . $imagen->url
                                @endphp
                                <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                                    <img src="{{ asset($url) }}" class="d-block w-100"
                                        alt="{{ $imagen->nombre_imagen }}" style="object-fit: cover;">
                                </div>
                            @endforeach
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">{{ __('inicio.Previous') }}</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">{{ __('inicio.Next') }}</span>
                        </button>
                        <ol class="carousel-indicators">
                            @foreach ($cabana->imagenCabanas as $key => $imagen)
                                <li data-bs-target="#carouselExampleControls" data-bs-slide-to="{{ $key }}"
                                    class="{{ $key == 0 ? 'active' : '' }}"></li>
                            @endforeach
                        </ol>
                    </div>
                @else
                    <div class="d-flex align-items-center justify-content-center h-100">
                        <h3>{{ __('inicio.fotosNo') }}</h3>
                    </div>
                @endif

            </div>
        </div>
    </div>
@endsection

@push('css')
    <style>
        .carousel-indicators li {
            font-size: 0;
        }

        #cabana .btn {
            background-color: wheat !important;
            color: #474242 !important;
            transition: all 0.2s ease-in !important;
            border: none;
        }

        #cabana .btn:hover {
            transform: scale(1.10);
        }

        .texto {
            font-size: 18px !important;
        }
    </style>
@endpush
