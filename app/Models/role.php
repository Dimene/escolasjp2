<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\permission;
class role extends Model
{

    protected $fillable = [
        'name', 'label',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    'remember_token',
    ];

 public function permission()
 {
     return $this->belongsToMany(permission::class, 'permission_role', 'role_id', 'permission_id');
 }

}
