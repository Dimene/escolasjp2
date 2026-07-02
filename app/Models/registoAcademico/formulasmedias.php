<?php

namespace App\Models\registoAcademico;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class formulasmedias extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'formulasdemediastrimestrais';

    protected $fillable = [
        'disciplina_classe_id',
        'anolectivo_id',
        'divisao_id',
        'turma_id',
        'formula',
    ];
}
