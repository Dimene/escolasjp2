<?php $__env->startSection('title', 'Página Inicial'); ?>

<?php $__env->startSection('content'); ?>
<style>
    .message-wrapper {
        min-height: 60vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .message-box {
        max-width: 500px;
        width: 100%;
        text-align: center;
        animation: fadeInUp 0.5s ease-out;
    }

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

    .message-icon {
        width: 100px;
        height: 100px;
        margin: 0 auto 25px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 50px;
    }

    .message-title {
        font-size: 1.8rem;
        font-weight: 700;
        margin-bottom: 15px;
    }

    .message-text {
        font-size: 1.1rem;
        color: #6c757d;
        margin-bottom: 30px;
        line-height: 1.6;
    }

    .btn-custom {
        padding: 10px 30px;
        border-radius: 50px;
        font-weight: 600;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        text-decoration: none;
    }

    .btn-custom:hover {
        transform: translateY(-2px);
    }

    /* Cores para diferentes tipos */
    .bg-warning-custom { background: linear-gradient(135deg, #f59e0b, #f97316); }
    .bg-success-custom { background: linear-gradient(135deg, #10b981, #059669); }
    .bg-info-custom { background: linear-gradient(135deg, #3b82f6, #2563eb); }
    .bg-danger-custom { background: linear-gradient(135deg, #ef4444, #dc2626); }
</style>

<div class="breadcrumb-modern animate-fadeInUp">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#"><i class="fa fa-graduation-cap"></i> Registo Académico</a></li>
        <li class="breadcrumb-item"><a href="#"><i class="fa fa-book"></i> Gestão Notas</a></li>
        <li class="breadcrumb-item active"><i class="fa fa-pencil"></i> <b><?php echo e($tipopauta ?? 'Pauta'); ?></b></li>
    </ol>
</div>

<div class="message-wrapper">
    <div class="message-box">
        <?php
            $tipo = $tipoMensagem ?? 'warning'; // warning, success, info, danger
            $icones = [
                'warning' => 'fa-exclamation-triangle',
                'success' => 'fa-check-circle',
                'info' => 'fa-info-circle',
                'danger' => 'fa-times-circle'
            ];
            $cores = [
                'warning' => 'bg-warning-custom',
                'success' => 'bg-success-custom',
                'info' => 'bg-info-custom',
                'danger' => 'bg-danger-custom'
            ];
            $titulos = [
                'warning' => 'Atenção!',
                'success' => 'Sucesso!',
                'info' => 'Informação',
                'danger' => 'Erro!'
            ];
        ?>

        <div class="message-icon <?php echo e($cores[$tipo]); ?>">
            <i class="fa <?php echo e($icones[$tipo]); ?> text-white"></i>
        </div>

        <h2 class="message-title"><?php echo e($titulos[$tipo]); ?></h2>

        <div class="message-text">
            <?php echo $mensagem ?? 'Nenhuma mensagem disponível.'; ?>

        </div>

        <div>
            <a href="<?php echo e(url()->previous()); ?>" class="btn-custom btn-secondary">
                <i class="fa fa-arrow-left"></i> Voltar
            </a>
            <a href="<?php echo e(route('home')); ?>" class="btn-custom btn-primary ms-2">
                <i class="fa fa-home"></i> Início
            </a>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin-Lti', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\escola2025\resources\views/Componetes/alerta-Falha.blade.php ENDPATH**/ ?>