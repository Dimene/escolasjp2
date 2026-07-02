<?php
    // Verifica se está em alguma página de Finanças (base ou subpastas)
    $isFinancas = Request::is('Financas') || Request::is('Financas/*');

    // Verifica se está no Dashboard financeiro
    $isDashboard = Request::routeIs('dashboard.financeiro');

    // Verifica se está no submenu "Referências Bancárias" (qualquer rota que comece com Financas/Banco)
    $isBanco = Request::is('Financas/Banco*') || Request::routeIs('Financas.index');
?>

<li class="nav-item has-treeview <?php echo e($isFinancas || $isDashboard ? 'menu-open' : ''); ?>">
    <a href="#" class="nav-link <?php echo e($isFinancas || $isDashboard ? 'active' : ''); ?>">
        <i class="nav-icon fa fa-money"></i>
        <p>
            Gestão de Finanças
            <i class="right fa fa-angle-left"></i>
        </p>
    </a>

    <ul class="nav nav-treeview">
        
  <li class="nav-item">
            <a href="<?php echo e(route('dashboard.financeiro')); ?>"
               class="nav-link <?php echo e($isDashboard ? 'active' : ''); ?>">
                <i class="fa fa-eye nav-icon"></i>
                <p>Dashboard</p>
            </a>
        </li>
        
        <li class="nav-item has-treeview <?php echo e($isBanco ? 'menu-open' : ''); ?>">
            <a href="#" class="nav-link <?php echo e($isBanco ? 'active' : ''); ?>">
                <i class="nav-icon fa fa-bank"></i>
                <p>
                    Referências Bancárias
                    <i class="right fa fa-angle-left"></i>
                </p>
            </a>

            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="<?php echo e(route('Financas.index')); ?>"
                       class="nav-link <?php echo e(Request::routeIs('Financas.index') ? 'active' : ''); ?>">
                        <i class="fa fa-eye nav-icon"></i>
                        <p>Visualizar</p>
                    </a>
                </li>
            </ul>
        </li>



    </ul>
</li>
<?php /**PATH C:\laragon\www\escola2025\resources\views/Componetes/menum-GESTAOfINACEIRA.blade.php ENDPATH**/ ?>