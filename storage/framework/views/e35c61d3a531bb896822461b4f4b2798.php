


<ul class="nav nav-tabs listaTurmaTab" id="myTab" role="tablist">



       <?php if($turmasclasse[0]->Descricao==null): ?>

        <li class="list-group-item list-group-item-warning text-center rounded shadow-sm">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            As Jurri ainda não foram configuradas
        </li>
    <?php else: ?>

    <?php $__currentLoopData = $turmasclasse; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $turmasnoes): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>




<?php


$turmasnoes=(object) $turmasnoes;
$usuario = Auth::user()->id;

$anolectivo = DB::table('classe_direcao')
    ->where("classe_id", $turmasnoes->classe_id)
    ->max("anolectivo_id");

$dadosChave = DB::table('classe_direcao')
    ->where("classe_id", $turmasnoes->classe_id)
    ->where("anolectivo_id", $anolectivo)
    ->where(function ($query) use ($usuario) {

        $query->where("pedagogico_id", $usuario)
              ->orWhere("director_id", $usuario);

    })
    ->first();

    $edicaoativa=false;


     $turmapermisao=DB::table('professor_turmaview')->where("professor_id",$usuario)
    ->where("Tipo_Docencia_id",1)
    ->where("turma_id",$turmasnoes->id)->first();
    if($turmapermisao||$dadosChave){
   $edicaoativa=true;
    }


// dd($usuario,$turma,$edicaoativa);
?>


<?php if($edicaoativa|| Gate::check("ver-pauta")): ?>

        <li class="nav-item">
            <a class="nav-link <?php if($key == 0): ?> active <?php endif; ?> turmaselecionada"
               id="<?php echo e($turmasnoes->id); ?>"
               flag="0"
                
               data-toggle="tab"
               href="#turma-<?php echo e($turmasnoes->id); ?>"
               role="tab"
               aria-controls="turma-<?php echo e($turmasnoes->id); ?>"
               aria-selected="<?php echo e($key == 0 ? 'true' : 'false'); ?>">
               <?php echo e($turmasnoes->Descricao); ?>

            </a>
        </li>
        <?php endif; ?>

    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>


</ul>

<?php /**PATH C:\laragon\www\escolasaojoaopaulo\resources\views/registoAcademico/notas/notas-nomes-turmas-trimestre.blade.php ENDPATH**/ ?>