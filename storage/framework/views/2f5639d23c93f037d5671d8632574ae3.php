<?php $__env->startSection('title', 'Gestão de Permissões do Sistema'); ?>

<?php $__env->startSection('content'); ?>

<style>
    /* Animações e Keyframes */
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

    @keyframes fadeInLeft {
        from {
            opacity: 0;
            transform: translateX(-30px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes scaleIn {
        from {
            opacity: 0;
            transform: scale(0.9);
        }
        to {
            opacity: 1;
            transform: scale(1);
        }
    }

    @keyframes pulse {
        0%, 100% {
            transform: scale(1);
        }
        50% {
            transform: scale(1.05);
        }
    }

    @keyframes shimmer {
        0% {
            background-position: -1000px 0;
        }
        100% {
            background-position: 1000px 0;
        }
    }

    .animate-fadeInUp {
        animation: fadeInUp 0.6s ease-out;
    }

    .animate-fadeInLeft {
        animation: fadeInLeft 0.5s ease-out;
    }

    .animate-scaleIn {
        animation: scaleIn 0.4s ease-out;
    }

    /* Breadcrumb Moderno */
    .breadcrumb-modern {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 12px 25px;
        border-radius: 15px;
        margin-bottom: 25px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    }

    .breadcrumb-modern .breadcrumb {
        background: transparent;
        margin: 0;
        padding: 0;
    }

    .breadcrumb-modern .breadcrumb-item {
        color: rgba(255,255,255,0.9);
    }

    .breadcrumb-modern .breadcrumb-item a {
        color: white;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .breadcrumb-modern .breadcrumb-item a:hover {
        color: #ffd700;
        transform: translateX(3px);
        display: inline-block;
    }

    .breadcrumb-modern .breadcrumb-item.active {
        color: #ffd700;
        font-weight: bold;
    }

    /* Card Principal */
    .card-modern {
        border: none;
        border-radius: 20px;
        overflow: hidden;
        transition: all 0.3s ease;
        box-shadow: 0 10px 40px rgba(0,0,0,0.1);
    }

    .card-modern:hover {
        box-shadow: 0 15px 50px rgba(0,0,0,0.15);
        transform: translateY(-2px);
    }

    /* Header do Card */
    .card-header-modern {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 25px;
        text-align: center;
        border-bottom: none;
    }

    .card-header-modern h3 {
        margin: 0;
        color: white;
        font-weight: 600;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
    }

    .card-header-modern h3:before {
        content: "🔐";
        font-size: 28px;
    }

    .card-header-modern h3:after {
        content: "🔑";
        font-size: 28px;
    }

    /* Título da Função */
    .function-title {
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        padding: 15px;
        border-radius: 15px;
        margin-bottom: 25px;
        text-align: center;
        border-left: 5px solid #667eea;
        border-right: 5px solid #667eea;
    }

    .function-title h3 {
        margin: 0;
        color: #333;
        font-weight: bold;
        display: inline-block;
        padding: 8px 25px;
        background: white;
        border-radius: 50px;
        box-shadow: 0 3px 10px rgba(0,0,0,0.1);
    }

    .function-title h3 i {
        color: #667eea;
        margin-right: 10px;
    }

    /* Cards de Módulos */
    .module-card {
        background: white;
        border-radius: 15px;
        overflow: hidden;
        margin-bottom: 25px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
        height: 100%;
        animation: fadeInLeft 0.5s ease-out;
    }

    .module-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0,0,0,0.15);
    }

    .module-card-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 15px;
        text-align: center;
        border-bottom: none;
    }

    .module-card-header h5 {
        margin: 0;
        color: white;
        font-weight: 600;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .module-card-header h5 i {
        font-size: 20px;
    }

    .module-card-body {
        padding: 20px;
        max-height: 350px;
        overflow-y: auto;
    }

    /* Checkboxes Modernos */
    .custom-checkbox {
        display: block;
        position: relative;
        padding-left: 35px;
        margin-bottom: 12px;
        cursor: pointer;
        font-size: 14px;
        user-select: none;
        color: #333;
        transition: all 0.3s ease;
        border-radius: 8px;
        padding: 8px 8px 8px 35px;
    }

    .custom-checkbox:hover {
        background: linear-gradient(135deg, #f5f7fa 0%, #e9ecef 100%);
        transform: translateX(5px);
    }

    .custom-checkbox input {
        position: absolute;
        opacity: 0;
        cursor: pointer;
        height: 0;
        width: 0;
    }

    .checkmark {
        position: absolute;
        top: 50%;
        left: 8px;
        transform: translateY(-50%);
        height: 20px;
        width: 20px;
        background-color: #fff;
        border: 2px solid #667eea;
        border-radius: 6px;
        transition: all 0.3s ease;
    }

    .custom-checkbox:hover input ~ .checkmark {
        background-color: #f0f0f0;
    }

    .custom-checkbox input:checked ~ .checkmark {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-color: #667eea;
        animation: pulse 0.3s ease;
    }

    .checkmark:after {
        content: "";
        position: absolute;
        display: none;
    }

    .custom-checkbox input:checked ~ .checkmark:after {
        display: block;
    }

    .custom-checkbox .checkmark:after {
        left: 6px;
        top: 2px;
        width: 5px;
        height: 10px;
        border: solid white;
        border-width: 0 2px 2px 0;
        transform: rotate(45deg);
    }

    /* Scrollbar Personalizada */
    .module-card-body::-webkit-scrollbar {
        width: 6px;
    }

    .module-card-body::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    .module-card-body::-webkit-scrollbar-thumb {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 10px;
    }

    /* Botão Moderno */
    .btn-modern {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        padding: 12px 30px;
        border-radius: 50px;
        font-weight: 600;
        transition: all 0.3s ease;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 10px;
    }

    .btn-modern:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(102,126,234,0.4);
        color: white;
    }

    .btn-modern:active {
        transform: translateY(0);
    }

    /* Alertas Modernos */
    .alert-modern {
        border-radius: 15px;
        border: none;
        padding: 15px 20px;
        margin-bottom: 20px;
        animation: scaleIn 0.4s ease-out;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
    }

    .alert-modern ul {
        margin: 0;
        padding-left: 20px;
    }

    /* Loading Overlay */
    .loading-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0,0,0,0.7);
        display: none;
        justify-content: center;
        align-items: center;
        z-index: 9999;
    }

    .loading-spinner {
        width: 50px;
        height: 50px;
        border: 5px solid #f3f3f3;
        border-top: 5px solid #667eea;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    /* Footer do Card */
    .card-footer-modern {
        background: #f8f9fa;
        padding: 20px;
        text-align: right;
        border-top: 1px solid #e0e0e0;
    }

    /* Badge de Contagem */
    .count-badge {
        background: rgba(255,255,255,0.2);
        padding: 3px 10px;
        border-radius: 20px;
        font-size: 12px;
        margin-left: 10px;
    }

    /* Responsividade */
    @media (max-width: 768px) {
        .module-card {
            margin-bottom: 15px;
        }

        .btn-modern {
            width: 100%;
            justify-content: center;
        }

        .function-title h3 {
            font-size: 18px;
        }

        .card-header-modern h3 {
            font-size: 20px;
        }

        .card-header-modern h3:before,
        .card-header-modern h3:after {
            font-size: 20px;
        }
    }

    /* Toast Notification */
    .toast-notification {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 10000;
        animation: slideInRight 0.3s ease-out;
    }

    @keyframes slideInRight {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

    /* Efeito de seleção */
    .module-card-body li {
        list-style: none;
        margin: 0;
        padding: 0;
    }
</style>

<div class="loading-overlay" id="loadingOverlay">
    <div class="loading-spinner"></div>
</div>

<div class="content-wrapper">
    <!-- Breadcrumb Moderno -->
    <div class="breadcrumb-modern animate-fadeInUp">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="#"><i class="fa fa-dashboard"></i> Dashboard</a>
            </li>
            <li class="breadcrumb-item">
                <a href="#"><i class="fa fa-shield-alt"></i> Gestão Administrativa</a>
            </li>
            <li class="breadcrumb-item active">
                <i class="fa fa-key"></i> Permissões do Sistema
            </li>
        </ol>
    </div>

    <!-- Alertas de Erro -->
    <?php if($errors->any()): ?>
    <div class="container-fluid">
        <div class="alert alert-danger alert-modern">
            <i class="fa fa-exclamation-triangle"></i>
            <strong>Erros encontrados:</strong>
            <ul class="mb-0 mt-2">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><i class="fa fa-times-circle"></i> <?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    </div>
    <?php endif; ?>

    <!-- Mensagem de Sucesso -->
    <?php if(isset($mensage)): ?>
    <div class="container-fluid">
        <div class="alert alert-success alert-modern">
            <i class="fa fa-check-circle"></i>
            <strong>Sucesso!</strong> <?php echo e($mensage); ?>

        </div>
    </div>
    <?php endif; ?>

    <!-- Conteúdo Principal -->
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card card-modern animate-fadeInUp">
                    <!-- Header -->
                    <div class="card-header-modern">
                        <h3>
                            <i class="fa fa-lock"></i>
                            Gestão de Permissões
                            <i class="fa fa-unlock-alt"></i>
                        </h3>
                        <p class="text-white mt-2 mb-0" style="opacity: 0.9;">
                            Atribua permissões específicas para a função selecionada
                        </p>
                    </div>

                    <div class="card-body" style="padding: 30px;">
                        <!-- Título da Função -->
                        <?php if(isset($Funcois[0])): ?>
                        <div class="function-title animate-scaleIn">
                            <h3>
                                <i class="fa fa-users"></i>
                                Função: <?php echo e($Funcois[0]->label); ?>

                                <span class="count-badge" style="background: #667eea; color: white;">
                                    <i class="fa fa-key"></i> Configurando permissões
                                </span>
                            </h3>
                        </div>
                        <?php endif; ?>

                        <!-- Formulário -->
                        <form class="form-horizontal" role="form" method="POST"
                              action="<?php echo e(route('Admin.permisson.papel.Adicionar')); ?>"
                              enctype="multipart/form-data"
                              id="permissionForm">
                            <?php echo csrf_field(); ?>

                            <div class="row">
                                <?php $__currentLoopData = $modals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $ide): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="col-lg-4 col-md-6 col-sm-12">
                                    <div class="module-card" style="animation-delay: <?php echo e($index * 0.1); ?>s;">
                                        <div class="module-card-header">
                                            <h5>
                                                <i class="fa fa-cubes"></i>
                                                <?php echo e($ide->Descricao); ?>

                                                <span class="count-badge">
                                                    <?php echo e(count($ide->permission)); ?> permissões
                                                </span>
                                            </h5>
                                        </div>
                                        <div class="module-card-body">
                                            <ul class="list-unstyled">
                                                <?php $__currentLoopData = $ide->permission; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $perm): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <li>
                                                        <label class="custom-checkbox">
                                                            <input type="checkbox"
                                                                   value="<?php echo e($perm->id); ?>"
                                                                   name="elementosdepermissaoporpapel[]"
                                                                   <?php if(isset($Funcois[0])): ?>
                                                                       <?php $__currentLoopData = $Funcois[0]->permission; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permisso): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                           <?php if($permisso->id == $perm->id): ?>
                                                                               checked
                                                                           <?php endif; ?>
                                                                       <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                   <?php endif; ?>
                                                                   class="permission-checkbox">
                                                            <span class="checkmark"></span>
                                                            <i class="fa fa-check-circle" style="color: #667eea; margin-right: 8px;"></i>
                                                            <?php echo e($perm->label); ?>

                                                        </label>
                                                    </li>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>

                            <input name="idFuncao" value="<?php echo e($Funcois[0]->id ?? ''); ?>" type="hidden"/>

                            <div class="card-footer-modern">
                                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                                    <div class="text-muted">
                                        <i class="fa fa-info-circle"></i>
                                        <small>Selecione as permissões desejadas para esta função</small>
                                    </div>
                                    <div>
                                        <button type="button" id="selectAllBtn" class="btn btn-secondary btn-modern" style="background: #6c757d; margin-right: 10px;">
                                            <i class="fa fa-check-double"></i> Selecionar Todos
                                        </button>
                                        <button type="submit" class="btn btn-modern">
                                            <i class="fa fa-save"></i>
                                            Atualizar Permissões
                                            <i class="fa fa-arrow-right"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('script'); ?>
<script>
$(document).ready(function() {
    // Animação de entrada dos cards
    $(".module-card").each(function(index) {
        $(this).css('animation', 'fadeInLeft 0.5s ease-out');
        $(this).css('animation-delay', (index * 0.1) + 's');
    });

    // Selecionar todos os checkboxes
    let selectAllBtn = $('#selectAllBtn');
    let allCheckboxes = $('.permission-checkbox');
    let selectAllText = 'Selecionar Todos';
    let deselectAllText = 'Desmarcar Todos';

    selectAllBtn.click(function() {
        let allChecked = true;
        allCheckboxes.each(function() {
            if (!$(this).prop('checked')) {
                allChecked = false;
                return false;
            }
        });

        if (allChecked) {
            allCheckboxes.prop('checked', false);
            selectAllBtn.html('<i class="fa fa-check-double"></i> ' + selectAllText);
            showToast('Todas as permissões foram desmarcadas', 'info');
        } else {
            allCheckboxes.prop('checked', true);
            selectAllBtn.html('<i class="fa fa-times"></i> ' + deselectAllText);
            showToast('Todas as permissões foram selecionadas', 'success');
        }
    });

    // Atualizar texto do botão quando checkboxes mudam individualmente
    allCheckboxes.change(function() {
        let allChecked = true;
        allCheckboxes.each(function() {
            if (!$(this).prop('checked')) {
                allChecked = false;
                return false;
            }
        });

        if (allChecked) {
            selectAllBtn.html('<i class="fa fa-times"></i> ' + deselectAllText);
        } else {
            selectAllBtn.html('<i class="fa fa-check-double"></i> ' + selectAllText);
        }
    });

    // Contar permissões selecionadas
    function updateSelectedCount() {
        let selected = $('.permission-checkbox:checked').length;
        let total = $('.permission-checkbox').length;
        $('.count-badge').first().html(selected + ' / ' + total + ' selecionadas');
    }

    allCheckboxes.change(updateSelectedCount);
    updateSelectedCount();

    // Loading effect ao submeter
    $('#permissionForm').submit(function(e) {
        $('#loadingOverlay').fadeIn(300);

        // Mostrar toast de salvamento
        showToast('Salvando permissões...', 'info');

        setTimeout(() => {
            // O formulário continua o submit normal
        }, 500);
    });

    // Efeito hover nos cards
    $('.module-card').hover(
        function() {
            $(this).css('transform', 'translateY(-5px)');
        },
        function() {
            $(this).css('transform', 'translateY(0)');
        }
    );

    // Animação ao marcar/desmarcar checkbox
    $('.custom-checkbox').click(function(e) {
        let checkbox = $(this).find('.permission-checkbox');
        setTimeout(() => {
            if (checkbox.prop('checked')) {
                showToast('Permissão ativada: ' + checkbox.next().next().next().text(), 'success');
            }
        }, 100);
    });
});

// Função para mostrar notificações toast
function showToast(message, type = 'success') {
    const bgColor = type === 'success' ? 'linear-gradient(135deg, #43e97b 0%, #38f9d7 100%)'
                    : type === 'error' ? 'linear-gradient(135deg, #fa709a 0%, #fee140 100%)'
                    : 'linear-gradient(135deg, #4facfe 0%, #00f2fe 100%)';
    const icon = type === 'success' ? 'fa-check-circle'
                : type === 'error' ? 'fa-exclamation-circle'
                : 'fa-info-circle';

    const toast = $(`
        <div class="toast-notification">
            <div style="background: ${bgColor}; color: white; padding: 12px 20px; border-radius: 12px; box-shadow: 0 10px 25px rgba(0,0,0,0.2); display: flex; align-items: center; gap: 10px;">
                <i class="fa ${icon}" style="font-size: 18px;"></i>
                <span>${message}</span>
                <i class="fa fa-times" style="cursor: pointer; margin-left: 10px; opacity: 0.8;" onclick="$(this).closest('.toast-notification').fadeOut(300, function(){ $(this).remove(); })"></i>
            </div>
        </div>
    `);

    $('body').append(toast);

    setTimeout(() => {
        toast.fadeOut(300, function() { $(this).remove(); });
    }, 3000);
}

// Loading hide quando a página carregar
$(window).on('load', function() {
    $('#loadingOverlay').fadeOut(300);

    // Pequeno delay para mostrar o conteúdo
    setTimeout(() => {
        $('.module-card').css('opacity', '1');
    }, 100);
});
</script>
<?php $__env->stopPush(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin-Lti', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\escola2025\resources\views/Admin/ACL/permissao-addicionar.blade.php ENDPATH**/ ?>