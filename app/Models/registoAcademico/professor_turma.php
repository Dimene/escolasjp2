<?php

namespace App\Models\registoAcademico;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class professor_turma extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table="professor_turma";
    protected $fillable =[
        "professor_id",
        "turma_id",
        "disciplina_id",
        "anoLectivo",
        "classe_id"
    ];





    public function Docente(){
        return $this->hasOne(User::class,'id','professor_id');
    }



    public function turma(){
          return $this->hasOne(turma::class,'id','turma_id');
    }

    public function classe(){
          return $this->hasOne(classe::class,'id','turma_id');
    }


}
