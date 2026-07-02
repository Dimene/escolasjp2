<?php $__env->startSection('title', 'Dashboard Financeiro'); ?>

<?php $__env->startSection('content'); ?>
<style>
    /* Animações e melhorias visuais */
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }
    @keyframes slideInRight {
        from { opacity: 0; transform: translateX(50px); }
        to { opacity: 1; transform: translateX(0); }
    }
    .animate-fadeInUp { animation: fadeInUp 0.5s ease-out; }
    .animate-slideInRight { animation: slideInRight 0.5s ease-out; }

    .info-box {
        border-radius: 15px;
        transition: all 0.3s ease;
        cursor: pointer;
        position: relative;
        overflow: hidden;
    }
    .info-box:hover { transform: translateY(-5px); box-shadow: 0 10px 25px rgba(0,0,0,0.1); }
    .info-box:hover .info-box-icon { transform: scale(1.1); }
    .info-box-icon { transition: all 0.3s ease; border-radius: 12px; }
    .info-box-number { font-size: 24px; font-weight: bold; }

    .filter-card {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border: none;
        border-radius: 20px;
    }
    .filter-card .form-control {
        border-radius: 10px;
        border: 2px solid #e0e0e0;
    }
    .filter-card .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102,126,234,0.25);
    }

    /* Estilos do relatório detalhado */
    .date-card {
        border: none;
        border-radius: 24px;
        overflow: hidden;
        margin-bottom: 2rem;
        box-shadow: 0 8px 20px rgba(0,0,0,0.05);
        transition: transform 0.2s ease;
    }
    .date-card:hover { transform: translateY(-3px); }
    .card-header-custom {
        background: linear-gradient(98deg, #1e4663 0%, #2a628f 100%);
        padding: 1rem 1.8rem;
        border: none;
    }
    .total-card {
        background: linear-gradient(120deg, #e9f0f5 0%, #ffffff 100%);
        border-radius: 18px;
        padding: 1rem 1.5rem;
        margin-bottom: 1.5rem;
        border-left: 5px solid #2a628f;
    }
    .total-value-lg { font-size: 1.9rem; font-weight: 800; color: #1e4663; }
    .class-card {
        background: white;
        border-radius: 18px;
        margin-bottom: 1.5rem;
        border: 1px solid #e9ecef;
    }
    .class-header {
        background: #f8f9fc;
        padding: 1rem 1.5rem;
        border-bottom: 2px solid #e9ecef;
        border-radius: 18px 18px 0 0;
        cursor: pointer;
    }
    .method-group {
        border-left: 3px solid #2a628f;
        margin: 1rem 1rem 1rem 2rem;
        background: #ffffff;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    }
    .method-header {
        padding: 0.75rem 1rem;
        background: #f2f6fc;
        border-radius: 12px 12px 0 0;
        cursor: pointer;
    }
    .student-list { padding: 0.5rem 1rem; display: none; }
    .student-item {
        padding: 0.5rem 0.75rem;
        border-bottom: 1px solid #f0f0f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
    }
    .badge-metodo {
        background: #e7f0ff;
        color: #004e92;
        padding: 0.35rem 1rem;
        border-radius: 30px;
        font-weight: 500;
        font-size: 0.8rem;
    }
    .badge-status {
        padding: 0.3rem 0.8rem;
        border-radius: 40px;
        font-weight: 600;
        font-size: 0.7rem;
    }
    .badge-pago { background: #d4edda; color: #155724; }
    .modal-details .modal-content { border-radius: 20px; }
    .toggle-icon, .toggle-icon-method { transition: transform 0.2s; }
    .btn-print { border-radius: 40px; padding: 0.5rem 1.5rem; font-weight: 500; }
    @media (max-width: 768px) {
        .method-group { margin-left: 0.5rem; margin-right: 0.5rem; }
        .student-item { flex-direction: column; align-items: flex-start; gap: 8px; }
    }
    .chart-container {
        background: white;
        border-radius: 20px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    }
    canvas { max-height: 350px; width: 100%; }
</style>

<section class="content">
    <div class="content-header">
        <div class="container-fluid">
            <div class="breadcrumb-modern animate-fadeInUp">
                <ol class="breadcrumb" style="background: transparent; margin: 0; padding: 0;">
                    <li class="breadcrumb-item"><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                    <li class="breadcrumb-item active"><i class="fa fa-chart-line"></i> Financeiro</li>
                </ol>
            </div>
        </div>
    </div>

    
    <div class="container-fluid animate-fadeInUp" style="animation-delay: 0.1s;">
        <form method="GET" action="<?php echo e(route('dashboard.financeiro')); ?>" class="card filter-card">
            <div class="card-body row">
                <div class="col-md-4">
                    <label><i class="fa fa-calendar"></i> <strong>Ano Lectivo</strong></label>
                    <select name="ano" class="form-control">
                        <?php $__currentLoopData = $anolectivo; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($a->id); ?>" <?php if($ano == $a->id): echo 'selected'; endif; ?>>📅 <?php echo e($a->anolectivo); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label><i class="fa fa-calendar-range"></i> <strong>Data Início</strong></label>
                    <input type="date" name="data1" class="form-control" value="<?php echo e($data1); ?>">
                </div>
                <div class="col-md-4">
                    <label><i class="fa fa-calendar-range"></i> <strong>Data Fim</strong></label>
                    <input type="date" name="data2" class="form-control" value="<?php echo e($data2); ?>">
                </div>
                <div class="col-md-4">
                    <label><i class="fa fa-credit-card"></i> <strong>Tipo de Pagamento</strong></label>
                    <select name="tipo" class="form-control">
                        <?php $__currentLoopData = $tipodepagamento; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tip): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($tip->id); ?>" <?php if($tipo == $tip->id): echo 'selected'; endif; ?>><?php echo e($tip->Descricao); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fa fa-filter"></i> Filtrar
                    </button>
                </div>
                <div class="col-md-4 d-flex align-items-end justify-content-end">
                    <button type="button" onclick="window.print()" class="btn btn-outline-secondary btn-print">
                        <i class="fa fa-print"></i> Imprimir
                    </button>
                </div>
            </div>
        </form>
    </div>

    
    <div class="container-fluid animate-fadeInUp" style="animation-delay: 0.2s;">
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
                <div class="info-box" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                    <span class="info-box-icon"><i class="fa fa-chart-line"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Total Arrecadado</span>
                        <span class="info-box-number"><?php echo e(number_format($totalGeral, 2, ',', '.')); ?> MT</span>
                        <small><?php echo e($pagamentos->count()); ?> transacções</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
                <div class="info-box" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); color: white;">
                    <span class="info-box-icon"><i class="fa fa-exclamation-triangle"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Total Multas</span>
                        <span class="info-box-number"><?php echo e(number_format($totalMultas, 2, ',', '.')); ?> MT</span>
                        <small>valores adicionais</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
                <div class="info-box" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); color: white;">
                    <span class="info-box-icon"><i class="fa fa-users"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Total Alunos</span>
                        <span class="info-box-number"><?php echo e($totalAlunos); ?></span>
                        <small>alunos únicos</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
                <div class="info-box" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white;">
                    <span class="info-box-icon"><i class="fa fa-ticket-alt"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Ticket Médio</span>
                        <span class="info-box-number"><?php echo e(number_format($mediaTicket, 2, ',', '.')); ?> MT</span>
                        <small>por transacção</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    <div class="container-fluid animate-fadeInUp" style="animation-delay: 0.25s;">
        <div class="row">
            <div class="col-md-6">
                <div class="chart-container">
                    <h5><i class="fa fa-chalkboard me-2"></i> Pagamentos e Multas por Classe</h5>
                    <canvas id="graficoClasses"></canvas>
                </div>
            </div>
            <div class="col-md-6">
                <div class="chart-container">
                    <h5><i class="fa fa-credit-card me-2"></i> Pagamentos e Multas por Via de Pagamento</h5>
                    <canvas id="graficoVias"></canvas>
                </div>
            </div>
        </div>
    </div>

    
    <div class="container-fluid">
        <?php
            $groupedByDate = $pagamentos->groupBy(function($item) {
                return \Carbon\Carbon::parse($item->data_pagamento)->format('Y-m-d');
            })->sortKeysDesc();
            $totalGeralPagos = $pagamentos->sum('valorDescricao');
        ?>

        <?php $__empty_1 = true; $__currentLoopData = $groupedByDate; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dateKey => $itemsByDate): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <?php
                $dateObj = \Carbon\Carbon::parse($dateKey);
                $diasSemana = ['Domingo','Segunda-feira','Terça-feira','Quarta-feira','Quinta-feira','Sexta-feira','Sábado'];
                $meses = ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'];
                $dataFormatada = $diasSemana[$dateObj->dayOfWeek].', '.$dateObj->format('d').' de '.$meses[$dateObj->month - 1].' de '.$dateObj->format('Y');
                $totalDia = $itemsByDate->sum('valorDescricao');
                $multasDia = $itemsByDate->sum('Multa');
                $porcentagemTotal = $totalGeralPagos > 0 ? ($totalDia / $totalGeralPagos) * 100 : 0;
            ?>

            <div class="date-card animate__animated animate__fadeInUp">
                <div class="card-header-custom text-white d-flex justify-content-between align-items-center flex-wrap">
                    <div>
                        <i class="fa fa-calendar-day me-2"></i>
                        <strong><?php echo e($dataFormatada); ?></strong>
                        <span class="ms-3 small opacity-75"><?php echo e($itemsByDate->count()); ?> pagamento(s)</span>
                    </div>
                    <div>
                        <span class="badge bg-light text-dark me-2"><?php echo e(number_format($porcentagemTotal,1)); ?>% do total</span>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div class="total-card d-flex justify-content-between align-items-center mb-4">
                        <div><i class="fa fa-hand-holding-usd fs-4 me-2 text-secondary"></i><span class="fw-semibold">Total do dia (sem multas):</span></div>
                        <div class="total-value-lg"><?php echo e(number_format($totalDia,2,',','.')); ?> MT</div>
                    </div>
                    <?php if($multasDia > 0): ?>
                    <div class="total-card d-flex justify-content-between align-items-center mb-4" style="border-left-color: #dc3545;">
                        <div><i class="fa fa-exclamation-triangle fs-4 me-2 text-danger"></i><span class="fw-semibold">Multas do dia:</span></div>
                        <div class="total-value-lg text-danger"><?php echo e(number_format($multasDia,2,',','.')); ?> MT</div>
                    </div>
                    <?php endif; ?>

                    <?php $groupedByClass = $itemsByDate->groupBy('classe'); ?>

                    <?php $__currentLoopData = $groupedByClass; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $classeNome => $itemsByClass): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php $classSlug = Str::slug($classeNome).'_'.$dateKey; ?>
                        <div class="class-card mb-4">
                            <div class="class-header d-flex justify-content-between align-items-center" data-toggle-class="<?php echo e($classSlug); ?>">
                                <h5 class="mb-0"><i class="fa fa-chalkboard-user me-2"></i> <?php echo e($classeNome); ?></h5>
                                <span><i class="fa fa-chevron-right toggle-icon" id="icon-<?php echo e($classSlug); ?>"></i></span>
                            </div>
                            <div id="class-content-<?php echo e($classSlug); ?>" style="display: none;">
                                <?php $groupedByMethod = $itemsByClass->groupBy('metodoPagDesc'); ?>
                                <?php $__currentLoopData = $groupedByMethod; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $metodoNome => $itemsByMethod): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php $methodSlug = Str::slug($metodoNome).'_'.$classSlug; ?>
                                    <div class="method-group">
                                        <div class="method-header d-flex justify-content-between align-items-center" data-toggle-method="<?php echo e($methodSlug); ?>">
                                            <div>
                                                <i class="fa fa-credit-card me-2"></i>
                                                <strong><?php echo e($metodoNome); ?></strong>
                                                <span class="badge-metodo ms-2"><?php echo e($itemsByMethod->count()); ?> aluno(s)</span>
                                            </div>
                                            <div>
                                                <span class="fw-semibold text-success"><?php echo e(number_format($itemsByMethod->sum('valorDescricao'),2,',','.')); ?> MT</span>
                                                <i class="fa fa-chevron-down toggle-icon-method ms-2" id="icon-method-<?php echo e($methodSlug); ?>"></i>
                                            </div>
                                        </div>
                                        <div id="method-content-<?php echo e($methodSlug); ?>" class="student-list">
                                            <?php $__currentLoopData = $itemsByMethod; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <div class="student-item">
                                                    <div>
                                                        <i class="fa fa-user-graduate me-2 text-secondary"></i>
                                                        <strong><?php echo e($pag->nome ?? '---'); ?></strong>
                                                        <?php if(($pag->Multa ?? 0) > 0): ?>
                                                            <span class="badge bg-warning text-dark ms-2"><i class="fa fa-exclamation-triangle me-1"></i> Multa: <?php echo e(number_format($pag->Multa,2,',','.')); ?> MT</span>
                                                        <?php endif; ?>
                                                    </div>
                                                    <div>
                                                        <span class="text-success fw-bold"><?php echo e(number_format($pag->valorDescricao,2,',','.')); ?> MT</span>
                                                        <button class="btn btn-sm btn-outline-primary btn-detail ms-2" data-bs-toggle="modal" data-bs-target="#detalheModal"
                                                            data-nome="<?php echo e($pag->nome); ?>"
                                                            data-classe="<?php echo e($classeNome); ?>"
                                                            data-metodo="<?php echo e($metodoNome); ?>"
                                                            data-valor="<?php echo e(number_format($pag->valorDescricao,2,',','.')); ?>"
                                                            data-multa="<?php echo e(number_format($pag->Multa ?? 0,2,',','.')); ?>"
                                                            data-data="<?php echo e(\Carbon\Carbon::parse($pag->data_pagamento)->format('d/m/Y H:i')); ?>"
                                                            data-mes="<?php echo e($pag->mes ?? ($pag->mes_id ? 'Mês '.$pag->mes_id : 'Anual')); ?>"
                                                            data-referencia="<?php echo e($pag->referencia ?? '---'); ?>">
                                                            <i class="fa fa-info-circle"></i> Detalhes
                                                        </button>
                                                    </div>
                                                </div>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <div class="student-item bg-light mt-2" style="border-radius: 8px;">
                                                <div><strong>Subtotal <?php echo e($metodoNome); ?></strong></div>
                                                <div><strong><?php echo e(number_format($itemsByMethod->sum('valorDescricao') + $itemsByMethod->sum('Multa'),2,',','.')); ?> MT</strong></div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <div class="p-3 bg-light mx-3 mb-3 rounded" style="border-left: 4px solid #1e4663;">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <strong><i class="fa fa-chart-simple me-2"></i>Total da Classe <?php echo e($classeNome); ?></strong>
                                        <strong class="text-primary"><?php echo e(number_format($itemsByClass->sum('valorDescricao') + $itemsByClass->sum('Multa'),2,',','.')); ?> MT</strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="alert alert-info text-center py-5">
                <i class="fa fa-inbox fa-3x mb-3"></i>
                <h5>Nenhum registo de pagamentos encontrado</h5>
                <p class="mb-0">Não existem transações no período selecionado.</p>
            </div>
        <?php endif; ?>

        
        <?php if($pagamentos->count()): ?>
        <div class="card mt-4" style="background: linear-gradient(135deg, #1e4663 0%, #2a628f 100%); color: white; border-radius: 20px;">
            <div class="card-body">
                <h5 class="card-title text-white"><i class="fa fa-chart-bar me-2"></i>TOTAL GERAL DO INTERVALO</h5>
                <div class="row text-center mt-3">
                    <div class="col-md-4 mb-2">
                        <div class="border rounded p-3 bg-white text-dark">
                            <small>Total de Pagamentos</small>
                            <h4 class="mb-0"><?php echo e(number_format($pagamentos->sum('valorDescricao'),2,',','.')); ?> MT</h4>
                        </div>
                    </div>
                    <div class="col-md-4 mb-2">
                        <div class="border rounded p-3 bg-white text-dark">
                            <small>Total de Multas</small>
                            <h4 class="mb-0 text-danger"><?php echo e(number_format($pagamentos->sum('Multa'),2,',','.')); ?> MT</h4>
                        </div>
                    </div>
                    <div class="col-md-4 mb-2">
                        <div class="border rounded p-3 bg-warning">
                            <small>TOTAL GERAL COM MULTAS</small>
                            <h4 class="mb-0"><?php echo e(number_format($pagamentos->sum('valorDescricao') + $pagamentos->sum('Multa'),2,',','.')); ?> MT</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>
</section>


<div class="modal fade modal-details" id="detalheModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title"><i class="fa fa-user-check me-2"></i>Detalhes do Pagamento</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
                <table class="table table-borderless">
                    <tr><th width="40%">Aluno:</th><td id="modal-nome"></td></tr>
                    <tr><th>Classe:</th><td id="modal-classe"></td></tr>
                    <tr><th>Mês referente:</th><td id="modal-mes"></td></tr>
                    <tr><th>Método de pagamento:</th><td id="modal-metodo"></td></tr>
                    <tr><th>Valor:</th><td id="modal-valor" class="fw-bold text-success"></td></tr>
                    <tr><th>Multa:</th><td id="modal-multa" class="text-danger"></td></tr>
                    <tr><th>Referência:</th><td id="modal-referencia"></td></tr>
                    <tr><th>Data do pagamento:</th><td id="modal-data"></td></tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
$(document).ready(function() {
    // Toggle para CLASSE
    $('[data-toggle-class]').click(function() {
        var targetId = $(this).attr('data-toggle-class');
        $('#class-content-' + targetId).slideToggle(200);
        $('#icon-' + targetId).toggleClass('fa-chevron-right fa-chevron-down');
    });
    // Toggle para MÉTODO
    $('[data-toggle-method]').click(function() {
        var targetId = $(this).attr('data-toggle-method');
        $('#method-content-' + targetId).slideToggle(200);
        $('#icon-method-' + targetId).toggleClass('fa-chevron-down fa-chevron-up');
    });
    // Modal
    $('#detalheModal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var modal = $(this);
        modal.find('#modal-nome').text(button.data('nome') || '---');
        modal.find('#modal-classe').text(button.data('classe') || '---');
        modal.find('#modal-metodo').text(button.data('metodo') || '---');
        modal.find('#modal-valor').text(button.data('valor') || '0,00 MT');
        modal.find('#modal-multa').text(button.data('multa') || '0,00 MT');
        modal.find('#modal-referencia').text(button.data('referencia') || '---');
        modal.find('#modal-data').text(button.data('data') || '---');
        modal.find('#modal-mes').text(button.data('mes') || '---');
    });

    /* ========== GRÁFICOS CALCULADOS DIRECTAMENTE DOS PAGAMENTOS ========== */
    const pagamentos = <?php echo json_encode($pagamentos, 15, 512) ?>;
    const classesMap = new Map();
    const viasMap = new Map();

    pagamentos.forEach(p => {
        const classe = p.classe;
        const via = p.metodoPagDesc;
        const valor = parseFloat(p.valorDescricao) || 0;
        const multa = parseFloat(p.Multa) || 0;

        if (classe) {
            if (!classesMap.has(classe)) classesMap.set(classe, { total_pago: 0, total_multa: 0 });
            const c = classesMap.get(classe);
            c.total_pago += valor;
            c.total_multa += multa;
        }
        if (via) {
            if (!viasMap.has(via)) viasMap.set(via, { total_pago: 0, total_multa: 0 });
            const v = viasMap.get(via);
            v.total_pago += valor;
            v.total_multa += multa;
        }
    });

    // Gráfico de Classes
    const classesLabels = Array.from(classesMap.keys());
    const classesPagos = classesLabels.map(c => classesMap.get(c).total_pago);
    const classesMultas = classesLabels.map(c => classesMap.get(c).total_multa);

    if (classesLabels.length) {
        new Chart(document.getElementById('graficoClasses'), {
            type: 'bar',
            data: {
                labels: classesLabels,
                datasets: [
                    {
                        label: 'Pagamentos (MT)',
                        data: classesPagos,
                        backgroundColor: 'rgba(54, 162, 235, 0.6)',
                        borderColor: '#36a2eb',
                        borderWidth: 1
                    },
                    {
                        label: 'Multas (MT)',
                        data: classesMultas,
                        backgroundColor: 'rgba(255, 99, 132, 0.6)',
                        borderColor: '#ff6384',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                scales: { y: { beginAtZero: true, title: { display: true, text: 'Valor (MT)' } } },
                plugins: { tooltip: { callbacks: { label: (ctx) => `${ctx.dataset.label}: ${ctx.raw.toFixed(2)} MT` } } }
            }
        });
    } else {
        $('#graficoClasses').parent().html('<div class="alert alert-warning">Sem dados para exibir</div>');
    }

    // Gráfico por Via de Pagamento
    const viasLabels = Array.from(viasMap.keys());
    const viasPagos = viasLabels.map(v => viasMap.get(v).total_pago);
    const viasMultas = viasLabels.map(v => viasMap.get(v).total_multa);

    if (viasLabels.length) {
        new Chart(document.getElementById('graficoVias'), {
            type: 'bar',
            data: {
                labels: viasLabels,
                datasets: [
                    {
                        label: 'Pagamentos (MT)',
                        data: viasPagos,
                        backgroundColor: 'rgba(54, 162, 235, 0.6)',
                        borderColor: '#36a2eb',
                        borderWidth: 1
                    },
                    {
                        label: 'Multas (MT)',
                        data: viasMultas,
                        backgroundColor: 'rgba(255, 99, 132, 0.6)',
                        borderColor: '#ff6384',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                scales: { y: { beginAtZero: true, title: { display: true, text: 'Valor (MT)' } } },
                plugins: { tooltip: { callbacks: { label: (ctx) => `${ctx.dataset.label}: ${ctx.raw.toFixed(2)} MT` } } }
            }
        });
    } else {
        $('#graficoVias').parent().html('<div class="alert alert-warning">Sem dados para exibir</div>');
    }
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin-Lti', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/sgemozco/escolasaojoaopauloii.sgemoz.com/resources/views/Dashabord/finaceiro.blade.php ENDPATH**/ ?>