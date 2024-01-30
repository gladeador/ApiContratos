<?php

namespace App\Http\Controllers;

use App\Models\Permisos;
use DB;
use Illuminate\Http\Request;
use Storage;

class PermisosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $sql = trim($request->get('buscarTexto'));
        $permisos = DB::table('permisos')->where('submenu_id','=' . $sql)
            ->orderBy('id', 'desc')
            ->paginate(10000);

                 /*listar los profiles en ventana modal*/
         $profiles = DB::table('profiles')
         ->select('id', 'nombre', 'descripcion')
         ->where('condicion', '=', '1')->get();
        return view('permisos.index', ["permisos" => $permisos, "profiles" => $profiles, "buscarTexto" => $sql]);
        //return $profile;

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Permisos  $permisos
     * @return \Illuminate\Http\Response
     */
    public function show(Permisos $permisos)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Permisos  $permisos
     * @return \Illuminate\Http\Response
     */
    public function edit(Permisos $permisos)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Permisos  $permisos
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Permisos $permisos)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Permisos  $permisos
     * @return \Illuminate\Http\Response
     */
    public function destroy(Permisos $permisos)
    {
        //
    }
}