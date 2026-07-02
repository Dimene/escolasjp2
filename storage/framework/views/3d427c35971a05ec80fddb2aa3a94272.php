<?php if(
    Gate::check('Criar-papel') ||
    Gate::check('visualizar-usuarios') ||
    Gate::check('Registo-Usuario') ||
    Gate::check('criar-anoLectivo') ||
    Gate::check('criar-Turma') ||
    Gate::check('Apagar-usuario') ||
    Gate::check('ver-operacoes') ||
    Gate::check('Atualizar-Usuario') ||
    Gate::check('criar-Tabela-valores')
): ?>

<?php
    // ROTAS ACTIVAS
    $isConfig = Request::is('Admin/Configuracoes*') ||
                Request::is('RegistoAcademico/ano/*')||
                Request::is('admin/Usuarios*')||
                Request::is('admin/permissons/*')||
                Request::is('admin/RegistoOperacoes/index')||
                Request::is('RegistoAcademico/metodosdepagamentos*')||
                Request::is('RegistoAcademico/TabelaValores/*')||
                Request::is('RegistoAcademico/classe/configuracao')
                ;

    $isUsers = Request::is('admin/Usuarios*');
    $isUsersIndex = Request::is('admin/Usuarios') || Request::is('admin/Usuarios/index');
    $isUsersCreate = Request::is('admin/Usuarios/create');

    $isOperations = Request::is('admin/RegistoOperacoes/index');

    // PERMISSÕES
    $hasUserAccess = Gate::any([
        'visualizar-usuarios',
        'Apagar-usuario',
        'Atualizar-Usuario',
        'Registo-Usuario'
    ]);

    $canRegisterUser = Gate::allows('Registo-Usuario');
    $canViewOperations = Gate::allows('ver-operacoes');
?>

<li class="nav-item has-treeview <?php echo e($isConfig || $isUsers || $isOperations ? 'menu-open' : ''); ?>">
    <a href="#" class="nav-link <?php echo e($isConfig ? 'active' : ''); ?>">
        <i class="nav-icon fa fa-cogs"></i>
        <p>
            Gestão administrativa
            <i class="right fa fa-angle-left"></i>
        </p>
    </a>

    <ul class="nav nav-treeview">

        
        <?php if(Gate::check('criar-anoLectivo') || Gate::check('criar-Turma') || Gate::check('criar-Tabela-valores')): ?>

        <?php
            $isConfigSub = Request::is('RegistoAcademico/ano*') ||
                           Request::is('RegistoAcademico/TabelaValores*') ||

                           Request::is('RegistoAcademico/metodosdepagamentos/AtribuirAlunos') ||
                                Request::is('RegistoAcademico/metodosdepagamentos/NovoPagamento')||

                           Request::is('RegistoAcademico/classe/configuracao');
        ?>

        <li class="nav-item has-treeview <?php echo e($isConfigSub ? 'menu-open' : ''); ?>">
            <a href="#" class="nav-link <?php echo e($isConfigSub ? 'active' : ''); ?>">
                <i class="fa fa-sliders nav-icon"></i>
                <p>
                    Configuração
                    <i class="right fa fa-angle-left"></i>
                </p>
            </a>

            <ul class="nav nav-treeview">

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('criar-anoLectivo')): ?>
                <li class="nav-item">
                    <a href="<?php echo e(route('ano.create')); ?>"
                       class="nav-link <?php echo e(Request::is('RegistoAcademico/ano*') ? 'active' : ''); ?>">
                        <i class="fa fa-calendar nav-icon"></i>
                        <p>Ano Lectivo</p>
                    </a>
                </li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('criar-Tabela-valores')): ?>
                <li class="nav-item">
                    <a href="/RegistoAcademico/TabelaValores/show"
                       class="nav-link <?php echo e(Request::is('RegistoAcademico/TabelaValores*')||Request::is('RegistoAcademico/metodosdepagamentos/NovoPagamento')? 'active' : ''); ?>">
                        <i class="fa fa-money nav-icon"></i>
                        <p>Tabela de Valores</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/RegistoAcademico/metodosdepagamentos/AtribuirAlunos"
                       class="nav-link <?php echo e(Request::is('RegistoAcademico/metodosdepagamentos/AtribuirAlunos')? 'active' : ''); ?>">
                        <i class="fa fa-money nav-icon"></i>
                        <p> TV.atribuicao a Alunos</p>
                    </a>
                </li>


                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('criar-Tabela-valores')): ?>
                <li class="nav-item">
                    <a href="<?php echo e(route('notas.create')); ?>"
                       class="nav-link <?php echo e(Request::is('RegistoAcademico/classe/configuracao') ? 'active' : ''); ?>">
                        <i class="fa fa-graduation-cap nav-icon"></i>
                        <p>Classes</p>
                    </a>
                </li>
                <?php endif; ?>

            </ul>
        </li>
        <?php endif; ?>

        
        <?php if($hasUserAccess): ?>
        <li class="nav-item has-treeview <?php echo e($isUsers || $isOperations ? 'menu-open' : ''); ?>">
            <a href="#" class="nav-link <?php echo e($isUsers ? 'active' : ''); ?>">
                <i class="fa fa-users nav-icon"></i>
                <p>
                    Usuários
                    <i class="right fa fa-angle-left"></i>
                </p>
            </a>

            <ul class="nav nav-treeview">

                <li class="nav-item">
                    <a href="<?php echo e(route('Usuarios.index')); ?>"
                       class="nav-link <?php echo e($isUsersIndex ? 'active' : ''); ?>">
                        <i class="fa fa-list nav-icon"></i>
                        <p>Listar Usuários</p>
                    </a>
                </li>

                <?php if($canRegisterUser): ?>
                <li class="nav-item">
                    <a href="<?php echo e(route('Usuarios.create')); ?>"
                       class="nav-link <?php echo e($isUsersCreate ? 'active' : ''); ?>">
                        <i class="fa fa-user-plus nav-icon"></i>
                        <p>Registar Usuário</p>
                    </a>
                </li>
                <?php endif; ?>

                <?php if($canViewOperations): ?>
                <li class="nav-item">
                    <a href="<?php echo e(route('Usuarios.RegistoOperacoes')); ?>"
                       class="nav-link <?php echo e($isOperations ? 'active' : ''); ?>">
                        <i class="fa fa-history nav-icon"></i>
                        <p>Operações de Usuários</p>
                    </a>
                </li>
                <?php endif; ?>

            </ul>
        </li>
        <?php endif; ?>

        
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Criar-papel')): ?>
        <li class="nav-item">
            <a href="<?php echo e(route('Admin.permissons.lista')); ?>"
               class="nav-link <?php echo e(Request::is('admin/permissons*') ? 'active' : ''); ?>">
                <i class="fa fa-lock nav-icon"></i>
                <p>Permissões do sistema</p>
            </a>
        </li>
        <?php endif; ?>

        
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Configuracoes-Sisitema')): ?>
        <li class="nav-item">
            <a href="<?php echo e(route('Configuracoes.edit', 1)); ?>"
               class="nav-link <?php echo e(Request::is('Admin/Configuracoes/*/edit') ? 'active' : ''); ?>">
                <i class="fa fa-cogs nav-icon"></i>
                <p>Configurações</p>
            </a>
        </li>
        <?php endif; ?>

    </ul>
</li>

<?php endif; ?>
<?php /**PATH C:\laragon\www\escola2025\resources\views/Componetes/menum-ADMISTRACAOaVANCADA.blade.php ENDPATH**/ ?>