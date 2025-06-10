<tfoot id="carrito-tfoot">
<?php $total = 0; ?>
<?php $__currentLoopData = $carrito; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php
        $subtotal = $item->precio_unitario * $item->cantidad;
        $iva = $item->iva * $item->cantidad / 100 * $item->precio_unitario;
        $total += $subtotal + $iva;
    ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<tr>
    <th colspan="4" class="text-right">Total:</th>
    <th colspan="2"><?php echo e(number_format($total, 2)); ?> €</th>
</tr>
</tfoot>
<?php /**PATH /var/www/html/resources/views/carrito/_tfoot.blade.php ENDPATH**/ ?>