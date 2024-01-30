<div class="modal-body">
    <div class="form-group">
        <label>NOMBRE</label>
        <input type="text" id="nombreEdita" name="nombreEdita" class="form-control" placeholder="Ingrese el Nombre" required
            pattern="^[a-zA-Z_áéíóúñ\s]{0,30}$">
    </div>
    <div class="form-group">
        <label>DOCUMENTO</label>

        <select class="form-control" name="tipo_documentoEdita" id="tipo_documentoEdita">

            <option value="0" selected>Seleccione</option>
            <option value="CDI">Cedula de Identidad</option>
            <option value="PASAPORTE">Pasaporte</option>

        </select>
    </div>
    <div class="DOC1">
        <div class="form-group">
            <label>NUMERO DE DOCUMENTO</label>
            <input type="text" id="pasaporteEdita" name="pasaporteEdita" class="form-control"
                placeholder="Ingrese el número documento" pattern="[0-9]{0,15}">
        </div>
    </div>
    <div class="DOC2">
        <div class="form-group">
            <label>RUT</label>
            <input type="text" id="rutEdita" name="rutEdita" oninput="checkRut(this)" placeholder="Ingrese RUT"
                class="form-control BuscarSiExisteRut">
            <div id="mostrarRut"></div>
        </div>
    </div>
    <div class="form-group">
        <label>DIRECCION</label>
        <input type="text" id="direccionEdita" name="direccionEdita" class="form-control" placeholder="Ingrese la dirección">
    </div>
    <div class="form-group">
        <label>TELEFONO</label>
        <input type="tel" id="telefonoEdita" name="telefonoEdita" class="form-control" placeholder="Ingrese el telefono">
    </div>
    <div class="form-group">
        <label>EMAIL</label>
        <input type="email" class="form-control" ruta="{{URL::to('user')}}" id="emailUserEdita"
            name="emailUserEdita" placeholder="Ingrese el correo" autocomplete="new-text" disabled>
        <div id="mostrarImagen"></div>
    </div>
    <div class="form-group">
        <label>Perfil</label>
        <select class="form-control" name="id_profileEdita" id="id_profileEdita" required>

            <option value="0" selected>Seleccione</option>
            @foreach($profiles as $profile)

            <option value="{{$profile->id}}" {{ ( $profile->id == $user->profile_id ) ? 'selected' : '' }}>
                {{$profile->nombre}}</option>

            @endforeach

        </select>
    </div>
    <div class="form-group">
        <label>PASSWORD</label>
        <input type="password" id="passwordEdita" name="passwordEdita" class="form-control" placeholder="Ingrese el password" autocomplete="new-password">
    </div>
    <div class="form-group">
        <label>IMAGEN</label>
        <img src="{{asset('img/usuario/default/anonymous.png')}}" class="img-thumbnail previsualizar" width="50px">
        <input type="file" id="imagenEdita" name="imagenEdita" class="form-control">
    </div>
</div>
<div class="modal-footer justify-content-between">
    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
    <button type="submit" class="btn btn-primary btnEditarUsuario">Guardar</button>
</div>
