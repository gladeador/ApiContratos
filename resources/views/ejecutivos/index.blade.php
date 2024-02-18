@extends('layouts.app')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Administrar ejecutivo</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                    <li class="breadcrumb-item active">Perfiles</li>
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

                        <button type="button" class="btn btn-primary" data-toggle="modal"
                            data-target="#insertarEjecutivo">
                            Agregar ejecutivo
                        </button>

                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Apellido</th>
                                <th>Descripcion</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($ejecutivos as $ejecutivo)
                            <tr>
                                <td>{{ $ejecutivo->nombre }}</td>
                                <td>{{ $ejecutivo->apellido }}</td>
                                <td>{{ $ejecutivo->descripcion }}</td>
                                <td>
                                    @if ($ejecutivo->estado == 1)
                                    <span class="badge bg-success">Activo</span>
                                    @else
                                    <span class="badge bg-danger">Inactivo</span>
                                    @endif
                                </td>
                                <td>
                                    <button class="btn btn-warning btn-sm  btnEditarEjecutivo" data-toggle="modal"
                                        data-id_ejecutivo="{{ $ejecutivo->id }}" data-nombre="{{ $ejecutivo->nombre }}"
                                        data-apellido="{{ $ejecutivo->apellido }}"
                                        data-descripcion="{{ $ejecutivo->descripcion }}"
                                        data-target="#modalEditarEjecutivo"><i class="fas fa-edit"></i></button>
                                    <button class="btn btn-danger btn-sm btnEliminarEjecutivo"
                                        idejecutivo="{{ $ejecutivo->id }}" ruta="{{ URL::to('ejecutivos') }}"><i
                                            class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Nombre</th>
                                <th>Apellido</th>
                                <th>Descripcion</th>
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


<!--=====================================
                                                                                                                                                MODAL AGREGAR ROL
                                                                                                                                                ======================================-->
<div class="modal fade" id="insertarEjecutivo">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Agregar Ejecutivo</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('ejecutivos.store') }}" role="form" method="POST">
                @csrf
                @include('ejecutivos.form')
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<!--=====================================
    MODAL UPDATE ROL
     ======================================-->
<div class="modal fade" id="modalEditarEjecutivo">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Editar Ejecutivo</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('ejecutivos.update', 'test') }}" role="form" method="POST">
                    @method('patch')
                    @csrf
                    <input type="hidden" id="id_ejecutivo" name="id_ejecutivo" value="">
                    @include('ejecutivos.form')
                </form>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

@push('page_scripts')
<script src="{{ asset('js/plantilla.js') }}"></script>
<script src="{{ asset('js/config.js') }}"></script>
@endpush
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

@endsection