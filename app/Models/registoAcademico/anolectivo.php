<?php

namespace App\Models\registoAcademico;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\registoAcademico\anolectivo_meta;
use App\Models\registoAcademico\mensalidade;
use App\Models\registoAcademico\alunoClasse;

class anolectivo extends Model
{
    use HasFactory;
    protected $table="anolectivos";
   protected  $fillable=['anolectivo','Inicio','Fim','modalidade'];


   public function anomodelo(){
    return $this->hasOne(anomodelo::class,'id','modalidade');
}


public function alunoClasseShow()
{
    return $this->hasMany(alunoClasse::class, 'anolectivo_id', 'id');
}
public function modalidadeDivisao(){

    return $this->hasMany(anolectivo_meta::class, 'anolectivo_id', 'id');
    //return $this->hasOne(anolectivo_meta::class, 'id', 'anolectivo_id');
}
/**
 * Get all of the comments for the anolectivo
 *
 * @return \Illuminate\Database\Eloquent\Relations\HasMany
 */

public function mensalidades()
{
    return $this->hasMany(mensalidade::class, 'aluno_classe_id', 'id');
}

}

