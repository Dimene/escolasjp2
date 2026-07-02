<!DOCTYPE html>
<html lang="pt">
<head>
    
    <?php
$conf = DB::table('config')->first();
$host = request()->getHost();
$subdomain = explode('.', $host)[0];
?>

    <meta charset="UTF-8">
    <style>
        @page {
            size: A5 portrait;
            margin: 6mm;
        }

        body {
            font-family: Consolas, monospace;
            font-size: 11px;
            color: #000;
        }

        h3, h4 {
            margin: 2px 0;
            text-align: left;
        }

        p {
            margin: 2px 0;
        }

        .center {
            text-align: center;
        }

        .logo {
            width: 55px;
            height: 55px;
            border-radius: 50%;
            object-fit: cover;
        }

        .recibo-header {
            height: 10px;
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .recibo-header .barcode {
            width: 140px;
            height: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 3px;
            font-size: 10px;
        }

        th, td {
            border: 1px solid #000;
            padding: 3px;
            text-align: center;
        }

        .grupo {
            background: #eee;
            font-weight: bold;
        }

        .assinatura {
            margin-top: 15px;
            text-align: center;
        }

        hr {
            border: 0;
            border-top: 1px dashed #333;
            margin: 6px 0;
        }
    </style>


<?php

    $tipoExibido = null;


    use Carbon\Carbon;
    use Picqer\Barcode\BarcodeGeneratorPNG;

    $conf = DB::table('config')->first();

    $diasAtraso = Carbon::parse($matricula->Datamatricula)
        ->diffInDays(Carbon::parse($matricula->limite), false);

    $generator = new BarcodeGeneratorPNG();

    //    dd($talao);


$barcode = base64_encode(
        $generator->getBarcode($talao, $generator::TYPE_CODE_128)
    );



    $primeiroItem = $dadosTabela->first();






    $primeiroMes  = $primeiroItem? optional($primeiroItem)['meses']->first() :null;


$total=0;


  $nome=DB::table('metodo_pagamento')->where("id",$matricula->metodo_pagamento)->first();
$flagDados=0;
    if($matricula->Multa>0){
$flagDados=1;
    }

    $dadosRev=DB::table('referenciasbancariasview')->where("id",$matricula->idAlunoclasse)
     ->where("multaflag",$flagDados)
     ->where("tipo_pagamento_id",$matricula->tipo_Pagamento_id)
    ->where("Banco_id",$nome->tipo)
    ->first();
    //  dd($dadosRev);

?>

<!-- CABEÇALHO -->
<div class="recibo-header">
    <div>
        <h3><?php echo e($nomeDoc); ?> Nº <?php echo e($talao); ?></h3>
    </div>
    <div>
        <img class="barcode" src="data:image/png;base64,<?php echo e($barcode); ?>" alt="Código de Barras">
    </div>
</div>

<!-- LOGO E NOME DA INSTITUIÇÃO -->
<div class="center" style="margin: 10px 0;">
     <img src="<?php echo e(asset('storage/'.$subdomain.'/logoMarca/'.$conf->avatar)); ?>" alt="<?php echo e($conf->nome_Empresa); ?>" class="logo">
   
</div>
<center> <h3><?php echo e($conf->nome); ?></h3></center>
<hr>

<!-- DADOS DO ALUNO -->
<p><b>Nome:</b> <?php echo e($matricula->nome); ?></p>
<p><b>Classe:</b> <?php echo e($matricula->classe); ?></p>
<?php if($flag==null): ?>
<hr>
<!-- TAXAS E MULTAS -->
<p><b>Taxa de Matrícula:</b> <?php echo e(number_format($matricula->valorDescricao,2,',','.')); ?> MT</p>

<?php if($matricula->Multa > 0): ?>
    <p><b>Multa:</b> <?php echo e(number_format($matricula->Multa,2,',','.')); ?> MT</p>

    <?php if($diasAtraso > 0): ?>
        <p><b>Atraso:</b> <?php echo e($diasAtraso); ?> dias</p>
    <?php endif; ?>

    <?php
      $total=$total+ $matricula->valorDescricao + $matricula->Multa;
    ?>
    <p><b>Total:</b> <?php echo e(number_format($matricula->valorDescricao + $matricula->Multa,2,',','.')); ?> MT</p>
<?php endif; ?>

<div style="background-color: rgba(0, 0, 0, 0.092); padding: 2px; border-radius: 2%">
 <?php if($nome->tipo>0): ?>

<p><b>Banco :</b><?php echo e($dadosRev->Banco); ?>     &nbsp;&nbsp;  <b>Entidade :</b>
    <?php echo e($dadosRev->Entidade); ?>

      &nbsp;&nbsp;   <b>Referencia: </b>   &nbsp;&nbsp; <?php echo e($dadosRev->referencia); ?></p>
    <?php else: ?>

<p><b>Via de  pagamento: </b>  &nbsp;<?php echo e($matricula->metodo_pagamento_desc); ?> &nbsp; &nbsp; <b>Referencia: </b>  &nbsp; <?php echo e($matricula->referencia); ?></p>
    <?php endif; ?>
    <?php endif; ?>
    <hr>
</div>
<?php if(count($dadosTabela)>0): ?>
<!-- TABELA DE MESES -->
<?php echo $__env->make("Componetes.compontenteTabelaRecibo", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<!-- ASSINATURA -->

<?php endif; ?>
<div class="assinatura">
  <p>
    <?php echo e(\Carbon\Carbon::now()->locale('pt')->translatedFormat('d \d\e F \d\e Y')); ?>

</p>
    ___________________________<br>
    <?php echo e(auth()->user()->name); ?>

</div>
<pre>
</pre>
<?php if(count($dadosTabela)<4): ?>

<hr>
corte

<!-- CABEÇALHO -->
<div class="recibo-header">
    <div>
        <h3><?php echo e($nomeDoc); ?> Nº <?php echo e($talao); ?></h3>
    </div>
    <div>
        <img class="barcode" src="data:image/png;base64,<?php echo e($barcode); ?>" alt="Código de Barras">
    </div>
</div>

<!-- LOGO E NOME DA INSTITUIÇÃO -->
<div class="center" style="margin: 10px 0;">
    <img src="<?php echo e(asset('storage/'.$subdomain.'/logoMarca/'.$conf->avatar)); ?>" alt="<?php echo e($conf->nome_Empresa); ?>" class="logo">
   
</div>
<center> <h3><?php echo e($conf->nome); ?></h3></center>
<hr>

<!-- DADOS DO ALUNO -->
<p><b>Nome:</b> <?php echo e($matricula->nome); ?></p>
<p><b>Classe:</b> <?php echo e($matricula->classe); ?></p>
<?php if($flag==null): ?>
<hr>
<!-- TAXAS E MULTAS -->
<p><b>Taxa de Matrícula:</b> <?php echo e(number_format($matricula->valorDescricao,2,',','.')); ?> MT</p>

<?php if($matricula->Multa > 0): ?>
    <p><b>Multa:</b> <?php echo e(number_format($matricula->Multa,2,',','.')); ?> MT</p>

    <?php if($diasAtraso > 0): ?>
        <p><b>Atraso:</b> <?php echo e($diasAtraso); ?> dias</p>
    <?php endif; ?>

    <p><b>Total:</b> <?php echo e(number_format($matricula->valorDescricao + $matricula->Multa,2,',','.')); ?> MT</p>


<?php endif; ?>

<div style="background-color: rgba(0, 0, 0, 0.092); padding: 2px; border-radius: 2%">
 <?php if($nome->tipo>0): ?>

<p><b>Banco :</b><?php echo e($dadosRev->Banco); ?>     &nbsp;&nbsp;  <b>Entidade :</b>
    <?php echo e($dadosRev->Entidade); ?>

      &nbsp;&nbsp;   <b>Referencia: </b>   &nbsp;&nbsp; <?php echo e($dadosRev->referencia); ?></p>
    <?php else: ?>

<p><b>Via de  pagamento: </b>  &nbsp;<?php echo e($matricula->metodo_pagamento_desc); ?> &nbsp; &nbsp; <b>Referencia: </b>  &nbsp; <?php echo e($matricula->referencia); ?></p>
    <?php endif; ?>
    <?php endif; ?>
    <hr>
</div>

<?php if(count($dadosTabela)>0): ?>
<!-- TABELA DE MESES -->
<?php echo $__env->make("Componetes.compontenteTabelaRecibo", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<!-- ASSINATURA -->

<?php endif; ?>
<div class="assinatura">
   <p>
    <?php echo e(\Carbon\Carbon::now()->locale('pt')->translatedFormat('d \d\e F \d\e Y')); ?>

</p>
    ___________________________<br>
    <?php echo e(auth()->user()->name); ?>

</div>
<?php endif; ?>


</body>
</html>

<?php /**PATH C:\laragon\www\escolasaojoaopaulo\resources\views/registoAcademico/recibo-matricula-Remprimir.blade.php ENDPATH**/ ?>