<?php
    $request = request();
    $host = $request->getHost();
    $subdomain = explode('.', $host)[0];
    $pagamentos = $pagamentos ?? [];
    $valortotal = 0;

    // Cálculos comuns
    $idade = \Carbon\Carbon::parse($aluno->dataNascimento)->age;
    $dataNascimentoFormatada = \Carbon\Carbon::parse($aluno->dataNascimento)->format('d/m/Y');
    $statusClass = $aluno->TIPOSAIDAa ? 'status-inativo' : 'status-ativo';
    $statusTexto = $aluno->TIPOSAIDAa ?: 'ATIVO';
    $tipoAluno = $aluno->Tipo == 'B' ? 'Bolseiro' : 'Normal';
    $tipoBadgeClass = $aluno->Tipo == 'B' ? 'bg-warning text-dark' : 'bg-primary';

    // dd($dadosMes);
?>

<!DOCTYPE html>
<html lang="pt" data-bs-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil do Aluno - <?php echo e($aluno->nome); ?></title>
    <meta name="description" content="Perfil completo do aluno <?php echo e($aluno->nome); ?>">

    <!-- CDN com fallback -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?php echo e(asset('perfilView/assets/css/styles.min.css')); ?>">

    <style>

        /* Popup PDF */
.pdf-popup {
  display: none;
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.8);
  z-index: 9999;
  animation: fadeIn 0.3s ease;
}

.pdf-popup-content {
  position: relative;
  margin: 2% auto;
  width: 90%;
  height: 90%;
  background: #fff;
  border-radius: 8px;
  box-shadow: 0 5px 30px rgba(0, 0, 0, 0.3);
  overflow: hidden;
  animation: slideIn 0.3s ease;
}

.pdf-close-btn {
  position: absolute;
  top: 10px;
  right: 10px;
  z-index: 10000;
  background: #dc3545;
  color: #fff;
  border: none;
  padding: 8px 15px;
  border-radius: 4px;
  cursor: pointer;
  font-size: 14px;
  transition: background 0.3s;
}

.pdf-close-btn:hover {
  background: #c82333;
}

.pdf-controls {
  position: absolute;
  top: 10px;
  left: 10px;
  z-index: 10000;
  display: flex;
  gap: 10px;
}

.pdf-control-btn {
  background: #007bff;
  color: #fff;
  border: none;
  padding: 8px 15px;
  border-radius: 4px;
  cursor: pointer;
  font-size: 14px;
  transition: background 0.3s;
}

.pdf-control-btn:hover {
  background: #0056b3;
}

.pdf-container {
  width: 100%;
  height: 100%;
  padding: 60px 20px 20px 20px;
}

#pdfFrame {
  width: 100%;
  height: 100%;
  border: none;
  border-radius: 4px;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

.pdf-loading {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  text-align: center;
  z-index: 100;
}

.pdf-loading p {
  margin-top: 15px;
  color: #666;
  font-size: 16px;
}

@keyframes fadeIn {
  from { opacity: 0; }
  to { opacity: 1; }
}

@keyframes slideIn {
  from { transform: translateY(-30px); opacity: 0; }
  to { transform: translateY(0); opacity: 1; }
}

/* Para impressão do popup */
@media print {
  .pdf-popup {
    position: static;
    background: #fff;
  }

  .pdf-popup-content {
    margin: 0;
    width: 100%;
    height: 100%;
    box-shadow: none;
  }

  .pdf-close-btn,
  .pdf-controls {
    display: none !important;
  }

  .pdf-container {
    padding: 0;
  }

  #pdfFrame {
    box-shadow: none;
  }
}
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --secondary-gradient: linear-gradient(135deg, #4f6df5, #8a2be2);
            --success-gradient: linear-gradient(45deg, #4cd964, #5ac8fa);
            --danger-gradient: linear-gradient(45deg, #ff3b30, #ff9500);
            --card-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            --transition-speed: 0.3s ease;
        }

        /* ===== BASE & TYPOGRAPHY ===== */
        body {
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            padding: 20px 0;
        }

        /* ===== LAYOUT COM FOTO FLUTUANTE ===== */
        .foto-flutuante {
            position: sticky;
            top: 20px;
            z-index: 100;
        }

        .conteudo-principal {
            padding-left: 5px;
        }

        @media (max-width: 992px) {
            .foto-flutuante {
                position: static;
                margin-bottom: 10px;
            }

            .conteudo-principal {
                padding-left: 0;
            }
        }

        /* ===== ESTILOS DA FOTO ===== */
        .avatar-container {
            width: 200px;
            height: 200px;
            margin: 0 auto;
            position: relative;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: var(--card-shadow);
            border: 5px solid white;
            background: var(--primary-gradient);
            transition: transform var(--transition-speed);
        }

        .avatar-container:hover {
            transform: translateY(-5px);
        }

        .avatar-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform var(--transition-speed);
        }

        .avatar-container:hover .avatar-img {
            transform: scale(1.05);
        }

        .avatar-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: rgba(0, 0, 0, 0.85);
            color: white;
            padding: 15px;
            text-align: center;
            transform: translateY(100%);
            transition: transform var(--transition-speed);
            backdrop-filter: blur(5px);
        }

        .avatar-container:hover .avatar-overlay {
            transform: translateY(0);
        }

        .avatar-id {
            font-size: 0.85rem;
            opacity: 0.9;
            font-weight: 300;
        }

        /* ===== STATUS DO ALUNO ===== */
        .status-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            padding: 8px 15px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 1px;
            z-index: 10;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            border: 2px solid white;
        }

        .status-ativo {
            background: var(--success-gradient);
            color: white;
        }

        .status-inativo {
            background: var(--danger-gradient);
            color: white;
        }

        /* ===== ABAS ESTILIZADAS ===== */
        .nav-tabs {
            border-bottom: 2px solid #dee2e6;
            gap: 5px;
        }

        .nav-tabs .nav-link {
            color: #6c757d;
            font-weight: 500;
            border: none;
            padding: 12px 24px;
            border-radius: 10px 10px 0 0;
            transition: all var(--transition-speed);
            position: relative;
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
        }

        .nav-tabs .nav-link:hover {
            color: #495057;
            background: rgba(248, 249, 250, 0.9);
            transform: translateY(-2px);
        }

        .nav-tabs .nav-link.active {
            color: #0d6efd;
            background: white;
            font-weight: 600;
            box-shadow: 0 -4px 10px rgba(13, 110, 253, 0.1);
        }

        .nav-tabs .nav-link.active::before {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 100%;
            height: 3px;
            background: var(--secondary-gradient);
            border-radius: 2px 2px 0 0;
        }

        /* ===== CONTEÚDO DAS ABAS ===== */
        .tab-content {
            background: white;
            border-radius: 0 0 15px 15px;
            box-shadow: 0 5px 25px rgba(0, 0, 0, 0.08);
            padding: 30px;
            min-height: 400px;
            backdrop-filter: blur(10px);
        }

        .info-card {
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
            border: none;
            border-radius: 15px;
            margin-bottom: 25px;
            transition: all var(--transition-speed);
            overflow: hidden;
            height: 100%;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .info-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        }

        .info-card .card-header {
            background: var(--secondary-gradient);
            color: white;
            border: none;
            font-weight: 600;
            padding: 18px 25px;
            border-radius: 15px 15px 0 0 !important;
            font-size: 1rem;
        }

        .info-card .card-body {
            padding: 25px;
        }

        .info-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 14px 0;
            border-bottom: 1px dashed #e9ecef;
            transition: background-color 0.2s;
        }

        .info-item:hover {
            background-color: rgba(0, 0, 0, 0.02);
            border-radius: 8px;
            padding-left: 10px;
            padding-right: 10px;
        }

        .info-item:last-child {
            border-bottom: none;
        }

        .info-label {
            color: #495057;
            font-weight: 500;
            display: flex;
            align-items: center;
            font-size: 0.9rem;
        }

        .info-label i {
            margin-right: 12px;
            color: #4f6df5;
            width: 20px;
            text-align: center;
        }

        .info-value {
            color: #212529;
            font-weight: 600;
            text-align: right;
            font-size: 0.95rem;
            max-width: 60%;
            word-break: break-word;
        }

        /* ===== BADGES ===== */
        .badge-status {
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
            letter-spacing: 0.5px;
        }

        .badge-pago {
            background: var(--success-gradient);
            color: white;
        }

        .badge-pendente {
            background: var(--danger-gradient);
            color: white;
        }

        /* ===== TABELA DE PAGAMENTOS ===== */
        .table-pagamentos {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
            border: 1px solid #dee2e6;
        }

        .table-pagamentos thead {
            background: var(--secondary-gradient);
            color: white;
            font-weight: 500;
        }

        .table-pagamentos th {
            padding: 18px 20px;
            font-size: 0.95rem;
            border: none;
        }

        .table-pagamentos tbody tr {
            transition: all var(--transition-speed);
            border-bottom: 1px solid #f1f3f4;
        }

        .table-pagamentos tbody tr:hover {
            background: linear-gradient(90deg, rgba(79, 109, 245, 0.05), rgba(138, 43, 226, 0.05));
            transform: translateX(8px);
        }

        .table-pagamentos td {
            padding: 16px 20px;
            vertical-align: middle;
        }

        /* ===== BOTÕES DE AÇÃO ===== */
        .action-buttons {
            margin-top: 50px;
            padding-top: 25px;
            border-top: 2px solid #e9ecef;
        }

        .btn-action {
            padding: 14px 35px;
            border-radius: 50px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all var(--transition-speed);
            border: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            min-width: 200px;
            font-size: 0.9rem;
            position: relative;
            overflow: hidden;
        }

        .btn-action::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }

        .btn-action:hover::after {
            width: 300px;
            height: 300px;
        }

        .btn-print {
            background: var(--secondary-gradient);
            color: white;
            box-shadow: 0 8px 25px rgba(74, 108, 245, 0.3);
        }

        .btn-print:hover {
            transform: translateY(-3px) scale(1.05);
            box-shadow: 0 12px 30px rgba(74, 108, 245, 0.4);
        }

        .btn-data {
            background: linear-gradient(45deg, #36d1dc, #5b86e5);
            color: white;
            box-shadow: 0 8px 25px rgba(54, 209, 220, 0.3);
        }

        .btn-data:hover {
            transform: translateY(-3px) scale(1.05);
            box-shadow: 0 12px 30px rgba(54, 209, 220, 0.4);
        }

        /* ===== MODAIS ===== */
        .print-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.95);
            z-index: 9999;
            justify-content: center;
            align-items: center;
            padding: 20px;
            backdrop-filter: blur(5px);
        }

        .print-content {
            width: 95%;
            max-width: 900px;
            height: 90vh;
            background: white;
            border-radius: 20px;
            overflow: hidden;
            position: relative;
            animation: modalSlideIn 0.4s ease-out;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        }

        @keyframes modalSlideIn {
            from {
                opacity: 0;
                transform: translateY(-50px) scale(0.9);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .print-iframe {
            width: 100%;
            height: 100%;
            border: none;
        }

        .print-controls {
            position: absolute;
            top: 20px;
            right: 20px;
            display: flex;
            gap: 10px;
            z-index: 10000;
        }

        .print-btn {
            background: white;
            border: none;
            width: 45px;
            height: 45px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            transition: all var(--transition-speed);
            font-size: 1.1rem;
            color: #333;
        }

        .print-btn:hover {
            transform: scale(1.15) rotate(90deg);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
        }

        /* ===== LOADING ===== */
        .print-loading {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.9);
            z-index: 10001;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            backdrop-filter: blur(10px);
        }

        .loading-spinner {
            width: 70px;
            height: 70px;
            border: 5px solid rgba(255, 255, 255, 0.1);
            border-top: 5px solid #4f6df5;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin-bottom: 20px;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* ===== ANIMAÇÕES ===== */
        .fade-in {
            animation: fadeIn 0.6s ease-out forwards;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(30px) scale(0.95);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        /* ===== RESPONSIVIDADE ===== */
        @media (max-width: 768px) {
            .nav-tabs .nav-link {
                padding: 10px 15px;
                font-size: 0.85rem;
            }

            .tab-content {
                padding: 20px;
            }

            .info-card .card-body {
                padding: 15px;
            }

            .action-buttons {
                display: flex;
                flex-direction: column;
                gap: 15px;
            }

            .btn-action {
                min-width: 100%;
                width: 100%;
            }

            .avatar-container {
                width: 150px;
                height: 150px;
            }
        }

        @media (max-width: 576px) {
            .nav-tabs {
                flex-wrap: nowrap;
                overflow-x: auto;
                padding-bottom: 5px;
            }

            .nav-tabs .nav-link {
                white-space: nowrap;
            }

            .table-responsive {
                font-size: 0.85rem;
            }
        }

        /* ===== UTILIDADES ===== */
        .text-truncate-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .cursor-pointer {
            cursor: pointer;
        }

        .hover-lift {
            transition: transform var(--transition-speed);
        }

        .hover-lift:hover {
            transform: translateY(-3px);
        }

        /* ===== DARK MODE SUPPORT ===== */
        @media (prefers-color-scheme: dark) {
            [data-bs-theme="dark"] {
                background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
            }

            [data-bs-theme="dark"] .tab-content,
            [data-bs-theme="dark"] .info-card {
                background: #2d3748;
                color: #e2e8f0;
            }

            [data-bs-theme="dark"] .info-item {
                border-color: #4a5568;
            }

            [data-bs-theme="dark"] .info-label {
                color: #cbd5e0;
            }

            [data-bs-theme="dark"] .info-value {
                color: #f7fafc;
            }
        }
    </style>
</head>

<body>
    <div class="container-fluid ">
        <div class="row">
            <!-- COLUNA DA FOTO FLUTUANTE -->
            <div class="col-lg-4 col-xl-4 foto-flutuante">
                <div class="card border-0 shadow-lg fade-in">
                    <div class="card-body text-center">
                        <!-- CONTAINER DA FOTO -->
                        <div class="avatar-container mb-2">
                            <?php if(isset($aluno->avatar)): ?>
                                <img src="/storage/<?php echo e($subdomain); ?>/fotoAluno/<?php echo e($aluno->avatar); ?>"
                                     class="avatar-img"
                                     alt="Foto do Aluno <?php echo e($aluno->nome); ?>"
                                     loading="lazy">
                            <?php else: ?>
                                <img src="/storage/fotoAluno/avatar.png"
                                     class="avatar-img"
                                     alt="Avatar Padrão"
                                     loading="lazy">
                            <?php endif; ?>

                            <!-- BADGE DE STATUS -->
                            <span class="status-badge <?php echo e($statusClass); ?>">
                                <?php echo e($statusTexto); ?>

                            </span>

                            <!-- OVERLAY COM INFORMAÇÕES -->
                            <div class="avatar-overlay">
                                <h6 class="mb-1 text-truncate"><?php echo e($aluno->nome); ?></h6>
                                <div class="avatar-id">ID: <?php echo e($aluno->id); ?></div>
                                <small class="d-block mt-1 opacity-75"><?php echo e($aluno->classe); ?></small>
                            </div>
                        </div>

                        <!-- BOTÕES RÁPIDOS -->

                        <div class="d-grid gap-2 mt-4">

                            <button class="btn btn-outline-primary btn-sm Recibo-print hover-lift"
                                    data-aluno-id="<?php echo e($aluno->id); ?>"
                                    data-classe="<?php echo e($ano); ?>">
                                <i class="fas fa-print me-2"></i>Recibo
                            </button>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("Imprimir-Processo")): ?>


                            <button class="btn btn-outline-secondary btn-sm dados-print hover-lift"
                                    data-aluno-id="<?php echo e($aluno->id); ?>">
                                <i class="fas fa-file-alt me-2"></i>Ficha Completa
                            </button>

                            <?php endif; ?>



                        </div>
                    </div>
                </div>
            </div>

            <!-- COLUNA DO CONTEÚDO PRINCIPAL -->
            <div class="col conteudo-principal">
                <!-- CABEÇALHO DO PERFIL -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h1 class="h3 mb-1"><?php echo e($aluno->nome); ?></h1>
                        <p class="text-muted mb-0">
                            <i class="fas fa-graduation-cap me-1"></i>
                            <?php echo e($aluno->classe); ?> • <?php echo e($tipoAluno); ?>

                        </p>
                    </div>
                    <div class="d-flex gap-2">
                        <span class="badge <?php echo e($tipoBadgeClass); ?> px-3 py-2">
                            <?php echo e($tipoAluno); ?>

                        </span>
                    </div>
                </div>

                <!-- ABAS DE NAVEGAÇÃO -->
                <ul class="nav nav-tabs" id="alunoTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="dados-tab" data-bs-toggle="tab" data-bs-target="#dados"
                            type="button" role="tab">
                            <i class="fas fa-user-graduate me-2"></i>Dados do Aluno
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="filiacao-tab" data-bs-toggle="tab" data-bs-target="#filiacao"
                            type="button" role="tab">
                            <i class="fas fa-users me-2"></i>Filiação & Encarregado
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pagamentos-tab" data-bs-toggle="tab" data-bs-target="#pagamentos"
                            type="button" role="tab">
                            <i class="fas fa-credit-card me-2"></i>Pagamentos
                            <?php if(count($pagamentos) > 0): ?>
                                <span class="badge bg-info ms-2"><?php echo e(count($dadosmatricula)); ?></span>
                            <?php endif; ?>
                        </button>
                    </li>
                </ul>

                <!-- CONTEÚDO DAS ABAS -->
                <div class="tab-content mt-3" id="alunoTabContent">
                    <!-- DADOS DO ALUNO -->
                    <div class="tab-pane fade show active" id="dados" role="tabpanel">
                        <div class="row g-4">
                            <div class="col-md-6 col-lg-6">
                                <div class="info-card h-100">
                                    <div class="card-header">
                                        <i class="fas fa-user-circle me-2"></i>Informações Pessoais
                                    </div>
                                    <div class="card-body">
                                        <div class="info-item">
                                            <div class="info-label">
                                                <i class="fas fa-user"></i> Nome Completo
                                            </div>
                                            <div class="info-value"><?php echo e($aluno->nome); ?></div>
                                        </div>
                                        <div class="info-item">
                                            <div class="info-label">
                                                <i class="fas fa-venus-mars"></i> Sexo
                                            </div>
                                            <div class="info-value"><?php echo e($aluno->sexo); ?></div>
                                        </div>
                                        <div class="info-item">
                                            <div class="info-label">
                                                <i class="fas fa-birthday-cake"></i> Data Nascimento
                                            </div>
                                            <div class="info-value"><?php echo e($dataNascimentoFormatada); ?></div>
                                        </div>
                                        <div class="info-item">
                                            <div class="info-label">
                                                <i class="fas fa-calendar-alt"></i> Idade
                                            </div>
                                            <div class="info-value"><?php echo e($idade); ?> anos</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col">
                                <div class="info-card h-100">
                                    <div class="card-header">
                                        <i class="fas fa-graduation-cap me-2"></i>Informações Académicas
                                    </div>
                                    <div class="card-body">
                                        <div class="info-item">
                                            <div class="info-label">
                                                <i class="fas fa-tag"></i> Tipo
                                            </div>
                                            <div class="info-value">
                                                <span class="badge <?php echo e($tipoBadgeClass); ?>">
                                                    <?php echo e($tipoAluno); ?>

                                                </span>
                                            </div>
                                        </div>
                                        <div class="info-item">
                                            <div class="info-label">
                                                <i class="fas fa-school"></i> Classe
                                            </div>
                                            <div class="info-value"><?php echo e($aluno->classe); ?></div>
                                        </div>
                                        <div class="info-item">
                                            <div class="info-label">
                                                <i class="fas fa-info-circle"></i> Estado
                                            </div>
                                            <div class="info-value"><?php echo e($statusTexto); ?></div>
                                        </div>
                                        <?php if(isset($aluno->anolectivo)): ?>
                                            <div class="info-item">
                                                <div class="info-label">
                                                    <i class="fas fa-calendar-alt"></i> Ano Lectivo
                                                </div>
                                                <div class="info-value"><?php echo e($aluno->anolectivo); ?></div>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>

                            <div class="col">
                                <div class="info-card h-100">
                                    <div class="card-header">
                                        <i class="fas fa-map-marked-alt me-2"></i>Endereço
                                    </div>
                                    <div class="card-body">
                                        <div class="info-item">
                                            <div class="info-label">
                                                <i class="fas fa-map-marker-alt"></i> Bairro
                                            </div>
                                            <div class="info-value"><?php echo e($aluno->Endereco ?? 'Não informado'); ?></div>
                                        </div>
                                        <div class="info-item">
                                            <div class="info-label">
                                                <i class="fas fa-road"></i> Rua/Avenida
                                            </div>
                                            <div class="info-value"><?php echo e($aluno->RuaAvenida ?? 'Não informado'); ?></div>
                                        </div>
                                        <div class="info-item">
                                            <div class="info-label">
                                                <i class="fas fa-home"></i> Casa
                                            </div>
                                            <div class="info-value"><?php echo e($aluno->Casa ?? 'Não informado'); ?></div>
                                        </div>
                                        <div class="info-item">
                                            <div class="info-label">
                                                <i class="fas fa-th-large"></i> Quarteirão
                                            </div>
                                            <div class="info-value"><?php echo e($aluno->Quarterao ?? 'Não informado'); ?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- FILIAÇÃO E ENCARREGADO -->
                    <div class="tab-pane fade" id="filiacao" role="tabpanel">
                        <div class="row g-4">
                            <!-- Encarregado de Educação -->
                            <div class="col-md-6 ">
                                <div class="info-card h-100">
                                    <div class="card-header">
                                        <i class="fas fa-user-tie me-2"></i> Encarregado de Educação
                                    </div>
                                    <div class="card-body">
                                        <div class="info-item">
                                            <div class="info-label">
                                                <i class="fas fa-user me-2"></i>Nome
                                            </div>
                                            <div class="info-value"><?php echo e($aluno->Encaregado ?? 'Não informado'); ?></div>
                                        </div>
                                        <div class="info-item">
                                            <div class="info-label">
                                                <i class="fas fa-handshake me-2"></i>Parentesco
                                            </div>
                                            <div class="info-value"><?php echo e($aluno->GrauParentesco ?? 'Não informado'); ?></div>
                                        </div>
                                        <div class="info-item">
                                            <div class="info-label">
                                                <i class="fas fa-briefcase me-2"></i>Profissão
                                            </div>
                                            <div class="info-value"><?php echo e($aluno->profissaoEncaregado ?? 'Não informado'); ?></div>
                                        </div>
                                        <div class="info-item">
                                            <div class="info-label">
                                                <i class="fas fa-pray me-2"></i>Religião
                                            </div>
                                            <div class="info-value"><?php echo e($aluno->Religiao_Encaregado ?? 'Não informado'); ?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Pai do Educando -->
                            <div class="col">
                                <div class="info-card h-100">
                                    <div class="card-header">
                                        <i class="fas fa-male me-2"></i> Pai do Educando
                                    </div>
                                    <div class="card-body">
                                        <div class="info-item">
                                            <div class="info-label">
                                                <i class="fas fa-user me-2"></i>Nome
                                            </div>
                                            <div class="info-value"><?php echo e($aluno->nome_pai ?? 'Não informado'); ?></div>
                                        </div>

                                      <?php $__currentLoopData = $contactos->where("Encaregado_id", $aluno->id_pai); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $contactoV): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

    <?php if(!empty($contactoV->Descricao)): ?>
        <div class="info-item">
            <div class="info-label">
                <i class="fas fa-phone me-2"></i>
                Contacto <?php echo e($i + 1); ?>

            </div>

            <div class="info-value">
                <?php echo e($contactoV->Descricao); ?>

            </div>
        </div>
    <?php endif; ?>

<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <div class="info-item">
                                            <div class="info-label">
                                                <i class="fas fa-briefcase me-2"></i>Profissão
                                            </div>
                                            <div class="info-value"><?php echo e($aluno->pai_profissao ?? 'Não informado'); ?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Mãe do Educando -->
                            <div class="col">
                                <div class="info-card h-100">
                                    <div class="card-header">
                                        <i class="fas fa-female me-2"></i> Mãe do Educando
                                    </div>
                                    <div class="card-body">
                                        <div class="info-item">
                                            <div class="info-label">
                                                <i class="fas fa-user me-2"></i>Nome
                                            </div>
                                            <div class="info-value"><?php echo e($aluno->nome_mae ?? 'Não informado'); ?></div>
                                        </div>
                                        <?php $__currentLoopData = $contactos->where("Encaregado_id", $aluno->id_mae); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $contactoV): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

    <?php if(!empty($contactoV->Descricao)): ?>
        <div class="info-item">
            <div class="info-label">
                <i class="fas fa-phone me-2"></i>
                Contacto <?php echo e($i + 1); ?>

            </div>

            <div class="info-value">
                <?php echo e($contactoV->Descricao); ?>

            </div>
        </div>
    <?php endif; ?>

<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <div class="info-item">
                                            <div class="info-label">
                                                <i class="fas fa-briefcase me-2"></i>Profissão
                                            </div>
                                            <div class="info-value"><?php echo e($aluno->mae_profissao ?? 'Não informado'); ?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Contactos do Encarregado -->
                            <div class="col-12">
                                <div class="info-card">
                                    <div class="card-header">
                                        <i class="fas fa-phone-alt me-2"></i>Contactos do Encarregado
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <?php $__currentLoopData = $contactos->where("Encaregado_id",$aluno->Encaregado_id); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i=>$contacto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>



                                                <?php if($contacto->Descricao): ?>
                                                    <div class="col-md-4">
                                                        <div class="info-item">
                                                            <div class="info-label">
                                                                <i class="fas fa-phone"></i> Contacto<?php echo e($i); ?>

                                                            </div>
                                                            <div class="info-value"><?php echo e($contacto->Descricao); ?></div>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>

                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- PAGAMENTOS -->
                    <div class="tab-pane fade" id="pagamentos" role="tabpanel">
                        <?php if(count($dadosmatricula) > 0): ?>
                            <div class="table-responsive">
                                <table class="table table-pagamentos">
                                    <thead>
                                        <tr>
                                            <th><i class="fas fa-calendar"></i> Parcela</th>
                                            <th><i class="fas fa-money-bill-wave me-2"></i> Valor</th>
                                            <th><i class="fas fa-exclamation-circle me-2"></i> Multa</th>
                                            <th><i class="fas fa-credit-card me-2"></i> Método</th>
                                            <th><i class="fas fa-hashtag me-2"></i> Referência</th>
                                            <th><i class="fas fa-check-circle me-2"></i> Estado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $valortotal = 0;
                                        ?>

                                        <!-- Matrícula -->
                                        <tr class="table-light">
                                            <td colspan="6" class="text-center py-3">
                                                <strong class="text-primary"><?php echo e($aluno->tipopagamentoNome); ?></strong>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><?php echo e($aluno->mesNome); ?></td>
                                            <td><?php echo e(number_format($aluno->valorDescricao, 2, ',', '.')); ?> MT</td>
                                            <td><?php echo e(number_format($aluno->Multa, 2, ',', '.')); ?> MT</td>
                                            <td><?php echo e($aluno->metodo_pagamento_desc); ?></td>
                                            <td><code><?php echo e($aluno->referencia); ?></code></td>
                                            <td>
                                                <span class="badge <?php echo e($aluno->Estado_Classe == 'Pago' ? 'badge-pago' : 'badge-pendente'); ?>">
                                                    <?php echo e($aluno->Estado_Classe); ?>

                                                </span>
                                            </td>
                                        </tr>
                                        <?php
                                            $valortotal += (float) $aluno->valorDescricao + (float) $aluno->Multa;
                                        ?>

                                        <!-- Mensalidades -->
                                        <?php $__currentLoopData = $dadosmatricula; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr class="table-light">
                                                <td colspan="6" class="text-center py-3">
                                                    <strong class="text-primary"><?php echo e($pg['Descrica'] ?? 'N/A'); ?></strong>
                                                </td>
                                            </tr>
                                            <?php $__currentLoopData = $pg['pagasNodia']->sortBy('mes_id'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td><?php echo e($item->mes); ?></td>
                                                    <td><?php echo e(number_format($item->valorDescricao, 2, ',', '.')); ?> MT</td>
                                                    <td><?php echo e(number_format($item->Multa, 2, ',', '.')); ?> MT</td>
                                                    <td><?php echo e($item->metodoPagDesc); ?></td>
                                                    <td><code><?php echo e($item->referencia); ?></code></td>
                                                    <td>
                                                        <span class="badge <?php echo e($item->estado == 'Pago' ? 'badge-pago' : 'badge-pendente'); ?>">
                                                            <?php echo e($item->estado); ?>

                                                        </span>
                                                    </td>
                                                </tr>
                                                <?php
                                                    $valortotal += (float) $item->valorDescricao + (float) $item->Multa;
                                                ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                    <tfoot class="table-dark">
                                        <tr>
                                            <td colspan="5" class="text-end"><strong>TOTAL GERAL:</strong></td>
                                            <td>
                                                <strong class="text-white">
                                                    <?php echo e(number_format($valortotal, 2, ',', '.')); ?> MT
                                                </strong>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        <?php else: ?>
                            <div class="text-center py-5">
                                <i class="fas fa-credit-card fa-4x text-muted mb-3 opacity-50"></i>
                                <h4 class="text-muted mb-2">Nenhum pagamento registado</h4>
                                <p class="text-muted">Este aluno ainda não possui registos de pagamento.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>



<!-- Popup para PDF -->
<div id="pdfPopup" class="pdf-popup">
  <div class="pdf-popup-content">
    <!-- Botão de fechar -->
    <button id="closeBtn" class="pdf-close-btn">
      <i class="fas fa-times"></i> Fechar
    </button>

    <!-- Botões de controle -->
    <div class="pdf-controls">
      <button id="printBtn" class="pdf-control-btn">
        <i class="fas fa-print"></i> Imprimir
      </button>
      <button id="downloadBtn" class="pdf-control-btn">
        <i class="fas fa-download"></i> Baixar
      </button>
    </div>

    <!-- Container do PDF -->
    <div class="pdf-container">
      <iframe id="pdfFrame" frameborder="0"></iframe>
    </div>

    <!-- Loading -->
    <div id="pdfLoading" class="pdf-loading">
      <div class="spinner-border text-primary" role="status">
        <span class="visually-hidden">Carregando PDF...</span>
      </div>
      <p>Carregando recibo...</p>
    </div>
  </div>
</div>
    <!-- SCRIPTS -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
            integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
            crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
            crossorigin="anonymous"></script>

    <script>


const dadosmatricula = <?php echo json_encode($dadosmatricula, 15, 512) ?>;
const dadosMes = <?php echo json_encode($dadosMes, 15, 512) ?>;
const aluno = <?php echo json_encode($aluno, 15, 512) ?>;
const dados= Object.values(dadosMes);
// const dados1 = dadosmatricula.flatMap(item => {
        // const dados1 = Object.values(item.pagasNodia || {}»);
  dados1 = dadosMes.map(e => ({
    tipo: e.tipo_pagamento_id,
    mes: e.mes_id
}));
// });

const dadosEncoded = encodeURIComponent(JSON.stringify(dados1));

// ===== CACHE DE ELEMENTOS =====
const elements = {
    printModal: $('#printModal'),
    printIframe: $('#printIframe'),
    printLoading: $('#printLoading'),
    closePrint: $('#closePrint')
};

// ===== CONFIGURAÇÕES =====
const config = {
    endpoints: {
        recibo: '/aluno/matricula/imprimir/recibo',
        dados: '/aluno/Informacao',
        imprimirRecibo: "/aluno/matricula/imprimir/recibo/",
        imprimirpoocesso: "/aluno/Informacao/",
    },
    response: {idaluno:aluno.idAlunoclasse,
        metodo:aluno.metodo_pagamento,
        dadosEncoded:<?php echo json_encode($dadosMes, 15, 512) ?>,
        anolectivo:aluno.anolectivo_id },   // corrigido
    animationSpeed: 300
};

$(document).on("click", ".Recibo-print", function () {
    const urlRecibo = `${config.endpoints.imprimirRecibo}${config.response.anolectivo}/${config.response.idaluno}/${dadosEncoded}/${config.response.metodo}`;
    window.open(urlRecibo, '_blank');
    abrirReciboPDF(urlRecibo,config.response.idaluno)
});


$(document).on("click", ".dados-print", function () {
    const urlRecibo = `${config.endpoints.imprimirpoocesso}${config.response.idaluno}}`;
    // window.open(urlRecibo, '_blank');
    abrirReciboPDF(urlRecibo,config.response.idaluno)
});

$(document).ready(function () {
    console.log(response);
});






// Função para abrir o PDF
function abrirReciboPDF(url,idaluno) {
    // Prepara dados para envio
    // const dados = response.meses.map(e => ({
    //     tipo: e.tipo,
    //     mes: e.mes
    // }));

    //const dadosEncoded = encodeURIComponent(JSON.stringify(dados));

    // Monta a URL
   // const urlRecibo = `${URLS.imprimirRecibo}${response.anolectivo}/${response.idaluno}/${dadosEncoded}/${response.metodo}`;

    console.log('URL do PDF:', url);

    // Mostra loading
    const popup = document.getElementById('pdfPopup');
    const loading = document.getElementById('pdfLoading');
    const pdfFrame = document.getElementById('pdfFrame');

    popup.style.display = 'block';
    loading.style.display = 'block';
    pdfFrame.style.display = 'none';

    // Faz a requisição do PDF
    fetch(url, {
        method: 'GET',
        headers: {
            'Accept': 'application/pdf'
        }
    })
    .then(res => {
        if (!res.ok) {
            throw new Error(`Erro ao buscar o PDF: ${res.status} ${res.statusText}`);
        }
        return res.blob();
    })
    .then(blob => {
        // Cria URL do blob
        const pdfUrl = URL.createObjectURL(blob);

        // Configura o iframe
        pdfFrame.src = pdfUrl;
        loading.style.display = 'none';
        pdfFrame.style.display = 'block';

        // Configura o botão de download
        document.getElementById('downloadBtn').onclick = function() {
            const link = document.createElement('a');
            link.href = pdfUrl;
            link.download = `recibo-matricula-${idaluno}.pdf`;
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        };

        // Configura impressão automática se necessário
        if (response.metodo !== 2) { // Só imprime automaticamente se não for M-Pesa
            setTimeout(() => {
                const iframeWindow = pdfFrame.contentWindow;
                if (iframeWindow) {
                    iframeWindow.focus();
                    iframeWindow.print();
                }
            }, 1000);
        }
    })
    .catch(err => {
        console.error('Falha ao carregar o PDF:', err);
        loading.innerHTML = `
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-triangle"></i>
                <h4>Erro ao carregar recibo</h4>
                <p>${err.message}</p>
                <button onclick="document.getElementById('pdfPopup').style.display='none'"
                        class="btn btn-sm btn-danger">
                    Fechar
                </button>
            </div>
        `;
    });
}
// Fecha popup
document.addEventListener('click', function(e) {
    if (e.target && e.target.id === 'closeBtn') {
        const popup = document.getElementById('pdfPopup');
        const pdfFrame = document.getElementById('pdfFrame');

        popup.style.display = 'none';
        if (pdfFrame.src) {
            URL.revokeObjectURL(pdfFrame.src);
            pdfFrame.src = '';
        }
    }
});

// Imprimir
document.addEventListener('click', function(e) {
    if (e.target && e.target.id === 'printBtn') {
        const pdfFrame = document.getElementById('pdfFrame');
        const iframeWindow = pdfFrame.contentWindow;

        if (iframeWindow) {
            iframeWindow.focus();
            iframeWindow.print();
        }
    }
});

// Fecha popup ao clicar fora
document.addEventListener('click', function(e) {
    const popup = document.getElementById('pdfPopup');
    if (popup && e.target === popup) {
        popup.style.display = 'none';
        const pdfFrame = document.getElementById('pdfFrame');
        if (pdfFrame.src) {
            URL.revokeObjectURL(pdfFrame.src);
            pdfFrame.src = '';
        }
    }
});

// Fecha com tecla ESC
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        const popup = document.getElementById('pdfPopup');
        if (popup && popup.style.display === 'block') {
            popup.style.display = 'none';
            const pdfFrame = document.getElementById('pdfFrame');
            if (pdfFrame.src) {
                URL.revokeObjectURL(pdfFrame.src);
                pdfFrame.src = '';
            }
        }
    }
});

    </script>
</body>
</html>
<?php /**PATH C:\laragon\www\escola2025\resources\views/registoAcademico/Visualizar-dados-Recibo.blade.php ENDPATH**/ ?>