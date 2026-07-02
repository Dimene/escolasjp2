<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class refrencia extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table="referenciasbancarias";
protected $fillable=[
    "Mensalidade_id",
    "referencia",
    "entidade_id",

];
}
