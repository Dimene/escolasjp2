<?php

namespace App\Observers;

use App\Models\Admin\observadorSys;
use App\Models\Aluno;

class AlunoObserver
{
    /**
     * Handle the Aluno "created" event.
     */
    public function created(Aluno $aluno): void
    {
        $tipoOperacao="create";
        $modelo="Aluno";
        $usuario= auth()->user()->id;
        observadorSys::updateOrCreate(['user_id' =>$usuario, 'action'=>$tipoOperacao, 'register'=>$aluno->id,
        'model'=>$modelo], ['user_id' =>$usuario, 'action'=>$tipoOperacao,'register'=>$aluno->id, 'model'=>$modelo]);
    }

    /**
     * Handle the Aluno "updated" event.
     */
    public function updated(Aluno $aluno): void
    {
        //
    }

    /**
     * Handle the Aluno "deleted" event.
     */
    public function deleted(Aluno $aluno): void
    {
        //
    }

    /**
     * Handle the Aluno "restored" event.
     */
    public function restored(Aluno $aluno): void
    {
        //
    }

    /**
     * Handle the Aluno "force deleted" event.
     */
    public function forceDeleted(Aluno $aluno): void
    {
        //
    }
}
