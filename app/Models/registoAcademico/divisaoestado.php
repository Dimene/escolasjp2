<?php

namespace App\Models\registoAcademico;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class divisaoestado extends Model
{
    use HasFactory;

protected $fillable=["divisao_id","Estado1","Estado2","classe_id",'EstadoView'];

}
