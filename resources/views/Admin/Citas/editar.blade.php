<div class="form-wrapper actividad-modal-wrapper">
  <div class="page-title">
    <i class="fas fa-calendar-edit text-success"></i>
    <span>Editar Cita</span>
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
  <form action="{{ route('admin.citas.actualizar', $cita) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="form-grid-2cols">
      <div class="form-group">
        <label for="actividad_id" class="nowrap-label"><i class="fas fa-dumbbell icono-label"></i> Actividad</label>
        <input type="number" name="actividad_id" id="actividad_id" class="form-control" value="{{ $cita->actividad_id }}" required>
      </div>
      <div class="form-group">
        <label for="fecha" class="nowrap-label"><i class="fas fa-calendar icono-label"></i> Fecha</label>
        <div class="input-group">
          <input type="text" name="fecha" id="fecha" class="form-control datepicker-cita" value="{{ $cita->fecha }}" required autocomplete="off">
          <div class="input-group-append">
            <span class="input-group-text" id="calendar-icon"><i class="fa fa-calendar"></i></span>
          </div>
        </div>
      </div>
      <div class="form-group">
        <label for="hueco" class="nowrap-label"><i class="fas fa-clock icono-label"></i> Hueco</label>
        <select name="hueco" id="hueco" class="form-control" required>
          <option value="">Seleccione un hueco</option>
          @if($cita->hueco)
            <option value="{{ $cita->hueco }}" selected>{{ $cita->hueco }}</option>
          @endif
        </select>
      </div>
      <div class="form-group">
        <label for="aforo" class="nowrap-label"><i class="fas fa-users icono-label"></i> Aforo</label>
        <input type="number" name="aforo" id="aforo" class="form-control" value="{{ $cita->aforo }}" required>
      </div>
      <div class="form-group">
        <label for="hora_inicio" class="nowrap-label"><i class="fas fa-clock icono-label"></i> Hora de Inicio</label>
        <input type="time" name="hora_inicio" id="hora_inicio" class="form-control" value="{{ $cita->hora_inicio }}" required>
      </div>
      <div class="form-group">
        <label for="duracion" class="nowrap-label"><i class="fas fa-hourglass-half icono-label"></i> Duración (minutos)</label>
        <input type="number" name="duracion" id="duracion" class="form-control" value="{{ $cita->duracion }}" required>
      </div>
      <div class="form-group">
        <label for="frecuencia" class="nowrap-label"><i class="fas fa-redo icono-label"></i> Frecuencia</label>
        <select name="frecuencia" id="frecuencia" class="form-control" required>
          <option value="una_vez" {{ $cita->frecuencia == 'una_vez' ? 'selected' : '' }}>Una vez</option>
          <option value="cada_semana" {{ $cita->frecuencia == 'cada_semana' ? 'selected' : '' }}>Cada semana</option>
          <option value="cada_mes" {{ $cita->frecuencia == 'cada_mes' ? 'selected' : '' }}>Cada mes</option>
        </select>
      </div>
    </div>
    <div class="form-group text-right mt-3">
      <button type="submit" class="btn btn-success btn-accion-modal">
        <i class="fas fa-check"></i> Actualizar Cita
      </button>
    </div>
  </form>
</div>

<style>
.actividad-modal-wrapper {
  background: rgb(236, 236, 236);
  border-radius: 12px;
  box-shadow: 0 4px 24px rgba(0,0,0,0.10);
  padding: 6px 4px 6px 4px;
  max-width: 1200px;
  margin: 0 auto;
  min-width: 260px;
}
.form-grid-2cols {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 6px 6px;
}
.form-group {
  margin-bottom: 4px;
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
    padding: 2px 1px 2px 1px;
  }
}
@media (min-width: 1200px) {
  .actividad-modal-wrapper {
    max-width: 1200px;
  }
}
.page-title {
  display: flex;
  align-items: center;
  font-size: 1.5rem;
  font-weight: 600;
  margin-bottom: 2px;
  gap: 10px;
}
.icono-label {
  color: #27ae60;
  margin-right: 4px;
}
.texto-aclaracion {
  font-weight: normal;
  font-size: 0.9em;
}
.btn-accion-modal {
  border-radius: 8px;
  min-width: 200px;
  padding-left: 1.5rem;
  padding-right: 1.5rem;
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

