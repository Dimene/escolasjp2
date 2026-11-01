<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Protection;
class ModeloEstadosPagamentos implements FromArray, WithHeadings, WithEvents
{
    private array $parcelas;
    private array $alunos;

    public function __construct(int $ano, int $classe,array $parcelas,array $dados)
    {
        $this->alunos = $dados;
        $this->parcelas = $parcelas;


        
    }

    public function headings(): array
    {
        return array_merge(
            ['Codigo', 'Nome', 'Sexo', 'Turma', 'Classe'],
            array_column($this->parcelas, 'mes')
        );
    }

    public function array(): array
    {
        return $this->alunos;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $ultimaColuna = Coordinate::stringFromColumnIndex(count($this->headings()));
                $ultimaLinha = max(2, count($this->alunos) + 1);

                $sheet->getStyle("A1:{$ultimaColuna}1")->applyFromArray([
                    'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['argb' => 'FF1E3A8A'],
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                        'wrapText' => true,
                    ],
                ]);
                $sheet->freezePane('F2');
                $sheet->setAutoFilter("A1:{$ultimaColuna}{$ultimaLinha}");

                foreach ([16, 32, 14, 20, 20] as $index => $width) {
                    $sheet->getColumnDimension(Coordinate::stringFromColumnIndex($index + 1))
                        ->setWidth($width);
                }

                for ($index = 0; $index < count($this->parcelas); $index++) {
                    $coluna = Coordinate::stringFromColumnIndex($index + 6);
                    $sheet->getColumnDimension($coluna)->setWidth(18);

                    for ($linha = 2; $linha <= $ultimaLinha; $linha++) {
                        $validacao = $sheet->getCell("{$coluna}{$linha}")->getDataValidation();
                        $validacao->setType(DataValidation::TYPE_LIST)
                            ->setErrorStyle(DataValidation::STYLE_STOP)
                            ->setAllowBlank(false)
                            ->setShowInputMessage(true)
                            ->setShowErrorMessage(true)
                            ->setFormula1('"Pago,Não Pago","Pago1"')
                            ->setPromptTitle('Estado do pagamento')
                            ->setPrompt('Selecione Pago ou Não Pago.')
                            ->setErrorTitle('Estado inválido')
                            ->setError('Selecione Pago ou Não Pago.');
                    }
                }


                // Proteger as colunas A, B, C, D e E
$sheet->getStyle("A2:E{$ultimaLinha}")
    ->getProtection()
    ->setLocked(Protection::PROTECTION_PROTECTED);

// Deixar as colunas das parcelas editáveis
$ultimaColunaParcelas = Coordinate::stringFromColumnIndex(
    count($this->parcelas) + 5
);

if (count($this->parcelas) > 0) {
    $sheet->getStyle("F2:{$ultimaColunaParcelas}{$ultimaLinha}")
        ->getProtection()
        ->setLocked(Protection::PROTECTION_UNPROTECTED);
}

// Proteger a folha
$sheet->getProtection()->setSheet(true);
            },
        ];
    }
}
