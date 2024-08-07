@extends('layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Ofertas')
@section('content_header_title', 'Editar')
@section('content_header_subtitle', 'Ofertas')

{{-- Content body: main page content --}}

@section('content_body')

<form action="{{ route('ofertas.update', $oferta->id) }}" method="POST" class="w-50" enctype="multipart/form-data">
    @csrf
    @method('PATCH')
    <div class="form-group">
        <label for="tipoCabana">Tipo de cabaña</label>
        <select class="form-control js-example-basic-single" name="tipoCabana" id="tipoCabana">
            <option value="">Seleccione un tipo</option>
            @foreach($tipoCabanas as $tipoCabana)
                <option value="{{ $tipoCabana->id }}" {{ $oferta->id_tipo_cabana == $tipoCabana->id ? 'selected' : '' }}>{{ $tipoCabana->nombre }}</option>
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
        <label for="descuento">Descuento</label>
        <input type="text" name="descuento" class="form-control" value="{{ $oferta->descuento }}" id="descuento" placeholder="Introduce el descuento %">
        @error('descuento')
            <div class="alert alert-danger d-flex align-items-center" role="alert">
                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
                <div>{{ $message }}</div>
            </div>
        @enderror
    </div>

    <div class="form-group">
        <label for="fechaInicio">Fecha de inicio</label>
        <input type="date" name="fechaInicio" class="form-control" value="{{ $oferta->fecha_inicio }}" id="fechaInicio">
        @error('fechaInicio')
            <div class="alert alert-danger d-flex align-items-center" role="alert">
                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
                <div>{{ $message }}</div>
            </div>
        @enderror
    </div>

    <div class="form-group">
        <label for="fechaFin">Fecha de Fin</label>
        <input type="date" name="fechaFin" class="form-control" value="{{ $oferta->fecha_fin }}" id="fechaFin">
        @error('fechaFin')
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


<a href="{{ route('ofertas.index') }}" class="mt-3 btn btn-outline-secondary">
    <i class="fas fa-arrow-left"></i> Volver
</a>


@stop




