<tbody id="carrito-contenido">
<?php $total = 0; ?>
<?php $__currentLoopData = $carrito; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php
        $subtotal = $item->precio_unitario * $item->cantidad;
        $iva = $item->iva * $item->cantidad / 100 * $item->precio_unitario;
        $total += $subtotal + $iva;
    ?>
    <tr>
        <td><?php echo e($item->producto->nombre); ?></td>
        <td><?php echo e(number_format($item->precio_unitario, 2)); ?> €</td>
        <td>
            <input type="number" class="input-cantidad-carrito" data-carrito-id="<?php echo e($item->id); ?>" value="<?php echo e($item->cantidad); ?>" min="1" style="width:60px;">
        </td>
        <td><?php echo e($item->iva ?? 21); ?> %</td>
        <td><?php echo e(number_format($subtotal + $iva, 2)); ?> €</td>
        <td>
            <button type="button" class="btn btn-sm btn-danger btn-eliminar-carrito" data-carrito-id="<?php echo e($item->id); ?>" data-nombre="<?php echo e($item->producto->nombre); ?>">Eliminar</button>
        </td>
    </tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</tbody>
<?php /**PATH /var/www/html/resources/views/carrito/_tbody.blade.php ENDPATH**/ ?>