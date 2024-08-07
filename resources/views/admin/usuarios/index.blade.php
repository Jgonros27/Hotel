@extends('layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Usuarios')
@section('content_header_title', 'Ver')
@section('content_header_subtitle', 'Usuarios')

{{-- Content body: main page content --}}

@section('content_body')
    <div class="container">
        <div class="card">
            <div class="card-header">Gestionar Usuarios</div>
            <div class="card-body">
                {{ $dataTable->table() }}
            </div>
        </div>
    </div>
@stop

@push('scripts')
    {{ $dataTable->scripts() }}
    
@endpush
