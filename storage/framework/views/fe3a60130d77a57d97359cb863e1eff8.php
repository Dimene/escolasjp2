


<?php
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Request;

$tipospagamentos = DB::table('tipos_pagamentos')->get();

$isHome        = Request::is('home*');
$isAcademico   = Request::is('RegistoAcademico/turma*') ||
$isAcademico   = Request::is('RegistoAcademico/notas*') || Request::is('aluno*');
$isFinancas    = Request::is('Financas*');

// FLAGS PERMISSÃO
$canAccess = false;
$McanAccess = false;

foreach ($tipospagamentos as $item) {
    $desc = trim($item->Descricao);

    $canAccess = $canAccess || Gate::check("Efetuar-$desc") || Gate::check("Visualizar-$desc");
    $McanAccess = $McanAccess || Gate::check("Lista-$desc");
}

// PROFESSOR / DIREÇÃO
$autor = Auth::user()->id;

$preshow = DB::table('professor_turmaview')
    ->where('professor_id', $autor)
    ->get();

$direcao = DB::table('classe_direcao')
    ->where("pedagogico_id", $autor)
    ->orWhere("director_id", $autor)
    ->first();

$validarTURMAS = !$preshow->isEmpty() || !empty($direcao);


$permitir=$canAccess || $McanAccess || $validarTURMAS;

?>





<div class="user-panel mt-3 pb-3 mb-3 d-flex">
    <div class="info">
        <a href="<?php echo e(route('Usuarios.Atualizarsenha', Auth()->user()->id)); ?>">
            <i class="fa fa-pencil-square"></i> Alterar Senha
        </a>
    </div>
</div>





<nav class="mt-2">
<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview">





<li class="nav-item">
    <a href="/home" class="nav-link <?php echo e($isHome ? 'active' : ''); ?>">
        <i class="nav-icon fa fa-dashboard"></i>
        <p>Página Inicial</p>
    </a>
</li>





<?php if($permitir): ?>

<li class="nav-item has-treeview <?php echo e($isAcademico ? 'menu-open' : ''); ?>">
    <a href="#" class="nav-link <?php echo e($isAcademico ? 'active' : ''); ?>">
        <i class="nav-icon fa fa-graduation-cap"></i>
        <p>
            Registo Académico
            <i class="right fa fa-angle-left"></i>
        </p>
    </a>

    <ul class="nav nav-treeview">


    
    
    
    <?php


        $isMatricula = Request::is('aluno/matricula*') ||
         Request::is('aluno/aluno*')||Request::is('aluno/matricula/atualizar/dados/*')
         ||Request::is('aluno/mostrar');
    ?>

    <?php if($McanAccess): ?>
    <li class="nav-item has-treeview <?php echo e($isMatricula ? 'menu-open' : ''); ?>">
        <a href="#" class="nav-link <?php echo e($isMatricula ? 'active' : ''); ?>">
            <i class="nav-icon fa fa-users"></i>
            <p>
                Matrícula
                <i class="right fa fa-angle-left"></i>
            </p>
        </a>

        <ul class="nav nav-treeview">

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("Efetuar-MATRICULA EXTERNOS")): ?>
            <li class="nav-item">
                <a href="<?php echo e(route('aluno.matricula')); ?>"
                   class="nav-link <?php echo e(Request::is('aluno/matricula') ? 'active' : ''); ?>">
                    <i class="fa fa-pencil-square nav-icon"></i>
                    <p>Efetuar</p>
                </a>
            </li>
            <?php endif; ?>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("Efetuar-MATRICULA INTERNOS")): ?>
            <li class="nav-item">
                <a href="<?php echo e(route('aluno.atualizacaoIndex')); ?>"
                   class="nav-link <?php echo e(Request::is('aluno/matricula/atualizacaoIndex') ? 'active' : ''); ?>">
                    <i class="fa fa-refresh nav-icon"></i>
                    <p>Atualizar</p>
                </a>
            </li>
            <?php endif; ?>

            <li class="nav-item">
                <a href="<?php echo e(route('aluno.mostrar')); ?>"
                   class="nav-link <?php echo e(Request::is('aluno/mostrar')||
                    Request::is('aluno/matricula/atualizar/dados/*') ? 'active' : ''); ?>">
                    <i class="fa fa-eye nav-icon"></i>
                    <p>Alunos Inscritos</p>
                </a>
            </li>

            <li class="nav-item">
                <a href="<?php echo e(route('aluno.Relatorio_matriculas')); ?>"
                   class="nav-link <?php echo e(Request::is('aluno/matricula/Relatorio_matriculas')

                    ? 'active' : ''); ?>">
                    <i class="fa fa-bar-chart nav-icon"></i>
                    <p>Relatório</p>
                </a>
            </li>

        </ul>
    </li>
    <?php endif; ?>


    
    <?php echo $__env->make("Componetes.menum-componente", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make("Componetes.menum-componente-notas", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make("Componetes.menum-Gestao-turma", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


    </ul>
</li>
<?php endif; ?>
  <?php echo $__env->make("Componetes.menum-GESTAOfINACEIRA", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>










<?php echo $__env->make("Componetes.menum-ADMISTRACAOaVANCADA", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

</ul>
</nav>
<?php /**PATH C:\laragon\www\escola2025\resources\views/layouts/menum-master.blade.php ENDPATH**/ ?>