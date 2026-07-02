<?php

namespace App\Http\Controllers\registoAcademico;

use App\Exports\turmaExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\anolectivoRequest;
use App\Models\registoAcademico\alunoClasse;
use App\Models\registoAcademico\anolectivo;
use App\Models\registoAcademico\anolectivo_meta;
use App\Models\registoAcademico\classe;
use App\Models\registoAcademico\classe_discplina;
use App\Models\registoAcademico\professor_turma;
use App\Models\registoAcademico\turma;
use App\Models\registoAcademico\turma_aluno;
use App\Models\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use Svg\Tag\Rect;

use function Laravel\Prompts\select;

class turmasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

$flag=1;
        $anoLectivo= anolectivo::all();
        $classes= classe::all();
  return view('registoAcademico.criarTurma',compact('anoLectivo','classes','flag'));
    }

    public function createJurri()
    {

$flag=2;
        $anoLectivo= anolectivo::all();
        $classes= classe::with("disciplinas")->where("Exame",1)->get();
  return view('registoAcademico.criarTurma',compact('anoLectivo','classes','flag'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {



$turmac=turma::create(["Descricao"=>$request->nomeTurma,
 "classe_id"=>$request->classeFrequentada,
 "ano_lecttivo_id"=>$request->Anolectivo_IDD]);


 foreach($request->classesItem  as  $key=>$item):

    if($request->flag==2)
        {DB::table('turma_alunos')->where(  'aluno_classe_id',$item)
             ->update(['jurri'=>$turmac->id,
    "Numero_jurri"=>($key+1)]);
        }
    else{
    DB::table('turma_alunos')->insert(['turma_id'=>$turmac->id,
    'aluno_classe_id'=> $item,"Numero_turma"=>($key+1)]);
    }


 endforeach;


 return redirect('/RegistoAcademico/alunosporanoselecionados/'.$request->Anolectivo_IDD.'/'.$request->classeFrequentada.'/'.$turmac->id.'/'.$request->jurri);
}

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id,$flg,$tipo)
    {


        $alunosturma= DB::select("SELECT * from turmasalunosview
         where turma_id=? or jurri_id=?  ORDER BY(nome) asc ",[$id,$id]);

         $turma = DB::table('turmas')->where('id',$id)->first();

        //  dd($id,$flg,$tipo, $alunosturma);

if($flg==3){



     return  view('registoAcademico.Turma-Lista', compact('turma','alunosturma','tipo'));
}
$turmanome=$turma->Descricao;
if($flg==2){
//$dados= new turmaExport();
//$dadDia=$dados->collection();

  return  Excel::download(new turmaExport($id),"turma".$turmanome.".xlsx");
}
if($flg==1){

    $pdf=PDF::loadView('registoAcademico.Turma-Lista', compact('turma','alunosturma','tipo'))->setPaper('a4');
    //$pdf=PDF::loadView("registoAcademico.mensalidadespagas",compact('aluno','meses','Valores_pago'))->setPaper('a5');
    return $pdf->download("Turma".$turmanome.".pdf");
}

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id,Request $flag)
    {
$alunosturma='';
    // dd($id,$flag->flag);
    $turmacriada= turma::where('id',$id)->first();
    if($flag->flag==1):

        // seleciona alunos da turma
          $alunosturma=DB::table("turmasalunosview")
     ->where("turma_id",$id)
     ->get();
        else:
              $alunosturma=DB::table("turmasalunosview")
     ->where("jurri_id",$id)
     ->get();
        endif;




        return json_encode([$turmacriada,$alunosturma]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
 public function update(Request $request, $id)
{
    turma::where('id', $id)->update([
        "Descricao" => $request->nomeTurma
    ]);

    $turma = turma::find($id);

    $classesItem = $request->classesItem ?? [];

    if ($request->flag != 2) {

        // Alunos atuais na turma
        $existentes = DB::table('turma_alunos')
            ->where('turma_id', $id)
            ->pluck("aluno_classe_id")
            ->toArray();

        // Remover os que saíram
        $remover = array_diff($existentes, $classesItem);

        DB::table('turma_alunos')
            ->where('turma_id', $id)
            ->whereIn('aluno_classe_id', $remover)
            ->delete();

        // Novos alunos
        $novos = array_diff($classesItem, $existentes);

        foreach ($novos as $item) {
            DB::table('turma_alunos')->insert([
                'turma_id' => $id,
                'aluno_classe_id' => $item,
            ]);
        }

        // Atualizar número da turma (ordem)
        foreach ($classesItem as $key => $item) {
            DB::table('turma_alunos')
                ->where('turma_id', $id)
                ->where('aluno_classe_id', $item)
                ->update([
                    'Numero_turma' => $key + 1
                ]);
        }

    } else {

        $alunoExistente = DB::table('turma_alunos')
            ->where('jurri', $id)
            ->pluck("aluno_classe_id")
            ->toArray();

        // Remover do jurri
        $removidos = array_diff($alunoExistente, $classesItem);

        DB::table('turma_alunos')
            ->whereIn('aluno_classe_id', $removidos)
            ->update([
                'jurri' => null,
                'Numero_turma' => null
            ]);

        // Adicionar/Atualizar jurri
        foreach ($classesItem as $key => $item) {
            DB::table('turma_alunos')
                ->where('aluno_classe_id', $item)
                ->update([
                    'jurri' => $id,
                    'Numero_turma' => $key + 1
                ]);
        }
    }

    return redirect('/RegistoAcademico/alunosporanoselecionados/'
        . $turma->ano_lecttivo_id . '/'
        . $turma->classe_id . '/'
        . $id . '/'
        . $request->flag
    );
}

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


public function alunosporclassano($ano, $classe,$flag,$disciplinaArea=null){

    $alunoclasseTurma="";
    $alunoclasse="";
    $turmascriadas="";


if($flag==1):
     $alunoclasse=DB::table("turmasalunosview")
     ->where("ano_lectivo_id",$ano)
     ->where("classe_id",$classe)
     ->whereNull("turma_id")
     ->get();

 $turmascriadas = DB::table("turmasalunosview")
    ->where("ano_lectivo_id", $ano)
    ->where("classe_id", $classe)
    ->whereNotNull("turma_id")
    ->distinct()
    ->get(["turma_id", "turma"]);
else:



    $classedados=classe::where("id",$classe)->first();
    $dadosid=DB::table("formasdetrasitar")->where("id",$classedados->FormaTrasitar_id)->first();

    //    $alunoclasse=DB::table("turmasalunosview")
    //  ->where("ano_lectivo_id",$ano)
    //  ->where("classe_id",$classe)
    //  ->where("Resultado2",)
    //  ->whereNull("jurri_id")
    //  ->get();

    if($classedados->FormaTrasitar_id==1){
       $Resultados = ["Aprovado", "Aprovada"];

// $Resultados = ["Reprovada", "Reprovado"];

$alunoclasse = DB::table("turmasalunosview")
    ->where("ano_lectivo_id", $ano)
    ->where("classe_id", $classe)
    ->whereNull("jurri_id")
    ->whereNotNull("Resultado1")
    ->whereIn(DB::raw("TRIM(Resultado1)"), $Resultados)
    ->get();


    }
    if($classedados->FormaTrasitar_id==2){


if($disciplinaArea==1):

$Resultado=["Reprovado  em Ciências","Reprovado ","Reprovada ","Reprovada  em Ciências "," "];
     $alunoclasse=DB::table("turmasalunosview")
     ->where("ano_lectivo_id",$ano)
     ->where("classe_id",$classe)
     ->whereNotIn("Resultado1",$Resultado)
     ->whereNull("jurri_id")
     ->get();
else:
$Resultado=["Reprovado  em Letras ","Reprovado","Reprovada "," ","Reprovada  em Letras "];
          $alunoclasse=DB::table("turmasalunosview")
     ->where("ano_lectivo_id",$ano)
     ->where("classe_id",$classe)
     ->whereNotIn("Resultado1",$Resultado)
     ->whereNull("jurri_id")
     ->get();
endif;
    }
    elseif($classedados->FormaTrasitar_id==3){


    }


     $turmascriadas = DB::table("turmasalunosview")
    ->where("ano_lectivo_id", $ano)
    ->where("classe_id", $classe)
    ->whereNotNull("jurri_id")
    ->distinct()
    ->get(["jurri_id", "jurri"]);

endif;

   // $alunoclasse=DB::table("alunosescritos")->where("Classe_id",$classe)->where('anolectivo_id',$ano)->get();


//turmas criadas


if ($turmascriadas->isNotEmpty()):
    $jurri= $turmascriadas->pluck("jurri_id")->toArray();
    $turma= $turmascriadas->pluck("turma_id")->toArray();

// turmas aluno escolhido primera'
 if (!empty($turma)):
$alunoclasseTurma= DB::table("turmasalunosview")
    ->where("ano_lectivo_id", $ano)
    ->where("classe_id", $classe)
    ->whereIn("jurri_id", $turmascriadas->pluck("jurri_id")->toArray())->get();
endif;
    if(empty($jurri)):
$alunoclasseTurma=DB::table("turmasalunosview")
    ->where("ano_lectivo_id", $ano)
    ->where("classe_id", $classe)
    ->whereIn("jurri_id", $turmascriadas->pluck("jurri_id")->toArray())->get();
endif;

endif;


return view('registoAcademico.alunospor-classe-ano-selectionados',
compact('alunoclasse','turmascriadas','alunoclasseTurma','flag'));
//return response()->json($alunoclasse);
}


public function marcarAlunos(Request $request){
    return response()->json($request->classes);


    $alunoclasse=DB::table("alunosescritos")->whereIn("idAlunoclasse",$request->classes)->get();
    return $alunoclasse;
}


public function export()
    {
        return Excel::download(new UsersExport, 'users.xlsx');
    }


    public function atribuirturma(){

        $dfuncionarios= User::all();
return view('auth.atribuirturma',compact('dfuncionarios'));
    }


    public function professoresselect(){
        $dfuncionarios= User::all();
        return view('auth.tabela-dados-atribuir-turma',compact('dfuncionarios'));
    }

    public function turmasprofesssor($id){
        $classe=classe::all();
        $anoLectivo= anolectivo::orderBy('id', 'DESC')->get();

        $tumasprofessor= DB::table('professor_turmaview')
        ->where('professor_id', $id)
       -> where('ano_lectivo_id',$anoLectivo[0]->id)
       ->get();

        return  view('auth.TurmasAtribuida-propfessor',compact('classe','anoLectivo','id','tumasprofessor'));
    }

    public function professoresselectdados($id,$classe,$ano){


        $tumasprofessor= DB::table('professor_turmaview')
        ->where('professor_id', $id)
       -> where('ano_lectivo_id',$ano)
       -> where('classe_id',$classe)
       ->get();




        $classes = classe::where('id', $classe)->with(['disciplinas','turmas','tipoDocencia'])->first();

        $classe_turma=turma::where('classe_id', $classe)->where('ano_lecttivo_id',$ano)->get();
  // 👉 Coleção personalizada de disciplinas
    $disciplinasFormatadas = collect();



  if($classes->disciplinas->isNotEmpty()){

    if($classes->TIpo_Docencia_id==2):

//   dd($classes->TIpo_Docencia_id);
    foreach($classes->disciplinas  as $dados):
$disciplinasFormatadas->push(['id' =>  $dados->id,'Descricao' =>  $dados->Descricao]);

    endforeach;

else:
 $disciplinasFormatadas->push( ['id' => 1000,'Descricao' => 'Mono Docência']);


     endif;
  }else{
    $disciplinasFormatadas->push( ['id' => 0,'Descricao' => 'Não possui Disciplinas']);
  }







        return  view('auth.classe-turma-professor',compact(['tumasprofessor',
        'classe_turma','classes','id','ano',"disciplinasFormatadas"]));
    }

    public function turmacheckprofessor($id,$classe,$ano,$disp){

          $tumasprofessor= DB::table('professor_turmaview')
        ->where('professor_id', $id)
       -> where('ano_lectivo_id',$ano)
       -> where('classe_id',$classe)
       -> where('disciplina_id',$disp)
       ->get();;

          if(  $disp==1000|| $disp==0):
        $tumasprofessor= DB::table('professor_turmaview')
        ->where('professor_id', $id)
       -> where('ano_lectivo_id',$ano)
       -> where('classe_id',$classe)
       ->get();



          endif;
        $classes = classe::where('id', $classe)
        ->with(['disciplinas','turmas'])->first();

        $classe_turma=turma::where('classe_id', $classe)
        ->where('ano_lecttivo_id',$ano)->get();


      // return response()->json($tumasprofessor);
       return  view('auth.turmasceked',compact(['tumasprofessor','classe_turma','classes','id','ano']));

    }



// public function turmasprofessorGuardar(Request $request)
// {
//     $requestData = $request->dados[0];
//     $professorId = $requestData['idprofessor'];
//     $disciplinaId = $requestData['disciplina_id'];
//     $turmasSelecionadas = $requestData['turma'] ?? [];
//     $anolectivo = $requestData['anolectivo'];

//     // Validação básica
//     if (!$professorId || !$disciplinaId) {
//         return response()->json([
//             'success' => false,
//             'message' => 'Dados incompletos ou inválidos.'
//         ], 400);
//     }

//     try {
//         DB::transaction(function () use ($professorId, $disciplinaId, $turmasSelecionadas, $anolectivo) {

//             // 1. Busca todas as turmas selecionadas e suas classes
//             $turmasComClasse = turma::whereIn('id', $turmasSelecionadas)
//                 ->pluck('classe_id', 'id')
//                 ->toArray();

//             // 2. Agrupa turmas selecionadas por classe
//             $turmasPorClasse = [];
//             foreach ($turmasComClasse as $turmaId => $classeId) {
//                 $turmasPorClasse[$classeId][] = $turmaId;
//             }

//             // 3. Para cada classe, remove turmas não selecionadas
//             foreach ($turmasPorClasse as $classeId => $turmasSelecionadasNaClasse) {
//                 professor_turma::where('professor_id', $professorId)
//                     ->where('anoLectivo', $anolectivo)
//                     ->whereHas('turma', function ($query) use ($classeId) {
//                         $query->where('classe_id', $classeId);
//                     })
//                     ->whereNotIn('turma_id', $turmasSelecionadasNaClasse)
//                     ->delete();
//             }

//             // 4. Se nenhuma turma foi selecionada, remove todas as atribuições do ano letivo
//             if (empty($turmasSelecionadas)) {
//                 professor_turma::where('professor_id', $professorId)
//                     ->where('anoLectivo', $anolectivo)
//                     ->delete();
//             }

//             // 5. Adiciona novas atribuições (se houver turmas selecionadas)
//             if (!empty($turmasSelecionadas)) {
//                 if ($disciplinaId == 1000) {
//                     // Atribui TODAS as disciplinas da turma
//                     foreach ($turmasSelecionadas as $turmaId) {
//                         $turma = turma::find($turmaId);
//                         if (!$turma) continue;

//                         $disciplinas = classe_discplina::where('classe_id', $turma->classe_id)
//                             ->where('anolectivo_id', $anolectivo)
//                             ->pluck('disciplina_id')
//                             ->toArray();

//                         foreach ($disciplinas as $disciplinaRealId) {
//                             $this->atribuirTurmaprof($professorId, $turmaId, $disciplinaRealId, $anolectivo);
//                         }
//                     }
//                 } else {
//                     // Atribui apenas a disciplina específica
//                     foreach ($turmasSelecionadas as $turmaId) {
//                         $turma = turma::find($turmaId);
//                         if (!$turma) continue;

//                         $anolectivoTurma = $turma->ano_lectivo_id ?? $anolectivo;
//                         $this->atribuirTurmaprof($professorId, $turmaId, $disciplinaId, $anolectivoTurma);
//                     }
//                 }
//             }
//         });

//         return response()->json([
//             'success' => true,
//             'message' => 'Atribuições salvas com sucesso!'
//         ]);

//     } catch (\Exception $e) {
//         return response()->json([
//             'success' => false,
//             'message' => 'Ocorreu um erro ao processar as atribuições.',
//             'error' => $e->getMessage()
//         ], 500);
//     }
// }
protected function atribuirTurmaprof($professorId, $turmaId, $disciplinaId, $anolectivo)
{
    if (!$professorId || !$turmaId || !$disciplinaId) return;

    professor_turma::updateOrCreate(
        [
            'professor_id'  => $professorId,
            'turma_id'      => $turmaId,
            'disciplina_id' => $disciplinaId,
            'anoLectivo'    => $anolectivo
        ],
        [
            'professor_id'  => $professorId,
            'turma_id'      => $turmaId,
            'disciplina_id' => $disciplinaId,
            'anoLectivo'    => $anolectivo
        ]
    );
}










    function turmaclasse($id){
        $anos=DB::select("SELECT  DISTINCT(ano_lectivo_id) ,
        anolectivo FROM professor_turmaview WHERE professor_id=?  ORDER BY anolectivo desc ",[$id]);




$turmasMono = DB::table('professor_turmaview')
    ->where('professor_id', $id)
    ->where('tipo_Docencia_id', 1)
    ->get()
    ->unique("turma_id")
    ->map(function ($turma) {
        $turma->disciplinas = 'Mono Docencia';
        return $turma;
    });

$turmasMULT = DB::table('professor_turmaview')
    ->where('professor_id', $id)
    ->where('tipo_Docencia_id', '!=', 1)
    ->get();

// Une as duas coleções
$turmas = $turmasMono->merge($turmasMULT)->groupBy('ano_lectivo_id');




return response()->json([
    'anos' => $anos,
    'turmas' => $turmas
]);



}




    public function  anoclasse($id,$ano){

        $turmas= collect(DB::table('professor_turmaview')
        ->where('professor_id',$id)
        ->where('ano_lectivo_id',$ano)->get());

        $classes=DB::select("SELECT  DISTINCT(classe_id) ,classe,
        anolectivo FROM professor_turmaview WHERE professor_id=?
        and ano_lectivo_id=?  ",[$id,$ano]);

       return view('auth.professor_turmas_ano',compact('turmas','classes'));
    }



    public function criaturmapersonalisada(Request $request)
    {

// dd($request->all());
        $coll = collect();
        $quantidade = $request->quantidade;
$classedados=classe::where("id", $request->classe)->first();
    $dadosid=DB::table("formasdetrasitar")->where("id",$classedados->FormaTrasitar_id)->first();



    $alunoclasse="";

      if($request->flag==1){

       $alunoclasse= DB::table("turmasalunosview")
    ->where("ano_lectivo_id",$request->ano)
    ->where("classe_id", $request->classe)
    ->whereNull("turma_id")
    ->get();
      }
      else{

    //    $alunoclasse= DB::table("turmasalunosview")
    // ->where("ano_lectivo_id",$request->ano)
    // ->where("classe_id", $request->classe)
    // ->whereNull("jurri_id")
    // ->get();




    if($classedados->FormaTrasitar_id==1){

    $Resultado=["Reprovado","Reprovada"];
     $alunoclasse=DB::table("turmasalunosview")
     ->where("ano_lectivo_id",$request->ano)
     ->where("classe_id",$request->classe)
     ->whereNotNull("Resultado1")
     ->whereNull("jurri_id")
    ->whereNotIn(DB::raw("TRIM(Resultado1)"), $Resultado)
     ->get();


    }
    if($classedados->FormaTrasitar_id==2){


if($request->area==1):

$Resultado=["Reprovado  em Ciências","Reprovado","Reprovada","Reprovada  em Ciências"," "];
    $alunoclasse=DB::table("turmasalunosview")
     ->where("ano_lectivo_id",$request->ano)
     ->where("classe_id",$request->classe)
     ->whereNotNull("Resultado1")
     ->whereNull("jurri_id")
    ->whereNotIn(DB::raw("TRIM(Resultado1)"), $Resultado)
     ->get();

else:
$Resultado=["Reprovado  em Letras","Reprovado","Reprovada"," ","Reprovada  em Letras"];
         $alunoclasse=DB::table("turmasalunosview")
     ->where("ano_lectivo_id",$request->ano)
     ->where("classe_id",$request->classe)
     ->whereNotNull("Resultado1")
     ->whereNull("jurri_id")
    ->whereNotIn(DB::raw("TRIM(Resultado1)"), $Resultado)
     ->get();

endif;
    }
    elseif($classedados->FormaTrasitar_id==3){


    }
      }


// dd($alunoclasse);

        foreach ($alunoclasse as $item) {
            // Verifica se dataNascimento está preenchida e é uma data válida
            $dataNascimento = Carbon::parse($item->dataNascimento);
            $idade = Carbon::now()->year - $dataNascimento->year;

            $coll->push((object)[
                "sexo" => $item->sexo,
                "idade" => $idade,
                "id" => $item->aluno_classe_id,
                "nome" => $item->nome
            ]);
        }

        // Define a ordem de classificação com base nos critérios selecionados
        $criteriosOrdenacao = [];

        if ($request->has("selectIdade")) {
            $criteriosOrdenacao[] = ['idade', 'asc'];
        }
        if ($request->has("select_sexo")) {
            $criteriosOrdenacao[] = ['sexo', 'asc'];
        }
        if ($request->has("selectAlfabeto")) {
            $criteriosOrdenacao[] = ['nome', 'asc'];
        }

        // Caso nenhum critério seja selecionado, ordena por ID (padrão)
        if (empty($criteriosOrdenacao)) {
            $criteriosOrdenacao[] = ['id', 'asc'];
        }

        // Ordena a coleção dinamicamente
        $coll = $coll->sortBy($criteriosOrdenacao)->values(); // Reindexa os índices

        // Se quantidade for nula ou zero, divide em grupos de tamanho igual
        if (empty($quantidade) || $quantidade == 0) {
            $tamanhoGrupo = ceil($coll->count() / 2); // Divide em dois grupos iguais
            $subdivisoes = $coll->chunk($tamanhoGrupo);
        } else {
            // Divide normalmente conforme a quantidade informada
            $subdivisoes = $coll->chunk($quantidade);
        }

         $dadosTurmas= ($subdivisoes->values()); // Retorna as subdivisões como JSON
        // dd($dadosTurmas);

$flag=$request->flag;
        //dd($dadosTurmas);
         return view("registoAcademico.turmas-condicionadas",compact('dadosTurmas','flag'));
    }


public function guardarTodasTurmas(Request $request)
{





    DB::transaction(function () use ($request) {
        foreach ($request->turmas as $turmaData) {
            // Cria ou encontra a turma
            $turma = Turma::updateOrCreate(
                [
                    'Descricao' => $turmaData['nome'],
                    'ano_lecttivo_id' => $request->anolectivo,
                    'classe_id' => $request->classe
                ]
            );

            // Obtém IDs de alunos atuais e recebidos
            $alunosRecebidos = collect($turmaData['alunos']);
            $alunosAtuais="";
            if($request->flag==1):
            $alunosAtuais = turma_aluno::where('turma_id', $turma->id)->pluck('aluno_classe_id');
            else:

            $alunosAtuais = turma_aluno::where('jurri', $turma->id)->pluck('aluno_classe_id');
             endif;

            // Calcula diferenças
            $alunosARemover = $alunosAtuais->diff($alunosRecebidos);
            $alunosAAdicionar = $alunosRecebidos->diff($alunosAtuais);

            // Remove alunos que não estão mais na lista
            if ($alunosARemover->isNotEmpty()) {
                if($request->flag==1){
                turma_aluno::where('turma_id', $turma->id)
                    ->whereIn('aluno_classe_id', $alunosARemover)
                    ->delete();
                }
                    else{
   turma_aluno::where('jurri', $turma->id)
                    ->whereIn('aluno_classe_id', $alunosARemover)
                    ->update(["jurri" => null]);
                    }
            }

            // Adiciona novos alunos em bloco
            if ($alunosAAdicionar->isNotEmpty()) {
                $dadosParaInserir = $alunosAAdicionar->map(function ($alunoId, $i=0) use ($turma,$request) {


               if($request->flag==1){
                    return [
                        'turma_id' => $turma->id,
                        'aluno_classe_id' => $alunoId,
                        'Numero_turma' => $i+1,

                        'created_at' => now(),
                        'updated_at' => now()
                    ];
               }
                    else{
                         return [
                        'jurri' => $turma->id,
                        'aluno_classe_id' => $alunoId,
                        'Numero_turma' => $i+1,

                        'created_at' => now(),
                        'updated_at' => now()
                    ];

                    }

                $i=$i+1;  })->toArray();
if($request->flag==1):

                turma_aluno::insert($dadosParaInserir);
else:
    // dd($dadosParaInserir);
    foreach($dadosParaInserir as  $item):
     turma_aluno::where('aluno_classe_id',$item["aluno_classe_id"])->update(['jurri' => $item["jurri"],'Numero_turma' =>$item["Numero_turma"]]);
    endforeach;
endif;
            }
        }
    });

    return response()->json([
        'success' => 'success',
        'message' => 'Turmas atualizadas com sucesso.'
    ]);
}
public function criaturmapersonalisadaPORPASSADO(Request $request)
{


    // Busca os alunos não atribuídos (usando Query Builder como antes)
    $alunosNaoAtribuidos = DB::table('alunosescritos')
        ->leftJoin('turmasview', 'alunosescritos.idAlunoclasse', '=',
        'turmasview.aluno_classe_id')
        ->whereNull('turmasview.turmas')
        ->where('alunosescritos.anolectivo_id', $request->ano)
        ->where('alunosescritos.Classe_id', $request->classe)
        ->get();

    $colecaoAlunoTurma = collect();

    foreach ($alunosNaoAtribuidos as $aluno) {
        $turmaAnterior = DB::table('turmasalunosview')
            ->where('ano_lectivo_id', '<', $request->ano)
            ->where('aluno_id', $aluno->aluno_id)
            ->orderByDesc('ano_lectivo_id')
            ->first();

        $colecaoAlunoTurma->push((object)[
            "id" => $aluno->idAlunoclasse,
            "idade" => Carbon::now()->format('Y') - Carbon::parse($aluno->dataNascimento)->format('Y'),
            "nome" => $aluno->nome,
            "sexo" => $aluno->sexo,
            "turma" => $turmaAnterior->turma ?? "XZY"
        ]);
    }
 $col=$colecaoAlunoTurma
    ->sortBy('turma'); // Ordena pela turma em ordem decrescente

    // Cria a estrutura específica que você quer
    $dadosTurmas = collect();
$turmasDistintas = $colecaoAlunoTurma
    ->pluck('turma')          // Extrai apenas os valores da chave 'turma'
    ->unique()                // Remove duplicatas
    ->sort()                  // Ordena alfabeticamente
    ->values();

    // Agrupa por turma e cria as coleções aninhadas
    $col->groupBy('turma')->each(function ($alunos) use ($dadosTurmas) {
        $dadosTurmas->push($alunos->map(function ($aluno) {
            return (object)[
                'sexo' => $aluno->sexo,
                'idade' => $aluno->idade,
                'id' => $aluno->id,
                'nome' => $aluno->nome,
                "turma" => $aluno->turma
            ];
        }));
    });





    return view("registoAcademico.turmas-condicionadas", compact('dadosTurmas',"turmasDistintas"));
}




protected function atualizarOuRestaurarAtribuicao($professorId, $turmaId, $disciplinaId, $anolectivo,$classe)
{
    // Verifica se já existe (incluindo registros deletados)
    $atribuicao = professor_turma::withTrashed()
        ->where('professor_id', $professorId)
        ->where('turma_id', $turmaId)
        ->where('disciplina_id', $disciplinaId)
        ->where('classe_id', $classe)
        ->where('anoLectivo', $anolectivo)
        ->first();

    if ($atribuicao) {
        // Restaura se estiver deletada
        if ($atribuicao->trashed()) {
            $atribuicao->restore();
        }
        // Atualiza outros campos se necessário (ex: updated_at)
        $atribuicao->touch();
    } else {
        // Cria novo registro se não existir
        professor_turma::create([
            'professor_id' => $professorId,
            'turma_id' => $turmaId,
            'disciplina_id' => $disciplinaId,
            'anoLectivo' => $anolectivo,
            'classe_id' => $classe,
        ]);
    }
}






public function turmasprofessorGuardar(Request $request)
{
    $requestData = $request->dados[0];
    $professorId = $requestData['idprofessor'];
    $disciplinaId = $requestData['disciplina_id'];
    $turmasSelecionadas = $requestData['turma'] ?? [];
    $anolectivo = $requestData['anolectivo'];
    $classe = $requestData['classe'];

    // Validação básica
    if (!$professorId || !$disciplinaId) {
        return response()->json([
            'success' => false,
            'message' => 'Dados incompletos ou inválidos.'
        ], 400);
    }

    try {
        DB::transaction(function () use ($professorId, $disciplinaId, $turmasSelecionadas, $anolectivo,$classe) {


            // Remove turmas não selecionadas (soft delete)
            professor_turma::where('professor_id', $professorId)
                ->where('anoLectivo', $anolectivo)
                ->where('classe_id', $classe)
                ->whereNotIn('turma_id', $turmasSelecionadas)
                ->delete();


            // Adiciona/Restaura turmas selecionadas
            if (!empty($turmasSelecionadas)) {
                if ($disciplinaId == 1000) {
                    // Caso especial: todas as disciplinas da turma
                    foreach ($turmasSelecionadas as $turmaId) {
                        $turma = turma::find($turmaId);
                        if (!$turma) continue;

                        $disciplinas = classe_discplina::where('classe_id', $turma->classe_id)
                            ->where('anolectivo_id', $anolectivo)
                            ->pluck('disciplina_id')
                            ->toArray();

                        foreach ($disciplinas as $disciplinaRealId) {
                            $this->atualizarOuRestaurarAtribuicao($professorId, $turmaId, $disciplinaRealId, $anolectivo,$classe);
                        }
                    }
                } else {
                    // Disciplina específica
                    foreach ($turmasSelecionadas as $turmaId) {
                        $turma = turma::find($turmaId);
                        if (!$turma) continue;

                        $anolectivoTurma = $turma->ano_lectivo_id ?? $anolectivo;
                        $this->atualizarOuRestaurarAtribuicao($professorId, $turmaId, $disciplinaId, $anolectivoTurma,$classe);
                    }
                }
            }
        });

        return response()->json([
            'success' => true,
            'message' => 'Atribuições salvas com sucesso!'
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Ocorreu um erro ao processar as atribuições.',
            'error' => $e->getMessage()
        ], 500);
    }
}
}
