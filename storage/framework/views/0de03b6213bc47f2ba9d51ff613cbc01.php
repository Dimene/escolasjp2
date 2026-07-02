
<input type="hidden" name="idprofessor" value="<?php echo e($id); ?>">
<?php $__currentLoopData = $classe_turma; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $turma): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

    <?php
        $checked = $tumasprofessor->contains('turma_id', $turma->id);
    ?>
    <li class="list-group-item d-flex justify-content-between align-items-center turma-item" data-turma-id="<?php echo e($turma->id); ?>">
        <div class="form-check">
            <input class="form-check-input turma-checkbox" type="checkbox"
                   value="<?php echo e($turma->id); ?>"
                   name="turmasid[]"
                   id="turma_<?php echo e($turma->id); ?>"
                   <?php echo e($checked ? 'checked' : ''); ?>>
            <label class="form-check-label <?php echo e($checked ? 'text-success fw-bold' : ''); ?>"
                   for="turma_<?php echo e($turma->id); ?>">
                <?php echo e($turma->Descricao); ?>

            </label>
        </div>
        <?php if($checked): ?>
            <span class="badge bg-warning text-dark atribuido-badge">Atribuído</span>
        <?php endif; ?>



    </li>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

  <div class="bg-light p-2 border-top text-right" id="detailFooter" >
                                    <button class="btn btn-sm btn-primary" id="btnSalvarTurmas" type="button">
                                        <i class="fas fa-save"></i> Salvar Alterações
                                    </button>
                                </div>
<script>
    // Passar os IDs das turmas atribuídas para JavaScript

$(document).on("click", ".turma-checkbox", function() {
    const $checkbox = $(this);
    const turmaId = $checkbox.val();
    const isChecked = $checkbox.is(":checked");
    const $li = $checkbox.closest('li.turma-item');
    const $label = $li.find('label.form-check-label');
    let $badge = $li.find('.atribuido-badge');

    if (isChecked) {
        $label.addClass('text-success fw-bold');
        if ($badge.length === 0) {
            $badge = $('<span class="badge bg-warning text-dark atribuido-badge">Atribuído</span>');
            $li.append($badge);
        }
    } else {
        $label.removeClass('text-success fw-bold');
        $badge.remove();
    }
});

</script>
<!-- Adicione no final da view -->
<?php /**PATH C:\laragon\www\escola2025\resources\views/auth/turmasceked.blade.php ENDPATH**/ ?>