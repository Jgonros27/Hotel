@extends('layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Salones')
@section('content_header_title', 'Editar')
@section('content_header_subtitle', 'Salones')

{{-- Content body: main page content --}}

@section('content_body')

<form action="{{ route('salons.update', $salon->id) }}" method="POST" class="w-50">
    @csrf
    @method('PATCH')
    <div class="form-group">
        <label for="nombre">Nombre</label>
        <input type="text" name="nombre" class="form-control" value="{{ $salon->nombre }}" id="nombre"
            placeholder="Introduce el nombre">
        @error('nombre')
            <div class="alert alert-danger d-flex align-items-center" role="alert">
                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="danger:">
                    <use xlink:href="#exclamation-triangle-fill" />
                </svg>
                <div>{{ $message }}</div>
            </div>
        @enderror
    </div>

    <div class="form-group">
        <label for="descripcion">Descripcion</label>
        <input type="text" name="descripcion" class="form-control" value="{{ $salon->descripcion }}" id="descripcion"
            placeholder="Introduce la descripcion">
        @error('descripcion')
            <div class="alert alert-danger d-flex align-items-center" role="alert">
                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="danger:">
                    <use xlink:href="#exclamation-triangle-fill" />
                </svg>
                <div>{{ $message }}</div>
            </div>
        @enderror
    </div>

    <div class="form-group">
        <label for="precio_hora">Precio por hora</label>
        <input type="text" name="precio_hora" class="form-control" value="{{ $salon->precio_hora }}" id="precio_hora"
            placeholder="Introduce el precio por hora">
        @error('precio_hora')
            <div class="alert alert-danger d-flex align-items-center" role="alert">
                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="danger:">
                    <use xlink:href="#exclamation-triangle-fill" />
                </svg>
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

<a href="{{ route('salons.index') }}" class="mt-3 btn btn-outline-secondary">
    <i class="fas fa-arrow-left"></i> Volver
</a>
@stop

