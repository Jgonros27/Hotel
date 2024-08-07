@extends('layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Reservas de Cabañas')
@section('content_header_title', 'Ver')
@if ($tipoCabanaId)
    @foreach ($tipoCabanas as $tipoCabana)
        @if ($tipoCabana->id == $tipoCabanaId)
            @section('content_header_subtitle', 'Reservas de cabañas del tipo ' . $tipoCabana->nombre)
        @endif
    @endforeach
@else
    @if ($usuarioId)
        @foreach ($usuarios as $usuario)
            @if ($usuario->id == $usuarioId)
                @section('content_header_subtitle', 'Reservas de cabañas del usuario ' . $usuario->name)
            @endif
        @endforeach
    @else
        @section('content_header_subtitle', 'Reservas de cabañas')
    @endif
@endif

{{-- Content body: main page content --}}

@section('content_body')
    <div class="container">
        @if ($tipoCabanaId || $usuarioId)
            <button onclick="window.history.back();" class="mt-3 btn btn-outline-secondary">
                <i class="fas fa-arrow-left"></i> Volver
            </button>
            <br>
            <br>
        @endif
        <div class="card">
            <div class="card-header">Gestionar Reservas De Cabañas</div>
            <div class="card-body">
                @if (!$tipoCabanaId && !$usuarioId)
                    <div class="row">
                        <div class="col-md-3">
                            <label for="filtro-tipos">Filtrar por tipos de cabañas: </label>
                            <select class="form-control js-example-basic-single" id="filtro-tipos" name="filtro-tipos">
                                <option value="">Todos los tipos</option>
                                @foreach ($tipoCabanas as $tipoCabana)
                                    <option value="{{ $tipoCabana->id }}">{{ $tipoCabana->nombre }}</option>
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
                            <label for="fecha-entrada">Fecha de Entrada: </label>
                            <input type="date" class="form-control" id="fecha-entrada" name="fecha-entrada">
                        </div>
                        <div class="col-md-3">
                            <label for="fecha-salida">Fecha de Salida: </label>
                            <input type="date" class="form-control" id="fecha-salida" name="fecha-salida">
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
        let baseUrl = "{!! route('reservaCabanas.index', ['tipoCabanaId' => 'TIPO_PLACEHOLDER','usuarioId' => 'USUARIO_PLACEHOLDER','fechaEntrada' => 'ENTRADA_PLACEHOLDER','fechaSalida' => 'SALIDA_PLACEHOLDER']) !!}";
        $(document).ready(function() {
            $('#filtro-tipos, #filtro-usuarios, #fecha-entrada, #fecha-salida').on('change', function() {
                let tipoCabanaId = $('#filtro-tipos').val();
                let usuarioId = $('#filtro-usuarios').val();
                let fechaEntrada = $('#fecha-entrada').val();
                let fechaSalida = $('#fecha-salida').val();

                let url = baseUrl
                    .replace('TIPO_PLACEHOLDER', encodeURIComponent(tipoCabanaId))
                    .replace('USUARIO_PLACEHOLDER', encodeURIComponent(usuarioId))
                    .replace('ENTRADA_PLACEHOLDER', encodeURIComponent(fechaEntrada))
                    .replace('SALIDA_PLACEHOLDER', encodeURIComponent(fechaSalida));

                console.log(url);
                $('#reservacabanas-table').DataTable().ajax.url(url).load();
            });
        });
    </script>
@endpush
