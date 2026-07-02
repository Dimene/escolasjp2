@extends('layouts.admin-Lti')

@section('title', 'Cadastro de Aluno')
@section('content')


@php
$request =Request();
    $host = $request->getHost();

    $subdomain = explode('.', $host)[0];

@endphp

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

{{-- {{ dd($dados) }} --}}



     <div class="breadcrumb-modern animate-fadeInUp">
        <ol class="breadcrumb" style="background: transparent; margin: 0; padding: 0;">
            <li class="breadcrumb-item">
                <a href="#"><i class="fa fa-graduation-cap"></i> Registo Académico</a>
            </li>
            <li class="breadcrumb-item">
                <a href="#"><i class="fa fa-users"></i>Matricula</a>
            </li>
            <li class="breadcrumb-item active">
                <i class="fa fa-edit"></i> <b>Atualizar Dados</b>
            </li>
        </ol>
    </div>
    <div>

   <form id="formAluno"
      method="POST"
      enctype="multipart/form-data"

      action="{{ route('aluno.update', $dados->idAlunoclasse) }}">
    @csrf
    @method('PUT')
        <div class="container-fluid">
            <div class="row">
                {{-- FOTO FLUTUANTE --}}
                  {{-- FOTO FLUTUANTE --}}
                <div class="col-lg-4 foto-flutuante">
                    <div class="card mb-3">
                        <div class="card-body text-center">
                            {{-- Container para imagem final --}}
                            <div class="avatar-container" id="avatar-container">
                                <img @if($dados->avatar)
                                     src="{{ asset('storage/' . $subdomain . '/fotoAluno/' . $dados->avatar) }}"
                                     @else
                                     src="{{ asset('storage/fotoAluno/avatar.png') }}"
                                     @endif
                                     id="avatar-img"
                                     alt="Avatar do Aluno"
                                     class="img-fluid">
                            </div>

                            {{-- Container para câmera --}}
                            <div id="camera-preview" style="display:none;"></div>

                            {{-- Campo para imagem base64 da câmera --}}
                            <input type="hidden" name="image" class="image-tag" id="image-tag">

                            {{-- BOTÃO UPLOAD - CORRIGIDO: name="avatar-file" --}}
                            <div class="custom-file mt-2">
                                <input type="file"
                                       class="custom-file-input"
                                       id="fileexplorer"
                                       name="avatar-file"  {{-- CORRIGIDO: era 'avatar_file' --}}
                                       accept="image/*">
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

                            {{-- Indicador de status da foto --}}
                            <div id="fotoStatus" class="mt-2 small text-muted"></div>
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

                    {{-- {{ dd($anolectivo,$ano) }} --}}
                    <div class="tab-content mt-3">
                        {{-- DADOS DO ALUNO --}}
                        <div class="tab-pane fade show active" id="dados" role="tabpanel">
                            <div class="card">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label><strong>Ano Lectivo *</strong></label>
                                        <select class="form-control select-class-ano" name="ano_lectivo" required>
                                            @foreach($anolectivo as $a)
                                            <option value="{{ $a->id }}" @if($ano == $a->id) selected @endif>
    {{ $a->anolectivo }}
</option>
                                           @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label><strong>Classe *</strong></label>
                                        <select class="form-control select-class-ano" name="classe" required>
                                            @foreach($classes as $c)
                                            <option value="{{ $c->id }}"

                                                @if($dados->Classe_id==$c->id)
                                                selected

                                                @endif
                                                >{{ $c->Descricao }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label><strong>Nome do Aluno *</strong></label>
                                        <input class="form-control" name="nome_aluno"
                                        value="{{$dados->nome }}"

                                        required placeholder="Digite o nome completo">
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label><strong>Data de Nascimento *</strong></label>
                                                <input type="date" class="form-control" name="data_nascimento" required
                                                value="{{ $dados->dataNascimento }}">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label><strong>Sexo *</strong></label>
                                                <select class="form-control" name="sexo_aluno" required>
                                                    <option value="M"  @if ($dados->sexo=="M")
                                                        selected

                                                    @endif>Masculino</option>
                                                    <option value="F"
                                                      @if ($dados->sexo=="F")
                                                        selected

                                                    @endif>Feminino</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label><strong>Religião *</strong></label>
                                                <select class="form-control" name="religiao" required>
                                                    @foreach($religiao as $religiaoitem)
                                                    <option value="{{ $religiaoitem->id }}"

                                                          @if ($dados->Religiao_id==$religiaoitem->id)
                                                        selected

                                                    @endif>
                                                        {{ $religiaoitem->nome }}</option>
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
                                        <input class="form-control" name="bairro"
                                        value="{{ $dados->Bairro  }}"
                                         placeholder="Nome do bairro">
                                    </div>
                                    <div class="form-group">
                                        <label><strong>Rua / Avenida</strong></label>
                                        <input class="form-control" name="rua_avenida"
                                        value="{{ $dados->RuaAvenida }}" placeholder="Nome da rua ou avenida">
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label><strong>Quarteirão</strong></label>
                                                <input class="form-control" name="quarteirao" value="{{ $dados->Quarterao }}" placeholder="Número do quarteirão">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label><strong>Casa Nº</strong></label>
                                                <input class="form-control" name="casa_numero"
                                                value="{{ $dados->Casa }}"
                                                 placeholder="Número da casa">
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
                                        <input class="form-control" name="naturalidade"
                                        value="{{ $dados->distrito }}"
                                         placeholder="Cidade de nascimento">
                                    </div>
                                    <div class="form-group">
                                        <label><strong>Província</strong></label>
                                        <input class="form-control" name="provincia"
                                        value="{{$dados->provincia }}"
                                         placeholder="Província de nascimento">
                                    </div>
                                    <div class="form-group">
                                        <label><strong>País</strong></label>
                                        <input class="form-control" name="pais" value="{{ $dados->pais }}" list="listaNacionalidades">
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
                                            <input type="radio" class="btn-check" name="estado_saude" id="saudeNao" value="nao" autocomplete="off"   @if(empty($dados->doenca_id)) checked @endif>
                                            <label class="btn btn-outline-success" for="saudeNao">
                                                <i class="fas fa-check-circle"></i> Sem Doença
                                            </label>

                                            <input type="radio" class="btn-check" name="estado_saude" id="saudeSim" value="sim" autocomplete="off"
                                             @if(!empty($dados->doenca_id)) checked @endif>
                                            <label class="btn btn-outline-danger" for="saudeSim">
                                                <i class="fas fa-exclamation-circle"></i> Com Doença
                                            </label>
                                        </div>
                                    </div>

                                    <div id="campoDoencas"  @if(empty($dados->doenca_id)) style="display:none" @endif>
                                        <label><strong>Doenças</strong></label>
                                        <div id="listaDoencas">
                         @if(!empty($dados->doenca_id))
    @php
        $doencas = json_decode($dados->doenca_id, true);

        // Se não for array, transforma em array
        if (!is_array($doencas)) {
            $doencas = [$doencas];
        }
    @endphp

    @foreach ($doencas as $doencaItem)
        <div class="input-group mb-2">
            <input type="text" class="form-control" name="doencas[]"
                   value="{{ optional($doenca->where('id', $doencaItem)->first())->nome }}"
                   placeholder="Nome da doença">
            <div class="input-group-append">
                <button type="button" class="btn btn-danger remove-doenca">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
    @endforeach
@endif
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
                                        <input class="form-control" name="nome_pai" placeholder="Nome completo do pai" value="{{$dados->nome_pai }}">
                                    </div>
                                    <div class="form-group">
                                        <label><strong>Profissão do pai</strong></label>
                                        <input class="form-control" name="profissao_pai" list="listaProfissoes" autocomplete="on" placeholder="Profissão do pai"
                                        value="{{ $dados->pai_Profissao }}">
                                    </div>

                                    <hr class="my-4">

                                    <h6 class="text-muted mb-3">Dados da Mãe</h6>
                                    <div class="form-group">
                                        <label><strong>Nome da Mãe</strong></label>
                                        <input class="form-control" name="nome_mae"   value="{{ $dados->nome_mae }}" placeholder="Nome completo da mãe">
                                    </div>
                                    <div class="form-group">
                                        <label><strong>Profissão da mãe</strong></label>
                                        <input class="form-control" name="profissao_mae" list="listaProfissoes" value="{{ $dados->mae_profisao }}" autocomplete="on" placeholder="Profissão da mãe">
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
                                        <input class="form-control" name="nome_encarregado" value="{{ $dados->Encaregado }}" placeholder="Nome completo do encarregado">
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label><strong>Sexo</strong></label>
                                                <select class="form-control" name="sexo_encarregado">
                                                    <option value="M" @if($dados->sexoEncaregado=="M") checked  @endif>Masculino</option>
                                                    <option value="F" @if($dados->sexoEncaregado=="F") checked  @endif>Feminino</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label><strong>Grau de Parentesco</strong></label>
                                                <select class="form-control" name="grau_parentesco">
                                                    <option value="">-- Selecione --</option>
                                                    @foreach($grauparentesco as $g)
                                                    <option value="{{ $g->id }}" @if($g->id==$dados->grauParentesto_id)  selected @endif>{{ $g->Descricao }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label><strong>Profissão</strong></label>
                                        <input class="form-control" name="profissao_encarregado"  value="{{ $dados->profissaoEncaregado }}"
                                        list="listaProfissoes" autocomplete="on" placeholder="Profissão do encarregado">
                                    </div>

                                    <div class="form-group">
                                        <label><strong>Contactos</strong></label>
                                        <div class="row">

                                            @php
                                              $contacto= $contactos->where("encaregado_id",$dados->Encaregado_id) ;
                                            @endphp


                                            <div class="col-md-4">
                                               <input
    class="form-control mb-2"
    name="contacto[]"
    placeholder="Contacto 1"
    value="{{ optional($contacto[0] ?? null)->Descricao }}"
    type="tel">
                                            </div>
                                            <div class="col-md-4">
                                               <input
    class="form-control mb-2"
    name="contacto[]"
    placeholder="Contacto 1"
    value="{{ optional($contacto[1] ?? null)->Descricao }}"
    type="tel">
                                            </div>   <div class="col-md-4">
                                               <input
    class="form-control mb-2"
    name="contacto[]"
    placeholder="Contacto 1"
    value="{{ optional($contacto[2] ?? null)->Descricao }}"
    type="tel">
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
                        {{-- <button type="button" class="btn btn-secondary mr-2" id="btnLimpar">
                            <i class="fas fa-eraser"></i> Limpar
                        </button> --}}
                        <button type="submit" class="btn btn-primary" id="btnatualizardados">
                            <i class="fas fa-user-plus"></i> Matricular Aluno
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('assets/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('Admin-LTE/plugins/sweetalert2/sweetalert2@11.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    tipoPagamento=@json($tipoPagamento);
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

    console.log(tabelaValoresAno);

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
                                   id="pagamento-${item.id}" value="${item.id}" name="tipospagamento[]" >
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
                $('#modalPagamentos').modal('show');
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

        if (pagamentos.length === 0) {
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

        //marcar os tipos que ele ja possui
        marcarpagamentoSelecionados();
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

  // Validação inicial
        if (!validarCampos()) {
            return false;
        }
        //  $('#formAluno').submit();
        // enviarFormulario();
           // Envia o formulário manualmente


// Percorre todos os checkboxes com a classe .checkbox-pagamento
let valoresSelecionados = [];

$('.checkbox-pagamento:checked').each(function() {
    valoresSelecionados.push($(this).val());
});

console.log(valoresSelecionados,tabelaValoresAno);


    this.submit();
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
                                const dados = response.meses.map(e => ({
                                    tipo: e.tipo,
                                    mes: e.mes
                                }));
                                const dadosEncoded = encodeURIComponent(JSON.stringify(dados));

                               const urlRecibo =`${URLS.imprimirRecibo}${response.anolectivo}/${response.idaluno}/${dadosEncoded}/${response.metodo}`
                               // window.open(urlRecibo, '_blank');
abrirReciboPDF(urlRecibo,response.idaluno)



// fetch(urlRecibo, {
//   method: 'GET',
//   headers: {
//     'Content-Type': 'application/pdf'
//   }
// })
// .then(res => {
//   if (!res.ok) {
//     throw new Error('Erro ao buscar o PDF');
//   }
//   return res.blob();
// })
// .then(blob => {
//   const pdfUrl = URL.createObjectURL(blob);

//   // coloca o PDF dentro do iframe
//   const frame = document.getElementById('pdfFrame');
//   frame.src = pdfUrl;

//   // mostra o popup
//   const popup = document.getElementById('pdfPopup');
//   popup.style.display = 'block';

//   // dispara impressão assim que o PDF carregar
//   frame.onload = () => {
//     const iframeWindow = frame.contentWindow;
//     iframeWindow.focus();
//     iframeWindow.print();

//     // fecha o popup quando terminar ou cancelar
//     iframeWindow.onafterprint = () => {
//       popup.style.display = 'none';
//       frame.src = ''; // limpa o iframe
//     };
//   };
// })
// .catch(err => {
//   console.error('Falha ao carregar o PDF:', err);
// });
                            }

                            // Limpar formulário
                            $('#formAluno')[0].reset();
                            $('#modalPagamentos').modal('hide');
                            inicializar();
                        });
                    } else {
                        mostrarAlerta('Erro', response.mensagem || 'Erro ao matricular aluno', 'error');
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





// Função para abrir o PDF
function abrirReciboPDF(url,idaluno) {
    // Prepara dados para envio
    // const dados = response.meses.map(e => ({
    //     tipo: e.tipo,
    //     mes: e.mes
    // }));

    //const dadosEncoded = encodeURIComponent(JSON.stringify(dados));

    // Monta a URL
   // const urlRecibo = `${URLS.imprimirRecibo}${response.anolectivo}/${response.idaluno}/${dadosEncoded}/${response.metodo}`;

    console.log('URL do PDF:', url);

    // Mostra loading
    const popup = document.getElementById('pdfPopup');
    const loading = document.getElementById('pdfLoading');
    const pdfFrame = document.getElementById('pdfFrame');

    popup.style.display = 'block';
    loading.style.display = 'block';
    pdfFrame.style.display = 'none';

    // Faz a requisição do PDF
    fetch(url, {
        method: 'GET',
        headers: {
            'Accept': 'application/pdf'
        }
    })
    .then(res => {
        if (!res.ok) {
            throw new Error(`Erro ao buscar o PDF: ${res.status} ${res.statusText}`);
        }
        return res.blob();
    })
    .then(blob => {
        // Cria URL do blob
        const pdfUrl = URL.createObjectURL(blob);

        // Configura o iframe
        pdfFrame.src = pdfUrl;
        loading.style.display = 'none';
        pdfFrame.style.display = 'block';

        // Configura o botão de download
        document.getElementById('downloadBtn').onclick = function() {
            const link = document.createElement('a');
            link.href = pdfUrl;
            link.download = `recibo-matricula-${idaluno}.pdf`;
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        };

        // Configura impressão automática se necessário
        if (response.metodo !== 2) { // Só imprime automaticamente se não for M-Pesa
            setTimeout(() => {
                const iframeWindow = pdfFrame.contentWindow;
                if (iframeWindow) {
                    iframeWindow.focus();
                    iframeWindow.print();
                }
            }, 1000);
        }
    })
    .catch(err => {
        console.error('Falha ao carregar o PDF:', err);
        loading.innerHTML = `
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-triangle"></i>
                <h4>Erro ao carregar recibo</h4>
                <p>${err.message}</p>
                <button onclick="document.getElementById('pdfPopup').style.display='none'"
                        class="btn btn-sm btn-danger">
                    Fechar
                </button>
            </div>
        `;
    });
}

// Event Listeners para o popup
document.addEventListener('DOMContentLoaded', function() {
    // Botão fechar
    document.getElementById('closeBtn').addEventListener('click', function() {
        const popup = document.getElementById('pdfPopup');
        const pdfFrame = document.getElementById('pdfFrame');

        popup.style.display = 'none';
        // Limpa o iframe para liberar memória
        if (pdfFrame.src) {
            URL.revokeObjectURL(pdfFrame.src);
            pdfFrame.src = '';
        }
    });

    // Botão imprimir
    document.getElementById('printBtn').addEventListener('click', function() {
        const pdfFrame = document.getElementById('pdfFrame');
        const iframeWindow = pdfFrame.contentWindow;

        if (iframeWindow) {
            iframeWindow.focus();
            iframeWindow.print();
        }
    });

    // Fecha popup ao clicar fora
    document.getElementById('pdfPopup').addEventListener('click', function(e) {
        if (e.target === this) {
            this.style.display = 'none';
            const pdfFrame = document.getElementById('pdfFrame');
            if (pdfFrame.src) {
                URL.revokeObjectURL(pdfFrame.src);
                pdfFrame.src = '';
            }
        }
    });

    // Fecha com tecla ESC
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            const popup = document.getElementById('pdfPopup');
            if (popup.style.display === 'block') {
                popup.style.display = 'none';
                const pdfFrame = document.getElementById('pdfFrame');
                if (pdfFrame.src) {
                    URL.revokeObjectURL(pdfFrame.src);
                    pdfFrame.src = '';
                }
            }
        }
    });
});


                        // Abre o PDF no pop


$(document).ready(function(){
marcarpagamentoSelecionados();
});
                        function marcarpagamentoSelecionados(){
                            tipoPagamento.forEach(function(item) {
    // Busca todos os checkboxes com a classe 'checkbox-pagamento'
    // que tenham o valor igual ao tipoPagamento_id
    $('.checkbox-pagamento[value="' + item.tipo_pagamento_id + '"]').prop('checked', true);
    // console.log("checkboxs---",item.tipoPagamento_id);
});
                        }
</script>
@endsection
