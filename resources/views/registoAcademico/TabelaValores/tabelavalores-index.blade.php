@extends('layouts.admin-Lti')
@section('title', 'Ano Lectivo')
@section('content')

<link  rel="stylesheet" href="jquery.dataTables.min.css"/>
<link  rel="stylesheet"  href="buttons.dataTables.min.css"/>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid ">
      <div class="row mb-2">
        <div class="col-sm-4">
          <h3 class="m-0 text-dark"></h3>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Registo Académico</a></li>
            <li class="breadcrumb-item active"> Configurar Ano </li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
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
    <li class="list-group-item active ListaItem TablelaVisualizar" title="TablelaVisualizar">Visualizar</li>
    <li class="list-group-item  ListaItem" aria-disabled="true" title="TablelaAdicionar">Adicionar</li>
</ul>


</ul>
 </div>

</div>

  </diV>
  <div class="col-md-8">

  <!-- Main content -->
  <div class="content  container-fluid  TablelaVisualizar ListaItemDiv">
    <div class="container  no-border no-shadow card-body Tabelashow" style="background-color: #fff" >


  <!--tabela DE VAVLORES SHOW-->




  <!--fIM TABELA vALORES SHOW-->






          </div>
          <br>
</div>

<div class="content  container-fluid  TablelaAdicionar ListaItemDiv"  style="display:none">
    <div class="container  no-border no-shadow card-body   tabelaformshow" style="background-color: #fff">

   <!--FORMULARIO DE valores -->



   <!--FIM-->



</div>




</div>
</div>
</div>






	@push('script')
    <script>

  var urlstore ='{{Route('TabelaValores.store')}}';

  var token ='{{Session::token()}}';







    </script>
	<script src="{{ asset('MyJs/tabela-valores.js')}}"></script>
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
