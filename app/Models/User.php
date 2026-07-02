<?php

namespace App\Models;

use App\Models\Admin\categoria;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\permission;
use App\Models\registoAcademico\anolectivo;
use App\Models\registoAcademico\nivel;
use App\Models\role;
use App\Models\role_user;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $connection = 'tenant';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
        "cargo_id","Nivel_id"
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime','sexo'
    ];


    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->setConnection(config('database.default'));
    }


    public function roles() {
        return $this->belongsToMany(role::class,'role_user', 'user_id', 'role_id');
    }

    public function categoria() {
        return $this->belongsToMany(categoria::class,'user_categorias', 'user_id', 'categoria_id');
    }
public function anolectivo() {
        return $this->belongsToMany(anolectivo::class,'user_categorias', 'user_id', 'anolectivo_id');
    }


    public function nivel(){
return $this->hasOne(nivel::class,'id','Nivel_id');
    }



    //metodo que fara a verificacao do usaurio suas funcoes
    //recebe as permisssoes
    public function hasPermission(permission $permission) {
        return $this->hasAnyRoles($permission->roles);
    }

    // recebe as funcoes e verifica
    public function hasAnyRoles($role) {
     //   var_dump($this->roles);

        if (is_object($role) || is_array($role)) {


    return  !! $role->intersect($this->roles)->count();
return $this->roles->contains('name', $role->name);
        }

        return $this->roles->contains('name', $role);
    }

}
