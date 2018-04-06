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

Route::get('home/{tri?}/{ano?}/{user_id?}/{token?}', 'HomeController@index')->where(['tri' => '[1-4]', 'ano' => '[0-9]+']);

Route::group(['middleware' => ['auth']], function() {

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
  Route::post('hora/borrar', 'HomeController@borraHora');

  Route::post('publicar', 'HomeController@publicar');
  Route::post('publicar/borrar', 'HomeController@despublicar');

});

Route::get('genera/{user_id?}/{dias?}', function($user_id = 0, $dias = 1) {

  $fecha = new DateTime();
  $fecha->modify('+'.$dias.' day');
  $fecha_format = $fecha->format('Y-m-d H:i:s');

  if ($user_id) {
    $user = App\User::find($user_id);
      $user->access_token = encrypt($fecha->format('Y-m-d H:i:s'));
    $user->save();

    echo url('home/' . 1 . '/' . date('Y') . '/' . $user_id . '/' . $user->access_token);
  } else {
    echo "Falta el user";
  }


});


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
