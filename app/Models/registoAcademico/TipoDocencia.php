<?php

namespace App\Models\RegistoAcademico;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoDocencia extends Model
{
    use HasFactory;
    protected $table="tiposdocencia";
    protected $fillable=["Descricao"];
     // Corrigindo a propriedade para desativar timestamps
    public $timestamps = false;
}
