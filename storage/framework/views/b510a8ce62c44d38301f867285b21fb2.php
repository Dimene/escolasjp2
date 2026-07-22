<?php
use Picqer\Barcode\BarcodeGeneratorPNG;

$conf = DB::table("config")->first();
$geradoPor = Auth()->user()->name ?? 'SISTEMA';
$idAluno = $aluno->id ?? '0000';

// Limpar o nome do usuário para o código de barras
$nomeLimpo = strtoupper(preg_replace('/[^A-Za-z0-9]/', '', $geradoPor));
$codigoBarra = $idAluno . '-' . $nomeLimpo;

// Gerar código de barras com tratamento de erro
try {
    $generator = new BarcodeGeneratorPNG();
    $barcode = base64_encode(
        $generator->getBarcode($codigoBarra, $generator::TYPE_CODE_128)
    );
} catch (Exception $e) {
    $barcode = null;
}

// Tratar data atual
$agora = Carbon\Carbon::now();
$data = $agora->format('d') . ' de ' . $agora->translatedFormat('F') . ' de ' . $agora->format('Y');

// VERIFICAR SE A COLEÇÃO NÃO ESTÁ VAZIA
$temRegistros = isset($referenciasbancariasview) && $referenciasbancariasview->isNotEmpty();

// Definir valores padrão caso não tenha registros
$tipoPagamento = $temRegistros ? ($referenciasbancariasview->first()->tipo_pagamento ?? 'BANCÁRIA') : 'BANCÁRIA';
$bancoReferencia = $temRegistros ? ($referenciasbancariasview->first()->Banco ?? '---') : '---';

$host = request()->getHost();
$subdomain = explode('.', $host)[0];
?>

<div class="content container-fluid" id="content">
    <div class="container-fluid">
        <div class="card" style="font-size: 12px; padding: 15px;">

            <!-- CABEÇALHO: LOGO + NOME ESQUERDA | CÓDIGO DE BARRAS DIREITA -->
            <div class="recibo-header">
                <div class="header-left">
                    <?php if(isset($conf->avatar) && $conf->avatar): ?>
                        <img src="<?php echo e(asset('storage/'.$subdomain.'/logoMarca/'.$conf->avatar)); ?>"
                             alt="Logo" class="logo-img">
                    <?php else: ?>
                        <span class="logo-placeholder">🏫</span>
                    <?php endif; ?>
                    <div class="school-info">
                        <strong><?php echo e($conf->nome ?? 'INSTITUIÇÃO DE ENSINO'); ?></strong>
                        <small><?php echo e($conf->lema ?? ''); ?></small>
                    </div>
                </div>
                <div class="header-right">
                    <?php if($barcode): ?>
                        <img class="barcode-img" src="data:image/png;base64,<?php echo e($barcode); ?>" alt="Código de Barras">
                        <span class="barcode-text"><?php echo e($codigoBarra); ?></span>
                    <?php else: ?>
                        <div class="barcode-fallback"><?php echo e($codigoBarra); ?></div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- SUBTÍTULO -->
            <div class="recibo-subtitle">
                REFERÊNCIAS TAXA <?php echo e($tipoPagamento); ?>

            </div>

            <!-- DADOS DO ALUNO -->
            <div class="profile-block">
                <ul style="list-style: none;">
                    <li>
                        <b>NOME:</b> <?php echo e(strtoupper($aluno->nome ?? '---')); ?> |
                        <b>SEXO:</b> <?php echo e($aluno->sexo ?? '---'); ?>

                    </li>
                    <li>
                        <b>ANO LECTIVO:</b> <?php echo e($aluno->anolectivo ?? '---'); ?> |
                        <b>CLASSE:</b> <?php echo e($aluno->classe ?? '---'); ?>

                    </li>
                    <li>
                        <b>EMISSÃO:</b> <?php echo e($data); ?> |
                        <b>REFERÊNCIA BANCO:</b> <?php echo e($bancoReferencia); ?>

                    </li>
                </ul>
            </div>

            <!-- TABELA DE PAGAMENTOS -->
            <table class="table table-bordered custom-borda">
                <thead>
                    <tr>
                        <th>MÊS</th>
                        <th>VALOR (MT)</th>
                        <th>ENTIDADE</th>
                        <th>REFERÊNCIA</th>
                        <th>Banco</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($temRegistros): ?>
                        <?php $__currentLoopData = $referenciasbancariasview->sortBy('mes_id'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $itemDado): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                // Tratar valor base
                                $valorBase = isset($itemDado->valorDescricao) && $itemDado->valorDescricao ? $itemDado->valorDescricao : 0;
                                $valorFinal = $valorBase;

                                // Tratar data limite com segurança
                                $statusPrazo = '---';

                                if(isset($itemDado->limite) && $itemDado->limite) {
                                    try {
                                        $statusPrazo = Carbon\Carbon::parse($itemDado->limite)->format('d/m/y');
                                    } catch (Exception $e) {
                                        $statusPrazo = 'Data inválida';
                                    }
                                }

                                // Calcular multa se houver
                                if(isset($itemDado->multaflag) && $itemDado->multaflag == true) {
                                    $multaPercentual = isset($itemDado->multa) && $itemDado->multa ? $itemDado->multa : 0;
                                    $multaValor = ($multaPercentual / 100) * $valorBase;
                                    $valorFinal += $multaValor;
                                    $statusPrazo = "VENCIDO + MULTA";
                                }

                                // Tratar outros campos
                                $mes = isset($itemDado->mes) && $itemDado->mes ? strtoupper($itemDado->mes) : '-';
                                $entidade = $itemDado->Entidade ?? '-';
                                $referencia = $itemDado->referencia ?? '-';

                                $escolha = $dadodospagos->where("mes_id", $itemDado->mes_id)->first();
                            ?>
                            <?php if(!empty($itemDado) && $escolha->Estado == 'Não pago'): ?>
                            <tr>
                                <td><?php echo e($mes); ?></td>
                                <td class="text-right"><?php echo e(number_format($valorFinal, 2, ',', '.')); ?></td>
                                <td><?php echo e($entidade); ?></td>
                                <td><?php echo e($referencia); ?></td>
                                <td><?php echo e($itemDado->Banco); ?></td>
                                <td><?php echo e($statusPrazo); ?></td>
                            </tr>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" style="text-align: center; padding: 20px;">
                                <strong>NENHUM REGISTRO DE PAGAMENTO ENCONTRADO</strong><br>
                                <small>Este aluno não possui referências bancárias cadastradas</small>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>

            <!-- ÁREA DE ASSINATURA -->
            <div class="assinatura">
                <div><?php echo e($data); ?></div>
                <div class="assinatura-line">
                    _______________________
                </div>
                <div>
                    <small><?php echo e(strtoupper(Auth()->user()->name ?? 'FUNCIONÁRIO')); ?></small><br>
                    <small>ASSINATURA / CARIMBO</small>
                </div>
            </div>

            <!-- RODAPÉ -->
            <div class="rodape">
                <b>ENDEREÇO:</b>
                <?php echo e($conf->Provincia ?? '-'); ?> -
                <?php echo e($conf->Distrito ?? '-'); ?> -
                <?php echo e($conf->Localizacao ?? '-'); ?><br>
                <b>CONTACTO:</b> <?php echo e($conf->Contacto ?? '-'); ?> |
                <b>EMAIL:</b> <?php echo e($conf->Email ?? '-'); ?>

            </div>
        </div>
    </div>
</div>

<!-- CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
      integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="<?php echo e(asset('perfilView/assets/css/styles.min.css')); ?>">

<style>
    /* ESTILO GERAL */
    body {
        font-family: 'Courier New', Courier, 'Lucida Sans Typewriter', monospace;
        font-size: 12px;
        background: #fff;
        margin: 0;
        padding: 2mm;
        width: 100%;
    }

    /* CABEÇALHO EM LINHA */
    .recibo-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-bottom: 10px;
        border-bottom: 2px solid #000;
        margin-bottom: 10px;
    }

    .header-left {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .logo-img {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        object-fit: cover;
        border: 1px solid #ccc;
    }

    .logo-placeholder {
        font-size: 30px;
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #eee;
        border-radius: 50%;
    }

    .school-info {
        display: flex;
        flex-direction: column;
        line-height: 1.2;
    }

    .school-info strong {
        font-size: 16px;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .school-info small {
        font-size: 10px;
        color: #555;
        font-style: italic;
    }

    .header-right {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .barcode-img {
        width: 140px;
        height: 30px;
    }

    .barcode-text {
        font-size: 9px;
        font-family: monospace;
        letter-spacing: 1px;
        color: #333;
        margin-top: 2px;
    }

    .barcode-fallback {
        font-family: monospace;
        font-size: 14px;
        font-weight: bold;
        padding: 5px 10px;
        background: #f0f0f0;
        border: 1px dashed #333;
    }

    /* SUBTÍTULO */
    .recibo-subtitle {
        font-size: 10px;
        text-align: center;
        margin-top: -5px;
        margin-bottom: 10px;
        font-weight: bold;
        text-transform: uppercase;
    }

    /* DADOS DO ALUNO */
    .profile-block {
        border: 1px dashed #333;
        padding: 8px;
        margin: 10px 0;
        background: #f9f9f9;
        font-size: 11px;
    }

    .profile-block ul {
        margin: 0;
        padding: 0;
    }

    .profile-block li {
        margin-bottom: 5px;
    }

    /* TABELA */
    table.custom-borda {
        border-collapse: collapse;
        width: 100%;
        font-size: 10px;
    }

    table.custom-borda th {
        border: 1px solid #000;
        padding: 8px;
        background: #e8e8e8;
        font-weight: bold;
        text-transform: uppercase;
        font-size: 9px;
        letter-spacing: 0.5px;
    }

    table.custom-borda td {
        border: 1px solid #000;
        padding: 6px;
        font-size: 10px;
    }

    .text-right {
        text-align: right;
    }

    /* ASSINATURA */
    .assinatura {
        font-size: 10px;
        margin-top: 20px;
        text-align: center;
    }

    .assinatura-line {
        margin-top: 30px;
        border-top: 1px dotted #000;
        width: 200px;
        margin-left: auto;
        margin-right: auto;
        padding-top: 5px;
    }

    /* RODAPÉ */
    .rodape {
        font-size: 8px;
        text-align: center;
        margin-top: 20px;
        border-top: 1px solid #ccc;
        padding-top: 10px;
    }

    /* IMPRESSÃO A5 */
    @media print {
        @page {
            size: A5 portrait;
            margin: 1cm;
        }

        body {
            padding: 0;
            margin: 0;
        }

        .profile-block {
            border: 1px dashed #000;
            background: none;
        }

        table.custom-borda th {
            background: #f0f0f0;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        .no-print {
            display: none;
        }

        .recibo-header {
            border-bottom: 2px solid #000;
        }

        .logo-img {
            border: 1px solid #000;
        }

        .barcode-img {
            background: #fff;
        }
    }

    /* RESPONSIVO PARA TELAS PEQUENAS */
    @media (max-width: 600px) {
        .recibo-header {
            flex-direction: column;
            align-items: stretch;
            gap: 10px;
        }
        .header-left {
            justify-content: center;
        }
        .header-right {
            align-items: center;
        }
        .school-info {
            text-align: center;
        }
    }
</style>
<?php /**PATH C:\laragon\www\escolasaojoaopaulo\resources\views/Financas/Banco/visualizar-entidadePrint.blade.php ENDPATH**/ ?>