<?php

namespace App\Http\Controllers;

use App\Models\Ejecutivos;
use Illuminate\Http\Request;
use DB;
use App\Models\ChangeLog;
use Illuminate\Support\Facades\Auth;

class EjecutivosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request){

            $sql=trim($request->get('buscarTexto'));
            $ejecutivos=DB::table('ejecutivos')->where('nombre','LIKE','%'.$sql.'%')
            ->orderBy('id','desc')
            ->paginate(10000);
            return view('ejecutivos.index',["ejecutivos"=>$ejecutivos,"buscarTexto"=>$sql]);
            //return $profile;
        }
    }


    public function store(Request $request)
    {
        //
        $ejecutivos= new Ejecutivos();
        $ejecutivos->nombre = $request->nombre;
        $ejecutivos->apellido = $request->apellido;
        $ejecutivos->descripcion = $request->descripcion;

        if($ejecutivos->save()){
            //registro de cambio de log
            $changeLog = new ChangeLog();
            $changeLog->change_type = 'create';
            $changeLog->details = 'Se ha creado un ejecutivo con el Nombre: '.$ejecutivos->nombres.' '.$ejecutivos->apellidos;
            $changeLog->users_id = auth()->user()->id;
            $changeLog->save();

            return redirect('ejecutivos')->with('toast_success', 'Ejecutivo Creado con Exito!');
        }else{
            return redirect('ejecutivos')->with('toast_error', 'Error al ingresar el Ejecutivo!');

        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Ejecutivos $ejecutivos)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ejecutivos $ejecutivos)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $ejecutivos = Ejecutivos::findOrFail($request->id_ejecutivo);
        $ejecutivos->nombre = $request->nombre;
        $ejecutivos->apellido = $request->apellido;
        $ejecutivos->descripcion = $request->descripcion;
        $ejecutivos->estado = '1';

        if($ejecutivos->save()){
            //registro de cambio de log
            $changeLog = new ChangeLog();
            $changeLog->change_type = 'update';
            $changeLog->details = 'Se ha actualizado un ejecutivo con el Nombre: '.$ejecutivos->nombres.' '.$ejecutivos->apellidos;
            $changeLog->users_id = auth()->user()->id;
            $changeLog->save();
            return redirect('ejecutivos')->with('toast_success', 'Ejecutivo actualizado con Exito!');
        }else{
            return redirect('ejecutivos')->with('toast_error', 'Error al actualizar el ejecutivo!');

        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $ejecutivos = DB::table('ejecutivos')->where('id', '=', $request->id_ejecutivo);
        if($ejecutivos->delete()){
            //registro de cambio de log
            $changeLog = new ChangeLog();
            $changeLog->change_type = 'delete';
            $changeLog->details = 'Se ha eliminado un ejecutivo con el ID: '.$request->id_ejecutivo;
            $changeLog->users_id = auth()->user()->id;
            return response()->json([
                'message' => "success"
              ]);
        }else{
            return response()->json([
                'message' => "error"
              ]);
        }
    }
}
