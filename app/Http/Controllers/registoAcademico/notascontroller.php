<?php

namespace App\Http\Controllers\registoAcademico;

use App\Exports\notasdisciplinaExport;
use App\Exports\pautaAnualExport;
use App\Exports\pautaclasseExport;
use App\Http\Controllers\Controller;
use App\Http\Controllers\NotificacaoController;
use App\Models\Admin\configuraceos;
use App\Models\Models\registoAcademico\TipoDisciplina;
use App\Models\registoAcademico\Aluno;
use App\Models\registoAcademico\alunoClasse;
use App\Models\registoAcademico\anolectivo;
use App\Models\registoAcademico\anolectivo_meta;
use App\Models\registoAcademico\classe;
use App\Models\registoAcademico\classe_direcao;
use App\Models\registoAcademico\classe_discplina;
use App\Models\registoAcademico\classes_grupo;
use App\Models\registoAcademico\disciplinas;
use App\Models\registoAcademico\disciplinas_classes;
use App\Models\registoAcademico\divisaoestado;
use App\Models\registoAcademico\formulasmedias;
use App\Models\registoAcademico\mediaanual;
use App\Models\registoAcademico\mediaanualDados;
use App\Models\registoAcademico\mediasanuaistrimestralformula;
use App\Models\registoAcademico\nota;
use App\Models\registoAcademico\nota_meta;
use App\Models\registoAcademico\professor_turma;
use App\Models\registoAcademico\turma;
use App\Models\registoAcademico\turma_aluno;
use App\Models\User;
use App\Notifications\FechamentoTurmaNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Maatwebsite\Excel\Facades\Excel;
use Ramsey\Collection\Collection;
use Symfony\Component\HttpFoundation\Response;

//use  App\Models\registoAcademico\classe;
class notascontroller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


$anolectivo = Anolectivo::orderBy('id', 'desc')->get();
$trimestres=DB::table("anolectivometadata")
->get();
$nota_meta=DB::table("nota-metas")->get();
$classes=classe::all();
$divisaoestado=divisaoestado::all();


        return view(
            'registoAcademico.notas.notas-index',
            compact("anolectivo","classes",'trimestres',"nota_meta",'divisaoestado'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $anolectivo = anolectivo::orderBy('id', 'DESC')->get();
        $classes = classe::all();
        $disciplinas = disciplinas::with('tipodisciplina')->get();

$adjuntos=User::where("cargo_id",9)->get();
$directores=User::where("cargo_id",8)->get();
$tipo=TipoDisciplina::all();

        return view(
            'registoAcademico.notas.configurar-classe',
            compact('classes', 'disciplinas', 'anolectivo','adjuntos','directores','tipo')
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
   public function store(Request $request)

{


    $disciplina = disciplinas::whereRaw("Descricao= ?", [$request->disciplina])->first();

    if (!$disciplina) {
        return back()->withErrors("Disciplina não encontrada.");

    }

    $classeDisciplina = classe_discplina::where('classe_id', $request->classe)
        ->where('disciplina_id', $disciplina->id)
        ->where('anolectivo_id', $request->anolectivo)
        ->first();


    if (!$classeDisciplina) {
        return back()->withErrors("Classe/Disciplina não encontrada.");
    }

    foreach ($request->dados as $dadosItem) {

        foreach ($request->avaliacoes as $key => $avaliacoesItem) {
            //   dd($request->dados,$request->avaliacoes, $request->divisao,$request->anolectivo);
            $posicao = $key + 3;

            nota::updateOrCreate(
                [
                    "classe_disciplina_id" => $classeDisciplina->id,
                    "aluno_classe_id"      => $dadosItem[0],
                    "divisao_id"           => $request->divisao,
                    "nota_meta_id"         => $avaliacoesItem['nota_meta_id'],
                ],
                [
                    "nota_descricao" => $dadosItem[$posicao],
                ]
            );
        }
    }

    return response()->json(["success"=> "Notas lançadas com sucesso!",
    'disciplina'=>$disciplina->id,$request->turma]);
}


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $disp = 0;
        $anolectivo = 0;
        if ($id > 0) {

            $metodo = DB::table('turmas')->where('id', $id)->first();

            $disp = classe_discplina::where('classe_id', $metodo->classe_id)
                ->where('anolectivo_id', $metodo->ano_lecttivo_id)->with('disciplina')->get();

            $anolectivo = anolectivo::where('id', $metodo->ano_lecttivo_id)->with(['anomodelo', 'modalidadeDivisao'])->first();
        }
             $divisaoestado=divisaoestado::where("classe_id",$metodo->classe_id)->get();

//  dd( $divisaoestado, $metodo , $disp,  $anolectivo );

        return view('registoAcademico.notas.notas-turma', compact('disp', 'anolectivo','divisaoestado'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

public function edit($id, Request $request)
{
    // Busca disciplina e turma
    $disciplinaItem = disciplinas::where('Descricao', $request->disciplina)->first();
    $turmaItem = turma::where('id', $request->turma)->first();

    // Busca a relação classe-disciplina
    $classe_disciplina = classe_discplina::where('disciplina_id', $disciplinaItem->id)
        ->where('classe_id', $turmaItem->classe_id)
        ->where('anolectivo_id', $turmaItem->ano_lecttivo_id)
        ->first();

    // Nota antiga
    $notanomeold = nota_meta::where('id', $id)->first();

    // Cria nova nota_meta se não existir
    $notanomenew = nota_meta::firstOrCreate(
        ['Decricao' => $request->novonome]
    );

    try {
        DB::transaction(function () use ($classe_disciplina, $request, $notanomeold, $notanomenew, $turmaItem,$id) {

            // Atualiza fórmulas das médias, se existir
            $medias = DB::table('formulasdemediastrimestrais')
                ->where('turma_id', $request->turma)
                ->where('anolectivo_id', $turmaItem->ano_lecttivo_id)
                ->where('divisao_id', $request->trimestre)
                ->where('disciplina_classe_id', $classe_disciplina->id)
                ->first();

            if (!empty($medias)) {
                $novaFormula = str_replace($notanomeold->Decricao, $request->novonome, $medias->formula);


                DB::table('formulasdemediastrimestrais')
                    ->where('turma_id', $request->turma)
                    ->where('anolectivo_id', $turmaItem->ano_lecttivo_id)
                    ->where('divisao_id', $request->trimestre)
                    ->where('disciplina_classe_id', $classe_disciplina->id)
                    ->update(["formula" => $novaFormula]);
            }

            // Atualiza todas as notas ligadas à nota_meta antiga
            nota::where('classe_disciplina_id', $classe_disciplina->id)
                ->where('divisao_id', $request->trimestre)
                ->where('nota_meta_id', $id)
                ->update(['nota_meta_id' => $notanomenew->id]);
        });

        // Retorna sucesso e novo nome para atualizar front-end
        return response()->json([
            'mensagem' => 'success',
            'novonome' => $notanomenew->Decricao
        ]);

    } catch (\Exception $e) {
        // Em caso de erro, retorna mensagem de erro
        return response()->json([
            'mensagem' => 'error',
            'erro' => $e->getMessage()
        ], 500);
    }
}


    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
    public function dadosTablepauta(Request $request)
{

     //dd($request->all());
    $request->validate([
        'file' => 'required|file|mimes:xlsx,xls',
    ]);

    $file = $request->file('file');

    // DataTable vindo via request (já como array)
   // $DADOSTABELA = $request->input('tableData');
$DADOSTABELA = json_decode($request->input('tableData'), true);
$inicio=(int)$request->input('Inicio');

    // dd($DADOSTABELA,$inicio);
    $dadosImport = collect();

    // Pega o array completo do Excel
  $arrayExcel = Excel::toArray([], $file);

$aba = $arrayExcel[0] ?? [];
$dadosInser = collect();

$size=(count($aba));
// dd($size,$aba);
for ($x =9; $x < $size; $x++) {
    $linha = $aba[$x];
    // remove a primeira coluna (índice 0)
    $linhaSemPrimeiraColuna = array_slice($linha, 1);
    $dadosInser->push($linhaSemPrimeiraColuna);


}


//   DD($dadosInser);
    return response()->json([
        'message' => 'Arquivo recebido e processado com sucesso!',
        'dados'   => $dadosInser
    ]);
}
    public function dadosTable(Request $request)
{

    //  dd($request->all());
    $request->validate([
        'file' => 'required|file|mimes:xlsx,xls',
    ]);

    $file = $request->file('file');

    // DataTable vindo via request (já como array)
   // $DADOSTABELA = $request->input('tableData');
$DADOSTABELA = json_decode($request->input('tableData'), true);
$inicio=(int)$request->input('Inicio');

    // dd($DADOSTABELA,$inicio);
    $dadosImport = collect();

    // Pega o array completo do Excel
  $arrayExcel = Excel::toArray([], $file);

$aba = $arrayExcel[0] ?? [];
$dadosInser = collect();
$size=(count($aba));
// dd($size,$aba);
for ($x =11; $x < $size; $x++) {
    $linha = $aba[$x];
    // remove a primeira coluna (índice 0)
    $linhaSemPrimeiraColuna = array_slice($linha, 1);
    $dadosInser->push($linhaSemPrimeiraColuna);
}


//   DD($dadosInser);
    return response()->json([
        'message' => 'Arquivo recebido e processado com sucesso!',
        'dados'   => $dadosInser ,
    ]);
}


    public function turmas($ano, $classe)
    {

        $turmas = turma::where('classe_id', $classe)
            ->where('ano_lecttivo_id', $ano)
            ->get();

        $autor = auth()->user()->id;

        $turmasAtribuidas = DB::select(
            'SELECT DISTINCT(turma_id),turma_id,turma FROM  professor_turmaview
        where classe_id=? and ano_lectivo_id=?',
            [ $classe, $ano]
        );

        return view('registoAcademico.notas.notas-nomes-turmas', compact('turmas', 'turmasAtribuidas'));
    }

    public function turmasTrimestre($ano, $classe,$flag=null)
    {

        $turmas = DB::table("turmasalunosview")->where('classe_id', $classe)
            ->where('ano_lectivo_id', $ano)
            ->get();

         $turmasclasse = $turmas
    ->unique('turma_id')
    ->map(function ($item) {
        return (object)[
            'id' => $item->turma_id,
            'Descricao' => $item->turma,
            'classe_id' => $item->classe_id,
        ];
    })
    ->values();

    if($flag==1):
 $turmasclasse  = $turmas
    ->unique('jurri_id')
    ->map(function ($item) {
        return (object)[
            'id' => $item->jurri_id,
            'Descricao' => $item->jurri,
            'classe_id' => $item->classe_id,
            'ano_lectivo_id' => $item->ano_lectivo_id,
        ];
    })
    ->values();
    endif;




        $autor = auth()->user()->id;

        $turmasAtribuidas = DB::select(
            'SELECT DISTINCT(turma_id),turma_id,turma FROM  professor_turmaview
        where  classe_id=? and ano_lectivo_id=?',
            [$classe, $ano]
        );

        return view('registoAcademico.notas.notas-nomes-turmas-trimestre', compact('turmasclasse', 'turmasAtribuidas',"flag"));
    }

    public function turmasAlunos($turmaid, $trimestre)
    {
        $turma = 0;
        $disp = 0;
        $alunoscolecao = 0;
        $disciplinaavalaicaotipo = 0;

        $divisao = 0;
        if ($turmaid > 0) {
            $divisao = $trimestre;
            $alunoscolecao = collect();
            $disciplinaavalaicaotipo = collect();

            $turmas = turma::where('id', $turmaid)->first();
            $disciplinas = classe_discplina::where('classe_id', $turmas->classe_id)
                ->where('anolectivo_id', $turmas->ano_lecttivo_id)
                ->with('disciplina')->get();
            $disp = $disciplinas;

            $alunos = turma_aluno::where('turma_id', $turmaid)->with(['alunoclass', 'notasdefrequencia'])->get();
            foreach ($alunos as $alunosItem) {
                //echo $alunosItem->alunoclass->aluno;
                $notas = collect();
                $disciplinasArrei = collect();
                foreach ($disciplinas as $disciplinasItem) {

                    $dadosTiponotas = DB::select('SELECT distinct(nota_meta_id), visaonotas.nota_descricao FROM  visaonotas
WHERE  visaonotas.turma_id=? AND visaonotas.divisao_id=? AND visaonotas.disciplina_id=?', [$turmaid, $trimestre, $disciplinasItem->disciplina->id]);
                    $disciplinaavalaicaotipo[$disciplinasItem->disciplina->Descricao] = $dadosTiponotas;
                    foreach ($dadosTiponotas as $Itemdado) {

                        $notas[$Itemdado->nota_meta_id] = '';
                        $dadonota = DB::table('visaonotas')
                            ->where('id', $alunosItem->aluno_classe_id)
                            ->where('divisao_id', $trimestre)
                            ->where('turma_id', $turmaid)
                            ->where('disciplina_id', $disciplinasItem->disciplina->id)
                            ->where('nota_meta_id', $Itemdado->nota_meta_id)
                            ->first();
                        if (! empty($dadonota)) {
                            $notas[$Itemdado->nota_meta_id] = $dadonota->notas;
                        }
                    }
                    $disciplinasArrei[''.$disciplinasItem->disciplina->Descricao.''] = $notas;
                }
                // dd($alunosItem->alunoclass);
                if (! empty($alunosItem->alunoclass)) {

                    //   dd($alunosItem->alunoclass->aluno_id);

                    $aluno = Aluno::where('id', $alunosItem->alunoclass->aluno_id)->first();

                    $alunoscolecao->push(['nome' => $alunosItem->alunoclass->aluno->nome, 'disciplinas' => $disciplinasArrei]);
                }
            }

            $turma = $alunoscolecao;
        }

        $autor = auth()->user()->id;
        /**
         * $turmasAtribuidasDisp=DB::table('professor_turmaview')->where('professor_id',$autor)
        ->where('classe_id', $turmas->classe_id)
        ->where('ano_lectivo_id',$turmas->ano_lecttivo_id)
        ->distinct('disciplina_id')
        ->get();
         */
        $turmasAtribuidasDisp = DB::select(
            'SELECT DISTINCT(disciplina_id) FROM  professor_turmaview
        where professor_id=? and classe_id=? and ano_lectivo_id=? and turma_id=?',

            [$autor, $turmas->classe_id, $turmas->ano_lecttivo_id, $turmaid]
        );

        return view(
            'registoAcademico.notas.tabela-notas',
            compact('turma', 'disp', 'alunoscolecao', 'disciplinaavalaicaotipo', 'turmaid', 'divisao', 'turmasAtribuidasDisp')
        );
    }

    public function elementoAddavaliacao(Request $request, $iddisciplia, $turmaid, $trimestre)
    {



        $guadar = nota_meta::firstOrCreate(
            ['Decricao' => $request->label],
            ['Decricao' => $request->label]
        );

        $alunos = turma_aluno::where('turma_id', $turmaid)->with('alunoclass')->get();

        $turmas = turma::where('id', $turmaid)->first();


        $idclassdiscipli = classe_discplina::where('classe_id', $turmas->classe_id)
            ->where('anolectivo_id', $turmas->ano_lecttivo_id)
            ->where('disciplina_id', $iddisciplia)
            ->with('disciplina')
            ->first();

        foreach ($alunos as $alunosItem) {
            nota::firstOrCreate(
                [
                    'classe_disciplina_id' => $idclassdiscipli->id,
                    'aluno_classe_id' => $alunosItem->aluno_classe_id,
                    'divisao_id' => $trimestre,

                    'nota_meta_id' => $guadar->id,
                ],
                [
                    'classe_disciplina_id' => $idclassdiscipli->id,
                    'aluno_classe_id' => $alunosItem->aluno_classe_id,
                    'divisao_id' => $trimestre,

                    'nota_meta_id' => $guadar->id,
                ]
            );
        }

        $disciplina = disciplinas::where('id', $iddisciplia)->first();

        return response()->json([
            'alert' => 'success', 'turma' => $turmaid,
            'disciplina' => $disciplina->Descricao,
            'trimestre' => $trimestre,
        ]);
    }







    public function elemento($iddisciplia, $turmaid, $trimestre)
    {
        //  dd($iddisciplia, $turmaid, $trimestre);
        $alunoscolecao = collect();
        $disciplinaavalaicaotipo = collect();
        $disciplinaclasses = '';

        $turmas = turma::where('id', $turmaid)->first();

        $alunos = turma_aluno::where('turma_id', $turmaid)->with(['alunoclass', 'notasdefrequencia'])->get();

        $turmas = turma::where('id', $turmaid)->first();
        $disciplinas = disciplinas::where('id', $iddisciplia)->first();
        $iddisciplia= $disciplinas->Descricao;
        $disp = $disciplinas;
        $disp = $disciplinas;



        $disciplinaclasse = DB::table('classe_disciplinas')
            ->where('classe_id', $turmas->classe_id)
            ->where('disciplina_id', $disciplinas->id)
            ->where('anolectivo_id', $turmas->ano_lecttivo_id)
            ->first();
        $formunlamendia = formulasmedias::where('disciplina_classe_id', $disciplinaclasse->id)
            ->where('anolectivo_id', $disciplinaclasse->anolectivo_id)
            ->where('divisao_id', $trimestre)
            ->where('turma_id', $turmaid)
            ->first();


        foreach ($alunos as $alunosItem) {
            //echo $alunosItem->alunoclass->aluno;

            $formula = '';
            if (! empty($formunlamendia)) {
                $formula = $formunlamendia->formula;
            }
            $notas = collect();
            $disciplinasArrei = collect();
            $iddisciplinanota = collect();

                $dadosTiponotas = DB::select(
                    'SELECT distinct(nota_meta_id), visaonotas.nota_descricao FROM  visaonotas
    WHERE  visaonotas.turma_id=? AND visaonotas.divisao_id=? AND visaonotas.disciplina_id=? and nota_meta_id !=0 ORDER BY (nota_meta_id) ',
                    [$turmaid, $trimestre, $disciplinas->id]
                );


                $dadosTiponotasmedia = DB::select(
                    'SELECT distinct(nota_meta_id), visaonotas.nota_descricao FROM  visaonotas
    WHERE  visaonotas.turma_id=? AND visaonotas.divisao_id=? AND visaonotas.disciplina_id=? and nota_meta_id=0 ORDER BY (nota_meta_id) ',
                    [$turmaid, $trimestre, $disciplinas->id]
                );


                if (! empty($dadosTiponotasmedia)) {
                    array_push($dadosTiponotas, (object) ['nota_meta_id' => 0, 'nota_descricao' => '@Media']);
                }
                $disciplinaavalaicaotipo[$disciplinas->Descricao] = $dadosTiponotas;


                //   dd( $dadosTiponotas, $dadosTiponotasmedia, $disciplinaavalaicaotipo);
                //adicionar media caso tenha formula

                foreach ($dadosTiponotas as $key => $Itemdado) {

                    $notas[$Itemdado->nota_meta_id] = '';
                    $iddisciplinanota[$Itemdado->nota_meta_id] = '';

                    $dadonota = DB::table('visaonotas')
                        ->where('id', $alunosItem->aluno_classe_id)
                        ->where('divisao_id', $trimestre)
                        ->where('turma_id', $turmaid)
                        ->where('disciplina_id', $disciplinas->id)
                        ->where('nota_meta_id', $Itemdado->nota_meta_id)
                        ->first();
                        //  dd($dadonota);

                    if (! empty($dadonota)) {

                        //$for = str_replace($Itemdado->nota_descricao, $dadonota->notas, $formula);
                        //$formula = $for;
                        if (($key + 2) > count($dadosTiponotas)) {

                            // $notas['0'] = ($formula);




                            $iddisciplinanota[$Itemdado->nota_meta_id] = $dadonota->iddanota;
                            $iddisciplinanota[0] = $dadonota->iddanota;
                        }
                        $notas[$Itemdado->nota_meta_id] = $dadonota->notas;
                        $iddisciplinanota[$Itemdado->nota_meta_id] = $dadonota->iddanota;
                        $iddisciplinanota["chave1"] = $dadonota->chave1;
                        $iddisciplinanota["chave2"] = $dadonota->chave2;
                    }
                }
                // if (! empty($formunlamendia)) {
                //     array_push($dadosTiponotas, (object) ['nota_meta_id' => 0, 'nota_descricao' => '@media']);
                //     $disciplinaavalaicaotipo[$disciplinas->Descricao] = $dadosTiponotas;

                // }

                $disciplinasArrei[''.$disciplinas->Descricao.''] = $notas;
                $disciplinasArrei['idnotas'] = $iddisciplinanota;


            $alunoscolecao->push(['id' => $alunosItem->alunoclass->id,
            'nome' => $alunosItem->alunoclass->aluno->nome,
            'sexo' => $alunosItem->alunoclass->aluno->sexo,
            'disciplinas' => $disciplinasArrei]);
		}

        $turma = $alunoscolecao;



        $dadosenvio=[];
       $turmaArray = [];

foreach ($turma as $key => $turmaItem) {
    $linha = [];

    // Colunas iniciais: número, nome, sexo
    $linha['1'] = $key + 1;
    $linha['2'] = $turmaItem['nome'];
    $linha['3'] = $turmaItem['sexo'];

    $colIndex = 4; // começar das notas a partir da coluna 4

    // dd($disciplinaavalaicaotipo );
    foreach ($disciplinaavalaicaotipo[$iddisciplia] as $dispv) {
        $notaMetaId = $dispv->nota_meta_id;

        if ($notaMetaId != 0) {
            // valor da nota
            $linha[$colIndex++] = $turmaItem['disciplinas'][$iddisciplia][$notaMetaId] ?? '';
            // id da nota
          //  $linha[$colIndex++] = $turmaItem['disciplinas']['idnotas'][$notaMetaId] ?? '';
        } else {
            // média ou nota sem avaliação
            $linha[$colIndex++] = $turmaItem['disciplinas'][$iddisciplia][$notaMetaId] ?? '';
        }
    }

    $turmaArray[] = $linha;
}



$dadosbloqueio=divisaoestado::where("classe_id",$turmas->classe_id)->where("id",$trimestre)->first();





    $direcao=false;
    if(DB::table("classe_direcao")
    ->where("anolectivo_id",$turmas->ano_lecttivo_id)
    ->where("classe_id",$turmas->classe_id)
    ->where("pedagogico_id",auth()->user()->id)
    ->orWhere("director_id",auth()->user()->id)
    ->first()): $direcao=true; endif;
    //  dd($turmas,$dadosbloqueio,  $direcao);

  return view(
            'registoAcademico.notas.notas-tabela-dados',
            compact(
                'direcao',
                'turma',
                'disp',
                'alunoscolecao',
                'disciplinaavalaicaotipo',
                'turmaid',
                'iddisciplia',
                'formunlamendia',
                'trimestre','turmaArray',
                'dadosbloqueio'
            )
        );
    }






    public function disciplinasclassesanolectivo($classes, $anolectivo)
    {
        $colecaodisciplinas = collect();

        // $disciplinaclasses = DB::table('classes_disciplinasview')
        // ->where('classe_id', $classes)->where('anolectivo_id', $anolectivo)->get();


$disciplinaclasses = DB::table('classes_disciplinasview')
    ->where('classe_id', $classes)
    ->where('anolectivo_id', function ($query) use ($classes) {
        $query->from('classes_disciplinasview')
              ->where('classe_id', $classes)
              ->selectRaw('MAX(anolectivo_id)');
    })
    ->get();
    $id =$disciplinaclasses->pluck("disciplina_id")->toArray();


        $colecaodisciplinas = disciplinas::whereNotIn("id",$id)->with("tipodisciplina")->get();



        return response()->json(['lecionadas' => $disciplinaclasses, 'naolecionadas' => $colecaodisciplinas]);
    }

public function nodadisciplina(Request $request)
{
    // dd($request->all());
    $request->validate([
        'novadisp' => 'required|string|max:255',
        'sigla' => 'required|string|max:50',
        'id' => 'nullable|integer'
    ]);

    $disciplina = disciplinas::updateOrCreate(

        [
            'id' => $request->id // se existir atualiza, se não cria
        ],

        [
            'Descricao' => $request->novadisp,
            'Sigla' => $request->sigla
        ]

    );

    return response()->json([
        'alert' => 'success',
        'data' => $disciplina
    ]);
}
    public function editdisciplina(Request $nodadisciplina, $classe, $anolectivo)
    {
        //dd($nodadisciplina);

        if($nodadisciplina->id!=null){
disciplinas::updateOrCreate(
            [
                'Descricao' => $nodadisciplina->nome,
                'id'=>$nodadisciplina->id
            ],
            [
                'Descricao' => $nodadisciplina->nome,
                'Sigla' => $nodadisciplina->sigla,

            ]
        );
        }
        else{
            disciplinas::updateOrCreate(
            [
                'Descricao' => $nodadisciplina->nome,

            ],
            [
                'Descricao' => $nodadisciplina->nome,
                'Sigla' => $nodadisciplina->sigla,

            ]
        );

        }


        return response()->json(['alert' => 'success']);
    }

    public function deleteDisp($id)
    {

        $disciplinaclasses = DB::table('classes_disciplinasview')->where('disciplina_id', $id)->first();

        if (empty($disciplinaclasses)) {
            $disciplinaclasses = DB::table('disciplinas')->where('id', $id)->delete();

            return response()->json(['alert' => 'success']);
        } else {
            return response()->json(['alert' => 'arror']);
        }
    }






  public function atualizardisplinas(Request $request, $classe, $anolectivo)
{
    $colletdisciplina = collect();
    $novasDisciplinas = collect($request->disciplinas)->filter(); // remove valores nulos/vazios


    // Se não houver novas disciplinas, apenas verifica se pode remover as antigas
    if ($novasDisciplinas->isEmpty()) {
        $disciplinasExistentes = disciplinas_classes::where('classe_id', $classe)
            ->where('anolectivo_id', $anolectivo)
            ->get();

        foreach ($disciplinasExistentes as $disciplina) {
            $notaExistente = DB::table('visaonotas')
                ->where('clase_id', $classe)
                ->where('anolectivo_id', $anolectivo)
                ->where('disciplina_id', $disciplina->disciplina_id)
                ->first();

            if (empty($notaExistente)) {
                disciplinas_classes::where('classe_id', $classe)
                    ->where('anolectivo_id', $anolectivo)
                    ->where('disciplina_id', $disciplina->disciplina_id)
                    ->delete();
            } else {
                $colletdisciplina->push($disciplina->disciplina);
            }
        }

        return response()->json([
            'alert' => $colletdisciplina,
            'message' => 'Nenhuma nova disciplina foi adicionada. Disciplinas sem notas foram removidas.'
        ]);
    }

    // Remover disciplinas que não estão na nova lista, se não houver notas
    $disciplinasParaRemover = disciplinas_classes::where('classe_id', $classe)
        ->where('anolectivo_id', $anolectivo)
        ->whereNotIn('disciplina_id', $novasDisciplinas)
        ->get();

    foreach ($disciplinasParaRemover as $disciplina) {
        $notaExistente = DB::table('visaonotas')
            ->where('clase_id', $classe)
            ->where('anolectivo_id', $anolectivo)
            ->where('disciplina_id', $disciplina->disciplina_id)
            ->first();

        if (empty($notaExistente)) {
            disciplinas_classes::where('classe_id', $classe)
                ->where('anolectivo_id', $anolectivo)
                ->where('disciplina_id', $disciplina->disciplina_id)
                ->delete();
        } else {
            $colletdisciplina->push($disciplina->disciplina);
        }
    }

    // Adicionar novas disciplinas
    foreach ($novasDisciplinas as $disciplinaId) {
        classe_discplina::firstOrCreate(
            [
                'disciplina_id' => $disciplinaId,
                'classe_id' => $classe,
                'anolectivo_id' => $anolectivo,
            ],
            [
                'disciplina_id' => $disciplinaId,
                'classe_id' => $classe,
                'anolectivo_id' => $anolectivo,
            ]
        );
    }

    return response()->json([
        'alert' => $colletdisciplina,
        'message' => 'Disciplinas atualizadas com sucesso.'
    ]);
}

    public function guadardadosprova(Request $request, $turma, $trimestre, $anolectivo, $classe, $disciplina)
    {

        $turmaItem = turma::where('id', $turma)->first();

        $classe_disciplina = classe_discplina::where('disciplina_id', $disciplina)
            ->where('classe_id', $turmaItem->classe_id)
            ->where('anolectivo_id', $turmaItem->ano_lecttivo_id)
            ->first();

        $descricoesnotas = DB::select(
            'SELECT
       DISTINCT(nota_meta_id)
       FROM
         notas_frequencias
         WHERE classe_disciplina_id=? AND divisao_id=?  AND
         aluno_classe_id in (SELECT turma_alunos.aluno_classe_id FROM turma_alunos WHERE turma_alunos.turma_id=?)',
            [$classe_disciplina->id, $trimestre, $turma]
        );

        foreach ($request->dados as $requestItem) {

            foreach ($requestItem['prova'] as $key => $provaItem) {

                for ($x = 0; $x < count($descricoesnotas); $x++) {

                    if (isset($provaItem[$descricoesnotas[$x]->nota_meta_id])) {

                        nota::updateOrCreate(
                            [
                                'classe_disciplina_id' => $classe_disciplina->id,
                                'aluno_classe_id' => $requestItem['ID'],
                                'divisao_id' => $trimestre,
                                'nota_meta_id' => $descricoesnotas[$x]->nota_meta_id,
                            ],
                            [
                                'nota_descricao' => $provaItem[$descricoesnotas[$x]->nota_meta_id],
                            ]
                        );
                    }
                }
            }

        }

        return response()->json(['Msg' => 'atualizado com sucesso', 'alert' => 'success']);
    }

    // apagar avaliacao
    public function apagarnota($turma, $trimestre, $prova, $disciplina)
    {
        $disciplinaItem = disciplinas::where('Descricao', $disciplina)->first();
        $turmaItem = turma::where('id', $turma)->first();
        $classe_disciplina = classe_discplina::where('disciplina_id', $disciplinaItem->id)
            ->where('classe_id', $turmaItem->classe_id)
            ->where('anolectivo_id', $turmaItem->ano_lecttivo_id)
            ->first();

        $medias = DB::table('formulasdemediastrimestrais')
            ->where('turma_id', $turma)
            ->where('anolectivo_id', $turmaItem->ano_lecttivo_id)
            ->where('divisao_id', $trimestre)
            ->where('disciplina_classe_id', $classe_disciplina->id)
            ->delete();

        $nota = nota::where('classe_disciplina_id', $classe_disciplina->id)
            ->where('divisao_id', $trimestre)
            ->where('nota_meta_id', $prova)
            ->delete();

            $nota = nota::where('classe_disciplina_id', $classe_disciplina->id)
            ->where('divisao_id', $trimestre)
            ->where('nota_meta_id',0)
            ->delete();
        if ($nota) {
            return response()->json(['mensagem' => 'success']);
        } else {
            return response()->json(['mensagem' => 'error']);
        }
    }

    // atualizarnome avaliacao
    public function atualizarNome($turma, $trimestre, $prova, $disciplina ,$dado)
    {




        $disciplinaItem = disciplinas::where('Descricao', $disciplina)->first();
        $turmaItem = turma::where('id', $turma)->first();
        $classe_disciplina = classe_discplina::where('disciplina_id', $disciplinaItem->id)
            ->where('classe_id', $turmaItem->classe_id)
            ->where('anolectivo_id', $turmaItem->ano_lecttivo_id)
            ->first();

        $medias = DB::table('formulasdemediastrimestrais')
            ->where('turma_id', $turma)
            ->where('anolectivo_id', $turmaItem->ano_lecttivo_id)
            ->where('divisao_id', $trimestre)
            ->where('disciplina_classe_id', $classe_disciplina->id)
            ->delete();

        $nota = nota::where('classe_disciplina_id', $classe_disciplina->id)
            ->where('divisao_id', $trimestre)
            ->where('nota_meta_id', $prova)
            ->delete();

            $nota = nota::where('classe_disciplina_id', $classe_disciplina->id)
            ->where('divisao_id', $trimestre)
            ->where('nota_meta_id',0)
            ->delete();
        if ($nota) {
            return response()->json(['mensagem' => 'success']);
        } else {
            return response()->json(['mensagem' => 'error']);
        }
    }
public function guadarformulamedias(Request $request, $turma, $trimestre, $anolectivo, $classe, $disciplina)
{



// dd( $request->all(), $turma, $trimestre, $anolectivo, $classe, $disciplina);
//  dd($request->all());// Validação mínima do request
    $request->validate([
        'formmulacriada' => 'required|string|max:255',
    ]);

   try {
        // Recupera os alunos da turma
        $turmaaluno = DB::table('turma_alunos')
            ->where('turma_id', $turma)
            ->get();





        // Recupera a disciplina da classe
        $disciplinaclasse = DB::table('classe_disciplinas')
            ->where([
                ['classe_id', $classe],
                ['disciplina_id', $disciplina],
                ['anolectivo_id', $anolectivo]
            ])
            ->first();


        if (!$disciplinaclasse) {
            return response()->json(['error' => 'Disciplina não encontrada para a classe'], 404);
        }

        // Recupera notas distintas para o cálculo da média
        $descricoesnotas = DB::table('notas_frequencias')
            ->distinct('nota_meta_id')
            ->where('classe_disciplina_id', $disciplinaclasse->id)
            ->where('divisao_id', $trimestre)
            ->whereIn('aluno_classe_id', function($query) use ($turma) {
                $query->select('aluno_classe_id')
                      ->from('turma_alunos')
                      ->where('turma_id', $turma);
            })
            ->pluck('nota_meta_id');

        // Atualiza ou cria a fórmula de médias
        $formula = formulasmedias::updateOrCreate(
            [
                'anolectivo_id' => $anolectivo,
                'divisao_id' => $trimestre,
                'turma_id' => $turma,
                'disciplina_classe_id' => $disciplinaclasse->id,
            ],
            ['formula' => $request->formmulacriada]
        );



        // Retorna os elementos calculados para a interface
      $this->retornarelementosmedia(
            $request->formmulacriada,
            $trimestre,
            $turma,
            $disciplinaclasse->id
        );
            $disciplinaItem = disciplinas::where('id', $disciplina)->first();

return $this->elemento($disciplinaItem->id,$turma,$trimestre);

    } catch (\Exception $e) {
        // Log do erro para debug
        Log::error('Erro ao guardar fórmula de médias: ' . $e->getMessage());

        return response()->json([
            'error' => 'Ocorreu um erro ao salvar a fórmula. Tente novamente.'
        ], 500);
    }
}


// Cálculo das médias com base na fórmula
public function retornarelementosmedia($formulaCriada, $trimestre, $turma, $disciplinaClasseId)
{

 $notasAluno="";
    // dd($formulaCriada, $trimestre, $turma, $disciplinaClasseId);
    // Buscar todos os alunos dessa turma com notas na disciplina e trimestre
    $dadosAlunos = DB::select(
        'SELECT DISTINCT aluno_classe_id, divisao_id, classe_disciplina_id
         FROM notas_frequencias
         WHERE divisao_id = ?
           AND classe_disciplina_id = ?
           AND aluno_classe_id IN (
               SELECT turma_alunos.aluno_classe_id
               FROM turma_alunos
               WHERE turma_alunos.turma_id = ?
           )',
        [$trimestre, $disciplinaClasseId, $turma]
    );

    $medias = collect();

    foreach ($dadosAlunos as $aluno) {
        $formulaCalculada = $formulaCriada;

        // Buscar notas reais do aluno
        $notasAluno = DB::table('visaonotas')
            ->where('divisao_id', $trimestre)
            ->where('turma_id', $turma)
            ->where('id', $aluno->aluno_classe_id)
            ->where('classe_disciplina_id', $disciplinaClasseId)
            ->get();

        foreach ($notasAluno as $notaItem) {
            $valorNota = $notaItem->notas ?: 0; // substitui vazio por 0
            // Substitui o nome da variável da fórmula pelo valor real
            $formulaCalculada = str_replace($notaItem->nota_descricao, $valorNota, $formulaCalculada);
        }

        // Avaliar a expressão matemática
        try {
            // Segurança: apenas números e operadores permitidos
            if (preg_match('/^[0-9\+\-\*\/\(\)\s\.]+$/', $formulaCalculada)) {
                // Usa eval para calcular
                $resultado = 0;
                eval("\$resultado = $formulaCalculada;");
            } else {
                $resultado = null; // fórmula inválida
            }
        } catch (\Throwable $e) {
            $resultado = null; // erro ao calcular
        }




$parteInteira = floor($resultado);
$decimal = $resultado - $parteInteira;

if ($decimal > 0.5) {
    $resultadoArredondado = ceil($resultado); // arredonda para cima
} else {
    $resultadoArredondado = floor($resultado); // arredonda para baixo
}

//echo $resultadoArredondado; // 7

        // Adiciona ao resultado
        $medias->push([
            'aluno' => $aluno->aluno_classe_id,
            'classe_disciplina_id' => $aluno->classe_disciplina_id,
            'trimestre' => $aluno->divisao_id,
            'media' => $resultado,
            'disciplina' => $notasAluno->first()->disciplina

        ]);


 nota::updateOrCreate(
                [
                    'classe_disciplina_id' =>  $aluno->classe_disciplina_id,
                    'aluno_classe_id' =>$aluno->aluno_classe_id,
                    'divisao_id' =>  $aluno->divisao_id,
                    'nota_meta_id' => 0,
                ],
                ['nota_descricao' => $resultadoArredondado]
            );

    }

    return ($medias);
}


    public function guadarMedia(Request $request)
    {

        //dd($request->all());
        foreach ($request->dados as $Item) {

            nota::updateOrCreate(
                [
                    'classe_disciplina_id' => $Item['classe_disciplina_id'],
                    'aluno_classe_id' => $Item['aluno'],
                    'divisao_id' => $Item['trimestre'],
                    'nota_meta_id' => 0,
                ],
                ['nota_descricao' => $Item['media']]
            );
        }

        $turma = turma_aluno::where('aluno_classe_id', $request->dados[0]['aluno'])->first();
        $classe = classe_discplina::where('id', $request->dados[0]['classe_disciplina_id'])->first();
        $disciplina_lecioada = disciplinas::where('id', $classe->disciplina_id)->first();

        return response()->json([
            'alert' => 'success', 'turma' => $turma->turma_id,
            'disciplina' => $disciplina_lecioada->Descricao,
            'trimestre' => $request->dados[0]['trimestre'],
        ]);
    }

    public function exportnotas($iddisciplia, $turmaid, $trimestre)
    {

        $alunoscolecao = collect();
        $disciplinaavalaicaotipo = collect();
        $disciplinaclasses = '';

        $turmas = turma::where('id', $turmaid)->first();

        $alunos = turma_aluno::where('turma_id', $turmaid)->with(['alunoclass', 'notasdefrequencia'])->get();

        $turmas = turma::where('id', $turmaid)->first();
        $disciplinas = disciplinas::where('Descricao', $iddisciplia)->get();
        $disp = $disciplinas;
        $disp = $disciplinas;

        $disciplinaclasse = DB::table('classe_disciplinas')
            ->where('classe_id', $turmas->classe_id)
            ->where('disciplina_id', $disciplinas[0]->id)
            ->where('anolectivo_id', $turmas->ano_lecttivo_id)
            ->first();
        $formunlamendia = formulasmedias::where('disciplina_classe_id', $disciplinaclasse->id)
            ->where('anolectivo_id', $disciplinaclasse->anolectivo_id)
            ->where('divisao_id', $trimestre)
            ->where('turma_id', $turmaid)
            ->first();

        foreach ($alunos as $alunosItem) {
            //echo $alunosItem->alunoclass->aluno;

            $formula = '';
            if (! empty($formunlamendia)) {
                $formula = $formunlamendia->formula;
            }
            $notas = collect();
            $disciplinasArrei = collect();
            $iddisciplinanota = collect();
            foreach ($disciplinas as $key => $disciplinasItem) {

                $dadosTiponotas = DB::select(
                    'SELECT distinct(nota_meta_id), visaonotas.nota_descricao FROM  visaonotas
WHERE  visaonotas.turma_id=? AND visaonotas.divisao_id=? AND visaonotas.disciplina_id=? and nota_meta_id !=0 ORDER BY (nota_meta_id) ',
                    [$turmaid, $trimestre, $disciplinasItem->id]
                );

                $dadosTiponotasmedia = DB::select(
                    'SELECT distinct(nota_meta_id), visaonotas.nota_descricao FROM  visaonotas
WHERE  visaonotas.turma_id=? AND visaonotas.divisao_id=? AND visaonotas.disciplina_id=? and nota_meta_id=0 ORDER BY (nota_meta_id) ',
                    [$turmaid, $trimestre, $disciplinasItem->id]
                );
                if (! empty($dadosTiponotasmedia)) {
                    array_push($dadosTiponotas, (object) ['nota_meta_id' => 0, 'nota_descricao' => '@Media']);
                }
                $disciplinaavalaicaotipo[$disciplinasItem->Descricao] = $dadosTiponotas;

                //adicionar media caso tenha formula

                foreach ($dadosTiponotas as $key => $Itemdado) {

                    $notas[$Itemdado->nota_meta_id] = '';
                    $iddisciplinanota[$Itemdado->nota_meta_id] = '';

                    $dadonota = DB::table('visaonotas')
                        ->where('id', $alunosItem->aluno_classe_id)
                        ->where('divisao_id', $trimestre)
                        ->where('turma_id', $turmaid)
                        ->where('disciplina_id', $disciplinasItem->id)
                        ->where('nota_meta_id', $Itemdado->nota_meta_id)
                        ->first();
                    if (! empty($dadonota)) {

                        //$for = str_replace($Itemdado->nota_descricao, $dadonota->notas, $formula);
                        //$formula = $for;
                        if (($key + 2) > count($dadosTiponotas)) {

                            // $notas['0'] = ($formula);
                            $iddisciplinanota[$Itemdado->nota_meta_id] = $dadonota->iddanota;
                            $iddisciplinanota[0] = $dadonota->iddanota;
                        }
                        $notas[$Itemdado->nota_meta_id] = $dadonota->notas;
                        $iddisciplinanota[$Itemdado->nota_meta_id] = $dadonota->iddanota;
                    }
                }
                // if (! empty($formunlamendia)) {
                //     array_push($dadosTiponotas, (object) ['nota_meta_id' => 0, 'nota_descricao' => '@media']);
                //     $disciplinaavalaicaotipo[$disciplinasItem->Descricao] = $dadosTiponotas;

                // }

                $disciplinasArrei[''.$disciplinasItem->Descricao.''] = $notas;
                $disciplinasArrei['idnotas'] = $iddisciplinanota;
            }
            $alunoscolecao->push([
                'id' => $alunosItem->alunoclass->id, 'nome' => $alunosItem->alunoclass->aluno->nome,
                'sexo' => $alunosItem->alunoclass->aluno->sexo,
                'disciplinas' => $disciplinasArrei,
            ]);
        }

        $turma = $alunoscolecao;
        $dadosturma = [];

        $cabecalho = [];
        $cabecalho[0] = ('Nr');
        $cabecalho[1] = ('Codigo');
        $cabecalho[2] = ('Nome');
        $cabecalho[3] = ('Sexo');
        foreach ($disciplinaavalaicaotipo[$iddisciplia] as $key => $dv) {
            $cabecalho[$key + 4] = ($dv->nota_descricao);
        }

        foreach ($turma as $key => $turmaItem) {
            $acs = [];
            $acs['Nr'] = ($key + 1);
            $acs['Codigo'] = ($turmaItem['id']);
            $acs['Nome'] = ($turmaItem['nome']);
            $acs['sexo'] = ($turmaItem['sexo']);

            foreach ($disciplinaavalaicaotipo[$iddisciplia] as $index => $dispv) {

                $acs[$dispv->nota_descricao] = ($turmaItem['disciplinas'][$iddisciplia][$dispv->nota_meta_id]);
                // $acs->push($dispv->nota_descricao);

            }

            array_push($dadosturma, $acs);
        }

        $dadosdaescola = DB::table('config')->first();
        $turmas = turma::where('id', $turmaid)->with(['classeturma', 'anolectivo', 'professor'])->first();


        return Excel::download(new notasdisciplinaExport(
            $cabecalho,
            $dadosturma,
            $iddisciplia,
            $dadosdaescola,
            $turmas
        ), $turmas->Descricao.''.$turmas->classeturma->Descricao.''.$turmas->anolectivo->anolectivo.'  '.$iddisciplia.'.xlsx');
        //  return  view('Export.notascaderneta');

    }

    public function notasTrimestrais($turma)
    {

    //busca a turma
        $turmas = turma::where('id', $turma)->with('formulas')->first();


// dd
       //dd($turmaprofessores[0]->Docente);
    // busca as notas da turma veriica de esta trancado
$divisoes = DB::table("visaonotas")
    ->where("turma_id", $turma)
    ->where(function($q) {
        $q->whereNotNull("chave1")
          ->orWhereNotNull("chave2");
    })
    ->select("divisao_id", "chave2")
    ->distinct()
    ->get();

    $classturma=classe::where("id",$turmas->classe_id)->first();
// define a forma que foi trancado
$resultadotRANCA = $divisoes->map(function($item) {
    return [
        "divisao_id" => $item->divisao_id,
        "fechamento" => is_null($item->chave2) ? "PARCIAL" : "TOTAL",
        "css"        => is_null($item->chave2) ? "color: orange;" : "color: green;"
    ];
})->toArray();


// busca as dsiciplinas de cada  classe
       $classe_disciplinas = classe_discplina::where('classe_id', $turmas->classe_id)
    ->where('anolectivo_id', $turmas->ano_lecttivo_id)
    ->with('disciplina')
    ->orderBy('disciplina_id', 'asc')
    ->get();


        $coleccaoalunos = collect();
        $alunos_turmas = turma_aluno::where('turma_id', $turma)->with('alunoclass')->get();
        $dadonota = collect();
// $nota_meta_id=[0,100];
      $ids = [0, 100]; // ou explode(',', $nota_meta_id)
$placeholders = implode(',', array_fill(0, count($ids), '?'));

$sql = "SELECT DISTINCT divisao_id, divisao, nota_meta_id
        FROM visaonotas
        WHERE turma_id = ?
        AND nota_meta_id IN ($placeholders)
        ORDER BY divisao ASC";

$params = array_merge([$turma], $ids);

$divisoes = DB::select($sql, $params);

// Atualiza o campo 'divisao' onde 'divisao_id' é 100
foreach ($divisoes as $item) {
    if ($item->divisao_id == 100) {
        $item->divisao = 100;
    }
}



$chave1="";
$chave1="";
        foreach ($alunos_turmas as $key => $itemI) {
            $colecaoDisp = collect();
            foreach ($classe_disciplinas as $classe_disciplinasItem) {

                $colecaoNotas = collect();
                foreach ($divisoes as $divisoesItem) {

                 $notasMetaIds = [0,100];
$placeholders = implode(',', $notasMetaIds);

$notas = DB::select("
    SELECT * FROM visaonotas
    WHERE classe_disciplina_id = ?
      AND id = ?
      AND divisao_id = ?
      AND nota_meta_id IN ($placeholders)
", [
    $classe_disciplinasItem->id,
    $itemI->alunoclass->id,
    $divisoesItem->divisao_id
]);




if (!empty($notas)) {
    $chave1 = $notas[0]->chave1;
    $chave2 = $notas[0]->chave2;
}




           if (! empty($notas)) {

                        $colecaoNotas->push([
                            'NT' => $notas[0]->notas,
                            'divisao_id' => $notas[0]->divisao_id ,
                            'divisao' =>  $notas[0]->divisao ,
                            'chave1' =>  $notas[0]->chave1,
                            'chave2' =>  $notas[0]->chave2,
                        ]);
                    } else {
                        // dd($notas[0]);
                        $colecaoNotas->push([
                            'NT' => ' ',
                            'divisao_id' => $divisoesItem->divisao_id,
                            'divisao' => $divisoesItem->divisao ,
                            'chave1' =>  null ,
                            'chave2' =>  null ,
                        ]);
                    }

                }
                $colecaoDisp->push([
                    'Nome' => $classe_disciplinasItem->disciplina->Descricao,
                    'disciplina_id' => $classe_disciplinasItem->disciplina->id,
                    'sigla' => $classe_disciplinasItem->disciplina->Sigla,
                    'area' => $classe_disciplinasItem->disciplina->Tipo,
                    'notas' => $colecaoNotas,
                ]);
            }

            $formulamediaanual = '';
            if (! empty($itemI->alunoclass->formulamediaAnual)) {
                $formulamediaanual = $itemI->alunoclass->formulamediaAnual->formula;
            } else {
                $classe_grupo = classes_grupo::where('classe_id', $itemI->alunoclass->classe_id)->first();
                if (empty($classe_grupo)) {

                    $formulamediaanual = DB::table('mediasanuaistrimestralformula')
                        ->where('turma', $turma)->where('TipoMedia', 2)->first();
                    if (! empty($formulamediaanual)) {
                        $formulamediaanual = $formulamediaanual->formula;
                    } else {
                        $formulamediaanual = '';
                    }
                }

            }
            $coleccaoalunos->push([
                'id' => $itemI->alunoclass->id,
                'nome' => $itemI->alunoclass->aluno->nome,
                'sexo' => $itemI->alunoclass->aluno->sexo,
                'MediaFormulaAnual' => $formulamediaanual,
                'disciplina' => $colecaoDisp,

            ]);
        }
        $formunlamendia = $turmas->formulas
        -> where('mediaflag', 0)
       ;

        // dd($formunlamendia);




$mediasanual=mediaanualDados::
where("ano_lectivo",$turmas->ano_lecttivo_id)
->where("MediaTempo",0)
->get();

$notasTodoano=DB::table("anolectivometadata")->where("anolectivo_id",$turmas->ano_lecttivo_id)->get();


$divisoes=collect($divisoes);
// dd($divisoes);

        return view(
            'registoAcademico.notas.notas-todoano',
            compact('alunos_turmas','resultadotRANCA','classe_disciplinas', 'divisoes', 'coleccaoalunos',
            'formunlamendia', 'turma','mediasanual','notasTodoano','classturma')
        );
    }


  public function PautadeExame($turma,$flag)
    {


    //busca a turma
        $turmas = turma::where('id', $turma)->with('formulas')->first();

// dd($turma,$flag);
       // dd($turmaprofessores[0]->Docente);
    // busca as notas da turma veriica de esta trancado
$divisoes = DB::table("visaonotas")
    ->where("turma_id", $turma)
    ->where(function($q) {
        $q->whereNotNull("chave1")
          ->orWhereNotNull("chave2");
    })
    ->select("divisao_id", "chave2")
    ->distinct()
    ->get();

// define a forma que foi trancado
$resultadotRANCA = $divisoes->map(function($item) {
    return [
        "divisao_id" => $item->divisao_id,
        "fechamento" => is_null($item->chave2) ? "PARCIAL" : "TOTAL",
        "css"        => is_null($item->chave2) ? "color: orange;" : "color: green;"
    ];
})->toArray();


// busca as dsiciplinas de cada  classe
       $classe_disciplinas = classe_discplina::where('classe_id', $turmas->classe_id)
    ->where('anolectivo_id', $turmas->ano_lecttivo_id)
    ->with('disciplina')
    ->orderBy('disciplina_id', 'asc')
    ->get();


        $coleccaoalunos = collect();

$Resultados = ["Aprovado", "Aprovado"];

$turmaidAlunos = DB::table("turmasalunosview")
    ->where("jurri_id", $turma)
    ->whereNotNull("Resultado1")
    ->pluck("aluno_classe_id")
    ->toArray();





        // dd($turmaidAlunos);
        $alunos_turmas = turma_aluno::whereIn("aluno_classe_id", $turmaidAlunos)
        // ->with('alunoclass')
        ->get();
        $dadonota = collect();
        // dd($jurii,$turma, $turmaidAlunos, $alunos_turmas);
// $nota_meta_id=[0,100];
      $ids = [0, 100]; // ou explode(',', $nota_meta_id)
$placeholders = implode(',', array_fill(0, count($ids), '?'));




$divisoes = collect([
     (object)[
    'divisao_id'   => 100,
    'divisao'      => 100,
    'nota_meta_id' => 100,
],
 (object)
[
    'divisao_id'   => 900,
    'divisao'      => 900,
    'nota_meta_id' => 900,
],
 (object)
[
    'divisao_id'   => 9000,
    'divisao'      => 9000,
    'nota_meta_id' => 9000,
]],
);


$chave1="";
$chave1="";
        foreach ($alunos_turmas as $key => $itemI) {
            $colecaoDisp = collect();
            foreach ($classe_disciplinas as $classe_disciplinasItem) {

                $colecaoNotas = collect();
                foreach ($divisoes as $divisoesItem) {

                 $notasMetaIds = [100,900,9000];
$placeholders = implode(',', $notasMetaIds);

$notas = DB::select("
    SELECT * FROM visaonotas
    WHERE classe_disciplina_id = ?
      AND id = ?
      AND divisao_id = ?
      AND nota_meta_id IN ($placeholders)
", [
    $classe_disciplinasItem->id,
    $itemI->alunoclass->id,
    $divisoesItem->divisao_id
]);




if (!empty($notas)) {
    $chave1 = $notas[0]->chave1;
    $chave2 = $notas[0]->chave2;
}




           if (! empty($notas)) {

                        $colecaoNotas->push([
                            'NT' => $notas[0]->notas,
                            'divisao_id' => $notas[0]->divisao_id ,
                            'divisao' =>  $notas[0]->divisao ,
                            'chave1' =>  $notas[0]->chave1,
                            'chave2' =>  $notas[0]->chave2,
                        ]);
                    } else {
                        // dd($notas[0]);
                        $colecaoNotas->push([
                            'NT' => ' ',
                            'divisao_id' => $divisoesItem->divisao_id,
                            'divisao' => $divisoesItem->divisao ,
                            'chave1' =>  null ,
                            'chave2' =>  null ,
                        ]);
                    }

                }
                $colecaoDisp->push([
                    'Nome' => $classe_disciplinasItem->disciplina->Descricao,
                    'disciplina_id' => $classe_disciplinasItem->disciplina->id,
                    'sigla' => $classe_disciplinasItem->disciplina->Sigla,
                     'area' => $classe_disciplinasItem->disciplina->Tipo,
                    'notas' => $colecaoNotas,
                ]);
            }

            $formulamediaanual = '';
            if (! empty($itemI->alunoclass->formulamediaAnual)) {
                $formulamediaanual = $itemI->alunoclass->formulamediaAnual->formula;
            } else {
                $classe_grupo = classes_grupo::where('classe_id', $itemI->alunoclass->classe_id)->first();
                if (empty($classe_grupo)) {

                    $formulamediaanual = DB::table('mediasanuaistrimestralformula')
                        ->where('turma', $turma)->where('TipoMedia', 2)->first();
                    if (! empty($formulamediaanual)) {
                        $formulamediaanual = $formulamediaanual->formula;
                    } else {
                        $formulamediaanual = '';
                    }
                }

            }
            $coleccaoalunos->push([
                'id' => $itemI->alunoclass->id,
                'nome' => $itemI->alunoclass->aluno->nome,
                'sexo' => $itemI->alunoclass->aluno->sexo,
                'MediaFormulaAnual' => $formulamediaanual,
                'disciplina' => $colecaoDisp,

            ]);
        }
        $formunlamendia = $turmas->formulas->where('mediaflag', 4);





$mediasanual=
mediaanualDados::
where("ano_lectivo",$turmas->ano_lecttivo_id)->
where("MediaTempo",4)
->get();

$notasTodoano=DB::table("anolectivometadata")->where("anolectivo_id",$turmas->ano_lecttivo_id)->get();




    $classturma=classe::where("id",$turmas->classe_id)->first();
        return view(
            'registoAcademico.notas.notas-PautaExame',
            compact('alunos_turmas','resultadotRANCA','classe_disciplinas', 'divisoes', 'coleccaoalunos',
            'formunlamendia', 'turma','mediasanual','notasTodoano','classturma')
        );
    }

    public function notastrimestraisedita($turma)
    {
        return view('registoAcademico.notas.notatodas-json', compact('turma'));
    }

    public function notastrimestraiseditadados($turma)
    {

        $dados = [
            [
                'nome' => 'Dimene Luis Ernesto',
                'idade' => '30',
                'Datadenascimento' => '12-12-1994',
                'posicao' => 'Funcionario',
            ],
            [
                'nome' => 'Ugo Panser Ernesto',
                'idade' => '29',
                'Datadenascimento' => '12-12-1994',
                'posicao' => 'Programador',
            ],
        ];

        return response()->json($dados);
    }

    public function notasTrimestraisshow()
    {
        $class = classe::all();
        $nota_meta = nota_meta::all();

        $anolectivo = anolectivo::orderby('id', 'desc')->get();

        // selecionar as turnas
        $turmas = turma::where('classe_id', $class[0]->id)
            ->where('ano_lecttivo_id', $anolectivo[0]->id)
            ->get();

        $disciplinas = DB::table('disciplinas')->get();
        $autor = auth()->user()->id;

        $turmasAtribuidas = DB::select(
            'SELECT DISTINCT(turma_id),turma_id,turma FROM  professor_turmaview
                where  classe_id=? and ano_lectivo_id=?',
            [$class[0]->id, $anolectivo[0]->id]
        );

        $classesprofessor = DB::select(
            'SELECT DISTINCT(classe_id), classe FROM  professor_turmaview
                where   ano_lectivo_id=?',
            [$anolectivo[0]->id]
        );
        $anoslectivoprofessore = DB::select("SELECT DISTINCT(ano_lectivo_id)
FROM  professor_turmaview");

        $preshow =
            DB::select('SELECT
*
FROM
  professor_turmaview
  ORDER BY classe_id,turma_id,disciplina_id ASC  ');

        if (empty($preshow)) {
         $mensagem = ' Nao foi criada nenhuma turma ';

         $tipopauta="Pauta Turma";
         return view('Componetes.alerta-Falha', compact('mensagem',"tipopauta"));
        }

        return view(
            'registoAcademico.notas.notas-trimestrais-show',
            compact(
                'class',
                'anolectivo',
                'turmas',
                'disciplinas',
                'nota_meta',
                'turmasAtribuidas',
                'classesprofessor',
                'anoslectivoprofessore',
                'preshow'
            )
        );
    }


  public function notasAnualExame()
    {
        $class = classe::all();
        $nota_meta = nota_meta::all();

        $anolectivo = anolectivo::orderby('id', 'desc')->get();

        // selecionar as turnas
        $turmas = turma::where('classe_id', $class[0]->id)
            ->where('ano_lecttivo_id', $anolectivo[0]->id)
            ->get();

        $disciplinas = DB::table('disciplinas')->get();
        $autor = auth()->user()->id;

        $turmasAtribuidas = DB::select(
            'SELECT DISTINCT(turma_id),turma_id,turma FROM  professor_turmaview
                where  classe_id=? and ano_lectivo_id=?',
            [$class[0]->id, $anolectivo[0]->id]
        );

        $classesprofessor = DB::select(
            'SELECT DISTINCT(classe_id), classe FROM  professor_turmaview
                where   ano_lectivo_id=?',
            [$anolectivo[0]->id]
        );
        $anoslectivoprofessore = DB::select("SELECT DISTINCT(ano_lectivo_id)
FROM  professor_turmaview ");

        $preshow =
            DB::select('SELECT
*
FROM
  professor_turmaview
  ORDER BY classe_id,turma_id,disciplina_id ASC  ');

        if (empty($preshow)) {
         $mensagem = ' Nao foi criada nenhuma Jurri ';
         $tipopauta="Jurri Classe ";

         return view('Componetes.alerta-Falha', compact('mensagem', "tipopauta"));
        }

        return view(
            'registoAcademico.notas.notas-PautaExame-show',
            compact(
                'class',
                'anolectivo',
                'turmas',
                'disciplinas',
                'nota_meta',
                'turmasAtribuidas',
                'classesprofessor',
                'anoslectivoprofessore',
                'preshow'
            )
        );
    }

    public function formulaAnualMedia(Request $request, $flag)
    {


    // dd($request->all(), $flag);

        $dados = mediasanuaistrimestralformula::updateOrCreate(
            [
                'turma' => $request->turma,
                'anolectivo_id' => $request->anolectivo,
                'TipoMedia' => $flag,
                'mediaflag' => $request->flagTempoMedia,
            ],
            ['formula' => $request->formula]
        );

        if ($flag == 1) {

            $turma = $request->turma;
            $turmas = turma::where('id', $turma)->with('formulas')->first();

            $classe_disciplinas = classe_discplina::where('classe_id', $turmas->classe_id)
                ->where('anolectivo_id', $turmas->ano_lecttivo_id)->with('disciplina')->get();

            $coleccaoalunos = collect();
            $alunos_turmas = turma_aluno::where('turma_id', $turma)->with('alunoclass')->get();
            $dadonota = collect();

        }


                $ifor = [
                    'alert' => 'success',
                    'msg' => 'guardado com sucesso',
                    'turma' => $request->turma,
                ];



            return response()->json($ifor);

    }



public function exportarPautaAnual(Request $request)
{

    $conf = configuraceos::first();
    $colunas = range('A', 'Z');

    // RECEBER DADOS DO FORM
    $corpo = json_decode($request->corpo, true);
    // dd(  $corpo);
    $cabecalhoEstruturado = json_decode($request->disciplinas, true);
    $trimestre = json_decode($request->trimestre, true);



//     if(collect($trimestre)->where("divisao_id",100)){
//     array_push(  $trimestre,["divisao_id" => 100,
//     "divisao" => 100,
//     "nota_meta_id" => 100
//   ]);
//     }

//    dd($request->all(),$trimestre,$cabecalhoEstruturado,   $trimestre);

    $turma = $request->turma;

    $tamanhoMesclar = (count($cabecalhoEstruturado) * count($trimestre))+4;

    $arayMesclagem = [];
    $arayMesclagemFooter = [];
    $arayMesclagemLetras = [];
    $arayprofessores = [];

    $variavelmeslagem = "";
    $variavelmeslagemFooter = "";
    $variavelmeslagemFooter1 = "";

    // CABEÇALHO
    $linha1 = ['codigo','Nr', 'Nome', 'Sexo'];
    $linha2 = ['', '', '',''];
    $arayprofessores = ['', '', '',''];

    foreach ($cabecalhoEstruturado as $disciplina) {

        $colspan = count($trimestre);

        $disciplinadesc =
            $disciplina['disciplina']["Descricao"] .
            ' (' . $disciplina['disciplina']["Sigla"] . ')';

        $linha1[] = $disciplinadesc;

        $prof =
            professor_turma::where("turma_id", $turma)
                ->where("disciplina_id", $disciplina['disciplina']["id"])
                ->first()->Docente->name ?? "";

// dd($cabecalhoEstruturado);
 $docente= "prof: " . $prof;
       array_push( $arayprofessores,$docente);
        // $arayprofessores[] = "";

        for ($i = 1; $i < $colspan; $i++) {
            $linha1[] = '';
        }

//  dd($trimestre,$request->notasdiferente);
        foreach ($trimestre as $coluna) {

            if ((int)$coluna["divisao"] <>(int)$request->notasdiferente) {

            $legenda="";

            if($coluna["divisao"]==100){
                 $legenda="NA";

            }
elseif($coluna["divisao"]==900){
 $legenda="NE";
}
else{
   $legenda=$coluna["divisao"] . "NF";
}
                array_push( $linha2,$legenda);

                array_push($arayprofessores,"");

            }

        }

        $linha2[] = "MF";

    }

    $linha1[] = 'MA';
    $linha1[] = 'Resultado';

    $linha2[] = '';
    $linha2[] = '';


    $arayprofessores[] = " ";
    $arayprofessores[] = " ";
    // dd($arayprofessores);

    $cabecalho = [$linha1, $linha2];
    $linhas = $corpo;

    $x2 = 1;

    // dd($tamanhoMesclar);
    for ($x = 4; $x < $tamanhoMesclar; $x++) {

        if ($x2 == 1):

            $variavelmeslagem = $colunas[$x] . "8";
            // echo $variavelmeslagem .'<BR>' ;
            $variavelmeslagemFooter = $colunas[$x] . (11 + count($linhas));
            $variavelmeslagemFooter1 = $colunas[$x] . (10 + count($linhas));

        elseif ($x2 == count($trimestre)):


            $variavelmeslagem .= ":" . $colunas[$x] . "8";
              echo $variavelmeslagem .'<BR>' ;
            $variavelmeslagemFooter .= ":" . $colunas[$x] . (11 + count($linhas));
            $variavelmeslagemFooter1 .= ":" . $colunas[$x] . (10 + count($linhas));

        endif;

        $x2++;

        if ($x2 == (count($trimestre) + 1)) {

            $arayMesclagem[] = $variavelmeslagem;
            $arayMesclagemFooter[] = $variavelmeslagemFooter;
            $arayMesclagemFooter[] = $variavelmeslagemFooter1;

            $x2 = 1;

        }

        // dd($colunas[$x]);
        $arayMesclagemLetras[] = $colunas[$x];

    }

    $turmasel = DB::table("turmas")->where("id", $turma)->first();

    $dados = classe_direcao::where("anolectivo_id", $turmasel->ano_lecttivo_id)
        ->with(["usuarioP", "usuariod", "classe"])
        ->where("classe_id", $turmasel->classe_id)
        ->first();

    $dadosDirecao = [

        "Director" => [
            "Nome" => $dados->usuariod->name,
            "sexo" => $dados->usuariod->sexo,
            "nivel" => optional($dados->usuariod->nivel)->Descricao
        ],

        "pedagogico" => [
            "Nome" => $dados->usuarioP->name,
            "sexo" => $dados->usuarioP->sexo,
            "nivel" => optional($dados->usuarioP->nivel)->Descricao
        ]

    ];

    $turmaclasse = DB::table('turmasalunosview')
        ->where("turma_id", $turma)
        ->first();


$descricaOPauta="Pauta da Turma ";

        if(empty($turmaclasse)):
        $turmaclasse = DB::table('turmasalunosview')
        ->where("Jurri_id", $turma)
        ->first();

$descricaOPauta="Pauta do Jurri ";
        endif;


  $dadosnomePauta =
        $descricaOPauta.
        $turmasel->Descricao .
        " " .
        $turmaclasse->classe;
             $dadosnome =
        $descricaOPauta .
        $turmasel->Descricao .
        "_" .
        $turmaclasse->classe .
        "_" .
        now()->format('Ymd_His');

// dd($turmaclasse);






    $config = DB::table("config")->first();

    $anolectivodados = [
        "anolectivo" => $turmaclasse->anolectivo,
        "escola" => $config->nome,
        "Nome" => $dadosnomePauta
    ];


    $tamanho = 2;
    $numerodisci = count($cabecalhoEstruturado);







    return Excel::download(

        new pautaclasseExport(
            $cabecalho,
            $linhas,
            $arayMesclagem,
            $arayMesclagemLetras,
            $arayMesclagemFooter,
            $colunas,
            $arayprofessores,
            $dadosDirecao,
            $anolectivodados,
            $tamanho,
            $numerodisci

        ),

        $dadosnome . '.xlsx'

    );

}
    public function ImprimirPautaAnual(Request $request)
    {
         //dd($request->all());

        $cabecalho = [];
        $cabecalho[1][0] = 'Nr';
        $cabecalho[1][1] = 'Nome';
        $cabecalho[1][2] = 'Sexo';
        $cabecalho[0][0] = '';
        $cabecalho[0][1] = '';
        $cabecalho[0][2] = '';
        $celulasunir = [];
        $dados = $request['dados'];

        $colunas = range('A', 'Z');
        $i = 0;
        for ($x = 0; $x < 26; $x++) {
            for ($y = 0; $y < 26; $y++) {
                $colunasAdd = $colunas[$x].$colunas[$y];
                array_push($colunas, $colunasAdd);

            }
        }
        $y = 3;

        foreach (json_encode($request['Disciplina']) as $key => $Item) {

            foreach ($request['trimestres'] as $key2 => $Item2) {
                if ($key2 == 0) {
                    $cabecalho[0][$y] = $Item['Descricao'];
                    $celuasunir[0][$key] = $colunas[$y];
                    $celuasunir[1][$key] = $colunas[$y + count($request['trimestres'])];
                } else {
                    $cabecalho[0][$y] = '';
                }

                $cabecalho[1][$y] = $Item2['divisao'].'NF';
                $y++;
            }
            $y++;
            $cabecalho[1][$y + count($request['trimestres'])] = 'MF';
            $cabecalho[0][$y + count($request['trimestres'])] = '';

        }
        $cabecalho[1][$y + 3] = 'MA';
        $cabecalho[1][$y + 4] = 'Resultato';

        $dadoTabela = [];

        $dadoTabela[0] = $cabecalho[0];
        $dadoTabela[1] = $cabecalho[1];
        for ($x = 0; $x < count($dados); $x++) {
            array_push($dadoTabela, $dados[$x]);

        }

        $dadotrimestres = count($request['trimestres']);

        return Excel::download(new pautaAnualExport($dados, $cabecalho, count($cabecalho[1]), $dadoTabela, $celuasunir,
            $colunas, $dadotrimestres), 'dadosnobre.xlsx');

    }

    public function processarcabecalhoPAuta($request)
    {
        $y = 3;
        $cabecalho = [];
        $cabecalho[1][0] = 'Nr';
        $cabecalho[1][1] = 'Nome';
        $cabecalho[1][2] = 'Sexo';
        $cabecalho[0][0] = '';
        $cabecalho[0][1] = '';
        $cabecalho[0][2] = '';

        foreach ($request['Disciplina'] as $key => $Item) {

            foreach ($request['trimestres'] as $key2 => $Item2) {
            }
        }
    }

    public function gerarResultado(Request $request)
    {

        //dd($request->all());
        $dadosa = collect();
        foreach ($request->dados as $item) {

            $dadosaluno = collect();
            $dadosaluno['id'] = ($item[0]);
            $dadosaluno['Nome'] = ($item[1]);
            $dadosaluno['sexo'] = ($item[2]);

            $y = 2;
            foreach ($request->Disciplina as $key => $disciplinasIntem) {

                for ($x = 0; $x <= (count($request->trimestres)); $x++) {
                    $y++;
                    if ($x == (count($request->trimestres))) {

                        $dadosaluno[''.$disciplinasIntem['sigla'].''] = $item[($y)];

                    }

                }

            }
            $dadosa->push($dadosaluno);
        }

        $dados = $this->Resultado($request->Disciplina, $dadosa, $request->classe);
        $dadosRetorno = collect();
        foreach ($request->dados as $key => $Item) {
            $Item[count($Item) - 1] = $dados[$key]['Resultado'];
            $dadosRetorno->push($Item);
        }

        return $dadosRetorno;
    }

    public function Resultado($Disciplinas, $Dados, $classe)
    {
        foreach ($Dados as $key => $Item) {
            $result = 'Aprovad'; // Definir o resultado padrão como "Aprovado"
            $contadorNegativasOutras = 0; // Inicializar contador de notas negativas em outras disciplinas

            foreach ($Disciplinas as $disp) {
                // Verificar se a nota é menor que 7 para qualquer disciplina
                if ($Item[$disp['sigla']] < 7) {
                    $result = 'Reprovad';
                    break; // Se uma nota for negativa, não precisa continuar verificando
                }
                // Verificar se a nota é menor que 10 para as disciplinas 'P' ou 'M'
                if ($disp['sigla'] == 'P' || $disp['sigla'] == 'M') {
                    if ($Item[$disp['sigla']] < 10) {
                        //hjhjg
                        $result = 'Reprovad';
                        break; // Se uma nota de 'P' ou 'M' for negativa, não precisa continuar verificando
                    }
                } else {
                    // Se não for 'P' nem 'M', verificar se a nota é negativa e menor que 7
                    if ($Item[$disp['sigla']] < 7) {
                        $contadorNegativasOutras++;
                        if ($contadorNegativasOutras > 2) {
                            $result = 'Reprovad';
                            break; // Se houver mais de duas negativas em outras disciplinas, reprova
                        }
                    }
                }
            }

            // Atribuir o resultado ao aluno
            if ($Dados[$key]['sexo'] == 'F') {
                $result = $result.'a';
            } else {
                $result = $result.'o';
            }
            $Dados[$key]['Resultado'] = $result;
        }

        // Retornar os dados atualizados
        return $Dados;
    }



    public function precistirbanco(Request $request)
    {

    //  dd($request->all());

   $turmaaluno = json_decode($request->rowData);
$trimeste = collect(json_decode($request->trimeste))->sortBy("divisao");
$disciplina = collect(json_decode($request->disciplina));
// dd($turmaaluno);
$divisao = collect();
$anolectivo_id = "";

if(!$trimeste->contains('divisao',100)){
    $trimeste->push((object)[
        "divisao_id"=>100,
        "divisao"=>100,
        "nota_meta_id"=>100
    ]);
}

    foreach($trimeste as $tri){
$divisao->push($tri);
    }
    // $trimestre=$divisao;
//  dd($disciplina, $divisao);
 $colecao=collect();
 $dadosInicias=["Nr","Nome","sexo"];
 $dadosfinais=["1000","Resultato"];

  $x=0;
  $xy=0;
  $discInc=0;

 foreach($turmaaluno as $key=>$item):
  $label="";
  $disciplinaINcdados="";
  $disciplinaclasse_id="";

  $descricaoDisciplina="";
   $nota_meta_id="";

  $idaluno="";

    if($key>2):
if($key<count($turmaaluno)-2){
    // $label=$divisao[$x]->divisao_id;
    // $nota_meta_id=$divisao[$x]->nota_meta_id;
    // $disciplinaINcdados= $disciplina[$discInc]->id??null;
    // $disciplinaclasse_id= $disciplina[$discInc]->classe_id??null;
     $anolectivo_id= $disciplina[$discInc]->anolectivo_id??null;

    // $descricaoDisciplina= $disciplina[$discInc]->disciplina->Descricao??null;
    // $idaluno=$request->idAluno;

nota::updateOrCreate(
                ["classe_disciplina_id" =>  $disciplina[$discInc]->id??null,
                    "aluno_classe_id" =>$request->idAluno,
                    "divisao_id" => $divisao[$x]->divisao_id,
                    "nota_meta_id" => $divisao[$x]->nota_meta_id
                ],["nota_descricao" =>(float) $item]
            );




    }
    // else{
    //      $idaluno=$request->idAluno;
    //     $label=$dadosfinais[$xy];



    //     $xy++;

    // }
$x++;
if($x==(count($trimeste))){$x=0; $discInc++;}


//  $colecao->push(["Descricao"=>$label,
//  "nota"=>$item,
//  "disc_class_id"=>$disciplinaINcdados,
//  "classe_id"=>$disciplinaclasse_id,
//  "anolectivo_id"=>$anolectivo_id,
//  "nota_meta_id"=>$nota_meta_id,
//  "descricaoDisciplina"=>$descricaoDisciplina,
//  "idaluno"=>$idaluno,
//  ]);
 endif;

 endforeach;
 $anolectivo_id= $disciplina[0]->anolectivo_id??null;
//  dd($anolectivo_id,);
 $dadossave = mediaanualDados::updateOrCreate(
    [
        "id" => $request->idAluno,
        "ano_lectivo" =>$anolectivo_id,
        "user_created" => auth()->user()->id,
         "MediaTempo" =>0,
    ],
    [
        "valor" =>(float) $turmaaluno[count($turmaaluno)-2],
        "Resultado"=>$turmaaluno[count($turmaaluno)-1],
    ]
);
//  dd($colecao,$dadossave);

    }



 public function precistirbancoExame(Request $request)
    {

    //  dd($request->all());
   $turmaaluno = json_decode($request->rowData);
$trimeste = collect(json_decode($request->trimeste))->sortBy("divisao");
$disciplina = collect(json_decode($request->disciplina));

$divisao = collect();
$anolectivo_id = "";


    foreach($trimeste as $tri){
$divisao->push($tri);
    }

  $x=0;
  $xy=0;
  $discInc=0;

 foreach($turmaaluno as $key=>$item):


    if($key>2):
if($key<count($turmaaluno)-2){

     $anolectivo_id= $disciplina[$discInc]->anolectivo_id??null;

nota::updateOrCreate(
                ["classe_disciplina_id" =>  $disciplina[$discInc]->id??null,
                    "aluno_classe_id" =>$request->idAluno,
                    "divisao_id" => $divisao[$x]->divisao_id,
                    "nota_meta_id" => $divisao[$x]->nota_meta_id
                ],["nota_descricao" =>(float) $item]
            );




    }

$x++;
if($x==(count($trimeste))){$x=0; $discInc++;}
 endif;

 endforeach;
 $anolectivo_id= $disciplina[0]->anolectivo_id??null;

 $dadossave = mediaanualDados::updateOrCreate(
    [
        "aluno_classe_id" => $request->idAluno,
        "ano_lectivo" =>$anolectivo_id,
        "MediaTempo" =>4,
        "user_created" => auth()->user()->id
    ],
    [
        "valor" =>(float) $turmaaluno[count($turmaaluno)-2],
        "Resultado"=>$turmaaluno[count($turmaaluno)-1],
    ]
);


    }


public function guardarmedia2(Request $request)
{
    // Converte os dados recebidos em uma coleção para facilitar o acesso

    $dados = collect($request->dados);

    // Itera sobre cada disciplina enviada
    foreach ($request->disciplinas as $disciplina) {
        $classeDisciplinaId = $disciplina["id"];
        $disciplinaId = $disciplina["disciplina"]["id"];

        // Obtém a média geral (divisão 100), com fallback para 0
        $media = isset($dados[$disciplinaId][100]) ? (float) $dados[$disciplinaId][100] : 0;

        // Itera sobre os trimestres que têm divisão diferente de 100
        foreach (collect($request->trimestres) as $trimestre) {
            $divisao = (int) $trimestre["divisao"];
            $divisaoId = (int) $trimestre["divisao_id"];
            $notaMetaId = $trimestre["nota_meta_id"];

            // Obtém a nota da divisão atual, com fallback para 0
            $nota = isset($dados[$disciplinaId][$divisao]) ? (float) $dados[$disciplinaId][$divisao] : 0;

            // Salva a nota do trimestre
            nota::updateOrCreate(
                ["classe_disciplina_id" => $classeDisciplinaId,
                    "aluno_classe_id" => $request->id,
                    "divisao_id" => $divisaoId,
                    "nota_meta_id" => $notaMetaId
                ],["nota_descricao" => $nota]
            );

            // Salva a mesma nota com nota_meta_id = 100 (média por divisão)
           /* nota::updateOrCreate(
                ["classe_disciplina_id" => $classeDisciplinaId,
                    "aluno_classe_id" => $request->id,
                    "divisao_id" => 100,
                    "nota_meta_id" => 100
                ],
                ["nota_descricao" => $nota]
            );
            */
// Log para depuração
 echo "nota_meta_id {$notaMetaId} | classe_disciplina {$classeDisciplinaId} | aluno {$request->id} | divisao {$divisaoId} | nota {$nota}\n";
        }
    }

    // Opcional: retorno JSON de sucesso
    return response()->json(["success" => "Notas salvas com sucesso"]);
}



public function guadarMediaAnual(Request $request,$flag){


//  dd($request->all(),$flag);

$dadossave = mediaanualDados::updateOrCreate(
    [
        "aluno_classe_id" => $request->id,
        "ano_lectivo" => $request->anolectivo,
        "MediaTempo" => $flag,
        "user_created" => auth()->user()->id
    ],
    [
        "valor" => (float) $request->media,
        "Resultado" =>$request->Resultado,
    ]
);
return Response()->json($dadossave);
}


public function RegistodirecaoClasse(Request $request, $classe, $anolectivo)
{
    if ($request->filled('director_id') && $request->filled('pedagogico_id')) {
        classe_direcao::updateOrCreate(
            ['anolectivo_id' => $anolectivo, 'classe_id' => $classe],
            ['director_id' => $request->director_id, 'pedagogico_id' => $request->pedagogico_id]
        );
    }

    $selecionar = classe_direcao::where('classe_id', $classe)
        ->where('anolectivo_id', $anolectivo)
        ->first();

    return response()->json($selecionar);
}






public function selecionardirecaoClasse($classe, $anolectivo)
{

 $selecionar = classe_direcao::where('classe_id', $classe)
       ->where(function($query) use($classe){
        $query->from("classe_direcao")->where("classe_id",$classe)->selectRaw('MAX(anolectivo_id)');
       })
        ->first();
        //  dd($selecionar);

    return ($selecionar);
}

public function trancar(Request $request)


{
    // Buscar alunos da turma com relações carregadas
// dd($request->all());

$estado=1;

if(isset($request->estado)&&$request->estado=="fechar"){
$estado=1;
}elseif(isset($request->estado)&&$request->estado!="fechar"){
$estado=null;
}

    $turmaaluno = turma_aluno::where("turma_id", $request->turma)
        ->with(["alunoclass", "turma"])
        ->get();

    // Verificações de segurança
    if ($turmaaluno->isEmpty()) {
        return; // Nenhum aluno encontrado
    }

    // Classe e ano lectivo da turma
    $classe = $turmaaluno->first()->alunoclass->classe_id;
    $anolectivo = $turmaaluno->first()->alunoclass->anolectivo_id;

    // Direção da classe
    $direcao = DB::table("classe_direcao")
        ->where("anolectivo_id", $anolectivo)
        ->where("classe_id", $classe)
        ->first();

    if (!$direcao) {
        return; // Nenhuma direção encontrada
    }

    // Trimestres que não foram selecionados (abertos)
    $trimestreaNotificarABERTURA = anolectivo_meta::where("anolectivo_id", $anolectivo)
        ->whereNotIn("id", $request->trimestre ?? [])
        ->get();

    // Coleção da direção (Director e Pedagógico)
    $colecaoDirecao = collect([
        ["id" => $direcao->director_id, "Cargo" => "Director"],
        ["id" => $direcao->pedagogico_id, "Cargo" => "Pedagogico"]
    ]);

    $dados=json_encode($request->all());
    // Trancar trimestres selecionados
    if (!empty($request->trimestre)) {
        foreach ($request->trimestre as $trimestre) {
            $this->trancardivisao($colecaoDirecao, $request->alunos, $trimestre, $estado, $turmaaluno,$dados);
        }
    }

    // Notificar abertura dos restantes
      if(!isset($request->estado)):
    if ($trimestreaNotificarABERTURA->isNotEmpty()) {

        foreach ($trimestreaNotificarABERTURA as $trimestre) {
            $this->trancardivisao($colecaoDirecao, $request->alunos, $trimestre->id, null, $turmaaluno,$dados);
        }

    }
        endif;




    if(isset($request->notificacaoId)){

        $notifcao= new NotificacaoController();
        $notifcao->edit($request->notificacaoId);

    }
}



public function trancardivisao($direcao, $turmaaluno, $trimestre, $trancarDostrancar, $turma, $dados)
{
    // 🔑 Usuário autenticado
    $usuarioId = auth()->user()->id;

    // 📌 Cargo do usuário atual (ex.: "Director" ou "Pedagogico")
    $cargoUsuario = $direcao->where("id", $usuarioId)->first()["Cargo"] ?? null;

    // 📌 IDs dos alunos da turma recebida
    $alunoClasseIds = collect($turmaaluno);

    // 📊 Notas dos alunos dessa turma
    $notas = Nota::whereIn("aluno_classe_id", $alunoClasseIds)->get();

    // 👥 Direção a ser notificada (quem não é o usuário atual)
    $direcaoNotificarId = $direcao->where("id", "!=", $usuarioId)->first()["id"] ?? null;
    $usuarioNotificar   = User::where("id", $direcaoNotificarId);

    // 📝 Atualizar notas conforme cargo do usuário
 foreach ($notas as $nota) {
    $atributos = [
        "aluno_classe_id" => $nota->aluno_classe_id,
        "divisao_id"      => $trimestre,
    ];

    if ($cargoUsuario === "Pedagogico") {
        Nota::where($atributos)->update([
            "chave1" => $trancarDostrancar
        ]);
    } elseif ($cargoUsuario === "Director") {
        Nota::where($atributos)->update([
            "chave2" => $trancarDostrancar
        ]);
    }
}

    // 📌 Status da operação (fechar ou abrir)
    $status = $trancarDostrancar !== null ? "fechar" : "Abrir";

    // 📌 Cargo do outro membro da direção (quem será notificado)
    $cargoNotificar = $direcao->where("id", $usuarioNotificar->first()->id)->first()["Cargo"] ?? null;

    // 🔒 Estado da notificação (1 = fechado, null = aberto)
    $estadoNotificar = ($status === "fechar") ? 1 : null;

    // Flag para decidir se deve notificar
    $deveNotificar = true;

    // 📌 IDs únicos dos alunos
    $alunosIds = $notas->pluck("aluno_classe_id")->unique()->toArray();

    // 🚦 Verificação se já existe registro com o mesmo estado
    if ($cargoNotificar === "Pedagogico" &&
        Nota::whereIn("aluno_classe_id", $alunosIds)
            ->where("divisao_id", $trimestre)
            ->where("chave1", $estadoNotificar)
            ->exists()
    ) {
        $deveNotificar = false;
    } elseif ($cargoNotificar === "Director" &&
        Nota::whereIn("aluno_classe_id", $alunosIds)
            ->where("divisao_id", $trimestre)
            ->where("chave2", $estadoNotificar)
            ->exists()
    ) {
        $deveNotificar = false;
    }

    // 🔍 Dados adicionais (se necessário para notificação)
    $dadosNotas = Nota::whereIn("aluno_classe_id", $alunosIds)
        ->where("divisao_id", $trimestre)
        ->where("chave2", $estadoNotificar)
        ->get();

    // 📢 Notificar outro membro da direção, se aplicável
    if ($usuarioNotificar && $deveNotificar) {
        $this->notificarSituacao($usuarioNotificar, $trimestre, $turma, $status, $dados);
    }
}


public function notificarSituacao($notifiado, $trimestre, $turmaaluno, $estado,$dados)
{
    if ($turmaaluno->isEmpty()) {
        return;
    }



    $turma = $turmaaluno->first()->turma;

    $turmaNotificao = $turma->Descricao;
    $turmaClasse = $turma->classeturma->Descricao;
    $anolectivo = $turma->anolectivo->anolectivo;
    $divisao = anolectivo_meta::find($trimestre)?->divisao;
    $modeloamo = $turma->anolectivo->anomodelo->Descricao;

   $notifiado->first()->notify(new FechamentoTurmaNotification(
        $turmaaluno->first()->id,
        $turmaNotificao,
        $trimestre,
        $divisao . "_" . $modeloamo,
        $turmaClasse,
        $anolectivo,
        $estado,
        $dados
    ));
}






public function ConfiguracoesTrimestrais($ano = null)
{
    $anosel = $ano ?? Carbon::now()->year;

    /*
    |--------------------------------------------------------------------------
    | VERIFICAR UTILIZADOR
    |--------------------------------------------------------------------------
    */


    if (auth()->user()->roles->where("name","Admin")->first()) {

        // ADMIN VÊ TUDO
        $classe = classe::all();

        $anolectivo = Anolectivo::orderBy('id', 'desc')->get();

    } else {

        /*
        |--------------------------------------------------------------------------
        | CLASSES DO UTILIZADOR
        |--------------------------------------------------------------------------
        */
        $classe_direcao = DB::table('classe_direcao')
            ->where('director_id', auth()->user()->id)
            ->orWhere('pedagogico_id', auth()->user()->id)
            ->get();

        $classeIds = $classe_direcao
            ->pluck('classe_id')
            ->unique()
            ->toArray();

        $anolectivoIds = $classe_direcao
            ->pluck('anolectivo_id')
            ->unique()
            ->toArray();

        /*
        |--------------------------------------------------------------------------
        | CLASSES
        |--------------------------------------------------------------------------
        */
        $classe = classe::whereIn('id', $classeIds)->get();

        /*
        |--------------------------------------------------------------------------
        | ANOS LECTIVOS
        |--------------------------------------------------------------------------
        */
        $anolectivo = Anolectivo::whereIn('id', $anolectivoIds)
            ->orderBy('id', 'desc')
            ->get();
    }

    return view(
        "registoAcademico.notas.PainelControlNotas",
        compact('anolectivo', 'classe')
    );
}

public function ListadosAlunos($ano = null, $classe = null,$tipoDoc=null){

// dd($ano ,$classe,$tipoDoc);
$dad="";
$local="Turma";
$codigo="codigo";
$class=classe::where("id",$classe)->first();

    if($tipoDoc==10000):


   $dad= DB::table("turmasalunosview")
->where("ano_lectivo_id",$ano)
->whereNotNull("Resultado1")
    ->whereRaw("TRIM(Resultado1) NOT IN (?, ?)", ["Reprovado", "Reprovada"])
->where("classe_id",$classe)->get();
    elseif($tipoDoc==1000):


     $dad= DB::table("turmasalunosview")
->where("ano_lectivo_id",$ano)
->whereNotNull("Resultado2")
    ->whereRaw("TRIM(Resultado2) NOT IN (?, ?)", ["Reprovado", "Reprovada"])
->where("classe_id",$classe)->get();
$codigo="codigo de Exame";
$local="Jurri";
    else:
$dad = DB::table("turmasalunosview as t")
    ->join("visaonotas as v", "t.aluno_classe_id", "=", "v.id")
    ->where("t.ano_lectivo_id", $ano)
    ->where("t.classe_id", $classe)
    ->where("v.divisao_id", $tipoDoc)
    ->where("v.nota_meta_id", 0)

    ->get();
    endif;





// dd($codigo,$dad);



return view("registoAcademico.notas.PainelControlNotasDocunetosConteudo",compact("local","codigo","dad",'tipoDoc'));


}
public function ConfiguracoesTrimestraisano($ano = null, $classe = null)
{
    // Inicializa coleção



    $dadosFechamento = collect();

    // Busca trimestres
    $trimestre = Anolectivo_meta::where("anolectivo_id", $ano)
        ->with("anolectivo.anomodelo")
        ->get();

    // Busca dados das notas
    $dados = DB::table("visaonotas")
        ->where("clase_id", $classe)
        ->where("anolectivo_id", $ano)
        ->get();
// dd($dados);



    foreach ($trimestre as $item) {
        $chave1status=null;
$chave2status=null;
$chave1suser=null;
$chave2user=null;

          $total = $dados->where("divisao_id", $item->id)
          ->count();
        $chave1 = $dados->where("divisao_id", $item->id)->where("chave1", 1)->count();
        $chave2 = $dados->where("divisao_id", $item->id)->where("chave2", 1)->count();
    $chavedivisao = divisaoestado::where("Estado1",1)
        ->where("id",$item->id)
        ->where("classe_id",$classe)
        ->exists();
       $visualizar= divisaoestado::where("divisao_id",$item->id)
        ->where("classe_id",$classe)
        ->first();


        $tranca = null;
        $estado1 = null;

        if ( $chave2>0 && $chave1>0) {

        $classe_direcao=DB::table('classe_direcao')->where("classe_id",$classe)->where("anolectivo_id",$ano)->first();


            $chave1status= $classe_direcao->director_id;

            $chave2status= $classe_direcao->pedagogico_id;
            $tranca = "Total";
            $estado1 = 1;
        } elseif ($chave1 == $chave2 && $chave1 == null) {
            $tranca = "Aberto";
            $estado1 = null;

        }
        elseif($chave1!=$chave2){
             $tranca = "Parcial";

            $estado1 = 1;
             $classe_direcao=DB::table('classe_direcao')->where("classe_id",$classe)->where("anolectivo_id",$ano)->first();

            if($chave1>0){

   $chave1status= $classe_direcao->director_id;
            }
            else{
  $chave2status= $classe_direcao->pedagogico_id;

            }


        }

        $dadosFechamento->push([
            "id"        => $item->id,
            "Descricao" => $item->anolectivo->anomodelo->Descricao,
            "Estado1"   => $estado1,
            "status"    => $tranca,
             "visualizar"=>$visualizar->EstadoView??null,
            "total"     => $total,
            "chave1status"=>$chave1status,
            "chave2status"=>$chave2status

        ]);
    }
    // dd($dadosFechamento);

$classe_direcao=DB::table('classe_direcao')->where("classe_id",$classe)->where("anolectivo_id",$ano)->first();



    //  dd($dadosFechamento, $dados);

    $anolectivo = Anolectivo::orderBy('id', 'desc')->get();

    return view("registoAcademico.notas.PainelControlNotasConteudo", compact('trimestre', 'dadosFechamento', 'anolectivo','classe_direcao'));
}



   public function  TrancarTrimestreAll(Request $request){

//   dd($request->all());

$aluno = alunoClasse::where("classe_id", $request->classe)
    ->where("anolectivo_id", $request->anolectivo)
    ->pluck("id")
    ->toArray();



    foreach($request->dadosTrimestre as $requestDados){
echo $requestDados["trimestre"];
// dd($requestDados);



$tanolectivoClasseAluno=divisaoestado::where("id",$requestDados["trimestre"])
->where("classe_id", $request->classe)
->get();

//  dd($requestDados);
$lock=null;
if($requestDados["LOCK"]!=null){
$lock=1;
}
$eye=null;
if($requestDados["EYE"]!=null){
$eye=1;
}



$classe_direcao=classe_direcao::where("classe_id",$request->classe)
->where("anolectivo_id",$request->anolectivo)->first();

echo $lock."--,".$requestDados["trimestre"].",-- ".$eye," ------classe ".$request->classe;

if($classe_direcao?->director_id==auth()->user()->id ||auth()->user()->roles->where("name","Admin")->first()){

divisaoestado::updateOrCreate(["divisao_id"=>(int)$requestDados["trimestre"],
"classe_id"=>(int)$request->classe],
['Estado1'=>$lock,
'EstadoView'=>$eye??null
]);
}
else{
    divisaoestado::updateOrCreate(["divisao_id"=>(int)$requestDados["trimestre"],
"classe_id"=>(int)$request->classe],
['Estado2'=>$lock,
'EstadoView'=>$eye??null
]);
}





   }
}



public function declaracao($id,$trimestre,$classe,$ano){



// dd($id,$trimestre,$classe,$ano);

$conf= DB::table("config")->first();

$anolectivodados= DB::table("anolectivometadata")->where("anolectivo_id",$ano)
->get();

$informacaoudeclracao="";

if($trimestre!=10000){
$informacaoudeclracao=$anolectivodados->where("anomodelo_id",$trimestre);
}






$html="registoAcademico.Documentos.".$conf->NomePasta.".declaracao-notas";
if($trimestre==1000){
$html="registoAcademico.Documentos.".$conf->NomePasta.".certificado-notas";
}
$request =Request();
    $host = $request->getHost();

    $subdomain = explode('.', $host)[0];
$direcao=DB::table("classe_direcao")->where("classe_id",$classe)->first();

    if(empty($direcao)){
        return view("include.mensage-alerta",["mensagem"=>"a direcao da Classe nao Definida Directo/Pedagogio"]);
    };

$director=User::where("id",$direcao->director_id)->first();
$nivel=DB::table("nivel")->where("id",$director->Nivel_id)->first()->Descricao;

// dd($direcao,$director,$nivel);
$aluno=DB::table("alunosescritos")->where("idAlunoclasse",$id)->first();
$alunoOutrosDados=DB::table("turmasalunosview")->where("aluno_classe_id",$id)->first();
$dadosnota=DB::table("visaonotas")->where("id",$id)->get();
// dd($alunoOutrosDados,$aluno);
if($trimestre==10000){
  $dadosnota=$dadosnota->where("nota_meta_id",100);
}
elseif($trimestre==1000){

 $dadosnota=$dadosnota->where("nota_meta_id",9000);
}
else{

    $dadosnota=$dadosnota->where("nota_meta_id",0)->
where("divisao_id",$trimestre);
}



 return view($html,compact('conf','subdomain','director','nivel','aluno','informacaoudeclracao','dadosnota','alunoOutrosDados','trimestre'));





}


public function certificado(){

$conf= DB::table("config")->first();




$html="registoAcademico.Documentos.".$conf->NomePasta.".certificado-notas";
$request =Request();
    $host = $request->getHost();

    $subdomain = explode('.', $host)[0];


 return view($html,compact('conf','subdomain'));





}





// painel de Documentos area  que pode ser impressa todas as notas


public function PainelDocumetos($ano=null){

$anosel = $ano ?? Carbon::now()->year;


//  $classe_direcao=DB::table('classe_direcao')->where("classe_id",$classe)->where("anolectivo_id",$ano)->first();
 $classe_direcao=DB::table('classe_direcao')
 ->where("director_id",auth()->user()->id)
 ->OrWhere("pedagogico_id",auth()->user()->id)
 ->get();

 $anolectivo=collect();
 $classe=collect();
 if(auth()->user()->roles->where("name","Admin")->first()){
$classe=classe::all();
$anolectivo=anolectivo::all();
 }
 else{
$classe= classe::whereIn("id",$classe_direcao->pluck("classe_id")->toArray())->get();
$anosel = $ano ?? Carbon::now()->year;

$anolectivo = Anolectivo::whereIn("id",$classe_direcao->pluck("anolectivo_id")->toArray())
->orderBy('id', 'desc')->get();

 }
$trimestres=DB::table("anolectivometadata")->get();
return view("registoAcademico.notas.PainelControlNotasDocumentos",compact('anolectivo','classe','trimestres'));

}


}
