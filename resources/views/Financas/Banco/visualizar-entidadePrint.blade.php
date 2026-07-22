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

$host = request()->getHost();
$subdomain = explode('.', $host)[0];

// ----- FUNÇÃO PARA CONVERTER LOGO EM BASE64 -----
function getLogoBase64($path) {
    if (file_exists($path)) {
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        return 'data:image/' . $type . ';base64,' . base64_encode($data);
    }
    return null;
}

$logoPath = null;
if (isset($conf->avatar) && $conf->avatar) {
    // Tenta no storage
    $logoPath = storage_path('app/public/' . $subdomain . '/logoMarca/' . $conf->avatar);
    if (!file_exists($logoPath)) {
        // Tenta no public
        $logoPath = public_path('storage/' . $subdomain . '/logoMarca/' . $conf->avatar);
    }
}
$logoBase64 = $logoPath ? getLogoBase64($logoPath) : null;
@endphp

<div class="content container-fluid" id="content">
    <div class="container-fluid">
        <div class="card" style="font-size: 12px; padding: 15px;">

            <!-- CABEÇALHO: LOGO + NOME ESQUERDA | CÓDIGO DE BARRAS DIREITA -->
            <div class="recibo-header">
                <div class="header-left">
                    @if($logoBase64)
                        <img src="{{ $logoBase64 }}" alt="Logo" class="logo-img">
                    @else
                        <span class="logo-placeholder">🏫</span>
                    @endif
                    <div class="school-info">
                        <strong>{{ $conf->nome ?? 'INSTITUIÇÃO DE ENSINO' }}</strong>
                        <small>{{ $conf->lema ?? '' }}</small>
                    </div>
                </div>
                <div class="header-right">
                    @if($barcode)
                        <img class="barcode-img" src="data:image/png;base64,{{ $barcode }}" alt="Código de Barras">
                        {{-- <span class="barcode-text">{{ $codigoBarra }}</span> --}}
                    @else
                        <div class="barcode-fallback">{{ $codigoBarra }}</div>
                    @endif
                </div>
            </div>

            <!-- SUBTÍTULO -->
            <div class="recibo-subtitle">
                REFERÊNCIAS TAXA {{ $tipoPagamento }}
            </div>

            <!-- DADOS DO ALUNO -->
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

            <!-- TABELA DE PAGAMENTOS -->
            <table class="table table-bordered custom-borda">
                <thead>
                    <tr>
                        <th>MÊS</th>
                        <th>VALOR (MT)</th>
                        <th>ENTIDADE</th>
                        <th>REFERÊNCIA</th>
                        <th>Banco</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @if($temRegistros)
                        @foreach ($referenciasbancariasview->sortBy('mes_id') as $itemDado)
                            @php
                                $valorBase = isset($itemDado->valorDescricao) && $itemDado->valorDescricao ? $itemDado->valorDescricao : 0;
                                $valorFinal = $valorBase;
                                $statusPrazo = '---';

                                if(isset($itemDado->limite) && $itemDado->limite) {
                                    try {
                                        $statusPrazo = Carbon\Carbon::parse($itemDado->limite)->format('d/m/y');
                                    } catch (Exception $e) {
                                        $statusPrazo = 'Data inválida';
                                    }
                                }

                                if(isset($itemDado->multaflag) && $itemDado->multaflag == true) {
                                    $multaPercentual = isset($itemDado->multa) && $itemDado->multa ? $itemDado->multa : 0;
                                    $multaValor = ($multaPercentual / 100) * $valorBase;
                                    $valorFinal += $multaValor;
                                    $statusPrazo = "VENCIDO + MULTA";
                                }

                                $mes = isset($itemDado->mes) && $itemDado->mes ? strtoupper($itemDado->mes) : '-';
                                $entidade = $itemDado->Entidade ?? '-';
                                $referencia = $itemDado->referencia ?? '-';
                                $escolha = $dadodospagos->where("mes_id", $itemDado->mes_id)->first();
                            @endphp
                            @if(!empty($itemDado) && $escolha->Estado == 'Não pago')
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
                            <td colspan="6" style="text-align: center; padding: 20px;">
                                <strong>NENHUM REGISTRO DE PAGAMENTO ENCONTRADO</strong><br>
                                <small>Este aluno não possui referências bancárias cadastradas</small>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>

            <!-- ÁREA DE ASSINATURA -->
            <div class="assinatura">
                <div>{{ $data }}</div>
                <div class="assinatura-line">
                    _______________________
                </div>
                <div>
                    <small>{{ strtoupper(Auth()->user()->name ?? 'FUNCIONÁRIO') }}</small><br>
                    {{-- <small>ASSINATURA / CARIMBO</small> --}}
                </div>
            </div>

            <!-- RODAPÉ -->
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
    /* ESTILO GERAL */
    body {
        font-family: 'Courier New', Courier, 'Lucida Sans Typewriter', monospace;
        font-size: 12px;
        background: #fff;
        margin: 0;
        padding: 2mm;
        width: 100%;
    }

    .recibo-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-bottom: 10px;
        border-bottom: 2px solid #000;
        margin-bottom: 10px;
        width: 100%;
    }

    .header-left {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .logo-img {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        object-fit: cover;
        border: 1px solid #ccc;
    }

    .logo-placeholder {
        font-size: 30px;
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #eee;
        border-radius: 50%;
    }

    .school-info {
        display: flex;
        flex-direction: column;
        line-height: 1.2;
    }

    .school-info strong {
        font-size: 16px;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .school-info small {
        font-size: 10px;
        color: #555;
        font-style: italic;
    }

    .header-right {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
    }

    .barcode-img {
        width: 100px;
        height: 15px;
    }

    .barcode-text {
        font-size: 5px;
        font-family: monospace;
        letter-spacing: 1px;
        color: #333;
        margin-top: 2px;
    }

    .barcode-fallback {
        font-family: monospace;
        font-size: 6px;
        font-weight: bold;
        padding: 5px 10px;
        background: #f0f0f0;
        border: 1px dashed #333;
    }

    .recibo-subtitle {
        font-size: 10px;
        text-align: center;
        margin-top: -5px;
        margin-bottom: 10px;
        font-weight: bold;
        text-transform: uppercase;
    }

    .profile-block {
        border: 1px dashed #333;
        padding: 8px;
        margin: 10px 0;
        background: #f9f9f9;
        font-size: 11px;
    }

    .profile-block ul {
        margin: 0;
        padding: 0;
    }

    .profile-block li {
        margin-bottom: 5px;
    }

    table.custom-borda {
        border-collapse: collapse;
        width: 100%;
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

    .assinatura {
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

    .rodape {
        font-size: 8px;
        text-align: center;
        margin-top: 20px;
        border-top: 1px solid #ccc;
        padding-top: 10px;
    }

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

        .logo-img {
            border: 1px solid #000;
        }

        .barcode-img {
            background: #fff;
        }
    }

    @media (max-width: 600px) {
        .recibo-header {
            flex-direction: column;
            align-items: stretch;
            gap: 10px;
        }
        .header-left {
            justify-content: center;
        }
        .header-right {
            align-items: center;
        }
        .school-info {
            text-align: center;
        }
    }
</style>
