@extends('layouts.appHotel')

@section('content')
    <div id="textoPresentación" class="container">
        <h1 class="mt-5">{{ __('cabanas.presentacionTitulo') }}</h1>
        <div class="row mt-5">
            <div class="col-md-7 texto">
                <p>{{ __('cabanas.presentacionTexto') }}</p>
                <p>{{ __('cabanas.presentacionTexto2') }}</p>
            </div>
            <div class="col-md-5">
                <img id="presentacionImg" src="{{ asset('images/hotel/image4.jpg') }}" alt="Imagen" class="md-ms-5 w-100">
            </div>
        </div>
    </div>

    <div id="cabanas" class="container mt-5 mb-5 rounded">
        @if (!$cabanas->isEmpty())
            <div id="cabanasCarusel" class="carousel slide" data-bs-ride="carousel">
                <!-- Diapositivas -->
                <div class="carousel-inner">
                    @foreach ($cabanas as $cabana)
                        <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                            <div class="card text-white m-width-100">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="card-body d-flex flex-column justify-content-between h-100">
                                            <div class="contenido">
                                                <h2 class="card-title fw-bold mb-3">{{ __('cabanas.cabana') }}
                                                    {{ ucwords($cabana->nombre) }}</h2>
                                                <p class="card-text texto">{{ __('cabanas.capacidad') }}:
                                                    {{ $cabana->capacidad }}
                                                </p>
                                                <p class="card-text texto">{{ __('cabanas.precio') }}: {{ $cabana->precio }}€
                                                </p>
                                                <p class="card-text texto">{{ __('cabanas.precioMediaPension') }}:
                                                    {{ $cabana->precio_media_pension }}€
                                                <p class="card-text texto">{{ __('cabanas.diasCancelacion1') }}
                                                    {{ $cabana->dias_cancelacion }} {{ __('cabanas.diasCancelacion2') }}
                                                </p>
                                            </div>
                                            <div class="botones d-flex justify-content-between align-items-center mt-3">
                                                <a href="{{ route('home') }}#anclaFormulario"
                                                    class="btn btn-primary">{{ __('inicio.cardReserva') }}</a>
                                                <a href="{{ route('tipoCabanas.show',$cabana->id) }}"
                                                    class="btn btn-secondary">{{ __('cabanas.detalles') }}</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        @if ($cabana->primera_url)
                                            @php
                                                $url = 'images/imagenes_cabanas/' . $cabana->primera_url;
                                            @endphp
                                            <img src="{{ asset($url) }}" class="w-100 h-100 card-img-top"
                                                alt="imagenOferta" style="object-fit: cover;">
                                        @else
                                            <div class="d-flex align-items-center justify-content-center h-100">
                                                <h3>{{ __('inicio.fotosNo') }}</h3>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <!-- Controles -->
                <a class="carousel-control-prev" href="#cabanasCarusel" role="button" data-bs-slide="prev">
                    <span class="controlador ms-5">
                        < </span>
                </a>
                <a class="carousel-control-next" href="#cabanasCarusel" role="button" data-bs-slide="next">
                    <span class="controlador me-5">></span>

                </a>
            </div>
        @else
            <div class="d-flex align-items-center justify-content-center h-100">
                <h3>{{ __('inicio.cabanasNo') }}</h3>
            </div>
        @endif

    </div>
@endsection

@push('css')
    <style>
        #cabanas .btn {
            background-color: wheat !important;
            color: #474242 !important;
            transition: all 0.2s ease-in !important;
            border: none;
        }

        #cabanas .btn:hover {
            transform: scale(1.10);
        }

        .controlador {
            color: #474242
        }

        @media (min-width: 768px) {

            #cabanasCarusel .carousel-control-next,
            #opinionesCarusel .carousel-control-next {
                width: 20px;
                right: -40px;
            }

            #cabanasCarusel .carousel-control-prev,
            #opinionesCarusel .carousel-control-prev {
                width: 20px;
                left: -40px;
            }
        }

        @media (max-width: 768px) {

            #cabanasCarusel .carousel-control-next,
            #opinionesCarusel .carousel-control-next {
                display: none;
            }

            #cabanasCarusel .carousel-control-prev,
            #opinionesCarusel .carousel-control-prev {
                display: none;
            }
        }

        .texto {
            font-size: 18px
        }

        .card {
            background-color: #474242 !important;
        }
    </style>
@endpush
