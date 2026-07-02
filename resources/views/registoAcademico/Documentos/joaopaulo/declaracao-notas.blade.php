@php
    // dd(($dadosnota->first()==null));
@endphp
@if($dadosnota->first()==null)


<div class="alert alert-success" role="alert">
  <h4 class="alert-heading"></h4>
  <p></p>
  <p class="mb-0"> N&atilde;o possuie nenhuma Nota para emiss&atilde;o de Declaração</p>
</div>
@else

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Declaração Escolar </title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Times New Roman', serif;
        }

        body {
            background-color: #f5f5f5;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 10px;
        }

        .a4-container {
            width: 21cm;
            height: 29.7cm;
            background-color: white;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            padding: 0.5cm;
            position: relative;
        }

        .a4-conteudo {
            border: 8px double #000;
            outline: 4px solid #555;
            padding: 0.5cm;
            height: 100%;
            position: relative;
        }

        .school-header {
            text-align: center;
            margin-bottom: 1cm;
            padding-bottom: 0.3cm;
        }

        .school-name {
            font-size: 18pt;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 0.3cm;
        }

        .school-subtitle {
            font-size: 17pt;
            font-weight: bold;
        }

        .document-title {
            font-size: 18pt;
            text-align: center;
            margin-bottom: 1.3cm;
            text-decoration: underline;
        }

        .document-content {
            font-size: 12pt;
            line-height: 1.3;
            margin-bottom: 1.3cm;
        }

        .student-name {
            font-weight: bold;
            text-transform: uppercase;
        }

        .grades-table {
            width: 100%;
            margin-bottom: 0,5cm;
            border-collapse: collapse;
        }

        .grades-table td {

            border-bottom: 1px dotted #ccc;
        }

        .subject-name {
            width: 60%;
        }

        .grade-value {
            text-align: center;
            width: 40%;
        }

        .average-row {
            font-weight: bold;
            border-top: 2px solid #333;
        }

        .additional-info {
            margin-top: 0.3cm;
            /* margin-bottom: 0.5cm; */
        }

        .location-date {

            text-align: center;
             position: absolute;
              display: flex;
               justify-content: space-evenly;
                width: 100%;
            /* margin-bottom: 8cm; */

            bottom: 4cm;
        }

        /* Assinaturas fixas */
        .signatures {
            position: absolute;
            bottom: 1.6cm; /*fixa a posição acima do rodapé SysGeC*/
            left: 0;
            width: 100%;
            display: flex;
            justify-content: space-between;
            text-align: center;
        }

        .extracted-by, .verified-by, .director-signature {
            width: 30%;
        }

        .signature-line {
            padding-top: 0.3cm;
        }

        .signature-name {
            font-weight: bold;
            text-transform: uppercase;
        }

        /* Rodapé SysGeC */
        .sysgec-footer {
            position: absolute;
            bottom: 5px;
            left: 0;
            width: 100%;
            text-align: center;
            font-size: 10pt;
            font-style: italic;
            color: #333;
        }

        @media print {
            body {
                background: none;
                padding: 0;
            }

            .a4-container {
                box-shadow: none;
                width: 100%;
                height: auto;
                page-break-after: always;
            }
        }
    </style>
</head>
<body>

    @php
        // dd( $conf,$subdomain,);
    @endphp
   <div class="a4-container">
        <div class="a4-conteudo">
            <div class="school-header">
                <div class="logom">
                    <img src="{{ asset('storage/'.$subdomain.'/logoMarca/' . $conf->avatar) }}" style="width: 25mm; height: 25mm; margin: 0 auto;">
                </div>
                <div class="school-name">{{ $conf->nome }}-{{ $conf->Distrito }}</div>
                <div class="school-subtitle">Declaração</div>
            </div>

            <div class="document-content">

                <strong >=== {{$director->name }} ,{{ $nivel }}</strong>, Directora da {{ $conf->nome }} certifico que:
                <span class="student-name">{{ $aluno->nome }},</span>
                @if($aluno->sexo=="M")
                Filho
                @else
                filha
                @endif de
                 {{ $aluno->nome_pai }}
                e de {{ $aluno->nome_mae }},
                Natural de {{ $aluno->distrito }},
                 Distrito de {{ $aluno->distrito??"_____" }}, Província de {{ $aluno->provincia??"___" }},

                 @if($aluno->sexo=="M")
              nascido
                @else
               nascida
                @endif

@php
    \Carbon\Carbon::setLocale('pt');


@endphp
                em
                {{ \Carbon\Carbon::parse($aluno->dataNascimento)->translatedFormat('d \d\e F \d\e Y') }}
                no ano lectivo de {{ $aluno->anolectivo }},
                 @if($informacaoudeclracao=="")
                 concluiu neste Estabelecimento de Ensino
                 a
                 <strong>{{  $aluno->classe }},</strong> tendo <strong>

                     @if($aluno->sexo=="M")
              APROVADO
                @else
               APROVADA
                @endif
</strong>   com

                     @else

no {{ $informacaoudeclracao->first()->divisao}} <sup>º</sup>
{{ $informacaoudeclracao->first()->anomodelos }} teve
                 @endif
                  as seguintes classificações:

                <table class="grades-table">
                    @php
                        $somaNota=0;
                        $contador=0;
                    @endphp

                    @foreach ($dadosnota as $dadosnotaItem)

   @php
                        $somaNota=$somaNota+$dadosnotaItem->notas;
                        $contador= $contador+1;
                    @endphp
                    <tr>
                        <td class="subject-name">{{ $dadosnotaItem->disciplina }}......................................................</td>
                            <td class="grade-value"><strong>( {{$dadosnotaItem->notas }})</strong></td>
                    </tr>
                      @endforeach

                    <tr class="average-row">
    <td class="subject-name">Média.....................................................</td>
    <td class="grade-value"><strong>({{ round($somaNota/$contador) }})</strong></td>
</tr>
                </table>

                <div class="additional-info">
                    <p>Consta da Pauta de Frequência, no nº {{ $dadosnota->first()->Numero_turma}} da Turma
                        <span  style="text-decoration:uppercase;">
                           <b> {{ $dadosnota->first()->turma }}</b>
                        </span>

                        , ano lectivo de {{ $aluno->anolectivo }}</p>
                    <p>E, por ser verdade mandei passar a presente Declaração assinada e autenticada com o carimbo em uso neste Estabelecimento. <strong>===</strong></p>
                </div>
            </div>


  <div class="location-date">
               {{ \Carbon\Carbon::now()->translatedFormat('d \d\e F \d\e Y') }}
            </div>
            <!-- Assinaturas fixas -->
            <div class="signatures">

                {{-- <div class="extracted-by">
                    <div class="signature-name">Canamo Francisco Gil</div>
                    <div class="signature-line">_____________________________</div>
                    <div>Extraiu</div>
                </div> --}}

                <div class="verified-by">
                    <div class="signature-name">{{ Auth::user()->name }}</div>
                    <div class="signature-line">_____________________________</div>
                    <div>Conferiu</div>
                </div>

                <div class="director-signature">
                    <div class="signature-name">{{$director->name }}</div>
                    <div class="signature-line">___________________________</div>
                    <div>
@if($director->sexo=="F")
                        <strong>A Directora da Escola</strong>
                        @else
<strong>O Director da Escola</strong>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Rodapé SysGeC -->
            <div class="sysgec-footer">
                Documento processado pelo <strong>SysGeC</strong>
            </div>
        </div>
    </div>
</body>
</html>
@endif
