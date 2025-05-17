<div class="form-wrapper actividad-modal-wrapper">
  <div class="d-flex align-items-start justify-content-between mb-2" style="gap: 0;">
    <div class="page-title mb-0" style="flex-shrink:0; white-space:nowrap;">
      <i class="fas fa-calendar-plus text-success"></i>
      <span>Crear Cita</span>
    </div>
    <div class="form-group-checkbox form-group mb-0" style="min-width:220px; align-items: flex-start; justify-content: flex-end;">
      <label class="mb-0" style="margin-bottom:0;">
        <input type="checkbox" id="masiva" name="masiva" value="1"> Crear de forma masiva
      </label>
    </div>
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
  <form action="{{ route('admin.citas.almacenar') }}" method="POST" id="formCrearCita">
    @csrf
    <div class="form-grid-2cols">
      <div class="form-group group-individual">
        <label for="fecha" class="nowrap-label"><i class="fas fa-calendar icono-label"></i> Fecha</label>
        <input type="text" name="fecha" id="fecha" class="form-control datepicker-cita" required autocomplete="off">
      </div>
      <div class="form-group group-masiva" style="display:none;">
        <label for="fecha_inicio" class="nowrap-label"><i class="fas fa-calendar icono-label"></i> Fecha de Inicio</label>
        <input type="text" name="fecha_inicio" id="fecha_inicio" class="form-control datepicker-cita" autocomplete="off">
      </div>
      <div class="form-group group-masiva" style="display:none;">
        <label for="fecha_fin" class="nowrap-label"><i class="fas fa-calendar icono-label"></i> Fecha de Fin</label>
        <input type="text" name="fecha_fin" id="fecha_fin" class="form-control datepicker-cita" autocomplete="off">
      </div>
      <div class="form-group group-masiva" style="display:none;">
        <label for="frecuencia" class="nowrap-label"><i class="fas fa-redo icono-label"></i> Frecuencia</label>
        <select name="frecuencia" id="frecuencia" class="form-control">
          <option value="diaria">Diaria</option>
          <option value="semanal">Semanal</option>
          <option value="mensual">Mensual</option>
        </select>
      </div>
      <div class="form-group">
        <label for="actividad_id" class="nowrap-label"><i class="fas fa-dumbbell icono-label"></i> Actividad</label>
        <input type="number" name="actividad_id" id="actividad_id" class="form-control" required>
      </div>
      <div class="form-group">
        <label for="hueco" class="nowrap-label"><i class="fas fa-clock icono-label"></i> Hueco</label>
        <select name="hueco" id="hueco" class="form-control" required>
          <option value="">Seleccione un hueco</option>
        </select>
      </div>
      <div class="form-group">
        <label for="aforo" class="nowrap-label"><i class="fas fa-users icono-label"></i> Aforo</label>
        <input type="number" name="aforo" id="aforo" class="form-control" required>
      </div>
      <div class="form-group">
        <label for="hora_inicio" class="nowrap-label"><i class="fas fa-clock icono-label"></i> Hora de Inicio</label>
        <input type="time" name="hora_inicio" id="hora_inicio" class="form-control" required>
      </div>
      <div class="form-group">
        <label for="duracion" class="nowrap-label"><i class="fas fa-hourglass-half icono-label"></i> Duración (minutos)</label>
        <input type="number" name="duracion" id="duracion" class="form-control" required>
      </div>
      <div id="frecuenciaIndividualGroup" class="form-group group-individual">
        <label for="frecuencia_individual" class="nowrap-label"><i class="fas fa-redo icono-label"></i> Frecuencia</label>
        <select name="frecuencia_individual" id="frecuencia_individual" class="form-control" required>
          <option value="una_vez">Una vez</option>
          <option value="cada_semana">Cada semana</option>
          <option value="cada_mes">Cada mes</option>
        </select>
      </div>
    </div>
    <div class="form-group text-right mt-3">
      <button type="submit" class="btn btn-success btn-accion-modal">
        <i class="fas fa-check"></i> Crear Cita(s)
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
.form-group-checkbox {
  grid-column: 1 / -1;
  width: 100%;
  margin-bottom: 4px;
  display: flex;
  align-items: center;
  font-size: 1rem;
}
.form-group-checkbox label {
  display: flex;
  align-items: center;
  font-size: 1rem;
  font-weight: 500;
  white-space: normal;
}
.form-group-checkbox input[type="checkbox"] {
  margin-right: 8px;
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
  margin-bottom: 0;
  gap: 10px;
  white-space: nowrap;
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

@push('scripts')
<script>
  $(document).ready(function(){
    $('#masiva').on('change', function(){
      if ($(this).is(':checked')) {
        // Mostrar campos masivos, ocultar individuales
        $('.group-individual').hide();
        $('.group-masiva').show();
        $('#fecha').removeAttr('required');
        $('#fecha_inicio, #fecha_fin, #frecuencia').attr('required', 'required');
      } else {
        $('.group-individual').show();
        $('.group-masiva').hide();
        $('#fecha').attr('required', 'required');
        $('#fecha_inicio, #fecha_fin, #frecuencia').removeAttr('required');
      }
    });
  });
</script>
@endpush