<?php

namespace App\Http\Controllers;

use App\Helpers\ReferenciaBIMHelper;
use App\Http\Controllers\registoAcademico\alunosController;
use App\Http\Controllers\registoAcademico\MensalidadesController;
use App\Models\banco;
use App\Models\entidade;
use App\Models\referenciasbancaria;
use App\Models\registoAcademico\alunoClasse;
use App\Models\registoAcademico\anolectivo;
use App\Models\registoAcademico\classe;
use App\Models\registoAcademico\mensalidade;
use App\Models\registoAcademico\meses;
use App\Models\registoAcademico\outros_pagamentos;
use App\Models\registoAcademico\tipos_pagamentos;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class bancosControler extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

// $mes=meses::all();
        $anolectivo = anolectivo::orderBy('id', 'desc')->get();
        $banco = banco::all();
        $tipopagamento = tipos_pagamentos::all();
        $classes = classe::all();

        $detalhes= DB::table("detalhestabelavaores")
    ->orderBy('mes', 'asc')
->get();


        return view('Financas.Banco.visualizar-referencias', compact('anolectivo',
         'banco', 'tipopagamento', 'classes', 'detalhes'));

    }



      public function getmeses($tipo,$anolectvo,$classe)
    {


  $dados= DB::table("detalhestabelavaores")
        ->where("tipo",$tipo)
        ->where("anolectivo_id",$anolectvo)
        ->first();

$dadosmese = DB::table('outros_pagamentosview')
    ->select('mes_id', 'mes')
    ->where('classe_id', $classe)
    ->where('tipoPagamento_id', $dados->id)
    ->distinct()

    ->get();

return response()->json($dadosmese);


    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
     $anolectivo = anolectivo::orderBy('id', 'desc')->get();
        $banco = banco::all();


        $tipopagamento = tipos_pagamentos::all();
        $classes = classe::all();
        return view('Financas.Banco.gerar-referencias', compact('anolectivo', 'banco', 'tipopagamento', 'classes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

$aluno="";
        $entidade = banco::where('id', $request->Entidade)->first();

        if($request->tipopagamento==1){
        $aluno = DB::table('mensalidadesview')->where('anolectivo_id', $request->anolectivo)
            ->where('classe_id', $request->classe)
            ->get();
        }
        if($request->tipopagamento>2){
        $aluno = DB::table('outros_pagamentosview')->where('anolectivo_id', $request->anolectivo)
            ->where('classe_id', $request->classe)
            ->get();
        }

            $mesid="";
            $valorDescricao="";
        foreach ($aluno  as $alunoItem) {

            if(strlen($alunoItem->mes_id)==1):  $mesid="0".$alunoItem->mes_id; else: $mesid=$alunoItem->mes_id; endif;;

//echo $mesid;


$tipopagamentoget=DB::table("tipos_pagamentos")->where("id",$request->tipopagamento)->first();

$tablevalores=DB::table('tabelavaloresano')
->where('idanolectivo',$request->anolectivo)
->where('classId',$request->classe)
->where('Finalidade',$tipopagamentoget->Descricao)
->first();

$valorDescricao=$tablevalores->valorDescricao."00";
     $referencia=$this->gerarReferenciasBCI($alunoItem->aluno_classe_id,$entidade->Entidade,
        $mesid,$valorDescricao);

        referenciasbancaria::updateOrCreate(
            ['tipo_pagamento_id' => $request->tipopagamento,
            "banco_id"=>$request->Entidade,
            "mes_id"=>$alunoItem->mes_id,
            'aluno_classe_id' => $alunoItem->aluno_classe_id, "mes_id"=>$alunoItem->mes_id,"referencia"=>$referencia],
            ['tipo_pagamento_id' => $request->tipopagamento,
            "banco_id"=>$request->Entidade,
            "mes_id"=>$alunoItem->mes_id,
            'aluno_classe_id' => $alunoItem->aluno_classe_id, "mes_id"=>$alunoItem->mes_id,"referencia"=>$referencia]
        );

        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
    }



    public function gerarReferenciasBCI($codigoaluno, $entidade, $mes, $montante)
    {



        $pi = 0;
        $pn = 0;
        $ckdigit = 0;
        $referencia = $entidade . $codigoaluno . $mes . $montante;


        $referenciatamanho = strlen($referencia);
        $arraydados = str_split($referencia);



        for ($i = 0; $i < count($arraydados); $i++) {

            $si = $pi + $arraydados[$i];

            $pi = ($si * 10) % 97;

            if (($i + 1) == count($arraydados)) {
                $pn = ($pi * 10) % 97;


                $ckdigit = 98 - $pn;

                if (strlen($ckdigit) == 1) {
                    $ckdigit = (string)"0" . $ckdigit . "";
                } else {
                    $ckdigit = $ckdigit;
                }
            }
        }

        return $codigoaluno . $mes . $ckdigit;
    }





public function visuzlizarreferencias(Request $request)
{
    // Inicializar coleção de meses
    $meses = collect();
$tipo=DB::table("detalhestabelavaores")
            ->where("tipo", $request->tipopagamento)
            ->where("classe_id", $request->classe)
            ->where("anolectivo_id", $request->anolectivo)->first();
    // Se não vier mês, buscar todos os meses do tipo/ano

    // dd($tipo,$request->all());
    if (is_null($request->mes)) {
        $meses = DB::table("detalhestabelavaores")
            ->where("tipo", $request->tipopagamento)
             ->where("classe_id", $request->classe)
            ->where("anolectivo_id", $request->anolectivo)
            ->pluck("mes"); // já retorna Collection
    } else {
        $meses->push($request->mes);
    }


    $aluno=collect();
 if($request->tipopagamento>2){

   $dadods= alunoClasse::where('classe_id',$request->classe)->where("anolectivo_id", $request->anolectivo)->with(['mensalidades'=>function($e) use($tipo)
    {$e->tipo_Pagamento_id=$tipo->idtabelavalores;




    },"Aluno"])->get();


    foreach($dadods as $item){

    foreach($item->mensalidades as $meses):

    $entidade=entidade::where("id",$request->Entidade)->first();

$dados=0;

$multa=0;

    if(!empty($meses->data_Fim)){
 if(Carbon::parse($meses->data_Fim)->isPast()){
$dados=1;


$multa=($tipo->multa/100)*$tipo->valorDescricao;
 }

    }
    else{
       $dados=0;
    }



    $referencia=referenciasbancaria::where("aluno_classe_id",$item->id)
     ->where('tipo_pagamento_id',$tipo->idtabelavalores)
    ->where('banco_id',$entidade->id)
    ->where("mes_id",$meses->mes_id)
     ->where("Multa",$dados)
    ->first();

// dd($referencia,$item->id,$tipo->idtabelavalores,$meses->mes_id);


$aluno->push((object)[
    "id"=>$item->id,
    "idoutro"=>$meses->id,
    'idmensalidademes'=>$meses->id,
    "aluno_classe_id"=>$item->id,
    "nome"=>$item->Aluno->nome,
    "Entidade"=>$entidade->Entidade,
    "Banco"=>$entidade->descricao,
    "mes_id"=>$meses->mes_id,
    "mes"=>$meses->mes->Descricao,
    "limite"=>$meses->data_Fim,
    "referenciaBanco"=> $referencia?->referencia,
     "valorDescricao"=>$tipo->valorDescricao,
     "multaP"=>$tipo->multa,
     "tipo"=>$tipo->tipo,
    //  "tipo_pagamento_id"=>$tipo->idtabelavalores,
     "tipo_pagamento_id"=>$tipo->idtabelavalores,

]);




    endforeach;
    }

 }
 else{

 }


//  dd($aluno);

$alunos=$aluno;




    // Retornar view
    return view(
        'Financas.Banco.visualizar-referncias-datatable',
        compact('alunos', 'entidade')
    );
}


public function uplodefileCadastrofile(Request $request)
{
    if (!$request->hasFile('file')) {
        return response()->json(['erro' => 'Ficheiro não enviado'], 400);
    }

    $file = $request->file('file');
    $linhas = file($file->getRealPath());

    $dados = collect($this->fileCollect($linhas));


//   $relatorioRefer=collect();

    $ids = $dados->pluck("codigo_ac")->unique();

    foreach ($ids as $id) {

        $grupo = $dados->where("codigo_ac", $id);



        $referencias = $grupo->pluck("referencia")->toArray();
        $entidades   = $grupo->pluck("Entidade")->unique();

        $registos = DB::table("referenciasbancariasview")
            ->where("codigo_AC", $id)
            ->whereIn("Entidade", $entidades)
            ->whereIn("referencia", $referencias)
            ->get();

        if ($registos->isEmpty()) continue;

        $ano = $registos->first()->anolectivo_id ?? null;

        // 🔥 pega último talão
        // $ultimo = DB::table('relatoriograficoview')
        //     ->whereIn('Estado', ['Pago', 'activo'])
        //     ->whereNotNull('Ntalao')
        //     ->where('anolectivo_id', $ano)
        //     ->max('Ntalao');




// dd( $registos);

$select =DB::table("metodo_pagamento")->where('tipo',$registos[0]->Banco_id)->first();
         $ultimo= $this->talao($select->id ,$ano);



        $sequencia = $ultimo ? (int)$ultimo + 1 : 1;
 $talaoNumero = str_pad($sequencia++, 6, '0', STR_PAD_LEFT);
        foreach ($registos as $ref) {

            // 🔥 gera talão único por registo


//   $relatorioRefer->push($ref);
            // multa
            $multaflag = (int)$ref->multaflag;
            $multa = 0;

            if ($multaflag === 1) {
                $multa = $ref->valorDescricao * ($ref->multa / 100);
            }

            // banco
            $banco = banco::where("Entidade", $ref->Entidade)->first();

            if (!$banco) continue;

            // método pagamento
            $metodo = DB::table("metodo_pagamento")
                ->where("tipo", $banco->id)
                ->first();

            if (!$metodo) continue;


            $dataref=  $grupo->where('referencia', $ref->referencia)->first()["datadeposito"];



            outros_pagamentos::where("aluno_classe_id", $ref->id)
                ->where("mes_id", $ref->mes_id)
                ->where("tipo_pagamento_id", $ref->tipo_pagamento_id)
                ->update([
                    "Estado" => "Pago",
                    "metodo_pagamento_id" => $metodo->id,
                    "usuario_Atualizou" => auth()->id(),
                    "usuario_registou" => auth()->id(),
                     "data_pagamento" => $dataref,
                    "referencia" => $ref->referencia,
                    "multaActiva" => $multaflag,
                    "Multa" => $multa,
                    "Ntalao" => $talaoNumero
                ]);
        }
    }


//   $relatorioRefer->pus($ref);
    // dd($relatorioRefer);

    return response()->json(['status' => 'ok']);
}


    public function alunoReferencias(Request $request){


        $aluno=DB::table('alunosescritos')
        ->where('idAlunoclasse',$request->id)
        ->first();
 $referenciasbancariasview=DB::table('referenciasbancariasview')
        ->where('id',$request->id)
        ->Where('tipo_pagamento_id',$request->idpagamento)
        ->get();



      return view('Financas.Banco.visualizar-entidade',
      compact('aluno','referenciasbancariasview'));

    }


    public function alunoReferenciasPrint($id, $idpagamento,$mes){
        $aluno=DB::table('alunosescritos')
        ->where('idAlunoclasse',$id)
        ->first();



$dadosEnvio=collect();
$colectmeses=collect();
  $dados = DB::table("detalhestabelavaores")
    ->where("tipo",$idpagamento)
    ->where("classe_id",$aluno->Classe_id)
    ->where("anolectivo_id", $aluno->anolectivo_id)->get();
// dd($dados,$aluno,$id, $idpagamento,$mes);


    $dadodospagos=outros_pagamentos::where("aluno_classe_id",$id)
    ->where("tipo_pagamento_id",$dados->first()->idtabelavalores)->get();


if($mes>0){
$colectmeses= $dados->where("mes",$mes);
        }else{
$colectmeses= $dados;
        }
// dd($mes,$colectmeses,$idpagamento);

  foreach($colectmeses as $item){
$multaflag=0;
 if(Carbon::parse($item->limite)->isPast()){
$multaflag=1;
 }
//  dd($item);
 $referenciasbancariasview=DB::table('referenciasbancariasview')
        ->where('id',$id)
        ->where('mes_id',$item->mes)
     ->Where('multaflag',$multaflag)
         ->Where('tipo_pagamento_id',$item->idtabelavalores)
        ->first();

    //  dd($referenciasbancariasview,$id,$item);
    if(!empty($referenciasbancariasview)){
$dadosEnvio->push($referenciasbancariasview);
}

 }



// dd($dadosEnvio);

$referenciasbancariasview=$dadosEnvio;


// Formatação da data atual no estilo "24 de Outubro de 2025"
$data = Carbon::now()->format('d') . ' de ' . Carbon::now()->translatedFormat('F') . ' de ' . Carbon::now()->format('Y');
     $pdf = PDF::loadView('Financas.Banco.visualizar-entidadePrint',
      compact('aluno','referenciasbancariasview','data','dadodospagos'))
     ->setPaper('a5');;
  return $pdf->download("Referencia" . Carbon::now() . ".pdf");


//  return View('Financas.Banco.visualizar-entidadePrint',
//       compact('aluno','referenciasbancariasview','data','dadodospagos'));
    }



public function gerarReferencia($Entidade,$codigoAluno,$mes,$valor){

     $pesos = [
            1,10,3,30,9,90,27,76,81,34,49,5,50,15,53,45,62,38,89,17,
            73,51,25,56,75,71,31,19,93,57
        ];

        $valor2 = $valor."00";
        $mes= str_pad($mes, 2, '0', STR_PAD_LEFT);
        $string=$Entidade.$codigoAluno.$mes.$valor2;

         $digitos=collect(str_split($string));
         $dadosRevertidos=collect();
         for( $X=count($digitos);$X>0; $X--){
 $dadosRevertidos->push($digitos[$X-1]);
         }


         $soma=0;
         for($x=0;$x<count($dadosRevertidos);$x++){
            $indice=$x+2;

            $mult=(int)$dadosRevertidos[$x]*(int)$pesos[$indice];

$soma=$soma+$mult;
         }

      return $codigoAluno.$mes.(98-($soma%97));

}
public function gerarReferencia33($Entidade,$codigoAluno,$mes,$valor){
    $montante = str_pad($valor, 6, '0', STR_PAD_LEFT);
    $mes = str_pad($mes, 2, '0', STR_PAD_LEFT);
    $montante = str_pad($montante , 10, '0', STR_PAD_RIGHT);
    $referenciaInicial=$codigoAluno."".$mes;

$pesos = collect([
    57, 93, 19, 31, 71, 75, 56, 25, 51, 73, 17, 89,
    38, 62, 45, 53, 15, 50, 5, 49, 34, 81, 76, 27,
    90, 9, 30, 3, 10, 1
]);

$referenciaTotal=$Entidade.$codigoAluno.$mes.$valor;
// echo "referencia".$referenciaTotal;
// echo "referencia".$referenciaInicial;



$digitos = collect(str_split($referenciaTotal));
$contadorposicoes=count($digitos );
$contadorpeso=count($pesos);
$totapesodigito=0;
for($x=1;$x<($contadorposicoes+1);$x++){

    $tota=$pesos[$contadorpeso-$x]*(int)$digitos[$contadorposicoes-$x];

    $totapesodigito=$totapesodigito+$tota;



}

$resultadoDivisao =($totapesodigito/97);
$decimal = $resultadoDivisao - floor($resultadoDivisao); // 0.34567
 $dados= collect(str_split($decimal));
$flag=(int)$dados[2].$dados[3];
 $checkdigit=98-$flag ;


$referenciaTotal=$Entidade.$referenciaInicial;
return ($checkdigit);
   // dd($montante, count($pesos),$codigoAluno,$mes,$Servico,$Entidade);




// return
}




    /**
     * Gera a referência Millennium BIM (Algoritmo 97-10)
     *
     * @param int|string $entidade      Código da Entidade (3 dígitos)
     * @param int|string $codigoAluno   Código ou ID do Aluno
     * @param string|int $mes           Mês de referência (ex: 10, 11, 12)
     * @param float      $valor         Valor a pagar (ex: 5432.00)
     * @return array
     */
   /* function gerarReferenciaPagamento ($entidade, $codigoAluno, $mes, $valor)
    {
        // 1️⃣ Normalizar campos
        $entidade = str_pad($entidade, 3, '0', STR_PAD_LEFT);
        $referenciaBase = str_pad($codigoAluno . $mes, 7, '0', STR_PAD_LEFT);

        // 2️⃣ Montante formatado (sem vírgulas/pontos)
        $valor = number_format($valor, 2, '', '');
        $valor = str_pad($valor, 6, '0', STR_PAD_LEFT);

        // 3️⃣ Número completo
        $numero = $entidade . $referenciaBase . $valor;

        // 4️⃣ Pesos oficiais Millennium BIM (tabela de 30)
        $pesos = [
            1,10,3,30,9,90,27,76,81,34,49,5,50,15,53,45,62,38,89,17,
            73,51,25,56,75,71,31,19,93,57
        ];

        // 5️⃣ Calcular a soma
        $digitos = array_reverse(str_split($numero));
        $soma = 0;
        foreach ($digitos as $i => $d) {
            $peso = $pesos[$i % count($pesos)];
            $soma += intval($d) * $peso;
        }

        // 6️⃣ Calcular Check Digit
        $resto = $soma % 97;
        $checkDigit = 98 - $resto;
        $checkDigit = str_pad($checkDigit, 2, '0', STR_PAD_LEFT);

        // 7️⃣ Montar referência final
        $referenciaFinal = $referenciaBase . $checkDigit;

        return [
            'entidade' => $entidade,
            'referencia' => $referenciaFinal,
            'check_digit' => $checkDigit,
            'valor' => number_format($valor / 100, 2, ',', '.'),
        ];
    }*/




/*

function gerarReferencia($entidade, $codigoAluno, $mes)
{
    // --- Pesos (iguais ao código C#) ---
    $Peso = [
        57,93,19,31,71,75,56,25,51,73,
        17,89,38,62,45,53,15,50,5,49,
        34,81,76,27,90,9,30,3,10,1
    ];

    // --- Montagem da lista (concatenando como no C#) ---
    // Exemplo: "10001" + "923456708" + "10"
    $Lista = $entidade . $codigoAluno . $mes;

    $Soma = 0;
    $len = strlen($Lista);

    for ($i = 0; $i < $len; $i++) {
        // índice conforme o algoritmo original
        $indice = 27 + $i - ($len - 1);
        // pegar o dígito atual
        $valor = (int)substr($Lista, $i, 1);
        // multiplicar pelo peso correspondente
        $produto = $valor * $Peso[$indice];
        $Soma += $produto;

        // Debug (opcional)
        // echo "Indice: $i | Val: $valor | Peso: {$Peso[$indice]} | Produto: $produto | Soma: $Soma\n";
    }

    $Msoma = $Soma % 97;
    $CheckDigit = 98 - $Msoma;

    // Retornar os dados
    return [
        'lista' => $Lista,
        'soma' => $Soma,
        'mod97' => $Msoma,
        'check_digit' => $CheckDigit,
        'referencia_final' => $Lista . str_pad($CheckDigit, 2, '0', STR_PAD_LEFT)
    ];
}
*/






  public static function gerarReferencia5(string $entidade, string $referenciaBase, float $montante): string
    {
        // Normalizar entradas
       // $entidade = str_pad(preg_replace('/\D/', '', $entidade), 3, '0', STR_PAD_LEFT);
        //$referencia = str_pad(preg_replace('/\D/', '', $referenciaBase), 9, '0', STR_PAD_LEFT);
        //$montante = number_format($montante, 2, '', '');
        //$montante = str_pad($montante, 6, '0', STR_PAD_LEFT);
        //$montante = str_pad($montante, 2, '0', STR_PAD_RIGHT);

        // Concatenar número completo (sem check digit)
        $numero = $entidade . $referenciaBase . $montante;

        // Calcular soma ponderada
        $soma = 0;
        $digitos = str_split($numero);
        $totalDigitos = count($digitos);

        foreach ($digitos as $i => $digito) {
            $posicao = $totalDigitos - $i;
            $peso = self::$pesos[$posicao] ?? 0;
            $soma += intval($digito) * $peso;
        }

        // Calcular check digit
        $resto = $soma % 97;
        $checkDigit = str_pad(98 - $resto, 2, '0', STR_PAD_LEFT);

        // Retornar referência final (9 dígitos + 2 dígitos de controlo)
        return substr($referenciaBase, -9) . $checkDigit;
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




    public function fileCollect($linhas){

       $dados=[];
         // Entidade na primeira linha
    $entidade = trim(substr($linhas[0], 1, 5));
    $datadoDocumeto = trim(substr($linhas[0], 6, 8));
    $datadoDocumeto=Carbon::createFromFormat('dmY', $datadoDocumeto)->format('Y-m-d');

    foreach ($linhas as $key => $linhaItem) {

    if($key!=0&&$key<(count($linhas)-1)){
        $linhaItem = trim($linhaItem);

        // ignorar linhas vazias ou resumo
        if ($linhaItem == '' || strlen($linhaItem) < 20) {
            continue;
        }

        $referencia = substr($linhaItem, 1, 11);
        $codigoAluno = substr($linhaItem, 2, 6);

        // data (AJUSTAR conforme teu padrão real)
       // $dataRaw = str_split($linhaItem); // exemplo ddmmyyyy
        $dataRaw = substr($linhaItem,44,8); // exemplo ddmmyyyy

 $dataRaw=Carbon::createFromFormat('dmY', $dataRaw)->format('Y-m-d');





        $dados[] = [
            "Entidade" => $entidade,
            "referencia" => $referencia,
            "datadeposito" => $dataRaw,
            "datadoDocumeto" => $datadoDocumeto,
            "codigo_ac"=>  $codigoAluno
        ];
    }



    }



    return $dados;

    }



    function gerarReferenciainnline($id,$banco){
       $dados= DB::table('referenciasviewbanco')->where("idoutro",$id)->first();

       $codigoAC=$this->gerar_codigoAC($dados);
       $dados= DB::table('referenciasviewbanco')->where("idoutro",$id)->first();
       $referencia=$this->GerarReferencias($dados,$banco);
       $dados= DB::table('referenciasviewbanco')->where("idoutro",$id)->first();



       return  response()->json($dados);

    }



public function gerar_codigoAC($alunoclasse)
{
    // 🔹 1. Verificar se já tem código
    $dadoAc = alunoClasse::where("id", $alunoclasse->aluno_classe_id)
        ->whereNotNull("codigo_AC")
        ->first();

    if ($dadoAc) {
        return $dadoAc->codigo_AC;
    }

    // 🔹 2. Gerar novo código
    $ano = anolectivo::find($alunoclasse->anolectivo_id)?->anolectivo ?? now()->year;
    $ultimoDigitoAno = substr((string) $ano, -1);

    $classeFormatada = str_pad($alunoclasse->classe_id, 2, '0', STR_PAD_LEFT);

    // Buscar último código
   $ultimo = alunoClasse::where("anolectivo_id", $alunoclasse->anolectivo_id)
    ->where('classe_id', $alunoclasse->classe_id)
    ->whereNotNull("codigo_AC")
    ->orderBy("codigo_AC", "desc")
    ->first();
    if ($ultimo) {
        $ultimoNumero = (int) substr($ultimo->codigo_AC, -3);
        $incremento = $ultimoNumero + 1;
    } else {
        $incremento = 1;
    }

    $sequencial = str_pad($incremento, 3, '0', STR_PAD_LEFT);
    $codigoBase = $ultimoDigitoAno . $classeFormatada . $sequencial;

    // 🔹 3. Atualizar
    alunoClasse::where("id", $alunoclasse->aluno_classe_id)
        ->update(["codigo_AC" => $codigoBase]);

    return $codigoBase;
}









public function GerarReferencias($dados, $bancoId)
{
    $bancos = DB::table('bancos')->where('id', $bancoId)->get();
    $mes1 = Carbon::parse($dados->data_Fim)->format('m');
    $referencia="";
    $flagMulta=0;
    $valor= $dados->valorDescricao ;
    // Verifica se data expirou e tem multa
    if (Carbon::parse($dados->data_Fim)->isPast() && $dados->multaP > 0) {
        // Exemplo: aplicar multa
        $valor = $dados->valorDescricao + (($dados->multaP/100)* $dados->valorDescricao);
        $mes1 = DB::table("corespondeciameses")->where("id", $mes1)->first()->ccorespondente_ID;
        $flagMulta=1;
    }

    // dd($dados);

     foreach ($bancos as $banco) {
            $entidade = $banco->Entidade;

            $mes1 = str_pad($mes1, 2, '0', STR_PAD_LEFT);
          // Gera a referência conforme o banco

            if ($banco->descricao === 'BIM') {
                $referencia = ReferenciaBIMHelper::gerarReferencia($entidade,$dados->tipo_pagamento_id.$dados->codigo_AC,$mes1,$valor);
                 referenciasbancaria::updateOrCreate(
                [
        "tipo_pagamento_id"=>$dados->idtabelavalores,
        "referencia"=>$referencia,
        "aluno_classe_id"=>$dados->aluno_classe_id,
        "mes_id"=>$dados->mes_id],["banco_id"=>$banco->id,
        "Multa" =>$flagMulta
] );
                }
                // se tiver outros bancos para adicionar aque


            }

}





}
