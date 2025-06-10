<!-- Modal para creación masiva de citas -->
<div class="modal fade" id="modalCrearCitaMasiva" tabindex="-1" role="dialog" aria-labelledby="modalCrearCitaMasivaLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document" style="max-width:800px; width: 100%;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalCrearCitaMasivaLabel">
          <i class="fas fa-calendar-plus text-success"></i> Crear Citas de Forma Masiva
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <?php if($errors->any()): ?>
          <div class="alert alert-danger">
            <ul>
              <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><?php echo e($error); ?></li>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
          </div>
        <?php endif; ?>
        <form action="<?php echo e(route('admin.citas.almacenarMasiva')); ?>" method="POST" id="formCrearCitaMasiva">
          <?php echo csrf_field(); ?>
          <div class="form-grid-2cols">
            <div class="form-group">
              <label for="actividad_id_masiva" class="nowrap-label"><i class="fas fa-dumbbell icono-label"></i> Actividad</label>
              <select name="actividad_id" id="actividad_id_masiva" class="form-control" required>
                <option value="">Seleccione una actividad</option>
                <?php $__currentLoopData = $actividades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $actividad): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <option value="<?php echo e($actividad->id); ?>"><?php echo e($actividad->nombre); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </select>
            </div>
            <div class="form-group">
              <label for="aforo_masiva" class="nowrap-label"><i class="fas fa-users icono-label"></i> Aforo</label>
              <input type="number" name="aforo" id="aforo_masiva" class="form-control" required>
            </div>
            <div class="form-group">
              <label for="duracion_masiva" class="nowrap-label"><i class="fas fa-hourglass-half icono-label"></i> Duración (minutos)</label>
              <input type="number" name="duracion" id="duracion_masiva" class="form-control" required>
            </div>
            <div class="form-group">
              <label for="frecuencia_masiva" class="nowrap-label"><i class="fas fa-redo icono-label"></i> Frecuencia</label>
              <select name="frecuencia" id="frecuencia_masiva" class="form-control" required>
                <option value="una_vez">Una vez</option>
                <option value="cada_semana">Cada semana</option>
                <option value="cada_mes">Cada mes</option>
              </select>
            </div>
            <div class="form-group">
              <label for="fecha_inicio_masiva" class="nowrap-label"><i class="fas fa-calendar icono-label"></i> Fecha de Inicio</label>
              <input type="text" name="fecha_inicio" id="fecha_inicio_masiva" class="form-control datepicker-cita" autocomplete="off" required>
            </div>
            <div class="form-group">
              <label for="fecha_fin_masiva" class="nowrap-label"><i class="fas fa-calendar icono-label"></i> Fecha de Fin</label>
              <input type="text" name="fecha_fin" id="fecha_fin_masiva" class="form-control datepicker-cita" autocomplete="off" required>
            </div>
          </div>
          <div class="form-group text-right mt-3">
            <button type="submit" class="btn btn-success btn-accion-modal">
              <i class="fas fa-check"></i> Crear Citas Masivas
            </button>
          </div>
        </form>
        <div id="estimacion-citas-masiva" class="text-info mt-2"></div>
        <div id="advertencia-citas-masiva" class="alert alert-warning mt-2" style="display:none;">
            ¡Atención! Vas a crear un número muy alto de citas. Esto puede tardar varios segundos y afectar el rendimiento. ¿Estás seguro?
        </div>
      </div>
    </div>
  </div>
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

<?php $__env->startPush('scripts'); ?>
<script>
  $(document).ready(function(){
    // Inicializar datepicker solo para los campos de este modal
    $('#fecha_inicio_masiva, #fecha_fin_masiva').datepicker({
      format: 'yyyy-mm-dd',
      autoclose: true,
      todayHighlight: true,
      language: 'es'
    });
    // Al abrir el modal, limpiar y estimar
    $('#modalCrearCitaMasiva').on('shown.bs.modal', function(){
      $('#formCrearCitaMasiva')[0].reset();
      $('#estimacion-citas-masiva').text('');
      $('#advertencia-citas-masiva').hide();
      $('#fecha_inicio_masiva, #fecha_fin_masiva').datepicker('update', '');
      setTimeout(function(){ $('#actividad_id_masiva').focus(); }, 300);
      estimarCitasMasiva();
    });
    // Al cerrar el modal, limpiar
    $('#modalCrearCitaMasiva').on('hidden.bs.modal', function(){
      $('#formCrearCitaMasiva')[0].reset();
      $('#estimacion-citas-masiva').text('');
      $('#advertencia-citas-masiva').hide();
    });
    // Mostrar loader al enviar el formulario
    var $loaderCitasMasiva = $('<div id="loader-citas-masiva" class="text-center my-3"><div class="spinner-border text-success" role="status"><span class="sr-only">Cargando...</span></div><div class="mt-2">Creando citas, por favor espera...</div></div>');
    // Mensaje de éxito tras crear citas masivas
    var $mensajeExitoCitasMasiva = $('<div id="mensaje-exito-citas-masiva" class="alert alert-success text-center mt-3" style="display:none;"></div>');
    if($('#mensaje-exito-citas-masiva').length === 0) {
      $('#formCrearCitaMasiva').after($mensajeExitoCitasMasiva);
    }
    $('#formCrearCitaMasiva').on('submit', function(e){
      e.preventDefault();
      var form = this;
      var data = $(form).serialize();
      // Mostrar loader
      $(form).find('.alert-danger').remove();
      $('#mensaje-exito-citas-masiva').hide();
      if($('#loader-citas-masiva').length === 0) {
        $(form).after($loaderCitasMasiva);
      }
      $.ajax({
        url: $(form).attr('action'),
        method: 'POST',
        data: data,
        dataType: 'json',
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
      })
      .done(function(resp){
        $('#modalCrearCitaMasiva').modal('hide');
        // Limpiar el formulario tras submit exitoso
        $('#formCrearCitaMasiva')[0].reset();
        $('#estimacion-citas-masiva').text('');
        $('#advertencia-citas-masiva').hide();
        $('#loader-citas-masiva').remove();
        // Mostrar mensaje de éxito
        if(resp && resp.mensaje) {
          $('#mensaje-exito-citas-masiva').text(resp.mensaje).fadeIn().delay(3500).fadeOut();
        }
        // Si tienes una función para refrescar la tabla/lista de citas, llama aquí
        if(typeof window.refrescarListadoCitas === 'function') window.refrescarListadoCitas();
      })
      .fail(function(xhr){
        $('#loader-citas-masiva').remove();
        // Manejo robusto de errores
        let errores = {};
        let mensaje = 'Error inesperado.';
        if(xhr.responseJSON && xhr.responseJSON.errors) {
          errores = xhr.responseJSON.errors;
        } else if(xhr.responseJSON && xhr.responseJSON.error) {
          mensaje = xhr.responseJSON.error;
        } else if(xhr.responseText) {
          mensaje = xhr.responseText;
        }
        let html = '<div class="alert alert-danger"><ul>';
        if(Object.keys(errores).length > 0) {
          for(let campo in errores){
            html += '<li>' + errores[campo][0] + '</li>';
          }
        } else {
          html += '<li>' + mensaje + '</li>';
        }
        html += '</ul></div>';
        $(form).find('.alert-danger').remove();
        $(form).prepend(html);
      });
      return false; // Refuerzo para evitar cualquier submit por GET
    });
    function estimarCitasMasiva() {
      let fechaInicio = $('#fecha_inicio_masiva').val();
      let fechaFin = $('#fecha_fin_masiva').val();
      let duracion = parseInt($('#duracion_masiva').val());
      let frecuencia = $('#frecuencia_masiva').val();
      if (!fechaInicio || !fechaFin || !duracion || !frecuencia) {
        $('#estimacion-citas-masiva').text('');
        return;
      }
      let start = new Date(fechaInicio);
      let end = new Date(fechaFin);
      let total = 0;
      let incremento = { 'una_vez': 1, 'cada_semana': 7, 'cada_mes': 30 }[frecuencia] || 1;
      for (let d = new Date(start); d <= end; d.setDate(d.getDate() + incremento)) {
        let horarios = [
          {inicio: '07:00', fin: '13:00'},
          {inicio: '17:00', fin: '21:00'}
        ];
        for (let i = 0; i < horarios.length; i++) {
          var partesInicio = horarios[i].inicio.split(':');
          var partesFin = horarios[i].fin.split(':');
          var inicio = new Date(d);
          inicio.setHours(parseInt(partesInicio[0]), parseInt(partesInicio[1]), 0, 0);
          var fin = new Date(d);
          fin.setHours(parseInt(partesFin[0]), parseInt(partesFin[1]), 0, 0);
          for (let t = new Date(inicio); t < fin; t.setMinutes(t.getMinutes() + duracion)) {
            total++;
          }
        }
      }
      $('#estimacion-citas-masiva').text('Se crearán aproximadamente ' + total + ' citas.');
      if(total > 100) {
        $('#advertencia-citas-masiva').show();
      } else {
        $('#advertencia-citas-masiva').hide();
      }
    }
    // Recalcular estimación al cambiar campos
    $('#fecha_inicio_masiva, #fecha_fin_masiva, #duracion_masiva, #frecuencia_masiva').on('change keyup', estimarCitasMasiva);
  });
</script>
<?php $__env->stopPush(); ?><?php /**PATH /var/www/html/resources/views/Admin/Citas/crear_masiva.blade.php ENDPATH**/ ?>