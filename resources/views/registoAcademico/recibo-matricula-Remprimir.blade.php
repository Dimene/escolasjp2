<!DOCTYPE html>
<html lang="pt">
<head>
    @php
        use Carbon\Carbon;
        use Picqer\Barcode\BarcodeGeneratorPNG;

        $conf = DB::table('config')->first();
        $host = request()->getHost();
        $subdomain = explode('.', $host)[0];

        $diasAtraso = Carbon::parse($aluno->created_at)
            ->diffInDays(Carbon::parse($aluno->TBdetalhes->limite), false);

        $generator = new BarcodeGeneratorPNG();
        $barcode = base64_encode(
            $generator->getBarcode($aluno->Ntalao, $generator::TYPE_CODE_128)
        );

        $valorMatricula = (float) $aluno->TBdetalhes->valorDescricao + (float) $aluno->Multa;
        $valor = $flag == 0 ? $valorMatricula : 0;
        $mensalidadesPorTipo = collect();

        foreach ($aluno->mensalidades as $item) {
            $detalhes = $item->TBdetalhes($item->tipo_pagamento_id, $item->mes_id);
 $multa=$item->data_Fim > \Carbon\Carbon::now() ? 0 : 1;


  $multa = $item->data_Fim > \Carbon\Carbon::now() ? 0 : 1;

    $referencia = $item->referencidas(
        $item->mes_id,
        $item->tipo_pagamento_id,
        $item->aluno_classe_id
    )
    ->where('Multa', $multa)
    ->value('referencia');

            $mensalidadesPorTipo->push([
                'tipo' => $detalhes->Descricao ?? 'Outros pagamentos',
                'dados' => $detalhes,
                'multa' => (float) $item->Multa,
                'referencias' =>  $referencia,
                'limite' =>$item->data_Fim
            ]);
        }

        $mensalidadesPorTipo = $mensalidadesPorTipo->groupBy('tipo');
    @endphp

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        @page {
            size: A5 portrait;
            margin: 6mm;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, "DejaVu Sans", sans-serif;
            font-size: 10px;
            line-height: 1.4;
            color: #263445;
            margin: 0;
            padding: 10px;
            border: 1px solid #d9e1ea;
            border-radius: 8px;
            background: #fff;
        }

        h3, h4, p {
            margin: 2px 0;
        }

        h3 {
            font-size: 12px;
        }

        .center {
            text-align: center;
        }

        .muted {
            color: #66788a;
        }

        .recibo-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 8px;
            padding-bottom: 7px;
            border-bottom: 2px solid #1f4e79;
        }

        .recibo-header .doc-title {
            font-size: 11px;
            font-weight: bold;
        }

        .recibo-header .numero {
            display: block;
            margin-top: 3px;
            font-size: 10px;
        }

        .barcode {
            width: 135px;
            height: 30px;
            object-fit: contain;
        }

        .instituicao {
            text-align: center;
            margin: 8px 0;
        }

        .logo {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            object-fit: cover;
            border: 1px solid #d5d5d5;
            padding: 2px;
        }

        .nome-instituicao {
            margin-top: 4px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .subtitulo {
            margin-top: 2px;
            font-size: 8px;
            color: #666;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .secao-titulo {
            margin: 8px 0 5px;
            padding: 4px 6px;
            background: #edf3f8;
            border-top: 1px solid #d5e0ea;
            border-bottom: 1px solid #d5e0ea;
            color: #1f4e79;
            font-size: 9px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: .5px;
        }

        .dados-aluno {
            width: 100%;
            margin: 5px 0 8px;
        }

        .dados-aluno td {
            padding: 2px 3px 2px 0;
            vertical-align: top;
        }

        .label {
            color: #666;
            font-size: 8px;
            text-transform: uppercase;
        }

        table.pagamentos {
            width: 100%;
            border-collapse: collapse;
            margin-top: 4px;
            font-size: 9px;
        }

        .pagamentos thead th {
            padding: 5px 3px;
            text-align: left;
            text-transform: uppercase;
            font-size: 8px;
            letter-spacing: .2px;
            background: #1f4e79;
            color: #fff;
            border-top: 1px solid #1f4e79;
            border-bottom: 1px solid #1f4e79;
        }

        .pagamentos thead th.valor,
        .pagamentos tbody td.valor {
            text-align: right;
            white-space: nowrap;
        }

        .pagamentos tbody td {
            padding: 4px 3px;
            border-bottom: 1px solid #e7edf2;
            vertical-align: top;
            text-align: left;
        }

        .pagamentos tbody tr:nth-child(even):not(.grupo) td {
            background: #f7f9fb;
        }

        .pagamentos .grupo td {
            padding: 5px 4px;
            background: #edf3f8;
            border-top: 1px solid #d5e0ea;
            border-bottom: 1px solid #d5e0ea;
            font-size: 8px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: .6px;
        }

        .grupo-nome {
            padding-left: 6px;
            border-left: 3px solid #1f4e79;
        }

        .linha-principal td {
            font-weight: bold;
            background: #eef4f9;
        }

        .pagamento-info {
            margin-top: 9px;
            padding: 7px 8px;
            border: 1px solid #d9e1ea;
            border-left: 3px solid #1f4e79;
            border-radius: 5px;
            background: #f7f9fb;
        }

        .pagamento-info table {
            width: 100%;
            border-collapse: collapse;
        }

        .pagamento-info td {
            padding: 2px 3px;
            vertical-align: top;
        }

        .pagamento-info td:first-child {
            width: 28%;
            color: #666;
            font-size: 8px;
            text-transform: uppercase;
        }

        .total-linha {
            margin-top: 7px;
            padding: 7px 8px;
            background: #1f4e79;
            color: #fff;
            border-radius: 5px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-weight: bold;
        }

        .total-linha .total-label {
            font-size: 9px;
            letter-spacing: .8px;
            text-transform: uppercase;
        }

        .total-linha .total-valor {
            font-size: 13px;
            white-space: nowrap;
        }

        hr {
            border: 0;
            border-top: 1px dashed #888;
            margin: 7px 0;
        }

        .assinatura {
            margin-top: 15px;
            text-align: center;
        }

        .assinatura-data {
            margin-bottom: 16px;
            font-size: 9px;
        }

        .assinatura-linha {
            width: 65%;
            margin: 0 auto 4px;
            border-top: 1px solid #617386;
        }

        .assinatura-nome {
            font-weight: bold;
            font-size: 9px;
        }

        .assinatura-cargo {
            color: #666;
            font-size: 8px;
        }

        .rodape {
            margin-top: 9px;
            padding-top: 5px;
            border-top: 1px dashed #c5d0da;
            text-align: center;
            color: #666;
            font-size: 7px;
        }

        @media print {
            body {
                border-radius: 0;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }
    </style>
</head>
<body>

    <!-- CABEÇALHO DO RECIBO -->
    <div class="recibo-header">
        <div>
            <div class="doc-title">{{ $nomeDoc }}</div>
            <span class="numero">N.º {{ $aluno->Ntalao }}</span>
        </div>
        <img class="barcode"
             src="data:image/png;base64,{{ $barcode }}"
             alt="Código de barras">
    </div>

    <!-- LOGÓTIPO E INSTITUIÇÃO -->
    <div class="instituicao">
        <img src="{{ asset('storage/'.$subdomain.'/logoMarca/'.$conf->avatar) }}"
             alt="{{ $conf->nome_Empresa }}"
             class="logo">
        <div class="nome-instituicao">{{ $conf->nome }}</div>
        <div class="subtitulo">Comprovativo de pagamento</div>
    </div>

    <div class="secao-titulo">Dados do aluno</div>

    <table class="dados-aluno">
        <tr>
            <td>
                <span class="label">Nome do aluno</span><br>
                <strong>{{ $aluno->Aluno->nome }}</strong>
            </td>
            <td>
                <span class="label">Classe</span><br>
                <strong>{{ $aluno->classe->Descricao }}</strong>
            </td>
        </tr>
    </table>



     @if($flag==1&& $metodo->banco?->id>0)

     <div class="pagamento-info">
        <table>
            <tr>

           
                <td>{{ $metodo->tipo>0?"Banco":"via de pagamento"   }}</td>
                <td><strong>{{ $metodo->banco->descricao??"-" }}</strong></td>
            
          
                
           
            
                <td>Entidade</td>
                <td><strong>{{ $metodo->banco?->Entidade ?? '—' }}</strong></td>
            </tr>


     @endif
    <!-- DETALHES DOS PAGAMENTOS -->
    <div class="secao-titulo">Detalhes do pagamento</div>

    <table class="pagamentos">
        <thead>
            <tr>
                <th>Descrição</th>
                <th>Mês/Período</th>
                <th class="valor">Valor</th>


         
                  @if($flag==1&& $metodo->banco?->id>0)
   <th style="padding-left:50px">Referencia</th>
                @endif
                @if($flag != 0)
                    <th>Validade</th>
                @endif

              
            </tr>
        </thead>
        <tbody>

            @if($flag==0)
            <tr class="linha-principal">
                <td>{{ $aluno->TBdetalhes->Descricao }}</td>
                <td>{{ $aluno->TBdetalhes->mesNome }}</td>
                <td class="valor">{{ number_format($valorMatricula, 2, ',', '.') }} MT</td>

               
            </tr>
            @endif

            @foreach ($mensalidadesPorTipo as $tipo => $itensTipo)
                <tr class="grupo">

                    <td colspan="{{ $flag != 0 ? 5 : 4 }}">
                        <span class="grupo-nome">{{ $tipo }}</span>
                    </td>
                    
                </tr>

                @foreach ($itensTipo as $linha)
                    @php
                        $dados = $linha['dados'];
                        $valorLinha = (float) $dados->valorDescricao + $linha['multa'];
                        $valor += $valorLinha;
                    @endphp
                    <tr>
                        <td>{{ $dados->Descricao }}</td>
                        <td>{{ $dados->mesNome }}</td>
                        <td class="valor">{{ number_format($valorLinha, 2, ',', '.') }} MT</td>

                            @if($flag==1 && $metodo->banco?->id>0)
   <td  style="padding-left:50px">{{$linha["referencias"]}}</td>

  

                @endif
                        @if($flag != 0)
                            <td>{{ $dados->limite }}</td>
                        @endif
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>
    @if($flag==0 || $metodo->banco?->id==0)
  {{-- @IF($flag==0) --}}
    <!-- DADOS DA TRANSAÇÃO -->
    <div class="pagamento-info">
        <table>
            <tr>
                <td>{{ $metodo->tipo>0?"Banco":"via de pagamento"   }}</td>
                <td><strong>{{ $metodo->Descricao??"-" }}</strong></td>
            </tr>
            @if ($metodo->banco?->Entidade)
                
           
            <tr >
                <td>Entidade</td>
                <td><strong>{{ $metodo->banco?->Entidade ?? '—' }}</strong></td>
            </tr>
            
@endif

{{-- {{ dd($metodo->banco) }} --}}
 @if ($metodo->Descricao!="Dinheiro Fisco")
            <tr  >
                <td>Referência</td>
                <td>
                    <strong>
                        {{ $aluno->referencia
                            ?? $aluno->referencias
                                ->where('tipo_pagamento_id', $aluno->tipo_Pagamento_id)
                                ->where('Multa', $aluno->multaActiva == 0 ? null : 1)
                                ->first()?->referencia
                            ?? '—' }}
                    </strong>
                </td>
            </tr>

            @endif


            
        </table>

    </div>

@ENDIF;
  
    <!-- TOTAL -->
    <div class="total-linha">
        <span class="total-label">Valor total</span>
        <span class="total-valor">{{ number_format($valor, 2, ',', '.') }} MT</span>
    </div>

    <!-- ASSINATURA -->
    <div class="assinatura">
        <div class="assinatura-data">
            {{ Carbon::now()->locale('pt')->translatedFormat('d \d\e F \d\e Y') }}
        </div>
        <div class="assinatura-linha"></div>
        <div class="assinatura-nome">{{ auth()->user()->name }}</div>
        <div class="assinatura-cargo">Operador responsável</div>
    </div>

   <div class="rodape">
    Documento gerado electronicamente · {{ $conf->nome }}
    · Recibo N.º {{ $aluno->Ntalao }}

    @if ($flag == 0 && ($metodo->tipo>0) )
        <br>
        Referência válida até ao dia:
        <strong>{{ \Carbon\Carbon::now()->addDays(20)->format('d/m/Y') }}</strong>
    @endif
</div>
</body>
</html>
