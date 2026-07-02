<?php

namespace App\Http\Controllers\registoAcademico;

use App\Http\Controllers\Controller;
use App\Models\registoAcademico\anolectivo;
use App\Models\registoAcademico\classe;
use App\Models\registoAcademico\meses;
use App\Models\registoAcademico\tipos_pagamentos;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class efetuarPagamentoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show( $id=null)
    {

// dd($id);



        // $tipoPagamento = tipos_pagamentos::where('Descricao', $id)->get();
        $tipojanela=1;
  // 2. Buscar dados com filtros
    $dados = DB::table('detalhestabelavaores')
        ->where("tipo",'>',2)
        // ->where('tipo_janela', 1)
        ->get();


        // 1. Obter ano letivo ordenado
    $anolectivo = Anolectivo::orderBy('anolectivo', 'desc')->get();
    $anoAtualId = $anolectivo->first()?->id; // Protege contra null


    // 3. Filtrar dados pelo ano letivo atual
    $dadosAno = $dados->where('anolectivo_id', $anoAtualId);


    // 4. Tipos de pagamento únicos
    // $tipoPagamento =  $dadosAno->unique('tipo')->values();
// dd($tipoPagamento);

    // 5. Classes e meses únicos
    $classeIn = $dadosAno->pluck('classe_id')->unique()->toArray();
    $mesidIn = $dadosAno->pluck('mes')->unique()->toArray();

    // 6. Buscar classes e meses
    $classes = Classe::all();
    $meses = Meses::whereIn('id', $mesidIn)->get();

    // 7. Enviar para a view
    $dados=$dadosAno;

        return view(
            'registoAcademico.outrosPagamento.outros-pagamentosShowIndex',
            compact('anolectivo', 'meses', 'classes','tipojanela','dados')
        );
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
        //
    }




    public function relatorio($id=null){
        $ano =  DB::select("SELECT  * from anolectivos  order by(id) desc");
        $classe =  DB::select("SELECT  * from classes");
$tipoPagamento=tipos_pagamentos::where('id','>',2)->get();
        $data = Carbon::now()->format('m/d/') . "20" . Carbon::now()->format('y');



        return view("registoAcademico.outrosPagamento.relatoriospagamentos.relatorio-pagamentos-index", compact('classe', 'ano', 'data','tipoPagamento'));

    }



    public function relatoriogenerico($id=null){
        $anolectivos = DB::select("SELECT * FROM anolectivos ORDER BY id DESC");
        $classes = DB::table('classes')->get();
        $tipoPagamento=tipos_pagamentos::where('id',">",2)->get();
        return view("registoAcademico.outrosPagamento.relatorio-mensalidades", compact('anolectivos', 'classes', 'tipoPagamento')
        );
    }

}
