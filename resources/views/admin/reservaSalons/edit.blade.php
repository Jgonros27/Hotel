@extends('layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Reservas salones')
@section('content_header_title', 'Editar')
@section('content_header_subtitle', 'Reservas salones')

{{-- Content body: main page content --}}

@section('content_body')

    <form action="{{ route('reservaSalons.update', $reservaSalon->id) }}" method="POST" class="w-50">
        @csrf
        @method('PATCH')
        <div class="form-group">
            <label for="usuario">Usuario</label>
            <select class="form-control js-example-basic-single" name="usuario" id="usuario">
                <option value="">Seleccione un usuario</option>
                @foreach ($usuarios as $usuario)
                    <option value="{{ $usuario->id }}" {{ $reservaSalon->id_usuario == $usuario->id ? 'selected' : '' }}>
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
                    <option value="{{ $salon->id }}" {{ $reservaSalon->id_salon == $salon->id ? 'selected' : '' }}>
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
                <option value="comunion" {{ $reservaSalon->tipo_evento == 'comunion' ? 'selected' : '' }}>Comunión</option>
                <option value="bautizo" {{ $reservaSalon->tipo_evento == 'bautizo' ? 'selected' : '' }}>Bautizo</option>
                <option value="boda" {{ $reservaSalon->tipo_evento == 'boda' ? 'selected' : '' }}>Boda</option>
                <option value="cumpleaños" {{ $reservaSalon->tipo_evento == 'cumpleaños' ? 'selected' : '' }}>Cumpleaños
                </option>
                <option value="evento_empresarial"
                    {{ $reservaSalon->tipo_evento == 'evento_empresarial' ? 'selected' : '' }}>Evento Empresarial</option>
                <option value="otros" {{ $reservaSalon->tipo_evento == 'otros' ? 'selected' : '' }}>Otros</option>

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
            <input type="date" name="fechaEvento" class="form-control" value="{{ $reservaSalon->fecha_evento }}"
                id="fechaEvento" placeholder="Introduce la fecha del evento">
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
            <input type="time" name="horaInicio" class="form-control"
                value="{{ \Carbon\Carbon::createFromFormat('H:i:s', $reservaSalon->hora_inicio)->format('H:i') }}"
                id="horaInicio">
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
            <input type="time" name="horaFin" class="form-control"
                value="{{ \Carbon\Carbon::createFromFormat('H:i:s', $reservaSalon->hora_fin)->format('H:i') }}"
                id="horaFin">
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
            <textarea name="mensaje" class="form-control" id="mensaje" rows="4">{{ $reservaSalon->mensaje }}</textarea>
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
