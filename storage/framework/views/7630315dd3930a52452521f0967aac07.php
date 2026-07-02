<?php $__env->startSection('title', 'Relatorio de Mensalidade por classe'); ?>
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
                            <li class="breadcrumb-item "><?php echo e(session()->get('formadepagamentos')); ?> </li>
                            <li class="breadcrumb-item "><a href="/aluno/mensalidade/Relatorio">
                                    Relatorio </a></li>
                            <li class="breadcrumb-item active">Detalhes </li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <div class="content  container-fluid">
            <div class=" container  no-border no-shadow card-body" style="background-color: #fff">
                <table class="table table-light" id="listadosalunos">
                    <thead>
                        <tr>
                            <th>Nr</th>

                            <th>Nome</th>
                            <th>Estado</th>
                            <th>Mensalidades</th>
                            <th>Multa</th>

                            <th>Turma</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php $__currentLoopData = $relatorioDetalhado; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $Item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($key + 1); ?></td>

                                <td><?php echo e($Item->nome); ?></td>
                                <td><?php echo e($Item->Estado); ?></td>
                                <td><?php echo e($Item->valorDescricao); ?></td>
                                <td><?php echo e($Item->Multa); ?></td>
                                <td><?php echo e($Item->turmas); ?></td>

                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <tfoot>
                        <tr>
                            <th>Nr</th>

                            <th>Nome</th>
                            <th>Estado</th>
                            <th>Mensalidades</th>
                            <th>Multa</th>

                            <th>Turma</th>
                        </tr>
                    </tfoot>
                    </tbody>
                </table>

            </div>

        </div>
        <?php $__env->startPush('script'); ?>
            <script>
                $('#listadosalunos').DataTable({
                    dom: 'Bfrtip',

                    buttons: [

                        'colvis', 'copy', 'csv', 'excel', 'pdf', 'print'
                    ],


                    "paging": true,
                    "lengthChange": true,
                    "searching": true,
                    "ordering": true,
                    "info": false,
                    "autoWidth": true,
                    "lengthMenu": [
                        [5, -1],
                        [5, "All"]
                    ],
                    language: {
                        "lengthMenu": "visualizar _MENU_ ",
                        "zeroRecords": "Nada foi encontado",
                        "info": "mostrara pagina por pagina",
                        "processing": "processando..",
                        "infoEmpty": "Nada tem ",
                        "infoFiltered": "(filtered from _MAX_ total records)",
                        "loadingRecords": "processando...",
                        "search": "pesquisar:",
                        "paginate": {
                            "first": "primera",
                            "last": "ultima",
                            "next": "proxima",
                            "previous": " Anterior"
                        },
                    },
                    initComplete: function() {
                        this.api().columns([2, 3, 4, 5]).every(function() {
                            var column = this;
                            var select = $(
                                    '<select  class="SelectorSerach"><option value=""></option></select>')
                                .appendTo($(column.footer()).empty())
                                .on('change', function() {
                                    var val = $.fn.dataTable.util.escapeRegex(
                                        $(this).val()
                                    );

                                    column
                                        .search(val ? '^' + val + '$' : '', true, false)
                                        .draw();
                                });

                            column.data().unique().sort().each(function(d, j) {
                                select.append('<option value="' + d + '">' + d + '</option>')
                            });
                        });
                    }
                });
            </script>
        <?php $__env->stopPush(); ?>

    <?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin-Lti', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/sgemozco/escolasaojoaopauloii.sgemoz.com/resources/views/registoAcademico/relatorio-mensalidaders-detalhado-mes.blade.php ENDPATH**/ ?>