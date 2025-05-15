<div class="modal-header">
  <h5 class="modal-title" id="modalAccionLabel">Crear Cita</h5>
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

  <form action="{{ route('admin.citas.almacenar') }}" method="POST" id="formCrearCita">
    @csrf

    <!-- Checkbox para crear citas de forma masiva -->
    <div class="form-group">
      <label>
        <input type="checkbox" id="masiva" name="masiva" value="1"> Crear de forma masiva
      </label>
    </div>

    <!-- Campos para creación individual -->
    <div id="individualFields">
      <div class="form-group">
        <label for="fecha">Fecha</label>
        <input type="text" name="fecha" id="fecha" class="form-control datepicker-cita" required autocomplete="off">
      </div>
    </div>

    <!-- Campos para creación masiva (ocultos por defecto) -->
    <div id="masivaFields" style="display: none;">
      <div class="form-group">
        <label for="fecha_inicio">Fecha de Inicio</label>
        <input type="text" name="fecha_inicio" id="fecha_inicio" class="form-control datepicker-cita" autocomplete="off">
      </div>
      <div class="form-group">
        <label for="fecha_fin">Fecha de Fin</label>
        <input type="text" name="fecha_fin" id="fecha_fin" class="form-control datepicker-cita" autocomplete="off">
      </div>
      <div class="form-group">
        <label for="frecuencia">Frecuencia</label>
        <select name="frecuencia" id="frecuencia" class="form-control">
          <option value="diaria">Diaria</option>
          <option value="semanal">Semanal</option>
          <option value="mensual">Mensual</option>
        </select>
      </div>
    </div>

    <!-- Campos comunes -->
     <div class="form-group">
      <label for="actividad_id">ID de la Actividad</label>
      <input type="number" name="actividad_id" id="actividad_id" class="form-control" required>
    </div>
    <div class="form-group">
      <label for="hueco">Hueco</label>
      <select name="hueco" id="hueco" class="form-control" required>
        <option value="">Seleccione un hueco</option>
      </select>
    </div>
    <div class="form-group">
      <label for="aforo">Aforo</label>
      <input type="number" name="aforo" id="aforo" class="form-control" required>
    </div>
    <div class="form-group">
      <label for="hora_inicio">Hora de Inicio</label>
      <input type="time" name="hora_inicio" id="hora_inicio" class="form-control" required>
    </div>
    <div class="form-group">
      <label for="duracion">Duración (minutos)</label>
      <input type="number" name="duracion" id="duracion" class="form-control" required>
    </div>
    <!-- Para la cita individual usamos este campo para frecuencia -->
    <div id="frecuenciaIndividualGroup" class="form-group">
      <label for="frecuencia_individual">Frecuencia</label>
      <select name="frecuencia_individual" id="frecuencia_individual" class="form-control" required>
        <option value="una_vez">Una vez</option>
        <option value="cada_semana">Cada semana</option>
        <option value="cada_mes">Cada mes</option>
      </select>
    </div>
    <div class="form-group">
      <button type="submit" class="btn btn-success">
            <i class="fas fa-check"></i> Crear Cita(s)
    </div>
  </form>
</div>

@push('scripts')
<script>
  $(document).ready(function(){
    $('#masiva').on('change', function(){
      if ($(this).is(':checked')) {
        // Modo masivo: mostrar campos para rango de fechas y frecuencia, ocultar campo individual
        $('#masivaFields').show();
        $('#individualFields, #frecuenciaIndividualGroup').hide();
        $('#fecha').removeAttr('required');
        $('#fecha_inicio, #fecha_fin, #frecuencia').attr('required', 'required');
      } else {
        // Modo individual
        $('#individualFields, #frecuenciaIndividualGroup').show();
        $('#masivaFields').hide();
        $('#fecha').attr('required', 'required');
        $('#fecha_inicio, #fecha_fin, #frecuencia').removeAttr('required');
      }
    });
  });
</script>
@endpush