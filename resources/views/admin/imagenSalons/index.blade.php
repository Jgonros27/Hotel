@extends('layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Imagenes de Salones')
@section('content_header_title', 'Ver')
@if ($salonId)
    @foreach ($salons as $salon)
        @if ($salon->id == $salonId)
            @section('content_header_subtitle', 'Imagenes del salon ' . $salon->nombre)
        @endif
    @endforeach
@else
    @section('content_header_subtitle', 'Imagenes de salones')
@endif

{{-- Content body: main page content --}}

@section('content_body')
    <div class="container">
        @if ($salonId)
            <button onclick="window.history.back();" class="mt-3 btn btn-outline-secondary">
                <i class="fas fa-arrow-left"></i> Volver
            </button>
            <br>
            <br>
        @endif
        <div class="card">
            <div class="card-header">Gestionar Imagenes de Salones</div>
            <div class="card-body">
                @if (!$salonId)
                    <label for="filtro-salons">Filtrar por salones: </label>
                    <select class="w-50 form-control js-example-basic-single" id="filtro-salons" name="filtro-salons">
                        <option value="">Todos los salones</option>
                        @foreach ($salons as $salon)
                            <option value="{{ $salon->id }}">{{ $salon->nombre }}</option>
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
        function openModal(imageUrl) {

            document.getElementById('modalImage').src = imageUrl;

            var myModal = new bootstrap.Modal(document.getElementById('imageModal'), {
                keyboard: false
            });

            myModal.toggle();
        }
    </script>
    <script>
        let baseUrl = "{{ route('imagenSalons.index', ['salonId' => 'PLACEHOLDER']) }}";
        $(document).ready(function() {
            $('#filtro-salons').on('change', function() {
                let salonId = $(this).val();
                let url = baseUrl.replace('PLACEHOLDER', salonId);
                $('#imagensalons-table').DataTable().ajax.url(url).load();
            });
        });
    </script>
@endpush
