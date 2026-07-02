<!-- Inputs hidden para dados do formulário -->


@php
    use Illuminate\Support\Facades\Gate;
    use Illuminate\Support\Facades\Request;



     $descricao = trim($alunos->first()->tipodepagamentoDescricao ?? " ");
        $basePath = "aluno/pagament/$descricao";
        $isActive = Request::is("$basePath/efetuar", "$basePath/relatorio", "$basePath/relatoriogenerico");

        $canEfetuar = Gate::check("Efetuar-$descricao");
        $canVisualizar = Gate::check("Visualizar-$descricao");
        $canLista = Gate::check("Lista-$descricao");
        $canRelatorio = Gate::check("RelatorioPagameto-$descricao");
        $canGenerico = Gate::check("RelatorioGenerico-$descricao");

        $canAccess = $canEfetuar || $canVisualizar || $canLista || $canRelatorio || $canGenerico;
    @endphp





{{-- <input type="hidden" value="{{ $data }}" name="datas"> --}}
{{-- <input type="hidden" value="{{ $tipoPagamento }}" name="tipoPagamento"> --}}
<input type="hidden" value="" name="indexdados">
<input type="hidden" value="" name="indexlinha">

<!-- Tabela de alunos -->
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
          <table class="display no-shadow table table-light container-fluid display responsive

nowrap" style="width:100%" id="listadevalorestabela">
                <thead >
                    <tr>
                        <th class="text-center">Nr</th>
                        <th>Nome</th>
                        <th>turma</th>
                        <th>Estado</th>
                        @if( $canVisualizar|| $canEfetuar)
                        <th class="text-center">Ações</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @if(isset($alunos))
                        @foreach ($alunos as $key => $alunosItem)
                            <tr>
                                <td class="text-center">{{ $key + 1 }}</td>
                                <td>{{ $alunosItem->nome }}</td>
                                <td>{{ $alunosItem->turma }}</td>
                                <td>
                                       {{ $alunosItem->Estados }}

                                </td>
   @if($canEfetuar||$canVisualizar)
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm" role="group">
                                       @if($canEfetuar)
                                        <button type="button"
                                                class="btn btn-outline-primary GuadarOutrosPagamentos"
                                                idaluno="{{ $alunosItem->id }}"
                                                idmes="8"
                                                title="Pagar mensalidade">
                                            <i class="fa fa-upload"></i>
                                        </button>
                                        @endif
                                           @if( $canVisualizar)
                                        <button type="button"
                                                class="btn btn-outline-info visualizarOutrosPagamentos"
                                                title="Visualizar pagamentos"
                                                idaluno="{{ $alunosItem->id }}">
                                            <i class="fa fa-eye"></i>
                                        </button>
                                        @endif
                                    </div>


                                </td>
                                @endif
                            </tr>
                        @endforeach
                    @endif
                </tbody>
                <tfoot class="thead-light">
                    <tr>
                        <th class="text-center">Nr</th>
                        <th>Nome</th>
                        <th>turma</th>
                        <th>Estado</th>
   @if( $canVisualizar|| $canEfetuar)
                        <th class="text-center">Ações</th>
                        @endif
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<!-- Modal para pagar mensalidade -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="exampleModalLabel">Dados do Aluno</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body ConteudoMensalidades">
                <div class="text-center py-3">
                    <div class="spinner-border text-primary" role="status">
                        <span class="sr-only">Carregando...</span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>


<!-- Modal para visualizar mensalidades -->
<div class="modal fade" id="Visializar-Mensalidades" tabindex="-1" role="dialog" aria-labelledby="Visializar-MensalidadesLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="Visializar-MensalidadesLabel">Histórico de Pagamentos</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body ConteudoMensalidadesVisualizar">
                <div class="text-center py-4">
                    <div class="spinner-border text-info" role="status">
                        <span class="sr-only">Carregando...</span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="{{ asset('Datatable/js/dataTables.responsive.min.js') }}"></script>

{{-- <script src="{{ asset('Datatable/js/dataTables.responsive.min.js') }}"></script> --}}
<script>

     var tabela;
    $(document).ready(function() {

        $(".GuadarOutrosPagamentos").click(function(){
$(".Modal-pagamento").addClass("modal-lg");
 var indice = tabela.row($(this).closest('tr')).index()
 $("[name='indexlinha']").val(indice);
			 var btn = $(this);
            btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i>');

            $.ajax({
             url:'/RegistoAcademico/outrosPagamento/payrShow/'
             +$(this).attr("idAluno")+'/'
             +$("[name='datas']").val()+'/'
             +$("[name='tipoPagamento']").val()+'/'
             +$("[ name='flag']").val(),
              type:'GET',

              success: function (data, textStatus, jqXHR){
                 $(".ConteudoMensalidades").html(data);
                      jQuery.noConflict();
                 $("#exampleModal").modal("show");


             },
			 complete: function() {
                    btn.prop('disabled', false).html('<i class="fas fa-upload"></i>');
                }
         });
         });




// visualizar

$(".visualizarOutrosPagamentos").click(function(){
 var btn = $(this);
            btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i>');



            console.log($("[ name='flag']").val());

    $.ajax({
        url:'/RegistoAcademico/outrosPagamento/mostraasmensalidadesDotipo/'
        +$(this).attr("idAluno")+'/'+$("[name='tipoPagamento']").val()+'/'
        +$("[ name='flag']").val(),
         type:'GET',

         success: function (data, textStatus, jqXHR){
            $(".ConteudoMensalidadesVisualizar").html(data);
                 jQuery.noConflict();
            $("#Visializar-Mensalidades").modal("show");


        },
		complete: function() {
                    btn.prop('disabled', false).html('<i class="fas fa-eye"></i>');
                }
    });

    });



       tabela= $('#listadevalorestabela').DataTable({
           dom: 'Bfrtip',
        buttons: [
            {
                extend: 'copy',
                text: '<i class="fa fa-copy"></i> Copiar',
                className: 'btn btn-primary'
            },
            {
                extend: 'excel',
                text: '<i class="fa fa-file-excel"></i> Excel',
                className: 'btn btn-info'
            },
            {
                extend: 'pdf',
                text: '<i class="fa fa-file-pdf"></i> PDF',
                className: 'btn btn-danger'
            },
            {
                extend: 'print',
                text: '<i class="fa fa-print"></i> Imprimir',
                className: 'btn btn-success'
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
                this.api().columns([2]).every(function() {
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





// Adicionar evento de clique na tabela
$('#listadevalorestabela tbody').on('click', 'tr', function () {
    var rowIndex = tabela.row(this).index(); // Obtém o índice da linha clicada
    $('[name="indexdados"]').val(rowIndex);
});


    });


</script>
