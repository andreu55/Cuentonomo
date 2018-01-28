<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Hash;
use Auth;

use App\User;
use App\Gasto;
// use App\Client;
// use App\Factura;
// use App\Tipo_gasto;

class APIController extends Controller {

  public function login(Request $request) {

    $res = [];

    $login = isset($request->login) ? $request->login : '';
    $password = isset($request->password) ? $request->password : 0;

    $status = 200;
    $msj = '';

    // // Datos que queremos pasar tambien (Son los nombres de las funciones que hemos creado en el modelo)
    // $eager_load = [
    //   // 'provincia',
    //   'user_tipo',
    //   'avatar',
    //   'archivos',
    //   'empresas.empresa_tipo'
    // ];

    if ($login) {
      if ($password) {

        // OJO! Esta consulta ya ignora los usuarios que tienen rellenado el campo 'deleted_at' si queremos verlos todos hay que añadir ->withTrashed() a la consulta
        if (strpos($login, '@') !== false) {
          $user = User::where('email', $login)->first(); // with($eager_load)->
        } else {
          $user = User::where('clave', $login)->first();
        }

        if ($user) {

          // Comprobar que el $pass que nos pasan coincida con los datos del usuario que pretenden loguear
          if (Hash::check($password, $user->password)) {

            // Si el usuario no tiene api_token se lo generamos
            if (!$user->api_token) {
              $token = str_random(60);

              while (User::where('api_token', $token)->take(1)->count()) {
                $token = str_random(60);
              }

              $user->api_token = $token;
              $user->save();
            }

            $data['msj'] = "¡Bienvenido!";
            $data['user'] = $user;

            // Aqui cargamos los datos comunes con los que ya tenemos en $data
            $res = $this->get_datos_comunes($data);

          }
          else { $status = 401; $msj = 'No existe / Dado de baja / Credenciales inválidas'; }
        }
        // El usuario no existe.
        else { $status = 400; $msj = 'Credenciales inválidas'; }
      }
      else { $status = 400; $msj = 'Falta el password'; }
    }
    else { $status = 400; $msj = 'Falta el login'; }

    $res['error'] = $msj;

    return response()->json($res, $status);
  }
  public function getUser(Request $request) {

    $data['msj'] = "¡Bienvenido de nuevo!";
    $data['user'] = $request->user();

    // Aqui cargamos los datos comunes con los que ya tenemos en $data
    $res = $this->get_datos_comunes($data);

    return response()->json($res, 200);
  }

  // Construimos un array con los datos que recibimos y los comunes para la app
  private function get_datos_comunes($data) {

    // Datos que recibimos en esta funcion desde $data
    $res['msj'] = isset($data['msj']) ? $data['msj'] : '';
    $res['user'] = isset($data['user']) ? $data['user'] : [];
    $res['status'] = "success";

    // Datos que sacamos de DB
    // $res['finalidades'] = DB::table('finalidades')->get();
    // $res['tasador_tipos'] = DB::table('tasador_tipos')->get();
    // $res['paises'] = DB::table('paises')->get();
    // $res['archivo_tipos'] = DB::table('archivo_tipos')->orderBy('prioridad', 'ASC')->select('id', 'nombre', 'icon', 'prefix')->get();
    // $res['trabajos'] = DB::table('trabajos')->where('creador_id', $res['user']->id)->orderBy('id', 'DESC')->select('id', DB::raw("CONCAT(concepto) AS nombre"), 'finalidad_id')->get();
    // $res['areas'] = Area::todas();

    return $res;
  }

  public function nuevoGasto(Request $request) {

    $cantidad = isset($request->cantidad) ? $request->cantidad : 0;
    $concepto = isset($request->concepto) ? $request->concepto : 'Sin Concepto';
    $tipo = isset($request->tipo) ? $request->tipo : 1;
    $fecha = isset($request->fecha) ? date("Y-m-d 00:00:00",strtotime($request->fecha)) : date("Y-m-d h:i:s");

    if (!$fecha || !$cantidad || !$tipo || !$concepto) {
      $res['status'] = "error";
      $res['msj'] = '¡Faltan datos!';
      $status = 406;
    } else {
      $gasto = new Gasto();
        $gasto->user_id = Auth::id();
        $gasto->cantidad = $cantidad;
        $gasto->concepto = $concepto;
        $gasto->tipo_gasto_id = $tipo;
        $gasto->created_at = $fecha;
      $gasto->save();

      $res['status'] = "success";
      $res['msj'] = '¡Gasto guardado!';
      $status = 200;
    }
    return response()->json($res, $status);
  }

  public function borraGasto(Request $request) {

    $id = (isset($request->id) && $request->id) ? $request->id : 0;

    if ($id) {
      if ($gasto = Gasto::find($id)) {
        $gasto->delete();
        $res['status'] = "success";
        $status = 200;
        $res['msj'] = 'Borrado con éxito!';
      } else {
        $res['status'] = "error";
        $status = 400;
        $res['msj'] = 'Gasto no encontrado';
      }
    } else {
      $res['status'] = "error";
      $status = 406;
      $res['msj'] = 'Faltan datos!';
    }
    return response()->json($res, $status);
  }

}
