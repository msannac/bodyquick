

<?php $__env->startSection('title', 'Dashboard Admin'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
  <div class="row">
    <!-- Sidebar -->
    <div class="col-md-2 sidebar" style="background-color: #F4F4F4; min-height: 100vh; padding: 20px;">
      <div class="title" style="font-size: 24px; color: #000; margin-bottom: 30px; display: flex; align-items: center;">
        <i class="fas fa-user-shield" style="margin-right: 10px; font-size: 28px;"></i> Administrador
      </div>
      <div class="menu">
        <a href="<?php echo e(route('admin.dashboard')); ?>" style="display: block; padding: 10px 15px; margin-bottom: 10px; background-color: rgb(254,171,3); color: #fff; text-decoration: none; border-radius: 5px;">
          Home
        </a>
        <a href="<?php echo e(route('admin.estadisticas')); ?>" style="display: block; padding: 10px 15px; margin-bottom: 10px; background-color: rgb(254,171,3); color: #fff; text-decoration: none; border-radius: 5px;">
          Estadísticas
        </a>
        <a href="<?php echo e(route('admin.actividades.listar')); ?>" style="display: block; padding: 10px 15px; margin-bottom: 10px; background-color: rgb(254,171,3); color: #fff; text-decoration: none; border-radius: 5px;">
          Listar Actividades
        </a>
        <a href="<?php echo e(route('admin.clientes.listar')); ?>" style="display: block; padding: 10px 15px; margin-bottom: 10px; background-color: rgb(254,171,3); color: #fff; text-decoration: none; border-radius: 5px;">
          Listar Clientes
        </a>
        <a href="<?php echo e(route('admin.citas.listar')); ?>" style="display: block; padding: 10px 15px; margin-bottom: 10px; background-color: rgb(254,171,3); color: #fff; text-decoration: none; border-radius: 5px;">
          Listar Citas
        </a>
        <a href="<?php echo e(route('admin.entrenadores.listar')); ?>" style="display: block; padding: 10px 15px; margin-bottom: 10px; background-color: rgb(254,171,3); color: #fff; text-decoration: none; border-radius: 5px;">
          Listar Entrenadores
        </a>
        </a>
        <a href="<?php echo e(route('admin.reservas.listar')); ?>" style="display: block; padding: 10px 15px; margin-bottom: 10px; background-color: rgb(254,171,3); color: #fff; text-decoration: none; border-radius: 5px;">
          Listar Reservas
        </a>
        <a href="<?php echo e(route('admin.productos.listar')); ?>" style="display: block; padding: 10px 15px; margin-bottom: 10px; background-color: rgb(254,171,3); color: #fff; text-decoration: none; border-radius: 5px;">
          Listar Productos
        </a>
      </div>
    </div>

    <!-- Contenido principal: Google Calendar -->
    <div class="col-md-10">
      <div class="container mt-4">
        <h2>Calendario</h2>
        <!-- Calendario de Google incrustado -->
        <iframe id="iframeGoogleCalendar" src="https://calendar.google.com/calendar/embed?src=manueldesandenacarino%40gmail.com&ctz=Europe%2FMadrid" style="border: 0" width="100%" height="800" frameborder="0" scrolling="no"></iframe>
      </div>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
// Recargar el iframe de Google Calendar tras operaciones AJAX exitosas de reservas
(function(){
  // Escuchar evento global tras recarga AJAX de reservas
  document.addEventListener('reservas:actualizadas', function() {
    var iframe = document.getElementById('iframeGoogleCalendar');
    if (iframe) {
      // Forzar recarga del iframe
      var src = iframe.src;
      iframe.src = '';
      setTimeout(function(){ iframe.src = src; }, 100);
    }
  });

  // Hook automático para integración con el JS global de reservas
  if (window.jQuery) {
    $(document).ajaxSuccess(function(event, xhr, settings) {
      // Detectar si la petición AJAX es de reservas admin
      if (settings.url && settings.url.includes('/admin/reservas')) {
        document.dispatchEvent(new Event('reservas:actualizadas'));
      }
    });
  }
})();
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\bodyquick\resources\views/Admin/dashboardAdmin.blade.php ENDPATH**/ ?>