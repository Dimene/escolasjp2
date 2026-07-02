<?php

namespace App\Models\registoAcademico;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class anolectivo_meta extends Model
{
    protected $table="anolective_metas";
    protected $fillable=['anolectivo_id','Inicio', 'Fim','divisao',
    'Estado1','Estado2'
];

    use HasFactory;
public function anolectivo(){
   return  $this->hasOne(anolectivo::class,'id','anolectivo_id');
}

}
