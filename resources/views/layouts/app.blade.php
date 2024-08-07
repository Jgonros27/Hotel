@extends('adminlte::page')

{{-- Extend and customize the browser title --}}

@section('title')
    {{ config('adminlte.title') }}
    @hasSection('subtitle') | @yield('subtitle') @endif
@stop

{{-- Extend and customize the page content header --}}

@section('content_header')
    @hasSection('content_header_title')
        <h1 class="text-muted">
            @yield('content_header_title')

            @hasSection('content_header_subtitle')
                <small class="text-dark">
                    <i class="fas fa-xs fa-angle-right text-muted"></i>
                    @yield('content_header_subtitle')
                </small>
            @endif
        </h1>
    @endif
@stop

{{-- Rename section content to content_body --}}

@section('content')
    @yield('content_body')
    @stack('scripts')
    @if(session()->has('success'))
        <div id="successMessage" class="alert alert-success alert-dismissible fade show position-fixed top-0 end-0 mt-5 me-5" role="alert">
            <strong>{{ session()->get('success') }}</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    
@stop


{{-- Add common CSS customizations --}}

@push('css')

@vite(['resources/sass/app.scss', 'resources/js/app.js'])
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<style>
    
    #successMessage{
        margin-top: 80px;
        margin-right: 50px;
        z-index: 1050;
    }
</style>
<style>
    .select2-container .select2-selection--single {
        height: 38px;
    }
</style>

@endpush

@push('js')

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.js-example-basic-single').select2({
            placeholder: 'Seleccione una opcion',
            language: {
                noResults: function () { return 'No se encontraron resultados'; },
                searching: function () { return 'Buscando...'; }
            }
        });
    });
</script>
<script src="https://cdn.datatables.net/plug-ins/2.0.3/i18n/es-ES.json"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var successMessage = document.getElementById('successMessage');
        if (successMessage) {
            setTimeout(function() {
                successMessage.classList.add('hide');
                setTimeout(function() {
                    successMessage.remove();
                }, 300);
            }, 4000);
        }
    });
</script>



@endpush

