<?php
    $host = request()->getHost();
    $subdomain = explode('.', $host)[0];
?>
<link rel="stylesheet" href="<?php echo e(asset('Admin-LTE/plugins/colorpicker/bootstrap-colorpicker.min.css')); ?>">
<form id="formAluno" method="POST" enctype="multipart/form-data">
    <?php echo csrf_field(); ?>
    <?php echo method_field("PUT"); ?>

    <input type="hidden" name="idAlunos" id="idAlunos" value="<?php echo e($aluno->id); ?>">

    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#dados-<?php echo e($aluno->id); ?>">Dados do Aluno</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#pagamentos-<?php echo e($aluno->id); ?>">Pagamentos</a>
        </li>
    </ul>

    <div class="tab-content mt-3">
        
        <div class="tab-pane fade" id="pagamentos-<?php echo e($aluno->id); ?>">
            <div class="card">
                <div class="card-body">
                    <h5>Tipos de Pagamento</h5>
                    <ul class="list-group" id="listaPagamentosTab"></ul>
                </div>
            </div>
        </div>

        
        <div class="tab-pane fade show active" id="dados-<?php echo e($aluno->id); ?>">
            <div class="row">
                <div class="col-md-4 text-center">
                    
                    <div class="avatar-container" id="avatar-container">
                        <img src="<?php echo e($aluno->avatar
                            ? asset("storage/$subdomain/fotoAluno/$aluno->avatar")
                            : asset('storage/fotoAluno/avatar.png')); ?>"
                            alt="Foto de <?php echo e($aluno->nome); ?>">
                    </div>

                    
                    <div id="camera-preview" style="display:none;"></div>

                    <input type="hidden" name="image" class="image-tag">

                    
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="fileexplorer" name="avatar-file" accept="image/*">
                        <label class="custom-file-label" for="fileexplorer">
                            <i class="fas fa-upload"></i> Escolher Foto
                        </label>
                    </div>

                    <div class="btn-foto mt-3">
                        <button type="button" id="startCamera" class="btn btn-dark">
                            <i class="fas fa-video"></i> Abrir Câmara
                        </button>
                        <button type="button" id="stopCamera" class="btn btn-danger" style="display:none">
                            <i class="fas fa-stop"></i> Parar
                        </button>
                        <button type="button" id="takeSnapshot" class="btn btn-secondary" style="display:none">
                            <i class="fas fa-camera"></i> Tirar Foto
                        </button>
                    </div>
                </div>
<div class="col-md-8">
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">📘 Dados do Aluno</h4>
        </div>
        <div class="card-body">
            <dl class="row">
                <dt class="col-sm-4">Nome:</dt>
                <dd class="col-sm-8"><?php echo e($aluno->nome); ?></dd>

                <dt class="col-sm-4">Sexo:</dt>
                <dd class="col-sm-8"><?php echo e($aluno->sexo); ?></dd>

                <dt class="col-sm-4">Idade:</dt>
                <dd class="col-sm-8">
                    <?php echo e($aluno->dataNascimento ? \Carbon\Carbon::parse($aluno->dataNascimento)->age . ' anos' : 'Não informado'); ?>

                </dd>

                <dt class="col-sm-4">Tipo:</dt>
                <dd class="col-sm-8">
                    <span class="badge <?php echo e($aluno->Tipo === 'B' ? 'bg-success' : 'bg-secondary'); ?>">
                        <?php echo e($aluno->Tipo === 'B' ? 'Bolseiro' : 'Normal'); ?>

                    </span>
                </dd>

                <?php if($aluno->encaregado): ?>
                    <dt class="col-sm-4">Encarregado:</dt>
                    <dd class="col-sm-8"><?php echo e($aluno->encaregado->nome); ?></dd>
                <?php endif; ?>

                <?php if($class): ?>
                    <dt class="col-sm-4">Classe Anterior:</dt>
                    <dd class="col-sm-8"><?php echo e($class->Descricao); ?></dd>
                <?php endif; ?>

                <dt class="col-sm-4">Estado:</dt>
                <dd class="col-sm-8">
                    <span class="badge bg-info">
                        <?php echo e($classeDescricao->estado ?? 'Frequentado'); ?>

                    </span>
                </dd>
            </dl>



                            <h6 class="text-center"><b>Atualização de Matrícula</b></h6>

                            <div class="form-group">
                                <label>Classe</label>
                                <select class="form-control select-class-ano" name="ClassedeAtualizacao">
                                    <?php $__currentLoopData = $classesshow; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $classe): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($classe->id); ?>">
                                            <?php echo e($classe->Descricao); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="footer">
        <button type="button" class="btn btn-primary float-right botaoAtualizacaoAlunoId">
            <i class="fas fa-save"></i> Atualizar Matrícula
        </button>
    </div>
</form>

<script>
// Este script será executado quando o conteúdo for carregado
$(document).ready(function() {
    // Inicializar pagamentos
    const ano = $('#anolectivo').val();
    const classe = $('[name="ClassedeAtualizacao"]').val();

    if (ano && classe) {
        // A função atualizarPagamentosPorAno está no script principal
        if (typeof window.sistemaMatricula !== 'undefined') {
            window.sistemaMatricula.atualizarPagamentosPorAno(ano, classe);
        }
    }
});
</script>
<?php /**PATH C:\laragon\www\escolasaojoaopaulo\resources\views/registoAcademico/Aluno-matricula-atualizar.blade.php ENDPATH**/ ?>