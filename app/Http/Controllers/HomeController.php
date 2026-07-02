<?php

namespace App\Http\Controllers;

use App\Models\detalhestabelavalores;
use App\Models\registoAcademico\anolectivo;
use App\Models\registoAcademico\tipos_pagamentos;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use App\Models\registoAcademico\alunoClasse;
use App\Models\registoAcademico\classe;
use App\Models\registoAcademico\outros_pagamentos;
use App\Models\registoAcademico\tabela_valore;


class HomeController extends Controller
{
    private $cacheTimeout = 3600; // Cache de 1 hora

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // Cache para dados que não mudam com frequência
        $tipodepagamento = Cache::remember('tipos_pagamentos', $this->cacheTimeout, function () {
            return DB::table('tipos_pagamentos')->get();
        });

        $tipodepagamentofirst = Cache::remember('tipos_pagamentos_first', $this->cacheTimeout, function () {
            return DB::table('tipos_pagamentos')->where('id', ">", 2)->first();
        });

        $anolectivo = Cache::remember('ano_lectivo_list', $this->cacheTimeout, function () {
            return anolectivo::all();
        });

        $ano = optional(anolectivo::latest('id')->first())->id ?? 0;

        $tipo = DB::table('detalhestabelavaores')
            ->where("anolectivo_id", $ano)
            ->where('tipo', ">", 2)
            ->value('tipo') ?? 0;

        return view('home-index', compact('anolectivo', 'tipodepagamento', 'tipodepagamentofirst'));
    }




 public function homedados($ano, $data1, $data2, $tipo)
{
    if($tipo < 3){
	return	$this->homedadosMatricula($ano, $data1, $data2, $tipo);
	}
	else{
		return $this->homedadospagamentos($ano, $data1, $data2, $tipo);
	}


}

 public function homedadosMatricula($ano, $data1, $data2, $tipo)
{
    $inicio = Carbon::parse($data1, 'Africa/Maputo')->startOfDay();
    $fim    = Carbon::parse($data2, 'Africa/Maputo')->endOfDay();

    $tipodescricao = tipos_pagamentos::where("id", $tipo)->first();
    $tabelavalres = tabela_valore::where("Descricao", $tipodescricao->Descricao)
        ->where("anolectivo_id", $ano)
        ->get();



        $dados = DB::table("alunosescritos")->whereIn("tipo_Pagamento_id", $tabelavalres->pluck("id"))
            ->where("TIPOSAIDAa",null)
            ->get()->map(function ($item) {

            // padronizar data
            $item->limite = Carbon::parse($item->limite);
 $item->updated_at = Carbon::parse($item->updated_at);
            // padronizar estado
            $item->Estado_Classe = trim(ucfirst(strtolower($item->Estado_Classe)));

            return $item;
        });




    // ===============================
    // DIÁRIAS
    // ===============================
    $diarias = $dados->filter(function ($item) use ($inicio, $fim) {
        return $item->updated_at->between($inicio, $fim)
            && is_null($item->TIPOSAIDAa)
             && $item->Estado_Classe=="Activo";
    });

    // dd($diarias,$inicio, $fim);
    // ===============================
    // MENSAL
    // ===============================
    $mesal = $dados->filter(function ($item) use ($inicio, $fim) {

        return $item->updated_at->between($inicio, $fim)
         && is_null($item->TIPOSAIDAa)
            && $item->Estado_Classe=="Activo";
    });

    // ===============================
    // TOTAL
    // ===============================
    $total = $dados;

    $totalpago = $dados->where('Estado_Classe', 'Activo');

    // ===============================
    // CONTAGENS
    // ===============================
    $diariaNumero = $diarias->count();
    $mensalNumero = $mesal->count();
    $totalNumero  = $total->count();

    // ===============================
    // SOMAS
    // ===============================
    $diariavalor       = $diarias->sum('valorDescricao') ?? 0;
    $diariavalorMulta  = $diarias->sum('Multa') ?? 0;

    $mensalValor       = $mesal->sum('valorDescricao') ?? 0;
    $mensalValorMulta  = $mesal->sum('Multa') ?? 0;

    $totalValor        = $total->sum('valorDescricao') ?? 0;

    // ===============================
    // PERCENTAGEM
    // ===============================
    $percentagem = $totalNumero > 0
        ? ($totalpago->count() / $totalNumero) * 100
        : 0;

    // ===============================
    // GRÁFICO
    // ===============================
// Pré-agrupa os dados por classe_id para evitar where dentro do loop
$dadosPorClasse = $dados->groupBy('Classe_id');

$dadosGrafico = classe::all()->map(function ($classe) use ($dadosPorClasse) {

    // Pega os dados já filtrados pela classe
    $classeDados = $dadosPorClasse->get($classe->id, collect());


    return [
        'classe' => $classe->Descricao,
        'classe_id' => $classe->id,

        'pagos_activos' => $classeDados->where('Estado_Classe', 'Activo')->count(),
        'nao_pagos_pendentes' => $classeDados->where('Estado_Classe', 'Pendente')->count(),
        'multa' => $classeDados->where('Multa', '>', 0)->count(),
    ];
});


    // ===============================
    // RETORNO
    // ===============================



    return (object)[

        'Diarianumero' => $diariaNumero,
        'mensalNumero' => $mensalNumero,
        'totalNumero'  => $totalNumero,

        'dadoscobranca' => round($percentagem, 2),

        'Diariavalor' => $diariavalor,
        'mensalValor' => $mensalValor,
        'totalValor'  => $totalValor,

        'diariavalorMulta' => $diariavalorMulta,

        'Mensalivalor' => $mensalValor,
        'MensalivalorMulta' => $mensalValorMulta,

        'diariadetalhes' => $diarias->values(),

        'mensaldetalhes' => $mesal->values(),

        'esperadodetalhes' => $total->values(),

        'dadosGrafico' => $dadosGrafico->values(),
    ];


}

public function homedadospagamentos($ano, $data1, $data2, $tipo)
{
    /*
    |--------------------------------------------------------------------------
    | DATAS
    |--------------------------------------------------------------------------
    */
    $inicio = Carbon::parse($data1)->startOfDay();
    $fim    = Carbon::parse($data2)->endOfDay();

    /*
    |--------------------------------------------------------------------------
    | TIPO PAGAMENTO
    |--------------------------------------------------------------------------
    */
    $tipodescricao = tipos_pagamentos::find($tipo);

    if (!$tipodescricao) {
        return null;
    }

    /*
    |--------------------------------------------------------------------------
    | TABELA VALORES
    |--------------------------------------------------------------------------
    */
    $tabelavalores = tabela_valore::where('Descricao', $tipodescricao->Descricao)
        ->where('anolectivo_id', $ano)
        ->pluck('id');

    if ($tabelavalores->isEmpty()) {

        return (object)[
            'Diarianumero' => 0,
            'mensalNumero' => 0,
            'totalNumero' => 0,

            'dadoscobranca' => 0,

            'Diariavalor' => 0,
            'mensalValor' => 0,
            'totalValor' => 0,

            'diariavalorMulta' => 0,

            'Mensalivalor' => 0,
            'MensalivalorMulta' => 0,

            'diariadetalhes' => collect(),
            'mensaldetalhes' => collect(),
            'esperadodetalhes' => collect(),
            'dadosGrafico' => collect(),
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | BUSCAR DADOS
    |--------------------------------------------------------------------------
    */
    $dados = DB::table('outros_pagamentosview')
        ->whereIn('idtabelavalores', $tabelavalores)
        ->get()
        ->map(function ($item) {

            /*
            |--------------------------------------------------------------------------
            | PADRONIZAR DATA
            |--------------------------------------------------------------------------
            */
            $item->updated_at = Carbon::parse($item->updated_at);
 $item->data_Fim = Carbon::parse($item->data_Fim);
 $item->data_pagamento =Carbon::parse($item->data_pagamento);
            /*
            |--------------------------------------------------------------------------
            | PADRONIZAR ESTADO
            |--------------------------------------------------------------------------
            */
            $item->Estado = trim(mb_strtolower($item->Estado));

            return $item;
        });

    /*
    |--------------------------------------------------------------------------
    | PAGAMENTOS PAGOS
    |--------------------------------------------------------------------------
    */
    $pagos = $dados->filter(function ($item) {
        return $item->Estado === 'pago';
    });

    /*
    |--------------------------------------------------------------------------
    | DIÁRIAS
    |--------------------------------------------------------------------------
    */
    $diarias = $pagos->filter(function ($item) use ($inicio, $fim) {

        return $item->data_pagamento->between($inicio, $fim)
            && is_null($item->tipossaida_id);
    });

    /*
    |--------------------------------------------------------------------------
    | MENSAIS
    |--------------------------------------------------------------------------
    */
    $mensal = $pagos->filter(function ($item) use ($inicio, $fim) {

        return $item->data_Fim->between(
            $inicio->copy()->startOfMonth(),
            $fim->copy()->endOfMonth()
        );
    });

    /*
    |--------------------------------------------------------------------------
    | TOTAIS
    |--------------------------------------------------------------------------
    */
    $totalNumero = $dados->count();

    $totalPagoNumero = $pagos->count();

    /*
    |--------------------------------------------------------------------------
    | CONTAGENS
    |--------------------------------------------------------------------------
    */
    $diariaNumero = $diarias->count();

    $mensalNumero = $mensal->count();

    /*
    |--------------------------------------------------------------------------
    | VALORES DIÁRIOS
    |--------------------------------------------------------------------------
    */
    $diariavalor = $diarias->sum(function ($item) {
        return (float) ($item->valorDescricao ?? 0);
    });

    $diariavalorMulta = $diarias->sum(function ($item) {
        return (float) ($item->Multa ?? 0);
    });

    /*
    |--------------------------------------------------------------------------
    | VALORES MENSAIS
    |--------------------------------------------------------------------------
    */
    $mensalValor = $mensal->sum(function ($item) {
        return (float) ($item->valorDescricao ?? 0);
    });

    $mensalValorMulta = $mensal->sum(function ($item) {
        return (float) ($item->Multa ?? 0);
    });

    /*
    |--------------------------------------------------------------------------
    | TOTAL GERAL
    |--------------------------------------------------------------------------
    */
    $totalValor = $dados->sum(function ($item) {
        return (float) ($item->valorDescricao ?? 0);
    });

    /*
    |--------------------------------------------------------------------------
    | PERCENTAGEM COBRANÇA
    |--------------------------------------------------------------------------
    */
    $percentagem = $totalNumero > 0
        ? ($totalPagoNumero / $totalNumero) * 100
        : 0;

    /*
    |--------------------------------------------------------------------------
    | GRÁFICO POR CLASSE
    |--------------------------------------------------------------------------
    */
    $dadosGrafico = classe::select('id', 'Descricao')
        ->get()
        ->map(function ($classe) use ($dados) {

            $classeDados = $dados->where('classe_id', $classe->id);

            return [
                'classe' => $classe->Descricao,

                'classe_id' => $classe->id,

                'pagos_activos' => $classeDados
                    ->where('Estado', 'pago')
                    ->count(),

                'nao_pagos_pendentes' => $classeDados
                    ->filter(function ($item) {
                        return str_contains($item->Estado, 'não')
                            || str_contains($item->Estado, 'nao');
                    })
                    ->count(),

                'multa' => $classeDados
                    ->filter(function ($item) {
                        return (float) ($item->Multa ?? 0) > 0;
                    })
                    ->count(),
            ];
        });

    /*
    |--------------------------------------------------------------------------
    | RETORNO
    |--------------------------------------------------------------------------
    */
    return (object)[

        /*
        |--------------------------------------------------------------------------
        | QUANTIDADES
        |--------------------------------------------------------------------------
        */
        'Diarianumero' => $diariaNumero,

        'mensalNumero' => $mensalNumero,

        'totalNumero' => $totalNumero,

        /*
        |--------------------------------------------------------------------------
        | PERCENTAGEM
        |--------------------------------------------------------------------------
        */
        'dadoscobranca' => round($percentagem, 2),

        /*
        |--------------------------------------------------------------------------
        | VALORES
        |--------------------------------------------------------------------------
        */
        'Diariavalor' => round($diariavalor, 2),

        'mensalValor' => round($mensalValor, 2),

        'totalValor' => round($totalValor, 2),

        /*
        |--------------------------------------------------------------------------
        | MULTAS
        |--------------------------------------------------------------------------
        */
        'diariavalorMulta' => round($diariavalorMulta, 2),

        'Mensalivalor' => round($mensalValor, 2),

        'MensalivalorMulta' => round($mensalValorMulta, 2),

        /*
        |--------------------------------------------------------------------------
        | DETALHES
        |--------------------------------------------------------------------------
        */
        'diariadetalhes' => $diarias->values(),

        'mensaldetalhes' => $mensal->values(),

        'esperadodetalhes' => $dados->values(),

        /*
        |--------------------------------------------------------------------------
        | GRÁFICO
        |--------------------------------------------------------------------------
        */
        'dadosGrafico' => $dadosGrafico->values(),
    ];
}


public function relatorioPagamentos(Request $request)
{
    // Ano letivo padrão
    $anolectivo = anolectivo::orderBy('anolectivo', 'desc')->get();

    $ano = $request->get('ano', $anolectivo->first()?->id);
    $data1 = $request->get('data1', Carbon::now()->startOfMonth()->format('Y-m-d'));
    $data2 = $request->get('data2', Carbon::now()->endOfMonth()->format('Y-m-d'));
    $tipo = $request->get('tipo', 1);

    // Datas
    $inicio = Carbon::parse($data1, 'Africa/Maputo')->startOfDay();
    $fim = Carbon::parse($data2, 'Africa/Maputo')->endOfDay();

    $dados = collect();
    $pagamentos = null;

    // =========================
    // Carregar dados
    // =========================
    if ($tipo > 2) {

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
         'estado'=>$e->Estado,
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



    } else {

        $pagamentos = detalhestabelavalores::where('tipo', $tipo)
            ->where('anolectivo_id', $ano)
            ->with([
                'matriculas' => function ($q) use ($inicio, $fim) {
                    $q->where('estado', 'activo')
 ->whereNull('deleted_at')->with('metodopagamento')
                        ->whereBetween('updated_at', [$inicio, $fim]);

                }
            ])
            ->first();

        $pagamentos?->matriculas->map(function($e) use($dados,$pagamentos){
         $dados->push((object)["aluno_classe_id"=>$e->id,
         'nome'=>$e->aluno->nome,
         'classe_id'=>$e->classe_id,
         'classe'=>$e->classe->Descricao,
         'anolectivo_id'=>$e->anolectivo->id,
         'anolectivo'=>$e->anolectivo->anolectivo,
         'tipo_pagamento_id'=>$pagamentos->tipo,
         'tipo_pagamento_descricao'=>$pagamentos->Descricao,
         'valorDescricao'=>$pagamentos->valorDescricao,
         'data_pagamento'=>$e->data_pagamento,
         'data_Inicio'=>$e->data_inicio,
         'data_limite'=>$e->data_Fim,
         'Ntalao'=>$e->Ntalao,
         'estado'=>$e->estado,
         'Multa'=>$e->Multa,
         'mes_id'=>$e->mes()->id,
         'mes'=>$e->mes()->Descricao,
         'referencia'=>$e->referencia,
         'deleted_at'=>$e->deleted_at,
        //  'deleted_at'=>$e->deleted_at,
         'metodo_pagamento'=>$e->metodopagamento->id,
         'metodoPagDesc'=>$e->metodopagamento->Descricao,
         ]);

       });

    }


// dd($dados);

    // =========================
    // KPIs
    // =========================

    $valorUnitario = $pagamentos?->valorDescricao ?? 0;

    $totalGeral = $valorUnitario * $dados->count();

    $totalMultas = $dados->sum(function ($item) {
        return $item->Multa ?? $item->multa ?? 0;
    });

    $totalAlunos = $dados->unique('aluno_classe_id')->count();

    $mediaTicket = $dados->count()
        ? $totalGeral / $dados->count()
        : 0;

        $pagamentos=$dados;
    // =========================
    // Dados auxiliares
    // =========================

    $tipoPagamento = DB::table('tipos_pagamentos')
        ->where('id', $tipo)
        ->value('Descricao');

    $anoLectivo = anolectivo::where('id', $ano)
        ->value('anolectivo');

    $tipodepagamento = DB::table('tipos_pagamentos')
        ->whereNull('deleted_at')
        ->get();

    // =========================
    // View
    // =========================

    return view('Dashabord.finaceiro', compact(
        'pagamentos',
        'dados',
        'anolectivo',
        'tipodepagamento',
        'ano',
        'data1',
        'data2',
        'tipo',
        'tipoPagamento',
        'anoLectivo',
        'totalGeral',
        'totalMultas',
        'totalAlunos',
        'mediaTicket'
    ));
}
}
