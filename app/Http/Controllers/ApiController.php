<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

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
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiToken,
        ])->get('https://valuedesk2.valuetech.cl/api/v1/organizations');

        return $response->json();
    }
 
    // Método para obtener datos de la API 2 utilizando el token de autenticación
    public function fetchDataFromApi2()
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiToken,
        ])->get('https://api2.example.com/data');

        return $response->json();
    }

}
