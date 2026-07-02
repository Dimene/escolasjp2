@extends('layouts.admin-Lti')
@section('title', session()->get('formadepagamentos'))

@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Pagamentos</a></li>
                            <li class="breadcrumb-item active"> {{ session()->get('formadepagamentos') }} </li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">{{ session()->get('formadepagamentos') }} </h5>
                <div class="row">
                    <div class="col">
                        <?php $ano = 2019;
                        $CURENTyear = Date('y');
                        $mesid = Date('m');

                        $anoactual = '20' . $CURENTyear; ?>
                        <div class="form-group">
                            <label for="my-select">Selecione o Ano</label>
                            <select id="my-select" class="form-control  anoFrenquientado" name="Ano">

                                @foreach ($anolectivos as $ano)
                                    <option @if ($anoactual == $ano->anolectivo) selected @endif value="{{ $ano->id }}">
                                        {{ $ano->anolectivo }}</option>
                                @endforeach

                            </select>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <for="my-select">
                            {{ session()->get('formadepagamentos') }}


                            <select class="form-control Selectmes">
                                @foreach ($meses as $mesesItem)
                                    <option value="{{ $mesesItem->id }}"
                                        @if ($mesatual->id == $mesesItem->id) @selected(true) @endif>
                                        {{ $mesesItem->Descricao }} </option>
                                @endforeach



                            </select>
                        </div>
                    </div>
                </div>


                <div class="Tabela-de-mes">
                </div>
            </div>
        </div>




        <!-- /.row -->

        <!-- /.content -->
    </div>

    <!-- Modal pagar mensalidade -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog mensalidadeDialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Dados Do Aluno</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <label for=""><input type="checkbox" name="" id=""
                        class="btn btn-primary activar-todosmeses"> todos meses</label>
                <div class="modal-body ConteudoMensalidades"></div>
            </div>
        </div>
    </div>

    <!-- Modal Visualizar Mensalidades -->
    <div class="modal fade" id="Visializar-Mensalidades" tabindex="-1" role="dialog"
        aria-labelledby="Visializar-MensalidadesLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="Visializar-MensalidadesLabel"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body ConteudoMensalidadesVisualizar">...</div>
            </div>
        </div>
    </div>

    @push('script')
        <!-- JS do DataTables Responsive -->
        <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
        <!-- CSS do DataTables Responsive -->
        <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.dataTables.min.css">
        <!-- jQuery -->
        {{--  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>  --}}
        <!-- JS do DataTables -->
        {{--  <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>  --}}
        <!-- JS do DataTables Responsive -->
        <script src="{{ asset('Admin-LTE/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('Datatable/js/dataTables.responsive.min.js') }}"></script>

        </head>
        <script>
            $(document).ready(function() {
                var tabela2 =
                    $('#listadosalunos').DataTable({
                        dom: 'Bfrtip',

                        buttons: [

                            'colvis', 'copy', 'csv', 'excel', 'pdf', 'print'
                        ],

                        responsive: true,
                        columnDefs: [{
                                responsivePriority: 1,
                                targets: 0
                            },
                            {
                                responsivePriority: 2,
                                targets: 1
                            },
                            {
                                responsivePriority: 3,
                                targets: 2
                            },
                            {
                                responsivePriority: 4,
                                targets: 3
                            },
                            {
                                responsivePriority: 5,
                                targets: 4
                            },
                            {
                                responsivePriority: 6,
                                targets: 5
                            }
                        ],
                        columnDefs: [{
                            targets: [2, 8, 9, 10, 11],
                            visible: false
                        }],



                        "paging": true,
                        "lengthChange": true,
                        "searching": true,
                        "ordering": true,
                        "info": true,
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
                            this.api().columns([2, 4, 5, 6, 7, 11]).every(function() {
                                var column = this;
                                var select = $(
                                        '<select  class="SelectorSerach"><option value=""></option></select>'
                                    )
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
                                    select.append('<option value="' + d + '">' + d +
                                        '</option>')
                                });
                            });
                        }

                    });


                var tabela3 = $('#dadosAluno').DataTable({
                    dom: 'Bfrtip',

                    responsive: true,
                    columnDefs: [{
                            responsivePriority: 1,
                            targets: 0
                        },
                        {
                            responsivePriority: 2,
                            targets: 5
                        },
                        {
                            responsivePriority: 3,
                            targets: 2
                        },
                        {
                            responsivePriority: 4,
                            targets: 4
                        },
                        {
                            responsivePriority: 5,
                            targets: 3
                        },
                        {
                            responsivePriority: 6,
                            targets: 1
                        }
                    ],
                    "paging": true,
                    "lengthChange": true,
                    "searching": true,
                    "ordering": true,
                    "info": false,
                    "autoWidth": true,
                    "lengthMenu": [
                        [5, 10, 25, 50, -1],
                        [5, 10, 25, 50, "All"]
                    ],

                    language: {
                        "lengthMenu": "Visualizar _MENU_",
                        "zeroRecords": "Nada foi encontrado",
                        "info": "Mostrando página por página",
                        "processing": "Processando...",
                        "infoEmpty": "Nada encontrado",
                        "infoFiltered": "(filtrado de _MAX_ total de registros)",
                        "loadingRecords": "Carregando...",
                        "search": "Pesquisar:",
                        "paginate": {
                            "first": "Primeira",
                            "last": "Última",
                            "next": "Próxima",
                            "previous": "Anterior"
                        },
                    },
                    initComplete: function() {
                        this.api().columns([2, 3, 4, 5, 7]).every(function() {
                            var column = this;
                            var select = $(
                                    '<select class="SelectorSearch"><option value=""></option></select>'
                                )
                                .appendTo($(column.footer()).empty())
                                .on('change', function() {
                                    var val = $.fn.dataTable.util.escapeRegex($(this).val());
                                    column.search(val ? '^' + val + '$' : '', true, false)
                                        .draw();
                                });
                            column.data().unique().sort().each(function(d) {
                                select.append('<option value="' + d + '">' + d +
                                    '</option>')
                            });
                        });
                    }
                });


                var mes = $(".Selectmes").val();
                var ano = $(".anoFrenquientado").val();

                var $url = "/aluno/mensalidade/mes/" + mes + "/" + ano + "";

                var token = '{{ Session::token() }}';

                $.ajax({
                    url: $url,
                    type: 'GET',
                    beforeSend: function() {
                        $(".Tabela-de-mes").html(
                            ' <img src="{{ asset('imageproceaament/loading.gif') }}" style=" margin-left:500px;width:200px;height:200px">'
                        );
                    },





                    success: function(data, textStatus, jqXHR) {
                        $(".Tabela-de-mes").html(data);

                        var textoColuna5Linha = $('#listadosalunos tbody tr').eq(1).find('td').eq(8).text();

                        $.ajax({
                            url: '/aluno/mensalida/' + textoColuna5Linha + '/edit/',
                            type: 'GET',
                            success: function(data) {
                                $(".ConteudoMensalidadesVisualizar").html(data);
                                jQuery.noConflict();
                                $("#Visializar-Mensalidades").modal("show");
                            }

                        });
                    }


                });




                var mes = $(".Selectmes").val();
                var ano = $(".anoFrenquientado").val();
                $(".Selectmes,.anoFrenquientado").change(function() {
                    var mes = $('.Selectmes').val();
                    var ano = $(".anoFrenquientado").val();

                    var $url = "/aluno/mensalidade/mes/" + mes + "/" + ano + ""

                    var token = '{{ Session::token() }}';

                    $.ajax({
                        url: $url,
                        type: 'GET',

                        beforeSend: function() {
                            $(".Tabela-de-mes").html(
                                ' <img src="{{ asset('imageproceaament/loading.gif') }}" style=" margin-left:500px;width:200px;height:200px">'
                            );
                        },



                        success: function(data, textStatus, jqXHR) {

                            $(".Tabela-de-mes").html(data);
                        }


                    });
                });
            });
        </script>





        <!-- JavaScript -->
        <script>
            $(document).ready(function() {






                $(".activar-todosmeses").click(function() {
                    $.ajax({
                        url: "/aluno/mensalida/todosmeses/" + $("#idalunopagar").val(),
                        type: 'GET',
                        success: function(data) {
                            $(".mensalidadeDialog").addClass("modal-lg");
                            $(".ConteudoMensalidades").html(data);
                            jQuery.noConflict();
                            $("#exampleModal").modal("show");
                        }
                    });
                });

                $(".GuadarMensalidade").click(function() {
                    $("#idalunopagar").val($(this).attr('idaluno'));
                    $(".mensalidadeDialog").removeClass("modal-lg");
                    $.ajax({
                        url: '/aluno/mensalida/show/' + $(this).attr("idAluno") + '/' + $(this).attr(
                            "idmes"),
                        type: 'GET',
                        success: function(data) {
                            $(".ConteudoMensalidades").html(data);
                            jQuery.noConflict();
                            $("#exampleModal").modal("show");
                        }
                    });
                });

                $(".visualizar-mensalidades").click(function() {
                    $.ajax({
                        url: '/aluno/mensalida/' + $(this).attr("idAluno") + '/edit/',
                        type: 'GET',
                        success: function(data) {
                            $(".ConteudoMensalidadesVisualizar").html(data);
                            jQuery.noConflict();
                            $("#Visializar-Mensalidades").modal("show");
                        }
                    });
                });


            });



            $(document).ready(function() {


                $('#dadosAluno').DataTable({
                    dom: 'Bfrtip',
                    buttons: ['colvis', 'copy', 'csv', 'excel', 'pdf', 'print'],
                    responsive: true,
                    columnDefs: [{
                            responsivePriority: 1,
                            targets: 0
                        },
                        {
                            responsivePriority: 2,
                            targets: 5
                        },
                        {
                            responsivePriority: 3,
                            targets: 2
                        },
                        {
                            responsivePriority: 4,
                            targets: 4
                        },
                        {
                            responsivePriority: 5,
                            targets: 3
                        },
                        {
                            responsivePriority: 6,
                            targets: 1
                        }
                    ],
                    "paging": true,
                    "lengthChange": true,
                    "searching": true,
                    "ordering": true,
                    "info": false,
                    "autoWidth": true,
                    "lengthMenu": [
                        [5, 10, 25, 50, -1],
                        [5, 10, 25, 50, "All"]
                    ],

                    language: {
                        "lengthMenu": "Visualizar _MENU_",
                        "zeroRecords": "Nada foi encontrado",
                        "info": "Mostrando página por página",
                        "processing": "Processando...",
                        "infoEmpty": "Nada encontrado",
                        "infoFiltered": "(filtrado de _MAX_ total de registros)",
                        "loadingRecords": "Carregando...",
                        "search": "Pesquisar:",
                        "paginate": {
                            "first": "Primeira",
                            "last": "Última",
                            "next": "Próxima",
                            "previous": "Anterior"
                        },
                    },
                    initComplete: function() {
                        this.api().columns([2, 3, 4, 5, 7]).every(function() {
                            var column = this;
                            var select = $(
                                    '<select class="SelectorSearch"><option value=""></option></select>'
                                )
                                .appendTo($(column.footer()).empty())
                                .on('change', function() {
                                    var val = $.fn.dataTable.util.escapeRegex($(this).val());
                                    column.search(val ? '^' + val + '$' : '', true, false)
                                        .draw();
                                });
                            column.data().unique().sort().each(function(d) {
                                select.append('<option value="' + d + '">' + d +
                                    '</option>')
                            });
                        });
                    }
                });





            });
        </script>
    @endpush
@endsection
