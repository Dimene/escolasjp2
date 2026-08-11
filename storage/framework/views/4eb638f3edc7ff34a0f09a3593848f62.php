<?php
$dados = session()->get('nomeEm');
$avatar = session()->get('infosession')->avatar;
?>


<?php $__env->startSection('title', 'Referências Bancárias'); ?>

<?php $__env->startSection('content'); ?>

<style>
    /* ======================================== */
    /* ESTILOS MODERNOS PARA REFERÊNCIAS BANCÁRIAS */
    /* ======================================== */

    .fade-in {
        animation: fadeIn 0.4s ease-out;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Card Moderno */
    .filter-section {
        background: white;
        border-radius: 20px;
        padding: 25px;
        margin-bottom: 25px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
    }

    .filter-title {
        font-size: 0.85rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #6b7280;
        margin-bottom: 8px;
        display: block;
    }

    .filter-title i {
        margin-right: 5px;
        color: #667eea;
    }

    .filter-select {
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        padding: 12px 16px;
        width: 100%;
        background: #f9fafb;
        transition: all 0.3s ease;
        font-size: 0.9rem;
    }

    .filter-select:focus {
        outline: none;
        border-color: #667eea;
        background: white;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    /* Botões */
    .btn-modern {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        border-radius: 12px;
        padding: 12px 28px;
        font-weight: 600;
        transition: all 0.3s ease;
        color: white;
        font-size: 0.9rem;
    }

    .btn-modern:hover {
        transform: translateY(-2px);
        box-shadow: 0 7px 14px rgba(102, 126, 234, 0.3);
        color: white;
    }

    .btn-success-modern {
        background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
        border: none;
        border-radius: 12px;
        padding: 12px 28px;
        font-weight: 600;
        transition: all 0.3s ease;
        color: white;
        font-size: 0.9rem;
    }

    .btn-success-modern:hover {
        transform: translateY(-2px);
        box-shadow: 0 7px 14px rgba(72, 187, 120, 0.3);
        color: white;
    }

    .btn-danger-modern {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        border: none;
        border-radius: 12px;
        padding: 12px 28px;
        font-weight: 600;
        transition: all 0.3s ease;
        color: white;
        font-size: 0.9rem;
    }

    .btn-danger-modern:hover {
        transform: translateY(-2px);
        box-shadow: 0 7px 14px rgba(239, 68, 68, 0.3);
        color: white;
    }

    .btn-warning-modern {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        border: none;
        border-radius: 12px;
        padding: 12px 28px;
        font-weight: 600;
        transition: all 0.3s ease;
        color: white;
        font-size: 0.9rem;
    }

    .btn-warning-modern:hover {
        transform: translateY(-2px);
        box-shadow: 0 7px 14px rgba(245, 158, 11, 0.3);
        color: white;
    }

    /* Tabela de Resultados */
    .results-table {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
    }

    .results-table table {
        width: 100%;
        margin-bottom: 0;
    }

    .results-table thead th {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        font-weight: 600;
        padding: 15px;
        border: none;
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .results-table tbody tr {
        transition: all 0.2s ease;
        border-bottom: 1px solid #e5e7eb;
    }

    .results-table tbody tr:hover {
        background: #f8fafc;
    }

    .results-table tbody td {
        padding: 12px 15px;
        vertical-align: middle;
        color: #374151;
    }

    /* Loading */
    .loading-container {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        min-height: 300px;
    }

    .loading-spinner {
        width: 50px;
        height: 50px;
        border: 3px solid #e5e7eb;
        border-top-color: #667eea;
        border-radius: 50%;
        animation: spin 0.8s linear infinite;
    }

    @keyframes spin {
        to { transform: rotate(360deg); }
    }

    /* Modal */
    .modal-modern .modal-content {
        border-radius: 20px;
        border: none;
        overflow: hidden;
    }

    .modal-modern .modal-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        padding: 15px 20px;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 50px 20px;
        color: #9ca3af;
    }

    .empty-state i {
        font-size: 4rem;
        margin-bottom: 15px;
        opacity: 0.5;
    }

    /* Alertas */
    .alert-custom {
        border-radius: 12px;
        padding: 12px 20px;
        margin-bottom: 20px;
        border: none;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .alert-info-custom {
        background: linear-gradient(135deg, #e0f2fe 0%, #f0f9ff 100%);
        color: #0c4e6e;
        border-left: 4px solid #0ea5e9;
    }

    .alert-danger-custom {
        background: linear-gradient(135deg, #fee2e2 0%, #fef2f2 100%);
        color: #991b1b;
        border-left: 4px solid #dc2626;
    }

    .alert-success-custom {
        background: linear-gradient(135deg, #d1fae5 0%, #ecfdf5 100%);
        color: #065f46;
        border-left: 4px solid #10b981;
    }

    /* Botão Gerar na tabela */
    .btn-gerar {
        background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
        border: none;
        border-radius: 8px;
        padding: 6px 12px;
        font-size: 0.75rem;
        font-weight: 600;
        transition: all 0.2s ease;
        color: white;
        cursor: pointer;
    }

    .btn-gerar:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(72, 187, 120, 0.3);
    }

    /* Estatísticas */
    .stat-item {
        display: inline-block;
    }

    .stat-item .badge {
        font-size: 0.9rem;
        padding: 8px 16px;
        border-radius: 12px;
        font-weight: 500;
    }

    .badge.bg-warning {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        color: white;
    }

    .badge.bg-danger {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        color: white;
    }

    .badge.bg-info {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        color: white;
    }

    .filtro-ativo {
        outline: 2px solid #667eea;
        outline-offset: 2px;
        box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.2);
    }

    /* Animação para os cards de estatística */
    .stat-item .badge {
        transition: all 0.3s ease;
    }

    .stat-item .badge:hover {
        transform: scale(1.05);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    /* Indicador de referência mal gerada */
    .referencia-mal-gerada {
        background: #fee2e2 !important;
        border: 2px solid #dc2626 !important;
        animation: pulse-red 1.5s ease-in-out infinite;
        position: relative;
    }

    .referencia-mal-gerada::before {
        content: "⚠️";
        position: absolute;
        top: -8px;
        right: -8px;
        font-size: 14px;
    }

    @keyframes pulse-red {
        0% { opacity: 1; transform: scale(1); }
        50% { opacity: 0.7; transform: scale(0.98); }
        100% { opacity: 1; transform: scale(1); }
    }

    /* Painel de Estatísticas */
    .stats-panel {
        background: white;
        border-radius: 16px;
        padding: 15px 20px;
        margin-bottom: 20px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        border: 1px solid #e5e7eb;
    }

    .stats-panel .stat-group {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        align-items: center;
    }

    .stats-panel .stat-group .badge {
        font-size: 0.85rem;
        padding: 8px 14px;
    }

    .stats-panel .filter-group {
        display: flex;
        gap: 5px;
        flex-wrap: wrap;
    }

    .stats-panel .filter-group .btn {
        border-radius: 8px;
        font-size: 0.8rem;
        padding: 6px 14px;
    }

    @media (max-width: 768px) {
        .filter-section .row {
            flex-direction: column;
        }
        .filter-section .col-md-3 {
            margin-bottom: 15px;
        }
        .btn-modern, .btn-success-modern, .btn-danger-modern, .btn-warning-modern {
            width: 100%;
            margin-top: 10px;
        }
        .stats-panel .stat-group {
            flex-direction: column;
            align-items: stretch;
        }
        .stats-panel .filter-group {
            justify-content: center;
            margin-top: 10px;
        }
    }
</style>

<div class="">
    <div class="breadcrumb-modern animate-fadeInUp">
        <ol class="breadcrumb" style="background: transparent; margin: 0; padding: 0;">
            <li class="breadcrumb-item">
                <a href="#"><i class="fa fa-money"></i> Gestão Financeira</a>
            </li>
            <li class="breadcrumb-item">
                <a href="#"><i class="fa fa-bank"></i> Referências Bancárias</a>
            </li>
            <li class="breadcrumb-item active">
                <i class="fa fa-eye"></i> <b>Visualizar</b>
            </li>
        </ol>
    </div>

    <section class="content">
        <div class="">
            <div class="container-fluid fade-in">

                <!-- ===== ALERTA DE PERÍODO COM MULTA ===== -->
                <?php
                    $diaAtual = \Carbon\Carbon::now()->day;
                    $dataMaiorQue11 = $diaAtual > 11;
                ?>

                <div class="alert <?php echo e($dataMaiorQue11 ? 'alert-danger-custom' : 'alert-info-custom'); ?> alert-custom mb-4">
                    <i class="fa <?php echo e($dataMaiorQue11 ? 'fa-exclamation-triangle' : 'fa-info-circle'); ?> fa-2x"></i>
                    <div class="flex-grow-1">
                        <strong>
                            <?php if($dataMaiorQue11): ?>
                                ⚠️ PERÍODO COM APLICAÇÃO DE MULTA (Dia <?php echo e($diaAtual); ?>)
                            <?php else: ?>
                                ℹ️ PERÍODO SEM MULTA (Dia <?php echo e($diaAtual); ?>)
                            <?php endif; ?>
                        </strong>
                        <br>
                        <small>
                            <?php if($dataMaiorQue11): ?>
                                Referências vencidas estão sujeitas a multa a partir do dia 11.
                            <?php else: ?>
                                Multa será aplicada apenas a partir do dia 11.
                            <?php endif; ?>
                        </small>
                    </div>
                    <div class="text-right">
                        <span class="badge <?php echo e($dataMaiorQue11 ? 'badge-danger' : 'badge-info'); ?>" style="font-size: 0.9rem; padding: 8px 16px;">
                            <i class="fa fa-calendar"></i> Dia <?php echo e($diaAtual); ?>

                        </span>
                        <?php if($dataMaiorQue11): ?>
                            <span class="badge badge-danger ml-2" style="font-size: 0.9rem; padding: 8px 16px; background: #dc2626;">
                                <i class="fa fa-exclamation-circle"></i> Multa Ativa
                            </span>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Alerta informativo -->
                <div class="alert alert-info-custom alert-custom mb-4">
                    <i class="fa fa-info-circle fa-2x"></i>
                    <div>
                        <strong>Como funciona?</strong><br>
                        Selecione os filtros desejados e clique em "Consultar Referências".
                        O filtro de mês é opcional - se não selecionar, serão exibidos todos os meses disponíveis.
                    </div>
                </div>

                <!-- ===== FILTROS ===== -->
                <div class="filter-section">
                    <div class="row">
                        <div class="col-md-3">
                            <label class="filter-title">
                                <i class="fa fa-university"></i> Banco
                            </label>
                            <select class="filter-select" name="Entidade" id="selectEntidade">
                                <?php $__currentLoopData = $banco; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bancoItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($bancoItem->id); ?>">
                                        <?php echo e($bancoItem->descricao); ?> (<?php echo e($bancoItem->Entidade); ?>)
                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="filter-title">
                                <i class="fa fa-calendar"></i> Ano Lectivo
                            </label>
                            <select class="filter-select" name="anolectivo" id="selectAnoLectivo">
                                <?php $__currentLoopData = $anolectivo; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $anolectivoItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($anolectivoItem->id); ?>">
                                        <?php echo e($anolectivoItem->anolectivo); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="filter-title">
                                <i class="fa fa-credit-card"></i> Tipo de Pagamento
                            </label>
                            <select class="filter-select" name="tipopagamento" id="selectTipoPagamento">
                                <?php $__currentLoopData = $tipopagamento; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tipodepagamentoItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($tipodepagamentoItem->id > 2): ?>
                                        <option value="<?php echo e($tipodepagamentoItem->id); ?>">
                                            <?php echo e($tipodepagamentoItem->Descricao); ?>

                                        </option>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="filter-title">
                                <i class="fa fa-graduation-cap"></i> Classe
                            </label>
                            <select class="filter-select" name="classe" id="selectClasse">
                                <?php $__currentLoopData = $classes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $classeItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($classeItem->id); ?>">
                                        <?php echo e($classeItem->Descricao); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-3">
                            <label class="filter-title">
                                <i class="fa fa-calendar-alt"></i> Mês
                            </label>
                            <select class="filter-select" name="mes" id="selectMes">
                                <option value="">Todos os meses</option>
                            </select>
                        </div>

                        <div class="col-md-9 d-flex align-items-end gap-2 flex-wrap">
                            <button class="btn-modern" id="btnConsultar" onclick="consultarReferencias()">
                                <i class="fa fa-search mr-2"></i> Consultar Referências
                            </button>
                            <button class="btn-success-modern" id="btnGerarTodas" onclick="gerarTodasReferencias()">
                                <i class="fa fa-file-pdf-o mr-2"></i> Gerar Todas
                            </button>
                            <button class="btn-danger-modern" onclick="verificarReferenciasMalGeradas()">
                                <i class="fa fa-shield"></i> Verificar Mal Geradas
                            </button>
                            <button class="btn-warning-modern" onclick="gerarReferenciasPorGerar()">
                                <i class="fa fa-refresh"></i> Gerar Pendentes
                            </button>
                        </div>
                    </div>
                </div>

                <!-- ===== PAINEL DE ESTATÍSTICAS ===== -->
                <div class="stats-panel" id="statsPanel" style="display: none;">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <div class="stat-group">
                                <span class="badge bg-primary">
                                    <i class="fa fa-users"></i> Total: <span id="totalAlunos">0</span>
                                </span>
                                <span class="badge bg-success">
                                    <i class="fa fa-check-circle"></i> Com Ref.: <span id="totalComReferencia">0</span>
                                </span>
                                <span class="badge bg-warning">
                                    <i class="fa fa-exclamation-triangle"></i> Por Gerar: <span id="totalPorGerar">0</span>
                                </span>
                                <span class="badge bg-danger">
                                    <i class="fa fa-times-circle"></i> Mal Geradas: <span id="totalMalGeradas">0</span>
                                </span>
                                <span class="badge bg-info">
                                    <i class="fa fa-clock-o"></i> Vencidas: <span id="totalVencidas">0</span>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-4 text-md-right">
                            <div class="filter-group">
                                <button class="btn btn-outline-primary btn-sm filtro-ativo" onclick="filtrarTabela('todos')">
                                    <i class="fa fa-list"></i> Todos
                                </button>
                                <button class="btn btn-outline-warning btn-sm" onclick="filtrarTabela('por-gerar')">
                                    <i class="fa fa-exclamation-triangle"></i> Por Gerar
                                </button>
                                <button class="btn btn-outline-danger btn-sm" onclick="filtrarTabela('mal-geradas')">
                                    <i class="fa fa-times-circle"></i> Mal Geradas
                                </button>
                                <button class="btn btn-outline-success btn-sm" onclick="filtrarTabela('com-referencia')">
                                    <i class="fa fa-check-circle"></i> Com Ref.
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ===== RESULTADOS ===== -->
                <div class="results-table fade-in" id="resultsContainer">
                    <div class="empty-state">
                        <i class="fa fa-chart-line"></i>
                        <p class="mt-2">Selecione os filtros e clique em "Consultar Referências"</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Modal Visualizar Referências -->
<div class="modal fade modal-modern" id="modalVisualizar" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fa fa-file-pdf-o mr-2"></i>
                    Referência de Pagamento
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modalBodyReferencia" style="min-height: 500px;">
                <div class="loading-container">
                    <div class="loading-spinner"></div>
                    <p class="mt-3 text-muted">A carregar referência...</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fa fa-times"></i> Fechar
                </button>
                <button type="button" class="btn btn-success" id="btnImprimirReferencia" onclick="imprimirReferenciaAtual()">
                    <i class="fa fa-print"></i> Imprimir
                </button>
            </div>
        </div>
    </div>
</div>

<?php echo $__env->make("Componetes.frame-imprimir", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="<?php echo e(asset('Admin-LTE/plugins/jquery/jquery.min.js')); ?>"></script>
<script src="<?php echo e(asset('Datatable/js/jquery.dataTables.min.js')); ?>"></script>
<script src="<?php echo e(asset('Admin-LTE/plugins/bootstrap/js/bootstrap.bundle.min.js')); ?>"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="<?php echo e(asset('MyJs/imprimirRecibo.js')); ?>"></script>

<script>
    var meses = <?php echo json_encode($detalhes, 15, 512) ?>;
    var currentBlobUrl = null;
    var dataTableInstance = null;

    // ========================================
    // FUNÇÕES AUXILIARES
    // ========================================

    function formatMoney(value) {
        return new Intl.NumberFormat('pt-MZ', {
            style: 'currency',
            currency: 'MZN',
            minimumFractionDigits: 2
        }).format(value).replace('MT', '');
    }

    function isPeriodoMulta() {
        return new Date().getDate() > 11;
    }

    function getDiaAtual() {
        return new Date().getDate();
    }

    function isReferenciaMalGerada(referencia) {
        if (!referencia) return false;
        var apenasNumeros = referencia.replace(/[^0-9]/g, '');
        return apenasNumeros.length < 11;
    }

    // ========================================
    // DATATABLE
    // ========================================

    function destroyDataTable() {
        if (dataTableInstance) {
            dataTableInstance.destroy();
            dataTableInstance = null;
        }
        if ($.fn.DataTable.isDataTable('#listadosalunos')) {
            $('#listadosalunos').DataTable().destroy();
        }
    }

    function initDataTable() {
        if ($('#listadosalunos').length && $('#listadosalunos tbody tr').length > 0) {
            destroyDataTable();
            dataTableInstance = $('#listadosalunos').DataTable({
                language: {
                    url: "/Datatable/pt/Portuguese-Brasil.json"
                },
                responsive: true,
                pageLength: 10,
                dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>rt<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
                deferRender: true,
                destroy: true
            });
        }
    }

    // ========================================
    // CARREGAR MESES
    // ========================================

    function carregarMeses() {
        var ano = parseInt($("#selectAnoLectivo").val());
        var tipopagamento = $("#selectTipoPagamento").val();
        var classe = parseInt($("#selectClasse").val());

        if (!ano || !tipopagamento || !classe) {
            $("#selectMes").html('<option value="">Selecione todos os filtros primeiro</option>');
            return;
        }

        const mesesFiltrados = meses.filter(function(e) {
            return Number(e.classe_id) === Number(classe) &&
                   Number(e.anolectivo_id) === Number(ano) &&
                   Number(e.tipo) === Number(tipopagamento);
        });

        var html = '<option value="">Todos os meses</option>';
        if (mesesFiltrados.length > 0) {
            mesesFiltrados.forEach(function(element) {
                html += '<option value="' + element.mes + '">' + element.mesNome + '</option>';
            });
        } else {
            html += '<option value="" disabled>Nenhum mês disponível</option>';
        }
        $("#selectMes").html(html);
    }

    // ========================================
    // ATUALIZAR ESTATÍSTICAS
    // ========================================

    function atualizarEstatisticas() {
        var total = 0;
        var comReferencia = 0;
        var porGerar = 0;
        var malGeradas = 0;
        var vencidas = 0;

        $('#listadosalunos tbody tr').each(function() {
            var linha = $(this);
            total++;

            var temReferencia = linha.find('.badge').length > 0;
            var temBotaoGerar = linha.find('.AtualizarReferencia').length > 0;

            if (temReferencia) {
                comReferencia++;
                var badge = linha.find('td:eq(4) .badge');
                var texto = badge.text().trim();
                var match = texto.match(/[0-9\-\s]+/);
                if (match) {
                    var referencia = match[0].trim();
                    if (isReferenciaMalGerada(referencia)) {
                        malGeradas++;
                    }
                }
                var statusCell = linha.find('td:eq(6)');
                if (statusCell.find('.text-danger').length > 0) {
                    vencidas++;
                }
            }
            if (temBotaoGerar) {
                porGerar++;
            }
        });

        $('#totalAlunos').text(total);
        $('#totalComReferencia').text(comReferencia);
        $('#totalPorGerar').text(porGerar);
        $('#totalMalGeradas').text(malGeradas);
        $('#totalVencidas').text(vencidas);

        if (total > 0) {
            $('#statsPanel').show();
        }
    }

    // ========================================
    // CONSULTAR REFERÊNCIAS
    // ========================================

    function consultarReferencias() {
        var entidade = $("#selectEntidade").val();
        var mes = $("#selectMes").val();
        var anolectivo = $("#selectAnoLectivo").val();
        var tipopagamento = $("#selectTipoPagamento").val();
        var classe = $("#selectClasse").val();

        if (!anolectivo || !tipopagamento || !classe) {
            $("#resultsContainer").html(`
                <div class="empty-state">
                    <i class="fa fa-exclamation-triangle"></i>
                    <p class="mt-2">Por favor, selecione todos os filtros necessários</p>
                </div>
            `);
            $('#statsPanel').hide();
            return;
        }

        $.ajax({
            url: "/Financas/Banco/referencas/show",
            type: "GET",
            data: {
                "Entidade": entidade,
                "mes": mes,
                "anolectivo": anolectivo,
                "tipopagamento": tipopagamento,
                "classe": classe,
            },
            beforeSend: function() {
                $("#resultsContainer").html(`
                    <div class="loading-container">
                        <div class="loading-spinner"></div>
                        <p class="mt-3 text-muted">A carregar dados...</p>
                    </div>
                `);
                $('#statsPanel').hide();
            },
            success: function(data) {
                if (data && data.trim() !== "") {
                    $("#resultsContainer").html(data);
                    setTimeout(function() {
                        initDataTable();
                        setTimeout(function() {
                            atualizarEstatisticas();
                            verificarReferenciasMalGeradas(false);
                        }, 200);
                    }, 100);
                } else {
                    $("#resultsContainer").html(`
                        <div class="empty-state">
                            <i class="fa fa-search"></i>
                            <p class="mt-2">Nenhum resultado encontrado para os filtros selecionados</p>
                            <small class="text-muted">Tente alterar os filtros ou selecionar um mês específico</small>
                        </div>
                    `);
                    $('#statsPanel').hide();
                }
            },
            error: function(xhr) {
                console.error("Erro:", xhr);
                $("#resultsContainer").html(`
                    <div class="empty-state">
                        <i class="fa fa-exclamation-triangle"></i>
                        <p class="mt-2">Erro ao carregar os dados. Tente novamente.</p>
                        <button class="btn btn-modern mt-3" onclick="consultarReferencias()">
                            <i class="fa fa-refresh"></i> Tentar novamente
                        </button>
                    </div>
                `);
                $('#statsPanel').hide();
            }
        });
    }

    // ========================================
    // VERIFICAR REFERÊNCIAS MAL GERADAS
    // ========================================

    function verificarReferenciasMalGeradas(mostrarAlerta = true) {
        var totalMalGeradas = 0;
        var referenciasMalGeradas = [];

        $('#listadosalunos tbody tr').each(function() {
            var linha = $(this);
            var referenciaCell = linha.find('td:eq(4)');
            var badge = referenciaCell.find('.badge');

            if (badge.length > 0) {
                var referenciaTexto = badge.text().trim();
                var match = referenciaTexto.match(/[0-9\-\s]+/);
                if (match) {
                    var referencia = match[0].trim();
                    if (isReferenciaMalGerada(referencia)) {
                        totalMalGeradas++;
                        referenciasMalGeradas.push({
                            linha: linha,
                            referencia: referencia,
                            nome: linha.find('td:eq(1) strong').text() || 'N/A'
                        });
                        badge.addClass('referencia-mal-gerada');
                        if (!badge.find('.mal-gerada-label').length) {
                            badge.append('<br><small class="text-danger mal-gerada-label"><i class="fa fa-exclamation-circle"></i> Mal gerada (<11)</small>');
                        }
                    } else {
                        badge.removeClass('referencia-mal-gerada');
                        badge.find('.mal-gerada-label').remove();
                    }
                }
            }
        });

        $('#totalMalGeradas').text(totalMalGeradas);

        if (mostrarAlerta) {
            if (totalMalGeradas > 0) {
                var listaNomes = referenciasMalGeradas.map(function(item) {
                    return `${item.nome}: ${item.referencia}`;
                }).join('\n');

                Swal.fire({
                    icon: 'warning',
                    title: `⚠️ ${totalMalGeradas} Referência(s) Mal Gerada(s)`,
                    html: `<div class="text-left">
                            <p><strong>Referências com menos de 11 dígitos:</strong></p>
                            <pre style="max-height: 300px; overflow: auto; background: #f3f4f6; padding: 10px; border-radius: 8px;">${listaNomes}</pre>
                            <p class="mt-2 text-muted">Deseja corrigir estas referências?</p>
                           </div>`,
                    showCancelButton: true,
                    confirmButtonColor: '#dc2626',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: '<i class="fa fa-refresh"></i> Regenerar Todas',
                    cancelButtonText: 'Fechar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        regenerarReferenciasMalGeradas(referenciasMalGeradas);
                    }
                });
            } else {
                Swal.fire({
                    icon: 'success',
                    title: '✅ Nenhuma referência mal gerada encontrada!',
                    text: 'Todas as referências têm 11 dígitos ou mais.',
                    confirmButtonColor: '#10b981'
                });
            }
        }
    }

    // ========================================
    // REGENERAR REFERÊNCIAS MAL GERADAS
    // ========================================

    function regenerarReferenciasMalGeradas(referenciasMalGeradas) {
        if (referenciasMalGeradas.length === 0) {
            Swal.fire('Info', 'Nenhuma referência mal gerada para corrigir.', 'info');
            return;
        }

        var entidade = $("#selectEntidade").val();
        if (!entidade) {
            Swal.fire('Atenção!', 'Selecione um banco/entidade primeiro', 'warning');
            return;
        }

        Swal.fire({
            title: 'Regenerando Referências',
            html: `<div class="text-center">
                    <div class="spinner-border text-primary mb-3" role="status"></div>
                    <h5>Corrigindo ${referenciasMalGeradas.length} referência(s)</h5>
                    <div class="progress mt-3">
                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-danger"
                             style="width: 0%">0%</div>
                    </div>
                   </div>`,
            showConfirmButton: false,
            allowOutsideClick: false
        });

        let index = 0;
        let sucessos = 0;
        let falhas = 0;

        function regenerarProxima() {
            if (index >= referenciasMalGeradas.length) {
                Swal.fire({
                    icon: sucessos > 0 ? 'success' : 'warning',
                    title: 'Processo Concluído!',
                    html: `<strong>Resumo:</strong><br>
                           ✅ Corrigidas: ${sucessos}<br>
                           ❌ Falhas: ${falhas}<br>
                           📊 Total: ${referenciasMalGeradas.length}`,
                    confirmButtonColor: '#3085d6'
                }).then(() => {
                    if (sucessos > 0) {
                        setTimeout(() => location.reload(), 2000);
                    }
                });
                return;
            }

            var item = referenciasMalGeradas[index];
            var linha = item.linha;
            var botaoGerar = linha.find('.AtualizarReferencia');
            var id = botaoGerar.attr('value');

            if (!id || botaoGerar.length === 0) {
                index++;
                regenerarProxima();
                return;
            }

            var percentual = ((index + 1) / referenciasMalGeradas.length) * 100;
            Swal.update({
                html: `<div class="text-center">
                        <div class="spinner-border text-primary mb-3" role="status"></div>
                        <h5>Corrigindo ${index + 1} de ${referenciasMalGeradas.length}</h5>
                        <p class="text-muted">${item.nome}</p>
                        <div class="progress mt-3">
                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-danger"
                                 style="width: ${percentual}%">${Math.round(percentual)}%</div>
                        </div>
                        <small>✅ ${sucessos} corrigidas | ❌ ${falhas} falhas</small>
                       </div>`
            });

            var originalHtml = botaoGerar.html();
            botaoGerar.html('<i class="fa fa-spinner fa-spin"></i>').prop('disabled', true);

            $.ajax({
                url: '/Financas/Banco/referencas/gerar/' + id + '/' + entidade,
                type: 'POST',
                dataType: 'json',
                data: {
                    _token: '<?php echo e(csrf_token()); ?>'
                },
                success: function(response) {
                    if (response.referenciaBanco) {
                        sucessos++;
                        var cell = linha.find('td:eq(4)');
                        var badge = cell.find('.badge');
                        badge.removeClass('referencia-mal-gerada');
                        badge.find('.mal-gerada-label').remove();

                        var novaRef = response.referenciaBanco;
                        if (!isReferenciaMalGerada(novaRef)) {
                            badge.text(novaRef);
                            badge.removeClass('bg-danger bg-warning').addClass('bg-success');
                        } else {
                            badge.text(novaRef);
                            badge.removeClass('bg-success').addClass('bg-warning');
                        }
                    } else {
                        falhas++;
                    }
                    botaoGerar.html(originalHtml).prop('disabled', false);
                    index++;
                    regenerarProxima();
                },
                error: function() {
                    falhas++;
                    botaoGerar.html(originalHtml).prop('disabled', false);
                    index++;
                    regenerarProxima();
                }
            });
        }
        regenerarProxima();
    }

    // ========================================
    // FILTRAR TABELA
    // ========================================

    function filtrarTabela(tipo) {
        if (!dataTableInstance) {
            Swal.fire('Atenção', 'Carregue os dados primeiro.', 'warning');
            return;
        }

        $('.filter-group .btn').removeClass('filtro-ativo');

        switch(tipo) {
            case 'todos':
                dataTableInstance.search('').draw();
                dataTableInstance.rows().every(function() {
                    $(this.node()).show();
                });
                $('.filter-group .btn-outline-primary').addClass('filtro-ativo');
                break;

            case 'por-gerar':
                $('#listadosalunos tbody tr').each(function() {
                    var linha = $(this);
                    if (linha.find('.AtualizarReferencia').length > 0) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
                $('.filter-group .btn-outline-warning').addClass('filtro-ativo');
                break;

            case 'mal-geradas':
                $('#listadosalunos tbody tr').each(function() {
                    var linha = $(this);
                    var badge = linha.find('td:eq(4) .badge');
                    if (badge.length > 0 && badge.hasClass('referencia-mal-gerada')) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
                $('.filter-group .btn-outline-danger').addClass('filtro-ativo');
                break;

            case 'com-referencia':
                $('#listadosalunos tbody tr').each(function() {
                    var linha = $(this);
                    if (linha.find('.badge').length > 0 && linha.find('.AtualizarReferencia').length === 0) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
                $('.filter-group .btn-outline-success').addClass('filtro-ativo');
                break;
        }
    }

    // ========================================
    // GERAR REFERÊNCIA INDIVIDUAL
    // ========================================

    function gerarReferenciaIndividual(idpagamento, idaluno, nomeAluno) {
        const url = `/Financas/Banco/referencas/alunoReferenciasPrint/${idaluno}/${idpagamento}/0`;
        abrirReciboPDF(url, idaluno);
    }

    // ========================================
    // GERAR REFERÊNCIAS POR GERAR
    // ========================================

    function gerarReferenciasPorGerar() {
        var botoesGerar = $('.AtualizarReferencia');

        if (botoesGerar.length === 0) {
            Swal.fire('Info', 'Nenhuma referência pendente para gerar.', 'info');
            return;
        }

        var comMulta = isPeriodoMulta();
        var diaAtual = getDiaAtual();

        Swal.fire({
            title: 'Gerar Referências Pendentes',
            html: `Serão geradas <strong>${botoesGerar.length}</strong> referência(s).<br>
                   ${comMulta ? '<span class="text-danger">⚠️ Período com multa ativo (dia ' + diaAtual + ')</span><br>' : ''}
                   <small class="text-muted">Isso pode levar alguns segundos.</small>`,
            icon: comMulta ? 'warning' : 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Gerar Todas',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                gerarTodasReferencias();
            }
        });
    }

    // ========================================
    // GERAR TODAS AS REFERÊNCIAS
    // ========================================

    function gerarTodasReferencias() {
        var botoesGerar = $('.AtualizarReferencia');

        if (botoesGerar.length === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'Atenção',
                text: 'Nenhuma referência pendente encontrada para gerar.'
            });
            return;
        }

        var entidade = $("#selectEntidade").val();
        if (!entidade) {
            Swal.fire({
                title: 'Atenção!',
                text: 'Selecione um banco/entidade primeiro',
                icon: 'warning',
                confirmButtonColor: '#3085d6'
            });
            return;
        }

        var comMulta = isPeriodoMulta();
        var diaAtual = getDiaAtual();

        Swal.fire({
            title: comMulta ? '⚠️ Período com Multa' : 'Confirmar Geração',
            text: `Deseja gerar referências para ${botoesGerar.length} aluno(s)?` +
                  (comMulta ? '\n⚠️ Período com multa ativo (dia ' + diaAtual + ')' : ''),
            icon: comMulta ? 'warning' : 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sim, gerar todas',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                let index = 0;
                let sucessos = 0;
                let falhas = 0;
                let botoes = botoesGerar.toArray();

                function gerarProxima() {
                    if (index >= botoes.length) {
                        Swal.fire({
                            icon: sucessos > 0 ? 'success' : 'warning',
                            title: 'Processo Concluído!',
                            html: `<strong>Resumo:</strong><br>
                                   ✅ Geradas com sucesso: ${sucessos}<br>
                                   ❌ Falhas: ${falhas}<br>
                                   📊 Total: ${botoes.length}`,
                            confirmButtonColor: '#3085d6'
                        }).then(() => {
                            if (sucessos > 0) {
                                setTimeout(() => location.reload(), 2000);
                            }
                        });
                        return;
                    }

                    var btn = $(botoes[index]);
                    var id = btn.attr('value');
                    var linhaTabela = btn.closest('tr');
                    var originalHtml = btn.html();

                    var percentual = ((index) / botoes.length) * 100;
                    Swal.update({
                        html: `<div class="text-center">
                                <div class="spinner-border text-primary mb-3" role="status"></div>
                                <h5>Processando referência ${index + 1} de ${botoes.length}</h5>
                                <p class="text-muted">Aluno: ${linhaTabela.find('td:eq(1)').find('strong').text() || 'Carregando...'}</p>
                                ${comMulta ? '<p class="text-danger"><small>⚠️ Período com multa</small></p>' : ''}
                                <div class="progress mt-3">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-success"
                                         style="width: ${percentual}%">
                                        ${Math.round(percentual)}%
                                    </div>
                                </div>
                                <small class="text-muted mt-2 d-block">✅ ${sucessos} geradas | ❌ ${falhas} falhas</small>
                            </div>`,
                        showConfirmButton: false,
                        allowOutsideClick: false
                    });

                    btn.html('<i class="fa fa-spinner fa-spin"></i>').prop('disabled', true);

                    $.ajax({
                        url: '/Financas/Banco/referencas/gerar/' + id + '/' + entidade,
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            _token: '<?php echo e(csrf_token()); ?>'
                        },
                        success: function(response) {
                            if (response.referenciaBanco) {
                                sucessos++;

                                var badgeClass = 'badge bg-success';
                                var badgeIcon = 'fa fa-check-circle';

                                if (response.multaflagrefe > 0) {
                                    badgeClass = 'badge bg-danger';
                                    badgeIcon = 'fa fa-exclamation-circle';
                                } else if (response.Estado === "Pago") {
                                    badgeClass = 'badge bg-success';
                                    badgeIcon = 'fa fa-check-circle';
                                } else {
                                    badgeClass = 'badge bg-warning';
                                    badgeIcon = 'fa fa-clock-o';
                                }

                                var cell = linhaTabela.find('td:eq(4)');
                                var referenciaHtml = '<span class="' + badgeClass + '" style="font-size: 0.8rem; padding: 0.4rem 0.8rem;">';
                                referenciaHtml += '<i class="' + badgeIcon + '"></i> ' + (response.referenciaBanco || response.referencia);

                                if (response.multaflagrefe > 0) {
                                    referenciaHtml += '<small class="d-block text-danger"><i class="fa fa-exclamation-circle"></i> Com multa</small>';
                                }

                                referenciaHtml += '</span>';
                                cell.html(referenciaHtml);

                                // Atualizar valor
                                if (response.valorDescricao) {
                                    var valorFinal = response.valorDescricao;
                                    if (response.multaflagrefe > 0 && response.multaP > 0) {
                                        var multaValor = (response.multaP / 100) * valorFinal;
                                        valorFinal = valorFinal + multaValor;
                                    }
                                    var valorCell = linhaTabela.find('td:eq(5)');
                                    var valorClass = (response.multaflagrefe > 0) ? 'text-danger' : 'text-primary';
                                    var valorHtml = '<strong class="' + valorClass + '">' + formatMoney(valorFinal) + ' MZN</strong>';
                                    if (response.multaflagrefe > 0 && response.multaP > 0) {
                                        valorHtml += '<small class="d-block text-danger">Multa: ' + formatMoney(multaValor) + ' (' + response.multaP + '%)</small>';
                                    }
                                    valorCell.html(valorHtml);
                                }

                                // Atualizar estado
                                var estadoCell = linhaTabela.find('td:eq(6)');
                                if (response.multaflagrefe > 0) {
                                    estadoCell.html('<span class="text-danger"><i class="fa fa-exclamation-triangle"></i> VENCIDO COM MULTA</span>');
                                } else if (response.Estado === "Pago") {
                                    estadoCell.html('<span class="text-success"><i class="fa fa-check-circle"></i> Pago</span>');
                                } else {
                                    estadoCell.html('<span class="text-warning"><i class="fa fa-clock-o"></i> Pendente</span>');
                                }

                                // Adicionar botão de impressão
                                var acoesCell = linhaTabela.find('td:eq(7)');
                                if (acoesCell.find('.btn-secondary').length === 0 && response.id) {
                                    var tipoPagamentoId = response.tipo_pagamento_id || response.tipoPagamento_id || response.idpagamento;
                                    var printBtn = '<a class="btn btn-secondary btn-sm" href="/Financas/Banco/referencas/alunoReferenciasPrint/' + response.id + '/' + tipoPagamentoId + '/0" target="_blank" title="Imprimir Referência"><i class="fa fa-print"></i></a>';
                                    acoesCell.find('.btn-group').append(printBtn);
                                }
                            } else {
                                falhas++;
                                btn.html(originalHtml).prop('disabled', false);
                            }

                            var percentual = ((index + 1) / botoes.length) * 100;
                            Swal.update({
                                html: `<div class="text-center">
                                        <div class="spinner-border text-primary mb-3" role="status"></div>
                                        <h5>Processando referência ${index + 1} de ${botoes.length}</h5>
                                        <p class="text-muted">✅ ${sucessos} geradas | ❌ ${falhas} falhas</p>
                                        <div class="progress mt-3">
                                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-success"
                                                 style="width: ${percentual}%">
                                                ${Math.round(percentual)}%
                                            </div>
                                        </div>
                                        <small class="text-muted mt-2 d-block">Continuando...</small>
                                    </div>`
                            });

                            index++;
                            gerarProxima();
                        },
                        error: function(xhr) {
                            console.error('Erro:', xhr);
                            falhas++;
                            btn.html(originalHtml).prop('disabled', false);
                            index++;
                            gerarProxima();
                        }
                    });
                }

                gerarProxima();
            }
        });
    }

    // ========================================
    // IMPRIMIR REFERÊNCIA
    // ========================================

    function imprimirReferenciaAtual() {
        if (currentBlobUrl) {
            window.open(currentBlobUrl, '_blank');
        } else {
            Swal.fire({
                icon: 'warning',
                title: 'Atenção',
                text: 'Nenhuma referência carregada para impressão.'
            });
        }
    }

    // ========================================
    // EVENTOS
    // ========================================

    $(document).ready(function() {
        carregarMeses();
        consultarReferencias();

        $("#selectAnoLectivo, #selectTipoPagamento, #selectClasse").on("change", function() {
            carregarMeses();
        });

        $("#selectAnoLectivo, #selectTipoPagamento, #selectClasse, #selectEntidade, #selectMes").on("change", function() {
            consultarReferencias();
        });

        $(document).on("click", ".visualizarentidadesReferencias", function(e) {
            e.preventDefault();
            var idpagamento = $(this).attr("idpagamento");
            var idaluno = $(this).attr("idaluno");
            var nomeAluno = $(this).attr("nome") || "Aluno";
            gerarReferenciaIndividual(idpagamento, idaluno, nomeAluno);
        });
    });
</script>
<?php $__env->stopPush(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin-Lti', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\escolasaojoaopaulo\resources\views/Financas/Banco/visualizar-referencias.blade.php ENDPATH**/ ?>