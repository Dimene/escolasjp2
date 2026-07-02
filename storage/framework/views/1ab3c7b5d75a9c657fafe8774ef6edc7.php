<div class="card">
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-md-8">
                <div class="input-group">
                    <span class="input-group-text bg-transparent border-end-0">
                        <i class="fa fa-search text-primary"></i>
                    </span>
                    <input type="text" id="searchFarmacos" class="form-control border-start-0"
                           placeholder="Pesquisar por nome, banco, entidade ou referência...">
                </div>
            </div>
            <div class="col-md-4 text-end">
                <button type="button" class="btn btn-primary modalUploadAlunos" data-toggle="modal" data-target="#modalUploadAlunos">
                    <i class="fa fa-upload"></i> Importar Referências
                </button>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover table-striped" style="width:100%" id="listadosalunos">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Nome do Aluno</th>
                        <th>Banco</th>
                        <th>Entidade</th>
                        <th>Referência</th>
                        <th>Valor (MZN)</th>
                        <th>Estado</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $alunos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $valor = $value->valorDescricao ?? 0;
                            $limite = $value->limite ?? '';
                            $dataVencimento = $value->data_Fim ?? $value->limite;
                            $hoje = \Carbon\Carbon::now();
                            $dataVencimentoCarbon = \Carbon\Carbon::parse($dataVencimento);
                            $diasRestantes = $hoje->diffInDays($dataVencimentoCarbon, false);
                            $estaVencido = $diasRestantes < 0;
                            $multa = (($value->multaP ?? 0) / 100) * $valor;

                            // Determinar cor da referência baseada no status
                            $referenciaClasse = 'badge bg-success';
                            $referenciaIcone = 'fa fa-check-circle';

                            if(!empty($value->referenciaBanco)) {
                                if($estaVencido) {
                                    $referenciaClasse = 'badge bg-danger';
                                    $referenciaIcone = 'fa fa-exclamation-circle';
                                } elseif($diasRestantes <= 3 && $diasRestantes >= 0) {
                                    $referenciaClasse = 'badge bg-warning';
                                    $referenciaIcone = 'fa fa-clock-o';
                                } else {
                                    $referenciaClasse = 'badge bg-success';
                                    $referenciaIcone = 'fa fa-check-circle';
                                }
                            }

                            // Estado formatado
                            if($estaVencido){
                                $valor = $valor + $multa;
                                $estadoHtml = "<span class='text-danger'><i class='fa fa-exclamation-triangle'></i> Prazo Vencido - " . \Carbon\Carbon::parse($dataVencimento)->format('d/m/Y') .
                                    ($value->mes)."</span>";
                            } elseif($diasRestantes <= 3 && $diasRestantes >= 0) {
                                $estadoHtml = "<span class='text-warning'><i class='fa fa-clock-o'></i> Próximo ao Vencimento - {$diasRestantes} dia(s) restante(s). ($value->mes).  </span>";
                            } else {
                                $estadoHtml = "<span class='text-success'><i class='fa fa-calendar-check-o'></i> Dentro do Prazo - Vence em " . \Carbon\Carbon::parse($dataVencimento)->format('d/m/Y') . ($value->mes). "</span>";
                            }
                        ?>
                        <tr>
                            <td><?php echo e($key + 1); ?></td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <?php if($value->avatar ?? false): ?>
                                        <img src="<?php echo e(asset('storage/' . $value->avatar)); ?>"
                                             class="rounded-circle me-2" width="30" height="30">
                                    <?php endif; ?>
                                    <strong><?php echo e($value->nome ?? '-'); ?></strong>
                                </div>
                            </td>
                            <td><?php echo e($value->banco ?? '-'); ?></td>
                            <td><?php echo e($value->Entidade ?? '-'); ?></td>
                            <td>
                                <?php if(!empty($value->referenciaBanco)): ?>
                                    <span class="<?php echo e($referenciaClasse); ?>" style="font-size: 0.8rem; padding: 0.4rem 0.8rem;">
                                        <i class="<?php echo e($referenciaIcone); ?>"></i>
                                        <?php echo e($value->referenciaBanco); ?>

                                        <?php if($diasRestantes <= 3 && $diasRestantes >= 0 && !$estaVencido): ?>
                                            <small class="d-block">Expira em <?php echo e($diasRestantes); ?> dia(s)</small>
                                        <?php endif; ?>
                                    </span>
                                <?php else: ?>
                                    <button class="btn btn-sm btn-warning AtualizarReferencia"
                                            linha="<?php echo e($key); ?>"
                                            value="<?php echo e($value->idoutro); ?>">
                                        <i class="fa fa-download"></i> Gerar Referência
                                    </button>
                                <?php endif; ?>
                            </td>
                            <td>
                                <strong class="<?php echo e($estaVencido ? 'text-danger' : ($diasRestantes <= 3 && $diasRestantes >= 0 ? 'text-warning' : 'text-primary')); ?>">
                                    <?php echo e(number_format($valor, 2, ',', '.')); ?> MZN
                                </strong>
                                <?php if($multa > 0 && $estaVencido): ?>
                                    <small class="d-block text-danger">(Multa: <?php echo e(number_format($multa, 2, ',', '.')); ?>)</small>
                                <?php endif; ?>
                            </td>
                            <td><?php echo $estadoHtml; ?></td>
                            <td>
                                <?php if(!empty($value->referenciaBanco)): ?>
                                <div class="btn-group btn-group-sm" role="group">
                                    <button class="btn btn-secondary visualizarentidadesReferencias"
                                            idaluno="<?php echo e($value->id); ?>"
                                            idpagamento="<?php echo e($value->tipo_pagamento_id ?? 0); ?>"
                                            title="Imprimir Referência">
                                        <i class="fa fa-print"></i>
                                    </button>
                                </div>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
                <tfoot class="table-light">
                    <tr>
                        <th colspan="5" class="text-end">Total Geral:</th>
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
                <?php echo csrf_field(); ?>
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
                            <?php $anoAtual = date('Y'); ?>
                            <?php for($i = $anoAtual; $i >= $anoAtual - 5; $i--): ?>
                                <option value="<?php echo e($i); ?>" <?php echo e($i == $anoAtual ? 'selected' : ''); ?>><?php echo e($i); ?></option>
                            <?php endfor; ?>
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
    var dataTable = null;

    $(document).ready(function () {
        // Inicializar DataTable apenas uma vez
        if (!$.fn.DataTable.isDataTable('#listadosalunos')) {
            dataTable = $('#listadosalunos').DataTable({
                dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>rt<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
                buttons: [
                    { extend: 'copy', text: '<i class="fa fa-copy"></i> Copiar', className: 'btn btn-sm btn-primary' },
                    { extend: 'excel', text: '<i class="fa fa-file-excel"></i> Excel', className: 'btn btn-sm btn-success' },
                    { extend: 'pdf', text: '<i class="fa fa-file-pdf"></i> PDF', className: 'btn btn-sm btn-danger' },
                    { extend: 'print', text: '<i class="fa fa-print"></i> Imprimir', className: 'btn btn-sm btn-info' }
                ],
                responsive: true,
                pageLength: 10,
                lengthMenu: [[5, 10, 25, 50, 100, -1], [5, 10, 25, 50, 100, "Todos"]],
                language: {
                    lengthMenu: "Visualizar _MENU_ registros",
                    zeroRecords: "Nenhum registro encontrado",
                    info: "Página _PAGE_ de _PAGES_",
                    infoEmpty: "Sem registros disponíveis",
                    infoFiltered: "(filtrado de _MAX_ registros)",
                    search: "Pesquisar:",
                    paginate: {
                        first: "Primeira",
                        last: "Última",
                        next: "Próxima",
                        previous: "Anterior"
                    }
                },
                footerCallback: function(row, data, start, end, display) {
                    var api = this.api();
                    var total = api.column(5, { page: 'current' }).data()
                        .reduce(function(a, b) {
                            var cleanValue = String(b).replace(/[^\d,-]/g, '').replace(',', '.');
                            var num = parseFloat(cleanValue);
                            return a + (isNaN(num) ? 0 : num);
                        }, 0);
                    $('#totalValor').html(total.toFixed(2) + ' MZN');
                }
            });
        } else {
            dataTable = $('#listadosalunos').DataTable();
        }

        // Pesquisa customizada
        $('#searchFarmacos').on('keyup', function() {
            dataTable.search(this.value).draw();
        });

        // Atualizar referência (mantido)
        $(document).on('click', '.AtualizarReferencia', function() {
            var id = $(this).attr('value');
            var btn = $(this);
            var linhaTabela = $(this).closest('tr');
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
                title: 'Gerar Referência',
                text: 'Deseja gerar uma nova referência bancária?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sim, gerar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    var originalHtml = btn.html();
                    btn.html('<i class="fa fa-spinner fa-spin"></i>').prop('disabled', true);

                    $.ajax({
                        url: '/Financas/Banco/referencas/gerar/' + id + '/' + entidade,
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            _token: '<?php echo e(csrf_token()); ?>'
                        },
                        success: function(response) {
                            console.log(response);

                            if (response.Estado="Pago" && response.referenciaBanco) {
                                var badgeClass = 'badge bg-success';
                                var badgeIcon = 'fa fa-check-circle';

                                if (response.multaflagrefe>0) {
                                    badgeClass = 'badge bg-danger';
                                    badgeIcon = 'fa fa-exclamation-circle';
                                } else {
                                    badgeClass = 'badge bg-warning';
                                    badgeIcon = 'fa fa-clock-o';
                                }

                                var cell = linhaTabela.find('td:eq(4)');
                                var referenciaHtml = '<span class="' + badgeClass + '" style="font-size: 0.8rem; padding: 0.4rem 0.8rem;">';
                                referenciaHtml += '<i class="' + badgeIcon + '"></i> ' + response.referenciaBanco;
                                if (response.data_Fim <= 3 && response.diasRestantes >= 0 && !response.estaVencido) {
                                    referenciaHtml += '<small class="d-block">Expira em ' + response.diasRestantes + ' dia(s)</small>';
                                }
                                referenciaHtml += '</span>';
                                cell.html(referenciaHtml);
                                linhaTabela.find('td:eq(3)').html(response.Entidade);
                                linhaTabela.find('td:eq(2)').html(response.banco);

                                if (response.valor) {
                                    var valorCell = linhaTabela.find('td:eq(5)');
                                    var valorClass = response.estaVencido ? 'text-danger' : (response.diasRestantes <= 3 ? 'text-warning' : 'text-primary');
                                    var valorHtml = '<strong class="' + valorClass + '">' + formatMoney(response.valor) + ' MZN</strong>';
                                    if (response.multa && response.multa > 0) {
                                        valorHtml += '<small class="d-block text-danger">(Multa: ' + formatMoney(response.multa) + ')</small>';
                                    }
                                    valorCell.html(valorHtml);
                                }

                                if (response.estado) {
                                    var estadoCell = linhaTabela.find('td:eq(6)');
                                    estadoCell.html(response.estado);
                                }

                                if (dataTable) {
                                    var rowIndex = dataTable.row(linhaTabela).index();
                                    dataTable.cell(rowIndex, 4).data(response.referenciaBanco);
                                    if (response.valor) dataTable.cell(rowIndex, 5).data(formatMoney(response.valor));
                                    if (response.estado) dataTable.cell(rowIndex, 6).data(response.estado);
                                }

                                var acoesCell = linhaTabela.find('td:eq(7)');
                                if (acoesCell.find('.btn-secondary').length === 0) {
                                    var printBtn = '<a class="btn btn-secondary btn-sm" href="/Financas/Banco/referencas/alunoReferenciasPrint/' + response.id + '/' + response.tipo_pagamento_id + '/0" target="_blank" title="Imprimir Referência"><i class="fa fa-print"></i></a>';
                                    acoesCell.find('.btn-group').append(printBtn);
                                }

                                Swal.fire({
                                    title: 'Sucesso!',
                                    html: 'Referência gerada com sucesso!<br><small>' + response.referenciaBanco + '</small>',
                                    icon: 'success',
                                    timer: 3000,
                                    showConfirmButton: false
                                });
                            } else {
                                Swal.fire('Erro', response.message || 'Erro ao gerar referência', 'error');
                                btn.html(originalHtml).prop('disabled', false);
                            }
                        },
                        error: function(xhr) {
                            console.error('Erro:', xhr);
                            var errorMsg = xhr.responseJSON?.message || 'Erro ao gerar referência bancária';
                            Swal.fire('Erro', errorMsg, 'error');
                            btn.html(originalHtml).prop('disabled', false);
                        }
                    });
                }
            });
        });

        // ---------- UPLOAD DE ARQUIVO TXT (EXTRATO) ----------
        // Garantir remoção do backdrop ao fechar o modal
        $('#modalUploadAlunos').on('hidden.bs.modal', function () {
            $('body').removeClass('modal-open');
            $('.modal-backdrop').remove();
        });

        // Atualizar label do input file
        $('.custom-file-input').on('change', function() {
            var fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').html(fileName);
        });

        // Submissão do formulário via AJAX
        $('#formUploadReferencias').on('submit', function(e) {
            e.preventDefault();

            var formData = new FormData(this);
            var ano = $('#anoSelect').val();

            var fileInput = $('#fileReferencias');
            if (fileInput[0].files.length === 0) {
                Swal.fire('Atenção', 'Selecione um arquivo para importar.', 'warning');
                return;
            }

            $('#progressUpload').removeClass('d-none');
            $('#progressUpload .progress-bar').css('width', '0%');
            $('#uploadStatus').html('<span class="text-info"><i class="fa fa-spinner fa-spin"></i> Enviando arquivo...</span>');
            $('#btnUpload').prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Importando...');

            $.ajax({
                url: '/Financas/Banco/CaregarReferencias/' + ano,
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
                    $('#uploadStatus').html('<span class="text-success"><i class="fa fa-check-circle"></i> ' + response.message + '</span>');
                    Swal.fire('Sucesso!', response.message, 'success');

                    setTimeout(function() {
                        $('#modalUploadAlunos').modal('hide');
                        // Força a remoção do backdrop
                        $('body').removeClass('modal-open');
                        $('.modal-backdrop').remove();
                        $('#formUploadReferencias')[0].reset();
                        $('.custom-file-label').html('Escolher arquivo...');
                        $('#progressUpload').addClass('d-none');
                        $('#btnUpload').prop('disabled', false).html('<i class="fa fa-upload"></i> Importar');
                        // Recarregar página ou DataTable, se necessário
                        if (dataTable) {
                            location.reload(); // ou dataTable.ajax.reload()
                        }
                    }, 2000);
                },
                error: function(xhr) {
                    var errorMsg = 'Erro ao importar arquivo.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMsg = xhr.responseJSON.message;
                    }
                    $('#uploadStatus').html('<span class="text-danger"><i class="fa fa-exclamation-triangle"></i> ' + errorMsg + '</span>');
                    Swal.fire('Erro', errorMsg, 'error');
                    $('#btnUpload').prop('disabled', false).html('<i class="fa fa-upload"></i> Importar');
                    $('#progressUpload').addClass('d-none');
                }
            });
        });
    });

    // Função auxiliar para formatar dinheiro
    function formatMoney(value) {
        return new Intl.NumberFormat('pt-MZ', {
            style: 'currency',
            currency: 'MZN',
            minimumFractionDigits: 2
        }).format(value).replace('MT', '');
    }
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
        cursor: pointer;
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
</style>
<?php /**PATH C:\laragon\www\escolasaojoaopaulo\resources\views/Financas/Banco/visualizar-referncias-datatable.blade.php ENDPATH**/ ?>