@extends('layouts.appHotel')

@section('content')
<div id="textoPresentación" class="container">
    <h1 class="mt-5">{{ __('sobreAyuda.ayudaPresentacionTitulo') }}</h1>
    <div class="row mt-5">

        @auth
        <div class="mt-4 col-md-7 texto">
            <p>{{ __('sobreAyuda.ayudaPresentacionTexto2') }}</p>
            <div class="video-responsive">
                <iframe src="https://www.youtube.com/embed/vj6ZXXlyldI?si=5fwkrYiIkQOKbelx" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
            </div>
        </div>
        @else
        <div class="col-md-7 texto">
            <p>{{ __('sobreAyuda.ayudaPresentacionTexto') }}</p>
            <div class="video-responsive">
                <iframe src="https://www.youtube.com/embed/alyZMqk5xGA?si=5k10zHlG-qFXhA13" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
            </div>
        </div>
        @endauth

        <br>
    </div>
</div>
@endsection

@push('css')
<style>
    .texto {
        font-size: 18px;
        margin-bottom:35px
    }

    .video-responsive {
        height: 0;
        overflow: hidden;
        padding-bottom: 56.25%;
        padding-top: 30px;
        position: relative;
    }

    .video-responsive iframe,
    .video-responsive object,
    .video-responsive embed {
        height: 100%;
        left: 0%;
        position: absolute;
        width: 100%;
    }
</style>
@endpush