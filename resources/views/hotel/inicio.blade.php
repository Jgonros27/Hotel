@extends('layouts.appHotel')

@section('content')
    <div id="anclaFormulario"></div>
    <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="{{ asset('images/hotel/image1.jpg') }}" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
                <img src="{{ asset('images/hotel/image2.jpg') }}" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
                <img src="{{ asset('images/hotel/image3.jpg') }}" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
                <img src="{{ asset('images/hotel/image4.jpg') }}" class="d-block w-100" alt="...">
            </div>
        </div>

        <div class=" text-center">
            <div class="scroll-down text-center d-flex flex-column align-items-center">
                <p class="text-white wavy-text">{{ __('inicio.descubreOfertas') }}</p>
                <a href="#anclaBienvenido" class="scroll-icon">
                    <span class="arrow-down"></span>
                </a>
            </div>
        </div>

        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">{{ __('inicio.Previous') }}</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">{{ __('inicio.Next') }}</span>
        </button>
    </div>


    <div id="formulario">
        @auth
            <!-- Mini menú -->
            <div class="text-center d-flex justify-content-center">
                <div id="mini-menu" class="menu">
                    <button id="btnCabanas" class="btn active">{{ __('inicio.Cabañas') }}</button>
                    <button id="btnSalones" class="btn">{{ __('inicio.Salones') }}</button>
                </div>
            </div>


            <!-- Formulario de reserva de cabañas (por defecto visible) -->
            <div id="formCabanas" class="formulario active">
                <div class="text-center d-flex justify-content-center">
                    <form action="{{ route('reservaCabanas.store') }}" method="POST" class="w-75">
                        @csrf
                        @method('POST')
                        <input type="hidden" id="usuario" name="usuario" value="{{ auth()->user()->id }}">
                        <div class="row">
                            <div class="col-md-2">
                                <label for="tipoCabana" class="form-label">{{ __('inicio.Tipo de Cabañas') }}</label>
                                <select class="form-select" id="tipoCabana" name="tipoCabana">
                                    @foreach ($cabanas as $cabana)
                                        <option value="{{ $cabana->id }}"
                                            {{ old('tipoCabana') == $cabana->id ? 'selected' : '' }}>
                                            {{ ucwords($cabana->nombre) }}</option>
                                    @endforeach
                                </select>
                                @error('tipoCabana')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-2">
                                <label for="fechaEntrada" class="form-label">{{ __('inicio.Fecha de Entrada') }}</label>
                                <input type="date" class="form-control" id="fechaEntrada" name="fechaEntrada"
                                    value="{{ old('fechaEntrada') }}" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
                                @error('fechaEntrada')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-2">
                                <label for="fechaSalida" class="form-label">{{ __('inicio.Fecha de Salida') }}</label>
                                <input type="date" class="form-control" id="fechaSalida" name="fechaSalida"
                                    value="{{ old('fechaSalida') }}" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
                                @error('fechaSalida')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-2">
                                <label for="nHuespedes" class="form-label">{{ __('inicio.Número de Huéspedes') }}</label>
                                <input type="number" class="form-control" id="nHuespedes" name="nHuespedes"
                                    value="{{ old('nHuespedes') ? old('nHuespedes') : 1 }}" min="1">
                                @error('nHuespedes')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-2 text-center d-flex align-items-center flex-column">
                                <label class="form-label" for="mediaPension">{{ __('inicio.Media Pensión') }}</label>
                                <input type="checkbox" class="form-check-input mt-2" id="mediaPension" name="mediaPension"
                                    {{ old('mediaPension') ? 'checked' : '' }} style="display: block">
                            </div>
                            <div class="col-md-2 text-center d-flex align-items-center">
                                <button type="submit" class="btn btn-primary mt-4">{{ __('inicio.Enviar') }}</button>
                            </div>
                        </div>
                        @if (session('error'))
                            <div class="alert alert-danger d-flex align-items-center" role="alert">
                                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img"
                                    aria-label="danger:">
                                    <use xlink:href="#exclamation-triangle-fill" />
                                </svg>
                                <div>{{ session('error') }}</div>
                            </div>
                        @endif
                    </form>
                </div>
            </div>

            <!-- Formulario de reserva de salones (inicialmente oculto) -->
            <div id="formSalones" class="formulario">
                <div class="container">
                    <form action="{{ route('reservaSalons.store') }}" method="POST" class="w-100">
                        @csrf
                        @method('POST')
                        <input type="hidden" id="usuario" name="usuario" value="{{ auth()->user()->id }}">
                        <div class="row">
                            <div class="col-md-3">
                                <label for="salon" class="form-label">{{ __('inicio.Salón') }}</label>
                                <select class="form-select" id="salon" name="salon">
                                    @foreach ($salones as $salon)
                                        <option value="{{ $salon->id }}"
                                            {{ old('salon') == $salon->id ? 'selected' : '' }}>{{ ucwords($salon->nombre) }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('salon')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                <label for="tipoEvento" class="form-label">{{ __('inicio.Tipo de Evento') }}</label>
                                <select class="form-select" id="tipoEvento" name="tipoEvento">
                                    <option {{ old('tipoEvento') == 'cumpleaños' ? 'selected' : '' }} value="cumpleaños">
                                        {{ __('inicio.Cumpleaños') }}</option>
                                    <option {{ old('tipoEvento') == 'boda' ? 'selected' : '' }} value="boda">
                                        {{ __('inicio.Boda') }}</option>
                                    <option {{ old('tipoEvento') == 'bautizo' ? 'selected' : '' }} value="bautizo">
                                        {{ __('inicio.Bautizo') }}</option>
                                    <option {{ old('tipoEvento') == 'comunion' ? 'selected' : '' }} value="comunion">
                                        {{ __('inicio.Comunión') }}</option>
                                    <option {{ old('tipoEvento') == 'evento_empresarial' ? 'selected' : '' }}
                                        value="evento_empresarial">{{ __('inicio.Evento Empresarial') }}</option>
                                    <option {{ old('tipoEvento') == 'otros' ? 'selected' : '' }} value="otros">
                                        {{ __('inicio.Otros') }}</option>
                                </select>
                                @error('tipoEvento')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-2">
                                <label for="fechaEvento" class="form-label">{{ __('inicio.Fecha del Evento') }}</label>
                                <input type="date" class="form-control" id="fechaEvento" name="fechaEvento"
                                    value="{{ old('fechaEvento') }}"
                                    min="{{ \Carbon\Carbon::now()->addDay()->format('Y-m-d') }}">
                                @error('fechaEvento')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-2">
                                <label for="horaInicio" class="form-label">{{ __('inicio.Hora de Inicio') }}</label>
                                <input type="time" class="form-control" id="horaInicio" name="horaInicio"
                                    value="{{ old('horaInicio') }}">
                                @error('horaInicio')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-2">
                                <label for="horaFin" class="form-label">{{ __('inicio.Hora de Fin') }}</label>
                                <input type="time" class="form-control" id="horaFin" name="horaFin"
                                    value="{{ old('horaFin') }}">
                                @error('horaFin')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-12 mt-3">
                                <label for="mensaje" class="form-label">{{ __('inicio.Mensaje') }}</label>
                                <textarea class="form-control" id="mensaje" name="mensaje" rows="3">{{ old('mensaje') }}</textarea>
                                @error('mensaje')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-2 text-center d-flex align-items-center">
                                <button type="submit" class="btn btn-primary mt-4">{{ __('inicio.Enviar') }}</button>
                            </div>
                        </div>
                        @if (session('error'))
                            <div class="alert alert-danger d-flex align-items-center" role="alert">
                                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img"
                                    aria-label="danger:">
                                    <use xlink:href="#exclamation-triangle-fill" />
                                </svg>
                                <div>{{ session('error') }}</div>
                            </div>
                        @endif
                    </form>
                </div>
            </div>
        @else
            <p class="text-white fs-3 fw-bold pt-4">{{ __('inicio.Discover') }}</p>
            <div class="text-center mt-4">
                <a href="{{ route('login') }}" class="btn btn-login mt-3 mx-2">{{ __('menu.login') }}</a>
                <a href="{{ route('register') }}" class="btn btn-register mt-3 mx-2">{{ __('menu.register') }}</a>
            </div>
        @endauth

    </div>



    <div id="bienvenido" class="container">
        <h1 class="mt-5">{{ __('inicio.bienvenidoTitulo') }}</h1>
        <div class="row mt-5">
            <div class="col-md-6 texto">
                <p>{{ __('inicio.bienvenidoTexto') }}</p>
            </div>
            <div class="col-md-6">
                <div id="anclaBienvenido"></div>
                <img id="bienvenidoImg" src="{{ asset('images/hotel/image5.jpg') }}" alt="Imagen"
                    class="md-ms-5 w-100 ">
            </div>
        </div>
    </div>

    <div id="ofertas" class="container">
        <h1 class="mt-5">{{ __('inicio.ofertasTitulo') }}</h1>
        <div class="row mt-5 mb-5">
            <div class="col-md-3 mb-5">
                <img id="ofertaImage" src="{{ asset('images/hotel/oferta.webp') }}" alt="Imagen"
                    class="w-75 animate__backInLeft">
            </div>
            <div class="col-md-9 texto">
                <p>{{ __('inicio.ofertasTexto') }}</p>
                <p>{{ __('inicio.ofertasTexto2') }}</p>
            </div>
        </div>
        @if (!$ofertas->isEmpty())
            <div id="ofertasCarusel" class="carousel slide" data-bs-ride="carousel">
                <!-- Diapositivas -->
                <div class="carousel-inner">
                    @foreach ($ofertas as $oferta)
                        <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                            <div class="card text-white m-width-100">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="card-body d-flex flex-column justify-content-between h-100">
                                            <h2 class="card-title fw-bold mb-3">{{ __('inicio.cardTitulo') }}
                                                {{ ucwords($oferta->nombre) }}</h2>
                                            <div class="contenido texto">
                                                <p class="card-text">{{ __('inicio.cardInicio') }}:
                                                    {{ \Carbon\Carbon::parse($oferta->fecha_inicio)->format('d/m/Y') }}</p>
                                                <p class="card-text">{{ __('inicio.cardFin') }}:
                                                    {{ \Carbon\Carbon::parse($oferta->fecha_fin)->format('d/m/Y') }}</p>
                                                <p class="card-text">{{ __('inicio.cardDescuento') }}:
                                                    {{ $oferta->descuento }}%
                                                </p>
                                            </div>
                                            <div class="boton">
                                                <a href="#anclaFormulario"
                                                    class="btn btn-primary mt-3">{{ __('inicio.cardReserva') }}</a>
                                            </div>


                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        @if ($oferta->primera_url)
                                            @php
                                                $url = 'images/imagenes_cabanas/' . $oferta->primera_url;
                                            @endphp
                                            <img src="{{ asset($url) }}" class="w-100 h-100 card-img-top"
                                                alt="imagenOferta" style="object-fit: cover;">
                                        @else
                                            <div class="d-flex align-items-center justify-content-center h-100">
                                                <h3>{{ __('inicio.ofertasNo') }}</h3>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <!-- Controles -->
                <a class="carousel-control-prev" href="#ofertasCarusel" role="button" data-bs-slide="prev">
                    <span class="controlador ms-5">
                        < </span>
                </a>
                <a class="carousel-control-next" href="#ofertasCarusel" role="button" data-bs-slide="next">
                    <span class="controlador me-5">></span>

                </a>
            </div>
        @else
            <div class="d-flex align-items-center justify-content-center h-100">
                <h3>{{ __('inicio.ofertasNo') }}</h3>
            </div>
        @endif

    </div>

    <div id="opiniones" class="container mb-5">
        <h1 class="mt-5">{{ __('inicio.opinionesTitulo') }}</h1>
        <div class="row mt-5 mb-5">
            <div class="col-md-7 texto">
                <p>{{ __('inicio.opinionesTexto') }}</p>
                <p>{{ __('inicio.opinionesTexto2') }}</p>
            </div>
            <div class="col-md-5">
                <div id="formularioOpiniones" class="container pt-3 rounded">
                    <h2>{{ __('inicio.opinion') }}</h2>
                    @auth
                        <form action="{{ route('resenas.store') }}" method="POST" class="w-75 mx-auto mt-4">
                            @csrf
                            @method('POST')
                            <input type="hidden" id="usuario" name="usuario" value="{{ auth()->user()->id }}">
                            <div class="mb-3">
                                <label for="puntuacion" class="form-label">{{ __('inicio.puntuacion') }}</label>
                                <div class="rating">
                                    @for ($i = 5; $i >= 1; $i--)
                                        <input type="radio" id="star{{ $i }}" name="puntuacion"
                                            value="{{ $i }}" {{ old('puntuacion') == $i ? 'checked' : '' }}>
                                        <label title="text" for="star{{ $i }}"></label>
                                    @endfor
                                </div>
                                @error('puntuacion')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="comentario" class="form-label">{{ __('inicio.comentario') }}</label>
                                <textarea name="comentario" class="form-control" id="comentario" rows="4">{{ old('comentario') }}</textarea>
                                @error('comentario')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary">{{ __('inicio.Enviar') }}</button>
                            @if ($errors->has('error'))
                                <div class="text-danger">{{ $message }}</div>
                            @endif
                        </form>
                    @else
                        <div class="text-center mt-4">
                            <a href="{{ route('login') }}" class="btn mt-3 btn-login mx-2">{{ __('menu.login') }}</a>
                            <a href="{{ route('register') }}"
                                class="btn mt-3 btn-register mx-2">{{ __('menu.register') }}</a>
                        </div>
                    @endauth

                </div>
            </div>
        </div>
        @if (!$opiniones->isEmpty())
            <div id="opinionesCarusel" class="carousel slide" data-bs-ride="carousel">
                <!-- Diapositivas -->
                <div class="carousel-inner">
                    @foreach ($opiniones as $opinion)
                        <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                            <div class="card text-white m-width-100">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="card-body">
                                            <h3 class="card-text">{{ ucwords($opinion->name) }}</h3>
                                            <p class="card-text">"{{ $opinion->comentario }}"</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="d-flex align-items-center justify-content-center h-100">
                                            @for ($i = 0; $i < $opinion->puntuacion; $i++)
                                                <i class="bi bi-star-fill ms-2" style="color: gold;"></i>
                                            @endfor
                                            @for ($i = $opinion->puntuacion; $i < 5; $i++)
                                                <i class="bi bi-star ms-2" style="color: gold;"></i>
                                            @endfor
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <!-- Controles -->
                <a class="carousel-control-prev" href="#opinionesCarusel" role="button" data-bs-slide="prev">
                    <span class="controlador ms-5">
                        < </span>
                </a>
                <a class="carousel-control-next" href="#opinionesCarusel" role="button" data-bs-slide="next">
                    <span class="controlador me-5"> > </span>

                </a>
            </div>
        @else
            <div class="d-flex align-items-center justify-content-center h-100">
                <h3>{{ __('inicio.opinionesNo') }}</h3>
            </div>
        @endif
        @if (session()->has('resena'))
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    Swal.fire({
                        title: '{{ __('inicio.graciasResena') }}',
                        text: '{{ __('inicio.graciasResena2') }}',
                        icon: 'success',
                        showCancelButton: false,
                        confirmButtonText: '{{ __('inicio.si') }}',
                    });
                });
            </script>
        @endif


    </div>

@endsection

@push('css')
    <style>
        .rating {
            width: fit-content;
        }

        .rating:not(:checked)>label {
            float: right;
            cursor: pointer;
            font-size: 30px;
            color: #f0ecec;
        }

        .rating:not(:checked)>label::before {
            content: '★';
            font-size: 40px;
        }

        .rating>input {
            display: none;
        }

        .rating>input:checked~label {
            color: #e58e09;
        }

        .rating>input:checked~label:hover,
        .rating>input:checked~label:hover~label {
            color: #e58e09;
        }

        .rating>label:hover~input:checked~label {
            color: #ff9e0b;
        }

        .rating>input:checked~label:hover,
        .rating>input:checked~label:hover~label,
        .rating>label:hover~input:checked~label {
            color: #ff9e0b;
        }
    </style>
    <style>
        .controlador {
            color: #474242
        }


        @media (min-width: 768px) {


            #ofertasCarusel .carousel-control-next,
            #opinionesCarusel .carousel-control-next {
                width: 20px;
                right: -40px;
            }

            #ofertasCarusel .carousel-control-prev,
            #opinionesCarusel .carousel-control-prev {
                width: 20px;
                left: -40px;
            }
        }

        @media (max-width: 768px) {

            #ofertasCarusel .carousel-control-next,
            #opinionesCarusel .carousel-control-next {
                display: none;
            }

            #ofertasCarusel .carousel-control-prev,
            #opinionesCarusel .carousel-control-prev {
                display: none;
            }
        }

        #ofertasCarusel .carousel-item img {
            width: 70%;
        }

        .card {
            background-color: #474242 !important;
        }

        .texto {
            font-size: 18px
        }

        .scroll-down {
            position: absolute;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 2;
        }

        .scroll-icon {
            width: 40px;
            height: 40px;
            border: 2px solid wheat;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.6s ease;
        }

        .scroll-icon:hover {
            transform: rotate(180deg);
        }

        .arrow-down {
            width: 0;
            height: 0;
            border-left: 10px solid transparent;
            border-right: 10px solid transparent;
            border-bottom: 14px solid wheat;
            transition: transform 0.3s ease;
        }

        #texto {
            padding: ;
            height: 1000px;
        }

        .fs-3 {
            font-size: 1.75rem !important;
        }

        #formulario,
        #formularioOpiniones {
            background-color: #474242;
            width: 100%;
            padding-bottom: 49px;
            min-height: 20vh;
            text-align: center;
            font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
        }

        #formularioOpiniones h2 {
            color: wheat;
        }

        #carouselExampleControls .carousel-inner .carousel-item {
            height: 73vh;
        }

        #carouselExampleControls .carousel-item img {
            height: 100vh;
            object-fit: cover;
        }

        .menu {
            margin-bottom: 20px;
            border-bottom: 1px solid #ccc;
            width: fit-content;

        }

        #formulario .btn,
        #formularioOpiniones .btn {
            padding: 10px 20px;
            cursor: pointer;
            font-size: 23px !important;
        }



        #mini-menu .btn.active {
            color: #f0f0f0 !important;
            border-bottom: 3px solid #f0f0f0 !important;
            border-radius: 0px;
        }

        .formulario {
            display: none;
        }

        .formulario.active {
            display: block;
        }

        .form-label {
            font-size: 17px !important;
            color: #ccc !important;
        }

        #formulario .btn,
        #ofertas .btn,
        #formularioOpiniones .btn {
            background-color: wheat !important;
            color: #474242 !important;
            transition: all 0.2s ease-in !important;
            border: none;
        }

        #formulario .btn:hover,
        #ofertas .btn:hover,
        #formularioOpiniones .btn:hover {
            transform: scale(1.10);
        }

        #mini-menu .btn {
            background-color: #474242 !important;
            color: #ccc !important;
            border: none !important;
        }

        #mini-menu .btn:hover {
            transform: scale(1.0);
            color: #eeebeb !important;
        }
    </style>
    <style>
        .wavy-text {
            display: inline-block;
            white-space: nowrap;
        }

        .wavy-text span {
            display: inline-block;
            position: relative;
            font-size: 25px;
            color: #fff;
            animation: wave-animation 2s infinite;
        }

        @keyframes wave-animation {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-10px);
            }
        }
    </style>
@endpush

@push('js')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const btnCabanas = document.getElementById("btnCabanas");
            const btnSalones = document.getElementById("btnSalones");
            const formCabanas = document.getElementById("formCabanas");
            const formSalones = document.getElementById("formSalones");

            if (btnCabanas && btnSalones && formCabanas && formSalones) {
                btnCabanas.addEventListener("click", function() {
                    btnCabanas.classList.add("active");
                    btnSalones.classList.remove("active");
                    formCabanas.classList.add("active");
                    formSalones.classList.remove("active");
                });

                btnSalones.addEventListener("click", function() {
                    btnCabanas.classList.remove("active");
                    btnSalones.classList.add("active");
                    formCabanas.classList.remove("active");
                    formSalones.classList.add("active");
                });
            }
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const textElement = document.querySelector('.wavy-text');
            const text = textElement.textContent;
            textElement.innerHTML = '';

            for (let i = 0; i < text.length; i++) {
                const span = document.createElement('span');
                if (text[i] === ' ') {
                    span.innerHTML = '&nbsp;';
                } else {
                    span.textContent = text[i];
                }
                span.style.animationDelay = `${i * 0.1}s`;
                textElement.appendChild(span);
            }
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Obtener el campo de fecha de entrada y de salida
            var fechaEntrada = document.getElementById("fechaEntrada");
            var fechaSalida = document.getElementById("fechaSalida");

            if (fechaEntrada && fechaSalida) {
                // Función para actualizar la fecha mínima de salida cuando cambie la fecha de entrada
                fechaEntrada.addEventListener("change", function() {
                    // Obtener la fecha seleccionada en el campo de entrada
                    var selectedDate = fechaEntrada.value;

                    // Establecer la fecha mínima de salida como un día después de la fecha de entrada seleccionada
                    var nextDay = new Date(selectedDate);
                    nextDay.setDate(nextDay.getDate() + 1);

                    // Formatear la fecha mínima de salida en formato YYYY-MM-DD
                    var minSalida = nextDay.toISOString().split('T')[0];

                    // Establecer la nueva fecha mínima de salida
                    fechaSalida.setAttribute('min', minSalida);

                    // Reiniciar el valor del campo de salida para evitar problemas de fechas inválidas
                    fechaSalida.value = minSalida;
                });
            }

        });
    </script>
@endpush
