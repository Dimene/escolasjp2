    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <style>
        .editable { text-align: center;
    vertical-align: middle;
    cursor: pointer;
    padding: 0; margin: 0px;  }
    td{
        padding: 0px;
    }
        /* .editable input { width: 100%;  height: 100%; text-align: center; } */
        .media-cell { font-weight: bold; background-color: #e9ecef; text-align:center; }
        .highlight { background-color: #e6ffed; transition: background-color 0.5s; }
        .alert-floating { position: fixed; top:20px; right:20px; z-index:1000; display:none; }
        .btn-column-action { padding: 0.25rem 0.5rem; font-size: 0.8rem; }
    </style>
</head>
<body>
<div class="container-fluid mt-3">

    <!-- Alertas flutuantes -->
    <div class="alert alert-success alert-floating" id="successAlert"></div>
    <div class="alert alert-danger alert-floating" id="errorAlert"></div>

    <!-- Cabeçalho -->
     <h6 class="col-12">Caderneta de Notas</h6>
    <div class="d-flex justify-content-between align-items-center mb-3">

        <div class="row">

                    <?php if(empty($dadosbloqueio)||$dadosbloqueio->Estado1==null): ?>
            <button class="btn btn-primary col" data-toggle="modal" data-target="#formulaModal">
                <i class="fas fa-calculator"></i> Configurar Média
            </button>
            <?php endif; ?>

            <a class="btn btn-success col" href="<?php echo e(Route('notas.export', [$iddisciplia, $turmaid, $trimestre])); ?>">
                <i class="fas fa-file-export"></i> Exportar
            </a>
           <!-- Botão estilizado -->

                    <?php if(empty($dadosbloqueio)||$dadosbloqueio->Estado1==null): ?>
<a class="btn btn-primary col btnImportar" onclick="document.getElementById('excelInput').click();">
    <i class="fas fa-file-import"></i> Importar Excel
</a>
<?php endif; ?>




                    <?php if(empty($dadosbloqueio)||$dadosbloqueio->Estado1==null): ?>
            <button class="btn btn-info col" id="btnSaveAll">
                <i class="fas fa-save"></i> Salvar Tudo
            </button>

<a class="config-item btn btn-dark col" href="#" nome-modal="adicionarCampoNotas">
                <i class="fas fa-plus me-2"></i>Adicionar Prova
            </a>

            <?php endif; ?>

        </div>

    </div>



    <!-- Tabela -->
    <div class="table-responsive">
        <table class="display no-shadow table table-light container-fluid
display responsive nowrap"
    style="width:100%" id="editableTable">
            <thead >
                <tr>
                    <th>Nr</th>
                    <th>Nome</th>
                    <th>Sexo</th>
                    <?php $__currentLoopData = $disciplinaavalaicaotipo[$iddisciplia]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dispv): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>



<th>
    <div class="d-flex justify-content-between align-items-center">
        <span class="notanome"><?php echo e($dispv->nota_descricao); ?></span>


                    <?php if(empty($dadosbloqueio)||$dadosbloqueio->Estado1==null): ?>

        <?php if($dispv->nota_meta_id != 0): ?>
            <!-- Botão Editar -->
            <button class="btn btn-sm btn-primary btn-column-action editar-notaavaliacao"
                provaid="<?php echo e($dispv->nota_meta_id); ?>"
                disciplina_id="<?php echo e($iddisciplia); ?>"
                turma_id="<?php echo e($turmaid); ?>"
                trimestre="<?php echo e($trimestre); ?>"
                title="Editar">
                <i class="fas fa-edit"></i>
            </button>

            <!-- Botão Excluir -->
           
        <?php endif; ?>
        <?php endif; ?>
    </div>
</th>



                        </th>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $turma; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $turmaItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr data-aluno-id="<?php echo e($turmaItem['id']); ?>">
                    <td><?php echo e($key + 1); ?></td>
                    <td class="font-weight-bold"><?php echo e($turmaItem['nome']); ?></td>
                    <td class="font-weight-bold"><?php echo e($turmaItem['sexo']); ?></td>

                    <?php $__currentLoopData = $disciplinaavalaicaotipo[$iddisciplia]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $dispv): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($dispv->nota_meta_id != 0): ?>
                            <td


                            

                            class="<?php if(empty($turmaItem['disciplinas']["idnotas"]["chave1"])&&empty($turmaItem['disciplinas']["idnotas"]["chave2"])): ?>
                             editable <?php endif; ?>"

                            id="<?php echo e($key."".$index); ?>"
                                data-aluno="<?php echo e($turmaItem['id']); ?>"
                                data-avaliacao="<?php echo e($dispv->nota_meta_id); ?>"
                                 avaliacaobvalor="<?php echo e($turmaItem['disciplinas'][$iddisciplia][$dispv->nota_meta_id] ?? ''); ?>"
                                data-avaliacaoNome="<?php echo e($dispv->nota_descricao); ?>"
                                 <?php echo e($dispv->nota_meta_id); ?>="<?php echo e($turmaItem['disciplinas'][$iddisciplia][$dispv->nota_meta_id] ?? 0); ?>"
                                data-idnota="<?php echo e($turmaItem['disciplinas']['idnotas'][$dispv->nota_meta_id] ?? ''); ?>">
                                <?php echo e($turmaItem['disciplinas'][$iddisciplia][$dispv->nota_meta_id] ?? ''); ?>



                            </td>
                        <?php else: ?>
                            <td class="media-cell" id="media-<?php echo e($turmaItem['id']); ?>">
                                <?php echo e($turmaItem['disciplinas'][$iddisciplia][$dispv->nota_meta_id] ?? ''); ?>

                            </td>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Fórmula -->
<div class="modal fade" id="formulaModal" class="modal fade" tabindex="-1" role="dialog" >
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header"  >
                <h5 class="modal-title">Configurar Fórmula de Cálculo</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="formulaForm">
                    <?php echo csrf_field(); ?>
                    <div class="form-group">
                        <label for="formulaInput">Fórmula:</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Média =</span>
                            </div>
                            <input type="text" class="form-control" id="formulaInput" name="formmulacriada"
                                value="<?php echo e(!empty($formunlamendia) ? $formunlamendia->formula : ''); ?>">
                        </div>
                        <small class="form-text text-muted">
                            Use os botões abaixo para inserir as avaliações na fórmula. Ex: (A1+A2+A3)/3
                        </small>
                    </div>
                    <div class="form-group">
                        <label>Avaliações:</label>
                        <div class="d-flex flex-wrap">
                            <?php $__currentLoopData = $disciplinaavalaicaotipo[$iddisciplia]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $nota_metaItm): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($nota_metaItm->nota_meta_id != 0): ?>
                                    <button type="button" class="btn btn-outline-primary m-1 btn-insert-var"
                                        data-var="<?php echo e($nota_metaItm->nota_descricao); ?>">
                                        <?php echo e($nota_metaItm->nota_descricao); ?>

                                    </button>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                
                <button type="button" class="btn btn-primary" id="btnSaveFormula">
                    <i class="fas fa-save"></i> Salvar Fórmula
                </button>
            </div>
        </div>
    </div>
</div>



<!-- Input file escondido -->
<input type="file" id="excelInput" accept=".xlsx,.xls" style="display: none;" onchange="uploadExcel(this.files)">


<script src="<?php echo e(asset('Admin-LTE/plugins/jquery/jquery.min.js')); ?>"></script>



    <script src="<?php echo e(asset('Admin-LTE/plugins/bootstrap/js/bootstrap.bundle.min.js')); ?>"></script>
    <script src="<?php echo e(asset('Admin-LTE/plugins/datatables/dataTables.bootstrap4.js')); ?>"></script>
    <script src="<?php echo e(asset('Datatable/js/jquery.dataTables.min.js')); ?>"></script>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>




<script>
    var table = $('#editableTable').DataTable({
        pageLength: 10,
        language:{
                url: "/Datatable/pt/Portuguese-Brasil.json"
        }
    });

    // Fórmula vinda do banco
    var formula = "<?php echo e(!empty($formunlamendia) ? $formunlamendia->formula : ''); ?>";
    var changes = {};
    var columnMap = {};

    var  avaliacoesdados= <?php echo json_encode($disciplinaavalaicaotipo[$iddisciplia], 15, 512) ?>;


	// Função que calcula e atualiza a média de um aluno
    function updateMedia(linha){
        if(!formula) return;


        var formulaToCalculate = formula;


$dados=table.row(linha).data();
$array=[];
$arrayDados=[];
let avaliacaoMap = {};
avaliacoesdados.forEach(function(e,index){
    $array.push(e.nota_descricao);
    $arrayDados.push($dados[index+3]);

    avaliacaoMap[e.nota_descricao] =$dados[index+3];
});
        console.log($dados,$array,$arrayDados,formulaToCalculate,avaliacaoMap);
        let formulaCalculada = formulaToCalculate;

        for (let nome in avaliacaoMap) {
    // substitui todas as ocorrências do nome pela nota
    let regex = new RegExp("\\b" + nome + "\\b", "g");
    formulaCalculada = formulaCalculada.replace(regex, avaliacaoMap[nome]);
}

console.log("Fórmula original:", formulaToCalculate);
console.log("Fórmula substituída:", formulaCalculada);

// Se quiser calcular:
let resultado = eval(formulaCalculada);
let parteInteira = Math.floor(resultado);
let parteDecimal = resultado - parteInteira;

let resultadoFinal = (parteDecimal > 0.4)
    ? Math.ceil(resultado)
    : Math.floor(resultado);

console.log("Resultado bruto:", resultado);
console.log("Resultado arredondado:", resultadoFinal);
$dados[$dados.length-1]=resultadoFinal;
console.log($dados);

 // Atualiza a linha no DataTable
    table.row(linha).data($dados).draw(false);


let row = table.row(linha).node(); // <tr> da linha atualizada
    // percorre as células (td) da 4ª até a penúltima
$(row).find('td').each(function (index) {
    let totalCols = $(row).find('td').length;
    if (index >= 3 && index < totalCols - 1) {
        $(this).addClass('editable');

        $(this).attr('id');
    }
});

    }


function uploadExcel(files) {

    if (files.length === 0) return;

    let formData = new FormData();
    formData.append('file', files[0]);

    let tableData = [];

    // pegar dados atuais da DataTable
    let table = $('#editableTable').DataTable();

    table.rows().every(function () {
        tableData.push(this.data());
    });

    formData.append('tableData', JSON.stringify(tableData));
    formData.append('Inicio', 10);

    $.ajax({
        url: '<?php echo e(route("notas.dadosTable")); ?>',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,

        headers: {
            'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
        },

        beforeSend: function () {

            $("#btnImportar")
                .prop("disabled", true)
                .html(`
                    <span class="spinner-border spinner-border-sm"></span>
                    Importando...
                `);
        },

        success: function (response) {

            console.log("Dados recebidos:", response.dados);

            // limpar tabela
            table.clear();

            // adicionar novos dados
            table.rows.add(response.dados);

            // redesenhar
            table.draw();

            // percorrer linhas da tabela
            table.rows().every(function (rowIdx) {

                let rowNode = this.node();
                let cells = $(rowNode).find('td');
                let rowData = this.data();

                // coluna numerador
                $(cells[0]).text(rowIdx + 1);

                // tornar células editáveis
                for (let i = 2; i < cells.length; i++) {
                    $(cells[i]).addClass('editable');
                }

                // adicionar atributo aluno
                if (rowData) {
                    $(rowNode).attr('data-aluno-id', rowData[0]);
                }

                // calcular média
                updateMedia(rowIdx);

            });

            Swal.fire({
                icon: 'success',
                title: 'Importação concluída!',
                text: response.message || '',
                timer: 2000,
                showConfirmButton: false
            });






        },

        complete: function () {

            $("#btnImportar")
                .prop("disabled", false)
                .html(`<i class="fas fa-file-import"></i> Importar Excel`);
        },

        error: function (xhr) {

            console.error(xhr.responseText);

            Swal.fire({
                icon: 'error',
                title: 'Erro ao importar',
                text: xhr.responseJSON?.message || 'Algo deu errado'
            });
        }
    });
}




$(document).ready(function() {







$('#btnSaveAll').on('click', async function () {

let btn = $(this);
    // Mostra todos os registros
    table.page.len(-1).draw();

    let alunoIds = [];
    let dados = table.rows().data().toArray();
    let i = 0;

    // Percorre todas as linhas do DataTable (mesmo as não visíveis)
    table.rows().every(function () {
        let id = $(this.node()).data('aluno-id');
        if (id !== undefined) {
            alunoIds.push(id);
            if (dados[i]) {
                dados[i][0] = id; // substitui a 1ª coluna pelo ID
            }
        }
        i++;
    });

    console.log("IDs capturados:", alunoIds);
    console.log("Dados enviados:", dados);

    // Enviar via Ajax
    $.ajax({
        url: "<?php echo e(route('notas.store')); ?>",
        type: "POST",
        dataType: "json",
        data: {
            _token: "<?php echo e(csrf_token()); ?>",
            dados: dados,
            avaliacoes:  avaliacoesdados,
            turma: <?php echo json_encode($turmaid, 15, 512) ?>,
            divisao: $("#my-divisao").val(),
        anolectivo: $('#my-anolectivo').val(),
            classe: $('#my-classe').val(),
            disciplina:<?php echo json_encode($iddisciplia, 15, 512) ?>
        },
          beforeSend: function() {
                    $(".Conteudotabela").html(
                        '<div class="loading-container"><div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div></div>'
                    );
                },
        success: function (response) {
            Swal.fire({
                position: "top-end",
                icon: "success",
                title: "atualizado com sucesso",
                showConfirmButton: false,
                timer: 2000
            });

            // Atualiza notas sem recarregar página
            // buscarnotas(
            //     $("[name='turma_idController']").val(),
            //     $("[name='divisao_aolectivo']").val()

            // );

            $(".Conteudotabela").empty();
     let disciplinaId=$(".disciplina_id.active").data("disciplina-id");
         let trimestre=$("#my-divisao").val();
          let liAtivo = document.querySelector(".Turma-elemento.active");


     buscarnotasportrimestreturma(disciplinaId,liAtivo.id,trimestre);;

			 btn.find(".spinner-border").addClass("d-none");
        btn.find(".btn-text").text("Salvar Tudo");
        btn.prop("disabled", false);
        },
        error: function (xhr) {
            console.error("Erro:", xhr.responseText);
            Swal.fire({
                position: "top-end",
                icon: "error",
                title: "Erro ao salvar os dados!",
                showConfirmButton: false,
                timer: 2000
            });
        },
        complete: function () {
            // Sempre volta para 25 registros por página
            table.page.len(25).draw();
        }
    });
});






    // Mapeia colunas para substituir variáveis
    <?php $__currentLoopData = $disciplinaavalaicaotipo[$iddisciplia]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $dispv): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php if($dispv->nota_meta_id != 0): ?>
            columnMap[<?php echo e($index + 2); ?>] = { id: "<?php echo e($dispv->nota_meta_id); ?>", desc: "<?php echo e($dispv->nota_descricao); ?>" };
        <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    // Função para exibir alertas flutuantes
    function showAlert(message, type){
        var alert = type==='success'?$('#successAlert'):$('#errorAlert');
        alert.removeClass('alert-success alert-danger').addClass('alert-'+type).text(message).fadeIn();
        setTimeout(()=>alert.fadeOut(),3000);
    }


    // Edição inline
    $('#editableTable').on('click','td.editable',function(){
        if($(this).find('input').length) return;

        var cell = $(this);
        var value = cell.text().trim();
        var alunoId = cell.data('aluno');
        var alunoIdCelula = cell.attr('id');
        var avaliacaoId = cell.data('avaliacao');
        var avaliacaoValor = cell.attr('avaliacaobvalor');
        var avaliacaoIdNome = cell.data('avaliacaonome');
        var idnota = cell.data('idnota');

        cell.html('<input type="text" style="width:100%;heigth:100%" value="'+
        value+'" data-aluno="'+alunoId+
        '" data-avaliacao="'+avaliacaoId+
        '" data-idnota="'+idnota+'">');
        var input = cell.find('input');
        input.focus().select();

        // Ao sair do input ou pressionar ENTER
        input.on('blur keydown', function(e){
            if(e.type==='blur' || e.key==='Enter'){
                var newValue = input.val().trim();

                // Validação entre 0 e 20
                if(newValue && !/^([0-9]|1[0-9]|20)(\.[0-9]{1,2})?$/.test(newValue)){
                    showAlert("Valor inválido! Use números entre 0 e 20.","danger");
                    input.focus();
                    return;
                }

                // Atualiza DataTable
                var pos = table.cell(cell).index();
                table.cell(pos.row, pos.column).data(newValue).draw(false);

                // Destaque visual
                cell.addClass('highlight');
                setTimeout(()=>cell.removeClass('highlight'), 1000);
                console.log(""+avaliacaoIdNome+"",newValue,alunoIdCelula,pos.row, pos.column);
        $("#"+alunoIdCelula+"").attr("avaliacaobvalor",newValue);
cell.data("avaliacaonome",newValue);
                // Registra alteração
                changes[alunoId] = changes[alunoId] || {};
                changes[alunoId][avaliacaoId] = { value: newValue, idnota: idnota };

                // Atualiza a média
                updateMedia(pos.row);


            } else if(e.key==='Escape'){
                cell.text(value);
            }
        });

        // Navegação com TAB e setas
        input.on('keydown',function(e){
            var pos = table.cell(cell).index();
            var rowIdx = pos.row, colIdx = pos.column;
            var totalRows = table.rows().count(),
                totalCols = table.columns().count();

            switch(e.keyCode){
                case 9: // Tab
                    e.preventDefault();
                    if(!e.shiftKey){
                        colIdx++;
                        if(colIdx>=totalCols){ colIdx=2; rowIdx++; }
                    } else {
                        colIdx--;
                        if(colIdx<2){ colIdx=totalCols-1; rowIdx--; }
                    }
                    break;
                case 37: colIdx--; break; // Esquerda
                case 39: colIdx++; break; // Direita
                case 38: rowIdx--; break; // Cima
                case 40: rowIdx++; break; // Baixo
            }

            if(rowIdx>=0 && rowIdx<totalRows && colIdx>=2 && colIdx<totalCols)
                table.cell(rowIdx,colIdx).node().click();
        });
    });

    // Inserir variável na fórmula
    $('.btn-insert-var').click(function(){
        var input = $('#formulaInput');
        var pos = input[0].selectionStart;
        var val = input.val();
        input.val(val.substring(0,pos) + $(this).data('var') + val.substring(pos)).focus();
    });



    // Excluir coluna
    $('.delete-column').click(function(){
        if(!confirm('Deseja excluir esta avaliação?')) return;
        showAlert("Avaliação excluída com sucesso!","success");
        setTimeout(()=>location.reload(),1500);
    });

});






</script>

<?php /**PATH /home/sgemozco/escolasaojoaopauloii.sgemoz.com/resources/views/registoAcademico/notas/notas-tabela-dados.blade.php ENDPATH**/ ?>