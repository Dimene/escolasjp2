<?php

namespace App\Imports;

use App\Models\registoAcademico\anolectivo;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class AlunosImport implements ToCollection
{
    protected $ano;
    protected $tipopagamento;
    protected const COLUNAS_FIXAS = 7;

    public function __construct($ano)
    {
        $this->ano = $ano;

        $anolectivo = anolectivo::find($this->ano);
        if (!$anolectivo) {
            throw new \Exception("Ano lectivo com ID {$this->ano} não encontrado.");
        }

        // Obtém tipos de pagamento únicos do ano lectivo
        $this->tipopagamento = DB::table("detalhestabelavaores")
            ->where("anolectivo_id", $anolectivo->id)
            ->where("tipo", ">", 2)
            ->pluck('Descricao')
            ->unique()
            ->toArray();
    }

    public function collection(Collection $collection)
    {

    }
}
