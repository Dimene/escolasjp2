<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\configuraceos;
use Illuminate\Http\Request;

class configuracoesController extends Controller
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
public function store(Request $request)
{

    $guardar = configuraceos::where('id', 1)
        ->update([
            'Contacto' => $request->Contacto,
            'Contacto2' => $request->Contacto2,
            'nome' => $request->Nome,
            'NUit' => $request->NUit,
            'Email' => $request->email,
            'TIpoSistema' => $request->TIpoSistema,
            'nome_Empresa' => $request->nome_Empresa,
            'linkEmpresa' => $request->linkEmpresa,
            'Localizacao' => $request->endereco,
        ]);

    if ($guardar) {

        // Captura subdomínio
        $host = $request->getHost();
        $subdomain = explode('.', $host)[0];

        if ($request->hasFile('avatar-file')) {

            $file = $request->file('avatar-file');

            // Extensão sem depender de fileinfo
            $ext = strtolower($file->getClientOriginalExtension());

            // Validar extensões permitidas
            $permitidos = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

            if (in_array($ext, $permitidos)) {

                $nome = 'logoTipo.' . $ext;

                // Caminho da pasta
                $path = storage_path("app/public/{$subdomain}/logoMarca");

                // Criar pasta
                if (!file_exists($path)) {
                    mkdir($path, 0755, true);
                }

                // Mover arquivo
                $file->move($path, $nome);

                // Atualizar base de dados
                configuraceos::where('id', 1)
                    ->update(['avatar' => $nome]);

            } else {

                return redirect()->back()
                    ->with('error', 'Formato de imagem inválido.');

            }
        }

        return redirect()->back()
            ->with('success', 'Logo atualizada com sucesso!');
    }

    return redirect()->back()
        ->with('error', 'Erro ao atualizar.');
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
          // Captura o subdomínio (ex: cliente1.localhost)

    $host = request()->getHost();
        $subdomain = explode('.', $host)[0];
    $conf= configuraceos::first();
//    / dd($conf);
    return view('Admin.ACL.configuracoes',compact('conf','subdomain'));
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


public function configuracoesdeLayoutCor(Request $request){

    //     DB::table('Configlayout')->where->update(['label'])
    //    $dados = DB::table('Configlayout')->get();
    // return response()->json($dados);


    }
}
