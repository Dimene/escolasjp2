<?php

namespace App\Exports;


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
class pautaAnualExport implements  WithDrawings,FromArray, WithCustomStartCell,WithHeadings,WithStyles,WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */

    protected $dados;
    protected $cabecalho;
    protected $inicioLogo;
    protected $dadossize;
    protected $Quantidadelinhas;
    protected $dadoTabela;
    protected $celuasunir;
    protected $colunas;
    protected $numerotrimestres;

public function __construct($dados,$cabecalho,$tamanho,$dadoTabela,$celuasunir,$colunas,$numerotrimestres) {
    $this->dados = $dados;
    $this->cabecalho = $cabecalho;
    $x2=($tamanho/2);
    $arac=range('A','Z');
  $this->inicioLogo=  $colunas[intval($x2)-2]."3";
  $this->dadossize=count($this->cabecalho[1]);
  $this->Quantidadelinhas=count($dados);
  $this->dadoTabela=$dadoTabela;

  $this->colunas=$colunas;
  $this->celuasunir=$celuasunir;
  $this->numerotrimestres=$numerotrimestres;

}

public function drawings(){
    // Adiciona a imagem


    $drawing = new Drawing();
    $drawing->setName('Logo');
    $drawing->setDescription('Logo Description');
    $drawing->setPath(public_path('/storage/logoMarca/logoTipo.png'));
    $drawing->setHeight(100);
    $drawing->setOffsetX(280);
    $drawing->setOffsetY(5);

    $drawing->setCoordinates($this->inicioLogo);


    return $drawing;
}
public function headings(): array
    {
        return[
            ["Serviço Distrital de Educação Juventude e Tecnologia"],
            ["Escola Secundaria Geral de Derre"],
            ["PAUTA DE FREQUÊNCIA DA  8ª CLASSE, TURMA: B CURSO DIURNO - 2024 "],
            $this->cabecalho[0],
            $this->cabecalho[1],

        ];

    }
    public function array():array
    {
      return $this->dados;
    }



    public function startCell(): string
    {

        return 'A9';
    }




public function styles(Worksheet $sheet)
{

   $arraydados=[
    'font'=>
    ['name'=>'Arial','size'=>16]

];
$x2=($this->dadossize);
$arac=range('A','Z');
for($i=0;$i<count($this->celuasunir[0]);$i++){

$sheet->mergeCells($this->celuasunir[0][$i].'12:'.$this->celuasunir[1][$i].'12');


}


$sheet->mergeCells('A9:'.$this->colunas[count($this->cabecalho[1])-1].'9');
$sheet->mergeCells('A10:'.$this->colunas[count($this->cabecalho[1])-1].'10');
$sheet->mergeCells('A11:'.$this->colunas[count($this->cabecalho[1])-1].'11');


for($x=8;$x<11;$x++){
$sheet->getStyle('A'.$x)->getFont()->setBold(true);
$sheet->getStyle('A'.$x)->getFont()->setSize(12);
}


$style = [
    'alignment' => [
        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
        'wrapText' => true,
    ],
];

$style2=[
    'borders' => [
        'bottom' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
        ],
         'top' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
        ]

    ],
];

$style3=[
    'borders' =>  [
        'left' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
        ],
         'rigth' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
        ]

    ],
];

$style4=[
    'borders' =>  [
        'right ' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
        ],

        'left' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
        ],


    ],
];

$style5bachead=[
    'fill' => [
        'fillType' => Fill::FILL_SOLID,
        'color' => ['argb' => '636464'], // Cor de fundo amarelo
    ],
    'font' => [
        'bold' => true, // Deixa o texto em negrito
    ],

];
$stylemedia=[
    'fill' => [
        'fillType' => Fill::FILL_SOLID,
        'color' => ['argb' => 'BEC4C0'], // Cor de fundo amarelo
    ],
    'font' => [
        'bold' => true, // Deixa o texto em negrito
    ],

];






//$sheet->getStyle('A11:H11')->getStartColor()->setARGB('FFFF0000');

;

if($this->cabecalho[count($this->cabecalho)-1]=="@Media"){

    $size=($this->Quantidadelinhas)+11;
    $sheet->getStyle($arac[count($this->cabecalho)-1].'12:'.$arac[count($this->cabecalho)-1].$size.'')
    ->applyFromArray($stylemedia);
}
$abcr=range('A','z');
for($x=12;$x<=($this->Quantidadelinhas+13);$x++){


$sheet->getStyle('A'.$x.':'.$this->colunas[count($this->cabecalho[1])-1].$x.'')->applyFromArray($style2);


}

$Qtdadecolunas=count($this->cabecalho);
for($x=0;$x<=$Qtdadecolunas;$x++){



}
$x="8.43";

$size=(3*8.43);
$sheet->getColumnDimension('B')->setWidth($size);
$sheet->getColumnDimension('B')->setAutoSize(false);





$xc=-1;
$keyl=0;
foreach($this->cabecalho[1] as$cab){

   if($keyl>2){

$xc++;
if($xc==(($this->numerotrimestres))){
    $colunalimite= $this->colunas[$keyl].'12:'.$this->colunas[$keyl].(count($this->dados)+13).'';

    $colunalimite2= $this->colunas[$keyl].'10';


    $sheet->getStyle($colunalimite)
    ->applyFromArray($stylemedia);


   // echo$colunalimite;
   $xc=-1;

}

$sheet->getStyle('A12:'.$this->colunas[count($this->cabecalho[1])-1]."13")
    ->applyFromArray($stylemedia);




}

$keyl++;

}




$sheet->getStyle('A9:'.$this->colunas[count($this->cabecalho[1])-1].'9')->applyFromArray($style);;
$sheet->getStyle('A10:'.$this->colunas[count($this->cabecalho[1])-1].'10')->applyFromArray($style);;
$sheet->getStyle('A11:'.$this->colunas[count($this->cabecalho[1])-1].'11')->applyFromArray($style);
//$sheet->getStyle('A11:'.$this->colunas[count($this->cabecalho[1])-1].'11')->applyFromArray($style);

$sheet->getStyle('A12:'.$this->colunas[count($this->cabecalho[1])-1].'13')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
$sheet->getStyle('A12:'.$this->colunas[count($this->cabecalho[1])-1].'13')->getFont()->setBold(true);
}



public function registerEvents(): array {
    return [
        BeforeSheet::class => function (BeforeSheet $event) {
            $event->sheet
                ->getPageSetup()
                ->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
        },
    ];
}
}
