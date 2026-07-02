<span>Add Mais</span>
<div>
    <input value="{{ count($turma) }}" id="qtdadeitem">
    <table class="table table-light" id="listadosalunos">

        <thead>
            <tr>
                <th>Nome</th>

                @foreach ($disciplinaavalaicaotipo[$iddisciplia] as $dispv)
                    <th>
                        <span style="width: 10%;">{{ $dispv->nota_descricao }}</span>
                    </th>
                @endforeach

            </tr>

        </thead>
        <tbody>
            @foreach ($turma as $turmaItem)
                <tr>
                    <td>{{ $turmaItem['nome'] }}</td>
                    @foreach ($disciplinaavalaicaotipo[$iddisciplia] as $index => $dispv)
                        <td id="td{{ $index + 1 }}">


                            {{ $turmaItem['disciplinas'][$iddisciplia][$dispv->nota_meta_id] }}
                        </td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

{{--  modal para criarnota  --}}
<div id="fa-edit-tabela" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <center>
                    <h5> Editar Notas </h5>

                    <hr>

                    @foreach ($disciplinaavalaicaotipo[$iddisciplia] as $index => $dispv)
                        <button idprova="{{ $index + 1 }}" id="bt-prova"
                            style="background-color:rgba(100, 183, 255, 0.926)">
                            {{ $dispv->nota_descricao }}
                        </button>
                    @endforeach
                </center>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
        $('#listadosalunos').DataTable({
            dom: 'Bfrtip',

            buttons: [

                'colvis', 'copy', 'csv', 'excel', 'pdf', 'print'
            ],



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
                this.api().columns([1, 3, 4, 5]).every(function() {
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
    })
</script>
