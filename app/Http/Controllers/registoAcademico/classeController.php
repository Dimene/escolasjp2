<?php

namespace App\Http\Controllers\registoAcademico;

use App\Http\Controllers\Controller;
use App\Models\registoAcademico\classe_discplina;
use App\Models\registoAcademico\disciplinas;
use App\Models\registoAcademico\nota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class classeController extends Controller
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




    for($x=0; $x<count($request->disciplinas);$x++){

    classe_discplina::updateOrCreate(
        ['classe_id' => $request->classe_id,
        'disciplina_id' => $request->disciplinas[$x],
        'anolectivo_id' => $request->anolectivo,
    ],
         ['classe_id' => $request->classe_id, 'anolectivo_id' => $request->anolectivo,
        'disciplina_id' => $request->disciplinas[$x]],

         );



 }


$colectiondisciplinascomnotasnaclass=collect();
 $requestshow=classe_discplina::where('classe_id', $request->classe_id)
 ->where('anolectivo_id',$request->anolectivo)
 ->whereNotIn('disciplina_id',$request->disciplinas)->with(['disciplina','classe'])->get();
foreach($requestshow as $requesItem){
$selectdado=nota::where('classe_disciplina_id',$requesItem->id)->first();
if(!empty($selectdado)){
   $colectiondisciplinascomnotasnaclass->push($requesItem->disciplina);
}
else{
classe_discplina::where('id',$requesItem->id)->delete();
}
}

$alert="success";
if(!empty($colectiondisciplinascomnotasnaclass[0])){
$alert="warning";
}
return response()->json(['mensage'=>"Guardado com sucesso",
"classe"=>$request->classe_id,"alertaNaoapagado"=>$colectiondisciplinascomnotasnaclass,"alert"=>$alert]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id,$anolectivo)
    {

    $dados=DB::table('classes_disciplinasview')->
    where('classe_id',$id)
    ->where('anolectivo_id',$anolectivo)
    ->get();
    return response()->json($dados);


    }

    public function disciplinasclasse(string $id,$anolectivo)
    {

    $dados=DB::table('classes_disciplinasview')->
    where('classe_id',$id)
    ->where('anolectivo_id',$anolectivo)
    ->get();
    return response()->json($dados);


    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id, $anolectivo)
    {
        $dados=DB::table('classes_disciplinasview')
        ->where('anolectivo_id',$anolectivo)
        ->where('classe_id',$id)->get(['disciplina_id']);
        $colection =collect();
        foreach($dados as $Item){
$colection->push($Item->disciplina_id);
        }

$dados2="";
if(empty($colection)){
    $dados2=DB::table('disciplinas')->get();
}
else {
       $dados2=DB::table('disciplinas')->whereNotIn('id',$colection)->get();
}
        return response()->json($dados2);

    }


    public function disciplinas(string $id, $anolectivo)
    {
        $dados=DB::table('classes_disciplinasview')
        ->where('anolectivo_id',$anolectivo)
        ->where('classe_id',$id)->get(['disciplina_id']);
        $colection =collect();
        foreach($dados as $Item){
$colection->push($Item->disciplina_id);
        }

$dados2="";
if(empty($colection)){
    $dados2=DB::table('disciplinas')->get();
}
else {
       $dados2=DB::table('disciplinas')->whereNotIn('id',$colection)->get();
}
        return response()->json($dados2);

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



    public function guadar_disciplinas(Request $request){

        $alert="success";
		if($request->oldeclasseAtualizar==""){
		$id=disciplinas::where('Descricao',$request->oldeclasseAtualizar)->first();
		disciplinas::updateOrCreate(
    ['Descricao' => $request->Disciplina,
	'id'=>$id
	],
    ['Descricao' => $request->Disciplina,'id'=>$id
	]

);

		}
		else{
disciplinas::updateOrCreate(
    ['Descricao' => $request->Disciplina],
    ['Descricao' => $request->Disciplina]

);
		}
return response()->json(['mensage'=>"Guardado com sucesso",
"classe"=>$request->classe_id,"alertaNaoapagado"=>"","alert"=>$alert]);


    }
}
