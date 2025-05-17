<div class="form-wrapper">
  <div class="page-title">
    <i class="fas fa-user-edit icono-label"></i>
    <span>Editar Entrenador</span>
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
  <form action="{{ route('admin.entrenadores.actualizar', $entrenador) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="form-grid-2cols">
      <div class="form-group custom-file-wrapper-vertical">
        <label for="profile_photo_path" class="label-foto"><i class="fas fa-image icono-label"></i> Foto</label>
        @if($entrenador->profile_photo_path)
          <div class="mb-2">
            <img src="{{ asset('storage/'.$entrenador->profile_photo_path) }}" alt="Foto de Entrenador" style="max-width: 100px; border-radius:50%; margin-top:6px; display:block; margin-left:auto; margin-right:auto;">
          </div>
        @endif
        <input type="file" name="profile_photo_path" id="profile_photo_path" class="form-control file-narrow" accept="image/*">
      </div>
      <div>
        <div class="form-group">
          <label for="nombre"><i class="fas fa-user icono-label"></i> Nombre</label>
          <input type="text" name="nombre" id="nombre" class="form-control" value="{{ $entrenador->nombre }}" required>
        </div>
        <div class="form-group">
          <label for="apellidos"><i class="fas fa-user-tag icono-label"></i> Apellidos</label>
          <input type="text" name="apellidos" id="apellidos" class="form-control" value="{{ $entrenador->apellidos }}" required>
        </div>
        <div class="form-group">
          <label for="dni"><i class="fas fa-id-card icono-label"></i> DNI</label>
          <input type="text" name="dni" id="dni" class="form-control" value="{{ $entrenador->dni }}" required>
        </div>
        <div class="form-group">
          <label for="telefono"><i class="fas fa-phone icono-label"></i> Teléfono</label>
          <input type="text" name="telefono" id="telefono" class="form-control" value="{{ $entrenador->telefono }}">
        </div>
        <div class="form-group">
          <label for="especialidad"><i class="fas fa-dumbbell icono-label"></i> Especialidad</label>
          <select name="especialidad" id="especialidad" class="form-control" required>
            <option value="entrenamiento funcional" {{ $entrenador->especialidad == 'entrenamiento funcional' ? 'selected' : '' }}>Entrenamiento Funcional</option>
            <option value="electroestimulación" {{ $entrenador->especialidad == 'electroestimulación' ? 'selected' : '' }}>Electroestimulación</option>
            <option value="readaptacion de lesiones" {{ $entrenador->especialidad == 'readaptacion de lesiones' ? 'selected' : '' }}>Readaptación de Lesiones</option>
          </select>
        </div>
      </div>
    </div>
    <div class="form-group text-right mt-2">
      <button type="submit" class="btn btn-success btn-accion-modal">
        <i class="fas fa-check"></i> Actualizar Entrenador
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
.custom-file-wrapper {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 2px;
}
input[type="file"] {
  width: auto !important;
  min-width: 0 !important;
  max-width: 220px !important;
  display: inline-block !important;
  margin: 0 auto 0 auto !important;
  background: #fff !important;
  color: #333 !important;
  font-size: 0.98rem;
  padding: 2px 4px;
  border-radius: 8px;
  border: 1px solid #ccc;
  vertical-align: middle;
}
.file-narrow {
  width: 160px !important;
  min-width: 0 !important;
  max-width: 180px !important;
  display: inline-block !important;
  margin: 0 auto 0 auto !important;
  background: #fff !important;
  color: #333 !important;
  font-size: 0.98rem;
  padding: 2px 4px;
  border-radius: 8px;
  border: 1px solid #ccc;
  vertical-align: middle;
}
.custom-file-wrapper-vertical {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  height: 100%;
  min-height: 220px;
}
.label-foto {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 6px;
  margin-bottom: 8px;
  font-size: 1.05rem;
}
@media (max-width: 991.98px) {
  .custom-file-wrapper-vertical {
    min-height: 120px;
  }
}
</style>