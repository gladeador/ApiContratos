<!-- resources/views/configuracion/index.blade.php -->

@extends('layouts.app')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Configuración</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Configuración</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <div class="box-header with-border">
                            Configuración de Empresa
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <form action="{{route('configuracion.store')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="nombre_empresa">Nombre de la Empresa</label>
                                <input type="text" class="form-control" id="nombre_empresa" name="nombre_empresa" value="{{ config('app.name') }}" required>
                            </div>
                            <div class="form-group">
                                <label for="logo_empresa">Logo de la Empresa</label>
                                <input type="file" class="form-control-file" id="logo_empresa" name="logo_empresa" required>
                            </div>
                            <!-- Agregar más campos de configuración según sea necesario -->

                            <button type="submit" class="btn btn-primary">Guardar Configuración</button>
                        </form>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->

            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <div class="box-header with-border">
                            Otras Configuraciones
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <!-- Agregar otras configuraciones según sea necesario -->
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
<script src="{{ asset('js/plantilla.js') }}"></script>
<script src="{{ asset('js/script.js') }}"></script>
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

 