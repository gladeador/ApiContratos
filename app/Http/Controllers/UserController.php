<?php

namespace App\Http\Controllers;

use Storage;
use DB;
use Illuminate\Http\Request;
use \App\Models\User;

class UserController extends Controller
{
    //

    public function index(Request $request)
    {
        //
        if ($request) {

            $sql = trim($request->get('buscarTexto'));
            $usuarios = DB::table('users')
                ->join('profiles', 'users.profile_id', '=', 'profiles.id')
                ->select('users.id', 'users.name', 'users.tipo_documento',
                    'users.num_documento', 'users.direccion', 'users.telefono',
                    'users.email', 'users.password',
                    'users.estado', 'users.profile_id', 'users.imagen', 'profiles.nombre as profile')
                ->where('users.name', 'LIKE', '%' . $sql . '%')
                ->orwhere('users.num_documento', 'LIKE', '%' . $sql . '%')
                ->orderBy('users.id', 'desc')
                ->paginate(1000);

            /*listar los profiles en ventana modal*/
            $profiles = DB::table('profiles')
                ->select('id', 'nombre', 'descripcion')
                ->where('condicion', '=', '1')->get();

            return view('user.index', ["usuarios" => $usuarios, "profiles" => $profiles, "buscarTexto" => $sql]);

            //return $usuarios;
        }

    }

    public function store(Request $request)
    {

        /*  return response()->json([
        'message' => $request->num_documento
        ]);*/
        //
        //if(!$request->ajax()) return redirect('/');
        $user = new User();
        $user->name = $request->nombre;
        if ($request->tipo_documento == "CDI") {
            $cadena = $request->rut;
            $cadena = str_replace("-", "", $cadena);
            $user->num_documento = $cadena;
        } elseif ($request->tipo_documento == "PASAPORTE") {
            $user->num_documento = $request->pasaporte;
        } else {
            $user->num_documento = 0;
        }
        $user->tipo_documento = $request->tipo_documento;
        $user->telefono = $request->telefono;
        $user->email = $request->emailUser;
        $user->direccion = $request->direccion;
        $user->password = bcrypt($request->password);
        $user->estado = '1';
        $user->profile_id = $request->id_profile;

        //inicio registrar imagen
        //Handle File Upload
        if ($request->hasFile('imagen')) {

            //Get filename with the extension
            $filenamewithExt = $request->file('imagen')->getClientOriginalName();

            //Get just filename
            $filename = pathinfo($filenamewithExt, PATHINFO_FILENAME);

            //Get just ext
            $extension = $request->file('imagen')->guessClientExtension();

            //FileName to store
            $fileNameToStore = time() . '.' . $extension;

            //Upload Image
            $path = $request->file('imagen')->storeAs('public/img/usuario', $fileNameToStore);

        } else {

            $fileNameToStore = "noimagen.jpg";
        }

        $user->imagen = $fileNameToStore;

        //fin registrar imagen
        if ($user->save()) {

            return redirect('user')->with('toast_success', 'Usuario Creado con Exito!');
        } else {
            return redirect('user')->with('toast_error', 'Error al ingresar el Usuario!');

        }
    }

    public function update(Request $request)
    {
        //

        $user = User::findOrFail($request->id_usuario);
        $user->name = $request->nombreEdita;
        $user->tipo_documento = $request->tipo_documentoEdita;
        if ($request->tipo_documentoEdita == "CDI") {
            $cadena = $request->rutEdita;
            $cadena = str_replace("-", "", $cadena);
            $user->num_documento = $cadena;
        } elseif ($request->tipo_documentoEdita == "PASAPORTE") {
            $user->num_documento = $request->pasaporteEdita;
        } else {
            $user->num_documento = 0;
        }
        $user->telefono = $request->telefonoEdita;
        $user->direccion = $request->direccionEdita;
        if ($request->passwordEdita != '') {
            $user->password = bcrypt($request->passwordEdita);
        }
        $user->estado = '1';
        $user->profile_id = $request->id_profileEdita;

        //Editar imagen
        // if ($request->imagenEdita != '') {
        if ($request->hasFile('imagenEdita')) {

            /*si la imagen que subes es distinta a la que está por defecto
            entonces eliminaría la imagen anterior, eso es para evitar
            acumular imagenes en el servidor*/
            if ($user->imagen != 'noimagen.jpg') {

                try {
                    Storage::delete('storage/img/usuario/' . $user->imagen);
                } catch (ModelNotFoundException $exception) {
                    return back()->withError($exception->getMessage())->withInput();
                }
            }

            //Get filename with the extension
            $filenamewithExt = $request->file('imagenEdita')->getClientOriginalName();

            //Get just filename
            $filename = pathinfo($filenamewithExt, PATHINFO_FILENAME);

            //Get just ext
            $extension = $request->file('imagenEdita')->guessClientExtension();

            //FileName to store
            $fileNameToStore = time() . '.' . $extension;

            //Upload Image
            $path = $request->file('imagenEdita')->storeAs('public/img/usuario', $fileNameToStore);

        } else {

            $fileNameToStore = $user->imagen;
        }
        $user->imagen = $fileNameToStore;

        // }

        //fin editar imagen

        if ($user->save()) {

            return redirect('user')->with('toast_success', 'Usuario fua actualizado con Exito!');
        } else {
            return redirect('user')->with('toast_error', 'Error al actualizar el Usuario!');

        }
    }

    public function destroy(Request $request)
    {

        $user = DB::table('users')->where('id', '=', $request->id_usuario);
        if ($user->delete()) {
            return response()->json([
                'message' => "success",
            ]);
        } else {
            return response()->json([
                'message' => "error",
            ]);
        }
        //
        /*   $user= User::findOrFail($request->id_usuario);

    if($user->condicion=="1"){

    $user->condicion= '0';
    $user->save();
    return Redirect("user");

    }else{

    $user->condicion= '1';
    $user->save();
    return Redirect("user");

    }*/

    }

}
