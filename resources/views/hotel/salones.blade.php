@extends('layouts.appHotel')

@section('content')
    <div id="textoPresentación" class="container">
        <h1 class="mt-5">{{ __('salones.presentacionTitulo') }}</h1>
        <div class="row mt-5">
            <div class="col-md-7 texto">
                <p>{{ __('salones.presentacionTexto') }}</p>
                <p>{{ __('salones.presentacionTexto2') }}</p>
            </div>
            <div class="col-md-5">
                <img id="presentacionImg" src="{{ asset('images/hotel/image6.webp') }}" alt="Imagen" class="md-ms-5 w-100">
            </div>
        </div>
    </div>

    <div class="container mt-5 mb-5">
        @if (!$salones->isEmpty())
            @foreach ($salones as $salon)
                <div id="{{$salon->nombre}}" class="text-white mt-5">_</div>
                <div  class="card text-white m-width-100 mt-5">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card-body h-100 d-flex flex-column justify-content-around">
                                <div class="contenido ">
                                    <h2 class="card-title fw-bold mb-3">{{ __('salones.salon') }}
                                        {{ ucwords($salon->nombre) }}</h2>
                                    <p class="card-text texto">{{ __('salones.descripcion') }}: {{ $salon->descripcion }}
                                    </p>
                                    <p class="card-text texto">{{ __('salones.precioHora') }}: {{ $salon->precio_hora }}€
                                    </p>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <a href="{{route('home')}}#anclaFormulario"
                                        class="btn btn-primary">{{ __('inicio.cardReserva') }}</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            @if (!$salon->imagenSalons->isEmpty())
                                <div id="{{ $salon->id }}" class="carousel slide" data-bs-ride="carousel">
                                    <div class="carousel-inner">

                                        @foreach ($salon->imagenSalons as $imagen)
                                            @php
                                                $url = 'images/imagenes_salons/' . $imagen->url
                                            @endphp
                                            <div class="carousel-item active">
                                                <img src="{{ asset($url) }}" class="d-block w-100 h-100"
                                                    alt="{{ $imagen->nombre_imagen }}" style="object-fit: cover;">
                                            </div>
                                        @endforeach

                                    </div>
                                    <button class="carousel-control-prev" type="button"
                                        data-bs-target="#{{ $salon->id }}" data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">{{ __('inicio.Previous') }}</span>
                                    </button>
                                    <button class="carousel-control-next" type="button"
                                        data-bs-target="#{{ $salon->id }}" data-bs-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">{{ __('inicio.Next') }}</span>
                                    </button>
                                    <ol class="carousel-indicators">
                                        @foreach ($salon->imagenSalons as $key => $imagen)
                                            <li data-bs-target="#{{ $salon->id }}"
                                                data-bs-slide-to="{{ $key }}"
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
            @endforeach
        @else
            <div class="d-flex align-items-center justify-content-center h-100">
                <h3>{{ __('inicio.salonesNo') }}</h3>
            </div>
        @endif

    </div>
@endsection

@push('css')
    <style>
        .carousel-indicators li {
            font-size: 0;
        }

        .card .btn {
            background-color: wheat !important;
            color: #474242 !important;
            transition: all 0.2s ease-in !important;
            border: none;
        }

        .card .btn:hover {
            transform: scale(1.10);
        }

        .controlador {
            color: #474242
        }

        @media (min-width: 768px) {


            .carousel {
                width: 100%;
                height: 100%;
            }

            .carousel-control-next {
                width: 20px;
                right: -40px;
            }

            .carousel-control-prev {
                width: 20px;
                left: -50px;
            }
        }

        @media (max-width: 768px) {

            .carousel-control-next {
                display: none;
            }

            .carousel-control-prev {
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
