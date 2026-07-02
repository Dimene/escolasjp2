<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;

class turmaExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
public $dados;
public function __construct($dados)
{
    $this->dados=$dados;
}
    public function collection()
    {
        $dados=$this->dados;
        return DB::table('turmasalunosview')->where('turma_id',$dados)->orWhere("jurri_id",$dados)->get(['nome','sexo','idade']);

    }
}
