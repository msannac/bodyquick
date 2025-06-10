<?php $__currentLoopData = $citas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $loopIndex => $cita): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<tr data-index="<?php echo e($loopIndex); ?>">
    <td class="fecha-col"><?php echo e($cita->fecha); ?></td>
    <td class="hueco-col"><?php echo e($cita->hueco); ?></td>
    <td><?php echo e($cita->aforo); ?></td>
    <td><?php echo e($cita->hora_inicio); ?></td>
    <td><?php echo e($cita->duracion); ?></td>
    <td><?php echo e($cita->frecuencia); ?></td>
    <td><?php echo e($cita->actividad->nombre ?? 'N/A'); ?></td>
    <td>
        <div class="btn-group-acciones">
            <a href="<?php echo e(route('admin.citas.editar', $cita)); ?>" class="btn-custom-editar abrirModal" data-url="<?php echo e(route('admin.citas.editar', $cita)); ?>">
                <i class="fas fa-edit"></i> Editar
            </a>
            <form method="POST" action="<?php echo e(route('admin.citas.eliminar', $cita)); ?>" style="display:inline;">
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
<?php /**PATH /var/www/html/resources/views/Admin/Citas/partials/tbody.blade.php ENDPATH**/ ?>