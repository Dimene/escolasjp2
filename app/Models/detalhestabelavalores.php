<?php

namespace App\Models;

use App\Models\registoAcademico\alunoClasse;
use App\Models\registoAcademico\mensalidade;
use App\Models\registoAcademico\outros_pagamentos;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class detalhestabelavalores extends Model
{
    use HasFactory;

    protected $table="detalhes2";
protected $fillable = [
    'classe_id',
    'id',
    'tipo',
    'valorDescricao',
    'multa',
    'periodepagamento',
    'Descricao',
    'idtabelavalores',
    'anolectivo_id',
    'mes',
    'inicio',
    'mesNome',
    'formames',
    'limite',
    'tipo_janela',
    'icon',
    'rn',
    'anolectivo',
];

    public function  mensalidades(){
        return $this->hasMany(outros_pagamentos::class,'tipo_pagamento_id','idtabelavalores');
    }
 public function  matriculas(){
        return $this->hasMany(alunoClasse::class,'tipo_Pagamento_id','idtabelavalores');
    }


}
