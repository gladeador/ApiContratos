@extends('layouts.app')
@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Mantenedor Servicios</h1>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="organizacion_id">Organización</label>
                                    <select class="form-control verificarorganizacion" id="organizacion_id_get"
                                        name="organizacion_id_get" required>
                                        <option value="">Selecciona una organización</option>
                                        @foreach ($organizaciones as $organizacion)
                                        <option value="{{ $organizacion['id'] }}" {{
        $organizacion_id == $organizacion['id'] ? 'selected' : '' }}>{{
        $organizacion['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- /.container-fluid -->
    <!-- Aqui hacemos un div para continuar formulario del servicio en caso de ser false -->
    <div class="card">
        <div class="card-header">
            <div class="box-header with-border">
                <a href="{{ url('/servicio', ['contrato_id' => $contrato_id, 'organizacion_id' => $organizacion_id]) }}"
                    class="btn btn-primary agregaservicio">Agregar servicio</a>
                    <button type="reset" class="btn btn-info" onclick="window.location.href='/contratoss'">Volver a Contratos</button>
            </div>
        </div>
        <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th style="width:10px">#</th>
                        <th>Servicio</th>
                        <th>Fecha Inicio</th>
                        <th>Fecha Termino</th>
                        <th>Tipo Servicio</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($servicios as $servicio)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $servicio->servicio_tree_select}}</td>
                        <td>{{ $servicio->fecha_inicio}}</td>
                        <td>{{ $servicio->fecha_fin}}</td>
                        <td>{{ $servicio->tipo_servicio}}</td>
                        <td>
                            @if ($servicio->estado_servicio == "Activo")
                            <span class="badge bg-success">Activo</span>
                            @else
                            <span class="badge bg-danger">Inactivo</span>
                            @endif
                        </td>
                        <td>
                        <button class="btn btn-sm" data-toggle="tooltip" data-placement="top"
                                title="Agregar Horas Adicionales  ">
                                <a href="#" data-toggle="modal" data-target="#InsertaHoraAdicionalServicio"
                                    data-idservicio="{{$servicio->id}}">
                                    <i class="fas fa-clock icons-clock"></i>
                                </a>
                            </button>
                            <button class="btn btn-sm btnEditarServicio" data-id="{{ $servicio->id }}">
                                <a href="{{ route('contrato.editar.servicio', $servicio->id) }}">
                                <i class="fas fa-edit edit-icon"></i>
                                </a>
                            </button>
                            <button class="btn btn-sm btnEliminarServicio" idservicio="{{$servicio->id}}"
                                ruta="{{ URL::to('servicios') }}">
                                <i class="fas fa-trash trash-icon"></i>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th style="width:10px">#</th>
                        <th>Servicio</th>
                        <th>Fecha Inicio</th>
                        <th>Fecha Termino</th>
                        <th>Tipo Servicio</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </tfoot>
            </table>
        </div>
</section>

<div class="modal fade" id="InsertaHoraAdicionalServicio">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Agregar Horas Adcionales Servicios </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('horasadicionelesservicio.store') }}" role="form" method="POST">
                @csrf
                <div class="modal-body ">
                    <div class="form-group">
                        <label for="horasadicionales">Horas Adicionales</label>
                        <input type="decimal" class="form-control" id="horasadicionales"
                            placeholder="Ingrese Horas Adicionales" name="horasadicionales" required>
                    </div>
                    <div class="form-group
                        <label for=" exampleInputEmail1">Fecha</label>
                        <input type="date" class="form-control" id="fecha" placeholder="Ingrese Fecha" name="fecha"
                            required>
                    </div>
                    <div class="form-group
                        <label for=" exampleInputEmail1">Observaciones</label>
                        <input type="text" class="form-control" id="observaciones" placeholder="Ingrese observación"
                            name="observaciones" required>
                    </div>

                </div>
                <div class="modal-footer justify-content-between">
                    <input type="hidden" id="idservicio" name="idservicio" value="">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>

            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

@if (isset($toast_success))
<script>
Swal.fire({
    position: 'top-end',
    icon: 'success',
    title: '{{$toast_success }}',
    showConfirmButton: false,
    timer: 1500
})
</script>
@endif
@if (isset($toast_error))
<script>
Swal.fire({
    position: 'top-end',
    icon: 'error',
    title: '{{$toast_success }}',
    showConfirmButton: false,
    timer: 1500
})
</script>
@endif
@push('page_scripts')
<script src="{{ asset('js/plantilla.js') }}"></script>
<script src="{{ asset('js/servicio.js') }}"></script>
<script src="{{ asset('js/script.js') }}"></script>
@endpush
<!-- alert sweetalert -->
@if (Session::has('toast_success'))
<script>
Swal.fire({
    position: 'top-end',
    icon: 'success',
    title: '{{ Session::get('
    toast_success ') }}',
    showConfirmButton: false,
    timer: 1500
})
</script>
@endif
@if (Session::has('toast_error'))
<script>
Swal.fire({
    position: 'top-end',
    icon: 'error',
    title: '{{ Session::get('
    toast_error ') }}',
    showConfirmButton: false,
    timer: 1500
})
</script>
@endif
@if (Session::has('toast_alert'))
<script>
Swal.fire({
    icon: "error",
    title: "Oops...",
    text: "{{ Session::get('toast_alert') }}"
});
</script>
@endif
@endsection