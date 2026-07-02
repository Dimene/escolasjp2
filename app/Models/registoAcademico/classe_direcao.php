<?php

namespace App\Models\registoAcademico;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class classe_direcao extends Model
{
    use HasFactory;
    protected $table="classe_direcao";
    protected $fillable=["director_id",'classe_id','pedagogico_id','anolectivo_id'];


    public function usuarioP(){

        return $this->hasOne(User::class,'id',"pedagogico_id");
    }
    public function usuariod(){

        return $this->hasOne(User::class,'id',"director_id");
    }

    public function classe(){

        return $this->hasOne(classe::class,'id',"classe_id");
    }

    public function anolectivo(){

        return $this->hasOne(anolectivo::class,'id',"anolectivo_id");
    }

}
