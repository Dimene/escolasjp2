<?php

namespace App\Models\registoAcademico;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class classes_grupo extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table="classes_grupos";
    protected $fillable=['classe_id',"grupo"];
}
