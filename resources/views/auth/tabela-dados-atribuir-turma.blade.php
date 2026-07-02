<div class="row">
    <div class="Coluna1 col">
        <table class="table table-response" id="usuariosprofessores">
            <thead>
                <tr>
                    <th>Nr</th>
                    <th>Nome</th>

                    <th>Ac&ccedil;&atilde;o</th>
                </tr>
            </thead>
            <tbody>

                @foreach ($dfuncionarios as $key => $dfuncionariosItem)
                    <tr class="registocoluna colunaEspecifica{{ $dfuncionariosItem->id }}">
                        <td>
                            {{ $key + 1 }}
                        </td>
                        <td>{{ $dfuncionariosItem->name }}</td>

                        <td>

                            <a class="badge badge-primary addturmas" idprofessor="{{ $dfuncionariosItem->id }}">
                                <i data-dismiss="modal" data-toggle="modal" href="#model{{ $key }}"
                                    class="fa fa-lg fa-plus-circle"></i>
                            </a>
                            <a class="badge badge-primary funcionarioSelect "
                                funcionarioId="{{ $dfuncionariosItem->id }}" idprofessor="{{ $dfuncionariosItem->id }}">
                                <i data-dismiss="modal" data-toggle="modal" href="#model{{ $key }}"
                                    class="fa fa-lg fa-eye"></i>
                            </a>



                        </td>

                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="Coluna2">

    </div>

</div>


<script>
    jQuery.noConflict();
</script>
<script src="{{ asset('Datatable/js/jquery-3.5.1.js') }}"></script>
<script src="{{ asset('Datatable/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('Datatable/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('Datatable/js/buttons.flash.min.js') }}"></script>
<script src="{{ asset('Datatable/js/jszip.min.js') }}"></script>
<script src="{{ asset('Datatable/js/pdfmake.min.js') }}"></script>
<script src="{{ asset('Datatable/js/vfs_fonts.js') }}"></script>
<script src="{{ asset('Datatable/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('Datatable/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('Datatable/js/buttons.colVis.min.js') }}"></script>
<script src="https://unpkg.com/mathjs/lib/browser/math.js"></script>


<script>
    $(document).ready(function() {


        $(document).on('click', '.funcionarioSelect', function() {

            $(".Coluna1").addClass("col-md col-sm-12 ");
            $(".Coluna2").addClass("col-md col-sm-12 ");
            $id = $(this).attr('idprofessor');

            $(".registocoluna").css("background-color", "rgba(255, 255,255, 0.289)");
            $(".colunaEspecifica" + $id + "").css("background-color", "rgba(80, 80, 75, 0.289)");
            $.ajax({
                url: '/RegistoAcademico/turma/atriburi/professores/professoresselect/' + $id +
                    '/turma',
                type: 'Get',
                success: function(data) {
                    $(".Coluna2").html(data);
                    $id = $(this).attr('idprofessor');
                    $ano = $('[name = "Anolectivo_classe"]').val();
                    $idF = $('[name = "Anolectivo_classe"]').attr('idFuncionario');

                    $.ajax({
                        url: '/RegistoAcademico/turma/atriburi/' + $idF + '/' +
                            $ano + '/turma',
                        type: 'Get',
                        success: function(data) {
                            $(".conteudoTurmas").html(data);
                        }
                    });
                }
            });



        })


        $(document).on('change', '[name="Anolectivo_classe"]', function() {

            $(".Coluna1").addClass("co-md col-sm-12 ");
            $(".Coluna2").addClass("col-md col-sm-12 ");
            $id = $(this).attr('idprofessor');

            $.ajax({
                url: '/RegistoAcademico/turma/atriburi/' + $(this)
                    .attr('idFuncionario') + '/' + $(this).val() + '/turma',
                type: 'Get',
                success: function(data) {
                    $(".conteudoTurmas").html(data);
                }
            });

        })


        $('#usuariosprofessores').DataTable({


            "paging": true,
            "lengthChange": false,
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
                                .search(val ? '^' + val + '$' : '', true,
                                    false)
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



    function adicionarTurmasClasse($id) {
        $.ajax({
            url: "",
            type: 'Get',
            success: function(data) {

            }
        })
    }
</script>
