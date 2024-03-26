<?php

namespace App\Http\Controllers;

use App\Models\Contrato;
use App\Models\Ejecutivos;
use App\Models\HorasAdicionalesContrato;
use App\Models\HorasAdicionalesServicios;
use App\Models\Servicio;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use DB;

class ContratoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Verificar si se ha enviado una solicitud
        if ($request) {
            // Instancia el controlador ApiController
            $apiController = new ApiController();
            // Obtener los datos de la API de organizaciones
            $organizationsData = $apiController->fetchDataFromApiOrganizations();

            // Realizar la consulta para obtener los contratos
            $sql = trim($request->get('buscarTexto'));
            $contratos = DB::table('contratos')
                ->join('ejecutivos', 'contratos.ejecutivo_id', '=', 'ejecutivos.id')
                ->select(
                    'contratos.id',
                    'contratos.organizacion_id',
                    'contratos.fecha_inicio',
                    'contratos.contrato_o_servicio',
                    'contratos.fecha_fin',
                    'contratos.tipo_contrato',
                    'contratos.horas_contrato',
                    'contratos.contrato_texto',
                    'contratos.renovacion_automatica',
                    'contratos.pdf_path',
                    'contratos.estado_contrato',
                    'ejecutivos.id as ejecutivo_id',
                    'ejecutivos.nombre',
                    'ejecutivos.apellido'
                )
                ->where('contratos.organizacion_id', 'LIKE', '%' . $sql . '%')
                ->orderBy('contratos.id', 'desc')
                ->paginate(10000);

            // Iterar sobre los contratos y agregar los nombres de las organizaciones
            foreach ($contratos as $contrato) {
                $organizationId = $contrato->organizacion_id;

                // Buscar la organización correspondiente en los datos de la API
                $organization = collect($organizationsData)->firstWhere('id', $organizationId);

                // Si se encuentra la organización, agregar el nombre al contrato
                if ($organization) {
                    $contrato->organizacion_name = $organization['name'];
                }
            }

            // Obtiene las organizaciones
            $organizaciones = $apiController->fetchDataFromApiOrganizations();
            return view('contratos.index', ["contratos" => $contratos, "organizaciones" => $organizaciones, "buscarTexto" => $sql]);
        }

        // Si se llega aquí, significa que se ha ejecutado dd($request)
        // Deja este espacio para manejar casos específicos cuando $request no esté definido.
    }


    public function contrato($organizacion_id)
    {
        // Instancia el controlador ApiController
        $apiController = new ApiController();
        // Obtiene las organizaciones
        $organizaciones = $apiController->fetchDataFromApiOrganizations();

        // obtiene ejecutivos
        $ejecutivos = DB::table('ejecutivos')
            ->select('id', 'nombre', 'apellido', 'descripcion')
            ->where('estado', '=', '1')->get();

        return view('contratos.contrato', ['organizaciones' => $organizaciones, 'organizacion_id' => $organizacion_id, 'ejecutivos' => $ejecutivos]);
    }

    public function servicio($contrato_id)
    {
        // Instancia el controlador ApiController
        $apiController = new ApiController();
        // Obtiene las organizaciones
        $organizaciones = $apiController->fetchDataFromApiOrganizations();

        /* AQuí busco los servicios que tiene la organización si es que existe */
        if ($contrato_id) {
            // Si se proporciona una ID específica, obtén los datos para esa ID
            $servicios = Servicio::where('contrato_id', $contrato_id)->get();
        } else {
            // Si no se proporciona ninguna ID, obtén todos los datos de la tabla
            $servicios = Servicio::all();
        }

        return view('contratos.servicios', ['contrato_id' => $contrato_id, 'organizaciones' => $organizaciones, 'servicios' => $servicios]);
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
    public function contratoredireccion($contrato_id, $organizacion_id)
    {
        // Instancia el controlador ApiController
        $apiController = new ApiController();
        // Obtiene las organizaciones
        $organizaciones = $apiController->fetchDataFromApiOrganizations();

        /* AQuí busco los servicios que tiene la organización si es que existe */
        if ($contrato_id) {
            // Si se proporciona una ID específica, obtén los datos para esa ID
            $servicios = Servicio::where('contrato_id', $contrato_id)->get();
        } else {
            // Si no se proporciona ninguna ID, obtén todos los datos de la tabla
            $servicios = Servicio::all();
        }
        return view('contratos.servicios', [
            'contrato_id' => $contrato_id,
            'organizacion_id' => $organizacion_id,
            'organizaciones' => $organizaciones,
            'servicios' => $servicios
        ])->with('toast_success', 'Contrato creado con Éxito!');

    }

    public function contratoredireccionDos($contrato_id, $organizacion_id)
    {
        // Instancia el controlador ApiController
        $apiController = new ApiController();
        // Obtiene las organizaciones
        $organizaciones = $apiController->fetchDataFromApiOrganizations();

        /* AQuí busco los servicios que tiene la organización si es que existe */
        if ($contrato_id) {
            // Si se proporciona una ID específica, obtén los datos para esa ID
            $servicios = Servicio::where('contrato_id', $contrato_id)->get();
        } else {
            // Si no se proporciona ninguna ID, obtén todos los datos de la tabla
            $servicios = Servicio::all();
        }
        return view('contratos.serviciosget', [
            'contrato_id' => $contrato_id,
            'organizacion_id' => $organizacion_id,
            'organizaciones' => $organizaciones,
            'servicios' => $servicios
        ]);

    }
    public function store(Request $request)
    {
        $contrato = new Contrato();
        $contrato->organizacion_id = $request->input('organizacion_consulta');
        $contrato->contrato_o_servicio = $request->input('servicioOcontrato');
        $contrato->fecha_inicio = $request->input('fecha_inicio');
        $contrato->fecha_fin = $request->input('fecha_fin');
        $contrato->tipo_contrato = $request->input('tipocontrato');
        $horas_contrato = str_replace(",", ".", $request->input('horascontrato'));
        $contrato->horas_contrato = $horas_contrato;
        $contrato->contrato_texto = $request->input('textocontrato');
        if ($request->hasFile('pdf_contrato')) {
            // Crear la carpeta 'contratos' si no existe    
            $directory = '/public/contratos';
            if (!Storage::exists($directory)) {
                Storage::makeDirectory($directory);
            }
            // Obtener el nombre del archivo con la extensión
            $filenamewithExt = $request->file('pdf_contrato')->getClientOriginalName();
            // Obtener solo el nombre del archivo
            $filename = pathinfo($filenamewithExt, PATHINFO_FILENAME);
            // Obtener solo la extensión
            $extension = $request->file('pdf_contrato')->getClientOriginalExtension();
            // Nombre de archivo para almacenar
            $fileNameToStore = time() . '.' . $extension;
            // Subir archivo
            $path = $request->file('pdf_contrato')->storeAs($directory, $fileNameToStore);

        }

        $contrato->pdf_path = $fileNameToStore;
        // Usar el operador ternario para simplificar
        $contrato->renovacion_automatica = $request->has('renovacionautomatica') ? true : false;

        $contrato->ejecutivo_id = $request->input('ejecutivo_id');

        if ($contrato->save()) {
            // Instancia el controlador ApiController
            $apiController = new ApiController();
            // Obtiene las organizaciones
            $organizaciones = $apiController->fetchDataFromApiOrganizations();

            // Obtener el ID del contrato creado
            $contrato_id = $contrato->id;

            /* AQuí busco los servicios que tiene la organización si es que existe */
            if ($contrato_id) {
                // Si se proporciona una ID específica, obtén los datos para esa ID
                $servicios = Servicio::where('contrato_id', $contrato_id)->get();
            } else {
                // Si no se proporciona ninguna ID, obtén todos los datos de la tabla
                $servicios = Servicio::all();
            }
            //obtener el id de la organizacion
            $organizacion_id = $contrato->organizacion_id;

            // Redirigir al servicio con el ID del contrato como parámetro

            return view('contratos.servicios', [
                'contrato_id' => $contrato_id,
                'organizacion_id' => $organizacion_id,
                'organizaciones' => $organizaciones,
                'servicios' => $servicios,
                'toast_success' => 'Contrato creado con Éxito!'
            ])->with('toast_success', 'Contrato creado con Éxito!');

            //  return redirect()->route('servicio', ['contrato_id' => $contrato_id, 'organizacion_id' => $organizacion_id])->with('toast_success', 'Contrato creado con Éxito!');

        } else {
            return redirect('contratos')->with('toast_error', 'Error al ingresar el contrato!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($contrato_id, $organizacion_id)
    {
        // Instancia el controlador ApiController
        $apiController = new ApiController();
        // Obtener los datos de la API de organizaciones
        $organizationsData = $apiController->fetchDataFromApiOrganizations();
        //
        $contrato = Contrato::find($contrato_id);

        $organizationId = $contrato->organizacion_id;

        // Buscar la organización correspondiente en los datos de la API
        $organization = collect($organizationsData)->firstWhere('id', $organizationId);

        // Si se encuentra la organización, agregar el nombre al contrato
        if ($organization) {
            $contrato->organizacion_name = $organization['name'];
        }


        $horas_adicionales_contrato = HorasAdicionalesContrato::where('contrato_id', $contrato_id)->get();
        $servicios = Servicio::where('contrato_id', $contrato_id)->get();


        return view('contratos.ver', ['contrato' => $contrato, 'horas_adicionales_contrato' => $horas_adicionales_contrato, 'servicios' => $servicios]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(contrato $ccontrato)
    {
        //
    }

    public function showForm($id)
    {
        $contrato = Contrato::find($id);

        // Instancia el controlador ApiController
        $apiController = new ApiController();

        // obtiene ejecutivos
        $ejecutivos = DB::table('ejecutivos')
            ->select('id', 'nombre', 'apellido', 'descripcion')
            ->where('estado', '=', '1')->get();
        // Obtiene las organizaciones
        $organizaciones = $apiController->fetchDataFromApiOrganizations();
        // Aquí puedes pasar los datos del contrato a la vista de edición
        return view('contratos.editar-contrato', compact('contrato', 'organizaciones', 'ejecutivos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        $contratos = Contrato::find($id);

        $contratos->organizacion_id = $request->input('organizacion_consulta_edita');
        $contratos->contrato_o_servicio = $request->input('servicioOcontrato');
        $contratos->fecha_inicio = $request->input('fecha_inicio');
        $contratos->fecha_fin = $request->input('fecha_fin');
        $contratos->tipo_contrato = $request->input('tipocontrato');
        $horas_contrato = str_replace(",", ".", $request->input('horascontrato'));
        $contratos->horas_contrato = $horas_contrato;
        $contratos->contrato_texto = $request->input('textocontrato');
        if ($request->hasFile('pdf_contrato')) {
            // Crear la carpeta 'contratos' si no existe
            $directory = '/public/contratos';
            if (!Storage::exists($directory)) {
                Storage::makeDirectory($directory);
            }
            // Obtener el nombre del archivo con la extensión
            $filenamewithExt = $request->file('pdf_contrato')->getClientOriginalName();
            // Obtener solo el nombre del archivo
            $filename = pathinfo($filenamewithExt, PATHINFO_FILENAME);
            // Obtener solo la extensión
            $extension = $request->file('pdf_contrato')->getClientOriginalExtension();
            // Nombre de archivo para almacenar
            $fileNameToStore = time() . '.' . $extension;
            // Subir archivo
            $path = $request->file('pdf_contrato')->storeAs($directory, $fileNameToStore);
            $contratos->pdf_path = $fileNameToStore;
        }

        // Usar el operador ternario para simplificar
        $contratos->renovacion_automatica = $request->has('renovacionautomatica') ? true : false;

        $contratos->ejecutivo_id = $request->input('ejecutivo_id');

        if ($contratos->save()) {
            // Instancia el controlador ApiController
            $apiController = new ApiController();
            // Obtener los datos de la API de organizaciones
            $organizationsData = $apiController->fetchDataFromApiOrganizations();

            // Realizar la consulta para obtener los contratos
            $sql = trim($request->get('buscarTexto'));
            $contratos = DB::table('contratos')
                ->join('ejecutivos', 'contratos.ejecutivo_id', '=', 'ejecutivos.id')
                ->where('contratos.organizacion_id', 'LIKE', '%' . $sql . '%')
                ->orderBy('contratos.id', 'desc')
                ->paginate(10000);

            // Iterar sobre los contratos y agregar los nombres de las organizaciones
            foreach ($contratos as $contrato) {
                $organizationId = $contrato->organizacion_id;

                // Buscar la organización correspondiente en los datos de la API
                $organization = collect($organizationsData)->firstWhere('id', $organizationId);

                // Si se encuentra la organización, agregar el nombre al contrato
                if ($organization) {
                    $contrato->organizacion_name = $organization['name'];
                }
            }

            // Obtiene las organizaciones
            $organizaciones = $apiController->fetchDataFromApiOrganizations();
            return view('contratos.index', [
                "contratos" => $contratos,
                "organizaciones" => $organizaciones,
                "buscarTexto" => $sql,
                'toast_success' => 'Contrato actualizado con Éxito!'
            ])->with('toast_success', 'Contrato actualizado con Éxito!');
        } else {
            return redirect('contratoss')->with('toast_error', 'Error al actualizar el contrato!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $contrato = DB::table('contratos')->where('id', '=', $request->idcontrato);

        $servicio = DB::table('servicios')->where('contrato_id', '=', $request->idcontrato)->exists();

        if ($servicio) {
            return response()->json([
                'message_alert' => "error",
            ]);
        } else {
            if ($contrato->delete()) {
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
}