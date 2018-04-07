@extends('layouts.app')

@section('title', 'Home')

@section('invitado')
  @if (isset($invitado))
    <div class="text-muted">
      Acceso <b>concedido hasta</b> {{ $restante }} <i class="fas fa-exclamation-triangle text-danger fa-fw"></i>
    </div>
  @else
    {{-- Despublicar --}}
    <div id="despublicar-group" class="input-group" style="<?= $user->access_token ? '' : 'display:none' ?>">
      <input id="publicar_url" type="text" onclick="$(this).select();" class="form-control" value="{{ url('home/' . $trimestre . '/' . $year . '/' . $user->id . '/' . $user->access_token) }}">
      <div class="input-group-append">
        <button id="despublicar" class="btn btn-outline-secondary" type="button">Despublicar</button>
      </div>
    </div>
    {{-- Publicar --}}
    <div id="publicar-group" class="input-group" style="<?= $user->access_token ? 'display:none' : '' ?>">
      <div class="input-group-prepend">
        <span class="input-group-text" style="background-color:#fff;border-color:#7c7c7c">Núm. días</span>
      </div>
      <input id="publicar_dias" type="text" onclick="$(this).select();" class="form-control" value="1">
      <div class="input-group-append" title="Crear una url publica para compartir durante un tiempo">
        <button id="publicar" class="btn btn-outline-secondary" type="button">Publicar</button>
      </div>
    </div>
  @endif
@endsection

@section('css')
  <style media="screen">
  .ease { transition: all 0.5s ease }
  /* .ease { padding-right: 15px } */
  /* .ease:hover { padding-right: 20px } */
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
            @if (!isset($invitado))
              <button onclick="window.location.href = '{{ url('new') }}'" class="btn btn-sm btn-subtle" type="button">
                <i class="fas fa-plus fa-fw"></i> Nueva
              </button>
            @endif
          </span>
          <em class="float-right">

            @php
              $url_aux_ant = 'home/'.$ant_trim.'/'.$ant_year;
              $url_aux_sig = 'home/'.$sig_trim.'/'.$sig_year;

              if (isset($invitado)) {
                $url_aux_ant .= '/'.$user_id_invitado.'/'.$access_token;
                $url_aux_sig .= '/'.$user_id_invitado.'/'.$access_token;
              }
            @endphp

            <a href="{{ url($url_aux_ant) }}" class="btn">
              <i class="fas fa-angle-double-left fa-fw fa-2x" aria-hidden="true"></i>
            </a>
            {{ $trimestre }}º Trimestre {{ $year }}
            <a href="{{ url($url_aux_sig) }}" class="btn ease my-right">
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
                <td>{{ $irpf }}</td>
                <td>{{ $total }}</td>
                <td class="float-right">
                  @if ($f->url_temp)
                    <a href="{{ url('public/facturas/' . $user->id . '/' . $f->url_temp) }}" target="_blank" class="text-info mr-1">
                      <i class="fas fa-download"></i>
                    </a>
                  @endif
                  @if (!isset($invitado))
                    <button class="btn btn-sm btn-success pagada-factura" data-id="{{ $f->id }}">
                      <i class="fas fa-<?= $f->pagada ? "undo" : "check" ?>"></i>
                    </button>
                    <button class="btn btn-sm btn-danger borra-factura" data-id="{{ $f->id }}">
                      <i class="far fa-trash-alt"></i>
                    </button>
                  @endif
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

      <div class="col-md-7 col-md-offset-2">

        <div class="card mb-4">
          <div class="card-block">
            <h3 id="title_gastos" class="card-title">Total gastos</h3>

            <div class="dropdown card-title-btn-container">
              @if (!isset($invitado))
                <button onclick="window.location.href = '{{ url('new') }}'" class="btn btn-sm btn-subtle" type="button">
                  <i class="fas fa-plus fa-fw"></i> Nuevo
                </button>
              @endif

              {{-- <div class="d-none d-sm-inline"> --}}
                <button class="btn btn-sm btn-subtle dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <em class="fas fa-filter"></em>
                </button>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                  @foreach ($tipo_gastos as $tipo_gasto)
                    <li class="dropdown-item pointer" onclick="filtra_gasto({{ $tipo_gasto->id }})">
                      <i class="{{ $tipo_gasto->icon }} fa-fw"></i> &nbsp;{{ $tipo_gasto->name }}
                    </li>
                  @endforeach
                  <li id="reset_filtro_gastos" class="dropdown-item pointer" onclick="filtra_gasto(0)" style="display:none">
                    <i class="fas fa-undo-alt fa-fw"></i> &nbsp;Total gastos
                  </li>
                </div>
              {{-- </div> --}}
            </div>

            <h6 class="card-subtitle mb-2 text-muted">Recientes primero</h6>

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
                $iva_total_gastos += round(($base * $g->tipo_gasto->iva * $g->tipo_gasto->percent), 2); // Con esa base, sacamos el iva del gasto
                @endphp

                <div class="article tipo_gasto-{{ $g->tipo_gasto_id }}" id="gasto<?=$g->id?>">
                  <div class="col-xs-12">
                    <div class="row">
                      <div class="col-2 date">
                        <div class="large">{{ $g->created_at->format('d') }}</div>
                        <div class="text-muted">{{ $g->created_at->format('M') }}</div>
                      </div>
                      <div class="col-10">
                        <h4 class="borra-gasto pointer" data-id="<?=$g->id?>">
                          <?=$g->concepto?>
                          @if (!isset($invitado))
                            <i class="far fa-sm fa-trash-alt fa-fw text-danger float-right"></i>
                          @endif
                        </h4>
                        <p>
                          {!! formatGasto($g->cantidad, $g->tipo_gasto) !!}
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

      <div class="col-md-5">

        @if ($iva_total && $iva_total_gastos)
          <div class="card mb-2">
            <div class="card-body">
              <h5 class="card-title">
                Resumen IVA
                <small class="float-right">
                  <b>{{ $trimestre }}º</b> trimestre
                </small>
              </h5>
              {{-- <h6 class="card-subtitle mb-2 text-muted"><b>{{ $trimestre }}</b>º trimestre</h6> --}}
              <p class="card-text">Has recibido <b class="text-warning">{{ $iva_total }}€</b> en IVA este trimestre, puedes desgravarte <b class="text-success">{{ $iva_total_gastos }}€</b> gracias a los gastos, debes ingresar un total de:</p>
              <h4 class="card-text mb-0 text-primary float-right">
                {{ $iva_total - $iva_total_gastos }}€
              </h4>
              {{-- <p class="card-text">
                <em>
                  Este total es diferente de los totales por tipo porque aquí hemos sumado los gastos ya redondeados.
                </em>
              </p> --}}
            </div>
          </div>
        @endif

        @foreach ($tipo_gastos as $tipo_gasto)

          @php
            $base = ($tipo_gasto->total / (1 + $tipo_gasto->iva)); // Sacamos la base sabiendo el iva y el total
            $tipo_gasto_percent_total = ($base * $tipo_gasto->iva) * $tipo_gasto->percent;
          @endphp

          @if ($tipo_gasto->total)
            <div class="card mb-2">
              <div class="card-body">
                <h5 class="card-title">
                  {{ $tipo_gasto->name }}
                  <small class="float-right">
                    <b>{{ $trimestre }}º</b> Tr.
                  </small>
                </h5>
                <h6 class="card-subtitle mt-1 mb-1 text-muted">

                  {{-- <span class="text-danger">{{ $tipo_gasto->total }}€</span>
                  <span class="text-primary"> * {{ $tipo_gasto->iva }}%</span>
                  @if ($tipo_gasto->percent != 1)
                    <span class="text-primary"> * {{ $tipo_gasto->percent }}%</span>
                  @endif
                  = <span class="text-success"> {{ $tipo_gasto_percent_total }}</span>
                  <br> --}}

                  {!! formatGasto($tipo_gasto->total, $tipo_gasto) !!}
                </h6>
                <b class="text-primary mb-0 float-right">
                  {{ number_format($tipo_gasto_percent_total, 2) }}€
                </b>
              </div>
            </div>
          @endif
        @endforeach

      </div>
    </div>
  </div>
@endsection

@section('scripts')

  {{-- <script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script> --}}
  <script type="text/javascript">

  function filtra_gasto(tipo_id) {

    if (tipo_id) {
      @foreach ($tipo_gastos as $tipo_gasto)
        $('.tipo_gasto-'+{{ $tipo_gasto->id }}).hide();

        if (tipo_id == {{ $tipo_gasto->id }}) {
          $('#title_gastos').hide().text('{{ $tipo_gasto->name }}').fadeIn();
        }
      @endforeach

      $('.tipo_gasto-'+tipo_id).show();
      $('#reset_filtro_gastos').show();

    } else {

      @foreach ($tipo_gastos as $tipo_gasto)
        $('.tipo_gasto-'+{{ $tipo_gasto->id }}).show();
      @endforeach

      $('#title_gastos').hide().text('Total gastos').fadeIn();
      $('#reset_filtro_gastos').hide();
    }

  }

  $(".borra-gasto").click(function() {

    swal({
      title: "¿Borrar gasto?",
      icon: "warning",
      dangerMode: true,
      buttons: true
    })
    .then((okey) => {
      if (okey) {
        $(this).html('<i class="fas fa-sync-alt fa-spin fa-fw"></i>');
        var id = $(this).data('id');

        $.post('{{ url('gasto/borrar') }}',
        {
          _token: "{{ csrf_token() }}",
          id: id
        },
        function(data, status) {

          if (status == "success") {

            if (data.status == '200') {
              $('#gasto'+id).slideUp();
            }
          }
        });
      }
    });
  });

  $(".borra-factura").click(function() {

    swal({
      title: "¿Borrar esta factura?",
      icon: "warning",
      dangerMode: true,
      buttons: true
    })
    .then((okey) => {
      if (okey) {
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

  $("#publicar").click(function() {

    var btn = $(this);
    var html_original = $(this).html();
    btn.html('<i class="fas fa-sync-alt fa-fw fa-spin"></i>');

    $.post('{{ url('publicar') }}',
    {
      _token: "{{ csrf_token() }}",
      dias: $('#publicar_dias').val()
    },
    function(data, status) {
      if (status == "success") {
        if (data.token) {
          btn.html('<i class="fa fa-fw fa-check"></i>');

          url = '{{ url('home/' . $trimestre . '/' . $year . '/' . $user->id) }}' + '/' + data.token;

          $('#publicar_url').val(url);
          $('#despublicar-group').slideDown();
          $('#publicar-group').slideUp("fast", function() {
            btn.html(html_original);
          });
        }
        // location.reload();
      }
    });
  });

  $("#despublicar").click(function() {

    var btn = $(this);
    var html_original = $(this).html();
    btn.html('<i class="fas fa-sync-alt fa-fw fa-spin"></i>');

    $.post('{{ url('publicar/borrar') }}',
    {
      _token: "{{ csrf_token() }}"
    },
    function(data, status) {
      if (status == "success") {
        btn.html('<i class="fa fa-fw fa-check"></i>');
        $('#publicar-group').slideDown();
        $('#despublicar-group').slideUp("fast", function() {
          btn.html(html_original);
        });
      }
    });
  });

  </script>

@endsection
