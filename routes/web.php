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

Route::get('home/{tri?}/{ano?}', 'HomeController@index')->where(['tri' => '[1-4]', 'ano' => '[0-9]+']);
Route::get('new', 'HomeController@new');
Route::get('user', 'HomeController@user');
Route::get('horas', 'HomeController@horas');

Route::post('pdf/nuevo', 'HomeController@generaPdf');

Route::post('user/editar', 'HomeController@editaUserField');

Route::post('gasto/nuevo', 'HomeController@gasto_nuevo');
Route::post('gasto/borrar', 'HomeController@borraGasto');

Route::post('factura/nuevo', 'HomeController@factura_nuevo');
Route::post('factura/borrar', 'HomeController@borraFactura');
Route::post('factura/pagada', 'HomeController@pagadaFactura');

Route::post('cliente/nuevo', 'HomeController@nuevoCliente');

Route::post('jornada/guardar', 'HomeController@guardaJornada');
