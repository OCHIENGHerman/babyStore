<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Exception;

class MpesaController extends Controller
{
    public function getAcessToken()
    {
        try
        {
            $consumerKey = env('MPESA_CONSUMER_KEY');
            $consumerSecret = env('MPESA_CONSUMER_SECRET');

            $url = env('MPESA_AUTH_ENDPOINT');

            $encodedCredentials = base64_encode($consumerKey.':'.$consumerSecret);

            $headers = [
                'Authorization' => 'Basic '. $encodedCredentials,
                'Content-Type' => 'application/json'
            ];

            $response = Http::withHeaders($headers)->get($url);

            if ($response->failed())
            {
                throw new Exception('Failed to get access token:' . $response->body());
            }

            $responseData = $response->json();

            if (isset($responseData['access_token'])) {
                return response()->json(['access_token' => $responseData['access_token']]);
            } else {
                throw new Exception('Failed to get access token:' . $responseData['error_description']);
            }
        } catch (Exception $error) {
            
            return response()->json(['error' => $error->getMessage()], 500);
        }
    }
}
