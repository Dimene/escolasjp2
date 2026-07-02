<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class observadorSys extends Model
{
    use HasFactory;
protected $table="observers";
    protected $fillable=[
'user_id',
'register',
'action',
'model'
    ];
}
