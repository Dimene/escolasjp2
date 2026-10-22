<div class="card">
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-md-6">
                <div class="input-group">
                    <span class="input-group-text bg-transparent border-right-0">
                        <i class="fa fa-search text-primary"></i>
                    </span>
                    <input type="search" id="searchReferencias" class="form-control border-left-0"
                           placeholder="Pesquisar por nome, banco, entidade ou referência...">
                </div>
            </div>
            <div class="col-md-6 text-right">
                <button type="button" class="btn btn-primary modalUploadAlunos" data-toggle="modal" data-target="#modalUploadAlunos">
                    <i class="fa fa-upload"></i> Importar Referências
                </button>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-4">
                <label for="filtroMesReferencia" class="sr-only">Filtrar por mês</label>
                <select id="filtroMesReferencia" class="form-control">
                    <option value="">Todos os meses</option>
                </select>
            </div>
            <div class="col-md-4">
                <label for="filtroEstadoMesReferencia" class="sr-only">Filtrar por estado do mês</label>
                <select id="filtroEstadoMesReferencia" class="form-control">
                    <option value="">Todos os estados do mês</option>
                </select>
            </div>
            <div class="col-md-4">
                <button type="button" id="limparFiltrosMesReferencia" class="btn btn-outline-secondary">
                    <i class="fa fa-eraser" aria-hidden="true"></i> Limpar filtros
                </button>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover table-striped" style="width:100%" id="listadosalunos">
                <caption class="sr-only">Referências bancárias dos alunos</caption>
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Nome do Aluno</th>
                        <th>Banco</th>
                        <th>Entidade</th>

                        <th>Referência</th>
                        <th>Estado do Mês</th>
                        <th>Valor (MZN)</th>
                        <th>Estado</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($alunos as $key => $value)
                        @php
                            $tabela = $value->TBdetalhes($value->tipo_pagamento_id, $value->mes_id);
                            $valor = (float) ($tabela->valorDescricao ?? 0);
                            $multaPercentual = (float) ($tabela->multa ?? 0);
                            $multa = ($multaPercentual / 100) * $valor;
                            $dataVencimento = $tabela->data_Fim ?? $tabela->limite ?? null;
                            $dataVencimentoCarbon = filled($dataVencimento)
                                ? \Carbon\Carbon::parse($dataVencimento)->startOfDay()
                                : null;
                            $diasRestantes = $dataVencimentoCarbon
                                ? now()->startOfDay()->diffInDays($dataVencimentoCarbon, false)
                                : null;
                            $estaVencido = $diasRestantes !== null && $diasRestantes < 0;
                            $flag = $estaVencido ? 1 : 0;
                            $referencia = $value->referencidas(
                                $value->mes_id,
                                $value->tipo_pagamento_id,
                                $value->aluno_classe_id
                            )
                                ->where('Multa', $flag)
                                ->where('banco_id', $entidade->id)
                                ->first()
                                ?->referencia;
                            $referenciaNumerica = preg_replace('/\D/', '', (string) $referencia);
                            $referenciaMalGerada = filled($referencia) && strlen($referenciaNumerica) < 11;
                            $estadoMesLabel = trim((string) ($value->Estado ?? '')) ?: 'Sem estado';
                            $estadoMesFiltro = strtolower($estadoMesLabel);
                            $mesIdFiltro = (string) ($value->mes_id ?? '');
                            $mesNomeFiltro = $value->mes->Descricao ?? ($mesIdFiltro !== '' ? 'Mês ' . $mesIdFiltro : '');
                            $referenciaClasse = 'badge bg-success';
                            $referenciaIcone = 'fa fa-check-circle';

                            if (filled($referencia)) {
                                if ($referenciaMalGerada) {
                                    $referenciaClasse = 'badge bg-danger referencia-mal-gerada';
                                    $referenciaIcone = 'fa fa-exclamation-circle';
                                } elseif ($estaVencido) {
                                    $referenciaClasse = 'badge bg-danger';
                                    $referenciaIcone = 'fa fa-exclamation-circle';
                                } elseif ($diasRestantes !== null && $diasRestantes <= 3 && $diasRestantes >= 0) {
                                    $referenciaClasse = 'badge bg-warning';
                                    $referenciaIcone = 'fa fa-clock-o';
                                }
                            }

                            if ($estaVencido) {
                                $valor = $valor + $multa;
                            }
                        @endphp
                        <tr data-has-reference="{{ filled($referencia) ? '1' : '0' }}"
                            data-is-overdue="{{ $estaVencido ? '1' : '0' }}"
                            data-is-mal-generated="{{ $referenciaMalGerada ? '1' : '0' }}"
                            data-mes-id="{{ $mesIdFiltro }}"
                            data-mes-nome="{{ $mesNomeFiltro }}"
                            data-estado-mes="{{ $estadoMesFiltro }}"
                            data-estado-mes-label="{{ $estadoMesLabel }}">
                            <td>{{ $key + 1 }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    @if($value->avatar ?? false)
                                        <img src="{{ asset('storage/' . $value->avatar) }}"
                                             class="rounded-circle mr-2" width="30" height="30"
                                             alt="Fotografia de {{ $value->nome ?? 'aluno' }}" loading="lazy">
                                    @endif
                                    <strong>{{ $value->alunoclasse->aluno->nome ?? $value->nome ?? '-' }}</strong>
                                </div>
                            </td>
                            <td>{{ $entidade->descricao ?? '-' }}</td>
                            <td>{{ $entidade->Entidade ?? '-' }}</td>
                            <td>
                                @if(!empty($referencia))
                                    <span class="{{ $referenciaClasse }}" style="font-size: 0.8rem; padding: 0.4rem 0.8rem;">
                                        <i class="{{ $referenciaIcone }}"></i>
                                        {{ $referencia }}
                                        @if($diasRestantes !== null && $diasRestantes <= 3 && $diasRestantes >= 0)
                                            <small class="d-block">Expira em {{ $diasRestantes }} dia(s)</small>
                                        @endif
                                        @if($referenciaMalGerada)
                                            <small class="d-block">Referência inválida</small>
                                        @endif
                                    </span>
                                @else
                                    <button type="button" class="btn btn-sm btn-warning AtualizarReferencia btn-gerar-pendente"
                                            data-action="generate"
                                            value="{{ $value->id }}">
                                        <i class="fa fa-download"></i> Gerar Referência
                                    </button>
                                @endif
                            </td>
                            <td>{{$value->Estado}}</td>
                            <td>
                                <strong data-value="{{ number_format((float) $valor, 2, '.', '') }}"
                                        class="{{ $estaVencido ? 'text-danger' : ($diasRestantes !== null && $diasRestantes <= 3 && $diasRestantes >= 0 ? 'text-warning' : 'text-primary') }}">
                                    {{ number_format($valor, 2, ',', '.') }} MZN
                                </strong>
                                @if($multa > 0 && $estaVencido)
                                    <small class="d-block text-danger">(Multa: {{ number_format($multa, 2, ',', '.') }})</small>
                                @endif
                            </td>
                            <td>
                                @if ($diasRestantes === null)
                                    <span class="text-muted"><i class="fa fa-calendar-times-o"></i> Sem data limite</span>
                                @elseif ($estaVencido)
                                    <span class="text-danger">
                                        <i class="fa fa-exclamation-triangle"></i>
                                        Prazo vencido - {{ $dataVencimentoCarbon->format('d/m/Y') }} ({{ $value->mes->Descricao ?? '' }})
                                    </span>
                                @elseif ($diasRestantes <= 3)
                                    <span class="text-warning">
                                        <i class="fa fa-clock-o"></i>
                                        Próximo do vencimento - {{ $diasRestantes }} dia(s) ({{ $value->mes->Descricao ?? '' }})
                                    </span>
                                @else
                                    <span class="text-success">
                                        <i class="fa fa-calendar-check-o"></i>
                                        Dentro do prazo - {{ $dataVencimentoCarbon->format('d/m/Y') }} ({{ $value->mes->Descricao ?? '' }})
                                    </span>
                                @endif
                            </td>
                            <td>
                                @if(!empty($referencia))
                                <div class="btn-group btn-group-sm" role="group">
                                    <button type="button" class="btn btn-primary AtualizarReferencia"
                                            data-action="regenerate"
                                            idaluno="{{ $value->aluno_classe_id }}"
                                            idpagamento="{{ $tabela->tipo ?? 0 }}"
                                            value="{{ $value->id }}"
                                            title="Gerar Referencia">
                                        <i class="fa fa-refresh"></i>
                                    </button>

                                </div>

                                <div class="btn-group btn-group-sm" role="group">
                                    <button type="button" class="btn btn-secondary visualizarentidadesReferencias"
                                            idaluno="{{ $value->aluno_classe_id }}"
                                            idpagamento="{{ $tabela->tipo ?? 0 }}"
                                            title="Imprimir Referência">
                                        <i class="fa fa-print"></i>
                                    </button>

                                </div>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot class="table-light">
                    <tr>
                        <th colspan="6" class="text-right">Total Geral:</th>
                        <th id="totalValor" class="text-primary">0.00 MZN</th>
                        <th colspan="2"></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<!-- Modal Upload -->
<div class="modal fade" id="modalUploadAlunos" tabindex="-1" role="dialog" aria-labelledby="modalUploadAlunosLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalUploadAlunosLabel">
                    <i class="fa fa-upload"></i> Importar Referências
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formUploadReferencias" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="alert alert-info">
                        <i class="fa fa-info-circle"></i>
                        Faça upload de um arquivo <strong>.txt</strong> fornecido pelo banco.
                    </div>
                    <div class="form-group">
                        <label for="fileReferencias">Selecione o arquivo</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="fileReferencias" name="file" accept=".txt" required>
                            <label class="custom-file-label" for="fileReferencias">Escolher arquivo...</label>
                        </div>
                        <small class="form-text text-muted">Tamanho máximo: 5MB</small>
                    </div>
                    <div class="form-group">
                        <label for="anoSelect">Ano letivo</label>
                        <select class="form-control" id="anoSelect" name="ano" required>
                            @php $anoAtual = date('Y'); @endphp
                            @for ($i = $anoAtual; $i >= $anoAtual - 5; $i--)
                                <option value="{{ $i }}" {{ $i == $anoAtual ? 'selected' : '' }}>{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="progress d-none" id="progressUpload">
                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%"></div>
                    </div>
                    <div id="uploadStatus" class="mt-2"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary" id="btnUpload">
                        <i class="fa fa-upload"></i> Importar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
    function carregarOpcoesFiltro(selector, valorAtributo, textoAtributo, textoPadrao) {
        var opcoes = new Map();

        $('#listadosalunos tbody tr').each(function() {
            var valor = this.getAttribute(valorAtributo);
            var texto = this.getAttribute(textoAtributo);
            if (valor && texto && !opcoes.has(valor)) {
                opcoes.set(valor, texto);
            }
        });

        var $select = $(selector).empty().append(
            $('<option>', { value: '', text: textoPadrao })
        );
        Array.from(opcoes.entries())
            .sort(function(a, b) {
                return a[1].localeCompare(b[1], 'pt');
            })
            .forEach(function(opcao) {
                $select.append($('<option>', {
                    value: opcao[0],
                    text: opcao[1]
                }));
            });
    }

    carregarOpcoesFiltro(
        '#filtroMesReferencia',
        'data-mes-id',
        'data-mes-nome',
        'Todos os meses'
    );
    carregarOpcoesFiltro(
        '#filtroEstadoMesReferencia',
        'data-estado-mes',
        'data-estado-mes-label',
        'Todos os estados do mês'
    );

    $('#filtroMesReferencia, #filtroEstadoMesReferencia')
        .off('change.filtrosMesReferencia')
        .on('change.filtrosMesReferencia', function() {
            if (typeof dataTableInstance !== 'undefined' && dataTableInstance) {
                dataTableInstance.draw();
            }
        });

    $('#limparFiltrosMesReferencia')
        .off('click.filtrosMesReferencia')
        .on('click.filtrosMesReferencia', function() {
            $('#filtroMesReferencia, #filtroEstadoMesReferencia').val('');
            if (typeof dataTableInstance !== 'undefined' && dataTableInstance) {
                dataTableInstance.draw();
            }
        });

    // Atualizar referência (mantido)
        $(document).off('click.referenciaIndividual', '.AtualizarReferencia')
            .on('click.referenciaIndividual', '.AtualizarReferencia', function(e) {
                e.preventDefault();
                var btn = $(this);
                var id = btn.val();
                var entidade = $("[name='Entidade']").val();

                if (btn.prop('disabled')) {
                    return;
                }
                if (!id) {
                    Swal.fire('Erro', 'Não foi possível identificar a parcela selecionada.', 'error');
                    return;
                }
                if (!entidade) {
                    Swal.fire('Atenção!', 'Selecione um banco/entidade primeiro.', 'warning');
                    return;
                }

                Swal.fire({
                    title: btn.attr('data-action') === 'regenerate' ? 'Regenerar Referência' : 'Gerar Referência',
                    text: 'Deseja gerar uma nova referência bancária?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sim, gerar',
                    cancelButtonText: 'Cancelar'
                }).then(function(result) {
                    if (!result.isConfirmed) {
                        return;
                    }

                    var originalHtml = btn.html();
                    btn.html('<i class="fa fa-spinner fa-spin" aria-hidden="true"></i> A gerar...')
                        .prop('disabled', true);

                    $.ajax({
                        url: @json(url('/Financas/Banco/gerar/referencas/aluno')) + '/' +
                            encodeURIComponent(id) + '/' + encodeURIComponent(entidade),
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            _token: '{{ csrf_token() }}'
                        }
                    }).done(function(response) {
                        var referencia = response.referenciaBanco || response.referencia;
                        if (!referencia) {
                            Swal.fire('Erro', response.message || 'O servidor não devolveu a referência gerada.', 'error');
                            return;
                        }

                        Swal.fire({
                            title: 'Sucesso!',
                            text: 'Referência gerada com sucesso: ' + referencia,
                            icon: 'success',
                            timer: 2500,
                            showConfirmButton: false
                        });
                        if (typeof consultarReferencias === 'function') {
                            consultarReferencias();
                        }
                    }).fail(function(xhr) {
                        console.error('Erro:', xhr);
                        var errorMsg = xhr.responseJSON && xhr.responseJSON.message
                            ? xhr.responseJSON.message
                            : 'Erro ao gerar referência bancária.';
                        Swal.fire('Erro', errorMsg, 'error');
                    }).always(function() {
                        btn.html(originalHtml).prop('disabled', false);
                    });
                });
        });

        // ---------- UPLOAD DE ARQUIVO TXT (EXTRATO) ----------
        // Atualizar label do input file
        $('.custom-file-input').on('change', function() {
            var fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').text(fileName);
        });

        // Submissão do formulário via AJAX
        $('#formUploadReferencias').on('submit', function(e) {
            e.preventDefault();
            if ($('#btnUpload').prop('disabled')) {
                return;
            }

            var formData = new FormData(this);
            var ano = $('#anoSelect').val();

            var fileInput = $('#fileReferencias');
            if (fileInput[0].files.length === 0) {
                Swal.fire('Atenção', 'Selecione um arquivo para importar.', 'warning');
                return;
            }
            if (!/\.txt$/i.test(fileInput[0].files[0].name)) {
                Swal.fire('Atenção', 'Selecione um ficheiro no formato .txt.', 'warning');
                return;
            }
            if (fileInput[0].files[0].size > 5 * 1024 * 1024) {
                Swal.fire('Atenção', 'O arquivo excede o limite de 5 MB.', 'warning');
                return;
            }

            $('#progressUpload').removeClass('d-none');
            $('#progressUpload .progress-bar').css('width', '0%');
            $('#uploadStatus').html('<span class="text-info"><i class="fa fa-spinner fa-spin"></i> Enviando arquivo...</span>');
            $('#btnUpload').prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Importando...');

            $.ajax({
                url: '/Financas/Banco/CaregarReferencias/' + encodeURIComponent(ano),
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                xhr: function() {
                    var xhr = new window.XMLHttpRequest();
                    xhr.upload.addEventListener('progress', function(evt) {
                        if (evt.lengthComputable) {
                            var percentComplete = Math.round((evt.loaded / evt.total) * 100);
                            $('#progressUpload .progress-bar').css('width', percentComplete + '%');
                        }
                    }, false);
                    return xhr;
                },
                success: function(response) {
                    $('#progressUpload .progress-bar').css('width', '100%');
                    var mensagem = response.message || 'Referências importadas com sucesso.';
                    $('#uploadStatus').empty().append(
                        $('<span>', { class: 'text-success' })
                            .append($('<i>', { class: 'fa fa-check-circle' }))
                            .append(document.createTextNode(' ' + mensagem))
                    );
                    Swal.fire('Sucesso!', mensagem, 'success');

                    setTimeout(function() {
                        $('#modalUploadAlunos').modal('hide');
                        $('#formUploadReferencias')[0].reset();
                        $('.custom-file-label').text('Escolher arquivo...');
                        $('#progressUpload').addClass('d-none');
                        $('#btnUpload').prop('disabled', false).html('<i class="fa fa-upload"></i> Importar');
                        if (typeof consultarReferencias === 'function') {
                            consultarReferencias();
                        }
                    }, 2000);
                },
                error: function(xhr) {
                    var errorMsg = 'Erro ao importar arquivo.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMsg = xhr.responseJSON.message;
                    } else if (xhr.responseJSON && xhr.responseJSON.errors) {
                        errorMsg = Object.values(xhr.responseJSON.errors).flat().join(' ');
                    }
                    $('#uploadStatus').empty().append(
                        $('<span>', { class: 'text-danger' })
                            .append($('<i>', { class: 'fa fa-exclamation-triangle' }))
                            .append(document.createTextNode(' ' + errorMsg))
                    );
                    Swal.fire('Erro', errorMsg, 'error');
                    $('#btnUpload').prop('disabled', false).html('<i class="fa fa-upload"></i> Importar');
                    $('#progressUpload').addClass('d-none');
                }
            });
        });
    });

</script>

<style>
    #listadosalunos_filter {
        display: none;
    }

    .custom-file-label::after {
        content: "Procurar" !important;
    }

    .table-hover tbody tr:hover {
        background-color: rgba(102, 126, 234, 0.05);
    }

    .btn-group-sm .btn {
        padding: 0.25rem 0.5rem;
        font-size: 0.75rem;
    }

    .badge {
        font-size: 0.8rem;
        padding: 0.4rem 0.8rem;
    }

    .badge.bg-success {
        background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
    }

    .badge.bg-warning {
        background: linear-gradient(135deg, #ed8936 0%, #dd6b20 100%);
        color: white;
    }

    .badge.bg-danger {
        background: linear-gradient(135deg, #f56565 0%, #c53030 100%);
    }

    .text-warning {
        color: #ed8936 !important;
    }

    .text-danger {
        color: #f56565 !important;
    }

    .text-success {
        color: #48bb78 !important;
    }

    @media (max-width: 767.98px) {
        #searchReferencias {
            min-width: 0;
        }

        .modalUploadAlunos {
            width: 100%;
            margin-top: 0.75rem;
        }

        #limparFiltrosMesReferencia {
            width: 100%;
        }

        #listadosalunos {
            font-size: 0.875rem;
        }

        #listadosalunos .btn-group {
            margin-bottom: 0.25rem;
        }
    }
</style>
