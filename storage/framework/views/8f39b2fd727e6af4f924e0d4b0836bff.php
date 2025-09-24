

<?php $__env->startSection('title', 'Historial de compras'); ?>

<?php $__env->startSection('content'); ?>
<main class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3 sidebar" style="background-color: #F4F4F4; min-height: calc(100vh - 140px); padding: 20px;">
            <div class="title" style="font-size: 24px; color:  #000000; margin-bottom: 30px; display: flex; align-items: center;">
                <i class="fas fa-user" style="margin-right: 10px; font-size: 28px; color:  #000000;"></i> Cliente
            </div>
            <div class="menu">
                <a href="<?php echo e(route('cliente.reservas.index')); ?>" style="display: block; background-color: rgb(254,171,3); color: #fff; padding: 10px 15px; margin-bottom: 10px; border: 1px solid #fff; border-radius: 5px; text-decoration: none;">Mis Citas Reservadas</a>
                <a href="<?php echo e(route('pedidos.historial')); ?>" style="display: block; background-color: rgb(254,171,3); color: #fff; padding: 10px 15px; margin-bottom: 10px; border: 1px solid #fff; border-radius: 5px; text-decoration: none;">Mis Compras</a>
            </div>
        </div>
        <!-- Panel de Contenido -->
        <div class="col-md-9">
            <div class="container mt-4">
                <div class="d-flex align-items-center">
                    <h1 class="mb-0"><i class="fa-solid fa-shopping-bag"></i> Historial de compras</h1>
                </div>
                <?php if($pedidos->isEmpty()): ?>
                    <div class="alert alert-info">Aún no has realizado ninguna compra.</div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="thead-dark">
                                <tr>
                                    <th># Pedido</th>
                                    <th>Fecha</th>
                                    <th>Total</th>
                                    <th>Estado</th>
                                    <th>Factura</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $pedidos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pedido): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($pedido->id); ?></td>
                                        <td><?php echo e($pedido->created_at->format('d/m/Y H:i')); ?></td>
                                        <td><?php echo e(number_format($pedido->total, 2)); ?> €</td>
                                        <td><?php echo e(ucfirst($pedido->status)); ?></td>
                                        <td>
                                            <?php if($pedido->factura_pdf): ?>
                                                <a href="<?php echo e(asset('storage/' . $pedido->factura_pdf)); ?>" target="_blank" class="btn-custom-editar">
                                                    <i class="fas fa-file-invoice"></i> Ver factura
                                                </a>
                                            <?php else: ?>
                                                <span class="text-muted">No disponible</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
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

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\bodyquick\resources\views/pedidos/historial.blade.php ENDPATH**/ ?>