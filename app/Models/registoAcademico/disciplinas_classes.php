<?php

namespace App\Models\registoAcademico;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class disciplinas_classes extends Model
{
    use HasFactory;
    use HasFactory;
    protected $table="classe_disciplinas";
        protected $fillable=[
            "classe_id",
            "disciplina_id",
            "anolectivo_id"
        ];

        public Function classe(){
    return $this->hasOne(classe::class,'id','classe_id');
        }
    public Function disciplinas(){
    return $this->hasmany(disciplinas::class,'id','disciplina_id');
        }

}
