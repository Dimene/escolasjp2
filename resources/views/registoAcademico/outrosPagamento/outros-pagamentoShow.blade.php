{{-- Inputs hidden para dados do formulário --}}

@php
    use Illuminate\Support\Facades\Gate;
    use Illuminate\Support\Facades\Request;

    $descricao = trim($alunos->first()->tipodepagamentoDescricao ?? " ");
    $basePath = "aluno/pagament/$descricao";
    $isActive = Request::is("$basePath/efetuar", "$basePath/relatorio", "$basePath/relatoriogenerico");

    $canEfetuar   = Gate::check("Efetuar-$descricao");
    $canVisualizar = Gate::check("Visualizar-$descricao");
    $canLista     = Gate::check("Lista-$descricao");
    $canRelatorio = Gate::check("RelatorioPagameto-$descricao");
    $canGenerico  = Gate::check("RelatorioGenerico-$descricao");

    $canAccess = $canEfetuar || $canVisualizar || $canLista || $canRelatorio || $canGenerico;
@endphp

<input type="hidden" value="" name="indexdados">
<input type="hidden" value="" name="indexlinha">

<!-- Indicador de carregamento da tabela -->
<div id="tabelaCarregamento" hidden class="text-center p-2">
    <i class="fas fa-spinner fa-spin"></i> Carregando dados...
</div>

<!-- Tabela de alunos -->
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="display no-shadow table table-light container-fluid display responsive nowrap"
                   style="width:100%" id="listadevalorestabela">
                <thead>
                    <tr>
                        <th class="text-center">Nr</th>
                        <th>Nome</th>
                        <th>Turma</th>
                        <th>Estado</th>
                        <th class="text-center">Data Pagamento</th>
                        @if($canVisualizar || $canEfetuar)
                        <th class="text-center">Ações</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    {{-- Tabela populada via AJAX por atualizarDadosTabela() --}}
                </tbody>
                <tfoot class="thead-light">
                    <tr>
                        <th class="text-center"></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        @if($canVisualizar || $canEfetuar)
                        <th class="text-center"></th>
                        @endif
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<!-- Modal para pagar mensalidade -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
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

<!-- DataTables + Buttons -->
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="{{ asset('Datatable/js/dataTables.responsive.min.js') }}"></script>

{{-- ⚠️ NÃO colocar inicialização de DataTable aqui — ela é feita no JS externo --}}