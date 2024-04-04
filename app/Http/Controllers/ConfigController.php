<?php

namespace App\Http\Controllers;

use Storage;
use App\Models\Config;
use Illuminate\Http\Request;
use App\Models\ChangeLog;
use Illuminate\Support\Facades\Auth;
use DB;

class ConfigController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('configuracion.index');
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
        $config = new Config();
        $config->nombre = $request->nombre_empresa;
         //inicio registrar imagen
         if ($request->hasFile('logo_empresa') && $request->file('logo_empresa')->isValid()) {
            $fileNameToStore = 'favicon.png';
        
            // Intenta mover el archivo a la carpeta de destino
            $request->file('logo_empresa')->move(public_path('img'), $fileNameToStore);
        
            // Verifica si el archivo se ha movido correctamente
            if (file_exists(public_path('img') . '/' . $fileNameToStore)) {
                // El archivo se ha movido correctamente
                // Resto del código...
            } else {
                // Hubo un problema al mover el archivo
                return redirect('configuracion')->with('toast_error', 'Error al mover la imagen.');
            }
        } else {
            // Archivo no válido o no presente
            return redirect('configuracion')->with('toast_error', 'La imagen no es válida o no está presente.');
        }
        
        // Asignar el nombre del archivo al campo 'logo' del modelo de usuario (o modelo correspondiente)
        $config->logo = $fileNameToStore;

        if ($config->save()) {
            // Registro de cambio en el log
            $changeLog = new ChangeLog();
            $changeLog->change_type = 'create';
            $changeLog->details = 'Se ha creado una configuración de la empresa ' . $config->nombre;
            $changeLog->users_id = auth()->user()->id;
            $changeLog->save();
            return redirect('configuracion')->with('toast_success', 'Configuración guardada con Exito!');
        } else {

            return redirect('configuracion')->with('toast_error', 'Error al guardar configuración!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Config $config)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Config $config)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Config $config)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Config $config)
    {
        //
    }
}
