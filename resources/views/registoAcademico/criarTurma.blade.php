@extends('layouts.admin-Lti')
@section('title', 'Lista de Alunos')
@section('content')

<link rel="stylesheet" href="jquery.dataTables.min.css"/>
<link rel="stylesheet" href="buttons.dataTables.min.css"/>

<!-- Content Wrapper. Contains page content -->
<div class="">
  <!-- Content Header (Page header) -->
 <div class="breadcrumb-modern animate-fadeInUp">
        <ol class="breadcrumb" style="background: transparent; margin: 0; padding: 0;">
             <li class="breadcrumb-item">
                <a href="#"><i class="fa fa-graduation-cap"></i> Registo Académico</a>
            </li>
            <li class="breadcrumb-item">
                <a href="#"><i class="fa fa-sitemap"></i> Gestão Turmas</a>
            </li>

            <li class="breadcrumb-item active">
                <i class="fa fa-plus-square"></i> <b>
                     @if($flag==1)
                 Criação de Turma
                @else
                 Criação de Jurri
                @endif
                </b>
            </li>
        </ol>
    </div>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="card">
        <div class="card-header bg-primary">
          <div class="d-flex justify-content-between align-items-center">
            <h3 class="card-title">

                @if($flag==1)
                Filtros para Criação de Turma
                @else
                  Filtros para Criação de Jurri
                @endif

            </h3>
            <button class="btn btn-sm btn-light" id="toggleDistribuicao">
              <i class="fas fa-sliders-h mr-1"></i> Opções de Distribuição
            </button>
          </div>
        </div>

        <div class="card-body">
          <div class="row">
            <div class="form-group col">
              <?php $anoCurente = "20".Date('y'); ?>
              <label for="anoselecionado">Selecione o Ano Lectivo</label>
              <select class="custom-select anoselecionado" name="anoselecionado" id="anoselecionado">
                @foreach($anoLectivo as $anoLectivoItem)
                <option value="{{ $anoLectivoItem->id }}"
                  @if($anoLectivoItem->anolectivo == $anoCurente) selected @endif>
                  {{ $anoLectivoItem->anolectivo }}
                </option>
                @endforeach
              </select>
            </div>

            <div class="form-group col">
              <label for="classeSelecionada">Selecione a Classe</label>
              <select id="classeSelecionada" class="custom-select classeSelecionada" name="classeSelecionada">
                @foreach($classes as $classesItem)
                <option value="{{ $classesItem->id }}">{{ $classesItem->Descricao }}</option>
                @endforeach
              </select>
            </div>

             <div class="form-group col areaDisciplinaDiv" style="display: none">
              <label for="labelareaDisciplina" class="labelareaDisciplina"> </label>
              <select id="areaDisciplina" class="custom-select areaDisciplina" name="areaDisciplina">

              </select>
            </div>

          </div>
        </div>
      </div>

      <!-- Floating Distribution Options Panel -->
      <div class="card shadow-lg " id="distribuicaoPanel" style="display: none; position: absolute; width: 70%; z-index: 1000; left: 20%;">
        <div class="card-header bg-info">
          <div class="d-flex justify-content-between align-items-center">
            <h3 class="card-title">Opções de Distribuição</h3>
            <button class="btn btn-sm btn-light" id="closeDistribuicao">
              <i class="fas fa-times"></i>
            </button>
          </div>
        </div>
        <div class="card-body ">
          <div class="row">
            <div class="form-group col-md-3">
              <label for="Quantidade">
                @if($flag==1)
                Quantidade por Turma
                @else
                   Quantidade por Jurri
                @endif

              </label>
              <input type="number" class="form-control Quantidade" value="20">
            </div>

            <div class="form-group col-md-3">
              <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input por_idade" id="por_idade" value="1">
                <label class="custom-control-label" for="por_idade">Distribuir por idade</label>
              </div>
            </div>

            <div class="form-group col-md-3">
              <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input por_sexo" id="por_sexo" value="1">
                <label class="custom-control-label" for="por_sexo">Distribuir por sexo</label>
              </div>
            </div>

            <div class="form-group col-md-3">
              <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input por_Alfabeto" id="por_Alfabeto" value="1">
                <label class="custom-control-label" for="por_Alfabeto">Ordem alfabética</label>
              </div>
            </div>
          </div>

          <div class="row mt-3">

             <div class="col-md-6 text-left gerar_at_passadodiv">
                @if($flag==1)
              <button class="btn btn-success gerar_at_passado " >
                <i class="fa fa-plus-circle"></i> Aplicar Distribuicao de ano anterior
              </button>
              @endif
            </div>
            <div class="col-md-6 text-right Gerar_turmadiv">
              <button class="btn btn-success Gerar_turma">
                <i class="fa fa-plus-circle"></i>

                @if($flag==1)
                Aplicar e Criar Turma
                @else
                  Aplicar e Criar Jurri
                @endif
              </button>
            </div>
          </div>
        </div>
      </div>



          <div class="Tabelaalunosselecionadoasporanoclasses">
            <!-- Content will be loaded via AJAX -->
          </div>


    </div>
  </section>
</div>

@push('scripts')

<script>

let flag=@json($flag);
let classes=@json($classes);



$(document).ready(function(){
 console.log("flag",flag);

 if(Number(flag)===2){
    ArreaDisciplimaJurri()
 }




desablitarButao();



  // Initialize with data
  buscar_Dados();

  // Event listeners for filters
  $("#anoselecionado, .classeSelecionada").change(function(){
    ArreaDisciplimaJurri();

     if ( $.fn.DataTable.isDataTable('.listadosalunosTurma') ) {
    $('.listadosalunosTurma').DataTable().destroy();
}
    buscar_Dados();
  });

  // Toggle distribution panel
  $("#toggleDistribuicao").click(function(){
    $("#distribuicaoPanel").fadeIn();
    desablitarButao();
  });

  // Close distribution panel
  $("#closeDistribuicao").click(function(){
    $("#distribuicaoPanel").fadeOut();
  });

  // Close when clicking outside
  $(document).mouseup(function(e) {
    var container = $("#distribuicaoPanel");
    if (!container.is(e.target) && container.has(e.target).length === 0) {
      container.fadeOut();
    }
  });

  $(".passarparaturma").click(function(){
    if($("[name='alunoClasse']").is(":checked")) {
      if(confirm('Tem certeza que deseja adicionar os alunos selecionados à turma?')) {
        addicionaraturma();
      }
    } else {
      alert('Atenção: Selecione alunos para adicionar à turma.');
    }
  });
});

function buscar_Dados() {
  var ano = $(".anoselecionado").val();
  var classe = $(".classeSelecionada").val();
  var classe = $(".classeSelecionada").val();
  var areaDisciplina = $(".areaDisciplina").val();
  var url = "/RegistoAcademico/alunosporanoselecionados/"+ano+"/"+classe+"/"+flag+"/"+areaDisciplina;

  $.ajax({
    url: url,
    type: 'GET',
    beforeSend: function() {
      $(".Tabelaalunosselecionadoasporanoclasses").html(
        '<div class="text-center">' +
        '<p>Carregando dados...</p>' +
        '</div>'
      );
    },
    success: function(data) {
      $(".Tabelaalunosselecionadoasporanoclasses").html(data);
    },
    error: function() {
      $(".Tabelaalunosselecionadoasporanoclasses").html(
        '<div class="alert alert-danger">Erro ao carregar dados. Por favor, tente novamente.</div>'
      );
    }
  });
}




function desablitarButao(){

if($(".classeSelecionada").val()<2){

    $(".gerar_at_passadodiv").hide();
$(".Gerar_turmadiv").removeClass('col-md-6');
$(".Gerar_turmadiv").addClass('col-md-12');
}
else{
     $(".gerar_at_passadodiv").show();

}
}


function ArreaDisciplimaJurri() {
 classid=$("#classeSelecionada").val();

    const selecionado = classes.find(e => Number(e.id) === Number(classid));

    // console.log(selecionado,disciplinas);
    console.log(selecionado,selecionado.disciplinas);
    if (!selecionado) return;

    $(".areaDisciplinaDiv").show();

    let areaDisciplina = "";

    const tipo = Number(selecionado.FormaTrasitar_id);

    if (tipo === 2) {

        areaDisciplina += `
            <option value="1">Ciencias</option>
            <option value="2">Letras</option>
        `;

        $(".labelareaDisciplina").text("Selecione uma secção");

    } else if (tipo === 3) {

        $(".labelareaDisciplina").text("Selecione a disciplina");

        selecionado.disciplinas.forEach(element => {
            areaDisciplina += `<option value="${element.id}">${element.Descricao}</option>`;
             //console.log(element);
        });


    } else {
        $(".areaDisciplinaDiv").hide();
    }
//  console.log("kgfklgfklgfklgfklgf");
    $(".areaDisciplina").html(areaDisciplina);
}

</script>
@endpush

<style>
  #distribuicaoPanel {
    box-shadow: 0 0 20px rgba(0,0,0,0.2);
    border-radius: 5px;
    top: 150px;
  }
</style>

@endsection
