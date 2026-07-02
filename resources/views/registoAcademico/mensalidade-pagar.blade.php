<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DataTable Responsivo</title>
    <!-- CSS do DataTables -->
</head>

<body><!-- Main content -->
    <div class="content">
        <div class="container-fluid conteudotodo">

            <!--todo conteudo aque-->
            <div class="card">

                <div class="informacao"> </div>
                <div class="row">

                    <div class="col-md-12">

                        <?php
                        $multa = 0;

                        $estadomensalidade = '';
                        ?>

                        @if ($dadossaida = Gate::check('Reverter-Mensalidade'))
                            :
                            <input value="{{ $dadossaida }}" id="EstadoReverter" type="hidden">
                        @endif


                        @foreach ($alunoMesalidade as $Item)
                            <input id="mes_estado{{ $Item['mes_id'] }}" value="{{ $Item['Estado'] }}" type="hidden">
                        @endforeach


                        <div class="profile-block">


                            <ul>


                                <li><span class="font-400"><b>Nome do Aluno:</b> </span><span
                                        class="profile-right">{{ $aluno->nome }}</span> </li>
                                <li><span class="font-400"><b>Sexo:</b> </span><span
                                        class="profile-right">{{ $aluno->sexo }}</span> </li>
                                <li><span class="font-400"><b>Idade:</b> </span>
                                    <span
                                        class="profile-right">{{ carbon\Carbon::now()->format('y') - carbon\Carbon::createFromDate($aluno->dataNascimento)->format('y') }}</span>
                                </li>

                                <li><span class="font-400"><b>Tipo:</b> </span><span class="profile-right">
                                        @if ($aluno->Tipo == 'B')
                                            {{ 'Bolseiro' }}
                                        @else
                                            {{ 'Normal' }}
                                        @endif
                                    </span> </li>

                                <li><span class="font-400"><b>Classe :</b> </span><span class="profile-right">
                                        {{ $aluno->classe }}
                                    </span> </li>
                            </ul>


                            <div class="card no-shadow my-4">


                                <center>
                                    <h3> <b>Pagamento de {{ session()->get('formadepagamentos') }} :</b></h3>
                                </center>

                                <form action="{{ Route('mensalida.update', $aluno->Aluno_classe_id) }}" method="POST"
                                    onsubmit="this.enviar.value='Enviando....'; this.enviar.disabled=true"
                                    class="formulario-primero">
                                    @method('PUT')
                                    @csrf
                                    <div class="row meses-select">
                                        <div class="form-group col-md-6">

                                            <label> {{ session()->get('formadepagamentos') }} :</label>


                                            <select id="my-select" class="form-control select-mes" name="mesid">

                                                <?php $mesCorente = $mesid;

                                                ?>

                                                @foreach ($messes as $key => $messesvalue)
                                                    <option value="{{ $messesvalue->id }}"
                                                        @if ($messesvalue->id == $mesid) <?php

                                                        $mesCorente = $messesvalue->id;
                                                        ?>

		   selected @endif>
                                                        {{ $messesvalue->Descricao }}
                                                    </option>
                                                @endforeach

                                            </select>

                                        </div>



                                        <div class="form-group col-md-6">
                                            <label for="my-select">Via de pagamento</label>
                                            <select id="my-select" class="form-control tipopagamento"
                                                name="tipopagamento">

                                                @foreach ($metodos as $metodoItem)
                                                    <option value="{{ $metodoItem->Descricao }}">
                                                        {{ $metodoItem->Descricao }}</option>
                                                @endforeach



                                            </select>
                                        </div>
                                    </div>

                                    @foreach ($alunoMesalidade as $key => $messesvalue)
                                        <?php $ano = $messesvalue['anolectivo'];

                                        $datalimite = $messes->where('id', $messesvalue['mes_id'])->first()->Fim;

                                        $data1 = Carbon\carbon::create($datalimite);
                                        $data2 = Carbon\carbon::now();

                                        // estado da mesalidade;
                                        $estadomensalidade = $messesvalue['Estado'];

                                        if (Carbon\carbon::now() > Carbon\carbon::create($datalimite) && $messesvalue['Estado'] != 'Pago'):
                                            $multa = $valorMensalidade->valorDescricao * ($valorMensalidade->multaP / 100);
                                        endif;
                                        $dias = $data2->diffInDays($data1);
                                        ?>


                                        <div class="col-md-12">
                                            @if (Carbon\carbon::now() > Carbon\carbon::create($datalimite) && $messesvalue['Estado'] != 'Pago')
                                                <center>

                                                <p class="Divestado Divestado{{ $messesvalue['mes_id'] }}"
                                                    @if ($messesvalue['mes_id'] != $mesCorente) style="display:none  " @endif>
                                                    <input type="checkbox" value="1" name="multaactiva"
                                                        class="informacaoMultachcked" checked="true">
                                                    <span class="informacaoMulta">
                                                        A Mensalidade contem uma multa de 25% por motivos do atraso de
                                                        {{ $dias }} dias
                                                        equivalente a {{ $valorMensalidade->valorDescricao * 0.25 }},00
                                                        MT
                                                    </span>
                                                </p>
                                                <p class="Divestado DivestadoMPESA{{ $messesvalue['mes_id'] }}"
                                                    @if ($messesvalue['mes_id'] != $mesCorente) style="display:none  " @endif>
                                                    <input type="checkbox" value="1" name="multaactiva"
                                                        class="informacaoMultachcked" checked="true">
                                                    <span class="informacaoMulta">
                                                        A Mensalidade contem uma multa de 25% por motivos do atraso de
                                                        {{ $dias }} dias
                                                        equivalente a {{ $valorMensalidade->valorDescricao * 0.25 }},00
                                                        MT
                                                    </span>
                                                </p>


                                            </center>
                                            @endif
                                        </div>



                                        <div class="btn-group btn-group-toggle col-md-12 Divestado Divestado{{ $messesvalue['mes_id'] }}"
                                            @if ($messesvalue['mes_id'] != $mesCorente) style="display:none" @endif
                                            idmes="{{ $messesvalue['mes_id'] }}" data-toggle="buttons">



                                            <label id="botaoescolhidooposto{{ $messesvalue['mes_id'] }}"
                                                idtipoflagEstado="{{ $messesvalue['Estado'] }}"
                                                class="btn    botaoescolhido botaoescolhido{{ $messesvalue['mes_id'] }}
				  @if ($messesvalue['Estado'] != 'Pago') btn-success active @else btn-danger  botaoescolhido @endif ">
                                                <input type="radio" name="options{{ $messesvalue['mes_id'] }}"
                                                    value="Não Pago" id="option_b1" autocomplete="off"
                                                    @if ($messesvalue['Estado'] != 'Pago') checked @endif> Não Pago
                                            </label>

                                            <label id="botaoescolhido{{ $messesvalue['mes_id'] }}"
                                                idtipoflagEstado="{{ $messesvalue['Estado'] }}"
                                                class="btn   botaoescolhido botaoescolhidooposto{{ $messesvalue['mes_id'] }} @if ($messesvalue['Estado'] == 'Pago') btn-success active @else btn-danger @endif ">
                                                <input type="radio" name="options{{ $messesvalue['mes_id'] }}"
                                                    id="option_b2" value="Pago" autocomplete="off"
                                                    @if ($messesvalue['Estado'] == 'Pago') checked @endif> Pagar
                                            </label>


                                        </div>

                                        <div class="btn-group btn-group-toggle col-md-12 Divestado DivestadoMPESA{{ $messesvalue['mes_id'] }}"
                                            style="display:none" idmes="{{ $messesvalue['mes_id'] }}"
                                            data-toggle="buttons">
                                            <div class="row">
                                                <div class="col-md-12 ">
                                                    <img src="{{ asset('imageproceaament/mpesalogo.png') }}"
                                                        alt="Logo" class="img-circle elevation-5"
                                                        style="opacity: .8 width:100px; height:100px; margin-left:150px;">
                                                </div>
                                                @if ($messesvalue['Estado'] != 'Pago')
                                                    <div class="col-md-12  form-group">

                                                        <label>Numero</label>
                                                        <input class="form-control" type="text" value=""
                                                            name="numero{{ $messesvalue['mes_id'] }}">
                                                    </div>
                                                @else
                                                    <label style="margin-left:30px"
                                                        id="botaoescolhido{{ $messesvalue['mes_id'] }}"
                                                        class="btn col-md-12  botaoescolhido botaoescolhidooposto{{ $messesvalue['mes_id'] }} @if ($messesvalue['Estado'] == 'Pago') btn-success active @else btn-danger @endif ">
                                                        Pago
                                                    </label>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                            </div>


                            <input name="multa" value="{{ $multa }}" type="hidden" />
                            <input name="class" value=" {{ $aluno->classe_id }}" type="hidden" />

                            <input name="idclass" value=" {{ $aluno->Aluno_classe_id }}" type="hidden" />
                            <input name="mesid" value="{{ $mesid }}" type="hidden" />


                            </span> </li>






                        </div>



                        <div class="inforeversao">
                        </div>

                        </ul>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>


                            <input class="btn btn-primary  float-right col-2 Guardar-mensalida" type="submit"
                                value="Guardar" name='enviar'>
                            <br>
                            </form>

                        </div>
                    </div>
                </div>

            </div>



            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
    </div>
</body>

</html>



<link rel="stylesheet" href="{{ asset('perfilView/assets/bootstrap/css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('perfilView/assets/fonts/ionicons.min.css') }}">
<link rel="stylesheet" href="{{ asset('perfilView/assets/css/styles.min.css') }}">
<script>
    jQuery.noConflict();
</script>

<script>
    $(document).ready(function() {


        if ($("#mes_estado" + $('.select-mes').val() + "").val() === 'Pago') {
            if (parseInt($('#EstadoReverter').val()) != 1) {
                $(".Guardar-mensalida").attr('disabled', 'true')
            }
        } else {
            $(".Guardar-mensalida").removeAttr('disabled')

        }



        $(".informacaoMultachcked").click(function() {
            $(".informacaoMulta").toggle();


            if ($(this).val() == 1) {
                $(".informacaoMultachcked").val(0);
            } else {
                $(".informacaoMultachcked").val(1);
            }

        });

        $(".select-mes, .tipopagamento").change(function() {


            if ($("#mes_estado" + $('.select-mes').val() + "").val() === 'Pago') {
                if (parseInt($('#EstadoReverter').val()) != 1) {
                    $(".Guardar-mensalida").attr('disabled', 'true')
                }
            } else {
                $(".Guardar-mensalida").removeAttr('disabled')

            }




            if ($(".tipopagamento").val() == "Mpesa-Online") {
                //$(".Divestado").hide();
                $(".DivestadoMPESA" + $('.select-mes').val() + "").show();
            } else {

                $(".Divestado").hide();
                $(".Divestado" + $('.select-mes').val() + "").show();

            }


        });


        $(".botaoescolhido").click(function() {





            if ($(this).attr('idtipoflagEstado') == 'Pago') {

                if (parseInt($('#EstadoReverter').val()) == 1) {


                    $(this).removeClass('btn-danger');
                    $(this).addClass('btn-success');
                    $(this).addClass('btn-active');
                    $classe = $(this).attr("id");
                    $("." + $classe + "").removeClass('btn-sucess');
                    $("." + $classe + "").addClass('btn-danger');
                    $(this).removeClass('btn-active');
                }
            } else {



                $(this).removeClass('btn-danger');
                $(this).addClass('btn-success');
                $(this).addClass('btn-active');
                $classe = $(this).attr("id");
                $("." + $classe + "").removeClass('btn-sucess');
                $("." + $classe + "").addClass('btn-danger');
                $(this).removeClass('btn-active');
            }



        });


        $(".Guardar-mensalida").click(function() {
            $idclass = $("[name='idclass']").val();

            $idmes = $("[name='mesid']").val();
            $numero = $("[name='numero" + $idmes + "']").val();
            $estadomens = $("[name='options" + $idmes + "']:checked").val();
            $tipode_pagamento = $(".tipopagamento").val();

            $multaactiva = $(".informacaoMultachcked").val();


            {{--  console.log($idclass, $idmes, $estadomens);  --}}


            var $arraEstado = [];
            var $arraIdmes = [];
            $arraEstado[0] = $estadomens;
            $arraIdmes[0] = $idmes;


            $.ajax({
                url: "/aluno/mensalidade/atualizardados/" + parseInt($idclass),
                type: 'GET',
                data: {
                    "estado": $arraEstado,
                    "mesid": $arraIdmes,
                    "tipopagamento": $tipode_pagamento,
                    "multaactiva": $multaactiva,
                    "numero": $numero,

                    //  "_token": "{{ csrf_token() }}",
                    //  "_method": "PUT"
                },
                success: function(data) {

                    if (data == 0) {
                        $(".inforeversao").html(
                            "<h5 class='inforela'><i class='fa fa-undo fg' style='color:red;'>Reversão  efectuada com sucesso</i></h5>"
                        );
                        $(".inforela").fadeOut(2000);


                    } else {
                        tela_impressao = window.open('about:blank');
                        tela_impressao.document.write(data);
                        tela_impressao.window.print();
                        tela_impressao.window.close();
                    }


                }
            })

        });
    });
</script>
