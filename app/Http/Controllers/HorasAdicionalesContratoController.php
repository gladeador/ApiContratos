<?php

namespace App\Http\Controllers;

use App\Models\HorasAdicionalesContrato;
use Illuminate\Http\Request;
use DB;
class   HorasAdicionalesContratoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
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
            'idcontrato' => 'required'
        ]);
        $horasAdicionales = new HorasAdicionalesContrato();
        $horas_adicionales = str_replace(",", ".", $request->horasadicionales);
        $horasAdicionales->horas_adicionales = $horas_adicionales;
        $horasAdicionales->fecha = $request->fecha;
        $horasAdicionales->observaciones = $request->observaciones;
        $horasAdicionales->contrato_id = $request->idcontrato;
        
        if ($horasAdicionales->save()) {
            return back()->with('toast_success', 'Horas Adicionales Guardadas');
        } else {
            return back()->with('toast_error', 'Error al Guardar Horas Adicionales');
        }

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $contrato_id)
    {
        //
        $horasAdicionalescontrato = HorasAdicionalesContrato::find($request->id_horascontrato);
        $horas_adicionales = str_replace(",", ".", $request->horasadicionales);
        $horasAdicionalescontrato->horas_adicionales = $horas_adicionales;
        $horasAdicionalescontrato->fecha = $request->fecha;
        $horasAdicionalescontrato->observaciones = $request->observaciones;
        if ($horasAdicionalescontrato->save()) {
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
        $horas = DB::table('horas_adicionales_contrato')->where('id', '=', $request->idhorascontrato);

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
