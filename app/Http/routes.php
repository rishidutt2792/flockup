<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

$api = app('Dingo\Api\Routing\Router');

$api->version('v1',['prefix' => 'api/v1'], function ($api) {
    $api->post('login', 'App\Http\Controllers\OAuth\OAuthController@login');
});

$api->version('v1', ['prefix' => 'api/v1','middleware' => 'api.auth','providers' => ['oauth'],'scopes' => ['superuser']], function ($api) {
    $api->get('test1', 'App\Http\Controllers\TestController@test1');

    // me endpoints
    $api->get('me', 'App\Http\Controllers\Me\MeController@index');
});

$api->version('v1', ['prefix' => 'api/v1','middleware' => 'api.auth','providers' => ['oauth'],'scopes' => ['admin']], function ($api) {
    $api->get('test2', 'App\Http\Controllers\TestController@test2');
});