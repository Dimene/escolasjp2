<?php

namespace App\Models\registoAcademico;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class profissao extends Model
{
    use HasFactory;
    protected $table="profissaos";
  protected $fillable=[
      "Descricao",

  ];
}
