<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;

use App\User;
use App\Client;
use App\Factura;
use App\Gasto;
use App\Tipo_gasto;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($tri = 0, $ano = 0) {

      $trimestre = $tri ? $tri : trimestre(date('Y-m-d H:i:s'));
      $year = $ano ? $ano : date('Y');

      switch ($trimestre) {
        case 1: $ini_tri = '-01-01'; $fin_tri = '-03-31'; break;
        case 2: $ini_tri = '-04-01'; $fin_tri = '-06-30'; break;
        case 3: $ini_tri = '-07-01'; $fin_tri = '-09-30'; break;
        case 4: $ini_tri = '-10-01'; $fin_tri = '-12-31'; break;
        default: $data['error'] = "WTF"; break;
      }

      if ($year && $ini_tri && $fin_tri) {

        $fecha_ini = $year . $ini_tri;
        $fecha_fin = $year . $fin_tri;

        // Cogemos las del trimestre
        $data['trimestre'] = $trimestre;
        $data['year'] = $year;
        $data['facturas'] = Factura::where('user_id', Auth::id())->whereBetween('created_at', [$fecha_ini, $fecha_fin])->orderBy('created_at', 'DESC')->orderBy('id', 'DESC')->get();
        $data['gastos'] = Gasto::where('user_id', Auth::id())->whereBetween('created_at', [$fecha_ini, $fecha_fin])->orderBy('created_at', 'DESC')->orderBy('id', 'DESC')->get();
      }

      return view('home', $data);
    }

    public function new() {

      $data['tipo_gastos'] = Tipo_gasto::get();
      $data['clients'] = Client::get();

      return view('new', $data);
    }


    public function gasto_nuevo(Request $request) {

      $cantidad = isset($request->cantidad) ? $request->cantidad : 0;
      $concepto = isset($request->concepto) ? $request->concepto : 0;
      $tipo = isset($request->tipo) ? $request->tipo : 0;
      $fecha = isset($request->fecha) ? $request->fecha : 0;

      if (!$fecha || !$cantidad || !$tipo || !$concepto) {
        return response()->json([
            'res' => 400,
            'msj' => 'Faltan datos!'
        ]);
      } else {
        $gasto = new Gasto();
          $gasto->user_id = Auth::id();
          $gasto->cantidad = $cantidad;
          $gasto->concepto = $concepto;
          $gasto->tipo_gasto_id = $tipo;
          $gasto->created_at = $fecha;
        $gasto->save();

        return response()->json([
          'res' => 200,
          'msj' => 'Ok'
        ]);
      }
    }

    public function factura_nuevo(Request $request) {

      $id = isset($request->id) ? $request->id : 0;
      $cliente = isset($request->cliente) ? $request->cliente : 0;
      $horas = isset($request->horas) ? $request->horas : 0;
      $precio = isset($request->precio) ? $request->precio : 0;
      $fecha = isset($request->fecha) ? $request->fecha : 0;

      if (!$id || !$cliente || !$precio || !$fecha) {
        return response()->json([
            'res' => 400,
            'msj' => 'Faltan datos!'
        ]);
      } else {

        $y = substr($fecha, 2, 2);
        $num = "00" . $id . "/" . $y;

        $factura = new Factura();
          $factura->num = $num;
          $factura->user_id = Auth::id();
          $factura->client_id = $cliente;
          $factura->horas = $horas;
          $factura->precio = $precio;
          $factura->created_at = $fecha;
        $factura->save();

        return response()->json([
          'res' => 200,
          'msj' => 'Ok'
        ]);
      }
    }
}
