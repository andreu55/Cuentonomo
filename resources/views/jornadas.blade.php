@extends('layouts.app')

@section('title', 'Jornadas')

@section('css')
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/timepicker@1.11.12/jquery.timepicker.min.css">
@endsection

@section('content')
  <div class="container">
    <div class="row">

      <div class="col-lg-7 col-md-offset-2">
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

        <div class="text-center mt-4 mb-4">
          @if ($actual)
            <button class="guardaHora btn btn-lg btn-success btn-block mt-3" data-entrada="0" type="button" data-hora_id="{{ $actual->id }}">Salida <small id="horas_despues">({{ $desdeLasHuman }})</small> <i class="fas fa-sign-out-alt fa-fw"></i></button>
          @else
            <button class="guardaHora btn btn-lg btn-primary btn-block" data-entrada="1" type="button" data-hora_id="0"><i class="fas fa-sign-in-alt fa-fw"></i> Entrada</button>
          @endif
        </div>

        <div class="card mb-4">
					<div class="card-block">
						<h3 class="card-title">Overview</h3>
            <h6 class="card-subtitle mb-2 text-muted">Horas por día</h6>

						<div class="canvas-wrapper">
							<canvas class="main-chart" id="line-chart" height="200" width="600"></canvas>
						</div>
					</div>
				</div>

      </div>

      <div class="col-lg-5">
        @if ($ult_jornadas_new)
          <div class="card mb-4">
            <div class="card-block">
              <h3 class="card-title">Balance</h3>
              <h6 class="card-subtitle mb-2">
                <a class="text-muted" href="{{ url('user') }}">Horas por jornada: <b>{{ $horas_dia }}</b> <i class="fas fa-pencil-alt fa-fw"></i></a>
                <br>
                <div class="row">
                  <div class="col text-center">
                    <a href="{{ url('horas/'.$ant_mes.'/'.$ant_year) }}" class="btn my-left">
                      <i class="fas fa-angle-double-left fa-fw fa-2x" aria-hidden="true"></i>
                    </a>
                    <em>
                      <b>{{ $mes }}</b> {{ $year }}
                    </em>
                    <a href="{{ url('horas/'.$sig_mes.'/'.$sig_year) }}" class="btn my-right">
                      <i class="fas fa-angle-double-right fa-fw fa-2x" aria-hidden="true"></i>
                    </a>
                  </div>
                </div>
              </h6>

              <div class="card-title-btn-container">
                <em class="{{ $balance_horas >= 0 ? 'text-success' : 'text-danger' }}">
                  <b>{{ formatBonito($balance_horas) }}</b> Horas
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
                        <td>
                          De <b class="text-info">{{ $laEntrada->format('H:i') }}</b> a <b class="text-primary">{{ $laSalida->format('H:i') }}</b>
                          @if ($j->nota)
                            <small class="text-muted" style="vertical-align:super">
                              <i class="far fa-question-circle fa-fw" data-toggle="tooltip" data-placement="top" title="{{ $j->nota }}"></i>
                            </small>
                          @endif
                        </td>

                        @php
                          // $diff = formatBonito($laEntrada->diffInMinutes($laSalida->subHours(8), false)/60);
                          $dia_actual = $laEntrada->format('j');
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
                          <small>
                            @if ($diff)
                              <em class="{{ $diff[0] == '+' ? 'text-success' : 'text-danger' }}">
                                <b>{{ $diff }}</b>
                              </em>
                              &nbsp;
                            @endif
                            <em class="{{ $diff ? '' : 'text-muted' }}">
                              {{ traduceDia($laEntrada->format('l')) }} {{ $laEntrada->format('d') }}
                            </em>
                          </small>
                      </td>

                      @else
                        <td>
                          De <b class="text-info">{{ $laEntrada->format('H:i') }}</b> hasta <b class="text-primary">Ahora</b>
                          {{-- Actualmente desde las <b class="text-info">{{ $laEntrada->format('H:i') }}</b> --}}
                        </td>
                        <td class="text-right">
                          <small>
                            <em class="text-muted">
                              {{ traduceDia($laEntrada->format('l')) }} {{ $laEntrada->format('d') }}
                            </em>
                          </small>
                        </td>
                      @endif
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
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

      // $('[data-toggle="tooltip"]').tooltip();
    });

    var labels = [
      @foreach ($minsTrabajadosPorDia as $dia => $mins)
        "Día {{ $dia }}",
      @endforeach
    ];

    var datos = [
      @foreach ($minsTrabajadosPorDia as $dia => $mins)
        {{ $mins/60 }},
      @endforeach
    ];

    var horas_dia = [
      @foreach ($minsTrabajadosPorDia as $dia => $mins)
        {{ $horas_dia }},
      @endforeach
    ];

    var randomScalingFactor = function(){ return Math.round(Math.random()*1000)};

    var lineChartData = {
  			labels : labels,
  			datasets : [
          {
  					label: "Horas al día",
  					fillColor : "rgba(220,220,220,0.2)",
  					strokeColor : "rgba(220,220,220,1)",
  					pointColor : "rgba(220,220,220,1)",
  					pointStrokeColor : "#fff",
  					pointHighlightFill : "#fff",
  					pointHighlightStroke : "rgba(220,220,220,1)",
  					data : horas_dia
  				},{
  					label: "Horas reales",
            fillColor : "rgba(128,130,228,0.6)",
  					strokeColor : "rgba(128,130,228,1)",
  					pointColor : "rgba(128,130,228,1)",
  					pointStrokeColor : "#fff",
  					pointHighlightFill : "#fff",
  					pointHighlightStroke : "rgba(128,130,228,1)",
  					data : datos
  				}
  			]

  		}

    window.onload = function () {
			var chart1 = document.getElementById("line-chart").getContext("2d");
			window.myLine = new Chart(chart1).Line(lineChartData, {
			responsive: true,
			scaleLineColor: "rgba(0,0,0,.2)",
			scaleGridLineColor: "rgba(0,0,0,.05)",
			scaleFontColor: "#c5c7cc"
			});
		};

  </script>

@endsection
