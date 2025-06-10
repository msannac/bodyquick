<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Factura #<?php echo e($order->id); ?></title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 14px; }
        .header { text-align: center; margin-bottom: 30px; }
        .datos { margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background: #f4f4f4; }
        .total { text-align: right; font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Bodyquick</h2>
        <h4>Factura #<?php echo e($order->id); ?></h4>
    </div>
    <div class="datos">
        <strong>Cliente:</strong> <?php echo e($user->name); ?><br>
        <strong>Email:</strong> <?php echo e($user->email); ?><br>
        <strong>Fecha:</strong> <?php echo e($order->created_at->format('d/m/Y H:i')); ?>

    </div>
    <table>
        <thead>
            <tr>
                <th>Producto</th>
                <th>Precio unitario</th>
                <th>Cantidad</th>
                <th>IVA</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($item->nombre); ?></td>
                <td><?php echo e(number_format($item->precio_unitario, 2)); ?> €</td>
                <td><?php echo e($item->cantidad); ?></td>
                <td><?php echo e($item->iva); ?> %</td>
                <td><?php echo e(number_format($item->subtotal, 2)); ?> €</td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
    <div class="total">
        Total: <?php echo e(number_format($order->total, 2)); ?> €
    </div>
</body>
</html>
<?php /**PATH /var/www/html/resources/views/factura.blade.php ENDPATH**/ ?>