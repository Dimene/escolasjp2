<div class="profile-block">

    <ul>


        <li><span class="font-400"><b>Nome do Aluno:</b> </span><span
                class="profile-right">{{ $mensalidadeAluno[0]->nome }}</span> </li>
        <li><span class="font-400"><b>Sexo:</b> </span><span class="profile-right">{{ $mensalidadeAluno[0]->sexo }}</span>
        </li>
        <li><span class="font-400"><b>Idade:</b> </span>
            <span
                class="profile-right">{{ carbon\Carbon::now()->format('y') - carbon\Carbon::createFromDate($mensalidadeAluno[0]->dataNascimento)->format('y') }}</span>
        </li>

        <li><span class="font-400"><b>Tipo:</b> </span><span class="profile-right">
                @if ($mensalidadeAluno[0]->Tipo == 'B')
                    {{ 'Bolseiro' }}
                @else
                    {{ 'Normal' }}
                @endif
            </span> </li>

        <li><span class="font-400"><b>Classe :</b> </span><span class="profile-right">
                {{ $mensalidadeAluno[0]->classe }}
            </span> </li>
    </ul>


</div>
<form class='formulariodetodos'>


    <div class="row">
        <div class="col-12">
            <center>
                <h3> <b>Pagamento de {{ session()->get('formadepagamentos') }} :</b></h3>
            </center>
            <div class="form-group col">
                <label for="my-select">Via de pagamento</label>
                <select id="my-select" class="form-control tipopagamento" name="tipopagamento">
                    <option value="Mpesa">M-pesa</option>
                    <option value="Banco">Banco BCI</option>
                    <option value="Mpesa-Online">Mpesa-Online</option>
                    <option value="Outro">Outras</option>

                </select>
            </div>
        </div>






        @foreach ($mensalidadeAluno as $mensalidadeAlunoItem)
            <?php $ano = $mensalidadeAlunoItem->anolectivo;

            $datalimite = $ano . '-' . $mensalidadeAlunoItem->mes_id . '-10';

            $data1 = Carbon\carbon::create($mesdados->where('id', $mensalidadeAlunoItem->mes_id)->first()->Fim);

            $data2 = Carbon\carbon::now();

            // estado da mesalidade;
            $estadomensalidade = $mensalidadeAlunoItem->Estado;

            if (Carbon\carbon::now() > Carbon\carbon::create($mesdados->where('id', $mensalidadeAlunoItem->mes_id)->first()->Fim) && $mensalidadeAlunoItem->Estado != 'Pago'):
                $multa = $mensalidadeAlunoItem->valorDescricao * ($mensalidadeAlunoItem->multaP / 100);
            endif;
            $dias = $data2->diffInDays($data1);
            ?>
            <div class="col-4 py-1">
                <label>


                    {{ $mesdados->where('id', $mensalidadeAlunoItem->mes_id)->first()->Descricao }}
                </label>

                <div class="btn-group btn-group-toggle col-md-12 Divestado " idmes="" data-toggle="buttons">



                    <label id="option2{{ $mensalidadeAlunoItem->mes_id }}" idestado="{{ $perimsadereverter }}"
                        Estado="{{ $mensalidadeAlunoItem->Estado }}"
                        @if ($perimsadereverter == 0 && $mensalidadeAlunoItem->Estado == 'Pago') disabled="true" @endif;
                        @if ($mensalidadeAlunoItem->Estado == 'Pago') disabled="true" @endif
                        class="btn    botaoescolhido botaoescolhido
                                            option1{{ $mensalidadeAlunoItem->mes_id }}
                                            @if ($mensalidadeAlunoItem->Estado != 'Pago') btn-success active
@else
btn-danger  botaoescolhido @endif  ">
                        <input type="radio" name="options{{ $mensalidadeAlunoItem->mes_id }}"
                            idestado="{{ $perimsadereverter }}"
                            @if ($perimsadereverter == 0 && $mensalidadeAlunoItem->Estado == 'Pago') disabled="true" @endif;
                            @if ($mensalidadeAlunoItem->Estado != 'Pago') checked @endif @if ($mensalidadeAlunoItem->Estado == 'Pago')  @endif
                            value="Não Pago" id="option_b1" autocomplete="off"> Não Pago

                    </label>

                    <label Estado="{{ $mensalidadeAlunoItem->Estado }}"
                        @if ($perimsadereverter == 0 && $mensalidadeAlunoItem->Estado == 'Pago') disabled=true @endif;
                        id="option1{{ $mensalidadeAlunoItem->mes_id }}"
                        @if ($mensalidadeAlunoItem->Estado == 'Pago') disabled="true" @endif
                        class="btn  option2{{ $mensalidadeAlunoItem->mes_id }} botaoescolhido @if ($mensalidadeAlunoItem->Estado == 'Pago') btn-success active
@else
btn-danger @endif
                                             ">
                        <input @if ($perimsadereverter == 0 && $mensalidadeAlunoItem->Estado == 'Pago') disabled="true" @endif; type="radio"
                            name="options{{ $mensalidadeAlunoItem->mes_id }}" value="Pago" autocomplete="off"
                            @if ($mensalidadeAlunoItem->Estado == 'Pago') checked @endif> Pagar
                    </label>


                </div>
                @if (Carbon\carbon::now() > Carbon\carbon::create($mesdados->where('id', $mensalidadeAlunoItem->mes_id)->first()->Fim) &&
                        $mensalidadeAlunoItem->Estado != 'Pago')
                    <center>

                        <p class="Divestado Divestado{{ $mensalidadeAlunoItem->mes_id }}">
                            <input type="checkbox" value="1" name="multaactiva{{ $mensalidadeAlunoItem->mes_id }}"
                                class="informacaoMultachcked" checked="true">
                            <span class="informacaoMulta">

                                {{ $dias }} dias
                                Multa
                                {{ $mensalidadeAlunoItem->valorDescricao * ($mensalidadeAlunoItem->multaP / 100) }},00
                                MT
                            </span>
                        </p>



                    </center>
                @endif
            </div>
        @endforeach;
        <div class=" col-md-12 DivestadoMPESA" style="display:none;" idmes="" data-toggle="buttons">


            <center>
                <img src="{{ asset('imageproceaament/mpesalogo.png') }}" alt="Logo"
                    class="img-circle elevation-5 py-2"
                    style="opacity: .8 width:100px; height:100px; margin-left:150px;">




                <label>Numero</label>
                <input class="form-control col-10" type="number" value="" name="">

                <center>

        </div>


    </div>

    <input name="_token" value="{{ csrf_token() }}" type="hidden">
    <input name="_method" value="post" type="hidden">
    <input name="class" value=" {{ $mensalidadeAluno[0]->classe_id }}" type="hidden" />

    <input name="idclass" value=" {{ $mensalidadeAluno[0]->aluno_classe_id }}" type="hidden" />
</form>

<div class="row">
    <div class="col-10"></div>
    <div class="col float-right">
        <button class="btn btn-primary float-rigth Guardar-mensalida"">Guardar</button>
    </div>
</div>

<link rel="stylesheet" href="{{ asset('perfilView/assets/bootstrap/css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('perfilView/assets/fonts/ionicons.min.css') }}">
<link rel="stylesheet" href="{{ asset('perfilView/assets/css/styles.min.css') }}">
<script></script>
<script src="{{ asset('Datatable/js/jquery-3.5.1.js') }}"></script>

<script>
    //var token = '{{ Session::token() }}';
    $(document).ready(function() {




        $(".botaoescolhido").click(function() {


            if ($(this).attr('Estado') == 'Pago') {


            } else {
                $(this).removeClass('btn-danger');
                $(this).addClass('btn-success');
                $(this).addClass('active');
                $classe = $(this).attr("id");

                $("." + $classe + "").removeClass('btn-sucess');
                $("." + $classe + "").addClass('btn-danger');
                $("." + $classe + "").removeClass('active');
            }



        });




        $(".select-mes, .tipopagamento").change(function() {


            if ($(".tipopagamento").val() == "Mpesa-Online") {


                $(".DivestadoMPESA").show();
            } else {
                $(".DivestadoMPESA").hide();
            }


        });



        //efetuarpagamento

        $(".Guardar-mensalida").click(function() {

            $idclass = $("[name='idclass']").val();

            $.ajax({
                url: "/aluno/mensalida/todas/" + parseInt($idclass),
                type: 'POST',
                //dataType: 'json',
                data: $('.formulariodetodos').serialize(),

                success: function(data) {

                    $("#exampleModal").modal("hide");

                    tela_impressao = window.open('about:blank');
                    tela_impressao.document.write(data);
                    tela_impressao.window.print();
                    tela_impressao.window.close();
                }



            });
        });


    });
</script>
