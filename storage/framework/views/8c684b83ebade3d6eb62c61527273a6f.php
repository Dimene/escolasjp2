<?php if(is_object($disp)): ?>

    <style>
        /* Versão monocromática - apenas tons de cinza */
        .nav-tabs .nav-link {
            background-color: #f1f3f5;  /* Cinza claro para inativas */
            color: #495057;
            border: 1px solid #ced4da;
            margin-right: 5px;
            transition: all 0.2s ease;
        }

        .nav-tabs .nav-link:hover {
            background-color: #e9ecef;
            border-color: #adb5bd;
        }

        .nav-tabs .nav-link.active {
            background-color: #ffffff !important;  /* Branco puro para ativa */
            color: #212529 !important;              /* Preto para texto */
            border: 1px solid #ced4da;
            border-bottom: 2px solid #495057;       /* Destaque cinza escuro */
            font-weight: 600;
            box-shadow: 0 -2px 4px rgba(0,0,0,0.05);
        }
    </style>

    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <?php $__currentLoopData = $disp; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $disItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>


                    <li class="nav-item" role="presentation">
                        <a class="nav-link disciplina_id <?php if($key === 0): ?> active <?php endif; ?>"
                           id="tab-<?php echo e($disItem->disciplina->id); ?>"
                           href="#<?php echo e($disItem->disciplina->id); ?>tab"
                           role="tab"
                           aria-controls="<?php echo e($disItem->disciplina->id); ?>tab"
                           aria-selected="<?php echo e($key === 0 ? 'true' : 'false'); ?>"
                           data-toggle="tab"
                           data-disciplina-id="<?php echo e($disItem->disciplina->id); ?>"
                           title="<?php echo e($disItem->disciplina->Descricao); ?>">
                            <?php echo e($disItem->disciplina->Descricao); ?>

                        </a>
                    </li>

        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>
<?php endif; ?>
<?php /**PATH C:\laragon\www\escola2025\resources\views/registoAcademico/notas/tabela-notas.blade.php ENDPATH**/ ?>