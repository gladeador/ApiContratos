@extends('layouts.app')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Formulario Contrato</h1>
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
                        <form action="{{ route('contratos.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="organizacion_id">Organización</label>
                                        <select class="form-control verorganizacioncreada" id="organizacion_consulta" name="organizacion_consulta"
                                            required>
                                            <option value="">Selecciona una organización</option>
                                            @foreach ($organizaciones as $organizacion)
                                            <option value="{{ $organizacion['id'] }}" {{
                                            $organizacion_id == $organizacion['id'] ? 'selected' : '' }}>{{ $organizacion['name'] }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div id="organizacioncreada"></div>

                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="organizacion_id">Contrato/Servicio</label>
                                        <select class="form-control" id="servicioOcontrato" name="servicioOcontrato"
                                            tabindex="2" required>
                                            <option value="">Seleccione un tipo</option>
                                            <option value="true">Contrato</option>
                                            <option value="false">Servicio</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">

                                    </div>
                                </div>
                            </div>

                            <!-- Aqui hacemos un div para continuar formulario del contrato en caso de ser true -->
                            <div id="contrato">
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
                                            <label for="ejecutivo_id">Ejecutivo</label>
                                            <select class="form-control" id="ejecutivo_id" name="ejecutivo_id"
                                                tabindex="6" required>
                                                <option value="">Selecciona un ejecutivo</option>
                                                @foreach ($ejecutivos as $ejecutivo)
                                                <option value="{{ $ejecutivo->id }}">{{ $ejecutivo->nombre }} {{
                                                $ejecutivo->apellido }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="organizacion_id">Tipo Contrato</label>
                                            <select class="form-control" id="tipocontrato" name="tipocontrato"
                                                tabindex="7" required>
                                                <option value="">Selecciona un tipo contrato</option>
                                                <option value="mensuales">Mensuales</option>
                                                <option value="anuales">Anuales</option>
                                                <option value="spot">Spot</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="horascontrato">Horas Contrato</label>
                                            <input type="decimal" class="form-control" id="horascontrato"
                                                name="horascontrato" tabindex="8" required>
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
                                            <label for="pdf_contrato">Subir Contrato PDF</label>
                                            <input type="file" class="form-control" id="pdf_contrato"
                                                accept="application/pdf" name="pdf_contrato" tabindex="10" required>
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
                                            <textarea class="form-control" id="textocontrato" rows="3"
                                                placeholder="Ingrese sus observaciones" name="textocontrato"
                                                tabindex="13" required></textarea>

                                        </div>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary botongurdarcontrato">Enviar</button>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
<script>
    CKEDITOR.replace('textocontrato');
</script>
@push('page_scripts')
<script src="{{ asset('js/contrato.js') }}"></script>
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
@endsection