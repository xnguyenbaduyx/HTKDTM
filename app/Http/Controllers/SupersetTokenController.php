<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class SupersetTokenController extends Controller
{
    public function test(){
        $client = new Client();

        // Khai báo url api superset
        $supersetApiUrl = "http://82.112.237.22:8088/api/v1";

        $responseTokenLogin = $client->request('POST', $supersetApiUrl . "/security/login", [
            'json' => [
                'username' => 'admin',
                'password' => 'admin',
                'provider' => 'db',
                'refresh' => false
            ]
        ]);

        $bodyTokenLogin = json_decode($responseTokenLogin->getBody(), true);
        $token = $bodyTokenLogin['access_token'];

        $responseGetGuestToken = $client->request('POST', $supersetApiUrl . "/security/guest_token/", [
            'headers' => [
                'Authorization' => 'Bearer ' . $token
            ],
            'json' => [
                'resources' => [
                    [
                        'type' => 'dashboard',
                        'id' => '43406797-3673-4179-b8e5-771f922079d0' // ID dashboard
                    ]
                ],
                'user' => [
                    'username' => 'guest_user',
                    'first_name' => 'guest_user',
                    'last_name' => 'guest_user',
                    'email' => 'guest_user'
                ],
                'rls' => [
                    
                ]
            ]
        ]);

        $bodyGuestToken = json_decode($responseGetGuestToken->getBody(), true);
        $guestToken = $bodyGuestToken['token'];

        return response()->json($guestToken);
    }
}
