<?php


namespace App\Models\registoAcademico;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use SebastianBergmann\CodeUnit\FunctionUnit;

class clase_disciplinas extends Model{

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

}
