<!DOCTYPE html>
<?php
    $dados = session()->get('nomeEm');
    $avatar = session()->get('infosession')->avatar ?? 'default.png';
    $host = request()->getHost();
    $subdomain = explode('.', $host)[0];
    $menuCollapsed = session('menu_collapsed', false);
?>

<html lang="pt">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>Sistema de Gestão Escolar | <?php echo $__env->yieldContent('title'); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Favicon -->
    <link rel="icon" href="<?php echo e(asset('storage/'.$subdomain.'/logoMarca/' . $avatar)); ?>" type="image/png" sizes="32x32">

    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="<?php echo e(asset('Admin-LTE/plugins/font-awesome/css/font-awesome.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('Admin-LTE/dist/css/adminlte.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('Admin-LTE/plugins/iCheck/all.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('Admin-LTE/plugins/morris/morris.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('Admin-LTE/plugins/jvectormap/jquery-jvectormap-1.2.2.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('Admin-LTE/plugins/datepicker/datepicker3.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('Admin-LTE/plugins/colorpicker/bootstrap-colorpicker.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('Admin-LTE/plugins/daterangepicker/daterangepicker-bs3.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('Admin-LTE/plugins/select2/select2.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('Admin-LTE/plugins/datatables/jquery.dataTables.min.css')); ?>">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.dataTables.min.css">

    <?php echo $__env->yieldPushContent('style'); ?>

    <style>
        /* ======================================== */
        /* ESTILOS MODERNOS DO LAYOUT */
        /* ======================================== */

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            /* font-family: 'Inter', 'Arial', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #f8f9fc 100%);
            overflow-x: hidden; */
               font-family: Arial, Helvetica, sans-serif;
            font-size: 14px;
        }




        /* Sidebar Moderno */
        .main-sidebar {
            background: linear-gradient(180deg, #1a1c23 0%, #1f2937 100%);
            box-shadow: 4px 0 20px rgba(0, 0, 0, 0.1);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Brand Link */
        .brand-link {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-bottom: none;
            padding: 15px 20px;
            transition: all 0.3s ease;
        }

        .brand-link:hover {
            background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
        }

        .brand-image {
            transition: all 0.3s ease;
        }

        .brand-link:hover .brand-image {
            transform: rotate(5deg) scale(1.05);
        }

        .brand-text {
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        /* Navbar Moderna */
        .main-header {
            background: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .nav-link {
            transition: all 0.2s ease;
        }

        .nav-link:hover {
            transform: translateY(-2px);
        }

        /* Botão de toggle do menu */
        .nav-item .nav-link[data-widget="pushmenu"] {
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .nav-item .nav-link[data-widget="pushmenu"]:hover {
            background: rgba(102, 126, 234, 0.1);
            transform: scale(1.05);
        }

        .nav-item .nav-link[data-widget="pushmenu"] i {
            transition: all 0.3s ease;
        }

        .nav-item .nav-link[data-widget="pushmenu"]:hover i {
            transform: rotate(90deg);
            color: #667eea;
        }

        /* Efeito ripple no botão */
        .ripple-effect {
            position: relative;
            overflow: hidden;
        }

        .ripple-effect:after {
            content: "";
            display: block;
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            pointer-events: none;
            background-image: radial-gradient(circle, #667eea 10%, transparent 10.01%);
            background-repeat: no-repeat;
            background-position: 50%;
            transform: scale(10, 10);
            opacity: 0;
            transition: transform .5s, opacity 1s;
        }

        .ripple-effect:active:after {
            transform: scale(0, 0);
            opacity: .3;
            transition: 0s;
        }

        /* Content Wrapper */
        .content-wrapper {
            background: #f8f9fc;
            min-height: calc(100vh - 56px);
        }

        /* Footer */
        .main-footer {
            background: white;
            border-top: 1px solid rgba(0, 0, 0, 0.05);
            padding: 15px 20px;
            font-size: 0.85rem;
            color: #6c757d;
        }

        /* Animações */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .content-wrapper {
            animation: fadeIn 0.4s ease-out;
        }

        /* Sidebar Collapse Transition */
        .main-sidebar,
        .content-wrapper,
        .main-header {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Scrollbar Customizada */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .brand-text {
                display: none;
            }

            .main-footer {
                font-size: 0.7rem;
                text-align: center;
            }

            .main-footer .float-right {
                float: none !important;
                display: block;
                margin-top: 5px;
            }
        }

        /* Loading Overlay */
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 9999;
            display: none;
            align-items: center;
            justify-content: center;
        }

        .loading-overlay.active {
            display: flex;
        }

        .spinner {
            width: 50px;
            height: 50px;
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: #667eea;
            animation: spin 0.8s ease-in-out infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* Tooltip moderno */
        [data-tooltip] {
            position: relative;
        }

        [data-tooltip]:before {
            content: attr(data-tooltip);
            position: absolute;
            bottom: 100%;
            left: 50%;
            transform: translateX(-50%);
            padding: 5px 10px;
            background: #1f2937;
            color: white;
            font-size: 0.75rem;
            border-radius: 6px;
            white-space: nowrap;
            opacity: 0;
            pointer-events: none;
            transition: all 0.3s ease;
            z-index: 1000;
        }

        [data-tooltip]:hover:before {
            opacity: 1;
            transform: translateX(-50%) translateY(-5px);
        }


        .card {
        border: none;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.08);
        border-radius: 0.75rem;
        transition: box-shadow 0.2s;
    }
    .card:hover {
        box-shadow: 0 1rem 2rem rgba(0, 0, 0, 0.12);
    }
    .card-header {
        background-color: transparent;
        border-bottom: 1px solid rgba(0,0,0,0.05);
        font-weight: 600;
        padding: 1.25rem 1.5rem;
    }
    .card-body {
        padding: 1.5rem;
    }
    .btn-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }
    .table th {
        border-top: none;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        color: #6c757d;
    }
    .table td {
        vertical-align: middle;
    }
    .table tbody tr:hover {
        background-color: #f8f9fc;
    }
    .action-btns .btn {
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
        border-radius: 0.5rem;
        margin: 0 2px;
    }
    .alert-custom {
        border-radius: 0.75rem;
        border-left: 4px solid;
        padding: 1rem 1.5rem;
    }
    .alert-success-custom {
        background-color: #e6f7e6;
        border-left-color: #28a745;
        color: #1e7e34;
    }
    .select2-container--bootstrap4 .select2-selection--single {
        height: calc(1.5em + 0.75rem + 2px) !important;
        padding: 0.375rem 0.75rem;
    }
    .select2-container--bootstrap4 .select2-selection__rendered {
        line-height: 1.5 !important;
    }
    .select2-container--bootstrap4 .select2-selection__arrow {
        height: calc(1.5em + 0.75rem) !important;
    }
    .form-group {
        margin-bottom: 1.5rem;
    }
    .section-title {
        font-size: 1.25rem;
        font-weight: 600;
        margin-bottom: 1.5rem;
        color: #2c3e50;
        display: flex;
        align-items: center;
    }
    .section-title i {
        margin-right: 0.75rem;
        color: #4e73df;
    }

    /* Breadcrumb Moderno */
    .breadcrumb-modern {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 12px 20px;
        border-radius: 12px;
        margin-bottom: 20px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }

    .breadcrumb-modern .breadcrumb-item {
        color: rgba(255,255,255,0.9);
    }

    .breadcrumb-modern .breadcrumb-item a {
        color: white;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .breadcrumb-modern .breadcrumb-item a:hover {
        color: #ffd700;
        transform: translateX(3px);
        display: inline-block;
    }

    .breadcrumb-modern .breadcrumb-item.active {
        color: #ffd700;
        font-weight: bold;
    }

    </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed <?php echo e($menuCollapsed ? 'sidebar-collapse' : ''); ?>">
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link ripple-effect" data-widget="pushmenu" href="#" id="toggleMenuBtn" data-tooltip="Expandir/Recolher Menu">
                        <i class="fas fa-bars"></i>
                    </a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="/home" class="nav-link">
                        <i class="fas fa-home"></i> Home
                    </a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="#" class="nav-link">
                        <i class="fas fa-question-circle"></i> Ajuda
                    </a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Notifications Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="far fa-bell"></i>
                        <span class="badge badge-warning navbar-badge">3</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <span class="dropdown-item dropdown-header">3 Notificações</span>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-envelope mr-2"></i> Nova mensagem
                            <span class="float-right text-muted text-sm">3 min</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item dropdown-footer">Ver todas</a>
                    </div>
                </li>

                <!-- User Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="fas fa-user-circle fa-lg"></i>
                        <span class="d-none d-md-inline ml-1"><?php echo e($dados ?? 'Usuário'); ?></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-user mr-2"></i> Meu Perfil
                        </a>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-cog mr-2"></i> Configurações
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="<?php echo e(route('logout')); ?>" class="dropdown-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt mr-2"></i> Sair
                        </a>
                        <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
                            <?php echo csrf_field(); ?>
                        </form>
                    </div>
                </li>
            </ul>
        </nav>

        <!-- Sidebar -->
        <aside class="main-sidebar elevation-2">
            <a href="/" class="brand-link">
                <img src="<?php echo e(asset('storage/'.$subdomain.'/logoMarca/' . $avatar)); ?>" alt="Logo"
                     class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light"><?php echo e(session()->get('infosession')->TIpoSistema ?? 'Sistema'); ?></span>
            </a>
            <div class="sidebar">
                <?php echo $__env->make('layouts.menum-master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="content-wrapper">
            <?php echo $__env->yieldContent('content'); ?>
        </div>

        <!-- Footer -->
        <footer class="main-footer">
            <div class="float-right d-none d-sm-inline-block">
                <b>Versão</b> 2.0.0
            </div>
            <strong>&copy; <?php echo e(date('Y')); ?> </strong> Todos os Direitos Reservados
            <i class="fas fa-heart text-danger ml-1 mr-1"></i> Sistema de Gestão Escolar
        </footer>
    </div>

    <!-- Loading Overlay -->
    <div class="loading-overlay" id="loadingOverlay">
        <div class="spinner"></div>
    </div>

    <!-- Scripts -->
    <script src="<?php echo e(asset('Admin-LTE/plugins/jquery/jquery.min.js')); ?>"></script>
    <script src="<?php echo e(asset('Admin-LTE/plugins/bootstrap/js/bootstrap.bundle.min.js')); ?>"></script>
    <script src="<?php echo e(asset('Admin-LTE/plugins/slimScroll/jquery.slimscroll.min.js')); ?>"></script>
    <script src="<?php echo e(asset('Admin-LTE/plugins/fastclick/fastclick.js')); ?>"></script>
    <script src="<?php echo e(asset('Admin-LTE/plugins/iCheck/icheck.min.js')); ?>"></script>
    <script src="<?php echo e(asset('Admin-LTE/plugins/morris/morris.min.js')); ?>"></script>
    <script src="<?php echo e(asset('Admin-LTE/plugins/sparkline/jquery.sparkline.min.js')); ?>"></script>
    <script src="<?php echo e(asset('Admin-LTE/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js')); ?>"></script>
    <script src="<?php echo e(asset('Admin-LTE/plugins/jvectormap/jquery-jvectormap-world-mill-en.js')); ?>"></script>
    <script src="<?php echo e(asset('js/chart.min.js')); ?>"></script>
    <script src="<?php echo e(asset('bootstrap-daterangepicker-master/moment.js')); ?>"></script>
    <script src="<?php echo e(asset('bootstrap-daterangepicker-master/daterangepicker.js')); ?>"></script>
    <script src="<?php echo e(asset('Admin-LTE/plugins/datatables/jquery.dataTables.min.js')); ?>"></script>
    <script src="<?php echo e(asset('Datatable/js/dataTables.buttons.min.js')); ?>"></script>
    <script src="<?php echo e(asset('Datatable/js/buttons.flash.min.js')); ?>"></script>
    <script src="<?php echo e(asset('Datatable/js/jszip.min.js')); ?>"></script>
    <script src="<?php echo e(asset('Datatable/js/pdfmake.min.js')); ?>"></script>
    <script src="<?php echo e(asset('Datatable/js/vfs_fonts.js')); ?>"></script>
    <script src="<?php echo e(asset('Datatable/js/buttons.html5.min.js')); ?>"></script>
    <script src="<?php echo e(asset('Datatable/js/buttons.print.min.js')); ?>"></script>
    <script src="<?php echo e(asset('Datatable/js/buttons.colVis.min.js')); ?>"></script>
    <script src="<?php echo e(asset('Admin-LTE/dist/js/adminlte.js')); ?>"></script>
    <script src="<?php echo e(asset('Admin-LTE/dist/js/demo.js')); ?>"></script>
    <script src="<?php echo e(asset('Admin-LTE/plugins/sweetalert2/sweetalert2@11.js')); ?>"></script>

    <script>
        $(document).ready(function() {
            // Inicializar Select2
            $('.select2').select2();

            // Inicializar Datepicker
            $('#datemask').inputmask('dd/mm/yyyy');
            $('#reservation').daterangepicker();

            // Inicializar iCheck
            $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
                checkboxClass: 'icheckbox_minimal-blue',
                radioClass: 'iradio_minimal-blue'
            });

            $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
                checkboxClass: 'icheckbox_flat-green',
                radioClass: 'iradio_flat-green'
            });

            // ========================================
            // PERSISTÊNCIA DO ESTADO DO MENU
            // ========================================

            // Verificar localStorage primeiro
            const localCollapsed = localStorage.getItem('menu_collapsed');
            if (localCollapsed !== null) {
                const isCollapsed = localCollapsed === 'true';
                if (isCollapsed) {
                    $('body').addClass('sidebar-collapse');
                } else {
                    $('body').removeClass('sidebar-collapse');
                }
            }

            // Botão de toggle do menu
            $('#toggleMenuBtn').on('click', function(e) {
                e.preventDefault();

                // Adicionar efeito ripple
                $(this).addClass('ripple-effect');
                setTimeout(() => {
                    $(this).removeClass('ripple-effect');
                }, 500);

                // Alternar a classe no body
                $('body').toggleClass('sidebar-collapse');

                // Determinar novo estado
                const isCollapsed = $('body').hasClass('sidebar-collapse');

                // Salvar no localStorage
                localStorage.setItem('menu_collapsed', isCollapsed);

                // Salvar no session via AJAX
                $.ajax({
                    url: "<?php echo e(route('toggle.menu.state')); ?>",
                    type: 'POST',
                    data: {
                        _token: '<?php echo e(csrf_token()); ?>',
                        collapsed: isCollapsed
                    },
                    success: function(response) {
                        console.log('Estado do menu salvo:', response.collapsed);
                    },
                    error: function(xhr) {
                        console.error('Erro ao salvar estado do menu:', xhr);
                    }
                });
            });

            // Sincronizar estado entre abas/janelas
            window.addEventListener('storage', function(e) {
                if (e.key === 'menu_collapsed') {
                    const isCollapsed = e.newValue === 'true';
                    if (isCollapsed) {
                        $('body').addClass('sidebar-collapse');
                    } else {
                        $('body').removeClass('sidebar-collapse');
                    }
                }
            });

            // Loading overlay para navegação
            $(document).on('click', 'a:not([target="_blank"]):not([href^="#"]):not([href^="javascript"])', function(e) {
                if ($(this).attr('href') && $(this).attr('href') !== '#' && !$(this).hasClass('no-loading')) {
                    $('#loadingOverlay').addClass('active');
                }
            });

            $(window).on('load', function() {
                setTimeout(() => {
                    $('#loadingOverlay').removeClass('active');
                }, 300);
            });
        });

        // File input handler
        document.getElementById('exampleFile')?.addEventListener('change', function(e) {
            const fileNameDisplay = document.getElementById('file-name-display');
            if (this.files.length > 0) {
                fileNameDisplay.textContent = this.files[0].name;
                fileNameDisplay.style.color = '#333';
            } else {
                fileNameDisplay.textContent = 'Nenhum arquivo selecionado';
                fileNameDisplay.style.color = '#555';
            }
        });
    </script>

    <?php echo $__env->yieldPushContent('script'); ?>
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\laragon\www\escola2025\resources\views/layouts/admin-Lti.blade.php ENDPATH**/ ?>