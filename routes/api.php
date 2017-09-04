<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/oauth/grant/password', 'PasswordGrantController@login');
Route::post('/oauth/grant/refresh', 'PasswordGrantController@refresh');

Route::group(['middleware' => 'auth:api'], function() {
    Route::post('/logout', 'PasswordGrantController@logout');
    
    Route::resource('meetings', 'Api\MeetingController', ['except' => [
        'create', 'edit'
    ]]);
});
