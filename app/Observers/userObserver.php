<?php

namespace App\Observers;

use App\Models\Admin\observadorSys;
use App\Models\User;
use Illuminate\Foundation\Auth\User as AuthUser;
use Illuminate\Support\Facades\DB;

class userObserver
{
    /**
     * Handle the user "created" event.
     */
    public function created(User $user): void
    {
        $usuario= auth()->user()->id;

        observadorSys::updateOrCreate(['user_id' =>$usuario,
        'action'=>'update',
        'register'=>$user->id,
        'model'=>'user'],['user_id' =>$usuario,
        'action'=>'update',
        'register'=> $user->id,
        'model'=>'user']);
    }

    /**
     * Handle the user "updated" event.
     */
    public function updated(User $user): void
    {
        //
        $usuario= auth()->user()->id;
        observadorSys::create(['user_id' =>$user->id,
        'action'=>'update',
        'register'=>$user->id,
        'model'=>'user']);

    }

    /**
     * Handle the user "deleted" event.
     */
    public function deleted(User $user): void
    {
        $usuario= auth()->user()->id;
        observadorSys::create(['user_id' =>$usuario->id,
        'action'=>'deleted',
        'register'=>$user->id,
        'model'=>'user']);

    }

    /**
     * Handle the user "restored" event.
     */
    public function restored(User $user): void
    {
        //
        $usuario= auth()->user()->id;
        observadorSys::create(['user_id' =>$usuario,
        'action'=>'restor',
        'register'=>$user->id,
        'model'=>'user']);

    }

    /**
     * Handle the user "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        //
        $usuario= auth()->user()->id;
        observadorSys::create(['user_id' =>$usuario,
        'action'=>'forceDelete',
        'register'=>$user->id,
        'model'=>'user']);

    }
}
