<?php

namespace App\Models\registoAcademico;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class provincia extends Model
{
    use HasFactory;

    protected $table = 'provincias';

    public $timestamps = false;

    protected $fillable = [
        'nome',
        'pais_id'
    ];

}
