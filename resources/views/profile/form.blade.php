<div class="modal-body">
    <div class="form-group">
        <label>Nombre</label>
        <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ingrese Nombre" required
            pattern="^[a-zA-Z_áéíóúñ\s]{0,30}$">
    </div>
    <div class="form-group">
        <label>Descripción</label>
        <input type="text" class="form-control" id="descripcion" name="descripcion" placeholder="Ingrese Descripción"
            required pattern="^[a-zA-Z_áéíóúñ\s]{0,30}$">
    </div>
</div>
<div class="modal-footer justify-content-between">
    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
    <button type="submit" class="btn btn-primary">Guardar</button>
</div>
