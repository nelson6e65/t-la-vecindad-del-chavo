<?php

use Illuminate\Support\Facades\Route;

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

Route::group([
    'prefix' => 'auth',
], function ($router) {
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::get('me', 'AuthController@me');
});

Route::group([
    'middleware' => 'auth:api',
], function ($router) {
    Route::resource('tenants', 'TenantsController')->except([
        'create',
        'edit',
    ]);

    Route::resource('tenants.media', 'Tenants\MediaController')->only('store');

    Route::resource('titles', 'TitlesController')->only([
        'index',
        'show',
    ]);
});
