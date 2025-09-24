

<?php $__env->startSection('title', 'Mis Citas Reservadas'); ?>

<?php $__env->startSection('content'); ?>
<main class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-2 sidebar" style="background-color: #F4F4F4; min-height: 100vh; padding: 20px;">
        <div class="title" style="font-size: 24px; color: #000; margin-bottom: 30px; display: flex; align-items: center;">
                <i class="fas fa-user" style="margin-right: 10px; font-size: 28px; color:  #000000;"></i> Cliente
            </div>
            <div class="menu">
                <a href="<?php echo e(route('cliente.reservas.index')); ?>" style="display: block; background-color: rgb(254,171,3); color: #fff; padding: 10px 15px; margin-bottom: 10px; border: 1px solid #fff; border-radius: 5px; text-decoration: none;">Mis Citas Reservadas</a>
                <a href="<?php echo e(route('pedidos.historial')); ?>" style="display: block; background-color: rgb(254,171,3); color: #fff; padding: 10px 15px; margin-bottom: 10px; border: 1px solid #fff; border-radius: 5px; text-decoration: none;">Mis Compras</a>
            </div>
        </div>
        <!-- Panel de Contenido -->
        <div class="col-12 col-md-10">
            <div class="container mt-4">
                <div class="d-flex align-items-center">
                    <h1 class="mb-0"><i class="fa-solid fa-list"></i> Mis Citas Reservadas</h1>
                    <!-- Botón Crear -->
                    <a href="<?php echo e(route('cliente.reservas.nueva')); ?>" 
                       class="btn btn-success ml-3 inline-button abrirModal" 
                       data-url="<?php echo e(route('cliente.reservas.nueva')); ?>">
                      <i class="fas fa-plus"></i>
                    </a>
                </div>
                <?php if(session('status')): ?>
                    <div class="alert alert-success"><?php echo e(session('status')); ?></div>
                <?php endif; ?>
                <?php if(session('error')): ?>
                    <div class="alert alert-danger"><?php echo e(session('error')); ?></div>
                <?php endif; ?>

                <table class="table table-bordered table-striped">
                  <thead class="thead-dark">
                    <tr>
                      <th>Fecha</th>
                      <th>Hora</th>
                      <th>Actividad</th>
                      <th>Acciones</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $__currentLoopData = $reservas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reserva): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                      <td><?php echo e($reserva->cita->fecha); ?></td>
                      <td><?php echo e($reserva->cita->hora_inicio); ?></td>
                      <td><?php echo e($reserva->cita->actividad->nombre ?? 'Sin Actividad'); ?></td>
                      <td>
                        <div class="btn-group-acciones">
                          <a href="<?php echo e(route('cliente.reservas.editar', $reserva)); ?>" 
                             class="btn-custom-editar abrirModal" 
                             data-url="<?php echo e(route('cliente.reservas.editar', $reserva)); ?>">
                            <i class="fas fa-edit"></i> Editar
                          </a>
                          <form method="POST" action="<?php echo e(route('cliente.reservas.eliminar', $reserva)); ?>" style="display:inline;">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="button" class="btn-custom-eliminar btn-eliminar" data-toggle="modal" data-target="#confirmDeleteModal">
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
</main>
<?php $__env->stopSection(); ?>

<style>
  /* General */
  body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
   box-sizing: border-box;
  }

  /* Sidebar */
  .sidebar {
    background-color: #F4F4F4;
    padding: 20px;
    min-height: calc(100vh - 140px);
  }

  .sidebar .menu a {
    display: block;
    background-color: rgb(254,171,3);
    color: #fff;
    padding: 10px 15px;
    margin-bottom: 10px;
    border: 1px solid #fff;
    border-radius: 5px;
    text-decoration: none;
    text-align: center;
  }

  /* Content Panel */
  .container {
    padding: 15px;
  }

  .table {
    width: 100%;
    border-collapse: collapse;
  }

  .table th, .table td {
    padding: 10px;
    text-align: left;
  }

  .table th {
    background-color: #333;
    color: #fff;
  }

  /* Buttons */
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

  .btn-custom-editar, .btn-custom-eliminar {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 10px 15px;
    font-size: 14px;
    border-radius: 5px;
    border: 1px solid;
    width: 120px;
    height: 40px;
    text-align: center;
    line-height: 1.2;
  }

  .btn-custom-editar {
    color: #00a65a;
    border-color: #00a65a;
    background-color: #ffffff;
  }

  .btn-custom-eliminar {
    color: #d11149;
    border-color: #d11149;
    background-color: #ffffff;
  }

  .btn-group-acciones {
    display: flex;
    gap: 10px;
  }

  /* Responsive Design */
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

    .sidebar {
      display: none;
    }

    .container {
      padding: 10px;
    }

    .table th, .table td {
      font-size: 12px;
      padding: 5px;
    }
  }
</style>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\bodyquick\resources\views/Cliente/Reservas/index.blade.php ENDPATH**/ ?>