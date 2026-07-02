<?php if(!empty($oberveroperacoes)): ?>


<table id="lista_operacoes" class="table table-reposive">

<thead>
<tr>
<th>
    &aacute;rea:
</th>
<th>Operacao</th>
<th>data</th>
<th>
accoes
</th>
</tr>
</thead>

<tbody>

    <?php $__currentLoopData = $oberveroperacoes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <tr>
    <td><?php echo e($value->model); ?></td>

    <td><?php echo e($value->action); ?></td>
    <td> <?php echo e($value->created_at); ?></td>

    <td> <a href="/admin/RegistoOperacoes/detalhes/<?php echo e($value->register); ?>" id="maisdetalhes"

        >Mais Detalhes</a></td>
    </tr>



    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</tbody>
<tfoot>
    <tr>
    <th>
        &aacute;rea:
    </th>
    <th>Operacao</th>
    <th>data</th>
    <th>
    accoes
    </th>
    </tr>
</tfoot>
</table>
<?php endif; ?>
<?php if(empty($oberveroperacoes)): ?>


<center>
<h4>Nenhuma opera&ccedil;&atilde;o foi registada </h4>
</center>
<?php endif; ?>
<script>
    $('#lista_operacoes').DataTable({
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
            [4, 10, 25, 50, 100, -1],
            [4, 10, 25, 50, 100, "All"]
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
            this.api().columns([0,1,2]).every(function() {
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
<?php /**PATH C:\laragon\www\escola2025\resources\views/Admin/ACL/oberver-lista.blade.php ENDPATH**/ ?>