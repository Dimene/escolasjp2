<?php
    use Carbon\Carbon;

    $conf = DB::table("config")->first();
    $data = Carbon::now()->format('d') . ' de ' . Carbon::now()->translatedFormat('F') . ' de ' . Carbon::now()->format('Y');
?>

<div class="content container-fluid" id="content">
    <div class="container-fluid">
        <div class="card" style="font-size: 12px">
            <?php echo $__env->make('Componetes.cabecalho', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
   <p><strong>Taxa de <?php echo e($referenciasbancariasview->first()->tipo_pagamento ?? '---'); ?></strong></p>
            <div class="row">

                    <div class="profile-block">
                        <ul style="list-style: none;">
                            <li><b>Nome do Aluno:</b> <span class="profile-right"><?php echo e($aluno->nome); ?></span> <b>Sexo:</b> <span class="profile-right"><?php echo e($aluno->sexo); ?></span></li>
                            <li><b>Ano Lectivo:</b> <span><?php echo e($aluno->anolectivo); ?></span> <b>Classe que frequenta:</b> <span class="profile-right"><?php echo e($aluno->classe); ?></span></li> </ul>
                    </div>

            </div>

            <center>

            </center>

            <div class="no-shadow  container-fluid">
                <table class="table table-bordered custom-borda">
                    <thead>
                        <tr>
                            <th>Meses</th>
                            <th>Valor (MT)</th>
                            <th>Entidade</th>
                            <th>Referência</th>
                            <th>Prazo</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php $__currentLoopData = $referenciasbancariasview->sortBy('mes_id'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $itemDado): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if(!empty($itemDado)): ?>
                                <?php
                                    $valor = $itemDado->valorDescricao;


$estado =  \Carbon\Carbon::parse($itemDado->limite)->format('d-m-y');
                                    $valorMulta = ($itemDado->multa / 100) * $valor;

                                    if ($itemDado->multaflag) {
                                        $estado = "Vencida";
                                        $valor += $valorMulta;
                                    }
                                ?>
                                <tr>
                                    <td><?php echo e($itemDado->mes ?? '-'); ?></td>
                                    <td><?php echo e(number_format($valor, 2, ',', '.')); ?></td>
                                    <td><?php echo e($itemDado->Entidade ?? '-'); ?></td>
                                    <td><?php echo e($itemDado->referencia ?? '-'); ?></td>
                                    <td><?php echo e($estado); ?></td>
                                </tr>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>

                <center>
                    <p><?php echo e($data); ?></p>
                    Assinatura do Funcionário<br>
                    _______________________<br>
                    (<?php echo e(Auth()->user()->name); ?>)
                </center>
            </div>
        </div>
    </div>
    <div class="rodape">
        <center>
          <p>
            <b>Endereço:</b>
            <i><?php echo e($conf->Provincia); ?> - <?php echo e($conf->Distrito); ?> - <?php echo e($conf->Localizacao); ?> |
            <b>Email/Contacto:</b> <?php echo e($conf->Email); ?> / <?php echo e($conf->Contacto); ?> |
            <b>Processado por:</b> <?php echo e($conf->nome_Empresa); ?> Sistemy</i>
          </p>
        </center>
      </div>
</div>

<style>
    @media print {
        @page {
            size: A5 portrait;

        }

    .rodape {

      font-size: 8px;
      background-color: rgba(0,0,0,0.2);
    }
        body {
            font-family: Consolas, monospace;
            font-size: 12px;
            background: #fff;
            padding: 0;
            margin: 0;
        }

        .card, .no-shadow {
            box-shadow: none !important;
            border: none !important;
        }

        .container-fluid, .content {
            width: 100%;
            padding: 0;
            margin: 0;
        }

        .table th, .table td {
            padding: 4px;
            font-size: 10px;
        }

        .no-print {
            display: none !important;
        }
    }

    table.custom-borda {
        border-collapse: collapse;
        width: 100%;
    }

    table.custom-borda th,
    table.custom-borda td {
        border: 1px solid #333;
        padding: 8px;
    }

    body {
        font-family: Consolas, monospace;
        font-size: 12px;
        background: #fff;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: flex-start;
        padding: 5mm;
    }
</style>

<script>
    // window.onload = function () {
    //     window.print();
    // };
</script>
<?php /**PATH C:\laragon\www\escola2025\resources\views/Financas/Banco/visualizar-entidadePrint.blade.php ENDPATH**/ ?>