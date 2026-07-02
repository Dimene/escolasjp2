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

    /* Card Moderno */
    .card-modern {
        border: none;
        border-radius: 24px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .card-modern:hover {
        box-shadow: 0 15px 50px rgba(0, 0, 0, 0.12);
    }

    .card-header-modern {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 25px 30px;
        color: white;
        text-align: center;
    }

    .card-header-modern h3 {
        margin: 0;
        font-weight: 600;
    }

    .card-header-modern p {
        margin: 5px 0 0;
        opacity: 0.9;
    }

    .card-body-modern {
        padding: 30px;
    }

    /* Informações do usuário */
    .user-info {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-radius: 20px;
        padding: 20px;
        margin-bottom: 30px;
        text-align: center;
    }

    .user-avatar {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        margin: 0 auto 15px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .user-avatar i {
        font-size: 40px;
        color: white;
    }

    .user-name {
        font-size: 1.5rem;
        font-weight: 700;
        color: #374151;
        margin-bottom: 5px;
    }

    .user-roles {
        display: inline-flex;
        flex-wrap: wrap;
        gap: 8px;
        justify-content: center;
    }

    .role-badge {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 5px 15px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 500;
    }

    /* Formulário */
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

    .input-modern.error {
        border-color: #f56565;
        background: #fff5f5;
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

    /* Requisitos de senha */
    .password-requirements {
        background: #f8f9fa;
        border-radius: 12px;
        padding: 15px;
        margin-top: 15px;
    }

    .password-requirements h6 {
        margin-bottom: 10px;
        color: #374151;
    }

    .requirement {
        font-size: 0.8rem;
        color: #6c757d;
        margin-bottom: 5px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .requirement i {
        width: 18px;
    }

    .requirement.valid {
        color: #48bb78;
    }

    .requirement.invalid {
        color: #f56565;
    }

    /* Mensagens */
    .message-error {
        background: linear-gradient(135deg, #feb2b2 0%, #fc8181 100%);
        color: #c53030;
        padding: 12px 15px;
        border-radius: 12px;
        margin-top: 15px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .message-success {
        background: linear-gradient(135deg, #d4fc79 0%, #96e6a1 100%);
        color: #1e7e34;
        padding: 12px 15px;
        border-radius: 12px;
        margin-top: 15px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    /* Força da senha */
    .password-strength {
        margin-top: 10px;
    }

    .strength-bar {
        height: 4px;
        border-radius: 2px;
        background: #e5e7eb;
        overflow: hidden;
    }

    .strength-fill {
        height: 100%;
        width: 0%;
        transition: all 0.3s ease;
    }

    .strength-text {
        font-size: 0.7rem;
        margin-top: 5px;
        display: block;
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

    /* Responsivo */
    @media (max-width: 768px) {
        .card-body-modern {
            padding: 20px;
        }

        .user-name {
            font-size: 1.2rem;
        }

        .btn-primary-modern, .btn-secondary-modern {
            width: 100%;
            margin-top: 10px;
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
                <a href="#"><i class="fa fa-user-circle"></i> Utilizador</a>
            </li>
            <li class="breadcrumb-item active">
                <i class="fa fa-key"></i> Actualizar Senha
            </li>
        </ol>
    </div>

    <div class="row">
        <div class="col-lg-8 offset-lg-2">
            <div class="card-modern">
                <div class="card-header-modern">
                    <h3>
                        <i class="fa fa-lock mr-2"></i> Actualizar Senha
                    </h3>
                    <p>Altere a sua senha de acesso ao sistema</p>
                </div>

                <div class="card-body-modern">
                    <!-- Informações do Utilizador -->
                    <div class="user-info">
                        <div class="user-avatar">
                            <i class="fa fa-user-circle"></i>
                        </div>
                        <div class="user-name"><?php echo e($usuario->name); ?></div>
                        <div class="user-roles">
                            <?php $__currentLoopData = $usuario->roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <span class="role-badge">
                                    <i class="fa fa-tag"></i> <?php echo e($item->label); ?>

                                </span>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>

                    <form action="<?php echo e(Route('Usuarios.updatesenha', $usuario->id)); ?>" method="POST" id="passwordForm">
                        <?php echo method_field("PUT"); ?>
                        <?php echo csrf_field(); ?>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group-modern">
                                    <label class="label-modern">
                                        <i class="fa fa-key"></i> Nova Senha <span class="text-danger">*</span>
                                    </label>
                                    <input type="password"
                                           name="senha"
                                           id="password"
                                           minlength="8"
                                           required
                                           class="input-modern password-field"
                                           placeholder="Digite a nova senha">
                                    <div class="password-strength" id="passwordStrength">
                                        <div class="strength-bar">
                                            <div class="strength-fill" id="strengthFill"></div>
                                        </div>
                                        <span class="strength-text" id="strengthText"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group-modern">
                                    <label class="label-modern">
                                        <i class="fa fa-check-circle"></i> Confirmar Senha <span class="text-danger">*</span>
                                    </label>
                                    <input type="password"
                                           name="senhaConfirme"
                                           id="confirmPassword"
                                           minlength="8"
                                           required
                                           class="input-modern confirm-password-field"
                                           placeholder="Confirme a nova senha">
                                </div>
                            </div>
                        </div>

                        <!-- Requisitos da Senha -->
                        <div class="password-requirements">
                            <h6><i class="fa fa-shield"></i> Requisitos da Senha:</h6>
                            <div class="requirement" id="lengthReq">
                                <i class="fa fa-circle-o"></i> Mínimo de 8 caracteres
                            </div>
                            <div class="requirement" id="letterReq">
                                <i class="fa fa-circle-o"></i> Pelo menos uma letra
                            </div>
                            <div class="requirement" id="numberReq">
                                <i class="fa fa-circle-o"></i> Pelo menos um número
                            </div>
                            <div class="requirement" id="matchReq">
                                <i class="fa fa-circle-o"></i> As senhas devem coincidir
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-12 text-right">
                                <a href="<?php echo e(url()->previous()); ?>" class="btn-secondary-modern">
                                    <i class="fa fa-arrow-left mr-2"></i> Cancelar
                                </a>
                                <button type="submit" class="btn-primary-modern ml-2" id="submitBtn">
                                    <i class="fa fa-save mr-2"></i> Actualizar Senha
                                </button>
                            </div>
                        </div>

                        <div id="messageContainer"></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('script'); ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function(){
    const $password = $('#password');
    const $confirmPassword = $('#confirmPassword');
    const $submitBtn = $('#submitBtn');
    const $form = $('#passwordForm');

    // Elementos dos requisitos
    const $lengthReq = $('#lengthReq');
    const $letterReq = $('#letterReq');
    const $numberReq = $('#numberReq');
    const $matchReq = $('#matchReq');

    // Elementos da força da senha
    const $strengthFill = $('#strengthFill');
    const $strengthText = $('#strengthText');

    // Função para verificar força da senha
    function checkPasswordStrength(password) {
        let strength = 0;
        let message = '';
        let color = '';

        if (password.length >= 8) strength++;
        if (password.match(/[a-zA-Z]/)) strength++;
        if (password.match(/[0-9]/)) strength++;
        if (password.match(/[^a-zA-Z0-9]/)) strength++;

        switch(strength) {
            case 1:
                message = 'Fraca';
                color = '#f56565';
                break;
            case 2:
                message = 'Média';
                color = '#ed8936';
                break;
            case 3:
                message = 'Boa';
                color = '#48bb78';
                break;
            case 4:
                message = 'Forte';
                color = '#38a169';
                break;
            default:
                message = 'Muito Fraca';
                color = '#f56565';
        }

        const width = (strength / 4) * 100;
        $strengthFill.css('width', width + '%');
        $strengthFill.css('background', color);
        $strengthText.text(message).css('color', color);
    }

    // Função para verificar requisitos
    function checkRequirements() {
        const password = $password.val();
        const confirmPassword = $confirmPassword.val();
        let allValid = true;

        // Verificar comprimento
        if (password.length >= 8) {
            $lengthReq.removeClass('invalid').addClass('valid');
            $lengthReq.html('<i class="fa fa-check-circle"></i> Mínimo de 8 caracteres');
        } else {
            $lengthReq.removeClass('valid').addClass('invalid');
            $lengthReq.html('<i class="fa fa-exclamation-circle"></i> Mínimo de 8 caracteres');
            allValid = false;
        }

        // Verificar letras
        if (/[a-zA-Z]/.test(password)) {
            $letterReq.removeClass('invalid').addClass('valid');
            $letterReq.html('<i class="fa fa-check-circle"></i> Pelo menos uma letra');
        } else {
            $letterReq.removeClass('valid').addClass('invalid');
            $letterReq.html('<i class="fa fa-exclamation-circle"></i> Pelo menos uma letra');
            allValid = false;
        }

        // Verificar números
        if (/[0-9]/.test(password)) {
            $numberReq.removeClass('invalid').addClass('valid');
            $numberReq.html('<i class="fa fa-check-circle"></i> Pelo menos um número');
        } else {
            $numberReq.removeClass('valid').addClass('invalid');
            $numberReq.html('<i class="fa fa-exclamation-circle"></i> Pelo menos um número');
            allValid = false;
        }

        // Verificar coincidência
        if (password === confirmPassword && password.length > 0) {
            $matchReq.removeClass('invalid').addClass('valid');
            $matchReq.html('<i class="fa fa-check-circle"></i> As senhas coincidem');
        } else if (confirmPassword.length > 0) {
            $matchReq.removeClass('valid').addClass('invalid');
            $matchReq.html('<i class="fa fa-exclamation-circle"></i> As senhas não coincidem');
            allValid = false;
        } else {
            $matchReq.removeClass('valid invalid');
            $matchReq.html('<i class="fa fa-circle-o"></i> As senhas devem coincidir');
        }

        // Verificar força da senha se tiver conteúdo
        if (password.length > 0) {
            checkPasswordStrength(password);
        } else {
            $strengthFill.css('width', '0%');
            $strengthText.text('');
        }

        // Remover classes de erro dos inputs
        if (password.length > 0 && !allValid) {
            $password.addClass('error');
        } else {
            $password.removeClass('error');
        }

        if (confirmPassword.length > 0 && password !== confirmPassword) {
            $confirmPassword.addClass('error');
        } else {
            $confirmPassword.removeClass('error');
        }

        return allValid;
    }

    // Evento de digitação na senha
    $password.on('keyup', function() {
        checkRequirements();
    });

    // Evento de digitação na confirmação
    $confirmPassword.on('keyup', function() {
        checkRequirements();
    });

    // Validação antes do submit
    $form.on('submit', function(e) {
        e.preventDefault();

        const isValid = checkRequirements();
        const password = $password.val();
        const confirmPassword = $confirmPassword.val();

        if (!isValid || password.length === 0 || confirmPassword.length === 0) {
            Swal.fire({
                icon: 'error',
                title: 'Erro de Validação',
                text: 'Por favor, preencha todos os requisitos da senha corretamente.',
                confirmButtonColor: '#3085d6'
            });
            return false;
        }

        if (password !== confirmPassword) {
            Swal.fire({
                icon: 'error',
                title: 'Senhas não coincidem',
                text: 'A nova senha e a confirmação devem ser iguais.',
                confirmButtonColor: '#3085d6'
            });
            return false;
        }

        // Mostrar loading e submeter
        const $btn = $(this).find('button[type="submit"]');
        const originalHtml = $btn.html();
        $btn.html('<span class="loading-spinner"></span> A processar...').prop('disabled', true);

        // Submeter o formulário
        this.submit();
    });

    // Remover mensagem de erro ao digitar
    $('.password-field, .confirm-password-field').on('keyup', function() {
        $(this).removeClass('error');
        $('#messageContainer').empty();
    });
});
</script>

<style>
    .requirement.valid {
        color: #48bb78;
    }

    .requirement.invalid {
        color: #f56565;
    }

    .requirement i {
        width: 18px;
    }

    .password-field.error, .confirm-password-field.error {
        border-color: #f56565 !important;
        background: #fff5f5 !important;
    }

    .ml-2 {
        margin-left: 0.5rem;
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin-Lti', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\escolasaojoaopaulo\resources\views/auth/Atualizarsenha.blade.php ENDPATH**/ ?>