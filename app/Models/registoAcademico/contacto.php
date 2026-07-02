<?php

namespace App\Models\registoAcademico;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class contacto extends Model
{
    use HasFactory;

    protected $table="contactos";
    protected $fillable=[
        "Descricao",
        "encaregado_id",
    ];
}
