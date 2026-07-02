<?php

namespace app\Models;

use Illuminate\Database\Eloquent\Model;

class post extends Model
{
    public function  user(){
        return $this->belongsTo(User::class);
    }

    protected $fillable = [
        'Title', 'description','user_id'
    ];


}
