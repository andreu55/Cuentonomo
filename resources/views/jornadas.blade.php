@extends('layouts.app')

@section('title', 'Jornadas')

@section('css')
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/timepicker@1.11.12/jquery.timepicker.min.css">
@endsection

@section('content')
  <div class="container">
    <div class="row">

      <div class="col-lg-8 col-md-offset-2">
        <h3><i class="fas fa-plus fa-sm fa-fw"></i> Nueva</h3>
        <div class="row mb-2">
          <div class="col">
            <input id="laHora" type="text" class="time ui-timepicker-input form-control" autocomplete="off">
          </div>
          <div class="col">
            <input type="date" class="form-control" id="fecha" value="<?= date('Y-m-d') ?>" required>
          </div>
        </div>

        <div class="text-center mt-4 mb-5">
          <button class="guardaHora btn btn-lg btn-primary btn-block" data-entrada="1" type="button"><i class="fas fa-sign-in-alt fa-fw"></i> Entrada</button>
          <button class="guardaHora btn btn-lg btn-success btn-block mt-3" data-entrada="0" type="button">Salida <i class="fas fa-sign-out-alt fa-fw"></i></button>
        </div>
      </div>

      <div class="col-lg-4">
        @if ($ult_jornadas)
          <h5>
            Últimas
            <em class="float-right" title="{{ $horas_dia }} horas al día">
              <small class="{{ $balance['horas'] >= 0 ? 'text-success' : 'text-danger' }}">
                <b>{{ $balance['horas'] >= 0 ? '+' : '' }}{{ $balance['horas'] }}{{ $balance['minutos'] ? ':'.$balance['minutos'] : '' }}</b> horas
              </small>
            </em>
          </h5>
          <ul class="list-group">
            @foreach ($ult_jornadas as $jornada)
              @php
                $entrada = new DateTime($jornada->entrada);
                $salida = new DateTime($jornada->salida);
                $resta = $entrada->diff($salida);
                $horas = $resta->h;
                $minutos = $resta->i;
                $bal = $horas - 8;
                if ($minutos) {
                  // Deberíamos pasarlo todo a minutos y restar correctamente, esto es un apaño
                  if ($bal < 0) {
                    if ($minutos == 45) { $minutos = $minutos - 30; }
                    elseif ($minutos == 15) { $minutos = $minutos + 30; $bal = $bal + 1; }
                  }
                  $bal .= ":" . $minutos;
                }
                else { $bal .= ":00"; }
              @endphp

              <li class="list-group-item" title="{{ $jornada->client->name }}">
                De <b class="text-info">{{ $jornada->entrada ? $entrada->format('H:i') : '??' }}</b>
                a <b class="text-primary">{{ $jornada->salida ? $salida->format('H:i') : '??' }}</b>
                @if ($jornada->notas)
                  <small style="vertical-align:text-top">
                    <i class="far fa-question-circle fa-fw" data-toggle="tooltip" data-placement="top" title="{{ $jornada->notas }}"></i>
                  </small>
                @endif
                <em class="float-right">
                  <small class="text-muted">
                    @php
                      $fecha_jornada = strtotime($jornada->fecha);
                    @endphp
                    {{ traduceDia(date('l', $fecha_jornada)) }}
                    {{ date('d', $fecha_jornada) }}
                  </small>
                  &nbsp;
                  <small class="{{ $bal >= 0 ? 'text-success' : 'text-danger' }}">
                    <b>{{ $bal >= 0 ? '+' : '' }}{{ $bal }}</b>
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

      $(this).html('<i class="fas fa-sync-alt fa-spin fa-fw"></i>');
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

      $('[data-toggle="tooltip"]').tooltip()
    });

  </script>

@endsection
