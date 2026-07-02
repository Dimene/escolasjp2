<?php

namespace App\Exports;
use App\Models\registoAcademico\disciplinas;
use App\Models\registoAcademico\formulasmedias;
use App\Models\registoAcademico\turma;
use App\Models\registoAcademico\turma_aluno;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromArray;
//use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithMappedCells;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\BeforeSheet;
use PhpOffice\PhpSpreadsheet\Reader\Xls\Style\Border;

use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class pautaExport implements WithDrawings,FromArray
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $inicioLogo="B2";
    protected $cabecalho="B2";
    protected $dados=[];
    public function  __construct($dados) {

$this->dados=$dados;
    }

    public function drawings(){

}
public function array(): array
{
   return $this->dados;
}
}
