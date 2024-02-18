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

                            <button type="button" class="btn btn-primary" data-toggle="modal"
                                data-target="#insertarcontrato">
                                Agregar contrato
                            </button>

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
                                        <td>{{ $contrato->organizacion_id }}</td>
                                        <td>{{ $contrato->fecha_inicio }}</td>
                                        <td>{{ $contrato->fecha_fin }}</td>
                                        <td>{{ $contrato->ejecutivo_id }}</td>
                                        <td>
                                            @if ($contrato->estado == 1)
                                                <span class="badge bg-success">Activo</span>
                                            @else
                                                <span class="badge bg-danger">Inactivo</span>
                                            @endif
                                        </td>
                                        <td>
                                            <button class="btn btn-warning btn-sm  btnEditarPerfil" data-toggle="modal"
                                                data-id_contrato="{{ $contrato->id }}"
                                                data-organizacion_id="{{ $contrato->organizacion_id }}"
                                                data-fecha_inicio="{{ $contrato->fecha_inicio }}"
                                                data-fecha_fin="{{ $contrato->fecha_fin }}"
                                                data-estado="{{ $contrato->estado }}"
                                                data-target="#modalEditarcontrato"><i class="fas fa-edit"></i></button>
                                            <button class="btn btn-danger btn-sm btnEliminarcontrato"
                                                idcontrato="{{ $contrato->id }}" ruta="{{ URL::to('contrato') }}"><i
                                                    class="fas fa-trash"></i></button>
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

    <!-- Modal Agregar Contacto -->
    <div class="modal fade" id="insertarcontrato" tabindex="-1" role="dialog" aria-labelledby="insertarcontratoLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ route('contratos.store') }}" method="POST">
                    @csrf
                    @include('contratos.formContrato');
                </form>
            </div>
        </div>
    </div>
    <!-- Fin Modal Agregar Contacto -->

    @push('page_scripts')
        <script src="{{ asset('js/plantilla.js') }}"></script>
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
