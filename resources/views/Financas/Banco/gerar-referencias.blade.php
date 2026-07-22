<?php


$dados=session()->get('nomeEm');
$avatar= session()->get('infosession')[0]->avatar;

?>
@extends('layouts.admin-Lti')
@section('title', 'Pagina Inicial')

@section('content')

<section class="content">
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid shadow-no">
                <div class="row mb-2">
                    <div class="col-sm-6">

                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right"  >
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">historico</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <div class=" container container-fluid col-md-10">
<form action="{{ route('Financas.store') }}" method="post">

    @csrf
            <div class="card">
            <div class="card-body">

                <center>

                <legend><b>  Refer&ecirc;ncias Bancarias</b></legend>
            </center>

            </div>
        </div>
        <div class="card  shadow-none">

        <div class="card-body row">

            <div class="form-group col-md-12">
                <label for="my-select">Selecione o Banbo</label>
                <select id="my-select" class="form-control selectInput" name="Entidade">

                    @foreach ( $banco as  $bancoItem)
                    <option value="{{ $bancoItem->id}}">{{ $bancoItem->descricao }}({{ $bancoItem->Entidade }})</option>
                    @endforeach

                </select>
            </div>
            <div class="form-group col-md-12">
                <label for="my-select">Selecione  Ano Lectivo</label>
                <select id="my-select" class="form-control selectInput" name="anolectivo">
                    @foreach ( $anolectivo as $anolectivoItem )


                    <option value="{{ $anolectivoItem ->id}}"


                       >{{ $anolectivoItem ->anolectivo}}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-md-12">
                <label for="my-select">Selecione Tipo de Pagamento</label>
                <select id="my-select" class="form-control selectInput" name="tipopagamento">
                    @foreach ( $tipopagamento as $tipodepagamentoItem )


                    <option   value="{{ $tipodepagamentoItem ->id}}"   >
                        {{ $tipodepagamentoItem ->Descricao}}
                    </option>
                    @endforeach
                </select>
            </div>


            <div class="form-group col-md-12">
                <label for="my-select">classe</label>
                <select id="my-select" class="form-control selectInput " name="classe">
                    @foreach ( $classes as $classeItem )


                    <option   value="{{ $classeItem ->id}}"   >
                        {{ $classeItem ->Descricao}}
                    </option>
                    @endforeach
                </select>
            </div>
            </div>

        </div>


        <div class="col card float-right">

            <div class="card-footer">
        <button class="btn btn-primary float-right" type="submit">Guardar</button>
            </div>
        </div>
    </from>

    </div>



    <div class="container dadosRequest">


    </div>
     <!-- /.row -->
            </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
    </div>
    </div>
    </div>
    </div>
</section>

@push('scripts')
<script>



@endpush


@endsection
