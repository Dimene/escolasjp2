<?php
$dadosInfo = session()->get('nomeEm')??null;
$avatar = session()->get('infosession')->avatar;


?>


<?php $__env->startSection('title', 'Dashboard'); ?>

<?php $__env->startSection('content'); ?>
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
    }

    .info-box-number {
        font-size: 24px;
        font-weight: bold;
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

    /* Tabela melhorada */
    #listadosalunos {
        border-radius: 12px;
        overflow: hidden;
    }

    #listadosalunos thead {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    #listadosalunos tbody tr:hover {
        background-color: #f8f9fa;
        transition: all 0.3s ease;
    }

    /* Badges para status */
    .badge-pago {
        background-color: #28a745;
        color: white;
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 12px;
    }

    .badge-pendente {
        background-color: #dc3545;
        color: white;
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 12px;
    }

    /* Responsividade */
    @media (max-width: 768px) {
        .info-box-number {
            font-size: 18px;
        }

        .filter-card .row {
            flex-direction: column;
        }

        .filter-card .col {
            margin-bottom: 15px;
        }
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
</style>

<div class="loading-overlay" id="loadingOverlay">
    <div class="loading-spinner"></div>
</div>

<section class="content">



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


<div class="container-fluid animate-fadeInUp" style="animation-delay: 0.1s;">
    <div class="card filter-card">
        <div class="card-body row">
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("Trocar-ano-lectivo")): ?>
            <div class="col-md-4">
                <label><i class="fa fa-calendar"></i> <strong>Ano Lectivo</strong></label>
                <select class="form-control Ano">
                    <?php $__currentLoopData = $anolectivo; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ano): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($ano->id); ?>" <?php if($ano->anolectivo == now()->year): echo 'selected'; endif; ?>>
                        📅 <?php echo e($ano->anolectivo); ?>

                    </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <?php endif; ?>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("select-dataRange")): ?>
            <div class="col-md-4">
                <label><i class="fa fa-calendar-range"></i> <strong>Intervalo de Datas</strong></label>
                <div id="reportrange" class="form-control" style="cursor: pointer;">
                    <i class="fa fa-calendar"></i>
                    <span class="datashow"></span> <i class="fa fa-caret-down"></i>
                </div>
            </div>
            <?php endif; ?>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("select-tiposPagamensto")): ?>
            <div class="col-md-4">
                <label><i class="fa fa-credit-card"></i> <strong>Tipo de Pagamento</strong></label>
                <select class="form-control Tipo">
                    <?php $__currentLoopData = $tipodepagamento; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tipo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($tipo->id); ?>"><?php echo e($tipo->Descricao); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>


<div class="container-fluid animate-fadeInUp" style="animation-delay: 0.2s;">
    <div class="row">

        <?php
        $kpis = [
            ['diarias','calendar-day','Total Diário','visualizarDiariasDetalhes', 'primary', ''],
            ['mensal','calendar-alt','Total Mensal','visualizarMensalDetalhes', 'success', ''],
            ['Esperado','bullseye','Esperado','visualizarEsperadoDetalhes', 'warning', ''],
            ['taxaCobranca','percent','Taxa Cobrança',null, 'info', '%'],
        ];

        $cans = [
            ["Ver-Diaria","Detalhes-Diaria"],
            ["Ver-Mensal","Detalhes-Mensal"],
            ["Ver-Anual","Detalhes-Esperado"],
            ["Ver-Taxa-Cobranca","Detalhes-Taxa-Cobranca"],
        ];

        $bgColors = [
            'primary' => 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)',
            'success' => 'linear-gradient(135deg, #43e97b 0%, #38f9d7 100%)',
            'warning' => 'linear-gradient(135deg, #fa709a 0%, #fee140 100%)',
            'info' => 'linear-gradient(135deg, #4facfe 0%, #00f2fe 100%)'
        ];
        ?>

        <?php $__currentLoopData = $kpis; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $k): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php
        $permissaoKPI = Illuminate\Support\Facades\Gate::check($cans[$index][0]);
        ?>
        <?php if($permissaoKPI): ?>
        <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
            <div class="info-box" style="background: <?php echo e($bgColors[$k[4]]); ?>; color: white;">
                <span class="info-box-icon">
                    <i class="fa fa-<?php echo e($k[1]); ?>"></i>
                </span>
                <div class="info-box-content">
                    <span class="info-box-text"><?php echo e($k[2]); ?></span>
                    <span class="info-box-number <?php echo e($k[0]); ?>">
                        <span class="valor">0</span>
                        <small><?php echo e($k[5]); ?></small>
                    </span>
                    <?php if($k[3]): ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check($cans[$index][1])): ?>
                    <a href="#" class="text-white <?php echo e($k[3]); ?>" style="font-size: 12px;">
                        <i class="fa fa-eye botaoAbrirtabela"></i> Ver detalhes
                    </a>
                    <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    </div>
</div>


<div class="container-fluid contudoGrafico animate-fadeInUp" style="animation-delay: 0.3s;">
    <div class="row">

        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5><i class="fa fa-chart-bar"></i> Pagamentos Mensais por Classe</h5>
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
                    <canvas id="chartMensal" height="120"></canvas>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5><i class="fa fa-chart-pie"></i> Pagos / Não Pagos</h5>
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
                    <canvas id="chartPizza" height="200"></canvas>
                    <div class="text-center mt-3" id="pizzaLegend"></div>
                </div>
            </div>
        </div>

    </div>
</div>


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
                <button class="btn btn-success ml-2" id="exportarExcel">
                    <i class="fa fa-file-excel"></i> Exportar Excel
                </button>
                <button class="btn btn-danger ml-2" id="exportarPDFCompleto">
                    <i class="fa fa-file-pdf"></i> Exportar PDF
                </button>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="listadosalunos" width="100%">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Classe</th>
                            <th>Parcelas</th>
                            <th>Valor (MZN)</th>
                            <th>Multa (MZN)</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                    <tfoot>
                        <tr>
                            <th colspan="3" style="text-align:right">TOTAL:</th>
                            <th>0.00</th>
                            <th>0.00</th>
                            <th></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>


</section>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/daterangepicker/3.1/daterangepicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.2/js/buttons.html5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>

<?php $__env->startPush('script'); ?>
<script>
let chartMensal, chartPizza, dataInicio, dataFim;
let diariasdetalhes = [], mensaldetalhes = [], esperadodetalhes = [];
let tabela;

$(function() {
    initDatePicker();
    carregarDados();

    $('.Ano, .Tipo').change(function() {
        showLoading();
        carregarDados().finally(() => hideLoading());
    });

    // Inicializar DataTable
    tabela = $('#listadosalunos').DataTable({
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'copy',
                text: '<i class="fa fa-copy"></i> Copiar',
                className: 'btn btn-primary btn-sm'
            },
            {
                extend: 'excel',
                text: '<i class="fa fa-file-excel"></i> Excel',
                className: 'btn btn-info btn-sm',
                customize: function(xlsx) {
                    let sheet = xlsx.xl.worksheets['sheet1.xml'];
                    let lastRow = $('row', sheet).last();
                    let footerData = [];
                    $('#listadosalunos tfoot th').each(function() {
                        footerData.push($(this).text().trim());
                    });
                    let footerRow = `<row>${footerData[3]} | ${footerData[4]}</row>`;
                    lastRow.after(footerRow);
                }
            },
            {
                extend: 'pdf',
                text: '<i class="fa fa-file-pdf"></i> PDF',
                className: 'btn btn-danger btn-sm',
                customize: function(doc) {
                    let footerData = [];
                    $('#listadosalunos tfoot th').each(function() {
                        footerData.push($(this).text().trim());
                    });
                    let footerRow = footerData[3] + ' | ' + footerData[4];
                    doc.content[1].table.body.push([footerRow.split('|')]);
                }
            },
            {
                extend: 'print',
                text: '<i class="fa fa-print"></i> Imprimir',
                className: 'btn btn-warning btn-sm',
                customize: function(win) {
                    $(win.document.body).find('table').append($(document).find('#listadosalunos tfoot').clone());
                    $(win.document.body).find('tfoot').css({
                        'font-weight': 'bold',
                        'text-align': 'right'
                    });
                }
            }
        ],
        language: {
            search: "🔍 Pesquisar:",
            lengthMenu: "Mostrar _MENU_ registos por página",
            info: "Mostrando _START_ a _END_ de _TOTAL_ registos",
            infoEmpty: "Nenhum registo encontrado",
            infoFiltered: "(filtrado de _MAX_ registos no total)",
            paginate: {
                next: "Próximo",
                previous: "Anterior"
            },
            zeroRecords: "Nenhum registo encontrado"
        },
        pageLength: 10,
        footerCallback: function(row, data, start, end, display) {
            let api = this.api();
            let totalValor = api.column(3, { page: 'current' }).data().reduce((a, b) => a + (parseFloat(b) || 0), 0);
            let totalMulta = api.column(4, { page: 'current' }).data().reduce((a, b) => a + (parseFloat(b) || 0), 0);
            $(api.column(3).footer()).html(totalValor.toFixed(2));
            $(api.column(4).footer()).html(totalMulta.toFixed(2));
        }
    });

    // Eventos dos botões de visualização
    $('.visualizarDiariasDetalhes').click(function(e) {
        e.preventDefault();
        loadTabela(diariasdetalhes, "📅 Pagamentos do Dia");
    });

    $('.visualizarMensalDetalhes').click(function(e) {
        e.preventDefault();
        loadTabela(mensaldetalhes, "📊 Pagamentos do Mês");
    });

    $('.visualizarEsperadoDetalhes').click(function(e) {
        e.preventDefault();
        loadTabela(esperadodetalhes, "🎯 Pagamentos Esperados");
    });

    $('.botaoVoltar').click(function(e) {
        e.preventDefault();
        $(".contudoTabela").fadeOut(400, function() {
            $(".contudoGrafico").fadeIn(600);
        });
    });

    $('#exportBarras').click(() => exportChart(chartMensal, 'grafico_barras'));
    $('#exportPizza').click(() => exportChart(chartPizza, 'grafico_pizza'));

    $('#refreshBarras, #refreshPizza').click(function() {
        showLoading();
        carregarDados().finally(() => hideLoading());
    });

    $('#exportarExcel').click(() => {
        $('.buttons-excel').click();
        showToast('Excel exportado com sucesso!', 'success');
    });

    $('#exportarPDFCompleto').click(() => {
        $('.buttons-pdf').click();
        showToast('PDF exportado com sucesso!', 'success');
    });

    $('#lastUpdate').text('Última atualização: ' + moment().format('HH:mm:ss'));
});

function showLoading() {
    $('#loadingOverlay').fadeIn(300);
}

function hideLoading() {
    $('#loadingOverlay').fadeOut(300);
}

function showToast(message, type = 'info') {
    const bgColor = type === 'success' ? '#28a745' : '#17a2b8';
    const toast = $(`
        <div class="toast-notification" style="background: ${bgColor}; color: white; padding: 15px; border-radius: 8px; box-shadow: 0 5px 15px rgba(0,0,0,0.2); z-index: 10000;">
            <i class="fa fa-${type === 'success' ? 'check-circle' : 'info-circle'}"></i>
            ${message}
        </div>
    `);

    $('body').append(toast);
    setTimeout(() => {
        toast.fadeOut(300, () => toast.remove());
    }, 3000);
}

// FUNÇÃO CORRIGIDA - Processa arrays simples como: ["teste2a_10", "1ª classe", 1, "2000.00", "200.00"]
function loadTabela(dados, descricao) {
    console.log('Carregando tabela com dados:', dados);
    console.log('Tipo de dados:', Array.isArray(dados) ? 'Array' : typeof dados);

    if (!dados || dados.length === 0) {
        showToast('Nenhum dado encontrado para exibir', 'info');
        tabela.clear().draw();
        $(".detalhesDescricao").html(`<i class="fa fa-info-circle"></i> ${descricao} - Nenhum registo encontrado`);
        $(".contudoGrafico").fadeOut(400, function() {
            $(".contudoTabela").fadeIn(600);
        });
        return;
    }

    // Processar dados - cada item pode ser um array ou objeto
    const dadosFormatados = dados.map(item => {
        let nome, classe, parcelas, valor, multa;

        // Verificar se é um array (como no seu exemplo)
        if (Array.isArray(item)) {
            // Formato esperado: [nome, classe, parcelas, valor, multa]
            nome = item[0] || 'N/A';
            classe = item[1] || 'N/A';
            parcelas = item[2] || 'N/A';
            valor = parseFloat(item[3]) || 0;
            multa = parseFloat(item[4]) || 0;
        }
        // Se for objeto (fallback)
        else if (typeof item === 'object') {
            nome = item.nome || item.nome_aluno || item[0] || 'N/A';
            classe = item.classe || item.nome_classe || item[1] || 'N/A';
            parcelas = item.parcelas || item.n_parcelas || item[2] || 'N/A';
            valor = parseFloat(item.valor || item.valor_pago || item[3] || 0);
            multa = parseFloat(item.multa || item.valor_multa || item[4] || 0);
        }
        else {
            // Se for um valor único (fallback)
            nome = String(item);
            classe = 'N/A';
            parcelas = 'N/A';
            valor = 0;
            multa = 0;
        }

        // Determinar status
        const status = valor > 0 ? 'Pago' : 'Pendente';
        const statusIcon = valor > 0 ? '✅' : '⏳';

        return [
            nome,
            classe,
            parcelas,
            valor.toFixed(2),
            multa.toFixed(2),
            `<span class="badge badge-${valor > 0 ? 'pago' : 'pendente'}" style="background-color: ${valor > 0 ? '#28a745' : '#dc3545'}; color: white; padding: 5px 10px; border-radius: 20px;">
                ${statusIcon} ${status}
            </span>`
        ];
    });

    $(".detalhesDescricao").html(`<i class="fa fa-info-circle"></i> ${descricao} - ${dadosFormatados.length} registos encontrados`);

    tabela.clear();
    tabela.rows.add(dadosFormatados);
    tabela.draw();

    $(".contudoGrafico").fadeOut(400, function() {
        $(".contudoTabela").fadeIn(600);
    });
}

function initDatePicker() {
    let start = moment().startOf('month');
    let end = moment().endOf('month');
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

    $('.datashow').text(dataInicio + ' - ' + dataFim);

    $('#reportrange').on('apply.daterangepicker', function(ev, p) {
        dataInicio = p.startDate.format('YYYY-MM-DD');
        dataFim = p.endDate.format('YYYY-MM-DD');
        $('.datashow').text(dataInicio + ' - ' + dataFim);
        showLoading();
        carregarDados().finally(() => hideLoading());
    });
}

async function carregarDados() {
    try {
        $(".contudoTabela").fadeOut(400);

        let url = `/home/dados/${$('.Ano').val()}/${dataInicio}/${dataFim}/${$('.Tipo').val()}`;
        let d = await $.getJSON(url);

        console.log('Dados recebidos:', d);

        // Atualizar KPIs
        $('.diarias .valor').text((d.Diarianumero || 0).toFixed(2));
        $('.mensal .valor').text((d.mensalNumero || 0).toFixed(2));
        $('.Esperado .valor').text((d.totalNumero || 0).toFixed(2));
        $('.taxaCobranca .valor').text(d.dadoscobranca || '0%');

        // Armazenar dados para detalhes
        diariasdetalhes = d.diariadetalhes || [];
        mensaldetalhes = d.mensaldetalhes || [];
        esperadodetalhes = d.esperadodetalhes || [];

        console.log('diariadetalhes (array):', diariasdetalhes);
        console.log('Primeiro item de diariadetalhes:', diariasdetalhes[0]);

        // Renderizar gráficos
        renderMensal(d.dadosGrafico || [], d.totalNumero || 0);
        renderPizza(d.dadosGrafico || []);

        $('#lastUpdate').text('Última atualização: ' + moment().format('HH:mm:ss'));

        setTimeout(() => {
            $(".contudoGrafico").fadeIn(600);
        }, 200);

    } catch (error) {
        console.error('Erro ao carregar dados:', error);
        showToast('Erro ao carregar dados do dashboard', 'error');
    }
}

function renderMensal(dados, esperado) {
    if (chartMensal) chartMensal.destroy();

    const ctx = document.getElementById('chartMensal').getContext('2d');
    chartMensal = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: dados.map(x => x.classe || 'N/A'),
            datasets: [
                {
                    label: '✅ Pagos',
                    data: dados.map(x => parseFloat(x.pagos_activos) || 0),
                    backgroundColor: 'rgba(40, 167, 69, 0.8)',
                    borderColor: '#28a745',
                    borderWidth: 2,
                    borderRadius: 8
                },
                {
                    label: '❌ Não Pagos',
                    data: dados.map(x => parseFloat(x.nao_pagos_pendentes) || 0),
                    backgroundColor: 'rgba(220, 53, 69, 0.8)',
                    borderColor: '#dc3545',
                    borderWidth: 2,
                    borderRadius: 8
                },
                {
                    label: '📊 Esperado',
                    type: 'line',
                    data: Array(dados.length).fill(esperado),
                    borderColor: '#007bff',
                    borderWidth: 3,
                    fill: false,
                    tension: 0.4,
                    pointRadius: 5,
                    pointBackgroundColor: '#007bff',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                        usePointStyle: true,
                        boxWidth: 10
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let label = context.dataset.label || '';
                            let value = context.raw;
                            return `${label}: ${value.toFixed(2)} MZN`;
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Valor (MZN)'
                    },
                    ticks: {
                        callback: function(value) {
                            return value.toLocaleString() + ' MZN';
                        }
                    }
                }
            }
        }
    });
}

function renderPizza(dados) {
    if (chartPizza) chartPizza.destroy();

    const pagosTotal = dados.reduce((s, x) => s + (parseFloat(x.pagos_activos) || 0), 0);
    const naoPagosTotal = dados.reduce((s, x) => s + (parseFloat(x.nao_pagos_pendentes) || 0), 0);
    const percentualPagos = pagosTotal + naoPagosTotal > 0 ? ((pagosTotal / (pagosTotal + naoPagosTotal)) * 100).toFixed(1) : 0;

    const ctx = document.getElementById('chartPizza').getContext('2d');
    chartPizza = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['✅ Pagos', '❌ Não Pagos'],
            datasets: [{
                data: [pagosTotal, naoPagosTotal],
                backgroundColor: ['#28a745', '#dc3545'],
                borderWidth: 2,
                borderColor: '#fff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        usePointStyle: true,
                        padding: 15
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let label = context.label || '';
                            let value = context.raw;
                            let total = context.dataset.data.reduce((a, b) => a + b, 0);
                            let percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                            return `${label}: ${value.toFixed(2)} MZN (${percentage}%)`;
                        }
                    }
                }
            }
        }
    });

    $('#pizzaLegend').html(`
        <div class="row">
            <div class="col-6">
                <div class="small-box bg-success" style="background: #28a745; color: white; padding: 10px; border-radius: 8px;">
                    <strong>Pagos</strong><br>
                    ${pagosTotal} <br>
                    <small>${percentualPagos}% do total</small>
                </div>
            </div>
            <div class="col-6">
                <div class="small-box bg-danger" style="background: #dc3545; color: white; padding: 10px; border-radius: 8px;">
                    <strong>Não Pagos</strong><br>
                    ${naoPagosTotal}<br>
                    <small>${(100 - percentualPagos)}% do total</small>
                </div>
            </div>
        </div>
    `);
}

function exportChart(chart, nomeArquivo = 'grafico') {
    if (!chart) return;

    html2canvas(chart.canvas, {
        scale: 2,
        backgroundColor: '#ffffff'
    }).then(canvas => {
        const pdf = new jspdf.jsPDF('l', 'pt', [canvas.width, canvas.height]);
        pdf.addImage(canvas.toDataURL('image/png', 1.0), 'PNG', 0, 0, canvas.width, canvas.height);
        pdf.save(`${nomeArquivo}_${moment().format('YYYY-MM-DD_HH-mm')}.pdf`);
        showToast('Gráfico exportado com sucesso!', 'success');
    }).catch(error => {
        console.error('Erro ao exportar gráfico:', error);
        showToast('Erro ao exportar gráfico', 'error');
    });
}
</script>
<?php $__env->stopPush(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin-Lti', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\escola2025\resources\views/home-index.blade.php ENDPATH**/ ?>