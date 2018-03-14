@extends('layouts.app')

@section('css')
  {{-- <link rel="stylesheet" href="https://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css"> --}}
@endsection

@section('content')
  <div class="container">

    @if (session('status'))
      <div class="alert alert-success">
        {{ session('status') }}
      </div>
    @endif

    <div class="row">
      <div class="col-md-12 col-md-offset-2">

        <h2>
          <span class="d-none d-sm-inline">
            Facturas
          </span>
          <em class="pull-right">
            <a href="{{ url('home/'.$ant_trim.'/'.$ant_year) }}" class="btn my-2 my-sm-0">
              <i class="fa fa-2x fa-angle-double-left" aria-hidden="true"></i>
            </a>
            {{ $trimestre }}º Trimestre {{ $year }}
            <a href="{{ url('home/'.$sig_trim.'/'.$sig_year) }}" class="btn my-2 my-sm-0">
              <i class="fa fa-2x fa-angle-double-right" aria-hidden="true"></i>
            </a>
          </em>
        </h2>

      </div>
    </div>

    <div class="row d-none d-sm-block">
      <div class="col-md-12 col-md-offset-2">

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
              <th scope="col"></th>
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
                if ($f->horas != 0.00) {
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

              <tr id="factura{{ $f->id }}" class="table-<?= $f->pagada ? "success" : "danger" ?>">
                <th scope="row">{{ $f->num }}</th>
                <td>{{ $f->client->name }}</td>
                <td>{{ $f->created_at->format('d/m/Y') }}</td>
                <td><b>{{ $f->horas }}</b> <small><em>x {{ $f->precio }}</em></small></td>
                <td>{{ number_format($base, 2) }}</td>
                <td>{{ number_format($iva, 2) }}</td>
                <td>{{  $irpf  }}</td>
                <td>{{  $total  }}</td>
                <td><button class="btn btn-sm btn-danger pull-right borra-factura" data-id="{{ $f->id }}"><i class="fa fa-fw fa-times"></i></button></td>
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
              <td></td>
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
                <em class="text-muted lafecha fw-200">{{ $g->created_at->format('d/m/Y') }}</em>
                <button class="btn btn-sm btn-danger pull-right borra-gasto" data-id="<?=$g->id?>"><i class="fa fa-fw fa-times"></i></button>
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

        @if ($iva_total && $iva_total_gastos)
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Resumen IVA</h5>
              <h6 class="card-subtitle mb-2 text-muted">{{ $trimestre }}º trimestre</h6>
              <p class="card-text">Has recibido <b class="text-primary">{{ $iva_total }}€</b> en IVA este trimestre, puedes desgravarte <b class="text-success">{{ $iva_total_gastos }}€</b> gracias a los gastos, debes ingresar un total de:</p>
              <h4 class="card-text"><b class="text-warning">{{ $iva_total - $iva_total_gastos }}€</b></h4>
            </div>
          </div>
        @endif

      </div>
    </div>
  </div>
@endsection

@section('scripts')

  {{-- <script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script> --}}
  <script type="text/javascript">

    $(".borra-gasto").click(function() {

      $(this).html('<i class="fa fa-refresh fa-spin fa-fw"></i>');
      var id = $(this).data('id');

      $.post('{{ url('gasto/borrar') }}',
      {
        _token: "{{ csrf_token() }}",
        id: id
      },
      function(data, status){

        if (status == "success") {

          if (data.status == '200') {
            $('#gasto'+id).slideUp();
          }
        }
      });
    });

    $(".borra-factura").click(function() {

      if (confirm("¿Borrar seguro?")) {

        $(this).html('<i class="fa fa-refresh fa-spin fa-fw"></i>');
        var id = $(this).data('id');

        $.post('{{ url('factura/borrar') }}',
        {
          _token: "{{ csrf_token() }}",
          id: id
        },
        function(data, status){

          if (status == "success") {

            if (data.status == '200') {
              $('#factura'+id).hide();
              location.reload();
            }
          }
        });
      }

    });

  </script>

@endsection
