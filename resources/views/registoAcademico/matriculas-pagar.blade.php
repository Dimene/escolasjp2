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
.img-round {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    object-fit: cover;
}
.spinner-avatar img {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    object-fit: cover;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    z-index: 2;
    background: #fff;
}

/* CÍRCULO GIRATÓRIO */
.spinner-avatar::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    width: 140px;
    height: 140px;
    border-radius: 50%;
    border: 4px solid #e9ecef;
    border-top: 4px solid #28a745; /* cor do spinner */
    animation: spin 1.2s linear infinite;
}

/* ANIMAÇÃO */
@keyframes spin {
    from {
        transform: rotate(0deg);
    }
    to {
        transform: rotate(360deg);
    }
}


        #pagamentoMpesa {
    border: 2px dashed #28a745;
    background: #f8fff8;
}

        .btn-check { display: none; }
        .btn-check + .btn {
            border: 1px solid #ced4da;
            background: #fff;
            color: #495057;
            width: 100%;
            text-align: center;
            font-weight: 500;
            transition: all .2s ease;
            border-radius: 5px;
        }
        .btn-check:checked + .btn {
            background-color: #0d6efd;
            color: #fff;
            border-color: #0d6efd;
            box-shadow: 0 4px 10px rgba(13,110,253,.3);
        }
        .btn-check + .btn:hover { background: #f1f3f5; }

        .resumo-box {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 10px;
            font-size: 14px;
        }
        .badge-total { font-size: 15px; }
        .card-header { font-weight: 600; }
        .divitem { margin-top: 5px; }
    </style>
</head>
<body>
<div class="container mt-4">

    <div class="card">
        <div class="card-header bg-primary text-white">


            <input value="{{$dados->Descricao??0 }}"  type="hidden" class="flagdeativaConformacao">
            <strong>{{ $dados->Descricao ?? $mensagem }}</strong>
        </div>

        <div class="card-body">
            <form id="paymentForm" method="POST" action="">
                @csrf

                <input type="hidden" name="idtipopagamento" value="{{ $tabela_valores->id ?? 0 }}" class="idtipopagamento">
                <input type="hidden" name="multaApagarC" value="{{ $multa ?? 0 }}" class="multaApagarC">
{{-- Resumo --}}
                <div class="resumo-box mb-3">
                    <div>Valor da matrícula: <span class="badge bg-info badge-total" id="valorMatricula">{{ $dados->valorDescricao ?? 0 }},00 MT</span></div>

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

                    <div>Meses selecionados: <span class="badge bg-info badge-total" id="totalMeses">0</span></div>
                    <div>Total a pagar: <span class="badge bg-success badge-total" id="totalValor">0,00 MT</span>
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
                                <input type="hidden" name="tipospagamento[]" value="{{ $tipoAgrupado->id }}">

                                <div class="row row-cols-2 row-cols-md-4 g-2 divitem" style="display:none" id="item{{$tipoAgrupado->id}}div">
                                    @foreach($dadosano->where('tipo', $tipoAgrupado->tipo)->sortBy('mes') as $itemcadatipo)
                                        <div class="col">
                                            <input type="checkbox"
                                                   class="btn-check checkbox-mes"
                                                   name="meses[]"
                                                   id="mes_{{ $tipoAgrupado->id }}_{{ $itemcadatipo->mes }}"
                                                   {{-- value="@json([$itemcadatipo->mes])" --}}
                                                   value='@json([
    "tipo" => $tipoAgrupado->id,
    "mes" => $itemcadatipo->mes,
    "valor" => $itemcadatipo->valorDescricao
])'

                                                   data-valor="{{ $itemcadatipo->valorDescricao ?? 0 }}"
                                                   data-tipo="{{ $tipoAgrupado->id }}"
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
    "tipo" => $tipoAgrupado->id,
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
