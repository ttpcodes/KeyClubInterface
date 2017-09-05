<?php

namespace App\Http\Controllers;

use App\Member;
use App\Setting;

use GuzzleHttp;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RemindController extends Controller
{
    protected $token;

    public function __construct()
    {
        if (!$this->token) {
            $this->token = Setting::firstOrCreate(['id' => 'remindToken'], ['value' => null])->value;
        }
    }

    public function accessTokens(Request $request) {
        $http = new GuzzleHttp\Client;
        try {
            $response = $http->post('https://api.remind.com/v2/access_tokens', [
                'form_params' => [
                    'user' => [
                        'email' => $request->email,
                        'password' => $request->password
                    ]
                ]
            ]);
        } catch (ClientException $e) {
            Log::info('Error on getting credentials for Remind.');
            return response()->json([
                'status' => 401,
                'error' => json_decode((string) $e->getResponse()->getBody(), true)
            ], 401);
        }
        $json = json_decode((string) $response->getBody(), true);
        Setting::updateOrCreate(['id' => 'remindToken'], ['value' => $json['token']]);

        return view('remind/access_tokens', [
            'status' => 200,
            'data' => $json
        ]);

        // return [
        //     'status' => 200,
        //     'data' => $json
        // ];
    }

    public function accessTokensCreate() {
        return view('remind/access_tokens');
    }

    public function classes() {
        $http = new GuzzleHttp\Client([
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ' . $this->token
            ]
        ]);
        try {
            $response = $http->get('https://api.remind.com/v2/classes');
        } catch (ClientException $e) {
            Log::info('Error on getting credentials for Remind.');
            return response()->json([
                'status' => 401,
                'error' => json_decode((string) $e->getResponse()->getBody(), true)
            ], 401);
        }
        return json_decode((string) $response->getBody(), true);
    }

    public function classesInvitations(Request $request) {
        $http = new GuzzleHttp\Client([
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ' . $this->token
            ]
        ]);

        $member = Member::find($request->memberID);
        try {
            $response = $http->post('https://api.remind.com/v2/classes/' . $request->classID . '/invitations', [
                'form_params' => [
                    'invitation' => [
                        'recipient' => 'sms://+1' . $member->phone,
                        'name' => $member->first . " " . $member->last,
                        'not_child' => true,
                        'role' => 'student'
                    ]
                ]
            ]);
        } catch (ClientException $e) {
            Log::info('Error on getting credentials for Remind.');
            return response()->json([
                'status' => 401,
                'error' => json_decode((string) $e->getResponse()->getBody(), true)
            ], 401);
        } catch (ServerException $e) {
            Log::info('Error on request.');
            return [
                'status' => 500
            ];
        }
        return json_decode((string) $response->getBody(), true);
    }

    public function user() {
        $http = new GuzzleHttp\Client([
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ' . $this->token
            ]
        ]);
        try {
            $response = $http->get('https://api.remind.com/v2/user');
        } catch (ClientException $e) {
            Log::info('Error on getting credentials for Remind.');
            return response()->json([
                'status' => 401,
                'error' => json_decode((string) $e->getResponse()->getBody(), true)
            ], 401);
        }
        return json_decode((string) $response->getBody(), true);
    }
}
