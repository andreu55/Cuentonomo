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
              <input type="number" class="form-control" id="cantidad" step='0.01' value="2" required>
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
            <input type="text" class="form-control" id="concepto" value="Cafetería" onclick="select()" required>
          </div>
          <button id="guarda-gasto" class="btn btn-epic btn-block mb-3 mt-4">Guardar</button>

          <div id="alert_block">

          </div>

        </div>

        {{-- INGRESO / CREACION DE FACTURAS --}}
        <div class="tab-pane fade" id="pills-ingreso" role="tabpanel" aria-labelledby="pills-ingreso-tab">

          <form action="{{ url('pdf/nuevo') }}" method="post" target="_blank">
            {{ csrf_field() }}
            <div class="row">
              <div class="col-12 col-sm-9">
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label text-right d-none d-sm-block">
                    <b>Nº factura</b>
                  </label>
                  <div class="col-sm-10">
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-fw fa-info" aria-hidden="true"></i></span>
                      </div>
                      <input class="form-control" type="text" value="1" name="id">
                    </div>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label text-right d-none d-sm-block">
                    <i class="fa fa-fw fa-question-circle text-muted" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Dejar a 0 para consierar el precio como valor final"></i>
                    <b>Horas</b>
                  </label>
                  <div class="col-sm-10">
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-fw fa-clock-o" aria-hidden="true"></i></span>
                      </div>
                      <input class="form-control" type="number" step="0.01" value="100" name="horas">
                    </div>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label text-right d-none d-sm-block">
                    <b>Precio</b>
                  </label>
                  <div class="col-sm-10">
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-fw fa-usd" aria-hidden="true"></i></span>
                      </div>
                    <input class="form-control" type="number" step="0.01" value="15" name="precio">
                    </div>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label text-right d-none d-sm-block">
                    <b>Fecha</b>
                  </label>
                  <div class="col-sm-10">
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-fw fa-calendar-o" aria-hidden="true"></i></span>
                      </div>
                    <input class="form-control" type="date" value="<?=date('Y-m-d')?>" name="fecha">
                    </div>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label text-right d-none d-sm-block">
                    <b>Concepto</b>
                  </label>
                  <div class="col-sm-10">
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-fw fa-quote-right" aria-hidden="true"></i></span>
                      </div>
                    <input class="form-control" type="text" value="Desarrollo aplicaciones y mantenimiento web" name="concepto">
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-12 col-sm-3">
                <h5 for="select-cliente">
                  <i class="fa fa-fw fa-user" aria-hidden="true"></i>
                  Cliente
                  <span class="pull-right">
                    <a href="#" class="btn btn-sm btn-outline-warning" title="Nuevo cliente" data-toggle="modal" data-target="#nuevoCliente"><i class="fa fa-plus"></i></a>
                  </span>
                </h5>

                <select class="custom-select mt-2" id="select-cliente" name="cliente">
                  @foreach ($clients as $client)
                    <option value="{{ $client->id }}" {{ $client->id == 2 ? 'selected' : '' }}>{{ $client->name }}</option>
                  @endforeach
                </select>

                {{-- @foreach ($clients as $client)
                  <div class="form-check">
                    <label class="form-check-label">
                      <input class="form-check-input" type="radio" name="cliente" value="{{ $client->id }}" {{ $client->id == 2 ? 'checked' : '' }}> {{ $client->name }}
                    </label>
                  </div>
                @endforeach --}}

                <button type="submit" class="btn btn-sm mt-3 btn-block btn-secondary" data-toggle="tooltip" data-placement="bottom" title="Nueva ventana">Ver Factura <i class="fa fa-fw fa-external-link" aria-hidden="true"></i></button>

                <button id="guarda-factura" class="btn btn-epic btn-block mb-3 mt-2">Guardar ingreso</button>
              </div>
            </div>
          </form>



          <!-- Modal -->
          <div class="modal fade" id="nuevoCliente" tabindex="-1" role="dialog" aria-labelledby="nuevoClienteLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">

              <form action="{{ url('cliente/nuevo') }}" method="post">
                {{ csrf_field() }}

                <div class="modal-header">
                  <h5 class="modal-title" id="nuevoClienteLabel">
                    <i class="fa fa-fw fa-plus" aria-hidden="true"></i>
                    Añadir nuevo cliente
                  </h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <div class="col-12">

                    <label class="col-form-label">
                      <i class="fa fa-fw fa-user" aria-hidden="true"></i>
                      Nombre
                    </label>
                    <input class="form-control" type="text" placeholder="Andreu García Martínez" name="name">

                    <label class="col-form-label">
                      <i class="fa fa-fw fa-info" aria-hidden="true"></i>
                      NIF
                    </label>
                    <input class="form-control" type="text" placeholder="12345678Z" name="nif">

                    <label class="col-form-label">
                      <i class="fa fa-fw fa-map-marker" aria-hidden="true"></i>
                      Dirección fiscal
                    </label>
                    <input class="form-control" type="text" placeholder="C/ Falsa 123" name="address">

                    <div class="custom-control custom-checkbox mt-3">
                      <input type="checkbox" class="custom-control-input" id="persona_fisica_check" name="persona_fisica">
                      <label class="custom-control-label" for="persona_fisica_check">Es un particular?</label>
                    </div>

                  </div>
                </div>
                <div class="modal-footer">
                  <button type="submit" class="btn btn-primary">
                    <i class="fa fa-fw fa-plus" aria-hidden="true"></i>
                    Crear
                  </button>
                </div>
              </form>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
</div>

@endsection

@section('scripts')

  <script>

  $("#guarda-gasto").click(function() {

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

  $("#guarda-factura").click(function() {

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
    $('#cantidad').val("2");
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
