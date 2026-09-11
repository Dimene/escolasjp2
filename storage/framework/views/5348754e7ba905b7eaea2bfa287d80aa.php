

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

    h5, h6 {
        color: var(--secondary-color);
        font-weight: 600;
    }

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

    .main-row {
        display: flex;
        flex-wrap: wrap;
        margin: 0 -10px;
    }

    .main-row > [class*="col-"] {
        padding: 0 10px;
    }

    .turmas-card {
        height: fit-content;
        position: sticky;
        top: 20px;
    }

    .filtros-card {
        margin-bottom: 15px;
    }

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

    .table-notas {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.85rem;
    }

    .table-notas th,
    .table-notas td {
        border: 1px solid #dee2e6;
        padding: 8px 12px;
        text-align: center;
        vertical-align: middle;
    }

    .table-notas th {
        background-color: #f8f9fa;
        font-weight: 600;
        color: #495057;
    }

    .table-notas tr:hover {
        background-color: #f8f9fa;
    }

    .btn-xs {
        padding: 2px 6px;
        font-size: 0.75rem;
    }

    .formula-badge {
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .formula-badge:hover {
        transform: scale(1.05);
        box-shadow: 0 2px 8px rgba(0,0,0,0.15);
    }

    .btn-add-prova {
        margin: 10px;
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
            <i class="fa fa-pencil"></i> <b>Caderneta Do Professor</b>
        </li>
    </ol>
</div>

<div class="">
    <div class="main-row">
        <!-- Coluna das Turmas -->
        <div class="col-lg-2 col-md-3">
            <div class="card turmas-card">
                <div class="card-header">
                    <i class="fas fa-users"></i> Turmas
                </div>
                <div class="card-body">
                    <div class="turmas-container">
                        <div class="lista-Turmas listaturmasAdd list-group">
                            <div class="text-center text-muted py-3">
                                <i class="fas fa-spinner fa-spin mb-2"></i>
                                <p class="small mb-0">Carregando turmas...</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Coluna Principal -->
        <div class="col-lg-10 col-md-9">
            <!-- Card de Filtros -->
            <div class="card filtros-card">
                <div class="card-header">
                    <i class="fas fa-filter"></i> Filtros de Pesquisa
                </div>
                <div class="card-body">
                    <div class="filtros-container">
                        <div class="filtro-item">
                            <div class="form-group">
                                <label for="my-classe" class="form-label">
                                    <i class="fas fa-layer-group mr-1"></i> Classe
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
                                    <i class="fas fa-calendar-alt mr-1"></i> Ano Lectivo
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
                                <label for="my-divisao" class="form-label">
                                    <i class="fas fa-clock mr-1"></i> Trimestre
                                </label>
                                <select id="my-divisao" class="form-control">
                                    <option value="">Selecione um trimestre</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card das Notas -->
            <div class="card">
                <div class="p-0">
                    <div class="conteudonotas">
                        <div id="disciplinas-tabs-container">
                            <div class="text-center text-muted py-4">
                                <i class="fas fa-arrow-up mb-2" style="font-size: 2rem; opacity: 0.3;"></i>
                                <p class="mb-0">Selecione uma turma para ver as disciplinas</p>
                            </div>
                        </div>
                    </div>
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

<!-- Modal para adicionar prova - CORRIGIDO -->
<div id="adicionarCampoNotas" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modalAddProvaTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalAddProvaTitle">
                    <i class="fas fa-plus-circle mr-2"></i>Adicionar Prova
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="nome-nota">Nome da Prova <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-pen"></i></span>
                        </div>
                        <input type="text" id="nome-prova-input" class="form-control" name="labelavalicacao" list="lista-label-avaliacao" placeholder="Ex: Teste 1, Prova Oral, Trabalho, etc." autocomplete="off">
                        <datalist id="lista-label-avaliacao">
                            <?php $__currentLoopData = $nota_meta; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $nota_metaItm): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($nota_metaItm->Decricao); ?>"></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </datalist>
                    </div>
                    <small class="form-text text-muted">Digite o nome da prova ou selecione uma sugestão</small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fas fa-times"></i> Cancelar
                </button>
                <button type="button" class="btn btn-primary btn-guardar-nomeprova" id="btnSaveProva">
                    <i class="fas fa-save"></i> Guardar Prova
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Fórmula de Médias -->
<div class="modal fade" id="formulaModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-calculator mr-2"></i>Fórmula de Cálculo de Médias</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form id="formulaForm">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Fórmula <small class="text-muted">(Use {n1}, {n2}, etc. para as notas)</small></label>
                        <textarea id="formulaInput" name="formula" class="form-control" rows="4" placeholder="Ex: ({n1}+{n2}+{n3})/3"></textarea>
                        <small class="form-text text-muted mt-2">
                            <strong>Exemplos:</strong><br>
                            - Média simples: ({n1}+{n2}+{n3})/3<br>
                            - Com pesos: ({n1}*0.3 + {n2}*0.3 + {n3}*0.4)<br>
                            - Média ponderada: (2*{n1}+2*{n2}+3*{n3})/7
                        </small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="btnSaveFormula">
                        <i class="fas fa-save"></i> Salvar Fórmula
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal de Alerta/Confirmação -->
<div class="modal fade" id="modalalert" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-warning"><i class="fas fa-exclamation-triangle"></i> Confirmação</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body conteudo_alert_iformacao"></div>
        </div>
    </div>
</div>

<?php $__env->startPush('script'); ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Passar dados do PHP para JavaScript
    const trimestresData = <?php echo json_encode($trimestres, 15, 512) ?>;
    const divisaoestado = <?php echo json_encode($divisaoestado, 15, 512) ?>;

    $(document).ready(function() {
        console.log("Documento pronto - Inicializando...");

        let anolectivo = Number($("#my-anolectivo").val());
        let classe = Number($("#my-classe").val());

        filtrar(anolectivo, classe);
        buscar_turmas(anolectivo, classe);

        // Eventos dos filtros
        $(document).on("change", ".myChange", function() {
            let anolectivo = Number($("#my-anolectivo").val());
            let classe = Number($("#my-classe").val());
            filtrar(anolectivo, classe);
            $(".Conteudotabela, .conteudonotas").empty();
            buscar_turmas(anolectivo, classe);
        });

        $(document).on("change", "#my-divisao", function() {
            let anolectivo = Number($("#my-anolectivo").val());
            let classe = Number($("#my-classe").val());
            $(".Conteudotabela, .conteudonotas").empty();
            buscar_turmas(anolectivo, classe);
        });

        // Evento para abrir o modal - CORRIGIDO
        $(document).on("click", ".btn-add-prova, .config-item", function() {
            console.log("Botão para adicionar prova clicado");
            let nomeProvaInput = document.getElementById('nome-prova-input');
            if (nomeProvaInput) {
                nomeProvaInput.value = '';
            }

            // Verificar se há disciplina ativa
            let disciplinaId = $(".disciplina_id.active").data("disciplina-id");
            if (!disciplinaId) {
                Swal.fire({
                    icon: "warning",
                    title: "Atenção",
                    text: "Selecione uma disciplina primeiro",
                    confirmButtonText: "OK"
                });
                return;
            }

            // Abrir modal usando Bootstrap 5
            try {
                let modalEl = document.getElementById('adicionarCampoNotas');
                let modal = new bootstrap.Modal(modalEl);
                modal.show();
            } catch(e) {
                console.error("Erro ao abrir modal:", e);
                // Fallback para jQuery
                $('#adicionarCampoNotas').modal('show');
            }
        });
    });

    // Função para filtrar trimestres
    function filtrar(ano, classe) {
        const hoje = new Date();
        let options = "";

        const trimestresFiltrados = trimestresData.filter(t => Number(t.anolectivo_id) === Number(ano));

        trimestresFiltrados.forEach(element => {
            let isDisponivel = true;

            if (divisaoestado && divisaoestado.length > 0) {
                const bloqueio = divisaoestado.find(dbloqueiada =>
                    Number(element.anomodelo_id) === Number(dbloqueiada.divisao_id) &&
                    Number(classe) === Number(dbloqueiada.classe_id)
                );

                if (bloqueio) {
                    isDisponivel = bloqueio.EstadoView === null;
                }
            }

            if (isDisponivel) {
                options += `<option value="${element.anomodelo_id}">${element.divisao} - ${element.anomodelos}</option>`;
            }
        });

        $("#my-divisao").html(options || '<option value="">Nenhum trimestre disponível</option>');

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

        if (!selecionado && trimestresFiltrados.length > 0 && options) {
            $("#my-divisao").val(trimestresFiltrados[0].anomodelo_id);
        }
    }

    // Clique em turma
    $(document).on("click", ".Turma-elemento", function() {
        $(".Turma-elemento").removeClass('active');
        $(this).addClass('active');
        $(".Conteudotabela, .conteudonotas").empty();

        let classe = Number($("#my-classe").val());
        buscarnotas(this.id, classe);
    });

    // Clique em disciplina
    $(document).on("click", ".disciplina_id", function() {
        $(".disciplina_id").removeClass('active');
        $(this).addClass('active');
        $(".Conteudotabela").empty();

        let disciplinaId = $(".disciplina_id.active").data("disciplina-id");
        let trimestre = $("#my-divisao").val();
        let liAtivo = document.querySelector(".Turma-elemento.active");

        if (disciplinaId && liAtivo && trimestre) {
            buscarnotasportrimestreturma(disciplinaId, liAtivo.id, trimestre);
        }
    });

    // Buscar turmas
    function buscar_turmas(ano, classe) {
        $.ajax({
            url: '/RegistoAcademico/notas/' + ano + '/' + classe,
            type: "GET",
            success: function(data) {
                $(".lista-Turmas").html(data);
                setTimeout(function() {
                    let primeiraTurma = $(".Turma-elemento").first();
                    if (primeiraTurma.length) {
                        $(".Turma-elemento").removeClass("active");
                        primeiraTurma.addClass("active");
                        buscarnotas(primeiraTurma.attr("id"), classe);
                    }
                }, 100);
            },
            error: function(xhr) {
                console.error("Erro ao buscar turmas:", xhr);
                $(".lista-Turmas").html('<div class="text-danger text-center p-3">Erro ao carregar turmas</div>');
            }
        });
    }

    // Buscar notas por turma (disciplinas)
    function buscarnotas(turma, classe) {
        $.ajax({
            url: '/RegistoAcademico/notas/turmasAlunos/' + turma + '/' + classe,
            type: 'GET',
            beforeSend: function() {
                $(".Conteudotabela, .conteudonotas").empty();
                $(".conteudonotas").html(`
                    <div class="loading-container text-center p-3">
                        <div class="spinner-border text-primary" role="status"></div>
                        <p class="mt-2">Carregando disciplinas...</p>
                    </div>
                `);
            },
            success: function(data) {
                $(".conteudonotas").html(data);

                setTimeout(function() {
                    let disciplinaId = $(".disciplina_id.active").data("disciplina-id");
                    let trimestre = $("#my-divisao").val();
                    let liAtivo = document.querySelector(".Turma-elemento.active");

                    if (disciplinaId && liAtivo && trimestre && trimestre !== "") {
                        buscarnotasportrimestreturma(disciplinaId, liAtivo.id, trimestre);
                    }
                }, 150);
            },
            error: function(xhr) {
                console.error("Erro ao buscar disciplinas:", xhr);
                $(".conteudonotas").html(`<div class="text-center text-danger p-4">Erro ao carregar disciplinas</div>`);
            }
        });
    }

    // Buscar notas por disciplina, turma e trimestre
    function buscarnotasportrimestreturma(disciplina, turma, trimestre) {
        if (!disciplina || !turma || !trimestre || trimestre === "") {
            $(".Conteudotabela").html(`<div class="text-muted text-center p-4">Selecione disciplina, turma e trimestre</div>`);
            return;
        }

        $.ajax({
            url: '/RegistoAcademico/notas/elemento/' + disciplina + '/' + turma + '/' + trimestre,
            type: 'GET',
            beforeSend: function() {
                $(".Conteudotabela").html(`<div class="loading-container text-center p-4"><div class="spinner-border text-primary"></div><p class="mt-2">Carregando notas...</p></div>`);
            },
            success: function(data) {
                $(".Conteudotabela").html(data);
                $(".butoes-controlo-notas").show("slow");
            },
            error: function(xhr) {
                console.error("Erro ao carregar notas:", xhr);
                $(".Conteudotabela").html(`<div class="text-danger text-center p-4">Erro ao carregar notas</div>`);
            }
        });
    }

    // GUARDAR NOVA PROVA - CORRIGIDO
    $(document).on("click", "#btnSaveProva, .btn-guardar-nomeprova", function(e) {
        e.preventDefault();

        console.log("=== Salvando nova prova ===");

        let disciplinaId = $(".disciplina_id.active").data("disciplina-id");
        let trimestre = $("#my-divisao").val();
        let liAtivo = document.querySelector(".Turma-elemento.active");
        let turmaId = liAtivo ? liAtivo.id : null;
        let nomeProva = $("#nome-prova-input").val().trim();

        console.log("Disciplina:", disciplinaId);
        console.log("Turma:", turmaId);
        console.log("Trimestre:", trimestre);
        console.log("Nome da Prova:", nomeProva);

        // Validações
        if (!disciplinaId) {
            Swal.fire("Erro", "Selecione uma disciplina primeiro", "error");
            return;
        }

        if (!turmaId) {
            Swal.fire("Erro", "Selecione uma turma primeiro", "error");
            return;
        }

        if (!trimestre || trimestre === "") {
            Swal.fire("Erro", "Selecione um trimestre", "error");
            return;
        }

        if (!nomeProva) {
            Swal.fire("Aviso", "Informe o nome da prova", "warning");
            return;
        }

        const $btn = $(this);
        const originalHtml = $btn.html();
        $btn.html('<span class="spinner-border spinner-border-sm"></span> Salvando...');
        $btn.prop("disabled", true);

        $.ajax({
            url: '/RegistoAcademico/notas/elementoAddavaliacao/' + disciplinaId + '/' + turmaId + '/' + trimestre,
            type: 'GET',
            data: { 'label': nomeProva },
            dataType: 'json',
            success: function(response) {
                console.log("Resposta:", response);

                // Fechar modal
                try {
                    let modal = bootstrap.Modal.getInstance(document.getElementById('adicionarCampoNotas'));
                    if (modal) modal.hide();
                } catch(e) {
                    $('#adicionarCampoNotas').modal('hide');
                }

                // Limpar input
                $("#nome-prova-input").val('');

                // Recarregar notas
                buscarnotasportrimestreturma(disciplinaId, turmaId, trimestre);

                Swal.fire({
                    icon: 'success',
                    title: 'Sucesso!',
                    text: 'Prova adicionada com sucesso',
                    timer: 2000,
                    showConfirmButton: false
                });
            },
            error: function(xhr) {
                console.error("Erro:", xhr);
                let errorMsg = "Não foi possível adicionar a prova";
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMsg = xhr.responseJSON.message;
                }
                Swal.fire("Erro", errorMsg, "error");
            },
            complete: function() {
                $btn.html(originalHtml);
                $btn.prop("disabled", false);
            }
        });
    });

    // Editar nome da prova
    $(document).on("click", ".editar-notaavaliacao", function() {
        let $th = $(this).closest('th');
        let $span = $th.find('.notanome');
        let texto = $span.text().trim();

        let $input = $('<input type="text" class="form-control form-control-sm input-notanome" style="width: 120px;">')
            .val(texto)
            .attr("oldvalue", texto)
            .attr("turma_id", $(this).attr("turma_id"))
            .attr("trimestre", $(this).attr("trimestre"))
            .attr("disciplina_id", $(this).attr("disciplina_id"))
            .attr("provaid", $(this).attr("provaid"));

        $span.replaceWith($input);
        $input.focus()[0].setSelectionRange(texto.length, texto.length);
    });

    // Salvar nome da prova após edição
    $(document).on("blur", ".input-notanome", function() {
        let novoTexto = $(this).val().trim();
        let antigo = $(this).attr("oldvalue");
        let $span = $('<span class="notanome"></span>').text(novoTexto || antigo);

        $(this).replaceWith($span);

        if (!novoTexto || novoTexto === antigo) return;

        let turma = $(this).attr("turma_id");
        let trimestre = $(this).attr("trimestre");
        let disciplina = $(this).attr("disciplina_id");
        let provaid = $(this).attr("provaid");

        $span.html('<i class="fas fa-spinner fa-spin text-primary"></i>');

        $.ajax({
            url: "/RegistoAcademico/notas/disciplinas/atualizarNome/" + turma + "/" + trimestre + "/" + provaid + "/" + disciplina,
            type: "GET",
            data: { novonome: novoTexto },
            success: function(data) {
                if (data.mensagem === "success") {
                    buscarnotasportrimestreturma(disciplina, turma, trimestre);
                } else {
                    $span.text(antigo);
                    Swal.fire("Erro", "Não foi possível salvar", "error");
                }
            },
            error: function() {
                $span.text(antigo);
                Swal.fire("Erro", "Não foi possível salvar", "error");
            }
        });
    });

    // Salvar fórmula
    $(document).on("click", "#btnSaveFormula", function() {
        const $btn = $(this);
        let liAtivo = document.querySelector(".Turma-elemento.active");
        const newFormula = $('#formulaInput').val().trim();
        const turmaId = liAtivo ? liAtivo.id : null;
        const divisao = $("#my-divisao").val();
        const anoLectivo = $('#my-anolectivo').val();
        const classe = $('#my-classe').val();
        const disciplinaId = $(".disciplina_id.active").data("disciplina-id");

        if (!newFormula) {
            Swal.fire("Aviso", "Insira uma fórmula válida", "warning");
            return;
        }

        if (!turmaId || !divisao || !anoLectivo || !classe || !disciplinaId) {
            Swal.fire("Erro", "Parâmetros incompletos", "error");
            return;
        }

        $('#formulaModal').modal('hide');
        setTimeout(() => $(".modal-backdrop").remove(), 300);

        $btn.html('<span class="spinner-border spinner-border-sm"></span> Salvando...');
        $btn.prop("disabled", true);

        $.ajax({
            url: `/RegistoAcademico/notas/disciplinas/guadarformulamedias/${turmaId}/${divisao}/${anoLectivo}/${classe}/${disciplinaId}`,
            type: 'POST',
            data: $("#formulaForm").serialize(),
            success: function(response) {
                $(".Conteudotabela").html(response);
                Swal.fire({ icon: 'success', title: 'Sucesso!', text: 'Fórmula guardada', timer: 1500, showConfirmButton: false });
            },
            error: function(xhr) {
                Swal.fire("Erro", "Erro ao salvar fórmula", "error");
            },
            complete: function() {
                $btn.html('<i class="fas fa-save"></i> Salvar Fórmula');
                $btn.prop("disabled", false);
            }
        });
    });

    // Apagar prova
    $(document).on('click', ".apagar-notaavaliacao", function() {
        let turma = $(this).attr('turma_id');
        let trimestre = $(this).attr('trimestre');
        let disciplina = $(this).attr('disciplina_id');
        let provaid = $(this).attr('provaid');
        let nomeProva = $(this).text().trim();

        let html = `
            <h5><i class="fa fa-warning text-warning"></i> Confirmar exclusão</h5>
            <hr>
            <p>Apagar a prova <strong>"${nomeProva}"</strong>?</p>
            <div class="row mt-3">
                <div class="col-6"><button class="btn btn-success btn-block apagar-notaavaliacaodados" turma_id="${turma}" trimestre="${trimestre}" disciplina_id="${disciplina}" provaid="${provaid}">Sim</button></div>
                <div class="col-6"><button class="btn btn-danger btn-block naoApagar-notaavaliacao">Não</button></div>
            </div>
        `;
        $(".conteudo_alert_iformacao").html(html);
        $("#modalalert").modal("show");
    });

    $(document).on('click', ".naoApagar-notaavaliacao", function() {
        $("#modalalert").modal("hide");
    });

    $(document).on('click', ".apagar-notaavaliacaodados", function() {
        $("#modalalert").modal("hide");

        let turma = $(this).attr('turma_id');
        let trimestre = $(this).attr('trimestre');
        let disciplina = $(this).attr('disciplina_id');
        let provaid = $(this).attr('provaid');

        $.ajax({
            url: "/RegistoAcademico/notas/disciplinas/apagarnota/" + turma + "/" + trimestre + "/" + provaid + "/" + disciplina,
            type: 'GET',
            success: function(data) {
                if (data.mensagem === "success") {
                    buscarnotasportrimestreturma(disciplina, turma, trimestre);
                    Swal.fire({ icon: 'success', title: 'Apagado!', timer: 1500, showConfirmButton: false });
                }
            }
        });
    });
</script>
<?php $__env->stopPush(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin-Lti', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\escolasaojoaopaulo\resources\views/registoAcademico/notas/notas-index.blade.php ENDPATH**/ ?>