<!-- Main content -->
<div class="content container-fluid" id="content">
    <div class="container-fluid">
        <div class="card">
            <div class="row">
                <div class="col my-3 py-3">
                    <div class="profile-block">
                        <h3>Dados do Aluno</h3>
                        <ul>
                            <li><span class="font-400"><b>Nome do Aluno:</b></span><span
                                    class="profile-right">{{ $aluno->nome }}</span></li>
                            <li><span class="font-400"><b>Sexo:</b></span><span
                                    class="profile-right">{{ $aluno->sexo }}</span></li>
                            <li><span class="font-400"><b>Idade:</b></span><span
                                    class="profile-right">{{ \Carbon\Carbon::now()->diffInYears(\Carbon\Carbon::createFromDate($aluno->dataNascimento)) }}</span>
                            </li>
                            <li><span class="font-400"><b>Tipo:</b></span><span
                                    class="profile-right">{{ $aluno->Tipo == 'B' ? 'Bolseiro' : 'Normal' }}</span></li>
                            <li><span class="font-400"><b>Ano Letivo:</b></span><span>{{ $aluno->anolectivo }}</span>
                            </li>
                            <li><span class="font-400"><b>Classe que Frequenta:</b></span><span
                                    class="profile-right">{{ $aluno->classe }}</span></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="no-shadow my-4 container-fluid">
                <center>
                    <h3><b>Situação das {{ session()->get('formadepagamentos') }} :</b></h3>
                </center>
                <table id="dadosAluno"
                    class="display no-shadow table table-light container-fluid display responsive nowrap"
                    style="width:100%">
                    <thead>
                        <tr>
                            <th>{{ session()->get('formadepagamentos') }}</th>
                            <th>Estado</th>
                            <th>Multa</th>
                            <th>Taxa Mensal</th>
                            <th>Total</th>
                            <th>Recibo</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $AnualMulta = 0;
                        $Anual = 0;
                        ?>
                        @foreach ($Valores_pago as $key => $Valores_pagoItem)
                            <?php
                            $valormensal = 0;
                            $valorMulta = 0;
                            if ($Valores_pagoItem->Estado == 'Pago') {
                                $valormensal = $Valores_pagoItem->valorDescricao;
                                $valorMulta = $Valores_pagoItem->Multa;
                                $AnualMulta += $valorMulta;
                                $Anual += $valormensal;
                            }
                            ?>
                            <tr>
                                <td>{{ $Valores_pagoItem->mes }}</td>
                                <td>{{ $Valores_pagoItem->Estado }}</td>
                                <td>{{ $valorMulta }},00MT</td>
                                <td>{{ $valormensal }},00MT</td>
                                <td>{{ $valorMulta + $valormensal }},00MT</td>
                                <td>
                                    @if ($valormensal > 0)
                                        <i class="fa fa-print print-mes-Especifo" aria-hidden="true"
                                            idaluno="{{ $aluno->Aluno_classe_id }}" idmes="{{ $key + 1 }}"></i>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Total</th>
                            <th></th>
                            <th>{{ $AnualMulta }},00MT</th>
                            <th>{{ $Anual }},00MT</th>
                            <th>{{ $AnualMulta + $Anual }},00MT</th>
                            <th></th>
                        </tr>
                    </tfoot>
                </table>
                <div class="form-group">
                    <input name="IdClasseAluno" value="{{ $aluno->Aluno_classe_id }}" type="hidden">
                    <table class="table table-light table-responsive container-fluid py-3 my-3 col-10">
                        <!-- Conteúdo da tabela aqui -->
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="container-fluid col-md-6">
        <a href="/aluno/mensalida/imprimir/{{ $aluno->Aluno_classe_id }}/1"
            class="button btn btn-primary buttonbaixar">Baixar em PDF</a>
        <button class="buttonImprimir btn btn-success" title="{{ $aluno->Aluno_classe_id }}">Imprimir</button>
    </div>
</div>


<link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
<!-- CSS do DataTables Responsive -->
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.dataTables.min.css">
<!-- jQuery -->

<script src="{{ asset('Datatable/js/jquery-3.5.1.js') }}"></script>
<script src="{{ asset('Datatable/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('Datatable/js/dataTables.responsive.min.js') }}"></script>
<script>
    $(".print-mes-Especifo").click(function() {
        $.ajax({
            url: "/aluno/mensalida/mes/imprimir/" + $(this).attr('idaluno') + "/" + $(this).attr(
                'idmes'),
            type: "get",
            success: function(data) {
                var tela_impressao = window.open('', '_blank');
                tela_impressao.document.write(data);
                tela_impressao.print();
                tela_impressao.close();
            }
        });
    });

    $(".buttonImprimir").click(function() {
        var id = $(this).attr("title");
        $.ajax({
            url: "/aluno/mensalida/imprimir/" + id + "/0",
            type: "GET",
            success: function(data) {
                var tela_impressao = window.open('', '_blank');
                tela_impressao.document.write(data);
                tela_impressao.print();
                tela_impressao.close();
            }
        });
    });

    $(document).ready(function() {


        $('#dadosAluno').DataTable({


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
            "paging": false,
            "lengthChange": false,
            "searching": false,
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
                this.api().columns([]).every(function() {
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
