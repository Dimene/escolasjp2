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

    .form-card {
        border: none;
        border-radius: 24px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .form-card:hover {
        box-shadow: 0 15px 50px rgba(0, 0, 0, 0.12);
    }

    .form-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 25px 30px;
        color: white;
    }

    .form-header h3 {
        margin: 0;
        font-weight: 600;
    }

    .form-header p {
        margin: 5px 0 0;
        opacity: 0.9;
    }

    .form-body {
        padding: 30px;
    }

    .form-group-modern {
        margin-bottom: 25px;
    }

    .label-modern {
        font-weight: 600;
        color: #374151;
        margin-bottom: 8px;
        display: block;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
        text-transform: uppercase;
    }

    .label-modern i {
        margin-right: 8px;
        color: #667eea;
    }

    .input-modern {
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        padding: 12px 16px;
        width: 100%;
        transition: all 0.3s ease;
        background: #f9fafb;
        font-size: 0.95rem;
    }

    .input-modern:focus {
        outline: none;
        border-color: #667eea;
        background: white;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    .input-modern.is-invalid {
        border-color: #f56565;
        background: #fff5f5;
    }

    .select-modern {
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        padding: 12px 16px;
        width: 100%;
        background: #f9fafb;
        font-size: 0.95rem;
        transition: all 0.3s ease;
    }

    .select-modern:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    /* Select2 customizado */
    .select2-container--default .select2-selection--single {
        border: 2px solid #e5e7eb !important;
        border-radius: 12px !important;
        height: 48px !important;
        background: #f9fafb !important;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 44px !important;
        padding-left: 16px !important;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 44px !important;
    }

    /* Botões */
    .btn-primary-modern {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        border-radius: 12px;
        padding: 12px 28px;
        font-weight: 600;
        transition: all 0.3s ease;
        color: white;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .btn-primary-modern:hover {
        transform: translateY(-2px);
        box-shadow: 0 7px 14px rgba(102, 126, 234, 0.3);
        color: white;
    }

    .btn-secondary-modern {
        background: linear-gradient(135deg, #6c757d 0%, #5a6268 100%);
        border: none;
        border-radius: 12px;
        padding: 12px 28px;
        font-weight: 600;
        transition: all 0.3s ease;
        color: white;
    }

    .btn-secondary-modern:hover {
        transform: translateY(-2px);
        color: white;
    }

    /* Avatar upload */
    .avatar-upload {
        text-align: center;
        margin-bottom: 30px;
    }

    .avatar-preview {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        margin: 0 auto 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
        overflow: hidden;
        position: relative;
    }

    .avatar-preview:hover {
        transform: scale(1.05);
        box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
    }

    .avatar-preview img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .avatar-preview i {
        font-size: 48px;
        color: white;
    }

    .avatar-upload input {
        display: none;
    }

    .avatar-hint {
        font-size: 0.75rem;
        color: #6c757d;
    }

    /* Alerts */
    .alert-modern {
        border: none;
        border-radius: 16px;
        padding: 15px 20px;
        margin-bottom: 20px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }

    .invalid-feedback-modern {
        color: #f56565;
        font-size: 0.8rem;
        margin-top: 5px;
        display: block;
    }

    hr {
        background: linear-gradient(90deg, #667eea, #764ba2, #667eea);
        height: 2px;
        border: none;
        margin: 20px 0;
    }

    /* Breadcrumb */
    .breadcrumb-modern {
        margin-bottom: 25px;
    }

    .breadcrumb-modern .breadcrumb {
        background: transparent;
        padding: 0;
    }

    .breadcrumb-modern .breadcrumb-item a {
        color: #667eea;
        text-decoration: none;
    }

    /* Responsivo */
    @media (max-width: 768px) {
        .form-body {
            padding: 20px;
        }

        .btn-primary-modern, .btn-secondary-modern {
            width: 100%;
            margin-top: 10px;
        }

        .text-right {
            text-align: center !important;
        }
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
</style>

<div class="container-fluid fade-in">
    <!-- Breadcrumb -->
    <div class="breadcrumb-modern">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="#"><i class="fa fa-cogs"></i> Gestão Administrativa</a>
            </li>
            <li class="breadcrumb-item">
                <a href="#"><i class="fa fa-users"></i> Utilizadores</a>
            </li>
            <li class="breadcrumb-item active">
                <i class="fa fa-user-plus"></i> <b>Registar Utilizador</b>
            </li>
        </ol>
    </div>

    <!-- Form Card -->
    <div class="row">
        <div class="col-lg-10 offset-lg-1">
            <div class="form-card">
                <div class="form-header">
                    <h3>
                        <i class="fa fa-user-plus mr-2"></i> Registo de Utilizador
                    </h3>
                    <p>Preencha os dados abaixo para criar um novo utilizador no sistema</p>
                </div>

                <div class="form-body">
                    <!-- Mensagens de Sucesso/Erro -->
                    <?php if(isset($sucess)): ?>
                        <div class="alert alert-success alert-modern">
                            <i class="fa fa-check-circle mr-2"></i> <?php echo e($mensage ?? 'Operação realizada com sucesso!'); ?>

                        </div>
                    <?php endif; ?>

                    <?php if(isset($error)): ?>
                        <div class="alert alert-danger alert-modern">
                            <i class="fa fa-exclamation-triangle mr-2"></i> <?php echo e($mensage ?? 'Erro ao processar solicitação'); ?>

                        </div>
                    <?php endif; ?>

                    <?php if($errors->any()): ?>
                        <div class="alert alert-danger alert-modern">
                            <i class="fa fa-exclamation-triangle mr-2"></i>
                            <strong>Por favor, corrija os seguintes erros:</strong>
                            <ul class="mb-0 mt-2">
                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><?php echo e($error); ?></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <form method="POST" action="<?php echo e(route('Usuarios.store')); ?>" enctype="multipart/form-data" id="userForm">
                        <?php echo csrf_field(); ?>

                        <!-- Avatar Upload -->
                        <div class="avatar-upload">
                            <div class="avatar-preview" onclick="$('#avatarInput').click()">
                                <i class="fa fa-camera"></i>
                                <img id="avatarPreview" src="#" alt="Avatar" style="display: none;">
                            </div>
                            <input type="file" name="avatar" id="avatarInput" accept="image/*">
                            <div class="avatar-hint">
                                <i class="fa fa-info-circle"></i> Clique para adicionar foto (opcional)
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group-modern">
                                    <label class="label-modern">
                                        <i class="fa fa-user"></i> Nome Completo <span class="text-danger">*</span>
                                    </label>
                                    <input type="text"
                                           class="input-modern <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                           name="name"
                                           value="<?php echo e(old('name')); ?>"
                                           placeholder="Digite o nome completo do utilizador"
                                           required>
                                    <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback-modern"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group-modern">
                                    <label class="label-modern">
                                        <i class="fa fa-venus-mars"></i> Sexo <span class="text-danger">*</span>
                                    </label>
                                    <select class="select-modern <?php $__errorArgs = ['sexo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="sexo" required>
                                        <option value="">Selecione...</option>
                                        <option value="M" <?php echo e(old('sexo') == 'M' ? 'selected' : ''); ?>>Masculino</option>
                                        <option value="F" <?php echo e(old('sexo') == 'F' ? 'selected' : ''); ?>>Feminino</option>
                                    </select>
                                    <?php $__errorArgs = ['sexo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback-modern"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                        </div>

                        <div class="form-group-modern">
                            <label class="label-modern">
                                <i class="fa fa-envelope"></i> Email <span class="text-danger">*</span>
                            </label>
                            <input type="email"
                                   class="input-modern <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   name="email"
                                   value="<?php echo e(old('email')); ?>"
                                   placeholder="exemplo@dominio.com"
                                   required>
                            <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback-modern"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group-modern">
                                    <label class="label-modern">
                                        <i class="fa fa-briefcase"></i> Categoria do Funcionário <span class="text-danger">*</span>
                                    </label>
                                    <select class="select-modern <?php $__errorArgs = ['categoria'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="categoria" required>
                                        <option value="">Selecione a categoria...</option>
                                        <?php $__currentLoopData = $categoria; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categoriaItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($categoriaItem->id); ?>" <?php echo e(old('categoria') == $categoriaItem->id ? 'selected' : ''); ?>>
                                                <?php echo e($categoriaItem->Descricao); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <?php $__errorArgs = ['categoria'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback-modern"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group-modern">
                                    <label class="label-modern">
                                        <i class="fa fa-calendar"></i> Ano Lectivo <span class="text-danger">*</span>
                                    </label>
                                    <select class="select-modern <?php $__errorArgs = ['anolectivo_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="anolectivo_id" required>
                                        <option value="">Selecione o ano lectivo...</option>
                                        <?php $__currentLoopData = $anolectivo; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $anolectivoItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($anolectivoItem->id); ?>" <?php echo e(old('anolectivo_id') == $anolectivoItem->id ? 'selected' : ''); ?>>
                                                <?php echo e($anolectivoItem->anolectivo); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <?php $__errorArgs = ['anolectivo_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback-modern"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group-modern">
                                    <label class="label-modern">
                                        <i class="fa fa-layer-group"></i> Nível <span class="text-danger">*</span>
                                    </label>
                                    <select class="select-modern <?php $__errorArgs = ['Nivel'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="Nivel" required>
                                        <option value="">Selecione o nível...</option>
                                        <?php $__currentLoopData = $nivel; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $nivelItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($nivelItem->id); ?>" <?php echo e(old('Nivel') == $nivelItem->id ? 'selected' : ''); ?>>
                                                <?php echo e($nivelItem->Descricao); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <?php $__errorArgs = ['Nivel'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback-modern"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group-modern">
                                    <label class="label-modern">
                                        <i class="fa fa-tasks"></i> Papel/Função <span class="text-danger">*</span>
                                    </label>
                                    <select class="select-modern <?php $__errorArgs = ['role'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="role" required>
                                        <option value="">Selecione o papel...</option>
                                        <?php $__currentLoopData = $roles->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rolesvalue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($rolesvalue->id); ?>" <?php echo e(old('role') == $rolesvalue->id ? 'selected' : ''); ?>>
                                                <?php echo e($rolesvalue->label); ?>

                                                <?php if($roles->find($rolesvalue->id)->permission->count()): ?>
                                                    (<?php echo e($roles->find($rolesvalue->id)->permission->pluck('label')->implode(', ')); ?>)
                                                <?php endif; ?>
                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <?php $__errorArgs = ['role'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback-modern"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-12 text-right">
                                <button type="reset" class="btn-secondary-modern">
                                    <i class="fa fa-undo-alt mr-2"></i> Limpar
                                </button>
                                <button type="submit" class="btn-primary-modern ml-2" id="submitBtn">
                                    <i class="fa fa-save mr-2"></i> Registar Utilizador
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('script'); ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        // Preview de avatar
        $('#avatarInput').on('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                if (file.size > 2 * 1024 * 1024) {
                    Swal.fire('Erro', 'A imagem não pode exceder 2MB', 'error');
                    this.value = '';
                    return;
                }

                const reader = new FileReader();
                reader.onload = function(e) {
                    $('#avatarPreview').attr('src', e.target.result).show();
                    $('.avatar-preview i').hide();
                }
                reader.readAsDataURL(file);
            }
        });

        // Validação do formulário
        $('#userForm').on('submit', function(e) {
            let isValid = true;

            $(this).find('[required]').each(function() {
                if (!$(this).val()) {
                    $(this).addClass('is-invalid');
                    isValid = false;
                } else {
                    $(this).removeClass('is-invalid');
                }
            });

            if (!isValid) {
                e.preventDefault();
                Swal.fire('Atenção!', 'Por favor, preencha todos os campos obrigatórios.', 'warning');
            } else {
                const btn = $('#submitBtn');
                btn.html('<span class="loading-spinner"></span> A processar...').prop('disabled', true);
            }
        });

        // Remover classe de erro ao digitar
        $('input, select').on('input change', function() {
            if ($(this).val()) {
                $(this).removeClass('is-invalid');
                $(this).next('.invalid-feedback-modern').remove();
            }
        });
    });
</script>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('style'); ?>
<link rel="stylesheet" href="<?php echo e(asset('Registo/css/styles.min.css')); ?>" />
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<?php $__env->stopPush(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin-Lti', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\escola2025\resources\views/auth/register-usuario.blade.php ENDPATH**/ ?>