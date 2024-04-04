<?php

namespace App\Http\Controllers;

use App\Models\Servicio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use DB;
use App\Models\ChangeLog;
use Illuminate\Support\Facades\Auth;

class ServicioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        if ($request) {
            // Instancia el controlador ApiController
            $apiController = new ApiController();
            // Obtiene las organizaciones
            $organizaciones = $apiController->fetchDataFromApiOrganizations();

            $contrato_id = $request->segment(2);
            $organizacion_id = $request->segment(3);

            /* AQuí busco los servicios que tiene la organización si es que existe */
            if ($contrato_id) {
                // Si se proporciona una ID específica, obtén los datos para esa ID
                $servicios = Servicio::where('contrato_id', $contrato_id)->get();
            } else {
                // Si no se proporciona ninguna ID, obtén todos los datos de la tabla
                $servicios = Servicio::all();
            }

            return view('contratos.servicios', ['organizacion_id' => $organizacion_id, 'contrato_id' => $contrato_id, 'organizaciones' => $organizaciones, 'servicios' => $servicios]);
        }
    }

    public function servicio(Request $request)
    {

        $contrato_id = $request->segment(2);
        $organizacion_id = $request->segment(3);

        if ($organizacion_id == null) {
            return redirect('servicios')->with('toast_alert', 'Oops! Debe seleccionar la organización!');
        }

        // Instancia el controlador ApiController
        $apiController = new ApiController();
        // Obtiene las organizaciones
        $servicios = $apiController->fetchDataServicioSelectTree();

        return view('contratos.formServicio', ["contrato_id" => $contrato_id, "organizacion_id" => $organizacion_id, 'servicios' => $servicios]);
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
        $servicio = new Servicio();
        $servicio->servicio_tree_select = $request->input('idservicio');
        $servicio->fecha_inicio = $request->input('fecha_inicio');
        $servicio->fecha_fin = $request->input('fecha_fin');
        $servicio->tipo_servicio = $request->input('tiposervicio');
        $horas_servicio = str_replace(",", ".", $request->input('horasservicio'));
        $servicio->horas_servicio = $horas_servicio;
        $servicio->servicio_texto = $request->input('textoservicio');
        if ($request->hasFile('pdf_servicio')) {
            // Crear la carpeta 'servicios' si no existe
            $directory = '/public/servicios';

            if (!Storage::exists($directory)) {
                Storage::makeDirectory($directory);
            }
            // Obtener el nombre del archivo con la extensión
            $filenamewithExt = $request->file('pdf_servicio')->getClientOriginalName();
            // Obtener solo el nombre del archivo
            $filename = pathinfo($filenamewithExt, PATHINFO_FILENAME);
            // Obtener solo la extensión
            $extension = $request->file('pdf_servicio')->getClientOriginalExtension();
            // Nombre de archivo para almacenar
            $fileNameToStore = time() . '.' . $extension;
            // Subir archivo
            $path = $request->file('pdf_servicio')->storeAs($directory, $fileNameToStore);

        }

        $servicio->pdf_path = $fileNameToStore;
        // Usar el operador ternario para simplificar
        $servicio->renovacion_automatica = $request->has('renovacionautomatica') ? true : false;
        $servicio->contrato_id = $request->input('contrato_id');

        if ($servicio->save()) {
            //registro de cambio de log
            $changeLog = new ChangeLog();
            $changeLog->change_type = 'create';
            $changeLog->details = 'Se ha creado un servicio: ' . $servicio->servicio_tree_select;
            $changeLog->users_id = Auth::user()->id;
            $changeLog->save();
            // Instancia el controlador ApiController
            $apiController = new ApiController();
            // Obtiene las organizaciones
            $organizaciones = $apiController->fetchDataFromApiOrganizations();

            // Obtener el ID del servicio creado
            $servicio_id = $servicio->id;

            /* AQuí busco los servicios que tiene la organización si es que existe */
            if ($servicio_id) {
                // Si se proporciona una ID específica, obtén los datos para esa ID
                $servicios = Servicio::where('contrato_id', $servicio->contrato_id)->get();
            } else {
                // Si no se proporciona ninguna ID, obtén todos los datos de la tabla
                $servicios = Servicio::all();
            }
            //obtener el id de la organizacion
            $organizacion_id = $request->input('organizacion_id');

            // Redirigir al servicio con el ID del servicio como parámetro

            return view('contratos.servicios', [
                'servicio_id' => $servicio_id,
                'organizacion_id' => $organizacion_id,
                'organizaciones' => $organizaciones,
                'servicios' => $servicios,
                'contrato_id' => $servicio->contrato_id,
                'toast_success' => 'Servicio creado con Éxito!'
            ])->with('toast_success', 'Servicio creado con Éxito!');

        } else {
            return redirect('servicios')->with('toast_error', 'Error al ingresar el servicio!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Servicio $servicio)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Servicio $servicio)
    {
        //
    }
    public function showForm($id)
    {
        $services = Servicio::find($id);

        // Instancia el controlador ApiController
        $apiController = new ApiController();

        // obtiene ejecutivos
        $ejecutivos = DB::table('ejecutivos')
            ->select('id', 'nombre', 'apellido', 'descripcion')
            ->where('estado', '=', '1')->get();

        // Instancia el controlador ApiController
        $apiController = new ApiController();
        // Obtiene las organizaciones
        $servicios = $apiController->fetchDataServicioSelectTree();

        // Aquí puedes pasar los datos del contrato a la vista de edición
        return view('contratos.editar-servicio', compact('servicios', 'services', 'ejecutivos'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
        $servicio = Servicio::find($id);
        $servicio->servicio_tree_select = $request->input('idservicio');
        $servicio->fecha_inicio = $request->input('fecha_inicio');
        $servicio->fecha_fin = $request->input('fecha_fin');
        $servicio->tipo_servicio = $request->input('tiposervicio');
        $horas_servicio = str_replace(",", ".", $request->input('horasservicio'));
        $servicio->horas_servicio = $horas_servicio;
        $servicio->servicio_texto = $request->input('textoservicio');
        if ($request->hasFile('pdf_servicio')) {
            // Crear la carpeta 'servicios' si no existe
            $directory = '/public/servicios';

            if (!Storage::exists($directory)) {
                Storage::makeDirectory($directory);
            }
            // Obtener el nombre del archivo con la extensión
            $filenamewithExt = $request->file('pdf_servicio')->getClientOriginalName();
            // Obtener solo el nombre del archivo
            $filename = pathinfo($filenamewithExt, PATHINFO_FILENAME);
            // Obtener solo la extensión
            $extension = $request->file('pdf_servicio')->getClientOriginalExtension();
            // Nombre de archivo para almacenar
            $fileNameToStore = time() . '.' . $extension;
            // Subir archivo
            $path = $request->file('pdf_servicio')->storeAs($directory, $fileNameToStore);
            $servicio->pdf_path = $fileNameToStore;

        }

        // Usar el operador ternario para simplificar
        $servicio->renovacion_automatica = $request->has('renovacionautomatica') ? true : false;
        $servicio->contrato_id = $request->input('contrato_id');

        if ($servicio->save()) {
            // registro de cambio de log
            $changeLog = new ChangeLog();
            $changeLog->change_type = 'update';
            $changeLog->details = 'Se ha actualizado un servicio: ' . $servicio->servicio_tree_select;
            $changeLog->users_id = Auth::user()->id;
            $changeLog->save();
            // Instancia el controlador ApiController
            $apiController = new ApiController();
            // Obtiene las organizaciones
            $organizaciones = $apiController->fetchDataFromApiOrganizations();

            // Obtener el ID del servicio creado
            $servicio_id = $servicio->id;

            /* AQuí busco los servicios que tiene la organización si es que existe */
            if ($servicio_id) {
                // Si se proporciona una ID específica, obtén los datos para esa ID
                $servicios = Servicio::where('contrato_id', $servicio->contrato_id)->get();
            } else {
                // Si no se proporciona ninguna ID, obtén todos los datos de la tabla
                $servicios = Servicio::all();
            }
            // obtiene ejecutivos
            $organizacion_id = DB::table('contratos')
                ->select('organizacion_id')
                ->where('id', '=', $servicio->contrato_id)->get();

            // Redirigir al servicio con el ID del servicio como parámetro
           // dd($organizacion_id);

            return view('contratos.servicios', [
                'servicio_id' => $servicio_id,
                'organizacion_id' => $organizacion_id,
                'organizaciones' => $organizaciones,
                'servicios' => $servicios,
                'contrato_id' => $servicio->contrato_id
            ])->with('toast_success', 'Servicio actualizado con Éxito!');

        } else {
            return redirect('servicios')->with('toast_error', 'Error al ingresar el servicio!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $servicio = DB::table('servicios')->where('id', '=', $request->idservicio);

        if ($servicio->delete()) {
            //registro de cambio de log
            $changeLog = new ChangeLog();
            $changeLog->change_type = 'delete';
            $changeLog->details = 'Se ha eliminado un servicio con el ID: ' . $request->idservicio;
            $changeLog->users_id = Auth::user()->id;
            $changeLog->save();
            return response()->json([
                'message' => "success",
            ]);
        } else {
            return response()->json([
                'message' => "error"
            ]);
        }
    }
}
