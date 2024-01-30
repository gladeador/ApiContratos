@extends('layouts.app')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Administrar Usuarios</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
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
                    <div class="box-header with-border">

                        <button type="button" class="btn btn-primary" data-toggle="modal"
                            data-target="#insertarUsuario">
                            Agregar Usuario
                        </button>

                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>

                                <th style="width:10px">#</th>
                                <th>Nombre</th>
                                <th>Tipo Documento</th>
                                <th>Número</th>
                                <th>Dirección</th>
                                <th>Teléfono</th>
                                <th>Email</th>
                                <th>Perfil</th>
                                <th>Imagen</th>
                                <th>Estado</th>
                                <th>Acciones</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($usuarios as $user)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{$user->name}}</td>
                                <td>{{$user->tipo_documento}}</td>
                                <td>
                                    @if ($user->tipo_documento == "CDI")
                                    {{valida_rut($user->num_documento)}}
                                    @else
                                    {{$user->num_documento}}
                                    @endif
                                </td>
                                <td>{{$user->direccion}}</td>
                                <td>{{$user->telefono}}</td>
                                <td>{{$user->email}}</td>
                                <td>{{$user->profile}}</td>
                                <td>
                                    <img src="{{asset('storage/img/usuario/'.$user->imagen)}}" id="imagen1" name="imagen1"
                                        alt="{{$user->name}}" class="img-responsive" width="100px" height="100px">
                                </td>
                                <td>
                                    @if ($user->estado == 1)
                                    <span class="badge bg-success">Activo</span>
                                    @else
                                    <span class="badge bg-danger">Inactivo</span>
                                    @endif
                                </td>
                                <td>
                                    <button class="btn btn-warning btn-sm" data-toggle="modal"
                                        data-id_usuario="{{$user->id}}" data-nombre="{{$user->name}}"
                                        data-tipo_documento="{{$user->tipo_documento}}"
                                        data-num_documento="{{$user->num_documento}}"
                                        data-direccion="{{$user->direccion}}" data-telefono="{{$user->telefono}}"
                                        data-email="{{$user->email}}" data-id_profile="{{$user->profile_id}}"
                                        data-imagen1="{{$user->imagen}}" data-target="#modalEditarUsuario"><i
                                            class="fas fa-edit"></i></button>
                                    <button class="btn btn-danger btn-sm btnEliminarUsuario" idUsuario="{{$user->id}}"
                                        ruta="{{URL::to('user')}}"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>

                                <th style="width:10px">#</th>
                                <th>Nombre</th>
                                <th>Tipo Documento</th>
                                <th>Número</th>
                                <th>Dirección</th>
                                <th>Teléfono</th>
                                <th>Email</th>
                                <th>Perfil</th>
                                <th>Imagen</th>
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
    MODAL AGREGAR USUARIO
    ======================================-->
<div class="modal fade" id="insertarUsuario">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Agregar Rol</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('user.store')}}" role="form" method="POST" autocomplete="off"
                enctype="multipart/form-data">
                @csrf
                @include('user.form')
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<!--=====================================
    MODAL UPDATE USUARIO
    ======================================-->
<div class="modal fade" id="modalEditarUsuario">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Editar Usuario</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('user.update','test')}}" role="form" method="POST" autocomplete="off"
                    enctype="multipart/form-data">
                    @method('patch')
                    @csrf
                    <input type="hidden" id="id_usuario" name="id_usuario" value="">
                    @include('user.edita')
                </form>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
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
