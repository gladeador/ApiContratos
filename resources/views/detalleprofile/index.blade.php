@extends('layouts.app')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Administrar Permisos</h1>
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
                                data-target="#insertarProfile">
                                Agregar profile
                            </button>

                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th style="width:70%">Nombre Menu</th>
                                    <th>Ver</th>
                                    <th>Grabar</th>
                                    <th>Borrar</th>
                                </tr>
                            </thead>
                            <tbody>
                                    <tr>
                                        <td>
                                    Menu
                                    </td>
                                        <td><span class="badge bg-success">Activo</span>
                                                <span class="badge bg-danger">Inactivo</span></td>
                                        <td>

                                                <span class="badge bg-success">Activo</span>
                                                <span class="badge bg-danger">Inactivo</span>
                                        </td>
                                        <td>
                                        <span class="badge bg-success">Activo</span>
                                                <span class="badge bg-danger">Inactivo</span>
                                        </td>
                                    </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Nombre</th>
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

    @push('page_scripts')
        <script src="{{ asset('js/permisosPerfiles.js') }}"></script>
    @endpush


@endsection
