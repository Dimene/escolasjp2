<?php

namespace App\Models\registoAcademico;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class endereco extends Model
{
    use HasFactory;
    protected $table="enderecos";
    protected $fillable=[
        "Endereco",
        "RuaAvenida"
    ];
}
