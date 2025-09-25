<div class="form-wrapper actividad-modal-wrapper">
  <div class="d-flex align-items-start justify-content-between mb-2" style="gap: 0;">
    <div class="page-title mb-0" style="flex-shrink:0; white-space:nowrap;">
      <i class="fas fa-calendar-plus text-success"></i>
      <span>Crear Cita</span>
    </div>
  </div>
  <?php if($errors->any()): ?>
    <div class="alert alert-danger">
      <ul>
        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <li><?php echo e($error); ?></li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </ul>
    </div>
  <?php endif; ?>
  <form action="<?php echo e(route('admin.citas.almacenar')); ?>" method="POST" id="formCrearCita">
    <?php echo csrf_field(); ?>
    <div class="form-grid-2cols">
      <!-- INDIVIDUAL -->
      <div class="form-group">
        <label for="fecha" class="nowrap-label"><i class="fas fa-calendar icono-label"></i> Fecha</label>
        <input type="text" name="fecha" id="fecha" class="form-control datepicker-cita" required autocomplete="off">
      </div>
      <div class="form-group">
        <label for="hueco" class="nowrap-label"><i class="fas fa-clock icono-label"></i> Hueco</label>
        <select name="hueco" id="hueco" class="form-control" required>
          <option value="">Seleccione un hueco</option>
        </select>
      </div>
      <div class="form-group">
        <label for="hora_inicio" class="nowrap-label"><i class="fas fa-clock icono-label"></i> Hora de Inicio</label>
        <input type="time" name="hora_inicio" id="hora_inicio" class="form-control" required>
      </div>
      <div id="frecuenciaIndividualGroup" class="form-group">
        <label for="frecuencia_individual" class="nowrap-label"><i class="fas fa-redo icono-label"></i> Frecuencia</label>
        <select name="frecuencia_individual" id="frecuencia_individual" class="form-control" required>
          <option value="una_vez">Una vez</option>
          <option value="cada_semana">Cada semana</option>
          <option value="cada_mes">Cada mes</option>
        </select>
      </div>
      <!-- CAMPOS COMUNES -->
      <div class="form-group">
        <label for="actividad_id" class="nowrap-label"><i class="fas fa-dumbbell icono-label"></i> Actividad</label>
        <input type="number" name="actividad_id" id="actividad_id" class="form-control" required>
      </div>
      <div class="form-group">
        <label for="aforo" class="nowrap-label"><i class="fas fa-users icono-label"></i> Aforo</label>
        <input type="number" name="aforo" id="aforo" class="form-control" required>
      </div>
      <div class="form-group">
        <label for="duracion" class="nowrap-label"><i class="fas fa-hourglass-half icono-label"></i> Duración (minutos)</label>
        <input type="number" name="duracion" id="duracion" class="form-control" required>
      </div>
    </div>
    <div class="form-group text-right mt-3">
      <button type="submit" class="btn btn-success btn-accion-modal">
        <i class="fas fa-check"></i> Crear Cita
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

<script>
  $(document).ready(function(){
    // Inicializar datepickers para todos los campos de fecha
    $('.datepicker-cita').datepicker({
      format: 'yyyy-mm-dd',
      autoclose: true,
      todayHighlight: true,
      language: 'es'
    });
  });
</script><?php /**PATH C:\xampp\htdocs\bodyquick\resources\views/Admin/Citas/crear.blade.php ENDPATH**/ ?>