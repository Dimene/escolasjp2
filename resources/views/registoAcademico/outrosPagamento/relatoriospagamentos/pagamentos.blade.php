<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório Analítico de Pagamentos</title>

    <!-- Bootstrap 5 + Ícones + Fonts -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

    <style>
        * { font-family: 'Inter', sans-serif; }
        body {
            background: linear-gradient(135deg, #f0f2f5 0%, #e9ecef 100%);
            padding: 2rem 0;
        }
        .header-gradient {
            background: linear-gradient(135deg, #0b2b44 0%, #1c4e6e 100%);
            border-radius: 24px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            position: relative;
            overflow: hidden;
        }
        .header-gradient::before {
            content: '';
            position: absolute;
            top: -30%;
            right: -30%;
            width: 160%;
            height: 160%;
            background: radial-gradient(circle, rgba(255,255,255,0.08) 2%, transparent 2.5%);
            background-size: 40px 40px;
            animation: moveDots 25s linear infinite;
        }
        @keyframes moveDots {
            0% { transform: translate(0,0); }
            100% { transform: translate(50px, 50px); }
        }
        .header-title {
            font-size: 2rem;
            font-weight: 700;
            letter-spacing: -0.3px;
            position: relative;
            z-index: 1;
        }
        .header-subtitle {
            font-size: 0.9rem;
            opacity: 0.9;
            position: relative;
            z-index: 1;
        }
        .summary-card {
            background: white;
            border-radius: 20px;
            padding: 1.5rem;
            transition: all 0.25s ease;
            border: 1px solid rgba(0,0,0,0.04);
            box-shadow: 0 5px 15px rgba(0,0,0,0.02);
        }
        .summary-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 35px rgba(0,0,0,0.08);
        }
        .summary-icon {
            width: 55px;
            height: 55px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 26px;
            margin-bottom: 1rem;
        }
        .summary-label {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 600;
            color: #6c757d;
        }
        .summary-value {
            font-size: 1.8rem;
            font-weight: 800;
            color: #1e4663;
            margin: 0.5rem 0 0;
        }
        .date-card {
            border: none;
            border-radius: 24px;
            overflow: hidden;
            margin-bottom: 2rem;
            box-shadow: 0 8px 20px rgba(0,0,0,0.05);
            transition: transform 0.2s ease;
        }
        .date-card:hover {
            transform: translateY(-3px);
        }
        .card-header-custom {
            background: linear-gradient(98deg, #1e4663 0%, #2a628f 100%);
            padding: 1rem 1.8rem;
            border: none;
        }
        .class-card {
            background: white;
            border-radius: 18px;
            margin-bottom: 1.5rem;
            border: 1px solid #e9ecef;
            transition: all 0.2s;
        }
        .class-card:hover {
            box-shadow: 0 8px 20px rgba(0,0,0,0.05);
        }
        .class-header {
            background: #f8f9fc;
            padding: 1rem 1.5rem;
            border-bottom: 2px solid #e9ecef;
            border-radius: 18px 18px 0 0;
            cursor: pointer;
            transition: all 0.2s;
        }
        .class-header:hover {
            background: #eef2f7;
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
            transition: all 0.2s;
        }
        .method-header:hover {
            background: #e9f0f5;
        }
        .class-content-wrapper {
            display: none;
        }
        .class-content-wrapper.show {
            display: block;
        }
        .student-list {
            padding: 0.5rem 1rem;
            display: none;
        }
        .student-list.show {
            display: block;
        }
        .student-item {
            padding: 0.5rem 0.75rem;
            border-bottom: 1px solid #f0f0f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .student-item:last-child {
            border-bottom: none;
        }
        .btn-detail {
            padding: 0.2rem 0.6rem;
            font-size: 0.75rem;
            border-radius: 20px;
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
        .badge-naopago { background: #f8d7da; color: #721c24; }
        .modal-details .modal-content {
            border-radius: 20px;
        }
        footer {
            font-size: 0.8rem;
            color: #6c757d;
            text-align: center;
            border-top: 1px solid #dee2e6;
            padding-top: 1.5rem;
            margin-top: 2rem;
        }
        @media (max-width: 768px) {
            .summary-value { font-size: 1.3rem; }
            .header-title { font-size: 1.5rem; }
            .method-group { margin-left: 0.5rem; margin-right: 0.5rem; }
        }
        .toggle-icon, .toggle-icon-method {
            transition: transform 0.3s ease;
            display: inline-block;
        }
        .toggle-icon.rotated, .toggle-icon-method.rotated {
            transform: rotate(90deg);
        }
        .class-header .toggle-icon {
            font-size: 1.2rem;
        }
    </style>
</head>
<body>

<div class="container py-4">

    {{-- HEADER --}}
    <div class="header-gradient text-white animate__animated animate__fadeInDown">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="header-title">
                    <i class="fas fa-chart-pie me-2"></i> Relatório Analítico de Pagamentos
                </div>
                <div class="header-subtitle mt-2">
                    <i class="fas fa-calendar-alt me-1"></i> Período:
                    {{ $outrosPagamentos->min('updated_at') ? date('d/m/Y', strtotime($outrosPagamentos->min('updated_at'))) : '---' }} —
                    {{ $outrosPagamentos->max('updated_at') ? date('d/m/Y', strtotime($outrosPagamentos->max('updated_at'))) : '---' }}
                    <span class="mx-2">•</span>
                    <i class="fas fa-receipt me-1"></i> {{ $outrosPagamentos->count() }} registos
                </div>
            </div>
            <div class="col-md-4 text-md-end mt-3 mt-md-0">
                <div class="header-subtitle">
                    <i class="fas fa-sync-alt me-1"></i> Emissão: {{ date('d/m/Y H:i') }}
                </div>
            </div>
        </div>
    </div>

    {{-- CARDS RESUMO --}}
    @php
        $totalGeral = $outrosPagamentos->sum('valorDescricao');
        $totalPago = $outrosPagamentos->where('Estados', 'Pago')->sum('valorDescricao');
        $totalNaoPago = $outrosPagamentos->where('Estados', 'Não pago')->sum('valorDescricao');
        $mediaTicket = $outrosPagamentos->avg('valorDescricao') ?? 0;
        $diasComMovimento = $outrosPagamentos->groupBy(function($i) { return date('Y-m-d', strtotime($i->updated_at)); })->count();
        $mediaDiaria = $diasComMovimento > 0 ? $totalGeral / $diasComMovimento : 0;
    @endphp

    <div class="row g-4 mb-5 animate__animated animate__fadeInUp">
        <div class="col-md-3"><div class="summary-card"><div class="summary-icon" style="background:#e3f2fd;color:#0d6efd;"><i class="fas fa-chart-line"></i></div><div class="summary-label">Total Arrecadado</div><div class="summary-value">{{ number_format($totalGeral,2,',','.') }} MT</div><small class="text-muted">em {{ $outrosPagamentos->count() }} transacções</small></div></div>
        <div class="col-md-3"><div class="summary-card"><div class="summary-icon" style="background:#d1fae5;color:#10b981;"><i class="fas fa-check-circle"></i></div><div class="summary-label">Pago</div><div class="summary-value">{{ number_format($totalPago,2,',','.') }} MT</div><small>{{ $outrosPagamentos->where('Estados','Pago')->count() }} recibos</small></div></div>
        <div class="col-md-3"><div class="summary-card"><div class="summary-icon" style="background:#ffe6e6;color:#dc3545;"><i class="fas fa-hourglass-half"></i></div><div class="summary-label">Pendente</div><div class="summary-value">{{ number_format($totalNaoPago,2,',','.') }} MT</div><small>{{ $outrosPagamentos->where('Estados','Não pago')->count() }} débitos</small></div></div>
        <div class="col-md-3"><div class="summary-card"><div class="summary-icon" style="background:#fff3e0;color:#fd7e14;"><i class="fas fa-ticket-alt"></i></div><div class="summary-label">Ticket Médio</div><div class="summary-value">{{ number_format($mediaTicket,2,',','.') }} MT</div><small>média diária ≈ {{ number_format($mediaDiaria,0,',','.') }} MT</small></div></div>
    </div>

    {{-- RELATÓRIO POR DATA, CLASSE E MÉTODO --}}
    @php
        $groupedByDate = $outrosPagamentos->groupBy(function($item) {
            return date('Y-m-d', strtotime($item->updated_at));
        })->sortKeysDesc();
    @endphp

    @forelse ($groupedByDate as $dateKey => $itemsByDate)
        @php
            $timestamp = strtotime($dateKey);
            $diasSemana = ['Domingo','Segunda-feira','Terça-feira','Quarta-feira','Quinta-feira','Sexta-feira','Sábado'];
            $meses = ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'];
            $dataFormatada = $diasSemana[date('w',$timestamp)].', '.date('d',$timestamp).' de '.$meses[date('n',$timestamp)-1].' de '.date('Y',$timestamp);
            $totalDia = $itemsByDate->sum('valorDescricao');
            $porcentagemTotal = $totalGeral > 0 ? ($totalDia / $totalGeral) * 100 : 0;
        @endphp

        <div class="date-card animate__animated animate__fadeInUp">
            <div class="card-header-custom text-white d-flex justify-content-between align-items-center flex-wrap">
                <div><i class="fas fa-calendar-day me-2"></i><strong>{{ $dataFormatada }}</strong><span class="ms-3 small opacity-75">{{ $itemsByDate->count() }} pagamento(s)</span></div>
                <div><span class="badge bg-light text-dark me-2">{{ number_format($porcentagemTotal,1) }}% do total</span></div>
            </div>
            <div class="card-body p-4">
                <div class="total-card d-flex justify-content-between align-items-center mb-4">
                    <div><i class="fas fa-hand-holding-usd fs-4 me-2 text-secondary"></i><span class="fw-semibold">Total do dia:</span></div>
                    <div class="total-value-lg">{{ number_format($totalDia,2,',','.') }} MT</div>
                </div>

                {{-- Agrupar por classe --}}
                @php 
                    $groupedByClass = $itemsByDate->groupBy(function($item) { 
                        return $item->classe ?? $item->classe_id ?? 'Sem classe'; 
                    }); 
                @endphp

                @foreach ($groupedByClass as $classeNome => $itemsByClass)
                    @php 
                        $classUniqueId = 'class_' . preg_replace('/[^a-zA-Z0-9]/', '_', $classeNome) . '_' . $dateKey;
                    @endphp
                    <div class="class-card mb-4">
                        <div class="class-header" data-class-id="{{ $classUniqueId }}">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="mb-0"><i class="fas fa-chalkboard-user me-2"></i> {{ $classeNome }}</h5>
                                <i class="fas fa-chevron-right toggle-icon" data-icon-id="{{ $classUniqueId }}"></i>
                            </div>
                        </div>
                        <div id="{{ $classUniqueId }}" class="class-content-wrapper">
                            @php $groupedByMethod = $itemsByClass->groupBy(function($item) { return $item->metodo_pagamento ?? ($item->metodo_pagamento_id ? 'Método #'.$item->metodo_pagamento_id : 'Não definido'); }); @endphp

                            @foreach ($groupedByMethod as $metodoNome => $itemsByMethod)
                                @php 
                                    $methodUniqueId = 'method_' . preg_replace('/[^a-zA-Z0-9]/', '_', $metodoNome) . '_' . preg_replace('/[^a-zA-Z0-9]/', '_', $classeNome) . '_' . $dateKey;
                                @endphp
                                <div class="method-group">
                                    <div class="method-header" data-method-id="{{ $methodUniqueId }}">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <i class="fas fa-credit-card me-2"></i>
                                                <strong>{{ $metodoNome }}</strong>
                                                <span class="badge-metodo ms-2">{{ $itemsByMethod->count() }} aluno(s)</span>
                                            </div>
                                            <div>
                                                <span class="fw-semibold text-success">{{ number_format($itemsByMethod->sum('valorDescricao'),2,',','.') }} MT</span>
                                                <i class="fas fa-chevron-down toggle-icon-method ms-2" data-method-icon-id="{{ $methodUniqueId }}"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="{{ $methodUniqueId }}" class="student-list">
                                        @foreach ($itemsByMethod as $pag)
                                            <div class="student-item">
                                                <div>
                                                    <i class="fas fa-user-graduate me-2 text-secondary"></i>
                                                    <strong>{{ $pag->nome ?? '---' }}</strong>
                                                    <span class="badge-status {{ $pag->Estados == 'Pago' ? 'badge-pago' : 'badge-naopago' }} ms-2">
                                                        {{ $pag->Estados ?? '---' }}
                                                    </span>
                                                </div>
                                                <div>
                                                    <span class="text-success fw-bold">{{ number_format($pag->valorDescricao,2,',','.') }} MT</span>
                                                    <button class="btn btn-sm btn-outline-primary btn-detail ms-2" data-bs-toggle="modal" data-bs-target="#detalheModal"
                                                        data-nome="{{ $pag->nome }}"
                                                        data-classe="{{ $classeNome }}"
                                                        data-metodo="{{ $metodoNome }}"
                                                        data-valor="{{ number_format($pag->valorDescricao,2,',','.') }}"
                                                        data-estado="{{ $pag->Estados }}"
                                                        data-data="{{ $pag->data_pagamento ? date('d/m/Y', strtotime($pag->data_pagamento)) : ($pag->updated_at ? date('d/m/Y H:i', strtotime($pag->updated_at)) : '---') }}"
                                                        data-mes="{{ $pag->mes ?? ($pag->mes_id ? 'Mês '.$pag->mes_id : '-') }}">
                                                        <i class="fas fa-info-circle"></i> Detalhes
                                                    </button>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @empty
        <div class="alert alert-info text-center py-5 animate__animated animate__fadeIn">
            <i class="fas fa-inbox fa-3x mb-3"></i>
            <h5>Nenhum registo de pagamentos encontrado</h5>
            <p class="mb-0">Não existem transações no período selecionado.</p>
        </div>
    @endforelse

    <footer>
        <i class="fas fa-chart-pie me-1"></i> Relatório gerado automaticamente · Sistema de Gestão Escolar · {{ date('Y') }}
    </footer>
</div>

{{-- MODAL DE DETALHES DO ALUNO --}}
<div class="modal fade modal-details" id="detalheModal" tabindex="-1" aria-labelledby="detalheModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="detalheModalLabel"><i class="fas fa-user-check me-2"></i>Detalhes do Pagamento</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
                <table class="table table-borderless">
                    <tr><th width="40%">Aluno:</th><td id="modal-nome"></td></tr>
                    <tr><th>Classe:</th><td id="modal-classe"></td></tr>
                    <tr><th>Mês referente:</th><td id="modal-mes"></td></tr>
                    <tr><th>Método de pagamento:</th><td id="modal-metodo"></td></tr>
                    <tr><th>Valor:</th><td id="modal-valor" class="fw-bold text-success"></td></tr>
                    <tr><th>Estado:</th><td id="modal-estado"></td></tr>
                    <tr><th>Data do pagamento:</th><td id="modal-data"></td></tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
$(document).ready(function() {
    // Toggle para CLASSE
    $('.class-header').on('click', function(e) {
        e.stopPropagation();
        var classId = $(this).data('class-id');
        var contentDiv = $('#' + classId);
        var icon = $('[data-icon-id="' + classId + '"]');
        
        // Toggle da classe de conteúdo
        if (contentDiv.hasClass('show')) {
            contentDiv.removeClass('show');
            icon.removeClass('rotated');
            setTimeout(function() {
                contentDiv.hide();
            }, 200);
        } else {
            contentDiv.show();
            setTimeout(function() {
                contentDiv.addClass('show');
            }, 10);
            icon.addClass('rotated');
        }
    });

    // Toggle para MÉTODO (lista de alunos)
    $('.method-header').on('click', function(e) {
        e.stopPropagation();
        var methodId = $(this).data('method-id');
        var contentDiv = $('#' + methodId);
        var icon = $('[data-method-icon-id="' + methodId + '"]');
        
        // Toggle da lista de alunos
        if (contentDiv.hasClass('show')) {
            contentDiv.removeClass('show');
            icon.removeClass('rotated');
            setTimeout(function() {
                contentDiv.hide();
            }, 200);
        } else {
            contentDiv.show();
            setTimeout(function() {
                contentDiv.addClass('show');
            }, 10);
            icon.addClass('rotated');
        }
    });

    // Inicializar estados (tudo fechado por padrão)
    $('.class-content-wrapper').hide();
    $('.student-list').hide();

    // Preencher modal com dados do botão "Detalhes"
    $('#detalheModal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var nome = button.data('nome');
        var classe = button.data('classe');
        var metodo = button.data('metodo');
        var valor = button.data('valor');
        var estado = button.data('estado');
        var data = button.data('data');
        var mes = button.data('mes');

        var modal = $(this);
        modal.find('#modal-nome').text(nome || '---');
        modal.find('#modal-classe').text(classe || '---');
        modal.find('#modal-metodo').text(metodo || '---');
        modal.find('#modal-valor').text(valor || '0,00 MT');
        modal.find('#modal-estado').html(estado == 'Pago' ? '<span class="badge-status badge-pago">Pago</span>' : '<span class="badge-status badge-naopago">Não pago</span>');
        modal.find('#modal-data').text(data || '---');
        modal.find('#modal-mes').text(mes || '---');
    });
});
</script>
</body>
</html>