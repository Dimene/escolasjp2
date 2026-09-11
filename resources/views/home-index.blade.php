<?php
$dadosInfo = session()->get('nomeEm') ?? null;
$avatar = session()->get('infosession.avatar') ?? null;
?>

@extends('layouts.admin-Lti')
@section('title', 'Dashboard')

@section('content')
<style>
    /* Animações e melhorias visuais */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes slideInRight {
        from {
            opacity: 0;
            transform: translateX(50px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    .animate-fadeInUp {
        animation: fadeInUp 0.5s ease-out;
    }

    .animate-slideInRight {
        animation: slideInRight 0.5s ease-out;
    }

    /* Cards melhorados */
    .info-box {
        border-radius: 15px;
        transition: all 0.3s ease;
        cursor: pointer;
        position: relative;
        overflow: hidden;
        min-height: 100px;
        padding: 10px;
        box-shadow: 0 0 10px #e0e0e0;
    }

    .info-box:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    }

    .info-box:hover .info-box-icon {
        transform: scale(1.1);
    }

    .info-box-icon {
        transition: all 0.3s ease;
        border-radius: 12px;
        height: 80px;
        width: 80px;
        font-size: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .info-box-content {
        padding-left: 10px;
        font-size: 14px;
    }

    .info-box-text {
        font-weight: 600;
        font-size: 14px;
        color: #fff;
    }

    .info-box-number {
        font-size: 24px;
        font-weight: bold;
        color: #fff;
    }

    /* Loading melhorado */
    .loading-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0,0,0,0.7);
        display: none;
        justify-content: center;
        align-items: center;
        z-index: 9999;
    }

    .loading-spinner {
        width: 50px;
        height: 50px;
        border: 5px solid #f3f3f3;
        border-top: 5px solid #3498db;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    /* Cards de gráficos */
    .card {
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
    }

    .card:hover {
        box-shadow: 0 8px 25px rgba(0,0,0,0.12);
    }

    /* Botões melhorados */
    .btn-sm {
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .btn-sm:hover {
        transform: translateY(-2px);
    }

    /* DataTables melhorado */
    #listadosalunos {
        border-radius: 12px;
        overflow: hidden;
    }

    #listadosalunos thead {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    #listadosalunos thead th {
        color: white;
        font-weight: 600;
        padding: 12px;
    }

    #listadosalunos tbody tr:hover {
        background-color: #f8f9fa;
        transition: all 0.3s ease;
    }

    #listadosalunos tbody tr {
        transition: all 0.2s ease;
    }

    /* DataTables custom styles */
    .dataTables_wrapper .dataTables_length,
    .dataTables_wrapper .dataTables_filter,
    .dataTables_wrapper .dataTables_info,
    .dataTables_wrapper .dataTables_processing,
    .dataTables_wrapper .dataTables_paginate {
        margin-bottom: 15px;
        margin-top: 15px;
    }

    .dataTables_wrapper .dataTables_filter input {
        border-radius: 20px;
        padding: 5px 15px;
        border: 2px solid #e0e0e0;
        margin-left: 10px;
        transition: all 0.3s ease;
    }

    .dataTables_wrapper .dataTables_filter input:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102,126,234,0.25);
        outline: none;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button {
        border-radius: 8px;
        margin: 0 2px;
        padding: 6px 12px;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-color: #667eea;
        color: white !important;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-color: #667eea;
        color: white !important;
    }

    /* Badges para status */
    .badge-pago {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        color: white;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 12px;
        display: inline-block;
        font-weight: 600;
    }

    .badge-pendente {
        background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
        color: white;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 12px;
        display: inline-block;
        font-weight: 600;
    }

    /* Cards de KPI abaixo do gráfico */
    .resumo-cards {
        margin-top: 20px;
    }

    .resumo-card {
        background: white;
        border-radius: 12px;
        padding: 15px;
        text-align: center;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        transition: transform 0.3s ease;
        cursor: pointer;
    }

    .resumo-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    }

    .resumo-card.valor {
        border-left: 4px solid #28a745;
    }

    .resumo-card.percent {
        border-left: 4px solid #17a2b8;
    }

    .resumo-card-title {
        font-size: 12px;
        color: #6c757d;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .resumo-card-number {
        font-size: 24px;
        font-weight: bold;
        color: #333;
        margin: 10px 0;
    }

    .resumo-card-percent {
        font-size: 14px;
        color: #28a745;
    }

    /* Filtros modernos */
    .filter-card {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border: none;
        border-radius: 20px;
    }

    .filter-card .form-control {
        border-radius: 10px;
        border: 2px solid #e0e0e0;
        transition: all 0.3s ease;
    }

    .filter-card .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102,126,234,0.25);
    }

    /* Toast notifications */
    .toast-notification {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 10000;
        animation: slideInRightFast 0.3s ease-out;
    }

    @keyframes slideInRightFast {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

    /* Gráfico de pizza */
    .pizza-container {
        width: 100%;
        max-width: 300px;
        margin: 0 auto;
        text-align: center;
    }

    #chartPizza {
        max-width: 280px !important;
        max-height: 280px !important;
        width: auto !important;
        height: auto !important;
        display: block;
        margin: 0 auto;
    }

    .legend-items {
        display: flex;
        justify-content: center;
        gap: 1.5rem;
        flex-wrap: wrap;
        margin-top: 15px;
    }

    .legend-item {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .legend-color {
        width: 14px;
        height: 14px;
        border-radius: 50%;
        display: inline-block;
    }

    .legend-color.green {
        background-color: #28a745;
    }

    .legend-color.red {
        background-color: #dc3545;
    }

    /* Botões de exportação */
    .btn-export {
        margin: 0 5px;
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .btn-export:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(0,0,0,0.15);
    }

    /* Responsividade */
    @media (max-width: 768px) {
        .info-box-number {
            font-size: 18px;
        }
        .resumo-card-number {
            font-size: 18px;
        }
        .info-box-icon {
            height: 60px;
            width: 60px;
            font-size: 24px;
        }

        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter {
            float: none;
            text-align: left;
            margin-bottom: 10px;
        }

        .dataTables_wrapper .dataTables_filter input {
            width: 100%;
            margin-left: 0;
        }
    }
</style>

<div class="loading-overlay" id="loadingOverlay">
    <div class="loading-spinner"></div>
</div>

<section class="content">

{{-- HEADER --}}
<div class="content-header">
    <div class="container-fluid">
        <div class="breadcrumb-modern animate-fadeInUp">
            <ol class="breadcrumb" style="background: transparent; margin: 0; padding: 0;">
                <li class="breadcrumb-item">
                    <a href="#"><i class="fa fa-dashboard"></i> Dashboard</a>
                </li>
                <li class="breadcrumb-item active">
                    <i class="fa fa-home"></i> <b>Home</b>
                </li>
            </ol>
        </div>
    </div>
</div>

@php

$can = false;

foreach ($tipodepagamento as $tipo):

    $can = $can || Gate::check("Visualizar-" . trim($tipo->Descricao));

endforeach;

@endphp


@if($can)
{{-- FILTROS --}}
<div class="container-fluid animate-fadeInUp" style="animation-delay: 0.1s;">
    <div class="card filter-card">
        <div class="card-body row">

            <div class="col-md-4">
                <label><i class="fa fa-calendar"></i> <strong>Ano Lectivo</strong></label>
                <select class="form-control Ano">
                    @foreach ($anolectivo as $ano)


                    <option value="{{ $ano->id }}" @selected($ano->anolectivo == now()->year)>
                        📅 {{ $ano->anolectivo }}
                    </option>
                    @endforeach
                </select>
            </div>



            <div class="col-md-4">
                <label><i class="fa fa-calendar-range"></i> <strong>Intervalo de Datas</strong></label>
                <div id="reportrange" class="form-control" style="cursor: pointer;">
                    <i class="fa fa-calendar"></i>
                    <span class="datashow"></span> <i class="fa fa-caret-down"></i>
                </div>
            </div>



            <div class="col-md-4">
                <label><i class="fa fa-credit-card"></i> <strong>Tipo de Pagamento</strong></label>
               <select class="form-control Tipo">
    @foreach ($tipodepagamento as $tipo)

        @can('Visualizar-' . trim($tipo->Descricao))
            <option value="{{ $tipo->id }}">
                {{ $tipo->Descricao }}
            </option>
        @endcan

    @endforeach
</select>
            </div>

        </div>
    </div>
</div>

{{-- KPI CARDS SUPERIOR --}}
<div class="container-fluid animate-fadeInUp" style="animation-delay: 0.2s;">
    <div class="row">
        @php
        $bgColors = [
            'primary' => 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)',
            'success' => 'linear-gradient(135deg, #43e97b 0%, #38f9d7 100%)',
            'warning' => 'linear-gradient(135deg, #fa709a 0%, #fee140 100%)',
            'info' => 'linear-gradient(135deg, #4facfe 0%, #00f2fe 100%)'
        ];
        @endphp

        <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
            <div class="info-box" style="background: {{ $bgColors['primary'] }}; color: white;">
                <span class="info-box-icon">
                    <i class="fa fa-calendar-day"></i>
                </span>
                <div class="info-box-content">
                    <span class="info-box-text">Total de Diárias</span>
                    <span class="info-box-number">
                       <span class="totalDiario-valor">0</span>
                        <small>alunos</small>
                    </span>
                    <a href="#" class="text-white visualizarDiariasDetalhes" style="font-size: 12px;">
                        <i class="fa fa-eye"></i> Ver detalhes
                    </a>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
            <div class="info-box" style="background: {{ $bgColors['success'] }}; color: white;">
                <span class="info-box-icon">
                    <i class="fa fa-calendar-alt"></i>
                </span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Mensal</span>
                    <span class="info-box-number">
                        <span class="totalMensal-valor">0</span>
                        <small>alunos</small>
                    </span>
                    <a href="#" class="text-white visualizarMensalDetalhes" style="font-size: 12px;">
                        <i class="fa fa-eye"></i> Ver detalhes
                    </a>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
            <div class="info-box" style="background: {{ $bgColors['warning'] }}; color: white;">
                <span class="info-box-icon">
                    <i class="fa fa-bullseye"></i>
                </span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Esperado</span>
                    <span class="info-box-number">
                        <span class="totalEsperado-valor">0</span>
                        <small>alunos</small>
                    </span>
                    <a href="#" class="text-white visualizarEsperadoDetalhes" style="font-size: 12px;">
                        <i class="fa fa-eye"></i> Ver detalhes
                    </a>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
            <div class="info-box" style="background: {{ $bgColors['info'] }}; color: white;">
                <span class="info-box-icon">
                    <i class="fa fa-percent"></i>
                </span>
                <div class="info-box-content">
                    <span class="info-box-text">Taxa de Cobrança</span>
                    <span class="info-box-number">
                       <span class="taxaCobranca-valor">0</span>
                        <small>%</small>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- GRÁFICOS --}}
<div class="container-fluid contudoGrafico animate-fadeInUp" style="animation-delay: 0.3s;">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5><i class="fa fa-chart-bar"></i> Pagamentos por Classe</h5>
                    <div>
                        <button class="btn btn-sm btn-primary" id="exportBarras" title="Exportar gráfico">
                            <i class="fa fa-download"></i> Exportar
                        </button>
                        <button class="btn btn-sm btn-secondary ml-1" id="refreshBarras" title="Atualizar gráfico">
                            <i class="fa fa-refresh"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="chartMensal" height="250"></canvas>
                </div>
            </div>

            {{-- CARDS DE RESUMO ABAIXO DO GRÁFICO --}}
            <div class="resumo-cards">
                <div class="row">
                    <div class="col-md-4">
                        <div class="resumo-card valor visualizarDiariasDetalhes">
                            <div class="resumo-card-title">
                                <i class="fa fa-calendar-day"></i> Receita Diária
                            </div>
                             @can('Detalhes-Diarias')
                            <div class="resumo-card-number">
                                <span class="diarias-valor">0.00</span> MZN
                            </div>
                            @endcan
                            <div class="resumo-card-percent">
                                <span class="diarias-percent">0</span>% do total
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="resumo-card valor visualizarMensalDetalhes">
                            <div class="resumo-card-title">
                                <i class="fa fa-calendar-alt"></i> Receita Mensal
                            </div>
                              @can('Detalhes-Mensal')
                            <div class="resumo-card-number">
                                <span class="mensal-valor">0.00</span> MZN
                            </div>
                            @endcan
                            <div class="resumo-card-percent">
                                <span class="mensal-percent">0</span>% do total
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="resumo-card valor visualizarEsperadoDetalhes">
                            <div class="resumo-card-title">
                                <i class="fa fa-bullseye"></i> Meta Esperada
                            </div>
                              @can('Detalhes-Anual')
                            <div class="resumo-card-number">
                                <span class="esperado-valor">0.00</span> MZN
                            </div>
                            @endcan
                            <div class="resumo-card-percent">
                                100% da meta
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5><i class="fa fa-chart-pie"></i> Pagos / Activos vs Pendentes</h5>
                    <div>
                        <button class="btn btn-sm btn-primary" id="exportPizza" title="Exportar gráfico">
                            <i class="fa fa-download"></i> Exportar
                        </button>
                        <button class="btn btn-sm btn-secondary ml-1" id="refreshPizza" title="Atualizar gráfico">
                            <i class="fa fa-refresh"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="pizza-container">
                        <canvas id="chartPizza" width="280" height="280"></canvas>
                    </div>
                    <div class="text-center mt-3" id="pizzaLegend"></div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- TABELA COM DATATABLES --}}
<div class="container-fluid contudoTabela" style="display: none">
    <div class="card">
        <div class="card-header">
            <h5><i class="fa fa-table"></i> Detalhes</h5>
            <h6 class="detalhesDescricao text-muted">Detalhes</h6>
        </div>
        <div class="card-body">
            <div class="mb-3">
                <a href="#" class="btn btn-secondary botaoVoltar">
                    <i class="fa fa-arrow-left"></i> Voltar
                </a>
                <button class="btn btn-success ml-2 btn-export" id="exportarExcel">
                    <i class="fa fa-file-excel"></i> Exportar Excel
                </button>
                <button class="btn btn-danger ml-2 btn-export" id="exportarPDFCompleto" permission="true">
                    <i class="fa fa-file-pdf" ></i> Exportar PDF
                </button>
                <button class="btn btn-info ml-2 btn-export" id="exportarCSV">
                    <i class="fa fa-file-csv"></i> Exportar CSV
                </button>
                <button class="btn btn-primary ml-2 btn-export" id="imprimirTabela">
                    <i class="fa fa-print"></i> Imprimir
                </button>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="listadosalunos" width="100%">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Classe</th>
                            <th>Descrição</th>
                            <th>Valor (MZN)</th>
                            <th>Multa (MZN)</th>

                        </tr>
                    </thead>
                    <tbody></tbody>
                    <tfoot>
                        <tr>
                            <th colspan="3" style="text-align:right">TOTAL:</th>
                            <th class="total-valor">0.00</th>
                            <th class="total-multa">0.00</th>

                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
@else
@include('welcome')
@endif
</section>

@push('script')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.31/jspdf.plugin.autotable.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/moment@2.29.4/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-daterangepicker@3.1.0/daterangepicker.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-daterangepicker@3.1.0/daterangepicker.css" />

<!-- DataTables CSS e JS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap4.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap4.min.js"></script>

<script>
let chartMensal = null;
let chartPizza = null;
let dataInicio = null;
let dataFim = null;
let cacheDados = null;
let dadosTabelaAtuais = [];
let dataTable = null;
let diariasPermissao = @json(Gate::check('Detalhes-Diarias'));
let mensalPermissao = @json(Gate::check('Detalhes-Mensal'));
let anualPermissao = @json(Gate::check('Detalhes-Anual'));

$(document).ready(function () {
    initDatePicker();
    carregarDados();

    // Filtros
    $('.Ano').on('change', carregarDados);
    $('.Tipo').on('change', carregarDados);

    // Refresh buttons
    $('#refreshBarras, #refreshPizza').on('click', carregarDados);

    // Export buttons
    $('#exportBarras').on('click', () => exportarGrafico('barra'));
    $('#exportPizza').on('click', () => exportarGrafico('pizza'));
    $('#exportarExcel').on('click', exportarParaExcel);
    $('#exportarPDFCompleto').on('click', exportarParaPDF);
    $('#exportarCSV').on('click', exportarParaCSV);
    $('#imprimirTabela').on('click', imprimirTabela);

    // Voltar button
    $('.botaoVoltar').on('click', function(e) {
        e.preventDefault();
        $(".contudoTabela").fadeOut(200);
        $(".contudoGrafico").fadeIn(300);
        if (dataTable) {
            dataTable.destroy();
            dataTable = null;
        }
    });

    // Visualizar detalhes
    $(document).on('click', '.visualizarDiariasDetalhes', visualizarDiariasDetalhes);
    $(document).on('click', '.visualizarMensalDetalhes', visualizarMensalDetalhes);
    $(document).on('click', '.visualizarEsperadoDetalhes', visualizarEsperadoDetalhes);
});

// ===============================
// CARREGAR DADOS
// ===============================
async function carregarDados() {
    try {
        showLoading();
        $(".contudoTabela").fadeOut(200);

        let ano = $('.Ano').val();
        let tipo = $('.Tipo').val();

        if (!ano || !tipo || !dataInicio || !dataFim) {
            showToast('Selecione todos os filtros', 'error');
            return;
        }

        let url = `/home/dados/${ano}/${dataInicio}/${dataFim}/${tipo}`;

        const d = await $.ajax({
            url: url,
            type: 'GET',
            dataType: 'json',
            cache: false,
            timeout: 30000
        });

        cacheDados = d;

        // KPIs SUPERIORES
        $('.totalDiario-valor').text(d.Diarianumero ?? 0);
        $('.totalMensal-valor').text(d.mensalNumero ?? 0);
        $('.totalEsperado-valor').text(d.totalNumero ?? 0);
        $('.taxaCobranca-valor').text(parseFloat(d.dadoscobranca ?? 0).toFixed(1));

        // CARDS ABAIXO DO GRÁFICO
        const diariaValor = d.Diariavalor ?? 0;
        const mensalValor = d.mensalValor ?? 0;
        const totalValor = d.totalValor ?? 0;

        const percentDiaria = totalValor > 0 ? ((diariaValor / totalValor) * 100).toFixed(1) : 0;
        const percentMensal = totalValor > 0 ? ((mensalValor / totalValor) * 100).toFixed(1) : 0;

        $('.diarias-valor').text(formatMoney(diariaValor));
        $('.diarias-percent').text(percentDiaria);

        $('.mensal-valor').text(formatMoney(mensalValor));
        $('.mensal-percent').text(percentMensal);

        $('.esperado-valor').text(formatMoney(totalValor));

        // Detalhes para tabelas
        window.diariadetalhes = d.diariadetalhes ?? [];
        window.mensaldetalhes = d.mensaldetalhes ?? [];
        window.esperadodetalhes = d.esperadodetalhes ?? [];

        // Gráficos
        const dadosGrafico = d.dadosGrafico ?? [];

        renderMensal(dadosGrafico);

        const pagos = d.Diarianumero ?? 0;
        const totalAlunos = d.totalNumero ?? 0;
        renderPizza({
            pagos: pagos,
            naoPagos: totalAlunos - pagos
        });

        $(".contudoGrafico").fadeIn(300);

    } catch (error) {
        console.error("Erro carregarDados:", error);
        let msg = "Erro ao carregar dados";
        if (error.status === 404) msg = "Rota não encontrada";
        if (error.status === 500) msg = "Erro interno do servidor";
        showToast(msg, 'error');
    } finally {
        hideLoading();
    }
}

// ===============================
// DATE PICKER
// ===============================
function initDatePicker() {
    let start = moment();
    let end = moment();
    dataInicio = start.format('YYYY-MM-DD');
    dataFim = end.format('YYYY-MM-DD');

    $('#reportrange').daterangepicker({
        startDate: start,
        endDate: end,
        ranges: {
            'Hoje': [moment(), moment()],
            'Ontem': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Últimos 7 Dias': [moment().subtract(6, 'days'), moment()],
            'Últimos 30 Dias': [moment().subtract(29, 'days'), moment()],
            'Este Mês': [moment().startOf('month'), moment().endOf('month')],
            'Mês Passado': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
            'Este Ano': [moment().startOf('year'), moment().endOf('year')]
        },
        locale: {
            applyLabel: 'Aplicar',
            cancelLabel: 'Cancelar',
            fromLabel: 'De',
            toLabel: 'Até',
            customRangeLabel: 'Personalizado',
            daysOfWeek: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb'],
            monthNames: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro']
        }
    });

    $('.datashow').text(`${dataInicio} - ${dataFim}`);

    $('#reportrange').on('apply.daterangepicker', function (ev, picker) {
        dataInicio = picker.startDate.format('YYYY-MM-DD');
        dataFim = picker.endDate.format('YYYY-MM-DD');
        $('.datashow').text(`${dataInicio} - ${dataFim}`);
        carregarDados();
    });
}

// ===============================
// GRÁFICO MENSAL (BARRAS)
// ===============================
function renderMensal(dados) {
    const ctx = document.getElementById('chartMensal');
    if (!ctx) return;
    if (chartMensal) chartMensal.destroy();

    let labels = [];
    let pagosAtivos = [];
    let naoPagosPendentes = [];
    let multas = [];

    if (Array.isArray(dados) && dados.length > 0) {
        labels = dados.map(item => item.classe ?? 'Sem Classe');
        pagosAtivos = dados.map(item => Number(item.pagos_activos ?? 0));
        naoPagosPendentes = dados.map(item => Number(item.nao_pagos_pendentes ?? 0));
        multas = dados.map(item => Number(item.multa ?? 0));
    } else {
        labels = ['Sem dados'];
        pagosAtivos = [0];
        naoPagosPendentes = [0];
        multas = [0];
    }

    chartMensal = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Pagos/Activos',
                    data: pagosAtivos,
                    backgroundColor: 'rgba(40, 167, 69, 0.6)',
                    borderColor: 'rgba(40, 167, 69, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Não Pagos/Pendentes',
                    data: naoPagosPendentes,
                    backgroundColor: 'rgba(220, 53, 69, 0.6)',
                    borderColor: 'rgba(220, 53, 69, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Com Multa',
                    data: multas,
                    backgroundColor: 'rgba(255, 193, 7, 0.6)',
                    borderColor: 'rgba(255, 193, 7, 1)',
                    borderWidth: 1
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1,
                        callback: function(value) {
                            return value;
                        }
                    }
                }
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return `${context.dataset.label}: ${context.raw}`;
                        }
                    }
                }
            }
        }
    });
}

// ===============================
// GRÁFICO PIZZA
// ===============================
function renderPizza(dados) {
    const ctx = document.getElementById('chartPizza');
    if (!ctx) return;

    if (chartPizza) {
        chartPizza.destroy();
        chartPizza = null;
    }

    const pagos = Number(dados.pagos ?? 0);
    const naoPagos = Number(dados.naoPagos ?? 0);
    const total = pagos + naoPagos;

    ctx.style.width = '280px';
    ctx.style.height = '280px';
    ctx.width = 280;
    ctx.height = 280;

    chartPizza = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['Pagos/Activos', 'Não Pagos/Pendentes'],
            datasets: [{
                data: [pagos, naoPagos],
                backgroundColor: ['#28a745', '#dc3545'],
                borderWidth: 2,
                borderColor: '#fff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            aspectRatio: 1,
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const value = context.raw;
                            const percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                            return `${context.label}: ${value} (${percentage}%)`;
                        }
                    }
                },
                legend: {
                    position: 'bottom',
                    labels: {
                        boxWidth: 12,
                        padding: 10,
                        font: { size: 11 }
                    }
                }
            }
        }
    });

    const percentPagos = total > 0 ? ((pagos / total) * 100).toFixed(1) : 0;
    const percentNaoPagos = total > 0 ? ((naoPagos / total) * 100).toFixed(1) : 0;

    const legendHtml = `
        <div class="legend-items">
            <div class="legend-item">
                <span class="legend-color green"></span>
                <span><strong>Pagos/Activos:</strong> ${pagos} (${percentPagos}%)</span>
            </div>
            <div class="legend-item">
                <span class="legend-color red"></span>
                <span><strong>Não Pagos/Pendentes:</strong> ${naoPagos} (${percentNaoPagos}%)</span>
            </div>
        </div>
    `;

    $('#pizzaLegend').html(legendHtml);
}

// ===============================
// FUNÇÕES DE DETALHES COM DATATABLE
// ===============================
function visualizarDiariasDetalhes() {
    mostrarTabela(window.diariadetalhes, '📅 Receita Diária - Detalhes',diariasPermissao);
    $("#exportarPDFCompleto").attr("permission",diariasPermissao);

}

function visualizarMensalDetalhes() {
    mostrarTabela(window.mensaldetalhes, '📆 Receita Mensal - Detalhes',mensalPermissao);
    $("#exportarPDFCompleto").attr("permission",mensalPermissao);
}

function visualizarEsperadoDetalhes() {
    mostrarTabela(window.esperadodetalhes, '🎯 Meta Esperada - Detalhes',anualPermissao);
    $("#exportarPDFCompleto").attr("permission",anualPermissao);
}

function mostrarTabela(dados, titulo, permisao) {
    if (!dados || dados.length === 0) {
        showToast('Nenhum dado encontrado para exibir', 'error');
        return;
    }

    // Processar dados
    const dadosResumidos = mostrarDadosResumo(dados);

    // 🔥 guardar como fonte principal (para outras tabelas)
    window.dadosPrincipais = dadosResumidos;
    dadosTabelaAtuais = dadosResumidos;

    $(".contudoGrafico").fadeOut(200);
    $(".contudoTabela").fadeIn(300);
    $(".detalhesDescricao").text(titulo);

    // destruir DataTable existente
    if (dataTable) {
        dataTable.destroy();
        dataTable = null;
    }

    const tbody = $('#listadosalunos tbody');
    tbody.empty();

    let totalValor = 0;
    let totalMulta = 0;

    dadosResumidos.forEach((item) => {

        const valor = parseFloat(item.Valor) || 0;
        const multa = parseFloat(item.Multa) || 0;

        const nomeAluno = item.nome || '-';
        const classeNome = item.classe || '-';
        const parcelas = item.Parcelas || 1;

        const descricao = `${parcelas} ${parcelas !== 1 ? 'parcelas' : 'parcela'}`;

        totalValor += valor;
        totalMulta += multa;

        tbody.append(`
            <tr>
                <td>${escapeHtml(nomeAluno)}</td>
                <td>${escapeHtml(classeNome)}</td>
                <td>${descricao}</td>

                <!-- guardamos valor real no data-attribute -->
                <td class="text-right" data-valor="${valor}">
                    ${permisao ? formatMoney(valor) : 'SPM'}
                </td>

                <td class="text-right" data-multa="${multa}">
                    ${permisao ? formatMoney(multa) : 'SPM'}
                </td>
            </tr>
        `);
    });

    // Totais do footer
    $('#listadosalunos tfoot .total-valor').html(
        `<strong>${permisao ? formatMoney(totalValor) : 'SPM'}</strong>`
    );

    $('#listadosalunos tfoot .total-multa').html(
        `<strong>${permisao ? formatMoney(totalMulta) : 'SPM'}</strong>`
    );

    // DataTable
    dataTable = $('#listadosalunos').DataTable({
        responsive: true,
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/pt-BR.json'
        },
        order: [[3, 'desc']],
        pageLength: 10,
        lengthMenu: [
            [10, 25, 50, 100, -1],
            [10, 25, 50, 100, "Todos"]
        ],
        dom:
            '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>' +
            '<"row"<"col-sm-12"tr>>' +
            '<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',

        drawCallback: function () {

            if (!permisao) {
                $('#listadosalunos tfoot .total-valor').html('<strong>SPM</strong>');
                $('#listadosalunos tfoot .total-multa').html('<strong>SPM</strong>');
                return;
            }

            let api = this.api();

            let totalValorFiltrado = 0;
            let totalMultaFiltrado = 0;

            api.rows({ search: 'applied' }).every(function () {

                const rowNode = this.node();

                const valor = parseFloat(
                    $(rowNode).find('td:eq(3)').data('valor')
                ) || 0;

                const multa = parseFloat(
                    $(rowNode).find('td:eq(4)').data('multa')
                ) || 0;

                totalValorFiltrado += valor;
                totalMultaFiltrado += multa;
            });

            $('#listadosalunos tfoot .total-valor').html(
                `<strong>${formatMoney(totalValorFiltrado)}</strong>`
            );

            $('#listadosalunos tfoot .total-multa').html(
                `<strong>${formatMoney(totalMultaFiltrado)}</strong>`
            );
        }
    });

    // 🔥 aqui podes sincronizar outra tabela principal se existir
    if (typeof atualizarTabelaPrincipal === 'function') {
        atualizarTabelaPrincipal(window.dadosPrincipais);
    }
}

// Função para escapar HTML
function escapeHtml(str) {
    if (!str) return '-';
    return String(str)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#39;');
}

// Função para resumir dados por aluno
function mostrarDadosResumo(dados) {
    if (!dados || dados.length === 0) {
        return [];
    }

    const uniqueMap = new Map();

    dados.forEach(item => {
        const id = item.idAlunoclasse || item.id;
        if (!uniqueMap.has(id)) {
            uniqueMap.set(id, {
                idAlunoclasse: id,
                nome: item.alunos?.nome || item.nome,
                classe: item.classe?.Descricao || item.classe
            });
        }
    });

    const dadosRet = Array.from(uniqueMap.values()).map(unique => {
        const registrosDoAluno = dados.filter(item =>
            (item.idAlunoclasse || item.id) === unique.idAlunoclasse
        );

        const totalParcelas = registrosDoAluno.length;
        const totalValor = registrosDoAluno.reduce((sum, item) => {
            let valor = 0;
            if (item.tabelavalor && Array.isArray(item.tabelavalor)) {
                valor = item.tabelavalor.reduce((s, tv) => s + (parseFloat(tv.valorDescricao) || 0), 0);
            } else if (item.valorDescricao) {
                valor = parseFloat(item.valorDescricao) || 0;
            } else if (item.Valor) {
                valor = parseFloat(item.Valor) || 0;
            }
            return sum + valor;
        }, 0);

        const totalMulta = registrosDoAluno.reduce((sum, item) =>
            sum + (parseFloat(item.Multa || item.multa || 0)), 0);

        return {
            id: unique.idAlunoclasse,
            nome: unique.nome,
            classe: unique.classe,
            Parcelas: totalParcelas,
            Valor: totalValor,
            Multa: totalMulta
        };
    });

    return dadosRet;
}

// ===============================
// FUNÇÕES DE EXPORTAÇÃO
// ===============================
function exportarParaCSV() {
    if (!dadosTabelaAtuais || dadosTabelaAtuais.length === 0) {
        showToast('Nenhum dado para exportar', 'error');
        return;
    }

    try {
        const dadosExport = dadosTabelaAtuais.map(item => ({
            'Nome': item.nome,
            'Classe': item.classe,
            'Descrição': `${item.Parcelas} ${item.Parcelas !== 1 ? 'parcelas' : 'parcela'}`,
            'Valor (MZN)': item.Valor,
            'Multa (MZN)': item.Multa
        }));

        const ws = XLSX.utils.json_to_sheet(dadosExport);
        const wb = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(wb, ws, 'Pagamentos');
        XLSX.writeFile(wb, `pagamentos_${moment().format('YYYYMMDD_HHmmss')}.csv`);
        showToast('CSV exportado com sucesso!', 'success');
    } catch (error) {
        console.error('Erro CSV:', error);
        showToast('Erro ao exportar CSV', 'error');
    }
}

function exportarParaExcel() {
    if (!dadosTabelaAtuais || dadosTabelaAtuais.length === 0) {
        showToast('Nenhum dado para exportar', 'error');
        return;
    }

    try {
        const dadosExport = dadosTabelaAtuais.map(item => ({
            'Nome': item.nome,
            'Classe': item.classe,
            'Descrição': `${item.Parcelas} ${item.Parcelas !== 1 ? 'parcelas' : 'parcela'}`,
            'Valor (MZN)': item.Valor,
            'Multa (MZN)': item.Multa
        }));

        const ws = XLSX.utils.json_to_sheet(dadosExport);
        const wb = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(wb, ws, 'Pagamentos');
        XLSX.writeFile(wb, `pagamentos_${moment().format('YYYYMMDD_HHmmss')}.xlsx`);
        showToast('Excel exportado com sucesso!', 'success');
    } catch (error) {
        console.error('Erro Excel:', error);
        showToast('Erro ao exportar Excel', 'error');
    }
}

function exportarParaPDF() {

permisao= $("#exportarPDFCompleto").attr("permission");

    if (!dadosTabelaAtuais || dadosTabelaAtuais.length === 0) {
        showToast('Nenhum dado para exportar', 'error');
        return;
    }

    try {
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF('landscape');

        doc.setFontSize(18);
        doc.text('Relatório de Pagamentos', 14, 15);

        doc.setFontSize(10);
        doc.text(
            `Gerado em: ${moment().format('DD/MM/YYYY HH:mm:ss')}`,
            14,
            25
        );

        doc.text(
            `Filtro: ${$('.detalhesDescricao').text()}`,
            14,
            32
        );

        const headers = [
            ['Nome', 'Classe', 'Descrição', 'Valor (MZN)', 'Multa (MZN)']
        ];

        let totalValor = 0;
        let totalMulta = 0;

        const rows = dadosTabelaAtuais.map(item => {

            const valor = parseFloat(item.Valor) || 0;
            const multa = parseFloat(item.Multa) || 0;

            totalValor += valor;
            totalMulta += multa;

            const descricao =
                `${item.Parcelas || 1} ${(item.Parcelas || 1) !== 1 ? 'parcelas' : 'parcela'}`;

            return [
                item.nome || '-',
                item.classe || '-',
                descricao,
                permisao ? formatMoney(valor) : 'SPM',
                permisao ? formatMoney(multa) : 'SPM'
            ];
        });

        // TOTAL
        rows.push([
            '',
            '',
            'TOTAL:',
            permisao ? formatMoney(totalValor) : 'SPM',
            permisao ? formatMoney(totalMulta) : 'SPM'
        ]);

        doc.autoTable({
            head: headers,
            body: rows,
            startY: 40,
            theme: 'striped',
            styles: {
                fontSize: 8,
                cellPadding: 2
            },
            headStyles: {
                fillColor: [102, 126, 234],
                textColor: 255,
                fontSize: 9,
                fontStyle: 'bold'
            }
        });

        doc.save(`pagamentos_${moment().format('YYYYMMDD_HHmmss')}.pdf`);

        showToast('PDF exportado com sucesso!', 'success');

    } catch (error) {
        console.error('Erro PDF:', error);
        showToast('Erro ao exportar PDF', 'error');
    }
}

function imprimirTabela() {
    if (!dadosTabelaAtuais || dadosTabelaAtuais.length === 0) {
        showToast('Nenhum dado para imprimir', 'error');
        return;
    }

    const conteudo = `
    <html>
    <head>
        <title>Relatório de Pagamentos</title>
        <style>
            body { font-family: Arial, sans-serif; margin: 20px; }
            h1 { color: #333; font-size: 18px; }
            table { width: 100%; border-collapse: collapse; margin-top: 20px; }
            th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
            th { background-color: #667eea; color: white; }
            tr:nth-child(even) { background-color: #f2f2f2; }
            .text-right { text-align: right; }
            .footer { margin-top: 30px; text-align: center; font-size: 12px; color: #666; }
        </style>
    </head>
    <body>
        <h1>${$('.detalhesDescricao').text()}</h1>
        <p>Gerado em: ${moment().format('DD/MM/YYYY HH:mm:ss')}</p>
        <table>
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Classe</th>
                    <th>Descrição</th>
                    <th>Valor (MZN)</th>
                    <th>Multa (MZN)</th>
                </tr>
            </thead>
            <tbody>
                ${dadosTabelaAtuais.map(item => `
                    <tr>
                        <td>${escapeHtml(item.nome)}</td>
                        <td>${escapeHtml(item.classe)}</td>
                        <td>${item.Parcelas} ${item.Parcelas !== 1 ? 'parcelas' : 'parcela'}</td>
                        <td class="text-right">${ permisao?formatMoney(item.Valor):'SPM'}</td>
                        <td class="text-right">${permisao?formatMoney(item.Multa):'SPM'}</td>
                    </tr>
                `).join('')}
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3" style="text-align:right">TOTAL:</th>
                    <th class="text-right">${formatMoney(dadosTabelaAtuais.reduce((sum, item) => sum + (parseFloat(item.Valor) || 0), 0))}</th>
                    <th class="text-right">${formatMoney(dadosTabelaAtuais.reduce((sum, item) => sum + (parseFloat(item.Multa) || 0), 0))}</th>
                </tr>
            </tfoot>
        </table>
        <div class="footer">
            <p>Sistema de Gestão Escolar - Relatório gerado automaticamente</p>
        </div>
    </body>
    </html>
    `;

    const win = window.open();
    win.document.write(conteudo);
    win.document.close();
    win.print();
}

// ===============================
// EXPORTAÇÕES DE GRÁFICOS
// ===============================
async function exportarGrafico(tipo) {
    try {
        showLoading();
        let canvas = document.getElementById(tipo === 'barra' ? 'chartMensal' : 'chartPizza');

        if (!canvas) {
            showToast('Gráfico não encontrado', 'error');
            return;
        }

        const dataURL = canvas.toDataURL('image/png');
        const link = document.createElement('a');
        link.download = `grafico_${tipo}_${moment().format('YYYYMMDD_HHmmss')}.png`;
        link.href = dataURL;
        link.click();

        showToast('Gráfico exportado com sucesso!', 'success');
    } catch (error) {
        console.error('Erro ao exportar gráfico:', error);
        showToast('Erro ao exportar gráfico', 'error');
    } finally {
        hideLoading();
    }
}

// ===============================
// UTILITÁRIOS
// ===============================
function formatMoney(value) {
    if (value === null || value === undefined || isNaN(value)) return '0,00';
    return Number(value).toLocaleString('pt-MZ', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    });
}

function showLoading() {
    $('#loadingOverlay').fadeIn(150);
}

function hideLoading() {
    $('#loadingOverlay').fadeOut(150);
}

function showToast(msg, tipo = 'success') {
    const bg = tipo === 'error' ? '#dc3545' : '#28a745';
    const icon = tipo === 'error' ? '⚠' : '✓';

    const toast = $(`
        <div class="toast-notification" style="background:${bg}; color:white; padding:15px 20px; border-radius:10px; box-shadow:0 5px 15px rgba(0,0,0,0.2);">
            <strong>${icon} ${tipo === 'error' ? 'Erro' : 'Sucesso'}</strong><br>
            ${msg}
        </div>
    `);

    $('body').append(toast);

    setTimeout(() => {
        toast.fadeOut(300, function() { $(this).remove(); });
    }, 3000);
}

</script>
@endpush
@endsection
