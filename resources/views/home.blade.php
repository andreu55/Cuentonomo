@extends('layouts.app')

@section('content')
  <div class="container">

    @if (session('status'))
      <div class="alert alert-success">
        {{ session('status') }}
      </div>
    @endif

    <div class="row">
      <div class="col-md-12 col-md-offset-2">

        <h2>Facturas <em class="pull-right">{{ $trimestre }}º Trimestre {{ $year }}</em></h2>

        <table class="table">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Cliente</th>
              <th scope="col">Fecha</th>
              <th scope="col">Horas</th>
              <th scope="col">Base</th>
              <th scope="col">IVA</th>
              <th scope="col">IRPF</th>
              <th scope="col">Importe</th>
            </tr>
          </thead>
          <tbody>

            @php
              $base_total = $iva_total = $irpf_total = $total_total = 0;
            @endphp

            @foreach ($facturas as $key => $f)

              @php

                // Si es persona física, no le retenemos IRPF
                if ($f->client->persona_fisica) { $ret_irpf = 0; }
                else { $ret_irpf = 7; }

                // Si hemos especificado horas, calculamos el importe
                if ($f->horas) {
                  $base = round($f->horas * $f->precio, 2);
                }
                // Sino, suponemos que lo que pone en precio es el precio final
                else {
                  $base = round($f->precio, 2);
                }

                $iva = round(($base * 0.21), 2);
                $irpf = round(($base*$ret_irpf)/100, 2);
                $total = round($iva + $base - $irpf, 2);

                $base_total += $base;
                $iva_total += $iva;
                $irpf_total += $irpf;
                $total_total += $total;

              @endphp

              <tr class="table-<?= $f->pagada ? "success" : "danger" ?>">
                <th scope="row">{{ $f->num }}</th>
                <td>{{ $f->client->name }}</td>
                <td>{{ $f->created_at->format('Y-m-d') }}</td>
                <td><b><?=$f->horas?></b> <small><em>x <?=$f->precio?></em></small></td>
                <td><?=number_format($base, 2)?></td>
                <td><?=number_format($iva, 2)?></td>
                <td><?= $irpf ?></td>
                <td><?= $total ?></td>
              </tr>
            @endforeach

            <tr>
              <th></th>
              <td></td>
              <td></td>
              <td></td>
              <td><b class="text-success">{{ $base_total }}</b></td>
              <td><b class="text-warning">{{ $iva_total }}</b></td>
              <td><b class="text-info">{{ $irpf_total }}</b></td>
              <td><b class="text-default">{{ $total_total }}</b></td>
            </tr>

          </tbody>
        </table>

      </div>
    </div>

    <div class="row">
      <div class="col-md-8 col-md-offset-2">
        <h2>Gastos</h2>

        @php
          $cantidad_total = $base_total_gastos = $iva_total_gastos = 0;
        @endphp

        @foreach ($gastos as $key => $g)

          @php
          // Sacamos la base sabiendo el iva y el total
          $base = round(($g->cantidad / (1 + $g->tipo_gasto->iva)), 2);
          // Con esa base, sacamos el iva del gasto
          $iva = round(($base * $g->tipo_gasto->iva), 2);

          $cantidad_total += $g->cantidad;
          $base_total_gastos += $base;
          $iva_total_gastos += $iva;

          @endphp

          <div class="card mb-2" id="gasto<?=$g->id?>">
            <div class="card-body">
              <h4 class="card-title">
                <?=$g->concepto?>
                <em class="text-muted lafecha fw-200">{{ $g->created_at->format('Y-m-d') }}</em>
                <button class="btn btn-danger pull-right borra-gasto" data-id="<?=$g->id?>"><i class="fa fa-fw fa-times"></i></button>
              </h4>
              <p class="card-text">
                <b><?=number_format($g->cantidad, 2)?>€</b> =
                <span class="text-danger"><?=number_format($base, 2)?></span>
                <i class="fa fa-fw fa-arrow-right"></i>
                <b class="text-success"><?=number_format($iva, 2)?></b>
                <small>(<?=number_format($g->tipo_gasto->iva, 2)?>%)</small>
              </p>
            </div>
          </div>
        @endforeach
      </div>

      <div class="col-md-4">
        <h2>Resumen IVA</h2>

        <ul class="list-group text-center">

          <?php if ($iva_total && $iva_total_gastos): ?>
            <li class="list-group-item justify-content-between">
              <b><?=$trimestre?>º trim:</b>
              <span class="text-danger">
                <?= $iva_total ?>€
              </span><b>-</b>
              <span class="text-success">
                <?= $iva_total_gastos ?>€
              </span><b>=</b>
              <span class="badge badge-warning badge-pill"><?= number_format(($iva_total - $iva_total_gastos), 2, ".", "") ?> €</span>
            </li>
          <?php endif; ?>

        </ul>

      </div>
    </div>
  </div>
@endsection

@section('scripts')

  <script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
  <script src="https://www.gstatic.com/charts/loader.js"></script>

  <script type="text/javascript">

  function drawChart() {

    // Create the data table.
    var data = new google.visualization.DataTable();
    data.addColumn('string', 'Topping');
    data.addColumn('number', 'Slices');
    // data.addRows([
    //   <?php// foreach ($suma_tipos_gasto as $tipo => $num): ?>
    //     ['<?//=$tipo?>', <?//=$num?>],
    //   <?php// endforeach; ?>
    // ]);

    // Set chart options
    var options = {title:'Total €/Tipo',
    pieSliceText:'value',
    width:430,
    height:300};

    // Instantiate and draw our chart, passing in some options.
    var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
    chart.draw(data, options);
  }

  function toggle_trimestre(i) {
    if (i != 1) { $('.trim_1').toggle(); }
    if (i != 2) { $('.trim_2').toggle(); }
    if (i != 3) { $('.trim_3').toggle(); }
    if (i != 4) { $('.trim_4').toggle(); }
  }

  $(document).ready(function() {

    // Inicializamos la datatable
    $('#tabla_facturas').DataTable({
      "order": [[ 0, "desc" ]]
    });

    toggle_trimestre(<?=$trimestre?>);

    // Cargamos los tooltips
    $('[data-toggle="tooltip"]').tooltip();


    // Load the Visualization API and the corechart package.
    google.charts.load('current', {'packages':['corechart']});

    // Set a callback to run when the Google Visualization API is loaded.
    google.charts.setOnLoadCallback(drawChart);

  });
  </script>

@endsection
