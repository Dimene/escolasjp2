<?php $__env->startSection('title', 'Visualizar Notificação'); ?>

<?php $__env->startSection('content'); ?>
<section class="content">
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid shadow-no">
                <div class="row">
                    <div class="col-sm-6"></div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Notificação</a></li>
                            <li class="breadcrumb-item active">Visualizar</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="container mt-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="fa fa-bell"></i> Detalhes da Notificação
                        </h5>
                        <a href="<?php echo e(route('BDNotificao.index')); ?>" class="btn btn-light btn-sm">
                            <i class="fa fa-arrow-left"></i> Voltar
                        </a>
                    </div>

                    <div class="card-body">
                        <p class="lead">
                            <?php echo e($notificacao->data['mensagem'] ?? 'Sem mensagem disponível'); ?>

                        </p>

                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><strong>ID:</strong> <?php echo e($notificacao->id); ?></li>
                            <li class="list-group-item"><strong>Data de criação:</strong> <?php echo e($notificacao->created_at->format('d/m/Y H:i')); ?></li>
                            <li class="list-group-item">
                                <strong>Status:</strong>
                                <?php if($notificacao->read_at): ?>
                                    <span class="badge badge-success">Lida</span>
                                <?php else: ?>
                                    <span class="badge badge-warning">Não lida</span>
                                <?php endif; ?>
                            </li>
                        </ul>
                    </div>

                    <div class="card-footer d-flex justify-content-between">
                        <!-- Marcar como lida -->
                        <?php if(!$notificacao->read_at): ?>
                            <a href="<?php echo e(route('BDNotificao.edit', $notificacao->id)); ?>" class="btn btn-success">
                                <i class="fa fa-check"></i> Marcar como lida
                            </a>
                        <?php endif; ?>

                        <!-- Apagar -->
                        <form action="<?php echo e(route('BDNotificao.destroy', $notificacao->id)); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button class="btn btn-danger">
                                <i class="fa fa-trash"></i> Apagar
                            </button>
                        </form>




                        <!-- Botão para disparar o AJAX -->
<button type="button" class="btn btn-info" id="btnResponder-<?php echo e($notificacao->id); ?>">
    <i class="fa fa-reply"></i> Responder
</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Formulário oculto para responder -->
    <form id="notificacao-<?php echo e($notificacao->id); ?>"
          action="<?php echo e($notificacao->data['link']); ?>"
          method="POST"
          class="d">
        <?php echo csrf_field(); ?>


        <input type="hidden" name="notificacaoId"  value="<?php echo e($notificacao->id); ?>">
        <input type="hidden" name="estado"  value="<?php echo e($notificacao->data['estado']); ?>">
        <?php
            // Decodifica como array associativo
            $dados = json_decode($notificacao->data['dados'], true);
        ?>

        <?php $__currentLoopData = $dados; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if(is_array($value)): ?>
                <?php $__currentLoopData = $value; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value2): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <input type="hidden" name="<?php echo e($key); ?>[]" value="<?php echo e($value2); ?>">
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php else: ?>
            <?php if($key!="_token"): ?>
                <input type="hidden" name="<?php echo e($key); ?>" value="<?php echo e($value); ?>">
                <?php endif; ?>
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </form>






<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function () {
    $('#btnResponder-<?php echo e($notificacao->id); ?>').on('click', function (e) {
        e.preventDefault();

        let form = $('#notificacao-<?php echo e($notificacao->id); ?>');
        let url = form.attr('action');
        let data = form.serialize(); // 🔑 serializa todos os inputs

        $.ajax({
            url: url,
            type: 'POST',
            data: data,
           success: function (response) {
    Swal.fire({
        title: 'Sucesso!',
        text: 'Resposta enviada com sucesso!',
        icon: 'success',
        confirmButtonText: 'OK'
    }).then(() => {
           // 🔄 Atualiza a página depois do usuário clicar em "OK"
        location.reload();
    });
},
error: function (xhr) {
    Swal.fire({
        title: 'Erro!',
        text: 'Não foi possível enviar a resposta.',
        icon: 'error',
        confirmButtonText: 'Tentar novamente'
    });
}
        });
    });
});
</script>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin-Lti', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\escola2025\resources\views/Notificacao/Notificacao-visualizar.blade.php ENDPATH**/ ?>