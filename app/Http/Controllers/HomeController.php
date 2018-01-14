<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Factura;
use App\Gasto;

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
    public function index($tri = 0, $ano = 0)
    {
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
        $data['facturas'] = Factura::whereBetween('created_at', [$fecha_ini, $fecha_fin])->orderBy('created_at', 'DESC')->orderBy('id', 'DESC')->get();
        $data['gastos'] = Gasto::whereBetween('created_at', [$fecha_ini, $fecha_fin])->orderBy('created_at', 'DESC')->orderBy('id', 'DESC')->get();
      }

      return view('home', $data);
    }
}
