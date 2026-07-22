<?php
    $host = request()->getHost();
    $subdomain = explode('.', $host)[0];
?>

<?php $__env->startSection('content'); ?>
<?php $__env->startPush('style'); ?>
<link rel="stylesheet" href="<?php echo e(asset('Comfig/assets/bootstrap/css/bootstrap.min.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('Comfig/assets/css/styles.min.css')); ?>">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

<style>
    /* Animações e estilos modernos */
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

    .slide-in {
        animation: slideIn 0.4s ease-out;
    }

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateX(-30px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    /* Content Wrapper */
    .content-wrapper {
        background: linear-gradient(135deg, #f5f7fa 0%, #f8f9fc 100%);
        min-height: 100vh;
    }

    /* Card Moderno */
    .card-modern {
        border: none;
        border-radius: 24px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        overflow: hidden;
    }

    .card-modern:hover {
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.12);
    }

    /* Avatar Section */
    .avatar-wrapper {
        padding: 20px;
        background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
        border-radius: 20px;
    }

    .avatar-preview {
        width: 200px;
        height: 200px;
        margin: 0 auto;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        position: relative;
    }

    .avatar-preview:hover {
        transform: scale(1.02);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
    }

    .avatar-img {
        width: 100%;
        height: 100%;
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        transition: all 0.3s ease;
    }

    .avatar-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.6);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .avatar-preview:hover .avatar-overlay {
        opacity: 1;
    }

    .avatar-overlay i {
        color: white;
        font-size: 2rem;
    }

    /* Custom File Input */
    .custom-file-modern {
        position: relative;
        display: inline-block;
        width: 100%;
        margin-top: 15px;
    }

    .custom-file-input-modern {
        position: absolute;
        opacity: 0;
        width: 100%;
        height: 100%;
        cursor: pointer;
    }

    .custom-file-label-modern {
        display: block;
        padding: 10px 15px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        text-align: center;
        border-radius: 12px;
        cursor: pointer;
        transition: all 0.3s ease;
        font-weight: 500;
    }

    .custom-file-label-modern:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
    }

    /* Form Groups */
    .form-group-modern {
        margin-bottom: 1.5rem;
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

    .label-modern .text-danger {
        color: #f56565;
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

    .invalid-feedback-modern {
        color: #f56565;
        font-size: 0.8rem;
        margin-top: 5px;
        display: block;
    }

    /* Select Modern */
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

    /* Buttons */
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
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .btn-secondary-modern:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 12px rgba(108, 117, 125, 0.3);
        color: white;
    }

    /* Header Section */
    .content-header-modern {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 20px;
        padding: 20px 25px;
        margin-bottom: 25px;
        color: white;
    }

    /* Breadcrumb */
    .breadcrumb-modern {
        background: rgba(255, 255, 255, 0.1);
        border-radius: 12px;
        padding: 8px 16px;
    }

    .breadcrumb-modern .breadcrumb-item a {
        color: white;
        text-decoration: none;
    }

    .breadcrumb-modern .breadcrumb-item.active {
        color: rgba(255, 255, 255, 0.8);
    }

    /* Alerts */
    .alert-modern {
        border: none;
        border-radius: 16px;
        padding: 16px 20px;
        margin-bottom: 20px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        animation: slideIn 0.4s ease-out;
    }

    .alert-success-modern {
        background: linear-gradient(135deg, #d4fc79 0%, #96e6a1 100%);
        color: #1e7e34;
    }

    .alert-danger-modern {
        background: linear-gradient(135deg, #feb2b2 0%, #fc8181 100%);
        color: #c53030;
    }

    /* Título */
    .section-title {
        font-size: 1.8rem;
        font-weight: 700;
        margin-bottom: 0;
        display: flex;
        align-items: center;
    }

    .section-title i {
        margin-right: 15px;
        font-size: 2rem;
    }

    hr {
        background: linear-gradient(90deg, #667eea, #764ba2, #667eea);
        height: 2px;
        border: none;
        margin: 20px 0;
    }

    /* Loading Spinner */
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

    /* Responsive */
    @media (max-width: 768px) {
        .avatar-preview {
            width: 150px;
            height: 150px;
            margin-bottom: 20px;
        }

        .section-title {
            font-size: 1.3rem;
        }

        .btn-primary-modern, .btn-secondary-modern {
            padding: 8px 20px;
            font-size: 0.85rem;
        }
    }

    /* Tooltip */
    .tooltip-custom {
        position: relative;
        display: inline-block;
    }

    .tooltip-custom .tooltip-text {
        visibility: hidden;
        background-color: #374151;
        color: white;
        text-align: center;
        border-radius: 6px;
        padding: 5px 10px;
        position: absolute;
        z-index: 1;
        bottom: 125%;
        left: 50%;
        margin-left: -60px;
        opacity: 0;
        transition: opacity 0.3s;
        font-size: 0.75rem;
        white-space: nowrap;
    }

    .tooltip-custom:hover .tooltip-text {
        visibility: visible;
        opacity: 1;
    }
</style>
<?php $__env->stopPush(); ?>

<section class="content">

        <div class="content-header">
            <div class="container-fluid">
                <!-- Header Moderno -->
                <div class="content-header-modern fade-in">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h1 class="section-title">
                                <i class="fas fa-cogs"></i>
                                Configurações do Sistema
                            </h1>
                            <p class="mb-0 mt-2 opacity-75">
                                <i class="fas fa-info-circle mr-1"></i>
                                Configure as informações da sua instituição
                            </p>
                        </div>
                        <div class="col-md-4">
                            <ol class="breadcrumb breadcrumb-modern float-md-right">
                                <li class="breadcrumb-item">
                                    <a href="#">
                                        <i class="fas fa-home mr-1"></i> <?php echo e(session()->get('infosession')->TIpoSistema ?? 'Sistema'); ?>

                                    </a>
                                </li>
                                <li class="breadcrumb-item active">Configurações</li>
                            </ol>
                        </div>
                    </div>
                </div>

                <!-- Card Principal -->
                <div class="card-modern fade-in">
                    <div class="card-body p-4">
                        <form method="POST" action="<?php echo e(route('Configuracoes.store')); ?>" enctype="multipart/form-data" id="configForm">
                            <?php echo csrf_field(); ?>

                            <!-- Alertas -->
                            <div class="alert alert-success alert-modern alert-success-modern d-none" id="successAlert" role="alert">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-check-circle fa-2x mr-3"></i>
                                    <div>
                                        <strong class="d-block">Sucesso!</strong>
                                        <span id="alertMessage">Configurações salvas com sucesso!</span>
                                    </div>
                                </div>
                            </div>

                            <?php if($errors->any()): ?>
                                <div class="alert alert-danger alert-modern alert-danger-modern" role="alert">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-exclamation-triangle fa-2x mr-3"></i>
                                        <div>
                                            <strong class="d-block">Erro de validação!</strong>
                                            <p class="mb-0">Por favor, corrija os erros abaixo.</p>
                                            <ul class="mb-0 mt-2">
                                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <li><?php echo e($error); ?></li>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <div class="row">
                                <!-- Logo Section -->
                                <div class="col-md-4 text-center slide-in">
                                    <div class="avatar-wrapper">
                                        <div class="avatar-preview" id="avatarPreview">
                                            <div class="avatar-img" style="background-image: url('<?php echo e(url("storage/$subdomain/logoMarca/$conf->avatar")); ?>');"></div>
                                            <div class="avatar-overlay" onclick="$('#avatarFile').click()">
                                                <i class="fas fa-camera"></i>
                                            </div>
                                        </div>

                                        <div class="custom-file-modern mt-3">
                                            <input type="file" name="avatar-file" id="avatarFile" class="custom-file-input-modern" accept="image/*">
                                            <label class="custom-file-label-modern" for="avatarFile">
                                                <i class="fas fa-upload mr-2"></i> Escolher Logo
                                            </label>
                                        </div>
                                        <small class="form-text text-muted mt-2">
                                            <i class="fas fa-info-circle mr-1"></i> Formatos: JPG, PNG, GIF (Max. 2MB)
                                        </small>
                                    </div>
                                </div>

                                <!-- Form Fields -->
                                <div class="col-md-8 slide-in" style="animation-delay: 0.1s">
                                    <div class="d-flex align-items-center mb-4">
                                        <i class="fas fa-building fa-2x" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;"></i>
                                        <h3 class="mb-0 ml-3" style="font-weight: 600;">Informações da Instituição</h3>
                                    </div>
                                    <hr>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group-modern">
                                                <label class="label-modern" for="Nome">
                                                    <i class="fas fa-building mr-2" style="color: #667eea;"></i>
                                                    Nome da Instituição <span class="text-danger">*</span>
                                                </label>
                                                <input class="input-modern <?php $__errorArgs = ['Nome'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                       type="text" id="Nome" name="Nome"
                                                       value="<?php echo e(old('Nome', $conf->nome ?? '')); ?>"
                                                       placeholder="Digite o nome da instituição" required>
                                                <?php $__errorArgs = ['Nome'];
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
                                                <label class="label-modern" for="NUit">
                                                    <i class="fas fa-id-card mr-2" style="color: #667eea;"></i>
                                                    NUIT <span class="text-danger">*</span>
                                                </label>
                                                <input class="input-modern <?php $__errorArgs = ['NUit'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                       type="text" id="NUit" name="NUit"
                                                       value="<?php echo e(old('NUit', $conf->NUit ?? '')); ?>"
                                                       placeholder="123456789"
                                                      maxlength="9" required>
                                                <?php $__errorArgs = ['NUit'];
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
                                        <label class="label-modern" for="email">
                                            <i class="fas fa-envelope mr-2" style="color: #667eea;"></i>
                                            Email Institucional <span class="text-danger">*</span>
                                        </label>
                                        <input class="input-modern <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                               type="email" id="email" name="email"
                                               value="<?php echo e(old('email', $conf->Email ?? '')); ?>"
                                               placeholder="contato@instituicao.com" required>
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

                                    <div class="form-group-modern">
                                        <label class="label-modern" for="endereco">
                                            <i class="fas fa-map-marker-alt mr-2" style="color: #667eea;"></i>
                                            Endereço <span class="text-danger">*</span>
                                        </label>
                                        <input class="input-modern <?php $__errorArgs = ['endereco'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                               type="text" id="endereco" name="endereco"
                                               value="<?php echo e(old('endereco', $conf->Localizacao ?? '')); ?>"
                                               placeholder="Cidade, Bairro, Rua, Nº" required>
                                        <?php $__errorArgs = ['endereco'];
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
                                                <label class="label-modern" for="Contacto">
                                                    <i class="fas fa-phone mr-2" style="color: #667eea;"></i>
                                                    Contacto Principal <span class="text-danger">*</span>
                                                </label>
                                                <input class="input-modern <?php $__errorArgs = ['Contacto'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                       type="tel" id="Contacto" name="Contacto"
                                                       value="<?php echo e(old('Contacto', $conf->Contacto ?? '')); ?>"
                                                       placeholder="841234567"
                                                       pattern="[0-9]{9}" maxlength="9" required>
                                                <?php $__errorArgs = ['Contacto'];
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
                                                <label class="label-modern" for="Contacto2">
                                                    <i class="fas fa-phone-alt mr-2" style="color: #667eea;"></i>
                                                    Contacto Alternativo
                                                </label>
                                                <input class="input-modern <?php $__errorArgs = ['Contacto2'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                       type="tel" id="Contacto2" name="Contacto2"
                                                       value="<?php echo e(old('Contacto2', $conf->Contacto2 ?? '')); ?>"
                                                       placeholder="842345678"
                                                       pattern="[0-9]{9}" maxlength="9">
                                                <?php $__errorArgs = ['Contacto2'];
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
                                                <label class="label-modern" for="TIpoSistema">
                                                    <i class="fas fa-chart-line mr-2" style="color: #667eea;"></i>
                                                    Tipo de Sistema <span class="text-danger">*</span>
                                                </label>
                                                <select class="select-modern <?php $__errorArgs = ['TIpoSistema'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                        id="TIpoSistema" name="TIpoSistema" required>
                                                    <option value="">Selecione o tipo de sistema...</option>
                                                    <option value="ERP" <?php echo e(old('TIpoSistema', $conf->TIpoSistema ?? '') == 'ERP' ? 'selected' : ''); ?>>
                                                        📊 ERP - Gestão Empresarial
                                                    </option>
                                                    <option value="CRM" <?php echo e(old('TIpoSistema', $conf->TIpoSistema ?? '') == 'CRM' ? 'selected' : ''); ?>>
                                                        🤝 CRM - Gestão de Clientes
                                                    </option>
                                                    <option value="POS" <?php echo e(old('TIpoSistema', $conf->TIpoSistema ?? '') == 'POS' ? 'selected' : ''); ?>>
                                                        🛒 POS - Ponto de Venda
                                                    </option>
                                                </select>
                                                <?php $__errorArgs = ['TIpoSistema'];
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
                                                <label class="label-modern" for="nome_Empresa">
                                                    <i class="fas fa-briefcase mr-2" style="color: #667eea;"></i>
                                                    Nome Comercial
                                                </label>
                                                <input class="input-modern <?php $__errorArgs = ['nome_Empresa'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                       type="text" id="nome_Empresa" name="nome_Empresa"
                                                       value="<?php echo e(old('nome_Empresa', $conf->nome_Empresa ?? '')); ?>"
                                                       placeholder="Nome fantasia (opcional)">
                                                <?php $__errorArgs = ['nome_Empresa'];
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

                                    <hr class="mt-4">

                                    <div class="text-right">
                                        <button type="reset" class="btn-secondary-modern mr-2">
                                            <i class="fas fa-undo-alt mr-2"></i> Limpar
                                        </button>
                                        <button type="submit" class="btn-primary-modern" id="submitBtn">
                                            <i class="fas fa-save mr-2"></i> Guardar Configurações
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

</section>

<?php $__env->startPush('scripts'); ?>
<script src="<?php echo e(asset('Comfig/assets/js/jquery.min.js')); ?>"></script>
<script src="<?php echo e(asset('Comfig/assets/bootstrap/js/bootstrap.min.js')); ?>"></script>

<script>
$(document).ready(function() {
    // Preview da imagem
    $('#avatarFile').on('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            if (file.size > 2 * 1024 * 1024) {
                alert('O arquivo é muito grande. Máximo 2MB.');
                this.value = '';
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                $('.avatar-img').css('background-image', 'url(' + e.target.result + ')');
            }
            reader.readAsDataURL(file);
        }
    });

    // Submit com loading
    $('#configForm').on('submit', function(e) {
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
            alert('Por favor, preencha todos os campos obrigatórios.');
            return false;
        }

        const btn = $('#submitBtn');
        btn.html('<span class="loading-spinner"></span> A processar...').prop('disabled', true);

        // O form será submetido normalmente pelo servidor
        return true;
    });

    // Remover classe de erro ao digitar
    $('input, select').on('input change', function() {
        if ($(this).val()) {
            $(this).removeClass('is-invalid');
        }
    });

    // Máscara para NUIT e Contactos
    $('#NUit').on('input', function() {
        this.value = this.value.replace(/[^0-9]/g, '').slice(0, 9);
    });

    $('#Contacto, #Contacto2').on('input', function() {
        this.value = this.value.replace(/[^0-9]/g, '').slice(0, 9);
    });

    // Mostrar sucesso se houver na sessão
    <?php if(session('success')): ?>
        $('#alertMessage').text('<?php echo e(session('success')); ?>');
        $('#successAlert').removeClass('d-none').addClass('show');
        setTimeout(function() {
            $('#successAlert').fadeOut('slow', function() {
                $(this).addClass('d-none').removeClass('show').show();
            });
        }, 4000);
    <?php endif; ?>
});
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin-Lti', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\escolasaojoaopaulo\resources\views/Admin/ACL/configuracoes.blade.php ENDPATH**/ ?>