@extends('layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Imagenes de Cabañas')
@section('content_header_title', 'Ver')
@if ($tipoCabanaId)
    @foreach ($tipoCabanas as $tipoCabana)
        @if ($tipoCabana->id == $tipoCabanaId)
            @section('content_header_subtitle', 'Imagenes de cabañas del tipo ' . $tipoCabana->nombre)
        @endif
    @endforeach
@else
    @section('content_header_subtitle', 'Imagenes de cabañas')
@endif

{{-- Content body: main page content --}}

@section('content_body')
    <div class="container">
        @if ($tipoCabanaId)
            <button onclick="window.history.back();" class="mt-3 btn btn-outline-secondary">
                <i class="fas fa-arrow-left"></i> Volver
            </button>
            <br>
            <br>
        @endif
        <div class="card">
            <div class="card-header">Gestionar Imagenes de Cabañas</div>
            <div class="card-body">
                @if (!$tipoCabanaId)
                <label for="filtro-tipos">Filtrar por tipos de cabañas: </label>
                <select class="w-50 form-control js-example-basic-single" id="filtro-tipos" name="filtro-tipos">
                    <option value="">Todos los tipos</option>
                    @foreach ($tipoCabanas as $tipoCabana)
                        <option value="{{ $tipoCabana->id }}">{{ $tipoCabana->nombre }}</option>
                    @endforeach
                </select>
                <br>
                <br>
                @endif
                {{ $dataTable->table() }}
            </div>
        </div>
    </div>
    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="imageModalLabel"></h5>
                    <button type="button" class="close" id="closeButton" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <img src="" alt="Imagen" id="modalImage" style="max-width: 100%; height: auto;">
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
        function openModal(imageUrl, nombreCabana) {

            document.getElementById('modalImage').src = imageUrl;

            document.getElementById('imageModalLabel').innerText = "Cabaña " + nombreCabana;

            var myModal = new bootstrap.Modal(document.getElementById('imageModal'), {
                keyboard: false
            });

            myModal.toggle();

            document.getElementById("closeButton").addEventListener('click', function() {
                myModal.hide();
            });
        }
    </script>
    
    <script>
        let baseUrl = "{{ route('imagenCabanas.index', ['tipoCabanaId' => 'PLACEHOLDER']) }}";
        $(document).ready(function() {
            $('#filtro-tipos').on('change', function() {
                let tipoCabanaId = $(this).val();
                let url = baseUrl.replace('PLACEHOLDER', tipoCabanaId);
                $('#imagencabanas-table').DataTable().ajax.url(url).load();
            });
        });
    </script>
@endpush
