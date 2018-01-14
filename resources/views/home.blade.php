@extends('layouts.app')

@section('content')
  <div class="container">

    @if (session('status'))
      <div class="alert alert-success">
        {{ session('status') }}
      </div>
    @endif

    <div class="row">
      <div class="col-md-8 col-md-offset-2">

        <h2>Facturas</h2>

        @foreach ($facturas as $key => $f)

          {{ $f->client->name }}

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

            if ($f->pagada) {

              $fecha = $f->created_at->format('Y-m-d');

            } else {
              $base_total_pend += $base;
              $iva_total_pend += $iva;
              $irpf_total_pend += $irpf;
              $total_total_pend += $total;
            }

          @endphp

          {{-- style="width: 18rem;" --}}
          <div class="card mb-2">
            <div class="card-body">
              <h5 class="card-title">{{ $f->num }} <em class="text-muted lafecha fw-200">{{ $f->created_at->format('Y-m-d') }}</em></h5>
              <h6 class="card-subtitle mb-2 text-muted">{{ $f->client->name }}</h6>
              <p class="card-text">




                <b><?=$f->horas?> <small><em>x <?=$f->precio?></em></small></b> =
                <span class="text-danger"><?=number_format($base, 2)?></span>
                <i class="fa fa-fw fa-arrow-right"></i>
                <b class="text-success"><?=number_format($iva, 2)?></b>
                -<?= $irpf ?>
                <?= $total ?>
              </p>
              <a href="#" class="card-link">Ver detalles</a>
            </div>
          </div>
        @endforeach

      </div>
    </div>

    <div class="row">
      <div class="col-md-8 col-md-offset-2">
        <h2>Gastos</h2>
        @foreach ($gastos as $key => $g)

          @php
          // Sacamos la base sabiendo el iva y el total
          $base = round(($g->cantidad / (1 + $g->tipo_gasto->iva)), 2);
          // Con esa base, sacamos el iva del gasto
          $iva = round(($base * $g->tipo_gasto->iva), 2);

          $fecha = $g->created_at->format('Y-m-d');
          @endphp

          <div class="card mb-2" id="gasto<?=$g->id?>">
            <div class="card-body">
              <h4 class="card-title">
                <?=$g->concepto?>
                <em class="text-muted lafecha fw-200"><?=$fecha?></em>
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
