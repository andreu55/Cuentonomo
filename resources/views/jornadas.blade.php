@extends('layouts.app')

@section('title', 'Jornadas')

@section('css')
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/timepicker@1.11.12/jquery.timepicker.min.css">
@endsection

@section('content')
  <div class="container">
    <div class="row">

      <div class="col-lg-8 col-md-offset-2">
        <h4 class="mb-4">
          @if ($actual)
            <i class="fas fa-sign-in-alt fa-fw"></i> Actualmente <small>desde las <b>{{ $desdeLas }}</b>...</small>
          @else
            <i class="fas fa-plus fa-sm fa-fw"></i> Nueva
          @endif
        </h4>
        <div class="row mb-2">
          <div class="col">
            <input id="laHora" type="text" class="time ui-timepicker-input form-control" autocomplete="off">
          </div>
          <div class="col">
            <input type="date" class="form-control" id="fecha" value="<?= date('Y-m-d') ?>" required>
          </div>
        </div>

        <div class="text-center mt-4 mb-5">
          @if ($actual)
            <button class="guardaHora btn btn-lg btn-success btn-block mt-3" data-entrada="0" type="button" data-hora_id="{{ $actual->id }}">Salida <small id="horas_despues">({{ $desdeLasHuman }})</small> <i class="fas fa-sign-out-alt fa-fw"></i></button>
          @else
            <button class="guardaHora btn btn-lg btn-primary btn-block" data-entrada="1" type="button" data-hora_id="0"><i class="fas fa-sign-in-alt fa-fw"></i> Entrada</button>
          @endif
        </div>

        <hr>


        <div class="card mb-4">
									<div class="card-block">
										<h3 class="card-title">Últimas</h3>

										<div class="dropdown card-title-btn-container" title="{{ $horas_dia }} horas al día">
                      <em class="{{ $balance['horas'] >= 0 ? 'text-success' : 'text-danger' }}">
                        <b>{{ formatBonito($balance_horas) }}</b> horas
                      </em>
										</div>

										<div class="table-responsive">
											<table class="table">
												<tbody>
                          @foreach ($ult_jornadas_new as $j)

                            <tr>

                            @php
                              $laEntrada = $j->entrada;
                              $laSalida = $j->salida;
                            @endphp

                            @if ($j->salida)

                              <td>De <b class="text-info">{{ $laEntrada->format('H:i') }}</b> a <b class="text-primary">{{ $laSalida->format('H:i') }}</b><br></td>
                              @php

                                // Mostrar aqui la suma total si primera vez esa fecha!!!

                                  // 21 => 1146
                                  // 20 => 480

                                // $diff = formatBonito($laEntrada->diffInMinutes($laSalida->subHours(8), false)/60);
                                $dia_actual = $laEntrada->format('d');
                                if (isset($dia_anterior) && $dia_actual == $dia_anterior) {
                                  $diff = '';
                                  $dia_anterior = $dia_actual;
                                } else {
                                  $minsHoy = $minsTrabajadosPorDia[$dia_actual] - $minutos_dia;
                                  $diff = formatBonito($minsHoy/60);
                                  $dia_anterior = $dia_actual;
                                }

                              @endphp

                              <td class="text-right">
                              @if ($diff)
                                  <small>
                                    <em class="text-muted">
                                      {{ traduceDia($laEntrada->format('l')) }} {{ $laEntrada->format('d') }}
                                    </em>
                                    &nbsp;
                                    <em class="{{ $diff >= 0 ? 'text-success' : 'text-danger' }}">
                                      <b>{{ $diff }}</b>
                                    </em>
                                  </small>
                              @endif
                            </td>



                            @else
                              <td>Actualmente desde las <b class="text-info">{{ $laEntrada->format('H:i') }}</b></td>
                              <td></td>
                            @endif
                          </tr>
                          @endforeach
												</tbody>
											</table>
										</div>
									</div>
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
          <ul style="margin-top:25px;padding:0">
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

      var elBoton = $(this);
      elBoton.html('<i class="fas fa-sync-alt fa-spin fa-fw"></i>');
      var entrada = $(this).data('entrada');
      var hora_id = $(this).data('hora_id');

      $.post("{{ url('jornada/guardar') }}",
      {
        _token: "{{ csrf_token() }}",
        hora: $('#laHora').val(),
        fecha: $('#fecha').val(),
        client: 2,
        entrada: entrada,
        hora_id: hora_id
      },
      function(data, status){
        elBoton.html('<i class="fas fa-check fa-fw"></i>');
        location.reload();
      });
    });

    $('.form-control').change(function(){
      $('#horas_despues').html('');
    })


    $(document).ready(function(){
      $('#laHora').timepicker('setTime', new Date());

      $('[data-toggle="tooltip"]').tooltip()
    });

  </script>

@endsection
