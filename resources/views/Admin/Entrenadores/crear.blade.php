<div class="form-wrapper">
  <div class="page-title">
    <i class="fas fa-plus-circle"></i>
    <span>Crear Entrenador</span>
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
  <form action="{{ route('admin.entrenadores.almacenar') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="form-grid-2cols">
      <div class="form-group">
        <label for="nombre"><i class="fas fa-user icono-label"></i> Nombre</label>
        <input type="text" name="nombre" id="nombre" class="form-control" required>
      </div>
      <div class="form-group">
        <label for="apellidos"><i class="fas fa-user-tag icono-label"></i> Apellidos</label>
        <input type="text" name="apellidos" id="apellidos" class="form-control" required>
      </div>
      <div class="form-group">
        <label for="dni"><i class="fas fa-id-card icono-label"></i> DNI</label>
        <input type="text" name="dni" id="dni" class="form-control" required>
      </div>
      <div class="form-group">
        <label for="telefono"><i class="fas fa-phone icono-label"></i> Teléfono</label>
        <input type="text" name="telefono" id="telefono" class="form-control">
      </div>
      <div class="form-group">
        <label for="especialidad"><i class="fas fa-dumbbell icono-label"></i> Especialidad</label>
        <select name="especialidad" id="especialidad" class="form-control" required>
          <option value="entrenamiento funcional">Entrenamiento Funcional</option>
          <option value="electroestimulación">Electroestimulación</option>
          <option value="readaptacion de lesiones">Readaptación de Lesiones</option>
        </select>
      </div>
      <div class="form-group">
        <label for="profile_photo_path"><i class="fas fa-image icono-label"></i> Foto</label>
        <input type="file" name="profile_photo_path" id="profile_photo_path" class="form-control" accept="image/*">
      </div>
    </div>
    <div class="form-group text-right mt-2">
      <button type="submit" class="btn btn-success btn-accion-modal">
        <i class="fas fa-check"></i> Crear Entrenador
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
.form-wrapper {
  background: rgb(236, 236, 236);
  border-radius: 12px;
  box-shadow: 0 4px 24px rgba(0,0,0,0.10);
  padding: 8px 8px 8px 8px;
  max-width: 700px;
  margin: 0 auto;
  min-width: 260px;
}
@media (max-width: 991.98px) {
  .form-wrapper {
    max-width: 98vw;
  }
  .form-grid-2cols {
    grid-template-columns: 1fr;
    gap: 4px;
  }
}
@media (max-width: 600px) {
  .form-wrapper {
    padding: 4px 2px 4px 2px;
  }
}
@media (min-width: 1200px) {
  .form-wrapper {
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

