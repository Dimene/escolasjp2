<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Protection;

class ModeloImportacaoAlunosExport implements FromCollection, WithHeadings, WithCustomStartCell, WithEvents
{
    protected $classe;
    protected $ano;
    protected $dados;

    public function __construct($classe, $ano, $dados)
    {
        $this->classe = $classe;
        $this->ano = $ano;
        $this->dados = $dados;
    }

    public function collection()
    {
        return $this->dados;
    }

    public function headings(): array
    {
        return [
            'codigo',
            'Nome',
            'Sexo',
            'Turma',
        ];
    }

    public function startCell(): string
    {
        return 'A8';
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $lastRow = max(9, $sheet->getHighestRow());

                $sheet->mergeCells('A2:D2');
                $sheet->mergeCells('A3:D3');
                $sheet->mergeCells('A4:D4');
                $sheet->mergeCells('A5:D5');

                $sheet->setCellValue('A2', 'MODELO DE IMPORTAÇÃO DE ALUNOS');
                $sheet->setCellValue('A3', 'Classe: ' . ($this->classe->Descricao ?? ''));
                $sheet->setCellValue('A4', 'Ano lectivo: ' . ($this->ano->anolectivo ?? ''));
                $sheet->setCellValue('A5', 'A coluna Código está protegida. Preencha ou atualize apenas Nome, Sexo e Turma.');

                $sheet->getStyle('A2:D2')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 16,
                        'color' => ['argb' => 'FFFFFFFF'],
                    ],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['argb' => 'FF1F4E78'],
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                ]);

                $sheet->getStyle('A3:D4')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'color' => ['argb' => 'FF1F2937'],
                    ],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['argb' => 'FFEAF1F8'],
                    ],
                    'alignment' => [
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                ]);

                $sheet->getStyle('A5:D5')->applyFromArray([
                    'font' => [
                        'italic' => true,
                        'color' => ['argb' => 'FF7F6000'],
                    ],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['argb' => 'FFFFF2CC'],
                    ],
                    'alignment' => [
                        'vertical' => Alignment::VERTICAL_CENTER,
                        'wrapText' => true,
                    ],
                ]);

                $sheet->getStyle('A8:D8')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'color' => ['argb' => 'FFFFFFFF'],
                    ],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['argb' => 'FF2F75B5'],
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                ]);

                $sheet->getStyle("A8:D{$lastRow}")->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['argb' => 'FFD9E2F3'],
                        ],
                    ],
                    'alignment' => [
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                ]);

                if ($lastRow > 8) {
                    $sheet->getStyle("A9:D{$lastRow}")
                        ->getFill()
                        ->setFillType(Fill::FILL_SOLID);
                    $sheet->getStyle("A9:D{$lastRow}")
                        ->getFill()
                        ->getStartColor()
                        ->setARGB('FFF8FAFC');
                }

                $sheet->getColumnDimension('A')->setWidth(18);
                $sheet->getColumnDimension('B')->setWidth(38);
                $sheet->getColumnDimension('C')->setWidth(15);
                $sheet->getColumnDimension('D')->setWidth(28);
                $sheet->getRowDimension(2)->setRowHeight(32);
                $sheet->getRowDimension(5)->setRowHeight(30);
                $sheet->getRowDimension(8)->setRowHeight(24);
                $sheet->freezePane('A9');
                $sheet->setAutoFilter("A8:D{$lastRow}");
                $sheet->setShowGridlines(false);

                $sheet->getStyle("A8:A{$lastRow}")
                    ->getProtection()
                    ->setLocked(Protection::PROTECTION_PROTECTED);
                $sheet->getStyle("B9:D{$lastRow}")
                    ->getProtection()
                    ->setLocked(Protection::PROTECTION_UNPROTECTED);
                $sheet->getProtection()->setSheet(true);
            },
        ];
    }
}
