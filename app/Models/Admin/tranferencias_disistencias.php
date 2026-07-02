<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class tranferencias_disistencias extends Model
{
    use HasFactory;
    use  SoftDeletes;
    protected $table="tranferencias_disistencias";
    protected $fillable=["aluno_classe_id","tipo_id","mes_id"];
}
