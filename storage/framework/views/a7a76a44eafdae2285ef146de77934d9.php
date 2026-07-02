<?php
 function numeroParaRomano($num) {
    $mapa = [
        1000 => 'M', 900 => 'CM',
        500 => 'D', 400 => 'CD',
        100 => 'C', 90 => 'XC',
        50 => 'L', 40 => 'XL',
        10 => 'X', 9 => 'IX',
        5 => 'V', 4 => 'IV',
        1 => 'I'
    ];

    $resultado = '';

    foreach ($mapa as $valor => $romano) {
        while ($num >= $valor) {
            $resultado .= $romano;
            $num -= $valor;
        }
    }

    return $resultado;
}
$tituloselecao="Selecionar Turma";
 $optionturma="Turma";

   $alfabeto = $turmasDistintas ?? range('A', 'Z');

if ($flag == 2) {
    $alfabeto = [];

    for ($i = 1; $i <= 30; $i++) { // define limite que quiser
        $alfabeto[] = numeroParaRomano($i);
        $tituloselecao="Selecionar Jurri";
        $optionturma="Jurri";
    }
}



?>
<div class="container mt-4">
    <div class="row">

        <?php $__currentLoopData = $dadosTurmas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $turma): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>


            <div class="col-md-6 mb-4 card-turma" id="card-<?php echo e($key); ?>">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white" style="cursor: pointer;" onclick="toggleTurma('turma-<?php echo e($key); ?>')">
                        <h5 class="mb-0 d-flex justify-content-between align-items-center">
                            <span>
                                <?php if($flag==2): ?>
                                Jurri
                                <?php else: ?>
                                Turma
                                <?php endif; ?>
                            </span>
                            <input name="turmasNome[]" class="form-control form-control-sm w-50 d-inline-block" value="<?php echo e($turma[0]->turma ?? $alfabeto[$key]); ?>">
                            <span class="toggle-icon">⬇</span>
                        </h5>
                    </div>
                    <div class="card-body turma-table" id="turma-<?php echo e($key); ?>" style="display: none;">
                        <table class="table table-bordered listadosalunosTurma" id="turmaAlunos-<?php echo e($key); ?>">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Nr</th>
                                    <th>Nome</th>
                                    <th>Sexo</th>
                                    <th>Idade</th>
                                    <th>Ação</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $turma; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $aluno): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                    <tr id="aluno-<?php echo e($aluno->id); ?>">
                                        <td><?php echo e($aluno->id); ?></td>
                                        <td><?php echo e($aluno->nome); ?></td>
                                        <td><?php echo e($aluno->sexo); ?></td>
                                        <td><?php echo e($aluno->idade); ?></td>
                                        <td>
                                            <select class="form-control" onchange="moverAluno(<?php echo e($aluno->id); ?>, '<?php echo e($key); ?>', this.value)">
                                                <option value=""><?php echo e($tituloselecao); ?></option>
                                                <?php $__currentLoopData = $dadosTurmas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key2 => $turmaDestino): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php if($key !== $key2): ?>
                                                        <option value="<?php echo e($key2); ?>"><?php echo e($optionturma); ?> <?php echo e($turmaDestino[0]->turma ?? $alfabeto[$key2]); ?></option>
                                                    <?php endif; ?>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    <div class="card mt-4">
        <div class="card-footer text-right">
            <button class="btn btn-success GuadarTurmas">
                <?php if($flag==1): ?>
                Guardar as Turmas
                <?php else: ?>
Guardar Jurri
                <?php endif; ?>
            </button>
        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
flagtipo=<?php echo json_encode($flag, 15, 512) ?>;



// Função para alternar a visibilidade da turma
function toggleTurma(id) {
    const div = document.getElementById(id);
    const icon = div.closest('.card').querySelector('.toggle-icon');

    if (div.style.display === "none") {
        div.style.display = "block";
        icon.textContent = "⬆";
        $(`#${id} .listadosalunos`).DataTable().columns.adjust().responsive.recalc();
    } else {
        div.style.display = "none";
        icon.textContent = "⬇";
    }
}

// Função para mover aluno entre turmas
function moverAluno(alunoId, turmaOrigem, novaTurma) {
    if (!novaTurma) {
        alert("Selecione uma nova turma.");
        return;
    }

    const origemTable = $(`#turmaAlunos-${turmaOrigem}`).DataTable();
    const alunoRow = origemTable.row(`#aluno-${alunoId}`);

    if (!alunoRow.any()) {
        alert("Aluno não encontrado na tabela de origem!");
        return;
    }

    const alunoData = alunoRow.data();
    alunoRow.remove().draw();

    const destinoTable = $(`#turmaAlunos-${novaTurma}`).DataTable();

     const novaLinha = destinoTable.row.add([alunoData[0],alunoData[1],alunoData[2],alunoData[3],
        `<button class="btn btn-sm btn-warning" onclick="voltarAluno(${alunoId}, '${novaTurma}', '${turmaOrigem}')">Voltar</button>`
    ]).draw();

    // Desenhar a tabela e depois adicionar o ID ao nó
    novaLinha.draw().nodes().to$().attr('id', `aluno-${alunoId}`);
    verificarTurmaVazia(turmaOrigem);
}

// Função para voltar aluno à turma original
function voltarAluno(alunoId, turmaAtual, turmaOrigem) {
    const atualTable = $(`#turmaAlunos-${turmaAtual}`).DataTable();
    const alunoRow = atualTable.row(`#aluno-${alunoId}`);

    if (!alunoRow.any()) {
        alert("Aluno não encontrado na tabela atual!");
        return;
    }

    const alunoData = alunoRow.data();
    alunoRow.remove().draw();

    const origemTable = $(`#turmaAlunos-${turmaOrigem}`).DataTable();

    // Construir opções de turmas
    let options = '<option value="">Selecionar Turma</option>';
    $(`[id^="card-"]`).each(function() {
        const turmaId = $(this).attr('id').replace('card-', '');
        if (turmaId !== turmaOrigem) {
            const turmaNome = $(this).find("[name='turmasNome[]']").val();
            options += `<option value="${turmaId}">Turma ${turmaNome}</option>`;
        }
    });

   const novaLinha= origemTable.row.add([
        alunoData[0],
        alunoData[1],
        alunoData[2],
        alunoData[3],
        `<select class="form-control" onchange="moverAluno(${alunoId}, '${turmaOrigem}', this.value)">${options}</select>`
    ]).draw();
  // Desenhar a tabela e depois adicionar o ID ao nó
    novaLinha.draw().nodes().to$().attr('id', `aluno-${alunoId}`);
    verificarTurmaVazia(turmaAtual);
}

// Verificar se turma ficou vazia
function verificarTurmaVazia(turmaId) {
    const table = $(`#turmaAlunos-${turmaId}`).DataTable();
    if (table.rows().count() === 0) {
        $(`#card-${turmaId}`).remove();
    }
}

$(document).ready(function() {
    // if ($.fn.DataTable.isDataTable('.listadosalunos')) {
    //     $('.listadosalunos').DataTable().clear().destroy();
    // }

    $('.listadosalunosTurma').DataTable({
        dom: 'Bfrtip',
        buttons: [
            { extend: 'csv', text: '<i class="fa fa-file-csv"></i> CSV', className: 'btn btn-sm btn-outline-primary' },
            { extend: 'excel', text: '<i class="fa fa-file-excel"></i> Excel', className: 'btn btn-sm btn-outline-success' },
            { extend: 'pdf', text: '<i class="fa fa-file-pdf"></i> PDF', className: 'btn btn-sm btn-outline-danger' },
            { extend: 'print', text: '<i class="fa fa-print"></i> Imprimir', className: 'btn btn-sm btn-outline-dark' }
        ],
        responsive: true,
        paging: true,
        language: {
            lengthMenu: "Visualizar _MENU_ registros por página",
            zeroRecords: "Nenhum registro encontrado",
            info: "Mostrando página _PAGE_ de _PAGES_",
            infoEmpty: "Nenhum registro disponível",
            infoFiltered: "(filtrado de _MAX_ registros no total)",
            search: "Pesquisar:",
            paginate: {
                first: "Primeiro",
                last: "Último",
                next: "Próximo",
                previous: "Anterior"
            },
        }
    });
});


// Salvar turmas via Ajax
(function($){
    $.fn.loadingButton = function(action, options = {}) {
        const $btn = this;
        const defaultText = options.text || 'Guardar Turmas';
        const loadingText = options.loadingText || '<i class="fas fa-spinner fa-spin"></i> Salvando...';

        switch(action) {
            case 'start':
                $btn.prop('disabled', true).addClass('loading').html(loadingText);
                break;
            case 'stop':
                $btn.prop('disabled', false).removeClass('loading').html(defaultText);
                break;
        }

        return $btn;
    };
})(jQuery);


let isSubmitting = false;

$(document).on("click", ".GuadarTurmas", function(e){
    e.preventDefault();
    if (isSubmitting) return;
    isSubmitting = true;

    const $btn = $(this).loadingButton('start', {
        text: 'Guardar Turmas',
        loadingText: '<i class="fas fa-spinner fa-spin"></i> Salvando...'
    });

    let turmas = [];
    let hasErrors = false;

    $('.card-turma').each(function() {
       const card = $(this);
    const turmaId = card.attr('id').replace('card-', '');
    const nomeTurma = card.find("[name='turmasNome[]']").val().trim();

    if (!nomeTurma) {
        alert(`O nome da turma ${turmaId} está vazio!`);
        hasErrors = true;
        return false;
    }

    const tabela = card.find('.listadosalunosTurma').DataTable();
    let alunos = [];

    tabela.rows().every(function() {
        const rowData = this.data();
        const alunoId = this.node().id.replace('aluno-', '');
        if (alunoId) alunos.push(alunoId);
    });

    if (alunos.length === 0) {
        alert(`A turma "${nomeTurma}" não tem alunos!`);
        hasErrors = true;
        return false;
    }

    turmas.push({
        id: turmaId,
        nome: nomeTurma,
        alunos: alunos
    });
    });


  // Verifica se há turmas válidas
// if (turmas.length === 0 && !hasErrors) {
//     $(".GuadarTurmas").prop('disabled', true).html('<i class="fas fa-ban"></i> Nenhuma turma válida');
//     return;
// }



    if (hasErrors) {
        $btn.loadingButton('stop');
        isSubmitting = false;
        return;
    }

    $.ajax({
        url: "<?php echo e(route('turma.guardarTodasTurmas')); ?>",
        method: 'POST',
        dataType: 'json',
        data: {
            anolectivo: $("#anoselecionado").val(),
            classe: $('[name="classeSelecionada"]').val(),
            turmas: turmas,
            flag: flagtipo,
            _token: '<?php echo e(csrf_token()); ?>'
        },
        success: function(response) {
            // ... feedback com Swal


             if (response.success) {
            Swal.fire({
                icon: 'success',
                title: 'Sucesso!',
                text: response.message || 'Turmas guardadas com sucesso!',
                timer: 2000
            });
       buscar_Dados();
     } else {
            Swal.fire({
                icon: 'error',
                title: 'Erro!',
                text: response.message || 'Ocorreu um erro ao guardar as turmas'
            });
        }
        },
        error: function(xhr) {
          Swal.fire({
            icon: 'error',
            title: 'Erro!',
            text: xhr.responseJSON?.message || xhr.responseText || 'Erro ao guardar turmas!'
        });
        },
        complete: function() {
            $btn.loadingButton('stop');
            isSubmitting = false;
        }
    });
});



    </script>

<style>

    .GuadarTurmas.loading {
    cursor: not-allowed;
    opacity: 0.7;
    pointer-events: none;
}
    </style>
<?php /**PATH C:\laragon\www\escola2025\resources\views/registoAcademico/turmas-condicionadas.blade.php ENDPATH**/ ?>