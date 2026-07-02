<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <title>Recibo</title>

<?php

$conf = DB::table("config")->first();

$host = request()->getHost();

$subdomain = explode('.', $host)[0];

?>

<style>

    @page {
        size: 100mm auto;
        margin: 0mm;
    }

    body {

        font-family: "Courier New", monospace;
        font-size: 11px;
        color: #000;
        width: 100mm;
        margin: 0 auto;
        padding: 0;
        line-height: 1.4;
    }

    .center {
        text-align: center;
    }

    .logo {

        width: 65px;
        height: 65px;
        border-radius: 50%;
        object-fit: cover;
        margin-bottom: 5px;
    }

    .empresa {

        font-size: 14px;
        font-weight: bold;
        text-transform: uppercase;
    }

    .subtitulo {

        font-size: 11px;
        margin-top: 2px;
    }

    .documento {

        margin-top: 5px;
        font-size: 13px;
        font-weight: bold;
        text-transform: uppercase;
    }

    hr {

        border: none;
        border-top: 1px dashed #000;
        margin: 5px 0;
    }

    .info {

        width: 100%;
        font-size: 11px;
        margin-top: 5px;
    }

    .info td {

        padding: 2px 0;
        vertical-align: top;
    }

    .tituloTabela {

        margin-top: 8px;
        margin-bottom: 4px;
        text-align: center;
        font-weight: bold;
        text-transform: uppercase;
    }

    table.recibo {

        width: 100%;
        border-collapse: collapse;
        font-size: 10px;
    }

    table.recibo th {

        border-bottom: 1px dashed #000;
        padding: 4px 0;
        text-align: left;
    }

    table.recibo td {

        padding: 3px 0;
    }

    .right {

        text-align: right;
    }

    .total {

        border-top: 1px dashed #000;
        font-weight: bold;
    }

    .assinatura {

        margin-top: 15px;
        text-align: center;
        font-size: 10px;
    }

    .footer {

        margin-top: 10px;
        text-align: center;
        font-size: 10px;
    }

    .small {

        font-size: 9px;
    }

</style>

</head>

<body>

<!-- ========================================================= -->
<!-- CABECALHO -->
<!-- ========================================================= -->

<div class="center">

    <img
        src="<?php echo e(asset('storage/'.$subdomain.'/logoMarca/'.$conf->avatar)); ?>"
        class="logo"
    >

    <div class="empresa">
        <?php echo e($conf->nome); ?>

    </div>

    <div class="subtitulo">

        SISTEMA DE GESTÃO ESCOLAR

    </div>

    <div class="documento">

        RECIBO DE PAGAMENTO

    </div>

</div>

<hr>

<!-- ========================================================= -->
<!-- DADOS ALUNO -->
<!-- ========================================================= -->

<table class="info">

    <tr>
        <td width="35%"><b>Aluno:</b></td>
        <td><?php echo e($aluno->nome); ?></td>
    </tr>

    <tr>
        <td><b>Sexo:</b></td>
        <td><?php echo e($aluno->sexo); ?></td>
    </tr>

    <tr>
        <td><b>Tipo:</b></td>
        <td>

            <?php echo e($aluno->Tipo == "B" ? "Bolseiro" : "Normal"); ?>


        </td>
    </tr>

    <tr>
        <td><b>Ano Lectivo:</b></td>
        <td><?php echo e($aluno->anolectivo); ?></td>
    </tr>

    <tr>
        <td><b>Classe:</b></td>
        <td><?php echo e($aluno->classe); ?></td>
    </tr>

    <tr>
        <td><b>Talão:</b></td>
        <td><?php echo e($talao ?? '---'); ?></td>
    </tr>

</table>

<hr>

<!-- ========================================================= -->
<!-- TITULO -->
<!-- ========================================================= -->

<div class="tituloTabela">

    <?php echo e($Valores_pago[0]->tipodepagamentoDescricao ?? 'Pagamentos'); ?>


</div>

<!-- ========================================================= -->
<!-- CALCULOS -->
<!-- ========================================================= -->

<?php

$AnualMulta = 0;

$Anual = 0;

?>

<!-- ========================================================= -->
<!-- TABELA -->
<!-- ========================================================= -->

<table class="recibo">

    <thead>

        <tr>

            <th>Mês</th>

            <th class="right">Taxa</th>

            <th class="right">Multa</th>

            <th class="right">Total</th>

        </tr>

    </thead>

    <tbody>

<?php $__currentLoopData = $Valores_pago; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $Valores_pagoItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

<?php

$valormensal = 0;

$valorMulta = 0;

if($Valores_pagoItem->Estados == "Pago"):

$valores = DB::table("tabelavaloresano")
    ->where("Finalidade", $Valores_pagoItem->tipoPagamento)
    ->where("idanolectivo", $Valores_pagoItem->anolectivo_id)
    ->where("classId", $Valores_pagoItem->classe_id)
    ->first();

$valormensal = $valores->valorDescricao ?? 0;

$valorMulta = $Valores_pagoItem->Multa ?? 0;

$AnualMulta += $valorMulta;

$Anual += $valormensal;

endif;

?>

        <tr>

            <td>

                <?php echo e($Valores_pagoItem->mes); ?>


            </td>

            <td class="right">

                <?php echo e(number_format($valormensal, 2)); ?>


            </td>

            <td class="right">

                <?php echo e(number_format($valorMulta, 2)); ?>


            </td>

            <td class="right">

                <?php echo e(number_format($valormensal + $valorMulta, 2)); ?>


            </td>

        </tr>

<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    </tbody>

    <tfoot>

        <tr class="total">

            <td>TOTAL</td>

            <td class="right">

                <?php echo e(number_format($Anual, 2)); ?>


            </td>

            <td class="right">

                <?php echo e(number_format($AnualMulta, 2)); ?>


            </td>

            <td class="right">

                <?php echo e(number_format($Anual + $AnualMulta, 2)); ?>


            </td>

        </tr>

    </tfoot>

</table>

<hr>

<!-- ========================================================= -->
<!-- DATA -->
<!-- ========================================================= -->

<?php

$datalimite =
Carbon\Carbon::now()->day
." de ".
Carbon\Carbon::now()->monthName
." de ".
Carbon\Carbon::now()->year;

?>

<!-- ========================================================= -->
<!-- ASSINATURA -->
<!-- ========================================================= -->

<div class="assinatura">

    <?php echo e($datalimite); ?>


    <br><br>

    __________________________

    <br>

    <?php echo e(Auth()->user()->name); ?>


</div>

<!-- ========================================================= -->
<!-- FOOTER -->
<!-- ========================================================= -->

<div class="footer">

    <hr>

    <div class="small">

        Documento processado por computador

    </div>

    <div class="small">

        Obrigado pela preferência

    </div>

</div>

</body>
</html><?php /**PATH /home/sgemozco/escolasaojoaopauloii.sgemoz.com/resources/views/registoAcademico/outrosPagamento/mensalidadespagas.blade.php ENDPATH**/ ?>