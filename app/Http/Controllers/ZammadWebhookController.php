<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ZammadWebhookController extends Controller
{
    //
    public function __construct()
    {
        // Aquí puedes asignar el token de autenticación
        $this->apiToken = env('APP_TOKEN_API');
    }
    public function handle(Request $request)
    {
        // Clave secreta para calcular el HMAC
        $secretKey = 'Valuetech2014**';

        // Obtener el HMAC SHA-1 del encabezado HTTP enviado por Zammad
        $receivedHmac = $request->header('X-Hub-Signature');

        // Recuperar el cuerpo de la solicitud como datos JSON
        $requestBody = file_get_contents('php://input');


        // Calcular el HMAC SHA-1 del cuerpo de la solicitud utilizando la clave secreta
        $calculatedHmac = hash_hmac('sha1', $requestBody, $secretKey);
        $calculatedHmac = 'sha1=' . $calculatedHmac;

        // Comparar el HMAC recibido con el HMAC calculado para verificar la integridad de los datos
        if ($receivedHmac === $calculatedHmac) {
            // Obtener los datos del webhook y decodificarlos desde JSON
            $webhookData = json_decode($request->getContent(), true);
            $ticket_id = $webhookData['ticket']['id'];
            $organizacion_id = $webhookData['ticket']['organization_id'];
            $idservicio = $webhookData['ticket']['idservicio'];
            $time_unit = $webhookData['ticket']['time_unit'];
            $created_at = $webhookData['ticket']['created_at'];
            $updated_at = $webhookData['ticket']['updated_at'];
            $accounted_time = $webhookData['article']['accounted_time'];

            /* Aqui consutamos si estan las horas por contrato o por servicio */
            $xcontratooservicio = busca_true_contrato($organizacion_id);

            /* Aquí verificamos que es por contrato */
            if ($xcontratooservicio->contrato_o_servicio == "true") {

                $inserta_horas_ticket_contrato = inserta_horas_ticket_contrato($ticket_id, $organizacion_id, $created_at, $updated_at, $accounted_time, $xcontratooservicio);

                // Datos para enviar en la solicitud PUT
                $data = [
                    'horas_disponibles' => $inserta_horas_ticket_contrato
                ];

                // Realizar la solicitud PUT utilizando Http facade
                $response = Http::withHeaders([
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Basic ' . base64_encode('eguzman@valuetech.cl:GUZ183my**')
                ])->put(env('APP_URL_API') . '/api/v1/tickets/' . $ticket_id, $data);

                return response()->json([
                    'response' => 'Insersión exitosa',
                ], 200);

                /* Aquí verificamos si es por servicio */
            } else if ($xcontratooservicio->contrato_o_servicio == "false" || $xcontratooservicio->contrato_o_servicio == false || $xcontratooservicio->contrato_o_servicio == "") {

                $inserta_horas_ticket_servicio = inserta_horas_ticket_servicio($ticket_id, $organizacion_id, $idservicio, $time_unit, $created_at, $updated_at, $accounted_time, $xcontratooservicio);
                // Datos para enviar en la solicitud PUT
                $data = [
                    'horas_disponibles' => $inserta_horas_ticket_servicio
                ];

                // Realizar la solicitud PUT utilizando Http facade
                $response = Http::withHeaders([
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Basic ' . base64_encode('eguzman@valuetech.cl:GUZ183my**')
                ])->put(env('APP_URL_API') . '/api/v1/tickets/' . $ticket_id, $data);

                return response()->json([
                    'response' => 'Insersión exitosa',
                ], 200);


                /* Aqui dejamos la organizacion que no tiene contrato */
            } else {

                $data = [
                    'horas_disponibles' => 'La organización no tiene creado un contrato'
                ];

                // Realizar la solicitud PUT utilizando Http facade
                $response = Http::withHeaders([
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Basic ' . base64_encode('eguzman@valuetech.cl:GUZ183my**')
                ])->put(env('APP_URL_API') . '/api/v1/tickets/' . $ticket_id, $data);
            }

        } else {
            return response()->json([
                'message' => 'No tiene acceso para ingresar al webhook'
            ], 200);
        }


    }
}