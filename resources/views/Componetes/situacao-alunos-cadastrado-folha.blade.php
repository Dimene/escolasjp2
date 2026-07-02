@extends('layouts.admin-Lti')
@section('title', 'Relatorio de pagamentos')
@section('content')


    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Registo Académico</a></li>
                            <li class="breadcrumb-item ">Relatorio</li>
                            <li class="breadcrumb-item active">Outros pagamentos</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>


        <div class=" card conuainer col-11 mx-5">


            <div class="row card-body container-fluid">

                <table class="table table-light">
                    <thead>
                        <th>
                            Linha
                        </th>
                        <th>
                            Situacao
                        </th>
                    </thead>
                    <tbody>

                        @foreach ($dadosrelatorio as $dadosrelatorioItem)
                            <tr>
                                <td>{{ $dadosrelatorioItem->Linha }}</td>
                                <td>{{ $dadosrelatorioItem->situacao }}</td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>



@endsection
