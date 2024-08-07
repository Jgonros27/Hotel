@extends('layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Usuarios')
@section('content_header_title', 'Editar')
@section('content_header_subtitle', 'Usuarios')

{{-- Content body: main page content --}}

@section('content_body')

<form action="{{ route('usuarios.update', $usuario->id) }}" method="POST" class="w-50">
    @csrf
    @method('PATCH')
    <div class="form-group">
        <label for="name">Nombre</label>
        <input type="text" name="name" class="form-control" value="{{ $usuario->name }}" id="name" placeholder="Introduce el nombre">
        @error('name')
            <div class="alert alert-danger d-flex align-items-center" role="alert">
                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
                <div>{{ $message }}</div>
            </div>
        @enderror
    </div>

    <div class="form-group">
        <label for="email">Correo electrónico</label>
        <input type="text" name="email" class="form-control" value="{{ $usuario->email }}" id="email" placeholder="Introduce el correo electrónico">
        @error('email')
            <div class="alert alert-danger d-flex align-items-center" role="alert">
                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
                <div>{{ $message }}</div>
            </div>
        @enderror
    </div>

    <div class="form-group">
        <label for="password">Contraseña</label>
        <input type="text" name="password" class="form-control" id="password" placeholder="Introduce la contraseña">
        @error('password')
            <div class="alert alert-danger d-flex align-items-center" role="alert">
                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
                <div>{{ $message }}</div>
            </div>
        @enderror
    </div>

    <div class="form-group">
        <label for="password_confirmation">Confirmar contraseña</label>
        <input type="password" name="password_confirmation" class="form-control" id="password_confirmation" placeholder="Confirma la contraseña">
        @error('password_confirmation')
            <div class="alert alert-danger d-flex align-items-center" role="alert">
                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
                <div>{{ $message }}</div>
            </div>
        @enderror
    </div>

    <div class="form-group form-check">
        <input type="checkbox" class="form-check-input" id="admin" name="admin" {{ $usuario->admin ? 'checked' : '' }}>
        <label class="form-check-label" for="admin">¿Es administrador?</label>
    </div>

    <input type="hidden" name="user_id" value="{{ $usuario->id }}">
    <br>
    <button type="submit" class="btn btn-primary">Guardar</button>

    @if($errors->has('error'))
        <div class="alert alert-danger d-flex align-items-center" role="alert">
            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
            <div>{{ $message }}</div>
        </div>
    @endif
</form>

<a href="{{ route('tipoCabanas.index') }}" class="mt-3 btn btn-outline-secondary">
    <i class="fas fa-arrow-left"></i> Volver
</a>

@stop

