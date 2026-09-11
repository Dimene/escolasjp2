<?php
use Carbon\Carbon;
$conf = $conf ?? DB::table('config')->first();
$currentYear = now()->year;
$alunoId = $aluno->id ?? null;


$request =Request();
    $host = $request->getHost();

    $subdomain = explode('.', $host)[0];


                    $nomePai=DB::table("encaregadosview")->where("id",$aluno->pai_id)->first();
                    // dd($nomePai,$aluno);
                    $nome_mae=DB::table("encaregadosview")->where("id",$aluno->mae_id)->first();
                    $naturalidade=DB::table("distritos")->where("id",$aluno->Naturalidade_id)->first();
                    // dd(  $naturalidade->nome,$aluno->Naturalidade_id);

?>



      <?php
$disciplinas = [
    "Portugues",
    "Matemática",
    "C.Naturais",
    "Ed.Cv.Moral",
    "Ed.Física",
    "Ed.Musical",
    "Ed.Visual",
    "Inglês",
    "Física",
    "Química",
    "Biologia",
    "Geografia",
    "História",
    "Filosofia",
    "TIC", // Tecnologias de Informação e Comunicação
    "Agropecuária"
];



$faltas=["Faltas Justificadas","Faltas Injustificas"]
?>
<!doctype html>
<html lang="pt">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Processo Individual — <?php echo e($aluno->nome ?? 'Aluno'); ?></title>

<?php

?>
<style>


* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: DejaVu Sans;
}

body {
    background: #fff;
    color: #000;
    font-size: 11pt;
    line-height: 1.3;
    margin: 0;
    padding: 0;
}

/* Configuração para A3 landscape contendo 2 páginas A4 lado a lado */
@page {
    size: A3 landscape;
    margin: 0;
}

.a3-page {
    width: 420mm;
    height: 297mm;
    display: flex;
    flex-direction: row;
    position: relative;
    background: white;
    page-break-after: always;
}

/* Cada coluna representa uma página A4 vertical */
.a4-column {
    width: 210mm;
    height: 297mm;
    padding: 20mm;
    display: flex;
    flex-direction: column;
    position: relative;
    border-right: 1px dashed #ccc;
}

.a4-column:last-child {
    border-right: none;
}

/* Cabeçalho estilo oficial */
.header {
    border: 2px solid #000;
    padding: 8px 12px;
    margin-bottom: 15px;
    text-align: center;
}

.header h1 {
    font-size: 14pt;
    font-weight: bold;
    margin: 0;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.header .subtitle {
    font-size: 10pt;
    margin-top: 2px;
}

/* Informações da Escola */
.school-info {
    border: 1px solid #000;
    padding: 8px;
    margin-bottom: 12px;
    font-size: 10pt;
}

.school-info .row {
    display: flex;
    margin-bottom: 4px;
}

.school-info .label {
    font-weight: bold;
    min-width: 80px;
}

/* Seções principais */
.section {
    margin-bottom: 12px;
    page-break-inside: avoid;
}

.section-title {
    font-size: 11pt;
    font-weight: bold;
    margin-bottom: 6px;
    border-bottom: 1px solid #000;
    padding-bottom: 2px;
}.container {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 12px; /* espaço entre logo e cabeçalho */
}

.logo {
  width: 20mm;
  height: 20mm;
  border-radius: 12px;
  overflow: hidden;
  background: #f3f3f3;
  display: flex;
  align-items: center;
  justify-content: center;
}

.cabecalho {
  flex: 1; /* ocupa o espaço restante */
  display: flex;
  align-items: center;
  justify-content: flex-start;
}
.logo img {
  width: 100%;
  height: 100%;
  /* object-fit: cover;
  position: absolute; */
  /* top: 65mm;
  left: 20mm; */
  /* z-index: 999;
  opacity: 0.3; ajuste a transparência conforme necessário
  pointer-events: none; evita que a imagem bloqueie interações abaixo */
}
/* Tabelas */
.table {
    width: 100%;
    border-collapse: collapse;
    font-size: 9pt;
    margin-top: 6px;
}

.table th {
    border: 1px solid #000;
    padding: 3px 4px;
    background: #f0f0f0;
    font-weight: bold;
    text-align: center;
}

.table td {
    border: 1px solid #000;
    padding: 3px 4px;
    text-align: left;
    vertical-align: top;
}

/* Campos de dados */
.data-field {
    display: flex;
    margin-bottom: 3px;
    font-size: 10pt;
}

.field-label {
    font-weight: bold;
    min-width: 40mm;
}

.field-value {
    flex: 1;
    border-bottom: 1px dotted #000;
    margin-left: 4px;
    padding: 0 2px;
    min-height: 5mm;
}

/* Foto do aluno */
.photo-container {
    position: absolute;
    top: 26mm;
    right: 20mm;
    width: 39mm;
    height: 50mm;
    border: 1px solid #000;
    background: #f9f9f9;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 8pt;
    text-align: center;
    padding: 1mm;
}

.photo-container img {
    max-width: 100%;
    max-height: 100%;
    object-fit: cover;
}

/* Assinaturas */
.signatures {
    display: flex;
    justify-content: space-between;
    margin-top: 15mm;
    padding-top: 5mm;
}

.signature-box {
    text-align: center;
    width: 45mm;
}

.signature-line {
    border-top: 1px solid #000;
    margin-top: 20mm;
    padding-top: 2px;
    font-size: 9pt;
}

/* Observações */
.observations {
    border: 1px solid #000;
    min-height: 30mm;
    padding: 4mm;
    font-size: 10pt;
    margin-top: 2mm;
}

/* Numeração de páginas */
.page-number {
    position: absolute;
    bottom: 10mm;
    right: 15mm;
    font-size: 10pt;
}

/* Utilidades */
.text-center { text-align: center; }
.text-right { text-align: right; }
.text-uppercase { text-transform: uppercase; }
.bold { font-weight: bold; }
.mt-1 { margin-top: 4px; }

/* Para impressão */
@media print {
    body {
        margin: 0;
        padding: 0;
        width: 420mm;
        height: 297mm;
    }

    .a3-page {
        margin: 0;
        padding: 0;
        width: 100%;
        height: 100%;
    }

    .a4-column {
        border-right: 1px dashed #ccc;
    }
}
</style>
</head>
<body>

<!--
    LAYOUT DAS PÁGINAS:
    A3 Page 1: Página 4 (esquerda) | Página 1 (direita)
    A3 Page 2: Página 2 (esquerda) | Página 3 (direita)
-->

<!-- A3 PAGE 1: PÁGINA 4 (esquerda) | PÁGINA 1 (direita) -->
<div class="a3-page">

    <!-- COLUNA ESQUERDA - PÁGINA 4 -->
    <div class="a4-column">






        <div class="section">
		<table class="table table-bordered table-striped">
<tr><td style="width:8%"> Ano Lectivo</td><td style="width:8%"> </td><td rowspan="3">

<pre>
                Data
     ____/____/________

     Director de Turma             Director da Escola

    ___________________           ___________________
             (assinatura)                   (assinatura/Carimbo)

</pre> </td>
<td rowspan="6">
<h3>TRANSFERÊNCIAS <slim>(Saida)</slim></h3>
Em ____/______/__________/ foi transferido desta escola  para  ade____________________
_____________________ província  de _____________________ tendo levado  consigo a seguintes  documentação
1._________________________________
2._________________________________
3._________________________________
4._________________________________
5._________________________________
 <pre>
 <center>
Director da Escola
_________________________
(Assinatura do Director/ carimbo)
</center>
</pre>

</td></tr>
<tr><td> Classe  </td> <td> </td>  </tr>
<tr><td> Turma</td><td style="width:8%"> </td>  </tr>
<tr><td>Ano Lectivo </td><td style="width:8%"> </td> <td rowspan="3"><pre>
                Data
     ____/____/________

     Director de Turma             Director da Escola

    ___________________           ___________________
             (assinatura)                   (assinatura/Carimbo)

</pre> </tr>
<tr><td>Classe </td><td style="width:8%"> </td>  </tr>
<tr><td>Turma</td><td style="width:8%"> </td></tr>


<tr><td style="width:8%"> Ano Lectivo</td><td style="width:8%"> </td><td rowspan="3">
<pre>
                Data
     ____/____/________

     Director de Turma             Director da Escola

    ___________________           ___________________
             (assinatura)                   (assinatura/Carimbo)

</pre> </td>
<td rowspan="6">

<h3>TRANSFERÊNCIAS <slim>(Entrada)</slim></h3>
<center>

Em   ____/____/________Veio transferido para esta Escola
Trazendo guia numero de transferência numero ______ passada pela Direcção de Educação de________________________  provincia   de  ________________________________


<pre>
Director da Escola

 ___________________
(assinatura do director/Carimbo)

____/____/________

<pre>
<center>
</td></tr>
<tr><td> Classe  </td> <td> </td>  </tr>
<tr><td> Turma</td><td style="width:8%"> </td>  </tr>
<tr><td>Ano Lectivo </td><td style="width:8%"> </td> <td rowspan="3"><pre>
                Data
     ____/____/________

     Director de Turma             Director da Escola

    ___________________           ___________________
             (assinatura)                   (assinatura/Carimbo)

</pre> </tr>
<tr><td>Classe </td><td style="width:8%"> </td>  </tr>
<tr><td>Turma</td><td style="width:8%"> </td></tr>
</table>
		</div>
        <div class="section">
            <div class="section-title">IX — DOCUMENTOS ANEXOS</div>
            <div class="observations">
                <div style="margin-bottom: 8px;">☐ <strong>Cópia do Bilhete de Identidade</strong></div>
                <div style="margin-bottom: 8px;">☐ <strong>Certificado de Habilitações Anteriores</strong></div>
                <div style="margin-bottom: 8px;">☐ <strong>Fotografias 3,5x4,5 cm</strong> (2 unidades)</div>
                <div style="margin-bottom: 8px;">☐ <strong>Declaração Médica</strong></div>
                <div style="margin-bottom: 8px;">☐ <strong>Comprovativo de Residência</strong></div>
                <div style="margin-bottom: 8px;">☐ <strong>Outros documentos:</strong></div>
                <div style="height: 40mm; border: 1px dotted #000; padding: 2mm;">
                    ________________________________<br>
                    ________________________________<br>
                    ________________________________
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

    <!-- COLUNA DIREITA - PÁGINA 1 -->
    <div class="a4-column">

        <div class="header">
  <div class="logom">
 <img src="<?php echo e(asset('logoTipo/simboloR.png')); ?>" style="
  width: 20mm;
  height: 20mm;
  display: flex;
  justify-content: center;
  align-items: center;
  margin: 0 auto;
">
           </div>

            <h1>processo individual do aluno</h1>
            <div class="subtitle">MINISTÉRIO DA EDUCAÇÃO — IDENTIFICAÇÃO</div>
        </div>

        <!-- Foto do Aluno -->
        <div class="photo-container">
            <?php if(!empty($aluno->avatar)): ?>
                <img src="<?php echo e(asset('storage/' . $subdomain . '/fotoAluno/' . $aluno->avatar)); ?>"
         alt="Foto do aluno"
         class="img-fluid rounded shadow-sm" style="width: 100%;height: 100%;">


            <?php else: ?>
                FOTOGRAFIA<br>
                (3,5 x 4,5 cm)
            <?php endif; ?>
        </div>

        <div class="school-info ">

              <div class="logo">
        <?php if(!empty($conf->avatar)): ?>
          <img src="<?php echo e(asset('storage/logoMarca/' . $conf->avatar)); ?>" alt="<?php echo e($conf->nome); ?>">
        <?php else: ?>
          <div style="padding:6px; font-weight:700; color:#888;">LOGO</div>
        <?php endif; ?>
      </div>

            <div class="row">
               

                <div class="field-value"><?php echo e($conf->nome ?? 'ESCOLA'); ?></div>
            </div>
            <div class="row">
                <div class="field-value">
                   <b>Provincia:</b> <?php echo e($conf->Provincia ?? ''); ?>

                    <b>Distrito:</b> <?php echo e($conf->Distrito ?? ''); ?>

                     <b>Bairro:</b><?php echo e($conf->Localizacao ?? ''); ?>

                </div>
            </div>
            <div class="row">
                <div class="label">Telefone:</div>
                <div class="field-value">
                    <?php echo e($conf->Contacto ?? ''); ?>/
                    <?php echo e($conf->Contacto2 ?? ''); ?>


                </div>
                <div class="label" style="min-width: 20mm; margin-left: 5mm;">Email:</div>
                <div class="field-value"><?php echo e($conf->Email ?? 'EMAIL'); ?></div>
            </div>
            </div>


        <div class="section">
            <div class="section-title">I — IDENTIFICAÇÃO PESSOAL</div>

            <div class="data-field">
                <div class="field-label">N.º do processo:</div>
                <div class="field-value text-uppercase bold"><?php echo e($processo_id ?? $alunoId ?? ''); ?></div>
            </div>

            <div class="data-field">
                <div class="field-label">Nome completo:</div>
                <div class="field-value text-uppercase bold"><?php echo e($aluno->nome ?? ''); ?></div>
            </div>

            <div class="data-field">
                <div class="field-label">Data de nascimento:</div>
                <div class="field-value"><?php echo e(isset($aluno->dataNascimento) ? Carbon::parse($aluno->dataNascimento)->format('d/m/Y') : ''); ?></div>
                <div class="field-label" style="min-width: 15mm; margin-left: 5mm;">Idade:</div>
                <div class="field-value" style="min-width: 20mm;"><?php echo e(isset($aluno->dataNascimento) ? Carbon::parse($aluno->dataNascimento)->age . ' anos' : ''); ?></div>
            </div>

            <div class="data-field">
                <div class="field-label">Naturalidade:</div>
                <div class="field-value"><?php echo e($naturalidade->nome ?? ''); ?></div>
                <div class="field-label" style="min-width: 10mm; margin-left: 5mm;">Sexo:</div>
                <div class="field-value" style="min-width: 15mm;"><?php echo e($aluno->sexo ?? ''); ?></div>
            </div>

            <div class="data-field">
                <div class="field-label">Nome do pai:</div>

                <div class="field-value text-uppercase"><?php echo e($nomePai->nome   ?? ''); ?></div>

                <div class="field-label">Nome da mãe:</div>
                <div class="field-value text-uppercase"><?php echo e($nome_mae->nome ?? ''); ?></div>
            </div>



            <div class="data-field">
                <div class="field-label">Documento de identificação:</div>
                <div class="field-value"><?php echo e(($aluno->documento_tipo ?? '')); ?> — <?php echo e($aluno->documento_num ?? ''); ?></div>
            </div>
             <div class="section">
            <div class="section-title">III — ENDEREÇO E CONTACTOS</div>

            <div class="data-field">
                <div class="field-label">Bairro/Localidade:</div>
                <div class="field-value"><?php echo e($aluno->Bairo->Endereco ?? ''); ?></div>
                 <div class="field-label">Rua/Avenida:</div>
                <div class="field-value"><?php echo e($aluno->Bairo->RuaAvenida ?? ''); ?></div>



            </div>



            <div class="data-field">
                <div class="field-label">N.º da casa/Quarteirão:</div>
                <div class="field-value"><?php echo e($aluno->Casa ?? ''); ?> / <?php echo e($aluno->Quarterao ?? ''); ?></div>

                <div class="field-label">Contactos :</div>
                <div class="field-value">
                    <?php if(!empty($aluno->encaregado->contacto) && count($aluno->encaregado->contacto)): ?>
                        <?php $__currentLoopData = $aluno->encaregado->contacto; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php echo e($c->Descricao); ?><?php if(!$loop->last): ?>, <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php else: ?>

                    <?php endif; ?>
                </div>
            </div>

            <div class="data-field">

            </div>
        </div>


         <div class="section">
            <div class="section-title">IV — ENCARREGADO DE EDUCAÇÃO</div>

            <div class="data-field">
                <div class="field-label">Nome:</div>
                <div class="field-value text-uppercase bold"><?php echo e($aluno->encaregado->nome ?? ''); ?></div>

                <div class="field-label">Parentesco/Relação:</div>
                <div class="field-value"><?php echo e(($aluno->graoparentesto->Descricao ??'')); ?></div>
            </div>

            <div class="data-field">
                <div class="field-label">Profissão:</div>
                <div class="field-value"><?php echo e($aluno->encaregado->profissao->Descricao ?? ''); ?></div>
                <div class="field-label" style="min-width: 20mm; margin-left: 5mm;">Religião:</div>
                <div class="field-value" style="min-width: 25mm;"><?php echo e($aluno->encaregado->religiao->nome ?? ''); ?></div>
            </div>
        </div>

<div class="section">
    <div class="section-title">
        📘 Histórico Escolar — Classes Frequentadas
    </div>
    <table class="table table-bordered table-striped">
        <thead class="table-dark text-center">
            <tr>
                <th  rowspan="2">Ano Lectivo</th>
                <th   rowspan="2">Classe</th>
                <th  rowspan="2">Estabelecimento de Ensino</th>
                <th colspan="3">Enderco</th>
                <th rowspan="2">turma</th>
            </tr>
            <tr>
               <th> provincia</th>
               <th> Distrito</th>
               <th> AV/Bairo</th>


            </tr>
        </thead>
        <tbody>
            <?php for($x = 1; $x < 13; $x++): ?>
                <?php
                    $dadolinha = $dadosAnterior->where("Classe_id", $x)->first();
                ?>
                <tr>
                    <td class="text-center">
                        <?php echo e($dadolinha->anolectivo ?? '—'); ?>

                    </td>
                    <td class="text-center">
                        <?php echo e($dadolinha->classe ?? '—'); ?>

                    </td>
                    <td>
                        <?php if(!empty($dadolinha)): ?>
                            <?php echo e($conf->nome); ?>

                        <?php else: ?>

                        <?php endif; ?>
                    </td>
                    <td> <?php if(!empty($dadolinha)): ?>
                            <?php echo e($conf->Provincia); ?>

                        <?php else: ?>

                        <?php endif; ?> </td>
                        <td> <?php if(!empty($dadolinha)): ?>
                            <?php echo e($conf->Distrito); ?>

                        <?php else: ?>

                        <?php endif; ?> </td>

                        <td> <?php if(!empty($dadolinha)): ?>
                            <?php echo e($conf->Localizacao); ?>

                        <?php else: ?>

                        <?php endif; ?> </td>
                        <td> </td>

                </tr>
            <?php endfor; ?>
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

<!-- A3 PAGE 2: PÁGINA 2 (esquerda) | PÁGINA 3 (direita) -->
<div class="a3-page">

    <!-- COLUNA ESQUERDA - PÁGINA 2 -->
    <div class="a4-column">

		<div class="section">
    <div class="section-title">V — HISTÓRICO ACADÉMICO</div>
    <table class="table table-bordered table-striped">
        <thead class="table-dark text-center">
            <tr>
                <th >Classe</th>
            <?php for($i=0;$i<5;$i++): ?>
            <th colspan="4">

            </th>

            <?php endfor; ?>

            </tr>
            <tr>
                <th >Ano lectivo</th>
            <?php for($i=0;$i<5;$i++): ?>
            <th colspan="4" style="padding-top: 10px">
---/----/-----
            </th>

            <?php endfor; ?>

            </tr>
            <tr>
                <th >Turma</th>
            <?php for($i=0;$i<5;$i++): ?>
            <th colspan="4" style="padding-top: 10px">

            </th>

            <?php endfor; ?>

            </tr>
            <tr>
                <td >Notas</td>
            <?php for($i=0;$i<5;$i++): ?>

                <td>1ºT</td>
                <td>2ºT</td>
                <td>3ºT</td>
                <td>MF</td>



            <?php endfor; ?>

            </tr>

        <?php for($iy = 0; $iy < 22; $iy++): ?>


            <tr>
                <td ><?php echo e($disciplinas[$iy]??'- '); ?></td>
            <?php for($i=0;$i<5;$i++): ?>

                <td></td>
                <td></td>
                <td></td>
                <td></td>



            <?php endfor; ?>

            </tr>
            <?php endfor; ?>
            <tr>
                <td >Comportamento</td>
            <?php for($i=0;$i<5;$i++): ?>

                <td colspan="4"></td>



            <?php endfor; ?>

            </tr>
            <tr>
                <td >Data. assinatura Director de Turma</td>
            <?php for($i=0;$i<5;$i++): ?>

                <td colspan="4" style="padding-top: 30px">----/----/--------/</td>



            <?php endfor; ?>

            </tr>



        </tbody>
    </table>
</div>





        <div class="page-number">2</div>
    </div>

    <!-- COLUNA DIREITA - PÁGINA 3 -->
    <div class="a4-column">





<div class="section">
    <div class="section-title">V — HISTÓRICO de PRESEN&Ccedil;AS
</div>
    <table class="table table-bordered table-striped">
        <thead class="table-dark text-center">
            <tr>
                <th >Classe</th>
            <?php for($i=0;$i<5;$i++): ?>
            <th colspan="4">

            </th>

            <?php endfor; ?>

            </tr>
            <tr>
                <th >Ano lectivo</th>
            <?php for($i=0;$i<5;$i++): ?>
            <th colspan="4" style="padding-top: 10px">
---/----/-----
            </th>

            <?php endfor; ?>

            </tr>
            <tr>
                <th >Turma</th>
            <?php for($i=0;$i<5;$i++): ?>
            <th colspan="4" style="padding-top: 10px">

            </th>

            <?php endfor; ?>

            </tr>
            <tr>
                <td >Trimestre</td>
            <?php for($i=0;$i<5;$i++): ?>

                <td>1ºT</td>
                <td>2ºT</td>
                <td>3ºT</td>
                <td>..S</td>



            <?php endfor; ?>

            </tr>

        <?php for($iy = 0; $iy < 2; $iy++): ?>


            <tr>
                <td ><?php echo e($faltas[$iy]??'- '); ?></td>
            <?php for($i=0;$i<5;$i++): ?>

                <td></td>
                <td></td>
                <td></td>
                <td></td>



            <?php endfor; ?>

            </tr>
            <?php endfor; ?>
            <tr>
                <td >Comportamento</td>
            <?php for($i=0;$i<5;$i++): ?>

                <td colspan="4"></td>



            <?php endfor; ?>

            </tr>
            <tr>
                <td >Data. assinatura Director de Turma</td>
            <?php for($i=0;$i<5;$i++): ?>

                <td colspan="4" style="padding-top: 30px">----/----/--------/</td>



            <?php endfor; ?>

            </tr>



        </tbody>
    </table>
</div>

        <div class="section">
		<div class="section-title">VII — APRECIAÇÃO GERAL E TRANSFERÊNCIAS</div>
            <div class="">
<table class="table table-bordered table-striped">
<tr><td style="width:8%"> Ano Lectivo</td><td style="width:8%"> </td><td rowspan="3">

<pre>
                Data
     ____/____/________

     Director de Turma             Director da Escola

    ___________________           ___________________
             (assinatura)                   (assinatura/Carimbo)

</pre> </td>
<td rowspan="6">
<h3>TRANSFERÊNCIAS <slim>(Saida)</slim></h3>
Em ____/______/__________/ foi transferido desta escola  para  ade____________________
_____________________ província  de _____________________ tendo levado  consigo a seguintes  documentação
1._________________________________
2._________________________________
3._________________________________
4._________________________________
5._________________________________
 <pre>
 <center>
Director da Escola
_________________________
(Assinatura do Director/ carimbo)
</center>
</pre>

</td></tr>
<tr><td> Classe  </td> <td> </td>  </tr>
<tr><td> Turma</td><td style="width:8%"> </td>  </tr>
<tr><td>Ano Lectivo </td><td style="width:8%"> </td> <td rowspan="3"><pre>
                Data
     ____/____/________

     Director de Turma             Director da Escola

    ___________________           ___________________
             (assinatura)                   (assinatura/Carimbo)

</pre> </tr>
<tr><td>Classe </td><td style="width:8%"> </td>  </tr>
<tr><td>Turma</td><td style="width:8%"> </td></tr>


<tr><td style="width:8%"> Ano Lectivo</td><td style="width:8%"> </td><td rowspan="3">
<pre>
                Data
     ____/____/________

     Director de Turma             Director da Escola

    ___________________           ___________________
             (assinatura)                   (assinatura/Carimbo)

</pre> </td>
<td rowspan="6">

<h3>TRANSFERÊNCIAS <slim>(Entrada)</slim></h3>
<center>

Em   ____/____/________Veio transferido para esta Escola
Trazendo guia numero de transferência numero ______ passada pela Direcção de Educação de________________________  provincia   de  ________________________________


<pre>
Director da Escola

 ___________________
(assinatura do director/Carimbo)

____/____/________

<pre>
<center>
</td></tr>
<tr><td> Classe  </td> <td> </td>  </tr>
<tr><td> Turma</td><td style="width:8%"> </td>  </tr>
<tr><td>Ano Lectivo </td><td style="width:8%"> </td> <td rowspan="3"><pre>
                Data
     ____/____/________

     Director de Turma             Director da Escola

    ___________________           ___________________
             (assinatura)                   (assinatura/Carimbo)

</pre> </tr>
<tr><td>Classe </td><td style="width:8%"> </td>  </tr>
<tr><td>Turma</td><td style="width:8%"> </td></tr>
</table>


		</div>
		</div>



        <div class="page-number">3</div>
    </div>
</div>

</body>
</html>
<?php /**PATH C:\laragon\www\escolasaojoaopaulo\resources\views/registoAcademico/imprimirInformacao.blade.php ENDPATH**/ ?>