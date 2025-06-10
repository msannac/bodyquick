<?php $__currentLoopData = $clientes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cliente): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<tr>
    <td><?php echo e($cliente->name); ?></td>
    <td><?php echo e($cliente->apellidos); ?></td>
    <td><?php echo e($cliente->email); ?></td>
    <td><?php echo e($cliente->dni); ?></td>
    <td><?php echo e($cliente->telefono); ?></td>
    <td>
        <div class="btn-group-acciones">
            <a href="<?php echo e(route('admin.clientes.editar', $cliente)); ?>" class="btn-custom-editar abrirModal" data-url="<?php echo e(route('admin.clientes.editar', $cliente)); ?>">
                <i class="fas fa-edit"></i> Editar
            </a>
            <form method="POST" action="<?php echo e(route('admin.clientes.eliminar', $cliente)); ?>" style="display:inline;">
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
<?php /**PATH /var/www/html/resources/views/Admin/Clientes/partials/tbody.blade.php ENDPATH**/ ?>