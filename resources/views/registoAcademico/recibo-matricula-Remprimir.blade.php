<!DOCTYPE html>
<html lang="pt">
<head>
    @php
        use Carbon\Carbon;
        use Picqer\Barcode\BarcodeGeneratorPNG;

        /* ---------- Contexto ---------- */
        $conf      = DB::table('config')->first();
        $host      = request()->getHost();
        $subdomain = explode('.', $host)[0];

        /* ---------- Variáveis com fallback seguro ---------- */
        $flag       = $flag ?? null;
        $nomeDoc    = $nomeDoc ?? 'Recibo';
        $metodoTipo = (int) ($metodo->tipo ?? 0);
        $labelMetodo = $metodoTipo > 0 ? 'Banco' : 'Via de pagamento';
        $temBanco    = !empty($metodo->banco);

        /* ---------- Código de barras (protegido) ---------- */
        try {
            $generator = new BarcodeGeneratorPNG();
            $barcode   = base64_encode(
                $generator->getBarcode((string) $aluno->Ntalao, $generator::TYPE_CODE_128)
            );
        } catch (\Throwable $e) {
            $barcode = null;
        }

        /* ---------- Dados derivados da coleção ---------- */
        $primeira    = $dadoscolect->first();
        $estado      = $primeira['estado'] ?? null;
        $isPendente  = $estado === 'Pendente';
        $isPago      = $estado === 'Pago';

        $temMultiRef = $dadoscolect->pluck('referencia')->filter()->unique()->count() > 1;
        $total       = $dadoscolect->sum('valor');

        // Colunas reais: Descrição + Mês + Valor + (Referência) + (Limite/Estado | Estado)
        $colunas = 3 + ($temMultiRef ? 1 : 0) + ($isPendente ? 0 : 1);

        $agora = Carbon::now()->locale('pt');

        /* ---------- Iniciais do aluno ---------- */
        $nomeAluno = $aluno->Aluno->nome ?? '';
        $partes    = preg_split('/\s+/', trim($nomeAluno));
        $iniciais  = strtoupper(
            (isset($partes[0]) ? mb_substr($partes[0], 0, 1) : '') .
            (isset($partes[1]) ? mb_substr($partes[1], 0, 1) : '')
        ) ?: '?';
    @endphp

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $nomeDoc }} - {{ $aluno->Ntalao }}</title>

    <style>
        @page { size: A5 portrait; margin: 6mm; }

        * { box-sizing: border-box; }

        body {
            font-family: Arial, Helvetica, "DejaVu Sans", sans-serif;
            font-size: 10pt;
            line-height: 1.35;
            color: #263445;
            margin: 0;
            padding: 0;
            background: #fff;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        /* Cabeçalho do recibo */
        .recibo-titulo {
            font-size: 15pt;
            font-weight: 700;
            text-align: center;
            text-transform: uppercase;
        }

        .recibo-dados { font-size: 10pt; line-height: 1.4; }

        .recibo-tabela {
            width: 100%;
            border-collapse: collapse;
            font-size: 9pt;
        }
        .recibo-tabela th { font-weight: 700; text-align: left; }
        .recibo-tabela th, .recibo-tabela td { padding: 4px 5px; }
        .recibo-total { font-size: 12pt; font-weight: 700; }

        .doc {
            border: 1px solid #d9e1ea;
            border-radius: 10px;
            overflow: hidden;
            background: #fff;
        }

        .faixa {
            height: 5px;
            background: linear-gradient(90deg, #1f4e79 0%, #2f6fa5 60%, #4a90c4 100%);
        }

        /* ============ CABEÇALHO ============ */
        .cabecalho {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            padding: 12px 16px 10px;
            gap: 12px;
            border-bottom: 1px solid #e7edf2;
        }
        .cabecalho .marca { display: flex; align-items: center; gap: 10px; }

        .logo {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            object-fit: cover;
            border: 1px solid #d5d5d5;
            background: #fafbfc;
            padding: 2px;
            flex-shrink: 0;
        }

        .marca-txt .nome {
            font-size: 12px;
            font-weight: 800;
            letter-spacing: .4px;
            text-transform: uppercase;
            color: #1f4e79;
            margin: 0;
        }
        .marca-txt .sub {
            font-size: 7.5px;
            color: #66788a;
            letter-spacing: 1.2px;
            text-transform: uppercase;
            margin-top: 1px;
        }

        .cabecalho .doc-meta { text-align: right; }

        .doc-meta .tipo-doc {
            font-size: 9px;
            font-weight: 800;
            letter-spacing: 1px;
            text-transform: uppercase;
            color: #1f4e79;
            border: 1px solid #1f4e79;
            border-radius: 4px;
            padding: 2px 8px;
            display: inline-block;
        }
        .doc-meta .numero { margin-top: 4px; font-size: 9px; color: #263445; }
        .doc-meta .numero strong { color: #1f4e79; }

        /* ============ CÓDIGO DE BARRAS ============ */
        .barcode-wrap {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 2px;
            margin-top: 6px;
        }
        .barcode {
            width: 150px;
            height: 38px;
            object-fit: contain;
            image-rendering: -webkit-optimize-contrast;
            image-rendering: crisp-edges;
            background: #fff;
        }
        .barcode-num {
            font-family: "Courier New", monospace;
            font-size: 8px;
            letter-spacing: 1.5px;
            color: #263445;
            font-weight: 700;
        }
        .barcode-fallback {
            width: 150px;
            height: 38px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 7px;
            color: #999;
            border: 1px dashed #ccc;
            border-radius: 3px;
        }

        /* ============ META BAR ============ */
        .meta-bar {
            display: flex;
            justify-content: space-between;
            gap: 10px;
            padding: 6px 16px;
            background: #f7f9fb;
            border-bottom: 1px solid #e7edf2;
            font-size: 8px;
            color: #66788a;
        }
        .meta-bar .item { display: flex; flex-direction: column; gap: 1px; }
        .meta-bar .item .k {
            text-transform: uppercase;
            letter-spacing: .8px;
            font-size: 7px;
        }
        .meta-bar .item .v {
            color: #263445;
            font-weight: 600;
            font-size: 8.5px;
        }

        /* ============ CORPO ============ */
        .corpo { padding: 12px 16px 14px; }

        /* ============ CARTÃO DO ALUNO ============ */
        .cartao-aluno {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 11px;
            border: 1px solid #e7edf2;
            border-left: 3px solid #1f4e79;
            border-radius: 6px;
            background: #fbfcfd;
            margin-bottom: 12px;
        }
        .avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: #1f4e79;
            color: #fff;
            font-weight: 700;
            font-size: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            letter-spacing: .5px;
        }
        .aluno-info {
            flex: 1;
            display: grid;
            grid-template-columns: 1fr auto;
            gap: 4px 14px;
            align-items: center;
        }
        .aluno-info .nome {
            font-size: 11px;
            font-weight: 700;
            color: #1f4e79;
            margin: 0;
        }
        .aluno-info .classe {
            font-size: 8.5px;
            color: #66788a;
            text-transform: uppercase;
            letter-spacing: .6px;
            white-space: nowrap;
        }
        .aluno-info .classe strong { color: #263445; font-size: 9px; }

        /* ============ SEÇÃO ============ */
        .secao { margin-bottom: 12px; }
        .secao-titulo {
            display: flex;
            align-items: center;
            gap: 6px;
            margin: 0 0 6px;
            font-size: 8px;
            font-weight: 800;
            letter-spacing: 1px;
            text-transform: uppercase;
            color: #1f4e79;
        }
        .secao-titulo::before {
            content: "";
            width: 3px;
            height: 11px;
            background: #1f4e79;
            border-radius: 2px;
        }

        /* ============ TABELA ============ */
        table.pagamentos {
            width: 100%;
            border-collapse: collapse;
            font-size: 9px;
            border: 1px solid #e7edf2;
            border-radius: 6px;
            overflow: hidden;
        }
        .pagamentos thead th {
            padding: 7px 8px;
            text-align: left;
            text-transform: uppercase;
            font-size: 7.5px;
            letter-spacing: .7px;
            background: #1f4e79;
            color: #fff;
            font-weight: 700;
        }
        .pagamentos thead th.valor { text-align: right; }
        .pagamentos thead th.ref   { text-align: center; }

        .pagamentos tbody td {
            padding: 7px 8px;
            border-bottom: 1px solid #eef2f6;
            vertical-align: top;
            text-align: left;
        }
        .pagamentos tbody td.valor {
            text-align: right;
            white-space: nowrap;
            font-variant-numeric: tabular-nums;
        }
        .pagamentos tbody td.ref {
            text-align: center;
            font-family: "Courier New", monospace;
            font-size: 8.5px;
            letter-spacing: .5px;
        }
        .pagamentos tbody tr:last-child td { border-bottom: none; }
        .pagamentos tbody tr:nth-child(even):not(.grupo) td { background: #fafbfc; }

        .pagamentos .grupo td {
            padding: 5px 8px;
            background: #eef4f9;
            border-top: 1px solid #d5e0ea;
            border-bottom: 1px solid #d5e0ea;
            font-size: 7.5px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: .8px;
            color: #1f4e79;
        }
        .pagamentos .grupo td .badge {
            display: inline-block;
            padding: 1px 7px;
            background: #1f4e79;
            color: #fff;
            border-radius: 10px;
            font-size: 7px;
            letter-spacing: .5px;
        }
        .pagamentos .vazio td {
            padding: 14px 8px;
            text-align: center;
            color: #66788a;
            font-size: 8.5px;
            font-style: italic;
        }

        /* ============ INSTRUÇÕES ============ */
        .instrucoes {
            margin-top: 10px;
            border: 1px dashed #c5d0da;
            border-radius: 6px;
            background: #fbfcfd;
            padding: 9px 11px;
        }
        .instrucoes-titulo {
            font-size: 7.5px;
            font-weight: 800;
            letter-spacing: 1px;
            text-transform: uppercase;
            color: #66788a;
            margin-bottom: 7px;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .instrucoes-titulo::before { content: "▸"; color: #1f4e79; }

        .instrucoes-grid {
            display: grid;
            grid-template-columns: 1fr 1fr 1.4fr;
            gap: 10px;
        }
        .instrucoes-grid .campo { display: flex; flex-direction: column; gap: 2px; }
        .instrucoes-grid .campo .lbl {
            font-size: 7px;
            letter-spacing: .8px;
            text-transform: uppercase;
            color: #66788a;
        }
        .instrucoes-grid .campo .val {
            font-size: 10px;
            font-weight: 700;
            color: #1f4e79;
            letter-spacing: .3px;
            font-family: "Courier New", monospace;
        }
        .instrucoes-grid .campo .val.txt {
            font-family: inherit;
            font-weight: 700;
            font-size: 9.5px;
        }

        /* ============ TOTAL ============ */
        .total-banner {
            margin-top: 12px;
            padding: 10px 14px;
            background: linear-gradient(90deg, #1f4e79 0%, #2f6fa5 100%);
            color: #fff;
            border-radius: 6px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 1px 3px rgba(31, 78, 121, .2);
        }
        .total-banner .lbl {
            font-size: 8.5px;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            opacity: .9;
        }
        .total-banner .val {
            font-size: 15px;
            font-weight: 800;
            letter-spacing: .3px;
            font-variant-numeric: tabular-nums;
        }

        /* ============ ESTADO ============ */
        .estado {
            margin-top: 8px;
            text-align: center;
            font-size: 8px;
            letter-spacing: 1px;
            text-transform: uppercase;
            font-weight: 800;
        }
        .estado.pago     { color: #1e7e34; }
        .estado.pendente { color: #c0392b; }
        .estado .pill {
            display: inline-block;
            padding: 3px 12px;
            border-radius: 12px;
            border: 1px solid currentColor;
        }

        /* ============ ASSINATURA ============ */
        .assinatura {
            margin-top: 22px;
            text-align: center;
            page-break-inside: avoid;
        }
        .assinatura-data { margin-bottom: 26px; font-size: 8.5px; color: #66788a; }
        .assinatura-linha {
            width: 60%;
            margin: 0 auto 4px;
            border-top: 1px solid #617386;
        }
        .assinatura-nome { font-weight: 700; font-size: 9px; color: #1f4e79; }
        .assinatura-cargo {
            color: #66788a;
            font-size: 7.5px;
            text-transform: uppercase;
            letter-spacing: .6px;
        }

        /* ============ RODAPÉ ============ */
        .rodape {
            padding: 8px 16px 10px;
            background: #f7f9fb;
            border-top: 1px solid #e7edf2;
            text-align: center;
            color: #66788a;
            font-size: 7px;
            line-height: 1.5;
        }
        .rodape .linha-1 { font-weight: 600; color: #263445; letter-spacing: .3px; }
        .rodape .linha-2 { margin-top: 2px; }
        .rodape .pendente-info {
            display: inline-block;
            margin-top: 5px;
            padding: 3px 10px;
            border-radius: 10px;
            background: #fff3cd;
            color: #856404;
            font-weight: 700;
            font-size: 7.5px;
            letter-spacing: .4px;
        }

        /* ============ PRINT ============ */
        @media print {
            body { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            .doc { border-radius: 0; border: none; }
            .faixa { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            .barcode { image-rendering: -webkit-optimize-contrast; }
        }
    </style>
</head>
<body>

<div class="doc">

    <div class="faixa"></div>

    <!-- ============ CABEÇALHO ============ -->
    <div class="cabecalho">
        <div class="marca">
            <img src="{{ asset('storage/'.$subdomain.'/logoMarca/'.$conf->avatar) }}"
                 alt="{{ $conf->nome_Empresa ?? '' }}"
                 class="logo">
            <div class="marca-txt">
                <div class="nome">{{ $conf->nome }}</div>
                <div class="sub">Comprovativo de pagamento</div>
            </div>
        </div>

        <div class="doc-meta">
            <span class="tipo-doc">{{ $nomeDoc }}</span>
            <div class="numero">N.º <strong>{{ $aluno->Ntalao }}</strong></div>

            <div class="barcode-wrap">
                @if($barcode)
                    <img class="barcode"
                         src="data:image/png;base64,{{ $barcode }}"
                         alt="Código de barras {{ $aluno->Ntalao }}">
                @else
                    <div class="barcode-fallback">— código indisponível —</div>
                    <span class="barcode-num">{{ $aluno->Ntalao }}</span>
                @endif
            </div>
        </div>
    </div>

    <!-- ============ META BAR ============ -->
    <div class="meta-bar">
        <div class="item">
            <span class="k">Data de emissão</span>
            <span class="v">{{ $agora->format('d/m/Y') }}</span>
        </div>
        <div class="item">
            <span class="k">Hora</span>
            <span class="v">{{ $agora->format('H:i') }}</span>
        </div>
        <div class="item">
            <span class="k">Estado</span>
            <span class="v">{{ $estado ?? '—' }}</span>
        </div>
    </div>

    <!-- ============ CORPO ============ -->
    <div class="corpo">

        <!-- CARTÃO DO ALUNO -->
        <div class="cartao-aluno">
            <div class="avatar">{{ $iniciais }}</div>
            <div class="aluno-info">
                <div>
                    <div class="nome">{{ $nomeAluno }}</div>
                </div>
                <div class="classe">
                    Classe: <strong>{{ $aluno->classe->Descricao ?? '—' }}</strong>
                </div>
            </div>
        </div>

        <!-- DETALHES DOS PAGAMENTOS -->
        <div class="secao">
            <div class="secao-titulo">Detalhes do pagamento</div>

            <table class="pagamentos">
                <thead>
                    <tr>
                        <th>Descrição</th>
                        <th>Mês / Período</th>
                        <th class="valor">Valor</th>
                        @if($temMultiRef)
                            <th class="ref">Referência</th>
                        @endif
                        @if(!$isPendente)
                            <th class="valor">{{ $isPago ? 'Estado' : 'Limite / Estado' }}</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse ($dadoscolect->groupBy('metodo') as $tipo => $itensTipo)
                        <tr class="grupo">
                            <td colspan="{{ $colunas }}">
                                <span class="badge">{{ $tipo }}</span>
                            </td>
                        </tr>

                        @foreach ($itensTipo as $linha)
                            <tr>
                                <td>{{ $linha['metodo'] }}</td>
                                <td>{{ $linha['mes'] }}</td>
                                <td class="valor">{{ number_format((float) $linha['valor'], 2, ',', '.') }} MT</td>

                                @if($temMultiRef)
                                    <td class="ref">{{ $linha['referencia'] ?? '—' }}</td>
                                @endif

                                @if(!$isPendente)
                                    <td class="valor">
                                        @if($isPago)
                                            {{ $linha['estado'] ?? '—' }}
                                        @else
                                            @if(!empty($linha['limite']) && Carbon::parse($linha['limite'])->isPast())
                                                Com Multa
                                            @else
                                                {{ $linha['limite'] ?? '—' }}
                                            @endif
                                        @endif
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    @empty
                        <tr class="vazio">
                            <td colspan="{{ $colunas }}">Sem pagamentos registados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- INSTRUÇÕES -->
        <div class="instrucoes">
            <div class="instrucoes-titulo">Instruções de pagamento</div>
            <div class="instrucoes-grid">
                <div class="campo">
                    <span class="lbl">{{ $labelMetodo }}</span>
                    <span class="val txt">{{ $metodo->banco?->descricao ?? ($metodo->Descricao ?? '—') }}</span>
                </div>

                @if($temBanco)
                    <div class="campo">
                        <span class="lbl">Entidade</span>
                        <span class="val">{{ $metodo->banco?->Entidade ?? '—' }}</span>
                    </div>
                @endif

                @if(count($dadoscolect->unique('referencia'))==1)
                    <div class="campo">
                        <span class="lbl">Referência</span>
                        <span class="val">{{ $primeira['referencia'] ?? '—' }}</span>
                    </div>
                @endif
            </div>
        </div>

        <!-- ESTADO -->
      
    

             @if($estado=="Activo"||$estado=="activo"||$estado=="Pago")
        
            <div class="estado pago">
                <span class="pill">● Pago</span>
            </div>
            @else
              <div class="estado pendente">
                <span class="pill">● Aguarda pagamento</span>
            </div>
        @endif

        <!-- TOTAL -->
        <div class="total-banner">
            <span class="lbl">Valor total</span>
            <span class="val">{{ number_format((float) $total, 2, ',', '.') }} MT</span>
        </div>

        <!-- ASSINATURA -->
        <div class="assinatura">
            <div class="assinatura-data">
                {{ $agora->translatedFormat('d \d\e F \d\e Y') }}
            </div>
            <div class="assinatura-linha"></div>
            <div class="assinatura-nome">{{ auth()->user()?->name ?? '—' }}</div>
            <div class="assinatura-cargo">Operador responsável</div>
        </div>

    </div>

    <!-- ============ RODAPÉ ============ -->
    <div class="rodape">
        <div class="linha-1">
            {{ $conf->nome }} · Recibo N.º {{ $aluno->Ntalao }}
        </div>
        <div class="linha-2">
            Documento gerado electronicamente. Válido como comprovativo de pagamento.
        </div>
        @if($isPendente)
            <div class="pendente-info">
                Referência válida até {{ $agora->copy()->addDays(20)->format('d/m/Y') }}
            </div>
        @endif
    </div>

</div>

</body>
</html>