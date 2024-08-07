@extends('layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Cabañas')
@section('content_header_title', 'Ver')
@section('content_header_subtitle', 'Cabañas')

{{-- Content body: main page content --}}

@section('content_body')
    <div class="container">
        <div class="card">
            <div class="card-header">Gestionar Cabañas</div>
            <div class="card-body">
                <label for="filtro-tipos">Filtrar por tipos: </label>
                <select class="w-50 form-control js-example-basic-single" id="filtro-tipos" name="filtro-tipos">
                    <option value="">Todos los tipos</option>
                    @foreach ($tipoCabanas as $tipoCabana)
                        <option value="{{ $tipoCabana->id }}">{{ $tipoCabana->nombre }}</option>
                    @endforeach
                </select>
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
        let baseUrl = "{{ route('cabanas.index', ['tipoCabanaId' => 'PLACEHOLDER']) }}";
        $(document).ready(function() {
            $('#filtro-tipos').on('change', function() {
                let tipoCabanaId = $(this).val();
                let url = baseUrl.replace('PLACEHOLDER', tipoCabanaId);
                $('#cabanas-table').DataTable().ajax.url(url).load();
            });
        });
    </script>
@endpush
