<?php $__env->startSection('title', 'Lista de Notificações'); ?>

<?php $__env->startSection('content'); ?>
<section class="content">
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid shadow-no">
                <div class="row">
                    <div class="col-sm-6">
                        <h4><i class="fa fa-bell"></i> Notificações</h4>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Notificação</a></li>
                            <li class="breadcrumb-item active">Lista</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    🔔 Não lidas
                </div>
                <div class="card-body">
                    <?php $__empty_1 = true; $__currentLoopData = $notificacoesNaoLidas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $n): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span><?php echo e($n->data['mensagem'] ?? 'Despesa pendente para aprovação'); ?></span>
                            <div>
                                <a href="<?php echo e(route('BDNotificao.show', $n->id)); ?>" class="btn btn-info btn-sm">
                                    <i class="fa fa-eye"></i> Ver
                                </a>
                                <form action="<?php echo e(route('BDNotificao.destroy', $n->id)); ?>" method="POST" class="d-inline">
                                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                    <button class="btn btn-danger btn-sm">
                                        <i class="fa fa-trash"></i> Apagar
                                    </button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <p class="text-muted">Sem novas notificações</p>
                    <?php endif; ?>
                </div>
            </div>

            <?php if($notificacoesLidas->count()): ?>
                <div class="card shadow-sm mt-4">
                    <div class="card-header bg-secondary text-white">
                        📬 Lidas
                    </div>
                    <div class="card-body">
                        <?php $__currentLoopData = $notificacoesLidas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $n): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-muted"><?php echo e($n->data['mensagem'] ?? 'Despesa lida'); ?></span>
                                <div>
                                    <a href="<?php echo e(route('BDNotificao.show', $n->id)); ?>" class="btn btn-info btn-sm">
                                        <i class="fa fa-eye"></i> Ver
                                    </a>
                                    <form action="<?php echo e(route('BDNotificao.destroy', $n->id)); ?>" method="POST" class="d-inline">
                                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                        <button class="btn btn-danger btn-sm">
                                            <i class="fa fa-trash"></i> Apagar
                                        </button>
                                    </form>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin-Lti', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\escola2025\resources\views/Notificacao/Notificacao-index.blade.php ENDPATH**/ ?>