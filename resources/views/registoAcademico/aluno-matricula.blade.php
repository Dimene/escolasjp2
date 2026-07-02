@extends('layouts.admin-Lti')

@section('title', 'Cadastro de Aluno')
@section('content')

<head>
    <link rel="stylesheet" href="{{ asset('assets/css/styles.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.26/webcam.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
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
        /* FOTO FLUTUANTE */
        .foto-flutuante {
            position: sticky;
            top: 80px;
            z-index: 100;
        }

        /* AVATAR */
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

        .campo-erro {
            border: 2px solid #dc3545 !important;
            background-color: #fff3f3;
        }

        .campo-valido {
            border: 2px solid #28a745 !important;
        }

        .avatar-container img, #camera-preview video {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
        }

        /* BOTÃO UPLOAD */
        .custom-file-label {
            background-color: #f8f9fa;
            border: 1px solid #ced4da;
            color: #495057;
            cursor: pointer;
            text-align: center;
            transition: all 0.3s;
        }

        .custom-file-label:hover {
            background-color: #e9ecef;
        }

        /* BOTÕES DA CÂMERA */
        .btn-foto button {
            margin-top: 5px;
            width: 100%;
        }

        /* STATUS REFERÊNCIA */
        .status-referencia {
            font-size: 0.875rem;
            margin-top: 5px;
            display: none;
        }

        .status-referencia.valida {
            color: #28a745;
            display: block;
        }

        .status-referencia.invalida {
            color: #dc3545;
            display: block;
        }

        /* LOADING */
        .spinner-avatar {
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .imgprocessar {
            display: none;
        }

        .imgprocessar.ativo {
            display: inline-block;
        }

        /* PAGAMENTOS */
        .list-group-item:hover {
            background-color: #f8f9fa;
        }

        .checkbox-pagamento:checked + div strong {
            color: #28a745;
        }

        /* VALIDAÇÃO */
        .is-invalid {
            border-color: #dc3545 !important;
        }

        .is-valid {
            border-color: #28a745 !important;
        }

        /* MODAL FIX */
        .modal-body {
            max-height: 70vh;
            overflow-y: auto;
        }
    </style>
</head>
 <div class="breadcrumb-modern animate-fadeInUp">
        <ol class="breadcrumb" style="background: transparent; margin: 0; padding: 0;">
            <li class="breadcrumb-item">
                <a href="#"><i class="fa fa-graduation-cap"></i> Registo Académico</a>
            </li>
            <li class="breadcrumb-item">
                <a href="#"><i class="fa fa-users"></i>Matricula</a>
            </li>
            <li class="breadcrumb-item active">
                <i class="fa fa-edit"></i> <b>Matricula Externos</b>
            </li>
        </ol>
    </div>

<div class="">


    <form id="formAluno" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="container-fluid">
            <div class="row">
                {{-- FOTO FLUTUANTE --}}
                <div class="col-lg-4 foto-flutuante">
                    <div class="card mb-3">
                        <div class="card-body text-center">
                            {{-- Container para imagem final --}}
                            <div class="avatar-container" id="avatar-container">
                                <img src="{{ asset('storage/fotoAluno/avatar.png') }}" id="avatar-img" alt="Avatar do Aluno">
                            </div>

                            {{-- Container para câmera --}}
                            <div id="camera-preview" style="display:none;"></div>

                            <input type="hidden" name="image" class="image-tag">

                            {{-- BOTÃO UPLOAD --}}
                            <div class="custom-file mt-2">
                                <input type="file" class="custom-file-input" id="fileexplorer" name="avatar_file" accept="image/*">
                                <label class="custom-file-label" for="fileexplorer" id="fileexplorer-label">
                                    <i class="fas fa-upload"></i> Escolher Foto
                                </label>
                            </div>

                            <div class="btn-foto mt-3">
                                <button type="button" id="startCamera" class="btn btn-dark">
                                    <i class="fas fa-video"></i> Abrir Câmara
                                </button>

                                <button type="button" id="stopCamera" class="btn btn-danger" style="display:none">
                                    <i class="fas fa-stop"></i> Parar Câmara
                                </button>

                                <button type="button" id="takeSnapshot" class="btn btn-secondary" style="display:none">
                                    <i class="fas fa-camera"></i> Tirar Foto
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- CONTEÚDO --}}
                <div class="col-lg-8">
                    {{-- ABAS --}}
                    <ul class="nav nav-tabs" id="alunoTabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#dados" role="tab">
                                <i class="fas fa-user"></i> Dados do Aluno
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#endereco" role="tab">
                                <i class="fas fa-home"></i> Endereço
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#naturalidade" role="tab">
                                <i class="fas fa-globe"></i> Naturalidade
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#saude" role="tab">
                                <i class="fas fa-heartbeat"></i> Saúde
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#filiacao" role="tab">
                                <i class="fas fa-users"></i> Filiação
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#encarregado" role="tab">
                                <i class="fas fa-user-tie"></i> Encarregado
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#pagamentos" role="tab">
                                <i class="fas fa-credit-card"></i> Pagamentos
                            </a>
                        </li>
                    </ul>

                    <div class="tab-content mt-3">
                        {{-- DADOS DO ALUNO --}}
                        <div class="tab-pane fade show active" id="dados" role="tabpanel">
                            <div class="card">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label><strong>Ano Lectivo *</strong></label>
                                        <select class="form-control select-class-ano" name="ano_lectivo" required>
                                            @foreach($anolelctivo as $a)
                                            <option value="{{ $a->id }}">{{ $a->anolectivo }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label><strong>Classe *</strong></label>
                                        <select class="form-control select-class-ano" name="classe" required>
                                            @foreach($classes as $c)
                                            <option value="{{ $c->id }}">{{ $c->Descricao }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label><strong>Nome do Aluno *</strong></label>
                                        <input class="form-control" name="nome_aluno" required placeholder="Digite o nome completo">
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label><strong>Data de Nascimento *</strong></label>
                                                <input type="date" class="form-control" name="data_nascimento" required>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label><strong>Sexo *</strong></label>
                                                <select class="form-control" name="sexo_aluno" required>
                                                    <option value="M">Masculino</option>
                                                    <option value="F">Feminino</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label><strong>Religião *</strong></label>
                                                <select class="form-control" name="religiao" required>
                                                    @foreach($religiao as $religiaoitem)
                                                    <option value="{{ $religiaoitem->id }}">{{ $religiaoitem->nome }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- ENDEREÇO --}}
                        <div class="tab-pane fade" id="endereco" role="tabpanel">
                            <div class="card">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label><strong>Bairro</strong></label>
                                        <input class="form-control" name="bairro" placeholder="Nome do bairro">
                                    </div>
                                    <div class="form-group">
                                        <label><strong>Rua / Avenida</strong></label>
                                        <input class="form-control" name="rua_avenida" placeholder="Nome da rua ou avenida">
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label><strong>Quarteirão</strong></label>
                                                <input class="form-control" name="quarteirao" placeholder="Número do quarteirão">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label><strong>Casa Nº</strong></label>
                                                <input class="form-control" name="casa_numero" placeholder="Número da casa">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- NATURALIDADE --}}
                        <div class="tab-pane fade" id="naturalidade" role="tabpanel">
                            <div class="card">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label><strong>Natural de</strong></label>
                                        <input class="form-control" name="naturalidade" placeholder="Cidade de nascimento">
                                    </div>
                                    <div class="form-group">
                                        <label><strong>Província</strong></label>
                                        <input class="form-control" name="provincia" placeholder="Província de nascimento">
                                    </div>
                                    <div class="form-group">
                                        <label><strong>País</strong></label>
                                        <input class="form-control" name="pais" value="Moçambique" list="listaNacionalidades">
                                        <datalist id="listaNacionalidades">
                                            <option value="Moçambique">
                                            <option value="Angola">
                                            <option value="Portugal">
                                            <option value="Brasil">
                                        </datalist>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- SAÚDE --}}
                        <div class="tab-pane fade" id="saude" role="tabpanel">
                            <div class="card">
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label class="form-label"><strong>Estado de Saúde</strong></label><br>
                                        <div class="btn-group" role="group">
                                            <input type="radio" class="btn-check" name="estado_saude" id="saudeNao" value="nao" autocomplete="off" checked>
                                            <label class="btn btn-outline-success" for="saudeNao">
                                                <i class="fas fa-check-circle"></i> Sem Doença
                                            </label>

                                            <input type="radio" class="btn-check" name="estado_saude" id="saudeSim" value="sim" autocomplete="off">
                                            <label class="btn btn-outline-danger" for="saudeSim">
                                                <i class="fas fa-exclamation-circle"></i> Com Doença
                                            </label>
                                        </div>
                                    </div>

                                    <div id="campoDoencas" style="display:none">
                                        <label><strong>Doenças</strong></label>
                                        <div id="listaDoencas">
                                            <div class="input-group mb-2">
                                                <input type="text" class="form-control" name="doencas[]" placeholder="Nome da doença">
                                                <div class="input-group-append">
                                                    <button type="button" class="btn btn-danger remove-doenca">
                                                        <i class="fas fa-minus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-success mt-2" id="addDoenca">
                                            <i class="fas fa-plus"></i> Adicionar Doença
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- FILIAÇÃO --}}
                        <div class="tab-pane fade" id="filiacao" role="tabpanel">
                            <div class="card">
                                <div class="card-body">
                                    <h6 class="text-muted mb-3">Dados do Pai</h6>
                                    <div class="form-group">
                                        <label><strong>Nome do Pai</strong></label>
                                        <input class="form-control" name="nome_pai" placeholder="Nome completo do pai">
                                    </div>
                                    <div class="form-group">
                                        <label><strong>Profissão do pai</strong></label>
                                        <input class="form-control" name="profissao_pai" list="listaProfissoes" autocomplete="on" placeholder="Profissão do pai">
                                    </div>

                                    <hr class="my-4">

                                    <h6 class="text-muted mb-3">Dados da Mãe</h6>
                                    <div class="form-group">
                                        <label><strong>Nome da Mãe</strong></label>
                                        <input class="form-control" name="nome_mae" placeholder="Nome completo da mãe">
                                    </div>
                                    <div class="form-group">
                                        <label><strong>Profissão da mãe</strong></label>
                                        <input class="form-control" name="profissao_mae" list="listaProfissoes" autocomplete="on" placeholder="Profissão da mãe">
                                    </div>

                                    <datalist id="listaProfissoes">
                                        @foreach($profissao as $profissaoItem)
                                        <option value="{{ $profissaoItem->Descricao }}">
                                        @endforeach
                                    </datalist>
                                </div>
                            </div>
                        </div>

                        {{-- ENCARREGADO DE EDUCAÇÃO --}}
                        <div class="tab-pane fade" id="encarregado" role="tabpanel">
                            <div class="card">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label><strong>Nome do Encarregado</strong></label>
                                        <input class="form-control" name="nome_encarregado" placeholder="Nome completo do encarregado">
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label><strong>Sexo</strong></label>
                                                <select class="form-control" name="sexo_encarregado">
                                                    <option value="M">Masculino</option>
                                                    <option value="F">Feminino</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label><strong>Grau de Parentesco</strong></label>
                                                <select class="form-control" name="grau_parentesco">
                                                    <option value="">-- Selecione --</option>
                                                    @foreach($grauparentesco as $g)
                                                    <option value="{{ $g->id }}">{{ $g->Descricao }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label><strong>Profissão</strong></label>
                                        <input class="form-control" name="profissao_encarregado" list="listaProfissoes" autocomplete="on" placeholder="Profissão do encarregado">
                                    </div>

                                    <div class="form-group">
                                        <label><strong>Contactos</strong></label>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <input class="form-control mb-2" name="contacto[]" placeholder="Contacto 1" type="tel">
                                            </div>
                                            <div class="col-md-4">
                                                <input class="form-control mb-2" name="contacto[]" placeholder="Contacto 2" type="tel">
                                            </div>
                                            <div class="col-md-4">
                                                <input class="form-control mb-2" name="contacto[]" placeholder="Contacto 3" type="tel">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- PAGAMENTOS --}}
                        <div class="tab-pane fade" id="pagamentos" role="tabpanel">
                            <div class="card">
                                <div class="card-body">
                                    <h5>Tipos de Pagamento</h5>
                                    <p class="text-muted">Selecione os tipos de pagamento para este aluno</p>

                                    <ul class="list-group" id="listaPagamentosTab">
                                        <!-- Dinamicamente carregado -->
                                    </ul>

                                    <div class="alert alert-info mt-3">
                                        <i class="fas fa-info-circle"></i> Os pagamentos serão configurados após a matrícula.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- BOTÃO MATRICULAR --}}
                    <div class="text-right my-3">
                        <button type="button" class="btn btn-secondary mr-2" id="btnLimpar">
                            <i class="fas fa-eraser"></i> Limpar
                        </button>
                        <button type="button" class="btn btn-primary" id="btnMatricular">
                            <i class="fas fa-user-plus"></i> Matricular Aluno
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

{{-- MODAL DE PAGAMENTOS --}}
<div class="modal fade" id="modalPagamentos" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Configurar Pagamentos</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="corpoConteudo"></div>

                <!-- Loading -->
                <div class="text-center">
                    <img src="{{ asset('imageproceaament/loading.gif') }}" class="imgprocessar" style="width:100px; height:100px;">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>

                <button type="button" class="btn btn-primary" id="btnConfirmarPagamento">
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
<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('assets/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('Admin-LTE/plugins/sweetalert2/sweetalert2.js') }}"></script>
<script src="{{ asset('MyJs/imprimirRecibo.js') }}"></script>




<script>
    let pagamentosFiltrados=[];
$(document).ready(function() {
    // ============ VARIÁVEIS GLOBAIS ============
    const URLS = {
        store: '{{ route("aluno.store") }}',
        matriculaStore: "/aluno/matricula/store",
        selecionarValores: "/aluno/matricula/selecionar_tabelaValores/",
        imprimirRecibo: "/aluno/matricula/imprimir/recibo/",
        validarReferencia: "/aluno/matricula/validarReferencia/",    };

    const tabelaValoresAno = @json($tabelavaloresano);
    const CSRF_TOKEN = '{{ csrf_token() }}';
    let statusValidacaoReferencia = "";
    let processandoPagamento = false;

    // ============ INICIALIZAÇÃO ============
    function inicializar() {
        const anoId = $("[name='ano_lectivo']").val();
        const classeId = $("[name='classe']").val();
        atualizarPagamentosPorAno(anoId, classeId);
    }

    // ============ FUNÇÕES DE FOTO ============
    $('#fileexplorer').on('change', function() {
        const file = this.files[0];
        if (file) {
            if (file.size > 5 * 1024 * 1024) { // 5MB
                mostrarAlerta('Erro', 'A imagem não pode exceder 5MB', 'error');
                $(this).val('');
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                $('#avatar-img').attr('src', e.target.result);
                $('.image-tag').val('');
            };
            reader.readAsDataURL(file);
            $('#fileexplorer-label').html(`<i class="fas fa-check"></i> ${file.name}`);
        }
    });

    $('#startCamera').click(function() {
        $('#camera-preview').show();
        $('#avatar-container').hide();

        Webcam.set({
            width: 200,
            height: 200,
            image_format: 'jpeg',
            jpeg_quality: 90
        });

        Webcam.attach('#camera-preview');
        $('#stopCamera, #takeSnapshot').show();
        $('#startCamera, #fileexplorer').hide();
    });

    $('#stopCamera').click(function() {
        Webcam.reset();
        $('#camera-preview').hide();
        $('#avatar-container').show();
        $('#stopCamera, #takeSnapshot').hide();
        $('#startCamera, #fileexplorer').show();
    });

    $('#takeSnapshot').click(function() {
        Webcam.snap(function(uri) {
            $('.image-tag').val(uri);
            $('#avatar-img').attr('src', uri);
            $('#camera-preview').hide();
            $('#avatar-container').show();
            Webcam.reset();
            $('#stopCamera, #takeSnapshot').hide();
            $('#startCamera, #fileexplorer').show();
            $('#fileexplorer').val('');
            $('#fileexplorer-label').html('<i class="fas fa-upload"></i> Escolher Foto');
        });
    });

    // ============ FUNÇÕES DE SAÚDE ============
    $('input[name="estado_saude"]').on('change', function() {
        if ($(this).val() === 'sim') {
            $('#campoDoencas').slideDown();
        } else {
            $('#campoDoencas').slideUp();
            $('#listaDoencas input').val('');
        }
    });

    $('#addDoenca').click(function() {
        $('#listaDoencas').append(`
            <div class="input-group mb-2">
                <input type="text" class="form-control" name="doencas[]" placeholder="Nome da doença">
                <div class="input-group-append">
                    <button type="button" class="btn btn-danger remove-doenca">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
        `);
    });

    $(document).on('click', '.remove-doenca', function() {
        $(this).closest('.input-group').remove();
    });

    // ============ VALIDAÇÃO DE FORMULÁRIO ============
    function validarCampos() {
        let valido = true;
        const camposInvalidos = [];

        $('input[required], select[required]').each(function() {


             const $campo = $(this);
        const idCampo = $campo.attr('name');

        // ⭐ EXCLUIR CAMPO REFERÊNCIA ⭐
        if (idCampo === 'Referencia') {
            return true; // Pula para o próximo campo (continue)
        }
            if (!$campo .val().trim()) {
                $(this).addClass('is-invalid').removeClass('is-valid');
                camposInvalidos.push($campo .attr('name'));
                valido = false;
            } else {
                $campo .removeClass('is-invalid').addClass('is-valid');
            }
        });

        // Validação de data de nascimento
        const dataNascimento = $('[name="data_nascimento"]').val();
        if (dataNascimento) {
            const nascimento = new Date(dataNascimento);
            const hoje = new Date();
            const idade = hoje.getFullYear() - nascimento.getFullYear();

            if (idade < 3 || idade > 25) {
                $('[name="data_nascimento"]').addClass('is-invalid');
                camposInvalidos.push('data_nascimento (idade inválida)');
                valido = false;
            }
        }

        if (!valido) {
            const mensagem = `Preencha os seguintes campos obrigatórios:\n${camposInvalidos.join('\n')}`;
            mostrarAlerta('Campos obrigatórios', mensagem, 'warning');

            // Vai para a primeira aba com erro
            const primeiroErro = $('.is-invalid').first();
            if (primeiroErro.length) {
                const abaPai = primeiroErro.closest('.tab-pane');
                if (abaPai.length) {
                    const abaId = abaPai.attr('id');
                    $(`a[href="#${abaId}"]`).tab('show');
                    primeiroErro.focus();
                }
            }
        }

        return valido;
    }

    // ============ FUNÇÕES DE PAGAMENTO ============
    function atualizarPagamentosPorAno(anoId, classeId) {
        $('#listaPagamentosTab').empty();

        const pagamentosFiltrados = tabelaValoresAno.filter(function(item) {
            return item.idanolectivo == anoId && item.classId == classeId;
        });

        let htmlDados = "";

        pagamentosFiltrados.forEach(function(item) {
            if (item.id > 2) {
                const detalhes = typeof item.detalhes === "string" ? JSON.parse(item.detalhes) : item.detalhes;
                const numeroDetalhes = Array.isArray(detalhes) ? detalhes.length : 0;

                htmlDados += `
                    <li class="list-group-item">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input checkbox-pagamento"
                                   id="pagamento-${item.id}" value="${item.id}" checked>
                            <label class="custom-control-label d-flex justify-content-between w-100" for="pagamento-${item.id}">
                                <div>
                                    <strong>${item.Finalidade}</strong><br>
                                    <small class="text-muted">${numeroDetalhes} parcela(s)</small>
                                </div>
                                <div>
                                    <span class="badge badge-primary">${item.valorDescricao},00 MT</span>
                                </div>
                            </label>
                        </div>
                    </li>`;
            }
        });

        if (htmlDados === "") {
            htmlDados = `
                <li class="list-group-item text-center text-muted">
                    <i class="fas fa-info-circle fa-2x mb-2"></i><br>
                    Nenhum pagamento configurado para esta classe/ano
                </li>`;
        }

        $('#listaPagamentosTab').html(htmlDados);
    }

    function obterPagamentosSelecionados() {
        const pagamentos = [];
        $('.checkbox-pagamento:checked').each(function() {
            pagamentos.push($(this).val());
        });
        return pagamentos;
    }

    function carregarModalPagamentos(pagamentos, classeId, anoId,tipoId) {


        if (processandoPagamento) return;

        processandoPagamento = true;
        $('.imgprocessar').addClass('ativo');


        $.ajax({
            url: `${URLS.selecionarValores}${classeId}/${anoId}/${tipoId}`,
            type: "GET",
            data: { pagamentos: pagamentos },
            success: function(data) {
                $('.corpoConteudo').html(data);
                 $("#btnConfirmarPagamento").show();
                if($(".flagdeativaConformacao").val()==parseInt(0)){
  $("#btnConfirmarPagamento").hide();
                }

                $('#modalPagamentos').modal('show');
                // console.log($(".flagdeativaConformacao").val(), "flagdkdkdkdkd");
            },
            error: function() {
                mostrarAlerta('Erro', 'Não foi possível carregar os pagamentos', 'error');
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
              //  $('#btnConfirmarPagamento').

                return;
            }

           // const url = URLS.validarReferencia.replace(':referencia', encodeURIComponent(referencia));
         const  url= `${URLS.validarReferencia}${referencia}`

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

    // ============ ENVIO DO FORMULÁRIO ============
    async function enviarFormulario() {
        // Validação inicial
        if (!validarCampos()) {
            return false;
        }

        // Obter dados
        const anoId = $("[name='ano_lectivo']").val();
        const classeId = $("[name='classe']").val();
        const pagamentos = obterPagamentosSelecionados();

        if (pagamentos.length === 0&&pagamentosFiltrados.length>0) {
            mostrarAlerta('Atenção', 'Selecione pelo menos um tipo de pagamento', 'warning');
            return false;
        }

        // Carregar modal de pagamentos
        carregarModalPagamentos(pagamentos, classeId, anoId,1);
        return false;
    }

    // ============ EVENT LISTENERS ============
    $(document).on("change", ".select-class-ano", function() {
        const anoId = $("[name='ano_lectivo']").val();
        const classeId = $("[name='classe']").val();
        atualizarPagamentosPorAno(anoId, classeId);
    });

    $('#btnLimpar').click(function() {
        Swal.fire({
            title: 'Limpar formulário?',
            text: "Todos os dados serão perdidos!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sim, limpar!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $('#formAluno')[0].reset();
                $('#avatar-img').attr('src', '{{ asset("storage/fotoAluno/avatar.png") }}');
                $('.image-tag').val('');
                $('#fileexplorer-label').html('<i class="fas fa-upload"></i> Escolher Foto');
                $('.is-invalid, .is-valid').removeClass('is-invalid is-valid');
                inicializar();
                mostrarAlerta('Sucesso', 'Formulário limpo com sucesso', 'success');
            }
        });
    });

    $('#formAluno').on('submit', function(e) {
        e.preventDefault();
        enviarFormulario();
    });

    $('#btnMatricular').click(function() {
        // $('#formAluno').submit();
        enviarFormulario();
    });

    $(document).on('click', '#btnConfirmarPagamento', async function() {
        const btn = $(this);
        const originalText = btn.html();

        try {
            btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Processando...');

            // Validar referência se existir
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
                    $('#statusReferencia')
                        .removeClass('valida')
                        .addClass('invalida')
                        .text(validacao.mensagem)
                        .show();
                    mostrarAlerta('Referência Inválida', validacao.mensagem, 'error');
                    btn.prop('disabled', false).html(originalText);
                    return;
                }

                $('#statusReferencia')
                    .removeClass('invalida')
                    .addClass('valida')
                    .text(validacao.mensagem)
                    .show();
            }

            // Preparar dados do formulário
            const formData = new FormData($('#formAluno')[0]);

            // Adicionar dados do modal de pagamento
            $('#modalPagamentos form').serializeArray().forEach(function(field) {
                if (field.name !== "_token") {
                    formData.append(field.name, field.value);
                }
            });

            // Enviar para o servidor
            $.ajax({
                url: URLS.store,
                method: "POST",
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': CSRF_TOKEN
                },
                beforeSend: function() {
                   // $('.imgprocessar').addClass('ativo');
                },
                success: function(response) {
                    if (response.estado === "INS-0") {
                        Swal.fire({
                            title: 'Sucesso!',
                            text: 'Aluno matriculado com sucesso!',
                            icon: 'success',
                            showCancelButton: true,
                            confirmButtonText: 'Ver Recibo',
                            cancelButtonText: 'Fechar'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // Imprimir recibo
                                // const dados = response.meses.map(e => ({
                                //     tipo: e.tipo,
                                //     mes: e.mes
                                // }));
 // const dadosEncoded = encodeURIComponent(JSON.stringify(dados));
const urlRecibo =`${URLS.imprimirRecibo}${response.anolectivo}/${response.idaluno}/${response.talao}/${response.metodo}`
                               // window.open(urlRecibo, '_blank');
abrirReciboPDF(urlRecibo,response.idaluno)



                            }

                            // Limpar formulário
                            $('#formAluno')[0].reset();
                            $('#modalPagamentos').modal('hide');
                            inicializar();
                        });
                    }
                     else {
                        mostrarAlerta('Erro', response.messagem , 'error');
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
                }
            });

        } catch (error) {
            console.error('Erro:', error);
            mostrarAlerta('Erro', 'Ocorreu um erro inesperado', 'error');
            btn.prop('disabled', false).html(originalText);
        }
    });

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

    // Auto-validação em tempo real
    $('input[required], select[required]').on('input change', function() {
        if ($(this).val().trim()) {
            $(this).removeClass('is-invalid').addClass('is-valid');
        } else {
            $(this).removeClass('is-valid');
        }
    });

    // Inicializar
    inicializar();
});




           // Abre o PDF no pop
</script>
@endsection
