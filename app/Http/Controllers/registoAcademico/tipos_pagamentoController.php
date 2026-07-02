<?php

namespace App\Http\Controllers\registoAcademico;

use App\Http\Controllers\Controller;
use App\Models\modelopagamento;
use App\Models\permission;
use App\Models\registoAcademico\Aluno;
use App\Models\registoAcademico\alunoClasse;
use App\Models\registoAcademico\anolectivo;
use App\Models\registoAcademico\classe;
use App\Models\registoAcademico\contacto;
use App\Models\registoAcademico\Doenca;
use App\Models\registoAcademico\encaregado;
use App\Models\registoAcademico\endereco;
use App\Models\registoAcademico\grauparentesco;
use App\Models\registoAcademico\mensalidade;
use App\Models\registoAcademico\meses;
use App\Models\registoAcademico\outros_pagamentos;
use App\Models\registoAcademico\profissao;
use App\Models\registoAcademico\religiao;
use App\Models\registoAcademico\tabela_valore;
use App\Models\registoAcademico\tipos_pagamentos;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use PhpParser\Node\Stmt\Return_;

class tipos_pagamentoController extends Controller
{

 public function NovoPagamento()
 {
    $dados= tipos_pagamentos::all();

     return view('registoAcademico.tipopagamento-create-novo',
     compact('dados'));
 }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     *
     *
     *
     */


     public function guardar(Request $request){

// dd($request->all());
   $idtipopagamento=    tipos_pagamentos::where('Descricao',strtoupper($request->nomePagamento))->first();
        if(!empty($idtipopagamento->id)){
            return redirect()->route('tipoPagamento.NovoPagamento');
        }
        else {
            if(!empty($request->nomePagamento)):
$daodoInserido=tipos_pagamentos::create(['Descricao'=>strtoupper($request->nomePagamento),"icon"=>$request->icon]);
            endif;
            $this->adicionarprevilegios( $daodoInserido->id);
   return redirect()->route('tipoPagamento.NovoPagamento');

        }
     }


   public function  atualizar( Request $request){
// dd($request->all());




    $daodoInserido=tipos_pagamentos::where('id',$request->id)
    ->update(['Descricao'=>strtoupper($request->nomePagamento),
"icon"=>$request->icon]);

$this->adicionarprevilegios( $request->id);
    return redirect()->route('tipoPagamento.NovoPagamento');

     }


     public  function apagar (Request $request){

        $dado=outros_pagamentos::where('tipo_pagamento_id',$request->id)->first();


        if((!empty($dado->id))&& $request->id<=3){
            echo "Nao pode ser Apagado este dado porque esta associado a certos Registos";
        }
        else{
        $tipoDesc=    tipos_pagamentos::where('id',$request->id)->first();
            $dadosInfo=DB::table('tabela_valores')->where('Descricao',$tipoDesc->Descricao)->first();


            if(isset($dadosInfo->Descricao)){
echo" Precisa Anates disvincular na tabela de presso";
            }
            else{
             tipos_pagamentos::where('id',$request->id)->delete();
             return redirect()->route('tipoPagamento.NovoPagamento');
            }
        }


     }




    public function adicionarprevilegios($tipoPagamento)
    {


        $tipopaga = tipos_pagamentos::where(column: "id", operator: $tipoPagamento)->first();



        $dados = modelopagamento::firstOrCreate(["tipo_pagameto_id"
        => $tipopaga->id, "Descricao" => $tipopaga->Descricao]);



        $arrayprefix = ["Visualizar", "RelatorioPagameto", "RelatorioGenerico", "Lista", "Efetuar", "Reverter"];
        $arrayprefixLabel = ["Visualizar pagamento de ", "Relatorio de Pagameto de pagamento de", "RelatorioGenerico de ", "Lista de pagamento de ", "Efetuar pagamento de ", "Reverter pagamento de "];


        for ($x = 0; $x < count($arrayprefix); $x++) {
            $name = ucfirst($arrayprefix[$x]) . "-" . $dados->Descricao;
            $labelstr = ucfirst($arrayprefixLabel[$x]) . " " . $dados->Descricao;

            permission::updateOrCreate(
                 ["name" => $name, "model_id" => $dados->id],
                values: ["label" => $labelstr]
            );
        }
        $dadopermission = DB::table("permissions")
            ->where("model_id", $dados->id)->pluck("id")->toArray();

        $dadopermission = json_encode($dadopermission);
        modelopagamento::where('tipo_pagameto_id', $tipoPagamento)->update(["detalhes" => $dadopermission]);

    }

     public function AtribuirAlunos(){
$anolectivo= anolectivo::orderBy("id",'Desc')->get();
     $dados=DB::table('detalhestabelavaores') ->orderBy("id",'Desc')->get();
     return view("registoAcademico.TabelaValores.atribuir-alunos",compact('dados','anolectivo'));

     }



//   public function BuscaralunosparaConfig(Request $request)
// {
//     $alunos = alunoClasse::where("anolectivo_id", $request->ano_id)
//         ->with(["aluno", "classe", "mensalidades", "turma.turma"])
//         ->get();

//         // $item->turma;


//     $data = [];

//     foreach ($alunos as $item) {


//         $estado = $item->mensalidades
//             ->where("tipo_pagamento_id", $request->tipo_id)
//             ->isNotEmpty()?"Gerado":"Pendente";
// $lock = $item->mensalidades
//             ->where("tipo_pagamento_id", $request->tipo_id)
//             ->where("Estado",'Pago')?"Bloqueiado":"DesBloqueiado";




//         $data[] = [
//             "bloqueio"=> $lock ,
//             "estado" => $estado,
//             "id" => $item->id,
//             "nome" => $item->aluno->nome ?? '',
//             "classe" => $item->classe->Descricao ?? '',
//             "turma" => $item->turma->turma->Descricao ?? '',
//         ];
//     }

//     return response()->json([
//         "data" => $data
//     ]);
// }


public function BuscaralunosparaConfig(Request $request)
{
    $alunos = alunoClasse::where("anolectivo_id", $request->ano_id)
        ->with(["aluno", "classe", "mensalidades", "turma.turma"])
        ->get();

    $data = [];

    foreach ($alunos as $item) {

        $mensalidade = $item->mensalidades
            ->where("tipo_pagamento_id", $request->tipo_id);

        $estado = $mensalidade->isNotEmpty()
            ? "Gerado"
            : "Pendente";

        $lock = $mensalidade

            ->isNotEmpty()
            ? "Bloqueado"
            : "";

        $data[] = [
            "bloqueio" => $lock,
            "estado" => $estado,
            "id" => $item->id,
            "nome" => $item->aluno->nome ?? '',
            "classe" => $item->classe->Descricao ?? '',
            "turma" => $item->turma->turma->Descricao ?? '',
        ];
    }

    return response()->json([
        "data" => $data
    ]);
}

  // No seu controlador (adicione este método se ainda não existir)
public function registar_pagamentos(Request $request)
{
    try {
        $alunoId = $request->id;
        $pagamentoId = $request->tipo_id;

        DB::transaction(function () use ($alunoId, $pagamentoId) {
            $aluno = alunoClasse::findOrFail($alunoId);

            $tabelaValores = DB::table('detalhestabelavaores')
                ->where('tipo', '>', 2)
                ->where('classe_id', $aluno->classe_id)
                ->where('anolectivo_id', $aluno->anolectivo_id)
                ->where('id', $pagamentoId)
                ->get();

            foreach ($tabelaValores as $item) {
                outros_pagamentos::updateOrCreate(
                    [
                        'aluno_classe_id' => $aluno->id,
                        'mes_id' => $item->mes,
                        'tipo_pagamento_id' => $item->id,
                    ],
                    [
                        'data_inicio' => $item->inicio,
                        'data_Fim' => $item->limite,
                        'deleted_at' => null,
                    ]
                );
            }
        });

        return response()->json(["success" => true]);
    } catch (\Exception $e) {
        return response()->json(["success" => false, "message" => $e->getMessage()], 500);
    }
}

}
