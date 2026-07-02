<nav class="main-header navbar navbar-expand <?php echo e(session('dadoslayout')->nav_header); ?> navbar-light border-bottom fixed-top">
    <div class="container-fluid">

        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="/" class="nav-link">Home</a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="#" class="nav-link">Sobre nós</a>
            </li>
            <li class="nav-item d-none d-sm-inline-block FazerBackup">
                <a href="#" class="nav-link">Backup</a>
            </li>
        </ul>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">

            <?php if(auth()->guard()->guest()): ?>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo e(route('login')); ?>"><?php echo e(__('Login')); ?></a>
                </li>
            <?php endif; ?>

            <?php if(auth()->guard()->check()): ?>
                <?php
                    $notificacoesNaoLidas = auth()->user()->unreadNotifications;
                    $notificacoesLidas = auth()->user()->readNotifications;
                ?>

                <!-- Notificações -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle position-relative" href="#" role="button"
                       data-toggle="dropdown" aria-expanded="false" aria-label="Notificações">
                        <i class="fa fa-bell"></i>
                        <?php if($notificacoesNaoLidas->count()): ?>
                            <span class="badge badge-danger rounded-pill position-absolute"
                                  style="top:0; right:0;">
                                <?php echo e($notificacoesNaoLidas->count()); ?>

                            </span>
                        <?php endif; ?>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right">
                        <span class="dropdown-header">🔔 Não lidas</span>
                        <?php $__empty_1 = true; $__currentLoopData = $notificacoesNaoLidas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $n): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <a class="dropdown-item  " href="<?php echo e(Route("BDNotificao.show",$n->id)); ?>" >
                                <?php echo e($n->data['titulo'] ?? 'Despesa pendente para aprovação'); ?>


                            </a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <span class="dropdown-item text-muted">Sem novas notificações</span>
                        <?php endif; ?>

                        <?php if($notificacoesLidas->count()): ?>
                            <div class="dropdown-divider"></div>
                            <span class="dropdown-header">📬 Lidas</span>
                            <?php $__currentLoopData = $notificacoesLidas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $n): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="dropdown-item d-flex justify-content-between align-items-center lida">
                                    <span><?php echo e($n->data['titulo'] ?? 'Despesa lida'); ?></span>
                                    <form method="POST" action="#">
                                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                        <button class="btn btn-sm btn-link text-danger" title="Apagar notificação">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                    </div>
                </li>

                <!-- Usuário -->
                <li class="nav-item d-flex align-items-center">
                    <i class="fa fa-user-circle-o mr-2"></i> <?php echo e(auth()->user()->name); ?>

                </li>

                <!-- Logout -->
                <li class="nav-item">
                    <a class="nav-link text-danger" href="<?php echo e(route('logout')); ?>"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fa fa-power-off"></i> Sair
                    </a>
                    <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" class="d-none">
                        <?php echo csrf_field(); ?>
                    </form>
                </li>

                <!-- Control Sidebar -->
                <li class="nav-item">
                    <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#">
                        <i class="fa fa-th-large"></i>
                    </a>
                </li>
            <?php endif; ?>

        </ul>
    </div>
</nav>


   <script src="<?php echo e(asset('Admin-LTE/plugins/jquery/jquery.min.js')); ?>"></script>
     <script src="<?php echo e(asset('Admin-LTE/plugins/bootstrap/js/bootstrap.bundle.min.js')); ?>"></script>
<script>

    // Abrir
$('.nav-item.dropdown > .nav-link').dropdown('show');

// Fechar
$('.nav-item.dropdown > .nav-link').dropdown('hide');
</script>



<style>

    /* Força cor visível nas notificações */
.dropdown-menu .dropdown-item {
    color: #212529 !important;   /* preto padrão Bootstrap */
}

.dropdown-menu .dropdown-item:hover {
    background-color: #f8f9fa;   /* cinza claro no hover */
    color: #000 !important;
}
    </style>
<?php /**PATH C:\laragon\www\escola2025\resources\views/layouts/nav-header.blade.php ENDPATH**/ ?>