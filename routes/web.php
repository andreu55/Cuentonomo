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
  if (Auth::guest()) {
    return view('welcome');
  } else {
    return redirect('home');
  }
});

Auth::routes();

Route::get('home/{tri?}/{ano?}', 'HomeController@index')->where(['tri' => '[1-4]', 'ano' => '[0-9]+']);
Route::get('new', 'HomeController@new');
Route::get('user', 'HomeController@user');
Route::get('horas/{mes?}/{ano?}', 'HomeController@horas');

Route::post('pdf/nuevo', 'HomeController@generaPdf');

Route::post('user/editar', 'HomeController@editaUserField');

Route::post('gasto/nuevo', 'HomeController@gasto_nuevo');
Route::post('gasto/borrar', 'HomeController@borraGasto');

Route::post('factura/nuevo', 'HomeController@factura_nuevo');
Route::post('factura/borrar', 'HomeController@borraFactura');
Route::post('factura/pagada', 'HomeController@pagadaFactura');

Route::post('cliente/nuevo', 'HomeController@nuevoCliente');
Route::post('cliente/borrar', 'HomeController@borraCliente');

Route::post('jornada/guardar', 'HomeController@guardaJornada');

// Route::get('migrationJornadasToHoras', function () {
//
//   $user = Auth::user();
//   $jornadas = $user->jornadas;
//
//   foreach ($user->jornadas as $j) {
//
//     $hora = new App\Hora();
//       $hora->user_id = 1;
//       $hora->client_id = 2;
//       $hora->nota = $j->notas ?? null;
//       $hora->entrada = $j->fecha . " " . $j->entrada;
//       $hora->salida = $j->fecha . " " . $j->salida;
//     $hora->save();
//   }
//
//   return 'Fin!';
// });
