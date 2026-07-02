<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class configuraceos extends Model
{
    use HasFactory;
    protected $table="config";

    protected  $fillable=[
        'id',
  'nome',
  'NUit',
  'Email' ,
  'Localizacao',
  'Contacto',
  'nome_Empresa',
  'TIpoSistema',
  'linkEmpresa'

    ];
}
