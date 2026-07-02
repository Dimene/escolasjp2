<?php $__env->startSection('title', 'Ano Lectivo'); ?>
<?php $__env->startSection('content'); ?>

<link  rel="stylesheet" href="jquery.dataTables.min.css"/>
<link  rel="stylesheet"  href="buttons.dataTables.min.css"/>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid ">
      <div class="row mb-2">
        <div class="col-sm-4">
          <h3 class="m-0 text-dark"></h3>
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
<?php if($errors->any()): ?>
    <div class="alert alert-danger container-fluid col-md-8">
        <ul>
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><?php echo e($error); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>
<?php endif; ?>
  <!-- /.content-header -->


  <div class="row container-fluid">
  <div class="col-md-4">
 <div class="card no-border no-shadow">
 <div class="card-header">
 tabela de Valores
 </div>
 <div class="card-body">
<ul class="list-group">
    <li class="list-group-item active ListaItem TablelaVisualizar" title="show">Visualizar</li>
    <li class="list-group-item  ListaItem" aria-disabled="true" title="create">Adicionar</li>
    <li class="list-group-item  ListaItem" aria-disabled="true"
     title="NovoPagamento">Criar novo pagamento

    </li>

</ul>


</ul>
 </div>

</div>

  </diV>
  <div class="col-md-8">

  <!-- Main content -->
  <div class="content  container-fluid  TablelaVisualizar ListaItemDiv">
  <?php if(isset($colecao)): ?>
    <div class="alert alerta-cadastro alert-success " role="alert">
        <h4 class="alert-heading"><?php echo e($colecao); ?></h4>

    </div>
	  <?php endif; ?>
    <div class="container  content-Add no-border no-shadow card-body Tabelashow" style="background-color: #fff" >


  <!--tabela DE VAVLORES SHOW-->




  <!--fIM TABELA vALORES SHOW-->






          </div>
          <br>
</div>




</div>
</div>
</div>






	<?php $__env->startPush('script'); ?>
    <script>

  var urlstore ='<?php echo e(Route('TabelaValores.store')); ?>';

  var token ='<?php echo e(Session::token()); ?>';



$(document).ready(function(){

$.ajax({
	url:"/RegistoAcademico/TabelaValores/show",
	type:'GET',
	success:function(data){

		$(".content-Add").html(data);

	}

});





$(".ListaItem").click(function(){
$(".ListaItem").removeClass('active');
$(this).addClass('active');
$(".alerta-cadastro").hide();
var novaurl="";
if($(this).attr('title')==="NovoPagamento"){
    novaurl ="metodosdepagamentos/NovoPagamento";
}
else{
novaurl ="/RegistoAcademico/TabelaValores/"+$(this).attr('title');
}
$.ajax({
	url:novaurl,
	type:'GET',
	success:function(data){

		$(".content-Add").html(data);

	}

});
});



});




    </script>

    <style>
    <style>
.novoItem {

  background: red;
  transition-property: background;
  transition-duration: 30s;
  transition-timing-function: linear;
  transition-delay: 10s;
}

.aparecer {

  background:#5DAC68;
}

    </style>

    <?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin-Lti', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\escola2025\resources\views/registoAcademico/tabelavalores-index.blade.php ENDPATH**/ ?>