@extends('layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Disponibilidad cabañas')
@section('content_header_title', 'Ver')
@section('content_header_subtitle', 'Disponibilidad de cabañas')

{{-- Content body: main page content --}}

@section('content_body')

    <form action="{{ route('reservaCabanas.disponibilidad') }}" method="POST" class="w-50 mb-4">
        @csrf
        @method('POST')

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

        <button type="submit" class="btn btn-primary">Consultar</button>

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


    @if (isset($cabanasLibresPorTipo))
        <br>
        <h4>Desde el día {{\Carbon\Carbon::parse($fechaEntrada)->format('d/m/Y')}} hasta el día {{\Carbon\Carbon::parse($fechaSalida)->format('d/m/Y')}} hay las siguientes cabañas disponibles:</h4>
        <ul>
            @foreach ($cabanasLibresPorTipo as $tipo => $cabanasLibres)
                <li>{{$tipo}} : {{$cabanasLibres}}</li>
            @endforeach
        </ul> 
    @endif

@stop
