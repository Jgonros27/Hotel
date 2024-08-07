@extends('layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Reservas de Salones')
@section('content_header_title', 'Ver')
@if ($salonId)
    @foreach ($salons as $salon)
        @if ($salon->id == $salonId)
            @section('content_header_subtitle', 'Reservas del salon ' . $salon->nombre)
        @endif
    @endforeach
@else
    @if ($usuarioId)
        @foreach ($usuarios as $usuario)
            @if ($usuario->id == $usuarioId)
                @section('content_header_subtitle', 'Reservas de salones del usuario ' . $usuario->name)
            @endif
        @endforeach
    @else
        @section('content_header_subtitle', 'Reservas de salones')
    @endif
@endif

{{-- Content body: main page content --}}

@section('content_body')
    <div class="container">
        @if ($salonId || $usuarioId)
            <button onclick="window.history.back();" class="mt-3 btn btn-outline-secondary">
                <i class="fas fa-arrow-left"></i> Volver
            </button>
            <br>
            <br>
        @endif
        <div class="card">
            <div class="card-header">Gestionar Reservas de Salones</div>
            <div class="card-body">
                @if (!$usuarioId && !$salonId)
                    <div class="row">
                        <div class="col-md-3">
                            <label for="filtro-salons">Filtrar por salones: </label>
                            <select class="form-control js-example-basic-single" id="filtro-salons" name="filtro-salons">
                                <option value="">Todos los salones</option>
                                @foreach ($salons as $salon)
                                    <option value="{{ $salon->id }}">{{ $salon->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="filtro-usuarios">Filtrar por usuarios: </label>
                            <select class="form-control js-example-basic-single" id="filtro-usuarios"
                                name="filtro-usuarios">
                                <option value="">Todos los usuarios</option>
                                @foreach ($usuarios as $usuario)
                                    <option value="{{ $usuario->id }}">{{ $usuario->email }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="fecha-inicio">Desde: </label>
                            <input type="date" class="form-control" id="fecha-inicio" name="fecha-inicio">
                        </div>
                        <div class="col-md-3">
                            <label for="fecha-fin">Hasta: </label>
                            <input type="date" class="form-control" id="fecha-fin" name="fecha-fin">
                        </div>
                    </div>
                    <br>
                    <br>
                @endif
                {{ $dataTable->table() }}
            </div>
        </div>
    </div>
@stop

@push('scripts')
    {{ $dataTable->scripts() }}
@endpush

@push('js')
    <script>
        let baseUrl = "{!! route('reservaSalons.index', ['salonId' => 'SALON_PLACEHOLDER','usuarioId' => 'USUARIO_PLACEHOLDER','fechaInicio' => 'INICIO_PLACEHOLDER','fechaFin' => 'FIN_PLACEHOLDER',]) !!}";
        $(document).ready(function() {
            $('#filtro-salons, #filtro-usuarios, #fecha-inicio, #fecha-fin').on('change', function() {
                let salonId = $('#filtro-salons').val();
                let usuarioId = $('#filtro-usuarios').val();
                let fechaInicio = $('#fecha-inicio').val();
                let fechaFin = $('#fecha-fin').val();

                let url = baseUrl
                    .replace('SALON_PLACEHOLDER', encodeURIComponent(salonId))
                    .replace('USUARIO_PLACEHOLDER', encodeURIComponent(usuarioId))
                    .replace('INICIO_PLACEHOLDER', encodeURIComponent(fechaInicio))
                    .replace('FIN_PLACEHOLDER', encodeURIComponent(fechaFin));

                console.log(url);
                $('#reservasalons-table').DataTable().ajax.url(url).load();
            });
        });
    </script>
@endpush
