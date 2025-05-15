<div class="modal-header">
  <h5 class="modal-title" id="modalAccionLabel">Editar Cita</h5>
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

  <form action="{{ route('admin.citas.actualizar', $cita) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="form-group">
      <label for="actividad_id">ID de la Actividad</label>
      <input type="number" name="actividad_id" id="actividad_id" class="form-control" value="{{ $cita->actividad_id }}" required>
    </div>
    <div class="form-group">
      <label for="fecha">Fecha</label>
      <div class="input-group">
        <input type="text" name="fecha" id="fecha" class="form-control datepicker-cita" value="{{ $cita->fecha }}" required autocomplete="off">
        <div class="input-group-append">
          <span class="input-group-text" id="calendar-icon"><i class="fa fa-calendar"></i></span>
        </div>
      </div>
    </div>
    <div class="form-group">
      <label for="hueco">Hueco</label>
      <select name="hueco" id="hueco" class="form-control" required>
        <option value="">Seleccione un hueco</option>
        @if($cita->hueco)
          <option value="{{ $cita->hueco }}" selected>{{ $cita->hueco }}</option>
        @endif
      </select>
    </div>
    <div class="form-group">
      <label for="aforo">Aforo</label>
      <input type="number" name="aforo" id="aforo" class="form-control" value="{{ $cita->aforo }}" required>
    </div>
    <div class="form-group">
      <label for="hora_inicio">Hora de Inicio</label>
      <input type="time" name="hora_inicio" id="hora_inicio" class="form-control" value="{{ $cita->hora_inicio }}" required>
    </div>
    <div class="form-group">
      <label for="duracion">Duración (minutos)</label>
      <input type="number" name="duracion" id="duracion" class="form-control" value="{{ $cita->duracion }}" required>
    </div>
    <div class="form-group">
      <label for="frecuencia">Frecuencia</label>
      <select name="frecuencia" id="frecuencia" class="form-control" required>
        <option value="una_vez" {{ $cita->frecuencia == 'una_vez' ? 'selected' : '' }}>Una vez</option>
        <option value="cada_semana" {{ $cita->frecuencia == 'cada_semana' ? 'selected' : '' }}>Cada semana</option>
        <option value="cada_mes" {{ $cita->frecuencia == 'cada_mes' ? 'selected' : '' }}>Cada mes</option>
      </select>
    </div>
    <div class="form-group">
      <button type="submit" class="btn btn-success">
            <i class="fas fa-check"></i> Actualizar Cita
    </div>
  </form>
</div>

