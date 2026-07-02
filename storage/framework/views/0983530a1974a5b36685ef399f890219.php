<?php $__env->startSection('title', 'Relatorio.' . session()->get('formadepagamentos')); ?>
<?php $__env->startSection('content'); ?>

    <link rel="stylesheet" href="<?php echo e(asset('Datatable/css/jquery.dataTables.min.css')); ?>" />


    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h3 class="m-0 text-dark">Pagina Inicial</h3>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Registo Académico</a></li>
                            <li class="breadcrumb-item active"><?php echo e(session()->get('formadepagamentos')); ?> </li>
                            <li class="breadcrumb-item active">Relatorio </li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
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
                                    <select class="anolectivo" data-placeholder="" style="width: 100%;">
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
                            <select class="select2 classes" style="width: 100%;">
                                <?php $__currentLoopData = $classes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $classesItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($classesItem->id); ?>"><?php echo e($classesItem->Descricao); ?></option>
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


        <?php $__env->startPush('script'); ?>
            <script>
                $(document).ready(function() {

                    $ano = $(".anolectivo").val();
                    $classes = $(".classes").val();
                    relatoriotesto($ano, $classes);


                    $(".anolectivo").change(function() {
                        $ano = $(".anolectivo").val();
                        $classes = $(".classes").val();

                        relatoriotesto($ano, $classes);

                    });

                    $(".classes").change(function() {
                        $ano = $(".anolectivo").val();
                        $classes = $(".classes").val();
                        relatoriotesto($ano, $classes);

                    });

                })



                function relatoriotesto($ano, $classe) {
                    $.ajax({
                        url: "/aluno/mensalidade/Relatorio/" + $ano + "/" + $classe,
                        type: 'GET',
                        success: function(data, textStatus, jqXHR) {

                            $(".conteudoRelatorio").html(data);
                        }
                    })
                }
            </script>
        <?php $__env->stopPush(); ?>





    <?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin-Lti', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/sgemozco/escolasaojoaopauloii.sgemoz.com/resources/views/registoAcademico/relatorio-mensalidades.blade.php ENDPATH**/ ?>