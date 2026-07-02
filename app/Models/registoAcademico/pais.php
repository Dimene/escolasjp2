<?php

namespace App\Models\registoAcademico;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pais extends Model
{
    use HasFactory;

    protected $table = 'paises';

    public $timestamps = false;

    protected $fillable = [
        'nome',
        'nacionalidade'
    ];


     protected $casts = [
        'nacionalidade' => 'array'
    ];
}
