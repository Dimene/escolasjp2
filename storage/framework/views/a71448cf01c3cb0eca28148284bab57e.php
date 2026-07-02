<div class="container  col-12">
<div class="card text-left ">

  <div class="card-body">
  <table id="dadTable" class="table table-striped table-bordered">
    <thead>
        <tr>
            <th><?php echo e($codigo); ?></th>
            <th><?php echo e($local); ?></th>
            <th>Nome</th>
            <th>Ac&ccedil;&otilde;es</th>
        </tr>
    </thead>
    <tbody>
        <?php if(!empty($dad)): ?>
        <?php $__currentLoopData = $dad; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dadItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>


        <tr>
            <td><?php echo e($dadItem->aluno_classe_id); ?></td>
            <td>

                <?php if($tipoDoc==1000): ?>

                 <?php echo e($dadItem->jurri); ?>

                <?php else: ?>

                <?php echo e($dadItem->turma); ?>

                 <?php endif; ?>

            </td>
            <td><?php echo e($dadItem->nome); ?></td>
            <td><button class="badge badge-primary botaoImpeimircertificado"
                data-idaluno="<?php echo e($dadItem->aluno_classe_id); ?>"


                ><i class="fa fa-lg fa-eye" ></i></button></td>
        </tr>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          <?php endif; ?>
    </tbody>

</table>

  </div>
</div>
</div>



<script>
    $(document).ready(function() {
        $('#dadTable').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/pt-BR.json'
            },
            pageLength: 5,
            lengthMenu: [5, 10, 25, 50],
            columnDefs: [
                { orderable: false, targets: 3 } // desabilita ordenação na coluna "Ações"
            ]
        });
    });
</script>


<?php /**PATH C:\laragon\www\escola2025\resources\views/registoAcademico/notas/PainelControlNotasDocunetosConteudo.blade.php ENDPATH**/ ?>