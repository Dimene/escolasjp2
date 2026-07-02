<li class="nav-item has-treeview <?php echo e(Request::is('RegistoAcademico/notas*') ? 'menu-open' : ''); ?>">
    <a href="#" class="nav-link <?php echo e(Request::is('RegistoAcademico/notas*') ? 'active' : ''); ?>">
        <i class="nav-icon fa fa-book"></i>
        <p>
            Gestão de Notas
            <i class="right fa fa-angle-left"></i>
        </p>
    </a>

    <ul class="nav nav-treeview">

        
        <?php if($validarTURMAS || Gate::check("Caderneta-Caregar")): ?>
        <li class="nav-item">
            <a href="<?php echo e(route('notas.index')); ?>"
               class="nav-link <?php echo e(Request::is('RegistoAcademico/notas') ? 'active' : ''); ?>">
                <i class="fa fa-pencil nav-icon"></i>
                <p>Lançamento</p>
            </a>
        </li>
        <?php endif; ?>

        
        <?php if(Gate::check("ver-pauta") || $edicaoativa): ?>
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

        
        <li class="nav-item">
            <a href="<?php echo e(route('notas.ConfiguracoesTrimestrais')); ?>"
               class="nav-link <?php echo e(Request::is('RegistoAcademico/notas/disciplinas/notasTrimestrais/painel/configuracoes') ? 'active' : ''); ?>">
                <i class="fa fa-cogs nav-icon"></i>
                <p>Configurações</p>
            </a>
        </li>

        
        <li class="nav-item">
            <a href="<?php echo e(route('notas.PainelDocumetos')); ?>"
               class="nav-link <?php echo e(Request::is('RegistoAcademico/notas/anual/disciplinas/painel') ? 'active' : ''); ?>">
                <i class="fa fa-folder nav-icon"></i>
                <p>Documentos</p>
            </a>
        </li>

    </ul>
</li>
<?php /**PATH C:\laragon\www\escola2025\resources\views/Componetes/menum-componente-notas.blade.php ENDPATH**/ ?>