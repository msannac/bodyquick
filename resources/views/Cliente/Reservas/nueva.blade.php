<div class="form-wrapper">
  <div class="page-title">
    <i class="fa-regular fa-calendar-days"></i>
    <span>Nueva Cita</span>
  </div>
  <form action="{{ route('cliente.reservas.almacenar') }}" method="POST">
    @csrf
    <!-- Seleccionar actividad -->
    <div class="form-group">
      <label for="actividad">Actividad</label>
      <select name="actividad" id="actividad" class="form-control">
        <option value="">Seleccione una actividad</option>
        @foreach($actividades as $actividad)
          <option value="{{ $actividad->id }}">{{ $actividad->nombre }}</option>
        @endforeach
      </select>
    </div>
    <!-- Seleccionar día (se llenará por AJAX) -->
    <div class="form-group">
      <label for="fecha">Selecciona el día</label>
      <select name="fecha" id="fecha" class="form-control">
        <option value="">Seleccione un día</option>
      </select>
    </div>
    <!-- Seleccionar hueco (se llenará por AJAX) -->
    <div class="form-group">
      <label for="hueco">Selecciona el hueco</label>
      <select name="cita_id" id="hueco" class="form-control">
        <option value="">Seleccione un hueco</option>
      </select>
    </div>
    <!-- Botón -->
    <div class="d-flex">
      <button type="submit" class="btn btn-success">
            <i class="fas fa-check"></i> Guardar Cambios
      </button>
    </div>
  </form>
</div>

