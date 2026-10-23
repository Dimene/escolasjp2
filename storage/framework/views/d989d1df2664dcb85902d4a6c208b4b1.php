<?php $__env->startSection('title', 'Lista de Alunos'); ?>
<?php $__env->startSection('content'); ?>

<link rel="stylesheet" href="jquery.dataTables.min.css"/>
<link rel="stylesheet" href="buttons.dataTables.min.css"/>

<!-- Content Wrapper. Contains page content -->
<div class="">
  <!-- Content Header (Page header) -->
 <div class="breadcrumb-modern animate-fadeInUp">
        <ol class="breadcrumb" style="background: transparent; margin: 0; padding: 0;">
             <li class="breadcrumb-item">
                <a href="#"><i class="fa fa-graduation-cap"></i> Registo Académico</a>
            </li>
            <li class="breadcrumb-item">
                <a href="#"><i class="fa fa-sitemap"></i> Gestão Turmas</a>
            </li>

            <li class="breadcrumb-item active">
                <i class="fa fa-plus-square"></i> <b>
                     <?php if($flag==1): ?>
                 Criação de Turma
                <?php else: ?>
                 Criação de Jurri
                <?php endif; ?>
                </b>
            </li>
        </ol>
    </div>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="card">
        <div class="card-header bg-primary">
          <div class="d-flex justify-content-between align-items-center">
            <h3 class="card-title">

                <?php if($flag==1): ?>
                Filtros para Criação de Turma
                <?php else: ?>
                  Filtros para Criação de Jurri
                <?php endif; ?>

            </h3>
            <button class="btn btn-sm btn-light" id="toggleDistribuicao">
              <i class="fas fa-sliders-h mr-1"></i> Opções de Distribuição
            </button>
          </div>
        </div>

        <div class="card-body">
          <div class="row">
            <div class="form-group col">
              <?php $anoCurente = "20".Date('y'); ?>
              <label for="anoselecionado">Selecione o Ano Lectivo</label>
              <select class="custom-select anoselecionado" name="anoselecionado" id="anoselecionado">
                <?php $__currentLoopData = $anoLectivo; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $anoLectivoItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($anoLectivoItem->id); ?>"
                  <?php if($anoLectivoItem->anolectivo == $anoCurente): ?> selected <?php endif; ?>>
                  <?php echo e($anoLectivoItem->anolectivo); ?>

                </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </select>
            </div>

            <div class="form-group col">
              <label for="classeSelecionada">Selecione a Classe</label>
              <select id="classeSelecionada" class="custom-select classeSelecionada" name="classeSelecionada">
                <?php $__currentLoopData = $classes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $classesItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($classesItem->id); ?>"><?php echo e($classesItem->Descricao); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </select>
            </div>

             <div class="form-group col areaDisciplinaDiv" style="display: none">
              <label for="labelareaDisciplina" class="labelareaDisciplina"> </label>
              <select id="areaDisciplina" class="custom-select areaDisciplina" name="areaDisciplina">

              </select>
            </div>

          </div>
        </div>
      </div>

      <!-- Floating Distribution Options Panel -->
      <div class="card shadow-lg " id="distribuicaoPanel" style="display: none; position: absolute; width: 70%; z-index: 1000; left: 20%;">
        <div class="card-header bg-info">
          <div class="d-flex justify-content-between align-items-center">
            <h3 class="card-title">Opções de Distribuição</h3>
            <button class="btn btn-sm btn-light" id="closeDistribuicao">
              <i class="fas fa-times"></i>
            </button>
          </div>
        </div>
        <div class="card-body ">
          <div class="row">
            <div class="form-group col-md-3">
              <label for="Quantidade">
                <?php if($flag==1): ?>
                Quantidade por Turma
                <?php else: ?>
                   Quantidade por Jurri
                <?php endif; ?>

              </label>
              <input type="number" class="form-control Quantidade" value="20">
            </div>

            <div class="form-group col-md-3">
              <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input por_idade" id="por_idade" value="1">
                <label class="custom-control-label" for="por_idade">Distribuir por idade</label>
              </div>
            </div>

            <div class="form-group col-md-3">
              <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input por_sexo" id="por_sexo" value="1">
                <label class="custom-control-label" for="por_sexo">Distribuir por sexo</label>
              </div>
            </div>

            <div class="form-group col-md-3">
              <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input por_Alfabeto" id="por_Alfabeto" value="1">
                <label class="custom-control-label" for="por_Alfabeto">Ordem alfabética</label>
              </div>
            </div>
          </div>

          <div class="row mt-3">

             <div class="col-md-6 text-left gerar_at_passadodiv">
                <?php if($flag==1): ?>
              <button class="btn btn-success gerar_at_passado " >
                <i class="fa fa-plus-circle"></i> Aplicar Distribuicao de ano anterior
              </button>
              <?php endif; ?>
            </div>
            <div class="col-md-6 text-right Gerar_turmadiv">
              <button class="btn btn-success Gerar_turma">
                <i class="fa fa-plus-circle"></i>

                <?php if($flag==1): ?>
                Aplicar e Criar Turma
                <?php else: ?>
                  Aplicar e Criar Jurri
                <?php endif; ?>
              </button>
            </div>
          </div>

<a href="#" id="baixarModelo"  class="btn btn-primary">
    Baixar modelo de importação
</a>




<button type="button" id="caregarExcel" class="btn btn-primary">
    <i class="fas fa-file-excel"></i> Carregar Excel
</button>


<input type="file" class="ficheiroTurmas" name="ficheiro"
       accept=".xlsx,.xls,.csv" style="display:none;">


<div id="overlayProcessamento"
     style="display:none; position:fixed; inset:0; background:rgba(0,0,0,.55);
            z-index:9999; align-items:center; justify-content:center;">
    <div style="background:#fff; padding:30px 40px; border-radius:12px;
                min-width:320px; text-align:center; box-shadow:0 8px 25px rgba(0,0,0,.3);">
        <div class="spinner-border text-primary mb-3" role="status"></div>
        <h5 id="progressoTexto">A processar...</h5>
        <div class="progress mt-3" style="height:10px;">
            <div id="progressoBarra" class="progress-bar" role="progressbar"
                 style="width:0%; transition:width .2s;"></div>
        </div>
    </div>
</div>


<div id="resultadoProcessamento" class="mt-4"></div>

        </div>
      </div>



          <div class="Tabelaalunosselecionadoasporanoclasses">
            <!-- Content will be loaded via AJAX -->
          </div>


    </div>
  </section>
</div>

<?php $__env->startPush('scripts'); ?>





<script>
    $('#baixarModelo').on('click', function (e) {
        e.preventDefault();

        let classe = $('.classeSelecionada').val();
        let anolectivo = $('.anoselecionado').val();

        if (!classe || !anolectivo) {
            alert('Seleccione a classe e o ano lectivo.');
            return;
        }

        let url = "<?php echo e(url('RegistoAcademico/turma/modelo/importacao')); ?>/"
            + encodeURIComponent(classe) + "/"
            + encodeURIComponent(anolectivo);

        window.location.href = url;
    });

 $(function () {

    // Abre o seletor de arquivo ao clicar no botão
    $("#caregarExcel").on("click", function (e) {
        e.preventDefault();
        $(".ficheiroTurmas").trigger("click");
    });

    // Ao selecionar o ficheiro → envia via AJAX
    $(".ficheiroTurmas").on("change", function () {

        if (!this.files || this.files.length === 0) return;

        let formData = new FormData();
        formData.append("ficheiro", this.files[0]);
        formData.append("flag", <?php echo json_encode($flag, 15, 512) ?>);

        // Mostra o overlay de processamento
        $("#overlayProcessamento").fadeIn(150);
        $("#progressoTexto").text("A enviar ficheiro...");
        $("#progressoBarra").css("width", "10%");

        $.ajax({
            url: "<?php echo e(route('turma.importarTurmas')); ?>",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                "Accept": "application/json"
            },
            xhr: function () {
                let xhr = new window.XMLHttpRequest();
                // Progresso do upload
                xhr.upload.addEventListener("progress", function (evt) {
                    if (evt.lengthComputable) {
                        let pct = Math.round((evt.loaded / evt.total) * 50); // 0–50%
                        $("#progressoBarra").css("width", pct + "%");
                        $("#progressoTexto").text("A enviar: " + pct * 2 + "%");
                    }
                }, false);
                return xhr;
            },
            success: function (res) {
                $("#progressoBarra").css("width", "100%");
                $("#progressoTexto").text("Concluído ✔");

                if (res.html) {
                    $(".Tabelaalunosselecionadoasporanoclasses").html(res.html);
                    $("#resultadoProcessamento").empty();
                }

                // Esconde o overlay após 800ms
                setTimeout(function () {
                    $("#overlayProcessamento").fadeOut(150);
                }, 800);
            },
            error: function (xhr) {
                $("#progressoBarra").css("width", "100%").css("background", "#dc3545");
                let msg = "Erro ao processar o ficheiro.";
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    msg = xhr.responseJSON.message;
                } else if (xhr.responseJSON && xhr.responseJSON.errors && xhr.responseJSON.errors.ficheiro) {
                    msg = xhr.responseJSON.errors.ficheiro[0];
                }
                $("#progressoTexto").text(msg);
                $(".Tabelaalunosselecionadoasporanoclasses").html(
                    '<div class="alert alert-danger mt-3" role="alert"></div>'
                ).find(".alert").text(msg);

                setTimeout(function () {
                    $("#overlayProcessamento").fadeOut(150);
                    $("#progressoBarra").css("background", "#0d6efd");
                }, 2000);
            }
        });

        // Limpa o input para permitir o mesmo ficheiro novamente
        $(this).val("");
    });
});
</script>
<script>

let flag=<?php echo json_encode($flag, 15, 512) ?>;
let classes=<?php echo json_encode($classes, 15, 512) ?>;



$(document).ready(function(){



 console.log("flag",flag);

 if(Number(flag)===2){
    ArreaDisciplimaJurri()
 }




desablitarButao();



  // Initialize with data
  buscar_Dados();

  // Event listeners for filters
  $("#anoselecionado, .classeSelecionada").change(function(){
    ArreaDisciplimaJurri();

     if ( $.fn.DataTable.isDataTable('.listadosalunosTurma') ) {
    $('.listadosalunosTurma').DataTable().destroy();
}
    buscar_Dados();
  });

  // Toggle distribution panel
  $("#toggleDistribuicao").click(function(){
    $("#distribuicaoPanel").fadeIn();
    desablitarButao();
  });

  // Close distribution panel
  $("#closeDistribuicao").click(function(){
    $("#distribuicaoPanel").fadeOut();
  });

  // Close when clicking outside
  $(document).mouseup(function(e) {
    var container = $("#distribuicaoPanel");
    if (!container.is(e.target) && container.has(e.target).length === 0) {
      container.fadeOut();
    }
  });

  $(".passarparaturma").click(function(){
    if($("[name='alunoClasse']").is(":checked")) {
      if(confirm('Tem certeza que deseja adicionar os alunos selecionados à turma?')) {
        addicionaraturma();
      }
    } else {
      alert('Atenção: Selecione alunos para adicionar à turma.');
    }
  });
});

function buscar_Dados() {
  var ano = $(".anoselecionado").val();
  var classe = $(".classeSelecionada").val();
  var classe = $(".classeSelecionada").val();
  var areaDisciplina = $(".areaDisciplina").val();
  var url = "/RegistoAcademico/alunosporanoselecionados/"+ano+"/"+classe+"/"+flag+"/"+areaDisciplina;

  $.ajax({
    url: url,
    type: 'GET',
    beforeSend: function() {
      $(".Tabelaalunosselecionadoasporanoclasses").html(
        '<div class="text-center">' +
        '<p>Carregando dados...</p>' +
        '</div>'
      );
    },
    success: function(data) {
      $(".Tabelaalunosselecionadoasporanoclasses").html(data);
    },
    error: function() {
      $(".Tabelaalunosselecionadoasporanoclasses").html(
        '<div class="alert alert-danger">Erro ao carregar dados. Por favor, tente novamente.</div>'
      );
    }
  });
}




function desablitarButao(){

if($(".classeSelecionada").val()<2){

    $(".gerar_at_passadodiv").hide();
$(".Gerar_turmadiv").removeClass('col-md-6');
$(".Gerar_turmadiv").addClass('col-md-12');
}
else{
     $(".gerar_at_passadodiv").show();

}
}


function ArreaDisciplimaJurri() {
 classid=$("#classeSelecionada").val();

    const selecionado = classes.find(e => Number(e.id) === Number(classid));

    // console.log(selecionado,disciplinas);
    console.log(selecionado,selecionado.disciplinas);
    if (!selecionado) return;

    $(".areaDisciplinaDiv").show();

    let areaDisciplina = "";

    const tipo = Number(selecionado.FormaTrasitar_id);

    if (tipo === 2) {

        areaDisciplina += `
            <option value="1">Ciencias</option>
            <option value="2">Letras</option>
        `;

        $(".labelareaDisciplina").text("Selecione uma secção");

    } else if (tipo === 3) {

        $(".labelareaDisciplina").text("Selecione a disciplina");

        selecionado.disciplinas.forEach(element => {
            areaDisciplina += `<option value="${element.id}">${element.Descricao}</option>`;
             //console.log(element);
        });


    } else {
        $(".areaDisciplinaDiv").hide();
    }
//  console.log("kgfklgfklgfklgfklgf");
    $(".areaDisciplina").html(areaDisciplina);
}

</script>
<?php $__env->stopPush(); ?>

<style>
  #distribuicaoPanel {
    box-shadow: 0 0 20px rgba(0,0,0,0.2);
    border-radius: 5px;
    top: 150px;
  }
</style>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin-Lti', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\escolasaojoaopaulo\resources\views/registoAcademico/criarTurma.blade.php ENDPATH**/ ?>