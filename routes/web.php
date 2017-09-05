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

Auth::routes();

Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@home')->name('home');
Route::get('/member', 'MemberController@view');
Route::get('/settings/edit', 'SettingsController@edit')->name('settings.edit');

Route::put('/settings', 'SettingsController@update')->name('settings.update');

Route::prefix('remind')->group(function() {
    Route::get('access_tokens', 'RemindController@accessTokensCreate')->name('remind.access_tokens.create');
    Route::get('classes', 'RemindController@classes');
    Route::get('user', 'RemindController@user')->name('remind.user');

    Route::post('access_tokens', 'RemindController@accessTokens')->name('remind.access_tokens.store');
    Route::post('classes/invitations', 'RemindController@classesInvitations')->name('remind.classes.invitations.store');
});

Route::resource('events', 'EventController');
Route::resource('meetings', 'MeetingController');
Route::resource('members', 'MemberController');
Route::resource('settings', 'SettingsController', ['only' =>
    [
        'index'
    ]
]);
Route::resource('users', 'UserController');
