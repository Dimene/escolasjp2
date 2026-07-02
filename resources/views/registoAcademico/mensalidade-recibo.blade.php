
<?php $conf=DB::table("config")->first(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Recibo de Matricula </title>
</head>
<body class="card">
<div class="row">

<div class="col-md-12">
<h5 class="float-right"  style="float: right; border:1px solid black; padding:10px;">
    0000{{ $matricula->id }} {{$matricula->mes_id }}
</h5>
</div>
</div>
<div class="row">
<div class="col">
    @include("Componetes.cabecalho")
    </div>
</div>

<div class="row ">
    <div class="col-md-12 ">





  <p style="font-size: 13px"><b>Nome: </b>   <span>{{  $matricula->nome }}</span></p>
  <p><b> Classe:  </b>   <span>{{  $matricula->classe }}</span></p>
  <p><b> valor:  </b>   <span>{{  $matricula->valorDescricao }}</span>,00 MT</p>
@if( $matricula->Multa>0)
<p><b> Multa:  </b>   <span>{{  $matricula->Multa }}</span>,00 MT</p>
@endif

  <center>

    <p>{{carbon\Carbon::create($data)->format('d-M-Y')}}</p>
            Assinatura do Funcionário<br>
            _______________________
            <br>
            ({{ Auth()->user()->name }})
            <Center>
    </div>
</div>

<hr>
</body>
</html>


<?php $conf=DB::table("config")->first(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Recibo de Matricula </title>
</head>
<body class="card">
<div class="row">

<div class="col-md-12">
<h5 class="float-right"  style="float: right; border:1px solid black; padding:10px;"> 0000{{ $matricula->id }} {{$matricula->mes_id }}</h5>
</div>
</div>
<div class="row">

    <div class="col">
        @include("Componetes.cabecalho")


    </div>
</div>

<div class="row ">
    <div class="col-md-12 ">





  <p style="font-size: 13px"><b>Nome: </b>   <span>{{  $matricula->nome }}</span></p>
  <p><b> Classe:  </b>   <span>{{  $matricula->classe }}</span></p>
  <p><b> valor:  </b>   <span>{{  $matricula->valorDescricao }}</span>,00 MT</p>
@if( $matricula->Multa>0)
<p><b> Multa:  </b>   <span>{{  $matricula->Multa }}</span>,00 MT</p>
@endif

  <center>

    <p>{{carbon\Carbon::create($data)->format('d-M-Y')}}</p>
            Assinatura do Funcionário<br>
            _______________________
            <br>
            ({{ Auth()->user()->name }})
            <Center>
    </div>
</div>

<hr>
</body>
</html>
