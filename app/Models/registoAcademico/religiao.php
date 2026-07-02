<?php

namespace App\Models\registoAcademico;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class religiao extends Model
{
    use HasFactory;
    protected $table="religiaes";
    protected $fillable=[
        'nome',
    ];
}
