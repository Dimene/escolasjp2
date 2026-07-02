
<?php
$conf=DB::table("config")->first();?>

<body class="card"   style="font-size:12px; font-family:consolas">




    <div class="row">

        <div class="col float-rigth">
         <b> <span style="float:right; font-size:17px;">  {{"00".$dadosmes->mes_id.$dadosmes->aluno_classe_id}}

        </span>
         </b>
        <div class="col">
            @include('Componetes.cabecalho')


        </div>
        </div>

        <div class=" ">
            <div class="col-md-12 ">

                <center>
        <div class="container-fluid"   style="" >




        </div>
                </center>


            <p><b>TAXA DE {{$dadosmes->tipoPagamento}} :</b>{{$dadoTabelavalores->valorDescricao}},00 MT</p>



        @if($dadosmes->Multa>0)
            <p><b>Multa por Atraso de: {{$dias}} Dias</b>{{$dadosmes->Multa}},00 MT</p>
            <p><b>Total:</b>{{(($dadosmes->Multa)+($dadoTabelavalores->valorDescricao))}},00 MT</p>
        @endif



          <p style="font-size: 13px"><b>Nome: </b>   <span>{{$dadosmes->nome}}</span></p>
          <p><b> Classe: </b>   <span>{{$dadosmes->classe}} </span></p>
          @if($dadosmes->mes==null)
               <p><b> Dos dias :</b>
           <span>{{Carbon\carbon::create($dadosmes->data_inicio)->format('d-m-Y')}} </span>&agrave;
           <span>{{Carbon\carbon::create($dadosmes->data_Fim)->format('d-m-Y')}} </span>
           </p>
              @else

          <p><b> {{$mesestipo->tipo   }}  :</b>   <span>{{$dadosmes->mes }} </span></p>
        @endif

          <center>

             <?php  $data="";
             if($dadosmes->data_pagamento==""):
        $dia= Carbon\carbon::now()->format('d');
        $mes= Carbon\carbon::now()->monthName;
        $ano= Carbon\carbon::now()->format('y');
        $data= "Aos  ".$dia." de ".$mes." de 20".$ano;

             else:
                $dia= Carbon\carbon::create($dadosmes->data_pagamento)->format('d');
                $mes= Carbon\carbon::create($dadosmes->data_pagamento)->format('m');
                $ano= Carbon\carbon::create($dadosmes->data_pagamento)->format('Y');
                $data= "Aos  ".$dia." de ".$mes." de ".$ano;
             endif;
             ?>
            <p>{{$data}}</p>

                    Assinatura do Funcionário<br>
                    _______________________
                    <br>
                    ({{ Auth()->user()->name }})
                    <Center>
            </div>
        </div>

        @include("Componetes.rodape")





<div class="row">

    <div class="col float-rigth">
     <b> <span style="float:right; font-size:17px;">  {{"00".$dadosmes->mes_id.$dadosmes->aluno_classe_id}}

    </span>
     </b>
    <div class="col">
        @include('Componetes.cabecalho')


    </div>
    </div>

    <div class=" ">
        <div class="col-md-12 ">

            <center>
    <div class="container-fluid"   style="" >




    </div>
            </center>


        <p><b>TAXA DE {{$dadosmes->tipoPagamento}} :</b>{{$dadoTabelavalores->valorDescricao}},00 MT</p>



    @if($dadosmes->Multa>0)
        <p><b>Multa por Atraso de: {{$dias}} Dias</b>{{$dadosmes->Multa}},00 MT</p>
        <p><b>Total:</b>{{(($dadosmes->Multa)+($dadoTabelavalores->valorDescricao))}},00 MT</p>
    @endif



      <p style="font-size: 13px"><b>Nome: </b>   <span>{{$dadosmes->nome}}</span></p>
      <p><b> Classe: </b>   <span>{{$dadosmes->classe}} </span></p>
      @if($dadosmes->mes==null)
           <p><b> Dos dias :</b>
       <span>{{Carbon\carbon::create($dadosmes->data_inicio)->format('d-m-Y')}} </span>&agrave;
       <span>{{Carbon\carbon::create($dadosmes->data_Fim)->format('d-m-Y')}} </span>
       </p>
          @else

      <p><b> {{$mesestipo->tipo   }}  :</b>   <span>{{$dadosmes->mes }} </span></p>
    @endif

      <center>

         <?php  $data="";
         if($dadosmes->data_pagamento==""):
    $dia= Carbon\carbon::now()->format('d');
    $mes= Carbon\carbon::now()->monthName;
    $ano= Carbon\carbon::now()->format('y');
    $data= "Aos  ".$dia." de ".$mes." de 20".$ano;

         else:
            $dia= Carbon\carbon::create($dadosmes->data_pagamento)->format('d');
            $mes= Carbon\carbon::create($dadosmes->data_pagamento)->format('m');
            $ano= Carbon\carbon::create($dadosmes->data_pagamento)->format('Y');
            $data= "Aos  ".$dia." de ".$mes." de ".$ano;
         endif;
         ?>
        <p>{{$data}}</p>

                Assinatura do Funcionário<br>
                _______________________
                <br>
                ({{ Auth()->user()->name }})
                <Center>
        </div>
    </div>

</div>
    </div>
    <div style="">
    @include("Componetes.rodape")
</div>

</body>
