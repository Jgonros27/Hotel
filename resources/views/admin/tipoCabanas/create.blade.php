@extends('layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Tipos de cabañas')
@section('content_header_title', 'Crear')
@section('content_header_subtitle', 'Tipos de cabañas')

{{-- Content body: main page content --}}

@section('content_body')

    <form action="{{ route('tipoCabanas.store') }}" method="POST" class="w-75 mx-auto">
        @csrf
        @method('POST')
        
        <div class="row">
            {{-- Primera columna --}}
            <div class="col-md-6">

                <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input type="text" name="nombre" class="form-control" value="{{ old('nombre') }}" id="nombre"
                        placeholder="Introduce el nombre">
                    @error('nombre')
                        <div class="alert alert-danger d-flex align-items-center" role="alert">
                            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="danger:">
                                <use xlink:href="#exclamation-triangle-fill" />
                            </svg>
                            <div>{{ $message }}</div>
                        </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="precio">Precio</label>
                    <input type="text" name="precio" class="form-control" value="{{ old('precio') }}" id="precio"
                        placeholder="Introduce el precio">
                    @error('precio')
                        <div class="alert alert-danger d-flex align-items-center" role="alert">
                            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="danger:">
                                <use xlink:href="#exclamation-triangle-fill" />
                            </svg>
                            <div>{{ $message }}</div>
                        </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="capacidad">Capacidad máxima</label>
                    <input type="text" name="capacidad" class="form-control" id="capacidad" value="{{ old('capacidad') }}"
                        placeholder="Introduce la capacidad">
                    @error('capacidad')
                        <div class="alert alert-danger d-flex align-items-center" role="alert">
                            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="danger:">
                                <use xlink:href="#exclamation-triangle-fill" />
                            </svg>
                            <div>{{ $message }}</div>
                        </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="nuevoServicio">Añadir servicio</label>
                    <div class="input-group">
                        <input type="text" id="nuevoServicio" name="servicios[]" class="form-control"
                            placeholder="Introduce un servicio">
                        <div class="input-group-append">
                            <button type="button" id="btn-add-servicio" class="btn btn-primary"><i class="bi bi-plus"></i></button>
                        </div>
                    </div>
                </div>

                <div id="servicios-container" class="d-flex flex-wrap">
                    {{-- Los servicios se añadirán aquí --}}
                </div>

                <input type="hidden" id="serviciosHidden" name="servicios" value="{{ old('servicios') }}">

            </div>
            {{-- Segunda columna --}}
            <div class="col-md-6">

                <div class="form-group">
                    <label for="precio_media_pension">Precio de la media pension</label>
                    <input type="text" name="precio_media_pension" class="form-control" id="precio_media_pension"
                        placeholder="Introduce el precio de la media pension" value="{{ old('precio_media_pension') }}">
                    @error('precio_media_pension')
                        <div class="alert alert-danger d-flex align-items-center" role="alert">
                            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="danger:">
                                <use xlink:href="#exclamation-triangle-fill" />
                            </svg>
                            <div>{{ $message }}</div>
                        </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="dias_cancelacion">Dias de cancelación</label>
                    <input type="text" name="dias_cancelacion" class="form-control" id="dias_cancelacion"
                        placeholder="Introduce los días de cancelación" value="{{ old('dias_cancelacion') }}">
                    @error('dias_cancelacion')
                        <div class="alert alert-danger d-flex align-items-center" role="alert">
                            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="danger:">
                                <use xlink:href="#exclamation-triangle-fill" />
                            </svg>
                            <div>{{ $message }}</div>
                        </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="especificaciones">Especificaciones</label>
                    <textarea name="especificaciones" class="form-control" id="especificaciones" rows="4" 
                              placeholder="Introduce las especificaciones">{{ old('especificaciones') }}</textarea>
                    @error('especificaciones')
                        <div class="alert alert-danger d-flex align-items-center" role="alert">
                            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="danger:">
                                <use xlink:href="#exclamation-triangle-fill" />
                            </svg>
                            <div>{{ $message }}</div>
                        </div>
                    @enderror
                </div>

            </div>
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
    <a href="{{ route('tipoCabanas.index') }}" class="mt-3 btn btn-outline-secondary">
        <i class="fas fa-arrow-left"></i> Volver
    </a>

@stop

@push('css')
    <style>
        .servicio {
            flex-shrink: 0;
            margin-bottom: 0.5rem;
            max-height: 30px; /* Altura máxima para cada div de servicio */
            overflow: hidden; /* Para recortar el contenido si excede la altura máxima */
        }

        .btn-remove {
            padding: 0.3rem 0.5rem;
        }
    </style>
@endpush

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
    const btnAddServicio = document.getElementById('btn-add-servicio');
    const nuevoServicioInput = document.getElementById('nuevoServicio');
    const serviciosContainer = document.getElementById('servicios-container');
    const serviciosHidden = document.getElementById('serviciosHidden');
    
    // Obtener el valor de servicios desde el input oculto
    const serviciosValue = serviciosHidden.value;
    
    // Separar los servicios por ;
    const serviciosArray = serviciosValue.split(';').filter(Boolean); // filter para eliminar posibles strings vacíos
    
    // Añadir los servicios al div servicios-container al cargar la página
    serviciosArray.forEach(function(servicio) {
        addServicioToContainer(servicio);
    });

    btnAddServicio.addEventListener('click', function() {
        const servicioValue = nuevoServicioInput.value.trim();

        if (servicioValue !== '') {
            addServicioToContainer(servicioValue);

            // Actualizar el input oculto con los nuevos servicios
            serviciosArray.push(servicioValue);
            serviciosHidden.value = serviciosArray.join(';');

            nuevoServicioInput.value = '';
        }
    });

    function addServicioToContainer(servicio) {
        const servicioDiv = document.createElement('div');
        servicioDiv.className = 'servicio mb-2 mr-2 pl-2 d-flex align-items-center';
        servicioDiv.style.border = '1px solid #ccc';
        servicioDiv.style.borderRadius = '0.25rem';

        const servicioText = document.createElement('span');
        servicioText.textContent = servicio;

        const btnRemove = document.createElement('button');
        btnRemove.type = 'button';
        btnRemove.className = 'btn btn-secondary btn-remove ml-2';
        btnRemove.innerHTML = '<i class="bi bi-x-lg"></i>';
        btnRemove.addEventListener('click', function() {
            serviciosContainer.removeChild(servicioDiv);
            
            // Eliminar el servicio del array y actualizar el input oculto
            const index = serviciosArray.indexOf(servicio);
            if (index > -1) {
                serviciosArray.splice(index, 1);
                serviciosHidden.value = serviciosArray.join(';');
            }
        });

        servicioDiv.appendChild(servicioText);
        servicioDiv.appendChild(btnRemove);

        serviciosContainer.appendChild(servicioDiv);
    }
});

    </script>
@endpush
