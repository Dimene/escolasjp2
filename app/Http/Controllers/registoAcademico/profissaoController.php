<?php

namespace App\Http\Controllers\registoAcademico;

use App\Http\Controllers\Controller;
use App\Models\registoAcademico\Doenca;
use App\Models\registoAcademico\encaregado;
use App\Models\registoAcademico\profissao;
use App\Models\registoAcademico\religiao;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class profissaoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

      public function store($request)
     {

  $profisaostore= profissao::updateOrCreate(['Descricao' =>ucwords($request)],
  ['Descricao' => ucwords($request)]);

  return $profisaostore;
     }

     public function getid($nome){

     return   profissao::where('Descricao',strtolower($nome))->first();
     }

     public  function organizarvar($var){
        $var=explode(" ",trim(ucwords($var)));
        $frase="";
      for($x=0;$x< count($var);$x++){
        $frase=$frase.$var[$x];
        if($x<(count($var)-1)){
            $frase=$frase." ";
        }



      }
    return $frase;
     }
     public function doencas($request){
$doenca= Doenca::firstOrCreate(
    ['nome' =>ucwords($request)],
    ['nome' =>ucwords($request)]

);
return $doenca;
     }
 public function datanascimento($request){


$doenca=$datanacimento=Carbon::create(strtolower($request));

return $doenca;
     }



     public function resultadoguardar($dadosrelatorio){

        return route('aluno.dadosAlunosAno');
     }



     public  function religiao($reli){
        $religiao = religiao::firstOrCreate(
            ['nome' => $reli],
            ['nome' => $reli]
        );
        return   $religiao ;
     }


     public function encaregado($nome,$reli,$sexo,$profisao){
        $nome=$this->organizarvar($nome);
        $religiao =$this->religiao($this->organizarvar($reli))->id;
        $sexo=$this->organizarvar($sexo);
 /*$encaregdoid = encaregado::where("nome",$nome)
            ->where("profissao_id",$profisao)->
            where("religiae_id", $religiao)->
            where("sexo",$sexo)->first();

            dd($encaregdoid);*/

            $encarego=encaregado::where('id',1620)->get();
            dd($encarego);
            if(empty($encaregdoid)){




           $encaregdo = encaregado::create(
            [
            "nome" => $this->organizarvar($nome),
            "profissao_id" => $profisao,
            "religiae_id" => $this->religiao($this->organizarvar($reli))->id,
            "sexo"=>$this->organizarvar($sexo)
            ]
        );



           $encaregdoid= $encaregdo;
            }

            return $encaregdoid;

    }


    public function guadardados($dados){

        dd($dados);
    }

}
