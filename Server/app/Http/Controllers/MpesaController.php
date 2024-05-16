<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Exception;

class MpesaController extends Controller
{
    public function getAccessToken()
    {
        try
        {
            $consumerKey = env('MPESA_CONSUMER_KEY');
            $consumerSecret = env('MPESA_CONSUMER_SECRET');

            $authUrl = env('MPESA_AUTH_ENDPOINT');

            $encodedCredentials = base64_encode($consumerKey.':'.$consumerSecret);

            $headers = [
                'Authorization' => 'Basic '. $encodedCredentials,
                'Content-Type' => 'application/json'
            ];

            $response = Http::withHeaders($headers)->get($authUrl);

            if ($response->failed())
            {
                return response()->json([
                    'error' => 'Failed to get access token: ' . $response->body()
                ]);
            }

            $responseData = $response->json();

            if (isset($responseData['access_token'])) {

                return response()->json([
                    'access_token' => $responseData['access_token']
                ]);

            } else {
                return response()->json([
                    'error' => 'Failed to get access token:' . $responseData['error_description']
                ]);
            }
        } catch (Exception $error) {

            return response()->json([
                'error' => $error->getMessage()
            ], 500);
        }
    }

    public function stkPush(Request $request)
    {
        try {
            $accessTokenResponse = $this->getAccessToken();

            if ($accessTokenResponse->getStatusCode() === 200)
            {
                $accessToken = $accessTokenResponse->getData()->access_token;

                $timestamp = now()->format('YmdHis');

                $shortCode = env('MPESA_SHORT_CODE');
                $passkey = env('MPESA_PASSKEY');

                $stkUrl = env('MPESA_STK_ENDPOINT');

                $stkPassword = base64_encode($shortCode.$passkey.$timestamp);

                $headers = [
                    'Authorization' => 'Bearer '.$accessToken,
                    'Content-Type' => 'application/json'
                ];

                $requestBody = [
                    'BusinessShortCode' => $shortCode,
                    'Password' => $stkPassword,
                    'Timestamp' => $timestamp,
                    'TransactionType' => 'CustomerPayBillOnline',
                    'Amount' => $request->amount,
                    'PartyA' => $request->partyA_phone_number,
                    'PartyB' => $shortCode,
                    'PhoneNumber' => $request->phone_number,
                    'CallBackURL' => env('MPESA_CALLBACK_URL'),
                    'AccountReference' => $request->reference,
                    'TransactionDesc' => $request->description
                ];

                $response = Http::withHeaders($headers)->post($stkUrl, $requestBody);

                return $response;
            } else {
                return response()->json([
                    'error' => 'Failed to get access token'
                ]);
            }
        } catch (Exception $error) {
            return response()->json([
                'error' => $error->getMessage()
            ], 500);
        }
    }
}
