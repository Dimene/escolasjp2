<?php $__env->startSection('title', 'notas dos alunos'); ?>
<?php $__env->startSection('content'); ?>

<style>
    :root {
        --primary-color: #3498db;
        --primary-dark: #2980b9;
        --secondary-color: #2c3e50;
        --accent-color: #e74c3c;
        --success-color: #27ae60;
        --light-gray: #f8f9fa;
        --medium-gray: #e9ecef;
        --dark-gray: #6c757d;
        --border-radius: 8px;
        --box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        --transition: all 0.3s ease;
    }

    body {
        background-color: #f5f7fa;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    /* Layout geral */
    .content-wrapper {
        background-color: #f5f7fa;
        padding: 20px;
        min-height: calc(100vh - 60px);
    }

    .card {
        border-radius: var(--border-radius);
        box-shadow: var(--box-shadow);
        border: none;
        margin-bottom: 20px;
        transition: var(--transition);
    }

    .card:hover {
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
    }

    .card-header {
        background: linear-gradient(to right, var(--primary-color), var(--primary-dark));
        color: white;
        border-bottom: none;
        border-radius: var(--border-radius) var(--border-radius) 0 0 !important;
        padding: 12px 20px;
        font-weight: 600;
        font-size: 0.95rem;
        letter-spacing: 0.3px;
    }

    .card-header i {
        margin-right: 8px;
        font-size: 1rem;
    }

    .card-body {
        padding: 20px;
    }

    /* Títulos */
    h5, h6 {
        color: var(--secondary-color);
        font-weight: 600;
    }

    /* Lista de turmas - SCROLLABLE */
    .turmas-container {
        max-height: 350px;
        overflow-y: auto;
        padding-right: 5px;
    }

    .turmas-container::-webkit-scrollbar {
        width: 6px;
    }

    .turmas-container::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    .turmas-container::-webkit-scrollbar-thumb {
        background: var(--primary-color);
        border-radius: 10px;
    }

    .turmas-container::-webkit-scrollbar-thumb:hover {
        background: var(--primary-dark);
    }

    .list-group-item {
        border: none;
        padding: 10px 12px;
        margin-bottom: 6px;
        border-radius: var(--border-radius) !important;
        transition: var(--transition);
        cursor: pointer;
        display: flex;
        align-items: center;
        background-color: white;
        font-size: 0.9rem;
        border-left: 3px solid transparent;
    }

    .list-group-item:hover {
        background-color: rgba(52, 152, 219, 0.1);
        transform: translateX(3px);
        border-left-color: var(--primary-color);
    }

    .list-group-item.active {
        background: linear-gradient(to right, var(--primary-color), var(--primary-dark));
        color: white;
        box-shadow: 0 4px 8px rgba(52, 152, 219, 0.3);
        border-left-color: var(--secondary-color);
    }

    .list-group-item i {
        margin-right: 10px;
        font-size: 14px;
        width: 20px;
        text-align: center;
    }

    /* Formulários e selects - COMPACTOS */
    .filtros-container {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        margin-bottom: 15px;
    }

    .filtro-item {
        flex: 1 1 200px;
        min-width: 180px;
    }

    .form-group {
        margin-bottom: 0;
    }

    .form-control, .form-select {
        border-radius: var(--border-radius);
        border: 1px solid #ddd;
        padding: 8px 12px;
        height: 38px;
        font-size: 0.9rem;
        transition: var(--transition);
    }

    .form-control:focus, .form-select:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.25);
    }

    .form-label {
        font-weight: 500;
        color: var(--secondary-color);
        margin-bottom: 4px;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }

    /* Área de conteúdo das notas - CARD SEPARADO */
    .notas-section {
        margin-top: 20px;
    }

    .conteudonotas {/*
        background-color: white;
        border-radius: var(--border-radius);
        padding: 0;
        min-height: 60px;
        border: 1px solid #eee;
        */
    }

    .Conteudotabela {/*
        background-color: white;
        border-radius: var(--border-radius);
        padding: 15px;
        margin-top: 15px;
        border: 1px solid #eee;
        overflow-x: auto;
        */
    }

    /* Abas de disciplinas */
    .nav-tabs {
        border-bottom: 2px solid #dee2e6;
        padding: 0 10px;
        background-color: #f8f9fa;
        border-radius: var(--border-radius) var(--border-radius) 0 0;
    }

    .nav-tabs .nav-link {
        background-color: #f1f3f5;
        color: #495057;
        border: 1px solid #ced4da;
        margin-right: 5px;
        margin-bottom: -2px;
        transition: all 0.2s ease;
        border-radius: 4px 4px 0 0;
        padding: 8px 16px;
        font-size: 0.9rem;
    }

    .nav-tabs .nav-link:hover {
        background-color: #e9ecef;
        border-color: #adb5bd;
    }

    .nav-tabs .nav-link.active {
        background-color: #ffffff !important;
        color: #212529 !important;
        border: 1px solid #ced4da;
        border-bottom: 2px solid var(--primary-color) !important;
        font-weight: 600;
        transform: translateY(-2px);
    }

    /* Estatísticas rápidas */
    .stats-mini-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 10px 15px;
        border-radius: var(--border-radius);
        margin-bottom: 15px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .stats-mini-card i {
        font-size: 1.5rem;
        opacity: 0.8;
    }

    .stats-mini-card .stats-info {
        text-align: right;
    }

    .stats-mini-card .stats-label {
        font-size: 0.8rem;
        opacity: 0.9;
    }

    .stats-mini-card .stats-number {
        font-size: 1.2rem;
        font-weight: 700;
    }

    /* Loading */
    .loading-container {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 150px;
    }

    .spinner-border {
        width: 2.5rem;
        height: 2.5rem;
        color: var(--primary-color);
    }

    /* Breadcrumb */
    .breadcrumb {
        background-color: transparent;
        padding: 0;
        font-size: 0.85rem;
        margin-bottom: 15px;
    }

    .breadcrumb-item a {
        color: var(--primary-color);
        text-decoration: none;
        transition: var(--transition);
    }

    .breadcrumb-item a:hover {
        color: var(--primary-dark);
        text-decoration: underline;
    }

    /* Cards lado a lado */
    .main-row {
        display: flex;
        flex-wrap: wrap;
        margin: 0 -10px;
    }

    .main-row > [class*="col-"] {
        padding: 0 10px;
    }

    /* Turmas card com altura fixa */
    .turmas-card {
        height: fit-content;
        position: sticky;
        top: 20px;
    }

    /* Container de filtros compacto */
    .filtros-card {
        margin-bottom: 15px;
    }

    /* Responsividade */
    @media (max-width: 992px) {
        .turmas-card {
            position: relative;
            top: 0;
            margin-bottom: 20px;
        }

        .filtro-item {
            flex: 1 1 100%;
        }
    }
</style>
    <style>
        .mudarCor {
            background-color: rgba(182, 173, 173, 0.504);

        }
    </style>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <!-- Content Wrapper. Contains page content -->

      <div class="breadcrumb-modern animate-fadeInUp">
        <ol class="breadcrumb" style="background: transparent; margin: 0; padding: 0;">
             <li class="breadcrumb-item">
                <a href="#"><i class="fa fa-graduation-cap"></i> Registo Académico</a>
            </li>
            <li class="breadcrumb-item">
                <a href="#"><i class="fa fa-book"></i> Gestão Notas</a>
            </li>

            <li class="breadcrumb-item active">
                <i class="fa fa-pencil"></i> <b>Pauta da Turma</b>
            </li>
        </ol>
    </div>
    <div class="">
        <!-- Content Header (Page header) -->


        <input name="disciplina_id" value="1" type="hidden">
        <input name="formulaTri" value="1" type="hidden">
        <input name="formulaanual" value="1" type="hidden">



<div class="card filtros-card">
                <div class="card-header">
                    <i class="fas fa-filter"></i> Filtros de Pesquisa
                </div>


<div class="card-body row">
                    <div class="filtros-container col">
                        <div class="filtro-item">
                            <div class="form-group ">


                    <select id="my-classe" class="form-control controler-classe-ano" name="">

                        <?php $__currentLoopData = $class; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $classItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php $__currentLoopData = $classesprofessor; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($classItem->id == $item->classe_id): ?>
                                    <option value="<?php echo e($classItem->id); ?>"><?php echo e($classItem->Descricao); ?></option>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    </select>
                </div>
                        </div>
						</div>






                        <div class="filtro-item col">
                            <div class="form-group">

                    <select id="my-anolectivo" class="form-control controler-classe-ano" name="">
                        <?php $__currentLoopData = $anolectivo; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $anolectivoItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php $__currentLoopData = $anoslectivoprofessore; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $anoslectivoprofessorItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($anoslectivoprofessorItem->ano_lectivo_id == $anolectivoItem->id): ?>
                                    <option value="<?php echo e($anolectivoItem->id); ?>"><?php echo e($anolectivoItem->anolectivo); ?>

                                    </option>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

            </div>
                        </div>

                        </div>

            <div class="card">
<div class="card-header" ></div>
                <div class=" cardeturmas pt-0 ">

                    <div class="lista-Turmas col-12 listaturmasAdd ">
                    </div>

                    <div class="card-body bodynotas">
                    </div>
                </div>
            </div>

        </div>
    </div>



    </div>
    </div>



<?php $__env->startPush("scripts"); ?>




<script src="<?php echo e(asset('Admin-LTE/plugins/jquery/jquery.min.js')); ?>"></script>



    <script src="<?php echo e(asset('Admin-LTE/plugins/bootstrap/js/bootstrap.bundle.min.js')); ?>"></script>
    <script src="<?php echo e(asset('Admin-LTE/plugins/datatables/dataTables.bootstrap4.js')); ?>"></script>
    <script src="<?php echo e(asset('Datatable/js/jquery.dataTables.min.js')); ?>"></script>
<script src="https://cdn.datatables.net/fixedheader/3.4.0/js/dataTables.fixedHeader.min.js"></script>
<script src="https://cdn.datatables.net/fixedcolumns/4.3.0/js/dataTables.fixedColumns.min.js"></script>
<script>


$(document).ready(function(){
   let classe= $("#my-classe").val();
   let anolectivo= $("#my-anolectivo").val();

buscar_turmas(anolectivo, classe);
})

  $(document).on("change",".controler-classe-ano", function(){
     let classe= $("#my-classe").val();
   let anolectivo= $("#my-anolectivo").val();
    buscar_turmas(anolectivo, classe)
  })

  $(document).on("click",".turmaselecionada ",function(){


   let turma =  document.querySelector(".turmaselecionada.active");
                    buscar_turmaSelecionada(turma.id);
                    inicializarDataTable();

  });



function buscar_turmas(ano, classe) {
                $.ajax({
                    url: '/RegistoAcademico/notas/turmasTrimestre/' + ano + '/' + classe + '',
                    type: "GET",

                    success: function(data, textStatus, jqXHR) {

                        $(".lista-Turmas").html(data);

                        let turma =  document.querySelector(".turmaselecionada.active");
                    buscar_turmaSelecionada(turma.id);


                    }

                });


            }



            function buscar_turmaSelecionada($id) {



                $.ajax({
                    url: "/RegistoAcademico/notas/disciplinas/notasTrimestrais/" +
                        $id + "",
                    type: "GET",
                    beforeSend: function() {
                        $(".bodynotas").empty();
                       $(".bodynotas").html(`
    <div class="d-flex justify-content-center align-items-center" style="height: 50px; align:center">
        <img src="<?php echo e(asset('imageproceaament/loading.gif')); ?>"
             alt="Carregando..."
             style="width:50px; height:50px;">
    </div>
`);

                    },

                    success: function(data) {
                        $(".bodynotas").html(data);





                    }
                })

            }


            $(document).on("click",".NotasPautaCaregar",function(){

            })

</script>



<?php $__env->stopPush(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin-Lti', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\escolasaojoaopaulo\resources\views/registoAcademico/notas/notas-trimestrais-show.blade.php ENDPATH**/ ?>