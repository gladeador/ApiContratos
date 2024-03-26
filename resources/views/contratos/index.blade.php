@extends('layouts.app')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Administrar Contratos</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                    <li class="breadcrumb-item active">Contrato</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="box-header with-border">
                        <a href="/contrato/0" class="btn btn-primary agregacontrato">Agregar contrato</a>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th style="width:10px">#</th>
                                <th>Organización</th>
                                <th>Fecha Inicio</th>
                                <th>Fecha Termino</th>
                                <th>Ejecutivo</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($contratos as $contrato)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $contrato->organizacion_name }}</td>
                                <td>{{ $contrato->fecha_inicio }}</td>
                                <td>{{ $contrato->fecha_fin }}</td>
                                <td>{{ $contrato->nombre }} {{ $contrato->apellido }}</td>
                                <td>
                                    @if ($contrato->estado_contrato == "Activo")
                                    <span class="badge bg-success">Activo</span>
                                    @else
                                    <span class="badge bg-danger">Inactivo</span>
                                    @endif
                                </td>
                                <td>
                                    <button class="btn btn-sm" data-toggle="tooltip" data-placement="top"
                                        title="Pdf Contrato">
                                        <a href="{{ asset('storage/contratos/' . $contrato->pdf_path) }}"
                                            target="_blank">
                                            <i class="fas fa-file-pdf"></i>
                                        </a>
                                    </button>
                                    <button class="btn btn-sm" data-toggle="tooltip" data-placement="top"
                                        title="Agregar Servicio">
                                        <a href="/servicio/{{$contrato->id}}/{{$contrato->organizacion_id}}">
                                            <i class="fas fa-plus icon-plus"></i>
                                        </a>
                                    </button>
                                    <button class="btn btn-sm" data-toggle="tooltip" data-placement="top"
                                        title="Agregar Horas Adicionales  ">
                                        <a href="#" data-toggle="modal" data-target="#InsertaHoraAdicional"
                                            data-idcontrato="{{$contrato->id}}">
                                            <i class="fas fa-clock icons-clock"></i>
                                        </a>
                                    </button>
                                    <button class="btn btn-sm" data-toggle="tooltip" data-placement="top"
                                        title="Ver Servicios Asociados">
                                        <a
                                            href="/contratoredireccionDos/{{$contrato->id}}/{{$contrato->organizacion_id}}">
                                            <i class="fas fa-tools icons-tools"></i>
                                        </a>
                                    </button>
                                    <button class="btn btn-sm" data-toggle="tooltip" data-placement="top"
                                        title="Ver Datos Contrato">
                                        <a href="/show/{{$contrato->id}}/{{$contrato->organizacion_id}}">
                                            <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn btn-sm btnEditarContrato" data-toggle="tooltip"
                                        data-placement="top" title="Editar Contrato" data-id="{{ $contrato->id }}">
                                        <a href="{{ route('contrato.editar.formulario', $contrato->id) }}">
                                            <i class="fas fa-edit edit-icon"></i>
                                        </a>
                                    </button>
                                    <button class="btn btn-sm btnEliminarcontrato" data-toggle="tooltip"
                                        data-placement="top" title="Eliminar Contrato" idcontrato="{{ $contrato->id }}"
                                        ruta="{{ URL::to('contratoss') }}">
                                        <i class="fas fa-trash trash-icon"></i>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th style="width:10px">#</th>
                                <th>Organización</th>
                                <th>Fecha Inicio</th>
                                <th>Fecha Termino</th>
                                <th>Ejecutivo</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</section>
<!-- /.content -->
<div class="modal fade" id="InsertaHoraAdicional">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Agregar Horas Adcionales</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('horasadicionelescontrato.store') }}" role="form" method="POST">
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
                    <input type="hidden" id="idcontrato" name="idcontrato" value="">
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
<script src="{{ asset('js/contrato.js') }}"></script>


@endpush
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
@endsection