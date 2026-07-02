@extends('layouts.admin-Lti')

@section('title', 'atualizar dados')


<?php

$request =Request();
    $host = $request->getHost();

    $subdomain = explode('.', $host)[0];
?>
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
                            <li class="breadcrumb-item active">Visuaizar Alunos</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->




        <div class="container-fluid card col-md-10">
            <div class="row">

                <div class="col-md-2">
                </div>
                <div class="col-md-8 ">
                    <div style="width: 100%; height: 350px;">
                        <?php if(isset($aluno->avatar)) { ?>



    <img src="/storage/{{$subdomain}}/fotoAluno/{{ $aluno->avatar }}" alt=""
                style="width: 70%; height: 70%;margin-left: 10%;
                 margin-top: 10%;border-radius: 20px; border: 2px solid rgb(14, 13, 13)">

            <?php }  else{
			?>
            <img src="/storage/fotoAluno/avatar.png" alt=""
                style="width: 70%; height: 70%;margin-left: 10%;
                 margin-top: 10%;border-radius: 20px; border: 2px solid rgb(14, 13, 13)">
            <?php

		}?>




                    </div>
                </div>
                <div class="col-md-2">
                </div>
            </div>
            <div class="row">
                <div class="col-md-2">
                </div>

                <div class="col-md-8">



                    <div class="profile-block">
                        <h3>Dados Do Aluno</h3>

                        <ul>


                            <li><span class="font-400"><b>Nome do Aluno:</b> </span><span
                                    class="profile-right">{{ $aluno->nome }}</span> </li>
                            <li><span class="font-400"><b>Sexo:</b> </span><span
                                    class="profile-right">{{ $aluno->sexo }}</span> </li>
                            <li><span class="font-400"><b>Idade:</b> </span>
                                <span
                                    class="profile-right">{{ carbon\Carbon::now()->format('y') - carbon\Carbon::createFromDate($aluno->dataNascimento)->format('y') }}</span>
                            </li>

                            <li><span class="font-400"><b>Tipo:</b> </span><span class="profile-right">
                                    @if ($aluno->Tipo == 'B')
                                        {{ 'Bolseiro' }}
                                    @else
                                        {{ 'Normal' }}
                                    @endif
                                </span> </li>
                            <li><span class="font-400"><b>Encaregado de Educa&ccedil;&atilde;o:</b> </span><span
                                    class="profile-right">
                                    {{ $aluno->Encaregado }}
                                </span> </li>
                            @if ($flag != 1)
                                <li><span class="font-400"><b>Grau de Parentesco</b> </span><span class="profile-right">
                                        {{ $aluno->GrauParentesco }} </span> </li>
                                <li><span class="font-400"><b>Profissão </b> </span><span class="profile-right">
                                        {{ $aluno->profissaoEncaregado }} </span> </li>
                                <li><span class="font-400"><b>Religião </b> </span><span class="profile-right">
                                        {{ $aluno->Religiao_Encaregado }} </span> </li>


                                <li><span class="font-400"><b>Classe frequentada Anteriormente:</b> </span><span
                                        class="profile-right">
                                        {{ $aluno->classe }}
                                    </span> </li>
                                <li><span class="font-400"><b>Classe frequentada Estado:</b> </span><span
                                        class="profile-right">
                                        @if ($aluno->Estado_Classe == null)
                                            {{ 'Frequentado' }}
                                        @else
                                            {{ $aluno->Estado_Classe }}
                                        @endif
                                    </span> </li>

                                <li><span class="font-400"><b>Classe frequentada Estado:</b> </span><span
                                        class="profile-right">
                                        @if ($aluno->Estado_Classe == null)
                                            {{ 'Frequentado' }}
                                        @else
                                            {{ $aluno->Estado_Classe }}
                                        @endif
                                    </span> </li>

                                <h3>Endereço </h3>
                                <li><span class="font-400"><b>Bairo</b> </span><span class="profile-right">
                                        {{ $aluno->Endereco }} </span> </li>
                                <li><span class="font-400"><b>Avenida/Rua</b> </span><span class="profile-right">
                                        {{ $aluno->RuaAvenida }} </span> </li>
                                <li><span class="font-400"><b>Casa</b> </span><span class="profile-right">
                                        {{ $aluno->Casa }} </span> </li>
                                <li><span class="font-400"><b>Quarteirão </b> </span><span class="profile-right">
                                        {{ $aluno->Quarterao }} </span> </li>

                                <h3></h3>Contactos </h3>





                                <li><span class="font-400"><b>Telefone/Celular</b> </span><span class="profile-right">
                                        @foreach ($contactos as $item)
                                            {{ $item->Descricao }} ,
                                        @endforeach
                                    </span> </li>

                    </div>
                </div>
                <div class="col-md-2">
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">


                    <hr>
                    <center>
                </div>
                @endif;
                <div class="col-10">
                    <div class="row">
                        <div class="col-12">
                        </div>

                        @if ($flag == 2)
                            <div class="col-12">
                                <a class="btn btn-primary"
                                    href="{{ Route('aluno.restoryAlunoClasse', $aluno->idAlunoclasse) }}">
                                    <i class="fa fa-shower"></i>Recuperar</a>
                            </div>
                        @elseif($flag == 1)
                            <div class="col-12">
                                @can('Apagar-Aluno')
                                    <a class="btn btn-danger"
                                        href="{{ Route('aluno.ApagarDados', [$aluno->id, $aluno->anolectivo_id]) }}"><i
                                            class="fa fa-trash"></i>Apagar</a>
                                @endcan

                            </div>
                        @else
                            <div class="col-12">
                                <span>IMprimir</span>
                                <button class="btn  btn-primary Recibo-print" idaluno="{{ $aluno->id }}"
                                    classAluno="{{ $ano }}"> Recibo </button>
                                {{--  {{ Route('aluno.   imprimir_reciboMatricula',[$aluno->id, $aluno->Classe_id]) }}  --}}
                                <a class="btn btn-primary  " href="{{ Route('aluno.Informacao', [$aluno->id]) }}"> Dados
                                </a>

                            </div>
                        @endif
                        <div class="col dadosshow">
                        </div>
                    </div>
                </div>
                </center>
            </div>
        </div>
    </div>






    @push('style')
        <link rel="stylesheet" href="{{ asset('perfilView/assets/bootstrap/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('perfilView/assets/fonts/ionicons.min.css') }}">
        <link rel="stylesheet" href="{{ asset('perfilView/assets/css/styles.min.css') }}">
    @endpush


    @push('script')
        <script>
            $(".Recibo-print").click(function() {



                $url = "/aluno/matricula/imprimir/recibo/" + $(this).attr("idAluno") + "/" + $(this).attr("classAluno");


                $.ajax({
                    url: $url,
                    type: 'GET',
                    beforeSend: function() {
                        //  $(".Tabela-de-mes").fadeOut()
                        //    $(".processamento").fadeIn()
                    },

                    success: function(data, textStatus, jqXHR) {
                        //    $(".processamento").fadeOut();

                        //   $(".Tabela-de-mes").fadeIn();
                        //	alert(data);
                        // $(".dadosshow").html(data);
                        //console.log(data);

                        //var conteudo = document.getElementById('conteudoDivshow').innerHTML,
                        tela_impressao = window.open('about:blank');
                        tela_impressao.document.write(data);
                        tela_impressao.window.print();
                        tela_impressao.window.close()
                    }


                });



            })
        </script>
    @endpush






@endsection
