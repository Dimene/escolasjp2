$(document).ready(function() {
    // Inicializa DataTables
    const tabelaDisponiveis = $('#tabelaAlunosDisponiveis').DataTable({
        language: {
            search: "",
            searchPlaceholder: "Pesquisar...",
            lengthMenu: "Ver _MENU_",
            zeroRecords: "Nenhum aluno encontrado",
            info: "Mostrando _START_ a _END_ de _TOTAL_",
            infoEmpty: "Nenhum registro",
            paginate: {
                first: "Primeiro",
                last: "Último",
                next: "Próximo",
                previous: "Anterior"
            }
        },
        pageLength: 10,
        lengthMenu: [[5, 10, 25, -1], [5, 10, 25, "Todos"]]
    });

    const tabelaTurma = $('#tabelaAlunosTurma').DataTable({
        paging: false,
        searching: false,
        info: false,
        ordering: false
    });

    let contadorLinhas = 1;

    // Mover aluno para turma
    $(document).on('click', '.mover-aluno', function() {
        const linha = $(this).closest('tr');
        const nome = linha.find('td:first').contents().filter(function() {
            return this.nodeType === Node.TEXT_NODE;
        }).text().trim();
        const idade = linha.find('td:nth-child(2)').text();
        const alunoId = linha.find('.aluno-id').val();

        tabelaDisponiveis.row(linha).remove().draw();
        
        tabelaTurma.row.add([
            contadorLinhas++,
            `<input type="hidden" name="classes[]" class="aluno-id-selecionado" value="${alunoId}">${nome}`,
            idade,
            '<i class="fa fa-caret-left fa-2x text-danger remover-aluno" role="button" aria-label="Remover aluno"></i>'
        ]).draw();
    });

    // Remover aluno da turma
    $(document).on('click', '.remover-aluno', function() {
        const linha = $(this).closest('tr');
        const nome = linha.find('td:nth-child(2)').contents().filter(function() {
            return this.nodeType === Node.TEXT_NODE;
        }).text().trim();
        const idade = linha.find('td:nth-child(3)').text();
        const alunoId = linha.find('.aluno-id-selecionado').val();

        tabelaTurma.row(linha).remove().draw();
        
        tabelaDisponiveis.row.add([
            `<input type="hidden" class="aluno-id" value="${alunoId}">${nome}`,
            idade,
            '',
            '<i class="fa fa-caret-right fa-2x text-primary mover-aluno" role="button" aria-label="Mover aluno"></i>'
        ]).draw();
        
        reordenarIndices();
    });

    function reordenarIndices() {
        contadorLinhas = 1;
        $('#tabelaAlunosTurma tbody tr').each(function() {
            $(this).find('td:first').text(contadorLinhas++);
        });
    }

    // Guardar turma
    $('#btnGuardarTurma').on('click', function() {
        const nomeTurma = $('#nomeTurma').val();
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
            flag: window.flag,
            nomeTurma: nomeTurma,
            classesItem: classesItem,
            classeFrequentada: $('input[name="classeFrequentada"]').val(),
            Anolectivo_IDD: $('input[name="Anolectivo_IDD"]').val()
        };

        $.ajax({
            url: window.routes.store,
            type: 'POST',
            data: formData,
            beforeSend: function() {
                $('#btnGuardarTurma').prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Salvando...');
            },
            success: function(response) {
                Swal.fire('Sucesso', 'Registro salvo com sucesso!', 'success').then(() => {
                    location.reload();
                });
            },
            error: function(xhr) {
                Swal.fire('Erro', 'Ocorreu um erro ao salvar', 'error');
                console.error(xhr.responseText);
            },
            complete: function() {
                $('#btnGuardarTurma').prop('disabled', false).html('<i class="fa fa-save"></i> Guardar');
            }
        });
    });

    // Toggle opções da turma
    $(document).on('click', '.toggle-options', function() {
        const parent = $(this).closest('.list-group-item');
        parent.find('.turma-options').toggleClass('d-none');
    });

    // Editar turma
    $(document).on('click', '.editar-turma', function() {
        const id = $(this).closest('.turma-options').data('id');
        const url = window.routes.edit.replace(':id', id);

        $.get(url, { flag: window.flag }, function(data) {
            if (!data || !data[0]) return;

            $('#nomeTurma').val(data[0].Descricao);
            tabelaTurma.clear().draw();
            contadorLinhas = 1;

            data[1].forEach(aluno => {
                tabelaTurma.row.add([
                    contadorLinhas++,
                    `<input type="hidden" name="classes[]" class="aluno-id-selecionado" value="${aluno.idAlunoclasse}">${aluno.nome}`,
                    aluno.idade,
                    '<i class="fa fa-caret-left fa-2x text-danger remover-aluno" role="button"></i>'
                ]).draw();
            });

            $('#btnGuardarTurma').replaceWith(`
                <button type="button" class="btn btn-warning" id="btnAtualizarTurma" data-id="${data[0].id}">
                    <i class="fa fa-refresh"></i> Atualizar
                </button>
            `);
        }).fail(() => Swal.fire('Erro', 'Não foi possível carregar os dados', 'error'));
    });

    // Atualizar turma
    $(document).on('click', '#btnAtualizarTurma', function() {
        const id = $(this).data('id');
        const nomeTurma = $('#nomeTurma').val();
        const classesItem = $('.aluno-id-selecionado').map(function() {
            return $(this).val();
        }).get();

        if (!nomeTurma || classesItem.length === 0) {
            Swal.fire('Atenção', 'Preencha todos os campos', 'warning');
            return;
        }

        const updateUrl = window.routes.update.replace(':id', id);
        
        $.ajax({
            url: updateUrl,
            type: 'POST',
            data: {
                _token: $('input[name="_token"]').val(),
                _method: 'PUT',
                id: id,
                nomeTurma: nomeTurma,
                classesItem: classesItem,
                classeFrequentada: $('input[name="classeFrequentada"]').val(),
                Anolectivo_IDD: $('input[name="Anolectivo_IDD"]').val()
            },
            beforeSend: function() {
                $('#btnAtualizarTurma').prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Atualizando...');
            },
            success: function() {
                Swal.fire('Sucesso', 'Atualizado com sucesso!', 'success').then(() => location.reload());
            },
            error: function() {
                Swal.fire('Erro', 'Erro ao atualizar', 'error');
            },
            complete: function() {
                $('#btnAtualizarTurma').prop('disabled', false).html('<i class="fa fa-refresh"></i> Atualizar');
            }
        });
    });

    // Imprimir turma
    $(document).on('click', '.imprimir-turma', function() {
        const id = $(this).closest('.turma-options').data('id');
        const url = window.routes.show.replace(':id', id).replace(':type', '3').replace(':flag', window.flag);
        
        window.open(url, '_blank');
    });
});