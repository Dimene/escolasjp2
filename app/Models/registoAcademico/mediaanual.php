<?php

namespace App\Models\registoAcademico;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class mediaanual extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table="formulaanual";
    protected $fillable=["formula"];

}
