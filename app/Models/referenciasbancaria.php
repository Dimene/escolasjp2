<?php

namespace App\Models;

use App\Models\registoAcademico\alunoClasse;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class referenciasbancaria extends Model
{
    use HasFactory;
    protected $table="referenciasbancarias";
    protected $fillable=[
        "tipo_pagamento_id",
        "referencia",
        "aluno_classe_id",
        "mes_id",
        "banco_id",
         "Multa"
    ];


    public function alunos(){
        return $this->belongsToMany(alunos::class, 'aluno_classes','aluno_classe_id','aluno_id');
    }

}
