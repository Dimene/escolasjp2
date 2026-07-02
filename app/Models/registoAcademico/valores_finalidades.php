<?php

namespace App\Models\registoAcademico;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class valores_finalidades extends Model
{
    use HasFactory;
    protected $table="valores_finalidades";
    protected $fillable=['classe_id','valores_id','anolectivo',"tipopagameto"];
}
