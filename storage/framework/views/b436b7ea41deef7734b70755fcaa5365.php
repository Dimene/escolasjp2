


    <link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.4.0/css/fixedHeader.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/fixedcolumns/4.3.0/css/fixedColumns.dataTables.min.css">
<?php
$classe = $classe_disciplinas->first()["classe_id"];

$usuario = Auth::user()->id;

$anolectivo = DB::table('classe_direcao')
    ->where("classe_id", $classe)
    ->max("anolectivo_id");

$dadosChave = DB::table('classe_direcao')
    ->where("classe_id", $classe)
    ->where("anolectivo_id", $anolectivo)
    ->where(function ($query) use ($usuario) {

        $query->where("pedagogico_id", $usuario)
              ->orWhere("director_id", $usuario);

    })
    ->first();

    $edicaoativa=false;


     $turmapermisao=DB::table('professor_turmaview')->where("professor_id",$usuario)
    ->where("Tipo_Docencia_id",1)
    ->where("turma_id",$turma)->first();
    if($turmapermisao||$dadosChave){
   $edicaoativa=true;
    }


// dd($usuario,$turma,$edicaoativa);
?>
<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <style>
        .erro-nota {
    background-color: #ffcccc !important;
    border: 1px solid red;
}
        .DTFC_LeftWrapper {
    border-right: 2px solid #ddd;
    background-color: white;
}

.DTFC_LeftHeadWrapper th {
    background-color: #f8f9fa;
    font-weight: bold;
}
        </style>
<div class="row align-items-center py-2 gx-3">
    <div class="col-auto">
        <?php echo csrf_field(); ?>
    </div>

    <script>
        var formula = "";
    </script>
<div id="progressContainer" style="display:none;margin-top:10px;" class="col-12">
    <div class="progress" style="height:25px;">
        <div id="progressBar"
            class="progress-bar progress-bar-striped progress-bar-animated bg-success"
            role="progressbar"
            style="width:0%">
            0%
        </div>
    </div>
</div>
<?php if($edicaoativa||Gate::check('Calcular-media-Disciplina')): ?>
     <div class="col-auto">
        <span class="btn btn-primary MediaDisciplina">📘 Média Disciplina</span>
    </div>
<?php endif; ?>

<?php if($edicaoativa||Gate::check("Calcular-media-Anual")): ?>


    <div class="col-auto">
        <span class="btn btn-primary MediaAnual">📗 Média Anual</span>
    </div>

<?php endif; ?>

<?php if($edicaoativa||Gate::check("Incluir-Resutado-pauta")): ?>


    <div class="col-auto">
      <span class="btn btn-secondary GereraResultado" data-estado="off" style="cursor:pointer;">
  ❌ Resultado
</span>
    </div>
  <?php endif; ?>

<?php if($edicaoativa||Gate::check("importar-excel-pauta")): ?>


    <div class="col-auto">
     <!-- Botão estilizado -->
<a class="btn btn-primary col btnImportar" onclick="document.getElementById('excelInput').click();">
    <i class="fa file-uplosd"></i> Importar Excel
</a>
<!-- Input file escondido -->
<input type="file" id="excelInput" accept=".xlsx,.xls" style="display: none;" onchange="uploadExcel(this.files)">

    </div>
   <?php endif; ?>

<?php if($edicaoativa||Gate::check("Imprimir-pauta")): ?>

    <div class="col-auto">
        
        



        <button type="button" class="btn btn-success BaixarExcel">
    Baixar Excel
</button>

<form id="formExcel" method="POST" action="/RegistoAcademico/notas/disciplinas/notasTrimestrais/Imprimir/Pauta/anual">
    <?php echo csrf_field(); ?>
    <input type="hidden" name="corpo" id="corpo">
    <input type="hidden" name="disciplinas" id="disciplinas">
    <input type="hidden" name="trimestre" id="trimestre">
    <input type="hidden" name="turma" id="turma">
    <input type="hidden" name="notasdiferente" id="notasdiferente"  value="9000">

</form>
    </div>
 <?php endif; ?>

<?php if($dadosChave): ?>
    <div class="col-auto">
        <span class="btn btn-success btn-fecharTRimestre d-flex align-items-center gap-1">
       <i class="fa   fa-lg fa-unlock-alt" aria-hidden="true">Trancar</i>
        </span>
    </div>
    <?php endif; ?>


    <div class="col"></div>
</div>
<div class="row">
    <div class="col">
        <div class=""></div>
    </div>
</div>


 <div class="col-md-12">
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa fa-search"></i></span>
                        <input type="text" id="searchFarmacos" class="form-control" placeholder="Pesquisar fármacos...">
                    </div>
                </div>
<table id="listadosalunos"
class="display no-shadow table table-light container-fluid
display responsive nowrap"
    style="width:100%">
    <thead>
        <tr style="background-color:rgba(79, 201, 140, 0.603);border-block-color:rgba(0,0,0,0.128)" id="primeraLinha">
            <th rowspan="2" class="coluna2">Nr</th>
            <th rowspan="2" class="coluna2">Nome</th>
            <th rowspan="2"class="coluna2">Sexo</th>


            <?php $__currentLoopData = $classe_disciplinas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $classe_disciplinasItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<?php

$size=collect($divisoes)->where('divisao_id', '<>', 9000);
 $array=["NA","NE"];

?>
                <th colspan="<?php echo e(count($size)+1); ?>"><?php echo e($classe_disciplinasItem->disciplina->Descricao); ?>



                    <span class="color:#fff; font-size:9px;">
   ( <?php echo e($classe_disciplinasItem->disciplina->Sigla); ?>  )
</span>
        </th>

            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <th rowspan="2">MA</th>
            <th rowspan="2">Resultado</th>

        </tr>

        <tr style="background-color:rgba(79, 201, 140, 0.603);border-block-color:rgba(0,0,0,0.128)" id="SegundaLinha">
            <?php $__currentLoopData = $classe_disciplinas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $keyC => $classe_disciplinasItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php $__currentLoopData = collect($divisoes)->where('divisao_id', '<>', 9000); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $divisoesItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>


                    <th class="coluna2">
                    <?php echo e($divisoesItem->divisao==900?"NE":"NA"); ?>


                    </th>


                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<th class="coluna2">MF</th>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tr>
    </thead>

    <tbody>


        <?php $__currentLoopData = $coleccaoalunos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $itemI): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php $x = 3; ?>

            <tr id="<?php echo e($key + 1); ?>" dadosNota="<?php echo e($itemI['id']); ?>"   data-id="<?php echo e($itemI['id']); ?>">
                <td id="<?php echo e($key + 1); ?>" linha="<?php echo e($key); ?>" coluna="0"><?php echo e($key + 1); ?></td>
                <td linha="<?php echo e($key); ?>" coluna="1" style="width:300px"><?php echo e($itemI['nome']); ?></td>
                <td linha="<?php echo e($key); ?>" coluna="2"><?php echo e($itemI['sexo']); ?></td>

                <?php $__currentLoopData = $itemI['disciplina']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key0 => $disciplina): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                    <?php $__currentLoopData = $disciplina['notas']->where("divisao_id","<>",9000); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key2 => $divisoesItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>


                    <td linha="<?php echo e($key); ?>"
                        coluna="<?php echo e($x); ?>"
                        divisaoid="<?php echo e($divisoesItem['divisao_id']); ?>"
                        <?php if( is_null($divisoesItem["chave1"])&& is_null($divisoesItem["chave2"])&&$edicaoativa): ?>

                        <?php if($array[$key2]!="NA"): ?>
                         flag="editalvel"
  contenteditable="true"
                         class="colunaEditavel colunaEditavelcolunaEditavel"
                         <?php endif; ?>
<?php endif; ?>
                            posicao="<?php echo e($key); ?><?php echo e($x); ?>posicao"

                            disciplina="<?php echo e($disciplina['disciplina_id']); ?>"
                            NFinfo="<?php echo e($divisoesItem['NT']); ?>"
                            title="<?php echo e($divisoesItem['divisao'] . 'NFDisp' . $disciplina['disciplina_id'] . 'linha' . $key); ?>"
formula="<?php echo e($formunlamendia->where("TipoMedia",1)->first()->formula ?? ''); ?>"

<?php echo e($divisoesItem['divisao']); ?>="<?php echo e($divisoesItem['NT']); ?> "

NT="<?php echo e($array[$key2]); ?>"


                              >
                           <?php echo e($divisoesItem['NT']); ?>





                        </td>



                        <?php if($key == 0): ?>
                        <?php endif; ?>

                        <?php $x = $x + 1; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>



                    <td linha="<?php echo e($key); ?>" coluna="<?php echo e($x); ?>"
                    id="<?php echo e($key); ?><?php echo e($disciplina['disciplina_id']); ?>"
                        style="background-color:rgba(0,0,0,0.128)"
                        mediaT="<?php echo e($disciplina['disciplina_id']); ?>MT<?php echo e($key); ?>"
  disciplina="<?php echo e($disciplina['disciplina_id']); ?>"
                        area="<?php echo e($disciplina["area"]); ?>"
                        siglaDisp="<?php echo e($disciplina["sigla"]); ?>"
                        divisao_id="<?php echo e($disciplina['notas']->where('divisao_id', '=', 9000)->first()['divisao_id']); ?>"
                        >

						<?php echo e(optional($disciplina['notas']->where('divisao_id', '=', 9000)->first())['NT'] ?? ''); ?>


                    </td>
                    <?php $x = $x + 1; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>



                <td id="<?php echo e($key); ?>linha" linha="<?php echo e($key); ?>linha" coluna="<?php echo e($x); ?>"
    FormulaMediaFinal="<?php echo e($itemI['MediaFormulaAnual']); ?>">
    <?php echo e(optional($mediasanual->
    where('aluno_classe_id', $itemI['id'])
   -> where('MediaTempo',4)
    ->first())->valor ?? ''); ?>

</td>
                <?php $x = $x + 1; ?>
                <td linha="<?php echo e($key); ?>" coluna="<?php echo e($x); ?>"></td>
            </tr>


        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
</table>







<div class="card">

    <div class="card-footer">

        <button class="btn btn-primary float-right NotasPautaCaregar">

            <i class="fa fa-cloud-upload" aria-hidden="true">Caregar</i>
        </button>

    </div>
</div>

<?php echo $__env->make("registoAcademico.notas.modals", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<script src="<?php echo e(asset('Admin-LTE/plugins/jquery/jquery.min.js')); ?>"></script>



    <script src="<?php echo e(asset('Admin-LTE/plugins/bootstrap/js/bootstrap.bundle.min.js')); ?>"></script>
    <script src="<?php echo e(asset('Admin-LTE/plugins/datatables/dataTables.bootstrap4.js')); ?>"></script>
    <script src="<?php echo e(asset('Datatable/js/jquery.dataTables.min.js')); ?>"></script>


<script src="<?php echo e(asset('Admin-LTE/plugins/jquery/jquery.min.js')); ?>"></script>



    <script src="<?php echo e(asset('Admin-LTE/plugins/bootstrap/js/bootstrap.bundle.min.js')); ?>"></script>
    <script src="<?php echo e(asset('Admin-LTE/plugins/datatables/dataTables.bootstrap4.js')); ?>"></script>
    <script src="<?php echo e(asset('Datatable/js/jquery.dataTables.min.js')); ?>"></script>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script src="https://cdn.datatables.net/fixedheader/3.4.0/js/dataTables.fixedHeader.min.js"></script>
<script src="https://cdn.datatables.net/fixedcolumns/4.3.0/js/dataTables.fixedColumns.min.js"></script>

    <style>
        #listadosalunos_filter {
            display: none;
        }
    </style>



<script src="<?php echo e(asset('MyJs/math.js')); ?>"></script>


<script src="<?php echo e(asset('MyJs/notastodastrimestral.js')); ?>"></script>

<script>


    // Botão para trancar selecionados

   window.urlmedia = '<?php echo e(route("notas.guardarmedia2")); ?>';
    // window.rotaDadosTable = '<?php echo e(route("notas.dadosTable")); ?>"';
window.urlTrancar = '<?php echo e(route("notas.trancar")); ?>';
window.urldadosTable = '<?php echo e(route("notas.dadosTablepauta")); ?>';
window.precistirbanco = '<?php echo e(route("notas.precistirbancoExame")); ?>';
 window.vriavelFormulaMedia=1;
 window.classturma=<?php echo json_encode($classturma, 15, 512) ?>;
 window.flag=0;
 window.tipoMedia=4;
   $idalunos=<?php echo json_encode($coleccaoalunos, 15, 512) ?>;
    window.arrayElementos=[];
 _token='<?php echo e(csrf_token()); ?>'
    window.classe_disciplinas=<?php echo json_encode($classe_disciplinas, 15, 512) ?>;
   window.trimestre=<?php echo json_encode($divisoes, 15, 512) ?>;
console.log("trimestres",window.trimestre);
   turma=<?php echo json_encode($turma, 15, 512) ?>;


$(document).ready(function() {
    $('#criarFormulaMedia').on('shown.bs.modal', function () {
        $("[name='formmulacriadaParamedia']").focus();
    });
});



function uploadExcel(files) {

    if (files.length === 0) return;

    let formData = new FormData();
    formData.append('file', files[0]);

    let tableData = $tabelatrimestral.rows().data().toArray();

    formData.append('tableData', JSON.stringify(tableData));
    formData.append('Inicio', 9);

    $.ajax({
        url:window.urldadosTable,
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        headers: {
            'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
        },

        beforeSend: function () {

            $("#btnImportar").prop("disabled", true).html(`
                <span class="spinner-border spinner-border-sm"></span>
                Importando Excel...
            `);

        },

        success: function(response) {

            if (!response.dados || !Array.isArray(response.dados)) {

                Swal.fire('Erro', 'Resposta inválida do servidor', 'error');
                return;

            }

            let dadosSalvar = [];

            $tabelatrimestral.rows().every(function (rowIdx) {

                const novaData = response.dados[rowIdx];

                if(!novaData) return;

                this.data(novaData).invalidate();

                let linha = $(this.node());

                let idAluno = linha.attr('dadosnota');

                dadosSalvar.push({
                    idAluno: idAluno,
                    dados: organisarArraySava(linha)
                });

            });

            $tabelatrimestral.draw(false);

            //salvarTudoEmLote(dadosSalvar);
            validarcelulas();


        },

        complete: function () {

            $("#btnImportar").prop("disabled", false).html(`
                <i class="fas fa-file-import"></i> Importar Excel
            `);

        },

        error: function(xhr) {

            Swal.fire({
                icon: 'error',
                title: 'Erro ao importar',
                text: xhr.responseJSON?.message || 'Algo deu errado'
            });

        }

    });

}






$(document).on('click', ".NotasPautaCaregar", function () {

    $tabelatrimestral.rows().every(function () {

        let tr = $(this.node()); // este já é o <tr>

        precistirBD(tr);

    });

});



function validarcelulas(){
     let erros = 0;

    $('#listadosalunos tbody tr').each(function () {

        let $cells = $(this).find('td');
        let totalCols = $cells.length;

        // da 4ª coluna até a penúltima
        for (let i = 3; i < totalCols - 1; i++) {

            let $cell = $cells.eq(i);
            let valor = parseFloat($cell.text().trim());

            // limpar erro anterior
            $cell.removeClass('erro-nota');

            // validar nota
            if (isNaN(valor) || valor < 0 || valor > 20) {

                $cell.addClass('erro-nota');
                erros++;

            }

        }
    });

    // mostrar alerta se existir erro
    if (erros > 0) {

   Swal.fire({
    icon: 'warning',
    title: "⚠️ Precisa revisar a tua pauta.",
    text: "Existem células destacadas a vermelho com notas inválidas (0 a 20). Por favor corrija e volte a carregar.",
    showConfirmButton: true
});


        return false;
    }
    else{
         Swal.fire({
                icon: 'success',
                title: 'Importação concluída! clque botao caregar  para guardar',

                showConfirmButton: true
            });

    }
}



function precistirBD(tr){


    let dados = $tabelatrimestral.row(tr).data();


    console.log(tr, window.classe_disciplinas, window.trimestre);

    let idAluno = tr.attr('dadosnota');

    console.log("id dados", idAluno);

    let formData = new FormData();

    let liAtivo = document.querySelector(".turmaselecionada.active");

    formData.append('rowData', JSON.stringify(dados));
    formData.append('disciplina', JSON.stringify(window.classe_disciplinas));
    formData.append('trimeste', JSON.stringify(window.trimestre));
    formData.append('turma', liAtivo.id);
    formData.append('idAluno', idAluno);

    $.ajax({
        url: window.precistirbanco,
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        headers: {
            'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
        },
        success:function(dados){
            console.log(dados);
        }
    });

}

</script>
<?php /**PATH C:\laragon\www\escola2025\resources\views/registoAcademico/notas/notas-PautaExame.blade.php ENDPATH**/ ?>