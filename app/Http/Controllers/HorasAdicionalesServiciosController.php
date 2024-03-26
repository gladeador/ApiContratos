<?php

namespace App\Http\Controllers;

use App\Models\HorasAdicionalesServicios;
use Illuminate\Http\Request;
use DB;

class HorasAdicionalesServiciosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $this->validate($request, [
            'horasadicionales' => 'required',
            'fecha' => 'required',
            'observaciones' => 'required',
            'idservicio' => 'required'
        ]);
        $horasAdicionalesservicios = new HorasAdicionalesServicios();
        $horas_adicionales = str_replace(",", ".", $request->horasadicionales);
        $horasAdicionalesservicios->horas_adicionales = $horas_adicionales;
        $horasAdicionalesservicios->fecha = $request->fecha;
        $horasAdicionalesservicios->observaciones = $request->observaciones;
        $horasAdicionalesservicios->servicio_id = $request->idservicio;

        if ($horasAdicionalesservicios->save()) {
            return back()->with('toast_success', 'Horas Adicionales Guardadas');
        } else {
            return back()->with('toast_error', 'Error al Guardar Horas Adicionales');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(HorasAdicionalesServicios $horasAdicionalesServicios)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(HorasAdicionalesServicios $horasAdicionalesServicios)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $contrato_id)
    {
        //


        $horasAdicionalesservicios = HorasAdicionalesServicios::find($request->id_horasservicio);
        $horas_adicionales = str_replace(",", ".", $request->horasadicionales);
        $horasAdicionalesservicios->horas_adicionales = $horas_adicionales;
        $horasAdicionalesservicios->fecha = $request->fecha;
        $horasAdicionalesservicios->observaciones = $request->observaciones;
        if ($horasAdicionalesservicios->save()) {
            return back()->with('toast_success', 'Horas Adicionales Actualizadas');
        } else {
            return back()->with('toast_error', 'Error al Actualizar Horas Adicionales');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        //
        $horas = DB::table('horas_adicionales_servicio')->where('id', '=', $request->idhorasservicio);

        if ($horas->delete()) {
            return response()->json([
                'message' => "success",
            ]);
        } else {
            return response()->json([
                'message' => "error",
            ]);
        }
    }
}