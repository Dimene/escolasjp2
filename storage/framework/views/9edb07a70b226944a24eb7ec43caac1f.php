<!-- Tabs Menu -->
<?php
$idprocurado = filter_var($_SERVER['REQUEST_URI'], FILTER_SANITIZE_NUMBER_INT);
$dadourl = explode('/', $_SERVER['REQUEST_URI']);
if (count($dadourl) < 15) {
    for ($x = count($dadourl); $x < 15; $x++) {
        $dadourl[$x] = null;
    }
}
?>

<div class="card">
    <div class="card-header">
        <ul class="nav nav-tabs card-header-tabs">
            <li class="nav-item">
                <a class="nav-link
                    <?php if($_SERVER['REQUEST_URI'] == '/RegistoAcademico/TabelaValores/show' ||
                        $_SERVER['REQUEST_URI'] == "/RegistoAcademico/TabelaValores/" . (int)$dadourl[3] . "/edit"): ?>
                        active
                    <?php endif; ?>"
                    href="/RegistoAcademico/TabelaValores/show"
                    title="show">
                    <i class="fa fa-eye"></i> Visualizar
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link
                    <?php if($_SERVER['REQUEST_URI'] == '/RegistoAcademico/TabelaValores/create'): ?>
                        active
                    <?php endif; ?>"
                    href="/RegistoAcademico/TabelaValores/create"
                    title="create">
                    <i class="fa fa-plus"></i> Adicionar
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link
                    <?php if($_SERVER['REQUEST_URI'] == '/RegistoAcademico/metodosdepagamentos/NovoPagamento'): ?>
                        active
                    <?php endif; ?>"
                    href="/RegistoAcademico/metodosdepagamentos/NovoPagamento"
                    title="NovoPagamento">
                    <i class="fa fa-credit-card"></i> Criar novo pagamento
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link
                    <?php if($_SERVER['REQUEST_URI'] == '/RegistoAcademico/metodosdepagamentos/AtribuirAlunos'): ?>
                        active
                    <?php endif; ?>"
                    href="/RegistoAcademico/metodosdepagamentos/AtribuirAlunos"
                    title="NovoPagamento">
                    <i class="fa fa-credit-card"></i>Atribuir o pagamento
                </a>
            </li>
        </ul>
    </div>

</div>

<!-- CSS adicional para estilizar as abas -->
<style>
    .nav-tabs .nav-link {
        color: #495057;
        border: none;
        padding: 10px 20px;
        transition: all 0.3s ease;
    }

    .nav-tabs .nav-link:hover {
        color: #007bff;
        border-bottom: 2px solid #007bff;
        background-color: transparent;
    }

    .nav-tabs .nav-link.active {
        color: #007bff;
        border-bottom: 2px solid #007bff;
        background-color: transparent;
    }

    .nav-tabs .nav-link i {
        margin-right: 8px;
    }

    .card-header-tabs {
        margin-right: -0.625rem;
        margin-bottom: -0.75rem;
        margin-left: -0.625rem;
        border-bottom: 1px solid #dee2e6;
    }
</style>
<?php /**PATH C:\laragon\www\escolasaojoaopaulo\resources\views/Componetes/menu-componte-tabelavalores.blade.php ENDPATH**/ ?>