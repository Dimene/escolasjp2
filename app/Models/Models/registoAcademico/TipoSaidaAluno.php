<?php

namespace App\Models\Models\registoAcademico;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TipoSaidaAluno extends Model
{
  use HasFactory;
use SoftDeletes;
protected $table="tipossaida";
protected $fillable=["Descricao"];
}
