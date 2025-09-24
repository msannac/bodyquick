<?php
    $faqs = config('faq');
?>
<div class="container mt-4 mb-4" style="background: #f8f9fa; border-radius: 1rem; box-shadow: 0 2px 16px rgba(0,0,0,0.06);">
    <h1 class="mb-4 text-center"><i class="fas fa-question-circle text-success"></i> Preguntas Frecuentes</h1>
    <div class="accordion shadow-sm rounded-lg" id="faqAccordion">
        <?php $__currentLoopData = $faqs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $faq): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="card mb-2 border-0 rounded-lg">
                <div class="card-header bg-light border-0 <?php if($i === 0): ?> rounded-top <?php elseif($i === count($faqs)-1): ?> rounded-bottom <?php endif; ?>" id="faq<?php echo e($i+1); ?>">
                    <h2 class="mb-0">
                        <button class="btn btn-link text-dark font-weight-bold <?php if($i !== 0): ?> collapsed <?php endif; ?>" type="button" data-toggle="collapse" data-target="#collapse<?php echo e($i+1); ?>" aria-expanded="<?php echo e($i === 0 ? 'true' : 'false'); ?>" aria-controls="collapse<?php echo e($i+1); ?>">
                            <?php echo $faq['question']; ?>

                        </button>
                    </h2>
                </div>
                <div id="collapse<?php echo e($i+1); ?>" class="collapse <?php if($i === 0): ?> show <?php endif; ?>" aria-labelledby="faq<?php echo e($i+1); ?>" data-parent="#faqAccordion">
                    <div class="card-body bg-white">
                        <?php echo $faq['answer']; ?>

                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>
<?php /**PATH C:\xampp\htdocs\bodyquick\resources\views/faq.blade.php ENDPATH**/ ?>