@extends('layouts.app')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Administrar profile</h1>
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
                                    <th>Nombre</th>
                                    <th>Descripcion</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($profiles as $profile)
                                    <tr>
                                        <td>{{ $profile->nombre }}</td>
                                        <td>{{ $profile->descripcion }}</td>
                                        <td>
                                            @if ($profile->condicion == 1)
                                                <span class="badge bg-success">Activo</span>
                                            @else
                                                <span class="badge bg-danger">Inactivo</span>
                                            @endif
                                        </td>
                                        <td>
                                            <button class="btn btn-warning btn-sm  btnEditarPerfil" data-toggle="modal"
                                                data-id_profile="{{ $profile->id }}"
                                                data-nombre="{{ $profile->nombre }}"
                                                data-descripcion="{{ $profile->descripcion }}"
                                                data-target="#modalEditarProfile"><i class="fas fa-edit"></i></button>
                                            <button class="btn btn-danger btn-sm btnEliminarprofile"
                                                idprofile="{{ $profile->id }}" ruta="{{ URL::to('profile') }}"><i
                                                    class="fas fa-trash"></i></button>
                                        </td>
                                    </tr>
                                @endforeach
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
    <!-- /.content -->


    <!--=====================================
                                                                                                                                                MODAL AGREGAR ROL
                                                                                                                                                ======================================-->
    <div class="modal fade" id="insertarProfile">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Agregar Profile</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('profile.store') }}" role="form" method="POST">
                    @csrf
                    @include('profile.form')
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <!--=====================================
    MODAL UPDATE ROL
     ======================================-->
    <div class="modal fade" id="modalEditarProfile">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Editar Profile</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('profile.update', 'test') }}" role="form" method="POST">
                        @method('patch')
                        @csrf
                        <input type="hidden" id="id_profile" name="id_profile" value="">
                        @include('profile.form')
                    </form>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

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
