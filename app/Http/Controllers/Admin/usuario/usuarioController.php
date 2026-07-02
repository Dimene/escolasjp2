<?php

namespace App\Http\Controllers\Admin\usuario;

use App\Http\Controllers\Controller;
use App\Http\Requests\usuariosrequest;
use App\Http\Requests\usuariosupdaterequest;
use App\Models\Admin\categoria;
use App\Models\Admin\observadorSys;
use App\Models\Admin\user_categorias;
use App\Models\registoAcademico\Aluno;
use App\Models\registoAcademico\alunoClasse;
use App\Models\registoAcademico\anolectivo;
use App\Models\registoAcademico\mensalidade;
use App\Models\registoAcademico\nivel;
use App\Models\role_user;
use App\sgdpolice\produto_apreiendido;
use App\Models\User;
use Auth;
use App\Models\role;
use App\Observers\userObserver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Illuminate\Support\Facades\Hash;


class usuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     protected $usuario;
     protected $roles;
     protected $categoria;

    public function index()
    {

        $usuario =User::with(['nivel','categoria'])->get();
      return view('auth.usuario-funcionario',compact('usuario'));



    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    { $roles=role::orderBy('id', 'DESC')->get();
       $categoria=categoria::all();
$anolectivo=anolectivo::orderBy('id', 'DESC')->get();
$nivel=nivel::all();
        return view("auth.register-usuario",compact('roles','categoria','anolectivo','nivel'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(usuariosrequest $request)
    {

       // $anolectivo =anolectivo::orderBy('id', 'DESC');();


        if(
            auth()->user()->can("Registar-usuario")
        ):
     $usuarioFuncionario =   User::UpdateOrcreate([
            'name' =>$request->name,
            'email' =>$request->email ],[
                'remember_token' =>$request->_token,
                'cargo_id' =>$request->categoria,
                'Nivel_id' =>$request->Nivel,
                'sexo' =>$request->sexo,

            'password' =>Hash::make("1234567890") ,
            ]);

user_categorias::updateOrCreate(
    ['user_id' => $usuarioFuncionario->id,'anolectivo_id' => $request->anolectivo_id],
    ['categoria_id' => $request->categoria]

);



// guadar permissoes

role_user::updateOrCreate(
    ['user_id' =>$usuarioFuncionario->id],
    ['role_id' =>$request->role]
);

    $mensage='registo bem sucedido';
    $sucess="sucesso";
    return redirect()->route('Usuarios.create',
        compact('mensage','sucess'));






        else:
            $mensagem ="nao possue a permissao de Registar novo usuario";
        return view("Componetes.alerta-Falha",compact('mensagem'));
        endif;


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id){
        $usuario=User::where('id',$id)->first();;
        $roles=role::all();
        // dd($usuario);
            return view('auth.apagar-usuario', compact('usuario','roles'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        if (auth()->user()->can('Edit_user')) {
            $usuario=User::where('id',$id)->with(['categoria','roles','anolectivo'])->first();;
            $roles=role::all();
$anolectivo=anolectivo::orderBy('id', 'DESC')->get();
$categoria=categoria::all();
$nivel=nivel::all();

                return view('auth.edit-usuario', compact('usuario','roles','categoria','anolectivo','nivel'));
        }
      else {
          $mensagem="nao tens permisao em realizar esta operacao";
          return view('Componetes.alerta-Falha',compact('mensagem'));

        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(usuariosupdaterequest $request, $id)
    {


       if(auth()->user()->can('Atualizar-Usuario')){
$update =User::where('id', $id)
            ->update([ 'name' =>$request->name ,
          'remember_token' =>$request->_token ,
            'password' =>Hash::make("1234567890"),
            'email' =>$request->email,
            "cargo_id"=>$request->categoria,
            "Nivel_id"=>$request->Nivel,
            "sexo"=>$request->sexo,
        ]);


            user_categorias::updateOrCreate(
                ['user_id' => $id,'anolectivo_id' => $request->anolectivo_id],
                ['categoria_id' => $request->categoria]

            );


// guadar permissoes

            role_user::updateOrCreate(
                ['user_id' =>$id],
                ['role_id' =>$request->role]
            );
            if($update){
                if(isset($request['avatar-file'])){

                    $fotoAvatart=$this->usuario->find($id)->Avatar;
                    Storage::delete('profile/'.$fotoAvatart);

                    $fileImg=$request['avatar-file'];
                        $nomeimage=  $id.$request->email.".".$fileImg->extension();
                        $request['avatar-file']->storeAs('profile',$nomeimage);

                        // atualizar avatar



                        User::where('id',$id ) ->update(['avatar' =>$nomeimage]);


                        // guadar permissoes

                }



            }
            $usuario= auth()->user()->id;

            observadorSys::updateOrCreate(['user_id' =>$usuario,
            'action'=>'updated',
            'register'=>$id,
            'model'=>'user'],['user_id' =>$usuario,
            'action'=>'update',
            'register'=>$id,
            'model'=>'user']);

            if(role_user::where('user_id', $id)
            ->update(['role_id' =>$request->role])){
return redirect()->route('Usuarios.funcionarios');
            }
            return redirect()->route('Usuarios.funcionarios');



    }

    else{

        $mensagem="nao tens permisao em realizar esta operacao";
        return view('Componetes.alerta-Falha',compact('mensagem'));



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
        if (auth()->user()->can('Apagar-usuario')){
 $usuario=User::where('id',$id)->delete();
 $usuario= auth()->user()->id;



 observadorSys::updateOrCreate(['user_id' =>$usuario,
            'action'=>'delete',
            'register'=>$id,
            'model'=>'user'],['user_id' =>$usuario,
            'action'=>'deleted',
            'register'=>$id,
            'model'=>'user']);

return redirect('/admin/Usuarios');
        }
        else{

$mensagem= "nao tens permisao em realizar esta operacao";
return view('Componetes.alerta-Falha',compact('mensagem'));



        }

    }

public function perfil()
{
 return view('auth.perfil-usuario');
}


public function AtualizarPerfil(usuariosrequest $request, $id){


$update =$this->usuario::where('id', $id)
->update([ 'name' =>$request->name ,
'remember_token' =>$request->_token ,
'Codigo' =>$request->codigo ,
'email' =>$request->email ]);

if($update){
    if(isset($request['avatar-file'])){


        $fotoAvatart=$this->usuario->find($id)->Avatar;
       //dd($fotoAvatart);
       //APAGAR a foto existente
       Storage::delete('profile/'.$fotoAvatart);  ;


        $fileImg=$request['avatar-file'];
            $nomeimage=  $id.$request->email.".".$fileImg->extension();

            $request['avatar-file']->storeAs('profile',$nomeimage);

            // atualizar avatar



            User::where('id',$id ) ->update(['avatar' =>$nomeimage]);


            // guadar permissoes

    }

    $usuario=User::where('id',$id)->delete();
    $usuario= auth()->user()->id;
    observadorSys::updateOrCreate(['user_id' =>$usuario,
    'action'=>'update',
    'register'=>$id,
    'model'=>'user'],
    ['user_id' =>$usuario,
    'action'=>'update',
    'register'=>$id,
    'model'=>'user']);

}


return redirect()->back();
}



public function Atualizarsenha($id) {


    $usuario=User::where('id',$id)->first();;
        $roles=$this->roles;

return  view("auth.Atualizarsenha", compact('usuario'));
}



public function fecharConta(request $request){

    $usuario = auth()->user()->id;

    $iddado=     DB::table('fechamentocontas')->where('user_id',$usuario)->latest('created_at')->first();


    DB::update('update fechamentocontas set saida =(select current_timestamp()) where id = ?', [$iddado->id]);


    Auth::logout();
    return redirect()->route('fecharConta.show',$usuario);

}





//  atualizar a senhas

public function updatesenha(Request $request, $id)
{

    $update =$this->usuario::where('id', $id)
            ->update([ 'password' =>Hash::make($request->senha)]);

            $usuario= auth()->user()->id;

            observadorSys::updateOrCreate(['user_id' =>$usuario,
            'action'=>'update',
            'register'=>$id,
            'model'=>'user'],['user_id' =>$usuario,
            'action'=>'update',
            'register'=>$id,
            'model'=>'user']);

return redirect()->back();
}

public function observadorIndex(){
    $usuario=User::all();
return view('Admin.ACL.oberver-index',compact('usuario'));
}



public function operacoesshow($id){

    $oberveroperacoes= observadorSys::where('user_id',$id)->get();
return view('Admin.ACL.oberver-lista',compact('oberveroperacoes'));
}



public function detalhes($id){


$oberveroperacoes= observadorSys::where('register',$id)->first();


if($oberveroperacoes->model=="Aluno"&& $oberveroperacoes->action=="deleted"){



$alunodadosaida=alunoClasse::onlyTrashed()
    ->where('id', $id)
    ->first();


if( empty($alunodadosaida)){
    $flag=1;
    if(auth()->user()->can("Ver-Aluno")):
        $aluno= DB::table('alunosescritos')->where('idAlunoclasse',$id)->where('anolectivo_id',$ano)->first();
$ano=$aluno->anolectivo_id;
      $dadoMesalidades=  DB::table('mensalidadesView')->where('aluno_classe_id',$id)->where('anolectivo_id',$ano)->get();
      $contactos=  DB::table('contactos')->where('encaregado_id',$aluno->Encaregado_id)->get();



          return view('registoAcademico.Visualizar-dados-Recibocheio',compact('aluno','flag','dadoMesalidades','contactos','ano'));
        else:
          $mensagem ="nao possue a permissao de  Ver dados do aluno";
      return view("Componetes.alerta-Falha",compact('mensagem'));
        endif;


}
else{
    $ano=$alunodadosaida->anolectivo_id;


    $flag=2;
    if(auth()->user()->can("Ver-Aluno")):
        $aluno= DB::table('alunosinscritosApagados')->where('idAlunoclasse',$id)->where('anolectivo_id',$ano)->first();

      $dadoMesalidades=  DB::table('mensalidadesView')->where('aluno_classe_id',$id)->where('anolectivo_id',$ano)->get();
      $contactos=  DB::table('contactos')->where('encaregado_id',$aluno->Encaregado_id)->get();



          return view('registoAcademico.Visualizar-dados-Recibocheio',compact('aluno','flag','dadoMesalidades','contactos','ano'));
        else:
          $mensagem ="nao possue a permissao de  Ver dados do aluno";
      return view("Componetes.alerta-Falha",compact('mensagem'));
        endif;





}
}
if($oberveroperacoes->model=="Aluno"&& $oberveroperacoes->action=="update"
||$oberveroperacoes->model=="Aluno"&& $oberveroperacoes->action=="create"
||$oberveroperacoes->model=="Aluno"&& $oberveroperacoes->action=="atualizar_matricula"
){


$alunoClasse=alunoClasse::where('id', $id)->first();


   return redirect()->route('aluno.edititaer',[$alunoClasse->aluno_id,$alunoClasse->anolectivo]);

}
if(($oberveroperacoes->model=="user"&& $oberveroperacoes->action=="update")||($oberveroperacoes->model=="user"&& $oberveroperacoes->action=="updated")){
    return redirect()->Route('Usuarios.edit',$id);
}
    if($oberveroperacoes->model=="user"&& $oberveroperacoes->action=="deleted"){
 $usuario=User::onlyTrashed()
    ->where('id', $id)
    ->first();


if(empty($usuario)){

    return redirect()->Route('Usuarios.edit',$id);
}
    if (auth()->user()->can('Edit_user')) {
        $roles=$this->roles;
        // dd($usuario);


        $trashed="1";
            return view('auth.edit-usuario', compact('usuario','roles','trashed'));
    }
  else {
      $mensagem="nao tens permisao em realizar esta operacao";
      return view('Componetes.alerta-Falha',compact('mensagem'));

    }



    // recuperar usuario apagado



}


if($oberveroperacoes->model=="Mensalidade"&& $oberveroperacoes->action=="update"
    ||$oberveroperacoes->model=="Mensalidade"&& $oberveroperacoes->action=="create"
    ||$oberveroperacoes->model=="Mensalidade"&& $oberveroperacoes->action=="atualizar_matricula"
    ){


        $dados= DB::table('mensalidadesview')->where('idmensalidademes',$id)->first();


        return view('Admin.ACL.oberver-mensalidade-historico',compact( 'dados'));

    }

}

public function userrestore($id){
$usuario=User::onlyTrashed()
    ->where('id', $id);
    $usuario->restore();

    return redirect()->Route('Usuarios.funcionarios');
}

}


