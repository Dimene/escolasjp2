<?php

namespace App\Http\Controllers\registoAcademico;

use App\Http\Controllers\Controller;
use App\Models\detalhestabelavalores;
use App\Models\registoAcademico\Aluno;
use App\Models\registoAcademico\alunoClasse;
use App\Models\registoAcademico\anolectivo;
use App\Models\registoAcademico\classe;
use App\Models\registoAcademico\Doenca;
use App\Models\registoAcademico\grauparentesco;
use App\Models\registoAcademico\mensalidade;
use App\Models\registoAcademico\meses;
use App\Models\modelmpesa;
use App\Models\modelmpesapay;
use App\Models\registoAcademico\outros_pagamentos;
use App\Models\registoAcademico\profissao;
use App\Models\registoAcademico\religiao;
use App\Models\registoAcademico\tabela_valore;
use App\Models\registoAcademico\tipos_pagamentos;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Barryvdh\DomPDF\PDF as DomPDFPDF;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\Can;
use PhpParser\Node\Stmt\Foreach_;
use Spatie\FlareClient\Http\Response;

use function Laravel\Prompts\select;

class outrospagamentoController extends Controller
{
    public function index()
    {

       // $lista = tipos_pagamentos::all();
        $lista=DB::table('tipos_pagamentos')->get();
       // dd($lista);

        $tipospagamento = DB::table('tipos_pagamentos')->where('id', '>', 2)
        ->where("tipo_janela",2)->get();


        $classes = classe::all();
        $meses = meses::all();

        $ano = anolectivo::all();
        return view('registoAcademico.outrosPagamento.outrospagamentos-create', compact(
            'tipospagamento',
            'classes',
            'meses',
            'ano'
        ));
    }

    public function tipospagamentosShow($ano,$classe){

 $tipospagamento = DB::table('detalhestabelavaores')
->where("tipo",">",2)
        ->where("anolectivo_id",$ano)
        ->where("classe_id",$classe)
        ->get();

    return  view("Componetes.componete-menum-pagamentosMeses", ["tipo"=>$tipospagamento]);

    }

    public function create(Request $request)
    {

        $dadosAlert = $request->contrato_pagamento;
        $dadosOutroPagamento = "";
        $dadosOutrosver = DB::table('outros_pagamentosview')
            ->where('tipoPagamento_id', $request->TipoPagamento_id)
            ->where('classe_id', $request->classe_id)
            ->where('anolectivo_id', $request->anolectivo_id)
            ->first();
        if (!empty($dadosOutrosver)) :
            if ($dadosOutrosver->mes_id != null) {
                $dadosAlert = 1;
                $dadosOutroPagamento =
                DB::select('SELECT  DISTINCT(mes_id) , outros_pagamentosview.mes, outros_pagamentosview.metodo_pagamento ,outros_pagamentosview.metodo_pagamento_id FROM   outros_pagamentosview WHERE  outros_pagamentosview.tipoPagamento_id=? AND outros_pagamentosview.classe_id=? AND outros_pagamentosview.anolectivo_id=?', [$request->TipoPagamento_id,$request->classe_id,$request->anolectivo_id]);


            } else {
                $dadosAlert = 2;
                $dadosOutroPagamento = DB::table('outros_pagamentosview')
                    ->where('tipoPagamento_id', $request->TipoPagamento_id)
                    ->where('classe_id', $request->classe_id)
                    ->where('anolectivo_id', $request->anolectivo_id)
                    ->where('mes', null)
                    ->distinct('data_inicio')
                    ->distinct('data_Fim')
                    ->get();
            }
        endif;


        return json_encode(["flag" => $dadosAlert, "dadosConfig" => $dadosOutroPagamento]);
    }

    public function  guardarConfiguracao(Request $request)
    {
        $id = auth()->user()->id;
        //dd($request->all());
        $alunos = DB::table('aluno_classes')->where('anolectivo_id', $request->anolectivo_id)
            ->where('classe_id', $request->classe_id)->get();


        // quando for por mes
        if ($request->contrato_pagamento == 1) {
           foreach ($alunos as $Item) {
                    for ($x = 1; $x < 12; $x++) {
                        $label = "check" . $x . "";
                        if (isset($request[$label])) {
                            outros_pagamentos::UpdateOrCreate([
                                'mes_id' => $x,
                                "tipo_pagamento_id" => $request->TipoPagamento_id,
                                "aluno_classe_id" => $Item->id
                            ],
                            [
                            'mes_id' => $x,
                            "tipo_pagamento_id" => $request->TipoPagamento_id,
                            "aluno_classe_id" => $Item->id
                        ]);

                    }
                }
            }
        }
        // quando for por data
        else {
            foreach ($alunos as $Item) {


                    outros_pagamentos::updateOrCreate([
                        'data_inicio' => $request->Data_inicio,
                        'data_Fim' => $request->Data_Fim,
                        "tipo_pagamento_id" => $request->TipoPagamento_id,
                        "aluno_classe_id" => $Item->id
                    ]);

            }
        }
        return  redirect()->route('outrosPagamento.show');
    }

    public function mostrarElementos($ano, $class, $tipoPagamento)
    {




        $alunos = DB::table('outros_pagamentosview')->where('tipoPagamento_id', $tipoPagamento)
            ->where('classe_id', $class)
            ->where('anolectivo_id', $ano)->first();


            $alunosClasses = DB::table('outros_pagamentosview')->where('tipoPagamento_id', $tipoPagamento)

            ->where('anolectivo_id', $ano)
            ->select('classe_id')
            ->distinct() ->pluck('classe_id') // Retorna apenas os valores da coluna "classe_id"
            ->toArray();



            $classes=classe::whereIn("id", $alunosClasses)->get();
        $limitedias = collect();
        $selecionado= Carbon::now()->month;
        $flegue = 0;
        if (!empty($alunos)) :
            if (!empty($alunos->mes_id)) {
                $limitedias = DB::table('outros_pagamentosview')->where('tipoPagamento_id', $tipoPagamento)
                    ->where('classe_id', $class)
                    ->where('anolectivo_id', $ano)->distinct('mes_id')->get(["mes_id", "mes"]);
                $flegue = 1;


            } else {
                $flegue = 2;
                $limitedias = DB::table('outros_pagamentosview')->where('tipoPagamento_id', $tipoPagamento)
                    ->where('classe_id', $class)
                    ->where('anolectivo_id', $ano)->distinct(['data_inicio', 'data_Fim'])->get(['data_inicio', 'data_Fim']);

 $selecionado = DB::table('outros_pagamentosview')->where('tipoPagamento_id', $tipoPagamento)
                    ->where('classe_id', $class)
                    ->where('anolectivo_id', $ano)
                    ->whereDate('data_inicio',"<=",Carbon::now()->format("Y-m-d"))
                    ->whereDate('data_Fim',">=",Carbon::now()->format("Y-m-d"))

                    ->first()->mes_id;

            }
        else :
            $flegue = 1;
            $limitedias->push(["mes_id" => 12, "mes" => " "]);
        endif;

$today = now()->toDateString(); // Gets current date in Y-m-d format




        return response()->json(["dadosTipo" => $flegue, 'datas' => $limitedias,"classes"=>$classes,'dataInicioselecionada'=>$selecionado]);

        // return view('registoAcademico\outrosPagamento\outros-pagamentoShow',compact('alunos'));

    }

  public function mostrarElementosDomes($ano, $class, $tipoPagamento, $data)
{
    // Buscar alunos
    $alunos = DB::table('outros_pagamentosview')
        ->where('idtabelavalores', $tipoPagamento)
        ->where('classe_id', $class)
        ->where('mes_id', $data)
        ->where("deleted_at",null)
        ->where('anolectivo_id', $ano)
        ->get();

    $datas = collect();

    foreach ($alunos as $key=>$dadosId) {
$descricao= $dadosId->tipoPagamento;
        $buttons ="" ;
if(auth()->user()->can("Efetuar-$descricao")){
       $buttons= '<button type="button"
                    class="btn btn-outline-primary GuadarOutrosPagamentos"
                    idaluno="' . $dadosId->aluno_classe_id . '"
                    idmes="' . $dadosId->mes_id . '"
                    idtipo="' . $dadosId->idtabelavalores . '"
                    anolectivo_id="' . $dadosId->anolectivo_id . '"
                    classe_id="' . $dadosId->classe_id . '"
                    title="Pagar mensalidade">
                <i class="fa fa-upload"></i>
            </button>';
}

if(auth()->user()->can("Visualizar-$descricao")){
            $buttons=$buttons.'<button type="button"
                    class="btn btn-outline-info visualizarOutrosPagamentos"
                    title="Visualizar pagamentos"
                    idaluno="'.$dadosId->aluno_classe_id  . '"
                    idmes="' . $dadosId->mes_id . '"
                    idtipo="' . $dadosId->idtabelavalores . '"
                    anolectivo_id="' . $dadosId->anolectivo_id . '"
                    classe_id="' . $dadosId->classe_id . '"
                    >
                <i class="fa fa-eye"></i>
            </button>
        ';
}
if(auth()->user()->can("Visualizar-$descricao")||auth()->user()->can("Efetuar-$descricao")){
        $datas->push([
            'id'     =>($key+1),
            'nome'   => $dadosId->nome,
            'turma'   => $dadosId->turma,
            'estado' => $dadosId->Estado,
             'data_pagamento' => trim($dadosId->data_pagamento),
            'acoes'  => $buttons,
        ]);
    }
    else{
$datas->push([
            'id'     =>($key+1),
            'nome'   => $dadosId->nome,
            'turma'   => $dadosId->turma,
            'estado' => $dadosId->Estado,
             'data_pagamento' => trim($dadosId->data_pagamento),
             'acoes'  =>"" ,
        ]);
    }
    }


    return response()->json($datas);
}


  public function show(Request $request)
{

    // 1. Obter ano letivo ordenado
    $anolectivo = Anolectivo::orderBy('anolectivo', 'desc')->get();
    $anoAtualId = $anolectivo->first()?->id; // Protege contra null

    // 2. Buscar dados com filtros
    $dados = DB::table('detalhestabelavaores')
        ->where('tipo', '>', 2)
        ->where('tipo_janela', 2)
        ->get();

    // 3. Filtrar dados pelo ano letivo atual
    $dadosAno = $dados->where('anolectivo_id', $anoAtualId);

    // 4. Tipos de pagamento únicos
    $tipoPagamento =  $dadosAno->unique('tipo')->values();


    // 5. Classes e meses únicos
    $classeIn = $dadosAno->pluck('classe_id')->unique()->toArray();
    $mesidIn = $dadosAno->pluck('mes')->unique()->toArray();

    // 6. Buscar classes e meses
    $classes = Classe::whereIn('id', $classeIn)->get();
    $meses = Meses::whereIn('id', $mesidIn)->get();

    // 7. Enviar para a view
    $dados=$dadosAno;
// dd($request->all(), $tipoPagamento);
if( $tipoPagamento->isEmpty()){
$mensagem="Outros pagamentos NÃO estao desponiveis ";

    return view("Componetes.alerta-Falha",["mensagem"=>$mensagem]);
}

    return view('registoAcademico.outrosPagamento.outros-pagamentosShowIndex', compact(
        'anolectivo', 'meses', 'tipoPagamento', 'classes', 'dados'
    ));
}




    public function payrShow( $id, $idmes, $tipopagamento, $flag=1)
    {


//  dd($id, $idmes, $tipopagamento);
        $mesid = $idmes;
        $mes = 1;
        $datalimite2 = [];

            $mes = meses::where('id', $mesid)->first()->Descricao;
$dadosTable= DB::table("outros_pagamentosview")->where("aluno_classe_id",$id)
->where("tipo_pagamento_id",">",2)
->get();
$alunoEscrito=alunoClasse::where("id",$id)->get();

        $messes = collect();
        $aluno = DB::table('outros_pagamentosview')
        ->where('Aluno_classe_id', $id)->first();

// dd( $aluno,$dadosTable, $id, $idmes, $tipopagamento,$alunoEscrito);

   if(empty($aluno)){
    $mensagem='Ocorreu um problema com esta operacao ,por favor consulte a equipe tecnica Reporte este Codigo-'.$id.'-Pagameto-'.$tipopagamento.'';
    return view('include.mensage-alerta',compact('mensagem'));
   }
        $alunoMesalidade = DB::table('outros_pagamentosview')->where('id', $id)->where('idtabelavalores', $tipopagamento)->get();




        $valorMensalidade = DB::table('tabelavaloresano')
            ->where('classId', $aluno->classe_id)
            ->where('Finalidade', $alunoMesalidade[0]->tipoPagamento)
            ->where('idanolectivo', $aluno->anolectivo_id)
            ->first();




        $alunoMesalidades2 = collect();
        foreach ($alunoMesalidade as $alunoMesalidadeItem) {

            // array meseses
            $messes->push(['id' => $alunoMesalidadeItem->mes_id,
            "Descricao" => $alunoMesalidadeItem->mes,"Data_limite"=>$alunoMesalidadeItem->data_Fim]);



            $mensagem="Adiciona a tabela de valores";
            if(empty($valorMensalidade->idtabelavalores)){
return view('include.mensage-alerta',compact('mensagem'));
            }
            $alunoMesalidades2->push([
                'mes_id' => $alunoMesalidadeItem->mes_id,
                "Aluno_classe_id" => $id,
                "Estados" => $alunoMesalidadeItem->Estados,
                "anolectivo_id" => $aluno->anolectivo_id,
                "tipoPagamento_id" => $alunoMesalidadeItem->tipoPagamento_id,
                "tipoPagamento" => $alunoMesalidadeItem->tipoPagamento,
                "anolectivo" => $aluno->anolectivo,
                "idtabelavalores" => $valorMensalidade->idtabelavalores,
                "valorDescricao" => $valorMensalidade->valorDescricao,
                "multaP" => $valorMensalidade->multaP,
                "classe_id" => $aluno->classe_id,
                "nome" => $aluno->nome,
                "id" => $aluno->id,
                "mes" => $alunoMesalidadeItem->mes,
                "Data_limite"=>$alunoMesalidadeItem->data_Fim
            ]);
        }
        $alunoMesalidade = $alunoMesalidades2;




$tipoPagamento=DB::table('metodo_pagamento')->get();
$reverterpermisao = false;
// dd($alunoMesalidade[0]["tipoPagamento"]);
if (auth()->user()->can("reverter-pagamento") || auth()->user()->can("Reverter-" .$alunoMesalidade[0]["tipoPagamento"]."")) {
    $reverterpermisao = true;
}



        return view("registoAcademico.outrosPagamento.outrosPagamentos-pagar", compact(
            'dadosTable',
            'tipoPagamento',
            'aluno',
            'mesid',
            'mes',
            'messes',
            'flag',
            'alunoMesalidade',
            'datalimite2',
            'valorMensalidade',
            'reverterpermisao',
            'id',
            'tipopagamento'

        ));
    }



    public function atualizarMensalidade(Request $request, $id)
    {

        $dadoTabelavalores = 0;
        $data_incio = "";
        $data_fim = "";
        $data_incio = "";
        $multa = 0;
        $idmes = null;
        $valor_apagar = 0;

        for ($x = 0; $x < count($request->mesid); $x++) :


            $tipoPagamento = DB::table('detalhestabelavaores')->where("id", $request->tipopagamentoapagar)
                ->first();
                // dd($id, $request->all());
            $aluno = alunoClasse::where('id', $id)->first();

            $tabelavalor = DB::table("tabelavaloresano")
                ->where('classId', $aluno->classe_id)
                ->where('idanolectivo', $aluno->anolectivo_id)
                ->where("Finalidade", $tipoPagamento->Descricao)
                ->first();
            $dadoTabelavalores = $tabelavalor;

            if (($request->multaactiva > 0) && ($request->estado[$x] == 'Pago')) {
                $multa = $multa + (($tabelavalor->valorDescricao) * 0.0);
                $valor_apagar = $valor_apagar + (($tabelavalor->valorDescricao));
            }


        endfor;




        if ($request->tipopagamento =="Mpesa-Online") {
            $mpesa = new modelmpesapay();
            $result = $mpesa->tranferencia($valor_apagar, "258" . $request->numero);
            if ($result[0]->output_ResponseCode=='INS-0') {
                $this->mensalidadesGuardar($request, $id, $result[2]->output_TransactionID);
            } else {
                $mensagem = "Transacao falho devido ";
                return view("include.mensage-alerta", compact('mensagem'));
            }
        } else {
            $this->mensalidadesGuardar($request, $id, null);
        }



        //  dd($request->all());
        //dd( $request->tipopagamentoapagar);
        //dd( $data_incio);
        $dadosmes = "";


                $dadosmes = DB::table('outros_pagamentosview')->where('aluno_classe_id', $id)
                    ->where('tipoPagamento_id', $request->tipopagamentoapagar)
                    ->where('mes_id', $request->mesid[0])
                    ->first();

                    $mesestipo= DB::table("mesespagamento")->where("id",$request->mesid[0])->first();

                   //dd($dadosmes,$request->all(), $mesestipo);
                    $datalimite=$dadosmes->data_Fim;
                    $data1 = carbon::create($datalimite);
                    $data2 = carbon::now();
                    $dias = $data2->diffInDays($data1);


if(count($request->mesid)==1){
        return view(
            "registoAcademico.outrosPagamento.recibo-mes",
            compact('dadosmes', 'dadoTabelavalores', 'dias', "datalimite",'mesestipo')
        );
    }
    else{
      $aluno = DB::table('mensalidadesollshow')->where('Aluno_classe_id', $id)->first();
        $meses = DB::table('meses')->get();
        $Valores_pago = DB::table('outros_pagamentosview')->where('aluno_classe_id', $id)
            ->where('tipoPagamento_id',$request->tipopagamentoapagar)
            ->get();




            return  view("registoAcademico.outrosPagamento.mensalidadespagas", compact('aluno', 'meses', 'Valores_pago'));
    }
    }





    public function mensalidadesGuardar(Request $request, $id, $referencia)
    {


        $usuario = auth()->user()->id;
        $data_incio = "";
        $data_fim = "";
        $data_incio = "";

        $idmes = null;
        $valor_apagar = 0;


        for ($x = 0; $x < count($request->mesid); $x++) :


  $tipoPagamento = DB::table('detalhestabelavaores')->where("id", $request->tipopagamentoapagar)
                ->first();
            // $tipoPagamento = tipos_pagamentos::where("id", $request->tipopagamentoapagar)
            //     ->first();

            $aluno = alunoClasse::where('id', $id)->first();

            $tabelavalor = DB::table("tabelavaloresano")
                ->where('classId', $aluno->classe_id)
                ->where('idanolectivo', $aluno->anolectivo_id)
                ->where("Finalidade", $tipoPagamento->Descricao)
                ->first();





            $dadosmetodopagamento = DB::table('metodo_pagamento')
                ->where('Descricao', $request->tipopagamento)->first();


          $saidadedado=  outros_pagamentos::where('tipo_pagamento_id',
           $request->tipopagamentoapagar)
                ->where('aluno_classe_id', $id)
                ->where("mes_id", $request->mesid[$x])
                ->update([
                    "Estado" =>  $request->estado[$x],
                    "multa" => $request->multaactiva[$x],
                    "metodo_pagamento_id" => $dadosmetodopagamento->id,
                    "referencia" => $referencia,
                    "usuario_Registou" => $usuario,
                    "data_pagamento"=>Carbon::now()

                ]);


                $saidadedado=  outros_pagamentos::where('tipo_pagamento_id', $request->tipopagamentoapagar)
                ->where('aluno_classe_id', $id)

                ->where("mes_id", $request->mesid[$x])->first();




        endfor;
    }



    //mostrar as mensalidade dos pagmentos

    public function  mostraasmensalidadesDotipo($id, $tipo, $flag=1)
    {
 $aluno = DB::table('mensalidadesollshow')->where('Aluno_classe_id', $id)->first();
        if(empty($aluno)){
            $mensagem='Ocorreu um problema com esta operacao ,por favor consulte a equipe
            tecnica Reporte este Codigo-'.$id.'-Visualizar';
            return view('include.mensage-alerta',compact('mensagem'));
           }
        $meses = DB::table('meses')->get();
        $Valores_pago = DB::table('outros_pagamentosview')->where('aluno_classe_id', $id)
            ->where('idtabelavalores', $tipo)
            ->get();

        return view("registoAcademico.outrosPagamento.mensalidades-todas", compact('aluno', 'meses', 'Valores_pago'));

    }

    // imprimir


    public  function imprimirTodasMensalidadesAluno($id, $tipo, $flag)
    {

        $aluno = DB::table('mensalidadesollshow')->where('Aluno_classe_id', $id)->first();
        $meses = DB::table('meses')->get();
        $Valores_pago = DB::table('outros_pagamentosview')->where('aluno_classe_id', $id)
            ->where('tipoPagamento_id', $tipo)
            ->get();


        if ($flag == 0) :

            return  view("registoAcademico.outrosPagamento.mensalidadespagas", compact('aluno', 'meses', 'Valores_pago'));
        else :
            $pdf = PDF::loadView("registoAcademico.outrosPagamento.mensalidadespagas", compact('aluno', 'meses', 'Valores_pago'))->setPaper('a5');

            return $pdf->download("mensalidadesdoaluno" . Carbon::now() . ".pdf");
        endif;
    }


    // relatio de mensalidades

    public function Relatorio()
    {$anolectivos = DB::select("SELECT * FROM anolectivos ORDER BY id DESC");
        $classes = DB::table('classes')->get();
        $tipoPagamento = tipos_pagamentos::where('id', '>', 2)->get();

        return view("registoAcademico.outrosPagamento.relatorio-mensalidades", compact('anolectivos', 'classes', 'tipoPagamento')
        );
    }


    public function RelatorioAnoClasse($ano, $classe, $tipov)
    {
            $arrayrelatorio = array();
             $tipo=DB::table('tabelavaloresano')->where('id',$tipov)->first();


        $tempoid=DB::table('detalhestabelavaores')->where('tipo',$tipov)->pluck('mes')->toArray();

        $meses = DB::table('meses')->whereIn('id',$tempoid)->get();

            foreach ($meses as $mesesIem) {


                $relatoriomes=DB::select("call relatorioGeericoOutrospagametos(?,?,?,?)",[$mesesIem->id,$tipo->Finalidade ,$ano,$classe]);
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



$flag= $tipo->Finalidade;

        //$arrayrelatorio=json_encode($arrayrelatorio);
        return view("registoAcademico.outrosPagamento.relatorio-ano-classe", compact(
            'arrayrelatorio',
            'ano',
            'classe',
            'meses',
            'tipo',
            'flag'
        ));
    }


    public function Relatoriodetalhado($ano, $classe, $mes,$tipo, $flag)
    {

        $tipopagamento=tipos_pagamentos::where('id',$tipo)->first();
        $relatorioDetalhado = "";

        if ($flag == 1) {
            $relatorioDetalhado = DB::table('outros_pagamentosview')
                ->leftjoin('turmasview', 'outros_pagamentosview.aluno_classe_id', '=', 'turmasview.aluno_classe_id')
                ->leftjoin('tranferencias_disistencias', 'outros_pagamentosview.aluno_classe_id', '=', 'tranferencias_disistencias.idalunoClasse')
                ->select('outros_pagamentosview.*', 'turmasview.turmas', 'turmasview.turma_id', 'tranferencias_disistencias.Tipo')
                ->where('outros_pagamentosview.tipoPagamento_id', $tipo)
                ->where('outros_pagamentosview.anolectivo_id', $ano)
                ->where('outros_pagamentosview.mes_id', $mes)
                ->where('outros_pagamentosview.classe_id', $classe)
                ->get();
        } else {
            $relatorioDetalhado = DB::table('outros_pagamentosview')
                ->leftjoin('turmasview', 'outros_pagamentosview.aluno_classe_id', '=', 'turmasview.aluno_classe_id')
                ->leftjoin('tranferencias_disistencias', 'outros_pagamentosview.aluno_classe_id', '=', 'tranferencias_disistencias.idalunoClasse')
                ->select('outros_pagamentosview.*', 'turmasview.turmas', 'turmasview.turma_id', 'tranferencias_disistencias.Tipo')
                ->where('outros_pagamentosview.tipoPagamento_id', $tipo)
                 ->where('outros_pagamentosview.anolectivo_id', $ano)
                ->whereMonth('outros_pagamentosview.updated_at', $mes)
                ->where('outros_pagamentosview.classe_id', $classe)
                ->get();

        }


        return view("registoAcademico.outrosPagamento.relatorio-mensalidaders-detalhado-mes", compact('relatorioDetalhado','tipopagamento'));
    }






    public function pagamentosIndex()
    {

        $ano =  DB::select("SELECT  * from anolectivos  order by(id) desc");
        $classe =  DB::select("SELECT  * from classes");
$tipoPagamento=tipos_pagamentos::where('id','>',2)->get();
        $data = Carbon::now()->format('m/d/') . "20" . Carbon::now()->format('y');



        return view("registoAcademico.outrosPagamento.relatoriospagamentos.relatorio-pagamentos-index", compact('classe', 'ano', 'data','tipoPagamento'));
    }



public function pagamentos($ano, $classe, $data1, $data2, $tipo)
{
    // =========================
    // TIPO PAGAMENTO
    // =========================
    $tipoPagamento = DB::table('tipos_pagamentos')
        ->where('id', $tipo)
        ->value('Descricao');

    // =========================
    // DATAS
    // =========================
    $dataInicio = Carbon::parse($data1)->startOfDay();

    $dataFim = Carbon::parse($data2)->endOfDay();

    // =========================
    // MÉTODOS PAGAMENTO
    // =========================
    $metodosPagamentos = DB::table('metodo_pagamento')
        ->orderBy('id')
        ->get();

    // =========================
    // CLASSES
    // =========================
    $classes = Classe::query()

        ->when($classe != 0, function ($query) use ($classe) {

            $query->where('id', $classe);

        })

        ->orderBy('id')

        ->get();

    // =========================
    // IDS DAS CLASSES
    // =========================
    $classesIds = $classes->pluck('id');

    // =========================
    // PAGAMENTOS
    // =========================


    // =========================
    // VIEW
    // =========================




    $inicio = Carbon::parse($data1, 'Africa/Maputo')->startOfDay();
    $fim = Carbon::parse($data2, 'Africa/Maputo')->endOfDay();



    $dados = collect();

        $pagamentos = detalhestabelavalores::where('tipo', $tipo)
            ->where('anolectivo_id', $ano)
            ->with([
                'mensalidades' => function ($q) use ($inicio, $fim) {
                    $q->where('Estado', 'Pago')
                     ->whereNull('deleted_at')->with('alunoclasse','mes','metodopagamento')
                        ->whereBetween('updated_at', [$inicio, $fim]);
                }
            ])
            ->first();


       $pagamentos?->mensalidades->map(function($e) use($dados,$pagamentos){
         $dados->push((object)["aluno_classe_id"=>$e->alunoclasse->id,
         'nome'=>$e->alunoclasse->aluno->nome,
         'classe_id'=>$e->alunoclasse->classe_id,
         'classe'=>$e->alunoclasse->classe->Descricao,
         'anolectivo_id'=>$e->alunoclasse->anolectivo->id,
         'anolectivo'=>$e->alunoclasse->anolectivo->anolectivo,
         'tipo_pagamento_id'=>$pagamentos->tipo,
         'tipo_pagamento_descricao'=>$pagamentos->Descricao,
         'valorDescricao'=>$pagamentos->valorDescricao,
         'data_pagamento'=>$e->data_pagamento,
         'data_Inicio'=>$e->data_inicio,
         'data_limite'=>$e->data_Fim,
         'Ntalao'=>$e->Ntalao,
         'Estados'=>$e->Estado,
         'Multa'=>$e->Multa,
         'mes_id'=>$e->mes_id,
         'mes'=>$e->mes->Descricao,
         'referencia'=>$e->referencia,
         'deleted_at'=>$e->deleted_at,
        //  'deleted_at'=>$e->deleted_at,
         'metodo_pagamento'=>$e->metodopagamento->id,
         'metodoPagDesc'=>$e->metodopagamento->Descricao,
         ]);

       });

     $dados=  $dados->whereIn("classe_id",$classesIds);

    // AGRUPAMENTO CORRETO (Collection)
    $esperadoDetalhes = $dados->groupBy('data_pagamento')->map(function ($items) {
        return (object)[
            'data_pagamento' => $items->first()->data_pagamento,
            'Classessize' => $items->pluck('classe_id')->unique()->count(),
            'ClassesList' => $items->pluck('classe')->unique()->implode(', ')
        ];
    });

    $outrosPagamentos = $dados;
    return view(
        'registoAcademico.outrosPagamento.relatoriospagamentos.pagamentos',
        compact(
            'metodosPagamentos',
            'classes',
            'outrosPagamentos',
            'tipoPagamento',
            'dataInicio',
            'dataFim'
        )
    );

    }


    public function pagamentosPrint($ano, $classe, $data1, $data2,$tipo)
    {

$tipo=DB::table('tipos_pagamentos')->where('id',$tipo)->first()->Descricao;

$data=Carbon::create($data1)->format('Y-m-d');
$collecao2=collect();
$collet= collect();
$periodo = CarbonPeriod::create($data1, $data2);
$classessizeS=1;
 foreach($periodo as $periodoItem):


if($classe!=0):
    $classessizeS=1;
    $collet->push(DB::select('CALL SelecioaRoutros_pagamentos(?,?,?,?)'
    ,[$periodoItem,$ano,$classe,$tipo]));
else:


    $tbv=DB::table("tabelavaloresano")->where("Finalidade",$tipo)
    ->where("idanolectivo",$ano)->pluck("classId")->toArray();

$classes=classe::whereIn("id",$tbv)->get();
$classessizeS=$classes->count();
    foreach($classes as  $classesItem)
    $collet->push(DB::select('call SelecioaRoutros_pagamentos(?,?,?,?)'
    ,[$periodoItem,$ano,$classesItem->id,$tipo]));
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
        return view('registoAcademico.outrosPagamento.relatoriospagamentos.pagamentosPrint',
        compact('collet','classessizeS','tipo','periodo','metodosPagamentos'));
    }



    public function imprimirLinha($id,$tipo,$mes){

         $dadoTabelavalores = 0;
        $data_incio = "";
        $data_fim = "";
        $data_incio = "";
        $multa = 0;
        $idmes = null;
        $valor_apagar = 0;




            // $tipoPagamento = tipos_pagamentos::where("id", $tipo)
            //     ->first();
                  $tipoPagamento = DB::table('detalhestabelavaores')->where("id", $tipo)
                ->first();
            $aluno = alunoClasse::where('id', $id)->first();

            $tabelavalor = DB::table("tabelavaloresano")
                ->where('classId', $aluno->classe_id)
                ->where('idanolectivo', $aluno->anolectivo_id)
                ->where("Finalidade", $tipoPagamento->Descricao)
                ->first();
            $dadoTabelavalores = $tabelavalor;


        $dadosmes = "";


                $dadosmes = DB::table('outros_pagamentosview')->where('aluno_classe_id', $id)
                    ->where('tipoPagamento_id', $tipo)
                    ->where('mes_id', $mes)
                    ->first();

                    $mesestipo= DB::table("mesespagamento")->where("id",$mes)->first();

                   //dd($dadosmes,$request->all(), $mesestipo);
                    $datalimite=$dadosmes->data_Fim;
                    $data1 = carbon::create($datalimite);
                    $data2 = carbon::now();
                    $dias = $data2->diffInDays($data1);



        return view(
            "registoAcademico.outrosPagamento.recibo-mes",
            compact('dadosmes', 'dadoTabelavalores', 'dias', "datalimite",'mesestipo')
        );
}
}
