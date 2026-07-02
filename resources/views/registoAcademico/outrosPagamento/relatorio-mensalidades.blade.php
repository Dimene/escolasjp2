@extends('layouts.admin-Lti')
@section('title', 'Relatorio Mensalidades')
@section('content')

    <link rel="stylesheet" href="{{ asset('Datatable/css/jquery.dataTables.min.css') }}" />


    <!-- Content Wrapper. Contains page content -->
    <div class="">
        <!-- Content Header (Page header) -->
       <div class="breadcrumb-modern animate-fadeInUp">
        <ol class="breadcrumb" style="background: transparent; margin: 0; padding: 0;">
            <li class="breadcrumb-item">
                <a href="#"><i class="fa fa-graduation-cap"></i> Registo Académico</a>
            </li>
            <li class="breadcrumb-item">
                <a href="#"><i class="fa fa-credit-card"></i>Pagamentos</a>
            </li>
            <li class="breadcrumb-item active">
                <i class="fa fa-chart-line"></i> <b>Relatorio Generico</b>
            </li>
        </ol>
    </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <div class="content  container-fluid">
            <div class=" container  no-border no-shadow card-body" style="background-color: #fff">

                <div class="row">
                    <div class="col">

                        <div class="form-group">

                            <div class="col">

                                <div class="form-group">
                                    <label>Ano</label>
                                    <select class="anolectivo selectescohido" data-placeholder="" style="width: 100%;">
                                        @foreach ($anolectivos as $anolectivoItem)
                                            <option value="{{ $anolectivoItem->id }}">{{ $anolectivoItem->anolectivo }}
                                            </option>
                                        @endforeach

                                    </select>
                                </div>
                            </div>


                        </div>
                    </div>


                    <div class="col">

                        <div class="form-group">
                            <label>Classe</label>
                            <select class="select2 classes selectescohido" style="width: 100%;">
                                @foreach ($classes as $classesItem)
                                    <option value="{{ $classesItem->id }}">{{ $classesItem->Descricao }}</option>
                                @endforeach

                            </select>
                        </div>
                    </div>
                    <div class="col">

                        <div class="form-group">
                            <label>Tipo de Pagamento</label>
                            <select class="select2 tipo selectescohido" style="width: 100%;">

                                @foreach ($tipoPagamento as $tipoPagamentoItem)
                                 @php
                                    $Descricao=$tipoPagamentoItem->Descricao;
                                @endphp
                                @can("RelatorioPagameto-$Descricao")
                                    <option value="{{ $tipoPagamentoItem->id }}">{{ $tipoPagamentoItem->Descricao }}
                                    </option>
                                    @endcan
                                @endforeach

                            </select>
                        </div>
                    </div>


                </div>


            </div>



        </div>






        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="col conteudoRelatorio">





                </div>
            </div>
        </div>
    </div>

        @push('script')
            <script>
                $(document).ready(function() {

                    $ano = $(".anolectivo").val();
                    $classes = $(".classes").val();
                    $tipo = $(".tipo").val();
                    relatoriotesto($ano, $classes, $tipo);




                    $(".selectescohido").change(function() {

                        $ano = $(".anolectivo").val();
                        $classes = $(".classes").val();
                        $tipo = $(".tipo").val();

                        relatoriotesto($ano, $classes, $tipo);

                    });

                })



                function relatoriotesto($ano, $classe, $tipo, $flag) {
                    $.ajax({
                        url: "/RegistoAcademico/outrosPagamento/Relatorio/" + $ano + "/" + $classe + "/" + $tipo,
                        type: 'GET',
                        success: function(data, textStatus, jqXHR) {

                            $(".conteudoRelatorio").html(data);
                        }
                    })
                }
            </script>
        @endpush





    @endsection
