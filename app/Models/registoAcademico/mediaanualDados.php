<?php

namespace App\Models\registoAcademico;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class mediaanualDados extends Model
{
    use HasFactory;

    protected $table="mediaanual";
    protected $fillable=[

  "aluno_classe_id",
  "ano_lectivo",
 "valor",
  "Estado" ,
  "MediaTempo",
  "Resultado" ,
    "user_created"
    ];

}
