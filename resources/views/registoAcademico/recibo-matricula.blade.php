<?php
$conf = DB::table('conf')->first();
?>

<body class="card" style="font-size:12px; font-family:consolas">




    <div class="col">
        <h5 class="float-right" style="float: right">Recibo code: 0000{{ $numerotalao[0]->QNTD + 1 }}</h5>
    </div>
    </div>
    <div class="row">

        <div class="col">
            @include('Componetes.cabecalho')

        </div>
    </div>

    <div class=" ">
        <div class="col-md-12 ">



            <p><b>Taxa de Matricula:</b>{{ $dadosMatriculaValores[0]->valorDescricao }},00 MT</p>

            <p style="font-size: 13px"><b>Nome: </b> <span>{{ $matricula->Aluno->nome }}</span></p>
            <p><b> Classe: </b> <span>{{ $matricula->classe->Descricao }}</span></p>


            <center>

                <p>{{ $data }}</p>
                Assinatura do Funcionário<br>
                _______________________
                <br>
                ({{ Auth()->user()->name }})
                <Center>
        </div>
    </div>

    </boody>
    <hr>

    <body>




        <div class="col">
            <h5 class="float-right" style="float: right">Recibo code: 0000{{ $numerotalao[0]->QNTD + 1 }}</h5>
        </div>
        </div>
        <div class="row">

            <div class="col">
                @include('Componetes.cabecalho')

            </div>
        </div>

        <div class=" ">
            <div class="col-md-12 ">



                <p><b>Taxa de Matricula:</b>{{ $dadosMatriculaValores[0]->valorDescricao }},00 MT</p>

                <p style="font-size: 13px"><b>Nome: </b> <span>{{ $matricula->Aluno->nome }}</span></p>
                <p><b> Classe: </b> <span>{{ $matricula->classe->Descricao }}</span></p>


                <center>

                    <p>{{ $data }}</p>
                    Assinatura do Funcionário<br>
                    _______________________
                    <br>
                    ({{ Auth()->user()->name }})
                    <Center>
            </div>
        </div>

        </boody>
