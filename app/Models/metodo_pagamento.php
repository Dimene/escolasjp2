<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class metodo_pagamento extends Model
{
    use HasFactory;
    protected $table="metodo_pagamento";
    protected $fillable = ["Descricao","tipo","ReferenciaFlag"];

}
