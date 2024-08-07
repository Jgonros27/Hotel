@extends('layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Reseñas')
@section('content_header_title', 'Ver')
@section('content_header_subtitle', 'Reseñas')

{{-- Content body: main page content --}}

@section('content_body')
    <div class="container">
        <div class="card">
            <div class="card-header">Gestionar reseñas</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <label for="filtro-usuarios">Filtrar por usuarios: </label>
                        <select class="form-control js-example-basic-single" id="filtro-usuarios" name="filtro-usuarios">
                            <option value="">Todos los usuarios</option>
                            @foreach ($usuarios as $usuario)
                                <option value="{{ $usuario->id }}">{{ $usuario->email }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="filtro-puntuacion">Filtrar por puntuacion: </label>
                        <select class="form-control js-example-basic-single" id="filtro-puntuacion"
                            name="filtro-puntuacion">
                            <option value="">Todas las puntuaciones</option>
                            @for ($i = 1; $i <= 5; $i++)
                                <option value='{{ $i }}'>{{ $i }}</option>
                            @endfor
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
        let baseUrl = "{!! route('resenas.index', ['puntuacion' => 'PUNTUACION_PLACEHOLDER','usuarioId' => 'USUARIO_PLACEHOLDER','fechaInicio' => 'INICIO_PLACEHOLDER','fechaFin' => 'FIN_PLACEHOLDER',]) !!}";
        $(document).ready(function() {
            $('#filtro-puntuacion, #filtro-usuarios, #fecha-inicio, #fecha-fin').on('change', function() {
                let puntuacion = $('#filtro-puntuacion').val();
                let usuarioId = $('#filtro-usuarios').val();
                let fechaInicio = $('#fecha-inicio').val();
                let fechaFin = $('#fecha-fin').val();

                let url = baseUrl
                    .replace('PUNTUACION_PLACEHOLDER', encodeURIComponent(puntuacion))
                    .replace('USUARIO_PLACEHOLDER', encodeURIComponent(usuarioId))
                    .replace('INICIO_PLACEHOLDER', encodeURIComponent(fechaInicio))
                    .replace('FIN_PLACEHOLDER', encodeURIComponent(fechaFin));

                console.log(url);
                $('#resenas-table').DataTable().ajax.url(url).load();
            });
        });
    </script>
@endpush
