
@php
$classe = $alunosturma[0]->classe_id??null;
// dd($alunosturma[0]);

$usuario = Auth::user()->id;

$anolectivo = DB::table('classe_direcao')
    ->where("classe_id", $classe)
    ->max("anolectivo_id");

$dadosChave = DB::table('classe_direcao')
    ->where("classe_id", $classe)
    ->where("anolectivo_id", $anolectivo)
    ->where(function ($query) use ($usuario) {

        $query->where("pedagogico_id", $usuario)
              ->orWhere("director_id", $usuario);

    })
    ->first();

    $edicaoativa=false;


     $turmapermisao=DB::table('professor_turmaview')->where("professor_id",$usuario)
    ->where("Tipo_Docencia_id",1)
    ->where("turma_id", $alunosturma[0]->turma_id)->first();
    if($turmapermisao||$dadosChave){
   $edicaoativa=true;
    }


// dd($usuario,$turma,$edicaoativa);
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <?php

    $conf = DB::table('config')->first();

    ?>

</head>

<body class="card">

    <div class="row">

        <div class="col">
            <center>
                <div class="container-fluid"
                    style="height:100px; width:100px; allign: center;  border-radius:500px;margin-bottom: 30px;">
                    <center>
                        <img src="{{ asset('storage/logoMarca/' . $conf->avatar . '') }}"
                            style="width: 100%;height: 100%; border: 3px solid rgba(131, 124, 124, 0.541); border-radius: 60px; ">



                </div>
            </center>

        </div>
    </div>

    <div class="row ">
        <div class="col-md-12 ">

            <center>
                <div class="container-fluid">
                    <h3 class="" style="">
                        <strong>{{ $conf->nome }}
                        </strong>
                    </h3>
                    <p>
                    <h4>Lista Nominal dos Alunos da {{  $alunosturma[0]->classe}} Ano de {{  $alunosturma[0]->anolectivo }}
                    </h4>
                    </p>
                    <hr>
                    @if($tipo==1)
                    <p><b>Turma</b> {{  $alunosturma[0]->turma}} </p>
                    @else
                       <p><b>Jurri</b> {{  $alunosturma[0]->jurri}} </p>
                    @endif
                    <hr>
                </div>
            </center>

            <div>

                <table class="table table-light" width="100%">
                    <thead>
                        <tr style="background-color:rgba(0, 0, 0, 0.102)">
                            <th>Nr</th>
                            <th>Nome</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($alunosturma as $key => $alunoclasseTurmaItem)
                            <tr style="border: 1px solid #ddd; padding: 8px;">
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $alunoclasseTurmaItem->nome }}</td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>



            <center>



        </div>
    </div>

    <hr>
</body>

</html>
