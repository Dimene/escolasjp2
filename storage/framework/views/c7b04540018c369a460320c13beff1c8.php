<?php
$canAccess      = false;
$canEfetuar     = false;
$canVisualizar  = false;
$canLista       = false;
$canRelatorio   = false;
$canGenerico    = false;

$basePath = "aluno/pagamento";

// ROTAS ATIVAS (SIMPLIFICADO)
$isActive = Request::is("$basePath*");

foreach ($tipospagamentos->where("id", ">", 2) as $item) {

    $descricao = trim($item->Descricao);

    $canEfetuar     = $canEfetuar     || Gate::check("Efetuar-$descricao");
    $canVisualizar  = $canVisualizar  || Gate::check("Visualizar-$descricao");
    $canLista       = $canLista       || Gate::check("Lista-$descricao");
    $canRelatorio   = $canRelatorio   || Gate::check("RelatorioPagamento-$descricao"); // corrigido
    $canGenerico    = $canGenerico    || Gate::check("RelatorioGenerico-$descricao");

    $canAccess = $canEfetuar || $canVisualizar || $canLista || $canRelatorio || $canGenerico;

    if ($canAccess) break; // otimização simples
}
?>


<?php if($canAccess): ?>
<li class="nav-item has-treeview <?php echo e($isActive ? 'menu-open' : ''); ?>">

    <a href="#" class="nav-link <?php echo e($isActive ? 'active' : ''); ?>">
        <i class="nav-icon fa fa-credit-card"></i> 
        <p>
            Pagamento
            <i class="right fa fa-angle-left"></i>
        </p>
    </a>

    <ul class="nav nav-treeview">

        
        <?php if($canEfetuar || $canVisualizar || $canLista): ?>
        <li class="nav-item">
            <a href="<?php echo e(route('pagament.show')); ?>"
               class="nav-link <?php echo e(Request::is("$basePath/efetuar") ? 'active' : ''); ?>">
                <i class="fa fa-pencil-square nav-icon"></i>
                <p>Efetuar</p>
            </a>
        </li>
        <?php endif; ?>

        
        <?php if($canRelatorio): ?>
        <li class="nav-item">
            <a href="<?php echo e(route('pagament.relatorio')); ?>"
               class="nav-link <?php echo e(Request::is("$basePath/relatorio") ? 'active' : ''); ?>">
                <i class="fa fa-bar-chart nav-icon"></i>
                <p>Relatório de Pagamentos</p>
            </a>
        </li>
        <?php endif; ?>

        
        <?php if($canGenerico): ?>
        <li class="nav-item">
            <a href="<?php echo e(route('pagament.relatoriogenerico')); ?>"
               class="nav-link <?php echo e(Request::is("$basePath/relatoriogenerico") ? 'active' : ''); ?>">
                <i class="fa fa-file-text nav-icon"></i>
                <p>Relatório Genérico</p>
            </a>
        </li>
        <?php endif; ?>

    </ul>
</li>
<?php endif; ?>
<?php /**PATH C:\laragon\www\escola2025\resources\views/Componetes/menum-componente.blade.php ENDPATH**/ ?>