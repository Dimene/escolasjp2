<?php $__env->startSection('title', 'Relatorio Mensalidades'); ?>
<?php $__env->startSection('content'); ?>

    <link rel="stylesheet" href="<?php echo e(asset('Datatable/css/jquery.dataTables.min.css')); ?>" />


    <!-- Content Wrapper. Contains page content -->
    <div class="">
        <!-- Content Header (Page header) -->
       <div class="breadcrumb-modern animate-fadeInUp">
        <ol class="breadcrumb" style="background: transparent; margin: 0; padding: 0;">
            <li class="breadcrumb-item">
                <a href="#"><i class="fa fa-graduation-cap"></i> Registo Académico</a>
            </li>
            <li class="breadcrumb-item">
                <a href="#"><i class="fa fa-credit-card"></i>Pagamentos</a>
            </li>
            <li class="breadcrumb-item active">
                <i class="fa fa-chart-line"></i> <b>Relatorio Generico</b>
            </li>
        </ol>
    </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <div class="content  container-fluid">
            <div class=" container  no-border no-shadow card-body" style="background-color: #fff">

                <div class="row">
                    <div class="col">

                        <div class="form-group">

                            <div class="col">

                                <div class="form-group">
                                    <label>Ano</label>
                                    <select class="anolectivo selectescohido" data-placeholder="" style="width: 100%;">
                                        <?php $__currentLoopData = $anolectivos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $anolectivoItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($anolectivoItem->id); ?>"><?php echo e($anolectivoItem->anolectivo); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                    </select>
                                </div>
                            </div>


                        </div>
                    </div>


                    <div class="col">

                        <div class="form-group">
                            <label>Classe</label>
                            <select class="select2 classes selectescohido" style="width: 100%;">
                                <?php $__currentLoopData = $classes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $classesItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($classesItem->id); ?>"><?php echo e($classesItem->Descricao); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            </select>
                        </div>
                    </div>
                    <div class="col">

                        <div class="form-group">
                            <label>Tipo de Pagamento</label>
                            <select class="select2 tipo selectescohido" style="width: 100%;">

                                <?php $__currentLoopData = $tipoPagamento; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tipoPagamentoItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                 <?php
                                    $Descricao=$tipoPagamentoItem->Descricao;
                                ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("RelatorioPagameto-$Descricao")): ?>
                                    <option value="<?php echo e($tipoPagamentoItem->id); ?>"><?php echo e($tipoPagamentoItem->Descricao); ?>

                                    </option>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            </select>
                        </div>
                    </div>


                </div>


            </div>



        </div>






        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="col conteudoRelatorio">





                </div>
            </div>
        </div>
    </div>

        <?php $__env->startPush('script'); ?>
            <script>
                $(document).ready(function() {

                    $ano = $(".anolectivo").val();
                    $classes = $(".classes").val();
                    $tipo = $(".tipo").val();
                    relatoriotesto($ano, $classes, $tipo);




                    $(".selectescohido").change(function() {

                        $ano = $(".anolectivo").val();
                        $classes = $(".classes").val();
                        $tipo = $(".tipo").val();

                        relatoriotesto($ano, $classes, $tipo);

                    });

                })



                function relatoriotesto($ano, $classe, $tipo, $flag) {
                    $.ajax({
                        url: "/RegistoAcademico/outrosPagamento/Relatorio/" + $ano + "/" + $classe + "/" + $tipo,
                        type: 'GET',
                        success: function(data, textStatus, jqXHR) {

                            $(".conteudoRelatorio").html(data);
                        }
                    })
                }
            </script>
        <?php $__env->stopPush(); ?>





    <?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin-Lti', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\escola2025\resources\views/registoAcademico/outrosPagamento/relatorio-mensalidades.blade.php ENDPATH**/ ?>