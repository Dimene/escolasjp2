<?php

namespace App\Models\registoAcademico;

use App\Models\RegistoAcademico\TipoDocencia;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class classe extends Model
{
    use HasFactory;

    protected $fillable=[
        "Descricao",
        "Tipo_Docencia_id",
        "FormaTrasitar_id",
        "Directo_id","Pedagogico_id","Exame"
    ];


    public function disciplinas(){
return $this->belongsToMany(disciplinas::class,'classe_disciplinas','classe_id','disciplina_id');
    }

public function turmas(){
   return $this->hasMany(turma::class,"classe_id","id");
}

public function tipoDocencia(){
    return $this->hasOne(TipoDocencia::class,"id","Tipo_Docencia_id");
}

public function Director(){
    return $this->hasOne(User::class,"id","Directo_id");
}

public function Pedagogico(){
    return $this->hasOne(User::class,"id","Pedagogico_id");
}

}
