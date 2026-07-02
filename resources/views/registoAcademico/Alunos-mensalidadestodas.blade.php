

<table class="table table-light isplay no-shadow table-responsive" id="listadosalunos" tyle="width:100%">
<thead>
<tr>
<th>Nome</th>
<th>Classe </th>
<th>Janeiro </th>
<th>Fevereiro</th>
<th>Março</th>
<th>Abril </th>
<th>Maio</th>
<th>Junho</th>
<th>julho</th>
<th>Agosto</th>
<th>Setembro</th>
<th>Outubro</th>
<th>Novembro</th>
<th>Dezembro</th>



</tr>
</thead>
    <tbody>
@for($x=0; $x<count($arraymensalidades); $x++)

     <tr>
            <td><?php  echo $arraymensalidades[$x]->nome; ?></td>
            <td><?php  echo $arraymensalidades[$x]->classeFRequnetada; ?></td>
            <td><?php  echo $arraymensalidades[$x]->Janeiro ;?></td>
            <td><?php  echo $arraymensalidades[$x]->Fevereiro; ?></td>
            <td><?php  echo $arraymensalidades[$x]->Março; ?></td>
            <td><?php  echo $arraymensalidades[$x]->Abril; ?></td>
            <td><?php  echo $arraymensalidades[$x]->Maio; ?></td>
            <td><?php  echo $arraymensalidades[$x]->Junho; ?></td>
            <td><?php  echo $arraymensalidades[$x]->Julho; ?></td>
            <td><?php  echo $arraymensalidades[$x]->Agosto; ?></td>
            <td><?php  echo $arraymensalidades[$x]->Setembro; ?></td>
            <td><?php  echo $arraymensalidades[$x]->Outubro; ?></td>
            <td><?php  echo $arraymensalidades[$x]->Novembro; ?></td>
            <td><?php  echo $arraymensalidades[$x]->Dezembro; ?></td>
            


        </tr>
@endfor
       
    </tbody>
    <tfoot>

   <th>Nome</th>
<th>Classe </th>
<th>Janeiro </th>
<th>Fevereiro</th>
<th>Março</th>
<th>Abril </th>
<th>Maio</th>
<th>Junho</th>
<th>julho</th>
<th>Agosto</th>
<th>Setembro</th>
<th>Outubro</th>
<th>Novembro</th>
<th>Dezembro</th>

    </tfoot>
</table>
<script>


	$(document).ready(function() {
     
        $('#listadosalunos').DataTable( {
            dom: 'Bfrtip',

            buttons: [

               'colvis','copy', 'csv', 'excel', 'pdf','print'
            ],
 columnDefs: [ {
                targets: [3,4,5,6,7,8],
                visible: false
            } ],

            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": false,
            "autoWidth": true,
            "lengthMenu": [[5, 10, 25, 50, -1], [5,10, 25, 50, "All"]],
            language: {
              "lengthMenu": "visualizar _MENU_ ",
              "zeroRecords": "Nada foi encontado",
              "info": "mostrara pagina por pagina",
              "processing":     "processando..",
              "infoEmpty": "Nada tem ",
              "infoFiltered": "(filtered from _MAX_ total records)",
              "loadingRecords": "processando...",
              "search":         "pesquisar:",
              "paginate": {
          "first":      "primera",
          "last":       "ultima",
          "next":       "proxima",
          "previous":   " Anterior"
        },
          },
            initComplete: function () {
                this.api().columns([1,2,3,3,4,5,6,7,8,9,10,11,12,13,14]).every( function () {
                    var column = this;
                    var select = $('<select  class="SelectorSerach"><option value=""></option></select>')
                        .appendTo( $(column.footer()).empty() )
                        .on( 'change', function () {
                            var val = $.fn.dataTable.util.escapeRegex(
                                $(this).val()
                            );

                            column
                                .search( val ? '^'+val+'$' : '', true, false )
                                .draw();
                        } );

                    column.data().unique().sort().each( function ( d, j ) {
                        select.append( '<option value="'+d+'">'+d+'</option>' )
                    } );
                } );
            }
        } );
    } );

    </script>