<div class="modal-body">
    <div class="form-group">
        <label>NOMBRE</label>
        <input type="text" id="nombre" name="nombre" class="form-control" placeholder="Ingrese el Nombre" required
            pattern="^[a-zA-Z_áéíóúñ\s]{0,30}$">
    </div>
    <div class="form-group">
        <label>DOCUMENTO</label>

        <select class="form-control" name="tipo_documento" id="tipo_documento">

            <option value="0" selected>Seleccione</option>
            <option value="CDI">Cedula de Identidad</option>
            <option value="PASAPORTE">Pasaporte</option>

        </select>
    </div>
    <div class="DOC1">
        <div class="form-group">
            <label>NUMERO DE DOCUMENTO</label>
            <input type="text" id="pasaporte" name="pasaporte" class="form-control"
                placeholder="Ingrese el número documento" pattern="[0-9]{0,15}">
        </div>
    </div>
    <div class="DOC2">
        <div class="form-group">
            <label>RUT</label>
            <input type="text" id="rut" name="rut" oninput="checkRut(this)" placeholder="Ingrese RUT"
                class="form-control BuscarSiExisteRut">
            <div id="mostrarRut"></div>
        </div>
    </div>
    <div class="form-group">
        <label>DIRECCION</label>
        <input type="text" id="direccion" name="direccion" class="form-control" placeholder="Ingrese la dirección"
            pattern="^[a-zA-Z0-9_áéíóúñ°\s]{0,200}$">
    </div>
    <div class="form-group">
        <label>TELEFONO</label>
        <input type="text" id="telefono" name="telefono" class="form-control" placeholder="Ingrese el telefono"
            pattern="[0-9]{0,15}">
    </div>
    <div class="form-group">
        <label>EMAIL</label>
        <input type="email" class="form-control BuscarSiExisteEmail" ruta="{{URL::to('user')}}" id="emailUser"
            name="emailUser" placeholder="Ingrese el correo" autocomplete="new-text">
        <div id="mostrarImagen"></div>
    </div>
    <div class="form-group">
        <label>Perfil</label>
        <select class="form-control" name="id_profile" id="id_profile" required>

            <option value="0" selected>Seleccione</option>
            @foreach($profiles as $profile)

            <option value="{{$profile->id}}">
                {{$profile->nombre}}
            </option>

            @endforeach

        </select>
    </div>
    <div class="form-group">
        <label>PASSWORD</label>
        <input type="password" id="password" name="password" class="form-control" placeholder="Ingrese el password" autocomplete="new-password"
            required>
    </div>
    <div class="form-group">
        <label>IMAGEN</label>
        <img src="{{asset('img/usuario/default/anonymous.png')}}" class="img-thumbnail previsualizar" width="50px">
        <input type="file" id="imagen" name="imagen" class="form-control">
    </div>
</div>
<div class="modal-footer justify-content-between">
    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
    <button type="submit" class="btn btn-primary btnGuardarUsuario">Guardar</button>
</div>
