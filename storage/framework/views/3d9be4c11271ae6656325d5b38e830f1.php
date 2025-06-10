
<?php $__env->startSection('title', 'Pago Exitoso'); ?>
<?php $__env->startSection('content'); ?>
<div class="container py-5 text-center">
    <h1 class="text-success"><i class="fas fa-check-circle"></i> ¡Pago realizado con éxito!</h1>
    <p>Gracias por tu compra. En breve recibirás un email con tu factura.</p>
    <a href="/cliente/reservas" class="btn btn-primary mt-4">Ir a mis reservas</a>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/carrito/success.blade.php ENDPATH**/ ?>