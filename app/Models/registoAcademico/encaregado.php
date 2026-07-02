<?php

namespace App\Models\registoAcademico;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\registoAcademico\profissao;
use App\Models\registoAcademico\contacto;
use App\Models\registoAcademico\religiao;

class encaregado extends Model
{
    use HasFactory;
protected $table="encaregados";
protected $fillable=[
    "nome","profissao_id",
    "religiae_id",
"sexo",

];


public function profissao(){
    return $this->hasOne(profissao::class,'id','profissao_id');
}
public function religiao(){
    return $this->hasOne(religiao::class,'id','religiae_id');
}






  public function contacto()
  {
      return $this->hasMany(contacto::class, 'encaregado_id', 'id');
  }


}
