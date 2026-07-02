<?php $__env->startSection('content'); ?>
<style>
    /* Animações e estilos modernos */
    .fade-in {
        animation: fadeIn 0.4s ease-out;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Card Moderno */
    .card-modern {
        border: none;
        border-radius: 24px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .card-modern:hover {
        box-shadow: 0 15px 50px rgba(0, 0, 0, 0.12);
    }

    .card-header-modern {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 20px 25px;
        color: white;
    }

    .card-header-modern h4 {
        margin: 0;
        font-weight: 600;
    }

    .card-header-modern p {
        margin: 5px 0 0;
        opacity: 0.9;
    }

    .card-body-modern {
        padding: 25px;
    }

    /* Barra de pesquisa */
    .search-wrapper {
        background: white;
        border-radius: 60px;
        padding: 5px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
        margin-bottom: 25px;
    }

    .search-wrapper:focus-within {
        box-shadow: 0 4px 20px rgba(102, 126, 234, 0.2);
        transform: translateY(-2px);
    }

    .search-wrapper .input-group-text {
        background: transparent;
        border: none;
        color: #667eea;
        font-size: 1.2rem;
    }

    .search-wrapper input {
        border: none;
        padding: 12px 0;
        font-size: 0.95rem;
    }

    .search-wrapper input:focus {
        box-shadow: none;
    }

    /* Tabela Moderna */
    .table-modern {
        width: 100%;
        margin-bottom: 0;
    }

    .table-modern thead th {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        font-weight: 600;
        padding: 15px;
        border: none;
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .table-modern tbody tr {
        transition: all 0.2s ease;
        border-bottom: 1px solid #e5e7eb;
    }

    .table-modern tbody tr:hover {
        background: #f8fafc;
        transform: translateX(5px);
    }

    .table-modern tbody td {
        padding: 12px 15px;
        vertical-align: middle;
        color: #374151;
    }

    /* Botões de Ação */
    .btn-action {
        width: 32px;
        height: 32px;
        padding: 0;
        border-radius: 10px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
        margin: 0 3px;
    }

    .btn-action i {
        font-size: 0.9rem;
    }

    .btn-action:hover {
        transform: translateY(-2px);
    }

    .btn-edit {
        background: linear-gradient(135deg, #4299e1 0%, #3182ce 100%);
        color: white;
        border: none;
    }

    .btn-delete {
        background: linear-gradient(135deg, #f56565 0%, #c53030 100%);
        color: white;
        border: none;
    }

    /* Badges */
    .badge-level {
        background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
        color: white;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 600;
    }

    .badge-category {
        background: linear-gradient(135deg, #ed8936 0%, #dd6b20 100%);
        color: white;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 600;
    }

    /* Avatar na tabela */
    .avatar-table {
        width: 35px;
        height: 35px;
        border-radius: 50%;
        object-fit: cover;
        margin-right: 10px;
    }

    /* DataTables Custom */
    .dataTables_wrapper .dataTables_length select {
        border-radius: 8px;
        border: 2px solid #e5e7eb;
        padding: 5px 10px;
        margin: 0 8px;
    }

    .dataTables_wrapper .dataTables_filter {
        display: none;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button {
        border-radius: 8px;
        padding: 6px 12px;
        margin: 0 2px;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        color: white !important;
    }

    .dataTables_wrapper .dt-buttons {
        margin-bottom: 15px;
    }

    .dataTables_wrapper .dt-buttons .btn {
        border-radius: 8px;
        margin-right: 5px;
        padding: 5px 12px;
        font-size: 0.8rem;
    }

    /* Footer filters */
    tfoot .form-control-sm {
        border-radius: 8px;
        border: 2px solid #e5e7eb;
        padding: 5px 10px;
        font-size: 0.8rem;
    }

    /* Responsivo */
    @media (max-width: 768px) {
        .card-body-modern {
            padding: 15px;
        }

        .table-modern thead th {
            font-size: 0.7rem;
            padding: 10px;
        }

        .table-modern tbody td {
            padding: 8px 10px;
            font-size: 0.85rem;
        }

        .btn-action {
            width: 28px;
            height: 28px;
        }

        .dataTables_wrapper .dt-buttons .btn {
            padding: 4px 8px;
            font-size: 0.7rem;
        }
    }

    /* Empty state */
    .empty-state {
        text-align: center;
        padding: 40px 20px;
        color: #9ca3af;
    }

    .empty-state i {
        font-size: 4rem;
        margin-bottom: 15px;
        opacity: 0.5;
    }

    /* Tooltip */
    [data-tooltip] {
        position: relative;
        cursor: pointer;
    }

    [data-tooltip]:before {
        content: attr(data-tooltip);
        position: absolute;
        bottom: 100%;
        left: 50%;
        transform: translateX(-50%);
        padding: 5px 10px;
        background: #1f2937;
        color: white;
        font-size: 0.7rem;
        border-radius: 6px;
        white-space: nowrap;
        opacity: 0;
        pointer-events: none;
        transition: all 0.3s ease;
        z-index: 1000;
    }

    [data-tooltip]:hover:before {
        opacity: 1;
        transform: translateX(-50%) translateY(-5px);
    }
</style>

<div class="container-fluid fade-in">
    <!-- Breadcrumb -->
    <div class="breadcrumb-modern">
        <ol class="breadcrumb" style="background: transparent; margin: 0; padding: 0;">
            <li class="breadcrumb-item">
                <a href="#"><i class="fa fa-cogs"></i> Gestão Administrativa</a>
            </li>
            <li class="breadcrumb-item">
                <a href="#"><i class="fa fa-users"></i> Utilizadores</a>
            </li>
            <li class="breadcrumb-item active">
                <i class="fa fa-list"></i> <b>Lista de Utilizadores</b>
            </li>
        </ol>
    </div>

    <!-- Card Principal -->
    <div class="row">
        <div class="col-12">
            <div class="card-modern">
                <div class="card-header-modern">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4>
                                <i class="fa fa-users mr-2"></i> Lista de Utilizadores
                            </h4>
                            <p class="mb-0">Gerencie todos os utilizadores do sistema</p>
                        </div>
                        <div>
                            <span class="badge bg-light text-dark">
                                <i class="fa fa-database mr-1"></i>
                                Total: <?php echo e($usuario->count()); ?> utilizadores
                            </span>
                        </div>
                    </div>
                </div>

                <div class="card-body-modern">
                    <!-- Barra de Pesquisa -->
                    <div class="search-wrapper">
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fa fa-search"></i>
                            </span>
                            <input type="text" id="searchFarmacos" class="form-control"
                                   placeholder="Pesquisar por nome, email, nível ou categoria...">
                        </div>
                    </div>

                    <!-- Tabela -->
                    <div class="table-responsive">
                        <table id="funcionarios" class="table-modern display" style="width:100%">
                            <thead>
                                <tr>
                                    <th><i class="fa fa-hashtag"></i> Nr</th>
                                    <th><i class="fa fa-user"></i> Nome</th>
                                    <th><i class="fa fa-layer-group"></i> Nível</th>
                                    <th><i class="fa fa-briefcase"></i> Categoria</th>
                                    <th><i class="fa fa-envelope"></i> Email</th>
                                    <?php if(Gate::check('Atualizar-Usuario') || Gate::check('Apagar-usuario')): ?>
                                        <th><i class="fa fa-cog"></i> Ações</th>
                                    <?php endif; ?>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <th>
                                        <select class="form-control form-control-sm filtro-coluna">
                                            <option value="">Todos os níveis</option>
                                            <?php $__currentLoopData = $usuario->map(fn($u) => optional($u->nivel)->Descricao)->unique()->filter(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $nivel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($nivel); ?>"><?php echo e($nivel); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </th>
                                    <th>
                                        <select class="form-control form-control-sm filtro-coluna">
                                            <option value="">Todas as categorias</option>
                                            <?php $__currentLoopData = $usuario->map(fn($u) => optional($u->categoria->last())->Descricao)->unique()->filter(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categoria): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($categoria); ?>"><?php echo e($categoria); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </th>
                                    <th></th>
                                    <?php if(Gate::check('Atualizar-Usuario') || Gate::check('Apagar-usuario')): ?>
                                        <th></th>
                                    <?php endif; ?>
                                </tr>
                            </tfoot>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $usuario; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $usuarioItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td>
                                            <span class="badge" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 5px 10px; border-radius: 10px;">
                                                <?php echo e($key + 1); ?>

                                            </span>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <?php if($usuarioItem->avatar ?? false): ?>
                                                    <img src="<?php echo e(asset('storage/' . $usuarioItem->avatar)); ?>"
                                                         class="avatar-table"
                                                         alt="Avatar"
                                                         onerror="this.src='<?php echo e(asset('Admin-LTE/dist/img/avatar.png')); ?>'">
                                                <?php endif; ?>
                                                <strong><?php echo e($usuarioItem->name); ?></strong>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge-level">
                                                <i class="fa fa-layer-group"></i> <?php echo e(optional($usuarioItem->nivel)->Descricao ?? 'N/A'); ?>

                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge-category">
                                                <i class="fa fa-briefcase"></i> <?php echo e(optional($usuarioItem->categoria->last())->Descricao ?? 'N/A'); ?>

                                            </span>
                                        </td>
                                        <td>
                                            <a href="mailto:<?php echo e($usuarioItem->email); ?>" class="text-decoration-none">
                                                <i class="fa fa-envelope-o text-muted"></i> <?php echo e($usuarioItem->email); ?>

                                            </a>
                                        </td>
                                        <?php if(Gate::check('Atualizar-Usuario') || Gate::check('Apagar-usuario')): ?>
                                            <td>
                                                <div class="d-flex gap-2">
                                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Atualizar-Usuario')): ?>
                                                        <a class="btn-action btn-edit"
                                                           href="<?php echo e(route('Usuarios.edit', $usuarioItem->id)); ?>"
                                                           data-tooltip="Editar Utilizador">
                                                            <i class="fa fa-edit"></i>
                                                        </a>
                                                    <?php endif; ?>
                                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Apagar-usuario')): ?>
                                                        <button class="btn-action btn-delete btn-delete-user"
                                                                data-id="<?php echo e($usuarioItem->id); ?>"
                                                                data-name="<?php echo e($usuarioItem->name); ?>"
                                                                data-tooltip="Eliminar Utilizador">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                        <?php endif; ?>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="6" class="text-center">
                                            <div class="empty-state">
                                                <i class="fa fa-users"></i>
                                                <p>Nenhum utilizador encontrado</p>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('script'); ?>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="<?php echo e(asset('Datatable/js/dataTables.responsive.min.js')); ?>"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function () {
        // Inicializar DataTable
        const table = $('#funcionarios').DataTable({
            dom: '<"row"<"col-sm-12 col-md-6"B><"col-sm-12 col-md-6"l>>rt<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
            buttons: [
                { extend: 'copy', text: '<i class="fa fa-copy"></i> Copiar', className: 'btn btn-sm btn-primary' },
                { extend: 'excel', text: '<i class="fa fa-file-excel"></i> Excel', className: 'btn btn-sm btn-success' },
                { extend: 'pdf', text: '<i class="fa fa-file-pdf"></i> PDF', className: 'btn btn-sm btn-danger' },
                { extend: 'print', text: '<i class="fa fa-print"></i> Imprimir', className: 'btn btn-sm btn-info' }
            ],
            responsive: true,
            paging: true,
            lengthChange: true,
            searching: true,
            ordering: true,
            info: true,
            autoWidth: false,
            pageLength: 10,
            lengthMenu: [[5, 10, 25, 50, 100, -1], [5, 10, 25, 50, 100, "Todos"]],
            language: {
                url: "/Datatable/pt/Portuguese-Brasil.json"
            },
            initComplete: function () {
                // Configurar filtros das colunas
                this.api().columns().every(function () {
                    const column = this;
                    const select = $(column.footer()).find('select');
                    if (select.length) {
                        select.on('change', function () {
                            const val = $.fn.dataTable.util.escapeRegex($(this).val());
                            column.search(val ? '^' + val + '$' : '', true, false).draw();
                        });
                    }
                });
            }
        });

        // Pesquisa global
        $('#searchFarmacos').on('keyup', function () {
            table.search(this.value).draw();
        });

        // Eliminar utilizador com confirmação
        $(document).on('click', '.btn-delete-user', function() {
            const userId = $(this).data('id');
            const userName = $(this).data('name');

            Swal.fire({
                title: 'Confirmar Eliminação',
                text: `Tem certeza que deseja eliminar o utilizador "${userName}"?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: '<i class="fa fa-trash mr-2"></i> Sim, eliminar',
                cancelButtonText: '<i class="fa fa-times mr-2"></i> Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "<?php echo e(route('Usuarios.show', '')); ?>/" + userId;
                }
            });
        });
    });
</script>

<style>
    #funcionarios_filter {
        display: none;
    }

    .gap-2 {
        gap: 8px;
    }

    .text-decoration-none {
        text-decoration: none;
        color: #374151;
        transition: all 0.2s ease;
    }

    .text-decoration-none:hover {
        color: #667eea;
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin-Lti', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/sgemozco/escolasaojoaopauloii.sgemoz.com/resources/views/auth/usuario-funcionario.blade.php ENDPATH**/ ?>