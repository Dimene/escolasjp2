<?php

namespace App\Models\Models\registoAcademico;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoDisciplina extends Model
{

    protected $table = "tipodisciplina";
    protected $fillable = ["Descricao"];
    public $timestamps = false; // Desativa created_at e updated_at

}
