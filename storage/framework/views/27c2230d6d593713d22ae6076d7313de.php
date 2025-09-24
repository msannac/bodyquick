

<?php $__env->startSection('title','Panel de Control - Listado de Actividades'); ?>

<?php $__env->startSection('content'); ?>
  <!-- Contenedor principal -->
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
      <!-- Panel de Contenido -->
      <div class="col-12 col-md-10">
        <div class="container mt-4">
          <div class="d-flex align-items-center">
            <h1 class="mb-0"><i class="fa-solid fa-list"></i> Listado de Actividades</h1>
            <!-- Botón Crear -->
            <a href="<?php echo e(route('admin.actividades.crear')); ?>" 
               class="btn btn-success ml-3 inline-button abrirModal" 
               data-url="<?php echo e(route('admin.actividades.crear')); ?>">
              <i class="fas fa-plus"></i>
            </a>
          </div>
          <?php if(session('status')): ?>
            <div class="alert alert-success"><?php echo e(session('status')); ?></div>
          <?php endif; ?>
          <div class="table-responsive mt-4">
            <table class="table table-bordered table-striped">
              <thead class="thead-dark">
                <tr>
                  <th>Nombre</th>
                  <th>Descripción</th>
                  <th>Activo</th>
                  <th>Acciones</th>
                </tr>
              </thead>
              <tbody>
                <?php $__currentLoopData = $actividades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $actividad): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <tr>
                    <td><?php echo e($actividad->nombre); ?></td>
                    <td><?php echo e($actividad->descripcion); ?></td>
                    <td><?php echo e($actividad->activo ? 'Sí' : 'No'); ?></td>
                    <td>
                      <div class="btn-group-acciones d-flex align-items-center" style="gap: 10px;">
                        <a href="<?php echo e(route('admin.actividades.editar', $actividad)); ?>" 
                           class="btn-custom-editar abrirModal" 
                           data-url="<?php echo e(route('admin.actividades.editar', $actividad)); ?>">
                          <i class="fas fa-edit"></i> Editar
                        </a>
                        <form method="POST" action="<?php echo e(route('admin.actividades.eliminar', $actividad)); ?>" style="display:inline; margin: 0;">
                          <?php echo csrf_field(); ?>
                          <?php echo method_field('DELETE'); ?>
                          <button type="button" class="btn-custom-eliminar btn-eliminar">
                            <i class="fas fa-trash-alt"></i> Eliminar
                          </button>
                        </form>
                      </div>
                    </td>
                  </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php $__env->stopSection(); ?>


<style>
  .inline-button {
    background-color: #00a65a !important;
    border: 1px solid #00a65a !important;
    color: #fff !important;
    padding: 10px 15px;
    font-size: 24px;
    border-radius: 50%;
    box-shadow: 0 2px 5px rgba(0,0,0,0.3);
    transform: translateY(-5%);
  }
  @media (max-width: 992px) {
    .inline-button {
      font-size: 20px;
      padding: 8px 12px;
      transform: translateY(0);
    }
  }
  @media (max-width: 768px) {
    .inline-button {
      font-size: 16px;
      padding: 6px 10px;
      position: fixed;
      bottom: 20px;
      right: 20px;
      z-index: 1000;
      transform: none;
    }
  }
  .btn-custom-editar {
    background-color: #ffffff;
    color: #00a65a;
    border: 1px solid #00a65a;
    padding: 5px 10px;
    border-radius: 5px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    line-height: 1;
  }
  .btn-custom-eliminar {
    background-color: #ffffff;
    color: #d11149;
    border: 1px solid #d11149;
    padding: 5px 10px;
    border-radius: 5px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    line-height: 1;
  }
  .btn-group-acciones {
    display: flex;
    align-items: center;
  }
  .btn-group-acciones > *:not(:last-child) {
    margin-right: 10px;
  }
</style>



<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\bodyquick\resources\views/Admin/Actividades/index.blade.php ENDPATH**/ ?>