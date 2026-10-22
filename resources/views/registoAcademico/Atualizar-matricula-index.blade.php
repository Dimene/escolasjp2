@extends('layouts.admin-Lti')
@section('title', 'Matrícula | Atualização')

@section('content')
<style>
/* Popup PDF */
.pdf-popup {
  display: none;
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.8);
  z-index: 9999;
  animation: fadeIn 0.3s ease;
}

.pdf-popup-content {
  position: relative;
  margin: 2% auto;
  width: 90%;
  height: 90%;
  background: #fff;
  border-radius: 8px;
  box-shadow: 0 5px 30px rgba(0, 0, 0, 0.3);
  overflow: hidden;
  animation: slideIn 0.3s ease;
}

.pdf-close-btn {
  position: absolute;
  top: 10px;
  right: 10px;
  z-index: 10000;
  background: #dc3545;
  color: #fff;
  border: none;
  padding: 8px 15px;
  border-radius: 4px;
  cursor: pointer;
  font-size: 14px;
  transition: background 0.3s;
}

.pdf-close-btn:hover { background: #c82333; }

.pdf-controls {
  position: absolute;
  top: 10px;
  left: 10px;
  z-index: 10000;
  display: flex;
  gap: 10px;
}

.pdf-control-btn {
  background: #007bff;
  color: #fff;
  border: none;
  padding: 8px 15px;
  border-radius: 4px;
  cursor: pointer;
  font-size: 14px;
  transition: background 0.3s;
}

.pdf-control-btn:hover { background: #0056b3; }

.pdf-container {
  width: 100%;
  height: 100%;
  padding: 60px 20px 20px 20px;
}

#pdfFrame {
  width: 100%;
  height: 100%;
  border: none;
  border-radius: 4px;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

.pdf-loading {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  text-align: center;
  z-index: 100;
}

.pdf-loading p { margin-top: 15px; color: #666; font-size: 16px; }

@keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
@keyframes slideIn { from { transform: translateY(-30px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }

@media print {
  .pdf-popup { position: static; background: #fff; }
  .pdf-popup-content { margin: 0; width: 100%; height: 100%; box-shadow: none; }
  .pdf-close-btn, .pdf-controls { display: none !important; }
  .pdf-container { padding: 0; }
  #pdfFrame { box-shadow: none; }
}

.avatar-container, #camera-preview {
    width: 200px;
    height: 200px;
    border-radius: 50%;
    overflow: hidden;
    margin: auto;
    background: #f4f4f4;
    display: flex;
    justify-content: center;
    align-items: center;
    border: 3px solid #dee2e6;
}
.avatar-container img, #camera-preview video {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 50%;
}
.btn-foto button {
    width: 100%;
    margin-top: 5px;
}
#listadosalunos_filter { display: none; }
.loading-spinner { display: none; }
.loading .loading-spinner { display: inline-block; }
.referencia-status {
    font-size: 0.875rem;
    margin-top: 0.25rem;
    display: none;
}
.referencia-status.valida { color: #28a745; display: block; }
.referencia-status.invalida { color: #dc3545; display: block; }
.imgprocessar { display: none; }
.imgprocessar.ativo { display: inline-block; }
.modal-body { max-height: 70vh; overflow-y: auto; }
.campo-erro { border: 2px solid #dc3545 !important; background-color: #fff3f3; }
.campo-valido { border: 2px solid #28a745 !important; }
.is-invalid { border-color: #dc3545 !important; }
.is-valid { border-color: #28a745 !important; }
</style>

<div class="breadcrumb-modern animate-fadeInUp">
    <ol class="breadcrumb" style="background: transparent; margin: 0; padding: 0;">
        <li class="breadcrumb-item">
            <a href="#"><i class="fa fa-graduation-cap"></i> Registo Académico</a>
        </li>
        <li class="breadcrumb-item">
            <a href="#"><i class="fa fa-users"></i> Matricula</a>
        </li>
        <li class="breadcrumb-item active">
            <i class="fa fa-refresh"></i> <b>Matricula Internos</b>
        </li>
    </ol>
</div>

<div class="">
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                {{-- ===================== LISTA ALUNOS ===================== --}}
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5><b>Lista dos Alunos</b></h5>
                            <input type="text" id="searchAlunos" class="form-control mb-2" placeholder="Pesquisar aluno...">
                            <table class="table table-bordered" id="listadosalunos">
                                <thead>
                                    <tr>
                                        <th>Nome</th>
                                        <th>Ação</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($alunos as $aluno)
                                    <tr data-aluno-id="{{ $aluno->id }}">
                                        <td>{{ $aluno->nome }}</td>
                                        <td class="text-center">
                                            <button class="btn btn-primary btn-sm AtualizarMatricula"
                                                    data-id="{{ $aluno->id }}"
                                                    title="Atualizar matrícula">
                                                <i class="fa fa-upload"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- ===================== CONTEÚDO ===================== --}}
                <div class="col-md-8">
                    <div class="form-group">
                        <label>Selecione o ano lectivo</label>
                        <select class="form-control mb-2 anolectivo select-class-ano" id="anolectivo" name="anolectivo">
                            @foreach($anolectivo as $ano)
                            <option value="{{ $ano->id }}">{{ $ano->anolectivo }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="card">
                        <div class="card-body ConteudoDeAtualizacao text-center text-muted">
                            <i class="fas fa-user-graduate fa-3x mb-3"></i>
                            <p>Selecione um aluno da lista para atualizar a matrícula</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

{{-- ===================== MODAL PAGAMENTO ===================== --}}
<div class="modal fade" id="modalPagamentos" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirmação de Pagamento</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="corpoConteudo">
                    <div class="text-center py-4">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Carregando...</span>
                        </div>
                        <p class="mt-2">Carregando informações de pagamento...</p>
                    </div>
                </div>
                <!-- Loading -->
                <div class="text-center">
                    <img src="{{ asset('imageproceaament/loading.gif') }}" class="imgprocessar" style="width:100px; height:100px;">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary btn-matricula" id="btnConfirmarPagamento">
                    <i class="fas fa-check"></i> Confirmar Pagamento
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Popup para PDF -->
<div id="pdfPopup" class="pdf-popup">
  <div class="pdf-popup-content">
    <button type="button" id="closeBtn" class="pdf-close-btn">
      <i class="fas fa-times"></i> Fechar
    </button>
    <div class="pdf-controls">
      <button type="button" id="printBtn" class="pdf-control-btn">
        <i class="fas fa-print"></i> Imprimir
      </button>
      <button type="button" id="downloadBtn" class="pdf-control-btn">
        <i class="fas fa-download"></i> Baixar
      </button>
    </div>
    <div class="pdf-container">
      <iframe id="pdfFrame" frameborder="0"></iframe>
    </div>
    <div id="pdfLoading" class="pdf-loading">
      <div class="spinner-border text-primary" role="status">
        <span class="visually-hidden">Carregando PDF...</span>
      </div>
      <p>Carregando recibo...</p>
    </div>
  </div>
</div>

@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.26/webcam.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('MyJs/imprimirRecibo.js') }}"></script>

<script>
$(document).ready(function() {
    // ============ VARIÁVEIS GLOBAIS ============
    const URLS = {
        atualizarAluno: "/aluno/matricula/atualizar/",
        atualizarM: "/aluno/matricula/atualizarM/",
        selecionarValores: "/aluno/matricula/selecionar_tabelaValores/",
        validarReferencia: "/aluno/matricula/validarReferencia/",
        imprimirRecibo: "/aluno/matricula/imprimir/recibo/"


    };

    const tabelaValoresAno = @json($tabelavaloresano);
    const mesesNomes = @json($mesesNomes);
    const modalidadesAnoLectivo = @json($modalidadesAnoLectivo);
    const CSRF_TOKEN = '{{ csrf_token() }}';

    let alunoSelecionado = null;
    let cameraAtiva = false;
    let dadosPagamento = null;
    let statusValidacaoReferencia = "";
    let processandoPagamento = false;
    let parcelasSelecionadasAntesModal = [];

    // Configurar CSRF globalmente
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': CSRF_TOKEN,
            'X-Requested-With': 'XMLHttpRequest'
        }
    });

    // ============ DATATABLE ============
    $('#listadosalunos').DataTable({
        pageLength: 10,
        searching: true,
        ordering: true,
        info: false,
        lengthChange: false,
        language: {
            search: "Pesquisar:",
            zeroRecords: "Nenhum aluno encontrado"
        }
    });

    $('#searchAlunos').on('keyup', function() {
        $('#listadosalunos').DataTable().search(this.value).draw();
    });

    // ============ CARREGAR ALUNO ============
    $(document).on('click', '.AtualizarMatricula', async function() {
        const botao = $(this);
        const alunoId = botao.data('id');

        try {
            botao.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i>');
            const response = await $.get(URLS.atualizarAluno + alunoId);

            $('.ConteudoDeAtualizacao').html(response);
            alunoSelecionado = alunoId;

            // Destacar linha selecionada
            $('#listadosalunos tr').removeClass('table-primary');
            botao.closest('tr').addClass('table-primary');

            // Atualizar pagamentos inicialmente
          
            atualizarPagamentos();

        } catch (error) {
            mostrarAlerta('Erro', 'Falha ao carregar dados do aluno', 'error');
            console.error('Erro:', error);
        } finally {
            botao.prop('disabled', false).html('<i class="fa fa-upload"></i>');
        }
    });

    // ============ PAGAMENTOS ============
    function atualizarPagamentos() {

      
        if (!alunoSelecionado) return;

        const ano = $('#anolectivo').val();
        const classe = $('[name="ClassedeAtualizacao"]').val();
        const $lista = $('.ConteudoDeAtualizacao #listaPagamentosTab');
 
        if (!ano || !classe) {
            $lista.html(
                '<li class="list-group-item text-center text-muted">' +
                'Selecione uma classe para consultar os pagamentos e parcelas.</li>'
            );
            return;
        }
   

        atualizarPagamentosPorAno(ano, classe);
    }

    function atualizarPagamentosPorAno(anoId, classeId) {
        const $lista = $('.ConteudoDeAtualizacao #listaPagamentosTab');
        if (!$lista.length) return;

        const modalidade = modalidadesAnoLectivo[anoId];
        const modalidadeNome = obterNomeModalidade(modalidade?.modalidade);
        $('.ConteudoDeAtualizacao #modalidadeAnoLectivo').text(modalidadeNome
            ? `Modalidade: ${modalidadeNome}`
            : 'Modalidade do ano lectivo não definida');

        const pagamentos = tabelaValoresAno.filter(item =>
            item.idanolectivo == anoId && item.classId == classeId && Number(item.id) > 2
        );

        const html = pagamentos.map(item => {
            let parcelas = item.detalhes;
            if (typeof parcelas === 'string') {
                try {
                    parcelas = JSON.parse(parcelas);
                } catch (error) {
                    console.error(`Parcelas inválidas no tipo de pagamento ${item.id}`, error);
                    return '';
                }
            }

            parcelas = Array.isArray(parcelas) ? parcelas : [];
            const parcelasHtml = parcelas.map((parcela, index) => {
                const idParcela = `atualizar-parcela-${item.id}-${index}`;
                const nomeParcela = mesesNomes[parcela.mes] || `Parcela ${index + 1}`;
                const inicio = formatarData(parcela.inicio);
                const limite = formatarData(parcela.limite);
                const periodo = inicio && limite
                    ? `${inicio} a ${limite}`
                    : limite ? `Vencimento: ${limite}` : '';
                const periodoModalidade = obterPeriodoModalidade(parcela, modalidade);

                return `
                    <div class="custom-control custom-checkbox mb-1">
                        <input type="checkbox" class="custom-control-input checkbox-parcela"
                               id="${idParcela}"
                               data-tipo="${escapeHtml(item.id)}"
                               data-mes="${escapeHtml(parcela.mes)}"
                               data-valor="${Number(item.valorDescricao) || 0}" checked>
                        <label class="custom-control-label" for="${idParcela}">
                            ${escapeHtml(nomeParcela)}
                            <span class="text-muted ml-1">${formatarValor(item.valorDescricao)}</span>
                            ${periodoModalidade ? `<span class="badge badge-light ml-1">${escapeHtml(periodoModalidade)}</span>` : ''}
                            ${periodo ? `<small class="d-block text-muted">${periodo}</small>` : ''}
                        </label>
                    </div>`;
            }).join('');

            const toggleParcelas = parcelas.length > 1
                ? `<button type="button" class="btn btn-sm btn-link p-0 btn-toggle-parcelas"
                           data-target="#atualizar-parcelas-${item.id}" aria-expanded="false">
                       Ver parcelas <i class="fas fa-chevron-down ml-1"></i>
                   </button>`
                : '';

            return `
                <li class="list-group-item">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input checkbox-pagamento"
                                   id="atualizar-pagamento-${item.id}" checked>
                            <label class="custom-control-label" for="atualizar-pagamento-${item.id}">
                                <strong>${escapeHtml(item.Finalidade)}</strong><br>
                                <small class="text-muted">
                                    <span class="parcelas-selecionadas">${parcelas.length}</span>
                                    de ${parcelas.length} parcelas selecionadas
                                </small>
                            </label>
                        </div>
                        <div class="text-right">
                            <span class="badge badge-primary valor-pagamento-selecionado">
                                ${formatarValor(parcelas.length * (Number(item.valorDescricao) || 0))}
                            </span>
                            ${toggleParcelas}
                        </div>
                    </div>
                    <div id="atualizar-parcelas-${item.id}" class="pl-4 pt-2" hidden>
                        ${parcelasHtml}
                    </div>
                </li>`;
        }).join('');

        $lista.html(html || (
            '<li class="list-group-item text-center text-muted">' +
            'Nenhum pagamento configurado para esta classe e ano lectivo.</li>'
        ));
        atualizarResumoListaPagamentos();
    }

    function obterNomeModalidade(numero) {
        const nomes = { 2: 'Semestre', 3: 'Trimestre', 4: 'Bimestre', 12: 'Modular' };
        return nomes[Number(numero)] || (Number(numero) > 0 ? `${numero} períodos` : '');
    }

    function obterPeriodoModalidade(parcela, modalidade) {
        if (!modalidade) return '';

        const dataParcela = String(parcela.limite || parcela.inicio || '').slice(0, 10);
        const divisaoPorData = (modalidade.divisoes || []).find(divisao => {
            const inicio = String(divisao.inicio || '').slice(0, 10);
            const fim = String(divisao.fim || '').slice(0, 10);
            return dataParcela && inicio && fim && dataParcela >= inicio && dataParcela <= fim;
        });
        let numero = divisaoPorData?.numero;

        if (!numero) {
            const mes = Number(parcela.mes);
            const quantidade = Number(modalidade.modalidade);
            if (mes > 0 && mes <= 12 && quantidade > 0) {
                numero = Math.ceil(mes / (12 / quantidade));
            }
        }

        return numero ? `${obterNomeModalidade(modalidade.modalidade)} ${numero}` : '';
    }

    function formatarValor(valor) {
        return `${Number(valor || 0).toLocaleString('pt-MZ', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        })} MT`;
    }

    function formatarData(value) {
        if (!value) return '';
        const parts = String(value).slice(0, 10).split('-');
        return parts.length === 3 ? `${parts[2]}/${parts[1]}/${parts[0]}` : escapeHtml(value);
    }

    function escapeHtml(value) {
        return $('<div>').text(value == null ? '' : value).html();
    }

    function obterParcelasSelecionadas() {
        return $('.ConteudoDeAtualizacao #listaPagamentosTab .checkbox-parcela:checked')
            .map(function() {
                return {
                    tipo: $(this).data('tipo'),
                    mes: $(this).data('mes')
                };
            })
            .get();
    }

    function atualizarResumoListaPagamentos() {
        $('.ConteudoDeAtualizacao #listaPagamentosTab > li').each(function() {
            const $grupo = $(this);
            const $parcelas = $grupo.find('.checkbox-parcela');
            if (!$parcelas.length) return;

            const selecionadas = $parcelas.filter(':checked');
            const total = selecionadas.toArray().reduce((soma, parcela) => {
                return soma + (Number($(parcela).data('valor')) || 0);
            }, 0);

            $grupo.find('.parcelas-selecionadas').text(selecionadas.length);
            $grupo.find('.valor-pagamento-selecionado').text(formatarValor(total));
            $grupo.find('.checkbox-pagamento')
                .prop('checked', selecionadas.length === $parcelas.length)
                .prop('indeterminate', selecionadas.length > 0 && selecionadas.length < $parcelas.length);
        });
    }

    // ============ EVENTOS DE PAGAMENTO ============
    $(document).on('change', '.select-class-ano, #anolectivo', function() {
        atualizarPagamentos();
    });

    $(document).on('change', '.checkbox-pagamento', function(e) {
        $(this).closest('li').find('.checkbox-parcela')
            .prop('checked', e.currentTarget.checked);
        $(this).prop('indeterminate', false);
        atualizarResumoListaPagamentos();
    });

    $(document).on('change', '.checkbox-parcela', function() {
        atualizarResumoListaPagamentos();
    });

    $(document).on('click', '.btn-toggle-parcelas', function() {
        const $botao = $(this);
        const $parcelas = $($botao.data('target'));
        const mostrar = $parcelas.prop('hidden');

        $parcelas.prop('hidden', !mostrar);
        $botao.attr('aria-expanded', mostrar);
        $botao.html(mostrar
            ? 'Ocultar parcelas <i class="fas fa-chevron-up ml-1"></i>'
            : 'Ver parcelas <i class="fas fa-chevron-down ml-1"></i>');
    });

    // ============ PREPARAR ATUALIZAÇÃO ============
    $(document).on('click', '.botaoAtualizacaoAlunoId', function() {
        if (!alunoSelecionado) {
            mostrarAlerta('Atenção', 'Selecione um aluno primeiro', 'warning');
            return;
        }

        const parcelas = obterParcelasSelecionadas();
        const ano = $('#anolectivo').val();
        const classe = $('[name="ClassedeAtualizacao"]').val();

        if (!ano || !classe) {
            mostrarAlerta('Atenção', 'Selecione o ano lectivo e a classe de destino', 'warning');
            return;
        }

        dadosPagamento = { ano, classe, parcelas };
        parcelasSelecionadasAntesModal = parcelas;
        carregarModalPagamento(ano, classe, parcelas);
    });

    function carregarModalPagamento(ano, classe, parcelas) {
        if (processandoPagamento) return;

        processandoPagamento = true;
        $('.imgprocessar').addClass('ativo');

        $.ajax({
            url: `${URLS.selecionarValores}${classe}/${ano}/2`,
            type: "GET",
            data: { parcelas: parcelas },
            success: function(data) {
                $('.corpoConteudo').html(data);
                $("#btnConfirmarPagamento").show();

                if ($(".flagdeativaConformacao").val() == parseInt(0)) {
                    $("#btnConfirmarPagamento").hide();
                }

                $('#modalPagamentos').modal('show');
            },
            error: function() {
                $('#modalPagamentos').modal('hide');
                mostrarAlerta('Erro', 'Falha ao carregar informações de pagamento', 'error');
            },
            complete: function() {
                $('.imgprocessar').removeClass('ativo');
                processandoPagamento = false;
            }
        });
    }

    // ============ VALIDAÇÃO DE REFERÊNCIA ============
    function validarReferencia(referencia) {
        return new Promise((resolve, reject) => {
            if (!referencia || referencia.trim() === "") {
                resolve({ valido: false, mensagem: "Referência não pode estar vazia" });
                return;
            }

            const url = `${URLS.validarReferencia}${referencia}`;

            $.ajax({
                url: url,
                type: "GET",
                dataType: 'json',
                success: function(response) {
                    if (response.status === "invalido") {
                        statusValidacaoReferencia = "invalido";
                        resolve({ valido: false, mensagem: "Referência inválida", detalhes: response });
                    } else {
                        statusValidacaoReferencia = "valido";
                        resolve({ valido: true, mensagem: "Referência válida", detalhes: response });
                    }
                },
                error: function() {
                    reject("Erro ao validar referência");
                }
            });
        });
    }

    // ============ CONFIRMAR PAGAMENTO ============
    $(document).on('click', '#btnConfirmarPagamento', async function() {
        const btn = $(this);
        const originalText = btn.html();

        try {
            btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Processando...');

            // 1. Validar referência se existir
            const campoReferencia = $("[name='Referencia']");
            if (campoReferencia.length > 0) {
                const referencia = campoReferencia.val().trim();

                if (!referencia) {
                    mostrarAlerta('Erro', 'Digite a referência de pagamento', 'error');
                    campoReferencia.addClass('is-invalid').focus();
                    btn.prop('disabled', false).html(originalText);
                    return;
                }

                const validacao = await validarReferencia(referencia);
                if (!validacao.valido) {
                    let $status = $('#statusReferencia');
                    if ($status.length === 0) {
                        $status = $('<small>').attr('id', 'statusReferencia').addClass('referencia-status');
                        campoReferencia.after($status);
                    }
                    $status.removeClass('valida').addClass('invalida').text(validacao.mensagem).show();
                    mostrarAlerta('Referência Inválida', validacao.mensagem, 'error');
                    btn.prop('disabled', false).html(originalText);
                    return;
                }

                let $status = $('#statusReferencia');
                if ($status.length === 0) {
                    $status = $('<small>').attr('id', 'statusReferencia').addClass('referencia-status');
                    campoReferencia.after($status);
                }
                $status.removeClass('invalida').addClass('valida').text(validacao.mensagem).show();
            }

            // 2. Preparar dados
            const alunoId = $('#idAlunos').val() || alunoSelecionado;
            if (!alunoId) {
                throw new Error('ID do aluno não encontrado');
            }

            // 3. Criar FormData manualmente
            const formData = new FormData();
            formData.append('idAlunos', alunoId);
            formData.append('ClassedeAtualizacao', $('[name="ClassedeAtualizacao"]').val());
            formData.append('anolectivo', $('#anolectivo').val());

            // Parcelas selecionadas
            const parcelas = dadosPagamento?.parcelas || [];
            parcelas.forEach((parcela, index) => {
                formData.append(`parcelasPreModal[${index}][tipo]`, parcela.tipo);
                formData.append(`parcelasPreModal[${index}][mes]`, parcela.mes);
            });

            // Foto da câmera (base64)
            const fotoBase64 = $('.image-tag').val();
            if (fotoBase64 && fotoBase64.startsWith('data:image')) {
                const base64Data = fotoBase64.split(',')[1];
                const binaryString = atob(base64Data);
                const bytes = new Uint8Array(binaryString.length);
                for (let i = 0; i < binaryString.length; i++) {
                    bytes[i] = binaryString.charCodeAt(i);
                }
                const blob = new Blob([bytes], { type: 'image/jpeg' });
                formData.append('image', blob, `foto_camera_${alunoId}_${Date.now()}.jpg`);
            }

            // Upload de arquivo
            const fileInput = document.getElementById('fileexplorer');
            if (fileInput && fileInput.files.length > 0) {
                formData.append('avatar-file', fileInput.files[0]);
            }

            // Dados do modal de pagamento
            const modalForm = document.querySelector('#modalPagamentos form');
            if (modalForm) {
                $(modalForm).find('input, select, textarea').each(function() {
                    const $this = $(this);
                    const nome = $this.attr('name');
                    const tipo = $this.attr('type');
                    const valor = $this.val();

                    if (!nome || nome === '_token' || nome === '_method') return;

                    if (tipo === 'checkbox' || tipo === 'radio') {
                        if ($this.is(':checked')) {
                            formData.append(nome, valor || 'on');
                        }
                    } else if (tipo === 'file') {
                        if ($this[0].files.length > 0) {
                            for (let i = 0; i < $this[0].files.length; i++) {
                                formData.append(nome, $this[0].files[i]);
                            }
                        }
                    } else if (valor !== undefined && valor !== '') {
                        formData.append(nome, valor);
                    }
                });
            }

            // CSRF Token
            let csrfToken = $('meta[name="csrf-token"]').attr('content') || CSRF_TOKEN;
            if (!csrfToken || csrfToken.length < 10) {
                const cookies = document.cookie.split('; ');
                for (const cookie of cookies) {
                    if (cookie.startsWith('XSRF-TOKEN=')) {
                        csrfToken = decodeURIComponent(cookie.split('=')[1]);
                        break;
                    }
                }
            }
            if (!csrfToken || csrfToken.length < 10) {
                throw new Error('Token CSRF não encontrado. Recarregue a página.');
            }
            formData.append('_token', csrfToken);
            formData.append('_method', 'PUT');

            // 4. Enviar requisição
            const resposta = await $.ajax({
                url: `${URLS.atualizarM}${alunoId}`,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json'
            });

            // 5. Processar resposta
            if (resposta.success || resposta.estado === "INS-0") {
                await processarSucesso(resposta);
            } else {
                throw new Error(resposta.messagem || 'Erro desconhecido do servidor');
            }

        } catch (error) {
            console.error('❌ Erro no envio:', error);

            let mensagemErro = error.message;
            if (error.responseJSON) {
                mensagemErro = error.responseJSON.message || JSON.stringify(error.responseJSON);
            }

            mostrarAlerta('Erro', mensagemErro, 'error');

            if (error.status === 419 || mensagemErro.includes('CSRF')) {
                Swal.fire({
                    title: 'Sessão Expirada',
                    text: 'Sua sessão expirou. Deseja recarregar a página?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Sim, recarregar',
                    cancelButtonText: 'Não'
                }).then((result) => {
                    if (result.isConfirmed) location.reload();
                });
            }
        } finally {
            btn.prop('disabled', false).html(originalText);
        }
    });

    async function processarSucesso(resposta) {
        const opcoes = {
            title: 'Sucesso!',
            text: resposta.message || 'Matrícula atualizada com sucesso!',
            icon: 'success'
        };

        if (resposta.estado === "INS-0" && resposta.anolectivo && resposta.idaluno && resposta.talao) {
            opcoes.showCancelButton = true;
            opcoes.confirmButtonText = 'Imprimir Recibo';
            opcoes.cancelButtonText = 'Fechar';
        }

        const resultado = await Swal.fire(opcoes);

        if (resultado.isConfirmed && resposta.estado === "INS-0") {
            const urlRecibo = `${URLS.imprimirRecibo}${resposta.anolectivo}/${resposta.idaluno}/${resposta.talao}/${resposta.metodo}`;
            abrirReciboPDF(urlRecibo, resposta.idaluno);
        }

        $('#modalPagamentos').modal('hide');
    }

    // ============ CÂMERA ============
    $(document).on('click', '#startCamera', function() {
        if (cameraAtiva) return;

        Webcam.set({
            width: 200,
            height: 200,
            image_format: 'jpeg',
            jpeg_quality: 90
        });

        Webcam.attach('#camera-preview');
        $('#camera-preview').show();
        $('#avatar-container').hide();
        $('#takeSnapshot, #stopCamera').show();
        $('#startCamera, #fileexplorer').hide();

        cameraAtiva = true;
    });

    $(document).on('click', '#stopCamera', function() {
        if (!cameraAtiva) return;

        Webcam.reset();
        $('#camera-preview').hide();
        $('#avatar-container').show();
        $('#takeSnapshot, #stopCamera').hide();
        $('#startCamera, #fileexplorer').show();

        cameraAtiva = false;
    });

    $(document).on('click', '#takeSnapshot', function() {
        if (!cameraAtiva) return;

        Webcam.snap(function(uri) {
            $('.image-tag').val(uri);
            $('#avatar-container').html(`<img src="${uri}">`).show();
            Webcam.reset();
            $('#camera-preview').hide();
            $('#takeSnapshot, #stopCamera').hide();
            $('#startCamera, #fileexplorer').show();
            cameraAtiva = false;
        });
    });

    $(document).on('change', '#fileexplorer', function(e) {
        const file = e.target.files[0];
        if (!file) return;

        const reader = new FileReader();
        reader.onload = function(e) {
            $('#avatar-container').html(`<img src="${e.target.result}">`);
        };
        reader.readAsDataURL(file);
    });

    // ============ AUXILIARES ============
    function mostrarAlerta(titulo, texto, tipo) {
        return Swal.fire({
            title: titulo,
            text: texto,
            icon: tipo,
            confirmButtonText: 'OK',
            confirmButtonColor: '#3085d6'
        });
    }
});
</script>
@endpush