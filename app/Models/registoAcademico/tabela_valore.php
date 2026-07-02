<?php

namespace App\Models\registoAcademico;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
 use App\Models\registoAcademico\anolectivo;

class tabela_valore extends Model
{
    use HasFactory;
    //public $timestamps= false;

    protected $table="tabela_valores";
   protected $fillable=[
       'Descricao',
       'valorDescricao',
       'multa',
       'anolectivo_id',
       "detalhes",
       "classes",

       "periodepagamento"
   ];



    /**
     * Get the user associated with the tabela_valore
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function anolectivo()
    {
        return $this->hasOne(anolectivo::class, 'id', 'anolectivo_id');
    }
}
