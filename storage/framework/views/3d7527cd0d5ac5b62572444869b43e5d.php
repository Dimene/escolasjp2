<?php $__env->startSection('title', 'Notas dos Alunos'); ?>
<?php $__env->startSection('content'); ?>

<style>
    :root {
        --primary-color: #3498db;
        --primary-dark: #2980b9;
        --secondary-color: #2c3e50;
        --accent-color: #e74c3c;
        --success-color: #27ae60;
        --light-gray: #f8f9fa;
        --medium-gray: #e9ecef;
        --dark-gray: #6c757d;
        --border-radius: 8px;
        --box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        --transition: all 0.3s ease;
    }

    body {
        background-color: #f5f7fa;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    /* Layout geral */
    .r {
        background-color: #f5f7fa;
        padding: 20px;
        min-height: calc(100vh - 60px);
    }

    .card {
        border-radius: var(--border-radius);
        box-shadow: var(--box-shadow);
        border: none;
        margin-bottom: 20px;
        transition: var(--transition);
    }

    .card:hover {
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
    }

    .card-header {
        background: linear-gradient(to right, var(--primary-color), var(--primary-dark));
        color: white;
        border-bottom: none;
        border-radius: var(--border-radius) var(--border-radius) 0 0 !important;
        padding: 12px 20px;
        font-weight: 600;
        font-size: 0.95rem;
        letter-spacing: 0.3px;
    }

    .card-header i {
        margin-right: 8px;
        font-size: 1rem;
    }

    .card-body {
        padding: 20px;
    }

    /* Títulos */
    h5, h6 {
        color: var(--secondary-color);
        font-weight: 600;
    }

    /* Lista de turmas - SCROLLABLE */
    .turmas-container {
        max-height: 350px;
        overflow-y: auto;
        padding-right: 5px;
    }

    .turmas-container::-webkit-scrollbar {
        width: 6px;
    }

    .turmas-container::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    .turmas-container::-webkit-scrollbar-thumb {
        background: var(--primary-color);
        border-radius: 10px;
    }

    .turmas-container::-webkit-scrollbar-thumb:hover {
        background: var(--primary-dark);
    }

    .list-group-item {
        border: none;
        padding: 10px 12px;
        margin-bottom: 6px;
        border-radius: var(--border-radius) !important;
        transition: var(--transition);
        cursor: pointer;
        display: flex;
        align-items: center;
        background-color: white;
        font-size: 0.9rem;
        border-left: 3px solid transparent;
    }

    .list-group-item:hover {
        background-color: rgba(52, 152, 219, 0.1);
        transform: translateX(3px);
        border-left-color: var(--primary-color);
    }

    .list-group-item.active {
        background: linear-gradient(to right, var(--primary-color), var(--primary-dark));
        color: white;
        box-shadow: 0 4px 8px rgba(52, 152, 219, 0.3);
        border-left-color: var(--secondary-color);
    }

    .list-group-item i {
        margin-right: 10px;
        font-size: 14px;
        width: 20px;
        text-align: center;
    }

    /* Formulários e selects - COMPACTOS */
    .filtros-container {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        margin-bottom: 15px;
    }

    .filtro-item {
        flex: 1 1 200px;
        min-width: 180px;
    }

    .form-group {
        margin-bottom: 0;
    }

    .form-control, .form-select {
        border-radius: var(--border-radius);
        border: 1px solid #ddd;
        padding: 8px 12px;
        height: 38px;
        font-size: 0.9rem;
        transition: var(--transition);
    }

    .form-control:focus, .form-select:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.25);
    }

    .form-label {
        font-weight: 500;
        color: var(--secondary-color);
        margin-bottom: 4px;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }

    /* Área de conteúdo das notas - CARD SEPARADO */
    .notas-section {
        margin-top: 20px;
    }

    .conteudonotas {/*
        background-color: white;
        border-radius: var(--border-radius);
        padding: 0;
        min-height: 60px;
        border: 1px solid #eee;
        */
    }

    .Conteudotabela {/*
        background-color: white;
        border-radius: var(--border-radius);
        padding: 15px;
        margin-top: 15px;
        border: 1px solid #eee;
        overflow-x: auto;
        */
    }

    /* Abas de disciplinas */
    .nav-tabs {
        border-bottom: 2px solid #dee2e6;
        padding: 0 10px;
        background-color: #f8f9fa;
        border-radius: var(--border-radius) var(--border-radius) 0 0;
    }

    .nav-tabs .nav-link {
        background-color: #f1f3f5;
        color: #495057;
        border: 1px solid #ced4da;
        margin-right: 5px;
        margin-bottom: -2px;
        transition: all 0.2s ease;
        border-radius: 4px 4px 0 0;
        padding: 8px 16px;
        font-size: 0.9rem;
    }

    .nav-tabs .nav-link:hover {
        background-color: #e9ecef;
        border-color: #adb5bd;
    }

    .nav-tabs .nav-link.active {
        background-color: #ffffff !important;
        color: #212529 !important;
        border: 1px solid #ced4da;
        border-bottom: 2px solid var(--primary-color) !important;
        font-weight: 600;
        transform: translateY(-2px);
    }

    /* Estatísticas rápidas */
    .stats-mini-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 10px 15px;
        border-radius: var(--border-radius);
        margin-bottom: 15px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .stats-mini-card i {
        font-size: 1.5rem;
        opacity: 0.8;
    }

    .stats-mini-card .stats-info {
        text-align: right;
    }

    .stats-mini-card .stats-label {
        font-size: 0.8rem;
        opacity: 0.9;
    }

    .stats-mini-card .stats-number {
        font-size: 1.2rem;
        font-weight: 700;
    }

    /* Loading */
    .loading-container {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 150px;
    }

    .spinner-border {
        width: 2.5rem;
        height: 2.5rem;
        color: var(--primary-color);
    }

    /* Breadcrumb */
    .breadcrumb {
        background-color: transparent;
        padding: 0;
        font-size: 0.85rem;
        margin-bottom: 15px;
    }

    .breadcrumb-item a {
        color: var(--primary-color);
        text-decoration: none;
        transition: var(--transition);
    }

    .breadcrumb-item a:hover {
        color: var(--primary-dark);
        text-decoration: underline;
    }

    /* Cards lado a lado */
    .main-row {
        display: flex;
        flex-wrap: wrap;
        margin: 0 -10px;
    }

    .main-row > [class*="col-"] {
        padding: 0 10px;
    }

    /* Turmas card com altura fixa */
    .turmas-card {
        height: fit-content;
        position: sticky;
        top: 20px;
    }

    /* Container de filtros compacto */
    .filtros-card {
        margin-bottom: 15px;
    }

    /* Responsividade */
    @media (max-width: 992px) {
        .turmas-card {
            position: relative;
            top: 0;
            margin-bottom: 20px;
        }

        .filtro-item {
            flex: 1 1 100%;
        }
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
                <i class="fa fa-pencil"></i> <b>Cadernesta Do professor</b>
            </li>
        </ol>
    </div>

<!-- Content Wrapper. Contains page content -->
<div class="">
    <!-- Content Header (Page header) -->


    <!-- Main content -->
    <div class="main-row">
        <!-- Coluna das Turmas - Card separado -->
        <div class="col-lg-2 col-md-3">
            <div class="card turmas-card">
                <div class="card-header">
                    <i class="fas fa-users"></i> Turmas
                </div>
                <div class="card-body">
                    <div class="turmas-container">
                        <div class="lista-Turmas listaturmasAdd list-group">
                            <!-- As turmas serão carregadas aqui via JavaScript -->
                            <div class="text-center text-muted py-3">
                                <i class="fas fa-spinner fa-spin mb-2"></i>
                                <p class="small mb-0">Carregando turmas...</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Coluna Principal - Filtros e Conteúdo -->
        <div class="col-lg-10 col-md-9">
            <!-- Card de Filtros - Compacto -->
            <div class="card filtros-card">
                <div class="card-header">
                    <i class="fas fa-filter"></i> Filtros de Pesquisa
                </div>
                <div class="card-body">
                    <div class="filtros-container">
                        <div class="filtro-item">
                            <div class="form-group">
                                <label for="my-classe" class="form-label">
                                    <i class="fas fa-layer-group mr-1" style="font-size: 0.8rem;"></i> Classe
                                </label>
                                <select id="my-classe" class="form-control controler-classe-ano myChange">
                                    <?php $__currentLoopData = $classes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $classItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($classItem->id); ?>"><?php echo e($classItem->Descricao); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>

                        <div class="filtro-item">
                            <div class="form-group">
                                <label for="my-anolectivo" class="form-label">
                                    <i class="fas fa-calendar-alt mr-1" style="font-size: 0.8rem;"></i> Ano Lectivo
                                </label>
                                <select id="my-anolectivo" class="form-control controler-classe-ano myChange">
                                    <?php $__currentLoopData = $anolectivo; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $anolectivoItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($anolectivoItem->id); ?>"><?php echo e($anolectivoItem->anolectivo); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>

                        <div class="filtro-item">
                            <div class="form-group">
                                <label for="my-divisao" class="form-label ">
                                    <i class="fas fa-clock mr-1 " style="font-size: 0.8rem;"></i> Trimestre
                                </label>
                                <select id="my-divisao" class="form-control ">
                                    <option value="">Selecione um trimestre</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card das Notas - Conteúdo separado -->
            <div class="card">

                <div class=" p-0">
                    <!-- Área para abas das disciplinas -->
                    <div class="conteudonotas">
                        <div id="disciplinas-tabs-container">
                            <!-- Conteúdo carregado dinamicamente -->
                            <div class="text-center text-muted py-4">
                                <i class="fas fa-arrow-up mb-2" style="font-size: 2rem; opacity: 0.3;"></i>
                                <p class="mb-0">Selecione uma turma para ver as disciplinas</p>
                            </div>
                        </div>
                    </div>

                    <!-- Área da tabela de notas -->
                    <div class="Conteudotabela">
                        <div class="text-center text-muted py-5">
                            <i class="fas fa-table mb-3" style="font-size: 3rem; opacity: 0.2;"></i>
                            <p>As notas dos alunos aparecerão aqui</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<!-- Modal para criar nota -->
<div id="adicionarCampoNotas" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-plus-circle mr-2"></i>Adicionar Prova</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="nome-nota">Nome da Prova</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-pen"></i></span>
                        </div>
                        <input id="my-select" type="text" class="form-control" name="labelavalicacao" list="lista-label-avaliacao" placeholder="Ex: Teste 1, Prova Oral, etc.">
                        <datalist id="lista-label-avaliacao">
                            <?php $__currentLoopData = $nota_meta; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $nota_metaItm): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($nota_metaItm->Decricao); ?>"></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </datalist>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary btn-guardar-nomeprova config-item-Div" nome-modal="adicionarCampoNotas">
                    <i class="fas fa-save mr-2"></i>Guardar
                </button>
            </div>
        </div>
    </div>
</div>


<?php $__env->startPush('script'); ?>
<script>
// Passar dados do PHP para JavaScript
const trimestresData = <?php echo json_encode($trimestres, 15, 512) ?>;
const divisaoestado = <?php echo json_encode($divisaoestado, 15, 512) ?>;
const flag = <?php echo json_encode($divisaoestado, 15, 512) ?>;

$(document).ready(function() {
    let anolectivo = Number($("#my-anolectivo").val());
    let classe = Number($("#my-classe").val());

    // Preenche trimestres e turmas iniciais
    filtrar(anolectivo,classe);
    buscar_turmas(anolectivo, classe);




    // Atualiza ao mudar ano lectivo ou classe
    $(document).on("change",".myChange", function() {
        let anolectivo = Number($("#my-anolectivo").val());
        let classe = Number($("#my-classe").val());

        filtrar(anolectivo,classe);
         $(".Conteudotabela").empty();
    $(".conteudonotas").empty();
        buscar_turmas(anolectivo, classe);

    })

    // Atualiza ao mudar ano lectivo ou classe
    $(document).on("change","#my-divisao", function() {
        let anolectivo = Number($("#my-anolectivo").val());
        let classe = Number($("#my-classe").val());

        // filtrar(anolectivo);
         $(".Conteudotabela").empty();
    $(".conteudonotas").empty();
        buscar_turmas(anolectivo, classe);

    });
});

// Clique em turma
$(document).on("click", ".Turma-elemento", function() {
    $(".Turma-elemento").removeClass('active');
    $(this).addClass('active');

    $(".Conteudotabela").empty();
    $(".conteudonotas").empty();

    console.log("ID:", this.id);
    console.log("Data Key:", this.dataset.key);
    console.log("Texto:", this.innerText);

    let classe = Number($("#my-classe").val());
    buscarnotas(this.id, classe);
});
$(document).on("click", ".disciplina_id", function() {
$(".Conteudotabela").empty();
     let disciplinaId=$(".disciplina_id.active").data("disciplina-id");
         let trimestre=$("#my-divisao").val();
          let liAtivo = document.querySelector(".Turma-elemento.active");


     buscarnotasportrimestreturma(disciplinaId,liAtivo.id,trimestre);
});



    $(document).on("click", ".config-item", function() {

           let nome = $(this).attr("nome-modal");
    let modal = new bootstrap.Modal(document.getElementById(nome));
    modal.show();
        });

//discipli}/{turma}/{trimestre}
       $(document).on("click", ".btn-guardar-nomeprova", function() {
            // $(".butoes-controlo-notas").hide("slow");
            // $("conteudo-confiDiv").hide("slow");

            let disciplinaId=$(".disciplina_id.active").data("disciplina-id");
         let trimestre=$("#my-divisao").val();
          let liAtivo = document.querySelector(".Turma-elemento.active");
            $.ajax({
                url: '/RegistoAcademico/notas/elementoAddavaliacao/' +disciplinaId+ '/' +liAtivo.id+'/' +trimestre,
                type: 'GET',
                dataType: 'json',
                data: {
                    'label': $("[name='labelavalicacao']").val()
                },
                beforeSend: function() {
                    $(".Conteudotabela").html(
                        '<div class="loading-container"><div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div></div>'
                    );
                },
                success: function(data, textStatus, jqXHR) {
                   // $("#adicionarCampoNotas").modal('hide');
                   buscarnotasportrimestreturma(disciplinaId,liAtivo.id,trimestre);

                   let nome = "adicionarCampoNotas";
    let modal = new bootstrap.Modal(document.getElementById(nome));
    modal.hide();
                }
            });
        });







        $(document).on("click", "#btnSaveFormula", function () {
    const $btn = $(this);
    let liAtivo = document.querySelector(".Turma-elemento.active");
    const newFormula = $('#formulaInput').val().trim();
    const turmaId = liAtivo.id;
    const divisao = $("#my-divisao").val();
    const anoLectivo = $('#my-anolectivo').val();
    const classe = $('#my-classe').val();
    const disciplinaId =$(".disciplina_id.active").data("disciplina-id");



    // Validação mais robusta
    if (!newFormula) {
        showAlert("Insira uma fórmula válida", "danger");
        return;
    }

    // Validar parâmetros necessários
    if (!turmaId || !divisao || !anoLectivo || !classe || !disciplinaId) {
        showAlert("Parâmetros incompletos para salvar a fórmula", "danger");
        return;
    }

    // Fechar o modal corretamente
    $('#formulaModal').modal('hide');

    // Remover backdrop manualmente se necessário (com timeout para garantir transição)
    setTimeout(() => {
        $(".modal-backdrop").remove();
        $("body").removeClass("modal-open");
    }, 300);

    // Ativar spinner e desabilitar botão
    $btn.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Salvando...');
    $btn.prop("disabled", true);

    // URL mais legível usando template literals
    const url = `/RegistoAcademico/notas/disciplinas/guadarformulamedias/${turmaId}/${divisao}/${anoLectivo}/${classe}/${disciplinaId}`;

    $.ajax({
        url: url,
        type: 'POST',
        data: $("#formulaForm").serialize(),

        success: function(response) {
            // Pequeno delay para garantir transição do modal
            setTimeout(function() {
                $(".Conteudotabela").html(response);

                // Inicializar DataTables se necessário
              //  initializeDataTables();

                showSuccessNotification("Fórmula guardada com sucesso");
            }, 300);
        },
        error: function(xhr, status, error) {
            console.error("Erro ao salvar fórmula:", error, xhr.responseText);

            let errorMessage = "Erro ao salvar fórmula. Por favor, tente novamente.";

            // Tratamento específico para diferentes tipos de erro
            if (xhr.status === 400) {
                errorMessage = "Dados inválidos. Verifique a fórmula e tente novamente.";
            } else if (xhr.status === 500) {
                errorMessage = "Erro interno do servidor. Contacte o administrador.";
            }

            Swal.fire({
                icon: "error",
                title: "Erro",
                text: errorMessage,
                confirmButtonText: "OK"
            });
        },
        complete: function() {
            // Restaurar botão independente de sucesso ou erro
            $btn.html('<i class="fas fa-save"></i> Salvar Fórmula');
            $btn.prop("disabled", false);
        }
    });
});

// Filtrar trimestres por ano lectivo e selecionar automaticamente o ativo
function filtrar(ano, clase) {
    const hoje = new Date();
    let options = "";

    // Filtrar trimestres pelo ano letivo
    const trimestresFiltrados = trimestresData.filter(t =>
        Number(t.anolectivo_id) === Number(ano)
    );

    // Construir opções válidas
    const classeSelecionada = $("#my-classe").val();
    trimestresFiltrados.forEach(element => {
        const bloqueada = !divisaoestado || divisaoestado.some(dbloqueiada =>
    Number(element.anomodelo_id) === Number(dbloqueiada.divisao_id) &&
    Number(classeSelecionada) === Number(dbloqueiada.classe_id) &&
    dbloqueiada.EstadoView === null
);
         console.log(bloqueada,divisaoestado);

       if (bloqueada) {
            options += `<option value="${element.anomodelo_id}">
                           ${element.divisao} - ${element.anomodelos}
                        </option>`;
        }
    });

    $("#my-divisao").html(options);

    // Selecionar automaticamente o trimestre ativo
    let selecionado = false;
    for (let element of trimestresFiltrados) {
        const inicio = new Date(element.inicio);
        const fim = new Date(element.fim);

        if (hoje >= inicio && hoje <= fim) {
            $("#my-divisao").val(element.anomodelo_id);
            selecionado = true;
            break;
        }
    }

    // Se nenhum ativo for encontrado, selecionar o primeiro disponível
    if (!selecionado && trimestresFiltrados.length > 0) {
        $("#my-divisao").val(trimestresFiltrados[0].anomodelo_id);
    }

    console.log(trimestresFiltrados);
}


function buscar_turmas(ano, classe) {
    $.ajax({
        url: '/RegistoAcademico/notas/' + ano + '/' + classe,
        type: "GET",
        success: function(data) {

            $(".lista-Turmas").html(data);

            // Esperar DOM atualizar
            setTimeout(function () {

                let primeiraTurma = $(".Turma-elemento").first();

                if (primeiraTurma.length) {

                    $(".Turma-elemento").removeClass("active");
                    primeiraTurma.addClass("active");

                    buscarnotas(primeiraTurma.attr("id"), classe);
                }

            }, 50);
        }
    });
}

// Buscar notas
function buscarnotas(turma, classe) {
    $(".conteudonotas").empty();

    $.ajax({
        url: '/RegistoAcademico/notas/turmasAlunos/' + turma + '/' + classe,
        type: 'GET',
        beforeSend: function () {
            $(".Conteudotabela").empty();
            $(".conteudonotas").empty();
            $(".conteudonotas").html(
                '<div class="loading-container text-center p-3">' +
                    '<div class="spinner-border text-primary" role="status">' +
                        '<span class="sr-only">Carregando...</span>' +
                    '</div>' +
                    '<p class="mt-2">Carregando notas...</p>' +
                '</div>'
            );
        },
        success: function (data) {
            $(".conteudonotas").html(data);

            // Alerta de sucesso (toast)
            // Swal.fire({
            //     position: "top-end",
            //     icon: "success",
            //     title: "Notas carregadas com sucesso!",
            //     showConfirmButton: false,
            //     timer: 1500
            // });

         let disciplinaId=$(".disciplina_id.active").data("disciplina-id");
         let trimestre=$("#my-divisao").val();
          let liAtivo = document.querySelector(".Turma-elemento.active");





             buscarnotasportrimestreturma(disciplinaId,liAtivo.id,trimestre);
        },
        error: function () {
            $(".conteudonotas").html(""); // limpa spinner se falhar

            Swal.fire({
                icon: "error",
                title: "Erro ao carregar notas",
                text: "Por favor, tente novamente mais tarde.",
                confirmButtonText: "OK"
            });
        }
    });
}




function buscarnotasportrimestreturma(disciplina, turma, trimestre) {

    // Verificar se todos os campos estão preenchidos
    if (disciplina !== null && turma !== null && trimestre !== null) {
        console.log("Todos os campos estão preenchidos");

        $.ajax({
            url: '/RegistoAcademico/notas/elemento/' + disciplina + '/' + turma + '/' + trimestre,
            type: 'GET',
            beforeSend: function() {
                $(".Conteudotabela").html(
                    '<div class="loading-container"><div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div></div>'
                );
            },
            success: function(data) {
                $(".Conteudotabela").html(data);
                $(".butoes-controlo-notas").show("slow");
            },
            error: function() {
                $(".Conteudotabela").html("<p>Erro ao carregar notas.</p>");
            }
        });

    } else {
        // Caso algum campo esteja vazio
        $(".Conteudotabela").html("<p>Por favor, selecione disciplina, turma e trimestre.</p>");
        $(".conteudonotas").html("");
    }
}






$(document).on("click", ".editar-notaavaliacao", function () {
    let $th = $(this).closest('th');
    let $span = $th.find('.notanome');
    let texto = $span.text().trim();

    // Pega atributos do botão
    let turma_id = $(this).attr("turma_id");
    let trimestre = $(this).attr("trimestre");
    let disciplina_id = $(this).attr("disciplina_id");
    let provaid = $(this).attr("provaid");

    // Cria input com valores e atributos
    let $input = $('<input type="text" class="form-control form-control-sm input-notanome">')
        .val(texto)
        .attr("oldvalue", texto)
        .attr("turma_id", turma_id)
        .attr("trimestre", trimestre)
        .attr("disciplina_id", disciplina_id)
        .attr("provaid", provaid);

    // Substitui o span pelo input
    $span.replaceWith($input);

    // Coloca foco no input e cursor no final
    $input.focus()[0].setSelectionRange(texto.length, texto.length);
});

// Quando perder o foco do input
$(document).on("blur", ".input-notanome", function () {
    let novoTexto = $(this).val().trim();
    let antigo = $(this).attr("oldvalue");

    // Cria de volta o span com o texto novo (mesmo se não salvar)
    let $span = $('<span class="notanome"></span>').text(novoTexto);
    $(this).replaceWith($span);

    // Se o texto não mudou, não faz nada
    if (novoTexto === antigo) {
        return;
    }

    // Pega atributos
    let turma = $(this).attr("turma_id");
    let trimestre = $(this).attr("trimestre");
    let disciplina = $(this).attr("disciplina_id");
    let provaid = $(this).attr("provaid");

    console.log(turma, trimestre, disciplina, provaid);

    // Ajax para salvar no servidor
    $.ajax({
        // url: "/RegistoAcademico/notas/disciplinas/atualizarNome/" + turma + "/" + trimestre + "/" + provaid + "/" + disciplina+"/"+novoTexto,
     url: "<?php echo e(route('notas.edit', ':provaid')); ?>".replace(':provaid', provaid),
        type: "GET",
        dataType: "json",
        data:{
            turma:turma,
            trimestre:trimestre,
            disciplina:disciplina,
            novonome:novoTexto
        },
        beforeSend: function () {
            // opcional: adicionar spinner no lugar do span
            $span.html('<i class="fas fa-spinner fa-spin text-primary"></i>');
        },
        success: function (data) {
            if (data.mensagem === "success") {
                buscarnotasportrimestreturma(disciplina, turma, trimestre);
            }
        }
    });
});



    $(document).on('click', ".apagar-notaavaliacao", function() {
            $turma = $(this).attr('turma_id');
            $trimestre = $(this).attr('trimestre');
            $disciplina = $(this).attr('disciplina_id');
            $provaid = $(this).attr('provaid');

            let $ml = '<h5><i class="fa fa-warning" aria-hidden="true">Pretedes apagar' + $(this).text() +
                '</i></h5>' +
                '<hr><div class="row"><div class="col-6">' +
                '<button  class="btn btn-primary apagar-notaavaliacaodados" ' +
                'turma_id="' + $turma + '"' +
                'trimestre="' + $trimestre + '"' +
                'disciplina_id="' + $disciplina + '"' +
                'provaid="' + $provaid + '">' +
                'Sim</button></div>' +
                '<div class="col-6"><button  class="btn btn-danger naoApagar-notaavaliacao">nao</button></div></div>'
            $(".conteudo_alert_iformacao").html($ml);
            jQuery.noConflict();
            $("#modalalert").modal("show");
        });

        $(document).on('click', ".naoApagar-notaavaliacao", function() {
            jQuery.noConflict();
            $("#modalalert").modal("hide");
        });







        $(document).on('click', ".apagar-notaavaliacaodados", function() {
            jQuery.noConflict();
            $("#modalalert").modal("hide");
            $turma = $(this).attr('turma_id');
            $trimestre = $(this).attr('trimestre');
            $disciplina = $(this).attr('disciplina_id');
            $provaid = $(this).attr('provaid');

            console.log($turma, $trimestre, $disciplina, $provaid);
            $.ajax({
                url: "/RegistoAcademico/notas/disciplinas/apagarnota/" + $turma + "/" + $trimestre + "/" +
                    $provaid + "/" + $disciplina + "",
                type: 'Get',
                datatype: 'json',
                success: function(data) {
                    if (data.mensagem == "success") {
                        buscarnotasportrimestreturma($disciplina, $turma, $trimestre)
                    }
                }
            })
        });

</script>

<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin-Lti', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\escola2025\resources\views/registoAcademico/notas/notas-index.blade.php ENDPATH**/ ?>