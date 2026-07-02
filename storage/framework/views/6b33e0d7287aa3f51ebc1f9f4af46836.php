<?php $__env->startSection('title', 'Lista de Alunos'); ?>
<?php $__env->startSection('content'); ?>

<?php
    $request = Request();
$host = $request->getHost();
$subdomain = explode('.', $host)[0];

?>

<!-- ============================================ -->
<!-- BREADCRUMB -->
<!-- ============================================ -->
<div class="breadcrumb-modern animate-fadeInUp">
    <ol class="breadcrumb" style="background: transparent; margin: 0; padding: 0;">
        <li class="breadcrumb-item">
            <a href="#"><i class="fa fa-graduation-cap"></i> Registo Académico</a>
        </li>
        <li class="breadcrumb-item">
            <a href="#"><i class="fa fa-users"></i> Matrícula</a>
        </li>
        <li class="breadcrumb-item active">
            <i class="fa fa-eye"></i> <b>Alunos Inscritos</b>
        </li>
    </ol>
</div>

<!-- ============================================ -->
<!-- CONTEÚDO PRINCIPAL -->
<!-- ============================================ -->
<div class="">
    <!-- Content Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2"></div>
        </div>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            <!-- Selectores Ano/Classe -->
            <div class="card card-primary card-outline diviConteudoselectordadosAnoClasse">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="selectAno"><i class="fa fa-calendar"></i> Ano Lectivo</label>
                                <select id="selectAno" class="form-control selectAno" name="ano">
                                    <?php for($x = 0; $x < count($anos); $x++): ?>
                                        <option value="<?php echo e($anos[count($anos) - 1 - $x]->id); ?>">
                                            📅 <?php echo e($anos[count($anos) - 1 - $x]->anolectivo); ?>

                                        </option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="selectClasse"><i class="fa fa-chalkboard"></i> Classe</label>
                                <select id="selectClasse" class="form-control selectClasse" name="classe">
                                    <?php $__currentLoopData = $claases; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $claasesItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($claasesItem->id); ?>">📚 <?php echo e($claasesItem->Descricao); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Conteúdo 1: Tabela de Alunos com Abas (visível inicialmente) -->
            <section class="Conteudotabela1" id="conteudoTabela1">
                <div class="container-fluid">
                    <div class="Tabela-de-mes"></div>
                    <div class="Dados-upload"></div>
                    <div class="DadosAlunoConteudo ">
<button class="btn-voltar btn btn-primary rounded-circle" style="display: none">
    <i class="fas fa-caret-left"></i>
</button>

                        <div class="DadosAlunoBody">
                        </div>

                    </div>
                </div>
            </section>

            <!-- Conteúdo 2: Área de Upload (inicialmente oculta) -->
            <section class="content Conteudotabela2" id="conteudoTabela2" style="display: none;">
                <div class="container-fluid">
                    <div class="card">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0"><i class="fa fa-file-excel"></i> Dados Importados da Planilha</h5>
                        </div>
                        <div class="card-body dadostabelaupload">
                            <!-- Os dados da tabela serão inseridos aqui via AJAX -->
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </section>
</div>

<!-- ============================================ -->
<!-- MODAL DE UPLOAD -->
<!-- ============================================ -->
<div class="modal fade" id="modalUploadAlunos" tabindex="-1" role="dialog" aria-labelledby="modalUploadAlunosLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalUploadAlunosLabel">
                    <i class="fa fa-upload"></i> Importar Alunos via Planilha Excel
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="container-fluid">
                    <!-- Área para exibir mensagens de resultado -->
                    <div id="importResult" class="alert" style="display: none;"></div>

                    <div class="row justify-content-end align-items-center mb-3">
                        <div class="col-auto">
                            <a href="" class="btn btn-outline-success UrlDownload">
                                <i class="fa fa-file-excel-o"></i> Download Modelo
                            </a>
                        </div>
                    </div>

                    <div class="row justify-content-center">
                        <div class="col-md-12">
                            <form id="uploadForm" enctype="multipart/form-data">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="ano_lectivo" id="anoLectivoInput" value="">

                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="custom-file">
                                            <input type="file" name="file" class="custom-file-input" id="exampleFile"
                                                   accept=".xls,.xlsx,.csv" required>
                                            <label class="custom-file-label" for="exampleFile">Escolher arquivo...</label>
                                        </div>
                                        <small id="file-name-display" class="text-muted">Nenhum arquivo selecionado</small>
                                    </div>

                                    <div class="col-md-4">
                                        <button type="submit" class="btn btn-primary btn-block" id="btnUpload">
                                            <i class="fa fa-upload"></i>
                                            <span id="btnText">Enviar</span>
                                            <span id="btnSpinner" class="spinner-border spinner-border-sm" style="display: none;"></span>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Barra de progresso -->
                    <div class="row mt-3" id="progressContainer" style="display: none;">
                        <div class="col-md-12">
                            <div class="progress" style="height: 25px;">
                                <div class="progress-bar progress-bar-striped progress-bar-animated bg-success"
                                     id="uploadProgress" style="width: 0%;">0%</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fa fa-times"></i> Fechar
                </button>
            </div>
        </div>
    </div>
</div>





<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
/* Animações */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fadeInUp {
    animation: fadeInUp 0.4s ease-out;
}

/* Cards Modernos */
.card-primary {
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 5px 20px rgba(0,0,0,0.05);
}

.card-primary .card-body {
    padding: 25px;
}

/* Selects */
.form-control {
    border-radius: 12px;
    border: 2px solid #e2e8f0;
    padding: 10px 15px;
    transition: all 0.3s ease;
}

.form-control:focus {
    border-color: #4f46e5;
    box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
}

/* Botões */
.btn-primary {
    background: linear-gradient(135deg, #4f46e5 0%, #4338ca 100%);
    border: none;
    border-radius: 12px;
    padding: 10px 20px;
    transition: all 0.3s ease;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(79, 70, 229, 0.3);
}

.btn-outline-success {
    border-radius: 12px;
    border-width: 2px;
}

/* Modal */
.modal-content {
    border-radius: 24px;
    overflow: hidden;
}

.modal-header {
    border: none;
}

/* Progress Bar */
.progress {
    border-radius: 20px;
    background-color: #e2e8f0;
}

.progress-bar {
    border-radius: 20px;
    font-weight: 600;
    line-height: 25px;
}

/* Tabela de Upload */
.dadostabelaupload {
    overflow-x: auto;
}

.dadostabelaupload table {
    width: 100%;
    border-collapse: collapse;
    border-radius: 16px;
    overflow: hidden;
}

.dadostabelaupload th,
.dadostabelaupload td {
    padding: 12px;
    border: 1px solid #e2e8f0;
    white-space: nowrap;
}

.dadostabelaupload th {
    background: linear-gradient(135deg, #4f46e5 0%, #4338ca 100%);
    color: white;
    font-weight: 600;
}

.dadostabelaupload tr:nth-child(even) {
    background-color: #f8fafc;
}

.dadostabelaupload tr:hover {
    background-color: #eef2ff;
}

/* Conteúdo */
.Conteudotabela2 {
    margin-top: 20px;
}

/* Custom File Input */
.custom-file-label {
    border-radius: 12px;
    border: 2px solid #e2e8f0;
    padding: 10px 15px;
}

.custom-file-label::after {
    border-radius: 0 12px 12px 0;
    background: linear-gradient(135deg, #4f46e5 0%, #4338ca 100%);
    color: white;
}
</style>
<?php $__env->stopPush(); ?>
<?php $__env->startPush('scripts'); ?>
<script src="<?php echo e(asset('Admin-LTE/plugins/jquery/jquery.min.js')); ?>"></script>
<script src="<?php echo e(asset('Datatable/js/jquery.dataTables.min.js')); ?>"></script>
<script src="<?php echo e(asset('Admin-LTE/plugins/bootstrap/js/bootstrap.bundle.min.js')); ?>"></script>
<script src="<?php echo e(asset('Datatable/js/dataTables.buttons.min.js')); ?>"></script>
<script src="<?php echo e(asset('Datatable/js/buttons.flash.min.js')); ?>"></script>
<script src="<?php echo e(asset('Datatable/js/jszip.min.js')); ?>"></script>
<script src="<?php echo e(asset('Datatable/js/pdfmake.min.js')); ?>"></script>
<script src="<?php echo e(asset('Datatable/js/vfs_fonts.js')); ?>"></script>
<script src="<?php echo e(asset('Datatable/js/buttons.html5.min.js')); ?>"></script>
<script src="<?php echo e(asset('Datatable/js/buttons.print.min.js')); ?>"></script>
<script src="<?php echo e(asset('Datatable/js/buttons.colVis.min.js')); ?>"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
// ============================================
// VARIÁVEIS GLOBAIS
// ============================================
var tabelaAlunos = null;

// ============================================
// DOCUMENT READY
// ============================================
$(document).ready(function() {
    var ano = $(".selectAno").val();
    atualizarUrls(ano);
    selecionarAlunos(ano, $(".selectClasse").val());

    // Eventos dos selects
    $(".selectAno").on('change', function() {
        var ano = $(this).val();
        atualizarUrls(ano);
        selecionarAlunos(ano, $(".selectClasse").val());
    });

    $(".selectClasse").on('change', function() {
        selecionarAlunos($(".selectAno").val(), $(this).val());
    });

    // Mostrar nome do arquivo
    $("#exampleFile").on('change', function() {
        var fileName = $(this).val().split('\\').pop();
        if (fileName) {
            $(".custom-file-label").text(fileName);
            $("#file-name-display").text(fileName).removeClass('text-muted').addClass('text-primary');
            $("#anoLectivoInput").val($(".selectAno").val());
        } else {
            $(".custom-file-label").text('Escolher arquivo...');
            $("#file-name-display").text("Nenhum arquivo selecionado").removeClass('text-primary').addClass('text-muted');
        }
    });

    // Upload via AJAX
    $("#uploadForm").on('submit', function(e) {
        e.preventDefault();

        if ($("#exampleFile").get(0).files.length === 0) {
            mostrarResultado('Selecione um arquivo para upload', 'danger');
            return;
        }

        var formData = new FormData(this);
        var ano = $(".selectAno").val();
        var urlup = "<?php echo e(route('aluno.uplodefileCadastrofile', ':ano')); ?>";
        urlup = urlup.replace(':ano', ano);

        $("#progressContainer").show();
        $("#btnUpload").prop('disabled', true);
        $("#btnText").hide();
        $("#btnSpinner").show();
        $("#importResult").hide();

        $.ajax({
            url: urlup,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            xhr: function() {
                var xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener("progress", function(evt) {
                    if (evt.lengthComputable) {
                        var percent = Math.round((evt.loaded / evt.total) * 100);
                        $("#uploadProgress").css('width', percent + '%').text(percent + '%');
                    }
                });
                return xhr;
            },
            success: function(response) {
                $("#uploadProgress").css('width', '100%').text('100%');

                setTimeout(function() {
                    $("#uploadForm")[0].reset();
                    $(".custom-file-label").text('Escolher arquivo...');
                    $("#file-name-display").text("Nenhum arquivo selecionado").removeClass('text-primary').addClass('text-muted');
                    $("#progressContainer").hide();
                    $("#uploadProgress").css('width', '0%').text('0%');
                    $("#btnUpload").prop('disabled', false);
                    $("#btnText").show();
                    $("#btnSpinner").hide();

                    mostrarResultado(response.message || 'Importação concluída com sucesso!', 'success');
                    selecionarAlunos($(".selectAno").val(), $(".selectClasse").val());

                    $(".Conteudotabela1").fadeOut(400, function() {
                        if (typeof response === 'string') {
                            $(".dadostabelaupload").html(response);
                        } else if (response.dados && response.cabecalho) {
                            var tabelaHTML = '<table class="table table-striped" id="tabelaDadosUpload">';
                            tabelaHTML += '<thead><tr>';
                            response.cabecalho.forEach(function(col) {
                                tabelaHTML += '<th>' + col + '</th>';
                            });
                            tabelaHTML += '</td></thead><tbody>';

                            response.dados.forEach(function(linha) {
                                tabelaHTML += '<tr>';
                                Object.values(linha).forEach(function(valor) {
                                    tabelaHTML += '<td>' + (valor || '') + '</td>';
                                });
                                tabelaHTML += '</tr>';
                            });
                            tabelaHTML += '</tbody></table>';

                            $(".dadostabelaupload").html(tabelaHTML);
                        }

                        $(".Conteudotabela2").slideDown(600);
                    });

                    setTimeout(function() {
                        fecharModalSeguro('#modalUploadAlunos');
                    }, 3000);
                }, 500);
            },
            error: function(xhr) {
                $("#progressContainer").hide();
                $("#btnUpload").prop('disabled', false);
                $("#btnText").show();
                $("#btnSpinner").hide();

                var errorMessage = 'Erro ao fazer upload do arquivo.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }

                mostrarResultado(errorMessage, 'danger');

                setTimeout(function() {
                    fecharModalSeguro('#modalUploadAlunos');
                }, 5000);
            }
        });
    });

    // Eventos desistência e transferência
    $(document).on("click", ".tranferir_Desistencia", function() {
        jQuery.noConflict();
        $(".conteudobodi").hide();
        $(".conteudobodiTRanfere").show();

        let foto = $(this).attr("avatar");
        let avatar = "<?php echo e(asset('storage/' . $subdomain . '/fotoAluno')); ?>/" + foto;
        $(".avatar-aluno").attr("src", avatar);

        $(".nomealuno").text($(this).attr('nome'));
        $(".classealunoSpan").text($(this).attr('classeAluno'));
        $("[name='idAluno']").val($(this).attr('idaluno_classe_id'));
        $("[name='idMes']").val($("[name='mes_id']").val());
        $("[name='Tiposaida']").val($("[name='TiposaidaSelect']").val());
        $("#exampleModalCenter").modal('show');
    });

    $("[name='TiposaidaSelect'],[name='mes_id']").change(function() {
        $("[name='idMes']").val($("[name='mes_id']").val());
        $("[name='Tiposaida']").val($("[name='TiposaidaSelect']").val());
    });

    $(document).on("click", ".visualizar", function() {
        var idCod = $(this).attr("idcodigo");
        var anolectivo = $(this).attr("anolectivo");

        $.ajax({
            url: "/aluno/visualizar/" + idCod + "/" + anolectivo,
            type: "GET",
            beforeSend: function() {
                const loadingGif = '<?php echo e(asset("imageproceaament/loading.gif")); ?>';
                $(".DadosAlunoBody").html(`
                    <div style="display:flex; justify-content:center; align-items:center; height:200px;">
                        <img src="${loadingGif}" style="width:100px;height:100px;">
                    </div>
                `).show();
            },
            success: function(data) {
                $(".conteudo_tabela").hide();
                $(".btn-voltar").show();

                $(".diviConteudoselectordadosAnoClasse").hide();
                $(".DadosAlunoBody").html(data);
                $(".DadosAlunoConteudo").fadeIn();
            },
            error: function() {
                $(".DadosAlunoConteudo").html(
                    "<div class='alert alert-danger'>Erro ao carregar dados do aluno</div>"
                );
            }
        });
    });

    $(document).on("click", ".btn-voltar", function() {
        $(".DadosAlunoConteudo").hide();
        $(".DadosAlunoBody").html("");
        $(".diviConteudoselectordadosAnoClasse").fadeIn();
        $(".conteudo_tabela").fadeIn();
    });
});

// ============================================
// FUNÇÕES AUXILIARES
// ============================================

function fecharModalSeguro(modalId) {
    $(modalId).modal('hide');
    setTimeout(function() {
        $('body').removeClass('modal-open');
        $('.modal-backdrop').remove();
        $('body').css({ 'padding-right': '', 'overflow': '' });
    }, 200);
}

function atualizarUrls(ano) {
    var urlDownload = "<?php echo e(route('aluno.planilhaCadastro', ':ano')); ?>";
    urlDownload = urlDownload.replace(':ano', ano);
    $(".UrlDownload").attr("href", urlDownload);
    $("#anoLectivoInput").val(ano);
}

function selecionarAlunos(ano, classe) {
    const loadingGif = '<?php echo e(asset("imageproceaament/loading.gif")); ?>';
    const loadingHTML = `<div class="text-center p-5"><img src="${loadingGif}" style="width:60px;"><p class="mt-3 text-muted">Carregando alunos...</p></div>`;

    $.ajax({
        url: `/aluno/mostrar/ano/${ano}/${classe}`,
        type: 'GET',
        beforeSend: function() {
            $(".Tabela-de-mes").html(loadingHTML);
        },
        success: function(data) {
            $(".Tabela-de-mes").html(data);

            if (typeof inicializarAbas === 'function') {
                setTimeout(function() {
                    inicializarAbas();
                }, 100);
            }
        },
        error: function() {
            $(".Tabela-de-mes").html('<div class="alert alert-danger m-3"><i class="fa fa-exclamation-triangle"></i> Erro ao carregar dados dos alunos</div>');
        }
    });
}

function mostrarResultado(mensagem, tipo) {
    var alertDiv = $("#importResult");
    alertDiv.removeClass('alert-success alert-danger alert-info')
            .addClass('alert-' + tipo)
            .html('<i class="fa ' + (tipo === 'success' ? 'fa-check-circle' : 'fa-exclamation-triangle') + '"></i> ' + mensagem)
            .show();

    $('html, body').animate({ scrollTop: alertDiv.offset().top - 100 }, 500);

    setTimeout(function() {
        alertDiv.fadeOut();
    }, 5000);
}

// Garantir que o modal funcione corretamente
$('#modalUploadAlunos').on('hidden.bs.modal', function() {
    $('body').removeClass('modal-open');
    $('.modal-backdrop').remove();
    $('body').css({ 'padding-right': '', 'overflow': '' });
});

// Botão para abrir o modal - se houver algum botão com essa classe
$(document).on('click', '.abrir-modal-upload', function(e) {
    e.preventDefault();
    $('#modalUploadAlunos').modal('show');
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin-Lti', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\escola2025\resources\views/registoAcademico/Alunos-inscrito-select.blade.php ENDPATH**/ ?>