@extends('layouts.app')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Administrar Usuarios</h1>
                </div>

                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Ususarios</li>
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
                        <div class="form-group">
                            <label>Seleccione <code>Perfil</code></label>

                            <select class="custom-select" id="listaPerfiles" name="lista1" >
                                <option value="0" selected>Seleccione</option>

                                @foreach ($profiles as $profile)
                                    <option value="{{ $profile->id }}">
                                        {{ $profile->nombre }}
                                    </option>
                                @endforeach

                            </select>

                        </div>
                    </div>
                    <!-- /.card-header -->

                    <!-- /. Aquí veremos la tabla con los datos del perfil de usuario -->
                     <div id="mostratTabla"></div>
                    <!-- /.Fin de tabla con los datos del perfil de usuario -->

                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
@endsection
@push('page_scripts')
<script src="{{ asset('js/permisosPerfiles.js') }}"></script>
@endpush
