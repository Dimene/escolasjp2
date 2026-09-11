<?php
$dadosInfo = session()->get('nomeEm');
$avatar = session()->get('infosession')->avatar ?? null;
?>


<?php $__env->startSection('title', 'Pagina Inicial'); ?>

<?php $__env->startSection('content'); ?>

<style>
    .botoesParacertificado {
        margin-bottom: 3px;
    }

    .badege {
        margin: 5px;
        padding: 10px 15px;
        cursor: pointer;
        border: none;
        background-color: #007bff;
        color: white;
        border-radius: 5px;
    }

    .badege:hover {
        background-color: #0056b3;
    }

    .conteudopainelConfiguracoes, .conteudoNotas {
        display: flex;
        justify-content: center;
        align-items: flex-start;
        min-height: 500px;
        max-height: 300px;
        width: 100%;
        border: 1px solid #ccc;
        border-radius: 8px;
        background-color: #f9f9f9;
        font-size: 16px;
        padding: 15px;
        overflow-y: auto;
    }

    /* Estilos para impressão */
    @media print {
        .no-print {
            display: none !important;
        }

        .btn, .btn-group, .botoesParacertificado,
        .card-header, .progress, .form-group,
        .breadcrumb, .content-header, .card,
        .col-md-12, .row > .form-group {
            display: none !important;
        }

        .conteudoNotas, .conteudopainelConfiguracoes {
            display: block !important;
            margin: 0 !important;
            padding: 0 !important;
            border: none !important;
            max-height: none !important;
            overflow: visible !important;
            box-shadow: none !important;
        }

        body {
            margin: 0;
            padding: 20px;
            background: white;
        }

        @page {
            size: A4;
            margin: 2cm;
        }
    }
</style>

<style>
/* Estilos personalizados para os botões */
.btn-group {
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    border-radius: 8px;
    overflow: hidden;
}

.btn {
    padding: 10px 20px;
    font-weight: 500;
    transition: all 0.3s ease;
    border-radius: 0;
}

.btn:first-child {
    border-top-left-radius: 8px;
    border-bottom-left-radius: 8px;
}

.btn:last-child {
    border-top-right-radius: 8px;
    border-bottom-right-radius: 8px;
}

.btn-outline-secondary {
    border: 1px solid #dee2e6;
    background: white;
    color: #6c757d;
}

.btn-outline-secondary:hover {
    background: #f8f9fa;
    border-color: #adb5bd;
    color: #495057;
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.btn-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    color: white;
}

.btn-primary:hover {
    background: linear-gradient(135deg, #5a67d8 0%, #6b46a0 100%);
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
}

.btn-success {
    background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
    border: none;
    color: white;
}

.btn-success:hover {
    background: linear-gradient(135deg, #38a169 0%, #2f855a 100%);
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(72, 187, 120, 0.4);
}

/* Ícones */
.btn i {
    font-size: 1rem;
    transition: transform 0.2s ease;
}

.btn:hover i {
    transform: scale(1.1);
}

/* Responsividade */
@media (max-width: 768px) {
    .d-flex {
        flex-direction: column;
        gap: 10px !important;
    }

    .btn-group {
        width: 100%;
    }

    .btn {
        flex: 1;
        text-align: center;
        padding: 8px 16px;
    }

    .btn i {
        font-size: 0.9rem;
    }
}

/* Efeito de clique */
.btn:active {
    transform: translateY(0);
    transition: transform 0.05s ease;
}

/* Animações */
@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.05); }
    100% { transform: scale(1); }
}

.btn-imprimir:active, .btn-download:active {
    animation: pulse 0.3s ease;
}
</style>
  <div class="breadcrumb-modern animate-fadeInUp">

        <ol class="breadcrumb" style="background: transparent; margin: 0; padding: 0;">
             <li class="breadcrumb-item">
                <a href="#"><i class="fa fa-graduation-cap"></i> Registo Académico</a>
            </li>
            <li class="breadcrumb-item">
                <a href="#"><i class="fa fa-book"></i> Gestão Notas</a>
            </li>

            <li class="breadcrumb-item active">
                <i class="fa fa-folder"></i> <b>Declarações e Certificados</b>
            </li>
        </ol>
    </div>
<section class="content">
    <div class="">


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
                                            <option value="<?php echo e($ano->id); ?>" <?php if($ano->anolectivo == Carbon\Carbon::now()->format("Y")): ?> selected <?php endif; ?>>
                                                <?php echo e($ano->anolectivo); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                                <div class="form-group col">
                                    <label for="classe">Selecione a classe</label>
                                    <select class="form-control controledeclasseano" name="classe" id="classe">
                                        <?php $__currentLoopData = $classe; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $classItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($classItem->id); ?>">
                                                <?php echo e($classItem->Descricao); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                                <div class="form-group col">
                                    <label for="classe">Selecione Tipo de Documento</label>
                                    <select class="form-control ControleTrimestre" name="Trimestres" id="Trimestres">
                                    </select>
                                </div>
                            </div>

                            <!-- Barra de progresso -->
                            <div class="progress mt-3" style="height: 25px; display:none">
                                <div id="progressBar" class="progress-bar progress-bar-striped progress-bar-animated"
                                     role="progressbar" style="width: 0%">
                                    0%
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="botoesParacertificado col-12" style="display: none">
                    <div class="card col-12">
                        <div class="card-header border-0 bg-transparent">
                            <div class="d-flex flex-wrap gap-2 align-items-center justify-content-between">
                                <div class="btn-group" role="group">
                                    <button class="btn btn-outline-secondary btn-voltar voltar" type="button">
                                        <i class="fa fa-arrow-left me-2"></i>
                                        <span>Voltar</span>
                                    </button>
                                </div>
                                <div class="btn-group" role="group">
                                    <button class="btn btn-primary btn-imprimir" type="button">
                                        <i class="fa fa-print me-2"></i>
                                        <span>Imprimir</span>
                                    </button>
                                    <button class="btn btn-success btn-download" type="button">
                                        <i class="fa fa-download me-2"></i>
                                        <span>Download</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="conteudopainelConfiguracoes col-12">
                    <!-- Conteúdo será inserido aqui -->
                </div>
                <div class="conteudoNotas col-12" id="conteudoNotas" style="display: none">
                    <!-- Conteúdo será inserido aqui -->
                </div>
            </div>
        </div>
    </div>
</section>

<?php $__env->startPush('script'); ?>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
let trimestres = <?php echo json_encode($trimestres, 15, 512) ?>;
let classeGet = <?php echo json_encode($classe, 15, 512) ?>;

$(document).ready(function () {
    let ano = $("[name='anolectivo']").val();
    let classe = $("[name='classe']").val();

    montarTrimestres(ano, classe);

    setTimeout(() => {
        let tipoDoc = $(".ControleTrimestre").val();
        getpainelAlunos(ano, classe, tipoDoc);
    }, 50);
});

// ==================== EVENTOS SELECT ====================
$(document).on("change", ".controledeclasseano", function () {
    let ano = $("[name='anolectivo']").val();
    let classe = $("[name='classe']").val();

    montarTrimestres(ano, classe);

    let tipoDoc = $(".ControleTrimestre").val();
    getpainelAlunos(ano, classe, tipoDoc);
});

$(document).on("change", ".ControleTrimestre", function () {
    let ano = $("[name='anolectivo']").val();
    let classe = $("[name='classe']").val();
    let tipoDoc = $(this).val();

    getpainelAlunos(ano, classe, tipoDoc);
});

// ==================== IMPRIMIR ====================
$(document).on("click", ".btn-imprimir", function () {
    if (!$(".conteudoNotas").html().trim()) {
        Swal.fire("Aviso", "Nenhum documento carregado!", "warning");
        return;
    }

    imprimirDiv("conteudoNotas");
});

// ==================== DOWNLOAD ====================
$(document).on("click", ".btn-download", function () {
    if (!$(".conteudoNotas").html().trim()) {
        Swal.fire("Aviso", "Nenhum documento carregado!", "warning");
        return;
    }

    downloadConteudo("conteudoNotas");
});

// ==================== VOLTAR ====================
$(document).on("click", ".btn-voltar", function () {
    $(".conteudopainelConfiguracoes").fadeIn();
    $(".conteudoNotas").hide().empty();
    $(".botoesParacertificado").hide();
});

// ==================== GERAR DOCUMENTO ====================
$(document).on("click", ".botaoImpeimircertificado", function () {
    let idaluno = $(this).data("idaluno");
    let trimestre = $('[name="Trimestres"]').val();
    let classe = $('[name="classe"]').val();
    let anolectivo = $('[name="anolectivo"]').val();

    let urlBase = "<?php echo e(route('notas.declaracao', [':idaluno',':trimestre',':classe',':anolectivo'])); ?>";

    let url = urlBase
        .replace(':idaluno', idaluno)
        .replace(':trimestre', trimestre)
        .replace(':classe', classe)
        .replace(':anolectivo', anolectivo);

    $(".progress").show();
    $("#progressBar").css("width", "0%").text("0%");

    $.ajax({
        url: url,
        xhr: function () {
            let xhr = new XMLHttpRequest();
            xhr.addEventListener("progress", function (evt) {
                if (evt.lengthComputable) {
                    let percent = Math.round((evt.loaded / evt.total) * 100);
                    $("#progressBar").css("width", percent + "%").text(percent + "%");
                }
            });
            return xhr;
        },
        success: function (html) {
            if (!html.trim()) {
                Swal.fire("Aviso", "Documento vazio!", "warning");
                return;
            }

            $(".conteudopainelConfiguracoes").hide();
            $(".conteudoNotas").html(html).fadeIn();
            $(".botoesParacertificado").fadeIn();

            $("#progressBar").css("width", "100%").text("Concluído")
                .removeClass("bg-danger")
                .addClass("bg-success");
        },
        error: function () {
            $("#progressBar").addClass("bg-danger").text("Erro");
        },
        complete: function () {
            setTimeout(() => $(".progress").fadeOut(), 800);
        }
    });
});

// ==================== LISTA ALUNOS ====================
function getpainelAlunos(ano, classe, tipoDocu) {
    let urlBase = "<?php echo e(route('notas.ListadosAlunos', [':ano',':classe',':tipoDocu'])); ?>";

    let url = urlBase
        .replace(':ano', ano)
        .replace(':classe', classe)
        .replace(':tipoDocu', tipoDocu);

    $(".progress").show();

    $.get(url, function (html) {
        $(".conteudopainelConfiguracoes").html(html);
    }).always(() => {
        setTimeout(() => $(".progress").fadeOut(), 500);
    });
}

// ==================== TRIMESTRES ====================
function montarTrimestres(ano, classe) {

    const filtrados = trimestres.filter(e => Number(e.anolectivo_id) === Number(ano));
    let html = "";

    let classeDocumento = classeGet.filter(c => Number(c.id) === Number(classe));

    filtrados.forEach(e => {
        html += `<option value="${e.anomodelo_id}">
            Declaração de ${e.divisao} - ${e.anomodelos}
        </option>`;
    });

    if (classeDocumento.length > 0 && Number(classeDocumento[0].Exame) === 1) {
        html += `<option value="1000">Certificado</option>`;
    } else {
        html += `<option value="10000">Declaração Anual</option>`;
    }

    console.log(html);
    $(".ControleTrimestre").html(html);
}

// ==================== FUNÇÕES ====================

// IMPRIMIR
function imprimirDiv(id) {
    let conteudo = document.getElementById(id).innerHTML;

    let janela = window.open("", "_blank");

    janela.document.write(`
        <html>
        <head>
            <title>Impressão</title>
            <style>
                body { font-family: Arial; padding:20px; }
                table { width:100%; border-collapse: collapse; }
                th,td { border:1px solid #ccc; padding:8px; }
            </style>
        </head>
        <body>${conteudo}</body>
        </html>
    `);

    janela.document.close();
    janela.print();
}

// DOWNLOAD
function downloadConteudo(id) {
    let conteudo = document.getElementById(id).innerHTML;

    Swal.fire({
        title: 'Escolher formato',
        showDenyButton: true,
        confirmButtonText: 'HTML',
        denyButtonText: 'PDF'
    }).then((result) => {

        if (result.isConfirmed) {
            let blob = new Blob([conteudo], { type: 'text/html' });
            let a = document.createElement('a');
            a.href = URL.createObjectURL(blob);
            a.download = "documento.html";
            a.click();
        }

        if (result.isDenied) {
            imprimirDiv(id);
        }
    });
}


function imprimirDiv() {
    // pega o conteúdo da div
    let conteudo = document.getElementById("conteudoNotas").innerHTML;

    // abre nova janela
    let tela = window.open('', '', 'width=800,height=600');

    // escreve o conteúdo dentro da nova janela
    tela.document.write(`
        <html>
            <head>
                <title>Impressão</title>
                <style>
                    body {
                        font-family: Arial, sans-serif;
                        padding: 20px;
                    }
                </style>
            </head>
            <body>
                ${conteudo}
            </body>
        </html>
    `);

    tela.document.close();
    tela.print();

}
</script>

<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin-Lti', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\escolasaojoaopaulo\resources\views/registoAcademico/notas/PainelControlNotasDocumentos.blade.php ENDPATH**/ ?>