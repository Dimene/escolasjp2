<?php

namespace App\Http\Controllers\registoAcademico;

use App\Http\Controllers\Controller;
use App\Models\modelopagamento;
use App\Models\permission;
use App\Models\registoAcademico\alunoClasse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use  App\Models\registoAcademico\tabela_valore;
use  App\Models\registoAcademico\anolectivo;
use App\Models\registoAcademico\outros_pagamentos;
use App\Models\registoAcademico\tipos_pagamentos;
use App\Models\registoAcademico\valores_finalidades;
use Carbon\Carbon;

class tabelavaloresController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $flag = 1;
        return view('registoAcademico.tabelavalores-index', compact('flag'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $clases =  DB::table('classes')->get();
        $anolectivo = anolectivo::all();
        $tipopagamento = tipos_pagamentos::all();
        $mesepagamento = DB::table("mesespagamento")
            ->get();

            // dd($mesepagamento );
        return view('registoAcademico.tabelavalores-create', compact('clases', 'anolectivo', 'tipopagamento', 'mesepagamento'));
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//  dd($request->all());
//   dd($request->classes);
        // Chama a função retornarDetalhes para processar os dados de início e fim dos pagamentos
        $detalhes = $this->retornarDetalhes($request);
    $idtipoPagamento = tipos_pagamentos::where("id", $request->Descricao)->first();
    // dd( $idtipoPagamento,$request->Descricao);

        // Atualiza ou cria um registro na tabela `tabela_valore` com base na descrição e ano letivo
        // Adiciona ou atualiza os valores de multa, montante e detalhes
        $valorid = tabela_valore::updateOrCreate(
            [
                'Descricao' => $idtipoPagamento->Descricao, // Critério para encontrar um registro existente
                'anolectivo_id' => $request->AnoLectivo, // Ano letivo associado
                 'valorDescricao' => $request->Montante, // Montante configurado
                 'classes' => json_encode($request->classes), // Montante configurado
            ],
            [
                "periodepagamento" => $request->periodepagamento,
                'multa' => $request->Multa, // Multa configurada
                "detalhes" => $detalhes // Detalhes gerados pela função retornarDetalhes
            ]
        );


        // Recupera todas as entradas da tabela `tabelavaloresano` associadas ao `idtabelavalores` do registro criado/acessado
        $tabela_valore = DB::table("tabelavaloresano")->where("idtabelavalores", $valorid->id)->get();

        // Obtém o ID do tipo de pagamento com base na descrição fornecida

        // dd($idtipoPagamento);

        // Itera sobre as classes enviadas na requisição

        // dd($request->classes);

        foreach ($request->classes as $classeIem) {

            // Cria ou atualiza registros na tabela `valores_finalidades` para associar classe e valor
            valores_finalidades::updateOrCreate(
                [
                    "anolectivo" => $request->AnoLectivo, // Ano letivo associado
                    "tipopagameto" => $idtipoPagamento->id,
                    'classe_id' => $classeIem, // ID da classe // Tipo de pagamento
                ],
                [

                    'valores_id' => $valorid->id, // ID do valor associado
                ]
            );
        }





        // Chama a função guadarMensalidades para salvar mensalidades no banco de dados
        //  $this->guadarMensalidades($request, $valorid);
      $this->guadarMensalidades($valorid->id,$request->AnoLectivo);
        $this->adicionarprevilegios($idtipoPagamento);
        // Define uma mensagem de sucesso (caso precise ser usada)
        $colecao = "Guardado com sucesso";

        // Redireciona o usuário para a página de listagem de valores
        return redirect("/RegistoAcademico/TabelaValores/show");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $tabela_valore = tabela_valore::orderBy('created_at', 'ASC')->orderBy('updated_at', 'ASC')->get();
        $colecao = collect();
        $classvalores = "";
        foreach ($tabela_valore as $key => $value) {
            $clasesid = collect();
            foreach (DB::table('valores_finalidades')->where('valores_id', $value->id)->get('classe_id') as $valu) {
                $clasesid->push($valu->classe_id);
            }


            $clasesresultado =     DB::table('classes')->whereIn('id', $clasesid)->get();


            //  /  dd( $clasesresultado);
            $result = "";
            foreach ($clasesresultado as  $clasesidValue) {


                $result = $clasesidValue->Descricao;
                $classvalores = $classvalores . "," . $result;
            }


            $colecao->push([
                'Descricao' => $value->Descricao,

                'valorDescricao' => $value->valorDescricao,
                'multa' => $value->multa,
                'id' => $value->id,
                'anolectivo' => $value->anolectivo["anolectivo"],
                'anolectivo_id' => $value->anolectivo["id"],
                'classes' => $classvalores
            ]);
            $classvalores = "";
        }



        return view('registoAcademico.tabelavalores-show', compact('colecao'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
  public function edit($id)
{
    $anolectivo = anolectivo::all();
    $clases = DB::table('classes')->get();
    $tabelaItem = tabela_valore::find($id);

    $classeporValor = DB::table('valores_finalidades')
        ->where('valores_id', $id)
        ->get();

    $tipopagamento = tipos_pagamentos::all();
    $mesepagamento = DB::table("mesespagamento")->get();

    // 🔥 Buscar apenas 1 registo
    $idta = DB::table("detalhestabelavaores")
        ->where("id", $id)
        ->first();

    // ✅ Sempre collections
    $classescomDados = collect();
    $MesescomDados = collect();

    if ($idta) {

        // 🔥 CASO 1
        if ($idta->id > 2) {

            $baseQuery = DB::table("outros_pagamentosview")
                ->where("idtaelavalores", $idta->id)
                ->where("anolectivo_id", $idta->anolectivo_id)
                ->where("Estado", "Pago");

            $classescomDados = (clone $baseQuery)
                ->select("classe_id")
                ->distinct()
                ->get();

            $MesescomDados = (clone $baseQuery)
                ->select("mes_id")
                ->distinct()
                ->get();

        }
        // 🔥 CASO 2
        else {

            $classescomDados = DB::table("aluno_classes")
                ->where("tipo_Pagamento_id", $idta->id)
                ->where("anolectivo_id", $idta->anolectivo_id)
                ->select("classe_id")
                ->distinct()
                ->get();

            // 👉 transformar meses corretamente em collection de objetos
            $meses = DB::table("detalhestabelavaores")
                ->where("id", $id)
                ->pluck("mes");

            $MesescomDados = collect($meses)->map(function ($mes) {
                return (object) ['mes_id' => $mes];
            });
        }
    }

    return view(
        'registoAcademico.tabelavalores-edit',
        compact(
            'anolectivo',
            'clases',
            'tabelaItem',
            'classeporValor',
            'tipopagamento',
            'mesepagamento',
            'classescomDados',
            'MesescomDados'
        )
    );
}

    /**idtaelavalores
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   public function update(Request $request, $id)
{
    // 🔒 Validação básica
    $request->validate([
        'Descricao' => 'required|exists:tipos_pagamentos,id',
        'AnoLectivo' => 'required',
        'Montante' => 'required',
    ]);

    // 🔍 Buscar tipo
    $tipo = tipos_pagamentos::find($request->Descricao);

    if (!$tipo) {
        return response()->json(['error' => 'Tipo inválido'], 400);
    }

    // 📦 Processar detalhes
    $detalhes = $this->retornarDetalhes($request);

    // 🔄 Atualizar registro principal
    $valor = tabela_valore::findOrFail($id);

    $valor->update([
        'Descricao' => $tipo->Descricao,
        'anolectivo_id' => $request->AnoLectivo,
        'periodepagamento' => $request->periodepagamento,
        'multa' => $request->Multa,
        'valorDescricao' => $request->Montante,
        'detalhes' => $detalhes
    ]);

    // 🧹 Limpar relações antigas
    valores_finalidades::where('valores_id', $id)->delete();

    // ✅ Recriar classes (seguro)
    if ($request->has('classes')) {
        foreach ($request->classes as $classe) {
            valores_finalidades::create([
                "anolectivo" => $request->AnoLectivo,
                "tipopagameto" => $tipo->id,
                "classe_id" => $classe,
                "valores_id" => $id,
            ]);
        }
    }

    // 🔐 Extras
    $this->adicionarprevilegios($tipo);

    // ✅ Resposta para AJAX
    return response()->json([
        'success' => true,
        'message' => 'Atualizado com sucesso'
    ]);
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




    public function apagar($id)
    {

$tabelavalores= DB::table('detalhestabelavaores')
    ->where('id', $id)
    ->get();

$dados=$tabelavalores->first()->tipo;

    if($dados>2){

// Verifica as classes que já têm dados
$mes = DB::table('outros_pagamentosview')
    ->where('idtabelavalores', $id)
    ->where('Estado', '!=', 'Não pago')
    ->get();

// Classes que não devem ser apagadas
$classes = collect($mes->pluck("classe_id")->toArray());

// Apagar dados que não estejam no intervalo
DB::table('outros_pagamentos')
    ->where('tipo_pagamento_id', $tabelavalores->first()->tipo)
    ->whereNotIn("classe_id", $classes)
    // ->whereNotIn('mes_id', $mes->pluck("mes_id")->toArray()) // Descomente se necessário
    ->delete();

// Apagar valores_finalidades que não estejam nas classes válidas
DB::table('valores_finalidades')
    ->where("tipopagameto", $tabelavalores->first()->tipo)
    ->where("anolectivo", $tabelavalores->first()->anolectivo_id)
    ->where("valores_id", $id)
    ->whereNotIn("classe_id", $classes)
    ->delete();

if ($mes->isEmpty()) {
    DB::table("tabela_valores")
        ->where("id", $tabelavalores->first()->id)
        ->where("anolectivo_id", $tabelavalores->first()->anolectivo_id)
        ->delete();
}


    }
    else{
$dadosmatricula=DB::table("alunosescritos")
->where("tipo_Pagamento_id",$id)
->where("anolectivo_id",$tabelavalores->first()->anolectivo_id)
->get();


//  DB::table("tabela_valores")->where("id",$tabelavalores->first()->id)->
// where("anolectivo_id",$tabelavalores->first()->anolectivo_id)
// ->delete();


// Apagar valores_finalidades que não estejam nas classes válidas
DB::table('valores_finalidades')
    ->where("tipopagameto", $tabelavalores->first()->tipo)
    ->where("anolectivo", $tabelavalores->first()->anolectivo_id)
    ->where("valores_id", $id)
    ->whereNotIn("classe_id",collect($dadosmatricula->pluck("Classe_id")->toArray()))
    ->delete();
if ($dadosmatricula->isEmpty()) {
    DB::table("tabela_valores")
        ->where("id", $tabelavalores->first()->id)
        ->where("anolectivo_id", $tabelavalores->first()->anolectivo_id)
        ->delete();
}



    }

     return  redirect('/RegistoAcademico/TabelaValores/show');
    }



    public  function configModalidadepagamento()
    {



        $mesepagamento = DB::table("mesespagamento")
            ->get();


        return  view("Admin.config.modelopagamento", compact('mesepagamento'));
    }



    public function guadarMensalidades($tabela_valore,$anolectivo)
    {



    $clases = DB::table('detalhestabelavaores')
    ->where('id', $tabela_valore)
    ->where('anolectivo_id', $anolectivo)
    ->distinct()
    ->pluck('classe_id')
    ->toArray();
// dd($tabela_valore,  $tabelavalores,$clases);

foreach($clases as $classItem):
$tabelavalores =DB::table("detalhestabelavaores")
    ->where('id',$tabela_valore)
    ->where('anolectivo_id',$anolectivo)
    ->where('classe_id',$classItem)
    ->get();


    $mese=$tabelavalores->pluck("mes")->toarray();

   // outros_pagamentos::where("tipo_pagamento_id",tabelavalores->first()->id)->,
$alunos=alunoClasse::where("classe_id",$classItem)->where("anolectivo_id",$anolectivo)->get();
foreach($alunos as $aluno):








foreach( $tabelavalores as $tabelavaloresItem){


        outros_pagamentos::updateOrCreate([
            "aluno_classe_id"=>$aluno->id,
        "mes_id"=>$tabelavaloresItem->mes,
        "tipo_pagamento_id"=>$tabelavaloresItem->id],
        [
        "data_Fim"=> $tabelavaloresItem->limite,
        "data_inicio"=>$tabelavaloresItem->inicio
        ]);


    }
endforeach;
endforeach;
    }



public function retornarDetalhes($request)
{
    $inicio = [];
    $final = [];
    $detalhes = [];

    if ($request->items[count($request->items) - 1] > 12) {
        foreach ($request->DataInicio as $i => $item) {
            $inicio[$i] = $request->DataInicio[$i];
            $final[$i] = $request->DataFim[$i];
        }
    } else {
        foreach ($request->items as $key => $item) {
            $ano = anolectivo::where("id", $request->AnoLectivo)->first()->anolectivo;
            $dataInicio = $ano . "-" . $item . "-01";
            $dataFim = $ano . "-" . $item . "-" . $request->DataFimGeericas;

            $inicio[$key] = Carbon::create($dataInicio)->format('Y-m-d');
            $final[$key] = Carbon::create($dataFim)->format('Y-m-d');
        }
    }

    // ✅ Construir array de objetos alinhados
    foreach ($request->items as $i => $mes) {
        $detalhes[] = [
            "mes" => $mes,
            "inicio" => $inicio[$i],
            "limite" => $final[$i]
        ];
    }

    return json_encode($detalhes);
}

    public function adicionarprevilegios($tipoPagamento)
    {
 $tipoPagamento=$tipoPagamento->id;


        $tipopaga = tipos_pagamentos::where( "id", $tipoPagamento)->first();



        $dados = modelopagamento::firstOrCreate(["tipo_pagameto_id"
        => $tipoPagamento, "Descricao" => $tipopaga->Descricao]);

// dd($dados,$tipopaga->Descricao,$tipoPagamento);
        $dadopermission = DB::table("permissions")
            ->where("model_id", $tipoPagamento)->get();

        $arrayprefix = ["Visualizar", "RelatorioPagameto", "RelatorioGenerico", "Lista", "Efetuar", "Reverter"];
        $arrayprefixLabel = ["Visualizar pagamento de ", "RelatorioPagameto de pagamento de", "RelatorioGenerico de ", "Lista de pagamento de ", "Efetuar pagamento de ", "Reverter pagamento de "];


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
}
