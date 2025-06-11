<div class="form-wrapper actividad-modal-wrapper">
  <div class="page-title">
    <i class="fa-regular fa-calendar-days icono-label"></i>
    <span>Nueva Cita</span>
  </div>
  <form action="{{ route('cliente.reservas.almacenar') }}" method="POST">
    @csrf
    <div class="form-grid-1col">
      <div class="form-group">
        <label for="actividad" class="nowrap-label"><i class="fas fa-dumbbell icono-label"></i> Actividad</label>
        <select name="actividad" id="actividad" class="form-control">
          <option value="">Seleccione una actividad</option>
          @foreach($actividades as $actividad)
            <option value="{{ $actividad->id }}">{{ $actividad->nombre }}</option>
          @endforeach
        </select>
      </div>
      <div class="form-group">
        <label for="fecha" class="nowrap-label"><i class="fa-regular fa-calendar-days icono-label"></i> Selecciona el día</label>
        <div class="input-group date" id="datepicker-container" style="margin-bottom:0;">
          <input type="text" name="fecha" id="fecha" class="form-control" placeholder="Seleccione un día" style="height:28px; padding:3px 6px; font-size:0.97rem;" autocomplete="off">
          <div class="input-group-append">
            <span class="input-group-text" style="padding:2px 8px; height:28px;">
              <i class="fa-regular fa-calendar-days"></i>
            </span>
          </div>
        </div>
      </div>
      <div class="form-group">
        <label for="hueco" class="nowrap-label"><i class="fas fa-clock icono-label"></i> Selecciona el hueco</label>
        <select name="cita_id" id="hueco" class="form-control">
          <option value="">Seleccione un hueco</option>
        </select>
      </div>
    </div>
    <div class="form-group text-right mt-1">
      <button type="submit" class="btn btn-success btn-accion-modal">
        <i class="fas fa-check"></i> Guardar Cambios
      </button>
    </div>
  </form>
  </form>
</div>
<style>
  .actividad-modal-wrapper {
    background: rgb(236, 236, 236);
    border-radius: 12px;
    box-shadow: none;
    max-width: 800px;
    width: 100%;
    min-width: 0;
    margin: 0 auto;
    box-sizing: border-box;
    padding: 32px 32px 32px 32px;
  }
  .form-grid-1col {
    display: grid;
    grid-template-columns: 1fr;
    gap: 18px;
    justify-items: center;
  }
  .form-group {
    margin-bottom: 12px;
    width: 100%;
    max-width: 520px;
    min-width: 220px;
  }
  @media (max-width: 991.98px) {
    .actividad-modal-wrapper {
      max-width: 98vw;
    }
    .form-grid-1col {
      grid-template-columns: 1fr;
      gap: 12px;
    }
  }
  @media (max-width: 600px) {
    .actividad-modal-wrapper {
      padding: 8px 4px 8px 4px;
    }
  }
  .page-title {
    display: flex;
    align-items: center;
    font-size: 1.1rem;
    font-weight: 600;
    margin-bottom: 12px;
    gap: 8px;
  }
  .icono-label {
    color: #27ae60;
    margin-right: 3px;
  }
  .btn-accion-modal {
    border-radius: 8px;
    min-width: 100px;
    padding-left: 0.7rem;
    padding-right: 0.7rem;
    font-size: 0.98rem;
  }
  .form-group label, .nowrap-label {
    font-weight: 500;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    font-size: 0.97rem;
    margin-bottom: 4px;
  }
  .form-group input, .form-group select, .form-group textarea {
    border-radius: 8px;
    border: 1px solid #ccc;
    width: 100%;
    box-sizing: border-box;
    min-width: 0;
    font-size: 0.97rem;
    padding: 8px 10px;
    height: 36px;
    max-width: 100%;
  }
</style>

