<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\profile;
use DB;

class ProfileController extends Controller
{
    //
     public function index(Request $request)
    {
        //

        if($request){

            $sql=trim($request->get('buscarTexto'));
            $profiles=DB::table('profiles')->where('nombre','LIKE','%'.$sql.'%')
            ->orderBy('id','desc')
            ->paginate(10000);
            return view('profile.index',["profiles"=>$profiles,"buscarTexto"=>$sql]);
            //return $profile;
        }

    }

    public function store(Request $request){
        $profile = new Profile();
        $profile->nombre = $request->nombre;
        $profile->descripcion = $request->descripcion;
        $profile->condicion= '1';
            if($profile->save()){

                return redirect('profile')->with('toast_success', 'Perfil Creado con Exito!');
            }else{
                return redirect('profile')->with('toast_error', 'Error al ingresar el perfil!');

            }
    }

    public function update(Request $request){

        $profile = Profile::findOrFail($request->id_profile);
        $profile->nombre = $request->nombre;
        $profile->descripcion = $request->descripcion;
        $profile->condicion = '1';

        if($profile->save()){

            return redirect('profile')->with('toast_success', 'Perfil actualizado con Exito!');
        }else{
            return redirect('profile')->with('toast_error', 'Error al actualizar el perfil!');

        }
    }

    public function destroy(Request $request){

        $profile = DB::table('profiles')->where('id', '=', $request->id_profile);
        if($profile->delete()){
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