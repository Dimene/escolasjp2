<link rel="stylesheet" href="<?php echo e(asset('Admin-LTE/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css')); ?>">

<form method="POST" action="<?php echo e(route('turma.store')); ?>" class="turma-form" id="turmaForm">
    <?php echo csrf_field(); ?>

    <?php if(!empty($alunoclasse) && $alunoclasse->first()): ?>
        <input type="hidden" name="classeFrequentada" value="<?php echo e($alunoclasse->first()->classe_id); ?>">
        <input type="hidden" name="Anolectivo_IDD" value="<?php echo e($alunoclasse->first()->ano_lectivo_id); ?>">
    <?php endif; ?>

    <div class="row p-3">
        <!-- Coluna de Alunos Disponíveis -->
        <div class="col-xl-4 col-md-6 col-sm-12 ">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <strong>Alunos Disponíveis</strong>
                </div>
                <div class="card-body p-0">
                    <table class="table table-hover table-striped mb-0" id="tabelaAlunosDisponiveis" style="width:100%">
                        <thead class="table-light">
                            <tr>
                                <th>Nome</th>
                                <th>Idade</th>
                                <th>Sexo</th>
                                <th class="text-center" style="width: 50px;">
                                    <i class="fa fa-arrow-right fa-lg text-muted"></i>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $alunoclasse; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $aluno): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr data-aluno-id="<?php echo e($aluno->aluno_classe_id); ?>">
                                    <td>
                                        <input type="hidden" class="aluno-id" value="<?php echo e($aluno->aluno_classe_id); ?>">
                                        <?php echo e($aluno->nome); ?>

                                    </td>
                                    <td><?php echo e(\Carbon\Carbon::parse($aluno->dataNascimento)->age); ?></td>
                                    <td><?php echo e($aluno->sexo); ?></td>
                                    <td class="text-center">
                                        <i class="fa fa-caret-right fa-2x text-primary mover-aluno"
                                           role="button"
                                           style="cursor: pointer;"></i>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Coluna do Formulário -->
        <div class="col-xl-4 col-md-6 col-sm-12 ">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <strong><?php echo e($flag == 1 ? 'Nova Turma' : 'Novo Jurri'); ?></strong>
                </div>
                <div class="card-body">
                    <div class="form-group mb-3">
                        <label for="nomeTurma" class="form-label">
                            <?php echo e($flag == 1 ? 'Nome da Turma' : 'Nome do Jurri'); ?>

                        </label>
                        <input type="text"
                               name="nomeTurma"
                               id="nomeTurma"
                               class="form-control"
                               placeholder="Ex: Turma A, 10ª Classe..."
                               required>
                    </div>

                    <div class="table-responsive" style="max-height: 400px;">
                        <table class="table table-sm" id="tabelaAlunosTurma" style="width:100%">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 40px;">#</th>
                                    <th>Nome</th>
                                    <th style="width: 60px;">Idade</th>
                                    <th style="width: 40px;" class="text-center">
                                        <i class="fa fa-arrow-left fa-lg text-muted"></i>
                                    </th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>

                    <div class="d-grid gap-2 mt-3">
                        <button type="button" class="btn btn-primary" id="btnGuardarTurma">
                            <i class="fa fa-save"></i> Guardar
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Coluna de Turmas/Jurris Criados -->
        <div class="col-xl-4 col-md-6 col-sm-12 ">
            <div class="card shadow-sm">
                <div class="card-header bg-secondary text-white">
                    <strong><?php echo e($flag == 1 ? 'Turmas Criadas' : 'Jurris Criados'); ?></strong>
                </div>
                <div class="card-body p-0" style="max-height: 500px; overflow-y: auto;">
                    <?php if($turmascriadas->isNotEmpty()): ?>
                        <div class="list-group list-group-flush">
                            <?php $__currentLoopData = $turmascriadas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="list-group-item">
                                    <div class="d-flex justify-content-between align-items-center turma-item"
                                         data-id="<?php echo e($item->turma_id ?? $item->jurri_id); ?>">
                                        <span class="fw-bold"><?php echo e($item->turma ?? $item->jurri); ?></span>
                                        <i class="fa fa-chevron-down text-secondary toggle-options"
                                           role="button"
                                           style="cursor: pointer;"></i>
                                    </div>
                                    <div class="turma-options mt-2 d-none" data-id="<?php echo e($item->turma_id ?? $item->jurri_id); ?>">
                                        <div class="btn-group w-100" role="group">
                                            <button type="button" class="btn btn-sm btn-outline-primary editar-turma">
                                                <i class="fa fa-edit"></i> Editar
                                            </button>
                                            <a href="<?php echo e(route('turma.show', [$item->turma_id ?? $item->jurri_id, 2, $flag])); ?>"
                                               class="btn btn-sm btn-outline-success"
                                               target="_blank">
                                                <i class="fa fa-file-excel-o"></i> Excel
                                            </a>
                                            <button type="button" class="btn btn-sm btn-outline-secondary imprimir-turma">
                                                <i class="fa fa-print"></i> Imprimir
                                            </button>
                                            <a href="<?php echo e(route('turma.show', [$item->turma_id ?? $item->jurri_id, 1, $flag])); ?>"
                                               class="btn btn-sm btn-outline-info"
                                               target="_blank">
                                                <i class="fa fa-download"></i> PDF
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php else: ?>
                        <div class="text-center text-muted py-4">
                            <i class="fa fa-info-circle fa-2x mb-2"></i>
                            <p>Nenhum <?php echo e($flag == 1 ? 'turma' : 'jurri'); ?> criado.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
$(document).ready(function() {
    let contadorLinhas = 1;
    let tabelaDisponiveis = null;
    let tabelaTurma = null;

    window.flagTurma = <?php echo json_encode($flag, 15, 512) ?>;
    window.routesTurma = {
        store: "<?php echo e(route('turma.store')); ?>",
        update: "<?php echo e(route('turma.update', ':id')); ?>",
        edit: "<?php echo e(route('turma.edit', ':id')); ?>",
        show: "<?php echo e(route('turma.show', [':id', ':type', ':flag'])); ?>"
    };

    // Inicializar DataTables
    if ($.fn.DataTable) {
        if ($('#tabelaAlunosDisponiveis').length) {
            tabelaDisponiveis = $('#tabelaAlunosDisponiveis').DataTable({
                language: {
                    search: "",
                    searchPlaceholder: "Pesquisar aluno...",
                    lengthMenu: "Ver _MENU_",
                    zeroRecords: "Nenhum aluno encontrado",
                    info: "Mostrando _START_ a _END_ de _TOTAL_",
                    infoEmpty: "Nenhum aluno",
                    paginate: { first: "«", last: "»", next: "›", previous: "‹" }
                },
                pageLength: 10,
                lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Todos"]],
                dom: '<"row"<"col-sm-6"l><"col-sm-6"f>>rtip'
            });
        }

        if ($('#tabelaAlunosTurma').length) {
            tabelaTurma = $('#tabelaAlunosTurma').DataTable({
                paging: false,
                searching: false,
                info: false,
                ordering: false,
                dom: 'rt'
            });
        }
    }

    // Mover aluno para turma
    $(document).on('click', '.mover-aluno', function(e) {
        e.preventDefault();
        const linha = $(this).closest('tr');
        const nome = linha.find('td:first').clone().children().remove().end().text().trim();
        const idade = linha.find('td:nth-child(2)').text();
        const alunoId = linha.find('.aluno-id').val();

        if (tabelaDisponiveis) {
            tabelaDisponiveis.row(linha).remove().draw();
        } else {
            linha.remove();
        }

        const novaLinha = [
            contadorLinhas++,
            `<input type="hidden" name="classes[]" class="aluno-id-selecionado" value="${alunoId}">${nome}`,
            idade,
            '<i class="fa fa-caret-left fa-2x text-danger remover-aluno" role="button" style="cursor:pointer"></i>'
        ];

        if (tabelaTurma) {
            tabelaTurma.row.add(novaLinha).draw();
        } else {
            $('#tabelaAlunosTurma tbody').append(`<tr><td>${novaLinha[0]}</td><td>${novaLinha[1]}</td><td>${novaLinha[2]}</td><td>${novaLinha[3]}</td></tr>`);
        }
    });

    // Remover aluno da turma
    $(document).on('click', '.remover-aluno', function() {
        const linha = $(this).closest('tr');
        const nome = linha.find('td:nth-child(2)').clone().children().remove().end().text().trim();
        const idade = linha.find('td:nth-child(3)').text();
        const alunoId = linha.find('.aluno-id-selecionado').val();

        if (tabelaTurma) {
            tabelaTurma.row(linha).remove().draw();
        } else {
            linha.remove();
        }

        const novaLinha = [
            `<input type="hidden" class="aluno-id" value="${alunoId}">${nome}`,
            idade,
            '',
            '<i class="fa fa-caret-right fa-2x text-primary mover-aluno" role="button" style="cursor:pointer"></i>'
        ];

        if (tabelaDisponiveis) {
            tabelaDisponiveis.row.add(novaLinha).draw();
        } else {
            $('#tabelaAlunosDisponiveis tbody').append(`<tr><td>${novaLinha[0]}</td><td>${novaLinha[1]}</td><td>${novaLinha[2]}</td><td>${novaLinha[3]}</td></tr>`);
        }

        reordenarIndices();
    });

    function reordenarIndices() {
        contadorLinhas = 1;
        $('#tabelaAlunosTurma tbody tr').each(function() {
            $(this).find('td:first').text(contadorLinhas++);
        });
    }

    // Guardar turma
    $('#btnGuardarTurma').off('click').on('click', function() {
        const nomeTurma = $('#nomeTurma').val().trim();
        const classesItem = $('.aluno-id-selecionado').map(function() {
            return $(this).val();
        }).get();

        if (!nomeTurma) {
            Swal.fire('Atenção', 'Informe o nome da turma', 'warning');
            return;
        }

        if (classesItem.length === 0) {
            Swal.fire('Atenção', 'Selecione pelo menos um aluno', 'warning');
            return;
        }

        const formData = {
            _token: $('input[name="_token"]').val(),
            flag: window.flagTurma,
            nomeTurma: nomeTurma,
            classesItem: classesItem,
            classeFrequentada: $('input[name="classeFrequentada"]').val(),
            Anolectivo_IDD: $('input[name="Anolectivo_IDD"]').val()
        };

        $.ajax({
            url: window.routesTurma.store,
            type: 'POST',
            data: formData,
            beforeSend: function() {
                $('#btnGuardarTurma').prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Salvando...');
            },
            success: function(response) {
                Swal.fire('Sucesso!', 'Registro salvo com sucesso!', 'success').then(() => {
                    // Recarregar o formulário
                    location.reload();
                });
            },
            error: function(xhr) {
                let errorMsg = 'Ocorreu um erro ao salvar';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMsg = xhr.responseJSON.message;
                }
                Swal.fire('Erro', errorMsg, 'error');
            },
            complete: function() {
                $('#btnGuardarTurma').prop('disabled', false).html('<i class="fa fa-save"></i> Guardar');
            }
        });
    });

    // Toggle opções da turma
    $(document).off('click', '.toggle-options').on('click', '.toggle-options', function(e) {
        e.stopPropagation();
        const parent = $(this).closest('.list-group-item');
        parent.find('.turma-options').toggleClass('d-none');
    });

    // Editar turma
    $(document).off('click', '.editar-turma').on('click', '.editar-turma', function() {
        const id = $(this).closest('.turma-options').data('id');
        const url = window.routesTurma.edit.replace(':id', id);

        $.ajax({
            url: url,
            type: 'GET',
             dataType: "json",
            data: { flag: window.flagTurma },
            success: function(data) {
                if (!data || !data[0]) return;

                $('#nomeTurma').val(data[0].Descricao);

                if (tabelaTurma) {
                    tabelaTurma.clear().draw();
                } else {
                    $('#tabelaAlunosTurma tbody').empty();
                }
                contadorLinhas = 1;

                data[1].forEach(aluno => {
                    const linha = [
                        contadorLinhas++,
                        `<input type="hidden" name="classes[]" class="aluno-id-selecionado" value="${aluno.aluno_classe_id}">${aluno.nome}`,
                        aluno.idade,
                        '<i class="fa fa-caret-left fa-2x text-danger remover-aluno" role="button" style="cursor:pointer"></i>'
                    ];

                    if (tabelaTurma) {
                        tabelaTurma.row.add(linha).draw();
                    } else {
                        $('#tabelaAlunosTurma tbody').append(`<tr><td>${linha[0]}</td><td>${linha[1]}</td><td>${linha[2]}</td><td>${linha[3]}</td></tr>`);
                    }
                });

                const idsSelecionados = data[1].map(a => a.idAlunoclasse);
                $('#tabelaAlunosDisponiveis tbody tr').each(function() {
                    const alunoId = $(this).find('.aluno-id').val();
                    if (idsSelecionados.includes(parseInt(alunoId))) {
                        if (tabelaDisponiveis) {
                            tabelaDisponiveis.row($(this)).remove().draw();
                        } else {
                            $(this).remove();
                        }
                    }
                });

                $('#btnGuardarTurma').replaceWith(`
                    <button type="button" class="btn btn-warning" id="btnAtualizarTurma" data-id="${data[0].id}">
                        <i class="fa fa-refresh"></i> Atualizar
                    </button>
                `);
            },
            error: function() {
                Swal.fire('Erro', 'Não foi possível carregar os dados', 'error');
            }
        });
    });


    // Atualizar turma

    $(document).off('click', '#btnAtualizarTurma').on('click', '#btnAtualizarTurma', function() {
        const id = $(this).data('id');
        const nomeTurma = $('#nomeTurma').val().trim();
        const classesItem = $('.aluno-id-selecionado').map(function() {
            return $(this).val();
        }).get();

        if (!nomeTurma) {
            Swal.fire('Atenção', 'Informe o nome da turma', 'warning');
            return;
        }



        const updateUrl = window.routesTurma.update.replace(':id', id);

        $.ajax({
            url: updateUrl,
            type: 'POST',
            data: {
                _token: $('input[name="_token"]').val(),
                _method: 'PUT',
                id: id,
                nomeTurma: nomeTurma,
                flag: window.flagTurma,
                classesItem: classesItem,
                classeFrequentada: $('input[name="classeFrequentada"]').val(),
                Anolectivo_IDD: $('input[name="Anolectivo_IDD"]').val()
            },
            beforeSend: function() {
                $('#btnAtualizarTurma').prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Atualizando...');
            },
            success: function() {
                Swal.fire('Sucesso!', 'Atualizado com sucesso!', 'success').then(() => {
                    location.reload();
                });
            },
            error: function(xhr) {
                Swal.fire('Erro', 'Erro ao atualizar', 'error');
            },
            complete: function() {
                $('#btnAtualizarTurma').prop('disabled', false).html('<i class="fa fa-refresh"></i> Atualizar');
            }
        });
    });

    // Imprimir turma
    $(document).off('click', '.imprimir-turma').on('click', '.imprimir-turma', function() {
        const id = $(this).closest('.turma-options').data('id');
        const url = window.routesTurma.show
            .replace(':id', id)
            .replace(':type', '3')
            .replace(':flag', window.flagTurma);

        const printWindow = window.open(url, '_blank');
        if (printWindow) {
            printWindow.focus();
        } else {
            Swal.fire('Atenção', 'Permita pop-ups para impressão', 'warning');
        }
    });




});




// adicionar de forma dinamica
       $(document).on("click", ".Gerar_turma", function() {
    // Access the DataTable instance
    var table = $('#listadosalunos').DataTable();

    // If you want to retrieve specific data, you can do this:+
    var selectedData = [];
    table.rows({ selected: true }).every(function() { // Get selected rows
        var data = this.data(); // Get data for a row
        selectedData.push(data); // Push it to the array
    });

    // Create an array to store data from the PHP variable
   // var allData = <?php echo json_encode($alunoclasse); ?>;

   // console.log(allData);
   var area = "";
    if ($(".areaDisciplina").length && $(".areaDisciplina").val()) {
        area = $(".areaDisciplina").val();
    }

    $.ajax({
        url: "<?php echo e(Route('turma.criaturmapersonalisada')); ?>",
        type: "POST",
        data: {
selectIdade: $(".por_idade:checked").val(),
            selectAlfabeto:$(".por_Alfabeto:checked").val(),
            ano:$(".anoselecionado").val(),
            classe:$("#classeSelecionada").val(),
            select_sexo: $(".por_sexo:checked").val(),
            quantidade: $(".Quantidade").val(),
            flag:flagTurma,
             $area:area,

            "_token": "<?php echo e(csrf_token()); ?>" // Ensure the CSRF token is properly used,
           // dadosTurma: allData
        },
        success: function(data) {
            $(".Tabelaalunosselecionadoasporanoclasses").html(data);
        },
        error: function(xhr, status, error) {
            console.error('Error:', error); // Handle errors
        }
    });
});
</script>
<?php /**PATH C:\laragon\www\escola2025\resources\views/registoAcademico/alunospor-classe-ano-selectionados.blade.php ENDPATH**/ ?>