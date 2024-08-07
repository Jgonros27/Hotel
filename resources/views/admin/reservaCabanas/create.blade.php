@extends('layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Reservas de cabañas')
@section('content_header_title', 'Crear')
@section('content_header_subtitle', 'Reservas de cabañas')

{{-- Content body: main page content --}}

@section('content_body')

    <form action="{{ route('reservaCabanas.store') }}" method="POST" class="w-50">
        @csrf
        @method('POST')

        <div class="form-group">
            <label for="usuario">Usuario</label>
            <select class="form-control js-example-basic-single" name="usuario" id="usuario">
                <option value="">Seleccione un usuario</option>
                @foreach ($usuarios as $usuario)
                    <option value="{{ $usuario->id }}" {{ old('usuario') == $usuario->id ? 'selected' : '' }}>
                        {{ $usuario->email }}</option>
                @endforeach
            </select>
            @error('usuario')
                <div class="alert alert-danger d-flex align-items-center" role="alert">
                    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="danger:">
                        <use xlink:href="#exclamation-triangle-fill" />
                    </svg>
                    <div>
                        {{ $message }}
                    </div>
                </div>
            @enderror
        </div>

        <div class="form-group">
            <label for="tipoCabana">Tipo de cabaña</label>
            <select class="form-control js-example-basic-single" name="tipoCabana" id="tipoCabana">
                <option value="">Seleccione un tipo</option>
                @foreach ($tipoCabanas as $tipoCabana)
                    <option value="{{ $tipoCabana->id }}" {{ old('tipoCabana') == $tipoCabana->id ? 'selected' : '' }}>
                        {{ $tipoCabana->nombre }}</option>
                @endforeach
            </select>
            @error('tipoCabana')
                <div class="alert alert-danger d-flex align-items-center" role="alert">
                    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="danger:">
                        <use xlink:href="#exclamation-triangle-fill" />
                    </svg>
                    <div>
                        {{ $message }}
                    </div>
                </div>
            @enderror
        </div>

        <div class="form-group">
            <label for="fechaEntrada">Fecha de entrada</label>
            <input type="date" name="fechaEntrada" class="form-control" value="{{ old('fechaEntrada') }}"
                id="fechaEntrada" placeholder="Introduce la fecha de entrada">
            @error('fechaEntrada')
                <div class="alert alert-danger d-flex align-items-center" role="alert">
                    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="danger:">
                        <use xlink:href="#exclamation-triangle-fill" />
                    </svg>
                    <div>{{ $message }}</div>
                </div>
            @enderror
        </div>

        <div class="form-group">
            <label for="fechaSalida">Fecha de salida</label>
            <input type="date" name="fechaSalida" class="form-control" value="{{ old('fechaSalida') }}" id="fechaSalida"
                placeholder="Introduce la fecha de salida">
            @error('fechaSalida')
                <div class="alert alert-danger d-flex align-items-center" role="alert">
                    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="danger:">
                        <use xlink:href="#exclamation-triangle-fill" />
                    </svg>
                    <div>{{ $message }}</div>
                </div>
            @enderror
        </div>

        <div class="form-group">
            <label for="nHuespedes">Número de huéspedes</label>
            <input type="text" name="nHuespedes" class="form-control" value="{{ old('nHuespedes') }}" id="nHuespedes"
                placeholder="Introduce el número de huéspedes">
            @error('nHuespedes')
                <div class="alert alert-danger d-flex align-items-center" role="alert">
                    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="danger:">
                        <use xlink:href="#exclamation-triangle-fill" />
                    </svg>
                    <div>{{ $message }}</div>
                </div>
            @enderror
        </div>

        <div class="form-group form-check">
            <input type="checkbox" class="form-check-input" id="mediaPension" name="mediaPension"
                {{ old('mediaPension') ? 'checked' : '' }}>
            <label class="form-check-label" for="mediaPension">Media Pension</label>
        </div>

        <br>

        <button type="submit" class="btn btn-primary">Guardar</button>

        @if ($errors->has('error'))
            <div class="alert alert-danger d-flex align-items-center" role="alert">
                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="danger:">
                    <use xlink:href="#exclamation-triangle-fill" />
                </svg>
                <div>{{ $message }}</div>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger d-flex align-items-center" role="alert">
                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="danger:">
                    <use xlink:href="#exclamation-triangle-fill" />
                </svg>
                <div>{{ session('error') }}</div>
            </div>
        @endif

    </form>

    <a href="{{ route('reservaCabanas.index') }}" class="mt-3 btn btn-outline-secondary">
        <i class="fas fa-arrow-left"></i> Volver
    </a>

@stop
