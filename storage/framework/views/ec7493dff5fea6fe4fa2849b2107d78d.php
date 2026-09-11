<?php $__env->startSection('title', 'Ano Lectivo'); ?>
<?php $__env->startSection('content'); ?>

<link rel="stylesheet" href="jquery.dataTables.min.css"/>
<link rel="stylesheet" href="buttons.dataTables.min.css"/>

<style>
    /* Animações e transições */
    .fade-in {
        animation: fadeIn 0.5s ease-out;
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

    /* Cards modernos */
    .card-modern {
        border: none;
        border-radius: 16px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.07), 0 1px 3px rgba(0, 0, 0, 0.05);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        overflow: hidden;
    }

    .card-modern:hover {
        box-shadow: 0 12px 20px rgba(0, 0, 0, 0.1);
    }

    /* Header da tabela */
    .table-header-modern {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 0px;
        border-radius: 16px 16px 0 0;
    }

    /* Tabela estilizada */
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
        font-size: 0.9rem;
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
        padding: 15px;
        vertical-align: middle;
        color: #374151;
    }

    /* Badges para status */
    .badge-class {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 500;
        display: inline-block;
        margin: 2px;
    }

    /* Botões de ação */
    .btn-action {
        padding: 8px 12px;
        border-radius: 10px;
        transition: all 0.2s ease;
        margin: 0 3px;
    }

    .btn-action i {
        font-size: 1rem;
    }

    .btn-edit {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        color: white;
    }

    .btn-edit:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        color: white;
    }

    .btn-delete {
        background: linear-gradient(135deg, #f56565 0%, #c53030 100%);
        border: none;
        color: white;
    }

    .btn-delete:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(245, 101, 101, 0.4);
        color: white;
    }

    /* Alert moderno */
    .alert-modern {
        border: none;
        border-radius: 12px;
        padding: 15px 20px;
        margin-bottom: 20px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        animation: slideIn 0.4s ease-out;
    }

    @keyframes slideIn {
        from {
            transform: translateX(-100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

    /* DataTables personalizado */
    .dataTables_wrapper .dataTables_length select {
        border-radius: 10px;
        border: 2px solid #e5e7eb;
        padding: 6px 12px;
        margin: 0 8px;
    }

    .dataTables_wrapper .dataTables_filter input {
        border-radius: 10px;
        border: 2px solid #e5e7eb;
        padding: 8px 15px;
        margin-left: 8px;
        width: 250px;
    }

    .dataTables_wrapper .dataTables_filter input:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
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

    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        background: #e5e7eb;
        border-color: #e5e7eb;
    }

    /* Selector de busca */
    .SelectorSerach {
        border-radius: 8px;
        border: 2px solid #e5e7eb;
        padding: 6px 10px;
        width: 100%;
        background: white;
    }

    .SelectorSerach:focus {
        outline: none;
        border-color: #667eea;
    }

    /* Container de conteúdo */
    . {
        background: #f8fafc;
    }

    /* Breadcrumb moderno
    .breadcrumb-modern {
        background: transparent;
        padding: 0;
    }

    .breadcrumb-modern .breadcrumb-item a {
        color: #667eea;
        text-decoration: none;
    } */

    /* Scrollbar personalizada */
    .table-responsive::-webkit-scrollbar {
        height: 8px;
    }

    .table-responsive::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    .table-responsive::-webkit-scrollbar-thumb {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 10px;
    }

    /* Loading spinner */
    .loading-spinner {
        display: inline-block;
        width: 16px;
        height: 16px;
        border: 2px solid rgba(255,255,255,0.3);
        border-radius: 50%;
        border-top-color: white;
        animation: spin 0.6s ease-in-out infinite;
        margin-right: 8px;
    }

    @keyframes spin {
        to { transform: rotate(360deg); }
    }

    /* Modal de confirmação personalizado */
    .custom-modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.5);
        z-index: 9999;
        align-items: center;
        justify-content: center;
    }

    .custom-modal.active {
        display: flex;
        animation: fadeIn 0.3s ease-out;
    }

    .modal-content-custom {
        background: white;
        border-radius: 20px;
        padding: 30px;
        max-width: 400px;
        text-align: center;
        box-shadow: 0 20px 40px rgba(0,0,0,0.2);
    }
</style>


<div class="breadcrumb-modern animate-fadeInUp">
    <ol class="breadcrumb" style="background: transparent; margin: 0; padding: 0;">
        <li class="breadcrumb-item">
            <a href="#"><i class="fa fa-cogs"></i> Gestão de Administrativa</a>
        </li>

<li class="breadcrumb-item">
            <a href="#"><i class="fa fa-sliders"></i>  Configuracoes</a>
        </li>

        <li class="breadcrumb-item active">
            <i class="fa fa-table"></i> <b>Tabela de  Valores</b>
        </li>
    </ol>
</div>
<div class="">

    <!-- Header -->

    <!-- Erros -->
    <?php if($errors->any()): ?>
        <div class="container-fluid">
            <div class="alert alert-danger alert-modern fade-in" role="alert">
                <div class="d-flex align-items-center">
                    <i class="fa fa-exclamation-triangle fa-2x mr-3"></i>
                    <div>
                        <strong class="d-block mb-1">Erros de validação:</strong>
                        <ul class="mb-0 pl-3">
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><?php echo e($error); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <div class="container-fluid fade-in">
        <div class="row">
            <div class="col-12 mb-4">
                <?php echo $__env->make("Componetes.menu-componte-tabelavalores", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card-modern">
                    <!-- Cabeçalho da tabela -->
                    <div class="table-header-modern">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <i class="fa fa-list-ul fa-2x mr-3"></i>
                                <strong style="font-size: 1.2rem;">Listagem de Valores</strong>
                            </div>
                            <div>
                                <span class="badge badge-light">
                                    <i class="fa fa-database mr-1"></i>
                                    Total: <?php echo e(count($colecao)); ?> registros
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Conteúdo da tabela -->
                    <div class="p-4" style="background: white;">
                        <div class="table-responsive">
                            <table class="table table-modern" id="listadevalorestabela">
                                <thead>
                                    <tr>
                                        <th><i class="fa fa-tag mr-2"></i>Descrição</th>
                                        <th><i class="fa fa-money-bill-wave mr-2"></i>Montante</th>
                                        <th><i class="fa fa-percent mr-2"></i>Multa</th>
                                        <th><i class="fa fa-users mr-2"></i>Para ?</th>
                                        <th><i class="fa fa-calendar mr-2"></i>Ano</th>
                                        <th><i class="fa fa-cog mr-2"></i>Ações</th>
                                    </tr>
                                </thead>
                                <tbody class="body">
                                    <?php $__currentLoopData = $colecao; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=> $colecaoV): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr data-id="<?php echo e($colecaoV['id']); ?>">
                                        <td>
                                            <strong><?php echo e($colecaoV["Descricao"]); ?></strong>
                                        </td>
                                        <td>
                                            <span class="badge badge-success" style="background: linear-gradient(135deg, #48bb78 0%, #38a169 100%); font-size: 0.9rem;">
                                                MZN <?php echo e(number_format($colecaoV["valorDescricao"], 2, ',', '.')); ?>

                                            </span>
                                        </td>
                                        <td>
                                            <?php if($colecaoV["multa"] > 0): ?>
                                                <span class="badge badge-warning" style="background: linear-gradient(135deg, #ed8936 0%, #dd6b20 100%);">
                                                    <?php echo e($colecaoV["multa"]); ?>%
                                                </span>
                                            <?php else: ?>
                                                <span class="badge badge-secondary">0%</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <div style="max-width: 250px;">
                                                <?php
                                                    $classes = explode(', ', $colecaoV["classes"]);
                                                ?>
                                                <?php $__currentLoopData = $classes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $classe): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <span class="badge-class">
                                                        <i class="fa fa-graduation-cap mr-1"></i><?php echo e($classe); ?>

                                                    </span>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </div>
                                        </td>
                                        <td>
                                            <i class="fa fa-calendar-alt mr-1" style="color: #667eea;"></i>
                                            <?php echo e($colecaoV["anolectivo"]); ?>

                                        </td>
                                        <td class="action-btns">


                                            <a class="btn btn-outline-primary  btn-sm btn-edit"   href="/RegistoAcademico/TabelaValores/<?php echo e($colecaoV['id']); ?>/edit"  title="<?php echo e($colecaoV['id']); ?>" > <i class="fa fa-edit"></i></a>
  <button class="btn btn-outline-danger btn-sm btn-apagar"  title="<?php echo e($colecaoV['id']); ?>" > <i class="fa fa-trash"></i></button>
                                        </td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Descrição</th>
                                        <th>Montante</th>
                                        <th>Multa</th>
                                        <th>Para ?</th>
                                        <th>Ano</th>
                                        <th>Ações</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de confirmação para deletar -->
<div class="custom-modal" id="deleteModal">
    <div class="modal-content-custom">
        <i class="fa fa-exclamation-triangle" style="font-size: 60px; color: #f56565; margin-bottom: 20px;"></i>
        <h4 style="margin-bottom: 10px;">Confirmar Eliminação</h4>
        <p style="color: #6b7280; margin-bottom: 20px;">
            Tem certeza que deseja eliminar <strong id="deleteDescricao"></strong>?
        </p>
        <p style="color: #9ca3af; font-size: 0.875rem; margin-bottom: 20px;">
            Esta ação não pode ser desfeita.
        </p>
        <div class="d-flex justify-content-center gap-3">
            <button class="btn btn-secondary" id="cancelDelete" style="border-radius: 10px; padding: 8px 20px;">
                Cancelar
            </button>
            <button class="btn btn-danger" id="confirmDelete" style="border-radius: 10px; padding: 8px 20px;">
                <i class="fa fa-trash mr-2"></i>Eliminar
            </button>
        </div>
    </div>
</div>

<?php $__env->startPush('script'); ?>
<script>
$(document).ready(function(){
    let deleteId = null;

    // Inicializar DataTable com configurações melhoradas
    $('#listadevalorestabela').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
        "pageLength": 10,
        "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Todos"]],
        "language": {
            "lengthMenu": "Mostrar _MENU_ registros por página",
            "zeroRecords": "Nenhum registro encontrado",
            "info": "Mostrando página _PAGE_ de _PAGES_",
            "infoEmpty": "Nenhum registro disponível",
            "infoFiltered": "(filtrado de _MAX_ total registros)",
            "search": "Pesquisar:",
            "paginate": {
                "first": "Primeira",
                "last": "Última",
                "next": "Próxima",
                "previous": "Anterior"
            },
            "loadingRecords": "Carregando...",
            "processing": "Processando..."
        },
        "dom": '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>rt<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
        "columnDefs": [
            { "orderable": true, "targets": [0, 1, 2, 4] },
            { "orderable": false, "targets": [3, 5] }
        ]
    });

    // Função para buscar e carregar o formulário de edição
    $(".btn-edit").click(function(){
        let id = $(this).data('id');
        let btn = $(this);

        // Mostrar loading no botão
        let originalText = btn.html();
        btn.html('<i class="fa fa-spinner fa-spin"></i>').prop('disabled', true);

        $.ajax({
            url: "/RegistoAcademico/TabelaValores/"+id+"/edit",
            type: 'GET',
            success: function (data) {
                // Animação de transição
                $(".content-Add").fadeOut(200, function() {
                    $(this).html(data).fadeIn(200);
                });

                // Scroll suave para o topo
                $('html, body').animate({
                    scrollTop: $(".content-Add").offset().top - 100
                }, 500);
            },
            error: function() {
                toastr.error('Erro ao carregar os dados para edição', 'Erro');
            },
            complete: function() {
                btn.html(originalText).prop('disabled', false);
            }
        });
    });

    // Modal de confirmação para deletar
    $(".btn-delete").click(function(){
        deleteId = $(this).data('id');
        let descricao = $(this).data('descricao');

        $("#deleteDescricao").text(descricao);
        $("#deleteModal").addClass('active');
    });

    // Cancelar exclusão
    $("#cancelDelete").click(function(){
        $("#deleteModal").removeClass('active');
        deleteId = null;
    });

    // Confirmar exclusão
    $("#confirmDelete").click(function(){
        if (!deleteId) return;

        let btn = $(this);
        let originalText = btn.html();
        btn.html('<span class="loading-spinner"></span> Eliminando...').prop('disabled', true);

        $.ajax({
            url: "/RegistoAcademico/TabelaValores/"+deleteId+"/apagar",
            type: 'GET',
            success: function (data) {
                // Fechar modal
                $("#deleteModal").removeClass('active');

                // Mostrar toast de sucesso
                toastr.success('Registro eliminado com sucesso!', 'Sucesso');

                // Recarregar a página após 1 segundo
                setTimeout(function() {
                    window.location.href = '/RegistoAcademico/TabelaValores/show';
                }, 1000);
            },
            error: function() {
                toastr.error('Erro ao eliminar o registro', 'Erro');
                btn.html(originalText).prop('disabled', false);
                $("#deleteModal").removeClass('active');
            }
        });
    });

    // Fechar modal clicando fora
    $(document).click(function(e) {
        if ($(e.target).is('#deleteModal')) {
            $("#deleteModal").removeClass('active');
        }
    });

    // Adicionar animação nas linhas da tabela
    $('#listadevalorestabela tbody tr').hover(
        function() {
            $(this).css('transform', 'translateX(5px)');
        },
        function() {
            $(this).css('transform', 'translateX(0)');
        }
    );

    // Formatação de valores monetários


    function formatMoney(value) {
    return new Intl.NumberFormat('pt-MZ', {
        style: 'currency',
        currency: 'MZN',
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    }).format(value);
}
});

// Toastr configuration
toastr.options = {
    "closeButton": true,
    "debug": false,
    "newestOnTop": false,
    "progressBar": true,
    "positionClass": "toast-top-right",
    "preventDuplicates": false,
    "onclick": null,
    "showDuration": "300",
    "hideDuration": "1000",
    "timeOut": "5000",
    "extendedTimeOut": "1000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
};
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin-Lti', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\escolasaojoaopaulo\resources\views/registoAcademico/tabelavalores-show.blade.php ENDPATH**/ ?>