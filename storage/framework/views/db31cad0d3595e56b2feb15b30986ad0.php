<?php $__env->startSection('title', 'Matrícula | Atualização'); ?>

<?php $__env->startSection('content'); ?>
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

.pdf-close-btn:hover {
  background: #c82333;
}

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

.pdf-control-btn:hover {
  background: #0056b3;
}

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

.pdf-loading p {
  margin-top: 15px;
  color: #666;
  font-size: 16px;
}

@keyframes fadeIn {
  from { opacity: 0; }
  to { opacity: 1; }
}

@keyframes slideIn {
  from { transform: translateY(-30px); opacity: 0; }
  to { transform: translateY(0); opacity: 1; }
}

/* Para impressão do popup */
@media print {
  .pdf-popup {
    position: static;
    background: #fff;
  }

  .pdf-popup-content {
    margin: 0;
    width: 100%;
    height: 100%;
    box-shadow: none;
  }

  .pdf-close-btn,
  .pdf-controls {
    display: none !important;
  }

  .pdf-container {
    padding: 0;
  }

  #pdfFrame {
    box-shadow: none;
  }
}
.avatar-container, #camera-preview {
    width:200px;
    height:200px;
    border-radius:50%;
    overflow:hidden;
    margin:auto;
    background:#f4f4f4;
    display:flex;
    justify-content:center;
    align-items:center;
    border:2px solid #dee2e6;
}
.avatar-container img {
    width:100%;
    height:100%;
    object-fit:cover;
}
.btn-foto button {
    width:100%;
    margin-top:5px;
}
#listadosalunos_filter { display:none; }
.loading-spinner {
    display: none;
}
.loading .loading-spinner {
    display: inline-block;
}
.referencia-status {
    font-size: 0.875rem;
    margin-top: 0.25rem;
}
.referencia-status.valida {
    color: #28a745;
}
.referencia-status.invalida {
    color: #dc3545;
}
</style>

<div class="breadcrumb-modern animate-fadeInUp">
        <ol class="breadcrumb" style="background: transparent; margin: 0; padding: 0;">
            <li class="breadcrumb-item">
                <a href="#"><i class="fa fa-graduation-cap"></i> Registo Académico</a>
            </li>
            <li class="breadcrumb-item">
                <a href="#"><i class="fa fa-users"></i>Matricula</a>
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
                                    <?php $__currentLoopData = $alunos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $aluno): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr data-aluno-id="<?php echo e($aluno->id); ?>">
                                        <td><?php echo e($aluno->nome); ?></td>
                                        <td class="text-center">
                                            <button class="btn btn-primary btn-sm AtualizarMatricula"
                                                    data-id="<?php echo e($aluno->id); ?>"
                                                    title="Atualizar matrícula">
                                                <i class="fa fa-upload"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                
                <div class="col-md-8">
                    <div class="form-group">
                        <label>Selecione o ano lectivo</label>
                        <select class="form-control mb-2 anolectivo" id="anolectivo" name="anolectivo">
                            <?php $__currentLoopData = $anolectivo; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ano): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($ano->id); ?>"><?php echo e($ano->anolectivo); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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


<div class="modal fade" id="modalPagamentos" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirmação de Pagamento</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body corpoConteudo">
                <div class="text-center py-4">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Carregando...</span>
                    </div>
                    <p class="mt-2">Carregando informações de pagamento...</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary btn-matricula">
                    <i class="fas fa-check"></i> Confirmar Pagamento
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Popup para PDF -->
<div id="pdfPopup" class="pdf-popup">
  <div class="pdf-popup-content">
    <!-- Botão de fechar -->
    <button id="closeBtn" class="pdf-close-btn">
      <i class="fas fa-times"></i> Fechar
    </button>

    <!-- Botões de controle -->
    <div class="pdf-controls">
      <button id="printBtn" class="pdf-control-btn">
        <i class="fas fa-print"></i> Imprimir
      </button>
      <button id="downloadBtn" class="pdf-control-btn">
        <i class="fas fa-download"></i> Baixar
      </button>
    </div>

    <!-- Container do PDF -->
    <div class="pdf-container">
      <iframe id="pdfFrame" frameborder="0"></iframe>
    </div>

    <!-- Loading -->
    <div id="pdfLoading" class="pdf-loading">
      <div class="spinner-border text-primary" role="status">
        <span class="visually-hidden">Carregando PDF...</span>
      </div>
      <p>Carregando recibo...</p>
    </div>
  </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.26/webcam.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="<?php echo e(asset('MyJs/imprimirRecibo.js')); ?>"></script>

<script>
// Sistema de Atualização de Matrícula
let pagamentosFiltrados =[];
class SistemaAtualizacaoMatricula {
    constructor() {
        this.urls = {
            atualizarAluno: "/aluno/matricula/atualizar/",
            atualizarM: "/aluno/matricula/atualizarM/",
            selecionarValores: "/aluno/matricula/selecionar_tabelaValores/",
            validarReferencia: "/aluno/matricula/validarReferencia/",
            imprimirRecibo: "/aluno/matricula/imprimir/recibo/"
        };
        this.estado = {
            alunoSelecionado: null,
            cameraAtiva: false,
            dadosPagamento: null,
            tabelaValoresAno: <?php echo json_encode($tabelavaloresano, 15, 512) ?>
        };
        this.inicializar();
    }

    inicializar() {
        this.inicializarDataTable();
        this.configurarEventos();
        this.configurarCSRF();
    }

    configurarCSRF() {
        // Configurar CSRF globalmente para todas as requisições AJAX
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'X-Requested-With': 'XMLHttpRequest'
            }
        });
    }

    inicializarDataTable() {
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
    }

    configurarEventos() {
        $(document).on('click', '.AtualizarMatricula', (e) => this.carregarAluno(e));
        $(document).on('click', '.botaoAtualizacaoAlunoId', (e) => this.prepararAtualizacao(e));
        $(document).on('click', '.btn-matricula', (e) => this.confirmarPagamento(e));

        // Eventos da câmera
        $(document).on('click', '#startCamera', () => this.ativarCamera());
        $(document).on('click', '#stopCamera', () => this.desativarCamera());
        $(document).on('click', '#takeSnapshot', () => this.tirarFoto());
        $(document).on('change', '#fileexplorer', (e) => this.previewUpload(e));

        // Evento para mudança de classe
        $(document).on('change', '.select-class-ano', () => this.atualizarPagamentos());
    }

    async carregarAluno(event) {
        const botao = $(event.currentTarget);
        const alunoId = botao.data('id');

        try {
            botao.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i>');
            const response = await $.get(this.urls.atualizarAluno + alunoId);

            $('.ConteudoDeAtualizacao').html(response);
            this.estado.alunoSelecionado = alunoId;

            // Destacar linha selecionada
            $('#listadosalunos tr').removeClass('table-primary');
            botao.closest('tr').addClass('table-primary');

            // Atualizar pagamentos inicialmente
            this.atualizarPagamentos();

        } catch (error) {
            this.mostrarAlerta('Erro', 'Falha ao carregar dados do aluno', 'error');
            console.error('Erro:', error);
        } finally {
            botao.prop('disabled', false).html('<i class="fa fa-upload"></i>');
        }
    }

    atualizarPagamentos() {
        if (!this.estado.alunoSelecionado) return;

        const ano = $('#anolectivo').val();
        const classe = $('[name="ClassedeAtualizacao"]').val();

        if (!ano || !classe) return;

        this.atualizarPagamentosPorAno(ano, classe);
    }

    atualizarPagamentosPorAno(anoId, classeId) {
        const $lista = $('#listaPagamentosTab');
        if ($lista.length === 0) return;

        $lista.empty();

        const pagamentosFiltrados = this.estado.tabelaValoresAno.filter(item => {
            return item.idanolectivo == anoId && item.classId == classeId;
        });

        let html = '';

        pagamentosFiltrados.forEach(item => {
            if (item.id > 2) {
                const detalhes = typeof item.detalhes === "string"
                    ? JSON.parse(item.detalhes)
                    : item.detalhes;
                const numeroDetalhes = Array.isArray(detalhes) ? detalhes.length : 0;

                html += `
                    <li class="list-group-item d-flex justify-content-between align-items-center flex-column flex-md-row">
                        <div class="d-flex align-items-center mb-2 mb-md-0">
                            <input type="checkbox"
                                   checked
                                   class="checkbox-pagamento me-2 listapagamentos"
                                   value="${item.id}"
                                   name="listapagamentos[]"/>
                            <div>
                                <strong>${item.Finalidade}</strong><br/>
                                <small class="text-muted">Número de pagamentos: ${numeroDetalhes}</small>
                            </div>
                        </div>
                        <div>
                            <small class="text-primary">Valor: ${item.valorDescricao},00 MT</small>
                        </div>
                    </li>`;
            }
        });

        $lista.html(html);
    }

    prepararAtualizacao(event) {
        if (!this.estado.alunoSelecionado) {
            this.mostrarAlerta('Atenção', 'Selecione um aluno primeiro', 'warning');
            return;
        }

        const pagamentos = $('.listapagamentos:checked').map(function() {
            return $(this).val();
        }).get();

        if (pagamentos.length === 0 && pagamentosFiltrados.length>0) {
            this.mostrarAlerta('Atenção', 'Selecione pelo menos um tipo de pagamento', 'warning');
            return;
        }

        const ano = $('#anolectivo').val();
        const classe = $('[name="ClassedeAtualizacao"]').val();

        if (!classe) {
            this.mostrarAlerta('Atenção', 'Selecione uma classe', 'warning');
            return;
        }

        this.estado.dadosPagamento = { ano, classe, pagamentos };
        this.carregarModalPagamento(ano, classe, pagamentos);
    }

    async carregarModalPagamento(ano, classe, pagamentos) {
        try {

             $("#btnConfirmarPagamento").show();
                if($(".flagdeativaConformacao").val()==parseInt(0)){
  $("#btnConfirmarPagamento").hide();
                }
            $('#modalPagamentos').modal('show');
            const data = await $.get(
                `${this.urls.selecionarValores}${classe}/${ano}/2`,
                { pagamentos }
            );
            $('.corpoConteudo').html(data);
        } catch (error) {
            $('#modalPagamentos').modal('hide');
            this.mostrarAlerta('Erro', 'Falha ao carregar informações de pagamento', 'error');
        }
    }

    async confirmarPagamento(event) {
        const btn = $(event.currentTarget);
        const originalText = btn.html();

        btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Processando...');

        try {
            // 1. Validar referência se existir
            const referenciaValida = await this.validarReferenciaSeNecessario();
            if (referenciaValida === false) {
                btn.prop('disabled', false).html(originalText);
                return;
            }

            // 2. Preparar dados
            const alunoId = $('#idAlunos').val() || this.estado.alunoSelecionado;
            if (!alunoId) {
                throw new Error('ID do aluno não encontrado');
            }

            // 3. Criar FormData manualmente (evita problemas de CSRF)
            const formData = this.criarFormDataManual(alunoId);

            // 4. Debug: mostrar dados no console
            console.log('📦 Dados a enviar:');
            for (let [key, value] of formData.entries()) {
                if (key === '_token') {
                    console.log(`${key}: ${value.substring(0, 20)}...`);
                } else if (value instanceof File) {
                    console.log(`${key}: 📄 ${value.name} (${value.size} bytes)`);
                } else if (value instanceof Blob) {
                    console.log(`${key}: 🖼️ Blob (${value.size} bytes)`);
                } else {
                    console.log(`${key}: ${value}`);
                }
            }

            // 5. Enviar requisição
            const resposta = await $.ajax({
                url: `${this.urls.atualizarM}${alunoId}`,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json'
            });

            // 6. Processar resposta
            if (resposta.success || resposta.estado === "INS-0") {
                await this.processarSucesso(resposta);
            } else {
                throw new Error(resposta.messagem || 'Erro desconhecido do servidor');
            }

        } catch (error) {
            console.error('❌ Erro no envio:', error);

            let mensagemErro = error.message;
            if (error.responseJSON) {
                mensagemErro = error.responseJSON.message || JSON.stringify(error.responseJSON);
            }

            this.mostrarAlerta('Erro', mensagemErro, 'error');

            // Se for erro de CSRF, sugerir recarregar a página
            if (error.status === 419 || mensagemErro.includes('CSRF')) {
                Swal.fire({
                    title: 'Sessão Expirada',
                    text: 'Sua sessão expirou. Deseja recarregar a página?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Sim, recarregar',
                    cancelButtonText: 'Não'
                }).then((result) => {
                    if (result.isConfirmed) {
                        location.reload();
                    }
                });
            }
        } finally {
            btn.prop('disabled', false).html(originalText);
        }
    }

    // FUNÇÃO CORRIGIDA: Criar FormData manualmente
    criarFormDataManual(alunoId) {
        console.group('🛠️  CRIANDO FORMDATA MANUAL');

        const formData = new FormData();

        try {
            // ========== 1. CAMPOS OBRIGATÓRIOS ==========

            // A. ID do Aluno
            if (!alunoId) {
                alunoId = $('#idAlunos').val();
                if (!alunoId) {
                    throw new Error('ID do aluno não encontrado');
                }
            }
            formData.append('idAlunos', alunoId);
            console.log('✅ idAlunos:', alunoId);

            // B. Classe de Atualização
            const classe = $('[name="ClassedeAtualizacao"]').val();
            if (!classe) {
                throw new Error('Selecione uma classe');
            }
            formData.append('ClassedeAtualizacao', classe);
            console.log('✅ ClassedeAtualizacao:', classe);

            // C. Ano Lectivo
            const anoLectivo = $('#anolectivo').val();
            if (!anoLectivo) {
                throw new Error('Selecione um ano lectivo');
            }
            formData.append('anolectivo', anoLectivo);
            console.log('✅ anolectivo:', anoLectivo);

            // ========== 2. PAGAMENTOS SELECIONADOS ==========
            const pagamentosSelecionados = [];
            $('.listapagamentos:checked').each(function() {
                const valor = $(this).val();
                if (valor) {
                    pagamentosSelecionados.push(valor);
                    formData.append('listapagamentos[]', valor);
                }
            });

            // if (pagamentosSelecionados.length === 0) {
            //     throw new Error('Selecione pelo menos um tipo de pagamento');
            // }
            // console.log('✅ Pagamentos selecionados:', pagamentosSelecionados);

            // ========== 3. FOTO DO ALUNO ==========

            // A. Foto da câmera (base64)
            const fotoBase64 = $('.image-tag').val();
            if (fotoBase64 && fotoBase64.startsWith('data:image')) {
                console.log('📸 Processando foto da câmera...');

                // Converter base64 para blob
                const base64Data = fotoBase64.split(',')[1];
                const binaryString = atob(base64Data);
                const bytes = new Uint8Array(binaryString.length);

                for (let i = 0; i < binaryString.length; i++) {
                    bytes[i] = binaryString.charCodeAt(i);
                }

                const blob = new Blob([bytes], { type: 'image/jpeg' });
                formData.append('image', blob, `foto_camera_${alunoId}_${Date.now()}.jpg`);
                console.log('✅ Foto da câmera adicionada');
            }

            // B. Upload de arquivo
            const fileInput = document.getElementById('fileexplorer');
            if (fileInput && fileInput.files.length > 0) {
                const file = fileInput.files[0];
                formData.append('avatar-file', file);
                console.log('✅ Arquivo de foto adicionado:', file.name);
            }

            // ========== 4. DADOS DO MODAL DE PAGAMENTO ==========
            const modalForm = document.querySelector('#modalPagamentos form');
            if (modalForm) {
                console.log('💰 Processando dados do modal...');

                // Processar todos os campos do modal
                $(modalForm).find('input, select, textarea').each(function() {
                    const $this = $(this);
                    const nome = $this.attr('name');
                    const tipo = $this.attr('type');
                    const valor = $this.val();

                    if (!nome || nome === '_token' || nome === '_method') {
                        return; // Ignorar
                    }

                    // Tratar diferentes tipos de input
                    if (tipo === 'checkbox' || tipo === 'radio') {
                        if ($this.is(':checked')) {
                            formData.append(nome, valor || 'on');
                        }
                    } else if (tipo === 'file') {
                        // Arquivos já são tratados pelo FormData automaticamente
                        if ($this[0].files.length > 0) {
                            for (let i = 0; i < $this[0].files.length; i++) {
                                formData.append(nome, $this[0].files[i]);
                            }
                        }
                    } else {
                        if (valor !== undefined && valor !== '') {
                            formData.append(nome, valor);
                        }
                    }
                });

                console.log('✅ Dados do modal processados');
            }

            // ========== 5. TOKEN CSRF (CRÍTICO) ==========
            let csrfToken = $('meta[name="csrf-token"]').attr('content');

            // Tentar outras fontes se a meta tag não tiver token
            if (!csrfToken || csrfToken.length < 10) {
                csrfToken = $('input[name="_token"]').val();
            }

            if (!csrfToken || csrfToken.length < 10) {
                // Tentar obter do cookie
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
            console.log('✅ CSRF Token adicionado (primeiros 20 chars):', csrfToken.substring(0, 20) + '...');

            // ========== 6. MÉTODO HTTP ==========
            formData.append('_method', 'PUT');
            console.log('✅ Método HTTP: PUT');

            // ========== 7. DEMAIS CAMPOS DO FORMULÁRIO PRINCIPAL ==========
            const formPrincipal = document.getElementById('formAluno');
            if (formPrincipal) {
                const elementos = formPrincipal.elements;

                for (let i = 0; i < elementos.length; i++) {
                    const elemento = elementos[i];
                    const nome = elemento.name;
                    const tipo = elemento.type;

                    // Ignorar campos já processados
                    if (!nome ||
                        ['idAlunos', 'ClassedeAtualizacao', 'image', 'avatar-file', '_token', '_method'].includes(nome)) {
                        continue;
                    }

                    // Adicionar campos restantes
                    if (tipo === 'checkbox' || tipo === 'radio') {
                        if (elemento.checked) {
                            formData.append(nome, elemento.value || 'on');
                        }
                    } else if (tipo !== 'file' && elemento.value) {
                        formData.append(nome, elemento.value);
                    }
                }
            }

            console.log('✅ Formulário principal processado');

            // ========== 8. RESULTADO FINAL ==========
            console.groupEnd();
            return formData;

        } catch (error) {
            console.groupEnd();
            throw error;
        }
    }

    async processarSucesso(resposta) {
        const opcoes = {
            title: 'Sucesso!',
            text: resposta.message || 'Matrícula atualizada com sucesso!',
            icon: 'success'
        };

        // Se tiver dados para imprimir recibo
        if (resposta.estado === "INS-0" && resposta.meses && resposta.anolectivo && resposta.idaluno) {
            opcoes.showCancelButton = true;
            opcoes.confirmButtonText = 'Imprimir Recibo';
            opcoes.cancelButtonText = 'Fechar';
        }

        const resultado = await Swal.fire(opcoes);

        if (resultado.isConfirmed && resposta.estado === "INS-0") {
            // Preparar URL do recibo
            // const dados = resposta.meses.map(e => ({
            //     tipo: e.tipo,
            //     mes: e.mes
            // }));
            // const dadosEncoded = encodeURIComponent(JSON.stringify(dados));
            console.log(resposta.idaluno);
            const urlRecibo = `${this.urls.imprimirRecibo}${resposta.anolectivo}/${resposta.idaluno}/${resposta.talao}/${resposta.metodo}`;

            // Abrir recibo
            //  this.abrirReciboPDF(urlRecibo, resposta.idaluno);
            abrirReciboPDF(urlRecibo,resposta.idaluno)
        }

        // Limpar e recarregar
        // $('#modalPagamentos').modal('hide');
        // setTimeout(() => location.reload(), 1000);
    }

    abrirReciboPDFd(url, alunoId) {
        fetch(url, {
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(res => {
            if (!res.ok) throw new Error('Erro ao buscar o PDF');
            return res.blob();
        })
        .then(blob => {
            const pdfUrl = URL.createObjectURL(blob);
            const frame = document.getElementById('pdfFrame');
            const popup = document.getElementById('pdfPopup');

            frame.src = pdfUrl;
            popup.style.display = 'block';

            // Imprimir automaticamente
            frame.onload = () => {
                const iframeWindow = frame.contentWindow;
                iframeWindow.focus();
                iframeWindow.print();

                // Fechar popup após impressão
                iframeWindow.onafterprint = () => {
                    popup.style.display = 'none';
                    frame.src = '';
                    URL.revokeObjectURL(pdfUrl);
                };
            };
        })
        .catch(err => {
            console.error('Falha ao carregar o PDF:', err);
            this.mostrarAlerta('Erro', 'Não foi possível carregar o recibo', 'error');
        });
    }

    async validarReferenciaSeNecessario() {
        const campoReferencia = $("[name='Referencia']");
        if (campoReferencia.length === 0) return true;

        const referencia = campoReferencia.val().trim();

        if (!referencia) {
            this.mostrarAlerta('Erro', 'Digite a referência de pagamento', 'error');
            campoReferencia.addClass('is-invalid').focus();
            return false;
        }

        try {
            const response = await $.ajax({
                url: `${this.urls.validarReferencia}${referencia}`,
                type: "GET",
                dataType: 'json'
            });

            if (response.status === "invalido") {
                this.atualizarStatusReferencia('Referência inválida', false);
                this.mostrarAlerta('Referência Inválida', 'A referência informada é inválida', 'error');
                return false;
            }

            this.atualizarStatusReferencia('Referência válida', true);
            return true;

        } catch (error) {
            this.mostrarAlerta('Erro', 'Falha ao validar referência', 'error');
            return false;
        }
    }

    atualizarStatusReferencia(mensagem, valida) {
        let elementoStatus = $('#statusReferencia');

        if (elementoStatus.length === 0) {
            elementoStatus = $('<small>').attr('id', 'statusReferencia').addClass('referencia-status');
            $("[name='Referencia']").after(elementoStatus);
        }

        elementoStatus
            .removeClass(valida ? 'invalida' : 'valida')
            .addClass(valida ? 'valida' : 'invalida')
            .text(mensagem)
            .show();
    }

    // Funções da câmera
    ativarCamera() {
        if (this.estado.cameraAtiva) return;

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

        this.estado.cameraAtiva = true;
    }

    desativarCamera() {
        if (!this.estado.cameraAtiva) return;

        Webcam.reset();
        $('#camera-preview').hide();
        $('#avatar-container').show();
        $('#takeSnapshot, #stopCamera').hide();
        $('#startCamera, #fileexplorer').show();

        this.estado.cameraAtiva = false;
    }

    tirarFoto() {
        if (!this.estado.cameraAtiva) return;

        Webcam.snap((uri) => {
            $('.image-tag').val(uri);
            $('#avatar-container').html(`<img src="${uri}">`).show();
            this.desativarCamera();
        });
    }

    previewUpload(event) {
        const file = event.target.files[0];
        if (!file) return;

        const reader = new FileReader();
        reader.onload = (e) => {
            $('#avatar-container').html(`<img src="${e.target.result}">`);
        };
        reader.readAsDataURL(file);
    }

    mostrarAlerta(titulo, texto, tipo) {
        return Swal.fire({
            title: titulo,
            text: texto,
            icon: tipo,
            confirmButtonText: 'OK',
            confirmButtonColor: '#3085d6'
        });
    }
}

// Funções globais para o popup de PDF
function fecharPopupPDF() {
    const popup = document.getElementById('pdfPopup');
    const frame = document.getElementById('pdfFrame');

    popup.style.display = 'none';
    frame.src = '';
}

// Inicializar quando o DOM estiver pronto
$(document).ready(function() {
    window.sistemaMatricula = new SistemaAtualizacaoMatricula();
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin-Lti', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/sgemozco/escolasaojoaopauloii.sgemoz.com/resources/views/registoAcademico/Atualizar-matricula-index.blade.php ENDPATH**/ ?>