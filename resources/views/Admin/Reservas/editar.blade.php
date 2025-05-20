<div class="form-wrapper actividad-modal-wrapper">
  <div class="page-title">
    <i class="fa-solid fa-pen text-success" style="color:#28a745;"></i>
    <span>Editar Reserva</span>
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
  <form action="{{ route('admin.reservas.actualizar', $reserva) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="form-grid-2cols">
      <div class="form-group">
        <label for="user_id"><i class="fas fa-user icono-label"></i> Cliente</label>
        <select name="user_id" id="user_id" class="form-control" required>
          <option value="">Selecciona un cliente</option>
          @foreach($clientes as $cliente)
            @if(!$cliente->is_admin)
              <option value="{{ $cliente->id }}" @if($reserva->user_id == $cliente->id) selected @endif>{{ $cliente->name }}{{ $cliente->apellidos ? ' ' . $cliente->apellidos : '' }}</option>
            @endif
          @endforeach
        </select>
      </div>
      <div class="form-group">
        <label for="actividad"><i class="fas fa-dumbbell icono-label"></i> Actividad</label>
        <select name="actividad" id="actividad" class="form-control" required>
          <option value="">Selecciona una actividad</option>
          @foreach($actividades as $actividad)
            <option value="{{ $actividad->id }}" @if($citaActual && $citaActual->actividad_id == $actividad->id) selected @endif>{{ $actividad->nombre }}</option>
          @endforeach
        </select>
      </div>
      <div class="form-group">
        <label for="fecha"><i class="fa-regular fa-calendar-days icono-label"></i> Selecciona el día</label>
        <input type="text" name="fecha" id="fecha" class="form-control" placeholder="Seleccione un día" autocomplete="off" value="{{ $citaActual ? $citaActual->fecha : '' }}">
      </div>
      <div class="form-group">
        <label for="hueco"><i class="fas fa-clock icono-label"></i> Selecciona el hueco</label>
        <select name="cita_id" id="hueco" class="form-control" required>
          <option value="">Seleccione un hueco</option>
          @if($citaActual)
            <option value="{{ $citaActual->id }}" selected>{{ $citaActual->hora_inicio }} - {{ \Carbon\Carbon::parse($citaActual->hora_inicio)->addMinutes($citaActual->duracion)->format('H:i') }}</option>
          @endif
        </select>
      </div>
    </div>
    <div class="form-group text-right mt-2">
      <button type="submit" class="btn btn-success btn-accion-modal">
        <i class="fas fa-check"></i> Actualizar Reserva
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
</style>
