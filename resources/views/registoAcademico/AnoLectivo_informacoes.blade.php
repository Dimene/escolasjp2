@extends('layouts.admin-Lti')
@section('title', 'Ano Lectivo')
@section('content')

<link  rel="stylesheet" href="jquery.dataTables.min.css"/>
<link  rel="stylesheet"  href="buttons.dataTables.min.css"/>

<!-- Content Wrapper. Contains page content -->
<div class="">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid ">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h3 class="m-0 text-dark">  Atualizar Ano Lctivo</h3>
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



@if(isset($dados[0]->nome))
<div class="card col-8 container-fluid">
    <div class="card-body">
        <h5 class="card-title"> Esta configuração, possui Alunos Associados</h5>
        <p class="card-text">

        <table class="table table-light">
        <thead>
        <tr>
       <th> Nome </th>
       <th> Classe </th>
       <th> Ano </th>
        </tr>

        </thead>
            <tbody>
            @for($x=0; $x<count($dados);$x++)


                <tr>
                    <td>{{$dados[$x]->nome}}</td>
                    <td>{{$dados[$x]->classe}}</td>
                    <td>{{$dados[$x]->anolectivo}}</td>
                </tr>
                @endfor
            </tbody>
        </table>
        </p>
    </div>
</div>
@else


<div class="card  col-8 container-fluid">
    <div class="card-body">
        <h5 class="card-title"><i class="fa fa-lg fa-warning">Pretendes Apagar Ano Lectivo{{$dadosAno[0]->anolectivo}} ??</i></h5>
        <p class="card-text">

    <div class="row">
        <div class="col">
           <div class="card">
               <div class="card-body">

                   <p class="card-text"><b>Inicio :</b>{{$dadosAno[0]->Inicio}}</p>
                   <p class="card-text"><b>Fim :</b>{{$dadosAno[0]->Fim}}</p>
                   <p class="card-text"><b>Divisao :</b>{{$dadosAno[0]->modalidade}}</p>
               </div>
           </div>

        </div>


        <div class="col">
           <div class="card">
               <div class="card-body">
                Divisoes do Ano
                 @for($i = 0; $i < count($dadosAnoLectivoDisao); $i++)


                   <p class="card-text"><b>Divisao</b> {{$i+1}} &nbsp;  <b>Inicio :</b>{{$dadosAnoLectivoDisao[$i]->Inicio}}  &nbsp;
                    <b>Fim :</b>{{$dadosAnoLectivoDisao[$i]->Fim}}</b></p>

                   @endfor

               </div>
           </div>

        </div>

    </div>


      <div class="card-body  col-md-8 container-fluid ">
      <div class="row ">
      <div class="col-md-6">

      <form class="" method="post" action="{{Route('ano.destroy',$dadosAno[0]->id )}}">

      @method("Delete")
       @csrf
        <button name="" id="" class="btn btn-danger" href="#"  type="submit" role="button">Sim</button>

</form>
</div>
  <div class="col-md-6">
        <a name="" id="" class="btn btn-primary" href="{{Route('ano.create')}}" role="button">Cancelar</a>

        </div>
        </div>
        </div>
        </div>

        </p>
    </div>
</div>


@endif
  @endsection
