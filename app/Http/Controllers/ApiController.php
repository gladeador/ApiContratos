<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use PhpOption\Option;

class ApiController extends Controller
{
    protected $apiToken;

    // Constructor para inicializar el token de la API
    public function __construct()
    {
        // Aquí puedes asignar el token de autenticación
        $this->apiToken = env('APP_TOKEN_API');
    }

    // Método para obtener datos de la API 1 utilizando el token de autenticación
    public function fetchDataFromApiOrganizations()
    {

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiToken,
            ])->timeout(30)->get(env('APP_URL_API') .'/api/v1/organizations');

            return $response->json();

        } catch (\Exception $e) {
            // Si se produce un error de tiempo de espera (timeout)
            if ($e->getCode() === CURLE_OPERATION_TIMEOUTED) {
                return redirect()->route('home')->with('toast_error', 'La solicitud ha excedido el tiempo límite.');
            }
            // Si se produce otro tipo de error
            return redirect()->route('home')->with('toast_error', 'Se produjo un error al realizar la solicitud a la API.');
        }
    }



    // Método para obtener datos de la API 2 utilizando el token de autenticación
    public function fetchDataServicioSelectTree()
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiToken,
        ])->get(env('APP_URL_API') .'/api/v1/object_manager_attributes');

        // Decodificar la respuesta JSON
        $data = $response->json();

        // Filtrar los resultados para mostrar solo aquellos con type = 'tree_select'
        $filteredResults = array_filter($data, function ($item) {
            return isset ($item['name']) && $item['name'] === 'idservicio';
        });

        // Retornar los resultados filtrados
        return $filteredResults;
    }

}
