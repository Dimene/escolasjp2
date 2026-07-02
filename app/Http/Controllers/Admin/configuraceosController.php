<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Admin\configuraceos;

class configuraceosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("Admin.ACL.configuracoes");
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
    public function store(Request $request){

  $guardar=configuraceos::where('id',1)
              ->update([
                  'Contacto' =>$request->Contacto,
                  'Contacto2' =>$request->Contacto2,
              'nome' =>$request->Nome,
      'NUit' =>$request->NUit,
      'Email' =>$request->email,
      'Localizacao' =>$request->endereco,]);


  if($guardar){

    if($request["avatar-file"]!=null):
        if($request->file("avatar-file")->isValid()){
           echo   $nome="logoTipo.".$request->file("avatar-file")->extension();
           $request->file("avatar-file")->storeAs('logoMarca',$nome); }
           $guardar=configuraceos::where('id',1)
           ->update(["avatar"=>$nome]);

        endif;

        $conf= configuraceos::first();

            return redirect()->back();
    }

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
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    $conf= configuraceos::first();
//    / dd($conf);
    return view('Admin.ACL.configuracoes',compact('conf'));
    }

    public function licenca(){
        $conf= configuraceos::first();

return view('Admin.ACL.lincenca',compact('conf'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


     public function guardar_senha(Request $request ){
        $conf= configuraceos::first();
    //  /   dd($request->all());

        $senhai= md5( $conf->nome."Dimene"."linktech"."30".date('m'));

$array=str_split(strtoupper($senhai));


$contador=0;
$senha="";
for($x=0; $x<count($array);$x++){


	 if($contador==4 && $x<count($array)){
		 $senha=$senha."-";
		 $contador=0;
	 }
$senha= $senha. $array[$x] ;
	 $contador++;

}
$senhaValidar=
$request->serie[0]."-".
$request->serie[1]."-".
$request->serie[2]."-".
$request->serie[3]."-".
$request->serie[4]."-".
$request->serie[5]."-".
$request->serie[6]."-".
$request->serie[7];
if($senha==$senhaValidar){
    //$datalicenca=   Storage::disk('public')->put('file.txt', );
    $dadoString=strtotime(Carbon::now()->addDays(30));
    configuraceos::where('id',1)->update(['datakey'=>$dadoString]);
return redirect("/");


}
else{
    return redirect()->back();
}

     }
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

    public function getLogoMarca(){

        return  configuraceos::first();
    }
}
