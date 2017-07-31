<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/member', 'MemberController@view');

// Officer panel related routes
Route::get('/officer', 'OfficerController@view');
Route::get('/officer/events', 'EventController@listEvents');
Route::get('/officer/events/manage/{id?}', 'EventController@manageEvent');
Route::post('/officer/events/manage/{id?}', 'EventController@updateEvent');

Route::resource('meetings', 'MeetingController');
