@extends('layouts.admin-Lti')
@section('title','- Relatório da Loja')
@section('content')

<section class="content">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ Route('produto.index') }}">
                <span>Estoque</span>
            </a>
        </li>
        <li class="breadcrumb-item active">
            <a><span><b>Relatório</b></span></a>
        </li>
    </ol>
</section>

<div class="container-fluid col-12" style="background:#fff; border-radius:10px; padding:20px;">

    {{-- FILTROS DE PESQUISA --}}
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="form-group">
                <label><strong>Dados do Fornecedor</strong></label>
                <select class="form-control compraIdShow select2" style="width: 100%;" name="Compra">
                    <optgroup class="CompraSelet">
                        <option value="0">Todas as faturas</option>
                        @foreach ($compra as $compraItem)
                            <option value="{{ $compraItem->id }}">
                                {{ $compraItem->Codigo_Fatura }}
                            </option>
                        @endforeach
                    </optgroup>
                </select>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label><strong>Categoria de Fármacos</strong></label>
                <div class="select2-purple">
                    <select class="select2 CategoriaFarmacos" multiple="multiple" name="Categoria[]"
                            data-placeholder="Selecione as categorias"
                            data-dropdown-css-class="select2-purple" style="width: 100%;">
                        @foreach ($categora as $categoraItem)
                            <option value="{{ $categoraItem->id }}">
                                {{ $categoraItem->Descricao }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>

    {{-- TABS MELHORADAS --}}
    <ul class="nav nav-tabs" id="relatorioTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="vendas-tab" data-bs-toggle="tab"
                    data-bs-target="#vendas" type="button" role="tab"
                    aria-controls="vendas" aria-selected="true">
                <i class="fas fa-shopping-cart"></i> Vendas
                <span class="badge bg-primary ms-1" id="vendasBadge">0</span>
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="estoque-tab" data-bs-toggle="tab"
                    data-bs-target="#estoque" type="button" role="tab"
                    aria-controls="estoque" aria-selected="false">
                <i class="fas fa-boxes"></i> Estoque
                <span class="badge bg-info ms-1" id="estoqueBadge">0</span>
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="faturacao-tab" data-bs-toggle="tab"
                    data-bs-target="#faturacao" type="button" role="tab"
                    aria-controls="faturacao" aria-selected="false">
                <i class="fas fa-file-invoice"></i> Faturação
                <span class="badge bg-success ms-1" id="faturacaoBadge">0</span>
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="iva-tab" data-bs-toggle="tab"
                    data-bs-target="#iva" type="button" role="tab"
                    aria-controls="iva" aria-selected="false">
                <i class="fas fa-percent"></i> IVA
                <span class="badge bg-warning ms-1" id="ivaBadge">0</span>
            </button>
        </li>
    </ul>

    {{-- CONTEÚDO DAS TABS --}}
    <div class="tab-content mt-3" id="relatorioTabsContent">

        {{-- TAB VENDAS --}}
        <div class="tab-pane fade show active" id="vendas" role="tabpanel" aria-labelledby="vendas-tab">
            <div class="card">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-shopping-cart"></i> Histórico de Vendas</h5>
                    <div>
                        <span class="badge bg-light text-dark me-2" id="totalVendas">0 vendas</span>
                        <button class="btn btn-sm btn-light" onclick="window.print()">
                            <i class="fas fa-print"></i> Imprimir
                        </button>
                    </div>
                </div>
                <div class="card-body" id="elementosSlectCompra">
                    {{-- Conteúdo carregado via AJAX --}}
                    <div class="text-center py-5">
                        <i class="fas fa-spinner fa-spin fa-3x text-primary"></i>
                        <p class="mt-3">Carregando dados...</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- TAB ESTOQUE --}}
        <div class="tab-pane fade" id="estoque" role="tabpanel" aria-labelledby="estoque-tab">
            <div class="card">
                <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-boxes"></i> Gestão de Estoque</h5>
                    <span class="badge bg-light text-dark">Produtos em stock</span>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover" id="tabelaEstoque">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Produto</th>
                                    <th>Categoria</th>
                                    <th class="text-center">Quantidade</th>
                                    <th class="text-end">Preço Compra</th>
                                    <th class="text-end">Preço Venda</th>
                                    <th class="text-end">Valor Total</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $totalEstoque = 0; @endphp
                                @forelse ($produtos ?? [] as $produto)
                                    @php
                                        $qtde = $produto->quantidade ?? 0;
                                        $precoVenda = $produto->preco_venda ?? 0;
                                        $totalEstoque += $qtde * $precoVenda;
                                    @endphp
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $produto->nome ?? 'N/A' }}</td>
                                        <td>{{ $produto->categoria->Descricao ?? 'N/A' }}</td>
                                        <td class="text-center">
                                            <span class="badge {{ $qtde > 10 ? 'bg-success' : ($qtde > 5 ? 'bg-warning' : 'bg-danger') }}">
                                                {{ $qtde }}
                                            </span>
                                        </td>
                                        <td class="text-end">{{ number_format($produto->preco_compra ?? 0, 2) }} MZN</td>
                                        <td class="text-end">{{ number_format($precoVenda, 2) }} MZN</td>
                                        <td class="text-end">{{ number_format($qtde * $precoVenda, 2) }} MZN</td>
                                        <td>
                                            @if($qtde > 10)
                                                <span class="badge bg-success">Stock Alto</span>
                                            @elseif($qtde > 5)
                                                <span class="badge bg-warning">Stock Médio</span>
                                            @elseif($qtde > 0)
                                                <span class="badge bg-danger">Stock Baixo</span>
                                            @else
                                                <span class="badge bg-secondary">Esgotado</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center text-muted py-4">
                                            <i class="fas fa-box-open fa-2x d-block mb-2"></i>
                                            Nenhum produto em estoque
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                            <tfoot>
                                <tr class="table-info font-weight-bold">
                                    <td colspan="6" class="text-end">VALOR TOTAL DO ESTOQUE:</td>
                                    <td class="text-end">{{ number_format($totalEstoque, 2) }} MZN</td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- TAB FATURAÇÃO --}}
        <div class="tab-pane fade" id="faturacao" role="tabpanel" aria-labelledby="faturacao-tab">
            <div class="card">
                <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-file-invoice"></i> Resumo de Faturação</h5>
                    <span class="badge bg-light text-dark">Período atual</span>
                </div>
                <div class="card-body">
                    @php
                        $totalVendas = 0;
                        $totalProdutosVendidos = 0;
                        $totalFaturado = 0;
                        $totalLucro = 0;
                    @endphp

                    @foreach ($dados ?? [] as $venda)
                        @php
                            $totalVendas++;
                            foreach ($venda->produto as $item) {
                                $qtde = $item->qunatidade ?? 0;
                                $preco = $item->produtos->produto_compra->preco_venda ?? 0;
                                $compra = $item->produtos->produto_compra->preco_compra ?? 0;
                                $totalProdutosVendidos += $qtde;
                                $totalFaturado += $qtde * $preco;
                                $totalLucro += $qtde * ($preco - $compra);
                            }
                        @endphp
                    @endforeach

                    {{-- CARDS RESUMO --}}
                    <div class="row mb-4">
                        <div class="col-md-3 col-6">
                            <div class="card bg-primary text-white">
                                <div class="card-body text-center">
                                    <h6 class="text-white-50">Total Vendas</h6>
                                    <h3 class="mb-0">{{ $totalVendas }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="card bg-info text-white">
                                <div class="card-body text-center">
                                    <h6 class="text-white-50">Produtos Vendidos</h6>
                                    <h3 class="mb-0">{{ $totalProdutosVendidos }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="card bg-success text-white">
                                <div class="card-body text-center">
                                    <h6 class="text-white-50">Total Faturado</h6>
                                    <h3 class="mb-0">{{ number_format($totalFaturado, 0) }} MZN</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="card {{ $totalLucro >= 0 ? 'bg-warning' : 'bg-danger' }} text-white">
                                <div class="card-body text-center">
                                    <h6 class="text-white-50">Lucro Total</h6>
                                    <h3 class="mb-0">{{ number_format($totalLucro, 0) }} MZN</h3>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- TABELA DETALHADA --}}
                    <div class="table-responsive">
                        <table class="table table-striped table-hover" id="tabelaFaturacao">
                            <thead>
                                <tr>
                                    <th>Venda #</th>
                                    <th>Data</th>
                                    <th>Cliente</th>
                                    <th>Tipo</th>
                                    <th class="text-end">Total</th>
                                    <th class="text-end">Lucro</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($dados ?? [] as $venda)
                                    @php
                                        $totalVenda = 0;
                                        $lucroVenda = 0;
                                        foreach ($venda->produto as $item) {
                                            $qtde = $item->qunatidade ?? 0;
                                            $preco = $item->produtos->produto_compra->preco_venda ?? 0;
                                            $compra = $item->produtos->produto_compra->preco_compra ?? 0;
                                            $totalVenda += $qtde * $preco;
                                            $lucroVenda += $qtde * ($preco - $compra);
                                        }
                                    @endphp
                                    <tr>
                                        <td><strong>#{{ $venda->id }}</strong></td>
                                        <td>{{ $venda->created_at->format('d/m/Y H:i') ?? 'N/A' }}</td>
                                        <td>{{ $venda->cliente->nome ?? 'Consumidor Final' }}</td>
                                        <td>{{ $venda->TipodeVenda ?? 'N/A' }}</td>
                                        <td class="text-end">{{ number_format($totalVenda, 2) }} MZN</td>
                                        <td class="text-end {{ $lucroVenda >= 0 ? 'text-success' : 'text-danger' }}">
                                            {{ number_format($lucroVenda, 2) }} MZN
                                        </td>
                                        <td>
                                            <span class="badge bg-success">Concluída</span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-muted py-4">
                                            <i class="fas fa-receipt fa-2x d-block mb-2"></i>
                                            Nenhuma venda registrada
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- TAB IVA --}}
        <div class="tab-pane fade" id="iva" role="tabpanel" aria-labelledby="iva-tab">
            <div class="card">
                <div class="card-header bg-warning text-dark d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-percent"></i> Gestão de IVA</h5>
                    <span class="badge bg-dark text-white">Taxa: 17%</span>
                </div>
                <div class="card-body">
                    @php
                        $taxaIva = 17;
                        $totalSemIva = 0;
                        $totalIva = 0;
                        $totalComIva = 0;
                    @endphp

                    @foreach ($dados ?? [] as $venda)
                        @foreach ($venda->produto as $item)
                            @php
                                $precoVenda = $item->produtos->produto_compra->preco_venda ?? 0;
                                $qtde = $item->qunatidade ?? 0;
                                $valor = $qtde * $precoVenda;
                                $iva = ($valor * $taxaIva) / 100;
                                $semIva = $valor - $iva;

                                $totalSemIva += $semIva;
                                $totalIva += $iva;
                                $totalComIva += $valor;
                            @endphp
                        @endforeach
                    @endforeach

                    {{-- CARDS IVA --}}
                    <div class="row mb-4">
                        <div class="col-md-3 col-6">
                            <div class="card bg-info text-white">
                                <div class="card-body text-center">
                                    <h6 class="text-white-50">Base de Cálculo</h6>
                                    <h4 class="mb-0">{{ number_format($totalSemIva, 2) }} MZN</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="card bg-primary text-white">
                                <div class="card-body text-center">
                                    <h6 class="text-white-50">Taxa IVA</h6>
                                    <h4 class="mb-0">{{ $taxaIva }}%</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="card bg-warning text-dark">
                                <div class="card-body text-center">
                                    <h6 class="text-dark-50">Valor IVA</h6>
                                    <h4 class="mb-0">{{ number_format($totalIva, 2) }} MZN</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="card bg-success text-white">
                                <div class="card-body text-center">
                                    <h6 class="text-white-50">Total com IVA</h6>
                                    <h4 class="mb-0">{{ number_format($totalComIva, 2) }} MZN</h4>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- TABELA IVA --}}
                    <div class="table-responsive">
                        <table class="table table-striped table-hover" id="tabelaIva">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Produto</th>
                                    <th>Qtd</th>
                                    <th class="text-end">Base sem IVA</th>
                                    <th class="text-center">Taxa</th>
                                    <th class="text-end">Valor IVA</th>
                                    <th class="text-end">Total com IVA</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($dados ?? [] as $venda)
                                    @foreach ($venda->produto as $item)
                                        @php
                                            $precoVenda = $item->produtos->produto_compra->preco_venda ?? 0;
                                            $qtde = $item->qunatidade ?? 0;
                                            $valor = $qtde * $precoVenda;
                                            $iva = ($valor * $taxaIva) / 100;
                                            $semIva = $valor - $iva;
                                        @endphp
                                        <tr>
                                            <td>{{ $loop->parent->iteration ?? $loop->iteration }}</td>
                                            <td>{{ $item->produtos->produto_compra->produtos->nome ?? 'N/A' }}</td>
                                            <td class="text-center">{{ $qtde }}</td>
                                            <td class="text-end">{{ number_format($semIva, 2) }} MZN</td>
                                            <td class="text-center">{{ $taxaIva }}%</td>
                                            <td class="text-end text-success">{{ number_format($iva, 2) }} MZN</td>
                                            <td class="text-end text-primary">{{ number_format($valor, 2) }} MZN</td>
                                        </tr>
                                    @endforeach
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-muted py-4">
                                            <i class="fas fa-calculator fa-2x d-block mb-2"></i>
                                            Nenhum dado para calcular IVA
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                            <tfoot>
                                <tr class="table-warning font-weight-bold">
                                    <td colspan="3" class="text-end">TOTAIS:</td>
                                    <td class="text-end">{{ number_format($totalSemIva, 2) }} MZN</td>
                                    <td class="text-center">{{ $taxaIva }}%</td>
                                    <td class="text-end">{{ number_format($totalIva, 2) }} MZN</td>
                                    <td class="text-end">{{ number_format($totalComIva, 2) }} MZN</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

{{-- SCRIPTS --}}
@push('script')
<script src="{{ asset('Datatable/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('Datatable/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('Datatable/js/buttons.flash.min.js') }}"></script>
<script src="{{ asset('Datatable/js/jszip.min.js') }}"></script>
<script src="{{ asset('Datatable/js/pdfmake.min.js') }}"></script>
<script src="{{ asset('Datatable/js/vfs_fonts.js') }}"></script>
<script src="{{ asset('Datatable/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('Datatable/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('Datatable/js/buttons.colVis.min.js') }}"></script>

<script>
var urlcreate = '{{ Route('RelatorioSaldo.create2') }}';
var urlstore = '{{ Route('fornecedor.store') }}';
var token = '{{ Session::token() }}';

$(document).ready(function(){

    // INICIALIZAR TABS
    inicializarTabs();

    // CARREGAR DADOS INICIAIS
    carregarDadosVendas($("form").serialize());

    // EVENTOS DOS FILTROS
    $(".compraIdShow").change(function(){
        carregarDadosVendas($("form").serialize());
    });

    $(".CategoriaFarmacos").change(function(){
        carregarDadosVendas($("form").serialize());
    });

    // DATATABLE
    $('#listaprodutos').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": false,
        "autoWidth": true,
        "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]],
        language: {
            "lengthMenu": "visualizar _MENU_ ",
            "zeroRecords": "Nada foi encontrado",
            "info": "mostrar página por página",
            "processing": "processando..",
            "infoEmpty": "Nada tem ",
            "infoFiltered": "(filtrado de _MAX_ registros)",
            "loadingRecords": "processando...",
            "search": "pesquisar:",
            "paginate": {
                "first": "primeira",
                "last": "última",
                "next": "próxima",
                "previous": " Anterior"
            }
        }
    });

    // ATUALIZAR BADGES
    atualizarBadges();
});

// FUNÇÃO PARA INICIALIZAR TABS
function inicializarTabs() {
    // Ativar tabs com Bootstrap 4/5
    $('#relatorioTabs button').on('click', function(e) {
        e.preventDefault();
        $(this).tab('show');
    });

    // Persistência da tab ativa
    var activeTab = localStorage.getItem('activeRelatorioTab');
    if (activeTab) {
        $('#relatorioTabs button[data-bs-target="' + activeTab + '"]').tab('show');
    }

    // Guardar tab ativa
    $('#relatorioTabs button').on('shown.bs.tab', function(e) {
        var target = $(e.target).attr('data-bs-target');
        localStorage.setItem('activeRelatorioTab', target);
    });
}

// FUNÇÃO PARA CARREGAR DADOS DAS VENDAS
function carregarDadosVendas(dadosForm) {
    $('#elementosSlectCompra').html(`
        <div class="text-center py-5">
            <i class="fas fa-spinner fa-spin fa-3x text-primary"></i>
            <p class="mt-3">Carregando dados...</p>
        </div>
    `);

    $.ajax({
        url: urlcreate,
        type: 'GET',
        data: dadosForm,
        success: function(data) {
            $('#elementosSlectCompra').html(data);
            atualizarBadges();

            // Re-inicializar DataTables se necessário
            if ($.fn.DataTable.isDataTable('#tabelaVendas')) {
                $('#tabelaVendas').DataTable().destroy();
            }
            // Inicializar nova tabela
            $('#tabelaVendas').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": false,
                "autoWidth": true,
                "language": {
                    "lengthMenu": "visualizar _MENU_ ",
                    "zeroRecords": "Nada foi encontrado",
                    "info": "mostrar página por página",
                    "processing": "processando.."
                }
            });
        },
        error: function() {
            $('#elementosSlectCompra').html(`
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle"></i>
                    Erro ao carregar dados. Tente novamente.
                </div>
            `);
        }
    });
}

// FUNÇÃO PARA ATUALIZAR BADGES
function atualizarBadges() {
    // Contar itens em cada tab
    var totalVendas = $('#tabelaVendas tbody tr').length || 0;
    var totalEstoque = $('#tabelaEstoque tbody tr:not(:empty)').length || 0;
    var totalFaturacao = $('#tabelaFaturacao tbody tr:not(:empty)').length || 0;
    var totalIva = $('#tabelaIva tbody tr:not(:empty)').length || 0;

    $('#vendasBadge').text(totalVendas);
    $('#estoqueBadge').text(totalEstoque);
    $('#faturacaoBadge').text(totalFaturacao);
    $('#ivaBadge').text(totalIva);
    $('#totalVendas').text(totalVendas + ' vendas');
}

// FUNÇÃO PARA GUARDAR PRODUTO
function guadar_produto_funct() {
    $('.Guardar_produto').click(function(e) {
        $("[name='FornecedorAdd']").val($("[name='Fornecedor']").val());
    });
}
</script>
@endpush

@endsection
