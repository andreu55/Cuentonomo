@extends('layouts.app')

@section('content')

<div id="block_final" style="display:none">
  <div class="jumbotron jumbotron-fluid">
    <div class="container">
      <div class="col">
        <h1 class="display-3">Todo guardado!</h1>
        <p class="lead">Enhorabuena! molas mogollón y aqui un Lorem ipsum dolor sit amet, a deserunt mollit anim id est laborum para rellenar</p>
        <hr class="my-4">
        <p>
          <p>¿Quieres introducir otro pago?</p>
          <button class="btn btn-primary btn-lg btn-block" id="refresh" role="button">
            <i class="fa fa-fw fa-plus" aria-hidden="true"></i>
            Oh yeah!
          </button>
        </p>
        <p>
          <p>Ir a todos los pagos</p>
          <a href="{{ url('home') }}" class="btn btn-warning btn-lg btn-block">
            <i class="fa fa-fw fa-list" aria-hidden="true"></i>
            Gestionar
          </a>
        </p>
      </div>
    </div>
  </div>
</div>
<div id="block_inicial" class="container">
  <div class="row">
    <div class="col-12">
      {{-- <h2 class="mt-3 mb-4">
        <span class="fw-200" style="vertical-align:middle">
          Hola, {{ Auth::user()->name }}
        </span>
      </h2>
      <a href="{{ url('home') }}" class="btn btn-lg btn-warning pull-right">
        <i class="fa fa-list" aria-hidden="true"></i>
      </a> --}}

      <ul class="nav nav-pills nav-fill mb-3" id="pills-tab" role="tablist">
        <li class="nav-item">
          <a class="nav-link active" id="pills-gasto-tab" data-toggle="pill" href="#pills-gasto" role="tab" aria-controls="pills-gasto" aria-selected="true">Gasto</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="pills-ingreso-tab" data-toggle="pill" href="#pills-ingreso" role="tab" aria-controls="pills-ingreso" aria-selected="false">Ingreso</a>
        </li>
      </ul>
      <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="pills-gasto" role="tabpanel" aria-labelledby="pills-gasto-tab">

          <div class="form-group">
            <label for="cantidad">Cantidad</label>
            <div class="input-group">
              <input type="number" class="form-control" id="cantidad" step='0.01' value="2.50" required>
              <div class="input-group-append">
                <span class="input-group-text"><b>€</b></span>
              </div>
            </div>
          </div>

          <div class="form-group">
            <div class="row">
              <div class="col">
                <label for="tipo">Tipo <small><em><span id="iva">0.10</span> % desgr.</em></small></label>
                <select class="form-control" id="tipo">
                  @foreach ($tipo_gastos as $tipog)
                    <option value="{{ $tipog->id }}" data-iva="{{ number_format($tipog->iva, 2) }}">{{ $tipog->name }}</option>
                  @endforeach
                </select>
              </div>
              <div class="col">
                <label for="fecha">Fecha</label>
                <input type="date" class="form-control" id="fecha" value="<?= date('Y-m-d') ?>" required>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label for="concepto">Concepto</label>
            <input type="text" class="form-control" id="concepto" value="Cafetería" required>
          </div>
          <button id="guarda-gasto" class="btn btn-epic btn-block mb-3 mt-4">Guardar</button>

          <div id="alert_block">

          </div>

        </div>

        {{-- INGRESO / CREACION DE FACTURAS --}}
        <div class="tab-pane fade" id="pills-ingreso" role="tabpanel" aria-labelledby="pills-ingreso-tab">


          <form action="{{ url('pdf/nuevo') }}" method="post">
            {{ csrf_field() }}
            <div class="row">
              <div class="col-12 col-sm-9">
                <div class="form-group row">
                  <label for="id" class="col-2 col-form-label">ID factura</label>
                  <div class="col-10">
                    <input class="form-control" type="text" value="1" name="id">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="horas" class="col-2 col-form-label">
                    Horas
                    <i class="fa fa-fw fa-question-circle text-muted" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="Dejar a 0 para consierar el precio como valor final"></i>
                  </label>
                  <div class="col-10">
                    <input class="form-control" type="number" step="0.01" value="100" name="horas">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="horas" class="col-2 col-form-label">Precio</label>
                  <div class="col-10">
                    <input class="form-control" type="number" step="0.01" value="15" name="precio">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="fecha" class="col-2 col-form-label">Fecha</label>
                  <div class="col-10">
                    <input class="form-control" type="date" value="<?=date('Y-m-d')?>" name="fecha">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="id" class="col-2 col-form-label">Concepto</label>
                  <div class="col-10">
                    <input class="form-control" type="text" value="Desarrollo aplicaciones y mantenimiento web" name="concepto">
                  </div>
                </div>
              </div>
              <div class="col-12 col-sm-3">

                @foreach ($clients as $client)
                  <div class="form-check">
                    <label class="form-check-label">
                      <input class="form-check-input" type="radio" name="cliente" value="{{ $client->id }}" {{ $client->id == 2 ? 'checked' : '' }}> {{ $client->name }}
                    </label>
                  </div>
                @endforeach

                <button type="submit" class="btn btn-sm mt-3 btn-block btn-secondary" title="Genera pdf" target="_blank">Genera PDF</button>
              </div>
            </div>
          </form>

          <button id="guarda-factura" class="btn btn-epic btn-block mb-3 mt-4">Guardar</button>

        </div>
      </div>
    </div>
  </div>
</div>

@endsection

@section('scripts')

  <script>

  $("#guarda-gasto").click(function(){

    $(this).html('<i class="fa fa-refresh fa-spin fa-fw"></i>');

    $.post("{{ url('gasto/nuevo') }}",
    {
      _token: "{{ csrf_token() }}",
      cantidad: $('#cantidad').val(),
      tipo: $('#tipo').val(),
      fecha: $('#fecha').val(),
      concepto: $('#concepto').val()
    },
    function(data, status){

      $("#guarda-gasto").html('Guardar');

      if (data.res == '200') {
        $('#block_inicial').slideUp();
        $('#block_final').slideDown();
      } else {
        $('#alert_block').html('<div class="alert alert-warning fade show" role="alert">' +
        '<strong>Holy guacamole!</strong> Server says: ' + data.msj +
        '</div>')
      }

    });
  });

  $("#guarda-factura").click(function(){

    $(this).html('<i class="fa fa-refresh fa-spin fa-fw"></i>');

    $.post("{{ url('factura/nuevo') }}",
    {
      _token: "{{ csrf_token() }}",
      id: $('input[name=id]').val(),
      cliente: $('input[name=cliente]:checked').val(),
      horas: $('input[name=horas]').val(),
      precio: $('input[name=precio]').val(),
      fecha: $('input[name=fecha]').val()
    },
    function(data, status){

      $("#guarda-factura").html('Guardar');

      if (data.res == '200') {
        $('#block_inicial').slideUp();
        $('#block_final').slideDown();
      } else {
        $('#alert_block').html('<div class="alert alert-warning fade show" role="alert">' +
        '<strong>Holy guacamole!</strong> Server says: ' + data.msj +
        '</div>')
      }

    });
  });

  $("#refresh").click(function(){

    $('#alert_block').html("");
    $('#cantidad').val("2.50");
    $('#concepto').val("Cafetería");

    $('#block_final').slideUp();
    $('#block_inicial').slideDown();
  });

  $("#tipo").change(function() {
    var iva = $("#tipo option:selected").data('iva');
    $("#iva").hide().html(iva).fadeIn();
  });


  </script>

@endsection
