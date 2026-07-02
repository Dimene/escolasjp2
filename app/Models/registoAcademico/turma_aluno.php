<?php

namespace App\Models\registoAcademico;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class turma_aluno extends Model
{
    use HasFactory;
    protected $table="turma_alunos";
    protected $fillable=[
        'turma_id','aluno_classe_id','Numero_turma','jurri','Numero_jurri'
    ];



    public function alunoclass()
    {
        return $this->hasOne(alunoClasse::class,'id','aluno_classe_id');

    }
    public function notasdefrequencia(){
return $this->hasMany(nota::class,'aluno_classe_id','aluno_classe_id');
    }
  public function turma(){
return $this->hasOne(turma::class,'id','turma_id');
    }



}
