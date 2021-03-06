<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" data-backdrop="static"
    data-keyboard="false" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" id="formEmpleados" enctype="multipart/form-data">
                @method('PATCH')
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ $titulo }}</h5>
                    <button type="button" id="close-modal2" class="btn-close " data-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {{ $slot }}
                </div>
                <div class="modal-footer">
                    <button id="close-modal" type="button " class="btn btn-secondary"
                        data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">{{ $accion }}</button>
                </div>
        </div>
        </form>
    </div>
</div>
