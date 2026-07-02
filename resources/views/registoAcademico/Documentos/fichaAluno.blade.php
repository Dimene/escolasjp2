<!DOCTYPE html>
<html lang="pt">
<head>
<meta charset="UTF-8">
<title>Ficha Individual do Aluno</title>
@php
use Carbon\Carbon;
$conf = $conf ?? DB::table('config')->first();
$currentYear = now()->year;
$alunoId = $aluno->id ?? null;


$request =Request();
    $host = $request->getHost();

    $subdomain = explode('.', $host)[0];

@endphp
<style>
/* ================== GERAL ================== */
body {
    font-family: "Times New Roman", serif;
    font-size: 12pt;
    color: #000;
    margin: 20px;
}

.print-section {
    border: 1px solid #000;
    padding: 12px;
    margin-bottom: 15px;
}

.section-title {
    background: #eee;
    padding: 6px 8px;
    font-weight: bold;
    border-left: 5px solid #000;
    margin-bottom: 10px;
    text-transform: uppercase;
}

.row {
    display: flex;
    flex-wrap: wrap;
    margin-bottom: 8px;
    align-items: center;
}

.label {
    font-weight: bold;
    min-width: 40mm;
    width: 40mm;
}

.field-value {
    flex: 1;
    border-bottom: 1px dotted #000;
    min-height: 20px;
    padding: 2px 0;
    margin-left: 5px;
}

.field-filled {
    border-bottom: 1px solid #000;
    font-weight: normal;
}

.grid-2 {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 15px;
}

.grid-3 {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 10px;
}

.grid-4 {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 8px;
}

.checkbox-group {
    display: flex;
    gap: 25px;
    margin-top: 5px;
}

.checkbox-item {
    display: flex;
    align-items: center;
    gap: 5px;
}

.checkbox-box {
    width: 14px;
    height: 14px;
    border: 1px solid #000;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 11px;
}

.photo-box {
    width: 35mm;
    height: 45mm;
    border: 2px solid #000;
    text-align: center;
    font-size: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f8f8f8;
}

.photo-box img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.signature-area {
    margin-top: 40px;
    text-align: center;
}

.signature-line {
    width: 200px;
    border-bottom: 1px solid #000;
    margin: 30px auto 5px;
    display: inline-block;
}

.footer {
    text-align: center;
    font-size: 10px;
    margin-top: 30px;
    border-top: 1px solid #ccc;
    padding-top: 10px;
}

.contact-grid {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr;
    gap: 10px;
    margin-top: 10px;
}

.contact-item {
    display: flex;
    align-items: center;
    gap: 5px;
}

/* ================== CABEÇALHO ================== */
.header {
    border: 2px solid #000;
    padding: 10px;
    margin-bottom: 15px;
    background: #f8f8f8;
}

.header h1 {
    margin: 0;
    font-size: 18pt;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.subtitle {
    font-size: 11pt;
    font-weight: bold;
}

/* ================== MARCA D'ÁGUA ================== */
.watermark {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%) rotate(-45deg);
    font-size: 80px;
    color: rgba(0,0,0,0.06);
    z-index: -1;
    opacity: 0.5;
}

/* ================== TABELA ================== */
.print-table {
    width: 100%;
    border-collapse: collapse;
    margin: 15px 0;
    font-size: 11pt;
}

.print-table th {
    background: #eee;
    border: 1px solid #000;
    padding: 6px;
    text-align: left;
    font-weight: bold;
}

.print-table td {
    border: 1px solid #000;
    padding: 6px;
}

.print-table tr.total-row {
    background: #000;
    color: white;
    font-weight: bold;
}

/* ================== PRINT ================== */
@media print {
    button {
        display: none;
    }

    @page {
        margin: 15mm;
    }

    .page-break {
        page-break-before: always;
    }
}
</style>
</head>

<body>

<div class="watermark">
    FICHA DO ALUNO
</div>

<button onclick="window.print()" style="position:fixed; top:20px; right:20px; padding:10px 20px; background:#007bff; color:white; border:none; border-radius:5px; cursor:pointer; z-index:1000;">
    📄 Imprimir
</button>

<!-- ================== CABEÇALHO ================== -->
<div class="header">
    <div style="display:flex; align-items:center; justify-content:space-between;">
        <!-- Logo do País -->
        <div style="width:30mm;">
            <img src="{{ asset('logoTipo/simboloR.png') }}" style="width:25mm; height:auto;">
        </div>

        <!-- Texto Central -->
        <div style="text-align:center; flex:1;">
            <h1>FICHA INDIVIDUAL DO ALUNO</h1>
            <div class="subtitle">
                {{ strtoupper($conf->nome ?? 'ESTABELECIMENTO DE ENSINO') }}
            </div>
            <div style="font-size:10pt;">Ministério da Educação e Desenvolvimento Humano</div>
            <div style="font-size:9pt; margin-top:5px;">
                Ano Lectivo: {{ $aluno->anolectivo ?? '________' }} | Classe: {{ $aluno->classe ?? '________' }}
            </div>
        </div>

        <!-- Logo da Escola -->
        <div style="width:30mm; text-align:right;">
            @if(!empty($conf->avatar))
                <img src="{{ asset('storage/logoMarca/' . $conf->avatar) }}"
                     style="width:25mm; height:auto;">
            @endif
        </div>
    </div>
</div>

<!-- ================== DADOS DA ESCOLA ================== -->
<div class="print-section">
    <div class="row">
        <div class="label">Província:</div>
        <div class="field-value field-filled">{{ $conf->Provincia ?? '____________________' }}</div>

        <div class="label">Distrito:</div>
        <div class="field-value field-filled">{{ $conf->Distrito ?? '____________________' }}</div>
    </div>

    <div class="row">
        <div class="label">Endereço:</div>
        <div class="field-value field-filled">{{ $conf->Endereco ?? '____________________' }}</div>

        <div class="label">Contacto:</div>
        <div class="field-value field-filled">{{ $conf->Contacto ?? '____________________' }}</div>
    </div>

    <div class="row">
        <div class="label">Email:</div>
        <div class="field-value field-filled">{{ $conf->Email ?? '____________________' }}</div>

        <div class="label">Website:</div>
        <div class="field-value field-filled">{{ $conf->Website ?? '____________________' }}</div>
    </div>
</div>

<!-- ================== IDENTIFICAÇÃO DO ALUNO ================== -->
<div class="print-section">
    <div class="section-title">Identificação do Aluno</div>

    <div class="grid-2">
        <div>
            <div class="row">
                <div class="label">Nº de Matrícula:</div>
                <div class="field-value field-filled">{{ $aluno->id ?? '________' }}</div>
            </div>

            <div class="row">
                <div class="label">Nome Completo:</div>
                <div class="field-value field-filled">{{ $aluno->nome ?? '_____________________________' }}</div>
            </div>

            <div class="row">
                <div class="label">Data de Nascimento:</div>
                <div class="field-value field-filled">{{ $dataNascimentoFormatada ?? '____/____/______' }}</div>
            </div>

            <div class="row">
                <div class="label">Idade:</div>
                <div class="field-value field-filled">{{ $idade ?? '____' }} anos</div>
            </div>

            <div class="row">
                <div class="label">Sexo:</div>
                <div class="checkbox-group">
                    <div class="checkbox-item">
                        <span class="checkbox-box">
                            @if($aluno->sexo === 'Masculino') ✔ @endif
                        </span> Masculino
                    </div>
                    <div class="checkbox-item">
                        <span class="checkbox-box">
                            @if($aluno->sexo === 'Feminino') ✔ @endif
                        </span> Feminino
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="label">Naturalidade:</div>
                <div class="field-value">____________________</div>
            </div>

            <div class="row">
                <div class="label">Nacionalidade:</div>
                <div class="field-value">____________________</div>
            </div>

            <div class="row">
                <div class="label">Bilhete de Identidade:</div>
                <div class="field-value">____________________</div>
            </div>
        </div>

        <div style="display:flex; justify-content:center; align-items:flex-start;">
            <div class="photo-box">
                @if(isset($aluno->avatar) && $aluno->avatar)
                    <img src="/storage/{{ $subdomain }}/fotoAluno/{{ $aluno->avatar }}"
                         alt="Foto do Aluno">
                @else
                    <div style="padding: 10px;">
                        FOTO 3x4<br>
                        (Colocar aqui)
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- ================== ENDEREÇO E CONTACTOS ================== -->
<div class="print-section">
    <div class="section-title">Endereço e Contactos</div>

    <div class="grid-2">
        <div>
            <div class="row">
                <div class="label">Bairro:</div>
                <div class="field-value field-filled">{{ $aluno->Endereco ?? '____________________' }}</div>
            </div>

            <div class="row">
                <div class="label">Rua/Avenida:</div>
                <div class="field-value field-filled">{{ $aluno->RuaAvenida ?? '____________________' }}</div>
            </div>

            <div class="row">
                <div class="label">Casa Nº:</div>
                <div class="field-value field-filled">{{ $aluno->Casa ?? '______' }}</div>
            </div>

            <div class="row">
                <div class="label">Quarteirão:</div>
                <div class="field-value field-filled">{{ $aluno->Quarterao ?? '______' }}</div>
            </div>
        </div>

        <div>
            <div class="row">
                <div class="label">Província:</div>
                <div class="field-value">____________________</div>
            </div>

            <div class="row">
                <div class="label">Distrito:</div>
                <div class="field-value">____________________</div>
            </div>

            <div class="row">
                <div class="label">Localidade:</div>
                <div class="field-value">____________________</div>
            </div>

            <div class="row">
                <div class="label">E-mail:</div>
                <div class="field-value">_____________________________</div>
            </div>
        </div>
    </div>

    <div style="margin-top: 15px;">
        <div class="row">
            <div class="label">Contactos de Emergência:</div>
        </div>
        <div class="contact-grid">
            <div class="contact-item">
                <span class="label" style="min-width: auto; width: auto;">1:</span>
                <div class="field-value field-filled">{{ $aluno->Contacto1 ?? '____________________' }}</div>
            </div>
            <div class="contact-item">
                <span class="label" style="min-width: auto; width: auto;">2:</span>
                <div class="field-value field-filled">{{ $aluno->Contacto2 ?? '____________________' }}</div>
            </div>
            <div class="contact-item">
                <span class="label" style="min-width: auto; width: auto;">3:</span>
                <div class="field-value field-filled">{{ $aluno->Contacto3 ?? '____________________' }}</div>
            </div>
        </div>
    </div>
</div>

<!-- ================== DADOS ACADÉMICOS ================== -->
<div class="print-section">
    <div class="section-title">Dados Académicos</div>

    <div class="grid-4">
        <div class="row">
            <div class="label">Classe:</div>
            <div class="field-value field-filled">{{ $aluno->classe ?? '________' }}</div>
        </div>

        <div class="row">
            <div class="label">Tipo de Aluno:</div>
            <div class="field-value field-filled">{{ $tipoAluno ?? '________' }}</div>
        </div>

        <div class="row">
            <div class="label">Ano Lectivo:</div>
            <div class="field-value field-filled">{{ $aluno->anolectivo ?? '________' }}</div>
        </div>

        <div class="row">
            <div class="label">Estado:</div>
            <div class="field-value field-filled">{{ $statusTexto ?? '________' }}</div>
        </div>
    </div>

    <div class="grid-2" style="margin-top: 10px;">
        <div>
            <div class="row">
                <div class="label">Data de Ingresso:</div>
                <div class="field-value">____/____/______</div>
            </div>

            <div class="row">
                <div class="label">Escola Anterior:</div>
                <div class="field-value">_____________________________</div>
            </div>
        </div>

        <div>
            <div class="row">
                <div class="label">Classe Anterior:</div>
                <div class="field-value">________</div>
            </div>

            <div class="row">
                <div class="label">Transferência de:</div>
                <div class="field-value">_____________________________</div>
            </div>
        </div>
    </div>
</div>

<!-- ================== INFORMAÇÃO DA FAMÍLIA ================== -->
<div class="print-section">
    <div class="section-title">Informação da Família</div>

    <div class="grid-3">
        <!-- ENCARREGADO DE EDUCAÇÃO -->
        <div>
            <h4 style="margin: 10px 0 5px 0; text-decoration: underline;">ENCARREGADO DE EDUCAÇÃO</h4>

            <div class="row">
                <div class="label">Nome:</div>
                <div class="field-value field-filled">{{ $aluno->Encaregado ?? '_____________________________' }}</div>
            </div>

            <div class="row">
                <div class="label">Parentesco:</div>
                <div class="field-value field-filled">{{ $aluno->GrauParentesco ?? '_________________' }}</div>
            </div>

            <div class="row">
                <div class="label">Profissão:</div>
                <div class="field-value field-filled">{{ $aluno->profissaoEncaregado ?? '_____________________________' }}</div>
            </div>

            <div class="row">
                <div class="label">Local Trabalho:</div>
                <div class="field-value">_____________________________</div>
            </div>

            <div class="row">
                <div class="label">Religião:</div>
                <div class="field-value field-filled">{{ $aluno->Religiao_Encaregado ?? '_________________' }}</div>
            </div>
        </div>

        <!-- PAI -->
        <div>
            <h4 style="margin: 10px 0 5px 0; text-decoration: underline;">PAI DO EDUCANDO</h4>

            <div class="row">
                <div class="label">Nome:</div>
                <div class="field-value field-filled">{{ $aluno->nome_pai ?? '_____________________________' }}</div>
            </div>

            <div class="row">
                <div class="label">Profissão:</div>
                <div class="field-value field-filled">{{ $aluno->pai_profissao ?? '_____________________________' }}</div>
            </div>

            @for ($i = 1; $i <= 3; $i++)
                @if ($aluno->{'contacto_pai' . $i})
                <div class="row">
                    <div class="label">Contacto {{ $i }}:</div>
                    <div class="field-value field-filled">{{ $aluno->{'contacto_pai'.$i} }}</div>
                </div>
                @endif
            @endfor

            <div class="row">
                <div class="label">Nível Académico:</div>
                <div class="field-value">_____________________________</div>
            </div>
        </div>

        <!-- MÃE -->
        <div>
            <h4 style="margin: 10px 0 5px 0; text-decoration: underline;">MÃE DO EDUCANDO</h4>

            <div class="row">
                <div class="label">Nome:</div>
                <div class="field-value field-filled">{{ $aluno->nome_mae ?? '_____________________________' }}</div>
            </div>

            <div class="row">
                <div class="label">Profissão:</div>
                <div class="field-value field-filled">{{ $aluno->mae_profissao ?? '_____________________________' }}</div>
            </div>

            @for ($i = 1; $i <= 3; $i++)
                @if ($aluno->{'contacto_mae' . $i})
                <div class="row">
                    <div class="label">Contacto {{ $i }}:</div>
                    <div class="field-value field-filled">{{ $aluno->{'contacto_mae'.$i} }}</div>
                </div>
                @endif
            @endfor

            <div class="row">
                <div class="label">Nível Académico:</div>
                <div class="field-value">_____________________________</div>
            </div>
        </div>
    </div>
</div>

<!-- ================== HISTÓRICO DE PAGAMENTOS ================== -->
{{-- @if(count($dadosmatricula) > 0)
<div class="print-section">
    <div class="section-title">Histórico de Pagamentos</div>

    <table class="print-table">
        <thead>
            <tr>
                <th>Tipo</th>
                <th>Mês/Descrição</th>
                <th>Valor</th>
                <th>Multa</th>
                <th>Método</th>
                <th>Referência</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @php
                $valortotal = 0;
            @endphp

            <!-- Matrícula -->
            <tr style="background: #f0f0f0;">
                <td colspan="7" style="font-weight: bold;">
                    {{ $aluno->tipopagamentoNome ?? 'MATRÍCULA' }}
                </td>
            </tr>
            <tr>
                <td>Matrícula</td>
                <td>{{ $aluno->mesNome ?? 'Matrícula' }}</td>
                <td>{{ number_format($aluno->valorDescricao ?? 0, 2, ',', '.') }} MT</td>
                <td>{{ number_format($aluno->Multa ?? 0, 2, ',', '.') }} MT</td>
                <td>{{ $aluno->metodo_pagamento_desc ?? '_________' }}</td>
                <td>{{ $aluno->referencia ?? '_________' }}</td>
                <td style="text-align: center;">
                    @if(($aluno->Estado_Classe ?? '') == 'Pago')
                        <span style="color: green; font-weight: bold;">✓ PAGO</span>
                    @else
                        <span style="color: red;">PENDENTE</span>
                    @endif
                </td>
            </tr>
            @php
                $valortotal += (float) ($aluno->valorDescricao ?? 0) + (float) ($aluno->Multa ?? 0);
            @endphp

            <!-- Mensalidades -->
            @foreach($dadosmatricula as $pg)
                @if(isset($pg['Descrica']) && isset($pg['pagasNodia']))
                <tr style="background: #f0f0f0;">
                    <td colspan="7" style="font-weight: bold;">
                        {{ $pg['Descrica'] }}
                    </td>
                </tr>

                @foreach($pg['pagasNodia']->sortBy('mes_id') as $item)
                <tr>
                    <td>Mensalidade</td>
                    <td>{{ $item->mes ?? '_________' }}</td>
                    <td>{{ number_format($item->valorDescricao ?? 0, 2, ',', '.') }} MT</td>
                    <td>{{ number_format($item->Multa ?? 0, 2, ',', '.') }} MT</td>
                    <td>{{ $item->metodo_pagamento ?? '_________' }}</td>
                    <td>{{ $item->referencia ?? '_________' }}</td>
                    <td style="text-align: center;">
                        @if(($item->Estado ?? '') == 'Pago')
                            <span style="color: green; font-weight: bold;">✓ PAGO</span>
                        @else
                            <span style="color: red;">PENDENTE</span>
                        @endif
                    </td>
                </tr>
                @php
                    $valortotal += (float) ($item->valorDescricao ?? 0) + (float) ($item->Multa ?? 0);
                @endphp
                @endforeach
                @endif
            @endforeach
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td colspan="5" style="text-align: right;">TOTAL GERAL:</td>
                <td colspan="2" style="text-align: center;">
                    {{ number_format($valortotal, 2, ',', '.') }} MT
                </td>
            </tr>
        </tfoot>
    </table>
</div>
@endif --}}

<!-- ================== OBSERVAÇÕES MÉDICAS ================== -->
<div class="print-section">
    <div class="section-title">Observações Médicas</div>

    <div class="row">
        <div class="label">Grupo Sanguíneo:</div>
        <div class="field-value">________</div>

        <div class="label">Alergias:</div>
        <div class="field-value">_____________________________</div>
    </div>

    <div class="row">
        <div class="label">Medicação Regular:</div>
        <div class="field-value">_____________________________</div>

        <div class="label">Contacto Médico:</div>
        <div class="field-value">_____________________________</div>
    </div>

    <div style="margin-top: 15px;">
        <div class="row">
            <div class="label">Observações:</div>
        </div>
        <div class="field-value" style="min-height: 60px; margin-left: 40mm;">
            __________________________________________________<br>
            __________________________________________________<br>
            __________________________________________________
        </div>
    </div>
</div>

<!-- ================== OBSERVAÇÕES GERAIS ================== -->
<div class="print-section">
    <div class="section-title">Observações Gerais</div>

    <div style="min-height: 80px; border: 1px solid #ddd; padding: 10px;">
        <div style="height: 60px;">
            ________________________________________________________________<br>
            ________________________________________________________________<br>
            ________________________________________________________________<br>
            ________________________________________________________________
        </div>
    </div>
</div>

<!-- ================== ASSINATURAS ================== -->
<div class="page-break"></div>

<div class="print-section" style="border: 2px solid #000; padding: 20px;">
    <div class="section-title">Assinaturas</div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 40px; margin-top: 30px;">
        <div class="signature-area">
            <div class="signature-line"></div>
            <div style="margin-top: 5px;">
                <strong>ASSINATURA DO ENCARREGADO</strong><br>
                Nome: ________________________________<br>
                Data: ____/____/______
            </div>
        </div>

        <div class="signature-area">
            <div class="signature-line"></div>
            <div style="margin-top: 5px;">
                <strong>ASSINATURA DO DIRECTOR</strong><br>
                Nome: ________________________________<br>
                Carimbo e Data: ____/____/______
            </div>
        </div>
    </div>

    <div style="margin-top: 60px; text-align: center;">
        <div class="signature-line" style="width: 300px;"></div>
        <div style="margin-top: 5px;">
            <strong>ASSINATURA DO ALUNO</strong><br>
            Nome: {{ $aluno->nome ?? '_____________________________' }}<br>
            Data: ____/____/______
        </div>
    </div>
</div>

<!-- ================== RODAPÉ ================== -->
<div class="footer">
    Ficha do Aluno Nº: {{ $aluno->id ?? 'N/A' }}<br>
    Documento gerado em: {{ date('d/m/Y H:i:s') }}<br>
    {{ $conf->nome ?? 'Estabelecimento de Ensino' }} - {{ $conf->Endereco ?? '' }}
</div>

</body>
</html>
