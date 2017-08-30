<?php

namespace App\Http\Controllers;

use GuzzleHttp;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PasswordGrantController extends Controller
{
    /**
     * Check if the credentials provided by the client are valid and attach
     * the password grant client information if so.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request) {
        Log::info('Attempting verification of user credentials...');
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            Log::info('Successfully verified user. Now initiating password grant...');
            $http = new GuzzleHttp\Client;
            try {
                $response = $http->post(env('APP_URL') . '/oauth/token', [
                    'form_params' => [
                        'grant_type' => 'password',
                        'client_id' => env('PASSWORD_CLIENT_ID'),
                        'client_secret' => env('PASSWORD_CLIENT_SECRET'),
                        'username' => $request->email,
                        'password' => $request->password,
                        'scope' => '*'
                    ],
                ]);

                return json_decode((string) $response->getBody(), true);
            } catch (ConnectException $e) {
                return response()->json([
                    'status' => 500,
                    'error' => 'GuzzleHttp APP_URL improperly configured.'
                ], 500);
            } catch (RequestException $e) {
                return response()->json([
                    'status' => 500,
                    'error' => 'PASSWORD_CLIENT improperly configured.'
                ]);
            }
        }
        return response()->json([
            'status' => 401,
            'error' => 'Incorrect credentials.'
        ], 401);
    }
}
