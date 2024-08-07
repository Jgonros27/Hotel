@extends('layouts.appHotel')

@section('content')
    <div id="textoPresentación" class="container">
        <h1 class="mt-5">{{ __('sobreAyuda.sobrePresentacionTitulo') }}</h1>
        <div class="row mt-5">
            <div class="col-md-7 texto">
                <p>{{ __('sobreAyuda.sobrePresentacionTexto') }}</p>
                <img id="presentacionImg" src="{{ asset('images/hotel/trassierra.png') }}" alt="Imagen" class="md-ms-5 w-50">
            </div>
            <div class="col-md-5">
                <img id="presentacionImg" src="{{ asset('images/hotel/juan.JPG') }}" alt="Imagen" class="md-ms-5 w-100">
            </div>
        </div>
    </div>
@endsection

@push('css')
    <style>
        .texto {
            font-size: 18px
        }
    </style>
@endpush
