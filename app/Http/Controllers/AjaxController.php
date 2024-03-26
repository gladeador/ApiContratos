<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\User;
use DB;

class AjaxController extends Controller
{
    public function __invoke()
    {
        dd('main');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        if ($request->tipo == "verificaEmail") {
            if (DB::table('users')->where('email', $request->email)->exists()) {
                return response()->json([
                    'message' => "success"
                ]);
            } else {
                return response()->json([
                    'message' => "error"
                ]);
            }
        }

        if ($request->tipo == "verificaRut") {
            $cadena = $request->rut;
            $cadena = str_replace("-", "", $cadena);
            if (DB::table('users')->where('num_documento', $cadena)->exists()) {
                return response()->json([
                    'message' => "success"
                ]);
            } else {
                return response()->json([
                    'message' => "error"
                ]);
            }
        }
        if ($request->tipo == "organizacion") {
            $organizacion_id = $request->organizacion_id;
            if (DB::table('contratos')->where('organizacion_id', $organizacion_id)->exists()) {
                return response()->json([
                    'message' => "success"
                ]);
            } else {
                return response()->json([
                    'message' => "error"
                ]);
            }
        }
        if ($request->tipo == "verifica_contrato") {
            $organizacion_id = $request->organizacion_id;
            $contrato_id = DB::table('contratos')->where('organizacion_id', $organizacion_id)->value('id');

            if ($contrato_id == null) {
                return response()->json([
                    'message' => "error"
                ]);
            } else {
                return response()->json([
                    'message' => "success",
                    'contrato_id' => $contrato_id
                ]);
            }
        }

        if ($request->tipo == "verifica_servicio") {
            $organizacion_id = $request->organizacion_id;
            $contrato_id = DB::table('contratos')->where('organizacion_id', $organizacion_id)->value('id');
            if ($contrato_id == null) {
                return response()->json([
                    'message' => "error"
                ]);
            } else {
                return response()->json([   
                    'message' => "success",
                    'contrato_id' => $contrato_id
                ]);
            }
        }

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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}