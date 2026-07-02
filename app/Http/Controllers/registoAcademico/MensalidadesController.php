<?php

namespace App\Http\Controllers\registoAcademico;

use App\Http\Controllers\Controller;
use App\Models\registoAcademico\Aluno;
use App\Models\registoAcademico\alunoClasse;
use App\Models\registoAcademico\anolectivo;
use App\Models\registoAcademico\classe;
use App\Models\registoAcademico\Doenca;
use App\Models\registoAcademico\grauparentesco;
use App\Models\registoAcademico\mensalidade;
use App\Models\registoAcademico\meses;

use App\Models\registoAcademico\profissao;
use App\Models\registoAcademico\religiao;
use App\Models\role;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use GuzzleHttp\Promise\Create;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use PhpParser\Node\Expr\Cast\Object_;
use PhpParser\Node\Stmt\Foreach_;
use App\Imports\alunosImport;
use App\Imports\mensalidadesImport;
use App\Models\Admin\observadorSys;
use App\Models\registoAcademico\outros_pagamentos;
use Maatwebsite\Excel\Facades\Excel;
// use App\Services\MpesaService;
class MensalidadesController extends Controller
{






    /**
     * Display a listing of the resource.
     * public function __construct()
    {
       $this->MpesaService=$MpesaService;
    }
     * @return \Illuminate\Http\Response
     */

protected $MpesaService;
    protected $religiao;
    protected $profissao;
    protected $doencas;
    protected $classes;
    protected $grauparentesco;
    protected $alunosInscritos;
    protected $Alunocontroller;

    public function  __construct(
        religiao $religiao,
        profissao $profissao,
        Doenca $doencas,
        classe $classe,
        grauparentesco $grauparentesco,
        Aluno $alunosInscritos,
        // MpesaService $MpesaService,
        alunosController $Alunocontroller
    ) {
        $this->religiao = $religiao;
        $this->profissao = $profissao;
        $this->doencas = $doencas;
        $this->classes = $classe;
        $this->grauparentesco = $grauparentesco;
        $this->alunosInscritos = $alunosInscritos;
        // $this->MpesaService = $MpesaService;
        $this->Alunocontroller=$Alunocontroller;


    }
    public function index()
    {
         if(auth()->user()->can('Registar-Mensalidades')):
        $alunosInscritos = Aluno::all();;

        return view("registoAcademico.mensalidade-index", compact('alunosInscritos'));
        ('aluno.mensagemAlerta');

         else:
            $mensagem ="nao possue a permissao de registar mensalidades 1";
return view("Componetes.alerta-Falha",compact('mensagem'));
         endif;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, $mesidselect)
    {
        if(auth()->user()->can('Registar-Mensalidades')):
$ano=carbon::now()->year;



      //  $dadostrimestre = DB::table('anolectivometadata')->where('anomodelo_id', $mesid)->first();

        $dadostrimestre= collect( DB::select('CALL  formadepagamentos(?)',[$ano]))->where('Descricao',$mesidselect)->first();
        $mes=$dadostrimestre->Descricao;
        $mesid = $dadostrimestre->id;
        $messes = collect( DB::select('CALL  formadepagamentos(?)',[$ano]));


        $aluno = DB::table('mensalidadesollshow')->where('Aluno_classe_id', $id)->first();
        $alunoMesalidade = DB::table('mensalidadesview')->where('aluno_classe_id', $id)->get();


        $valorMensalidade = DB::table('tabelavaloresano')
            ->where('classId', $aluno->classe_id)
            ->where('Finalidade', "Mensalidades")
            ->where('idanolectivo', $aluno->anolectivo_id)
            ->first();
if(empty($valorMensalidade)){
   // dd($aluno);
    $mensagem="Nao foi encontrado  o
    custo da mensalidade para ".$aluno->classe."  do ano ".$aluno->anolectivo." configure a tabela de valores por favor";
    return view('include.mensage-alerta',compact("mensagem"));
}

        if (empty($alunoMesalidade[0])) {
            $alunoMesalidade = collect();
            for ($x = 1; $x < 13; $x++) {
                $mes = meses::where('id', $x)->first();
                $alunoMesalidade->push([
                    'mes_id' => $x, "Aluno_classe_id" => $id, "Estado" => "Não Pago",
                    "anolectivo_id" => $aluno->anolectivo_id,
                    "anolectivo" => $aluno->anolectivo,
                    "idtabelavalores" => $valorMensalidade->idtabelavalores,
                    "valorDescricao" => $valorMensalidade->valorDescricao,
                    "classe_id" => $aluno->classe_id,
                    "nome" => $aluno->nome,
                    "id" => $aluno->id,
                    "mes" => $mes->Descricao
                ]);
            }
        } else {
            $alunoMesalidades2 = collect();
            foreach ($alunoMesalidade as $alunoMesalidadeItem) {

                $alunoMesalidades2->push([
                    'mes_id' => $alunoMesalidadeItem->mes_id, "Aluno_classe_id" => $id, "Estado" => $alunoMesalidadeItem->Estado,
                    "anolectivo_id" => $aluno->anolectivo_id,
                    "anolectivo" => $aluno->anolectivo,
                    "idtabelavalores" => $valorMensalidade->idtabelavalores,
                    "valorDescricao" => $valorMensalidade->valorDescricao,
                    "classe_id" => $aluno->classe_id,
                    "nome" => $aluno->nome,
                    "id" => $aluno->id,
                    "mes" => $alunoMesalidadeItem->mes
                ]);
            }
            $alunoMesalidade = $alunoMesalidades2;
        }




$metodos= DB::table('metodo_pagamento')->get();


        return view("registoAcademico.mensalidade-pagar", compact(
            'aluno',
            'mesid',
            'mes',
            'messes',
            'alunoMesalidade',
            'valorMensalidade',
            'mesid',
            'metodos',
            'dadostrimestre'
        ));
    else:
        $mensagem ="nao possue a permissao de registar mensalidades 2";
return view("Componetes.alerta-Falha",compact('mensagem'));
     endif;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)


    {

        if(auth()->user()->can('Visualizar-Mensalidades')):
        $aluno = DB::table('mensalidadesollshow')->where('Aluno_classe_id', $id)->first();
        $meses = DB::table('meses')->get();
        $Valores_pago = DB::table('mensalidadesview')->where('aluno_classe_id', $id)->get();



        //dd($aluno);





        return view(
            "registoAcademico.mensalidades-todas",
            compact('aluno', 'meses', 'Valores_pago')
        );

    else:
        $mensagem ="nao possue a permissao de registar mensalidades 3";
return view("Componetes.alerta-Falha",compact('mensagem'));
     endif;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   public function atualizarMensalidade(Request $request, $id)
{$x=0;

 $dadosmese = collect($request->meses);
 $ano = anolectivo::where("anolectivo", $dadosmese[0]["ano"])->first();


 $talaoNumero=$this->talao($request->metodo, $ano->id);
  $alunoid = DB::table("alunosescritos")->where("idAlunoclasse", $id)->first();

if($dadosmese->contains(fn($e) => $e['valor'] == 'Reverter')){
    foreach($dadosmese as $Item ):
     $ano = anolectivo::where("anolectivo", $dadosmese[0]["ano"])->first();
     $tipoId = DB::table("detalhestabelavaores")
            ->where("anolectivo_id", $ano->id)
            ->where("classe_id", $alunoid->Classe_id)
        ->where("tipo", $Item["idtipo"])
            ->first();



             outros_pagamentos::where( "aluno_classe_id",$id)
        -> where("mes_id",$Item["mesId"])
        ->where("tipo_pagamento_id",$tipoId->id)
        ->update([
            "Estado" => "Não pago",
            "referencia"=>null,
            "multaActiva" => 0,
            "Multa" =>0,
              "usuario_Registou" => auth()->user()->id,
                    "data_pagamento"=>Carbon::now(),
                      "metodo_pagamento_id" =>null,
                      "Ntalao"=>null

        ]);
    endforeach;
     $mesedado= "Reverteu o mes" . $Item["mes"];
          $this->observador($id,$Item["tipo"],$mesedado);

 return ["estado"=>"INS-0","messagem"=>"Reversao Com sucesso",'idaluno' => $id,
         'anolectivo' => $ano->id,"talao"=>null,"metodo"=>null];

};

    $finalidade = collect($request->meses)->unique('tipo')->pluck('tipo')->implode(',');
    $Referenciadepagamento = null;

        $dadosMes=[];
    $metodo=DB::table("metodo_pagamento")->where("id",$request->metodo)
->first();


    // dd($alunoid);


//  dd($talaoNumero,$request->all());



    if ($request->metodo == 2) {
        // $resultDO =$this->MpesaService->sendPaymentRequest("matricula","258".$request->numero,(float)$request->totalApagar,"matricula");
 $resultDO  = new mpesaController();
//  dd("Pagamento",$request->numero,$request->totalApagar,$talaoNumero,$request->all());
 $resul=$resultDO->Mpesapagamento("Pagamento",$request->numero,(float)$request->valor,$talaoNumero);

 IF($resul["INS"]!="INS-0"){


 return ["estado"=>$resul["INS"],"messagem"=>$resul["Descricao"]];
 }
$Referenciadepagamento=$resul["Referencia"];
        }


    if (isset($request->Referencia)) {
        $Referenciadepagamento = $request->Referencia;
    }


    $tipopagamentos = $dadosmese->unique("idtipo")->pluck('idtipo')->toArray();
    $meses = $dadosmese->unique("mesId")->pluck('mesId')->toArray();
    $dadosMUlta = $dadosmese->where("multa", ">", 0)->pluck('mesId')->toArray();

    // $alunoid = alunoClasse::where("id", $id)->first();


    foreach ($dadosmese as $Item) {
        $tipoId = DB::table("detalhestabelavaores")
            ->where("anolectivo_id", $ano->id)
            ->where("classe_id", $alunoid->Classe_id)
        ->where("tipo", $Item["idtipo"])
            ->first();

            $Item["multa"]=($Item["valor"]-$tipoId->valorDescricao);
        //  dd(  $tipoId,$Item );


// dd($Item["idtipo"]);
             if($metodo->tipo >0):

        outros_pagamentos::where( "aluno_classe_id",$id)
        -> where("mes_id",$Item["mesId"])
        ->where("tipo_pagamento_id",$tipoId->id)
        ->update([
            "referencia"=>$Referenciadepagamento,
            "multaActiva" => $Item["multa"] > 0 ? 1 : 0,
            "Multa" => $Item["multa"],
              "usuario_Registou" => auth()->user()->id,
                    "data_pagamento"=>Carbon::now(),
                      "metodo_pagamento_id" => $metodo->id,
                      "Ntalao"=>$talaoNumero]);

 else:
        outros_pagamentos::where( "aluno_classe_id",$id)
        -> where("mes_id",$Item["mesId"])
        ->where("tipo_pagamento_id",$tipoId->id)
        ->update([
            "Estado" => "Pago",
            "referencia"=>$Referenciadepagamento,
            "multaActiva" => $Item["multa"] > 0 ? 1 : 0,
            "Multa" => $Item["multa"],
              "usuario_Registou" => auth()->user()->id,
                    "data_pagamento"=>Carbon::now(),
                      "metodo_pagamento_id" => $metodo->id,
                      "Ntalao"=>$talaoNumero

        ]);

endif;

 $mesedado= $Item["multa"] > 0 ? $Item["mes"]." Com multa" : $Item["mes"];
          $this->observador($id,$Item["tipo"],$mesedado);


    }





         return ["estado"=>"INS-0","messagem"=>"Pagamenento Com sucesso",'idaluno' => $id,
         'anolectivo' => $ano->id,"talao"=>$talaoNumero,"metodo"=>$request->metodo];






}

    public function update($id, Request $request)
    {
    }



public function observador($aluno, $modelo, $tipoOperacao)
{
    // $tipoOperacao="create";
    //$modelo="Aluno";
    $usuario = auth()->user()->id;
    observadorSys::updateOrCreate(['user_id' => $usuario, 'action' => $tipoOperacao, 'register' => $aluno,
        'model' => $modelo], ['user_id' => $usuario, 'action' => $tipoOperacao, 'register' => $aluno, 'model' => $modelo]);

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
    public function getestadoMensalidade($classeAlunoId, $mesid)
    {
        $resultado = "";
        $resultado = mensalidade::where('aluno_classe_id', $classeAlunoId)->where('mes_id', $mesid)->first();
        if ($resultado) {
            $resultado = $resultado->Estado;
        } else {
            $resultado = "Não Pago";
        }

        return $resultado;
    }


    public function todasMensalidades(Request $request,$id)
    {
 $usuario_atualizou=auth()->user()->id;

 $ano = DB::table('mensalidadesview')->
where('aluno_classe_id', $request->idclass)->first();


 $mes= collect( DB::select('CALL  formadepagamentos(?)',[$ano->anolectivo]));

 //dd($request);

 $valormultaApagar=0;
$metodo= DB::table('metodo_pagamento')->where('Descricao',$request->tipopagamento)->first();

        foreach ($mes as $x=>$mesItem) {

            $resultado = mensalidade::where('aluno_classe_id', $request->idclass)
            ->where('mes_id', $mesItem->id)->first();
            $posicao="options".$x+1;
            $posicaomulta="multaactiva".$x+1;
            $estado= $request["".$posicao.""];
            $multa= $request["".$posicaomulta.""];
           // dd($multa);

if($multa==1){
$valormultaApagar = (($ano->valorDescricao)*(($ano->multaP)/100));
}
else{
    $valormultaApagar=0;
}



            if ($resultado) :
if($resultado->Estado!="Pago"):
                mensalidade::where('aluno_classe_id', $request->idclass)->where('mes_id', $x + 1)
                    ->update([
                        "aluno_classe_id" => $request->idclass,
                        "mes_id" => $mesItem->id,
                        "metodo_pagamento_id" =>$metodo->id ,
                        "metodo_pagamento" =>$metodo->id ,
                        'data_pagamento'=>Carbon::now(),
                        "Estado" =>$estado,
                        'Multa'=> $valormultaApagar,
                        "usuario_atualizou"=>$usuario_atualizou
                    ]);

                endif;

            else :
                mensalidade::create([
                    "aluno_classe_id" => $request->idclass,
                    "mes_id" => $mesItem->id,
                    "Estado" =>$estado,
                    "metodo_pagamento_id" =>$metodo->id ,
                    "metodo_pagamento" =>$metodo->id ,
                    'Multa'=> $valormultaApagar,
                    'data_pagamento'=>Carbon::now()
                ]);



            endif;
        }




//break;
       return $this->imprimirTodasMensalidadesAluno($id,0);
    }



    public  function imprimirTodasMensalidadesAluno($id, $flag)
    {

        $aluno = DB::table('mensalidadesollshow')->where('Aluno_classe_id', $id)->first();
        $meses = DB::table('meses')->get();
        $Valores_pago = DB::table('mensalidadesview')->where('aluno_classe_id', $id)->get();


        if ($flag == 0) :

            return  view("registoAcademico.mensalidadespagas", compact('aluno', 'meses', 'Valores_pago'));
        else :
            $pdf = PDF::loadView("registoAcademico.mensalidadespagas", compact('aluno', 'meses', 'Valores_pago'))->setPaper('a5');

            return $pdf->download("mensalidadesdoaluno" . Carbon::now() . ".pdf");
        endif;
    }



    public function imprimirmesMensalidade($id,$mes)
    {

       // dd($mes);
        $aluno=alunoClasse::where('id',$id)->first();
      //  dd($aluno);
      $ano=carbon::now()->year;

      $mes= collect( DB::select('CALL  formadepagamentos(?)',[$ano]))->where('id',$mes)->first();




$dadosmes=DB::table('mensalidadesview')->where('Aluno_classe_id', $id)
->where("mes_id",$mes->id)
->first();;

$data=$dadosmes->data_pagamento;
$dadoTabelavalores = DB::table('tabelavaloresano')
->where('classId', $dadosmes->classe_id)
->where('idanolectivo', $dadosmes->anolectivo_id)->where('Finalidade', 'Mensalidades')->first();


        return  view("registoAcademico.recibo-mes",compact('dadosmes','data','dadoTabelavalores'));
    }

    // 3/16/2021
    /**
     * metodo que retorna mensalidades de um dado mes para que sejam pagas
     */

    public function TodosAlunosMensalidadede()
    {

        $carbon = Carbon::now()->format('Y');
        $anolectivos = anolectivo::all();
       // $meses=DB::table('anolectivometadata')
       // ->where('anolectivo', $carbon)->get();  $anolectivos = anolectivo::all();
       $ano=carbon::now()->year;
        $meses=DB::select('CALL  formadepagamentos(?)',[$ano]);
        $mesatual=collect( DB::select('CALL  verifcar_mes(?)',[Carbon::now()]))->first();
       // ->where('anolectivo', $carbon)->get();


    //    dd($meses);
        return view("registoAcademico.mensalidade-select-mes", compact('anolectivos','meses','mesatual'));
    }


    public function Mensalidademes($id, $ano)
    {
        $data = Carbon::now()->format('Y-m-d');
        $nome = Carbon::create($data)->monthName;
        $mes = ucwords($nome);

// precisa rever se isso
$anod=carbon::now()->year;

$mes= collect( DB::select('CALL  formadepagamentos(?)',[$anod]))->where('id',$id)->first();
$mesatual= collect( DB::select('CALL  verifcar_mes(?)',[Carbon::now()]))->first();



        $Aluno = DB::table('mensalidadesview')->where('anolectivo_id', $ano)
       -> where('mes_id',$id)
       ->orderBy('classe','asc')
        ->orderBy('turma','asc')
       ->orderBy('nome','asc')
       ->get();


 $id=$mes->Descricao;
 $iddados=$mes->id;

        return view('registoAcademico.mensalidade-mes-ano-select',
            compact('id', 'ano', 'Aluno', 'mes','iddados','mesatual')
        );
    }





    public function verMensalidadesMes($id_class_aluno, $mes)
    {
        $resut =  mensalidade::where('aluno_classe_id', $id_class_aluno)->where('mes_id', $mes)->first();;
        if (!empty($resut)) {
            echo $resut->Estado;
        } else {
            echo "Não Pago";
        }
    }



    public function todasMensalidadestodos()
    {
        $claases = classe::all();
        $anos = anolectivo::all();

        return view('registoAcademico.todas-mensalidade', compact('claases', 'anos'));
    }


    public function todasMensalidadestodosSelect($ano, $classe = null)
    {

        $arraymensalidades = DB::table('mensalidadesollshow')->where('anolectivo_id', $ano)->get();


        return view("registoAcademico.Alunos-mensalidadestodas", compact('arraymensalidades'));
    }




    // pressesar resultado de cada mes
    public function mesmensalidadeget($mesid, $classAlunoid)
    {
        $mesmensalidade = mensalidade::where(
            'aluno_classe_id',
            $classAlunoid
        )->where("mes_id", $mesid)->get('estado')->first();
        $Estado = "";
        if ($mesmensalidade) {
            $Estado =  $mesmensalidade->estado;
        } else {
            $Estado = "Não Pago";
        }
        return $Estado;
    }



    // relatio de mensalidades

    public function Relatorio()
    {

        $anolectivos = DB::select("SELECT * FROM anolectivos ORDER BY id DESC");
        $classes = DB::table('classes')->get();
        return view("registoAcademico.relatorio-mensalidades", compact('anolectivos', 'classes'));
    }



    public function RelatorioAnoClasse($ano, $classe)
    {




        $arrayrelatorio = array();
        $meses = DB::table('meses')->get();

        foreach ($meses as $mesesIem) {


            $relatoriomes=DB::select("call relatorioGenerico(?,?,?)",[$classe,$ano,$mesesIem->id]);






            array_push($arrayrelatorio, [
                "mes" => $mesesIem->Descricao,
                'NrAlunos' => $relatoriomes[0]->NrAlunos,
                'tranferencias' => $relatoriomes[0]->tranferencias,
                'disistentes' => $relatoriomes[0]->disistentes,
                'qtdQpagar' => $relatoriomes[0]->qtdQpagar,
                "mesId" => $mesesIem->id,
                'alunoscommulta' => $relatoriomes[0]->alunoscommulta,
                'valorpagoMensalidades' => $relatoriomes[0]->valorpagoMensalidades,
                'valorpagodemulta' => $relatoriomes[0]->valorpagodemulta,
                'total' => $relatoriomes[0]->total,
            ]);
        }

        //$arrayrelatorio=json_encode($arrayrelatorio);
        return view("registoAcademico.relatorio-ano-classe", compact(
            'arrayrelatorio',
            'ano',
            'classe'
        ));
    }








    public function Relatoriodetalhado($ano, $classe, $mes)
    {



        $relatorioDetalhado = DB::table('mensalidadesview')
            ->leftjoin('turmasview', 'mensalidadesview.aluno_classe_id', '=', 'turmasview.aluno_classe_id')
            ->leftjoin('tranferencias_disistencias', 'mensalidadesview.aluno_classe_id', '=', 'tranferencias_disistencias.aluno_classe_id')
            ->select('mensalidadesview.*', 'turmasview.turmas', 'turmasview.turma_id', 'tranferencias_disistencias.tipo_id')
            ->where('mensalidadesview.anolectivo_id', $ano)
            ->where('mensalidadesview.mes_id', $mes)
            ->where('mensalidadesview.classe_id', $classe)
            ->get();



        return view("registoAcademico.relatorio-mensalidaders-detalhado-mes", compact('relatorioDetalhado'));
    }









    public function pagamentosIndex()
    {

        $ano =  DB::select("SELECT  * from anolectivos  order by(id) desc");
        $classe =  DB::select("SELECT  * from classes");


        $data = Carbon::now()->format('m/d/') . "20" . Carbon::now()->format('y');



        return view("registoAcademico.relatoriospagamentos.relatorio-pagamentos-index", compact('classe', 'ano', 'data'));
    }




    public function pagamentos( $ano,$classe, $data1, $data2)
    {


$data=Carbon::create($data1)->format('Y-m-d');
$collecao2=collect();
$collet= collect();
$dados=collect();
$periodo = CarbonPeriod::create($data1, $data2);
$classessizeS=1;
 foreach($periodo as $periodoItem):


if($classe!=0):
    $classessizeS=1;
    $collet->push(DB::select('call selecionarMensalidade(?,?,?)'
    ,[$periodoItem,$ano,$classe]));

    foreach(  $collet as   $colletItem):
//$dados->push(['Data'=>$periodoItem->format('Y-MM-d'), 'dados'=>$colletItem]);
    endforeach;
else:

    $classessizeS=classe::all()->count();
    foreach(classe::all() as $classesItem)
    $collet->push(DB::select('call selecionarMensalidade(?,?,?)'
    ,[$periodoItem,$ano,$classesItem->id]));
endif;
 endforeach;

foreach($collet as $colletItem){

    foreach( $colletItem as $collectItem2):
$collecao2->push( [
    "classes"=>  $collectItem2->classes_id,
    "classes_id"=>  $collectItem2->classes,
    "NUmerAlunos"=> $collectItem2->NUmerAlunos
    ,"data_pagamento"=> $collectItem2->data_pagamento
    ,"tipopagamento"=> $collectItem2->tipopagamento
    ,"NUmerMeses"=> $collectItem2->NUmerMeses
    ,"Mensaldade"=> $collectItem2->Mensaldade
    ,"subtotalmensalidade"=>$collectItem2->subtotalmensalidade
    ,"NUmerMulta"=> $collectItem2->NUmerMulta
    ,"Multavalor"=> $collectItem2->Multavalor
    ,"SubtotalMultas"=> $collectItem2->SubtotalMultas
]);
endforeach;
}


$metodosPagamentos=DB::table('metodo_pagamento')->get();

// dd($collecao2);
  return view('registoAcademico.relatoriospagamentos.pagamentos', compact('collet','classessizeS','metodosPagamentos'));

    }


    public function prencher()
    {
        $dados = DB::table('aluno_classes')
            ->where('anolectivo_id', 8)
            ->where('classe_id', 8)
            ->get();

        foreach ($dados as $dadosItem) {
            for ($x = 1; $x < 13; $x++) {
                mensalidade::insert(['Estado' => 'Não pago', 'mes_id' => $x, 'aluno_classe_id' => $dadosItem->id]);
            }
        }
    }



    public function mensalidadesGuardar($request, $id, $referencia)
    {

        $usuario_atualizou=auth()->user()->id;

        $dadoTabelavalores="";
        for ($x = 0; $x < count($request->mesid); $x++) {
            $dadoTabelavalores="";
$itemmesid=$request->mesid[$x];
            $dadosmes = DB::table('mensalidadesview')->where('aluno_classe_id', $id)->where('mes_id', $itemmesid)->first();
            $usuario = auth()->user()->id;

            if (empty($dadosmes)) {
                mensalidade::create(["aluno_classe_id" => $id, "mes_id" => $itemmesid, "Estado" => "Não pago",
                 "usuario_Registou" => $usuario]);
            }

            $dadosmes = DB::table('mensalidadesview')->where('aluno_classe_id', $id)->where('mes_id', $itemmesid)->first();



            $dadoTabelavalores = DB::table('tabelavaloresano')
                ->where('classId', $dadosmes->classe_id)
                ->where('idanolectivo', $dadosmes->anolectivo_id)->where('Finalidade', 'Mensalidades')->first();

            $ano = carbon::now()->year;

           // dd($dadosmes->mes_id);


           // $dadosdedata=DB::table('anolectivometadata')->where('anomodelo_id',$dadosmes->mes_id)->first();


            $dadosdedata= collect( DB::select('CALL  formadepagamentos(?)',[$dadosmes->anolectivo]))
            ->where('id',$dadosmes->mes_id)->first();
            $datalimite = $dadosdedata->Fim;

            $data1 = carbon::create($datalimite);
            $data2 = carbon::now();

            // multa a se pagar
            $multa = 0;
            // verificar se existem multa

            if ((carbon::now() > carbon::create($datalimite)) && ($request->estado[$x] == 'Pago')) {

                if ($request->multaactiva == 1) {
                    $multa = ($dadoTabelavalores->valorDescricao) * ($dadoTabelavalores->multaP/100);
                }
            }


            $dadosmetodopagamento = DB::table('metodo_pagamento')
                ->where('Descricao', $request->tipopagamento)->first();

            $dadoselect=mensalidade::where("mes_id",$request->mesid[$x])
            ->where( "aluno_classe_id", $id)->first();

            if(empty( $dadoselect)):
            mensalidade::create(
                    ["data_pagamento"=>carbon::now(),
                        "aluno_classe_id" => $id,
                        "mes_id" => $request->mesid[$x],
                        "multa" => $multa,
                        "Estado" => $request->estado[$x],
                        "metodo_pagamento_id" => $dadosmetodopagamento->id,
                        "metodo_pagamento" => $dadosmetodopagamento->id,
                        "usuario_Registou"=>auth()->user()->id,
                        "referencia" => $referencia,
                        'usuario_atualizou'=> $usuario_atualizou,

                    ]

            );

        else:
           mensalidade::where("mes_id",$request->mesid[$x])
            ->where( "aluno_classe_id", $id)->update(
                    [
                        "multa" => $multa,
                        "Estado" => $request->estado[$x],
                        "metodo_pagamento_id" => $dadosmetodopagamento->id,
                        "metodo_pagamento" => $dadosmetodopagamento->id,
                        "referencia" => $referencia,
                        'usuario_atualizou'=> $usuario_atualizou
                    ]

            );

            $dadosselecionado= mensalidade::where("mes_id",$request->mesid[$x])
            ->where( "aluno_classe_id", $id)->first();

            if($dadosselecionado->data_pagamento==""){
                $dadosselecionado= mensalidade::where("mes_id",$request->mesid[$x])
            ->where( "aluno_classe_id", $id)->update(
                    ["data_pagamento"=>carbon::now(),
                        "multa" => $multa,
                        "Estado" => $request->estado[$x],
                        "metodo_pagamento_id" => $dadosmetodopagamento->id,
                        "metodo_pagamento" => $dadosmetodopagamento->id,
                        "referencia" => $referencia,
                        'usuario_atualizou'=> $usuario_atualizou
                    ]

            );

            }
        endif;










        }





    }

    function verificarsepoderreverter($permisao){
        $flagAtualizar=0;
        $idflaatualizar=auth()->user()->id;
        $usuario=User::where('id',$idflaatualizar)->with('roles')->first();


        foreach($usuario->roles as $Item){
            $resultado=0;;
        if($Item->id==1){
      $resultado= 1;
      break;

        }
        else{$permissione=role::where('id', $Item->id)->with('permission')->first();;
            foreach($permissione->permission as $dado){
                if($dado->name==$permisao){
                    $resultado= 1;
                    break;
                }
                else{
                    $resultado=0;
                }

            }

        }

        }
   return $resultado; }


    public function pagamentostodosMesesIndex($id){

$perimsadereverter=$this->verificarsepoderreverter('Reverter-Mensalidade');

        $mensalidadeAluno= DB::table('mensalidadesview')->where('aluno_classe_id',$id)->get();
        $mesdados=collect(DB::select('CALL  formadepagamentos(?)',[$mensalidadeAluno[0]->anolectivo]));



        return view('registoAcademico.mensalidade-pagartodosmeses', compact('mensalidadeAluno',
        'perimsadereverter','mesdados'));

    }

    public function pagamentosprint( $ano,$classe, $data1, $data2)
    {


        $metodosPagamentos=DB::table('metodo_pagamento')->get();
$data=Carbon::create($data1)->format('Y-m-d');
$collecao2=collect();
$collet= collect();
$periodo = CarbonPeriod::create($data1, $data2);
$classessizeS=1;
 foreach($periodo as $periodoItem):


if($classe!=0):
    $classessizeS=1;
    $collet->push(DB::select('call selecionarMensalidade(?,?,?)'
    ,[$periodoItem,$ano,$classe]));
else:

    $classessizeS=classe::all()->count();
    foreach(classe::all() as $classesItem)
    $collet->push(DB::select('call selecionarMensalidade(?,?,?)'
    ,[$periodoItem,$ano,$classesItem->id]));
endif;
 endforeach;

foreach($collet as $colletItem){

    foreach( $colletItem as $collectItem2):
$collecao2->push( [
    "classes"=>  $collectItem2->classes_id,
    "classes_id"=>  $collectItem2->classes,
    "NUmerAlunos"=> $collectItem2->NUmerAlunos
    ,"data_pagamento"=> $collectItem2->data_pagamento
    ,"tipopagamento"=> $collectItem2->tipopagamento
    ,"NUmerMeses"=> $collectItem2->NUmerMeses
    ,"Mensaldade"=> $collectItem2->Mensaldade
    ,"subtotalmensalidade"=>$collectItem2->subtotalmensalidade
    ,"NUmerMulta"=> $collectItem2->NUmerMulta
    ,"Multavalor"=> $collectItem2->Multavalor
    ,"SubtotalMultas"=> $collectItem2->SubtotalMultas
]);
endforeach;
}


// dd($collecao2);
  return view('registoAcademico.relatoriospagamentos.pagamentosPrint',
  compact('collet','classessizeS',"periodo",'metodosPagamentos'));

}

public function uplodefileMensalidades(Request $request){

       $dadosrelatorio= Excel::import(new mensalidadesImport, $request->file('file'));
     $dados= request()->cookie('minha_colecao_cookie');


     return redirect()->back();




    }


public function talao($metodo, $ano)
{
    $metodoPagamento = DB::table('metodo_pagamento')
        ->select('id', 'tipo')
        ->where('id', $metodo)
        ->first();

    if (!$metodoPagamento) {
        return null;
    }

    $anoAtual = Carbon::now()->format('y');

    /*
    |-----------------------------------------
    | BUSCAR ÚLTIMOS TALÕES
    |-----------------------------------------
    */

    $ntalaoOutro = DB::table('outros_pagamentosview')
        ->where('Estado', 'Pago')
        ->whereNotNull('Ntalao')
        ->where('anolectivo_id', $ano)
        ->orderByRaw('CAST(Ntalao AS UNSIGNED) DESC')
        ->value('Ntalao');

    $ntalaoAluno = alunoClasse::where('Estado', 'activo')
        ->whereNotNull('Ntalao')
        ->where('anolectivo_id', $ano)
        ->orderByRaw('CAST(Ntalao AS UNSIGNED) DESC')
        ->value('Ntalao');

    $ultimoNtalao = max(
        (int) ($ntalaoAluno ?? 0),
        (int) ($ntalaoOutro ?? 0)
    );

    /*
    |-----------------------------------------
    | GERAR TALÃO
    |-----------------------------------------
    */

    if ($metodoPagamento->tipo > 0) {

        // Se talão inclui ano (EX: 260001)
        $sequencia = 0;

        if ($ultimoNtalao > 0) {
            $sequencia = (int) substr((string)$ultimoNtalao, 2);
        }

        $novoNumero = $sequencia + 1;

        $ntalao = $anoAtual . str_pad($novoNumero, 4, '0', STR_PAD_LEFT);

    } else {

        // Talão simples sequencial
        $novoNumero = $ultimoNtalao + 1;

        $ntalao = str_pad($novoNumero, 5, '0', STR_PAD_LEFT);
    }

    return $ntalao;
}





}
