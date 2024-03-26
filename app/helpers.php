<?php

use App\Models\Horasxcontrato;
use App\Models\Horasxservicio;
use Carbon\Carbon;

if (!function_exists('valida_rut')) {
    function valida_rut($rut_param)
    {

        //validaciones varias
        //....
        $contar = strlen($rut_param);

        if ($contar == 8) {
            $parte1 = substr($rut_param, 0, 1); //12
            $parte2 = substr($rut_param, 1, 3); //345
            $parte3 = substr($rut_param, 4, 3); //456
            $parte4 = substr($rut_param, 7);   //todo despues del caracter 8

            return $parte1 . "." . $parte2 . "." . $parte3 . "-" . $parte4;
        } elseif ($contar >= 9) {
            $parte1 = substr($rut_param, 0, 2); //12
            $parte2 = substr($rut_param, 2, 3); //345
            $parte3 = substr($rut_param, 5, 3); //456
            $parte4 = substr($rut_param, 8);   //todo despues del caracter 8
            return $parte1 . "." . $parte2 . "." . $parte3 . "-" . $parte4;

        } else {
            return $rut_param;
        }


    }
}


if (!function_exists('busca_true_contrato')) {
    function busca_true_contrato($organizacion_id)
    {
        // Lógica de la nueva función
        $xcontratooservicio = DB::table('contratos')->where('organizacion_id', $organizacion_id)->first();
        if ($xcontratooservicio == null) {
            return 'La organización no tiene creado un contrato';
        } else {
            return $xcontratooservicio;
        }


    }
}

if (!function_exists('inserta_horas_ticket_contrato')) {
    function inserta_horas_ticket_contrato($ticket_id, $organizacion_id, $created_at, $updated_at, $accounted_time, $contrato)
    {

        // Lógica de la nueva función
        $horas = new Horasxcontrato();
        $horas->ticket_id = $ticket_id;
        $horas->organizacion_id = $organizacion_id;
        $horas->contrato_id = $contrato->id;
        $horas->created_at_ticket = $created_at;
        $horas->updated_at_ticket = $updated_at;
        $horas->horas_ocupadas = $accounted_time;

        if ($horas->save()) {
            $tipocontrato = $contrato->tipo_contrato;
            // Obtener el año actual
            $anio_actual = now()->year;

            $fecha_inicio_contrato = Carbon::createFromFormat('Y-m-d', $contrato->fecha_inicio);
            $fecha_fin_contrato = Carbon::createFromFormat('Y-m-d', $contrato->fecha_fin);

            // Definir las fechas de inicio y fin del contrato
            if ($tipocontrato == "mensuales") {

                if ($contrato->renovacion_automatica == "true" && $fecha_inicio_contrato->year <= $anio_actual && $fecha_fin_contrato->year >= $anio_actual) {
                    // Si la renovación automática está activada y el contrato cubre el año actual, leer para todo el año pero por mes

                    $horas_contrato = $contrato->horas_contrato;
                    // Obtener la fecha de inicio del mes actual
                    $fecha_inicio_mes = now()->startOfMonth()->toDateString();
                    // Obtener la fecha de fin del mes actual
                    $fecha_fin_mes = now()->endOfMonth()->toDateString();

                    // Consulta para obtener las horas ocupadas dentro del mes actual
                    $horas_ocupadas_mes = DB::table('horas_contrato_x_ticket')
                        ->where('contrato_id', $contrato->id)
                        ->whereBetween('updated_at', [$fecha_inicio_mes, $fecha_fin_mes])
                        ->sum('horas_ocupadas');

                    $disponibleshoras = $horas_contrato - $horas_ocupadas_mes;

                    return $disponibleshoras;
                } elseif (!$contrato->renovacion_automatica && $fecha_inicio_contrato->year == $anio_actual && $fecha_fin_contrato->year == $anio_actual) {
                    // Si la renovación automática está desactivada y el contrato es solo para el año actual, leer para todo el año x mes

                    $horas_contrato = $contrato->horas_contrato;
                    // Obtener la fecha de inicio del mes actual
                    $fecha_inicio_mes = now()->startOfMonth()->toDateString();
                    // Obtener la fecha de fin del mes actual
                    $fecha_fin_mes = now()->endOfMonth()->toDateString();

                    // Consulta para obtener las horas ocupadas dentro del mes actual
                    $horas_ocupadas_mes = DB::table('horas_contrato_x_ticket')
                        ->where('contrato_id', $contrato->id)
                        ->whereBetween('updated_at', [$fecha_inicio_mes, $fecha_fin_mes])
                        ->sum('horas_ocupadas');

                    $disponibleshoras = $horas_contrato - $horas_ocupadas_mes;

                    return $disponibleshoras;
                } else {
                    // En cualquier otro caso, devolver error o mensaje adecuado
                    return "El contrato no está vigente para el año actual";
                }

            } elseif ($tipocontrato == "anuales") {

                // Consulta para obtener las horas ocupadas según la lógica requerida
                $horas_ocupadas = DB::table('horas_contrato_x_ticket')
                    ->where('contrato_id', $contrato->id)
                    ->where(function ($query) use ($contrato, $anio_actual) {
                        if ($contrato->renovacion_automatica) {
                            // Si la renovación automática es verdadera, consultar dentro del rango de fechas del contrato
                            $query->whereYear('updated_at', $contrato->fecha_inicio->year)
                                ->whereBetween('updated_at', [$contrato->fecha_inicio, $contrato->fecha_fin]);
                        } else {
                            // Si la renovación automática es falsa, el contrato debe ser del año actual
                            if ($contrato->fecha_inicio->year == $anio_actual && $contrato->fecha_fin->year == $anio_actual) {
                                // Contrato dentro del año actual
                                $query->whereYear('updated_at', $anio_actual)
                                    ->whereBetween('updated_at', [$contrato->fecha_inicio, $contrato->fecha_fin]);
                            } else {
                                // Contrato fuera del año actual
                                // Devolver "Contrato vencido"
                                return "El contrato no está vigente para el año actual";
                            }
                        }
                    })
                    ->sum('horas_ocupadas');

                // Si el contrato está vencido, devolver "Contrato vencido"
                if ($horas_ocupadas === "Contrato vencido") {
                    return "Contrato vencido";
                }

                $disponibleshoras = $contrato->horas_contrato - $horas_ocupadas;

                return $disponibleshoras;
            } else {
                return 'No se ingreso la cantidad de horas';
            }

        } else {
            return 'Error al ingresar las horas';
        }
    }
}

if (!function_exists('inserta_horas_ticket_servicio')) {

    function inserta_horas_ticket_servicio($ticket_id, $organizacion_id, $idservicio, $time_unit, $created_at, $updated_at, $accounted_time, $contrato)
    {
        // Lógica de la nueva función
        $horas = new Horasxservicio();
        $horas->ticket_id = $ticket_id;
        $horas->idservicio = $idservicio;
        $horas->organizacion_id = $organizacion_id;
        $horas->contrato_id = $contrato->id;
        $horas->created_at_ticket = $created_at;
        $horas->updated_at_ticket = $updated_at;
        $horas->horas_ocupadas = $accounted_time;

        if ($horas->save()) {


            $servicio = DB::table('servicios')->where('contrato_id', $contrato->id)->where('servicio_tree_select', $idservicio)->first();
            if ($servicio) {
                $anio_actual = now()->year;
                $tiposervicio = $servicio->tipo_servicio;


                $fecha_inicio_servicio = Carbon::createFromFormat('Y-m-d', $servicio->fecha_inicio);
                $fecha_fin_servicio = Carbon::createFromFormat('Y-m-d', $servicio->fecha_fin);

                if ($tiposervicio == "mensual") {
                    $horas_servicio = $servicio->horas_servicio;
                    // Obtener la fecha de inicio del mes actual
                    $fecha_inicio_mes = now()->startOfMonth()->toDateString();
                    // Obtener la fecha de fin del mes actual
                    $fecha_fin_mes = now()->endOfMonth()->toDateString();

                    if ($servicio->renovacion_automatica == "true" && $fecha_inicio_servicio->year <= $anio_actual && $fecha_fin_servicio->year >= $anio_actual) {
                        // Si la renovación automática está activada y el contrato cubre el año actual, leer para todo el año pero por mes

                        // Consulta para obtener las horas ocupadas dentro del mes actual
                        $horas_ocupadas_mes = DB::table('horas_servicio_x_ticket')
                            ->where('contrato_id', $contrato->id)
                            ->where('idservicio', $idservicio)
                            ->whereBetween('updated_at', [$fecha_inicio_mes, $fecha_fin_mes])
                            ->sum('horas_ocupadas');

                        $disponibleshoras = $horas_servicio - $horas_ocupadas_mes;

                        return $disponibleshoras;

                    } elseif ($servicio->renovacion_automatica == "false" && $fecha_inicio_servicio->year == $anio_actual && $servicio->fecha_fin->year == $anio_actual) {
                        // Si la renovación automática está desactivada y el contrato es solo para el año actual, leer para todo el año x mes

                        // Consulta para obtener las horas ocupadas dentro del mes actual
                        $horas_ocupadas_mes = DB::table('horas_servicio_x_ticket')
                            ->where('contrato_id', $contrato->id)
                            ->where('idservicio', $idservicio)
                            ->whereBetween('updated_at', [$fecha_inicio_mes, $fecha_fin_mes])
                            ->sum('horas_ocupadas');

                        $disponibleshoras = $horas_servicio - $horas_ocupadas_mes;

                        return $disponibleshoras;
                    } else {
                        // En cualquier otro caso, devolver error o mensaje adecuado
                        return "El servicio no está vigente para el año actual";
                    }

                } elseif ($tiposervicio == "anual") {

                    // Consulta para obtener las horas ocupadas según la lógica requerida
                    $horas_ocupadas = DB::table('horas_servicio_x_ticket')
                        ->where('contrato_id', $contrato->id)
                        ->where('idservicio', $idservicio)
                        ->where(function ($query) use ($servicio, $anio_actual) {
                            if ($servicio->renovacion_automatica) {
                                $fecha_inicio_servicio = Carbon::createFromFormat('Y-m-d', $servicio->fecha_inicio);
                                $fecha_fin_servicio = Carbon::createFromFormat('Y-m-d', $servicio->fecha_fin);
                                // Si la renovación automática es verdadera, consultar dentro del rango de fechas del contrato
                                $query->whereYear('updated_at', $fecha_inicio_servicio->year)
                                    ->whereBetween('updated_at', [$servicio->fecha_inicio, $servicio->fecha_fin]);
                            } else {
                                // Si la renovación automática es falsa, el contrato debe ser del año actual
                                $fecha_inicio_servicio = Carbon::createFromFormat('Y-m-d', $servicio->fecha_inicio);
                                $fecha_fin_servicio = Carbon::createFromFormat('Y-m-d', $servicio->fecha_fin);
                                if ($fecha_inicio_servicio->year == $anio_actual && $fecha_fin_servicio->year == $anio_actual) {
                                    // Contrato dentro del año actual
                                    $query->whereYear('updated_at', $anio_actual)
                                        ->whereBetween('updated_at', [$servicio->fecha_inicio, $servicio->fecha_fin]);
                                } else {
                                    // Contrato fuera del año actual
                                    // Devolver "Contrato vencido"
                                    return "El servicio no está vigente para el año actual";
                                }
                            }
                        })
                        ->sum('horas_ocupadas');

                    // Si el contrato está vencido, devolver "Contrato vencido"
                    if ($horas_ocupadas === "Contrato vencido") {
                        return "Servicio vencido";
                    }

                    $disponibleshoras = $servicio->horas_servicio - $horas_ocupadas;

                    return $disponibleshoras;

                } else {
                    return 'No se ingreso la cantidad de horas';
                }
            } else {
                return 'El servicio no existe';
            }

        } else {
            return 'Error al ingresar las horas';
        }

    }
}