<style>
     body {
      font-family: Consolas, monospace;
      font-size: 12px;
      background: #fff;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: flex-start;
      padding: 5mm;
    }
    </style>

@php
    use Carbon\Carbon;
    use Picqer\Barcode\BarcodeGeneratorPNG;

    $conf = DB::table("config")->first();

    // Cálculo de atraso
    $diasAtraso = Carbon::parse($matricula->Datamatricula)->diffInDays(Carbon::parse($matricula->limite), false);

    // Gerador de código de barras
    $generator = new BarcodeGeneratorPNG();
    $barcode = base64_encode($generator->getBarcode($matricula->codigo_AC, $generator::TYPE_CODE_128));

    // Proteção contra dados nulos
    $primeiroItem = $dadosTabela->first();
    $primeiroMes = isset($primeiroItem["meses"]) ? $primeiroItem["meses"]->first() : null;


@endphp

<div class="recibo-header">
    <h3>Recibo: {{ $matricula->codigo_AC }}</h3>
    <img src="data:image/png;base64,{{ $barcode }}" alt="Código de Barras">
</div>

<div style="text-align: center; margin-top: 10px;">
    <div style="display: inline-block; height: 60px; width: 60px; border-radius: 60px; overflow: hidden;">
        <img src="{{ asset('storage/logoMarca/' . $conf->avatar) }}"
             style="width: 100%; height: 100%; object-fit: cover; border-radius: 60px;">
    </div>

    <div style="margin-top: 10px;">
        <h4><strong>{{ $conf->nome }}</strong></h4>
    </div>
</div>


<p><b>Nome:</b> {{ $matricula->nome }}</p>
<p><b>Classe:</b> {{ $matricula->classe }}</p>


    <p><b>Taxa de Matrícula:</b> {{ number_format($matricula->valorDescricao, 2, ',', '.') }} MT</p>

    @if($matricula->Multa > 0)
        <p><b>Multa:</b> {{ number_format($detalhesTabela->Multa, 2, ',', '.') }} MT</p>

        @if($diasAtraso > 0)
            <p><b>Atraso de:</b> {{ $diasAtraso }} Dias</p>
        @endif

        <p><b>Total:</b> {{ number_format($matricula->Multa + $matricula->valorDescricao, 2, ',', '.') }} MT</p>



@if(!empty($dadosTabela[0]))
    @if($primeiroMes->multaflag > 0)
        @php
            $multa = ($primeiroMes->multa / 100) * $primeiroMes->valorDescricao;
            $total = $multa + $primeiroMes->valorDescricao;
        @endphp
        <p><strong>Multa:</strong> {{ number_format($multa, 2, ',', '.') }} MT</p>
        <p><strong>Taxa com Multa:</strong> {{ number_format($total, 2, ',', '.') }} MT</p>
    @else
        <p><strong>Taxa de Matrícula:</strong> {{ number_format($primeiroMes->valorDescricao, 2, ',', '.') }} MT</p>
    @endif
@endif
@endif


@if(!empty($dadosTabela[0]))

<p><strong>Entidade do Banco {{ $primeiroMes->Banco }}:</strong> {{ $primeiroMes->Entidade }}</p>
    <p><strong>Referência para {{ $primeiroMes->tipo_pagamento }}:</strong> {{ $primeiroMes->referencia }}</p>
    @endif
    @if(!empty($dadosTabela[1]))
    <table class="table table-bordered custom-borda">
        <thead>
            <tr>
                <th>Meses</th>
                <th>Valor</th>
                <th>Entidade</th>
                <th>Referência</th>
                <th>Situação</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($dadosTabela as $dadosTabelaitem)
                @if(!empty($dadosTabelaitem["meses"]) && optional($dadosTabelaitem["meses"]->first())->tipo > 2)
                    <tr>
                        <td colspan="5" style="background-color: rgba(0,0,0,0.1)">
                            <b>{{ $dadosTabelaitem["Tipo"] ?? 'Tipo não definido' }}</b>
                        </td>
                    </tr>


                @foreach ($dadosTabelaitem["meses"] ?? [] as $itemDado)
                    @if(!empty($itemDado))
                        <tr>
                            <td>{{ $itemDado->mes ?? '-' }}</td>
                            <td>
                                @php
$valor=$itemDado->valorDescricao;
$Estado="Data Limite:".$itemDado->limite;
$valorMulta= ((($itemDado->multa)/100)*$valor);

                                    if($itemDado->multaflag){
                                      $Estado="data Vencida";
$valor=$valorMulta+$valor;
                                    }
                                @endphp

                                {{ $valor}} MT


                            </td>
                            <td>{{ $itemDado->Entidade ?? '-' }}</td>
                            <td>{{ $itemDado->referencia ?? '-' }}</td>
                            <td>{{ $Estado ?? '-' }}</td>
                        </tr>
                    @endif
                @endforeach
                  @endif
            @endforeach
        </tbody>
    </table>
@endif

<center>
    <p>{{ $data }}</p>
    Assinatura do Funcionário<br>
    _______________________<br>
    ({{ Auth()->user()->name }})
</center>

<style>
    table.custom-borda {
        border-collapse: collapse;
        width: 100%;
    }

    table.custom-borda th,
    table.custom-borda td {
        border: 1px solid #333;
        padding: 8px;
    }
</style>
