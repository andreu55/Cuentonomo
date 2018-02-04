@extends('layouts.app')

@section('css')
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/timepicker@1.11.12/jquery.timepicker.min.css">
  <style media="screen">
    @import url(https://fonts.googleapis.com/css?family=BenchNine:700);
    .omg_button {
      background-color: #c47135;
      border: none;
      color: #ffffff;
      cursor: pointer;
      display: inline-block;
      font-family: 'BenchNine', Arial, sans-serif;
      font-size: 1em;
      font-size: 22px;
      line-height: 1em;
      margin-top: 25px;
      outline: none;
      padding: 14px 40px 12px;
      position: relative;
      text-transform: uppercase;
      font-weight: 700;
    }

    .omg_button:before,
    .omg_button:after {
      border-color: transparent;
      -webkit-transition: all 0.25s;
      transition: all 0.25s;
      border-style: solid;
      border-width: 0;
      content: "";
      height: 24px;
      position: absolute;
      width: 24px;
    }

    .omg_button:before {
      border-color: #c47135;
      border-left-width: 2px;
      border-top-width: 2px;
      left: -5px;
      top: -5px;
    }

    .omg_button:after {
      border-bottom-width: 2px;
      border-color: #c47135;
      border-right-width: 2px;
      bottom: -5px;
      right: -5px;
    }

    .omg_button:hover,
    .omg_button.hover {
      background-color: #c47135;
    }

    .omg_button:hover:before,
    .omg_button.hover:before,
    .omg_button:hover:after,
    .omg_button.hover:after {
      height: 100%;
      width: 100%;
    }

  </style>
@endsection

@section('content')
  <div class="container">
    <div class="row">

      <div class="col-lg-8 col-md-offset-2">
        <h2>Horas trabajadas</h2>

        <div class="row mb-2">
          <div class="col-8">
            <input id="laHora" type="text" class="time ui-timepicker-input form-control" autocomplete="off">
          </div>
          <div class="col-4">
            <input type="date" class="form-control" id="fecha" value="<?= date('Y-m-d') ?>" required>
          </div>
        </div>

        <div class="row text-center mb-5">
          <div class="col">
            <button class="guardaHora omg_button btn-block" data-entrada="1" type="button">Entrada</button>
          </div>
          <div class="col">
            <button class="guardaHora omg_button btn-block" data-entrada="0" type="button">Salida</button>
          </div>
        </div>

      </div>

      <div class="col-lg-4">

        @if ($ult_jornadas)
          <h3>
            Últimas jornadas
            <em class="pull-right" title="{{ $horas_dia }} horas al día">
              <small class="{{ $balance['horas'] >= 0 ? 'text-success' : 'text-danger' }}">
                <b>
                  {{ $balance['horas'] >= 0 ? '+' : '' }}{{ $balance['horas'] }}{{ $balance['minutos'] ? ':'.$balance['minutos'] : '' }}</b> horas
              </small>
            </em>
          </h3>
          <ul class="list-group">
            @foreach ($ult_jornadas as $jornada)
              @php
                $entrada = new DateTime($jornada->entrada);
                $salida = new DateTime($jornada->salida);
                $resta = $entrada->diff($salida);
                $horas = $resta->format('%h');
                $minutos = $resta->format('%i');
                $bal = $horas - 8;
                if ($minutos) {
                  if ($bal < 0) {
                    $minutos = $minutos - 30;
                  }
                  $bal .= ":" . $minutos;
                }
                else { $bal .= ":00"; }
              @endphp

              <li class="list-group-item" title="{{ $jornada->client->name }}">
                De <b class="text-info">{{ $jornada->entrada ? $entrada->format('H:i') : '??' }}</b>
                a <b class="text-primary">{{ $jornada->salida ? $salida->format('H:i') : '??' }}</b>
                <small>{{ $jornada->notas ? '(' . $jornada->notas . ')' : '' }}</small>
                <em class="pull-right">
                  <small class="{{ $bal >= 0 ? 'text-success' : 'text-danger' }}">
                    <b>{{ $bal >= 0 ? '+' : '' }}{{ $bal }}</b>
                  </small>
                  &nbsp;
                  <small class="text-muted">
                    {{ date('d F', strtotime($jornada->fecha)) }}
                  </small>
                </em>
              </li>
            @endforeach
          </ul>
        @endif

      </div>
    </div>
  </div>
@endsection

@section('scripts')

  <script src="https://cdn.jsdelivr.net/npm/timepicker@1.11.12/jquery.timepicker.min.js"></script>
  <script type="text/javascript">

    $('#laHora').timepicker({
      scrollDefault: 'now',
      timeFormat: 'H:i',
      show2400: true,
      forceRoundTime: true,
      step: 15
    });

    $(".guardaHora").click(function(){

      $(this).html('<i class="fa fa-refresh fa-spin fa-fw"></i>');
      var entrada = $(this).data('entrada');

      $.post("{{ url('jornada/guardar') }}",
      {
        _token: "{{ csrf_token() }}",
        hora: $('#laHora').val(),
        fecha: $('#fecha').val(),
        client: 2,
        entrada: entrada
      },
      function(data, status){
        // $('.guardaHora').html('<i class="fa fa-check fa-fw"></i>');
        location.reload();
      });
    });


    $(document).ready(function(){
      $('#laHora').timepicker('setTime', new Date());
    });

  </script>

@endsection
