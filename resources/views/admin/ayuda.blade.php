@extends('layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Ayuda')
@section('content_header_title', 'Ver')
@section('content_header_subtitle', 'Ayuda')

{{-- Content body: main page content --}}

@section('content_body')
<div class="container">
    <div class="mt-4 col-md-7 texto">
        <p>{{ __('sobreAyuda.ayudaPresentacionTexto3') }}</p>
        <div class="video-responsive">
            <iframe src="https://www.youtube.com/embed/rbN3EOY4TuQ?si=YW2NCCraZwxuC6R0" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
        </div>
    </div>
</div>
@stop

@push('css')
<style>
    .texto {
        font-size: 18px
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