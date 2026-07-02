<?php
$direcao = DB::table("classe_direcao")
    ->where(function($query) {
        $query->where("director_id", auth()->user()->id)
              ->orWhere("pedagogico_id", auth()->user()->id);
    })
    ->exists(); // More efficient than first() ? true : false
    
    

?>

<?php if(Gate::check('Ver-Notas')
        || Gate::check('Alterar-Notas')
         || Gate::check('gestao-notas')||$direcao): ?>
<li class="nav-item has-treeview <?php echo e(Request::is('RegistoAcademico/notas*') ? 'menu-open' : ''); ?>">
    <a href="#" class="nav-link <?php echo e(Request::is('RegistoAcademico/notas*') ? 'active' : ''); ?>">
        <i class="nav-icon fa fa-book"></i>
        <p>
            Gestão de Notas
            <i class="right fa fa-angle-left"></i>
        </p>
    </a>

    <ul class="nav nav-treeview">

        
        <?php if($validarTURMAS || Gate::check("Caderneta-Caregar")|| Gate::check('Ver-Notas')
        || Gate::check('Alterar-Notas')
         || Gate::check('gestao-notas')||$direcao): ?>
        <li class="nav-item">
            <a href="<?php echo e(route('notas.index')); ?>"
               class="nav-link <?php echo e(Request::is('RegistoAcademico/notas') ? 'active' : ''); ?>">
                <i class="fa fa-pencil nav-icon"></i>
                <p>Lançamento</p>
            </a>
        </li>
        <?php endif; ?>

        
        <?php if(Gate::check("ver-pauta")||$direcao ): ?>
        <li class="nav-item">
            <a href="<?php echo e(route('notas.notasTrimestraisshow')); ?>"
               class="nav-link <?php echo e(Request::is('RegistoAcademico/notas/disciplinas/notasTrimestrais/show/dados') ? 'active' : ''); ?>">
                <i class="fa fa-table nav-icon"></i>
                <p>Pauta Trimestral</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="<?php echo e(route('notas.notasAnualExame')); ?>"
               class="nav-link <?php echo e(Request::is('RegistoAcademico/notas/disciplinas/notasAnualExame/show/dados') ? 'active' : ''); ?>">
                <i class="fa fa-table nav-icon"></i>
                <p>Pauta de Exame</p>
            </a>
        </li>
        <?php endif; ?>

        
        
         <?php if($direcao ): ?>
        <li class="nav-item">
            <a href="<?php echo e(route('notas.ConfiguracoesTrimestrais')); ?>"
               class="nav-link <?php echo e(Request::is('RegistoAcademico/notas/disciplinas/notasTrimestrais/painel/configuracoes') ? 'active' : ''); ?>">
                <i class="fa fa-cogs nav-icon"></i>
                <p>Configurações</p>
            </a>
        </li>
<?php endif; ?>
<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("Gerar-Documento")): ?>
        
        <li class="nav-item">
            <a href="<?php echo e(route('notas.PainelDocumetos')); ?>"
               class="nav-link <?php echo e(Request::is('RegistoAcademico/notas/anual/disciplinas/painel') ? 'active' : ''); ?>">
                <i class="fa fa-folder nav-icon"></i>
                <p>Documentos</p>
            </a>
        </li>
        <?php endif; ?>

    </ul>
</li>
<?php endif; ?>

<?php /**PATH /home/sgemozco/escolasaojoaopauloii.sgemoz.com/resources/views/Componetes/menum-componente-notas.blade.php ENDPATH**/ ?>