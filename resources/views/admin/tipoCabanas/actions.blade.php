<a href="{{ route('tipoCabanas.edit', $tipoCabana->id) }}" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Editar">
    <svg xmlns="http://www.w3.org/2000/svg" height="20px" width="20px" viewBox="0 0 512 512"><path fill="#ffff" d="M441 58.9L453.1 71c9.4 9.4 9.4 24.6 0 33.9L424 134.1 377.9 88 407 58.9c9.4-9.4 24.6-9.4 33.9 0zM209.8 256.2L344 121.9 390.1 168 255.8 302.2c-2.9 2.9-6.5 5-10.4 6.1l-58.5 16.7 16.7-58.5c1.1-3.9 3.2-7.5 6.1-10.4zM373.1 25L175.8 222.2c-8.7 8.7-15 19.4-18.3 31.1l-28.6 100c-2.4 8.4-.1 17.4 6.1 23.6s15.2 8.5 23.6 6.1l100-28.6c11.8-3.4 22.5-9.7 31.1-18.3L487 138.9c28.1-28.1 28.1-73.7 0-101.8L474.9 25C446.8-3.1 401.2-3.1 373.1 25zM88 64C39.4 64 0 103.4 0 152V424c0 48.6 39.4 88 88 88H360c48.6 0 88-39.4 88-88V312c0-13.3-10.7-24-24-24s-24 10.7-24 24V424c0 22.1-17.9 40-40 40H88c-22.1 0-40-17.9-40-40V152c0-22.1 17.9-40 40-40H200c13.3 0 24-10.7 24-24s-10.7-24-24-24H88z"/></svg>
</a>

<a href="#"  class="btn btn-secondary mt-1" data-tipo-id="{{ $tipoCabana->id }}" data-toggle="tooltip"
    data-placement="top" title="Reservas de este tipo de cabaña">
    <svg xmlns="http://www.w3.org/2000/svg" height="20px" width="20px" viewBox="0 0 512 512">
        <path fill="#ffff" d="M448 64H64c-35.3 0-64 28.7-64 64v320c0 35.3 28.7 64 64 64h384c35.3 0 64-28.7 64-64V128c0-35.3-28.7-64-64-64zm16 384c0 8.8-7.2 16-16 16H64c-8.8 0-16-7.2-16-16V192h416v256zM64 144c-8.8 0-16 7.2-16 16v32c0 8.8 7.2 16 16 16h384c8.8 0 16-7.2 16-16v-32c0-8.8-7.2-16-16-16H64zm384 224H64v128h384V368zm-192 64h-64v-64h64v64zm128 0h-64v-64h64v64z"/>
    </svg>
</a>

<a href="#" class="btn btn-info mt-1" data-tipo-id="{{ $tipoCabana->id }}" data-toggle="tooltip"
    data-placement="top" title="Imagenes de este tipo de cabaña">
    <svg xmlns="http://www.w3.org/2000/svg" height="20px" width="20px" viewBox="0 0 512 512">
        <path fill="#ffff" d="M456 80h-88c-4.4 0-8-3.6-8-8V40c0-13.3-10.7-24-24-24H168c-13.3 0-24 10.7-24 24v32c0 4.4-3.6 8-8 8H56c-13.3 0-24 10.7-24 24v320c0 13.3 10.7 24 24 24h400c13.3 0 24-10.7 24-24V104c0-13.3-10.7-24-24-24zm-72-16h56v48h-56V64zM96 88h320v320H96V88zm104 296l-24-32 40-32 56 48h-72l-40 16zM312 336l-56-48-40 32-24 32h72l56-48zM456 400H56V120h72l40-16 56 48 40 32z"/>
    </svg>
</a>

<form id="deleteForm_{{ $tipoCabana->id }}" action="{{ route('tipoCabanas.destroy', $tipoCabana->id) }}" method="POST" style="display: inline-block;">
    @csrf
    @method('DELETE')
    <button type="button" class="btn btn-danger mt-1" onclick="confirmDelete('{{ $tipoCabana->id }}')" data-toggle="tooltip" data-placement="top" title="Eliminar">
        <svg xmlns="http://www.w3.org/2000/svg" height="20px" width="20px" viewBox="0 0 448 512"><path fill="#ffff" d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z"/></svg>        

    </button>
</form>

<script>
    function confirmDelete(tipoCabanaId) {
        Swal.fire({
            title: '¿Estás seguro?',
            text: '¡No podrás deshacer esto!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminarlo!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('deleteForm_' + tipoCabanaId).submit();
            }
        });
    }
</script>

<script>
    $(document).ready(function() {
        let baseUrl1 = "{!! route('reservaCabanas.index', ['tipoCabanaId' => 'TIPO_CABANA_PLACEHOLDER']) !!}"
        $('a.btn-secondary').click(function(e) {
            e.preventDefault();

            let tipoCabanaId = $(this).data('tipo-id');

            let url = baseUrl1.replace('TIPO_CABANA_PLACEHOLDER', encodeURIComponent(tipoCabanaId))

            window.location.href = url;
        });
    });
</script>

<script>
    $(document).ready(function() {
        let baseUrl2 = "{!! route('imagenCabanas.index', ['tipoCabanaId' => 'TIPO_CABANA_PLACEHOLDER']) !!}"
        $('a.btn-info').click(function(e) {
            e.preventDefault();

            let tipoCabanaId = $(this).data('tipo-id');

            let url = baseUrl2.replace('TIPO_CABANA_PLACEHOLDER', encodeURIComponent(tipoCabanaId))

            window.location.href = url;
        });
    });
</script>
