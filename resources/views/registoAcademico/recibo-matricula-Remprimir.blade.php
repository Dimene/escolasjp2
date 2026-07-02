<!DOCTYPE html>
<html lang="pt">
<head>
    
    <?php
$conf = DB::table('config')->first();
$host = request()->getHost();
$subdomain = explode('.', $host)[0];
?>

    <meta charset="UTF-8">
    <style>
        @page {
            size: A5 portrait;
            margin: 6mm;
        }

        body {
            font-family: Consolas, monospace;
            font-size: 11px;
            color: #000;
        }

        h3, h4 {
            margin: 2px 0;
            text-align: left;
        }

        p {
            margin: 2px 0;
        }

        .center {
            text-align: center;
        }

        .logo {
            width: 55px;
            height: 55px;
            border-radius: 50%;
            object-fit: cover;
        }

        .recibo-header {
            height: 10px;
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .recibo-header .barcode {
            width: 140px;
            height: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 3px;
            font-size: 10px;
        }

        th, td {
            border: 1px solid #000;
            padding: 3px;
            text-align: center;
        }

        .grupo {
            background: #eee;
            font-weight: bold;
        }

        .assinatura {
            margin-top: 15px;
            text-align: center;
        }

        hr {
            border: 0;
            border-top: 1px dashed #333;
            margin: 6px 0;
        }
    </style>


@php

    $tipoExibido = null;


    use Carbon\Carbon;
    use Picqer\Barcode\BarcodeGeneratorPNG;

    $conf = DB::table('config')->first();

    $diasAtraso = Carbon::parse($matricula->Datamatricula)
        ->diffInDays(Carbon::parse($matricula->limite), false);

    $generator = new BarcodeGeneratorPNG();

    //    dd($talao);


$barcode = base64_encode(
        $generator->getBarcode($talao, $generator::TYPE_CODE_128)
    );



    $primeiroItem = $dadosTabela->first();






    $primeiroMes  = $primeiroItem? optional($primeiroItem)['meses']->first() :null;


$total=0;


  $nome=DB::table('metodo_pagamento')->where("id",$matricula->metodo_pagamento)->first();
$flagDados=0;
    if($matricula->Multa>0){
$flagDados=1;
    }

    $dadosRev=DB::table('referenciasbancariasview')->where("id",$matricula->idAlunoclasse)
     ->where("multaflag",$flagDados)
     ->where("tipo_pagamento_id",$matricula->tipo_Pagamento_id)
    ->where("Banco_id",$nome->tipo)
    ->first();
    //  dd($dadosRev);

@endphp

<!-- CABEÇALHO -->
<div class="recibo-header">
    <div>
        <h3>{{$nomeDoc }} Nº {{ $talao }}</h3>
    </div>
    <div>
        <img class="barcode" src="data:image/png;base64,{{ $barcode }}" alt="Código de Barras">
    </div>
</div>

<!-- LOGO E NOME DA INSTITUIÇÃO -->
<div class="center" style="margin: 10px 0;">
     <img src="{{ asset('storage/'.$subdomain.'/logoMarca/'.$conf->avatar) }}" alt="{{ $conf->nome_Empresa }}" class="logo">
   
</div>
<center> <h3>{{ $conf->nome }}</h3></center>
<hr>

<!-- DADOS DO ALUNO -->
<p><b>Nome:</b> {{ $matricula->nome }}</p>
<p><b>Classe:</b> {{ $matricula->classe }}</p>
@if($flag==null)
<hr>
<!-- TAXAS E MULTAS -->
<p><b>Taxa de Matrícula:</b> {{ number_format($matricula->valorDescricao,2,',','.') }} MT</p>

@if($matricula->Multa > 0)
    <p><b>Multa:</b> {{ number_format($matricula->Multa,2,',','.') }} MT</p>

    @if($diasAtraso > 0)
        <p><b>Atraso:</b> {{ $diasAtraso }} dias</p>
    @endif

    @php
      $total=$total+ $matricula->valorDescricao + $matricula->Multa;
    @endphp
    <p><b>Total:</b> {{ number_format($matricula->valorDescricao + $matricula->Multa,2,',','.') }} MT</p>
@endif

<div style="background-color: rgba(0, 0, 0, 0.092); padding: 2px; border-radius: 2%">
 @if($nome->tipo>0)

<p><b>Banco :</b>{{$dadosRev->Banco}}     &nbsp;&nbsp;  <b>Entidade :</b>
    {{  $dadosRev->Entidade }}
      &nbsp;&nbsp;   <b>Referencia: </b>   &nbsp;&nbsp; {{  $dadosRev->referencia }}</p>
    @else
{{-- {{ dd($matricula) }} --}}
<p><b>Via de  pagamento: </b>  &nbsp;{{ $matricula->metodo_pagamento_desc }} &nbsp; &nbsp; <b>Referencia: </b>  &nbsp; {{  $matricula->referencia }}</p>
    @endif
    @endif
    <hr>
</div>
@if(count($dadosTabela)>0)
<!-- TABELA DE MESES -->
@include("Componetes.compontenteTabelaRecibo")
<!-- ASSINATURA -->

@endif
<div class="assinatura">
  <p>
    {{ \Carbon\Carbon::now()->locale('pt')->translatedFormat('d \d\e F \d\e Y')}}
</p>
    ___________________________<br>
    {{ auth()->user()->name }}
</div>
<pre>
</pre>
@if(count($dadosTabela)<4)

<hr>
corte

<!-- CABEÇALHO -->
<div class="recibo-header">
    <div>
        <h3>{{ $nomeDoc }} Nº {{ $talao }}</h3>
    </div>
    <div>
        <img class="barcode" src="data:image/png;base64,{{ $barcode }}" alt="Código de Barras">
    </div>
</div>

<!-- LOGO E NOME DA INSTITUIÇÃO -->
<div class="center" style="margin: 10px 0;">
    <img src="{{ asset('storage/'.$subdomain.'/logoMarca/'.$conf->avatar) }}" alt="{{ $conf->nome_Empresa }}" class="logo">
   
</div>
<center> <h3>{{ $conf->nome }}</h3></center>
<hr>

<!-- DADOS DO ALUNO -->
<p><b>Nome:</b> {{ $matricula->nome }}</p>
<p><b>Classe:</b> {{ $matricula->classe }}</p>
@if($flag==null)
<hr>
<!-- TAXAS E MULTAS -->
<p><b>Taxa de Matrícula:</b> {{ number_format($matricula->valorDescricao,2,',','.') }} MT</p>

@if($matricula->Multa > 0)
    <p><b>Multa:</b> {{ number_format($matricula->Multa,2,',','.') }} MT</p>

    @if($diasAtraso > 0)
        <p><b>Atraso:</b> {{ $diasAtraso }} dias</p>
    @endif

    <p><b>Total:</b> {{ number_format($matricula->valorDescricao + $matricula->Multa,2,',','.') }} MT</p>


@endif

<div style="background-color: rgba(0, 0, 0, 0.092); padding: 2px; border-radius: 2%">
 @if($nome->tipo>0)

<p><b>Banco :</b>{{$dadosRev->Banco}}     &nbsp;&nbsp;  <b>Entidade :</b>
    {{  $dadosRev->Entidade }}
      &nbsp;&nbsp;   <b>Referencia: </b>   &nbsp;&nbsp; {{  $dadosRev->referencia }}</p>
    @else
{{-- {{ dd($matricula) }} --}}
<p><b>Via de  pagamento: </b>  &nbsp;{{ $matricula->metodo_pagamento_desc }} &nbsp; &nbsp; <b>Referencia: </b>  &nbsp; {{  $matricula->referencia }}</p>
    @endif
    @endif
    <hr>
</div>

@if(count($dadosTabela)>0)
<!-- TABELA DE MESES -->
@include("Componetes.compontenteTabelaRecibo")
<!-- ASSINATURA -->

@endif
<div class="assinatura">
   <p>
    {{ \Carbon\Carbon::now()->locale('pt')->translatedFormat('d \d\e F \d\e Y') }}
</p>
    ___________________________<br>
    {{ auth()->user()->name }}
</div>
@endif


</body>
</html>

