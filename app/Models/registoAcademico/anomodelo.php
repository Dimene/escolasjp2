<?php

namespace App\Models\registoAcademico;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class anomodelo extends Model
{
    protected $table="anomodelos";
    protected $fillable=["id,Descricao"];
    use HasFactory;
}
