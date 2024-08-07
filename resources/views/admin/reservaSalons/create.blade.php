@extends('layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Reservas de salones')
@section('content_header_title', 'Crear')
@section('content_header_subtitle', 'Reservas de salones')

{{-- Content body: main page content --}}

@section('content_body')

    <form action="{{ route('reservaSalons.store') }}" method="POST" class="w-50">
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
            <label for="salon">Salon</label>
            <select class="form-control js-example-basic-single" name="salon" id="salon">
                <option value="">Seleccione un salon</option>
                @foreach ($salons as $salon)
                    <option value="{{ $salon->id }}" {{ old('salon') == $salon->id ? 'selected' : '' }}>
                        {{ $salon->nombre }}</option>
                @endforeach
            </select>
            @error('salon')
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
            <label for="tipoEvento">tipo de evento</label>
            <select class="form-control js-example-basic-single" name="tipoEvento" id="tipoEvento">
                <option value="">Seleccione un tipo de evento</option>
                <option value="comunion">Comunión</option>
                <option value="bautizo">Bautizo</option>
                <option value="boda">Boda</option>
                <option value="cumpleaños">Cumpleaños</option>
                <option value="evento_empresarial">Evento Empresarial</option>
                <option value="otros">Otros</option>

            </select>
            @error('tipoEvento')
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

        <div class="form-group">
            <label for="mensaje">Mensaje</label>
            <textarea name="mensaje" class="form-control" id="mensaje" rows="4">{{ old('mensaje') }}</textarea>
            @error('mensaje')
                <div class="alert alert-danger d-flex align-items-center" role="alert">
                    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="danger:">
                        <use xlink:href="#exclamation-triangle-fill" />
                    </svg>
                    <div>{{ $message }}</div>
                </div>
            @enderror
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

    <a href="{{ route('reservaSalons.index') }}" class="mt-3 btn btn-outline-secondary">
        <i class="fas fa-arrow-left"></i> Volver
    </a>


@stop
