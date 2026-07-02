<?php $__env->startSection('title', 'Atribuição de Turmas'); ?>

<?php $__env->startSection('content'); ?>
 <div class="breadcrumb-modern animate-fadeInUp">
        <ol class="breadcrumb" style="background: transparent; margin: 0; padding: 0;">
             <li class="breadcrumb-item">
                <a href="#"><i class="fa fa-graduation-cap"></i> Registo Académico</a>
            </li>
            <li class="breadcrumb-item">
                <a href="#"><i class="fa fa-sitemap"></i> Gestão Turmas</a>
            </li>

            <li class="breadcrumb-item active">
                <i class="fa fa-plus-exchange "></i> <b>atribuir turma </b>
            </li>
        </ol>
    </div>

<div class="">


    <section class="content">
        <div class="container-fluid">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-list"></i> Lista de Professores</h5>
                    <button class="btn btn-sm btn-light" id="btnRefresh">
                        <i class="fas fa-sync-alt"></i> Atualizar
                    </button>
                </div>

                <div class="card-body p-0">
                    <div class="row no-gutters">
                        <!-- Professor List Column -->
                        <div class="col-md-5 border-right">
                            <div class="p-3">
                                <table class="table table-hover table-sm" id="professoresTable">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th width="10%">Nr</th>
                                            <th>Nome</th>
                                            <th width="15%" class="text-center">Ação</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__currentLoopData = $dfuncionarios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $professor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr data-id="<?php echo e($professor->id); ?>">
                                                <td><?php echo e($key + 1); ?></td>
                                                <td><?php echo e($professor->name); ?></td>
                                                <td class="text-center">
                                                    <button class="btn btn-sm btn-outline-primary btn-view"
                                                            data-id="<?php echo e($professor->id); ?>">
                                                        <i class="fas fa-chevron-right"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Professor Details Column -->
                        <div class="col-md-7">
                            <div class="h-100 d-flex flex-column">
                                <div class="bg-light p-3 border-bottom d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0"><i class="fas fa-info-circle"></i> Detalhes do Professor</h5>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <button type="button" class="btn btn-outline-secondary active" id="btnViewTab">
                                            <i class="fas fa-eye"></i> Visualizar
                                        </button>
                                        <button type="button" class="btn btn-outline-secondary" id="btnAddTab">
                                            <i class="fas fa-plus"></i> Adicionar
                                        </button>
                                    </div>
                                </div>

                                <div class="flex-grow-1 overflow-auto p-3">
                                    <div id="view-content" class="content-tab">
                                        <div class="text-center text-muted py-5">
                                            <i class="fas fa-user-graduate fa-3x mb-3"></i>
                                            <p>Selecione um professor para visualizar detalhes</p>
                                        </div>
                                    </div>
                                    <div id="add-content" class="content-tab" style="display:none">
                                        <div class="text-center text-muted py-5">
                                            <i class="fas fa-plus-circle fa-3x mb-3"></i>
                                            <p>Selecione um professor para adicionar turmas</p>
                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">
<style>
    #professoresTable tr.selected-row {
        background-color: rgba(0, 123, 255, 0.1);
        position: relative;
    }

    #professoresTable tr.selected-row::after {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 3px;
        background-color: #007bff;
    }

    .table-hover tbody tr:hover {
        background-color: #f8f9fa;
    }

    .content-tab {
        min-height: 300px;
    }

    .card-body {
        background-color: #f8fafc;
    }

    .border-right {
        border-right: 1px solid #dee2e6 !important;
    }

    .overflow-auto {
        overflow: auto;
        max-height: 60vh;
    }

    .turma-badge {
        font-size: 0.8rem;
        margin-right: 5px;
        margin-bottom: 5px;
    }

    .ano-letivo-list .list-group-item.active {
        background-color: #007bff;
        border-color: #007bff;
    }

    .loading-spinner {
        display: inline-block;
        width: 1rem;
        height: 1rem;
        border: 2px solid rgba(0,0,0,.1);
        border-radius: 50%;
        border-top-color: #007bff;
        animation: spin 1s ease-in-out infinite;
    }

    @keyframes spin {
        to { transform: rotate(360deg); }
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>

<script>
$(document).ready(function() {
    // State management
    const state = {
        currentProfessorId: null,
        currentTab: 'view',
        anosLetivos: [],
        turmas: []
    };

    // Initialize DataTable
    const professoresTable = $('#professoresTable').DataTable({
        paging: true,
        lengthChange: false,
        pageLength: 10,
        searching: true,
        ordering: true,
        info: true,
        autoWidth: false,
        language: {
            url: '//cdn.datatables.net/plug-ins/1.10.25/i18n/Portuguese-Brasil.json'
        },
        initComplete: function() {
            // Add custom search input
            $('.dataTables_filter input').addClass('form-control form-control-sm')
                .attr('placeholder', 'Pesquisar...');
        }
    });

    // Refresh button
    $('#btnRefresh').click(function() {
        location.reload();
    });

    // Select professor
    $(document).on('click', '.btn-view', function() {
        const professorId = $(this).data('id');
        state.currentProfessorId = professorId;

        // Highlight selected row
        $('#professoresTable tr').removeClass('selected-row');
        $(this).closest('tr').addClass('selected-row');

        // Load initial content
        loadViewTab(professorId);
        showTab('view');
    });

    // Tab switching
    $('#btnViewTab').click(function() {
        if (!state.currentProfessorId) return;
        showTab('view');
        loadViewTab(state.currentProfessorId);
    });

    $('#btnAddTab').click(function() {
        if (!state.currentProfessorId) return;
        showTab('add');
        loadAddTab(state.currentProfessorId);
    });

    // Show tab function
    function showTab(tab) {
        state.currentTab = tab;
        $('.content-tab').hide();
        $(`#${tab}-content`).show();

        // Toggle active state of tab buttons
        $('#btnViewTab, #btnAddTab').removeClass('active');
        $(`#btn${tab.charAt(0).toUpperCase() + tab.slice(1)}Tab`).addClass('active');

        // Show/hide footer
        $('#detailFooter').toggle(tab === 'add');
    }

    // Load view tab content
    function loadViewTab(professorId) {
        const $viewContent = $('#view-content');

        $viewContent.html(`
            <div class="text-center py-4">
                <div class="loading-spinner"></div>
                <p class="mt-2">Carregando turmas...</p>
            </div>
        `);

        $.ajax({
            url: `/RegistoAcademico/turma/atriburi/professores/professoresselect/${professorId}/turma`,
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                state.anosLetivos = data.anos || [];
                state.turmas = data.turmas || {};

                renderViewContent();
            },
            error: function() {
                $viewContent.html(`
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-triangle"></i> Falha ao carregar turmas atribuídas
                    </div>
                `);
            }
        });
    }

    // Render view content
    function renderViewContent() {
        if (state.anosLetivos.length === 0) {
            $('#view-content').html(`
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i> Nenhuma turma atribuída a este professor.
                </div>
            `);
            return;
        }

        let html = `
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Turmas Atribuídas</h4>
                    <small class="text-muted">${state.anosLetivos.length} anos letivos</small>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="list-group" id="ano-letivo-list">
        `;

        // Add academic years as sidebar menu
        state.anosLetivos.forEach((ano, index) => {
            html += `
                <a href="#" class="list-group-item list-group-item-action ano-letivo-item ${index === 0 ? 'active' : ''}"
                   data-ano="${ano.ano_lectivo_id}">
                    ${ano.anolectivo}
                    <span class="badge badge-primary float-right">
                        ${state.turmas[ano.ano_lectivo_id]?.length || 0}
                    </span>
                </a>
            `;
        });

        html += `
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div id="turmas-container">
        `;

        // Add classes for the first academic year (default)
        const primeiroAnoId = state.anosLetivos[0]?.ano_lectivo_id;
        if (primeiroAnoId) {
            const turmasAno = state.turmas[primeiroAnoId] || [];
            html += renderTurmasTable(turmasAno);
        }

        html += `
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;

        $('#view-content').html(html);

        // Academic year click event
        $('.ano-letivo-item').on('click', function(e) {
            e.preventDefault();
            const anoId = $(this).data('ano');

            // Activate selected item
            $('.ano-letivo-item').removeClass('active');
            $(this).addClass('active');

            // Get classes for selected year
            const turmasAno = state.turmas[anoId] || [];
            $('#turmas-container').html(renderTurmasTable(turmasAno));
        });
    }

    // Render classes table
    function renderTurmasTable(turmas) {
        if (!turmas.length) {
            return `
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i> Nenhuma turma atribuída para este ano letivo.
                </div>
            `;
        }

        let html = `
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>Turma</th>
                            <th>Classe</th>
                            <th>Disciplina</th>
                        </tr>
                    </thead>
                    <tbody>
        `;

        turmas.forEach(turma => {
            html += `
                <tr>
                    <td>${turma.turma || '-'}</td>
                    <td>${turma.classe || '-'}</td>
                    <td>${turma.disciplinas || '-'}</td>
                </tr>
            `;
        });

        html += `
                    </tbody>
                </table>
            </div>
        `;

        return html;
    }

    // Load add tab content
    function loadAddTab(professorId) {
        const $addContent = $('#add-content');

        $addContent.html(`
            <div class="text-center py-4">
                <div class="loading-spinner"></div>
                <p class="mt-2">Carregando turmas disponíveis...</p>
            </div>
        `);

        $.ajax({
            url: `/RegistoAcademico/turma/atriburi/professor/${professorId}`,
            method: 'GET',
            success: function(data) {
                $addContent.html(data);
            },
            error: function() {
                $addContent.html(`
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-triangle"></i> Falha ao carregar turmas disponíveis
                    </div>
                `);
            }
        });
    }

    // Save assignments
    $(document).on('click', '#btnSalvarTurmas', function() {
        const $btn = $(this);
        const turmasSelecionadas = [];

        $('#add-content input[name="turmasid[]"]:checked').each(function() {
            turmasSelecionadas.push($(this).val());
        });

        const dados = {
            classe: $(".classes").val(),
            anolectivo:$(".anolectivo").val(),
            idprofessor: $('#add-content input[name="idprofessor"]').val(),
            disciplina_id: $('#add-content select[name="disciplina_id"]').val(),
            turma: turmasSelecionadas
        };


        $btn.prop('disabled', true).html(`
            <span class="loading-spinner"></span> Salvando...
        `);

        $.ajax({
            url: '/RegistoAcademico/turma/atriburi/professores/guardar',
            method: 'PUT',
            data: {
                dados: [dados],
                _token: '<?php echo e(csrf_token()); ?>'
            },
            success: function(response) {
                if (response.success) {
                    // Reload both tabs
                    loadViewTab(dados.idprofessor);
                    loadAddTab(dados.idprofessor);

                    // Switch back to view tab
                    showTab('view');

                    // Show success message
                    Swal.fire({
                        icon: 'success',
                        title: 'Sucesso',
                        text: 'Atribuições salvas com sucesso!',
                        confirmButtonColor: '#007bff',
                        timer: 2000
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Erro',
                        text: response.message || 'Erro ao salvar atribuições',
                        confirmButtonColor: '#007bff'
                    });
                }
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Erro',
                    text: 'Erro na comunicação com o servidor',
                    confirmButtonColor: '#007bff'
                });
            },
            complete: function() {
                $btn.prop('disabled', false).html(`
                    <i class="fas fa-save"></i> Salvar Alterações
                `);
            }
        });
    });
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin-Lti', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\escola2025\resources\views/auth/atribuirturma.blade.php ENDPATH**/ ?>