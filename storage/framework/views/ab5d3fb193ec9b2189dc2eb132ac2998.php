<?php $__env->startSection('title', 'Operações do Sistema'); ?>

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

    .slide-in {
        animation: slideIn 0.3s ease-out;
    }

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateX(-20px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    /* Cards */
    .card-modern {
        border: none;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        overflow: hidden;
    }

    .card-modern:hover {
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.12);
    }

    /* Lista de usuários */
    .users-list {
        max-height: 600px;
        overflow-y: auto;
    }

    .user-item {
        padding: 15px;
        border-bottom: 1px solid #e5e7eb;
        cursor: pointer;
        transition: all 0.2s ease;
        border-radius: 12px;
        margin: 5px 0;
    }

    .user-item:hover {
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
        transform: translateX(5px);
    }

    .user-item.active {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    .user-item.active .user-name {
        color: white;
    }

    .user-avatar {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: bold;
        font-size: 1.2rem;
    }

    .user-name {
        font-weight: 600;
        color: #374151;
        transition: all 0.2s ease;
    }

    .user-email {
        font-size: 0.75rem;
        color: #6b7280;
    }

    /* Header das operações */
    .operations-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 20px;
        border-bottom: none;
    }

    .operations-header h3 {
        margin: 0;
        font-weight: 600;
    }

    .operations-header p {
        margin: 5px 0 0;
        opacity: 0.9;
    }

    /* Tabela de operações */
    .table-operations {
        width: 100%;
        margin-bottom: 0;
    }

    .table-operations thead th {
        background: #f8f9fa;
        color: #374151;
        font-weight: 600;
        padding: 12px 15px;
        border: none;
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .table-operations tbody tr {
        transition: all 0.2s ease;
        border-bottom: 1px solid #e5e7eb;
    }

    .table-operations tbody tr:hover {
        background: #f8fafc;
    }

    .table-operations tbody td {
        padding: 12px 15px;
        vertical-align: middle;
        color: #374151;
    }

    /* Badges para tipos de operação */
    .badge-operation {
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 600;
    }

    .badge-create {
        background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
        color: white;
    }

    .badge-update {
        background: linear-gradient(135deg, #4299e1 0%, #3182ce 100%);
        color: white;
    }

    .badge-delete {
        background: linear-gradient(135deg, #f56565 0%, #c53030 100%);
        color: white;
    }

    .badge-login {
        background: linear-gradient(135deg, #ed8936 0%, #dd6b20 100%);
        color: white;
    }

    /* Loading */
    .loading-container {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        min-height: 400px;
    }

    .loading-spinner {
        width: 50px;
        height: 50px;
        border: 3px solid #e5e7eb;
        border-top-color: #667eea;
        border-radius: 50%;
        animation: spin 0.8s linear infinite;
    }

    @keyframes spin {
        to { transform: rotate(360deg); }
    }

    /* Empty state */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #9ca3af;
    }

    .empty-state i {
        font-size: 5rem;
        margin-bottom: 20px;
        opacity: 0.5;
    }

    /* Modal moderno */
    .modal-modern .modal-content {
        border-radius: 20px;
        border: none;
        overflow: hidden;
    }

    .modal-modern .modal-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        padding: 15px 20px;
    }

    .modal-modern .modal-header .close {
        color: white;
        opacity: 0.8;
    }

    .modal-modern .modal-header .close:hover {
        opacity: 1;
    }

    /* Scrollbar */
    .users-list::-webkit-scrollbar {
        width: 5px;
    }

    .users-list::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    .users-list::-webkit-scrollbar-thumb {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 10px;
    }

    /* Responsivo */
    @media (max-width: 768px) {
        .user-item {
            padding: 10px;
        }

        .user-avatar {
            width: 35px;
            height: 35px;
            font-size: 0.9rem;
        }

        .table-operations thead th {
            font-size: 0.7rem;
            padding: 8px 10px;
        }

        .table-operations tbody td {
            padding: 8px 10px;
            font-size: 0.8rem;
        }
    }

    /* Breadcrumb */
    .breadcrumb-modern {
        margin-bottom: 20px;
    }

    .breadcrumb-modern .breadcrumb {
        background: transparent;
        padding: 0;
    }

    .breadcrumb-modern .breadcrumb-item a {
        color: #667eea;
        text-decoration: none;
    }
</style>

<div class="container-fluid fade-in">
    <!-- Breadcrumb -->
    <div class="breadcrumb-modern">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="#"><i class="fa fa-shield"></i> Admin</a>
            </li>
            <li class="breadcrumb-item">
                <a href="#"><i class="fa fa-history"></i> Operações</a>
            </li>
            <li class="breadcrumb-item active">
                <i class="fa fa-users"></i> Utilizadores
            </li>
        </ol>
    </div>

    <div class="row">
        <!-- Lista de Utilizadores -->
        <div class="col-lg-3 mb-4">
            <div class="card-modern h-100">
                <div class="card-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 20px 20px 0 0;">
                    <h5 class="mb-0">
                        <i class="fa fa-users mr-2"></i> Utilizadores do Sistema
                    </h5>
                    <small><?php echo e($usuario->count()); ?> utilizadores registados</small>
                </div>
                <div class="users-list p-2">
                    <?php $__currentLoopData = $usuario; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $usuarioItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="user-item d-flex align-items-center" data-id="<?php echo e($usuarioItem->id); ?>" data-name="<?php echo e($usuarioItem->name); ?>">
                            <div class="user-avatar me-3">
                                <?php echo e(strtoupper(substr($usuarioItem->name, 0, 1))); ?>

                            </div>
                            <div class="flex-grow-1">
                                <div class="user-name"><?php echo e($usuarioItem->name); ?></div>
                                <div class="user-email"><?php echo e($usuarioItem->email); ?></div>
                            </div>
                            <i class="fa fa-chevron-right text-muted"></i>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>

        <!-- Operações do Utilizador -->
        <div class="col-lg-9">
            <div class="card-modern">
                <div class="operations-header">
                    <div class="d-flex align-items-center">
                        <i class="fa fa-history fa-2x mr-3"></i>
                        <div>
                            <h3 class="mb-0">Operações do Utilizador</h3>
                            <p class="mb-0">Selecione um utilizador para visualizar as operações realizadas no sistema</p>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="conteudooperacoes p-4">
                        <div class="empty-state">
                            <i class="fa fa-user-circle"></i>
                            <h5>Nenhum utilizador selecionado</h5>
                            <p class="text-muted">Clique em um utilizador da lista para visualizar as operações</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Detalhes -->
<div class="modal fade modal-modern" id="Visializar-operacao" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fa fa-info-circle mr-2"></i>
                    Detalhes da Operação
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body conteudodetalhes p-4">
                <!-- Conteúdo dinâmico -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fa fa-times"></i> Fechar
                </button>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('script'); ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        // Carregar operações ao clicar no usuário
        $(".user-item").click(function() {
            var userId = $(this).data('id');
            var userName = $(this).data('name');

            // Remover active de todos e adicionar ao clicado
            $(".user-item").removeClass('active');
            $(this).addClass('active');

            $.ajax({
                url: "/admin/RegistoOperacoes/usuario/" + userId,
                type: "GET",
                success: function(data) {
                    $(".conteudooperacoes").html(data);
                    // Adicionar título personalizado
                    $(".conteudooperacoes").prepend(`
                        <div class="mb-4 pb-2 border-bottom">
                            <h5 class="text-primary">
                                <i class="fa fa-user-circle mr-2"></i>
                                Operações realizadas por: <strong>${userName}</strong>
                            </h5>
                        </div>
                    `);
                },
                beforeSend: function() {
                    $(".conteudooperacoes").html(`
                        <div class="loading-container">
                            <div class="loading-spinner"></div>
                            <p class="mt-3 text-muted">A carregar operações do utilizador...</p>
                        </div>
                    `);
                },
                error: function() {
                    $(".conteudooperacoes").html(`
                        <div class="empty-state">
                            <i class="fa fa-exclamation-triangle text-danger"></i>
                            <h5>Erro ao carregar operações</h5>
                            <p class="text-muted">Tente novamente mais tarde</p>
                        </div>
                    `);
                }
            });
        });

        // Visualizar detalhes da operação (delegado para elementos dinâmicos)
        $(document).on('click', '.view-operation-details', function() {
            var operationId = $(this).data('id');
            var operationData = $(this).data('details');

            $("#Visializar-operacao").modal("show");

            // Formatar dados para exibição
            var html = `
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tr>
                            <th width="30%">ID da Operação</th>
                            <td>${operationId}</td>
                        </tr>
                        <tr>
                            <th>Dados da Operação</th>
                            <td><pre class="bg-light p-2 rounded" style="white-space: pre-wrap;">${JSON.stringify(operationData, null, 2)}</pre></td>
                        </tr>
                    </table>
                </div>
            `;

            $(".conteudodetalhes").html(html);
        });

        // Atualizar altura da lista de usuários
        function adjustUsersListHeight() {
            var windowHeight = $(window).height();
            var offset = $('.users-list').offset().top;
            var newHeight = windowHeight - offset - 40;
            $('.users-list').css('max-height', Math.max(300, newHeight) + 'px');
        }

        $(window).on('resize', adjustUsersListHeight);
        adjustUsersListHeight();
    });
</script>

<style>
    .me-3 {
        margin-right: 1rem;
    }

    .flex-grow-1 {
        flex-grow: 1;
    }

    .pre {
        white-space: pre-wrap;
        word-wrap: break-word;
    }

    .border-bottom {
        border-bottom: 2px solid #e5e7eb;
    }

    .text-primary {
        color: #667eea !important;
    }

    .bg-light {
        background-color: #f8f9fa !important;
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin-Lti', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\escola2025\resources\views/Admin/ACL/oberver-index.blade.php ENDPATH**/ ?>