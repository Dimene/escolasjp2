<div class="col-md-12">
    <hr>
    <center>
        <label>As Disciplinas e Turmas</label>
    </center>
</div>


<input type="hidden" class="idaluno" value="<?php echo e($id); ?>">
<input type="hidden" class="anolectivo" value="<?php echo e($ano); ?>">
<input type="hidden" class="classe_id" value="<?php echo e($classes->id ?? 0); ?>">


<div class="col-md-12">
    <select class="form-control controler-disciplinas" id="select-disciplinas" name="disciplina_id">
        <?php $__currentLoopData = $disciplinasFormatadas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $disciplina): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
                $ignorarSelected = [0, 100];
                $isSelecionado = !in_array($disciplina['id'], $ignorarSelected)
                    && $tumasprofessor->contains('disciplina_id', $disciplina['id']);
            ?>
            <option value="<?php echo e($disciplina['id']); ?>" <?php echo e($isSelecionado ? 'selected' : ''); ?>>
                <?php echo e($disciplina['Descricao']); ?>

            </option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>
</div>


<div class="col">
    <ul class="list-group listaselecioadas">
        
    </ul>
</div>


<script src="<?php echo e(asset('Datatable/js/jquery-3.5.1.js')); ?>"></script>
<script src="<?php echo e(asset('Datatable/js/jquery.dataTables.min.js')); ?>"></script>
<script src="<?php echo e(asset('Datatable/js/dataTables.buttons.min.js')); ?>"></script>
<script src="<?php echo e(asset('Datatable/js/buttons.flash.min.js')); ?>"></script>
<script src="<?php echo e(asset('Datatable/js/jszip.min.js')); ?>"></script>
<script src="<?php echo e(asset('Datatable/js/pdfmake.min.js')); ?>"></script>
<script src="<?php echo e(asset('Datatable/js/vfs_fonts.js')); ?>"></script>
<script src="<?php echo e(asset('Datatable/js/buttons.html5.min.js')); ?>"></script>
<script src="<?php echo e(asset('Datatable/js/buttons.print.min.js')); ?>"></script>
<script src="<?php echo e(asset('Datatable/js/buttons.colVis.min.js')); ?>"></script>
<script src="https://unpkg.com/mathjs/lib/browser/math.js"></script>

<script>
    $(document).ready(function () {
        controlarVisibilidadeLista();
        carregarDisciplinasSelecionadas();

        $(".controler-disciplinas").on("change", function () {
            controlarVisibilidadeLista();
            carregarDisciplinasSelecionadas();
        });
    });

    // Função para esconder a lista se disciplina == 0
    function controlarVisibilidadeLista() {
        const disciplinaSelecionada = $(".controler-disciplinas").val();
        if (disciplinaSelecionada == 0) {
            $(".listaselecioadas").hide();
        } else {
            $(".listaselecioadas").show();
        }
    }

    // Função para buscar os professores vinculados à disciplina selecionada
    function carregarDisciplinasSelecionadas() {
        const aluno      = $(".idaluno").val();
        const classe     = $(".classe_id").val();
        const ano        = $(".anolectivo").val();
        const disciplina = $(".controler-disciplinas").val();

        const url = `/RegistoAcademico/turma/atriburi/professores/professoresselect/ckeck/${aluno}/${classe}/${ano}/${disciplina}`;

        $.ajax({
            url: url,
            type: 'GET',
            beforeSend: function () {
                $(".listaselecioadas").html('<li class="list-group-item">Carregando...</li>');
            },
            success: function (data) {
                $(".listaselecioadas").html(data);
            },
            error: function () {
                $(".listaselecioadas").html('<li class="list-group-item text-danger">Erro ao carregar dados.</li>');
            }
        });
    }
</script>
<?php /**PATH C:\laragon\www\escolasaojoaopaulo\resources\views/auth/classe-turma-professor.blade.php ENDPATH**/ ?>