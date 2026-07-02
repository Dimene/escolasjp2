<?php
$dadosInfo = session()->get('nomeEm');
$avatar = session()->get('infosession')->avatar;
?>


<?php $__env->startSection('title', 'Pagina Inicial'); ?>

<?php $__env->startSection('content'); ?>

<section class="content">
    <div class="">
        <!-- Content Header -->
  <div class="breadcrumb-modern animate-fadeInUp">
        <ol class="breadcrumb" style="background: transparent; margin: 0; padding: 0;">
             <li class="breadcrumb-item">
                <a href="#"><i class="fa fa-graduation-cap"></i> Registo Académico</a>
            </li>
            <li class="breadcrumb-item">

                <a href="#"><i class="fa fa-book"></i> Gestão Notas</a>
            </li>

            <li class="breadcrumb-item active">
                <i class="fa fa-cogs"></i> <b>Configuração Trimestre</b>
            </li>
        </ol>
    </div>

        <!-- Main content -->
        <div class="container-fluid">
            <div class="row">
                <!-- Card Ano Lectivo -->
                <div class="col-md-12">
                    <div class="card shadow-sm">
                        <div class="card-body p-0">


                            <div class="row">
                            <div class="form-group col">
                                <label for="anolectivo">Selecione o ano lectivo</label>
                                <select class="form-control controledeclasseano" name="anolectivo" id="anolectivo">
                                    <?php $__currentLoopData = $anolectivo; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ano): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($ano->id); ?>"   <?php if($ano->anolectivo ==carbon\Carbon::now()->format("Y")): ?> selected=true <?php endif; ?>>
                                            <?php echo e($ano->anolectivo); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>

</div>
<div class="form-group col">
                                <label for="classe">Selecione  a classe</label>
                                <select class="form-control controledeclasseano" name="classe" id="classe">
                                    <?php $__currentLoopData = $classe; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $classItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($classItem->id); ?>"  >
                                            <?php echo e($classItem->Descricao); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>

</div>
                            </div>

                                <!-- Barra de progresso -->
<div class="progress mt-3" style="height: 25px; display:none" >
  <div id="progressBar" class="progress-bar progress-bar-striped progress-bar-animated"
       role="progressbar" style="width: 0%">
    0%
  </div>
</div>

                        </div>
                    </div>
                </div>


            <div class="conteudopainelConfiguracoes row">
            </div>


</section>

<script>

$(document).ready(function(){
    let ano = $("[name='anolectivo']").val();
    let classe = $("[name='classe']").val();
    getpainelConfiguracoes(ano,classe);
});

$(document).on("change", ".controledeclasseano", function() {
   let ano = $("[name='anolectivo']").val();
    let classe = $("[name='classe']").val();
    getpainelConfiguracoes(ano,classe);
});






// Função que chama painel de controle de cada ano
function getpainelConfiguracoes(ano,classe){
    let urlBase = "<?php echo e(route('notas.ConfiguracoesTrimestraisano', [':ano' ,':classe'])); ?>";
    // encadeando os replaces
    let url = urlBase.replace(':ano', ano).replace(':classe', classe);



    $("#progressBar").css("width", "0%").text("0%");
    $(".progress").show();

    $.ajax({
        url: url,
        xhr: function() {
            let xhr = new window.XMLHttpRequest();
            xhr.addEventListener("progress", function(evt) {
                if (evt.lengthComputable) {
                    let percentComplete = Math.round((evt.loaded / evt.total) * 100);
                    $("#progressBar").css("width", percentComplete + "%").text(percentComplete + "%");
                }
            }, false);
            return xhr;
        },
        beforeSend: function() {
            $("#progressBar").addClass("progress-bar-striped progress-bar-animated");
        },
        success: function(arg) {
            $(".conteudopainelConfiguracoes").html(arg);
            $("#progressBar").removeClass("progress-bar-animated").css("width", "100%").text("Concluído");
        },
        error: function() {
            $("#progressBar").removeClass("progress-bar-animated bg-success")
                             .addClass("bg-danger")
                             .css("width", "100%")
                             .text("Erro");
        },
        complete: function() {
            setTimeout(function() {
                $(".progress").fadeOut("slow");
            }, 1000);
        }
    });
}





    // trancar e destrancar o trimetre
$(document).on("click",".btn-fecharTrimestre",function(){

if ($(this).hasClass("fa-lock")) {
      // Se está fechado, troca para aberto
      $(this).removeClass("fa-lock").addClass("fa-unlock");
    } else {
      // Se está aberto, troca para fechado
      $(this).removeClass("fa-unlock").addClass("fa-lock");
    }


})



// tornar visivel esconder


$(document).on("click",".btn-mostrarTrimestre",function(){
let icon = $(this);

    if (icon.hasClass("fa-eye")) {
      // Se está mostrando, troca para ocultar
      icon.removeClass("fa-eye").addClass("fa-eye-slash");

    } else {
      // Se está ocultando, troca para mostrar
      icon.removeClass("fa-eye-slash").addClass("fa-eye");

    }





})





$(document).on('click', '.btngravaralteracoesTrimestres', function () {
    let resultado = [];

    $('.list-group-item').each(function () {
        let trimestreNome = $(this).attr("id"); // pega o texto do trimestre
        let lockIcon = $(this).find('.fa-lock, .fa-unlock'); // verifica lock/unlock
        let eyeIcon = $(this).find('.fa-eye-slash,.fa-eye'); // verifica olho

        // LOCK: 1 se for lock, 0 se for unlock
        let lockValue = lockIcon.hasClass('fa-lock') ? 1 :null;

        // EYE: 1 se tiver classe ativa, 0 caso contrário
        let eyeValue = eyeIcon.hasClass('fa-eye') ? null :1;

        // monta o array tridimensional
        resultado.push({
            trimestre: trimestreNome,
            LOCK: lockValue,
            EYE: eyeValue
        });
    });

    console.log(resultado);




      // Enviar via AJAX para Laravel
    $.ajax({
        url: "<?php echo e(route('notas.TrancarTrimestreAll')); ?>", // rota nomeada
        type: "POST",
        data: {
            _token: "<?php echo e(csrf_token()); ?>", // token CSRF obrigatório
            dadosTrimestre:resultado,
            anolectivo:$("[name=anolectivo]").val(),
        classe:$("[name=classe]").val(),

        },
        success: function (response) {
            Swal.fire({
                icon: 'success',
                title: 'Sucesso',
                text: 'Trimestres atualizados com sucesso!'
            });
        },
        error: function (xhr) {
            Swal.fire({
                icon: 'error',
                title: 'Erro',
                text: 'Não foi possível salvar as alterações.'
            });
        }
    });

});
</script>






<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin-Lti', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\escola2025\resources\views/registoAcademico/notas/PainelControlNotas.blade.php ENDPATH**/ ?>