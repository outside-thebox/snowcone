<div class="modal fade" id="pregunta-{{ $id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Atención</h4>
            </div>
            <div class="modal-body" id="contenido-pregunta-{{ $id }}">

            </div>
            <div class="modal-footer">
                <button id="cancelar" data-dismiss="modal" class="btn btn-success btn-sm">Cancelar</button>
                <button id="eliminar-{{ $id }}" class="btn btn-primary btn-sm">{{ $accion }}</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="confirmacion-{{ $id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Atención</h4>
            </div>
            <div class="modal-body" id="contenido-modal-{{ $id }}">
            </div>
            <div class="modal-footer" id="botones">
                <button id="Cerrar" data-dismiss="modal" class="btn btn-success btn-sm">Cerrar</button>
            </div>
        </div>
    </div>
</div>
