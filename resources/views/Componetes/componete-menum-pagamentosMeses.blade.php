<!-- ABAS PRINCIPAIS -->

<style>
  /* Container pai para melhor integração */
.container-tabela {
    background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
    border-radius: 16px;
    position: relative;
}
 .dataTables_wrapper .dataTables_filter {
        display: none;
    }

  .card-custom {
    border: none;
    border-radius: 12px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
    overflow: hidden;
    background-color: #fff;
    margin-bottom: 20px;
}
.container-tabela::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, #3b82f6, #8b5cf6, #10b981);
    border-radius: 16px 16px 0 0;
}

/* Título integrado */
.titulo-tabela {
    font-size: 1.5rem;
    font-weight: 600;
    color: #1e293b;
    margin-bottom: 20px;
    padding-bottom: 15px;
    border-bottom: 2px solid #e2e8f0;
    display: flex;
    align-items: center;
    gap: 10px;
}

.titulo-tabela i {
    color: #3b82f6;
    font-size: 1.25rem;
}

</style>

@php
    use Illuminate\Support\Facades\Gate;
    use Illuminate\Support\Facades\Request;


        // DD( $tipospagamentos);



    @endphp

 @php
                $arrayposicaoTab1=[];
                $i=0;
            @endphp

<div class=" shadow-sm border-0">
    <div class=" bg-white pb-0">
        <ul class="nav nav-tabs nav-tabs-professional" role="tablist">
            @foreach ($tipo->unique('Descricao') as $index => $tipoItem)
                @php
                $tabId = Str::slug($tipoItem->Descricao);
                  $descricao = trim($tipoItem->Descricao);
         $basePath = "aluno/pagament/$descricao";
        $isActive = Request::is("$basePath/efetuar", "$basePath/relatorio", "$basePath/relatoriogenerico");

        $canEfetuar = Gate::check("Efetuar-$descricao");

        $canVisualizar = Gate::check("Visualizar-$descricao");
        $canLista = Gate::check("Lista-$descricao");
        $canRelatorio = Gate::check("RelatorioPagameto-$descricao");
        $canGenerico = Gate::check("RelatorioGenerico-$descricao");



        $canAccess = $canEfetuar || $canVisualizar || $canLista || $canRelatorio || $canGenerico;
         if ($canAccess):
$arrayposicaoTab1[$i]=$descricao;
$i=$i+1;
        endif;

                @endphp

    @if ($canAccess)
                <li class="nav-item">
                    <a class="nav-link menuNivel1 {{ $tipoItem->Descricao ===$arrayposicaoTab1[0] ? 'active' : '' }}"
                       data-toggle="tab"
                       href="#pane-{{ $tabId }}"
                       role="tab"
                       data-idtipo="{{ $tipoItem->id }}">
                        <i class="fa {{ $tipoItem->icon }} mr-2"></i>
                        {{ $tipoItem->Descricao }}
                    </a>
                </li>
            @endif
            @endforeach
        </ul>
    </div>

    <div class="">
        <div class="tab-content">
            @php
                $arrayposicao=[];
                $x=0;
            @endphp
            @foreach ($tipo->unique('Descricao') as $index => $tipoItem)

                @php
                $tabId = Str::slug($tipoItem->Descricao);
                  $descricao = trim($tipoItem->Descricao);
         $basePath = "aluno/pagament/$descricao";
        $isActive = Request::is("$basePath/efetuar", "$basePath/relatorio", "$basePath/relatoriogenerico");

        $canEfetuar = Gate::check("Efetuar-$descricao");

        $canVisualizar = Gate::check("Visualizar-$descricao");
        $canLista = Gate::check("Lista-$descricao");
        $canRelatorio = Gate::check("RelatorioPagameto-$descricao");
        $canGenerico = Gate::check("RelatorioGenerico-$descricao");


        $canAccess = $canEfetuar || $canVisualizar || $canLista || $canRelatorio || $canGenerico;

 if ($canAccess):
$arrayposicao[$x]=$descricao;
$x=$x+1;


        endif;

                    $tabId = Str::slug($tipoItem->Descricao);
                    $subItems = $tipo->where('Descricao', $tipoItem->Descricao)->sortBy('mes');
                @endphp
                @if($canAccess)
                <div class="tab-pane fade {{  $tipoItem->Descricao ===$arrayposicao[0]  ? 'show active' : '' }}"
                     id="pane-{{ $tabId }}" role="tabpanel">

                    <!-- SUB ABAS -->
                    <ul class="nav nav-pills nav-pills-soft mb-3">
                        @foreach ($subItems as $subIndex => $item2)
                            <li class="nav-item">
                                <a class="nav-link sub-aba {{ $subIndex === 0 ? 'active' : '' }}"
                                   data-toggle="tab"
                                   href="#subpane-{{ $tabId }}-{{ $item2->mes }}"
                                   role="tab"
                                   data-idtipo="{{ $tipoItem->id }}"
                                   data-idmes="{{ $item2->mes }}"
                                   data-mesdesc="{{ $item2->mesNome }}"
                                   data-idano="{{ $item2->anolectivo_id }}"
                                   data-tipodesc="{{$tipoItem->Descricao}}"
                                   data-idclasse="{{ $item2->classe_id }}">
                                   {{ $item2->mesNome }}
                                </a>
                            </li>
                        @endforeach
                    </ul>

                </div>
                @endif
            @endforeach
        </div>
    </div>
</div>

<!-- TABELA -->
<div class="container-tabela">
    <h4 class="titulo-tabela">
        <i class="fa fa-users"></i>
        Lista de pagamentos de <span class="tipopagamento"> </span>-<smol class="mespagamento" style=" font-weight: bold;"> </smol>
    </h4>

    <div class="mt-0 card-custom table-responsive ">
        <div class="input-group mb-3">
        <span class="input-group-text"><i class="fa fa-search"></i></span>
        <input type="text" id="searchFarmacos" class="form-control" placeholder="Pesquisar fármacos...">
    </div>
        <table id="listadevalorestabela" class="table display no-shadow table table-light table-hover" style="width:100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nome</th>
                    <th>Turma</th>
                    <th>Estado</th>
<th>Data Pagamento</th>
                    <th>Ações</th>

                </tr>
            </thead>



            <tbody>

            </tbody>
            <tfoot>
                <tr>
                    <th>#</th>
                    <th>Nome</th>
                    <th>Turma</th>
                    <th>Estado</th>
                    <th>Data Pagamento</th>
                    <th>Ações</th>

                </tr>
            </tfoot>


        </table>
    </div>
</div>

<!-- JAVASCRIPT CORRIGIDO -->
<script>
(function() {
    let historicoAbas = {};

    function carregarDados(idtipo, idmes, idano, idclasse, mesNome, tipoDesc) {
        if (typeof window.atualizarDadosTabela === 'function') {
            window.atualizarDadosTabela(idtipo, idmes, idano, idclasse);
        } else {
            console.log('Atualizar tabela ->', idtipo, idmes, idano, idclasse);
        }

        // Atualiza os textos dos spans
        $(".tipopagamento").text(tipoDesc);
        $(".mespagamento").text(mesNome);
        console.log("Texto atualizado:", mesNome, tipoDesc);
    }

    // Clique em SUB-ABA (meses)
    $(document).on('click', '.sub-aba', function(e) {
        e.preventDefault();
        e.stopPropagation();

        const $subTab = $(this);
        const idtipo = $subTab.data('idtipo');
        const idmes = $subTab.data('idmes');
        const idano = $subTab.data('idano');
        const mesNome = $subTab.data('mesdesc');  // Note: mesdesc em minúsculas
        const tipoDesc = $subTab.data('tipodesc'); // Note: tipodesc em minúsculas
        const idclasse = $subTab.data('idclasse');

        // Remove active de todas as sub-abas do mesmo grupo
        $subTab.closest('.nav-pills').find('.sub-aba').removeClass('active');
        // Adiciona active à sub-aba clicada
        $subTab.addClass('active');

        // Salva histórico da aba principal
        historicoAbas[idtipo] = { idmes, idano, idclasse, mesNome, tipoDesc };

        // Atualiza tabela
        carregarDados(idtipo, idmes, idano, idclasse, mesNome, tipoDesc);
    });

    // Clique em ABA PRINCIPAL
    $(document).on('click', '.menuNivel1', function(e) {
        e.preventDefault();

        const $aba = $(this);
        const idtipo = $aba.data('idtipo');

        // Remove active de todas as abas principais
        $('.menuNivel1').removeClass('active');
        // Adiciona active à aba clicada
        $aba.addClass('active');

        // Ativa o painel correspondente
        const target = $aba.attr('href');
        $('.tab-pane').removeClass('show active');
        $(target).addClass('show active');

        // Agora ativa a sub-aba correta
        ativarSubAbaDoGrupo(idtipo, target);
    });

    // Função para ativar a sub-aba correta do grupo
    function ativarSubAbaDoGrupo(idtipo, targetPane) {
        const pane = $(targetPane);
        let $subTabAtiva = null;

        // 1. Verifica se há histórico para esta aba principal
        if (historicoAbas[idtipo]) {
            const historico = historicoAbas[idtipo];
            $subTabAtiva = pane.find(`.sub-aba[data-idmes='${historico.idmes}']`);
        }

        // 2. Se não encontrou histórico, usa a primeira sub-aba
        if (!$subTabAtiva || $subTabAtiva.length === 0) {
            $subTabAtiva = pane.find('.sub-aba').first();
        }

        // 3. Se encontrou uma sub-aba válida, ativa-a
        if ($subTabAtiva && $subTabAtiva.length > 0) {
            // Remove active de todas as sub-abas do grupo
            pane.find('.sub-aba').removeClass('active');
            // Adiciona active à sub-aba selecionada
            $subTabAtiva.addClass('active');

            // Pega os dados da sub-aba
            const idmes = $subTabAtiva.data('idmes');
            const idano = $subTabAtiva.data('idano');
            const idclasse = $subTabAtiva.data('idclasse');
            const mesNome = $subTabAtiva.data('mesdesc');
            const tipoDesc = $subTabAtiva.data('tipodesc');

            // Atualiza o histórico
            historicoAbas[idtipo] = { idmes, idano, idclasse, mesNome, tipoDesc };

            // Atualiza tabela
            carregarDados(idtipo, idmes, idano, idclasse, mesNome, tipoDesc);
        }
    }

    // Inicialização da página
    $(document).ready(function() {
        // Ativa a primeira aba principal automaticamente
        const $primeiraAba = $('.menuNivel1.active');
        if ($primeiraAba.length > 0) {
            const idtipo = $primeiraAba.data('idtipo');
            const target = $primeiraAba.attr('href');

            // Ativa a primeira sub-aba da primeira aba principal
            ativarSubAbaDoGrupo(idtipo, target);
        }
    });

})();


$('#searchFarmacos').on('keyup', function() {
    var searchValue = this.value;

    // Iterar sobre todas as instâncias de DataTable
    $.each($.fn.dataTable.tables(true), function() {
        $(this).DataTable().search(searchValue).draw();
    });
});

</script>
