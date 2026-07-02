$(document).ready(function () {
    buscarTiposPagamento();

    $(document).off('change', '[name="anolectivo_id"], [name="classe_id"]')
               .on('change', '[name="anolectivo_id"], [name="classe_id"]', function () {
        buscarTiposPagamento();
    });
});

function buscarTiposPagamento() {
    const ano = $('[name="anolectivo_id"]').val();
    const classe = $('[name="classe_id"]').val();
    $('.cabecalhoDados').html('<div class="text-center p-4"><i class="fas fa-spinner fa-spin fa-2x"></i><br>Carregando...</div>');

    $.ajax({
        url: `/RegistoAcademico/outrosPagamento/tipospagamentosShow/${ano}/${classe}`,
        method: 'GET',
        success: function (html) {
            $('.cabecalhoDados').html(html);
            setTimeout(() => {
                inicializarAbasBootstrap();
                inicializarDataTables();
            }, 100);
        },
        error: function (xhr, status, error) {
            console.error("Erro ao carregar dados:", error);
            $('.cabecalhoDados').html(
                '<div class="alert alert-danger">Erro ao carregar dados. Tente novamente.</div>'
            );
        }
    });
}

function inicializarAbasBootstrap() {
    document.querySelectorAll('[data-bs-toggle="tab"]').forEach(function(tabTriggerEl) {
        const tabInstance = bootstrap.Tab.getInstance(tabTriggerEl);
        if (tabInstance) {
            tabInstance.dispose();
        }
    });

    const tabTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tab"]'));
    tabTriggerList.forEach(function (tabTriggerEl) {
        new bootstrap.Tab(tabTriggerEl);
    });
}

// ============ FUNÇÕES AUXILIARES ============
function mostrarAlerta(titulo, texto, tipo) {
    Swal.fire({
        title: titulo,
        text: texto,
        icon: tipo,
        confirmButtonText: 'OK',
        confirmButtonColor: '#3085d6'
    });
}

function inicializarDataTables() {

    // =========================
    // DESTROY LIMPO
    // =========================
    if ($.fn.DataTable.isDataTable('#listadevalorestabela')) {
        $('#listadevalorestabela').DataTable().destroy();
    }

    $('#listadevalorestabela tfoot').remove();

    // =========================
    // FOOTER GARANTIDO
    // =========================
    const footerHtml = `
        <tfoot>
            <tr>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
        </tfoot>
    `;
    $('#listadevalorestabela').append(footerHtml);

    // =========================
    // INIT DATATABLE
    // =========================
    window.tabela = $('#listadevalorestabela').DataTable({
        dom: 'Bfrtip',
        pageLength: 5,
        destroy: true,

        buttons: [
            { extend: 'copy', className: 'btn btn-primary' },
            { extend: 'excel', className: 'btn btn-info' },
            { extend: 'pdf', className: 'btn btn-danger' },
            { extend: 'print', className: 'btn btn-success' }
        ],

        language: {
            search: "Pesquisar:",
            zeroRecords: "Nada encontrado",
            paginate: {
                next: "Próxima",
                previous: "Anterior"
            }
        },

        columns: [
            { data: 'id', width: '5%' },
            { data: 'nome', width: '30%' },
            { data: 'turma', width: '20%' },
            { data: 'estado', width: '15%' },
            { data: 'data_pagamento', width: '15%' },
            { data: 'acoes', width: '15%', orderable: false }
        ],

        initComplete: function () {
            const api = this.api();

            criarFiltroSelect(api, 2, 'filter-turma', 'Todas as Turmas');
            criarFiltroSelect(api, 3, 'filter-estado', 'Todos os Estados');
            criarFiltroData(api, 4);

        }
    });
}
function criarFiltroSelect(api, colIndex, className, label) {

    const col = api.column(colIndex);
    const footer = $(col.footer());

    footer.empty();

    const select = $(`
        <select class="form-select form-select-sm ${className}">
            <option value="">${label}</option>
        </select>
    `);

    footer.append(select);

    // valores únicos limpos
    col.data().unique().sort().each(function (d) {
        d = limparValor(d);
        if (d) {
            select.append(`<option value="${d}">${d}</option>`);
        }
    });

    // filtro correto
    select.on('change', function () {
        const val = $(this).val();
        col.search(val ? '^' + escapeRegex(val) + '$' : '', true, false).draw();
    });
}
function criarFiltroData(api, colIndex) {

    const col = api.column(colIndex);
    const footer = $(col.footer());

    footer.empty();

    const select = $(`
        <select class="form-select form-select-sm filter-data">
            <option value="">Todas as Datas</option>
        </select>
    `);

    footer.append(select);

    let datas = new Set();

    col.data().each(function (d) {
        d = limparValor(d);
        if (d) datas.add(d);
    });

    const ordenado = Array.from(datas).sort((a, b) => new Date(b) - new Date(a));

    ordenado.forEach(d => {
        select.append(`<option value="${d}">${formatarData(d)}</option>`);
    });

    select.on('change', function () {
        const val = $(this).val();
        col.search(val || '').draw();
    });
}
function limparValor(d) {
    if (!d) return '';
    return $('<div>').html(d).text().trim();
}

function escapeRegex(text) {
    return $.fn.dataTable.util.escapeRegex(text);
}

function formatarData(data) {
    if (!data) return '';
    const d = new Date(data);
    if (isNaN(d)) return data;
    return d.toLocaleDateString('pt-BR');
}
// Adicionar estilos CSS para os filtros
$(document).ready(function() {
    // Adicionar estilos personalizados
    $('<style>')
        .prop('type', 'text/css')
        .html(`
            #listadevalorestabela tfoot th {
                padding: 8px;
                background-color: #f8f9fa;
                vertical-align: middle;
            }

            .form-select-sm {
                width: 100%;
                font-size: 0.875rem;
                border-radius: 0.25rem;
                border: 1px solid #ced4da;
                padding: 0.25rem 0.5rem;
            }

            .form-select-sm:focus {
                border-color: #86b7fe;
                outline: 0;
                box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
            }

            #btnLimparFiltros {
                margin-left: 10px;
            }

            #listadevalorestabela tbody tr {
                cursor: pointer;
                transition: background-color 0.2s;
            }

            #listadevalorestabela tbody tr:hover {
                background-color: #f5f5f5;
            }
        `)
        .appendTo('head');
});

function atualizarDadosTabela(idtipo, idmes, idano, idclasse) {
    $.ajax({
        url: `/RegistoAcademico/outrosPagamento/show/${idano}/${idclasse}/${idtipo}/${idmes}`,
        method: "GET",
        success: function (data) {
            if (window.tabela) {
                window.tabela.clear().rows.add(data).draw();
            }
        },
        error: function (xhr, status, error) {
            console.error("Erro ao carregar dados da tabela:", error);
        }
    });
}

window.atualizarDadosTabela = atualizarDadosTabela;

// Controle de processamento para evitar duplicação
window.processingRequest = false;
window.pagamentoInicializado = false;
window.mesesSelecionados = [];

$(document).off('click', '.GuadarOutrosPagamentos')
           .on('click', '.GuadarOutrosPagamentos', function() {
    if (window.processingRequest) return;

    $(".Conteudopagamentos").fadeOut(400, function() {
        $(".Conteudopagamentospagar").slideDown(600);
    });

    let idaluno = $(this).attr('idaluno');
    let tipopagamento = $(this).attr('idtipo');
    let idmes = $(this).attr('idmes');

    pagar(idaluno, idmes, tipopagamento, null);
});

$(document).off('click', '.visualizarOutrosPagamentos')
           .on('click', '.visualizarOutrosPagamentos', function() {
    if (window.processingRequest) return;

    $(".Conteudopagamentos").fadeOut(400, function() {
        $(".Conteudopagamentospagar").slideDown(600);
    });

    let idaluno = $(this).attr('idaluno');
    let tipopagamento = $(this).attr('idtipo');
    let idmes = $(this).attr('idmes');

    mostrarEstadoMesesTIpo(idaluno, tipopagamento, null);
});

$(document).off('click', '.Voltarao_menumpagamentos')
           .on('click', '.Voltarao_menumpagamentos', function() {
    if (window.processingRequest) return;

    // Limpar variáveis globais
    window.pagamentoInicializado = false;
    window.mesesSelecionados = [];
    window.processingRequest = false;

    // Destruir instâncias
    $('.ConteudoPagarDados [data-bs-toggle="tab"]').each(function() {
        var tabInstance = bootstrap.Tab.getInstance(this);
        if (tabInstance) {
            tabInstance.dispose();
        }
    });

    // Limpar eventos específicos do pagamento
    $(document).off('click', '.toggle-btn');
    $(document).off('click', '[data-action="mark-all"]');
    $(document).off('change', '.tipopagamento');
    $(document).off('input', '#numeroMpesa');
    $(document).off('change', '.form-check-input');
    $(document).off('click', '#toggleResumo');
    $(document).off('click', '#closeResumo');
    $(document).off('click', '.select-mes');
    $(document).off('click', '.toggle-all-months');
    $(document).off('click', '#confirmarPagamento');
    $(document).off('click', '#Reverterpagamento');

    $(".ConteudoPagarDados").empty();

    $(".Conteudopagamentospagar").fadeOut(400, function() {
        $(".Conteudopagamentos").slideDown(600);
    });
});

function pagar(idaluno, idmes, tipopagamento, flag) {
    if (window.processingRequest) {
        console.log("Processamento em andamento, aguarde...");
        return;
    }

    window.processingRequest = true;

    // Resetar flag de inicialização
    window.pagamentoInicializado = false;
    window.mesesSelecionados = [];

    // Mostrar loader
    $(".ConteudoPagarDados").html(`
        <div class="text-center p-5">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Carregando...</span>
            </div>
            <p class="mt-2 text-muted">Carregando informações de pagamento...</p>
        </div>
    `);

    // Construir URL
    url = payrShow.replace(':idaluno', idaluno)
             .replace(':idmes', idmes)
             .replace(':tipopagamento', tipopagamento)
             .replace(':flag', flag || '');

    $.ajax({
        url: url,
        success: function(dados) {
            // Limpar completamente
            $(".ConteudoPagarDados").empty();
            $(".ConteudoPagarDados").html(dados);

            // Remover scripts inline da view carregada para evitar execução múltipla
            $('.ConteudoPagarDados script').remove();

            // Inicializar manualmente os componentes da view
            inicializarViewPagamento();

            // Flag para indicar que já foi inicializado
            window.pagamentoInicializado = true;
            window.processingRequest = false;
        },
        error: function(xhr, status, error) {
            console.error("Erro na função pagar:", error);
            $(".ConteudoPagarDados").html(`
                <div class="alert alert-danger text-center">
                    <i class="fas fa-exclamation-triangle fa-2x mb-2"></i>
                    <h5>Erro ao carregar dados</h5>
                    <p>Ocorreu um erro ao processar o pagamento. Tente novamente.</p>
                    <button class="btn btn-sm btn-outline-danger mt-2" onclick="location.reload()">
                        <i class="fas fa-redo"></i> Recarregar
                    </button>
                </div>
            `);
            window.processingRequest = false;
        }
    });
}

function mostrarEstadoMesesTIpo(idaluno, tipopagamento, flag) {
    if (window.processingRequest) {
        console.log("Processamento em andamento, aguarde...");
        return;
    }

    window.processingRequest = true;

    // Resetar flag de inicialização
    window.pagamentoInicializado = false;
    window.mesesSelecionados = [];

    // Mostrar loader
    $(".ConteudoPagarDados").html(`
        <div class="text-center p-5">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Carregando...</span>
            </div>
            <p class="mt-2 text-muted">Carregando informações de pagamento...</p>
        </div>
    `);

    // Construir URL
    url = mostrarestadodasparcelas.replace(':idaluno', idaluno)
             .replace(':tipo', tipopagamento)
             .replace(':flag', flag || '');

    $.ajax({
        url: url,
        success: function(dados) {
            // Limpar completamente
            $(".ConteudoPagarDados").empty();
            $(".ConteudoPagarDados").html(dados);

            // Remover scripts inline da view carregada para evitar execução múltipla
            $('.ConteudoPagarDados script').remove();

            // Inicializar manualmente os componentes da view
            inicializarViewPagamento();

            // Flag para indicar que já foi inicializado
            window.pagamentoInicializado = true;
            window.processingRequest = false;
        },
        error: function(xhr, status, error) {
            console.error("Erro na função pagar:", error);
            $(".ConteudoPagarDados").html(`
                <div class="alert alert-danger text-center">
                    <i class="fas fa-exclamation-triangle fa-2x mb-2"></i>
                    <h5>Erro ao carregar dados</h5>
                    <p>Ocorreu um erro ao processar o pagamento. Tente novamente.</p>
                    <button class="btn btn-sm btn-outline-danger mt-2" onclick="location.reload()">
                        <i class="fas fa-redo"></i> Recarregar
                    </button>
                </div>
            `);
            window.processingRequest = false;
        }
    });
}

// Função para inicializar manualmente a view de pagamento
function inicializarViewPagamento() {
    // Inicializar abas Bootstrap
    inicializarAbasPagamento();

    // Inicializar variáveis
    window.mesesSelecionados = [];

    // Inicializar funções específicas
    pedirReferencia();

    // Configurar eventos com delegação adequada
    setupEventosPagamento();

    // Mostrar apenas o primeiro mês de cada aba
    $('.tab-pane').each(function() {
        mostrarMes($(this));
    });

    // Configurar resumo flutuante
    $('#toggleResumo').off('click').on('click', function() {
        $('#resumoFlutuante').toggle();
    });

    $('#closeResumo').off('click').on('click', function() {
        $('#resumoFlutuante').hide();
    });

    // Atualizar resumo inicial
    atualizarResumo();
}

function inicializarAbasPagamento() {
    // Primeiro, destruir todas as instâncias existentes
    $('.ConteudoPagarDados [data-bs-toggle="tab"]').each(function() {
        var tabInstance = bootstrap.Tab.getInstance(this);
        if (tabInstance) {
            tabInstance.dispose();
        }
    });

    // Depois, criar novas instâncias
    const tabTriggerList = [].slice.call($('.ConteudoPagarDados [data-bs-toggle="tab"]'));
    tabTriggerList.forEach(function(tabTriggerEl) {
        new bootstrap.Tab(tabTriggerEl);
    });
}

// Funções específicas da view
function pedirReferencia() {
    let referenciaflag = $(".tipopagamento option:selected").attr("ReferenciaFlag");
    let $htm = `<label for="Referencia"><strong>Referencia</strong></label>
                <input type="text" class="form-control" id="Referencia" name="Referencia" required>
                <span class="StatusReferencia"></span>`;
    if (referenciaflag == 1) {
        $(".formReferenciaspagamento").html($htm);
    } else {
        $(".formReferenciaspagamento").empty();
    }
}

function pagamentoconfirmar(url, numero, metodopagamento, ReferenciaPagamento, totalValor, meses) {
    console.log("ola mundo", url, numero, metodopagamento, ReferenciaPagamento, meses);
    return $.ajax({
        url: url,
        method: 'GET',
        dataType: 'JSON',
        data: {
            valor: totalValor,
            Referencia: ReferenciaPagamento,
            metodo: metodopagamento,
            meses: meses,
            numero: numero
        }
    });
}

function validarReferencia(referencia) {
    return new Promise((resolve, reject) => {
        if (!referencia || referencia.trim() === "") {
            resolve({ valido: false, mensagem: "Referência não pode estar vazia" });
            return;
        }

        const url = validarReferenciaUrl + referencia;

        $.ajax({
            url: url,
            type: "GET",
            dataType: 'json',
            success: function(response) {
                if (response.status === "invalido") {
                    statusValidacaoReferencia = "invalido";
                    resolve({
                        valido: false,
                        mensagem: "Referência inválida",
                        detalhes: response
                    });
                } else {
                    statusValidacaoReferencia = "valido";
                    resolve({
                        valido: true,
                        mensagem: "Referência válida",
                        detalhes: response
                    });
                }
            },
            error: function() {
                reject("Erro ao validar referência");
            }
        });
    });
}

function mostrarMes($tab) {
    const mes = $tab.find('.select-mes').val();
    $tab.find('.month-container').hide();
    $tab.find('#month-' + mes).show();
}

function atualizarResumo() {
    const resumoContent = $('#resumoContent');
    const resumoTotal = $('#resumoTotal');
    const resumoCounter = $('#resumoCounter');

    if (window.mesesSelecionados.length === 0) {
        resumoContent.html('<div class="resumo-vazio"><i class="fas fa-calculator fa-2x mb-3"></i><p>Nenhum mês selecionado para pagamento</p><small>Marque os meses como "Pago" para aparecerem aqui</small></div>');
        resumoTotal.addClass('d-none');
        resumoCounter.text('0');
        return;
    }

    let html = '', total = 0;
    const grouped = {};

    window.mesesSelecionados.forEach(item => {
        if (!grouped[item.tipo]) grouped[item.tipo] = [];
        grouped[item.tipo].push(item);
    });

    console.log(window.mesesSelecionados);
    for (const tipo in grouped) {
        html += `<div class="resumo-item" style="background:#f1f1f1; padding:5px 10px; border-radius:4px; margin-top:5px;"><strong>${tipo}</strong></div>`;
        grouped[tipo].forEach(item => {
            if (item.valor !== 'Reverter') total += parseFloat(item.valor);
            html += `<div class="resumo-item" data-mes-id="${item.mesId}">
                        <div>${item.mes} ${item.ano}</div>
                        <div class="text-right">
                            <span class="badge ${item.valor === 'Reverter' ? 'badge-warning' : 'badge-success'}">${item.valor === 'Reverter' ? 'Reverter' : 'Pago'}</span><br>
                            <strong>${item.valor === 'Reverter' ? 'Reverter' : parseFloat(item.valor).toFixed(2).replace('.', ',') + ' MT'}</strong>
                        </div>
                    </div>`;
        });
    }

    resumoContent.html(html);
    resumoTotal.removeClass('d-none');
    $('#totalValor').text(total.toFixed(2).replace('.', ','));
    $('#totalItens').text(`${window.mesesSelecionados.length} ${window.mesesSelecionados.length === 1 ? 'item' : 'itens'}`);
    resumoCounter.text(window.mesesSelecionados.length);
}

// Controle para evitar duplo clique nos botões de confirmação
window.isProcessingPayment = false;
window.isProcessingRevert = false;

function setupEventosPagamento() {
    // Remover eventos antigos primeiro
    $(document).off('click', '.toggle-btn');
    $(document).off('click', '[data-action="mark-all"]');
    $(document).off('change', '.tipopagamento');
    $(document).off('input', '#numeroMpesa');
    $(document).off('change', '.form-check-input');
    $(document).off('change', '.select-mes');
    $(document).off('click', '.toggle-all-months');
    $(document).off('click', '#confirmarPagamento');
    $(document).off('click', '#Reverterpagamento');

    // Toggle individual Pago / Não Pago
    $(document).on('click', '.toggle-btn', function() {
        const $container = $(this).closest('.month-container');
        const mesId = $container.data('mes-id');
        const estado = $(this).data('estado');
        const $badge = $container.find('.badge');
        const prePago = $container.find('.btn-pago').attr('flag') === 'pago';
        const tipo = $(this).data('tipo');
        const tipoId = $(this).attr('tipoId');
        let valorMes = parseFloat($container.data('valor'));
        const $multa = $container.find('.form-check-input');
        const multavalor = $multa.is(':checked') ? parseFloat($multa.val()) : 0;

        console.log(multavalor, estado, tipo);

        // Atualiza badge
        if (estado === 'Pago') {
            $badge.removeClass('badge-warning badge-danger').addClass('badge-success').text('Pago');
        } else {
            $badge.removeClass('badge-success badge-danger').addClass('badge-warning').text('Pendente');
        }

        $container.find('.toggle-btn').removeClass('active');
        $(this).addClass('active');

        const index = window.mesesSelecionados.findIndex(i => i.mesId == mesId && i.idtipo == tipoId);

        if ($multa.is(':checked')) valorMes += parseFloat($multa.val());

        if (prePago) {
            if (estado === 'Pago') {
                if (index !== -1) window.mesesSelecionados.splice(index, 1);
            } else { // Reverter
                if (index === -1) {
                    const temReverter = mesesSelecionados.some(item => item.valor === 'Reverter');
                    if (temReverter || mesesSelecionados.length == 0) {
                        $("#confirmarPagamento").hide();
                        $("#Reverterpagamento").show();
                        window.mesesSelecionados.push({
                            mesId,
                            mes: $container.data('mes'),
                            ano: $container.data('ano'),
                            valor: 'Reverter',
                            tipo: tipo,
                            idtipo: tipoId,
                            multa: 0
                        });
                    }
                } else {
                    window.mesesSelecionados[index].valor = 'Reverter';
                }
            }
        } else {
            if (estado === 'Pago') {
                if (index === -1) {
                    const temReverter = mesesSelecionados.some(item => item.valor === 'Reverter');
                    if (!temReverter || mesesSelecionados.length == 0) {
                        $("#Reverterpagamento").hide();
                        $("#confirmarPagamento").show();
                        window.mesesSelecionados.push({
                            mesId,
                            mes: $container.data('mes'),
                            ano: $container.data('ano'),
                            valor: valorMes,
                            tipo: tipo,
                            idtipo: tipoId,
                            multa: multavalor
                        });
                    }
                } else {
                    window.mesesSelecionados[index].valor = valorMes;
                }
            } else {
                if (index !== -1) window.mesesSelecionados.splice(index, 1);
            }
        }

        atualizarResumo();
        if (mesesSelecionados.length == 0) {
            $("#Reverterpagamento").hide();
            $("#confirmarPagamento").hide();
        }
    });

    // Marcar todos
    $(document).on('click', '[data-action="mark-all"]', function() {
        const status = $(this).data('status');
        const $tab = $(this).closest('.tab-pane');
        $tab.find('.month-container:visible').each(function() {
            const $container = $(this);
            if (status === 'Pago') {
                $container.find('.btn-pago').click();
            } else {
                $container.find('.btn-nao-pago').click();
            }
        });
        $(this).siblings('.toggle-btn').removeClass('active');
        $(this).addClass('active');
    });

    // Mudança de tipo de pagamento
    $(document).on('change', '.tipopagamento', function() {
        let metodo = parseInt($(this).val());
        pedirReferencia();
        if (metodo == 2) $(".MpesaArea").slideDown(200);
        else $(".MpesaArea").slideUp(200);
    });

    // Validação do número M-Pesa
    $(document).on('input', '#numeroMpesa', function() {
        this.value = this.value.replace(/\D/g, '');
        if (this.value.length > 9) this.value = this.value.slice(0, 9);
        if (this.value.length === 9) {
            $(this).removeClass("is-invalid").addClass("is-valid");
            if (!this.value.startsWith("84") && !this.value.startsWith("85")) {
                $(this).addClass("is-invalid").removeClass("is-valid");
            }
        } else $(this).removeClass("is-valid").addClass("is-invalid");
    });

    // Adicionar/remover multa
    $(document).on('change', '.form-check-input', function() {
        const $container = $(this).closest('.month-container');
        const mesId = $container.data('mes-id');
        const checked = $(this).is(':checked');
        const index = window.mesesSelecionados.findIndex(i => i.mesId == mesId);
        if (index === -1) return;

        let baseValor = parseFloat($container.data('valor'));
        const multaValor = parseFloat($(this).val());
        if (window.mesesSelecionados[index].valor !== 'Reverter') {
            window.mesesSelecionados[index].valor = checked ? (baseValor + multaValor) : baseValor;
        }
        atualizarResumo();
    });

    // Evento de mudança de seleção de mês
    $(document).on('change', '.select-mes', function() {
        mostrarMes($(this).closest('.tab-pane'));
    });

    // Toggle mostrar todos os meses
    $(document).on('click', '.toggle-all-months', function() {
        const $tab = $(this).closest('.tab-pane');
        const showing = $(this).data('showing');
        if (showing) {
            mostrarMes($tab);
            $tab.find('.month-select-container').show();
            $(this).data('showing', false).removeClass('btn-secondary').addClass('btn-info')
                .html('<i class="fa fa-calendar"></i> Mostrar Todos os Meses');
        } else {
            $tab.find('.month-container').show();
            $tab.find('.month-select-container').hide();
            $(this).data('showing', true).removeClass('btn-info').addClass('btn-secondary')
                .html('<i class="fa fa-calendar"></i> Mostrar Um Mês');
        }
    });

    // Confirmação de Pagamento com proteção contra duplo clique
    $(document).on("click", "#confirmarPagamento", async function() {
        // if (window.isProcessingPayment) {
        //     mostrarAlerta('Aguarde', 'Processando pagamento...', 'info');
        //     return;
        // }
  const btn = $(this);
        window.isProcessingPayment = true;

        try {
            const campoReferencia = $("[name='Referencia']");
            if (campoReferencia.length > 0) {
                const referencia = campoReferencia.val().trim();

                if (!referencia) {
                    mostrarAlerta('Erro', 'Digite a referência de pagamento', 'error');
                    campoReferencia.addClass('is-invalid').focus();
                    return;
                }

                const validacao = await validarReferencia(referencia);

                console.log(validacao);
                if (!validacao.valido) {
                    $('#statusReferencia')
                        .removeClass('valida')
                        .addClass('invalida')
                        .text(validacao.mensagem)
                        .show();
                    mostrarAlerta('Referência Inválida', validacao.mensagem, 'error');
                    return;
                }

                $('#statusReferencia')
                    .removeClass('invalida')
                    .addClass('valida')
                    .text(validacao.mensagem)
                    .show();
            }

            var idaluno = btn.attr('idaluno');
            var Referencia = $('[name="Referencia"]').val();
            let urlspagamento = atualizarPagamento.replace(':idaluno', idaluno);
            var metodo = $("[name='tipopagamento']").val();
            var numero = $('#numeroMpesa').val();
            var valor = $('#totalValor').text().trim();

            if (window.mesesSelecionados.length == 0) {
                mostrarAlerta('Erro', 'Selecione as parcelas', 'error');
                return;
            }

            $.ajax({
                url: urlspagamento,
                method: 'POST',
                dataType: 'JSON',
                data: {
                    valor: valor,
                    Referencia: Referencia,
                    metodo: metodo,
                    meses: window.mesesSelecionados,
                    numero: numero,
                    _token: $token
                },

                beforeSend: function() {

    // Store original text if you need to restore it later
    const originalText = btn.html();

    // Store it on the button's data for use in complete callback
    btn.data('originalText', originalText);

    btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Processando...');
},

                success: function(response) {
                       var flag = 1;
                                const urlRecibo = `${imprimirRecibo}${response.anolectivo}/${response.idaluno}/${response.talao}/${response.metodo}/${flag}`;

                                const idtipo = $(".GuadarOutrosPagamentos").attr("idtipo");
                                const idmes = $(".GuadarOutrosPagamentos").attr("idmes");
                                const idano = $('[name="anolectivo_id"]').val();
                                const idclasse = $('[name="classe_id"]').val();
 $(".Voltarao_menumpagamentos").trigger("click");
                                atualizarDadosTabela(idtipo, idmes, idano, idclasse);
                    if (response.estado === "INS-0") {
                        Swal.fire({
                            title: 'Sucesso!',
                            text: 'Pagamento efetuado com sucesso!',
                            icon: 'success',
                            showCancelButton: true,
                            confirmButtonText: 'Ver Recibo',
                            cancelButtonText: 'Fechar'
                        }).then((result) => {
                            if (result.isConfirmed) {


                                abrirReciboPDF(urlRecibo, response.idaluno);
                            }

                            $('#formAluno')[0].reset();
                            $('#modalPagamentos').modal('hide');
                            inicializar();
                        });
                    } else {
                        mostrarAlerta('Erro', response.messagem);
                    }
                },
                error: function(xhr) {
                    let mensagem = 'Erro ao processar a matrícula';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        mensagem = xhr.responseJSON.message;
                    } else if (xhr.status === 422) {
                        const errors = xhr.responseJSON.errors;
                        mensagem = Object.values(errors).flat().join('\n');
                    }
                    mostrarAlerta('Erro', mensagem, 'error');
                },
                complete: function() {
                    btn.prop('disabled', false).html(originalText);
                    $('.imgprocessar').removeClass('ativo');
                    window.isProcessingPayment = false;
                }
            });
        } catch (error) {
            console.error("Erro na confirmação:", error);
            mostrarAlerta('Erro', 'Falha ao confirmar pagamento', 'error');
            btn.prop('disabled', false).html(originalText);
            window.isProcessingPayment = false;
        }
    });

    // Reversão de Pagamento com proteção contra duplo clique
    $(document).on("click", "#Reverterpagamento", async function() {
        if (window.isProcessingRevert) {
            mostrarAlerta('Aguarde', 'Processando reversão...', 'info');
            return;
        }

        window.isProcessingRevert = true;
        const btn = $(this);
        const originalText = btn.html();
        btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Processando...');

        try {
            var idaluno = btn.attr('idaluno');
            var Referencia = $('[name="Referencia"]').val();
            let urlspagamento = atualizarPagamento.replace(':idaluno', idaluno);
            var metodo = $("[name='tipopagamento']").val();
            var numero = $('#numeroMpesa').val();
            var valor = $('#totalValor').text().trim();

            if (window.mesesSelecionados.length == 0) {
                mostrarAlerta('Erro', 'Selecione as parcelas', 'error');
                return;
            }

            $.ajax({
                url: urlspagamento,
                method: 'POST',
                dataType: 'JSON',
                data: {
                    valor: valor,
                    Referencia: Referencia,
                    metodo: metodo,
                    meses: window.mesesSelecionados,
                    numero: numero,
                    _token: $token
                },
                success: function(response) {
                    if (response.estado === "INS-0") {
                        Swal.fire({
                            title: 'Sucesso!',
                            text: 'Reversão efetuada com sucesso!',
                            icon: 'success',
                            confirmButtonText: 'Fechar'
                        }).then((result) => {
                            if (result.isConfirmed) {

                                const idtipo = $(".GuadarOutrosPagamentos").attr("idtipo");
                                const idmes = $(".GuadarOutrosPagamentos").attr("idmes");
                                const idano = $('[name="anolectivo_id"]').val();
                                const idclasse = $('[name="classe_id"]').val();

                                atualizarDadosTabela(idtipo, idmes, idano, idclasse);
                                $(".Voltarao_menumpagamentos").trigger("click");

                            }

                            $('#modalPagamentos').modal('hide');
                            inicializar();
                        });
                    } else {
                        mostrarAlerta('Erro', response.messagem);
                    }
                },
                error: function(xhr) {
                    let mensagem = 'Erro ao processar a reversão';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        mensagem = xhr.responseJSON.message;
                    } else if (xhr.status === 422) {
                        const errors = xhr.responseJSON.errors;
                        mensagem = Object.values(errors).flat().join('\n');
                    }
                    mostrarAlerta('Erro', mensagem, 'error');
                },
                complete: function() {
                    btn.prop('disabled', false).html(originalText);
                    $('.imgprocessar').removeClass('ativo');
                    window.isProcessingRevert = false;
                }
            });
        } catch (error) {
            console.error("Erro na reversão:", error);
            mostrarAlerta('Erro', 'Falha ao processar reversão', 'error');
            btn.prop('disabled', false).html(originalText);
            window.isProcessingRevert = false;
        }
    });
}

// Adicionar limpeza quando a janela é fechada/atualizada
$(window).on('beforeunload', function() {
    window.pagamentoInicializado = false;
    window.mesesSelecionados = [];
    window.processingRequest = false;
    window.isProcessingPayment = false;
    window.isProcessingRevert = false;
});
