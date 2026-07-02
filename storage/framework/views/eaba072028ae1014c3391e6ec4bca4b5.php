<?php
$isTurma = Request::is('RegistoAcademico/turma*');
?>

<li class="nav-item has-treeview <?php echo e($isTurma ? 'menu-open' : ''); ?>">

    <a href="#" class="nav-link <?php echo e($isTurma ? 'active' : ''); ?>">
        <i class="nav-icon fa fa-sitemap"></i>
        <p>
            Gestão de Turmas
            <i class="right fa fa-angle-left"></i>
        </p>
    </a>

    <ul class="nav nav-treeview">

        
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('criar-Turma')): ?>
        <li class="nav-item">
            <a href="<?php echo e(route('turma.create')); ?>"
               class="nav-link <?php echo e(Request::is('RegistoAcademico/turma/create') ? 'active' : ''); ?>">
                <i class="fa fa-plus-square nav-icon"></i>
                <p>Criar Turma</p>
            </a>
        </li>
        <?php endif; ?>

        
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('criar-Turma')): ?>
        <li class="nav-item">
            <a href="<?php echo e(route('turma.atribuirturma')); ?>"
               class="nav-link <?php echo e(Request::is('RegistoAcademico/turma/atriburi/professor') ? 'active' : ''); ?>">
                <i class="fa fa-exchange nav-icon"></i>
                <p>Atribuir Professor</p>
            </a>
        </li>
        <?php endif; ?>

        
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('criar-Turma')): ?>
        <li class="nav-item">
            <a href="<?php echo e(route('turma.createJurri')); ?>"
               class="nav-link <?php echo e(Request::is('RegistoAcademico/turma/criar/createJurri') ? 'active' : ''); ?>">
                <i class="fa fa-users nav-icon"></i>
                <p>Criar Júri</p>
            </a>
        </li>
        <?php endif; ?>

    </ul>
</li>
<?php /**PATH C:\laragon\www\escola2025\resources\views/Componetes/menum-Gestao-turma.blade.php ENDPATH**/ ?>