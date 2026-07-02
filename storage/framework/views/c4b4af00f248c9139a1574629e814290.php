<center>
    <?php
    $data1 = $periodo->startDate->format('Y/M/d');
    $data2 = $periodo->endDate->format('Y/M/d');
    $conf = DB::table('config')->first();
    
    ?>
    <div class="container-fluid"
        style="height:130px; width:130px; allign: center;  border-radius:300px;margin-bottom: 30px;">
        <center>
            <img src="<?php echo e(asset('storage/logoMarca/' . $conf->avatar . '')); ?>"
                style="width: 100%;height: 100%; border: 3px solid rgba(131, 124, 124, 0.541); border-radius: 60px; ">



    </div>
    <h3> <?php echo e($conf->nome); ?></h3>
    <h4> Relatorio de pagamento Diario de <?php echo e($tipo); ?></h4>
    <?php if($data1 == $data2): ?>
        De::<?php echo e($data1); ?>

    <?php else: ?>
        De::<?php echo e($data1); ?> á <?php echo e($data2); ?>

    <?php endif; ?>;
    <hr>



    <table class="table ">

        <tbody>
            <thead>
                <th>Data </th>
                <th>Classe </th>
                <th>Nr.Alunos</th>
                <th>Modal.pagamento</th>
                <th>Nr.Meses</th>
                <th>Mensalidades</th>
                <th style="background-color:RGBA(0,0,0,0.20)">Subtotal</th>
                <th>Multas</th>
                <th>Multas a pagar</th>
                <th style="background-color:RGBA(0,0,0,0.20)">Subtotal</th>
                <th>Total</th>

                </tr>
                <?php $xcontrol = 0;
                
                $xx = 0;
                
                $qtdademetodos = count($metodosPagamentos);
                $subtotoaltotalMensalidade = 0;
                $subtotoaltotalMulta = 0;
                ?>
            </thead>
            <?php $__currentLoopData = $collet; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key1 => $collectIntem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                $xcontrol++;
                
                ?>

                <?php $__currentLoopData = $collectIntem; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php $xx++;
                    
                    ?>
                    <tr></tr>
                    <td <?php if($xx < $qtdademetodos * $classessizeS + 1): ?> style="border-bottom: none; border-top: none" <?php endif; ?>
                        <?php if($xx == $qtdademetodos * $classessizeS): ?> )style="border-bottom: 1px solid black;" <?php endif; ?>
                        <?php if($xx == $qtdademetodos * $classessizeS): ?> )style="border-top: none;" <?php endif; ?>>
                        <?php if($classessizeS == 1): ?>
                            <?php if($xx == 2): ?>
                                <?php echo e($value->data_pagamento); ?>

                            <?php endif; ?>
                        <?php elseif($xx == ($qtdademetodos * $classessizeS) / 2): ?>
                            <?php echo e($value->data_pagamento); ?>

                        <?php endif; ?>
                    </td>
                    <td <?php if($key > 0): ?> style="border-bottom: none; border-top: none" <?php endif; ?>
                        <?php if($key == 0): ?> style="border-bottom: none;" <?php endif; ?>>
                        <?php if($key == 2): ?>
                            <?php echo e($value->classes); ?>

                        <?php endif; ?>
                    </td>
                    <td><?php echo e($value->tipopagamento); ?></td>
                    <td <?php if($key > 0): ?> style="border-bottom: none; border-top: none" <?php endif; ?>
                        <?php if($key == 0): ?> style="border-bottom: none;" <?php endif; ?>>
                        <?php if($key == 2): ?>
                            <?php echo e($value->NUmerAlunos); ?>

                        <?php endif; ?>
                    </td>
                    <td><?php echo e($value->NUmerMeses); ?></td>

                    <td <?php if($key > 0): ?> style="border-bottom: none; border-top: none" <?php endif; ?>
                        <?php if($key == 0): ?> style="border-bottom: none;" <?php endif; ?>>
                        <?php if($key == 2): ?>
                            <?php echo e($value->Mensaldade); ?>

                        <?php endif; ?>
                    </td>
                    <td style="background-color:RGBA(0,0,0,0.20)"><?php echo e($value->subtotalmensalidade); ?></td>
                    <td><?php echo e($value->NUmerMulta); ?></td>
                    <td <?php if($key > 0): ?> style="border-bottom: none; border-top: none" <?php endif; ?>
                        <?php if($key == 0): ?> style="border-bottom: none;" <?php endif; ?>>
                        <?php if($key == 2): ?>
                            <?php echo e($value->Multavalor); ?>

                        <?php endif; ?>
                    </td>
                    <td style="background-color:RGBA(0,0,0,0.20)"><?php echo e($value->SubtotalMultas); ?></td>
                    <td><?php echo e($value->SubtotalMultas + $value->subtotalmensalidade); ?></td>

                    <?php $subtotoaltotalMensalidade = $subtotoaltotalMensalidade + $value->subtotalmensalidade; ?>
                    <?php $subtotoaltotalMulta = $subtotoaltotalMulta + $value->SubtotalMultas; ?>
                    </tr>


                    <?php if($xx == $qtdademetodos * $classessizeS): ?>
                        <tr style="background-color:RGBA(0,0,0,0.50)">
                            <td colspan="6">TOTAL</td>

                            <td colspan="3"><?php echo e($subtotoaltotalMensalidade); ?> </td>


                            <td><?php echo e($subtotoaltotalMulta); ?></td>
                            <td><?php echo e($subtotoaltotalMulta + $subtotoaltotalMensalidade); ?></td>
                        </tr>
                    <?php endif; ?>

                    <?php if ($xx == $qtdademetodos * $classessizeS) {
                        $xx = 0;
                        $subtotoaltotalMensalidade = 0;
                        $subtotoaltotalMulta = 0;
                    } ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
</center>

</html>

<style>
    table {
        border: 1px solid black;
    }

    td,
    th {
        border: 1px solid black;
    }

    .tableP {
        border-collapse: collapse;
        margin: auto;
    }

    .tablef {
        border-collapse: collapse;
        margin: -1px;

    }

    .tdf {
        border-botton: 1px solid black;
    }
</style>
<?php /**PATH C:\laragon\www\escola2025\resources\views/registoAcademico/outrosPagamento/relatoriospagamentos/pagamentosPrint.blade.php ENDPATH**/ ?>