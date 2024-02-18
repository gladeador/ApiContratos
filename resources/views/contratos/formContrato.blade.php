<div class="modal-header">
    <h5 class="modal-title" id="insertarcontratoLabel">Agregar Contrato</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">

    <div class="form-group">
        <label for="organizacion_id">Organización</label>
        <select class="form-control" id="organizacion_id" name="organizacion_id">
            <option value="">Selecciona una organización</option>
            @foreach ($organizaciones as $organizacion)
            <option value="{{ $organizacion['id'] }}">{{ $organizacion['name'] }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label for="fecha_inicio">Fecha Inicio</label>
        <input type="date" class="form-control" name="fecha_inicio" id="fecha_inicio">
    </div>
    <div class="form-group">
        <label for="fecha_fin">Fecha Termino</label>
        <input type="date" class="form-control" name="fecha_fin" id="fecha_fin">
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
    <button type="submit" class="btn btn-primary">Guardar</button>
</div>