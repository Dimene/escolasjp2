<?php $__env->startSection('title', 'Ano Lectivo'); ?>
<?php $__env->startSection('content'); ?>

<link  rel="stylesheet" href="jquery.dataTables.min.css"/>
<link  rel="stylesheet"  href="buttons.dataTables.min.css"/>

<!-- Content Wrapper. Contains page content -->
<div class="">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid ">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h3 class="m-0 text-dark">  Atualizar Ano Lctivo</h3>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Registo Académico</a></li>
            <li class="breadcrumb-item active"> Configurar Ano </li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>



<?php if(isset($dados[0]->nome)): ?>
<div class="card col-8 container-fluid">
    <div class="card-body">
        <h5 class="card-title"> Esta configuração, possui Alunos Associados</h5>
        <p class="card-text">

        <table class="table table-light">
        <thead>
        <tr>
       <th> Nome </th>
       <th> Classe </th>
       <th> Ano </th>
        </tr>

        </thead>
            <tbody>
            <?php for($x=0; $x<count($dados);$x++): ?>


                <tr>
                    <td><?php echo e($dados[$x]->nome); ?></td>
                    <td><?php echo e($dados[$x]->classe); ?></td>
                    <td><?php echo e($dados[$x]->anolectivo); ?></td>
                </tr>
                <?php endfor; ?>
            </tbody>
        </table>
        </p>
    </div>
</div>
<?php else: ?>


<div class="card  col-8 container-fluid">
    <div class="card-body">
        <h5 class="card-title"><i class="fa fa-lg fa-warning">Pretendes Apagar Ano Lectivo<?php echo e($dadosAno[0]->anolectivo); ?> ??</i></h5>
        <p class="card-text">

    <div class="row">
        <div class="col">
           <div class="card">
               <div class="card-body">

                   <p class="card-text"><b>Inicio :</b><?php echo e($dadosAno[0]->Inicio); ?></p>
                   <p class="card-text"><b>Fim :</b><?php echo e($dadosAno[0]->Fim); ?></p>
                   <p class="card-text"><b>Divisao :</b><?php echo e($dadosAno[0]->modalidade); ?></p>
               </div>
           </div>

        </div>


        <div class="col">
           <div class="card">
               <div class="card-body">
                Divisoes do Ano
                 <?php for($i = 0; $i < count($dadosAnoLectivoDisao); $i++): ?>


                   <p class="card-text"><b>Divisao</b> <?php echo e($i+1); ?> &nbsp;  <b>Inicio :</b><?php echo e($dadosAnoLectivoDisao[$i]->Inicio); ?>  &nbsp;
                    <b>Fim :</b><?php echo e($dadosAnoLectivoDisao[$i]->Fim); ?></b></p>

                   <?php endfor; ?>

               </div>
           </div>

        </div>

    </div>


      <div class="card-body  col-md-8 container-fluid ">
      <div class="row ">
      <div class="col-md-6">

      <form class="" method="post" action="<?php echo e(Route('ano.destroy',$dadosAno[0]->id )); ?>">

      <?php echo method_field("Delete"); ?>
       <?php echo csrf_field(); ?>
        <button name="" id="" class="btn btn-danger" href="#"  type="submit" role="button">Sim</button>

</form>
</div>
  <div class="col-md-6">
        <a name="" id="" class="btn btn-primary" href="<?php echo e(Route('ano.create')); ?>" role="button">Cancelar</a>

        </div>
        </div>
        </div>
        </div>

        </p>
    </div>
</div>


<?php endif; ?>
  <?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin-Lti', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\escola2025\resources\views/registoAcademico/AnoLectivo_informacoes.blade.php ENDPATH**/ ?>