<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class tipossaida extends Model
{
    use HasFactory;
use SoftDeletes;
protected $table="tipossaida";
protected $fillable=["Descricao"];

}
