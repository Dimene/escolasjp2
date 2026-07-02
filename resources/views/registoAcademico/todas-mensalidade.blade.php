@extends('layouts.admin-Lti')
@section('title', 'Lista de Alunos')
@section('content')

<link  rel="stylesheet" href="{{ asset('Datatable/css/jquery.dataTables.min.css')}}"/>


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h3 class="m-0 text-dark">Pagina Inicial</h3>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Registo Académico</a></li>
            <li class="breadcrumb-item active"> Alunos inscritos </li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <div class="content  container-fluid">
    <div class=" container  no-border no-shadow card-body" style="background-color: #fff">

<div class="row">
    <div class="col">

        <div class="form-group">
            <label for="my-select">Ano</label>
            <select id="my-select" class="form-control  selectAno" name="">
            @for ($x=0; $x<count($anos);$x++ )


                <option value="{{$anos[(count($anos)-1)-$x]->id}}">{{$anos[(count($anos)-1)-$x]->anolectivo}}</option>
                @endfor
            </select>
        </div>
    </div>

</div>


<div class="card">
    <div class="card-body">

	   <div class="Tabela-de-mes">
	   </div>
     </div>
 </div>
    </div>
</div>

</div>



  </div>
</div>






	@push('script')
    <script>

$(document).ready(function(){
    selecionarAlunos($(".selectAno").val(),$(".selectClasse").val());
    $(".selectAno").change(function(){

        selecionarAlunos($(".selectAno").val(),$(".selectClasse").val());
    });

     $(".selectClasse").change(function(){

        selecionarAlunos($(".selectAno").val(),$(".selectClasse").val());
    });
});




   function selecionarAlunos($ano,$classe){
    $.ajax({
        url:"/aluno/mensalida/todas/todos/"+$ano+"/"+$classe,
         type: 'GET',
         beforeSend: function(){
            $(".Tabela-de-mes").html(' <img src="{{ asset('imageproceaament/loading.gif')}}"  style=" margin-left:500px;width:200px;height:200px">');
          },




            success: function (data, textStatus, jqXHR) {
                // $(".processamento").fadeOut();


			$(".Tabela-de-mes").html(data);
            }
    })
}
</script>
  @endpush
    @endsection
