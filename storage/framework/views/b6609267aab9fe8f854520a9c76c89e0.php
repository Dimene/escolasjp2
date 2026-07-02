


<?php
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Request;




$direcao = DB::table("classe_direcao")
    ->where(function($query) {
        $query->where("director_id", auth()->user()->id)
              ->orWhere("pedagogico_id", auth()->user()->id);
    })
    ->exists(); // More efficient than first() ? true : false
    
    
    $isnotas= Gate::check('Ver-Notas')
        ||Gate::check("Caderneta-Caregar")
        || Gate::check('Alterar-Notas');
$tipospagamentos = DB::table('tipos_pagamentos')->get();

$isHome        = Request::is('home*');
$isAcademico   = Request::is('RegistoAcademico/turma*') ||
                 Request::is('RegistoAcademico/notas*') || 
                 Request::is('aluno*');
$isFinancas    = Request::is('Financas*');

// FLAGS PERMISSÃO
$canAccess = false;
$McanAccess = false;
$canLista = false;

foreach ($tipospagamentos as $item) {
    $desc = trim($item->Descricao);
    $canAccess = $canAccess || Gate::check("Efetuar-$desc") || Gate::check("Visualizar-$desc");
    $McanAccess = $McanAccess || Gate::check("Lista-$desc");
    $canLista = $canLista || Gate::check("Visualizar-$desc");
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
  $isfinacas= Gate::check('Dashabord-Financas') || Gate::check('Visualizar-Referencias')||Gate::check('Criar-Referencias');
    $isturmas=Gate::check('criar-Turma')||Gate::check('criar-Jurri')||Gate::check('atribuir-turmas');
$validarTURMAS = !$preshow->isEmpty() || !empty($direcao);
$permitir = $canAccess || $McanAccess || $validarTURMAS;

// PERMISSÕES MATRÍCULA
$canMatriculaExterna = Gate::check("Efetuar-".trim($tipospagamentos->where("id",1)->first()->Descricao));
$canMatriculaInterna = Gate::check("Efetuar-".trim($tipospagamentos->where("id",2)->first()->Descricao));
$canVisualizarMatricula = Gate::check("Visualizar-".trim($tipospagamentos->where("id",1)->first()->Descricao)) || 
                          Gate::check("Visualizar-".trim($tipospagamentos->where("id",2)->first()->Descricao));
$canRelatorioMatricula = Gate::check("RelatorioPagameto-".trim($tipospagamentos->where("id",1)->first()->Descricao)) || 
                         Gate::check("RelatorioPagameto-".trim($tipospagamentos->where("id",2)->first()->Descricao));

$isMatricula = Request::is('aluno/matricula*') ||
               Request::is('aluno/aluno*') ||
               Request::is('aluno/matricula/atualizar/dados/*') ||
               Request::is('aluno/mostrar');

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

        
        
        
        <?php if($permitir||Gate::check('Ver-Aluno')||Gate::check('Modificar-Estado')||Gate::check('Editar-Aluno')
       ||$isnotas
        ||$direcao
        || $isturmas
        ||$isfinacas
        ): ?>
            <li class="nav-item has-treeview <?php echo e($isAcademico ? 'menu-open' : ''); ?>">
                <a href="#" class="nav-link <?php echo e($isAcademico ? 'active' : ''); ?>">
                    <i class="nav-icon fa fa-graduation-cap"></i>
                    <p>
                        Registo Académico
                        <i class="right fa fa-angle-left"></i>
                    </p>
                </a>

                <ul class="nav nav-treeview">

                    
                   
                    
                    <?php if($canMatriculaExterna || $canMatriculaInterna || $canVisualizarMatricula || $canRelatorioMatricula 
                    ||Gate::check('Ver-Aluno')||Gate::check('Modificar-Estado')||Gate::check('Editar-Aluno')): ?>
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

                                <?php if($canVisualizarMatricula||Gate::check('Ver-Aluno')||Gate::check('Modificar-Estado')||Gate::check('Editar-Aluno')): ?>
                                    <li class="nav-item">
                                        <a href="<?php echo e(route('aluno.mostrar')); ?>"
                                           class="nav-link <?php echo e(Request::is('aluno/mostrar') || Request::is('aluno/matricula/atualizar/dados/*') ? 'active' : ''); ?>">
                                            <i class="fa fa-eye nav-icon"></i>
                                            <p>Alunos Inscritos</p>
                                        </a>
                                    </li>
                                <?php endif; ?>

                                <?php if($canRelatorioMatricula): ?>
                                    <li class="nav-item">
                                        <a href="<?php echo e(route('aluno.Relatorio_matriculas')); ?>"
                                           class="nav-link <?php echo e(Request::is('aluno/matricula/Relatorio_matriculas') ? 'active' : ''); ?>">
                                            <i class="fa fa-bar-chart nav-icon"></i>
                                            <p>Relatório</p>
                                        </a>
                                    </li>
                                <?php endif; ?>
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
</nav><?php /**PATH C:\laragon\www\escolasaojoaopaulo\resources\views/layouts/menum-master.blade.php ENDPATH**/ ?>