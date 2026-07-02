<?php $__env->startSection('title', 'Configuração de Disciplinas'); ?>

<?php $__env->startSection('content'); ?>

<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

<style>
:root {
    --primary: #4f46e5;
    --primary-soft: #6366f1;
    --primary-dark: #4338ca;
    --secondary: #64748b;
    --success: #10b981;
    --success-dark: #059669;
    --danger: #ef4444;
    --danger-dark: #dc2626;
    --warning: #f59e0b;
    --info: #0ea5e9;
    --dark: #1e293b;
    --light: #f8fafc;
    --gray: #94a3b8;
}

body {
    background: linear-gradient(135deg, #f5f7fa 0%, #eef2f7 100%);
    min-height: 100vh;
}

/* Animações */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.fade-in-up {
    animation: fadeInUp 0.5s ease-out;
}

/* Título da Página */
.page-title {
    font-size: 28px;
    font-weight: 800;
    background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    letter-spacing: -0.5px;
}

.page-title i {
    background: none;
    -webkit-text-fill-color: var(--primary);
    margin-right: 10px;
}

/* Breadcrumb Moderno */
.breadcrumb-custom {
    background: rgba(255,255,255,0.9);
    backdrop-filter: blur(10px);
    padding: 8px 20px;
    border-radius: 50px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.03);
}

.breadcrumb-custom .breadcrumb-item a {
    color: var(--primary);
    text-decoration: none;
    font-weight: 500;
    transition: color 0.3s;
}

.breadcrumb-custom .breadcrumb-item a:hover {
    color: var(--primary-dark);
}

/* Cards Modernos */
.card-modern {
    border: none;
    border-radius: 24px;
    overflow: hidden;
    background: white;
    box-shadow: 0 20px 35px -10px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
    margin-bottom: 24px;
}

.card-modern:hover {
    transform: translateY(-5px);
    box-shadow: 0 25px 40px -12px rgba(0,0,0,0.15);
}

.card-header-modern {
    padding: 18px 24px;
    color: white;
    font-size: 16px;
    font-weight: 700;
    display: flex;
    align-items: center;
    justify-content: space-between;
    letter-spacing: 0.3px;
}

.card-header-modern i {
    margin-right: 10px;
    font-size: 18px;
}

/* Gradientes */
.bg-primary-modern {
    background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
}

.bg-success-modern {
    background: linear-gradient(135deg, var(--success) 0%, var(--success-dark) 100%);
}

.bg-info-modern {
    background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
}

/* Inputs e Selects */
.select-modern,
.input-modern {
    width: 100%;
    border: 2px solid #e2e8f0;
    border-radius: 14px;
    padding: 12px 16px;
    font-size: 14px;
    transition: all 0.3s ease;
    outline: none;
    background: white;
}

.select-modern:focus,
.input-modern:focus {
    border-color: var(--primary);
    box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1);
    transform: translateY(-1px);
}

.label-modern {
    font-size: 12px;
    font-weight: 700;
    margin-bottom: 8px;
    display: block;
    color: var(--dark);
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.label-modern i {
    margin-right: 6px;
    color: var(--primary);
}

/* Botões Modernos */
.btn-modern {
    border: none;
    border-radius: 14px;
    padding: 10px 20px;
    font-weight: 600;
    font-size: 14px;
    color: white;
    cursor: pointer;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

.btn-modern:hover {
    transform: translateY(-2px);
    filter: brightness(105%);
    box-shadow: 0 8px 20px rgba(0,0,0,0.15);
}

.btn-primary-modern {
    background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
}

.btn-success-modern {
    background: linear-gradient(135deg, var(--success) 0%, var(--success-dark) 100%);
}

.btn-outline-modern {
    background: transparent;
    border: 2px solid var(--gray);
    color: var(--secondary);
}

.btn-outline-modern:hover {
    background: var(--secondary);
    border-color: var(--secondary);
    color: white;
}

/* Botões de Ação */
.action-btn {
    width: 36px;
    height: 36px;
    border: none;
    border-radius: 12px;
    color: white;
    margin: 0 3px;
    transition: all 0.2s ease;
    cursor: pointer;
}

.action-btn:hover {
    transform: scale(1.08);
    filter: brightness(110%);
}

.btn-edit {
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
}

.btn-delete {
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
}

.btn-add {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
}

.btn-remove {
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
}

/* Tabela Moderna */
.table-modern {
    border-radius: 16px;
    overflow: hidden;
}

.table-modern thead {
    background: #f1f5f9;
}

.table-modern thead th {
    border: none;
    font-size: 12px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: var(--dark);
    padding: 15px;
}

.table-modern tbody tr:hover {
    background: #f8fafc;
}

.table-modern tbody td {
    padding: 14px 15px;
    vertical-align: middle;
}

/* Lista de Disciplinas Lecionadas */
.list-item-modern {
    padding: 16px 20px;
    border-bottom: 1px solid #f1f5f9;
    display: flex;
    justify-content: space-between;
    align-items: center;
    transition: all 0.2s ease;
    background: white;
}

.list-item-modern:hover {
    background: linear-gradient(90deg, #f8fafc 0%, #ffffff 100%);
}

.list-item-modern strong {
    font-size: 15px;
    color: var(--dark);
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 50px 20px;
}

.empty-state i {
    font-size: 48px;
    color: #cbd5e1;
    margin-bottom: 15px;
}

.empty-state p {
    color: var(--gray);
    font-size: 14px;
}

/* Modal Moderno */
.modal-content {
    border: none;
    border-radius: 28px;
    overflow: hidden;
    box-shadow: 0 30px 50px rgba(0,0,0,0.2);
}

.modal-header {
    background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
    color: white;
    border: none;
    padding: 20px 24px;
}

.modal-header .close {
    color: white;
    opacity: 0.8;
    font-size: 28px;
    text-shadow: none;
}

.modal-header .close:hover {
    opacity: 1;
}

.modal-body {
    padding: 28px;
}

.modal-footer {
    border: none;
    padding: 20px 28px;
    background: #f8fafc;
}

/* DataTables */
.dataTables_wrapper .dataTables_filter input {
    border-radius: 40px !important;
    border: 2px solid #e2e8f0 !important;
    padding: 8px 15px 8px 38px !important;
    background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="%2394a3b8" stroke-width="2"><circle cx="10" cy="10" r="7"/><line x1="21" y1="21" x2="15" y2="15"/></svg>');
    background-repeat: no-repeat;
    background-position: 12px center;
}

.dataTables_wrapper .dataTables_paginate .paginate_button.current {
    background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%) !important;
    border: none !important;
    color: white !important;
    border-radius: 10px !important;
}

/* Scrollbar */
::-webkit-scrollbar {
    width: 8px;
}

::-webkit-scrollbar-track {
    background: #f1f5f9;
    border-radius: 10px;
}

::-webkit-scrollbar-thumb {
    background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
    border-radius: 10px;
}

/* Responsivo */
@media (max-width: 768px) {
    .page-title { font-size: 22px; }
    .action-btn { width: 32px; height: 32px; }
    .card-header-modern { padding: 14px 18px; }
}
</style>

<!-- ============================================ -->
<!-- MAIN CONTAINER -->
<!-- ============================================ -->
<div class="container-fluid mt-4 fade-in-up">

    <!-- ==================== HEADER ==================== -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
        <div>
            <h1 class="page-title">
                <i class="fas fa-chalkboard-user"></i>
                Configuração de Disciplinas
            </h1>
            <p class="text-muted mt-2 mb-0">
                Gerencie as disciplinas e a direção das turmas
            </p>
        </div>

        <ol class="breadcrumb breadcrumb-custom m-0">
            <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i> Início</a></li>
            <li class="breadcrumb-item"><a href="#">Registo Académico</a></li>
            <li class="breadcrumb-item">Turma</li>
            <li class="breadcrumb-item active text-primary">Disciplinas</li>
        </ol>
    </div>

    <!-- ==================== FILTROS ==================== -->
    <div class="card-modern">
        <div class="card-header-modern bg-primary-modern">
            <span><i class="fas fa-sliders-h"></i> Filtros de Configuração</span>
            <i class="fas fa-chevron-down"></i>
        </div>
        <div class="p-4">
            <div class="row g-4">
                <div class="col-md-6">
                    <label class="label-modern"><i class="fas fa-chalkboard-user"></i> Classe / Turma</label>
                    <select id="classe_id" class="select-modern">
                        <?php $__currentLoopData = $classes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($item->id); ?>">📚 <?php echo e($item->Descricao); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="label-modern"><i class="fas fa-calendar-alt"></i> Ano Lectivo</label>
                    <select id="anolectivo_id" class="select-modern">
                        <?php $__currentLoopData = $anolectivo; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($item->id); ?>">🗓️ <?php echo e($item->anolectivo); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- ==================== CONTEÚDO PRINCIPAL ==================== -->
    <div class="row g-4">

        <!-- COLUDA ESQUERDA - DISCIPLINAS DISPONÍVEIS -->
        <div class="col-lg-4">
            <div class="card-modern h-100">
                <div class="card-header-modern bg-info-modern">
                    <span><i class="fas fa-book-open"></i> Disciplinas Disponíveis</span>
                    <button class="btn-modern btn-success-modern addnewdisciplina">
                        <i class="fas fa-plus-circle"></i> Nova
                    </button>
                </div>
                <div class="p-0">
                    <table id="tabelaDisciplinas" class="table table-modern w-100">
                        <thead>
                            <tr>
                                <th><i class="fas fa-folder-open"></i> Disciplina</th>
                                <th width="130"><i class="fas fa-tools"></i> Ações</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- COLUNA DIREITA - DIREÇÃO + DISCIPLINAS LECIONADAS -->
        <div class="col-lg-8">

            <!-- DIREÇÃO DA TURMA -->
            <div class="card-modern">
                <div class="card-header-modern bg-success-modern">
                    <span><i class="fas fa-users"></i> Direção da Turma</span>
                    <i class="fas fa-user-check"></i>
                </div>
                <div class="p-4">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="label-modern"><i class="fas fa-user-tie"></i> Diretor de Turma</label>
                            <select id="diretor_id" class="select-modern">
                                <option value="">👨‍🏫 Selecionar Diretor</option>
                                <?php $__currentLoopData = $directores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($item->id); ?>">👤 <?php echo e($item->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="label-modern"><i class="fas fa-user-friends"></i> Diretor Adjunto</label>
                            <select id="diretor_adjunto_id" class="select-modern">
                                <option value="">👩‍🏫 Selecionar Adjunto</option>
                                <?php $__currentLoopData = $adjuntos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($item->id); ?>">👤 <?php echo e($item->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- DISCIPLINAS LECIONADAS -->
            <div class="card-modern">
                <div class="card-header-modern bg-primary-modern">
                    <span><i class="fas fa-chalkboard"></i> Disciplinas Lecionadas</span>
                    <i class="fas fa-check-circle"></i>
                </div>
                <div id="disciplinasLecionadasContainer">
                    <div class="empty-state">
                        <i class="fas fa-book fa-3x"></i>
                        <p class="text-muted mb-0">Nenhuma disciplina carregada</p>
                        <small class="text-muted">Selecione uma classe e ano lectivo</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ==================== MODAL ==================== -->
<div class="modal fade" id="exampleModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5><i class="fas fa-plus-circle me-2"></i> <span id="tituloModal">Nova Disciplina</span></h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="mb-4">
                    <label class="label-modern"><i class="fas fa-tag"></i> Nome da Disciplina</label>
                    <input type="text" id="disciplinanome" class="input-modern" placeholder="Ex: Matemática">
                </div>
                <div class="mb-4">
                    <label class="label-modern"><i class="fas fa-code"></i> Sigla</label>
                    <input type="text" id="disciplinSigla" class="input-modern" placeholder="Ex: MAT">
                </div>
                <div class="mb-3">
                    <label class="label-modern"><i class="fas fa-layer-group"></i> Área da Disciplina</label>
                    <select id="tipoDesciplina" class="select-modern">
                        <?php $__currentLoopData = $tipo; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($item->id); ?>"><?php echo e($item->Descricao); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn-modern btn-outline-modern" data-dismiss="modal"><i class="fas fa-times"></i> Cancelar</button>
                <button id="btnSalvar" class="btn-modern btn-primary-modern"><i class="fas fa-save"></i> Guardar</button>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script src="<?php echo e(asset('Admin-LTE/plugins/jquery/jquery.min.js')); ?>"></script>
<script src="<?php echo e(asset('Datatable/js/jquery.dataTables.min.js')); ?>"></script>
<script src="<?php echo e(asset('Admin-LTE/plugins/bootstrap/js/bootstrap.bundle.min.js')); ?>"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
// ============================================
// VARIÁVEIS GLOBAIS
// ============================================
let tabelaDisciplinas;
let disciplinaEditando = null;

// ============================================
// CSRF SETUP
// ============================================
$.ajaxSetup({
    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
});

// ============================================
// DOCUMENT READY
// ============================================
$(document).ready(function () {
    inicializarTabela();
    carregarTudo();

    $('#classe_id, #anolectivo_id').on('change', function () { carregarTudo(); });
    $('#diretor_id, #diretor_adjunto_id').on('change', function () { salvarDirecao(); });
});

// ============================================
// DATATABLE
// ============================================
function inicializarTabela() {
    if ($.fn.DataTable.isDataTable('#tabelaDisciplinas')) {
        $('#tabelaDisciplinas').DataTable().destroy();
    }

    tabelaDisciplinas = $('#tabelaDisciplinas').DataTable({
        responsive: true,
        language: {
            search: "🔍 Pesquisar:",
            lengthMenu: "Mostrar _MENU_ registos",
            zeroRecords: "📭 Nenhum registo encontrado",
            info: "Mostrando _START_ até _END_ de _TOTAL_",
            infoEmpty: "Nenhum dado disponível",
            paginate: { first: "⏮", last: "⏭", next: "▶", previous: "◀" }
        },
        pageLength: 8,
        columnDefs: [{ orderable: false, targets: 1 }]
    });
}

// ============================================
// CARREGAR DADOS
// ============================================
function carregarTudo() {
    let classe = $('#classe_id').val();
    let ano = $('#anolectivo_id').val();

    if (classe && ano) {
        carregarDisciplinas(classe, ano);
        carregarDisciplinasLecionadas(classe, ano);
        carregarDirecao(classe, ano);
    }
}

// ============================================
// DISCIPLINAS DISPONÍVEIS
// ============================================
function carregarDisciplinas(classe, ano) {
    $.ajax({
        url: `/RegistoAcademico/notas/config/disciplinas/${classe}/${ano}`,
        type: 'GET',
        success: function (response) {
            tabelaDisciplinas.clear();

            if (response.naolecionadas?.length > 0) {
                response.naolecionadas.forEach(function (item) {
                    let nome = item.Descricao ?? '';
                    let nomeClean = nome.replace(/'/g, "\\'");

                    let botoes = `
                        <div class="d-flex justify-content-center gap-1">
                            <button class="action-btn btn-edit" onclick="editarDisciplina(${item.id}, '${nomeClean}', '${item.Sigla ?? ''}')" title="Editar"><i class="fas fa-edit"></i></button>
                            <button class="action-btn btn-delete" onclick="apagarDisciplina(${item.id}, '${nomeClean}')" title="Apagar"><i class="fas fa-trash"></i></button>
                            <button class="action-btn btn-add" onclick="adicionarDisciplinaTurma(${item.id}, '${nomeClean}')" title="Adicionar"><i class="fas fa-arrow-right"></i></button>
                        </div>
                    `;
                    tabelaDisciplinas.row.add([nome, botoes]);
                });
            } else {
                tabelaDisciplinas.row.add(['<span class="text-muted">📭 Nenhuma disciplina disponível</span>', '']);
            }
            tabelaDisciplinas.draw();
        },
        error: function () {
            Swal.fire({ icon: 'error', title: 'Erro', text: 'Erro ao carregar disciplinas' });
        }
    });
}

// ============================================
// DISCIPLINAS LECIONADAS
// ============================================
function carregarDisciplinasLecionadas(classe, ano) {
    $.ajax({
        url: `/RegistoAcademico/notas/config/disciplinas/lecionadas/${classe}/${ano}`,
        type: 'GET',
        success: function (response) {
            let html = '';

            if (response.lecionadas?.length > 0) {
                response.lecionadas.forEach(function (item) {
                    html += `
                        <div class="list-item-modern" data-id="${item.disciplina_id}">
                            <div>
                                <input type="hidden" name="disciplinas[]" value="${item.disciplina_id}">
                                <i class="fas fa-book text-primary me-3"></i>
                                <strong>${item.disciplinas}</strong>
                            </div>
                            <button class="action-btn btn-remove" onclick="removerDisciplina(this)" title="Remover"><i class="fas fa-times"></i></button>
                        </div>
                    `;
                });
            } else {
                html = `
                    <div class="empty-state py-5">
                        <i class="fas fa-inbox fa-4x text-muted"></i>
                        <p class="text-muted mt-3 mb-0">Nenhuma disciplina adicionada</p>
                        <small class="text-muted">Clique em <i class="fas fa-arrow-right"></i> para adicionar</small>
                    </div>
                `;
            }

            html += `<div class="p-3 text-end border-top"><button class="btn-modern btn-primary-modern" onclick="salvarDisciplinasTurma()"><i class="fas fa-save"></i> Salvar Alterações</button></div>`;
            $('#disciplinasLecionadasContainer').html(html);
        }
    });
}

// ============================================
// ADICIONAR À TURMA
// ============================================
function adicionarDisciplinaTurma(id, nome) {
    let existe = false;
    $('input[name="disciplinas[]"]').each(function () { if ($(this).val() == id) existe = true; });

    if (existe) {
        Swal.fire({ icon: 'warning', title: 'Aviso', text: 'Disciplina já adicionada' });
        return;
    }

    let html = `
        <div class="list-item-modern" data-id="${id}">
            <div><input type="hidden" name="disciplinas[]" value="${id}"><i class="fas fa-book text-primary me-3"></i><strong>${nome}</strong></div>
            <button class="action-btn btn-remove" onclick="removerDisciplina(this)" title="Remover"><i class="fas fa-times"></i></button>
        </div>
    `;

    $('#disciplinasLecionadasContainer').prepend(html);
    // if ($('#disciplinasLecionadasContainer .empty-state').length) location.reload();
    Toast.fire({ icon: 'success', title: `"${nome}" adicionada` });
}

// ============================================
// REMOVER DA TURMA
// ============================================
function removerDisciplina(botao) {
    let item = $(botao).closest('.list-item-modern');
    let nome = item.find('strong').text();

    Swal.fire({
        title: 'Remover disciplina?',
        text: `Remover "${nome}" da lista?`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#dc2626',
        confirmButtonText: 'Sim, remover',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            item.remove();
            Toast.fire({ icon: 'success', title: 'Disciplina removida' });
        }
    });
}

// ============================================
// SALVAR DISCIPLINAS DA TURMA
// ============================================
function salvarDisciplinasTurma() {
    let disciplinas = [];
    $('input[name="disciplinas[]"]').each(function () { disciplinas.push($(this).val()); });

    let classe = $('#classe_id').val();
    let ano = $('#anolectivo_id').val();

    Swal.fire({
        title: 'Guardar alterações?',
        text: `Deseja salvar ${disciplinas.length} disciplina(s)?`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Sim, guardar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({ title: 'A processar...', allowOutsideClick: false, didOpen: () => Swal.showLoading() });

            $.ajax({
                url: `/RegistoAcademico/notas/disciplinas/atualizardisplinas/novas/${classe}/${ano}`,
                type: 'POST',
                data: { disciplinas: disciplinas },
                success: function () {
                    Swal.close();
                    Swal.fire({ icon: 'success', title: 'Sucesso!', text: 'Disciplinas atualizadas', timer: 2000 });
                    carregarTudo();
                },
                error: function () {
                    Swal.close();
                    Swal.fire({ icon: 'error', title: 'Erro', text: 'Erro ao guardar' });
                }
            });
        }
    });
}

// ============================================
// MODAL - NOVA DISCIPLINA
// ============================================
$('.addnewdisciplina').on('click', function () {
    disciplinaEditando = null;
    $('#tituloModal').text('➕ Nova Disciplina');
    $('#disciplinanome').val('');
    $('#disciplinSigla').val('');
    $('#tipoDesciplina').val('');
    $('#exampleModal').modal('show');
});

// ============================================
// SALVAR DISCIPLINA (NOVA/EDIÇÃO)
// ============================================
$('#btnSalvar').on('click', function () {
    let nome = $('#disciplinanome').val().trim();
    let sigla = $('#disciplinSigla').val().trim();
    let tipo = $('#tipoDesciplina').val();
    let classeId = $('#classe_id').val();
    let anoLectivo = $('#anolectivo_id').val();

    if (!nome) {
        Swal.fire({ icon: 'warning', title: 'Campo obrigatório', text: 'Digite o nome da disciplina' });
        $('#disciplinanome').focus();
        return;
    }
    if (!sigla) {
        Swal.fire({ icon: 'warning', title: 'Campo obrigatório', text: 'Digite a sigla' });
        $('#disciplinSigla').focus();
        return;
    }

    Swal.fire({ title: 'A processar...', allowOutsideClick: false, didOpen: () => Swal.showLoading() });

    $.ajax({
        url: '/RegistoAcademico/notas/disciplinas/guardar/novas',
        type: 'POST',
        data: { novadisp: nome, sigla: sigla, tipo: tipo, id: disciplinaEditando, classes: classeId, anolectivo: anoLectivo },
        success: function (response) {
            Swal.close();
            if (response.alert === "success") {
                Swal.fire({ icon: 'success', title: 'Sucesso!', text: disciplinaEditando ? 'Disciplina atualizada' : 'Disciplina guardada', timer: 2000 });
                $('#exampleModal').modal('hide');
                carregarTudo();
                disciplinaEditando = null;
            } else {
                Swal.fire({ icon: 'error', title: 'Erro', text: response.message || 'Erro ao guardar' });
            }
        },
        error: function () {
            Swal.close();
            Swal.fire({ icon: 'error', title: 'Erro', text: 'Erro ao guardar disciplina' });
        }
    });
});

// ============================================
// EDITAR DISCIPLINA
// ============================================
function editarDisciplina(id, nome, sigla) {
    disciplinaEditando = id;
    $('#tituloModal').text('✏️ Editar Disciplina');
    $('#disciplinanome').val(nome);
    $('#disciplinSigla').val(sigla);
    $('#exampleModal').modal('show');
}

// ============================================
// APAGAR DISCIPLINA
// ============================================
function apagarDisciplina(id, nome) {
    Swal.fire({
        title: `Apagar "${nome}"?`,
        text: 'Esta ação não pode ser desfeita!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc2626',
        confirmButtonText: 'Sim, apagar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({ title: 'A processar...', allowOutsideClick: false, didOpen: () => Swal.showLoading() });

            $.ajax({
                url: `/RegistoAcademico/notas/disciplinas/delete/novas/${id}`,
                type: 'GET',
                success: function (response) {
                    Swal.close();
                    if (response.alert === "success") {
                        Swal.fire({ icon: 'success', title: 'Apagado!', text: 'Disciplina removida', timer: 2000 });
                        carregarTudo();
                    } else {
                        Swal.fire({ icon: 'error', title: 'Erro', text: 'Não é possível apagar esta disciplina' });
                    }
                },
                error: function () {
                    Swal.close();
                    Swal.fire({ icon: 'error', title: 'Erro', text: 'Erro ao apagar disciplina' });
                }
            });
        }
    });
}

// ============================================
// DIREÇÃO DA TURMA
// ============================================
function carregarDirecao(classe, ano) {
    $.ajax({
        url: `/RegistoAcademico/notas/config/direcao/selecionar/classe/${classe}/${ano}`,
        type: 'GET',
        success: function (response) {
            $('#diretor_id').val(response.director_id || '');
            $('#diretor_adjunto_id').val(response.pedagogico_id || '');
        }
    });
}

function salvarDirecao() {
    let classe = $('#classe_id').val();
    let ano = $('#anolectivo_id').val();
    if (!classe || !ano) return;

    $.ajax({
        url: `/RegistoAcademico/notas/config/direcao/classe/${classe}/${ano}`,
        type: 'POST',
        data: { director_id: $('#diretor_id').val(), pedagogico_id: $('#diretor_adjunto_id').val() },
        success: function () { Toast.fire({ icon: 'success', title: 'Direção atualizada' }); }
    });
}

// ============================================
// TOAST
// ============================================
const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 2500,
    timerProgressBar: true
});
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin-Lti', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/sgemozco/escolasaojoaopauloii.sgemoz.com/resources/views/registoAcademico/notas/configurar-classe.blade.php ENDPATH**/ ?>