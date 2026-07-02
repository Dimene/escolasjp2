<?php

namespace App\Models\registoAcademico;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class turma extends Model
{
    use HasFactory;
protected $table="turmas";
protected $fillable=[
    'Descricao',
    'classe_id',
    'ano_lecttivo_id',
];


public function classeturma(){
return $this->hasOne(classe::class,'id','classe_id');
}public function anolectivo(){
return $this->hasOne(anolectivo::class,'id','ano_lecttivo_id');
}

public function alunos(){
    return $this->hasMany(turma_aluno::class,'turma_id','id');
}
function professor(){

    return $this->belongsToMany(User::class,'professor_turma','turma_id','professor_id');
}



public function formulas()
{
    return $this->hasMany(mediasanuaistrimestralformula::class, 'turma', 'id');
}


}
