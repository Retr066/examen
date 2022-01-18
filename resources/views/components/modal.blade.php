
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form method="POST" id="formEmpleados">
            @method('PATCH')
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">{{ $titulo}}</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            {{ $slot }}
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-primary">{{ $accion}}</button>
        </div>
      </div>
    </form>
    </div>
  </div>
