<?php

namespace App\Models\registoAcademico;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class tipos_pagamentos extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table="tipos_pagamentos";
    protected $fillable=[
        "Descricao",
        "icon",
        "tipo_janela"



    ];

}
