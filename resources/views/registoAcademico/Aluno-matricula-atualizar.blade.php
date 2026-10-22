@php
    $host = request()->getHost();
    $subdomain = explode('.', $host)[0];
    $fotoAluno = $aluno->avatar
        ? asset("storage/{$subdomain}/fotoAluno/{$aluno->avatar}")
        : asset('storage/fotoAluno/avatar.png');
    $classeAtual = $class->Descricao ?? 'Não definida';
    $estadoMatricula = $classeDescricao->estado ?? $classeDescricao->Estado ?? 'Frequentado';
    $moradaAluno = collect([
        $aluno->morada->Endereco ?? null,
        $aluno->morada->RuaAvenida ?? null,
    ])->filter()->implode(', ');
    $contactosEncarregado = optional($aluno->encaregado)->contacto
        ?->pluck('Descricao')->filter()->implode(' / ');
@endphp

<style>
    #formAluno .foto-aluno-card {
        min-width: 0;
        overflow: hidden;
    }

    #formAluno .avatar-container,
    #formAluno #camera-preview {
        width: 200px;
        max-width: 100%;
        height: 200px;
        margin-right: auto;
        margin-left: auto;
        overflow: hidden;
        border: 3px solid #dee2e6;
        border-radius: 50%;
        background: #f4f4f4;
    }

    #formAluno .avatar-container img,
    #formAluno #camera-preview video,
    #formAluno #camera-preview canvas {
        display: block;
        width: 100% !important;
        max-width: 100%;
        height: 100% !important;
        object-fit: cover;
    }
</style>

<form id="formAluno" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <input type="hidden" name="idAlunos" id="idAlunos" value="{{ $aluno->id }}">

    <ul class="nav nav-tabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#dados-{{ $aluno->id }}" role="tab">
                <i class="fas fa-user-graduate mr-1"></i> Dados do aluno
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#pagamentos-{{ $aluno->id }}" role="tab">
                <i class="fas fa-money-check-alt mr-1"></i> Pagamentos
            </a>
        </li>
    </ul>

    <div class="tab-content pt-3">
        <div class="tab-pane fade show active" id="dados-{{ $aluno->id }}" role="tabpanel">
            <div class="row">
                <div class="col-lg-4 mb-3 align-self-start">
                    <div class="card foto-aluno-card">
                        <div class="card-body text-center">
                            <div class="avatar-container mb-2" id="avatar-container">
                                <img src="{{ $fotoAluno }}" alt="Fotografia de {{ $aluno->nome }}">
                            </div>
                            <div id="camera-preview" style="display:none;"></div>
                            <input type="hidden" name="image" class="image-tag">

                            <div class="custom-file text-left">
                                <input type="file" class="custom-file-input" id="fileexplorer"
                                       name="avatar-file" accept="image/jpeg,image/png,image/webp">
                                <label class="custom-file-label" for="fileexplorer">Escolher fotografia</label>
                            </div>
                            <small class="form-text text-muted">Formatos JPG, PNG ou WEBP; máximo 5 MB.</small>

                            <div class="btn-foto mt-3">
                                <button type="button" id="startCamera" class="btn btn-outline-primary btn-sm">
                                    <i class="fas fa-camera mr-1"></i> Abrir câmara
                                </button>
                                <button type="button" id="stopCamera" class="btn btn-outline-danger btn-sm" style="display:none">
                                    Parar câmara
                                </button>
                                <button type="button" id="takeSnapshot" class="btn btn-primary btn-sm" style="display:none">
                                    Capturar fotografia
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-8">
                    <div class="card mb-3">
                        <div class="card-header">
                            <strong><i class="fas fa-id-card mr-1"></i> Identificação do aluno</strong>
                        </div>
                        <div class="card-body">
                            <dl class="row mb-0">
                                <dt class="col-sm-4">Nome completo</dt>
                                <dd class="col-sm-8">{{ $aluno->nome ?? '—' }}</dd>

                                <dt class="col-sm-4">Código do aluno</dt>
                                <dd class="col-sm-8">{{ $aluno->codigo_AC ?? $classeDescricao->codigo_AC ?? '—' }}</dd>

                                <dt class="col-sm-4">Data de nascimento</dt>
                                <dd class="col-sm-8">
                                    @if ($aluno->dataNascimento)
                                        {{ \Carbon\Carbon::parse($aluno->dataNascimento)->format('d/m/Y') }}
                                        ({{ \Carbon\Carbon::parse($aluno->dataNascimento)->age }} anos)
                                    @else
                                        Não informada
                                    @endif
                                </dd>

                                <dt class="col-sm-4">Sexo</dt>
                                <dd class="col-sm-8">{{ $aluno->sexo === 'M' ? 'Masculino' : ($aluno->sexo === 'F' ? 'Feminino' : '—') }}</dd>

                                <dt class="col-sm-4">Regime</dt>
                                <dd class="col-sm-8">{{ $aluno->Tipo === 'B' ? 'Bolseiro' : 'Normal' }}</dd>

                                <dt class="col-sm-4">Encarregado</dt>
                                <dd class="col-sm-8">{{ $aluno->encaregado->nome ?? 'Não informado' }}</dd>

                                <dt class="col-sm-4">Contacto</dt>
                                <dd class="col-sm-8">{{ $contactosEncarregado ?: 'Não informado' }}</dd>

                                <dt class="col-sm-4">Morada</dt>
                                <dd class="col-sm-8">{{ $moradaAluno ?: 'Não informada' }}</dd>

                                <dt class="col-sm-4">Classe atual</dt>
                                <dd class="col-sm-8">{{ $classeAtual }}</dd>

                                <dt class="col-sm-4">Ano lectivo actual</dt>
                                <dd class="col-sm-8">{{ $classeDescricao->anolectivo->anolectivo ?? '—' }}</dd>

                                <dt class="col-sm-4">Estado da matrícula</dt>
                                <dd class="col-sm-8">
                                    <span class="badge badge-info">{{ ucfirst($estadoMatricula) }}</span>
                                </dd>
                            </dl>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <strong><i class="fas fa-exchange-alt mr-1"></i> Nova matrícula</strong>
                        </div>
                        <div class="card-body">
                            <div class="form-group mb-0">
                                <label for="classeDestino-{{ $aluno->id }}">Classe de destino <span class="text-danger">*</span></label>
                                <select class="form-control select-class-ano" id="classeDestino-{{ $aluno->id }}"
                                        name="ClassedeAtualizacao" required>
                                    <option value="">Selecione a classe de destino</option>
                                    @foreach ($classesshow as $classe)
                                        <option value="{{ $classe->id }}">{{ $classe->Descricao }}</option>
                                    @endforeach
                                </select>
                                <small class="form-text text-muted">
                                    Classe atual: {{ $classeAtual }}. Selecione a nova classe para consultar os valores e parcelas disponíveis.
                                </small>
                            </div>
                        </div>
                    </div>
                </div>z
            </div>
        </div>

        <div class="tab-pane fade" id="pagamentos-{{ $aluno->id }}" role="tabpanel">
            <div class="card">
                <div class="card-header">
                    <strong><i class="fas fa-list-check mr-1"></i> Tipos de pagamento e parcelas</strong>
                </div>
                <div class="card-body">
                    <div class="mb-2">
                        <span class="badge badge-info" id="modalidadeAnoLectivo">Modalidade do ano lectivo</span>
                    </div>
                    <p class="text-muted">
                        Selecione os pagamentos e as parcelas a incluir na matrícula. Pode marcar um tipo para selecionar todas as parcelas.
                    </p>
                    <div id="conteudoListaPagamentos">
                        <ul class="list-group" id="listaPagamentosTab"></ul>
                    </div>
                    <div class="alert alert-light border mt-3 mb-0">
                        <i class="fas fa-info-circle text-primary mr-1"></i>
                        As parcelas escolhidas serão apresentadas para confirmação antes de guardar a matrícula.
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-end mt-3">
        <button type="button" class="btn btn-primary botaoAtualizacaoAlunoId">
            <i class="fas fa-save mr-1"></i> Continuar para confirmação
        </button>
    </div>
</form>
