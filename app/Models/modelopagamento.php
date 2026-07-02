<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class modelopagamento extends Model
{
    use HasFactory;

    protected $table="modales";
    protected $fillable=["Descricao","tipo_pagameto_id","detalhes"];



    public function permission(){
        return $this->hasMany(permission::class,"model_id","id");
    }
}
