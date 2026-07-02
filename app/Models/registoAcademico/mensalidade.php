<?php

namespace App\Models\registoAcademico;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class mensalidade extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable=[
        "aluno_classe_id",
        "mes_id",
        "referencia",
        "metodo_pagamento_id",
        "usuario_Registou",


    "Estado",

    ];

}
