<div class="modal-header">
  <h5 class="modal-title" id="modalAccionLabel">Editar Cliente</h5>
  <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
<div class="modal-body">
  @if($errors->any())
    <div class="alert alert-danger">
      <ul>
        @foreach($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form action="{{ route('admin.clientes.actualizar', $cliente) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="form-group">
      <label for="name">Nombre</label>
      <input type="text" name="name" id="name" class="form-control" value="{{ $cliente->name }}" required>
    </div>
    <div class="form-group">
      <label for="apellidos">Apellidos</label>
      <input type="text" name="apellidos" id="apellidos" class="form-control" value="{{ $cliente->apellidos }}">
    </div>
    <div class="form-group">
      <label for="dni">DNI</label>
      <input type="text" name="dni" id="dni" class="form-control" value="{{ $cliente->dni }}">
    </div>
    <div class="form-group">
      <label for="telefono">Teléfono</label>
      <input type="text" name="telefono" id="telefono" class="form-control" value="{{ $cliente->telefono }}">
    </div>
    <div class="form-group">
      <label for="email">Correo electrónico</label>
      <input type="email" name="email" id="email" class="form-control" value="{{ $cliente->email }}" required>
    </div>
    <div class="form-group">
      <label for="password">Nueva Contraseña (dejar en blanco para no modificar)</label>
      <input type="password" name="password" id="password" class="form-control">
    </div>
    <div class="form-group">
      <label for="password_confirmation">Confirmar Nueva Contraseña</label>
      <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
    </div>
    <div class="form-group">
      <button type="submit" class="btn btn-success">
            <i class="fas fa-check"></i> Actualizar Cliente
    </div>
  </form>
</div>