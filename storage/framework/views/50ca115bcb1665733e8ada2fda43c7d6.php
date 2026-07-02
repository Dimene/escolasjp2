<?php $__env->startSection('content'); ?>
<ol class="breadcrumb">
<li class="breadcrumb-item"><a href="/"><span>admin<i class="fa fa-bags"></i></span></a></li>
<li class="breadcrumb-item"><a href="/"><span>Usuario<i class="fa fa-bags"></i></span></a></li>
<li class="breadcrumb-item active"><a><span>Apagar USuario</span></a></li>

</ol>


     <div class="card col-md-8 no-shadow container-fluid" >
         <div class="card-body">
             <?php if(isset($sucess)): ?>

             <?php echo $__env->make('produtos.ComponetesGeral.sucesso_reportar', $mensage , \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
             <?php endif; ?>

             <?php if(isset($error)): ?>
             <?php echo $__env->make('produtos.ComponetesGeral.Error_reportar,',$mensage , \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

             <?php endif; ?>

	<form method="POST" action="<?php echo e(route('Usuarios.destroy',$usuario->id)); ?> " enctype="multipart/form-data">
        <?php echo method_field('Delete'); ?>
                        <?php echo csrf_field(); ?>

                      <center>  <h3><b>Pretendes Apagar ?</b></h3></center>


            <div class="">

                <hr>
                <div class="form-row">
                    <div class="col-sm-12 col-md-12">
                        <div class="form-group"><label>Nome </label>
						 <input  disabled id="phone" type="text" class="form-control<?php echo e($errors->has('name') ? ' is-invalid' : ''); ?>"
						 name="name" value="<?php echo e($usuario->name ?? old('name')); ?>" required>

                                <?php if($errors->has('name')): ?>
                                    <span class="invalid-feedback" role="alert">
                                        <strong><?php echo e($errors->first('name')); ?></strong>
                                    </span>
                                <?php endif; ?>
						</div>
                    </div>

                </div>
                <div class="form-group"><label>Email </label>

                 <input disabled  id="phone" type="email" class="form-control<?php echo e($errors->has('email') ? ' is-invalid' : ''); ?>"
                 name="email" value="<?php echo e($usuario->email  ??  old('email')); ?>" required>

                                <?php if($errors->has('email')): ?>
                                    <span class="invalid-feedback" role="alert">
                                        <strong><?php echo e($errors->first('email')); ?></strong>
                                    </span>
                                <?php endif; ?>
				</div>

                <div class="form-row">
                    <div class="col-sm-12 col-md-12">
                        <div class="form-group"><label>Codigo Funcionario </label>


                            <input  disabled id="my-codigo"  class="form-control<?php echo e($errors->has('codigo') ? ' is-invalid' : ''); ?>"
                            value="<?php echo e($usuario->Codigo ??  old('codigo')); ?>"
                            type="text" class="form-control" name="codigo"  />



                                <?php if($errors->has('codigo')): ?>
                                    <span class="invalid-feedback" role="alert">
                                        <strong><?php echo e($errors->first('codigo')); ?></strong>
                                    </span>
                                <?php endif; ?>
						</div>
                    </div>

                </div>
				<div class="form-row">

                    <div class="col-sm-12 col-md-12">
                        <div class="form-group"><label>Selecione Papel que desempenar&aacute;</label>

						</div>
                    </div>
                </div>





 


 <select  disabled class="form-control select2 select2-hidden-accessible"  name="role" style="width: 100%;" tabindex="-1" aria-hidden="true">

    <?php $__currentLoopData = $roles->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $rolesvalue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>


    <option
    <?php if(!empty($usuario->roles->first())): ?>
    <?php if($usuario->roles->first()->id == $rolesvalue->id): ?>
        selected="selected"   <?php endif; ?> value="<?php echo e($rolesvalue->id); ?>"
<?php endif; ?>
        ><font style="vertical-align: inherit;">

        <font style="vertical-align: inherit;"><?php echo e($rolesvalue->label); ?>

             <?php echo e("( "); ?>

            <?php $__currentLoopData = $roles->find($rolesvalue->id )->permission; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rolpalel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
           <b> <?php echo $rolpalel->label; ?></b>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php echo e(")"); ?>

            </font></font></option>

        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

  </select> </div>

 





                <hr>
                <div class="form-row">

                    <div class="col-md-6 content-right content-right ">
                        <button type="submit" class="btn btn-outline-danger float-right">

                                        <?php echo e(__('Apagar')); ?>

                                    </button>
                        </div>

                        



                    
                </div>
            </div>
        </div>

</div>
         </div>
     </div>
	  </form>
<?php $__env->startPush('style'); ?>


<link  rel="stylesheet" href="<?php echo e(asset('Registo/css/styles.min.css')); ?>"  />

<?php $__env->stopPush(); ?>
<?php $__env->startPush('script'); ?>

<script src="<?php echo e(asset('Registo/js/script.min.js')); ?>" ></script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin-Lti', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\escola2025\resources\views/auth/apagar-usuario.blade.php ENDPATH**/ ?>