


    <link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.4.0/css/fixedHeader.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/fixedcolumns/4.3.0/css/fixedColumns.dataTables.min.css">
@php
$classe = $classe_disciplinas->first()["classe_id"];

$usuario = Auth::user()->id;

$anolectivo = DB::table('classe_direcao')
    ->where("classe_id", $classe)
    ->max("anolectivo_id");

$dadosChave = DB::table('classe_direcao')
    ->where("classe_id", $classe)
    ->where("anolectivo_id", $anolectivo)
    ->where(function ($query) use ($usuario) {

        $query->where("pedagogico_id", $usuario)
              ->orWhere("director_id", $usuario);

    })
    ->first();

    $edicaoativa=false;


     $turmapermisao=DB::table('professor_turmaview')->where("professor_id",$usuario)
    ->where("Tipo_Docencia_id",1)
    ->where("turma_id",$turma)->first();
    if($turmapermisao||$dadosChave){
   $edicaoativa=true;
    }


// dd($usuario,$turma,$edicaoativa);
@endphp
<meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .erro-nota {
    background-color: #ffcccc !important;
    border: 1px solid red;
}
        .DTFC_LeftWrapper {
    border-right: 2px solid #ddd;
    background-color: white;
}

.DTFC_LeftHeadWrapper th {
    background-color: #f8f9fa;
    font-weight: bold;
}
        </style>
<div class="row align-items-center py-2 gx-3">
    <div class="col-auto">
        @csrf
    </div>

    <script>
        var formula = "";
    </script>
<div id="progressContainer" style="display:none;margin-top:10px;" class="col-12">
    <div class="progress" style="height:25px;">
        <div id="progressBar"
            class="progress-bar progress-bar-striped progress-bar-animated bg-success"
            role="progressbar"
            style="width:0%">
            0%
        </div>
    </div>
</div>
@if($edicaoativa||Gate::check('Calcular-media-Disciplina'))
     <div class="col-auto">
        <span class="btn btn-primary MediaDisciplina">📘 Média Disciplina</span>
    </div>
@endif

@if($edicaoativa||Gate::check("Calcular-media-Anual"))


    <div class="col-auto">
        <span class="btn btn-primary MediaAnual">📗 Média Anual</span>
    </div>

@endif

@if($edicaoativa||Gate::check("Incluir-Resutado-pauta"))


    <div class="col-auto">
      <span class="btn btn-secondary GereraResultado" data-estado="off" style="cursor:pointer;">
  ❌ Resultado
</span>
    </div>
  @endif

@if($edicaoativa||Gate::check("importar-excel-pauta"))


    <div class="col-auto">
     <!-- Botão estilizado -->
<a class="btn btn-primary col btnImportar" onclick="document.getElementById('excelInput').click();">
    <i class="fa file-uplosd"></i> Importar Excel
</a>
<!-- Input file escondido -->
<input type="file" id="excelInput" accept=".xlsx,.xls" style="display: none;" onchange="uploadExcel(this.files)">

    </div>
   @endif

@if($edicaoativa||Gate::check("Imprimir-pauta"))

    <div class="col-auto">
        {{-- <button class="BaixarExcel">Baixar Excel</button> --}}
        {{-- <span class="btn btn-success BaixarExcel d-flex align-items-center gap-1">
            <i class="fa fa-file-excel-o fa-lg" aria-hidden="true"></i> Exportar
        </span> --}}



        <button type="button" class="btn btn-success BaixarExcel">
    Baixar Excel
</button>

<form id="formExcel" method="POST" action="/RegistoAcademico/notas/disciplinas/notasTrimestrais/Imprimir/Pauta/anual">
    @csrf
    <input type="hidden" name="corpo" id="corpo">
    <input type="hidden" name="disciplinas" id="disciplinas">
    <input type="hidden" name="trimestre" id="trimestre">
    <input type="hidden" name="turma" id="turma">
    <input type="hidden" name="notasdiferente" id="notasdiferente"  value="9000">

</form>
    </div>
 @endif

@if($dadosChave)
    <div class="col-auto">
        <span class="btn btn-success btn-fecharTRimestre d-flex align-items-center gap-1">
       <i class="fa   fa-lg fa-unlock-alt" aria-hidden="true">Trancar</i>
        </span>
    </div>
    @endif


    <div class="col"></div>
</div>
<div class="row">
    <div class="col">
        <div class=""></div>
    </div>
</div>


 <div class="col-md-12">
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa fa-search"></i></span>
                        <input type="text" id="searchFarmacos" class="form-control" placeholder="Pesquisar fármacos...">
                    </div>
                </div>
<table id="listadosalunos"
class="display no-shadow table table-light container-fluid
display responsive nowrap"
    style="width:100%">
    <thead>
        <tr style="background-color:rgba(79, 201, 140, 0.603);border-block-color:rgba(0,0,0,0.128)" id="primeraLinha">
            <th rowspan="2" class="coluna2">Nr</th>
            <th rowspan="2" class="coluna2">Nome</th>
            <th rowspan="2"class="coluna2">Sexo</th>


            @foreach ($classe_disciplinas as $classe_disciplinasItem)
@php

$size=collect($divisoes)->where('divisao_id', '<>', 9000);
 $array=["NA","NE"];

@endphp
                <th colspan="{{ count($size)+1}}">{{ $classe_disciplinasItem->disciplina->Descricao }}


                    <span class="color:#fff; font-size:9px;">
   ( {{ $classe_disciplinasItem->disciplina->Sigla }}  )
</span>
        </th>

            @endforeach
            <th rowspan="2">MA</th>
            <th rowspan="2">Resultado</th>

        </tr>

        <tr style="background-color:rgba(79, 201, 140, 0.603);border-block-color:rgba(0,0,0,0.128)" id="SegundaLinha">
            @foreach ($classe_disciplinas as $keyC => $classe_disciplinasItem)
                @foreach (collect($divisoes)->where('divisao_id', '<>', 9000) as $divisoesItem)


                    <th class="coluna2">
                    {{$divisoesItem->divisao==900?"NE":"NA"}}

                    </th>


                @endforeach
<th class="coluna2">MF</th>
            @endforeach
        </tr>
    </thead>

    <tbody>


        @foreach ($coleccaoalunos as $key => $itemI)
            <?php $x = 3; ?>

            <tr id="{{  $key + 1 }}" dadosNota="{{$itemI['id']}}"   data-id="{{$itemI['id']}}">
                <td id="{{ $key + 1 }}" linha="{{ $key }}" coluna="0">{{ $key + 1 }}</td>
                <td linha="{{ $key }}" coluna="1" style="width:300px">{{ $itemI['nome'] }}</td>
                <td linha="{{ $key }}" coluna="2">{{ $itemI['sexo'] }}</td>

                @foreach ($itemI['disciplina'] as $key0 => $disciplina)

                    @foreach ($disciplina['notas']->where("divisao_id","<>",9000) as $key2 => $divisoesItem)


                    <td linha="{{ $key }}"
                        coluna="{{ $x }}"
                        divisaoid="{{ $divisoesItem['divisao_id']   }}"
                        @if( is_null($divisoesItem["chave1"])&& is_null($divisoesItem["chave2"])&&$edicaoativa)

                        @if($array[$key2]!="NA")
                         flag="editalvel"
  contenteditable="true"
                         class="colunaEditavel colunaEditavelcolunaEditavel"
                         @endif
@endif
                            posicao="{{ $key }}{{ $x }}posicao"

                            disciplina="{{ $disciplina['disciplina_id'] }}"
                            NFinfo="{{ $divisoesItem['NT'] }}"
                            title="{{ $divisoesItem['divisao'] . 'NFDisp' . $disciplina['disciplina_id'] . 'linha' . $key }}"
formula="{{ $formunlamendia->where("TipoMedia",1)->first()->formula ?? '' }}"

{{$divisoesItem['divisao']}}="{{ $divisoesItem['NT'] }} "

NT="{{ $array[$key2]}}"


                              >
                           {{ $divisoesItem['NT']


                        }}




                        </td>



                        @if ($key == 0)
                        @endif

                        <?php $x = $x + 1; ?>
                    @endforeach



                    <td linha="{{ $key }}" coluna="{{ $x }}"
                    id="{{ $key }}{{ $disciplina['disciplina_id'] }}"
                        style="background-color:rgba(0,0,0,0.128)"
                        mediaT="{{ $disciplina['disciplina_id'] }}MT{{ $key }}"
  disciplina="{{ $disciplina['disciplina_id'] }}"
                        area="{{ $disciplina["area"] }}"
                        siglaDisp="{{ $disciplina["sigla"] }}"
                        divisao_id="{{ $disciplina['notas']->where('divisao_id', '=', 9000)->first()['divisao_id'] }}"
                        >

						{{ optional($disciplina['notas']->where('divisao_id', '=', 9000)->first())['NT'] ?? '' }}

                    </td>
                    <?php $x = $x + 1; ?>
                @endforeach



                <td id="{{ $key }}linha" linha="{{ $key }}linha" coluna="{{ $x }}"
    FormulaMediaFinal="{{ $itemI['MediaFormulaAnual'] }}">
    {{ optional($mediasanual->
    where('aluno_classe_id', $itemI['id'])
   -> where('MediaTempo',4)
    ->first())->valor ?? '' }}
</td>
                <?php $x = $x + 1; ?>
                <td linha="{{ $key }}" coluna="{{ $x }}"></td>
            </tr>


        @endforeach
    </tbody>
</table>


{{-- $coleccaoalunos[0]['MediaFormulaAnual'] --}}


{{-- {{ dd($formunlamendia) }} --}}

<div class="card">

    <div class="card-footer">

        <button class="btn btn-primary float-right NotasPautaCaregar">

            <i class="fa fa-cloud-upload" aria-hidden="true">Caregar</i>
        </button>

    </div>
</div>
{{-- {{ dd($classe_disciplinas,$classturma) }} --}}
@include("registoAcademico.notas.modals")
<script src="{{ asset('Admin-LTE/plugins/jquery/jquery.min.js') }}"></script>



    <script src="{{ asset('Admin-LTE/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('Admin-LTE/plugins/datatables/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ asset('Datatable/js/jquery.dataTables.min.js') }}"></script>


<script src="{{ asset('Admin-LTE/plugins/jquery/jquery.min.js') }}"></script>



    <script src="{{ asset('Admin-LTE/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('Admin-LTE/plugins/datatables/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ asset('Datatable/js/jquery.dataTables.min.js') }}"></script>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script src="https://cdn.datatables.net/fixedheader/3.4.0/js/dataTables.fixedHeader.min.js"></script>
<script src="https://cdn.datatables.net/fixedcolumns/4.3.0/js/dataTables.fixedColumns.min.js"></script>

    <style>
        #listadosalunos_filter {
            display: none;
        }
    </style>



<script src="{{ asset('MyJs/math.js') }}"></script>

{{-- <script src="{{ asset('MyJs/notastodastrimestral.js') }}"></script> --}}
<script src="{{ asset('MyJs/notastodastrimestral.js') }}"></script>

<script>


    // Botão para trancar selecionados

   window.urlmedia = '{{ route("notas.guardarmedia2") }}';
    // window.rotaDadosTable = '{{ route("notas.dadosTable") }}"';
window.urlTrancar = '{{ route("notas.trancar") }}';
window.urldadosTable = '{{ route("notas.dadosTablepauta") }}';
window.precistirbanco = '{{ route("notas.precistirbancoExame") }}';
 window.vriavelFormulaMedia=1;
 window.classturma=@json($classturma);
 window.flag=0;
 window.tipoMedia=4;
   $idalunos=@json($coleccaoalunos);
    window.arrayElementos=[];
 _token='{{ csrf_token() }}'
    window.classe_disciplinas=@json($classe_disciplinas);
   window.trimestre=@json($divisoes);
console.log("trimestres",window.trimestre);
   turma=@json($turma);


$(document).ready(function() {
    $('#criarFormulaMedia').on('shown.bs.modal', function () {
        $("[name='formmulacriadaParamedia']").focus();
    });
});



function uploadExcel(files) {

    if (files.length === 0) return;

    let formData = new FormData();
    formData.append('file', files[0]);

    let tableData = $tabelatrimestral.rows().data().toArray();

    formData.append('tableData', JSON.stringify(tableData));
    formData.append('Inicio', 9);

    $.ajax({
        url:window.urldadosTable,
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },

        beforeSend: function () {

            $("#btnImportar").prop("disabled", true).html(`
                <span class="spinner-border spinner-border-sm"></span>
                Importando Excel...
            `);

        },

        success: function(response) {

            if (!response.dados || !Array.isArray(response.dados)) {

                Swal.fire('Erro', 'Resposta inválida do servidor', 'error');
                return;

            }

            let dadosSalvar = [];

            $tabelatrimestral.rows().every(function (rowIdx) {

                const novaData = response.dados[rowIdx];

                if(!novaData) return;

                this.data(novaData).invalidate();

                let linha = $(this.node());

                let idAluno = linha.attr('dadosnota');

                dadosSalvar.push({
                    idAluno: idAluno,
                    dados: organisarArraySava(linha)
                });

            });

            $tabelatrimestral.draw(false);

            //salvarTudoEmLote(dadosSalvar);
            validarcelulas();


        },

        complete: function () {

            $("#btnImportar").prop("disabled", false).html(`
                <i class="fas fa-file-import"></i> Importar Excel
            `);

        },

        error: function(xhr) {

            Swal.fire({
                icon: 'error',
                title: 'Erro ao importar',
                text: xhr.responseJSON?.message || 'Algo deu errado'
            });

        }

    });

}






$(document).on('click', ".NotasPautaCaregar", function () {

    $tabelatrimestral.rows().every(function () {

        let tr = $(this.node()); // este já é o <tr>

        precistirBD(tr);

    });

});



function validarcelulas(){
     let erros = 0;

    $('#listadosalunos tbody tr').each(function () {

        let $cells = $(this).find('td');
        let totalCols = $cells.length;

        // da 4ª coluna até a penúltima
        for (let i = 3; i < totalCols - 1; i++) {

            let $cell = $cells.eq(i);
            let valor = parseFloat($cell.text().trim());

            // limpar erro anterior
            $cell.removeClass('erro-nota');

            // validar nota
            if (isNaN(valor) || valor < 0 || valor > 20) {

                $cell.addClass('erro-nota');
                erros++;

            }

        }
    });

    // mostrar alerta se existir erro
    if (erros > 0) {

   Swal.fire({
    icon: 'warning',
    title: "⚠️ Precisa revisar a tua pauta.",
    text: "Existem células destacadas a vermelho com notas inválidas (0 a 20). Por favor corrija e volte a carregar.",
    showConfirmButton: true
});


        return false;
    }
    else{
         Swal.fire({
                icon: 'success',
                title: 'Importação concluída! clque botao caregar  para guardar',

                showConfirmButton: true
            });

    }
}



function precistirBD(tr){


    let dados = $tabelatrimestral.row(tr).data();


    console.log(tr, window.classe_disciplinas, window.trimestre);

    let idAluno = tr.attr('dadosnota');

    console.log("id dados", idAluno);

    let formData = new FormData();

    let liAtivo = document.querySelector(".turmaselecionada.active");

    formData.append('rowData', JSON.stringify(dados));
    formData.append('disciplina', JSON.stringify(window.classe_disciplinas));
    formData.append('trimeste', JSON.stringify(window.trimestre));
    formData.append('turma', liAtivo.id);
    formData.append('idAluno', idAluno);

    $.ajax({
        url: window.precistirbanco,
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        success:function(dados){
            console.log(dados);
        }
    });

}

</script>
