<div class="form-wrapper actividad-modal-wrapper">
  <div class="page-title">
    <i class="fa-solid fa-pen text-success" style="color:#28a745;"></i>
    <span>Editar Actividad</span>
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
  <form action="{{ route('admin.actividades.actualizar', $actividad) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="form-grid-2cols">
      <div class="form-group">
        <label for="nombre"><i class="fas fa-dumbbell icono-label"></i> Nombre</label>
        <input type="text" name="nombre" id="nombre" class="form-control" value="{{ $actividad->nombre }}" required>
      </div>
      <div class="form-group">
        <label for="activo"><i class="fas fa-check-circle icono-label"></i> Activo</label>
        <select name="activo" id="activo" class="form-control" required>
          <option value="1" {{ $actividad->activo ? 'selected' : '' }}>Sí</option>
          <option value="0" {{ !$actividad->activo ? 'selected' : '' }}>No</option>
        </select>
      </div>
      <div class="form-group form-group-descripcion" style="grid-column: 1 / -1;">
        <label for="descripcion"><i class="fas fa-align-left icono-label"></i> Descripción</label>
        <textarea name="descripcion" id="descripcion" class="form-control actividad-descripcion-area" rows="4">{{ $actividad->descripcion }}</textarea>
      </div>
    </div>
    <div class="form-group text-right mt-2">
      <button type="submit" class="btn btn-success btn-accion-modal">
        <i class="fas fa-check"></i> Actualizar Actividad
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
.form-group-descripcion {
  grid-column: 1 / -1;
}
.actividad-modal-wrapper {
  background: rgb(236, 236, 236);
  border-radius: 12px;
  box-shadow: 0 4px 24px rgba(0,0,0,0.10);
  padding: 8px 8px 8px 8px;
  max-width: 520px;
  margin: 0 auto;
  min-width: 260px;
}
@media (max-width: 600px) {
  .actividad-modal-wrapper {
    padding: 4px 2px 4px 2px;
    max-width: 98vw;
  }
  .form-grid-2cols {
    grid-template-columns: 1fr;
    gap: 4px;
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
.form-group label {
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
.actividad-descripcion-area {
  min-height: 80px;
  max-height: 220px;
  resize: vertical;
  width: 100%;
  font-size: 1rem;
  padding: 8px;
  border-radius: 8px;
  box-sizing: border-box;
}
@media (min-width: 768px) {
  .actividad-descripcion-area {
    min-height: 120px;
    max-height: 260px;
    font-size: 1.05rem;
  }
  .actividad-modal-wrapper {
    max-width: 600px;
  }
}
@media (min-width: 1200px) {
  .actividad-modal-wrapper {
    max-width: 900px;
  }
  .actividad-descripcion-area {
    min-height: 140px;
    max-height: 320px;
    font-size: 1.08rem;
  }
}
</style>