<?php
$conf=DB::table("config")->first();
?>
<!DOCTYPE html>
<html lang="en" style="font-size:12px; font-family:consolas">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge" style="font-size:12px; font-family:consolas">

    <title>Recibo de Matricula </title>
</head>
<body class="card conteudoDivshow"  id="conteudoDivshow">
<div class="row">

<div class="col-md-12">

<h5 class="float-right"  style="float: right">Recibo code: 0000{{ $numerotalao[0]->QNTD }}</h5>
</div>
</div>
<div class="row">

    <div class="col">
        @include("Componetes.cabecalho")
    </div>
</div>

<div class="row ">
    <div class="col-md-12 ">



  <p><b>Taxa de Matricula:</b>{{$dadosMatriculaValores[0]->valorDescricao}},00 MT</p>

  <p style="font-size: 13px"><b>Nome: </b>   <span>{{ $matricula[0]->nome }}</span></p>
  <p><b> Classe:  </b>   <span>{{ $matricula[0]->classe }}</span></p>


  <center>

    <p>{{$data}}</p>
            Assinatura do Funcionário<br>
            _______________________
            <br>
            ({{ Auth()->user()->name }})
            <Center>
    </div>
</div>

<hr>

<div class="col-md-12">
<h5 class="float-right"  style="float: right">Recibo code: 0000{{ $numerotalao[0]->QNTD }}</h5>
</div>
</div>
<div class="row">

    <div class="col">
        @include("Componetes.cabecalho")

    </div>
</div>

<div class="row ">
    <div class="col-md-12 ">


        <p><b>Taxa de Matricula:</b>{{$dadosMatriculaValores[0]->valorDescricao}},00 MT</p>



  <p style="font-size: 13px"><b>Nome: </b>   <span>{{ $matricula[0]->nome }}</span></p>
  <p><b> Classe:  </b>   <span>{{ $matricula[0]->classe }}</span></p>


  <center>

    <p>{{$data}}</p>
            Assinatura do Funcionário<br>
            _______________________
            <br>
            ({{ Auth()->user()->name }})
            <Center>
    </div>
</div>
</body>
<script>
  var conteudo = document.getElementById('conteudoDivshow').innerHTML,
tela_impressao = window.open('about:blank');
tela_impressao.document.write(conteudo);
tela_impressao.window.print();
tela_impressao.window.close()
</script>

</html>



