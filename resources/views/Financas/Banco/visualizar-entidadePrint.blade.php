@php
use Picqer\Barcode\BarcodeGeneratorPNG;

$conf = DB::table("config")->first();
$geradoPor = Auth()->user()->name ?? 'SISTEMA';
$idAluno = $aluno->id ?? '0000';

// Limpar o nome do usuário para o código de barras
$nomeLimpo = strtoupper(preg_replace('/[^A-Za-z0-9]/', '', $geradoPor));
$codigoBarra = $idAluno . '-' . $nomeLimpo;

// Gerar código de barras com tratamento de erro
try {
    $generator = new BarcodeGeneratorPNG();
    $barcode = base64_encode(
        $generator->getBarcode($codigoBarra, $generator::TYPE_CODE_128)
    );
} catch (Exception $e) {
    $barcode = null;
}

// Tratar data atual
$agora = Carbon\Carbon::now();
$data = $agora->format('d') . ' de ' . $agora->translatedFormat('F') . ' de ' . $agora->format('Y');

// VERIFICAR SE A COLEÇÃO NÃO ESTÁ VAZIA
$temRegistros = isset($referenciasbancariasview) && $referenciasbancariasview->isNotEmpty();

// Definir valores padrão caso não tenha registros
$tipoPagamento = $temRegistros ? ($referenciasbancariasview->first()->tipo_pagamento ?? 'BANCÁRIA') : 'BANCÁRIA';
$bancoReferencia = $temRegistros ? ($referenciasbancariasview->first()->Banco ?? '---') : '---';
@endphp

<div class="content container-fluid" id="content">
    <div class="container-fluid">
        <div class="card" style="font-size: 12px">

            <!-- CABEÇALHO COM CÓDIGO DE BARRAS -->
            <div class="recibo-header">
                <div>
                    {{-- <h3>{{$nomeDoc ?? ''}} Nº {{ $talao ?? '' }}</h3> --}}
                </div>
                <div>
                    @if($barcode)
                        <img class="barcode" src="data:image/png;base64,{{ $barcode }}" alt="Código de Barras">
                    @else
                        <div class="barcode-placeholder">{{ $codigoBarra }}</div>
                    @endif
                </div>
            </div>

            <!-- Cabeçalho estilo recibo -->
            <div class="recibo-title">
                @include("Componetes.cabecalho")
            </div>

            <div class="recibo-subtitle">
                REFERENCIAS  TAXA {{ $tipoPagamento }}
            </div>

            <div class="profile-block">
                <ul style="list-style: none;">
                    <li>
                        <b>NOME:</b> {{ strtoupper($aluno->nome ?? '---') }} | 
                        <b>SEXO:</b> {{ $aluno->sexo ?? '---' }}
                    </li>
                    <li>
                        <b>ANO LECTIVO:</b> {{ $aluno->anolectivo ?? '---' }} | 
                        <b>CLASSE:</b> {{ $aluno->classe ?? '---' }}
                    </li>
                    <li>
                        <b>EMISSÃO:</b> {{ $data }} | 
                        <b>REFERÊNCIA BANCO:</b> {{ $bancoReferencia }}
                    </li>
                </ul>
            </div>

            <!-- Tabela de pagamentos -->
            <table class="table table-bordered custom-borda">
                <thead>
                    <tr>
                        <th>MÊS</th>
                        <th>VALOR (MT)</th>
                        
                        <th>ENTIDADE</th>
                        <th>REFERÊNCIA</th>
                         <th>Banco</th>
                        <th>STATUS</th>
                    </tr>
                </thead>
                <tbody>
                    @if($temRegistros)
                        @foreach ($referenciasbancariasview->sortBy('mes_id') as $itemDado)
                            @php
                                // Tratar valor base
                                $valorBase = isset($itemDado->valorDescricao) && $itemDado->valorDescricao ? $itemDado->valorDescricao : 0;
                                $valorFinal = $valorBase;
                                
                                // Tratar data limite com segurança
                                $statusPrazo = '---';
                               
                                if(isset($itemDado->limite) && $itemDado->limite) {
                                    try {
                                        $statusPrazo = Carbon\Carbon::parse($itemDado->limite)->format('d/m/y');
                                    } catch (Exception $e) {
                                        $statusPrazo = 'Data inválida';
                                    }
                                }
                                
                                // Calcular multa se houver
                                if(isset($itemDado->multaflag) && $itemDado->multaflag == true) {
                                    $multaPercentual = isset($itemDado->multa) && $itemDado->multa ? $itemDado->multa : 0;
                                    $multaValor = ($multaPercentual / 100) * $valorBase;
                                    $valorFinal += $multaValor;
                                    $statusPrazo = "VENCIDO + MULTA";
                                }
                                
                                // Tratar outros campos
                                $mes = isset($itemDado->mes) && $itemDado->mes ? strtoupper($itemDado->mes) : '-';
                                $entidade = $itemDado->Entidade ?? '-';
                                $referencia = $itemDado->referencia ?? '-';
                            @endphp
                            @if(!empty($itemDado))
                            <tr>
                                <td>{{ $mes }}</td>
                                <td class="text-right">{{ number_format($valorFinal, 2, ',', '.') }}</td>
                                <td>{{ $entidade }}</td>
                                <td>{{ $referencia }}</td>
                                 <td>{{ $itemDado->Banco }}</td>
                                <td>{{ $statusPrazo }}</td>
                            </tr>
                            @endif
                        @endforeach
                    @else
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 20px;">
                                <strong>NENHUM REGISTRO DE PAGAMENTO ENCONTRADO</strong><br>
                                <small>Este aluno não possui referências bancárias cadastradas</small>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>

            <!-- Área de assinatura -->
            <div class="assinatura">
                <div>{{ $data }}</div>
                <div class="assinatura-line">
                    _______________________
                </div>
                <div>
                    <small>{{ strtoupper(Auth()->user()->name ?? 'FUNCIONÁRIO') }}</small><br>
                    <small>ASSINATURA / CARIMBO</small>
                </div>
            </div>

            <!-- Rodapé -->
            <div class="rodape">
                <b>ENDEREÇO:</b> 
                {{ $conf->Provincia ?? '-' }} - 
                {{ $conf->Distrito ?? '-' }} - 
                {{ $conf->Localizacao ?? '-' }}<br>
                <b>CONTACTO:</b> {{ $conf->Contacto ?? '-' }} | 
                <b>EMAIL:</b> {{ $conf->Email ?? '-' }}
            </div>
        </div>
    </div>
</div>

<style>
    /* Estilo geral do recibo */
    body {
        font-family: 'Courier New', Courier, 'Lucida Sans Typewriter', monospace;
        font-size: 12px;
        background: #fff;
        margin: 0;
        padding: 2mm;
        width: 100%;
    }

    /* Cabeçalho do recibo */
    .recibo-header {
        width: 100%;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .recibo-header .barcode {
        width: 140px;
        height: 20px;
    }
    
    .barcode-placeholder {
        font-family: monospace;
        font-size: 12px;
        font-weight: bold;
        padding: 5px;
        background: #f0f0f0;
        border: 1px solid #333;
    }

    /* Títulos com cara de recibo */
    .recibo-title {
        font-family: 'Courier New', monospace;
        font-size: 14px;
        font-weight: bold;
        text-transform: uppercase;
        letter-spacing: 1px;
        text-align: center;
    }

    .recibo-subtitle {
        font-family: 'Courier New', monospace;
        font-size: 10px;
        text-align: center;
        margin-top: -5px;
        margin-bottom: 10px;
    }

    /* Dados do aluno - formato carnê */
    .profile-block {
        font-family: 'Courier New', monospace;
        font-size: 11px;
        border: 1px dashed #333;
        padding: 8px;
        margin: 10px 0;
        background: #f9f9f9;
    }

    .profile-block ul {
        margin: 0;
        padding: 0;
    }

    .profile-block li {
        margin-bottom: 5px;
    }

    /* Tabela estilo extrato bancário */
    table.custom-borda {
        border-collapse: collapse;
        width: 100%;
        font-family: 'Courier New', monospace;
        font-size: 10px;
    }

    table.custom-borda th {
        border: 1px solid #000;
        padding: 8px;
        background: #e8e8e8;
        font-weight: bold;
        text-transform: uppercase;
        font-size: 9px;
        letter-spacing: 0.5px;
    }

    table.custom-borda td {
        border: 1px solid #000;
        padding: 6px;
        font-size: 10px;
    }
    
    .text-right {
        text-align: right;
    }

    /* Assinatura estilo recibo */
    .assinatura {
        font-family: 'Courier New', monospace;
        font-size: 10px;
        margin-top: 20px;
        text-align: center;
    }

    .assinatura-line {
        margin-top: 30px;
        border-top: 1px dotted #000;
        width: 200px;
        margin-left: auto;
        margin-right: auto;
        padding-top: 5px;
    }

    /* Rodapé */
    .rodape {
        font-family: 'Courier New', monospace;
        font-size: 8px;
        text-align: center;
        margin-top: 20px;
        border-top: 1px solid #ccc;
        padding-top: 10px;
    }

    /* Para impressão */
    @media print {
        @page {
            size: A5 portrait;
            margin: 1cm;
        }

        body {
            padding: 0;
            margin: 0;
        }

        .profile-block {
            border: 1px dashed #000;
            background: none;
        }

        table.custom-borda th {
            background: #f0f0f0;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        .no-print {
            display: none;
        }

        .recibo-header {
            border-bottom: 2px solid #000;
        }
    }
</style>