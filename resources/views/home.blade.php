@extends('layouts.app')

@section('title', 'Home')

@section('css')
  <style media="screen">
  .my-left, .my-right { transition: all 0.5s ease }
  /* .my-left { padding-right: 15px } */
  /* .my-left:hover { padding-right: 20px } */
  .my-right:hover { padding-left: 15px }
  .table td, .table th { border-top:0 }
  </style>
@endsection

@section('content')
  <div class="container">

    @if (session('status'))
      <div class="alert alert-success">
        {{ session('status') }}
      </div>
    @endif

    <div class="row d-none d-sm-block">
      <div class="col-md-12 col-md-offset-2">
        <h2>
          <span class="d-none d-sm-inline">
            Facturas
            <button onclick="window.location.href = '{{ url('new') }}'" class="btn btn-sm btn-subtle" type="button"><em class="fas fa-plus fa-fw"></em> Nueva</button>
          </span>
          <em class="float-right">
            <a href="{{ url('home/'.$ant_trim.'/'.$ant_year) }}" class="btn my-left">
              <i class="fas fa-angle-double-left fa-fw fa-2x" aria-hidden="true"></i>
            </a>
            {{ $trimestre }}º Trimestre {{ $year }}
            <a href="{{ url('home/'.$sig_trim.'/'.$sig_year) }}" class="btn my-right">
              <i class="fas fa-angle-double-right fa-fw fa-2x" aria-hidden="true"></i>
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
              if ($f->client->persona_fisica ?? false) { $ret_irpf = 0; }
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

              <tr id="factura{{ $f->id }}" class="tr-tabla table-<?= $f->pagada ? "success" : "danger" ?>">
                <th scope="row">{{ $f->num }}</th>
                <td>{{ $f->client->name ?? '- Cliente eliminado -' }}</td>
                <td>{{ $f->created_at->format('d/m/Y') }}</td>
                <td>{{ $f->horas }} <small><em>x {{ $f->precio }}</em></small></td>
                <td><b>{{ number_format($base, 2) }}</b></td>
                <td>{{ number_format($iva, 2) }}</td>
                <td>{{  $irpf  }}</td>
                <td>{{  $total  }}</td>
                <td class="float-right">
                  <button class="btn btn-sm btn-success pagada-factura mr-1" data-id="{{ $f->id }}"><i class="fas fa-<?= $f->pagada ? "undo" : "check" ?> fa-fw"></i></button>
                  <button class="btn btn-sm btn-danger borra-factura" data-id="{{ $f->id }}"><i class="far fa-trash-alt fa-fw"></i></button>
                </td>
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

        <div class="card mb-4">
          <div class="card-block">
            <h3 class="card-title">Gastos</h3>

            <div class="dropdown card-title-btn-container">
              <button onclick="window.location.href = '{{ url('new') }}'" class="btn btn-sm btn-subtle" type="button"><em class="fas fa-plus fa-fw"></em> Añadir nuevo</button>

              <div class="d-none d-sm-inline">
                <button class="btn btn-sm btn-subtle dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <em class="fas fa-cog"></em>
                </button>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                  <a class="dropdown-item" href="#"><i class="fas fa-exclamation-circle fa-fw"></i> Esto no hase na</a>
                  <a class="dropdown-item" href="#"><i class="fas fa-star fa-fw"></i> pero oye,</a>
                  <a class="dropdown-item" href="#"><i class="far fa-thumbs-up fa-fw"></i> queda de categoría</a>
                </div>
              </div>
            </div>

            <h6 class="card-subtitle mb-2 text-muted">Más recientes primero</h6>

            <div class="divider" style="margin-top: 1rem;"></div>

            <div class="articles-container">

              @php
              $cantidad_total = $base_total_gastos = $iva_total_gastos = 0;
              @endphp

              @foreach ($gastos as $key => $g)

                @php
                // Sacamos la base sabiendo el iva y el total
                $base = round(($g->cantidad / (1 + $g->tipo_gasto->iva)), 2);

                $cantidad_total += $g->cantidad;
                $base_total_gastos += $base;
                $iva_total_gastos += round(($base * $g->tipo_gasto->iva), 2); // Con esa base, sacamos el iva del gasto
                @endphp

                <div class="article" id="gasto<?=$g->id?>">
                  <div class="col-xs-12">
                    <div class="row">
                      <div class="col-2 date">
                        <div class="large">{{ $g->created_at->format('d') }}</div>
                        <div class="text-muted">{{ $g->created_at->format('M') }}</div>
                      </div>
                      <div class="col-10">
                        <h4>
                          <?=$g->concepto?>
                          <i class="far fa-trash-alt fa-fw text-danger float-right borra-gasto pointer" data-id="<?=$g->id?>"></i>
                        </h4>
                        <p>
                          {!! formatGasto($g->cantidad, $g->tipo_gasto->iva) !!}
                        </p>
                      </div>
                    </div>
                  </div>
                  <div class="clear"></div>
                </div>

              @endforeach

            </div>
          </div>
        </div>
      </div>

      <div class="col-md-4">

        @if ($iva_total && $iva_total_gastos)
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Resumen IVA</h5>
              <h6 class="card-subtitle mb-2 text-muted">{{ $trimestre }}º trimestre</h6>
              <p class="card-text">Has recibido <b class="text-warning">{{ $iva_total }}€</b> en IVA este trimestre, puedes desgravarte <b class="text-success">{{ $iva_total_gastos }}€</b> gracias a los gastos, debes ingresar un total de:</p>
              <h4 class="card-text"><b class="text-primary">{{ $iva_total - $iva_total_gastos }}€</b></h4>
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

    $(this).html('<i class="fas fa-sync-alt fa-spin fa-fw"></i>');
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

      $(this).html('<i class="fas fa-sync-alt fa-spin fa-fw"></i>');
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

  $(".pagada-factura").click(function() {

    // if (confirm("¿Modificar estado?")) {

    var btn = $(this);
    var id = $(this).data('id');

    btn.html('<i class="fas fa-sync-alt fa-fw fa-spin"></i>');

    $.post('{{ url('factura/pagada') }}',
    {
      _token: "{{ csrf_token() }}",
      id: id
    },
    function(data, status) {


      if (status == "success") {

        if (data.pagada) {
          btn.html('<i class="fa fa-fw fa-undo"></i>');
          $('#factura' + id).removeClass('table-danger').addClass('table-success');
        } else {
          btn.html('<i class="fa fa-fw fa-check"></i>');
          $('#factura' + id).removeClass('table-success').addClass('table-danger');
        }
      }
    });
    // }

  });

  </script>

@endsection
