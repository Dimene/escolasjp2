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

    @media (max-width: 768px) {
        .filter-section .row {
            flex-direction: column;
        }
        .filter-section .col-md-3 {
            margin-bottom: 15px;
        }
        .btn-modern, .btn-success-modern {
            width: 100%;
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
                <!-- Alerta informativo -->
                <div class="alert alert-info-custom alert-custom mb-4">
                    <i class="fa fa-info-circle fa-2x"></i>
                    <div>
                        <strong>Como funciona?</strong><br>
                        Selecione os filtros desejados e clique em "Consultar Referências".
                        O filtro de mês é opcional - se não selecionar, serão exibidos todos os meses disponíveis.
                    </div>
                </div>

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

                        <div class="col-md-9 d-flex align-items-end gap-2">
                            <button class="btn-modern" id="btnConsultar" onclick="consultarReferencias()">
                                <i class="fa fa-search mr-2"></i> Consultar Referências
                            </button>
                            <button class="btn-success-modern" id="btnGerarTodas" onclick="gerarTodasReferencias()" style="">
                                <i class="fa fa-file-pdf-o mr-2"></i> Gerar Todas as Referências
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Resultados -->
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
    var dataTableInstance = null; // Variável para armazenar a instância do DataTable

    $(document).ready(function() {
        // Carregar meses disponíveis
        carregarMeses();
            consultarReferencias();


        // Eventos de mudança nos filtros
        $("#selectAnoLectivo, #selectTipoPagamento, #selectClasse").on("change", function() {
            carregarMeses();
        });

        // Consultar automaticamente ao mudar os filtros principais
        $("#selectAnoLectivo, #selectTipoPagamento, #selectClasse, #selectEntidade, #selectMes").on("change", function() {
            consultarReferencias();
        });
    });

    // Função para carregar os meses disponíveis baseado nos filtros
    function carregarMeses() {
        var ano = parseInt($("#selectAnoLectivo").val());
        var tipopagamento = $("#selectTipoPagamento").val();
        var classe = parseInt($("#selectClasse").val());

        if (!ano || !tipopagamento || !classe) {
            $("#selectMes").html('<option value="">Selecione todos os filtros primeiro</option>');
            return;
        }

        // Filtrar meses
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

    // Função para destruir o DataTable se existir
    function destroyDataTable() {
        if (dataTableInstance) {
            dataTableInstance.destroy();
            dataTableInstance = null;
        }

        // Também verificar se existe tabela com id listadosalunos
        if ($.fn.DataTable.isDataTable('#listadosalunos')) {
            $('#listadosalunos').DataTable().destroy();
        }
    }

    // Função para inicializar o DataTable
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
                destroy: true // Isso permite recriar sem erro
            });
        }
    }

    // Função para consultar referências
    function consultarReferencias() {
        var entidade = $("#selectEntidade").val();
        var mes = $("#selectMes").val();
        var anolectivo = $("#selectAnoLectivo").val();
        var tipopagamento = $("#selectTipoPagamento").val();
        var classe = $("#selectClasse").val();

        // Validação básica
        if (!anolectivo || !tipopagamento || !classe) {
            $("#resultsContainer").html(`
                <div class="empty-state">
                    <i class="fa fa-exclamation-triangle"></i>
                    <p class="mt-2">Por favor, selecione todos os filtros necessários</p>
                </div>
            `);
            // $("#btnGerarTodas").hide();
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
                // $("#btnGerarTodas").hide();
            },
            success: function(data) {
                if (data && data.trim() !== "") {
                    $("#resultsContainer").html(data);

                    // Inicializar DataTable após o conteúdo ser carregado
                    setTimeout(function() {
                        initDataTable();
                    }, 100);

                    // Verificar se há alunos para mostrar o botão de gerar todas
                    if ($(".visualizarentidadesReferencias").length > 0) {
                        $("#btnGerarTodas").show();
                    } else {
                        // $("#btnGerarTodas").hide();
                    }

                } else {
                    $("#resultsContainer").html(`
                        <div class="empty-state">
                            <i class="fa fa-search"></i>
                            <p class="mt-2">Nenhum resultado encontrado para os filtros selecionados</p>
                            <small class="text-muted">Tente alterar os filtros ou selecionar um mês específico</small>
                        </div>
                    `);
                    // $("#btnGerarTodas").hide();
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
                // $("#btnGerarTodas").hide();
            }
        });
    }

    // Função para gerar referência individual



function gerarReferenciaIndividual(idpagamento, idaluno, nomeAluno) {



    const url = `/Financas/Banco/referencas/alunoReferenciasPrint/${idaluno}/${idpagamento}/0`;
    abrirReciboPDF(url, idaluno);
}
// Função para gerar todas as referências (usando a mesma lógica de atualização)
function gerarTodasReferencias() {
    // Buscar todos os botões "Gerar Referência" que ainda não têm referência
    var botoesGerar = $('.AtualizarReferencia');

    if (botoesGerar.length === 0) {
        Swal.fire({
            icon: 'warning',
            title: 'Atenção',
            text: 'Nenhuma referência pendente encontrada para gerar.'
        });
        return;
    }

    var entidade = $("[name='Entidade']").val();

    if (!entidade) {
        Swal.fire({
            title: 'Atenção!',
            text: 'Selecione um banco/entidade primeiro',
            icon: 'warning',
            confirmButtonColor: '#3085d6'
        });
        return;
    }

    Swal.fire({
        title: 'Confirmar',
        text: `Deseja gerar referências para ${botoesGerar.length} aluno(s)?`,
        icon: 'question',
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
                    // Finalizado
                    Swal.fire({
                        icon: sucessos > 0 ? 'success' : 'warning',
                        title: 'Processo Concluído!',
                        html: `<strong>Resumo:</strong><br>
                               ✅ Geradas com sucesso: ${sucessos}<br>
                               ❌ Falhas: ${falhas}<br>
                               📊 Total: ${botoes.length}`,
                        confirmButtonColor: '#3085d6'
                    }).then(() => {
                        // Recarregar a página para atualizar todos os dados
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

                // Atualizar progresso
                Swal.update({
                    html: `<div class="text-center">
                            <div class="spinner-border text-primary mb-3" role="status"></div>
                            <h5>Processando referência ${index + 1} de ${botoes.length}</h5>
                            <p class="text-muted">Aluno: ${linhaTabela.find('td:eq(1)').find('strong').text() || 'Carregando...'}</p>
                            <div class="progress mt-3">
                                <div class="progress-bar progress-bar-striped progress-bar-animated bg-success"
                                     style="width: ${((index) / botoes.length) * 100}%">
                                    ${Math.round(((index) / botoes.length) * 100)}%
                                </div>
                            </div>
                            <small class="text-muted mt-2 d-block">Aguardando resposta...</small>
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
                        console.log(`Resposta para ${id}:`, response);

                        if (response.referenciaBanco) {
                            sucessos++;

                            // Determinar classe da referência baseada no status
                            var badgeClass = 'badge bg-success';
                            var badgeIcon = 'fa fa-check-circle';

                            if (response.multaflagrefe > 0) {
                                badgeClass = 'badge bg-danger';
                                badgeIcon = 'fa fa-exclamation-circle';
                            } else {
                                badgeClass = 'badge bg-warning';
                                badgeIcon = 'fa fa-clock-o';
                            }

                            // Atualizar célula da referência
                            var cell = linhaTabela.find('td:eq(4)');
                            var referenciaHtml = '<span class="' + badgeClass + '" style="font-size: 0.8rem; padding: 0.4rem 0.8rem;">';
                            referenciaHtml += '<i class="' + badgeIcon + '"></i> ' + (response.referenciaBanco || response.referencia);
                            if (response.data_Fim && response.data_Fim <= 3 && !response.multaflegrefe) {
                                referenciaHtml += '<small class="d-block">Expira em breve</small>';
                            }
                            referenciaHtml += '</span>';
                            cell.html(referenciaHtml);

                            // Atualizar banco e entidade
                            if (response.banco) {
                                linhaTabela.find('td:eq(2)').html(response.banco);
                            }
                            if (response.Entidade) {
                                linhaTabela.find('td:eq(3)').html(response.Entidade);
                            }

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
                                valorCell.html(valorHtml);
                            }

                            // Atualizar estado
                            if (response.Estado || response.Estados) {
                                var estadoCell = linhaTabela.find('td:eq(6)');
                                var estadoTexto = response.Estado || response.Estados;

                                if (response.multaflagrefe > 0) {
                                    estadoTexto = '<span class="text-danger">PRAZO VENCIDO</span>';
                                } else if (response.data_Fim) {
                                    estadoTexto = '<span class="text-warning">PENDENTE</span>';
                                }
                                estadoCell.html(estadoTexto);
                            }

                            // Atualizar DataTable se existir
                            if (dataTable) {
                                var rowIndex = dataTable.row(linhaTabela).index();
                                dataTable.cell(rowIndex, 4).data(response.referenciaBanco);
                                if (response.valorDescricao) {
                                    var valorFinal = response.valorDescricao;
                                    if (response.multaflagrefe > 0 && response.multaP > 0) {
                                        valorFinal = valorFinal + ((response.multaP / 100) * valorFinal);
                                    }
                                    dataTable.cell(rowIndex, 5).data(formatMoney(valorFinal));
                                }
                            }

                            // Botão já foi substituído, não precisa adicionar impressão novamente
                        } else {
                            falhas++;
                            btn.html(originalHtml).prop('disabled', false);
                        }

                        // Atualizar progresso e continuar
                        var percentual = ((index + 1) / botoes.length) * 100;
                        Swal.update({
                            html: `<div class="text-center">
                                    <div class="spinner-border text-primary mb-3" role="status"></div>
                                    <h5>Processando referência ${index + 1} de ${botoes.length}</h5>
                                    <p class="text-muted">✅ ${sucessos} geradas com sucesso | ❌ ${falhas} falhas</p>
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
                        console.error('Erro ao gerar referência:', xhr);
                        falhas++;
                        btn.html(originalHtml).prop('disabled', false);

                        index++;
                        gerarProxima();
                    }
                });
            }

            // Iniciar o processo
            Swal.fire({
                title: 'Processando Referências',
                html: `<div class="text-center">
                        <div class="spinner-border text-primary mb-3" role="status"></div>
                        <h5>Preparando geração de referências...</h5>
                        <p class="text-muted">Total de ${botoes.length} aluno(s) para processar</p>
                        <div class="progress mt-3">
                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-success"
                                 style="width: 0%">0%</div>
                        </div>
                    </div>`,
                showConfirmButton: false,
                allowOutsideClick: false,
                didOpen: () => {
                    gerarProxima();
                }
            });
        }
    });
}


// Função para gerar todas as referências (pegando todos os registros do DataTable)
function gerarTodasReferencias() {
    // Pegar todos os dados do DataTable (todas as páginas)
    var todosOsDados = dataTable.rows({ search: 'applied' }).data();

    // Filtrar apenas os que NÃO têm referência (botão AtualizarReferencia ainda existe)
    var botoesGerar = [];

    // Percorrer todas as linhas do DataTable
    for (var i = 0; i < todosOsDados.length; i++) {
        var rowData = todosOsDados[i];
        var rowNode = dataTable.row(i).node();
        var botaoGerar = $(rowNode).find('.AtualizarReferencia');

        // Se encontrar o botão "Gerar Referência", adicionar à lista
        if (botaoGerar.length > 0) {
            botoesGerar.push({
                id: botaoGerar.attr('value'),
                btn: botaoGerar,
                linha: $(rowNode),
                nome: rowData[1] // Nome do aluno (ajuste o índice conforme sua tabela)
            });
        }
    }

    // Se não houver botões, mostrar mensagem
    if (botoesGerar.length === 0) {
        Swal.fire({
            icon: 'warning',
            title: 'Atenção',
            text: 'Nenhuma referência pendente encontrada para gerar.'
        });
        return;
    }

    var entidade = $("[name='Entidade']").val();

    if (!entidade) {
        Swal.fire({
            title: 'Atenção!',
            text: 'Selecione um banco/entidade primeiro',
            icon: 'warning',
            confirmButtonColor: '#3085d6'
        });
        return;
    }

    Swal.fire({
        title: 'Confirmar',
        text: `Deseja gerar referências para ${botoesGerar.length} aluno(s)?`,
        icon: 'question',
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

            function gerarProxima() {
                if (index >= botoesGerar.length) {
                    // Finalizado
                    Swal.fire({
                        icon: sucessos > 0 ? 'success' : 'warning',
                        title: 'Processo Concluído!',
                        html: `<strong>Resumo:</strong><br>
                               ✅ Geradas com sucesso: ${sucessos}<br>
                               ❌ Falhas: ${falhas}<br>
                               📊 Total: ${botoesGerar.length}`,
                        confirmButtonColor: '#3085d6'
                    }).then(() => {
                        // Recarregar a página para atualizar todos os dados
                        if (sucessos > 0) {
                            setTimeout(() => location.reload(), 2000);
                        }
                    });
                    return;
                }

                var item = botoesGerar[index];
                var btn = item.btn;
                var id = item.id;
                var linhaTabela = item.linha;
                var originalHtml = btn.html();

                // Atualizar progresso
                Swal.update({
                    html: `<div class="text-center">
                            <div class="spinner-border text-primary mb-3" role="status"></div>
                            <h5>Processando referência ${index + 1} de ${botoesGerar.length}</h5>
                            <p class="text-muted">Aluno: ${item.nome || 'Carregando...'}</p>
                            <div class="progress mt-3">
                                <div class="progress-bar progress-bar-striped progress-bar-animated bg-success"
                                     style="width: ${((index) / botoesGerar.length) * 100}%">
                                    ${Math.round(((index) / botoesGerar.length) * 100)}%
                                </div>
                            </div>
                            <small class="text-muted mt-2 d-block">Aguardando resposta...</small>
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
                        console.log(`Resposta para ${id}:`, response);

                        if (response.referenciaBanco) {
                            sucessos++;

                            // Determinar classe da referência baseada no status
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

                            // Atualizar célula da referência
                            var cell = linhaTabela.find('td:eq(4)');
                            var referenciaHtml = '<span class="' + badgeClass + '" style="font-size: 0.8rem; padding: 0.4rem 0.8rem;">';
                            referenciaHtml += '<i class="' + badgeIcon + '"></i> ' + (response.referenciaBanco || response.referencia);
                            referenciaHtml += '</span>';
                            cell.html(referenciaHtml);

                            // Atualizar banco e entidade
                            if (response.banco) {
                                linhaTabela.find('td:eq(2)').html(response.banco);
                            }
                            if (response.Entidade) {
                                linhaTabela.find('td:eq(3)').html(response.Entidade);
                            }

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
                                estadoCell.html('<span class="text-danger"><i class="fa fa-exclamation-triangle"></i> Prazo Vencido</span>');
                            } else if (response.Estado === "Pago") {
                                estadoCell.html('<span class="text-success"><i class="fa fa-check-circle"></i> Pago</span>');
                            } else {
                                estadoCell.html('<span class="text-warning"><i class="fa fa-clock-o"></i> Pendente</span>');
                            }

                            // Atualizar DataTable
                            if (dataTable) {
                                var rowIndex = dataTable.row(linhaTabela).index();
                                dataTable.cell(rowIndex, 4).data(response.referenciaBanco);
                                if (response.valorDescricao) {
                                    var valorFinal = response.valorDescricao;
                                    if (response.multaflagrefe > 0 && response.multaP > 0) {
                                        valorFinal = valorFinal + ((response.multaP / 100) * valorFinal);
                                    }
                                    dataTable.cell(rowIndex, 5).data(formatMoney(valorFinal));
                                }
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

                        // Atualizar progresso e continuar
                        var percentual = ((index + 1) / botoesGerar.length) * 100;
                        Swal.update({
                            html: `<div class="text-center">
                                    <div class="spinner-border text-primary mb-3" role="status"></div>
                                    <h5>Processando referência ${index + 1} de ${botoesGerar.length}</h5>
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
                        console.error('Erro ao gerar referência:', xhr);
                        falhas++;
                        btn.html(originalHtml).prop('disabled', false);

                        index++;
                        gerarProxima();
                    }
                });
            }

            // Iniciar o processo
            Swal.fire({
                title: 'Processando Referências',
                html: `<div class="text-center">
                        <div class="spinner-border text-primary mb-3" role="status"></div>
                        <h5>Preparando geração de referências...</h5>
                        <p class="text-muted">Total de ${botoesGerar.length} aluno(s) para processar</p>
                        <div class="progress mt-3">
                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-success"
                                 style="width: 0%">0%</div>
                        </div>
                    </div>`,
                showConfirmButton: false,
                allowOutsideClick: false,
                didOpen: () => {
                    gerarProxima();
                }
            });
        }
    });
}

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

    // Evento delegado para os botões de gerar referência
    $(document).on("click", ".visualizarentidadesReferencias", function(e) {
        e.preventDefault();
        var idpagamento = $(this).attr("idpagamento");
        var idaluno = $(this).attr("idaluno");
        var nomeAluno = $(this).attr("nome") || "Aluno";

        gerarReferenciaIndividual(idpagamento, idaluno, nomeAluno);
    });
</script>
<?php $__env->stopPush(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin-Lti', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/sgemozco/escolasaojoaopauloii.sgemoz.com/resources/views/Financas/Banco/visualizar-referencias.blade.php ENDPATH**/ ?>