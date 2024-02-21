<?php

namespace App\Http\Controllers;

use App\Models\Contrato;
use App\Models\Ejecutivos;
use Illuminate\Http\Request;
use DB;

class ContratoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        if ($request) {

            $sql = trim($request->get('buscarTexto'));
            $contratos = DB::table('contratos')->where('organizacion_id', 'LIKE', '%' . $sql . '%')
                ->orderBy('id', 'desc')
                ->paginate(10000);

            // Instancia el controlador ApiController
            $apiController = new ApiController();

            // Obtiene las organizaciones
            $organizaciones = $apiController->fetchDataFromApiOrganizations();
            return view('contratos.index', ["contratos" => $contratos, "organizaciones" => $organizaciones, "buscarTexto" => $sql]);
            //return $profile;
        }
    }

    public function contrato()
    {

        // Instancia el controlador ApiController
        $apiController = new ApiController();
        // Obtiene las organizaciones
        $organizaciones = $apiController->fetchDataFromApiOrganizations();

        // obtiene ejecutivos
        /*$ejecutivos= DB::table("ejecutivos")->get();*/
        $ejecutivos = DB::table('ejecutivos')
            ->select('id', 'nombre', 'apellido', 'descripcion')
            ->where('estado', '=', '1')->get();

        return view('contratos.contrato', ['organizaciones' => $organizaciones, 'ejecutivos' => $ejecutivos]);
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
    }

    /**
     * Display the specified resource.
     */
    public function show(Contrato $ccontrato)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ccontrato $ccontrato)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ccontrato $ccontrato)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ccontrato $ccontrato)
    {
        //
    }
}