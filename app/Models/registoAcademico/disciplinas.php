<?php

namespace App\Models\registoAcademico;

use App\Models\Models\registoAcademico\TipoDisciplina;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class disciplinas extends Model
{
    use HasFactory;

    protected $table="disciplinas";
    protected $fillable=['Descricao',"Sigla","Tipo"];


public function tipodisciplina(){
        return $this->hasOne(TipoDisciplina::class,"id","Tipo");
    }


}
