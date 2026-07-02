<?php

namespace App\Models\registoAcademico;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class nota_meta extends Model
{
    use HasFactory;

    protected $table='nota-metas';
    protected $fillable=['Decricao'];

}
