@extends('layouts.app')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Formulario Servicios</h1>
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
                                    <select class="form-control verificarorganizacion" id="organizacion_id" name="organizacion_id" required>
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
            <a href="{{ url('/servicio', ['contrato_id' => $contrato_id, 'organizacion_id' => $organizacion_id]) }}" class="btn btn-primary agregaservicio">Agregar servicio</a>
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
                            <button class="btn btn-warning btn-sm  btnEditarPerfil"
                                data-target="#modalEditarcontrato"><i class="fas fa-edit"></i></button>
                            <button class="btn btn-danger btn-sm btnEliminarcontrato" idcontrato="" ruta=""><i
                                    class="fas fa-trash"></i></button>
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
@endpush
<!-- alert sweetalert -->
@if (Session::has('toast_success'))
<script>
    Swal.fire({
        position: 'top-end',
        icon: 'success',
        title: '{{ Session::get('toast_success') }}',
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
        title: '{{ Session::get('toast_error') }}',
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

