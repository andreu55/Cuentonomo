@extends('layouts.app')

@section('title', 'Perfil')

@section('content')

  <div class="container">
    <div class="row">
      <div class="col-12">

        @foreach ($campos as $campo)

          @php
            $nombre = $campo['nombre'];
            $campo_db = $campo['campo_db'];
            $tipo = $campo['tipo'];
          @endphp

          <div class="form-group row">
            <label class="col-sm-2 col-form-label text-right d-none d-sm-block">
              <b>{{ $nombre }}</b>
            </label>
            <div class="col-sm-10">
              <div class="input-group">
                <input class="form-control fast_editing" type="{{ $tipo }}" {{ $tipo == 'number' ? 'step="0.01"' : '' }} value="{{ $user->$campo_db }}" name="{{ $campo_db }}">
              </div>
            </div>
          </div>
        @endforeach

        <hr>

        <div class="row mb-5">
          <div class="col-sm-2 text-right">
            <h4 for="select-cliente">
              Clientes
            </h4>
            <a href="#" class="btn btn-outline-warning" title="Nuevo cliente" data-toggle="modal" data-target="#nuevoCliente"><i class="fas fa-plus"></i></a>
          </div>

          <div class="col-sm-10">
            <ul class="list-group">
              @foreach ($clients as $client)
                <li class="list-group-item" data-client="{{ $client->id }}">
                  <a href="#" class="color-primary" data-toggle="modal" data-target="#editaCliente">
                    <i class="far fa-edit fa-fw"></i>
                  </a>
                  &nbsp;
                  {{ $client->name }}
                  <em class="pull-right">{{ $client->address }}</em>
                  <small class="text-muted">
                    <em>{{ $client->persona_fisica ? 'particular' : 'empresa' }}</em>
                  </small>
                </li>
              @endforeach
            </ul>
          </div>
        </div>

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

@endsection

@section('scripts')

  <script>

    var typingTimer; // timer identifier

    //on keyup, start the countdown
    $('.fast_editing').keyup(function() {

      clearTimeout(typingTimer);

      $('#load_text').slideUp(); // .hide()

      var campo = $(this).attr('name');
      var valor = $(this).val();

      if (campo) {
        typingTimer = setTimeout(doneTyping, 2000, campo, valor);
      }
    });

    //user is "finished typing," do something
    function doneTyping(campo, valor) {

      $('#load_text').show(); // .slideDown()
      $('#load_text').html('<em class="text-muted">Guardando</em> <i class="fa fa-fw fa-cog fa-spin text-warning"></i>');

      $.post("{{ url('user/editar') }}",
      {
        _token: "{{ csrf_token() }}",
        campo: campo,
        valor: valor
      },
      function(data, status) {
        if(status == 'success')
          $('#load_text').html('<em class="text-muted">Guardado</em> <i class="fa fa-fw fa-check text-success"></i>');
        else
          $('#load_text').html('<i class="fa fa-fw fa-times text-danger"></i>');
      });
    }

  </script>

@endsection
