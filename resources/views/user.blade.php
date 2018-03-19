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
              <i class="fas fa-user-plus fa-xs fa-fw ml-1 text-primary pointer" data-toggle="modal" data-target="#nuevoCliente"></i>
            </h4>
            {{-- <button class="btn btn-outline-warning" title="Nuevo cliente" data-toggle="modal" data-target="#nuevoCliente"><i class="fas fa-plus fa-fw"></i></button> --}}
          </div>

          <div class="col-sm-10">
            <ul class="list-group">
              @foreach ($clients as $client)
                <li class="list-group-item" data-client="{{ $client->id }}" id="client{{ $client->id }}">
                  {{-- <a href="#" class="color-primary" data-toggle="modal" data-target="#editaCliente">
                    <i class="far fa-edit fa-fw"></i>
                  </a>
                  &nbsp; --}}
                  <span class="borraCliente pointer" data-id="{{ $client->id }}">
                    <i class="far fa-trash-alt fa-fw text-danger"></i>
                  </span>
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
        @include('layouts.clienteModal')

      </div>
    </div>
  </div>

@endsection

@section('scripts')

  <script>

    $(".borraCliente").click(function() {

      if (confirm("¿Borrar seguro?")) {

        $(this).html('<i class="fas fa-sync-alt fa-spin fa-fw text-warning"></i>');
        var id = $(this).data('id');

        $.post('{{ url('cliente/borrar') }}',
        {
          _token: "{{ csrf_token() }}",
          id: id
        },
        function(data, status) {
          if (status == "success") {
            if (data.status == '200') {
              $('#client'+id).slideUp(); // hide
              // location.reload();
            }
          }
        });
      }
    });

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
