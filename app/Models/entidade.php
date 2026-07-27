<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class entidade extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table="bancos";
    protected $fillable=["descricao","Entidade",];
}
