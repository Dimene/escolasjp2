<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class user_categorias extends Model
{
    use HasFactory;
use SoftDeletes;
protected $table="user_categorias";
protected $fillable=['user_id','categoria_id','anolectivo_id'];
}
