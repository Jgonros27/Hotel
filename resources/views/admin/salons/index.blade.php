@extends('layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Salones')
@section('content_header_title', 'Ver')
@section('content_header_subtitle', 'Salones')

{{-- Content body: main page content --}}

@section('content_body')
    <div class="container">
        <div class="card">
            <div class="card-header">Gestionar Salones</div>
            <div class="card-body">
                {{ $dataTable->table() }}
            </div>
        </div>
    </div>
@stop

@push('scripts')
    {{ $dataTable->scripts() }}
    
@endpush
