<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use PDF;
use DB;

use App\User;
use App\Client;
use App\Factura;
use App\Gasto;
use App\Tipo_gasto;
use App\Jornada;

class HomeController extends Controller
{
    public function __construct() {
      $this->middleware('auth');
    }

    public function index($tri = 0, $ano = 0) {

      $trimestre = $tri ? $tri : trimestre(date('Y-m-d H:i:s'));
      $year = $ano ? $ano : date('Y');

      $sig_trim = $trimestre + 1;
      $ant_trim = $trimestre - 1;
      $sig_year = $ant_year = $year;

      if ($sig_trim > 4) { $sig_trim = 1; $sig_year++; }
      if ($ant_trim < 1) { $ant_trim = 4; $ant_year--; }

      $data['sig_trim'] = $sig_trim;
      $data['sig_year'] = $sig_year;
      $data['ant_trim'] = $ant_trim;
      $data['ant_year'] = $ant_year;

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

      $user = Auth::user();

      $data['tipo_gastos'] = Tipo_gasto::get();
      $data['clients'] = $user->clients;
      // Client::where('')->get();

      return view('new', $data);
    }

    public function user() {

      $user = Auth::user();

      // $campos[] = new \stdClass();

      $data['campos'] = [
        ['tipo' => 'text', 'campo_db' => 'name', 'nombre' => 'Nombre'],
        ['tipo' => 'text', 'campo_db' => 'email', 'nombre' => 'Email'],
        ['tipo' => 'text', 'campo_db' => 'email_public', 'nombre' => 'Email público'],
        ['tipo' => 'text', 'campo_db' => 'dni', 'nombre' => 'NIF / DNI'],
        ['tipo' => 'text', 'campo_db' => 'phone', 'nombre' => 'Teléfono'],
        ['tipo' => 'text', 'campo_db' => 'address_uno', 'nombre' => 'Dirección'],
        ['tipo' => 'text', 'campo_db' => 'address_dos', 'nombre' => 'Dirección (2ª línea)'],
        ['tipo' => 'number', 'campo_db' => 'irpf', 'nombre' => 'IRPF'],
        ['tipo' => 'number', 'campo_db' => 'iva', 'nombre' => 'IVA'],
        ['tipo' => 'text', 'campo_db' => 'banco_name', 'nombre' => 'Nombre del banco'],
        ['tipo' => 'text', 'campo_db' => 'banco_cuenta', 'nombre' => 'Nº de cuenta'],
      ];

      $data['user'] = $user;
      $data['clients'] = $user->clients;
      // $data['tipo_gastos'] = Tipo_gasto::get();

      return view('user', $data);
    }

    public function editaUserField(Request $request) {

      $campo = $request->campo ?? '';
      $valor = $request->valor ?? '';
      $user = Auth::user();

      if ($campo) {

        $user->$campo = $valor;
        $user->save();

        $res['msj'] = 'Guardado!';
        $status = 200;

      } else { $status = 406; $res['error'] = 'Falta el campo'; }

      return response()->json($res, $status);

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

    public function borraGasto(Request $request) {

      $id = (isset($request->id) && $request->id) ? $request->id : 0;

      if ($id) {
        if ($gasto = Gasto::find($id)) {
          $gasto->delete();
          $res['status'] = 200;
          $res['msj'] = 'Borrado con éxito!';
        } else {
          $res['status'] = 400;
          $res['msj'] = 'Gasto no encontrado';
        }
      } else {
        $res['status'] = 406;
        $res['msj'] = 'Faltan datos!';
      }
      return response()->json($res, $res['status']);
    }

    public function borraFactura(Request $request) {

      $id = (isset($request->id) && $request->id) ? $request->id : 0;

      if ($id) {
        if ($factura = Factura::find($id)) {
          $factura->delete();
          $res['status'] = 200;
          $res['msj'] = 'Borrado con éxito!';
        } else {
          $res['status'] = 400;
          $res['msj'] = 'Factura no encontrada';
        }
      } else {
        $res['status'] = 406;
        $res['msj'] = 'Faltan datos!';
      }
      return response()->json($res, $res['status']);
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
          'msj' => 'Ok',
          // 'pdf' => $this->generaPdf($request)
        ]);
      }
    }

    public function pagadaFactura(Request $request) {

      $user = Auth::user();
      $id = $request->id ?? 0;

      if ($id) {
        if ($user->facturas->contains($id)) {
          if ($factura = Factura::find($id)) {

            if ($factura->pagada) {
              $factura->pagada = 0;
              $res['pagada'] = 0;
            }
            else {
              $factura->pagada = 1;
              $res['pagada'] = 1;
            }

            $factura->save();

            $status = 200;
            $res['msj'] = 'Estado de factura modificado correctamente';

          } else { $status = 406; $res['error'] = 'Factura no encontrada'; }
        } else { $status = 406; $res['error'] = 'Esta factura no es tuya'; }
      } else { $status = 406; $res['error'] = 'Falta id de factura'; }

      return response()->json($res, $status);
    }

    public function generaPdf(Request $request) {

      $user = Auth::user();

      $iva = $user->iva;
      $ret_irpf = $user->irpf;

      if (isset($request->id)) {

      	$concepto = $request->concepto;

      	if (!$concepto) { $concepto = 'Desarrollo web'; }

        $cliente = Client::find($request->cliente);

      	$ultimo_char_nif = substr($cliente->nif, -1);

      	// Si no es numeric es una persona física (asique no le retenemos irpf)
      	if (!is_numeric($ultimo_char_nif)) { $ret_irpf = 0; }

      	$precio = $request->precio;

      	// Si le ponemos las horas cobramos por hora
      	if ($request->horas) {
      		$horas = $request->horas;
      		$base_unit = round($precio, 2); // Lo que vale la hora
      		$importe = $horas * $base_unit;
      		$cabecera_tabla = ["Concepto & Descripción", "Cant.", "Precio", "Importe"];
      	}

      	// Sino tiene horas es una cantidad fija
      	else {
      		$importe = $precio;
      		$horas = '';
      		$base_unit = '';
      		$cabecera_tabla = ["Concepto & Descripción", "", "", "Importe"];
      	}


      	$base_imponible = $importe;
      	$importe_iva = round(($base_imponible*$iva)/100, 2);
      	$importe_irpf = round(($base_imponible*$ret_irpf)/100, 2);
      	$importe_total = $base_imponible + $importe_iva - $importe_irpf;

      	$ftemp = explode('-', $request->fecha);
      	$fecha = $ftemp[2] . "/" . $ftemp[1] . "/" . $ftemp[0];
      	$any = $ftemp[0];
      	$any_sm = substr($ftemp[0], -2);


      	// Rellenado de ceros hacia la izquierda
      	$id = str_pad($request->id,  3, "0", STR_PAD_LEFT);
      	$id_factura = $id . '/' . $any_sm;


      	$id_nombre_factura = $id . '-' . $any_sm;
      	$nombre_pdf = 'fac_' . $id_nombre_factura . '.pdf';
      }

      // set document information
      PDF::SetCreator('Cuentónomo');
      PDF::SetAuthor($user->name);
      PDF::SetTitle('Factura ' . $user->name);
      PDF::SetSubject('Factura' . $any);

      // remove default header/footer
      PDF::setPrintHeader(false);
      PDF::setPrintFooter(false);

      PDF::SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
      PDF::SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
      PDF::SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
      PDF::setImageScale(PDF_IMAGE_SCALE_RATIO);

      // set some language-dependent strings (optional)
      if (@file_exists(dirname(__FILE__).'/lang/spa.php')) {
      	require_once(dirname(__FILE__).'/lang/spa.php');
      	PDF::setLanguageArray($l);
      }

      // ---------------------------------------------------------

      // set font
      PDF::SetFont('times', 'B', 20);
      // PDF::SetFont('helvetica', 'BI', 20);

      PDF::setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(230,230,230), 'opacity'=>1, 'blend_mode'=>'Normal'));
      PDF::SetFillColor(220, 255, 220);

      // add a page
      PDF::AddPage();

      // http://www.radmin.com/tcpdf_old/doc/com-tecnick-tcpdf/TCPDF.html#methodCell
      // Cell (width, height, $txt, $border [L, T, R, B], $ln [0, 1, 2], $align [L, C, R, J], $fill, $link, $stretch)

      // Título
      PDF::SetFont('times', 'B', 19);
      PDF::Cell(90, 0, $user->name, 0, 0, 'L', 0, '', 1);

      PDF::SetFont('times', 'BI', 19);
      PDF::Cell(90, 0, 'Fac. ' . $id_factura, 0, 1, 'R', 0, '', 1);

      PDF::Cell(0, 0, '', 'T', 1); // Linea separadora
      // PDF::Cell(0, 0, '', '', 1);

      // Mis datos
      PDF::SetFont('times', 'I', 15);

      PDF::Cell(0, 0, 'NIF: ' . $user->dni, 0, 1, 'L', 0, '', 1);

      PDF::Cell(90, 0, $user->address_uno, 0, 0, 'L', 0, '', 1);
      PDF::Cell(90, 0, $user->phone, 0, 1, 'R', 0, '', 1);

      PDF::Cell(90, 0, $user->address_dos, 0, 0, 'L', 0, '', 1);

      if (isset($user->email_public) && $user->email_public) {
        PDF::Cell(90, 0, $user->email_public, 0, 1, 'R', 0, '', 1);
      } else {
        PDF::Cell(90, 0, $user->email, 0, 1, 'R', 0, '', 1);
      }

      PDF::Ln();

      // Facturar a:
      PDF::SetFont('times', 'B', 15);
      PDF::Cell(90, 12, 'Facturar a:', 0, 0, 'L', 0, '', 1);
      PDF::Cell(90, 12, 'Fecha ' . $fecha, 0, 1, 'R', 0, '', 1);

      // Datos cliente aqui
      PDF::SetFont('times', 'I', 15);
      PDF::Cell(90, 0, 'NIF: ' . $cliente->nif, 0, 1, 'L', 0, '', 1);
      // PDF::Cell(90, 0, 'Pagadero a la recepción', 0, 1, 'R', 0, '', 1);

      PDF::Cell(90, 0, $cliente->name, 0, 1, 'L', 0, '', 1);
      // PDF::Cell(90, 0, 'Vencimiento ' . $fecha, 0, 1, 'R', 0, '', 1);


      PDF::Cell(90, 0, $cliente->address, 0, 1, 'L', 0, '', 1);

      // if (isset($cliente[3]) && $cliente[3]) {
      // 	PDF::Cell(90, 0, $cliente[3], 0, 1, 'L', 0, '', 1);
      // }


      PDF::Ln(15);
      PDF::SetFont('helvetica', '', 15);

      // bgcolor="#cccccc" colspan="2" rowspan="2"
      // font-weight: bold;



      $html = '<style>
      th {
      	border-bottom: 1px solid #000;
      	font-size: 15px;
      	color: #B5B5B5;
      }
      </style>
      <table border="0" cellspacing="0" cellpadding="5">
      	<tr id="hola">
      		<th colspan="2">' . $cabecera_tabla[0] . '</th>
      		<th align="center">' . $cabecera_tabla[1] . '</th>
      		<th align="center">' . $cabecera_tabla[2] . '</th>
      		<th align="right">' . $cabecera_tabla[3] . '</th>
      	</tr>
      	<tr>
      		<td colspan="2" style="font-style: italic;">' . $concepto . '</td>
      		<td align="center">' . $horas . '</td>
      		<td align="center">' . $base_unit . '</td>
      		<td align="right">' . $importe . '</td>
      	</tr>
      	<tr><td colspan="5"></td></tr>
      	<tr>
      		<td colspan="2"></td>
      		<td colspan="2" align="right">Base imponible</td>
      		<td align="right">' . number_format(($base_imponible), 2) . '</td>
      	</tr>
      	<tr>
      	<td colspan="4" align="right">IVA ' . $iva . '%</td>
      	<td align="right">' . number_format(($importe_iva), 2) . '</td>
      	</tr>';

        if ($importe_irpf) {
          $html .= '<tr>
          <td colspan="4" align="right">IRPF ' . $ret_irpf . '%</td>
          <td align="right"> -' . number_format(($importe_irpf), 2) . '</td>
          </tr>';
        }

        $html .= '<tr>
      		<td colspan="4" align="right"><b>Total</b></td>
      		<td align="right"><b>' . number_format(($importe_total), 2) . ' €</b></td>
      	</tr>
      </table>';

      // output the HTML content
      PDF::writeHTML($html, true, false, true, false, '');


      PDF::SetFont('times', 'BI', 14);
      PDF::Cell(0, 0, 'Forma de pago', 0, 1, 'L', 0, '', 1);

      PDF::SetFont('times', 'I', 13);
      PDF::Cell(0, 0, 'Transferencia bancaria', 0, 1, 'L', 0, '', 1);

      PDF::Ln(5);

      // PDF::SetFont('times', 'BI', 14);
      // PDF::Cell(0, 0, 'Cuenta bancaria de pago', 0, 1, 'L', 0, '', 1);
      // PDF::Ln(2);

      PDF::SetFont('helvetica', 'B', 14);
      PDF::Cell(0, 0, $user->banco_name, 0, 1, 'L', 0, '', 1);

      PDF::Ln(1);

      PDF::SetFont('helvetica', '', 13);
      PDF::Cell(0, 0, 'IBAN ' . $user->banco_cuenta, 0, 1, 'L', 0, '', 1);

      //Close and output PDF document
      PDF::Output($nombre_pdf, 'I');
    }

    public function horas() {

      $user = Auth::user();

      $horas_dia = 8;
      $dias = $horas_reales = $minutos_reales = 0;
      $jornadas = $user->jornadas()->where('client_id', 2)->get();

      // Para cada jornada, restamos la hora de salida a la de entrada y tenemos las horas trabajadasese dia
      foreach ($jornadas as $j) {

        if ($j->salida && $j->entrada) {

          $entrada = new \DateTime($j->entrada);
          $salida = new \DateTime($j->salida);

          $resta = $entrada->diff($salida);
          $horas = $resta->format('%h');
          $minutos = $resta->format('%i');

          // Guardamos las horas trabajadas en un contador
          $horas_reales += $horas;
          $minutos_reales += $minutos;

          if ($minutos_reales >= 60) {
            $minutos_reales = $minutos_reales - 60;
            $horas_reales++;
          }

          // Contamos los dias trabajados
          $dias++;
        }
      }

      // Calculamos las horas que 'deberiamos' haber hecho
      $horas_totales = $dias * $horas_dia;

      $data['balance']['horas'] = $horas_reales - $horas_totales;
      $data['balance']['minutos'] = $minutos_reales;
      $data['horas_dia'] = $horas_dia;

      $data['ult_jornadas'] = $user->jornadas()->where('client_id', 2)->orderBy('fecha', 'desc')->take(30)->get();

      return view('jornadas', $data);
    }

    public function guardaJornada(Request $request) {

      $user = Auth::user();
      $hora = isset($request->hora) ? $request->hora : 0;
      $fecha = isset($request->fecha) ? $request->fecha : date('Y-m-d');
      $client = isset($request->client) ? $request->client : 2;
      $entrada = isset($request->entrada) ? $request->entrada : 0;

      if ($hora && $fecha) {

        // $fila = Jornada::where('user_id', $user->id)->where('client_id', $client)->where('fecha', $fecha)->first();
        $fila = $user->jornadas()->where('client_id', $client)->where('fecha', $fecha)->first();

        if (!$fila) {
          $fila = new Jornada();
          $fila->user_id = $user->id;
          $fila->fecha = $fecha;
          $fila->client_id = $client;
        }

        if ($entrada) { $fila->entrada = $hora . ":00"; }
        else { $fila->salida = $hora . ":00"; }

        $fila->save();
      }

      $res['msj'] = 'exito';

      return response()->json($res, 200);
    }

    public function nuevoCliente(Request $request) {

      $nif = $request->nif ?? '';
      $name = $request->name ?? '';
      $address = $request->address ?? '';
      $persona_fisica = isset($request->persona_fisica) ? 1 : 0;

      if (!$nif || !$name || !$address) {
        return response()->json([
            'res' => 400,
            'msj' => 'Faltan datos!'
        ]);
      } else {

        $client = new Client();
          $client->nif = $nif;
          $client->user_id = Auth::id();
          $client->name = $name;
          $client->address = $address;
          $client->persona_fisica = $persona_fisica;
        $client->save();

        return back();
      }
    }
}
