<?php

namespace App\Http\Controllers;

use App\Models\Property;
use GuzzleHttp\Client;

class MapController extends Controller
{
    public function index()
    {
        $client = new Client();
        $supersetApiUrl = "http://82.112.237.22:8088/api/v1";

        // Lấy access token
        $responseTokenLogin = $client->request('POST', $supersetApiUrl . "/security/login", [
            'json' => [
                'username' => 'admin',
                'password' => 'admin',
                'provider' => 'db',
                'refresh' => false,
            ],
        ]);

        $bodyTokenLogin = json_decode($responseTokenLogin->getBody(), true);
        $token = $bodyTokenLogin['access_token'];

        // Lấy guest token
        $responseGetGuestToken = $client->request('POST', $supersetApiUrl . "/security/guest_token/", [
            'headers' => [
                'Authorization' => 'Bearer ' . $token,
            ],
            'json' => [
                'resources' => [
                    [
                        'type' => 'dashboard',
                        'id' => '43406797-3673-4179-b8e5-771f922079d0', // ID dashboard
                    ],
                ],
                'user' => [
                    'username' => 'guest_user',
                    'first_name' => 'guest_user',
                    'last_name' => 'guest_user',
                    'email' => 'guest_user@example.com',
                ],
                'rls' => [],
            ],
        ]);

        $bodyGuestToken = json_decode($responseGetGuestToken->getBody(), true);
        $guestToken = $bodyGuestToken['token'];

        // Trả về view với guest token
        return view('pages.map', ['guestToken' => $guestToken]);
    }
}