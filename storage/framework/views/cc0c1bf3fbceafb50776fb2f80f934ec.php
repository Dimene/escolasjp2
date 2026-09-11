<?php
    // dd(($dadosnota->first()==null));
?>
<?php if($dadosnota->first()==null): ?>


<div class="alert alert-success" role="alert">
  <h4 class="alert-heading"></h4>
  <p></p>
  <p class="mb-0"> N&atilde;o possuie nenhuma Nota para emiss&atilde;o de Declaração</p>
</div>
<?php else: ?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Declaração Escolar </title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Times New Roman', serif;
        }

        body {
            background-color: #f5f5f5;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 10px;
        }

        .a4-container {
            width: 21cm;
            height: 29.7cm;
            background-color: white;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            padding: 0.5cm;
            position: relative;
        }

        .a4-conteudo {
            border: 8px double #000;
            outline: 4px solid #555;
            padding: 0.5cm;
            height: 100%;
            position: relative;
        }

        .school-header {
            text-align: center;
            margin-bottom: 1cm;
            padding-bottom: 0.3cm;
        }

        .school-name {
            font-size: 18pt;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 0.3cm;
        }

        .school-subtitle {
            font-size: 17pt;
            font-weight: bold;
        }

        .document-title {
            font-size: 18pt;
            text-align: center;
            margin-bottom: 1.3cm;
            text-decoration: underline;
        }

        .document-content {
            font-size: 12pt;
            line-height: 1.3;
            margin-bottom: 1.3cm;
        }

        .student-name {
            font-weight: bold;
            text-transform: uppercase;
        }

        .grades-table {
            width: 100%;
            margin-bottom: 0,5cm;
            border-collapse: collapse;
        }

        .grades-table td {

            border-bottom: 1px dotted #ccc;
        }

        .subject-name {
            width: 60%;
        }

        .grade-value {
            text-align: center;
            width: 40%;
        }

        .average-row {
            font-weight: bold;
            border-top: 2px solid #333;
        }

        .additional-info {
            margin-top: 0.3cm;
            /* margin-bottom: 0.5cm; */
        }

        .location-date {

            text-align: center;
             position: absolute;
              display: flex;
               justify-content: space-evenly;
                width: 100%;
            /* margin-bottom: 8cm; */

            bottom: 4cm;
        }

        /* Assinaturas fixas */
        .signatures {
            position: absolute;
            bottom: 1.6cm; /*fixa a posição acima do rodapé SysGeC*/
            left: 0;
            width: 100%;
            display: flex;
            justify-content: space-between;
            text-align: center;
        }

        .extracted-by, .verified-by, .director-signature {
            width: 30%;
        }

        .signature-line {
            padding-top: 0.3cm;
        }

        .signature-name {
            font-weight: bold;
            text-transform: uppercase;
        }

        /* Rodapé SysGeC */
        .sysgec-footer {
            position: absolute;
            bottom: 5px;
            left: 0;
            width: 100%;
            text-align: center;
            font-size: 10pt;
            font-style: italic;
            color: #333;
        }

        @media print {
            body {
                background: none;
                padding: 0;
            }

            .a4-container {
                box-shadow: none;
                width: 100%;
                height: auto;
                page-break-after: always;
            }
        }
    </style>
</head>
<body>

    <?php
        // dd( $conf,$subdomain,);
    ?>
   <div class="a4-container">
        <div class="a4-conteudo">
            <div class="school-header">
                <div class="logom">
                    <img src="<?php echo e(asset('storage/'.$subdomain.'/logoMarca/' . $conf->avatar)); ?>" style="width: 25mm; height: 25mm; margin: 0 auto;">
                </div>
                <div class="school-name"><?php echo e($conf->nome); ?>-<?php echo e($conf->Distrito); ?></div>
                <div class="school-subtitle">Declaração</div>
            </div>

            <div class="document-content">

                <strong >=== <?php echo e($director->name); ?> ,<?php echo e($nivel); ?></strong>, Directora da <?php echo e($conf->nome); ?> certifico que:
                <span class="student-name"><?php echo e($aluno->nome); ?>,</span>
                <?php if($aluno->sexo=="M"): ?>
                Filho
                <?php else: ?>
                filha
                <?php endif; ?> de
                 <?php echo e($aluno->nome_pai); ?>

                e de <?php echo e($aluno->nome_mae); ?>,
                Natural de <?php echo e($aluno->distrito); ?>,
                 Distrito de <?php echo e($aluno->distrito??"_____"); ?>, Província de <?php echo e($aluno->provincia??"___"); ?>,

                 <?php if($aluno->sexo=="M"): ?>
              nascido
                <?php else: ?>
               nascida
                <?php endif; ?>

<?php
    \Carbon\Carbon::setLocale('pt');


?>
                em
                <?php echo e(\Carbon\Carbon::parse($aluno->dataNascimento)->translatedFormat('d \d\e F \d\e Y')); ?>

                no ano lectivo de <?php echo e($aluno->anolectivo); ?>,
                 <?php if($informacaoudeclracao==""): ?>
                 concluiu neste Estabelecimento de Ensino
                 a
                 <strong><?php echo e($aluno->classe); ?>,</strong> tendo <strong>

                     <?php if($aluno->sexo=="M"): ?>
              APROVADO
                <?php else: ?>
               APROVADA
                <?php endif; ?>
</strong>   com

                     <?php else: ?>

no <?php echo e($informacaoudeclracao->first()->divisao); ?> <sup>º</sup>
<?php echo e($informacaoudeclracao->first()->anomodelos); ?> teve
                 <?php endif; ?>
                  as seguintes classificações:

                <table class="grades-table">
                    <?php
                        $somaNota=0;
                        $contador=0;
                    ?>

                    <?php $__currentLoopData = $dadosnota; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dadosnotaItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

   <?php
                        $somaNota=$somaNota+$dadosnotaItem->notas;
                        $contador= $contador+1;
                    ?>
                    <tr>
                        <td class="subject-name"><?php echo e($dadosnotaItem->disciplina); ?>......................................................</td>
                            <td class="grade-value"><strong>( <?php echo e($dadosnotaItem->notas); ?>)</strong></td>
                    </tr>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    <tr class="average-row">
    <td class="subject-name">Média.....................................................</td>
    <td class="grade-value"><strong>(<?php echo e(round($somaNota/$contador)); ?>)</strong></td>
</tr>
                </table>

                <div class="additional-info">
                    <p>Consta da Pauta de Frequência, no nº <?php echo e($dadosnota->first()->Numero_turma); ?> da Turma
                        <span  style="text-decoration:uppercase;">
                           <b> <?php echo e($dadosnota->first()->turma); ?></b>
                        </span>

                        , ano lectivo de <?php echo e($aluno->anolectivo); ?></p>
                    <p>E, por ser verdade mandei passar a presente Declaração assinada e autenticada com o carimbo em uso neste Estabelecimento. <strong>===</strong></p>
                </div>
            </div>


  <div class="location-date">
               <?php echo e(\Carbon\Carbon::now()->translatedFormat('d \d\e F \d\e Y')); ?>

            </div>
            <!-- Assinaturas fixas -->
            <div class="signatures">

                

                <div class="verified-by">
                    <div class="signature-name"><?php echo e(Auth::user()->name); ?></div>
                    <div class="signature-line">_____________________________</div>
                    <div>Conferiu</div>
                </div>

                <div class="director-signature">
                    <div class="signature-name"><?php echo e($director->name); ?></div>
                    <div class="signature-line">___________________________</div>
                    <div>
<?php if($director->sexo=="F"): ?>
                        <strong>A Directora da Escola</strong>
                        <?php else: ?>
<strong>O Director da Escola</strong>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Rodapé SysGeC -->
            <div class="sysgec-footer">
                Documento processado pelo <strong>SysGeC</strong>
            </div>
        </div>
    </div>
</body>
</html>
<?php endif; ?>
<?php /**PATH C:\laragon\www\escolasaojoaopaulo\resources\views/registoAcademico/Documentos/joaopaulo/declaracao-notas.blade.php ENDPATH**/ ?>