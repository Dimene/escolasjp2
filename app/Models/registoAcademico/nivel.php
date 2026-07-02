<?php

namespace App\Models\registoAcademico;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class nivel extends Model
{ use HasFactory;
    protected $table="nivel";
    protected $fillable=["Descricao"];

}
