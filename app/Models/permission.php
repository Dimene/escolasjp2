<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use  App\Models\role;

class permission extends Model
{
    //

protected $fillable=["name","label","model_id"];
    public  function roles(){
        return $this->belongsToMany(role::class);
    }
}

