@extends('layouts.app')

@section('title', 'Añadir Nuevo')

@section('content')

<div id="block_final" class="container" style="display:none">
  <div class="col">
    <h1 class="display-3">Todo guardado!</h1>
    <p class="lead">Enhorabuena! molas mogollón y aqui un Lorem ipsum que no se va a leer nadie est laborum para rellenar</p>
    <hr class="my-4">
    <p>
      <button class="btn btn-primary btn-lg btn-block" id="refresh" role="button">
        <i class="fas fa-plus fa-fw" aria-hidden="true"></i>
        ¿Otro pago?
      </button>
    </p>
    <p>
      <a href="{{ url('home') }}" class="btn btn-warning btn-lg btn-block">
        <i class="fas fa-list fa-fw" aria-hidden="true"></i>
        Gestionar todos
      </a>
    </p>
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
                <span class="input-group-text"><i class="fas fa-euro-sign fa-fw"></i></span>
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
          <button id="guarda-gasto" class="btn btn-epic btn-block mb-3 mt-4">
            <i class="far fa-save fw-fw"></i> Guardar
          </button>

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
                        <span class="input-group-text"><i class="fas fa-info fa-fw"></i></span>
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
                        <span class="input-group-text"><i class="fas fa-hourglass-half fa-fw"></i></span>
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
                        <span class="input-group-text"><i class="fas fa-euro-sign fa-fw"></i></span>
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
                        <span class="input-group-text"><i class="far fa-calendar-alt fa-fw"></i></span>
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
                        <span class="input-group-text"><i class="fas fa-quote-right fa-fw"></i></span>
                      </div>
                    <input class="form-control" type="text" value="Desarrollo aplicaciones y mantenimiento web" name="concepto">
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-12 col-sm-3">
                <h5 for="select-cliente">
                  Cliente
                  <span class="float-right mr-2">
                    <i class="fas fa-user-plus text-primary pointer" data-toggle="modal" data-target="#nuevoCliente"></i>
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

                 {{-- data-toggle="tooltip" data-placement="left" title="Nueva ventana" --}}
                <button type="submit" class="btn btn-sm mt-3 btn-block btn-secondary">
                  Ver Factura <i class="fas fa-external-link-alt fa-fw"></i>
                </button>

                <button id="guarda-factura" class="btn btn-epic btn-block mb-3 mt-2">
                  <i class="far fa-save fw-fw"></i> Guardar
                </button>
              </div>
            </div>
          </form>

          <!-- Modal -->
          @include('layouts.clienteModal')

        </div>
      </div>
    </div>
  </div>
</div>

@endsection

@section('scripts')

  <script>

  $("#guarda-gasto").click(function() {

    $(this).html('<i class="fas fa-sync-alt fa-spin fa-fw"></i>');

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

    $(this).html('<i class="fas fa-sync-alt fa-spin fa-fw"></i>');

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
