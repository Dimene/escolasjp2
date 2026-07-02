<!-- Bootstrap -->


<style>
    /* STATUS REFERÊNCIA */

    .status-referencia {
        font-size: 0.875rem;
        margin-top: 5px;
        display: none;
    }

    .status-referencia.valida {
        color: #28a745;
        display: block;
    }

    .status-referencia.invalida {
        color: #dc3545;
        display: block;
    }

    /* LOADING */
    .spinner-avatar {
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }


    .imgprocessar {
        display: none;
    }

    .imgprocessar.ativo {
        display: inline-block;
    }

    /* PAGAMENTOS */
    .list-group-item:hover {
        background-color: #f8f9fa;
    }

    .checkbox-pagamento:checked + div strong {
        color: #28a745;
    }

    /* VALIDAÇÃO */
    .is-invalid {
        border-color: #dc3545 !important;
    }

    .is-valid {
        border-color: #28a745 !important;
    }

    /* MODAL FIX */
    .modal-body {
        max-height: 70vh;
        overflow-y: auto;
    }

    /* --- Estilos Gerais --- */
    .month-container{
        border:1px solid #dee2e6;
        border-radius:8px;
        padding:20px;
        margin-bottom:10px;
        background:#fff;
        box-shadow:0 2px 4px rgba(0,0,0,.05);
        display:none;
    }
    .img-round {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        object-fit: cover;
    }

    .month-header{
        display:flex;
        justify-content:space-between;
        align-items:center;
    }
    .month-select-container{margin-bottom:15px}

    /* Toggle Pago / Não Pago */
    .toggle-group { display: flex; gap: 5px; }
    .toggle-btn {
        flex: 1; padding: 6px 0; font-weight: 500;
        border-radius: 6px; cursor: pointer;
        transition: 0.2s all; border: 1px solid #dee2e6;
        background: #f8f9fa; color: #495057;
    }
    .toggle-btn.active { color: #fff; }
    .btn-pago.active { background-color: #198754; border-color: #198754; }
    .btn-nao-pago.active { background-color: #dc3545; border-color: #dc3545; }
    .toggle-btn:not(.active):hover { background-color: #e2e6ea; }

    /* Resumo flutuante */
    .resumo-flutuante {
        position: fixed; right: 20px; top: 160px;
        width: 350px; background: white;
        border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        z-index: 1000; max-height: 80vh; overflow-y: auto;
        border: 1px solid #dee2e6;
    }
    .resumo-header {
        background: linear-gradient(135deg, #007bff, #0056b3);
        color: white; padding: 15px;
        border-radius: 10px 10px 0 0;
        display: flex; justify-content: space-between; align-items: center;
    }
    .resumo-body { padding: 15px; }
    .resumo-item { padding: 10px 0; border-bottom: 1px solid #eee; display: flex; justify-content: space-between; align-items: center; }
    .resumo-item:last-child { border-bottom: none; }
    .resumo-total { background: #f8f9fa; padding: 15px; margin-top: 10px; border-radius: 8px; font-weight: bold; text-align: center; }
    .resumo-vazio { text-align: center; color: #6c757d; padding: 20px; }
    .badge-pendente { background-color: #ffc107; color: #000; }
    .badge-pago { background-color: #198754; }

    /* Botão flutuante resumo */
    .btn-resumo {
        position: fixed; right: 20px; bottom: 20px; z-index: 1000;
        width: 50px; height: 50px; border-radius: 50%;
        box-shadow: 0 3px 10px rgba(0,0,0,0.2);
    }
    .resumo-counter {
        position: absolute; top: -5px; right: -5px;
        background: #dc3545; color: white;
        border-radius: 50%; width: 20px; height: 20px;
        font-size: 12px; display: flex; align-items: center; justify-content: center;
    }

    /* Responsividade */
    @media (max-width: 768px) {
        .resumo-flutuante { width: 300px; right: 10px; left: 10px; margin: 0 auto; }
    }
</style>
@php
 $activar=false;

@endphp

<!-- Botão flutuante -->
<button class="btn btn-primary btn-resumo" id="toggleResumo">
    <i class="fas fa-receipt"></i>
    <span class="resumo-counter" id="resumoCounter">0</span>
</button>

<!-- Resumo flutuante -->
<div class="resumo-flutuante" id="resumoFlutuante">
    <div class="resumo-header">
        <h6 class="mb-0"><i class="fas fa-shopping-cart me-2"></i>Resumo de Pagamentos</h6>
        <button class="btn btn-sm btn-light" id="closeResumo"><i class="fas fa-times"></i></button>
    </div>
    <div class="resumo-body">
        <div id="resumoContent">
            <div class="resumo-vazio">
                <i class="fas fa-calculator fa-2x mb-3"></i>
                <p>Nenhum mês selecionado para pagamento</p>
                <small>Marque os meses como "Pago" para aparecerem aqui</small>
            </div>
        </div>
        <div class="resumo-total d-none" id="resumoTotal">
            <div>Total a Pagar: <span id="totalValor">0,00</span> MT</div>
            <small class="text-muted" id="totalItens">0 itens</small>
        </div>
        <div class="mt-3">

            <button class="btn btn-success w-100" id="confirmarPagamento"
             style="display: none"  idaluno="{{$dadosTable[0]->aluno_classe_id }}">
                <i class="fas fa-check-circle me-2"></i>Confirmar Pagamentos
            </button>
            <button class="btn btn-danger w-100" id="Reverterpagamento"  style="display: none" idaluno="{{$dadosTable[0]->aluno_classe_id }}">
                <i class="fas fa-trash-o me-2"></i>Reverter Pagamentos
            </button>
        </div>
    </div>
</div>


<!-- Conteúdo principal -->
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow border-0">
                <div class="card-header bg-white">
                    <strong>Aluno:</strong> {{ $aluno->nome }} ({{ $aluno->classe }})
                    <div class="mt-3">
                        <label>Via de pagamento</label>
                        <select class="form-control tipopagamento" name="tipopagamento">
                            @foreach($tipoPagamento as $tp)
                                <option value="{{ $tp->id }}"  ReferenciaFlag="{{$tp->ReferenciaFlag }}">{{ $tp->Descricao }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="formReferenciaspagamento">
                    </div>

                    <div class="text-center MpesaArea" style="display: none">
                        <div class="image-mpesa">
                            <img src="{{ asset('imageproceaament/mpesalogo.png') }}"
                                 alt="M-Pesa"
                                 class="img-round">
                        </div>

                        <div class="form-group">
                            <label for="numeroMpesa">
                                <strong>Número M-Pesa</strong>
                            </label>
                            <input
                                type="number"
                                class="form-control"
                                id="numeroMpesa"
                                name="numero"
                                placeholder="Ex: 84xxxxxxx"
                                length="9"
                            >
                            <small class="text-muted"  id="erroMpesa">
                                Introduza o número que será usado para o saque
                            </small>
                        </div>
                    </div>
@php
    $arrayposicaoTab1efetuar=[];
    $arrayposicaoTab2efetuar=[];


@endphp
                    <!-- Abas por tipo de pagamento -->
                    <ul class="nav nav-tabs mt-4">
                        @foreach($dadosTable->unique('tipo_pagamento_id') as $i => $tipo)
@php
      $activar=    $tipo->tipoPagamento_id ==(int)$tipopagamento;
@endphp

   {{-- {{dd( $tipo,$tipoPagamento,$tipopagamento,$activar ) }} --}}
                        @php






                $tabId = Str::slug($tipo->tipodepagamentoDescricao);
                  $descricao = trim($tipo->tipodepagamentoDescricao);
         $basePath = "aluno/pagament/$descricao";
        $isActive = Request::is("$basePath/efetuar", "$basePath/relatorio", "$basePath/relatoriogenerico");

        $canEfetuar = Gate::check("Efetuar-$descricao");

        $canVisualizar = Gate::check("Visualizar-$descricao");
        $canLista = Gate::check("Lista-$descricao");
        $canRelatorio = Gate::check("RelatorioPagameto-$descricao");
        $canGenerico = Gate::check("RelatorioGenerico-$descricao");



        $canAccess = $canEfetuar || $canVisualizar || $canLista || $canRelatorio || $canGenerico;
         if ($canAccess):
$arrayposicaoTab1efetuar[$i]=$descricao;
$i=$i+1;
        endif;

                @endphp

    @if ($canAccess)

                            <li class="nav-item">
                                <button class="nav-link {{ $tipo->tipoPagamento_id ==(int)$tipopagamento?'active':'' }}"
                                        data-toggle="tab"
                                        data-target="#tab-{{ $tipo->tipo_pagamento_id }}">
                                    {{ $tipo->tipodepagamentoDescricao }}
                                </button>
                            </li>
                            @endif
                        @endforeach
                    </ul>
                </div>


                <!-- Conteúdo das abas -->
                <div class="card-body tab-content">
                    @php
                        $canAccess      = false;
$canEfetuar     = false;
$canVisualizar  = false;
$canLista       = false;
$canRelatorio   = false;
$canGenerico    = false;

                    @endphp
                    @foreach($dadosTable->unique('tipo_pagamento_id') as $i => $tipo)

                         @php
                        $activar2=    $tipo->tipoPagamento_id ==(int)$tipopagamento;


                $tabId = Str::slug($tipo->tipodepagamentoDescricao);
                  $descricao = trim($tipo->tipodepagamentoDescricao);
         $basePath = "aluno/pagament/$descricao";
        $isActive = Request::is("$basePath/efetuar", "$basePath/relatorio", "$basePath/relatoriogenerico");

        $canEfetuar = Gate::check("Efetuar-$descricao");

        $canVisualizar = Gate::check("Visualizar-$descricao");
        $canLista = Gate::check("Lista-$descricao");
        $canRelatorio = Gate::check("RelatorioPagameto-$descricao");
        $canReverter = Gate::check("Reverter-$descricao");
        $canGenerico = Gate::check("RelatorioGenerico-$descricao");



        $canAccess = $canEfetuar || $canVisualizar || $canLista || $canRelatorio || $canGenerico;
         if ($canAccess):
$arrayposicaoTab2efetuar[$i]=$descricao;
$i=$i+1;
        endif;




                        @endphp
                        @if($canEfetuar || $canVisualizar || $canLista)
                    <div class="tab-pane fade {{  $tipo->tipoPagamento_id ==(int)$tipopagamento?'show active':'' }}" id="tab-{{ $tipo->tipo_pagamento_id }}">
                        <div class="d-flex justify-content-between mb-3 align-items-center">
                            <strong>Pagamento de  <span class="tituloMeses">{{ $tipo->tipodepagamentoDescricao }}</span></strong>
                            <div class="toggle-group">
                                <button class="toggle-btn active" data-action="mark-all" data-status="Pago">
                                    Marcar Todos Pago
                                </button>
                                <button class="toggle-btn" data-action="mark-all" data-status="Não Pago">
                                    Marcar Todos Não Pago
                                </button>
                            </div>
                            <button class="btn btn-info btn-sm toggle-all-months" data-showing="false">
                                <i class="fa fa-calendar"></i> Mostrar Todos os Meses
                            </button>
                        </div>

                        <!-- Dropdown de meses -->
                        <div class="month-select-container">
                            <label>Mês</label>
                            <select class="form-control select-mes">
                                @foreach($dadosTable->where('tipo_pagamento_id',$tipo->tipo_pagamento_id) as $mes)
                                    <option value="{{ $mes->mes_id }}" {{ $mes->mes_id==$mesid?'selected':'' }}
                                        data-valor="{{ $mes->valorDescricao }}"
                                        data-ano="{{ $mes->anolectivo }}"
                                        data-mes="{{ $mes->mes }}">
                                        {{ $mes->mes }} - {{ $mes->Estado ?? 'Pendente' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Meses -->
                        @foreach($dadosTable->where('tipo_pagamento_id',$tipo->tipo_pagamento_id) as $mes)
                        @php
                            $dataLimite = Carbon\Carbon::parse($mes->limite);
                            $dataAtual = Carbon\Carbon::now();
                            $diasAtraso = $dataAtual->diffInDays($dataLimite, false);
                            $multa = 0;
                            $multaActive = false;

                            if ($dataAtual->gt($dataLimite) && $mes->Estado != 'Pago' && $mes->multaP > 0) {
                                $multa = $mes->valorDescricao * ($mes->multaP / 100);
                                $multaActive = true;
                            }
                        @endphp

                        <div class="month-container"
                             id="month-{{ $mes->mes_id }}"
                             data-mes-id="{{ $mes->mes_id }}"
                             data-tipo="{{ $tipo->tipodepagamentoDescricao }}"
                             tipoId="{{ $tipo->tipo_pagamento_id }}"
                             data-valor="{{ $mes->valorDescricao }}"
                             data-mes="{{ $mes->mes }}"
                             valor="{{ $mes->valorDescricao }}"
                             data-ano="{{ $mes->anolectivo }}"
                             data-reverter="{{ $mes->Estado=='Pago' ? 1 : 0 }}"
                             {{-- @if($canReverter==false&& $mes->Estado=='Pago') --}}

                             {{-- @endif --}}
                             >
                            <div class="month-header">
                                <div>
                                    <h6>{{ $mes->mes }} - {{ $mes->anolectivo }}</h6>
                                    <small>Valor: {{ number_format($mes->valorDescricao,2,',','.') }} MT</small>
                                </div>
                                <span class="badge {{ $mes->Estado=='Pago'?'bg-success':'bg-warning' }}">
                                    {{ $mes->Estado ?? 'Pendente' }}
                                </span>
                            </div>

                            <!-- Toggle Pago / Não Pago -->
                            <div class="mt-3 row">
                                <div class="col toggle-group" >
                                    <button class="toggle-btn btn-pago {{ $mes->Estado=='Pago'?'active':'' }}"
                                            flag="{{ $mes->Estado=='Pago'?'pago':'Npago' }}"
                                            data-mes-id="{{ $mes->mes_id }}"
                                            data-estado="Pago"
                                                   data-tipo="{{ $tipo->tipodepagamentoDescricao }}"
                             tipoId="{{ $tipo->tipo_pagamento_id }}"
                                              @if($canReverter==false&& $mes->Estado=='Pago')
disabled="true"
                             @endif
                                            >Pago</button>
                                    <button class="toggle-btn btn-nao-pago {{ $mes->Estado!='Pago'?'active':'' }}"
                                            data-mes-id="{{ $mes->mes_id }}"
                                                   data-tipo="{{ $tipo->tipodepagamentoDescricao }}"
                             tipoId="{{ $tipo->tipo_pagamento_id }}"
                                            data-estado="Não Pago">Não Pago</button>
                                </div>

                                <div class="col-12 mt-2">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input"
                                               id="multaactiva{{ $mes->mes_id }}"
                                               name="multaactiva{{ $mes->mes_id }}"
                                               value="{{ $multa }}"
                                               @if($multaActive) checked @endif>
                                        <label class="form-check-label" for="multaactiva{{ $mes->mes_id }}">
                                            Mensalidade com multa de {{ $mes->multaP }}% ({{ number_format($multa, 2, ',', '.') }} MT) por {{ $diasAtraso }} dia(s) de atraso
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
<script>

        token = '{{ Session::token() }}';
    </script>



