@extends('layouts.app')
@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Show Detalles</h1>
                <button type="reset" class="btn btn-danger" onclick="window.location.href='/contratoss'">Volver</button>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Detalle</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">

    <div class="card">
        <div class="card-header">
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-8 order-2 order-md-1">
                        <div class="row">
                            <div class="col-12">
                                <h4>Contrato Detalles</h4>
                                <div class="post">
                                    <table class="table">
                                        <tr>
                                            <td><b>Organización:</b></td>
                                            <td>{{$contrato->organizacion_name}}</td>
                                            <td><b>Control de Horas X Contrato/Servicio:</b></td>
                                            <td>{{$contrato->tipo_contrato == "true" ? 'Contrato' : 'Servicio'}}</td>
                                        </tr>
                                        @if ($contrato->fecha_inicio != null)
                                        <tr>
                                            <td><b>Fecha Inicio: </b></td>
                                            <td>{{$contrato->fecha_inicio}}</td>
                                            <td><b>Fecha Termino:</b></td>
                                            <td>{{$contrato->fecha_fin}}</td>
                                        </tr>
                                        @endif
                                        <tr>
                                            <td><b>Ejecutivo: </b></td>
                                            <td>{{$contrato->ejecutivo_id}}</td>
                                            <td><b>Control de Horas:</b></td>
                                            <td>{{$contrato->tipo_contrato}}</td>
                                        </tr>
                                        <tr>
                                            <td><b>Tipo Contrato: </b></td>
                                            <td>{{$contrato->horas_contrato}}</td>
                                            <td><b>Renovacion Automatica:</b></td>
                                            <td>{{$contrato->renovacion_automatica == "true" ? 'SI' : 'NO'}}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"><b>Texto Contrato: </b></td>
                                            <td colspan="2"><button class="btn btn-primary"
                                                    onclick="toggleContentContrato()">Ver Contenido</button></td>
                                        </tr>
                                    </table>
                                    <div id="contentContrato" style="display: none;">
                                        <!-- Mostrar contenido HTML recuperado de la base de datos -->
                                        {!! html_entity_decode($contrato->contrato_texto) !!}
                                    </div>
                                </div>
                                <h4>Contrato Servicios</h4>
                                <div class="post clearfix">
                                    @foreach ($servicios as $servicio)
                                    <h4><span class="username"><a
                                                href="#">{{$servicio->servicio_tree_select}}</a></span></h4>
                                    <table class="table">
                                        @php if ($servicio->fecha_inicio != null){ @endphp
                                        <tr>
                                            <td><b>Fecha Inicio: </b></td>
                                            <td>{{$servicio->fecha_inicio}}</td>
                                            <td><b>Fecha Termino:</b></td>
                                            <td>{{$servicio->fecha_fin}}</td>
                                        </tr>
                                        @php }@endphp
                                        <tr>
                                            <td><b>Tipo Servicio: </b></td>
                                            <td>{{$servicio->tipo_servicio}}</td>
                                            <td><b>Renovacion Automatica:</b></td>
                                            <td>{{$servicio->renovacion_automatica == "true" ? 'SI' : 'NO'}}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"><b>Texto Contrato: </b></td>
                                            <td colspan="2"><button class="btn btn-primary"
                                                    onclick="toggleContentServicio({{$loop->iteration}})">Ver
                                                    Contenido</button></td>
                                        </tr>
                                    </table>
                                    <div id="contentServicio{{$loop->iteration}}" style="display: none;">
                                        <!-- Mostrar contenido HTML recuperado de la base de datos -->
                                        {!! html_entity_decode($servicio->servicio_texto) !!}
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-12 col-lg-4 order-1 order-md-2">
                        <h3 class="text-primary"><i class="fas fa-file-contract"></i> Horas Adicionales Contrato</h3>
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Fecha</th>
                                    <th>Horas Adicionales</th>
                                    <th>Observaciones</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            @foreach ($horas_adicionales_contrato as $horasAdicionalesContrato)
                            <tbody>
                                <tr>
                                    <td>{{$horasAdicionalesContrato->fecha}}</td>
                                    <td>{{$horasAdicionalesContrato->horas_adicionales}}</td>
                                    <td>{{$horasAdicionalesContrato->observaciones}}</td>
                                    <td>
                                    <button class="btn btn-sm" data-toggle="tooltip"
                                            data-placement="top" title="Editar Hora Adicional">
                                            <a href="#" data-toggle="modal" data-target="#EditaHoraADicionalContrato"
                                                data-fecha="{{$horasAdicionalesContrato->fecha}}"
                                                data-horas_adicionales="{{$horasAdicionalesContrato->horas_adicionales}}"
                                                data-observaciones="{{$horasAdicionalesContrato->observaciones}}"
                                                data-id_horascontrato="{{$horasAdicionalesContrato->id}}">
                                                <i class="fas fa-edit edit-icon"></i>
                                            </a>
                                        </button>
                                        <button class="btn btn-sm btnhorasAdicionalescontrato" data-toggle="tooltip"
                                            data-placement="top" title="Eliminar Hora Adicional"
                                            idhorascontrato="{{$horasAdicionalesContrato->id}}" ruta="{{ URL::to('horasadicionelescontrato') }}">
                                            <i class="fas fa-trash trash-icon"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                            @endforeach
                        </table>
                        <h3 class="text-primary"><i class="fas fa-tools"></i> Horas Adicionales Servicios</h3>
                        
                        @foreach ($servicios as $servicio)
                        <h6><span class="username">
                                <a href="#">{{$servicio->servicio_tree_select}}</a></span></h6>
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Fecha</th>
                                    <th>Horas Adicionales</th>
                                    <th>Observaciones</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $horas_adicionales_servicios = DB::table('horas_adicionales_servicio')
                                        ->select('horas_adicionales_servicio.*', 'servicios.servicio_tree_select')
                                        ->join('servicios', 'horas_adicionales_servicio.servicio_id', '=', 'servicios.id')
                                        ->where('horas_adicionales_servicio.servicio_id', $servicio->id)
                                        ->get();
                                @endphp
                                @foreach ($horas_adicionales_servicios as $horasAdicionalesservicio)
                                <tr>
                                    <td>{{$horasAdicionalesservicio->fecha}}</td>
                                    <td>{{$horasAdicionalesservicio->horas_adicionales}}</td>
                                    <td>{{$horasAdicionalesservicio->observaciones}}</td>
                                    <td>
                                        <button class="btn btn-sm" data-toggle="tooltip"
                                            data-placement="top" title="Editar Hora Adicional">
                                            <a href="#" data-toggle="modal" data-target="#EditaHoraADicionalServicio"
                                                data-fecha="{{$horasAdicionalesservicio->fecha}}"
                                                data-horas_adicionales="{{$horasAdicionalesservicio->horas_adicionales}}"
                                                data-observaciones="{{$horasAdicionalesservicio->observaciones}}"
                                                data-id_horasservicio="{{$horasAdicionalesservicio->id}}">
                                                <i class="fas fa-edit edit-icon"></i>
                                            </a>
                                        </button>
                                        <button class="btn btn-sm btnhorasAdicionalesservicio" data-toggle="tooltip"
                                            data-placement="top" title="Eliminar Hora Adicional"
                                            idhorasservicio="{{$horasAdicionalesservicio->id}}" ruta="{{ URL::to('horasadicionelesservicio') }}">
                                            <i class="fas fa-trash trash-icon"></i>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @endforeach
                    </div>

                </div>
            </div>

        </div>

</section>
<!-- Aqui es el modal para modificar las horas adicionales de los servicios -->
<div class="modal fade" id="EditaHoraADicionalServicio">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Editar Horas Adcionales Servicios</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('horasadicionelesservicio.update', $contrato->id) }}" role="form" method="POST">
                @method('patch')
                @csrf
                <div class="modal-body ">
                    <div class="form-group">
                        <label for="horasadicionales">Horas Adicionales</label>
                        <input type="decimal" class="form-control" id="horasadicionales"
                            placeholder="Ingrese Horas Adicionales" name="horasadicionales" required>
                    </div>
                    <div class="form-group
                        <label for="exampleInputEmail1">Fecha</label>
                        <input type="date" class="form-control" id="fecha" placeholder="Ingrese Fecha" name="fecha"
                            required>
                    </div>
                    <div class="form-group
                        <label for="exampleInputEmail1">Observaciones</label>
                        <input type="text" class="form-control" id="observaciones" placeholder="Ingrese observación"
                            name="observaciones" required>
                    </div>

                </div>
                <div class="modal-footer justify-content-between">
                    <input type="hidden" id="id_horasservicio" name="id_horasservicio" value="">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>

            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<!-- Aqui es el modal para modificar las horas adicionales de los contratos -->
<div class="modal fade" id="EditaHoraADicionalContrato">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Editar Horas Adcionales Contrato</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('horasadicionelescontrato.update', $contrato->id) }}" role="form" method="POST">
                @method('patch')
                @csrf
                <div class="modal-body ">
                    <div class="form-group">
                        <label for="horasadicionales">Horas Adicionales</label>
                        <input type="decimal" class="form-control" id="horasadicionales"
                            placeholder="Ingrese Horas Adicionales" name="horasadicionales" required>
                    </div>
                    <div class="form-group
                        <label for="exampleInputEmail1">Fecha</label>
                        <input type="date" class="form-control" id="fecha" placeholder="Ingrese Fecha" name="fecha"
                            required>
                    </div>
                    <div class="form-group
                        <label for="exampleInputEmail1">Observaciones</label>
                        <input type="text" class="form-control" id="observaciones" placeholder="Ingrese observación"
                            name="observaciones" required>
                    </div>

                </div>
                <div class="modal-footer justify-content-between">
                    <input type="hidden" id="id_horascontrato" name="id_horascontrato" value="">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>

            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


<script>
function toggleContentContrato() {
    var contentDiv = document.getElementById('contentContrato');
    if (contentDiv.style.display === 'none') {
        contentDiv.style.display = 'block';
    } else {
        contentDiv.style.display = 'none';
    }
}

function toggleContentServicio(iteration) {
    var contentDiv = document.getElementById('contentServicio' + iteration);
    if (contentDiv.style.display === 'none') {
        contentDiv.style.display = 'block';
    } else {
        contentDiv.style.display = 'none';
    }
}
</script>
@push('page_scripts')
<script src="{{ asset('js/plantilla.js') }}"></script>
@endpush
@endsection