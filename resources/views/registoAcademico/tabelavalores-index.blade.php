@extends('layouts.admin-Lti')
@section('title', 'Ano Lectivo')
@section('content')

<link  rel="stylesheet" href="jquery.dataTables.min.css"/>
<link  rel="stylesheet"  href="buttons.dataTables.min.css"/>

<!-- Content Wrapper. Contains page content -->
<div class="breadcrumb-modern animate-fadeInUp">
        <ol class="breadcrumb" style="background: transparent; margin: 0; padding: 0;">
            <li class="breadcrumb-item">
                <a href="#"><i class="fa fa-cogs"></i> Gestão de Configuracoes</a>
            </li>

            <li class="breadcrumb-item active">
                <i class="fa fa-table"></i> <b>Tabela de  Valores</b>
            </li>
        </ol>
    </div>
<div class="">
  <!-- Content Header (Page header) -->

@if ($errors->any())
    <div class="alert alert-danger container-fluid col-md-8">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
  <!-- /.content-header -->


  <div class="row container-fluid">
  <div class="col-md-4">
 <div class="card no-border no-shadow">
 <div class="card-header">
 tabela de Valores
 </div>
 <div class="card-body">
<ul class="list-group">
    <li class="list-group-item active ListaItem TablelaVisualizar" title="show">Visualizar</li>
    <li class="list-group-item  ListaItem" aria-disabled="true" title="create">Adicionar</li>
    <li class="list-group-item  ListaItem" aria-disabled="true"
     title="NovoPagamento">Criar novo pagamento

    </li>

</ul>


</ul>
 </div>

</div>

  </diV>
  <div class="col-md-8">

  <!-- Main content -->
  <div class="content  container-fluid  TablelaVisualizar ListaItemDiv">
  @if(isset($colecao))
    <div class="alert alerta-cadastro alert-success " role="alert">
        <h4 class="alert-heading">{{$colecao}}</h4>

    </div>
	  @endif
    <div class="container  content-Add no-border no-shadow card-body Tabelashow" style="background-color: #fff" >


  <!--tabela DE VAVLORES SHOW-->




  <!--fIM TABELA vALORES SHOW-->






          </div>
          <br>
</div>




</div>
</div>
</div>






	@push('script')
    <script>

  var urlstore ='{{Route('TabelaValores.store')}}';

  var token ='{{Session::token()}}';



$(document).ready(function(){

$.ajax({
	url:"/RegistoAcademico/TabelaValores/show",
	type:'GET',
	success:function(data){

		$(".content-Add").html(data);

	}

});





$(".ListaItem").click(function(){
$(".ListaItem").removeClass('active');
$(this).addClass('active');
$(".alerta-cadastro").hide();
var novaurl="";
if($(this).attr('title')==="NovoPagamento"){
    novaurl ="metodosdepagamentos/NovoPagamento";
}
else{
novaurl ="/RegistoAcademico/TabelaValores/"+$(this).attr('title');
}
$.ajax({
	url:novaurl,
	type:'GET',
	success:function(data){

		$(".content-Add").html(data);

	}

});
});



});




    </script>

    <style>
    <style>
.novoItem {

  background: red;
  transition-property: background;
  transition-duration: 30s;
  transition-timing-function: linear;
  transition-delay: 10s;
}

.aparecer {

  background:#5DAC68;
}

    </style>

    @endpush
@endsection
