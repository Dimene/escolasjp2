$('#example').DataTable( {

    dom: 'Bfrtip',
    buttons: [
        {
            extend: 'print',
            exportOptions: {
                columns: ':visible'
            }
        },
        'colvis'
    ],
    columnDefs: [ {
        targets: -1,
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
        this.api().columns([1,2,3,4,5,6]).every( function () {
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





