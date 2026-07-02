<?php

namespace App\Models\registoAcademico;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\registoAcademico\endereco;
use App\Models\registoAcademico\encaregado;
use App\Models\registoAcademico\grauparentesco;
use App\Models\registoAcademico\alunoClasse;
use App\Models\registoAcademico\classe;
use App\Models\registoAcademico\Doenca;
use Illuminate\Database\Eloquent\SoftDeletes;

class Aluno extends Model
{
    use HasFactory;
    use SoftDeletes;
  protected  $fillable=[
        'dataNascimento',
        'nome',
        'Tipo',
        'avatar',
        'doencaCronca',
        'doenca_id',
        'religiae_id',
        'religiae_id',
        'user_id',
        'encaredado_id',
        'grauParentesto_id',
        'endereco_id',
        'Quarterao',
        'Casa',
        'sexo',
        'codigobarra',
        'provincia_id',
        'naturalidade_id',
        'pai_id',
        'mae_id',
        'pais_id'


  ];



  public function morada(){

    return $this->hasOne(endereco::class,'id','endereco_id');

  }

  public function encaregado(){
      return $this->hasOne(encaregado::class,'id','encaredado_id');
  }


  public function graoparentesto(){
      return $this->hasOne(grauparentesco::class,'id','grauParentesto_id');
  }

  public function dencaAluno(){
    return $this->hasOne(Doenca::class,'id','doenca_id');
}




  public function classefrequentada()
  {
      return $this->belongsToMany(classe::class, 'aluno_classes', 'aluno_id', 'classe_id');
  }

  public function AlunoClasse()
  {
      return $this->hasMany(alunoClasse::class, 'aluno_id', 'id');
  }


  public function Bairo(){
      return $this->hasOne(endereco::class,'id','endereco_id');
  }





}
