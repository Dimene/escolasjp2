<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DataTable Responsivo</title>
    <!-- CSS do DataTables -->

<body>
    <div class="card">
        <div class="row">
            <div class="col-md-12">
                <form action="{{ Route('mensalidade.uplodefileCadastrofile') }}" class="col row" method="post"
                    enctype="multipart/form-data">
                    @method('post')
                    @csrf
                    <div class="custom-file col">
                        <input type="file" name="file" class="" id="exampleFile">
                        <label class="" for="exampleFile">Example label</label>
                    </div>
                    <div class="col">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="card-body">
            <table id="listadosalunos"
                class="display no-shadow table table-light container-fluid display responsive nowrap"
                style="width:100%">
                <thead>
                    <tr>

                        <th data-priority="7">Nr</th>
                        <th data-priority="1">Nome</th>
                        <th data-priority="6">Data</th>
                        <th data-priority="4">Classe</th>
                        <th data-priority="3">Turma</th>
                        <th data-priority="3">{{ $mes->Descricao }}</th>
                        <th data-priority="4">Preço</th>
                        <th data-priority="5">Multa</th>
                        <th data-priority="8">ID</th>
                        <th data-priority="9">Mês</th>
                        <th data-priority="10">Método Pagamento</th>
                        <th data-priority="11">Registado Por</th>
                        @if (Gate::check('Visualizar-Mensalidades') || Gate::check('Registar-Mensalidades'))
                            <th data-priority="2">Ações</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @for ($i = 0; $i < count($Aluno); $i++)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $Aluno[$i]->nome }}</td>
                            <td>{{ $Aluno[$i]->data_pagamento }}</td>
                            <td>{{ $Aluno[$i]->classe }}</td>
                            <td>{{ $Aluno[$i]->turma }}</td>
                            <td>{{ $Aluno[$i]->Estado }}</td>
                            <td>
                                @if ($Aluno[$i]->Estado == 'Pago')
                                    {{ $Aluno[$i]->valorDescricao }}
                                @endif
                            </td>
                            <td>{{ $Aluno[$i]->Multa }}</td>
                            <td>{{ $Aluno[$i]->idmensalidademes }}</td>
                            <td>{{ $Aluno[$i]->mes }}</td>
                            <td>{{ $Aluno[$i]->metodo_pagamento }}</td>
                            <td>{{ $Aluno[$i]->usuario_atualizou }}</td>
                            @if (Gate::check('Visualizar-Mensalidades') || Gate::check('Registar-Mensalidades'))
                                <td>
                                    @can('Registar-Mensalidades')
                                        <a class="btn btn-outline-primary GuadarMensalidade"
                                            idAluno="{{ $Aluno[$i]->aluno_classe_id }}" type="button"
                                            idmes="{{ $id }}" type="button"><i class="fa fa-upload"
                                                title="pagar mensalidade"></i></a>
                                    @endcan
                                    @can('Visualizar-Mensalidades')
                                        <a class="btn btn-primary visualizar-mensalidades" title="visualizar-mensalidades"
                                            idAluno="{{ $Aluno[$i]->aluno_classe_id }}" href="#"><i
                                                class="fa fa-eye"></i></a>
                                    @endcan
                                </td>
                            @endif
                        </tr>
                    @endfor
                </tbody>
                <tfoot>
                    <tr>
                        <th>Nr</th>
                        <th>Nome</th>
                        <th>Data</th>
                        <th>Classe</th>
                        <th>Turma</th>
                        <th>{{ $mes->Descricao }}</th>
                        <th>Preço</th>
                        <th>Multa</th>
                        <th>ID</th>
                        <th>Mês</th>
                        <th>Método Pagamento</th>
                        <th>registado por</th>
                        @if (Gate::check('Visualizar-Mensalidades') || Gate::check('Registar-Mensalidades'))
                            <th>Ações</th>
                        @endif
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <input value="" id="idalunopagar" type="hidden">



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
        });
    </script>
</body>

</html>
