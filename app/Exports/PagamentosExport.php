<?php
// App\Exports\PagamentosExport.php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PagamentosExport implements FromCollection, WithHeadings, WithStyles
{
    protected $relatorio;

    public function __construct($relatorio)
    {
        $this->relatorio = $relatorio;
    }

    public function collection()
    {
        $data = [];

        foreach ($this->relatorio['dadosPorData'] as $dataItem) {
            $data[] = [
                'Data' => $dataItem->data_formatada,
                'Classes' => $dataItem->classes,
                'Total Alunos' => $dataItem->total_alunos,
                'Valor Total' => $dataItem->valor_total,
                'Multa Total' => $dataItem->multa_total,
                'Total Geral' => $dataItem->valor_total + $dataItem->multa_total
            ];
        }

        return collect($data);
    }

    public function headings(): array
    {
        return [
            'Data',
            'Classes',
            'Total Alunos',
            'Valor Total',
            'Multa Total',
            'Total Geral'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
