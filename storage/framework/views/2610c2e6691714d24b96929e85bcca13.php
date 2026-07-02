
                <!-- Card 1 -->
                <div class="col">
                    <div class="card text-center shadow-sm">
                        <div class="card-body">
                   <i class="fa fa-lock fa-3x" style="border-radius:50%; background:#eee; padding:15px; color:rgb(255, 0, 123)"></i>
                   <br>
                   <h4>
                   <?php echo e($trimestre[0]->anolectivo->anomodelo->Descricao); ?>

                   </h4>
                   Gerir Trimestre abrir e tranca
                            <h5 class="card-title"></h5>


                            <ul class="list-group">

                                <?php $__currentLoopData = $trimestre; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $trimestreItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>


                                <li class="list-group-item d-flex justify-content-between align-items-center " id="<?php echo e($trimestreItem->id); ?>">
                                    <?php echo e($trimestreItem->divisao); ?> &ordm; <?php echo e($trimestreItem->anolectivo->anomodelo->Descricao); ?>


                          

                          <?php
                           $elementotrimeestre=$dadosFechamento->where("id",$trimestreItem->id)->first();
                           $total=$elementotrimeestre["total"];
                           $visualizar=$elementotrimeestre["visualizar"];
// dd($dadosFechamento,Auth::user()->id,$visualizar);
                          ?>
                                    <i


    data-disabled="<?php echo e($total == 0 ? 'true' : 'false'); ?>"

                                    class="fa  fa-lg
                                elemento-chave



<?php if($dadosFechamento->where("id",$trimestreItem->id)->first()["chave1status"]!=null &&
$dadosFechamento->where("id",$trimestreItem->id)->first()["chave2status"]!=null): ?>
                                        fa-lock
                                         <?php elseif($dadosFechamento->where("id",$trimestreItem->id)->first()["chave1status"]==Auth::user()->id): ?>
fa-lock
 <?php elseif($dadosFechamento->where("id",$trimestreItem->id)->first()["chave2status"]==Auth::user()->id): ?>
 fa-lock
 <?php else: ?>
                                         fa-unlock
                                         <?php endif; ?>
                                        btn-fecharTrimestre"
                                        >
                                        <small>
                                        <?php echo e($dadosFechamento->where("id",$trimestreItem->id)->first()["status"]); ?>

                                        </small>
                                    </i>

                                         <i class="fa  <?php if($visualizar==null): ?>
                                         fa-eye
                                         <?php else: ?>
                                          fa-eye-slash
                                         <?php endif; ?>
                                          fa-lg  btn-mostrarTrimestre"></i>

                                      </li>


                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>



                        </div>


<button class="btn btn-primary btngravaralteracoesTrimestres">Guardar a modificação</button>
                    </div>
                </div>

<?php /**PATH C:\laragon\www\escola2025\resources\views/registoAcademico/notas/PainelControlNotasConteudo.blade.php ENDPATH**/ ?>