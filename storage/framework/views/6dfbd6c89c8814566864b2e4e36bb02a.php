<?php if($dadosTabela->count() > 0): ?>
<table>
    <thead>
        <tr>
            <th>Mês</th>
            <th>Valor</th>
            <th>Entidade</th>
            <th>Referência</th>
            <th>Situação</th>
        </tr>
    </thead>
    <tbody>

  <?php $__currentLoopData = $dadosTabela; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grupo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php if(!empty($grupo['meses']) && optional($grupo['meses']->first())->tipo > 2): ?>

        <?php if($tipoExibido !== ($grupo['Tipo'] ?? 'Outros Pagamentos')): ?>
            <tr class="grupo">
                <td colspan="5"><?php echo e($grupo['Tipo'] ?? 'Outros Pagamentos'); ?></td>
            </tr>

            <?php
                $tipoExibido = $grupo['Tipo'] ?? 'Outros Pagamentos';
            ?>
        <?php endif; ?>

        <?php $__currentLoopData = $grupo['meses']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php



$dadoscaregado=DB::table('outros_pagamentosview')
->where("aluno_classe_id",$item->id??null)
->where("mes_id",$item->mes_id??null)
->where("tipoPagamento_id",$item->tipo_pagamento_id??null)
->first();

//  dd($dadoscaregado,$item);

                $valor = $item->valorDescricao;
                $estado = $item->Estado ?? 'Data limite: '.$item->limite;

               $estadoValor = $dadoscaregado->Estado ?? '';

if ($estadoValor == "Pago" || $estadoValor == "activo") {
    $estado = "pago";
}
                else{


                if($item->multaflag){
                    $valor += ($item->multa / 100) * $valor;
                    $estado = $dadoscaregado->estado ?? 'Vencido';
                }}

                  $total=$total+$valor;

            ?>
            <tr>
                <td><?php echo e($item->mes); ?></td>
                <td><?php echo e(number_format($valor,2,',','.')); ?> MT</td>
                <td><?php echo e($item->Entidade); ?></td>
                <td><?php echo e($item->referencia); ?></td>
                <td><?php echo e($estado); ?></td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    <?php endif; ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<tr>
    <th  colspan="4">Total
    </th>
    <th>
     <?php echo e(number_format($total,2,',','.')); ?> MT
    </th>
</tr>

    </tbody>
</table>

<?php endif; ?>
<?php /**PATH /home/sgemozco/escolasaojoaopauloii.sgemoz.com/resources/views/Componetes/compontenteTabelaRecibo.blade.php ENDPATH**/ ?>