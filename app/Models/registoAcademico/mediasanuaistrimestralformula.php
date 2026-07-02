<?php

namespace App\Models\registoAcademico;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class mediasanuaistrimestralformula extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table="mediasanuaistrimestralformula";
    protected $fillable=[
"turma",
"anolectivo_id",
"formula",
"TipoMedia",
"mediaflag",
    ];
}
