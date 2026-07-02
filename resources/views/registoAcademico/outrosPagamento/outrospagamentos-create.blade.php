@extends('layouts.admin-Lti')
@section('title', 'Outros PagamentosS')

@section('content')


    <!-- Content Wrapper. Contains page content -->
    <div class="">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">

                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Outros pagamentos</a></li>
                            <li class="breadcrumb-item active">Registo</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

<form  method="post" action="{{route('outrosPagamento.guardarConfiguracao')}}"  >

@csrf
@method('PUT')
        <div class="row col-md-11 mx-3">

            {{--  controler dados   --}}
            <div class="card col-md-12 ">
                <div class=" card-body">

                    <label style="font-size: 20px"> Selecione o Ano Lectivo </label>
                    <select name="anolectivo_id" onchange="buscarConf" class="form-control">

                        <optgroup>

                            @foreach ($ano as $anoItem)
                                <option value="{{ $anoItem->id }}" @if (carbon\Carbon::now()->format('Y') == $anoItem->anolectivo) selected @endif>
                                    {{ $anoItem->anolectivo }}
                                </option>
                            @endforeach
                        </optgroup>
                    </select>
                </div>
            </div>

            <input class="form-control" type="hidden" name="TipoPagamento_id"  @if(!empty($tipospagamento[0]))value="{{ $tipospagamento[0]->id }}" @endif>
            <input class="form-control" type="hidden" name="classe_id"
            @if(!empty( $classes)
            value="{{ $classes[0]->id }}"
            @endif>
            <input class="form-control" type="hidden" name="contrato_pagamento" value="1">



            {{--  fim controller  --}}
            <div class="container col-md-4">
                <div class="card ">
                    <div class="card-body">
                        <h5 class="card-title"><b>Lista de tipos de Pagamentos</b></h5>
                        <hr>
                        <ul>
                            <ul class="list-group">

                                @foreach ($tipospagamento as $key => $Item)
                                    <li class="list-group-item  lista_Itm_tipoPagamento
                                    @if ($key == 0) active @endif
                                    "
                                        title="{{ $Item->id }}" Descricao="{{ $Item->Descricao }}">
                                        {{ $Item->Descricao }}

                                    </li>
                                @endforeach
                            </ul>
                    </div>
                </div>

            </div>

            <div class="container col-md-8">
                <div class="card ">

                    <div class="card-body content-Add">
                        <b>
                            <h3 class="" style="text-align: center; border: 5px">

                                Configura&ccedil;&atilde;o de
                                <span class="Descricao">
                                    @if(!empty($tipospagamento[0]))
                                    {{ $tipospagamento[0]->Descricao }}
                                    @endif

                                </span>
                            </h3>
                        </b>
                        <hr>

                         <div class="row">
                            <div class="col selecionarTipo">

                                {{--  <div class="btn-group btn-group-toggle  float-right" data-toggle="buttons">
                                    <label class="btn   btn-success active   btn-mensal btnMe" id="btn-mensal"
                                        tipo="Mensal">
                                        <input type="radio" name="options" value="Não Pago" id="option_b1"
                                            autocomplete="off">Mensal
                                    </label>

                                    <label class="btn   btn-danger   btn-anual btnMe " tipo="Anual" disabled>
                                        <input type="radio" name="options" id="option_b2" value="Pago"
                                            autocomplete="off">
                                        Anual
                                    </label>

                                </div>  --}}
                            </div>
                        </div>


                        {{--  mostrar as datas de inicio e fim deste processo  --}}
                        <div class="row">
                            <div class="container Clasess col-md-4">
                                <ul class="list-group">
                                    @foreach ($classes as $key => $classesItem)

                                    <li class="list-group-item lista_classes
                                         @if ($key == 0) active @endif

                                         "
                                            title="{{ $classesItem->id }}">



                                            {{ $classesItem->Descricao }}</li>
                                    @endforeach
                                </ul>
                            </div>

                            <div class="container AnualForm col" style="display: none">


                                <div class="row " style="display: none">

                                    <div class="col">
                                        <label for="">
                                            Data Inicio
                                        </label>
                                        <input class="form-control" type="date" name="Data_inicio">
                                    </div>
                                    <div class="col">
                                        <label>Data Final</label>
                                        <input class="form-control" type="date" name="Data_Fim">
                                    </div>
                                </div>
                            </div>





                            <div class="container col MensalForm">
                                <hr>
                                <hr>
                                <div class="row">
                                    @foreach ($meses as $key=> $mesesItem)

                                    @if($key<12)
                                        <span class="col-3" style="height: 50px">

                                            <label>
                                                <input type="checkbox" name="check{{ $mesesItem->id }}"  value="{{  $mesesItem->id }}">
                                                {{ $mesesItem->Descricao }}
                                            </label>

                                        </span>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
                <div class="card">

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-10">

                            </div>
                            <div class="col-md-2">
                                <input type="submit" class="btn btn-primary float-rigth " value="Guardar">

                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </form>
    </div>
    </div>
    </div>
    </div>
    </div>
    @push('script')
        <script>
            $(document).ready(function() {
                buscarConf();
                $("[name='anolectivo_id']").change(function() {
                    buscarConf();
                })




                $(".btnMe").click(function() {
                    $(".selecionarTipo").show();
                    if ($(this).attr('tipo') === "Mensal") {
                        $(".MensalForm").show();
                        $(".AnualForm").hide();
                        $("[name='contrato_pagamento']").val(1);

                    }

                    if ($(this).attr('tipo') === "Anual") {
                        $(".MensalForm").hide();
                        $(".AnualForm").show();
                        $("[name='contrato_pagamento']").val(2);

                    }
                    $(".btnMe").addClass("btn-danger");
                    $(this).removeClass("btn-danger").addClass("btn-success");

                    buscarConf();
                });



                $(".lista_classes").click(function() {
                    $("[name='classe_id']").val($(this).attr('title'));
                    $id = $('.lista_classes').removeClass('active');
                    $id = $(this).addClass('active');
                    buscarConf();
                });




                $(".lista_Itm_tipoPagamento").click(function() {
                    $("[name='TipoPagamento_id']").val($(this).attr('title'));
                    $id = $('.lista_Itm_tipoPagamento').removeClass('active');
                    $id = $(this).addClass('active');
                    $(".selecionarTipo").show();
                    if ($(this).attr('tipo') === "Mensal") {
                        $(".MensalForm").show();
                        $(".AnualForm").hide();

                    }

                    if ($(this).attr('tipo') === "Anual") {
                        $(".MensalForm").hide();
                        $(".AnualForm").show();

                    }
                    $(".Descricao").text($(this).attr('Descricao'));





                    buscarConf();
                });

            });




            function buscarConf() {

                $.ajax({
                    url: "{{ Route('outrosPagamento.create') }}",
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        'classe_id': $("[name='classe_id']").val(),
                        'TipoPagamento_id': $("[name='TipoPagamento_id']").val(),
                        'contrato_pagamento': $("[name='contrato_pagamento']").val(),
                        'anolectivo_id': $("[name='anolectivo_id']").val()
                    },

                    success: function(data) {

                        console.log(data.dadosConfig);
                        for (x = 0; x < 13; x++) {
                            $("[name='check" + x + "']").prop('checked', false);
                        }
                        $("[name='Data_inicio']").val();
                        $("[name='Data_Fim']").val();
                        if (data.flag === 1) {
                            $(".MensalForm").show();
                            $(".AnualForm").hide();
                            $(".btnMe").addClass("btn-danger");
                            $(".btn-mensal").removeClass("btn-danger").addClass("btn-success");
                        }
                        if (data.flag === 2) {
                            $(".MensalForm").hide();
                            $(".AnualForm").show();
                            $(".btnMe").addClass("btn-danger");
                            $(".btn-anual").removeClass("btn-danger").addClass("btn-success");
                        }


                        if (parseInt(data.dadosConfig.length) > 0) {
                            data.dadosConfig.forEach(function(e) {

                               // if (e.mes_id != 13) {

                                    $("[name='check"+e.mes_id+"']").prop('checked', true);
                                   // $(".MensalForm").sow();
                                    //$(".AnualForm").hide();
                               /* } else {
                                    $(".MensalForm").hide();
                                    $(".AnualForm").show();
                                    $("[name='Data_inicio']").val(e.data_inicio);
                                    $("[name='Data_Fim']").val(e.data_Fim);
                                }*/

                            })
                        }



                    }

                });
            }

            // guardarNovoaconfiguracao()

            $dados=$("[name='contrato_pagamento']").val();

            var array = [];
            var arraydado = [];
            $(".Guardar_Config").on("click", function() {
if(parseInt($dados)<1){
                for (var x = 1; x < 13; x++) {

                    array.push([x, $("[name='check" + x + "']:checked").val()]);



                }
            }
            else{
                array.push([$("[name='Data_inicio']").val(),$("[name='Data_Fim']").val()]);
            }

               // console.log(arraydado);
            })




        </script>
    @endpush
@endsection
