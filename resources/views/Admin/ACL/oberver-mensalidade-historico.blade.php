@extends('layouts.admin-Lti')
@section('title', 'Pagina Inicial')

@section('content')


    <!-- Content Wrapper. Contains page content -->

        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">

                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">mensalidade</a></li>
                            <li class="breadcrumb-item"><a href="#">operacoes</a></li>
                            <li class="breadcrumb-item active">historico</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->
<div class="card container-fluid" style="width: 30rem;">
    <!--tips: add .text-center,.text-right to the .card to change card text alignment-->

    <div class="card-body">
        <h5 class="card-title"><label> Utima Atualiza&ccedil;&atilde;o do Mes de {{ $dados->mes }}</label></h5>
        <hr>
       <div class="row">
        <b class="col">Nome</b>
        <div class="col">{{ $dados->nome }}</div>
       </div>
       <div class="row">
        <b class="col">Classe</b>
        <div class="col">{{ $dados->classe }}</div>
       </div>

       <div class="row">
        <b class="col">Ano Lectivo</b>
        <div class="col">{{ $dados->anolectivo }}</div>
       </div>

       <div class="row">
        <b class="col">Data de ultima Atualiza&ccedil;&atilde;o</b>
        <div class="col">{{ $dados->updated_at }}</div>
       </div>
       <div class="row">
        <b class="col">Estado</b>
        <div class="col">{{ $dados->Estado }}<div>
       </div>
    </div>
</div>


                <!-- /.row -->
            </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
    </div>
    </div>
    </div>





@endsection
