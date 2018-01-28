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

Route::options('{any?}', function ($any) { return response('', 200); })->where('any', '.*'); // Ruta OPTIONS atrapalotodo
Route::post('/login', 'APIController@login');

Route::group(['middleware' => ['auth:api']], function() {

    Route::post('user', 'APIController@getUser'); // Para loguear por token guardado en el navegador

    Route::post('gasto/nuevo', 'APIController@nuevoGasto');

});
