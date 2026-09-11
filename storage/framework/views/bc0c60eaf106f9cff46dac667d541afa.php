<form>
    <h4>Atribui&ccedil;&atilde;o de turmas</h4>

    <input value="<?php echo e($id); ?>" class="idprofefessor" type="hidden">
    <div class="row">
        <div class="col">
            <label>selecione a classe</label>

            <select class="classes selectcotrol  form-control">
                <?php $__currentLoopData = $classe; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $classeItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($classeItem->id); ?>"
                        <?php $__currentLoopData = $tumasprofessor; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                        <?php if($item->classe_id == $classeItem->id): ?>
                        selected <?php endif; ?> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>>
                        <?php echo e($classeItem->Descricao); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            </select>

        </div>
        <div class="col">
            <label>Selecione o Ano lectivo</label>
            <select class="anolectivo selectcotrol form-control">
                <?php $__currentLoopData = $anoLectivo; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $anoLectivoItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($anoLectivoItem->id); ?>">
                        <?php echo e($anoLectivoItem->anolectivo); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            </select>

        </div>


    </div>

    <div class="row Tabelaturmaprofessores_dados">

    </div>

    <div class="row ">
        <div class="col-md-8">


        </div>
        

    </div>

</form>

<script>
    $(document).ready(function() {
        buscasr_professores_turma($(".idprofefessor").val(), $(".classes").val(), $(".anolectivo").val());

    });


    $(document).on("change", ".selectcotrol", function() {

        buscasr_professores_turma($(".idprofefessor").val(), $(".classes").val(), $(".anolectivo").val());


    })




    function buscasr_professores_turma(id, classe, ano) {
        $.ajax({
            url: '/RegistoAcademico/turma/atriburi/professores/professoresselect/' + id + '/' + classe + '/' +
                ano + '',
            type: 'get',

            beforeSend: function() {
                $(".Tabelaturmaprofessores_dados").html(
                    ' <img src="<?php echo e(asset('imageproceaament/loading.gif')); ?>"  style=" margin:auto;width:200px;height:200px">'
                );
                //$(".Tabelaturmaprofessores_dados").empty();

            },
            success: function(data) {
                $(".Tabelaturmaprofessores_dados").html(data);
            },

        });

    }
</script>
<?php /**PATH C:\laragon\www\escolasaojoaopaulo\resources\views/auth/TurmasAtribuida-propfessor.blade.php ENDPATH**/ ?>