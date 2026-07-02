<div class="form-group">

    <label>
<?php echo e(($anolectivo->anomodelo->Descricao )); ?>

    </label>
    <?php if(is_object($anolectivo)): ?>
        <select id="my-select" class="form-control" name="divisao_aolectivo">
            <?php $__currentLoopData = $anolectivo->modalidadeDivisao; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $Itemanodivisao): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>


                <option value="<?php echo e($Itemanodivisao->id); ?>"><?php echo e($Itemanodivisao->divisao); ?>

                    <?php echo e($anolectivo->anomodelo->Descricao); ?></option>
                    
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
</div>
<?php else: ?>
<?php endif; ?>
<?php /**PATH C:\laragon\www\escola2025\resources\views/registoAcademico/notas/notas-turma.blade.php ENDPATH**/ ?>