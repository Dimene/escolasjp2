



<?php
$conf=DB::table("config")->first();
?>

  <style>
        @page {
            size: A5 portrait;
            margin: 8mm;
        }

        body {
            font-family: Consolas, monospace;
            font-size: 11px;
            color: #000;
        }

        h3, h4 {
            margin: 3px 0;
            text-align: center;
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
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .recibo-header .barcode {
            width: 150px;
            height: 40px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 6px;
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

    <div class="center" style="margin: 10px 0;">

          <img    src="<?php echo e(asset('storage/logoMarca/'. $conf->avatar.'')); ?>" class="logo"
          >



       </div>
</center>
        <center>


         <strong style="font-size:15px;"><?php echo e($conf->nome); ?>

            </strong>


        </center>






                      <ul style="list-style:none; font-size:15px"  >


                      <li><span class=""><b>Nome do Aluno:</b> </span><span class="profile-right"><?php echo e($aluno->nome); ?></span> </li>
                      <li><span class=""><b>Sexo:</b> </span><span class="profile-right"><?php echo e($aluno->sexo); ?></span> </li>


                           <li><span class="font-400"><b>Tipo:</b> </span><span class="profile-right">
                               <?php if($aluno->Tipo=="B"): ?> <?php echo e("Bolseiro"); ?>

                              <?php else: ?> <?php echo e("Normal"); ?>

                          <?php endif; ?></span> </li>

                         <li><span class="font-400"><b>Ano Lectivo :</b> </span><span class="">
                          <?php echo e($aluno->anolectivo); ?></span> </li>
   <li><span class="font-400"><b>Classe  que frequentada :</b> </span><span class="profile-right">
                          <?php echo e($aluno->classe); ?></span> </li>




   </ul>









        <!-- /.row -->
  <!-- /.container-fluid -->




                       <center><b>Situação  de  <?php echo e($Valores_pago[0]->tipodepagamentoDescricao); ?> </b></center>
                       <ul>



      <table class="table table-light  table-striped" width="100%" style="font-size:14px;">
      <thead>
              <tr>

                  <th><?php echo e($Valores_pago[0]->tipodepagamentoDescricao); ?></th>
                    <th>Estado</th>
                 <th> Multa   </th>
                <th>Taxa  mensal </th>
                <th>Total</th>


              </tr>
        </thead>
      <tbody>
  <?php
  $AnualMulta=0;
    $Anual=0;
   ?>
  <?php $__currentLoopData = $Valores_pago; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$Valores_pagoItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>


  <?php
   $valormensal=0;
   $valorMulta=0;
   if($Valores_pagoItem->Estados=="Pago"):




  $valores =DB::table("tabelavaloresano")
  ->where("Finalidade",$Valores_pagoItem->tipoPagamento)
  ->where("idanolectivo",$Valores_pagoItem->anolectivo_id)
  ->where("classId",$Valores_pagoItem->classe_id)
  ->first();
  $valormensal=$valores->valorDescricao;
  $valorMulta=$Valores_pagoItem->Multa;

  $AnualMulta=$valorMulta+ $AnualMulta;
  $Anual=$valormensal+$Anual;
       endif

   ?>
  <tr    <?php if( $key%2==0): ?>style="background-color:#F0F0F1" <?php endif; ?>
  >

   <td id="nome_mes"><?php echo e($Valores_pagoItem->mes); ?></td>
   <td><?php echo e($Valores_pagoItem->Estados); ?></td>

   <td><?php echo e($valorMulta); ?>,00MT</td>
    <td><?php echo e($valormensal); ?>,00MT</td>
   <td><?php echo e(( $valorMulta)+($valormensal)); ?>,00MT</td>

  </tr>


  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
     </tbody>
     <tfoot>
  <th> TOtal </th>
  <th>  </th>
  <th> <?php echo e($AnualMulta); ?>,00MT</th>
  <th> <?php echo e($Anual); ?>,00MT</th>
  <th><?php echo e($AnualMulta+$Anual); ?>,00MT </th>
  </tfoot>

      </table>


<?php $ano=Carbon\carbon::now()->year;

	$datalimite =Carbon\carbon::now()->day." de ".Carbon\carbon::now()->monthName."  de  ".Carbon\carbon::now()->year;


	// dd($atraso);
	?>

	  <center>

    <p><?php echo e($datalimite); ?></p>
            Assinatura do Funcionário<br>
            _______________________
            <br>
            (<?php echo e(Auth()->user()->name); ?>)
            <Center>



  </div>
  </div>
  <!-- /.content -->






<?php /**PATH C:\laragon\www\escola2025\resources\views/registoAcademico/outrosPagamento/mensalidadespagas.blade.php ENDPATH**/ ?>