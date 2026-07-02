<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Declaração Escolar - Amilton José Jaime Chavana</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Times New Roman', serif;
        }

        body {
            background: url("<?php echo e(asset('storage/logoMarca/' . $conf->avatar)); ?>") no-repeat center center;
            background-size: contain;
            background-color: #f5f5f5;
            background-blend-mode: lighten;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        .a4-container {
            width: 29.7cm;
            height: 21cm;
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
            margin-bottom: 0.8cm;
            padding-bottom: 0.3cm;
        }

        .school-name {
            font-size: 18pt;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 0.2cm;
        }

        .school-subtitle {
            font-size: 17pt;
            font-weight: bold;
        }

        .document-title {
            font-size: 18pt;
            text-align: center;
            margin-bottom: 1cm;
            text-decoration: underline;
        }

        .document-content {
            font-size: 12pt;
            line-height: 1.4;
            margin-bottom: 0.6cm;
            text-align: justify;
        }

        .student-name {
            font-weight: bold;
            text-transform: uppercase;
        }

        /* Estilo para colunas dinâmicas */
        .grades-container {
            margin: 0.5cm 0;
        }

        .grades-columns {
            display: flex;
            flex-wrap: wrap;
            gap: 0.8cm;
            justify-content: flex-start;
        }

        .grades-column {
            flex: 1;
            min-width: 180px;
            max-width: 220px;
        }

        .grades-table {
            width: 100%;
            border-collapse: collapse;
        }

        .grades-table tr {
            page-break-inside: avoid;
            break-inside: avoid;
        }

        .grades-table td {
            border-bottom: 1px dotted #ccc;
            padding: 6px 4px;
            font-size: 11pt;
        }

        .grades-table td:first-child {
            white-space: nowrap;
        }

        .grades-table td:first-child:after {
            content: "........................................";
            letter-spacing: 2px;
            visibility: hidden;
        }

        .average-row {
            text-align: center;
            font-weight: bold;
            border-top: 2px solid #333;
            padding-top: 8px;
            margin-top: 12px;
            font-size: 12pt;
        }

        .additional-info {
            margin-top: 0.3cm;
            font-size: 11pt;
            line-height: 1.4;
            text-align: justify;
        }

        .location-date {
            text-align: center;
            margin-bottom: 1cm;
            font-size: 12pt;
        }

        .signatures {
            position: absolute;
            bottom: 1.2cm;
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
            border-top: 1px solid #000;
            width: 80%;
            margin: 0 auto;
        }

        .signature-name {
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 0.2cm;
        }

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

        .logo-img {
            width: 22mm;
            height: 22mm;
            margin: 0 auto;
            display: block;
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
            
            .grades-column {
                break-inside: avoid;
            }
        }
    </style>
</head>
<body>
    <div class="a4-container">
        <div class="a4-conteudo">
            <div class="school-header">
                <div class="logom">
                    <img src="<?php echo e(asset('storage/'.$subdomain.'/logoMarca/' . $conf->avatar)); ?>" class="logo-img" alt="Logo">
                </div>
                <div class="school-name"><?php echo e($conf->nome); ?>-<?php echo e($conf->Distrito); ?></div>
                <div class="school-subtitle">Certificado</div>
            </div>

            <div class="document-content">
                <strong><?php echo e($director->name); ?>, <?php echo e($nivel); ?></strong>, Directora da <?php echo e($conf->nome); ?>

                em face dos dados constantes dos registos académicos existentes nesta Instituição,
                que:
                <span class="student-name"><?php echo e($aluno->nome); ?>,</span> 

                <?php if($aluno->sexo=="M"): ?>
                    Filho
                <?php else: ?>
                    filha
                <?php endif; ?>
                de <?php echo e($aluno->nome_pai); ?> e de <?php echo e($aluno->nome_mae); ?>,
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

                em <?php echo e(\Carbon\Carbon::parse($aluno->dataNascimento)->translatedFormat('d \d\e F \d\e Y')); ?>

                no ano lectivo de <?php echo e($aluno->anolectivo); ?>,
                concluiu neste Estabelecimento de Ensino a
                <strong><?php echo e($aluno->classe); ?>,</strong> tendo
                <strong>
                    <?php if($aluno->sexo=="M"): ?>
                        APROVADO
                    <?php else: ?>
                        APROVADA
                    <?php endif; ?>
                </strong> com as seguintes classificações:
            </div>

            <!-- Disciplinas organizadas em colunas dinâmicas -->
            <div class="grades-container">
                <?php
                    // Processar dados das disciplinas
                    $disciplinasArray = [];
                    $somaNota = 0;
                    $contador = 0;
                    
                    foreach ($dadosnota as $dadosnotaItem) {
                        $disciplinasArray[] = [
                            'nome' => $dadosnotaItem->disciplina,
                            'nota' => $dadosnotaItem->notas
                        ];
                        $somaNota += $dadosnotaItem->notas;
                        $contador++;
                    }
                    
                    // Calcular número de colunas necessárias (máximo 4 linhas por coluna)
                    $maxLinhasPorColuna = 4;
                    $totalDisciplinas = count($disciplinasArray);
                    $numColunas = ceil($totalDisciplinas / $maxLinhasPorColuna);
                    
                    // Distribuir disciplinas pelas colunas
                    $colunas = [];
                    for ($i = 0; $i < $numColunas; $i++) {
                        $colunas[] = array_slice($disciplinasArray, $i * $maxLinhasPorColuna, $maxLinhasPorColuna);
                    }
                ?>

                <div class="grades-columns">
                    <?php $__currentLoopData = $colunas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $coluna): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="grades-column">
                            <table class="grades-table">
                                <?php $__currentLoopData = $coluna; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $disciplina): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td width="70%"><?php echo e($disciplina['nome']); ?></td>
                                        <td width="30%" align="center"><strong>(<?php echo e($disciplina['nota']); ?>)</strong></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </table>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>

            <!-- Média final -->
            <div class="average-row">
                Média Final .................................................. 
                <span style="font-size: 10pt; margin-left: 20px;">(<?php echo e(number_format($somaNota / $contador, 1)); ?> valores)</span>
            </div>

            <div class="additional-info">
                Consta da Pauta de Exames, com o nº 
				
				
				<?php echo e($alunoOutrosDados->Numero_jurri ?? '_____'); ?> do júri 
                <?php echo e($alunoOutrosDados->jurri ?? '_____'); ?>

                do ano lectivo de <?php echo e($alunoOutrosDados->anolectivo); ?>. E, por ser verdade, mandei passar a presente Certidão que é assinada e autenticada com o carimbo em uso neste Estabelecimento.
            </div>

            <div class="location-date" style="padding:50px;">
                Quelimane, <?php echo e(\Carbon\Carbon::now()->translatedFormat('d \d\e F \d\e Y')); ?>

            </div>

            <!-- Assinaturas -->
            <div class="signatures">
                <div class="extracted-by">
                    <div class="signature-name"><?php echo e(Auth::user()->name ?? '__________'); ?></div>
                    <div class="signature-line"></div>
                    <div>Conferiu</div>
                </div>

                

                <div class="director-signature">
                    <div class="signature-name"><?php echo e($director->name ?? '__________'); ?></div>
                    <div class="signature-line"></div>
                    <div>
					
					<?php
					
					
					
					?>
                        <?php if($director->sexo == 'F'): ?>
                            <strong>A Directora da Escola</strong>
                        <?php else: ?>
                            <strong>O Director da Escola</strong>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="sysgec-footer">
                Documento processado pelo <strong>SysGeC</strong>
            </div>
        </div>
    </div>
</body>
</html><?php /**PATH C:\laragon\www\escola2025\resources\views/registoAcademico/Documentos/joaopaulo/certificado-notas.blade.php ENDPATH**/ ?>