@php
use Carbon\Carbon;

$conf = $conf ?? DB::table('config')->first();
$disciplinas = DB::table('disciplinas')->get();
$currentYear = now()->year;
$alunoId = $aluno->id ?? null;

$subdominio = explode('.', request()->getHost())[0];
$request = Request();
$host = $request->getHost();
$subdomain = explode('.', $host)[0];

$nomePai = DB::table("encaregadosview")->where("id", $aluno->pai_id)->first();
$nome_mae = DB::table("encaregadosview")->where("id", $aluno->mae_id)->first();
$naturalidade = DB::table("distritos")->where("id", $aluno->Naturalidade_id)->first();

// 10 anos lectivos
$anosLectivos = [];
$anoInicio = $currentYear ;
for ($i = 0; $i < 10; $i++) {
    
    $anosLectivos[] = '20_ _' . '/' . '20_ _';
	$anoInicio=$anoInicio+1;
}
@endphp

<?php
$faltas = ["Faltas Justificadas", "Faltas Injustificadas"];
?>
<!doctype html>
<html lang="pt">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Processo Individual — {{ $aluno->nome ?? 'Aluno' }}</title>

<style>
/* ============================================================
   RESET & BASE
   ============================================================ */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: DejaVu Sans, sans-serif;
}

body {
    background: #fff;
    color: #1a1a1a;
    font-size: 10pt;
    line-height: 1.3;
}

@page {
    size: A3 landscape;
    margin: 0;
}

/* ============================================================
   ESTRUTURA A3 / A4 — MARGENS CONTROLADAS
   ============================================================ */
.a3-page {
    width: 420mm;
    height: 297mm;
    display: flex;
    flex-direction: row;
    position: relative;
    background: #fff;
    page-break-after: always;
    overflow: hidden;
}

.a4-column {
    width: 210mm;
    height: 297mm;
    /* Margens: 12mm topo, 12mm laterais, 14mm fundo (para nº página) */
    padding: 12mm 12mm 14mm 12mm;
    display: flex;
    flex-direction: column;
    position: relative;
    border-right: 1px dashed #b0b0b0;
    overflow: hidden;
}

.a4-column:last-child {
    border-right: none;
}

/* Área de conteúdo com scroll interno se necessário */
.content-area {
    flex: 1;
    display: flex;
    flex-direction: column;
    overflow: hidden;
    min-height: 0;
}

/* ============================================================
   CABEÇALHO OFICIAL
   ============================================================ */
.header {
    border: 2px solid #1a3a6b;
    border-radius: 6px;
    padding: 6px 12px 8px;
    margin-bottom: 8px;
    text-align: center;
    background: linear-gradient(180deg, #f8fafd 0%, #eef3fa 100%);
    position: relative;
    overflow: hidden;
    flex-shrink: 0;
}

.header::before {
    content: "";
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 4px;
    background: linear-gradient(90deg, #1a3a6b, #c9a227, #1a3a6b);
}

.header .logo-top {
    width: 15mm;
    height: 15mm;
    object-fit: contain;
    margin: 0 auto 2px;
    display: block;
}

.header h1 {
    font-size: 12pt;
    font-weight: bold;
    margin: 1px 0;
    text-transform: uppercase;
    letter-spacing: 1.2px;
    color: #1a3a6b;
}

.header .subtitle {
    font-size: 8.5pt;
    margin-top: 1px;
    color: #333;
    letter-spacing: 0.6px;
}

.header .subtitle.bold {
    font-weight: bold;
    color: #1a3a6b;
    font-size: 9.5pt;
}

.header .divider {
    width: 40%;
    height: 1px;
    background: #c9a227;
    margin: 3px auto;
}

/* ============================================================
   CAIXA DE INFORMAÇÕES DA ESCOLA
   ============================================================ */
.school-info {
    border: 1px solid #1a3a6b;
    border-radius: 4px;
    padding: 5px 7px;
    margin-bottom: 8px;
    font-size: 8.5pt;
    background: #fbfcfe;
    display: flex;
    gap: 6px;
    align-items: flex-start;
    flex-shrink: 0;
}

.school-info .logo {
    width: 14mm;
    height: 14mm;
    border-radius: 4px;
    overflow: hidden;
    background: #f0f4fa;
    border: 1px solid #d0dae8;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.school-info .logo img {
    width: 100%;
    height: 100%;
    object-fit: contain;
}

.school-info .info-body { flex: 1; }

.school-info .row {
    display: flex;
    margin-bottom: 1px;
    align-items: center;
}

.school-info .label {
    font-weight: bold;
    color: #1a3a6b;
    min-width: 18mm;
    font-size: 8pt;
}

.school-info .field-value {
    flex: 1;
    font-size: 8.5pt;
    color: #222;
}

.school-info .school-name {
    font-weight: bold;
    font-size: 9.5pt;
    color: #1a3a6b;
    text-transform: uppercase;
    letter-spacing: 0.4px;
    border-bottom: 1px solid #d0dae8;
    padding-bottom: 1px;
    margin-bottom: 2px;
}

/* ============================================================
   SEÇÕES
   ============================================================ */
.section {
    margin-bottom: 7px;
    page-break-inside: avoid;
    flex-shrink: 0;
}

.section-title {
    font-size: 9pt;
    font-weight: bold;
    margin-bottom: 3px;
    padding: 3px 7px;
    color: #fff;
    background: linear-gradient(90deg, #1a3a6b, #2c5aa0);
    border-radius: 3px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    display: flex;
    align-items: center;
    gap: 5px;
}

.section-title .num {
    background: #c9a227;
    color: #1a3a6b;
    font-weight: bold;
    border-radius: 3px;
    padding: 0 4px;
    font-size: 8.5pt;
    line-height: 1.4;
}

/* ============================================================
   CAMPOS DE DADOS
   ============================================================ */
.data-field {
    display: flex;
    margin-bottom: 2px;
    font-size: 8.5pt;
    align-items: flex-end;
}

.field-label {
    font-weight: bold;
    color: #1a3a6b;
    min-width: 30mm;
    font-size: 8pt;
}

.field-value {
    flex: 1;
    border-bottom: 1px dotted #6b7c93;
    margin-left: 3px;
    padding: 1px 3px 1px;
    min-height: 4mm;
    color: #111;
}

.field-value.bold { font-weight: bold; }

/* ============================================================
   FOTO DO ALUNO
   ============================================================ */
.photo-container {
    position: absolute;
    top: 18mm;
    right: 12mm;
    width: 33mm;
    height: 42mm;
    border: 2px solid #1a3a6b;
    border-radius: 4px;
    background: #f8fafd;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 6.5pt;
    text-align: center;
    padding: 1mm;
    overflow: hidden;
    box-shadow: 2px 2px 0 rgba(26, 58, 107, 0.15);
    z-index: 10;
}

.photo-container img {
    max-width: 100%;
    max-height: 100%;
    object-fit: cover;
}

.photo-container .placeholder {
    color: #6b7c93;
    font-weight: bold;
    line-height: 1.4;
}

/* ============================================================
   TABELAS
   ============================================================ */
.table {
    width: 100%;
    border-collapse: collapse;
    font-size: 8pt;
    margin-top: 3px;
    border: 1px solid #1a3a6b;
}

.table th {
    border: 1px solid #1a3a6b;
    padding: 3px 4px;
    background: linear-gradient(180deg, #e8eef7, #d4e0f0);
    font-weight: bold;
    text-align: center;
    color: #1a3a6b;
    font-size: 7.5pt;
}

.table td {
    border: 1px solid #9fb0c8;
    padding: 3px 4px;
    text-align: left;
    vertical-align: middle;
    font-size: 8pt;
    height: 6mm;
}

.table tbody tr:nth-child(even) {
    background: #f7fafd;
}

/* ============================================================
   TABELA HISTÓRICA ACADÉMICA — CÉLULAS MAIORES
   ============================================================ */
.historico-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 6pt;
    table-layout: fixed;
    border: 1px solid #1a3a6b;
}

.historico-table th,
.historico-table td {
    border: 1px solid #9fb0c8;
    padding: 2px 1px;
    text-align: center;
    overflow: hidden;
    white-space: nowrap;
}

.historico-table thead th {
    background: linear-gradient(180deg, #e8eef7, #d4e0f0);
    color: #1a3a6b;
    font-weight: bold;
    font-size: 5.5pt;
}

.historico-table .col-disciplina {
    width: 22mm;
    text-align: left;
    font-size: 6pt;
    padding-left: 3px;
    background: #f0f4fa;
    font-weight: bold;
    color: #1a3a6b;
}

.historico-table .col-ano {
    width: 16mm;
}

.historico-table tbody td {
    height: 5.5mm;  /* células mais altas para legibilidade */
}

.historico-table tbody tr:nth-child(even) {
    background: #f7fafd;
}

/* ============================================================
   TABELA DE FALTAS (RODAPÉ) — COMPACTA E ELEGANTE
   ============================================================ */
.faltas-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 6pt;
    table-layout: fixed;
    border: 1px solid #1a3a6b;
}

.faltas-table th,
.faltas-table td {
    border: 1px solid #9fb0c8;
    padding: 2px 1px;
    text-align: center;
    overflow: hidden;
    white-space: nowrap;
}

.faltas-table thead th {
    background: linear-gradient(180deg, #fdf3e0, #f8e6c4);
    color: #8a6d1a;
    font-weight: bold;
    font-size: 5.5pt;
}

.faltas-table .col-desc {
    width: 22mm;
    text-align: left;
    font-size: 6pt;
    padding-left: 3px;
    background: #fdf9f0;
    font-weight: bold;
    color: #8a6d1a;
}

.faltas-table .col-ano {
    width: 16mm;
}

.faltas-table tbody td {
    height: 5.5mm;
}

.faltas-table tbody tr:nth-child(even) {
    background: #fefcf7;
}

/* ============================================================
   ASSINATURAS
   ============================================================ */
.signatures {
    display: flex;
    justify-content: space-between;
    margin-top: auto;
    padding-top: 6mm;
    flex-shrink: 0;
}

.signature-box {
    text-align: center;
    width: 45mm;
}

.signature-line {
    border-top: 1px solid #1a3a6b;
    margin-top: 10mm;
    padding-top: 2px;
    font-size: 8pt;
    color: #1a3a6b;
    font-weight: bold;
}

/* ============================================================
   OBSERVAÇÕES / DOCUMENTOS
   ============================================================ */
.observations {
    border: 1px solid #1a3a6b;
    border-radius: 4px;
    min-height: 20mm;
    padding: 3mm;
    font-size: 8.5pt;
    margin-top: 2mm;
    background: #fbfcfe;
}

.observations .check-item {
    margin-bottom: 4px;
    display: flex;
    align-items: center;
    gap: 5px;
}

.observations .checkbox {
    width: 3.5mm;
    height: 3.5mm;
    border: 1.5px solid #1a3a6b;
    border-radius: 2px;
    display: inline-block;
    flex-shrink: 0;
    background: #fff;
}

/* ============================================================
   NUMERAÇÃO DE PÁGINAS
   ============================================================ */
.page-number {
    position: absolute;
    bottom: 6mm;
    right: 10mm;
    font-size: 8pt;
    color: #1a3a6b;
    font-weight: bold;
    background: #f0f4fa;
    border: 1px solid #d0dae8;
    border-radius: 50%;
    width: 7mm;
    height: 7mm;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* ============================================================
   TRANSFERÊNCIAS
   ============================================================ */
.transfer-block {
    font-size: 7pt;
    line-height: 1.35;
}

.transfer-block h4 {
    font-size: 8pt;
    color: #1a3a6b;
    text-align: center;
    margin-bottom: 3px;
    border-bottom: 1px solid #c9a227;
    padding-bottom: 2px;
}

.transfer-block .dotted {
    border-bottom: 1px dotted #333;
    display: inline-block;
    min-width: 25mm;
}

/* ============================================================
   UTILIDADES
   ============================================================ */
.text-center { text-align: center; }
.text-right { text-align: right; }
.text-uppercase { text-transform: uppercase; }
.bold { font-weight: bold; }
.mt-1 { margin-top: 4px; }
.spacer { flex: 1; }

/* ============================================================
   IMPRESSÃO
   ============================================================ */
@media print {
    body { margin: 0; padding: 0; width: 420mm; height: 297mm; }
    .a3-page { margin: 0; padding: 0; width: 100%; height: 100%; }
    .a4-column { border-right: 1px dashed #b0b0b0; }
}
</style>
</head>
<body>

<!-- ============================================================ -->
<!-- A3 PAGE 1: PÁGINA 4 (esquerda) | PÁGINA 1 (direita)         -->
<!-- ============================================================ -->
<div class="a3-page">

    <!-- ============ COLUNA ESQUERDA — PÁGINA 4 ============ -->
    <div class="a4-column">
        <div class="content-area">

            <div class="section">
                <div class="section-title">
                    <span class="num">VII</span> Apreciação Geral e Transferências
                </div>
                <table class="table">
                    <tr>
                        <td style="width:8%">Ano Lectivo</td>
                        <td style="width:8%"></td>
                        <td rowspan="3" style="font-size:6.5pt; padding:3px;">
                            <div style="text-align:center;font-weight:bold;color:#1a3a6b;">Data</div>
                            <div style="text-align:center;">____/____/________</div>
                            <div style="margin-top:6px;font-size:6pt;text-align:center;">
                                Director de Turma<br>
                                <span style="display:inline-block;border-top:1px solid #333;width:32mm;margin-top:10px;"></span><br>
                                <em>(assinatura)</em>
                            </div>
                            <div style="margin-top:5px;font-size:6pt;text-align:center;">
                                Director da Escola<br>
                                <span style="display:inline-block;border-top:1px solid #333;width:32mm;margin-top:10px;"></span><br>
                                <em>(assinatura/Carimbo)</em>
                            </div>
                        </td>
                        <td rowspan="6" class="transfer-block">
                            <h4>TRANSFERÊNCIAS (Saída)</h4>
                            Em <span class="dotted"></span> foi transferido desta escola para
                            <span class="dotted"></span> província de <span class="dotted"></span>,
                            tendo levado consigo a seguinte documentação:
                            <div style="margin-top:3px;">1. _______________________________</div>
                            <div>2. _______________________________</div>
                            <div>3. _______________________________</div>
                            <div>4. _______________________________</div>
                            <div>5. _______________________________</div>
                            <div style="text-align:center;margin-top:6px;">
                                Director da Escola<br>
                                <span style="display:inline-block;border-top:1px solid #333;width:35mm;margin-top:12px;"></span><br>
                                <em>(Assinatura do Director / carimbo)</em>
                            </div>
                        </td>
                    </tr>
                    <tr><td>Classe</td><td></td></tr>
                    <tr><td>Turma</td><td></td></tr>
                    <tr>
                        <td>Ano Lectivo</td><td></td>
                        <td rowspan="3" style="font-size:6.5pt; padding:3px;">
                            <div style="text-align:center;font-weight:bold;color:#1a3a6b;">Data</div>
                            <div style="text-align:center;">____/____/________</div>
                            <div style="margin-top:6px;font-size:6pt;text-align:center;">
                                Director de Turma<br>
                                <span style="display:inline-block;border-top:1px solid #333;width:32mm;margin-top:10px;"></span><br>
                                <em>(assinatura)</em>
                            </div>
                            <div style="margin-top:5px;font-size:6pt;text-align:center;">
                                Director da Escola<br>
                                <span style="display:inline-block;border-top:1px solid #333;width:32mm;margin-top:10px;"></span><br>
                                <em>(assinatura/Carimbo)</em>
                            </div>
                        </td>
                    </tr>
                    <tr><td>Classe</td><td></td></tr>
                    <tr><td>Turma</td><td></td></tr>
                    <tr>
                        <td>Ano Lectivo</td><td></td>
                        <td rowspan="3" style="font-size:6.5pt; padding:3px;">
                            <div style="text-align:center;font-weight:bold;color:#1a3a6b;">Data</div>
                            <div style="text-align:center;">____/____/________</div>
                            <div style="margin-top:6px;font-size:6pt;text-align:center;">
                                Director de Turma<br>
                                <span style="display:inline-block;border-top:1px solid #333;width:32mm;margin-top:10px;"></span><br>
                                <em>(assinatura)</em>
                            </div>
                            <div style="margin-top:5px;font-size:6pt;text-align:center;">
                                Director da Escola<br>
                                <span style="display:inline-block;border-top:1px solid #333;width:32mm;margin-top:10px;"></span><br>
                                <em>(assinatura/Carimbo)</em>
                            </div>
                        </td>
                        <td rowspan="6" class="transfer-block">
                            <h4>TRANSFERÊNCIAS (Entrada)</h4>
                            <div style="text-align:center;">
                                Em ____/____/________ veio transferido para esta Escola,
                                trazendo guia de transferência n.º <span class="dotted"></span>,
                                passada pela Direcção de Educação de
                                <span class="dotted"></span>, província de
                                <span class="dotted"></span>.
                            </div>
                            <div style="text-align:center;margin-top:8px;">
                                Director da Escola<br>
                                <span style="display:inline-block;border-top:1px solid #333;width:35mm;margin-top:12px;"></span><br>
                                <em>(assinatura do director / Carimbo)</em><br>
                                <span style="margin-top:4px;display:inline-block;">____/____/________</span>
                            </div>
                        </td>
                    </tr>
                    <tr><td>Classe</td><td></td></tr>
                    <tr><td>Turma</td><td></td></tr>
                    <tr>
                        <td>Ano Lectivo</td><td></td>
                        <td rowspan="3" style="font-size:6.5pt; padding:3px;">
                            <div style="text-align:center;font-weight:bold;color:#1a3a6b;">Data</div>
                            <div style="text-align:center;">____/____/________</div>
                            <div style="margin-top:6px;font-size:6pt;text-align:center;">
                                Director de Turma<br>
                                <span style="display:inline-block;border-top:1px solid #333;width:32mm;margin-top:10px;"></span><br>
                                <em>(assinatura)</em>
                            </div>
                            <div style="margin-top:5px;font-size:6pt;text-align:center;">
                                Director da Escola<br>
                                <span style="display:inline-block;border-top:1px solid #333;width:32mm;margin-top:10px;"></span><br>
                                <em>(assinatura/Carimbo)</em>
                            </div>
                        </td>
                    </tr>
                    <tr><td>Classe</td><td></td></tr>
                    <tr><td>Turma</td><td></td></tr>
                </table>
            </div>

            <div class="section">
                <div class="section-title">
                    <span class="num">IX</span> Documentos Anexos
                </div>
                <div class="observations">
                    <div class="check-item"><span class="checkbox"></span> <strong>Cópia do Bilhete de Identidade</strong></div>
                    <div class="check-item"><span class="checkbox"></span> <strong>Certificado de Habilitações Anteriores</strong></div>
                    <div class="check-item"><span class="checkbox"></span> <strong>Fotografias 3,5x4,5 cm</strong> (2 unidades)</div>
                    <div class="check-item"><span class="checkbox"></span> <strong>Declaração Médica</strong></div>
                    <div class="check-item"><span class="checkbox"></span> <strong>Comprovativo de Residência</strong></div>
                    <div class="check-item"><span class="checkbox"></span> <strong>Outros documentos:</strong></div>
                    <div style="height: 30mm; border: 1px dotted #6b7c93; border-radius: 3px; padding: 2mm; background: #fff;">
                        ________________________________<br>
                        ________________________________<br>
                        ________________________________
                    </div>
                </div>
            </div>
        </div>

        <div class="signatures">
            <div class="signature-box">
                <div class="signature-line">Arquivista</div>
            </div>
            <div class="signature-box">
                <div class="signature-line">Data: ____/____/________</div>
            </div>
        </div>

        <div class="page-number">4</div>
    </div>

    <!-- ============ COLUNA DIREITA — PÁGINA 1 ============ -->
    <div class="a4-column">
        <div class="content-area">

            <!-- CABEÇALHO OFICIAL -->
            <div class="header">
                <img src="{{ asset('logoTipo/simboloR.png') }}" class="logo-top" alt="Brasão">
                <h1>República de Moçambique</h1>
                <div class="divider"></div>
                <div class="subtitle bold">MINISTÉRIO DA EDUCAÇÃO</div>
                <div class="subtitle">PROCESSO INDIVIDUAL DO ALUNO</div>
            </div>

            <!-- FOTO DO ALUNO -->
            <div class="photo-container">
                @if(!empty($aluno->avatar))
                    <img src="{{ asset('storage/' . $subdomain . '/fotoAluno/' . $aluno->avatar) }}" alt="Foto do aluno">
                @else
                    <div class="placeholder">
                        FOTOGRAFIA<br>(3,5 x 4,5 cm)
                    </div>
                @endif
            </div>

            <!-- INFO DA ESCOLA -->
            <div class="school-info">
                <div class="logo">
                    @if(!empty($conf->avatar))
                        <img src="{{ asset('storage/' . $subdomain . '/logoMarca/' . $conf->avatar) }}" alt="{{ $conf->nome }}">
                    @else
                        <div style="padding:3px; font-weight:700; color:#6b7c93; font-size:6pt;">LOGO</div>
                    @endif
                </div>
                <div class="info-body">
                    <div class="school-name">{{ $conf->nome ?? 'ESCOLA' }}</div>
                    <div class="row">
                        <div class="label">Província:</div>
                        <div class="field-value">{{ $conf->Provincia ?? '' }}</div>
                        <div class="label" style="min-width:15mm;">Distrito:</div>
                        <div class="field-value">{{ $conf->Distrito ?? '' }}</div>
                    </div>
                    <div class="row">
                        <div class="label">Bairro:</div>
                        <div class="field-value">{{ $conf->Localizacao ?? '' }}</div>
                        <div class="label" style="min-width:15mm;">Telefone:</div>
                        <div class="field-value">{{ $conf->Contacto ?? '' }}/{{ $conf->Contacto2 ?? '' }}</div>
                    </div>
                    <div class="row">
                        <div class="label">Email:</div>
                        <div class="field-value">{{ $conf->Email ?? 'EMAIL' }}</div>
                    </div>
                </div>
            </div>

            <!-- I — IDENTIFICAÇÃO -->
            <div class="section">
                <div class="section-title"><span class="num">I</span> Identificação Pessoal</div>

                <div class="data-field">
                    <div class="field-label">N.º do processo:</div>
                    <div class="field-value bold text-uppercase">{{ $processo_id ?? $alunoId ?? '' }}</div>
                </div>
                <div class="data-field">
                    <div class="field-label">Nome completo:</div>
                    <div class="field-value bold text-uppercase">{{ $aluno->nome ?? '' }}</div>
                </div>
                <div class="data-field">
                    <div class="field-label">Data de nascimento:</div>
                    <div class="field-value">{{ isset($aluno->dataNascimento) ? Carbon::parse($aluno->dataNascimento)->format('d/m/Y') : '' }}</div>
                    <div class="field-label" style="min-width:10mm; margin-left:4mm;">Idade:</div>
                    <div class="field-value" style="min-width:16mm;">{{ isset($aluno->dataNascimento) ? Carbon::parse($aluno->dataNascimento)->age . ' anos' : '' }}</div>
                </div>
                <div class="data-field">
                    <div class="field-label">Naturalidade:</div>
                    <div class="field-value">{{ $naturalidade->nome ?? '' }}</div>
                    <div class="field-label" style="min-width:10mm; margin-left:4mm;">Sexo:</div>
                    <div class="field-value" style="min-width:14mm;">{{ $aluno->sexo ?? '' }}</div>
                </div>
                <div class="data-field">
                    <div class="field-label">Nome do pai:</div>
                    <div class="field-value text-uppercase">{{ $nomePai->nome ?? '' }}</div>
                </div>
                <div class="data-field">
                    <div class="field-label">Nome da mãe:</div>
                    <div class="field-value text-uppercase">{{ $nome_mae->nome ?? '' }}</div>
                </div>
                <div class="data-field">
                    <div class="field-label">Documento de identificação:</div>
                    <div class="field-value">{{ ($aluno->documento_tipo ?? '') }} — {{ $aluno->documento_num ?? '' }}</div>
                </div>
            </div>

            <!-- III — ENDEREÇO -->
            <div class="section">
                <div class="section-title"><span class="num">III</span> Endereço e Contactos</div>
                <div class="data-field">
                    <div class="field-label">Bairro/Localidade:</div>
                    <div class="field-value">{{ $aluno->Bairo->Endereco ?? '' }}</div>
                    <div class="field-label">Rua/Avenida:</div>
                    <div class="field-value">{{ $aluno->Bairo->RuaAvenida ?? '' }}</div>
                </div>
                <div class="data-field">
                    <div class="field-label">N.º casa/Quarteirão:</div>
                    <div class="field-value">{{ $aluno->Casa ?? '' }} / {{ $aluno->Quarterao ?? '' }}</div>
                    <div class="field-label">Contactos:</div>
                    <div class="field-value">
                        @if(!empty($aluno->encaregado->contacto) && count($aluno->encaregado->contacto))
                            @foreach($aluno->encaregado->contacto as $c)
                                {{ $c->Descricao }}@if(!$loop->last), @endif
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>

            <!-- IV — ENCARREGADO -->
            <div class="section">
                <div class="section-title"><span class="num">IV</span> Encarregado de Educação</div>
                <div class="data-field">
                    <div class="field-label">Nome:</div>
                    <div class="field-value bold text-uppercase">{{ $aluno->encaregado->nome ?? '' }}</div>
                    <div class="field-label">Parentesco:</div>
                    <div class="field-value">{{ $aluno->graoparentesto->Descricao ?? '' }}</div>
                </div>
                <div class="data-field">
                    <div class="field-label">Profissão:</div>
                    <div class="field-value">{{ $aluno->encaregado->profissao->Descricao ?? '' }}</div>
                    <div class="field-label" style="min-width:15mm; margin-left:4mm;">Religião:</div>
                    <div class="field-value" style="min-width:20mm;">{{ $aluno->encaregado->religiao->nome ?? '' }}</div>
                </div>
            </div>

            <!-- HISTÓRICO ESCOLAR -->
            <div class="section">
                <div class="section-title"><span class="num">📘</span> Histórico Escolar — Classes Frequentadas</div>
                <table class="table">
                    <thead>
                        <tr>
                            <th rowspan="2">Ano Lectivo</th>
                            <th rowspan="2">Classe</th>
                            <th rowspan="2">Estabelecimento de Ensino</th>
                            <th colspan="3">Endereço</th>
                            <th rowspan="2">Turma</th>
                        </tr>
                        <tr>
                            <th>Província</th><th>Distrito</th><th>AV/Bairro</th>
                        </tr>
                    </thead>
                    <tbody>
                        @for($x = 1; $x < 13; $x++)
                            @php $dadolinha = $dadosAnterior->where("Classe_id", $x)->first(); @endphp
                            <tr>
                                <td class="text-center">{{ $dadolinha->anolectivo ?? '—' }}</td>
                                <td class="text-center">{{ $dadolinha->classe ?? '—' }}</td>
                                <td>{{ !empty($dadolinha) ? $conf->nome : '' }}</td>
                                <td>{{ !empty($dadolinha) ? $conf->Provincia : '' }}</td>
                                <td>{{ !empty($dadolinha) ? $conf->Distrito : '' }}</td>
                                <td>{{ !empty($dadolinha) ? $conf->Localizacao : '' }}</td>
                                <td></td>
                            </tr>
                        @endfor
                    </tbody>
                </table>
            </div>
        </div>

        <div class="signatures">
            <div class="signature-box">
                <div class="signature-line">Director do Estabelecimento</div>
            </div>
            <div class="signature-box">
                <div class="signature-line">Encarregado de Educação</div>
            </div>
        </div>

        <div class="page-number">1</div>
    </div>
</div>

<!-- ============================================================ -->
<!-- A3 PAGE 2: PÁGINA 2 (esquerda) | PÁGINA 3 (direita)         -->
<!-- ============================================================ -->
<div class="a3-page">

    <!-- ============ COLUNA ESQUERDA — PÁGINA 2 ============ -->
    <div class="a4-column">
        <div class="content-area">

            <!-- V — HISTÓRICO ACADÉMICO (10 ANOS) — CÉLULAS MAIORES -->
            <div class="section">
                <div class="section-title">
                    <span class="num">V</span> Histórico Académico (5 Anos Lectivos)
                </div>
                <table class="historico-table">
                    <thead>
                        <tr>
                            <th class="col-disciplina" rowspan="2">Disciplina</th>
                            @for ($ano = 0; $ano < 5; $ano++)
                                <th class="col-ano" colspan="4">{{ $anosLectivos[$ano] }}</th>
                            @endfor
                        </tr>
                        <tr>
                            @for ($ano = 0; $ano < 5; $ano++)
                                <th>1ºT</th><th>2ºT</th><th>3ºT</th><th>MF</th>
                            @endfor
                        </tr>
                        <tr>
                            <th class="col-disciplina">Classe</th>
                            @for ($ano = 0; $ano < 5; $ano++)
                                <th colspan="4">___</th>
                            @endfor
                        </tr>
                        <tr>
                            <th class="col-disciplina">Turma</th>
                            @for ($ano = 0; $ano < 5; $ano++)
                                <th colspan="4">___</th>
                            @endfor
                        </tr>
                    </thead>
                    <tbody>
                        @for($x = 0; $x < count($disciplinas); $x++)
                            <tr>
                                <td class="col-disciplina">{{ $disciplinas[$x]->Descricao }}</td>
                                @for ($ano = 0; $ano < 5; $ano++)
                                    <td></td><td></td><td></td><td></td>
                                @endfor
                            </tr>
                        @endfor
                        <tr>
                            <td class="col-disciplina"><strong>Comportamento</strong></td>
                            @for ($ano = 0; $ano < 5; $ano++)
                                <td colspan="4"></td>
                            @endfor
                        </tr>
                        <tr>
                            <td class="col-disciplina"><strong>Data/Assinatura<br>Director de Turma</strong></td>
                            @for ($ano = 0; $ano < 5; $ano++)
                                <td colspan="4" style="padding-top:18px;">____/____/____</td>
                            @endfor
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- ESPAÇO FLEXÍVEL -->
            <div class="spacer"></div>

            <!-- V — HISTÓRICO DE FALTAS (RODAPÉ DA PÁGINA 2) -->
            <div class="section" style="margin-bottom:0; margin-top:6px;">
                <div class="section-title" style="background: linear-gradient(90deg, #8a6d1a, #c9a227);">
                    <span class="num" style="background:#fff; color:#8a6d1a;">V</span> Histórico de Faltas (5 Anos Lectivos)
                </div>
                <table class="faltas-table">
                    <thead>
                        <tr>
                            <th class="col-desc" rowspan="2">Descrição</th>
                            @for ($ano = 0; $ano < 5; $ano++)
                                <th class="col-ano" colspan="4">{{ $anosLectivos[$ano] }}</th>
                            @endfor
                        </tr>
                        <tr>
                            @for ($ano = 0; $ano < 5; $ano++)
                                <th>1ºT</th><th>2ºT</th><th>3ºT</th><th>S</th>
                            @endfor
                        </tr>
                        <tr>
                            <th class="col-desc">Classe</th>
                            @for ($ano = 0; $ano < 5; $ano++)
                                <th colspan="4">___</th>
                            @endfor
                        </tr>
                        <tr>
                            <th class="col-desc">Turma</th>
                            @for ($ano = 0; $ano < 5; $ano++)
                                <th colspan="4">___</th>
                            @endfor
                        </tr>
                    </thead>
                    <tbody>
                        @for($iy = 0; $iy < 2; $iy++)
                            <tr>
                                <td class="col-desc">{{ $faltas[$iy] ?? '- ' }}</td>
                                @for ($ano = 0; $ano < 5; $ano++)
                                    <td></td><td></td><td></td><td></td>
                                @endfor
                            </tr>
                        @endfor
                        <tr>
                            <td class="col-desc"><strong>Comportamento</strong></td>
                            @for ($ano = 0; $ano < 5; $ano++)
                                <td colspan="4"></td>
                            @endfor
                        </tr>
                        <tr>
                            <td class="col-desc"><strong>Data/Assinatura<br>Director de Turma</strong></td>
                            @for ($ano = 0; $ano < 5; $ano++)
                                <td colspan="4" style="padding-top:18px;">____/____/____</td>
                            @endfor
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="page-number">2</div>
    </div>

    <!-- ============ COLUNA DIREITA — PÁGINA 3 ============ -->
    <div class="a4-column">
        <div class="content-area">

            <!-- V — HISTÓRICO ACADÉMICO (CONTINUAÇÃO) -->
            <div class="section">
                <div class="section-title">
                    <span class="num">V</span> Histórico Académico (Continuação)
                </div>
                <table class="historico-table">
                    <thead>
                        <tr>
                            <th class="col-disciplina" rowspan="2">Disciplina</th>
                            @for ($ano = 0; $ano < 5; $ano++)
                                <th class="col-ano" colspan="4">{{ $anosLectivos[$ano] }}</th>
                            @endfor
                        </tr>
                        <tr>
                            @for ($ano = 0; $ano < 5; $ano++)
                                <th>1ºT</th><th>2ºT</th><th>3ºT</th><th>MF</th>
                            @endfor
                        </tr>
                        <tr>
                            <th class="col-disciplina">Classe</th>
                            @for ($ano = 0; $ano < 5; $ano++)
                                <th colspan="4">___</th>
                            @endfor
                        </tr>
                        <tr>
                            <th class="col-disciplina">Turma</th>
                            @for ($ano = 0; $ano < 5; $ano++)
                                <th colspan="4">___</th>
                            @endfor
                        </tr>
                    </thead>
                    <tbody>
                        @for($iy = 0; $iy < count($disciplinas); $iy++)
                            <tr>
                                <td class="col-disciplina">{{ $disciplinas[$iy]->Descricao ?? '- ' }}</td>
                                @for ($ano = 0; $ano < 5; $ano++)
                                    <td></td><td></td><td></td><td></td>
                                @endfor
                            </tr>
                        @endfor
                        <tr>
                            <td class="col-disciplina"><strong>Comportamento</strong></td>
                            @for ($ano = 0; $ano < 5; $ano++)
                                <td colspan="4"></td>
                            @endfor
                        </tr>
                        <tr>
                            <td class="col-disciplina"><strong>Data/Assinatura<br>Director de Turma</strong></td>
                            @for ($ano = 0; $ano < 5; $ano++)
                                <td colspan="4" style="padding-top:18px;">____/____/____</td>
                            @endfor
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- ESPAÇO FLEXÍVEL -->
            <div class="spacer"></div>

            
          <div class="spacer"></div>

            <!-- V — HISTÓRICO DE FALTAS (RODAPÉ DA PÁGINA 2) -->
            <div class="section" style="margin-bottom:0; margin-top:6px;">
                <div class="section-title" style="background: linear-gradient(90deg, #8a6d1a, #c9a227);">
                    <span class="num" style="background:#fff; color:#8a6d1a;">V</span> Histórico de Faltas (5 Anos Lectivos)
                </div>
                <table class="faltas-table">
                    <thead>
                        <tr>
                            <th class="col-desc" rowspan="2">Descrição</th>
                            @for ($ano = 0; $ano < 5; $ano++)
                                <th class="col-ano" colspan="4">{{ $anosLectivos[$ano] }}</th>
                            @endfor
                        </tr>
                        <tr>
                            @for ($ano = 0; $ano < 5; $ano++)
                                <th>1ºT</th><th>2ºT</th><th>3ºT</th><th>S</th>
                            @endfor
                        </tr>
                        <tr>
                            <th class="col-desc">Classe</th>
                            @for ($ano = 0; $ano < 5; $ano++)
                                <th colspan="4">___</th>
                            @endfor
                        </tr>
                        <tr>
                            <th class="col-desc">Turma</th>
                            @for ($ano = 0; $ano < 5; $ano++)
                                <th colspan="4">___</th>
                            @endfor
                        </tr>
                    </thead>
                    <tbody>
                        @for($iy = 0; $iy < 2; $iy++)
                            <tr>
                                <td class="col-desc">{{ $faltas[$iy] ?? '- ' }}</td>
                                @for ($ano = 0; $ano < 5; $ano++)
                                    <td></td><td></td><td></td><td></td>
                                @endfor
                            </tr>
                        @endfor
                        <tr>
                            <td class="col-desc"><strong>Comportamento</strong></td>
                            @for ($ano = 0; $ano < 5; $ano++)
                                <td colspan="4"></td>
                            @endfor
                        </tr>
                        <tr>
                            <td class="col-desc"><strong>Data/Assinatura<br>Director de Turma</strong></td>
                            @for ($ano = 0; $ano < 5; $ano++)
                                <td colspan="4" style="padding-top:18px;">____/____/____</td>
                            @endfor
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="signatures">
            <div class="signature-box">
                <div class="signature-line">Director da Escola</div>
            </div>
            <div class="signature-box">
                <div class="signature-line">Data: ____/____/________</div>
            </div>
        </div>

        <div class="page-number">3</div>
    </div>
</div>

</body>
</html>