@extends('layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Reseñas')
@section('content_header_title', 'Crear')
@section('content_header_subtitle', 'Reseñas')

{{-- Content body: main page content --}}

@section('content_body')

    <form action="{{ route('resenas.store') }}" method="POST" class="w-50">
        @csrf
        @method('POST')

        <div class="form-group">
            <label for="usuario">Usuario</label>
            <select class="form-control js-example-basic-single" name="usuario" id="usuario">
                <option value="">Seleccione un usuario</option>
                @foreach ($usuarios as $usuario)
                    <option value="{{ $usuario->id }}" {{ old('usuario') == $usuario->id ? 'selected' : '' }}>
                        {{ $usuario->name }}</option>
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
            <label>Puntuación</label><br>
            <div class="rating">
                @for ($i = 5; $i >= 1; $i--)
                    <input type="radio" id="star{{ $i }}" name="puntuacion" value="{{ $i }}"
                        {{ old('puntuacion') == $i ? 'checked' : '' }}>
                    <label title="text" for="star{{ $i }}"></label>
                @endfor
            </div>
            @error('puntuacion')
                <div class="alert alert-danger d-flex align-items-center mt-2" role="alert">
                    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="danger:">
                        <use xlink:href="#exclamation-triangle-fill" />
                    </svg>
                    <div>{{ $message }}</div>
                </div>
            @enderror
        </div>

        <br>
        <br>

        <div class="form-group">
            <label for="comentario">Comentario</label>
            <textarea name="comentario" class="form-control" id="comentario" rows="4">{{ old('comentario') }}</textarea>
            @error('comentario')
                <div class="alert alert-danger d-flex align-items-center" role="alert">
                    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="danger:">
                        <use xlink:href="#exclamation-triangle-fill" />
                    </svg>
                    <div>{{ $message }}</div>
                </div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Guardar</button>

        @if ($errors->has('error'))
            <div class="alert alert-danger d-flex align-items-center" role="alert">
                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="danger:">
                    <use xlink:href="#exclamation-triangle-fill" />
                </svg>
                <div>{{ $message }}</div>
            </div>
        @endif
    </form>

    <a href="{{ route('resenas.index') }}" class="mt-3 btn btn-outline-secondary">
        <i class="fas fa-arrow-left"></i> Volver
    </a>


@stop

@push('css')
    <style>
        .rating{
            width: fit-content;
        }
        .rating:not(:checked)>label {
            float: right;
            cursor: pointer;
            font-size: 30px;
            color: #666;
        }

        .rating:not(:checked)>label::before {
            content: '★';
            font-size: 40px;
        }

        .rating>input {
            display: none;
        }

        .rating>input:checked~label {
            color: #e58e09;
        }

        .rating>input:checked~label:hover,
        .rating>input:checked~label:hover~label {
            color: #e58e09;
        }

        .rating>label:hover~input:checked~label {
            color: #ff9e0b;
        }

        .rating>input:checked~label:hover,
        .rating>input:checked~label:hover~label,
        .rating>label:hover~input:checked~label {
            color: #ff9e0b;
        }
    </style>
@endpush
