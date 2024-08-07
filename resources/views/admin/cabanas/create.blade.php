@extends('layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Cabañas')
@section('content_header_title', 'Crear')
@section('content_header_subtitle', 'Cabañas')

{{-- Content body: main page content --}}

@section('content_body')

<form action="{{route('cabanas.store')}}" method="POST" class="w-50">
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

    <button type="submit" class="btn btn-primary">Guardar</button>

    @if($errors->has('error'))
        <div class="alert alert-danger d-flex align-items-center" role="alert">
            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
            <div>{{ $message }}</div>
        </div>
    @endif
</form>

<a href="{{route('cabanas.index')}}" class="mt-3 btn btn-outline-secondary">
    <i class="fas fa-arrow-left"></i> Volver
</a>


@stop

