@extends('layouts.appHotel')

@section('content')
    <div id="textoPresentación" class="container">
        <h1 class="mt-5">{{ __('reservas.PresentacionTitulo') }}</h1>
        <div class="row mt-5">
            <div class="col-md-7 texto">
                <p>{{ __('reservas.PresentacionTexto') }}</p>
            </div>
            <div class="col-md-5">
                <img id="presentacionImg" src="{{ asset('images/hotel/reserva.jpg') }}" alt="Imagen" class="md-ms-5 w-100">
            </div>
        </div>
    </div>
    <div class="container">
        <h1 class="mt-5">{{ __('reservas.reservasCabanas') }}</h1>
        @if (!$reservaCabanas->isEmpty())
            <div class="table-responsive mt-3">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>{{ __('reservas.tipoCabana') }}</th>
                            <th>{{ __('reservas.numCabana') }}</th>
                            <th>{{ __('reservas.fechaEntrada') }}</th>
                            <th>{{ __('reservas.fechaSalida') }}</th>
                            <th>{{ __('reservas.numHuespedes') }}</th>
                            <th>{{ __('reservas.precioHabitacion') }}</th>
                            <th>{{ __('reservas.precioMediaPension') }}</th>
                            <th>{{ __('reservas.precioFinal') }}</th>
                            <th>{{ __('reservas.acciones') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($reservaCabanas as $reserva)
                            <tr>
                                <td>{{ ucwords($reserva->cabana->tipoCabana->nombre) }}</td>
                                <td>{{ $reserva->id_cabana }}</td>
                                <td>{{ \Carbon\Carbon::parse($reserva->fecha_entrada)->format('d/m/Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($reserva->fecha_salida)->format('d/m/Y') }}</td>
                                <td>{{ $reserva->n_huespedes }}</td>
                                <td>{{ $reserva->precio_habitacion }}€</td>
                                <td>{{ $reserva->media_pension }}€</td>
                                <td>{{ $reserva->precio_final }}€</td>
                                <td>
                                    <a href="{{route('reservaCabanas.factura',['idReservaCabana' => $reserva->id])}}"
                                        class="btn btn1 " data-toggle="tooltip" data-placement="top"
                                        title="{{ __('reservas.generarFacturaPDF') }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="20px" width="20px"
                                            viewBox="0 0 512 512">
                                            <path fill="#ffff" d="M64 64h384v384H64z" />
                                            <path fill="#cccccc" d="M64 64v384h384V64H64zm32 32h320v320H96V96z" />
                                            <path fill="#999999"
                                                d="M144 128h224v32H144zm0 64h224v32H144zm0 64h224v32H144zm0 64h224v32H144zm0 64h160v32H144z" />
                                        </svg>
                                    </a>
                                    @if (\Carbon\Carbon::parse($reserva->fecha_entrada) > \Carbon\Carbon::now())
                                        <form id="deleteForm_Cabana_{{ $reserva->id }}"
                                            action="{{ route('reservaCabanas.destroy', $reserva->id) }}" method="POST"
                                            style="display: inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn2"
                                                onclick="confirmDeleteCabana('{{ $reserva->id }}')" data-toggle="tooltip"
                                                data-placement="top" title="Cancelar reserva">
                                                <svg xmlns="http://www.w3.org/2000/svg" height="20px" width="20px"
                                                    viewBox="0 0 448 512">
                                                    <path fill="#ffff"
                                                        d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z" />
                                                </svg>

                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="d-flex align-items-center justify-content-center h-100">
                <h3>{{ __('inicio.reservasNo') }}</h3>
            </div>
        @endif
    </div>

    <div class="container mt-5 mb-5">
        <h1>{{ __('reservas.reservasSalones') }}</h1>
        @if (!$reservaSalones->isEmpty())
            <div class="table-responsive mt-3">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>{{ __('reservas.nombreSalon') }}</th>
                            <th>{{ __('reservas.fechaEvento') }}</th>
                            <th>{{ __('reservas.horaInicio') }}</th>
                            <th>{{ __('reservas.horaFin') }}</th>
                            <th>{{ __('reservas.tipoEvento') }}</th>
                            <th>{{ __('reservas.mensaje') }}</th>
                            <th>{{ __('reservas.precioFinal') }}</th>
                            <th>{{ __('reservas.acciones') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($reservaSalones as $reserva)
                            <tr>
                                <td>{{ ucwords($reserva->salon->nombre) }}</td>
                                <td>{{ \Carbon\Carbon::parse($reserva->fecha_evento)->format('d/m/Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($reserva->hora_inicio)->format('H:m') }}</td>
                                <td>{{ \Carbon\Carbon::parse($reserva->hora_fin)->format('H:m') }}</td>
                                <td>{{ ucwords($reserva->tipo_evento) }}</td>
                                <td>{{ ucwords($reserva->mensaje) }}</td>
                                <td>{{ $reserva->precio_final }}€</td>
                                <td>
                                    <a href="{{route('reservaSalons.factura',['idReservaSalon' => $reserva->id])}}"
                                        class="btn btn1 " data-toggle="tooltip" data-placement="top"
                                        title="{{ __('reservas.generarFacturaPDF') }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="20px" width="20px"
                                            viewBox="0 0 512 512">
                                            <path fill="#ffff" d="M64 64h384v384H64z" />
                                            <path fill="#cccccc" d="M64 64v384h384V64H64zm32 32h320v320H96V96z" />
                                            <path fill="#999999"
                                                d="M144 128h224v32H144zm0 64h224v32H144zm0 64h224v32H144zm0 64h224v32H144zm0 64h160v32H144z" />
                                        </svg>
                                    </a>
                                    @if (\Carbon\Carbon::parse($reserva->fecha_evento) > \Carbon\Carbon::now())
                                        <form id="deleteForm_Salon_{{ $reserva->id }}"
                                            action="{{ route('reservaSalons.destroy', $reserva->id) }}" method="POST"
                                            style="display: inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn2"
                                                onclick="confirmDeleteSalon('{{ $reserva->id }}')" data-toggle="tooltip"
                                                data-placement="top" title="Cancelar reserva">
                                                <svg xmlns="http://www.w3.org/2000/svg" height="20px" width="20px"
                                                    viewBox="0 0 448 512">
                                                    <path fill="#ffff"
                                                        d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z" />
                                                </svg>

                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="d-flex align-items-center justify-content-center h-100">
                <h3>{{ __('inicio.reservasNo') }}</h3>
            </div>
        @endif

    </div>
    <div class="overlay" id="loading-overlay">
        <div class="spinner-container">
            <div class="spinner"></div> <!-- Spinner de carga -->
        </div>
    </div>
@endsection

@push('css')
    <style>
        tr .btn1,
        tr .btn2 {
            color: #474242 !important;
            transition: all 0.2s ease-in !important;
            border: none;
        }


        tr .btn1 {
            background-color: wheat !important;

        }

        tr .btn2 {
            background-color: #dc3545 !important;
        }

        tr .btn1:hover,
        tr .btn2:hover {
            transform: scale(1.10);
        }


        .texto {
            font-size: 18px
        }

        th {
            background-color: #474242 !important;
            color: white !important;
        }

        .swal2-confirm{
            background-color: wheat !important;
            color: #474242 !important;
            border: none !important;
        }
    </style>
    <style>
        /* Estilos para el overlay */
        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5); /* Fondo semi-transparente */
            display: none; /* Por defecto, el overlay estará oculto */
            z-index: 9999; /* Asegura que el overlay esté en la parte superior */
        }

        /* Estilos para el contenedor del spinner */
        .spinner-container {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        /* Estilos para el spinner */
        .spinner {
            border: 4px solid rgba(0, 0, 0, 0.1);
            border-left-color: #333; /* Color del spinner */
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spinner 0.8s linear infinite;
        }

        /* Animación del spinner */
        @keyframes spinner {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(360deg);
            }
        }
    </style>
@endpush

@push('js')
    <script>
        function confirmDeleteCabana(reservaCabanaId) {
            Swal.fire({
                title: '{{__('reservas.reservaCancel')}}',
                text: '{{__('reservas.reservaCancel1')}}',
                icon: 'warning',
                showCancelButton: true,
                cancelButtonColor: '#d33',
                confirmButtonText: '{{__('reservas.siCan')}}',
                cancelButtonText: '{{__('reservas.noCan')}}',
            }).then((result) => {
                if (result.isConfirmed) {
                    // Mostrar overlay y spinner de carga
                    showLoadingSpinner();
                    document.getElementById('deleteForm_Cabana_' + reservaCabanaId).submit();
                }
            });
        }

        function confirmDeleteSalon(reservaSalonId) {
            Swal.fire({
                title: '{{__('reservas.reservaCancel')}}',
                text: '{{__('reservas.reservaCancel2')}}',
                icon: 'warning',
                showCancelButton: true,
                cancelButtonColor: '#d33',
                confirmButtonText: '{{__('reservas.siCan')}}',
                cancelButtonText: '{{__('reservas.noCan')}}',
            }).then((result) => {
                if (result.isConfirmed) {
                    // Mostrar overlay y spinner de carga
                    showLoadingSpinner();
                    document.getElementById('deleteForm_Salon_' + reservaSalonId).submit();
                }
            });
        }

        function showLoadingSpinner() {
            // Mostrar overlay
            document.getElementById('loading-overlay').style.display = 'block';
        }
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Verificar si la variable de sesión "cancelada" está presente
            if ('{{ session('cancelada') }}' !== '') {
                // Mostrar Sweet Alert con el mensaje
                Swal.fire({
                    title: '{{__('reservas.reservaCancel3')}}',
                    text: '{{ session('cancelada') }}',
                    icon: 'success'
                });
            }
        });
    </script>
@endpush
