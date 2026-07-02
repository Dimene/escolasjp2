@php
$request = Request();
$host = $request->getHost();
$subdomain = explode('.', $host)[0];

// Agrupar alunos por estado
$alunosPorEstado = [];

foreach ($retornoAlunos as $aluno) {

    $estado = ($aluno->TIPOSAIDAa == null)
        ? 'activo'
        : $aluno->TIPOSAIDAa;

    if (!isset($alunosPorEstado[$estado])) {
        $alunosPorEstado[$estado] = [];
    }

    $alunosPorEstado[$estado][] = $aluno;
}

// Ordenar estados
uksort($alunosPorEstado, function($a, $b) {

    if ($a === 'activo') return -1;
    if ($b === 'activo') return 1;

    return strcmp($a, $b);
});
@endphp

<div class="conteudo_tabela  card "  style="border-bottom: 3px solid #007bff;"

>

    <div class="row mb-3 p-3">

        <div class="col-md-8">
    <div class="input-group">
        <input
            type="text"
            id="searchFarmacos"
            class="form-control form-control-lg"
            placeholder="Pesquisar em todas as abas..."
            style="border-right: none; border-radius: 8px 0 0 8px;"
        >
        <div class="input-group-append">
            <span class="input-group-text bg-white" style="border-left: none; border-radius: 0 8px 8px 0; cursor: pointer;">
                <i class="fa fa-search text-primary"></i>
            </span>
        </div>
    </div>
</div>

<style>
    #searchFarmacos:focus {
        box-shadow: none;
        border-color: #ced4da;
        
        
    }
    
    .input-group-text:hover i {
        transform: scale(1.1);
        transition: transform 0.2s ease;
    }
</style>
        @can('Atualizar-matricula-Excel')
        <div class="col-md-4 text-right">

            <button
                type="button"
                class="btn btn-primary"
                data-toggle="modal"
                data-target="#modalUploadAlunos"
            >
                <i class="fa fa-upload"></i>
                Importar Alunos
            </button>

        </div>
        @endcan

    </div>



    {{-- ================================= --}}
    {{-- TABS --}}
    {{-- ================================= --}}

    <ul class="nav nav-tabs" id="estadoTabs" role="tablist">

        @foreach($alunosPorEstado as $estado => $alunos)

            @php

                $isAtivo = ($estado === 'activo');

                $slug = Str::slug($estado);

                $tabId = "tab-{$slug}";
                $contentId = "content-{$slug}";
                $tableId = "table-{$slug}";

            @endphp

            <li class="nav-item">

                <a
                    class="nav-link {{ $isAtivo ? 'active' : '' }}"
                    id="{{ $tabId }}"
                    data-toggle="tab"
                    href="#{{ $contentId }}"
                    role="tab"
                    aria-controls="{{ $contentId }}"
                    aria-selected="{{ $isAtivo ? 'true' : 'false' }}"
                >

                    <i class="fa fa-{{ $estado == 'activo' ? 'check-circle' : 'times-circle' }}"></i>

                    {{ ucfirst($estado) }}

                    <span class="badge badge-pill {{ $isAtivo ? 'badge-primary' : 'badge-secondary' }} badge-count">
                        {{ count($alunos) }}
                    </span>

                </a>

            </li>

        @endforeach

    </ul>

    {{-- ================================= --}}
    {{-- CONTEUDO DAS TABS --}}
    {{-- ================================= --}}

    <div class="tab-content mt-3 " id="estadoTabsContent">

        @foreach($alunosPorEstado as $estado => $alunos)

            @php

                $isAtivo = ($estado === 'activo');

                $slug = Str::slug($estado);

                $contentId = "content-{$slug}";
                $tableId = "table-{$slug}";

            @endphp

            <div
                class="tab-pane fade {{ $isAtivo ? 'show active' : '' }}"
                id="{{ $contentId }}"
                role="tabpanel"
                aria-labelledby="tab-{{ $slug }}"
            >

                <div class="table-responsive">

                    <table
                        id="{{ $tableId }}"
                        class="table  table-striped tabelaEstado"
                        width="100%"
                    >

                        <thead>

                         <th>#</th>
<th>Nome</th>
<th>Sexo</th>
<th>Idade</th>
<th>Classe</th>
<th>turma</th>
<th>Endere&ccedil;o</th>
<th>Data.Insc</th>
<th>Estado</th>

@if(
    Gate::check('Modificar-Estado') ||
    Gate::check('Editar-Aluno') ||
    Gate::check('Ver-Aluno')
)
    <th>A&ccedil;&atilde;o</th>
@endif

                        </thead>

                        <tbody>

                            @foreach($alunos as $index => $aluno)

                                @php
                                    $tipopagamento = $aluno->tipopagamentoNome ?? '';
                                @endphp

                                @if(
                                    Gate::check("Visualizar-{$tipopagamento}") 
                                   
                                    ||Gate::check('Ver-Aluno')||Gate::check('Modificar-Estado')||Gate::check('Editar-Aluno')
                                )

                                <tr>

                                    <td>{{ $index + 1 }}</td>

                                    <td>{{ $aluno->nome ?? 'N/A' }}</td>

                                    <td>{{ $aluno->sexo ?? 'N/A' }}</td>

                                    <td>

                                        @php
                                            $dataNasc = Carbon\Carbon::parse(
                                                $aluno->dataNascimento ?? '2000-01-01'
                                            );
                                        @endphp

                                        {{ Carbon\Carbon::now()->year - $dataNasc->year }}

                                    </td>

                                    <td>{{ $aluno->classe ?? 'N/A' }}</td>
                                    <td>{{ $aluno->turma ?? 'N/A' }}</td>

                                    <td>{{ $aluno->Endereco ?? 'N/A' }}</td>

                                    <td>
                                        {{ Carbon\Carbon::parse($aluno->datainscricao ?? now())->format('d/m/Y') }}
                                    </td>

                                    <td>

                                        @if($aluno->TIPOSAIDAa == null)

                                            <span class="badge badge-success">
                                                Activo
                                            </span>

                                        @else

                                            <span class="badge badge-danger">
                                                {{ $aluno->TIPOSAIDAa }}
                                            </span>

                                        @endif

                                    </td>

                                    @if(
                                        Gate::check('Modificar-Estado') ||
                                        Gate::check('Editar-Aluno') ||
                                        Gate::check('Ver-Aluno')
                                    )

                                    <td>

                                        <div class="btn-group btn-group-sm">

                                            @can('Modificar-Estado')

                                            <button
                                                class="btn btn-warning tranferir_Desistencia"
                                                nome="{{ $aluno->nome }}"
                                                classeAluno="{{ $aluno->classe }}"
                                                avatar="{{ $aluno->avatar ?? '' }}"
                                                anolectivo="{{ $aluno->anolectivo ?? '' }}"
                                                idaluno_classe_id="{{ $aluno->idAlunoclasse ?? '' }}"
                                            >
                                                <i class="fa fa-paper-plane"></i>
                                            </button>

                                            @endcan

                                            @can('Editar-Aluno')

                                            <a
                                                class="btn btn-primary"
                                                href="{{ route('aluno.edititaer', [$aluno->id, $aluno->anolectivo_id ?? 1]) }}"
                                            >
                                                <i class="fa fa-edit"></i>
                                            </a>

                                            @endcan

                                            @can('Ver-Aluno')

                                            <button
                                                class="btn btn-info visualizar"
                                                idcodigo="{{ $aluno->id }}"
                                                anolectivo="{{ $aluno->anolectivo_id ?? 1 }}"
                                            >
                                                <i class="fa fa-eye"></i>
                                            </button>

                                            @endcan

                                        </div>

                                    </td>

                                    @endif

                                </tr>

                                @endif

                            @endforeach

                        </tbody>

                    </table>

                </div>

            </div>

        @endforeach

    </div>

</div>

{{-- ================================= --}}
{{-- SCRIPTS --}}
{{-- ================================= --}}
<!-- Modal -->
<div class="modal fade " id="exampleModalCenter" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content  ">

            <div class="conteudobodi"></div>

            <div class="conteudobodiTRanfere">
                 <form action="{{ Route('aluno.saidaTran') }}" method="get">
                                <div class="col-md-12">
                <div class="card">
                    <div class="card-header text-center">
                        <h5 class="card-title">Registe o tipo de Saida do Aluno</h5>
                    </div>

                    <!--<div class="card-body">-->
                        <!--<fieldset>-->
                            <div class="row">
                                <div class="col-md-3">
                                    <img   class="avatar-aluno" src="{{ asset('storage/'.$subdomain.'/fotoAluno/') }}" alt=""
                                        style="width:100%; height:100%; border-radius:10px;">
                                </div>
                                
<div class="col">
                                    <div class="row">
                                        <div class="col-md-6"><label><b>Nome:</b></label></div>
                                        <div class="col-md-6"><span class="nomealuno"></span></div>

                                        <div class="col-md-6"><label><b>Classe:</b></label></div>
                                        <div class="col-md-6"><span class="classealunoSpan"></span></div>

                                        <div class="col-md-6"><label><b>Tipo de saida:</b></label></div>
                                        <div class="col-md-6">
                                            <select class="form-control" name="TiposaidaSelect">
                                                @foreach ($tipossaida as $tipossaidaItem)
                                                    <option value="{{ $tipossaidaItem->id }}">
                                                        {{ $tipossaidaItem->Descricao }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-6"><label><b> M&ecirc;s :</b></label></div>
                                        <div class="col-md-6">
                                            <select class="form-control" name="mes_id">
                                                @foreach ($mes->where('id','<',13) as $mesItem)
                                                    <option value="{{ $mesItem->id }}">
                                                        {{ $mesItem->Descricao }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            <!--</div>-->
                        <!--</fieldset>-->
                    </div>

                    <div class="card-footer text-right">

                            @csrf
                            <input name="idAluno" type="hidden">
                            <input name="idMes" type="hidden">
                            <input name="Tiposaida" type="hidden">
                            <button type="submit" class="btn btn-outline-primary">Submeter</button>
                        </form>
                    <!--</div>-->
                <!--</div>-->
            </div>

        </div>
           </div>
    </div>
</div>
 <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">


<script>

var tables = {};

$(document).ready(function() {

    inicializarTabelas();

    inicializarTabs();

    pesquisaGlobal();

});

function inicializarTabelas() {

    $('.tabelaEstado').each(function() {

        let tabela = $(this);

        let tableId = tabela.attr('id');

        let estado = tableId.replace('table-', '');

        tables[estado] = tabela.DataTable({

            responsive: true,

            pageLength: 5,

            language: {
                url: "/Datatable/pt/Portuguese-Brasil.json"
            }

        });

    });

}

function inicializarTabs() {

    $('#estadoTabs a').on('shown.bs.tab', function(e) {

        let target = $(e.target).attr('href');

        let estado = target.replace('#content-', '');

        if (tables[estado]) {

            setTimeout(function() {

                tables[estado]
                    .columns
                    .adjust()
                    .responsive
                    .recalc();

            }, 200);

        }

    });

}

function pesquisaGlobal() {

    $('#searchFarmacos').on('keyup', function() {

        let valor = $(this).val();

        $.each(tables, function(index, table) {

            table.search(valor).draw();

        });

    });

}




</script>

<style>

.nav-tabs .nav-link{

    font-weight:bold;

}

.nav-tabs .nav-link.active{

    background:#007bff;
    color:white !important;

}

.badge-count{

    margin-left:8px;

}


/* Esconder todos os inputs de search do DataTable */
.dataTables_filter {
    display: none !important;
}


</style>
