
  $(function () {
    $("#example1").DataTable();
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
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
    });
  });
