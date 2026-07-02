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
        .total-card {
            background: linear-gradient(120deg, #e9f0f5 0%, #ffffff 100%);
            border-radius: 18px;
            padding: 1rem 1.5rem;
            margin-bottom: 1.5rem;
            border-left: 5px solid #2a628f;
        }
        .total-value-lg {
            font-size: 1.9rem;
            font-weight: 800;
            color: #1e4663;
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
            flex-wrap: wrap;
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
            .student-item { flex-direction: column; align-items: flex-start; gap: 8px; }
        }
        .toggle-icon, .toggle-icon-method {
            transition: transform 0.2s;
        }
        .rotate {
            transform: rotate(90deg);
        }
        .btn-print {
            border-radius: 40px;
            padding: 0.5rem 1.5rem;
            font-weight: 500;
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
                    @if($outrosPagamentos->isNotEmpty())
                        {{ \Carbon\Carbon::parse($outrosPagamentos->min('updated_at'))->format('d/m/Y') }} —
                        {{ \Carbon\Carbon::parse($outrosPagamentos->max('updated_at'))->format('d/m/Y') }}
                    @else
                        ---
                    @endif
                    <span class="mx-2">•</span>
                    <i class="fas fa-receipt me-1"></i> {{ $outrosPagamentos->count() }} registos
                </div>
            </div>
            <div class="col-md-4 text-md-end mt-3 mt-md-0">
                <div class="header-subtitle">
                    <i class="fas fa-sync-alt me-1"></i> Emissão: {{ now()->format('d/m/Y H:i') }}
                </div>
            </div>
        </div>
    </div>

    {{-- CARDS RESUMO --}}
    @php
        $totalGeral = $outrosPagamentos->sum('valorDescricao');
        $totalPago = $outrosPagamentos->where('estado', 'activo')->sum('valorDescricao');
        $totalNaoPago = 0; // Se não houver campo de estado pendente
        $totalMultas = $outrosPagamentos->sum('Multa');
        $totalComMultas = $totalGeral + $totalMultas;
        $totalAlunos = $outrosPagamentos->unique('aluno_classe_id')->count();
        $mediaTicket = $outrosPagamentos->avg('valorDescricao') ?? 0;

        // Totais por classe para o resumo
        $classesResumo = $outrosPagamentos->groupBy('classe');

        // Totais por método de pagamento
        $metodosResumo = $outrosPagamentos->groupBy('metodoPagDesc');

        // Agrupar por data, classe e método
        $groupedByDate = $outrosPagamentos->groupBy(function($item) {
            return \Carbon\Carbon::parse($item->data_pagamento)->format('Y-m-d');
        })->sortKeysDesc();
    @endphp

    <div class="row g-4 mb-5 animate__animated animate__fadeInUp">
        <div class="col-md-3">
            <div class="summary-card">
                <div class="summary-icon" style="background:#e3f2fd;color:#0d6efd;"><i class="fas fa-chart-line"></i></div>
                <div class="summary-label">Total Arrecadado</div>
                <div class="summary-value">{{ number_format($totalGeral,2,',','.') }} MT</div>
                <small class="text-muted">em {{ $outrosPagamentos->count() }} transacções</small>
            </div>
        </div>
        <div class="col-md-3">
            <div class="summary-card">
                <div class="summary-icon" style="background:#d1fae5;color:#10b981;"><i class="fas fa-check-circle"></i></div>
                <div class="summary-label">Total de Multas</div>
                <div class="summary-value">{{ number_format($totalMultas,2,',','.') }} MT</div>
                <small>valores adicionais</small>
            </div>
        </div>
        <div class="col-md-3">
            <div class="summary-card">
                <div class="summary-icon" style="background:#fff3e0;color:#fd7e14;"><i class="fas fa-users"></i></div>
                <div class="summary-label">Total Alunos</div>
                <div class="summary-value">{{ $totalAlunos }}</div>
                <small>alunos únicos</small>
            </div>
        </div>
        <div class="col-md-3">
            <div class="summary-card">
                <div class="summary-icon" style="background:#ffe6e6;color:#dc3545;"><i class="fas fa-ticket-alt"></i></div>
                <div class="summary-label">Ticket Médio</div>
                <div class="summary-value">{{ number_format($mediaTicket,2,',','.') }} MT</div>
                <small>por transacção</small>
            </div>
        </div>
    </div>

    {{-- TABELA RESUMO POR CLASSE --}}
    <div class="resumo-card mb-4 animate__animated animate__fadeInUp" style="background: white; border-radius: 20px; padding: 1.5rem; box-shadow: 0 5px 15px rgba(0,0,0,0.05);">
        <h5 class="mb-3"><i class="fas fa-chalkboard me-2"></i>Resumo por Classe</h5>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="table-primary">
                    <tr>
                        <th>Classe</th>
                        <th class="text-center">Nº Alunos</th>
                        <th class="text-end">Total Pago (MT)</th>
                        <th class="text-end">Total Multas (MT)</th>
                        <th class="text-end">Total Geral (MT)</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $grandeTotalPago = 0;
                        $grandeTotalMulta = 0;
                    @endphp
                    @foreach($classesResumo as $classe => $items)
                        @php
                            $totalPagoClasse = $items->sum('valorDescricao');
                            $totalMultaClasse = $items->sum('Multa');
                            $alunosClasse = $items->unique('aluno_classe_id')->count();
                            $grandeTotalPago += $totalPagoClasse;
                            $grandeTotalMulta += $totalMultaClasse;
                        @endphp
                        <tr>
                            <td><strong>{{ $classe }}</strong></td>
                            <td class="text-center">{{ $alunosClasse }}</td>
                            <td class="text-end">{{ number_format($totalPagoClasse,2,',','.') }}</td>
                            <td class="text-end text-danger">{{ number_format($totalMultaClasse,2,',','.') }}</td>
                            <td class="text-end"><strong>{{ number_format($totalPagoClasse + $totalMultaClasse,2,',','.') }}</strong></td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot class="table-secondary">
                    <tr>
                        <th>TOTAL GERAL</th>
                        <th class="text-center">{{ $totalAlunos }}</th>
                        <th class="text-end">{{ number_format($grandeTotalPago,2,',','.') }}</th>
                        <th class="text-end">{{ number_format($grandeTotalMulta,2,',','.') }}</th>
                        <th class="text-end">{{ number_format($grandeTotalPago + $grandeTotalMulta,2,',','.') }}</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    {{-- TABELA RESUMO POR MÉTODO DE PAGAMENTO --}}
    <div class="resumo-card mb-4 animate__animated animate__fadeInUp" style="background: white; border-radius: 20px; padding: 1.5rem; box-shadow: 0 5px 15px rgba(0,0,0,0.05);">
        <h5 class="mb-3"><i class="fas fa-credit-card me-2"></i>Resumo por Via de Pagamento</h5>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="table-success">
                    <tr>
                        <th>Via de Pagamento</th>
                        <th class="text-end">Valor Total (MT)</th>
                        <th class="text-end">% do Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($metodosResumo as $metodo => $items)
                        @php $valorMetodo = $items->sum('valorDescricao'); @endphp
                        <tr>
                            <td><i class="fas fa-wallet me-2"></i> {{ $metodo }}</td>
                            <td class="text-end">{{ number_format($valorMetodo,2,',','.') }}</td>
                            <td class="text-end">{{ number_format(($valorMetodo / max($totalGeral,1)) * 100,2,',','.') }}%</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot class="table-secondary">
                    <tr>
                        <th>TOTAL</th>
                        <th class="text-end">{{ number_format($totalGeral,2,',','.') }}</th>
                        <th class="text-end">100%</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    {{-- RELATÓRIO DETALHADO POR DATA, CLASSE E MÉTODO --}}
    @forelse ($groupedByDate as $dateKey => $itemsByDate)
        @php
            $dateObj = \Carbon\Carbon::parse($dateKey);
            $diasSemana = ['Domingo','Segunda-feira','Terça-feira','Quarta-feira','Quinta-feira','Sexta-feira','Sábado'];
            $meses = ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'];
            $dataFormatada = $diasSemana[$dateObj->dayOfWeek].', '.$dateObj->format('d').' de '.$meses[$dateObj->month - 1].' de '.$dateObj->format('Y');
            $totalDia = $itemsByDate->sum('valorDescricao');
            $multasDia = $itemsByDate->sum('Multa');
            $porcentagemTotal = $totalGeral > 0 ? ($totalDia / $totalGeral) * 100 : 0;
        @endphp

        <div class="date-card animate__animated animate__fadeInUp">
            <div class="card-header-custom text-white d-flex justify-content-between align-items-center flex-wrap">
                <div>
                    <i class="fas fa-calendar-day me-2"></i>
                    <strong>{{ $dataFormatada }}</strong>
                    <span class="ms-3 small opacity-75">{{ $itemsByDate->count() }} pagamento(s)</span>
                </div>
                <div>
                    <span class="badge bg-light text-dark me-2">{{ number_format($porcentagemTotal,1) }}% do total</span>
                </div>
            </div>
            <div class="card-body p-4">
                <div class="total-card d-flex justify-content-between align-items-center mb-4">
                    <div><i class="fas fa-hand-holding-usd fs-4 me-2 text-secondary"></i><span class="fw-semibold">Total do dia (sem multas):</span></div>
                    <div class="total-value-lg">{{ number_format($totalDia,2,',','.') }} MT</div>
                </div>
                @if($multasDia > 0)
                <div class="total-card d-flex justify-content-between align-items-center mb-4" style="border-left-color: #dc3545;">
                    <div><i class="fas fa-exclamation-triangle fs-4 me-2 text-danger"></i><span class="fw-semibold">Multas do dia:</span></div>
                    <div class="total-value-lg text-danger">{{ number_format($multasDia,2,',','.') }} MT</div>
                </div>
                @endif

                {{-- Agrupar por classe --}}
                @php
                    $groupedByClass = $itemsByDate->groupBy(function($item) {
                        return $item->classe ?? 'Sem classe';
                    });
                @endphp

                @foreach ($groupedByClass as $classeNome => $itemsByClass)
                    @php $classSlug = Str::slug($classeNome).'_'.$dateKey; @endphp

                    <div class="class-card mb-4">
                        <div class="class-header d-flex justify-content-between align-items-center" data-toggle-class="{{ $classSlug }}">
                            <h5 class="mb-0"><i class="fas fa-chalkboard-user me-2"></i> {{ $classeNome }}</h5>
                            <span><i class="fas fa-chevron-right toggle-icon" id="icon-{{ $classSlug }}"></i></span>
                        </div>
                        <div id="class-content-{{ $classSlug }}" style="display: none;">

                            {{-- Agrupar por método de pagamento dentro da classe --}}
                            @php
                                $groupedByMethod = $itemsByClass->groupBy(function($item) {
                                    return $item->metodoPagDesc ?? 'Não definido';
                                });
                            @endphp

                            @foreach ($groupedByMethod as $metodoNome => $itemsByMethod)
                                @php $methodSlug = Str::slug($metodoNome).'_'.$classSlug; @endphp

                                <div class="method-group">
                                    <div class="method-header d-flex justify-content-between align-items-center" data-toggle-method="{{ $methodSlug }}">
                                        <div>
                                            <i class="fas fa-credit-card me-2"></i>
                                            <strong>{{ $metodoNome }}</strong>
                                            <span class="badge-metodo ms-2">{{ $itemsByMethod->count() }} aluno(s)</span>
                                        </div>
                                        <div>
                                            <span class="fw-semibold text-success">{{ number_format($itemsByMethod->sum('valorDescricao'),2,',','.') }} MT</span>
                                            <i class="fas fa-chevron-down toggle-icon-method ms-2" id="icon-method-{{ $methodSlug }}"></i>
                                        </div>
                                    </div>
                                    <div id="method-content-{{ $methodSlug }}" class="student-list">
                                        @foreach ($itemsByMethod as $pag)
                                            <div class="student-item">
                                                <div>
                                                    <i class="fas fa-user-graduate me-2 text-secondary"></i>
                                                    <strong>{{ $pag->nome ?? '---' }}</strong>
                                                    @if(($pag->Multa ?? 0) > 0)
                                                        <span class="badge bg-warning text-dark ms-2"><i class="fas fa-exclamation-triangle me-1"></i> Multa: {{ number_format($pag->Multa,2,',','.') }} MT</span>
                                                    @endif
                                                </div>
                                                <div>
                                                    <span class="text-success fw-bold">{{ number_format($pag->valorDescricao,2,',','.') }} MT</span>
                                                    <button class="btn btn-sm btn-outline-primary btn-detail ms-2" data-bs-toggle="modal" data-bs-target="#detalheModal"
                                                        data-nome="{{ $pag->nome }}"
                                                        data-classe="{{ $classeNome }}"
                                                        data-metodo="{{ $metodoNome }}"
                                                        data-valor="{{ number_format($pag->valorDescricao,2,',','.') }}"
                                                        data-multa="{{ number_format($pag->Multa ?? 0,2,',','.') }}"
                                                        data-estado="Pago"
                                                        data-data="{{ \Carbon\Carbon::parse($pag->data_pagamento)->format('d/m/Y H:i') }}"
                                                        data-mes="{{ $pag->mes ?? ($pag->mes_id ? 'Mês '.$pag->mes_id : 'Anual') }}"
                                                        data-referencia="{{ $pag->referencia ?? '---' }}">
                                                        <i class="fas fa-info-circle"></i> Detalhes
                                                    </button>
                                                </div>
                                            </div>
                                        @endforeach
                                        {{-- Subtotal do método --}}
                                        <div class="student-item bg-light mt-2" style="border-radius: 8px;">
                                            <div><strong>Subtotal {{ $metodoNome }}</strong></div>
                                            <div><strong>{{ number_format($itemsByMethod->sum('valorDescricao') + $itemsByMethod->sum('Multa'),2,',','.') }} MT</strong></div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            {{-- Total da classe --}}
                            <div class="p-3 bg-light mx-3 mb-3 rounded" style="border-left: 4px solid #1e4663;">
                                <div class="d-flex justify-content-between align-items-center">
                                    <strong><i class="fas fa-chart-simple me-2"></i>Total da Classe {{ $classeNome }}</strong>
                                    <strong class="text-primary">{{ number_format($itemsByClass->sum('valorDescricao') + $itemsByClass->sum('Multa'),2,',','.') }} MT</strong>
                                </div>
                            </div>
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

    {{-- TOTAL GERAL DO INTERVALO --}}
    <div class="resumo-card mt-4 animate__animated animate__fadeInUp" style="background: linear-gradient(135deg, #1e4663 0%, #2a628f 100%); color: white; border-radius: 20px; padding: 1.5rem;">
        <h5 class="text-white mb-3"><i class="fas fa-chart-bar me-2"></i>TOTAL GERAL DO INTERVALO</h5>
        <div class="row text-center">
            <div class="col-md-4 mb-2">
                <div class="border rounded p-3 bg-white text-dark">
                    <small>Total de Pagamentos</small>
                    <h4 class="mb-0">{{ number_format($grandeTotalPago ?? $totalGeral,2,',','.') }} MT</h4>
                </div>
            </div>
            <div class="col-md-4 mb-2">
                <div class="border rounded p-3 bg-white text-dark">
                    <small>Total de Multas</small>
                    <h4 class="mb-0 text-danger">{{ number_format($grandeTotalMulta ?? $totalMultas,2,',','.') }} MT</h4>
                </div>
            </div>
            <div class="col-md-4 mb-2">
                <div class="border rounded p-3 bg-warning">
                    <small>TOTAL GERAL COM MULTAS</small>
                    <h4 class="mb-0">{{ number_format(($grandeTotalPago ?? $totalGeral) + ($grandeTotalMulta ?? $totalMultas),2,',','.') }} MT</h4>
                </div>
            </div>
        </div>
    </div>

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
                    <tr><th>Multa:</th><td id="modal-multa" class="text-danger"></td></tr>
                    <tr><th>Referência:</th><td id="modal-referencia"></td></tr>
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
        $('[data-toggle-class]').click(function() {
            var targetId = $(this).attr('data-toggle-class');
            var contentDiv = $('#class-content-' + targetId);
            var icon = $('#icon-' + targetId);
            contentDiv.slideToggle(200);
            icon.toggleClass('fa-chevron-right fa-chevron-down');
        });

        // Toggle para MÉTODO (lista de alunos)
        $('[data-toggle-method]').click(function() {
            var targetId = $(this).attr('data-toggle-method');
            var contentDiv = $('#method-content-' + targetId);
            var icon = $('#icon-method-' + targetId);
            contentDiv.slideToggle(200);
            icon.toggleClass('fa-chevron-down fa-chevron-up');
        });

        // Preencher modal com dados do botão "Detalhes"
        $('#detalheModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var modal = $(this);

            modal.find('#modal-nome').text(button.data('nome') || '---');
            modal.find('#modal-classe').text(button.data('classe') || '---');
            modal.find('#modal-metodo').text(button.data('metodo') || '---');
            modal.find('#modal-valor').text(button.data('valor') || '0,00 MT');
            modal.find('#modal-multa').text(button.data('multa') || '0,00 MT');
            modal.find('#modal-referencia').text(button.data('referencia') || '---');
            modal.find('#modal-estado').html('<span class="badge-status badge-pago">Pago</span>');
            modal.find('#modal-data').text(button.data('data') || '---');
            modal.find('#modal-mes').text(button.data('mes') || '---');
        });
    });
</script>
</body>
</html>
