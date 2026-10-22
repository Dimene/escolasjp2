<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulário de Matrícula</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('Admin-LTE/plugins/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('perfilView/assets/fonts/ionicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('perfilView/assets/css/styles.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <style>
        :root {
            --pagamento-azul: #174a7e;
            --pagamento-azul-escuro: #10365f;
            --pagamento-fundo: #f4f7fb;
            --pagamento-borda: #dce5ef;
            --pagamento-texto: #26384a;
        }

        body {
            margin: 0;
            background: var(--pagamento-fundo);
            color: var(--pagamento-texto);
            font-family: Arial, "Helvetica Neue", sans-serif;
        }

        .container {
            max-width: 960px;
            padding: 18px;
        }

        .container > .card {
            overflow: hidden;
            border: 1px solid var(--pagamento-borda);
            border-radius: 14px;
            box-shadow: 0 12px 34px rgba(24, 55, 86, .12);
        }

        .card-header {
            padding: 18px 22px;
            border: 0;
            background: linear-gradient(120deg, var(--pagamento-azul-escuro), #2872ad);
            color: #fff;
            font-size: 17px;
            font-weight: 700;
        }

        .card-body {
            padding: 22px;
        }

        .input-error {
            border: 2px solid #dc3545 !important;
        }

        .input-success {
            border: 2px solid #28a745 !important;
        }

        .spinner-avatar {
            position: relative;
            width: 140px;
            height: 140px;
            margin: auto;
        }

        .img-round,
        .spinner-avatar img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
        }

        .spinner-avatar img {
            position: absolute;
            top: 50%;
            left: 50%;
            z-index: 2;
            transform: translate(-50%, -50%);
            background: #fff;
        }

        .spinner-avatar::before {
            position: absolute;
            top: 0;
            left: 0;
            width: 140px;
            height: 140px;
            border: 4px solid #e9ecef;
            border-top-color: #28a745;
            border-radius: 50%;
            content: "";
            animation: spin 1.2s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        #pagamentoMpesa {
            border: 1px solid #b8e2c5;
            border-radius: 12px;
            background: #f4fff7;
        }

        .btn-check {
            display: none;
        }

        .btn-check + .btn {
            width: 100%;
            border: 1px solid var(--pagamento-borda);
            border-radius: 9px;
            background: #fff;
            color: #43566a;
            text-align: center;
            font-weight: 600;
            transition: border-color .18s ease, background .18s ease, color .18s ease, transform .18s ease;
        }

        .btn-check + .btn:hover {
            transform: translateY(-1px);
            border-color: #8eb4d8;
            background: #f3f8fd;
        }

        .btn-check:checked + .btn {
            border-color: var(--pagamento-azul);
            background: var(--pagamento-azul);
            color: #fff;
            box-shadow: 0 4px 12px rgba(23, 74, 126, .2);
        }

        .btn-check:focus + .btn {
            outline: 3px solid rgba(23, 74, 126, .2);
        }

        .resumo-box {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 12px;
            padding: 16px;
            border: 1px solid var(--pagamento-borda);
            border-radius: 12px;
            background: #f8fbfe;
            font-size: 13px;
        }

        .resumo-item {
            min-height: 72px;
            padding: 12px 14px;
            border: 1px solid #e2eaf2;
            border-radius: 9px;
            background: #fff;
        }

        .resumo-legenda {
            display: block;
            margin-bottom: 5px;
            color: #708196;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: .04em;
            text-transform: uppercase;
        }

        .badge-total {
            padding: 0;
            background: transparent;
            color: var(--pagamento-texto);
            font-size: 17px;
            font-weight: 700;
        }

        .resumo-item-total {
            border-color: #c6e5d1;
            background: #f2fbf5;
        }

        .resumo-item-total .badge-total {
            color: #18824b;
            font-size: 20px;
        }

        .fine-info {
            grid-column: 1 / -1;
            margin: 0 !important;
            border-color: #f0d58a !important;
            border-radius: 9px !important;
        }

        .form-group > label {
            margin-bottom: 7px;
            color: #354b61;
        }

        .form-control {
            min-height: 42px;
            border-color: #d3deea;
            border-radius: 8px;
            box-shadow: none;
        }

        .form-control:focus {
            border-color: #5d93c4;
            box-shadow: 0 0 0 3px rgba(23, 74, 126, .12);
        }

        .divOutrospagamento > .card {
            margin-bottom: 10px !important;
            overflow: hidden;
            border: 1px solid var(--pagamento-borda);
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(28, 55, 82, .04);
        }

        .divOutrospagamento .card-body {
            padding: 14px 16px;
        }

        .btn-abrirdiv {
            position: relative;
            margin: 0;
            padding: 11px 38px 11px 13px;
            border: 0;
            border-radius: 8px;
            background: #f2f6fa;
            color: #244b70;
            cursor: pointer;
            font-size: 14px;
            font-weight: 700;
            transition: background .18s ease;
        }

        .btn-abrirdiv:hover {
            background: #e8f0f8;
        }

        .btn-abrirdiv::after {
            position: absolute;
            top: 50%;
            right: 14px;
            content: "+";
            transform: translateY(-50%);
            color: var(--pagamento-azul);
            font-size: 21px;
            font-weight: 400;
        }

        .divitem {
            margin: 7px 0 0;
            padding: 7px 2px 2px;
        }

        .divitem > .col {
            margin-bottom: 10px;
        }

        .form-check-input-multa {
            margin-right: 4px;
        }

        .form-check-label {
            color: #825d12;
            font-size: 12px;
        }

        #btnSelecionarTodos,
        #btnLimpar {
            min-height: 40px;
            padding: 8px 14px;
            border-radius: 8px;
            font-weight: 600;
        }

        @media (max-width: 575.98px) {
            .container {
                padding: 8px;
            }

            .card-body {
                padding: 15px;
            }

            .resumo-box {
                grid-template-columns: 1fr 1fr;
                gap: 8px;
                padding: 10px;
            }

            .resumo-item-total {
                grid-column: 1 / -1;
            }

            .d-flex.gap-2 {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
<div class="container mt-4">

    <div class="card">
        <div class="card-header bg-primary text-white">
            <input value="{{$dados->Descricao??0 }}"  type="hidden" class="flagdeativaConformacao">
            <i class="fas fa-receipt mr-2" aria-hidden="true"></i>
            <strong>{{ $dados->Descricao ?? $mensagem }}</strong>
        </div>

        <div class="card-body">
            <form id="paymentForm" method="POST" action="">
                @csrf

                <input type="hidden" name="idtipopagamento" value="{{ $tabela_valores->id ?? 0 }}" class="idtipopagamento">
                <input type="hidden" name="multaApagarC" value="{{ $multa ?? 0 }}" class="multaApagarC">
                <div class="resumo-box mb-3">
                    <div class="resumo-item">
                        <span class="resumo-legenda">Valor da matrícula</span>
                        <span class="badge bg-info badge-total" id="valorMatricula">{{ $dados->valorDescricao ?? 0 }},00 MT</span>
                    </div>

                    @if(isset($multa) && $multa > 0)
                    <div class="fine-info mb-3 p-3 border rounded bg-warning">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input multaApagar" id="multaCheckbox" checked name="multaActiva" value="{{ $multa }}">
                            <label class="custom-control-label font-weight-bold" for="multaCheckbox">
                                Incluir Multa por Atraso
                            </label>
                        </div>
                        <div class="informacaoMulta mt-2">
                            <p class="mb-0">
                                Possui uma multa de {{ $dados->multa ?? 25 }}% que equivale a {{ $multa }} do valor da matrícula por atraso de {{ $diasdeatraso ?? 0 }} dias.
                            </p>
                        </div>
                    </div>
                    @endif

                    <div class="resumo-item">
                        <span class="resumo-legenda">Parcelas selecionadas</span>
                        <span class="badge bg-info badge-total" id="totalMeses">0</span>
                    </div>
                    <div class="resumo-item resumo-item-total">
                        <span class="resumo-legenda">Total a pagar</span>
                        <span class="badge bg-success badge-total" id="totalValor">0,00 MT</span>
                        <input name="totalApagar" value=""  type="hidden">
                    </div>
                </div>

                {{-- Método de Pagamento --}}
                @if(!empty($dados))
                <div class="form-group ">
                    <label for="paymentMethod" class="font-weight-bold">Método de Pagamento</label>
                    <select id="paymentMethod" name="tipopagamento" class="form-control selectmetodo" >
                        @foreach ($metodosdepagamento as $item)
                            {{-- @if($dados->id != 1 || $item->tipo == 0) --}}
                                <option value="{{ $item->id }}" data-tipo="{{ $item->tipo }}" ReferenciaFlag="{{ $item->ReferenciaFlag }}">
                                    {{ $item->Descricao }}
                                </option>
                            {{-- @endif --}}
                        @endforeach
                    </select>
                </div>
                @endif
<!-- PAGAMENTO MPESA -->



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

     <div class="form-group formReferenciaspagamento" >

        </div>



                {{-- Lista de Pagamentos --}}
                <div class="divOutrospagamento mb-3">


                    @foreach($dadosano->unique('tipo') as $tipoAgrupado)

                        <div class="card mb-1">
                            <div class="card-body">
                                <h5 class="card-title list-group-item btn-abrirdiv btn{{$tipoAgrupado->id}}abrir" id="{{$tipoAgrupado->id}}">
                                    {{ $tipoAgrupado->Descricao }}
                                </h5>

                                <div class="row row-cols-2 row-cols-md-4 g-2 divitem" style="display:none" id="item{{$tipoAgrupado->id}}div">
                                    @foreach($dadosano->where('tipo', $tipoAgrupado->tipo)->sortBy('mes') as $itemcadatipo)
                                        <div class="col">
                                            <input type="checkbox"
                                                   class="btn-check checkbox-mes"
                                                   name="meses[]"
                                                   id="mes_{{ $tipoAgrupado->id }}_{{ $itemcadatipo->mes }}"
                                                   value='@json([
    "tipo" => $itemcadatipo->id,
    "mes" => $itemcadatipo->mes,
    "valor" => $itemcadatipo->valorDescricao
])'

                                                   data-valor="{{ $itemcadatipo->valorDescricao ?? 0 }}"
                                                   data-tipo="{{ $itemcadatipo->id }}"
                                                   data-nomeMes="{{$itemcadatipo->mes }}"
                                                   data-multaValor="{{number_format($itemcadatipo->valorDescricao * ($itemcadatipo->multa / 100), 2) }}"
                                                   multaestado="@if (\Carbon\Carbon::now()->gt(\Carbon\Carbon::create($itemcadatipo->limite))) 1 @else 0 @endif">
                                            <label class="btn btn-outline-primary" for="mes_{{ $tipoAgrupado->id }}_{{ $itemcadatipo->mes }}">
                                                {{ $itemcadatipo->mesNome }}
                                            </label>
@if (\Carbon\Carbon::now()->gt(\Carbon\Carbon::create($itemcadatipo->limite)))
    <div class="form-check">
        <input type="checkbox" data-nome="{{$itemcadatipo->mes}}"
               class="form-check-input-multa"
               name="mesesMulta[]"
               value='@json([
    "tipo" => $itemcadatipo->id,
    "mes" => $itemcadatipo->mes,
    "valor" =>  $itemcadatipo->valorDescricao * ($itemcadatipo->multa / 100)
])'

               checked>
        <label class="form-check-label">
            Multa <small>{{ number_format($itemcadatipo->valorDescricao * ($itemcadatipo->multa / 100), 2) }} MT</small>
        </label>
    </div>
@endif

                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Selecionar todos / limpar --}}
                <div class="d-flex gap-2 mb-3">
                    <button type="button" class="btn btn-outline-success" id="btnSelecionarTodos">Selecionar todos</button>
                    <button type="button" class="btn btn-outline-danger" id="btnLimpar">Limpar seleção</button>
                </div>


                {{-- Botão --}}
                {{-- <div class="text-right">
                    <button type="button" class="btn btn-primary btn-matricula">Matricular</button>
                </div> --}}

            </form>
        </div>
    </div>
</div>



<script src="{{ asset('Admin-LTE/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('Admin-LTE/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function() {

    const valorMatricula = parseFloat("{{ $dados->valorDescricao ?? 0 }}");
    const multaValor = parseFloat("{{ $multa ?? 0 }}");
    pedirReferencia();

    // Abrir/esconder meses
    $(document).on("click",".btn-abrirdiv",function(){
        const id = $(this).attr("id");
        const nomediv = `item${id}div`;
        $(".divitem").slideUp(100);
        $("#"+nomediv).stop(true,true).slideToggle(200);
    });







    $('.checkbox-mes, .multaApagar').on('change', function(){
        atualizarResumo();
    });

    $('#btnSelecionarTodos').on('click', function(){
        $('.checkbox-mes').prop('checked', true).trigger('change');
    });

    $('#btnLimpar').on('click', function(){
        $('.checkbox-mes').prop('checked', false).trigger('change');
    });

    atualizarResumo(); // inicializa com valores corretos

function mostrarErro(mensagem) {
    $("#numeroMpesa").addClass("input-error");
    $("#erroMpesa").removeClass("d-none").empty();
    $("#erroMpesa").removeClass("d-none").text(mensagem);
    $("#erroMpesa").removeClass("text-muted");
    $("#erroMpesa").addClass("text-danger");
}

$(document).on("change", "#paymentMethod", function () {

    let metodo = parseInt($(this).val()); // STRING
pedirReferencia();



    if (metodo ==2) {
        $(".MpesaArea").slideDown(200);
         console.log(metodo);
    } else {
        $(".MpesaArea").slideUp(200);
       // $("#numeroMpesa").val("").removeClass("input-error input-success");
    }

});

$("#numeroMpesa").on("input", function () {
    this.value = this.value.replace(/\D/g, '');

    if (this.value.length > 9) {
        this.value = this.value.slice(0, 9);
    }

    if (this.value.length === 9) {
        $(this).removeClass("is-invalid").addClass("is-valid");
    } else {
        $(this).removeClass("is-valid").addClass("is-invalid");
    }

    if (this.value.length === 9) {
    if (!this.value.startsWith("84") && !this.value.startsWith("85")) {
        $(this).addClass("is-invalid").removeClass("is-valid");
    }
}
});



$(document).on("change", ".form-check-input-multa", function () {

    const mes = $(this).data("nome");
    const multaAtiva = $(this).is(":checked") ? 1 : 0;

    const checkboxMes = $('.checkbox-mes[data-nomeMes="' + mes + '"]');

    checkboxMes.attr("multaestado", multaAtiva);
// console.log(multaAtiva,checkboxMes);
    atualizarResumo(); // 🔥 recalcula imediatamente
});




 function atualizarResumo(){
    let totalMeses = 0;
    let total = valorMatricula;

    $('.checkbox-mes:checked').each(function(){

        const valorMes = parseFloat($(this).data('valor')) || 0;
        const multaEstado = parseInt($(this).attr('multaestado')) || 0;
        const multaValor = parseFloat($(this).data('multavalor')) || 0;

        totalMeses++;

        // soma valor do mês
        total += valorMes;

        // soma multa DO MÊS se estiver ativa
        if(multaEstado === 1){
            total += multaValor;
        }
    });

    // multa geral da matrícula
    const incluirMultaGeral = $("#multaCheckbox").length && $("#multaCheckbox").is(":checked")
        ? multaValor
        : 0;

    total += incluirMultaGeral;

    $('#totalMeses').text(totalMeses);
    $('#totalValor').text(
        total.toLocaleString('pt-PT',{minimumFractionDigits:2}) + ' MT'
    );
    $('[name="totalApagar"]').val(total.toFixed(2));
}





});



function pedirReferencia(){
 let referenciaflag = $(".selectmetodo option:selected").attr("ReferenciaFlag");

// alert(referenciaflag);
 $htm=` <label for="Referencia">
                <strong>Referencia</strong>
            </label>
            <input
                type="text"
                class="form-control"
                id="Referencia"
                name="Referencia"
required

            ><spam class="StatusReferencia"><spam> `
    if(referenciaflag==1){

        $(".formReferenciaspagamento").html($htm);

    }else{
      $(".formReferenciaspagamento").empty();
    }
}


</script>

</body>
</html>
