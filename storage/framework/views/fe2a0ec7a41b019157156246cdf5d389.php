
<div id="criarFormula" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <center>
                    <h5> Crie a formula por favor </h5>
                </center>
                <hr>
                <div class="row">
                    <div class="col"><label for="nome-nota">@Media=</label></div>
                    <div class="col-8">
                        <div class="form-group">
                            <div class="row">

<?php if($divisoes->where('divisao_id', 900)->isNotEmpty()): ?>
 <button class="badge bg-Primary btn-avaliacaofeitas col">
                                       NA
                                    </buptton>
                                    <button class="badge bg-Primary btn-avaliacaofeitas
                                     col ">
                                       NE
                                    </button>
<?php else: ?>
    <?php $__currentLoopData = $divisoes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $divisoesItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        

                                <?php if($divisoesItem->divisao<>100): ?>
                                    <button class="badge badge-Primary btn-avaliacaofeitas ">
                                        <?php echo e($divisoesItem->divisao); ?><?php echo e('NF'); ?>

                                    </button>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            </div>
                            <form action="" method="POST" id="formularioformula">
                                <?php echo csrf_field(); ?>
                                <input name="anolectivo" value="<?php echo e($classe_disciplinas[0]['anolectivo_id']); ?>"
                                    type="hidden">

                                <input name="turma" value="<?php echo e($turma); ?>" type="hidden">
                                <input id="my-select" type="text" class="form-control" name="formmulacriada"
                                    value="<?php echo e($formunlamendia->where("TipoMedia",1)->first()->formula??null); ?>"
                                    list="lista-label-avaliacao">


                                    <script>
                                        var formula = <?php echo json_encode($formunlamendia->where("TipoMedia", 1)->first()->formula??null, 512) ?>
                                    </script>

                                <datalist id="lista-label-avaliacao">

                                    <?php $__currentLoopData = $divisoes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $divisoesItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option><?php echo e($divisoesItem->divisao); ?>NF</option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                </datalist>
                        </div>
                        
                    </div>

                    <div class="col"> <a name="" id=""
                            class="btn btn-primary  btn-guadarformulamedia config-item-Div" href="#"
                            role="button">Guardar</a></div>




                    </form>
                </div>
            </div>
        </div>
    </div>
</div>



<div id="criarFormulaMedia" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <center>
                <label> Criar formula para Media Anual</label>
            </center>
            <div class="modal-body">
                <?php $__currentLoopData = $classe_disciplinas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $classe_disciplinasItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <button class="btn btn-avaliacaofeitasMedia"
                        value="<?php echo e($classe_disciplinasItem->disciplina->Sigla); ?>"><?php echo e($classe_disciplinasItem->disciplina->Sigla); ?></button>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                <div class="row">
                    <div class="col-2"><label>@Media</label></div>
                    <div class="col">
                       <input class="form-control" name="formmulacriadaParamedia"
    value="<?php echo e(isset($coleccaoalunos[0]['MediaFormulaAnual']) ? $coleccaoalunos[0]['MediaFormulaAnual'] : ''); ?>" />
                    </div>
                    <div class="col-12">
                        <button class="btn btn-primary btn-guadarformulamediaAnual"> Guardar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<div id="FecharTrimestre" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header justify-content-center">
                <?php
                    $colecao = collect($resultadotRANCA);

                ?>
                <h5 class="modal-title">Fechamento do <?php echo e($notasTodoano[0]->anomodelos); ?></h5>
            </div>
            <div class="modal-body">
                <ul class="list-group">
                    <?php $__currentLoopData = $notasTodoano; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                         $TRACA = "fa-unlock toggle-lock";
                    $TRACAbloqieio = false;
                    $cor = "";
                    $flag="Aberto";
                  //  dd($colecao);
                            $dados = $colecao->where("divisao_id", $item->anomodelo_id)->first();

                            if (!empty($dados) && $dados["fechamento"] == "TOTAL") {
                                $TRACA = "fa-lock";
                                $TRACAbloqieio = true;
                                $cor = "text-danger";
                                 $flag="Total";
                            } if (!empty($dados) && $dados["fechamento"] == "PARCIAL") {
                                $TRACA = "fa-lock toggle-lock";
                                $TRACAbloqieio = false;
                                $cor = "text-orange";
                                 $flag="parcial";
                            }
                        ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center trimestre-item"
                            data-trimestre-id="<?php echo e($item->anomodelo_id); ?>"
                            data-trimestre-nome="<?php echo e($item->divisao); ?> <?php echo e($item->anomodelos); ?>"
                            data-trancado="<?php echo e($TRACAbloqieio); ?>">
                            <span><?php echo e($item->divisao); ?> <?php echo e($item->anomodelos); ?></span>
                            <i class="fa <?php echo e($TRACA); ?> <?php echo e($cor); ?>" style="cursor:pointer;"> <span class="btn-badge"><?php echo e($flag); ?></span></i>
                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-primary" id="btnTrancarSelecionados">
                    Trancar Selecionados
                </button>
            </div>
        </div>
    </div>
</div>
<?php /**PATH /home/sgemozco/escolasaojoaopauloii.sgemoz.com/resources/views/registoAcademico/notas/modals.blade.php ENDPATH**/ ?>