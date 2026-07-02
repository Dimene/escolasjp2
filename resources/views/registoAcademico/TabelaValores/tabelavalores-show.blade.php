
    

 tabela de Valores


  <table class="table" id="listadevalorestabela">
  <thead>
  <tr>
  
  <th>Descrição</th>
  <th >Montante</th>
  <th >Multa</th>
  <th class="col-md-6 col-sm-6">Para ?</th>
  <th>Ano</th>
  <th class="col-md-4 col-sm-4" >Acções </th>
  </tr>
  </thead>
  <tbody class="boddy">
         
  @foreach($colecao as $key=> $colecaoV)
  <tr>

  <td>{{$colecaoV["Descricao"]}}</td>
  <td>{{$colecaoV["valorDescricao"]}}</td>
  <td>{{$colecaoV["multa"]}}</td>
  <td>{{$colecaoV["classes"]}}</td>
  <td>{{$colecaoV["anolectivo"]}}</td>
  <td>
  <button class="btn btn-primary btn-edit"   title="{{$colecaoV['id']}}" > <i class="fa fa-edit"></i></button>
  <button class="btn btn-danger"> <i class="fa fa-trash"></i></button>
  </td>
  </tr>
  @endforeach
  </tbody>
  <tfoot>
   <tr>
  
  <th>Descrição</th>
  <th>Montante</th>
  <th>Multa</th>
  <th>Para ?</th>
  <th>Ano</th>
  <th>Acções </th>
  </tr>
  </tfoot>
  
  
  </table>

	
<script>
$(".btn-edit").click(function(){
	
	var id=$(this).attr('title');
			
			
		  $.ajax({
            url: "/RegistoAcademico/TabelaValores/"+id+"/edit",
            type: 'GET',
            success: function (data, textStatus, jqXHR) {
				$(".tabelaformshow").html(data);
				 $(".ListaItemDiv").fadeOut("slow");;
		  $(".TablelaAdicionar").fadeIn("slow");
		 
		  alert();
			}
				  });
		});
</script>

<script>
        $('#listadevalorestabela').DataTable( {
         

            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": false,
            "autoWidth": true,
            "lengthMenu": [[4,5, 10, 25, 50, -1], [4,5,10, 25, 50, "All"]],
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
                this.api().columns([0,2,4,]).every( function () {
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
		
</script>