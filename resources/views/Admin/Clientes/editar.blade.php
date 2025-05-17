<div class="form-wrapper actividad-modal-wrapper">
  <div class="page-title">
    <i class="fas fa-user-circle text-success"></i>
    <span>Editar Cliente</span>
  </div>
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
    <div class="form-grid-2cols">
      <div class="form-group">
        <label for="name"><i class="fas fa-user icono-label"></i> Nombre</label>
        <input type="text" name="name" id="name" class="form-control" value="{{ $cliente->name }}" required>
      </div>
      <div class="form-group">
        <label for="apellidos"><i class="fas fa-user-tag icono-label"></i> Apellidos</label>
        <input type="text" name="apellidos" id="apellidos" class="form-control" value="{{ $cliente->apellidos }}">
      </div>
      <div class="form-group">
        <label for="email"><i class="fas fa-envelope icono-label"></i> Correo electrónico</label>
        <input type="email" name="email" id="email" class="form-control" value="{{ $cliente->email }}" required>
      </div>
      <div class="form-group">
        <label for="telefono"><i class="fas fa-phone icono-label"></i> Teléfono</label>
        <input type="text" name="telefono" id="telefono" class="form-control" value="{{ $cliente->telefono }}">
      </div>
      <div class="form-group">
        <label for="password" class="nowrap-label"><i class="fas fa-lock icono-label"></i> Nueva Contraseña</label>
        <input type="password" name="password" id="password" class="form-control">
      </div>
      <div class="form-group">
        <label for="password_confirmation" class="nowrap-label"><i class="fas fa-lock icono-label"></i> Confirmar Contraseña</label>
        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
      </div>
      <div class="form-group">
        <label for="dni"><i class="fas fa-id-card icono-label"></i> DNI</label>
        <input type="text" name="dni" id="dni" class="form-control" value="{{ $cliente->dni }}">
      </div>
    </div>
    <div class="form-group text-right mt-2">
      <button type="submit" class="btn btn-success btn-accion-modal">
        <i class="fas fa-check"></i> Actualizar Cliente
      </button>
    </div>
  </form>
</div>

<style>
.form-grid-2cols {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 6px 6px;
}
.form-group {
  margin-bottom: 4px;
}
.actividad-modal-wrapper {
  background: rgb(236, 236, 236);
  border-radius: 12px;
  box-shadow: 0 4px 24px rgba(0,0,0,0.10);
  padding: 8px 8px 8px 8px;
  max-width: 700px;
  margin: 0 auto;
  min-width: 260px;
}
@media (max-width: 991.98px) {
  .actividad-modal-wrapper {
    max-width: 98vw;
  }
  .form-grid-2cols {
    grid-template-columns: 1fr;
    gap: 4px;
  }
}
@media (max-width: 600px) {
  .actividad-modal-wrapper {
    padding: 4px 2px 4px 2px;
  }
}
@media (min-width: 1200px) {
  .actividad-modal-wrapper {
    max-width: 900px;
  }
}
.page-title {
  display: flex;
  align-items: center;
  font-size: 1.2rem;
  font-weight: 600;
  margin-bottom: 6px;
  gap: 8px;
}
.icono-label {
  color: #27ae60;
  margin-right: 4px;
}
.btn-accion-modal {
  border-radius: 8px;
  min-width: 120px;
  padding-left: 1rem;
  padding-right: 1rem;
}
.form-group label, .nowrap-label {
  font-weight: 500;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
  font-size: 1rem;
}
.form-group input, .form-group select, .form-group textarea {
  border-radius: 8px;
  border: 1px solid #ccc;
  width: 100%;
  box-sizing: border-box;
}
</style>