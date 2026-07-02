<?php

namespace App\Models\registoAcademico;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class classe_discplina extends Model
{
    use HasFactory;
    use SoftDeletes;
protected $table="classe_disciplinas";
    protected $fillable=['classe_id','disciplina_id', 'anolectivo_id'];




public function disciplina()
{
    return $this->hasOne(disciplinas::class, 'id', 'disciplina_id');
}

public function disciplinas()
{
    return $this->hasMany(disciplinas::class, 'id', 'disciplina_id');
}
public function classe()
{
    return $this->hasOne(classe::class, 'id', 'classe_id');
}

}
