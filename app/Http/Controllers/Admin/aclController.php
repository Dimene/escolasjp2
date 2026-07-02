<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\modelopagamento;
use App\Models\role;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Models\permission;
use App\Models\role_user;
class aclController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

public $Funcois;

    public function index()
    {
      //  $Funcois=$this->Funcois;
         $Funcois = role::with('permission')->get();
    return view('Admin.ACL.Permissons-lista',compact('Funcois'));
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

    $dadosform= $request->all();
   $result= role::create([
        'name' =>$request['nomeFuncao'],
        'label' =>$request['DiscricaoFuncao'],
    ]);


    if( $result){
        return redirect()->route('Admin.permissons.lista')->with('sucess','Funcao guradara com sucesso');
    }
    else{
        return redirect()->back()->with('error','Erro ao guadar a funcao');
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

        $update = role::find($id);
    //   / dd(  $update);
      // return redirect()->route('Admin.permissons.lista',compact('update'));
      $Funcois= role::with('permission')->get();
        return view('Admin.ACL.Permissons-lista',compact('Funcois','update'));

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
      $role= role::find($id);

    $atualizar=   $role->update([
        'name' =>$request['nomeFuncao'],
        'label' =>$request['DiscricaoFuncao'],
       ]);
       if( $atualizar){

        return redirect()->route('Admin.permissons.lista')->with('sucess','Funcao Atualizada com sucesso');
    }
    else{
        return redirect()->back()->with('error','Erro ao Atuazar a funcao');
    }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $resultado = role::destroy($id);

        if($resultado)
        {
         return redirect()->route('Admin.permissons.lista')->with('sucess','Funcao Apagada com sucesso');
        }
        else{
            return redirect()->back()->with('error','Erro ao Apagar a funcao');

    }
}




//adicioanr mais

public function papelEdit($id){
    $Funcois = role::with('permission')->where('id',$id)
    ->get();
    $permissions=permission::all();


    $modals =modelopagamento::with("permission")->get();
Return view("Admin.ACL.permissao-addicionar",
compact('Funcois','permissions','modals'));
}

public function permissaoAdincionarpapel(Request $request){
$dadosform=$request->all();

DB::table('permission_role')->where('role_id',$dadosform['idFuncao'])->delete();

if(isset($dadosform['elementosdepermissaoporpapel'])):
$var= count($dadosform['elementosdepermissaoporpapel']);
echo $var;
for($x=0;$x<$var;$x++){
    DB::insert('insert into permission_role (permission_id,role_id) values (?, ?)',
    [$dadosform['elementosdepermissaoporpapel'][$x],$dadosform['idFuncao']]);
}
endif;
return redirect()->route('Admin.permissons.lista')->with('sucess','permissoes adicionadas   com sucesso');
}




public function  Editusuario($id){

$usuarios= DB::table('users')->where('id',$id )->first();

$permissions=role::all();
$roleuser= DB::table('role_user')->where('user_id',$id)->get();
return view('Admin.ACL.permissao-usuario',compact('usuarios','permissions','roleuser'));
}


 public function adicionarprevilegiouser(Request $request){
$dadosform = $request->all();

// DB::delete('delete role_user where user_id = ?', ]);
    DB::table('role_user')
    ->where('user_id','=',$dadosform['usuario'])
    ->delete();
$sizeArray=count($dadosform['permissons']);
for($x=0;$x<$sizeArray; $x++){

DB::insert('insert into role_user (user_id, role_id) values (?, ?)',
 [$dadosform['usuario'], $dadosform['permissons'][$x] ]);
 return redirect()->route('Admin.usario.lista')->with('sucess','permissoes adicionadas   ao '.$dadosform['usuarioNome']);

}

}
}

