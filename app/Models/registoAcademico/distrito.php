<?php

namespace App\Models\registoAcademico;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class distrito extends Model
{
    use HasFactory;  use HasFactory;

    protected $table = 'distritos';

    public $timestamps = false;

    protected $fillable = [
        'nome',
        'provincia_id'
    ];


}
