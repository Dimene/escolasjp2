@php
$datalist=[0,0,"sexo","calendario","classe","TipoPagamento"];

$arraysimtalvez = array_fill(0, count($tipo)+1, "ListaSImNao");
$datalist = array_merge($datalist, $arraysimtalvez);

$complementar=[
"religioes",0,0,0,0,"distritos","provincias","paises",
"EstadoSaude","doencas",0,"profissoes",0,"profissoes",
0,"sexo","graus","profissoes",0,0,0
];

$complementar2=[
"religioes",0,0,0,0,0,0,0,
0,0,0,0,0,0,
0,0,0,0,0,0,0
];


$datalist = array_merge($datalist,$complementar);
$datalistajs=[0,0,"sexo","calendario","classe","TipoPagamento"];
 $datalistajs = array_merge($datalistajs, $arraysimtalvez);
// $datalistajs = array_merge($datalistajs,$complementar2);


@endphp

<style>
    td.erro-validacao{
    background:#f8d7da !important;
    border:1px solid #dc3545;
}
    </style>

<div class="resultado"></div>

 <div class="progress">
                                <div class="progress-bar progress-bar-striped progress-bar-animated bg-success"
                                     id="uploadProgress" style="width: 0%;">0%</div>
                            </div>
<div class="conteudo_tabela">
    <div class="input-group mb-3">
        <span class="input-group-text"><i class="fa fa-search"></i></span>
        <input type="text" id="searchFarmacos" class="form-control" placeholder="Pesquisar fármacos...">
    </div>
<div class="row">
<div class="col">

<div class="d-flex justify-content-between align-items-center mb-3">
    <span class="badge bg-primary p-2">
        {{ count($cabecalho) }} Colunas |
        {{ count($dados) }} Registros
    </span>

    <div>
        <button class="btn btn-sm btn-outline-success" id="btnSalvarTodos">
            <i class="fas fa-save"></i> Salvar Alterações
        </button>
    </div>
</div>

<div class="table-responsive">
<table class="table table-striped table-hover nowrap" id="alunosparaUplad" style="width:100%">
<thead class="table-dark">
<tr>
@foreach($cabecalho as $th)
    <th style="white-space:nowrap;">{{ $th }}</th>
@endforeach
</tr>
</thead>

<tbody>
@foreach ($dados as $rowIndex => $item)
<tr data-row="{{ $rowIndex }}">
@foreach ($item as $colIndex => $cell)

@php
$tipoCampo = $datalist[$colIndex] ?? 0;
$data="";
if($colIndex==3){

$data=carbon\Carbon::create($cell)->format("d/m/Y");
}
else{
    $data=$cell;
}

$cell=$data;
@endphp



<td contenteditable="true"
    data-row="{{ $rowIndex }}"
    data-col="{{ $colIndex }}"
    data-original="{{ $cell }}"
    @if($tipoCampo != 0)
        data-type="{{ $tipoCampo }}"
    @endif

>
{{ $cell }}
</td>

@endforeach
</tr>
@endforeach
</tbody>
</table>
</div>

</div>
</div>


<datalist id="ListaSImNao">
<option value="Sim">
<option value="Não">
<option value="Talvez">
</datalist>

<datalist id="EstadoSaude">
<option value="Com Doenca">
<option value="Sem Doenca">
</datalist>

<datalist id="sexo">
<option value="M">
<option value="F">
</datalist>

<datalist id="classe">
@foreach ($classe as $Item)
<option value="{{ $Item }}">
@endforeach
</datalist>

<datalist id="religioes">
@foreach ($religioes as $Item)
<option value="{{ $Item }}">
@endforeach
</datalist>

<datalist id="distritos">
@foreach ($distritos as $Item)
<option value="{{ $Item }}">
@endforeach
</datalist>

<datalist id="provincias">
@foreach ($provincias as $Item)
<option value="{{ $Item }}">
@endforeach
</datalist>

<datalist id="paises">
@foreach ($paises as $Item)
<option value="{{ $Item }}">
@endforeach
</datalist>

<datalist id="doencas">
@foreach ($doencas as $Item)
<option value="{{ $Item }}">
@endforeach
</datalist>

<datalist id="profissoes">
@foreach ($profissoes as $Item)
<option value="{{ $Item }}">
@endforeach
</datalist>

<datalist id="graus">
@foreach ($graus as $Item)
<option value="{{ $Item }}">
@endforeach
</datalist>

<datalist id="TipoPagamento">
@foreach($metodos as $value)
<option value="{{ $value }}">
@endforeach
</datalist>

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/fixedcolumns/4.3.0/css/fixedColumns.dataTables.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>
#alunosparaUplad th,
#alunosparaUplad td{
    white-space:nowrap;
    min-width:120px;
}

td[contenteditable]{
    background:#fff8e7;
    cursor:text;
}

td[contenteditable]:hover{
    background:#fff3d0;
}

td.alterado{
    background:#cff4fc !important;
    font-weight:500;
}
</style>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/fixedcolumns/4.3.0/js/dataTables.fixedColumns.min.js"></script>

<script>
    sexo =["M","F"];
    ListaSImNao =["Sim","Não"];
    classe=@json($classe);
    datalist=@json($datalistajs);
    TipoPagamento=@json($metodos);
    tipo=@json($tipo);
    cabecalho=@json($cabecalho);

var urlUPLOADfILA="{{route('aluno.MatriculaFila') }}";



$(document).ready(function(){

    $('#searchFarmacos').on('input', function () {
    table.search(this.value).draw();
});
const table = $('#alunosparaUplad').DataTable({
    scrollX:true,
    scrollY:'400px',
    scrollCollapse:true,
     language: { url: "https://cdn.datatables.net/plug-ins/1.13.6/i18n/pt-BR.json" },
    fixedColumns: {
    left: 3
},
    pageLength:25
});

const alteradas = new Set();

function atualizarBotao(){
    const btn = $('#btnSalvarTodos');
    if(alteradas.size>0){
        btn.html(`Salvar (${alteradas.size})`)
           .removeClass('btn-outline-success')
           .addClass('btn-success');
    }else{
        btn.html('Salvar Alterações')
           .removeClass('btn-success')
           .addClass('btn-outline-success');
    }
}

$('#alunosparaUplad tbody').on('click','td[contenteditable]',function(){

    const td=$(this);
    if(td.find('input').length) return;

    const tipo=td.data('type');
    const valor=td.text().trim();

    let input;

    if(tipo==="calendario"){
        input=$('<input type="date" class="form-control form-control-sm">')
            .val(converterParaInputDate(valor));
    }
    else if(tipo){
        input=$('<input type="text" class="form-control form-control-sm">')
            .attr('list',tipo)
            .val(valor);
    }
    else{
        input=$('<input type="text" class="form-control form-control-sm">')
            .val(valor);
    }

    input.css({width:'100%',border:'none',background:'transparent'});
    td.empty().append(input);
    input.focus();

    input.on('blur change',function(){

        let novo=$(this).val();

        if(tipo==="calendario" && novo){
            novo=converterParaExibicao(novo);
        }

        td.text(novo);

        const original=td.data('original');
        const key=td.data('row')+"-"+td.data('col');

        if(novo!==original){
            td.addClass('alterado');
            alteradas.add(key);
            td.data('original',novo);
        }

        atualizarBotao();
    });

});

$('#btnSalvarTodos').click(function(){

    var erros = [];
    $('.resultado').html('');
    $('#alunosparaUplad td').removeClass('erro-validacao');

    // 🔹 Mapeamento real das listas
    const listas = {
        sexo: sexo,
        ListaSImNao: ["Sim","Não"],
        classe: classe,
        TipoPagamento: TipoPagamento
    };

    table.rows().every(function(rowIdx){

        const rowNode = this.node();

        $(rowNode).find('td').each(function(colIdx){

            const td = $(this);
            const valor = td.text().trim();
            const tipoLista = datalist[colIdx];

            if(!tipoLista || tipoLista === 0) return;

            // 🔹 Validação de Data
            if(tipoLista === "calendario"){
                if(valor && !validarData(valor)){

                    marcarErro(td, rowIdx, cabecalho[colIdx], valor, erros);
                }
                return;
            }

            // 🔹 Validação por lista
            if(listas[tipoLista]){
                if(!listas[tipoLista].includes(valor)){
                    marcarErro(td, rowIdx, cabecalho[colIdx], valor, erros);
                }
            }

        });

    });

    if(erros.length > 0){
        $('.resultado').html(
            `<div class="alert alert-danger">
                <strong>Erros encontrados:</strong><br>` + erros.join("<br>") +
            `</div>`
        );
    }else{
        $('.resultado').html(
            `<div class="alert alert-success">
                ✅ Todos os dados são válidos!
            </div>`


        );
          enviarDados();
    }

});

function converterParaInputDate(data){
    if(!data || !data.includes('/')) return '';
    const p=data.split('/');
    return `${p[2]}-${p[1]}-${p[0]}`;
}

function converterParaExibicao(data){
    const p=data.split('-');
    return `${p[2]}/${p[1]}/${p[0]}`;
}



function marcarErro(td, rowIdx, colIdx, valor, erros){
    td.addClass('erro-validacao');
    erros.push(`Linha ${rowIdx+1}, Coluna ${colIdx}: valor inválido (${valor})`);
}

function validarData(data){
    const regex = /^\d{2}\/\d{2}\/\d{4}$/;
    if(!regex.test(data)) return false;

    const partes = data.split('/');
    const dia = parseInt(partes[0],10);
    const mes = parseInt(partes[1],10)-1;
    const ano = parseInt(partes[2],10);

    const dt = new Date(ano,mes,dia);

    return dt &&
        dt.getFullYear() === ano &&
        dt.getMonth() === mes &&
        dt.getDate() === dia;
}



function enviarDados(){
    anolectivo= $("#selectAno").val();

    let dados = [];

    table.rows().every(function(){
        dados.push(this.data());
    });

    $.ajax({
        url:urlUPLOADfILA,
        type:"POST",
        dataType:'json',
        data:{
            _token:"{{ csrf_token() }}",
            dados:dados,
            ano:anolectivo,
            cabecalho:cabecalho

        },
        xhr:function(){
            let xhr=new window.XMLHttpRequest();
            xhr.upload.addEventListener("progress",function(evt){
                if(evt.lengthComputable){
                    let percent=Math.round((evt.loaded/evt.total)*100);
                    $("#uploadProgress").css('width',percent+'%').text(percent+'%');
                }
            });
            return xhr;
        },
        success: function(response) {

            if(response.status!==true){
  mostrarAlerta(response.status, response.mensagem,response.status);
            }


    $("#uploadProgress").css('width','100%').text('100%');
    if (response.status == true) {
        window.location.reload(); // ou simplesmente location.reload();
    }
},
        error:function(){
            alert("Erro ao enviar dados");
        }
    });

}

});




</script>
