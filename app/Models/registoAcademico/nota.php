<?php

namespace App\Models\registoAcademico;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class nota extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $table="notas_frequencias";
    protected $fillable=[
        "classe_disciplina_id",
        "aluno_classe_id",
        "divisao_id",
        "nota_descricao",
        "chave1",
        "chave2",
        'nota_meta_id'
    ];


    public function notasnome(){
       return $this->hasOne(nota_meta::class,'id','nota_meta_id');
    }

    public function divisaoano(){
       return $this->hasOne(anolectivo_meta::class,'id','divisao_id');
    }

}
