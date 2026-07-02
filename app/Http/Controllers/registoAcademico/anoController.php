<?php

namespace App\Http\Controllers\registoAcademico;

use App\Http\Controllers\Controller;
use App\Http\Requests\anolectivoRequest;
use App\Models\registoAcademico\anolectivo;
use App\Models\registoAcademico\anolectivo_meta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class anoController extends Controller
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
        $anoLectivo= anolectivo::all();
  return view("registoAcademico.Confugurar-ano",compact('anoLectivo'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

  //dd($request->all());
   $ano=  anolectivo::updateOrCreate([ 'anolectivo' =>$request->anolectivo,
   'Inicio' =>$request->Inicio_ano,
   'Fim' =>$request->Fim_ano,
   'modalidade' =>$request->modalidade

    ],[
        'anolectivo' =>$request->anolectivo, 'modalidade' =>$request->modalidade]);

        // dd($ano->id);

if($ano->id){


   for(  $n=0;$n<count($request->numero) ; $n++):
    $idano=$ano->id;
    $inicio=$request->Inicio[$n];
    $Fim=$request->Fim[$n];
    $numero=$request->numero[$n];



     anolectivo_meta::updateOrCreate([
    "divisao"=>$numero,
    "Inicio"=>$inicio,
    "Fim"=>$Fim,
    "anolectivo_id"=>$ano->id
    ],
     ["anolectivo_id"=>$ano->id,
    "divisao"=>$numero]);
   endfor;
}
 return redirect()->Route('ano.create');
}

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $dados= DB::table('alunosescritos')->where('anolectivo_id',$id)->get();
      $dadosAno= DB::table('anolectivos')->where('id',$id)->get();
      $dadosAnoLectivoDisao= DB::table('anolective_metas')->where('anolectivo_id',$id)->get();


        return view("registoAcademico.AnoLectivo_informacoes",compact('dados','dadosAno','dadosAnoLectivoDisao'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $anoLectivoEscolhido= anolectivo::where('id', $id)->with('modalidadeDivisao')->first();
        $anoLectivo= anolectivo::all();

        return  view('registoAcademico.Confugurar-ano-edit',compact('anoLectivoEscolhido','anoLectivo'));
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
        $ano=  anolectivo:: where('id',$id)->update([ 'anolectivo' =>$request->anolectivo,
        'Inicio' =>$request->Inicio_ano,
        'Fim' =>$request->Fim_ano,
        'modalidade' =>$request->modalidade

         ]);





            //anolectivo_meta::where('anolectivo_id',$id)->delete();
        for(  $n=0;$n<count($request->numero) ; $n++):

          anolectivo_meta::
          where('anolectivo_id',$id)
         -> where('id',$request->idDivisao[$n])
          ->update([
         "divisao"=>$request->numero[$n],
         "Inicio"=>$request->Inicio[$n],
         "Fim"=>$request->Fim[$n],
         "anolectivo_id"=>$id
         ]);
        endfor;
     $mensage="Atualizado com sucesso";
      return redirect()->Route('ano.edit',$id)->with( ['mensage' => $mensage] );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {




DB::table('anolective_metas')-> where('anolectivo_id', $id)->delete();
DB::table('anolectivos')-> where('id', $id)->delete();


return redirect()->Route('ano.create');
    }


}
