@extends('layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Ofertas')
@section('content_header_title', 'Ver')
@section('content_header_subtitle', 'Ofertas')

{{-- Content body: main page content --}}

@section('content_body')

    <div class="container">
        <div class="card">
            <div class="card-header">Gestionar Ofertas</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <label for="filtro-tipos">Filtrar por tipos de cabañas: </label>
                        <select class="form-control js-example-basic-single" id="filtro-tipos" name="filtro-tipos">
                            <option value="">Todos los tipos</option>
                            @foreach ($tipoCabanas as $tipoCabana)
                                <option value="{{ $tipoCabana->id }}">{{ $tipoCabana->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="fecha-inicio">Fecha de inicio: </label>
                        <input type="date" class="form-control" id="fecha-inicio" name="fecha-inicio">
                    </div>
                    <div class="col-md-4">
                        <label for="fecha-fin">Fecha de fin: </label>
                        <input type="date" class="form-control" id="fecha-fin" name="fecha-fin">
                    </div>
                </div>
                <br>
                <br>
                {{ $dataTable->table() }}
            </div>
        </div>
    </div>
    </div>

@stop

@push('scripts')
    {{ $dataTable->scripts() }}
@endpush

@push('js')
<script>
    let baseUrl = "{!! route('ofertas.index', ['tipoCabanaId' => 'TIPO_PLACEHOLDER', 'fechaInicio' => 'INICIO_PLACEHOLDER', 'fechaFin' => 'FIN_PLACEHOLDER']) !!}";
    $(document).ready(function() {
        $('#filtro-tipos, #fecha-inicio, #fecha-fin').on('change', function() {
            let tipoCabanaId = $('#filtro-tipos').val();
            let fechaInicio = $('#fecha-inicio').val();
            let fechaFin = $('#fecha-fin').val();

            let url = baseUrl
                .replace('TIPO_PLACEHOLDER', encodeURIComponent(tipoCabanaId))
                .replace('INICIO_PLACEHOLDER', encodeURIComponent(fechaInicio))
                .replace('FIN_PLACEHOLDER', encodeURIComponent(fechaFin));

            console.log(url);
            $('#ofertas-table').DataTable().ajax.url(url).load();
        });
    });
</script>
@endpush
