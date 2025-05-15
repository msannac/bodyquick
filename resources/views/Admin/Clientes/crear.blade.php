<div class="modal-header">
  <h5 class="modal-title" id="modalAccionLabel">Crear Cliente</h5>
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

  <form action="{{ route('admin.clientes.almacenar') }}" method="POST" id="formCrearCliente">
    @csrf
    <div class="form-group">
      <label for="name">Nombre</label>
      <input type="text" name="name" id="name" class="form-control" required>
    </div>
    <div class="form-group">
      <label for="apellidos">Apellidos</label>
      <input type="text" name="apellidos" id="apellidos" class="form-control">
    </div>
    <div class="form-group">
      <label for="dni">DNI</label>
      <input type="text" name="dni" id="dni" class="form-control">
    </div>
    <div class="form-group">
      <label for="telefono">Teléfono</label>
      <input type="text" name="telefono" id="telefono" class="form-control">
    </div>
    <div class="form-group">
      <label for="email">Correo electrónico</label>
      <input type="email" name="email" id="email" class="form-control" required>
    </div>
    <div class="form-group">
      <label for="password">Contraseña</label>
      <input type="password" name="password" id="password" class="form-control" required>
    </div>
    <div class="form-group">
      <label for="password_confirmation">Confirmar Contraseña</label>
      <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
    </div>
    <div class="form-group">
      <button type="submit" class="btn btn-success">
            <i class="fas fa-check"></i> Crear Cliente
    </div>
  </form>
</div>