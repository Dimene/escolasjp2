<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
class pautaclasseExport implements  FromView, WithEvents
{
    protected $view;

    public function __construct(View $view)
    {
        $this->view = $view;
    }

    public function view(): View
    {
        return $this->view;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                // Adiciona a imagem
                $drawing = new Drawing();
                $drawing->setName('Logo');
                $drawing->setDescription('Logo Description');
                $drawing->setPath(public_path('/storage/logoMarca/logoTipo.png'));
                $drawing->setHeight(100);
                $drawing->setOffsetX(280);
                $drawing->setOffsetY(5);
                $drawing->setCoordinates('B3');
                $drawing->setWorksheet($event->sheet->getDelegate());

                // Define a célula de início
                $event->sheet->getDelegate()->getCell('A8')->setValue('');
            },
        ];
    }
}
