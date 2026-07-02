<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Relatório de Pagamentos</title>

    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #000;
            padding: 6px;
        }

        th {
            background: #eaeaea;
            text-align: center;
        }

        td {
            vertical-align: middle;
        }

        .text-center { text-align: center; }
        .text-right { text-align: right; }

        .bg-sub {
            background-color: rgba(0,0,0,0.08);
            font-weight: bold;
        }

        .bg-total {
            background-color: #d9edf7;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <center>
        <?php
        $conf = DB::table('config')->first();
        ?>

        <div style="width: 120px; height: 120px; margin: auto; border-radius: 60px; border: 3px solid rgba(131,124,124,0.5); overflow: hidden;">
            <img src="<?php echo e(asset('storage/logoMarca/' . $conf->avatar)); ?>" style="width: 100%; height: 100%;">
        </div>
<?php
    // $tipPa=tipos_pagamentos::where("id",$tipo)->first();
?>
        <h3>Relatório de Pagamentos</h3>
        <p>Período: <?php echo e($periodo->startDate->format('d/m/Y')); ?> - <?php echo e($periodo->endDate->format('d/m/Y')); ?></p>
        
    </center>

    <table>
        <thead>
            <tr>
                <th>Data</th>
                <th>Classe</th>
                <th>Método Pagamento</th>
                <th>Nr. Alunos</th>
                <th class="bg-sub">Subtotal</th>
                <th>Multas</th>
                <th class="bg-sub">Subtotal</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>

        <?php
            $totalAlunos = 0;
            $totalValores = 0;
            $totalMultas = 0;
            $totalGeral = 0;
        ?>

        <?php $__currentLoopData = $esperadoDetalhes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php $__currentLoopData = explode(',', $item->ClassesList); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $dado = DB::table('relatoriograficoview')
                        ->where('tipo_pagamento_id', $tipo)
                        ->where('classe', $c)
                        ->where('anolectivo_id', $ano)
                        ->whereDate('data_pagamento', $item->data_pagamento)
                        ->select(
                            'classe',
                            'metodoPagDesc',
                            DB::raw('COUNT(*) as qtd'),
                            DB::raw('SUM(valorDescricao) as valor'),
                            DB::raw('SUM(IFNULL(Multa,0)) as multa'),
                            DB::raw('SUM(valorDescricao + IFNULL(Multa,0)) as total')
                        )
                        ->groupBy('classe','metodoPagDesc')
                        ->get();

                    $qtdMetodos = $dado->count();
                    $totalClasse = $dado->sum('total');
                ?>

                <?php $__currentLoopData = $dado; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $subtotal = $row->valor + $row->multa;

                        // Totais gerais
                        $totalAlunos += $row->qtd;
                        $totalValores += $row->valor;
                        $totalMultas += $row->multa;
                        $totalGeral += $subtotal;
                    ?>

                    <tr>
                        
                        <?php if($i === 0): ?>
                            <td rowspan="<?php echo e($qtdMetodos); ?>" class="text-center">
                                <?php echo e($item->data_pagamento); ?>

                            </td>
                        <?php endif; ?>

                        
                        <?php if($i === 0): ?>
                            <td rowspan="<?php echo e($qtdMetodos); ?>" class="text-center">
                                <?php echo e($c); ?>

                            </td>
                        <?php endif; ?>

                        
                        <td><?php echo e($row->metodoPagDesc); ?></td>

                        
                        <td class="text-center"><?php echo e($row->qtd); ?></td>

                        
                        <td class="text-right"><?php echo e(number_format($row->valor,2,',','.')); ?></td>

                        
                        <td class="text-right"><?php echo e(number_format($row->multa,2,',','.')); ?></td>

                        
                        <td class="text-right bg-sub"><?php echo e(number_format($subtotal,2,',','.')); ?></td>

                        
                        <?php if($i === 0): ?>
                            <td rowspan="<?php echo e($qtdMetodos); ?>" class="text-right bg-sub"><?php echo e(number_format($totalClasse,2,',','.')); ?></td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        
        <tr class="bg-total">
            <td colspan="3" class="text-right">TOTAL GERAL</td>
            <td class="text-center"><?php echo e($totalAlunos); ?></td>
            <td class="text-right"><?php echo e(number_format($totalValores,2,',','.')); ?></td>
            <td class="text-right"><?php echo e(number_format($totalMultas,2,',','.')); ?></td>
            <td class="text-right"><?php echo e(number_format($totalValores + $totalMultas,2,',','.')); ?></td>
            <td class="text-right"><?php echo e(number_format($totalGeral,2,',','.')); ?></td>
        </tr>

        </tbody>
    </table>
</body>
</html>
<?php /**PATH C:\laragon\www\escola2025\resources\views/registoAcademico/relatoriospagamentos/pagamentosPrint_Matricula.blade.php ENDPATH**/ ?>