<?php
$conf = DB::table('config')->first();
$host = request()->getHost();
$subdomain = explode('.', $host)[0];
?>

<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?php echo e($conf->nome_Empresa ?? 'Instituição de Ensino'); ?> | <?php echo e($conf->TIpoSistema ?? 'Sistema de Gestão Escolar'); ?></title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700;800&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <style>
        /* ======================================== */
        /* VARIÁVEIS E RESET */
        /* ======================================== */
        :root {
            --primary-color: #4e73df;
            --primary-dark: #2e59d9;
            --primary-light: #5a8dee;
            --secondary-color: #f8f9fc;
            --accent-color: #36b9cc;
            --dark-color: #2c3e50;
            --dark-gray: #4a5568;
            --light-gray: #edf2f7;
            --success-color: #28a745;
            --warning-color: #ffc107;
            --danger-color: #dc3545;
            --info-color: #17a2b8;
            --white: #ffffff;
            --black: #1a202c;
            --shadow-sm: 0 2px 4px rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 6px rgba(0, 0, 0, 0.07);
            --shadow-lg: 0 10px 15px rgba(0, 0, 0, 0.1);
            --shadow-xl: 0 20px 25px rgba(0, 0, 0, 0.15);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #f8f9fc 100%);
            color: var(--dark-gray);
            line-height: 1.6;
            overflow-x: hidden;
        }

        /* ======================================== */
        /* ANIMAÇÕES */
        /* ======================================== */
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

        @keyframes fadeInRight {
            from {
                opacity: 0;
                transform: translateX(30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes zoomIn {
            from {
                opacity: 0;
                transform: scale(0.9);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        @keyframes float {
            0% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-10px);
            }
            100% {
                transform: translateY(0px);
            }
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.05);
            }
            100% {
                transform: scale(1);
            }
        }

        .fade-in-up {
            animation: fadeInUp 0.8s ease-out forwards;
        }

        .fade-in-left {
            animation: fadeInLeft 0.6s ease-out forwards;
        }

        .fade-in-right {
            animation: fadeInRight 0.6s ease-out forwards;
        }

        .zoom-in {
            animation: zoomIn 0.5s ease-out forwards;
        }

        /* ======================================== */
        /* HERO SECTION */
        /* ======================================== */
        .hero-section {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            position: relative;
            overflow: hidden;
            padding: 120px 0 80px;
            color: white;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 1%, transparent 1%);
            background-size: 50px 50px;
            animation: pulse 20s linear infinite;
        }

        .hero-section::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 100px;
            background: linear-gradient(to top, #f5f7fa, transparent);
        }

        .hero-content {
            position: relative;
            z-index: 2;
            text-align: center;
            max-width: 800px;
            margin: 0 auto;
        }

        .hero-title {
            font-size: 3.5rem;
            font-weight: 800;
            margin-bottom: 20px;
            font-family: 'Playfair Display', serif;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
        }

        .hero-subtitle {
            font-size: 1.2rem;
            margin-bottom: 30px;
            opacity: 0.9;
        }

        .hero-buttons .btn {
            margin: 0 10px;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 12px 30px;
            border-radius: 50px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }

        .btn-primary {
            background: white;
            color: var(--primary-color);
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }

        .btn-outline {
            background: transparent;
            border: 2px solid white;
            color: white;
        }

        .btn-outline:hover {
            background: white;
            color: var(--primary-color);
            transform: translateY(-3px);
        }

        /* ======================================== */
        /* LOGO SECTION */
        /* ======================================== */
        .logo-section {
            margin-top: -60px;
            position: relative;
            z-index: 10;
            margin-bottom: 60px;
        }

        .logo-wrapper {
            background: white;
            border-radius: 30px;
            box-shadow: var(--shadow-xl);
            padding: 30px;
            text-align: center;
            max-width: 250px;
            margin: 0 auto;
            transition: all 0.3s ease;
        }

        .logo-wrapper:hover {
            transform: translateY(-5px);
        }

        .logo-image {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 20px;
            border: 5px solid var(--primary-color);
        }

        .institution-name {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--dark-color);
            margin-bottom: 5px;
        }

        .institution-type {
            color: var(--primary-color);
            font-weight: 600;
        }

        /* ======================================== */
        /* CARDS SECTION */
        /* ======================================== */
        .stats-section {
            padding: 60px 0;
            background: linear-gradient(135deg, var(--secondary-color) 0%, white 100%);
        }

        .stat-card {
            background: white;
            border-radius: 20px;
            padding: 30px;
            text-align: center;
            box-shadow: var(--shadow-md);
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-10px);
            box-shadow: var(--shadow-xl);
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--primary-color);
            margin-bottom: 10px;
        }

        .stat-label {
            font-size: 1rem;
            color: var(--dark-gray);
        }

        /* ======================================== */
        /* MISSION VISION SECTION */
        /* ======================================== */
        .mission-vision-section {
            padding: 80px 0;
            background: white;
        }

        .section-header {
            text-align: center;
            margin-bottom: 50px;
        }

        .section-title {
            font-size: 2.2rem;
            font-weight: 700;
            color: var(--dark-color);
            margin-bottom: 15px;
            font-family: 'Playfair Display', serif;
        }

        .section-divider {
            width: 80px;
            height: 3px;
            background: linear-gradient(90deg, var(--primary-color), var(--accent-color));
            margin: 0 auto;
            border-radius: 3px;
        }

        .mission-card, .vision-card, .values-card {
            background: white;
            border-radius: 20px;
            padding: 40px 30px;
            text-align: center;
            box-shadow: var(--shadow-lg);
            transition: all 0.3s ease;
            height: 100%;
        }

        .mission-card:hover, .vision-card:hover, .values-card:hover {
            transform: translateY(-5px);
        }

        .card-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
        }

        .card-icon i {
            font-size: 2rem;
            color: white;
        }

        .card-title {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 15px;
            color: var(--dark-color);
        }

        /* ======================================== */
        /* VALUES SECTION */
        /* ======================================== */
        .values-section {
            padding: 80px 0;
            background: linear-gradient(135deg, var(--secondary-color) 0%, white 100%);
        }

        .value-item {
            text-align: center;
            padding: 20px;
        }

        .value-icon {
            width: 70px;
            height: 70px;
            background: rgba(78, 115, 223, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
            transition: all 0.3s ease;
        }

        .value-item:hover .value-icon {
            background: var(--primary-color);
            transform: scale(1.1);
        }

        .value-item:hover .value-icon i {
            color: white;
        }

        .value-icon i {
            font-size: 1.8rem;
            color: var(--primary-color);
        }

        /* ======================================== */
        /* TEAM SECTION */
        /* ======================================== */
        .team-section {
            padding: 80px 0;
            background: white;
        }

        .team-card {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: var(--shadow-md);
            transition: all 0.3s ease;
        }

        .team-card:hover {
            transform: translateY(-10px);
            box-shadow: var(--shadow-xl);
        }

        .team-photo {
            height: 280px;
            background-size: cover;
            background-position: center;
            position: relative;
        }

        .team-social {
            position: absolute;
            bottom: -50px;
            left: 0;
            right: 0;
            text-align: center;
            transition: all 0.3s ease;
        }

        .team-card:hover .team-social {
            bottom: 15px;
        }

        .team-social a {
            width: 35px;
            height: 35px;
            background: var(--primary-color);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            margin: 0 5px;
            color: white;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .team-social a:hover {
            transform: scale(1.1);
            background: var(--primary-dark);
        }

        .team-info {
            padding: 20px;
            text-align: center;
        }

        .team-name {
            font-size: 1.2rem;
            font-weight: 700;
            margin-bottom: 5px;
            color: var(--dark-color);
        }

        .team-position {
            color: var(--primary-color);
            font-size: 0.9rem;
            font-weight: 500;
        }

        /* ======================================== */
        /* CONTACT SECTION */
        /* ======================================== */
        .contact-section {
            padding: 80px 0;
            background: linear-gradient(135deg, var(--dark-color) 0%, #1a202c 100%);
            color: white;
        }

        .contact-card {
            background: rgba(255,255,255,0.1);
            border-radius: 20px;
            padding: 30px;
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
        }

        .contact-card:hover {
            transform: translateY(-5px);
            background: rgba(255,255,255,0.15);
        }

        .contact-icon {
            width: 60px;
            height: 60px;
            background: rgba(255,255,255,0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
        }

        .contact-icon i {
            font-size: 1.5rem;
            color: white;
        }

        /* ======================================== */
        /* FOOTER */
        /* ======================================== */
        .footer {
            background: var(--black);
            color: #a0aec0;
            padding: 30px 0;
            text-align: center;
        }

        /* ======================================== */
        /* RESPONSIVE */
        /* ======================================== */
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2rem;
            }

            .hero-subtitle {
                font-size: 1rem;
            }

            .section-title {
                font-size: 1.8rem;
            }

            .btn {
                padding: 8px 20px;
                font-size: 0.9rem;
            }

            .hero-buttons .btn {
                margin: 5px;
            }
        }

        /* Scroll reveal */
        .scroll-reveal {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.8s ease;
        }

        .scroll-reveal.revealed {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
</head>

<body>
    <!-- Hero Section -->
    <div class="hero-section">
        <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 20px;">
            <div class="hero-content fade-in-up">
                <h1 class="hero-title"><?php echo e($conf->nome_Empresa ?? 'Excelência em Educação'); ?></h1>
                <p class="hero-subtitle"><?php echo e($conf->TIpoSistema ?? 'Formando líderes para o futuro'); ?></p>
                <div class="hero-buttons">
                    <a href="<?php echo e(route('login')); ?>" class="btn btn-primary">
                        <i class="fas fa-sign-in-alt"></i> Acessar o Sistema
                    </a>
                    <a href="#contact" class="btn btn-outline">
                        <i class="fas fa-envelope"></i> Contacte-nos
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 20px;">
        <!-- Logo Section -->
        <div class="logo-section fade-in-up">
            <div class="logo-wrapper">
                <img src="<?php echo e(asset('storage/'.$subdomain.'/logoMarca/'.$conf->avatar)); ?>" alt="<?php echo e($conf->nome_Empresa); ?>" class="logo-image">
                <h3 class="institution-name"><?php echo e($conf->nome_Empresa); ?></h3>
                <p class="institution-type"><?php echo e($conf->TIpoSistema); ?></p>
            </div>
        </div>
    </div>

    <!-- Stats Section -->
    <div class="stats-section">
        <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 20px;">
            <div class="row" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 30px;">
                <div class="stat-card scroll-reveal">
                    <div class="stat-number">15+</div>
                    <div class="stat-label">Anos de Experiência</div>
                </div>
                <div class="stat-card scroll-reveal">
                    <div class="stat-number">5000+</div>
                    <div class="stat-label">Alunos Formados</div>
                </div>
                <div class="stat-card scroll-reveal">
                    <div class="stat-number">100+</div>
                    <div class="stat-label">Professores Qualificados</div>
                </div>
                <div class="stat-card scroll-reveal">
                    <div class="stat-number">20+</div>
                    <div class="stat-label">Prémios de Excelência</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Mission & Vision Section -->
    <div class="mission-vision-section">
        <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 20px;">
            <div class="section-header">
                <h2 class="section-title">Nossa Identidade</h2>
                <div class="section-divider"></div>
            </div>
            <div class="row" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 30px;">
                <div class="mission-card scroll-reveal">
                    <div class="card-icon">
                        <i class="fas fa-bullseye"></i>
                    </div>
                    <h3 class="card-title">Missão</h3>
                    <p>Proporcionar educação de excelência, formando cidadãos críticos, criativos e éticos, capazes de transformar a sociedade através do conhecimento e dos valores humanos.</p>
                </div>
                <div class="vision-card scroll-reveal">
                    <div class="card-icon">
                        <i class="fas fa-eye"></i>
                    </div>
                    <h3 class="card-title">Visão</h3>
                    <p>Ser reconhecida como instituição referência em educação, inovação e formação integral, contribuindo para o desenvolvimento sustentável da comunidade e do país.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Values Section -->
    <div class="values-section">
        <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 20px;">
            <div class="section-header">
                <h2 class="section-title">Nossos Valores</h2>
                <div class="section-divider"></div>
            </div>
            <div class="row" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 30px;">
                <div class="value-item scroll-reveal">
                    <div class="value-icon">
                        <i class="fas fa-hand-sparkles"></i>
                    </div>
                    <h4>Ética</h4>
                </div>
                <div class="value-item scroll-reveal">
                    <div class="value-icon">
                        <i class="fas fa-star-of-life"></i>
                    </div>
                    <h4>Excelência</h4>
                </div>
                <div class="value-item scroll-reveal">
                    <div class="value-icon">
                        <i class="fas fa-handshake"></i>
                    </div>
                    <h4>Respeito</h4>
                </div>
                <div class="value-item scroll-reveal">
                    <div class="value-icon">
                        <i class="fas fa-lightbulb"></i>
                    </div>
                    <h4>Inovação</h4>
                </div>
                <div class="value-item scroll-reveal">
                    <div class="value-icon">
                        <i class="fas fa-user-friends"></i>
                    </div>
                    <h4>Inclusão</h4>
                </div>
                <div class="value-item scroll-reveal">
                    <div class="value-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h4>Compromisso</h4>
                </div>
            </div>
        </div>
    </div>

    <!-- Team Section -->
    <div class="team-section">
        <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 20px;">
            <div class="section-header">
                <h2 class="section-title">Corpo Docente</h2>
                <div class="section-divider"></div>
            </div>
            <div class="row" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 30px;">
                <div class="team-card scroll-reveal">
                    <div class="team-photo" style="background-image: url('https://images.unsplash.com/photo-1573497019940-1c28c88b4f3e?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80');">
                        <div class="team-social">
                            <a href="#"><i class="fab fa-linkedin-in"></i></a>
                            <a href="#"><i class="fab fa-twitter"></i></a>
                            <a href="#"><i class="fas fa-envelope"></i></a>
                        </div>
                    </div>
                    <div class="team-info">
                        <h3 class="team-name">Dra. Maria Silva</h3>
                        <p class="team-position">Diretora Pedagógica</p>
                        <p class="team-bio">Doutora em Educação com 20 anos de experiência</p>
                    </div>
                </div>
                <div class="team-card scroll-reveal">
                    <div class="team-photo" style="background-image: url('https://images.unsplash.com/photo-1560250097-0b93528c311a?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80');">
                        <div class="team-social">
                            <a href="#"><i class="fab fa-linkedin-in"></i></a>
                            <a href="#"><i class="fab fa-twitter"></i></a>
                            <a href="#"><i class="fas fa-envelope"></i></a>
                        </div>
                    </div>
                    <div class="team-info">
                        <h3 class="team-name">Prof. João Santos</h3>
                        <p class="team-position">Coordenador Acadêmico</p>
                        <p class="team-bio">Mestre em Matemática e metodologias ativas</p>
                    </div>
                </div>
                <div class="team-card scroll-reveal">
                    <div class="team-photo" style="background-image: url('https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80');">
                        <div class="team-social">
                            <a href="#"><i class="fab fa-linkedin-in"></i></a>
                            <a href="#"><i class="fab fa-twitter"></i></a>
                            <a href="#"><i class="fas fa-envelope"></i></a>
                        </div>
                    </div>
                    <div class="team-info">
                        <h3 class="team-name">Profa. Ana Oliveira</h3>
                        <p class="team-position">Coord. Tecnologia Educacional</p>
                        <p class="team-bio">Especialista em Educação Digital</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Contact Section -->
    <div class="contact-section" id="contact">
        <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 20px;">
            <div class="section-header">
                <h2 class="section-title" style="color: white;">Contactos</h2>
                <div class="section-divider"></div>
            </div>
            <div class="row" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 30px;">
                <div class="contact-card scroll-reveal">
                    <div class="contact-icon">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <h4>Endereço</h4>
                    <p><?php echo e($conf->Localizacao); ?></p>
                </div>
                <div class="contact-card scroll-reveal">
                    <div class="contact-icon">
                        <i class="fas fa-phone-alt"></i>
                    </div>
                    <h4>Telefone</h4>
                    <p><?php echo e($conf->Contacto); ?></p>
                    <?php if($conf->Contacto2): ?>
                        <p><?php echo e($conf->Contacto2); ?></p>
                    <?php endif; ?>
                </div>
                <div class="contact-card scroll-reveal">
                    <div class="contact-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <h4>Email</h4>
                    <p><?php echo e($conf->Email); ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 20px;">
            <p>&copy; <?php echo e(date('Y')); ?> <?php echo e($conf->nome_Empresa); ?>. Todos os direitos reservados.</p>
            <p style="margin-top: 10px; font-size: 0.8rem;">Desenvolvido com <i class="fas fa-heart" style="color: #e74c3c;"></i> para a excelência educacional</p>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        // Scroll reveal
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('revealed');
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);

        document.querySelectorAll('.scroll-reveal').forEach(el => {
            observer.observe(el);
        });
    </script>
</body>

</html>
<?php /**PATH /home/sgemozco/escolasaojoaopauloii.sgemoz.com/resources/views/welcome.blade.php ENDPATH**/ ?>