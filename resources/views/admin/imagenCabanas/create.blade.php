@extends('layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Imagenes de cabañas')
@section('content_header_title', 'Crear')
@section('content_header_subtitle', 'Imagenes de cabañas')

{{-- Content body: main page content --}}

@section('content_body')

<form action="{{ route('imagenCabanas.store') }}" method="POST" class="w-50" enctype="multipart/form-data">
    @csrf
    @method('POST')
    <div class="form-group">
        <label for="tipoCabana">Tipo de cabaña</label>
        <select class="form-control js-example-basic-single" name="tipoCabana" id="tipoCabana">
            <option value="">Seleccione un tipo</option>
            @foreach($tipoCabanas as $tipoCabana)
                <option value="{{ $tipoCabana->id }}" {{ old("tipoCabana") == $tipoCabana->id ? 'selected' : '' }}>{{ $tipoCabana->nombre }}</option>
            @endforeach
        </select>
        @error('tipoCabana')
            <div class="alert alert-danger d-flex align-items-center" role="alert">
                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
                <div>
                    {{ $message }}
                </div>
            </div>
        @enderror
    </div>

    <div class="form-group">
        <label for="imagenCabana">Imagen</label>
        <input type="file" class="dropify" name="imagenCabana" id="imagenCabana" data-allowed-file-extensions="png jpg jpeg" data-max-file-size="1M" data-show-remove="false" data-show-errors="true" data-allowed-file-types="image/jpeg image/png image/jpg">
        @error('imagenCabana')
            <div class="alert alert-danger d-flex align-items-center" role="alert">
                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
                <div>
                    {{ $message }}
                </div>
            </div>
        @enderror
    </div>

    <div class="form-group">
        <label for="nombreImagen">Guardar como</label>
        <input type="text" name="nombreImagen" class="form-control" value="{{ old('nombreImagen') }}" id="nombreImagen" placeholder="Introduce el nombre">
        @error('nombreImagen')
            <div class="alert alert-danger d-flex align-items-center" role="alert">
                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
                <div>{{ $message }}</div>
            </div>
        @enderror
    </div>

    <button type="submit" class="btn btn-primary">Guardar</button>

    @if($errors->has('error'))
        <div class="alert alert-danger d-flex align-items-center" role="alert">
            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
            <div>{{ $message }}</div>
        </div>
    @endif
</form>


<a href="{{ route('imagenCabanas.index') }}" class="mt-3 btn btn-outline-secondary">
    <i class="fas fa-arrow-left"></i> Volver
</a>


@stop

@push('css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css" rel="stylesheet">
<style>
    .dropify-message>span>p{
        font-size : 18px;
    }
</style>
@endpush



@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"></script>
    <script>
            $('#imagenCabana').dropify({
                messages: {
                    'default': 'Arrastra y suelta un archivo aquí o haz clic',
                    'replace': 'Arrastra y suelta un archivo o haz clic para reemplazar',
                    'remove':  'Eliminar',
                    'error':   'Vaya, algo salió mal.'
                }
            });
    </script>
@endpush

