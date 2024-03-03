@extends('layouts.app')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Formulario Servicio</h1>
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
                        <form action="{{ route('servicios.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="organizacion_id">Servicio</label>
                                        <select class="form-control" name="idservicio" id="idservicio">
                                            <option value="">Selecciona un servicio</option>
                                            @foreach($servicios[9]['data_option']['options'] as $option)
                                            <option value="{{ $option['value'] }}">{{ $option['name'] }}</option>
                                            @if(isset($option['children']))
                                            @foreach($option['children'] as $child)
                                            <option value="{{ $child['value'] }}">-- {{ $child['name'] }}</option>
                                            @endforeach
                                            @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                            </div>

                            <!-- Aqui hacemos un div para continuar formulario del servicio en caso de ser true -->
                            <div id="servicio">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="fecha_inicio">Fecha Inicio</label>
                                            <input type="date" class="form-control" id="fecha_inicio"
                                                name="fecha_inicio" tabindex="4" required>
                                        </div>

                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="fecha_fin">Fecha Termino</label>
                                            <input type="date" class="form-control" id="fecha_fin" name="fecha_fin"
                                                tabindex="5" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="organizacion_id">Tipo Servicio</label>
                                            <select class="form-control" id="tiposervicio" name="tiposervicio"
                                                tabindex="7" required>
                                                <option value="">Selecciona un tipo servicio</option>
                                                <option value="mensual">Mensual</option>
                                                <option value="anual">Anual</option>
                                                <option value="spot">Spot</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="horasservicio">Horas Servicio</label>
                                            <input type="decimal" class="form-control" id="horasservicio"
                                                name="horasservicio" tabindex="8" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="horasadicionales">Horas Adicionales</label>
                                            <input type="decimal" class="form-control" id="horasadicionales"
                                                name="horasadicionales" tabindex="9" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="pdf_servicio">Subir Contrato PDF</label>
                                            <input type="file" class="form-control" id="pdf_servicio"
                                                accept="application/pdf" name="pdf_servicio" tabindex="10" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="horasadicionales">Renovación Automática</label>
                                            <br>
                                            <input type="checkbox" class="form-control" checked data-toggle="toggle"
                                                data-on="SI" data-size="sm" id="renovacionautomatica"
                                                name="renovacionautomatica" data-off="NO" data-onstyle="success"
                                                data-offstyle="danger" tabindex="11">
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="organizacion_id">Texto Contrato</label>
                                            <textarea class="form-control" id="textoservicio" rows="3"
                                                placeholder="Ingrese sus observaciones" name="textoservicio"
                                                tabindex="13" required></textarea>

                                        </div>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary botongurdarservicio">Enviar</button>
                                <input type="hidden" name="contrato_id" id="contrato_id" value="{{$contrato_id}}">
                                <input type="hidden" name="organizacion_id" id="organizacion_id" value="{{$organizacion_id}}">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
<script>
    CKEDITOR.replace('textoservicio');
</script>
@push('page_scripts')
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
        showConfirmButton: timer: 1500
    })
</script>
@endif
@endsection