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

Route::get('/', 'HomeController@index');

Auth::routes();

Route::get('/home', 'HomeController@home')->name('home');

Route::get('/member', 'MemberController@view');

// Officer panel related routes
Route::get('/officer', 'OfficerController@view');
Route::get('/officer/events', 'EventController@listEvents');
Route::get('/officer/events/manage/{id?}', 'EventController@manageEvent');
Route::get('/settings/edit', 'UserController@edit')->name('settings.edit');

Route::post('/officer/events/manage/{id?}', 'EventController@updateEvent');

Route::put('/settings/update', 'SettingsController@update')->name('settings.update');

Route::resource('meetings', 'MeetingController');
Route::resource('members', 'MemberController');
Route::resource('settings', 'SettingsController', ['only' =>
    [
        'index'
    ]
]);
Route::resource('users', 'UserController');
