<div class="modal fade" id="nuevoCliente" tabindex="-1" role="dialog" aria-labelledby="nuevoClienteLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">

    <form action="{{ url('cliente/nuevo') }}" method="post">
      {{ csrf_field() }}

      <div class="modal-header">
        <h4 class="modal-title" id="nuevoClienteLabel">
          <i class="fas fa-plus fa-fw"></i>
          Nuevo cliente
        </h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <i class="fas fa-times fa-fw"></i>
        </button>
      </div>
      <div class="modal-body">
        <div class="col-12">
          <label class="col-form-label">
            <b>Nombre completo</b>
          </label>
          <div class="input-group">
            <div class="input-group-prepend">
              <button onclick="iraUrlInput('https://contacts.google.com', 'clientName')" class="btn btn-sm btn-outline-secondary" type="button"><i class="fas fa-user fa-fw"></i></button>
            </div>
            <input class="form-control" type="text" placeholder="Andreu García" name="name" id="clientName">
          </div>

          <label class="col-form-label">
            <b>NIF</b>
          </label>
          <div class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text"><i class="far fa-id-card fa-fw"></i></span>
            </div>
            <input class="form-control" type="text" placeholder="1234...Z" name="nif">
          </div>

          <label class="col-form-label">
            <b>Dirección fiscal</b>
          </label>
          <div class="input-group">
            <div class="input-group-prepend">
              <button onclick="iraUrlInput('https://www.google.es/maps', 'clientAddress')" class="btn btn-sm btn-outline-secondary" type="button"><i class="fas fa-map-marker fa-fw"></i></button>
            </div>
            <input class="form-control" type="text" placeholder="C/" name="address" id="clientAddress">
          </div>

          <div class="custom-control custom-checkbox mt-3">
            <input type="checkbox" class="custom-control-input" id="persona_fisica_check" name="persona_fisica">
            <label class="custom-control-label" for="persona_fisica_check"><b>¿Es un particular?</b></label>
          </div>

        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">
          <i class="fas fa-plus fa-fw"></i>
          Crear
        </button>
      </div>
    </form>
    </div>
  </div>
</div>
