@extends('layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Tipos de Cabañas')
@section('content_header_title', 'Ver')
@section('content_header_subtitle', 'Tipos de Cabañas')

{{-- Content body: main page content --}}

@section('content_body')
    <div class="container">
        <div class="card">
            <div class="card-header">Gestionar Tipos De Cabañas</div>
            <div class="card-body">
                {{ $dataTable->table() }}
            </div>
        </div>
    </div>
@stop

@push('scripts')
    {{ $dataTable->scripts() }}
    
@endpush
