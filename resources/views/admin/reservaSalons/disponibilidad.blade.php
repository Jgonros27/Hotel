@extends('layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Disponibilidad salones')
@section('content_header_title', 'Ver')
@section('content_header_subtitle', 'Disponibilidad de salones')

{{-- Content body: main page content --}}

@section('content_body')

    <form action="{{ route('reservaSalons.disponibilidad') }}" method="POST" class="w-50 mb-4">
        @csrf
        @method('POST')

        <div class="form-group">
            <label for="fechaEvento">Fecha del evento</label>
            <input type="date" name="fechaEvento" class="form-control" value="{{ old('fechaEvento') }}" id="fechaEvento"
                placeholder="Introduce la fecha del evento">
            @error('fechaEvento')
                <div class="alert alert-danger d-flex align-items-center" role="alert">
                    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="danger:">
                        <use xlink:href="#exclamation-triangle-fill" />
                    </svg>
                    <div>{{ $message }}</div>
                </div>
            @enderror
        </div>



        <div class="form-group">
            <label for="horaInicio">Hora de inicio</label>
            <input type="time" name="horaInicio" class="form-control" value="{{ old('horaInicio') }}" id="horaInicio"
                placeholder="Introduce la hora de inicio">
            @error('horaInicio')
                <div class="alert alert-danger d-flex align-items-center" role="alert">
                    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="danger:">
                        <use xlink:href="#exclamation-triangle-fill" />
                    </svg>
                    <div>{{ $message }}</div>
                </div>
            @enderror
        </div>

        <div class="form-group">
            <label for="horaFin">Hora de fin</label>
            <input type="time" name="horaFin" class="form-control" value="{{ old('horaFin') }}" id="horaFin"
                placeholder="Introduce la hora de fin">
            @error('horaFin')
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

    @if (isset($salonesDisponibles))
        <h4>Salones Disponibles el dia {{ \Carbon\Carbon::parse($fechaEvento)->format('d/m/Y') }} desde las
            {{ \Carbon\Carbon::parse($horaInicio)->format('H:i') }} hasta las
            {{ \Carbon\Carbon::parse($horaFin)->format('H:i') }}:</h4>
        <ul>
            @forelse ($salonesDisponibles as $salon)
                <li>{{ $salon }}</li>
            @empty
                <li>No hay salones disponibles en el rango horario especificado.</li>
            @endforelse
        </ul>
    @endif

    

@stop
