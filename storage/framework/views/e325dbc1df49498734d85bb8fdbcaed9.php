<?php
$conf = DB::table('config')->first();
$host = request()->getHost();
$subdomain = explode('.', $host)[0];
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>Login - <?php echo e($conf->nome_Empresa ?? 'Sistema de Gestão Escolar'); ?></title>

    <!-- Styles -->
    <link rel="stylesheet" href="<?php echo e(asset('Comfig/assets/bootstrap/css/bootstrap.min.css')); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary: #4f46e5;
            --primary-dark: #4338ca;
            --primary-light: #6366f1;
            --secondary: #06b6d4;
            --accent: #f59e0b;
            --success: #10b981;
            --danger: #ef4444;
            --dark: #1e293b;
            --gray: #64748b;
            --light: #f1f5f9;
            --white: #ffffff;
        }

        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow-x: hidden;
        }

        /* Fundo Gradiente Animado */
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            z-index: -2;
        }

        /* Partículas de fundo */
        .bg-particles {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            overflow: hidden;
        }

        .particle {
            position: absolute;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            animation: float 20s infinite ease-in-out;
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0) translateX(0);
                opacity: 0.3;
            }
            25% {
                transform: translateY(-20px) translateX(10px);
                opacity: 0.6;
            }
            50% {
                transform: translateY(0) translateX(20px);
                opacity: 0.4;
            }
            75% {
                transform: translateY(20px) translateX(10px);
                opacity: 0.7;
            }
        }

        /* Onda decorativa */
        .wave {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 100px;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="rgba(255,255,255,0.1)" fill-opacity="1" d="M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,122.7C672,117,768,139,864,154.7C960,171,1056,181,1152,165.3C1248,149,1344,107,1392,85.3L1440,64L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>') repeat-x;
            background-size: cover;
            opacity: 0.3;
            pointer-events: none;
        }

        /* Container Principal */
        .login-wrapper {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }

        /* Card Principal */
        .login-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 32px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            overflow: hidden;
            transition: all 0.3s ease;
            width: 100%;
            max-width: 480px;
        }

        .login-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 30px 60px -12px rgba(0, 0, 0, 0.3);
        }

        /* Cabeçalho */
        .login-header {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            padding: 40px 30px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .login-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 1%, transparent 1%);
            background-size: 30px 30px;
            animation: pulse 20s linear infinite;
        }

        @keyframes pulse {
            0% {
                transform: translate(0, 0);
            }
            100% {
                transform: translate(30px, 30px);
            }
        }

        /* Logo */
        .logo-container {
            width: 100px;
            height: 100px;
            margin: 0 auto 20px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            z-index: 1;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
        }

        .logo-container:hover {
            transform: scale(1.05);
        }

        .logo-container img {
            width: 80%;
            height: 80%;
            object-fit: contain;
            border-radius: 50%;
        }

        .system-name {
            color: white;
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 5px;
            position: relative;
            z-index: 1;
        }

        .company-name {
            color: rgba(255, 255, 255, 0.9);
            font-size: 0.9rem;
            position: relative;
            z-index: 1;
        }

        /* Corpo do Formulário */
        .login-body {
            padding: 40px 35px;
        }

        /* Campos do Formulário */
        .input-group {
            border-radius: 12px;
            overflow: hidden;
            transition: all 0.3s ease;
            border: 2px solid #e2e8f0;
            background: white;
        }

        .input-group:focus-within {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        }

        .input-group-text {
            background: white;
            border: none;
            color: var(--primary);
            font-size: 1.1rem;
            padding-left: 15px;
        }

        .form-control {
            border: none;
            padding: 12px 15px;
            font-size: 0.95rem;
            background: white;
        }

        .form-control:focus {
            box-shadow: none;
            outline: none;
        }

        .form-label {
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 8px;
            display: block;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Botão Login */
        .btn-login {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            border: none;
            border-radius: 12px;
            padding: 14px 30px;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s ease;
            width: 100%;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .btn-login::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s ease;
        }

        .btn-login:hover::before {
            left: 100%;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px -5px rgba(79, 70, 229, 0.4);
        }

        .btn-login i {
            margin-left: 8px;
            transition: transform 0.3s ease;
        }

        .btn-login:hover i {
            transform: translateX(5px);
        }

        /* Link Esqueci Senha */
        .forgot-link {
            text-align: center;
            margin-top: 20px;
        }

        .forgot-link a {
            color: var(--gray);
            text-decoration: none;
            font-size: 0.85rem;
            transition: color 0.3s ease;
        }

        .forgot-link a:hover {
            color: var(--primary);
        }

        /* Mensagens de Erro */
        .invalid-feedback {
            font-size: 0.75rem;
            margin-top: 5px;
            color: var(--danger);
        }

        /* Checkbox personalizado */
        .form-check {
            display: flex;
            align-items: center;
        }

        .form-check-input {
            width: 18px;
            height: 18px;
            margin-right: 10px;
            cursor: pointer;
            accent-color: var(--primary);
        }

        .form-check-label {
            font-size: 0.85rem;
            color: var(--gray);
            cursor: pointer;
        }

        /* Responsivo */
        @media (max-width: 768px) {
            .login-card {
                margin: 20px;
            }

            .login-header {
                padding: 30px 20px;
            }

            .login-body {
                padding: 30px 25px;
            }

            .system-name {
                font-size: 1.5rem;
            }

            .logo-container {
                width: 80px;
                height: 80px;
            }
        }

        /* Animação de entrada */
        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .login-card {
            animation: slideInUp 0.6s ease-out;
        }
    </style>
</head>
<body>
    <!-- Partículas de fundo -->
    <div class="bg-particles">
        <?php for($i = 0; $i < 30; $i++): ?>
            <div class="particle" style="
                width: <?php echo rand(20, 100); ?>px;
                height: <?php echo rand(20, 100); ?>px;
                left: <?php echo rand(0, 100); ?>%;
                top: <?php echo rand(0, 100); ?>%;
                animation-delay: <?php echo rand(0, 20); ?>s;
                animation-duration: <?php echo rand(15, 30); ?>s;
            "></div>
        <?php endfor; ?>
    </div>

    <!-- Onda decorativa -->
    <div class="wave"></div>

    <div class="login-wrapper">
        <div class="login-card">
            <div class="login-header">
                <div class="logo-container">
                    <img src="<?php echo e(asset('storage/'.$subdomain.'/logoMarca/'.$conf->avatar)); ?>" alt="<?php echo e($conf->nome_Empresa ?? 'Logo'); ?>">
                </div>
                <h3 class="system-name">Sistema de Gestão</h3>
                <p class="company-name"><?php echo e($conf->nome_Empresa ?? 'Bem-vindo'); ?></p>
            </div>

            <div class="login-body">
                <?php if($errors->any()): ?>
                    <div class="alert alert-danger" style="border-radius: 12px; margin-bottom: 20px;">
                        <i class="fas fa-exclamation-circle"></i>
                        <strong>Erro!</strong> <?php echo e($errors->first()); ?>

                    </div>
                <?php endif; ?>

                <form method="POST" action="<?php echo e(route('login')); ?>">
                    <?php echo csrf_field(); ?>

                    <div class="mb-4">
                        <label class="form-label">
                            <i class="fas fa-envelope me-2"></i> Email
                        </label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-envelope"></i>
                            </span>
                            <input type="email"
                                   name="email"
                                   class="form-control"
                                   placeholder="seu@email.com"
                                   value="<?php echo e(old('email')); ?>"
                                   required
                                   autofocus>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">
                            <i class="fas fa-lock me-2"></i> Senha
                        </label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-lock"></i>
                            </span>
                            <input type="password"
                                   name="password"
                                   class="form-control"
                                   placeholder="••••••••"
                                   required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember">
                            <label class="form-check-label" for="remember">
                                <i class="fas fa-check-circle me-1"></i> Manter-me conectado
                            </label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-login">
                        Entrar no Sistema <i class="fas fa-arrow-right"></i>
                    </button>

                    <div class="forgot-link">
                        <a href="<?php echo e(route('password.request')); ?>">
                            <i class="fas fa-question-circle me-1"></i> Esqueceu a senha?
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="<?php echo e(asset('Comfig/assets/bootstrap/js/bootstrap.bundle.min.js')); ?>"></script>

    <script>
        // Adicionar partículas dinâmicas
        document.addEventListener('DOMContentLoaded', function() {
            const particlesContainer = document.querySelector('.bg-particles');
            const particleCount = 40;

            for (let i = 0; i < particleCount; i++) {
                const particle = document.createElement('div');
                particle.className = 'particle';
                const size = Math.random() * 80 + 20;
                particle.style.width = size + 'px';
                particle.style.height = size + 'px';
                particle.style.left = Math.random() * 100 + '%';
                particle.style.top = Math.random() * 100 + '%';
                particle.style.animationDelay = Math.random() * 20 + 's';
                particle.style.animationDuration = Math.random() * 20 + 15 + 's';
                particlesContainer.appendChild(particle);
            }
        });
    </script>
</body>
</html>
<?php /**PATH /home/sgemozco/escolasaojoaopauloii.sgemoz.com/resources/views/auth/login.blade.php ENDPATH**/ ?>