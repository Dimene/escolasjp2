<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Events\BeforeSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PHPUnit\Framework\Constraint\Count;

class pautaclasseExport implements FromArray, WithHeadings, WithDrawings, WithCustomStartCell, WithEvents
{
    protected $cabecalho;
    protected $linhas;
    protected $inicioLogo;
    protected $arayMesclagem;
    protected $arayMesclagemLetras;
    protected $variavelmeslagemFooter;
    protected $colunas;
      private $subdomain="";
    protected $arayprofessores;
    protected $dadosDirecao;
    protected $tamanho;
    protected $numerodisci;

protected $anolectivoDados;

    public function __construct(array $cabecalho, array $linhas, array $arayMesclagem, array $arayMesclagemLetras,
    array $variavelmeslagemFooter,array $colunas, array $arayprofessores, array $dados, array $anolectivoDados,$tamanho,$numerodisci)
    {
        $this->cabecalho = $cabecalho;
        $this->linhas = $linhas;
        $this->colunas = $colunas;
        $this->arayMesclagem = $arayMesclagem;
        $this->arayMesclagemLetras = $arayMesclagemLetras;
        $this->variavelmeslagemFooter = $variavelmeslagemFooter;
        $this->arayprofessores = $arayprofessores;
        $this->inicioLogo = 'G2';
        $this->dadosDirecao =$dados;
        $this->anolectivoDados=$anolectivoDados;
        $this->tamanho=$tamanho;
        $this->numerodisci=$numerodisci;
         $request = request();
    $host = $request->getHost();
    $this->subdomain = explode('.', $host)[0];
        //  dd( $this->cabecalho,  $this->linhas);



    }

    public function array(): array
    {
        return $this->linhas;
    }

    public function headings(): array
    {
        return [
            $this->cabecalho[0],
            $this->cabecalho[1],
        ];
    }

    public function startCell(): string
    {
        return 'A8';
    }

    public function drawings()
    {
        $drawing = new Drawing();
        $drawing->setName('Logo');
        $drawing->setDescription('Logotipo institucional');
        $drawing->setPath(public_path('/storage/'.$this->subdomain.'/logoMarca/logoTipo.png'));
        $drawing->setHeight(100);
        $drawing->setOffsetX(0);
        $drawing->setOffsetY(5);
        $drawing->setCoordinates($this->inicioLogo);

        return $drawing;
    }

    public function registerEvents(): array
    {
        return [



            BeforeSheet::class => function (BeforeSheet $event) {
                $event->sheet->getPageSetup()
                    ->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
            },


            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();






            // Bloquear colunas A, B e C
            $sheet->getStyle('A:C')->getProtection()->setLocked(true);

            // Desbloquear o resto (se quiser permitir edição nas outras colunas)
            $ultimaColuna = $sheet->getHighestColumn();
            $ultimaLinha  = $sheet->getHighestRow();
            $sheet->getStyle("D1:{$ultimaColuna}{$ultimaLinha}")
                  ->getProtection()->setLocked(false);

            // Ativar proteção da planilha com senha
            $sheet->getProtection()->setSheet(true);
            $sheet->getProtection()->setPassword('minha_senha_segura');



                $totalLinhas = count($this->linhas) + 2;
                $totalColunas = count($this->cabecalho[1]);
                $ultimaColuna = Coordinate::stringFromColumnIndex($totalColunas);
                $intervalo = "A8:{$ultimaColuna}" . ($totalLinhas + 7);

                // Estilo geral da tabela
                $sheet->getStyle($intervalo)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['argb' => 'FF000000'],
                        ],
                    ],
                    'alignment' => [
                        'vertical' => Alignment::VERTICAL_CENTER,
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'wrapText' => true,
                    ],
                ]);

                // Estilo dos cabeçalhos
                $cabecalhoIntervalo = "A8:{$ultimaColuna}9";
                $sheet->getStyle($cabecalhoIntervalo)->applyFromArray([
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['argb' => 'FFB0B0B0'],
                    ],
                    'font' => [
                        'bold' => true,
                        'color' => ['argb' => 'FF000000'],
                    ],
                ]);

                // Destacar MF e MA
                foreach ($this->cabecalho[1] as $index => $coluna) {
                    if (in_array(strtoupper(trim($coluna)), ['MF', 'MA'])) {
                        $colLetra = Coordinate::stringFromColumnIndex($index + 1);
                        $colRange = "{$colLetra}8:{$colLetra}" . ($totalLinhas + 7);
                        $sheet->getStyle($colRange)->applyFromArray([
                            'fill' => [
                                'fillType' => Fill::FILL_SOLID,
                                'startColor' => ['argb' => 'FFD9D9D9'],
                            ],
                            'font' => ['bold' => true],
                        ]);
                    }
                }

                // Altura das linhas
                for ($i = 8; $i <= ($totalLinhas + 7); $i++) {
                    $sheet->getRowDimension($i)->setRowHeight(22);
                }

                // Largura automática
                for ($col = 1; $col <= $totalColunas; $col++) {
                    $colLetra = Coordinate::stringFromColumnIndex($col);
                    $sheet->getColumnDimension($colLetra)->setAutoSize(true);
                }

                // Mesclagem vertical por disciplina
                $colunas = array_map('strtoupper', array_map('trim', $this->cabecalho[1]));
                $colDisciplina = array_search('DISCIPLINA', $colunas);
                $colLetraDisciplina = Coordinate::stringFromColumnIndex($colDisciplina + 1);

                $linhaInicial = 10;
                $disciplinaAtual = null;
                $inicioGrupo = $linhaInicial;

                for ($i = 0; $i < (count($this->linhas)); $i++) {
                    $linhaExcel = $linhaInicial + $i;
                    $disciplina = $this->linhas[$i][$colDisciplina];

                    if ($disciplinaAtual === null) {
                        $disciplinaAtual = $disciplina;
                        $inicioGrupo = $linhaExcel;
                    }

                    $proximaDisciplina = ($i + 1 < count($this->linhas)) ? $this->linhas[$i + 1][$colDisciplina] : null;

                    // if ($disciplina !== $proximaDisciplina) {
                    //     $fimGrupo = $linhaExcel;
                    //     if ($fimGrupo > $inicioGrupo) {
                    //         $intervaloDisc = "{$colLetraDisciplina}{$inicioGrupo}:{$colLetraDisciplina}{$fimGrupo}";
                    //         $sheet->mergeCells($intervaloDisc);
                    //        ;
                    //     }
                    //     $disciplinaAtual = $proximaDisciplina;
                    //     $inicioGrupo = $linhaExcel + 1;
                    // }


                }

    //             for($x=4;$x<($this->numerodisci+4);$x+=$this->tamanho){
    //                 $indice1=($x);
    //                 $indice2=($x+$this->tamanho);
    //                      $colLetraI = Coordinate::stringFromColumnIndex($indice1);
    //                      $colLetraF = Coordinate::stringFromColumnIndex($indice2);



    //                      $intervalo = $colLetraI . "8:" . $colLetraF . "8";
    //                      echo $intervalo;
    // $sheet->mergeCells($intervalo);

    //  $sheet->getStyle($intervalo)->applyFromArray([
    //                             'alignment' => [
    //                                 'vertical' => Alignment::VERTICAL_CENTER,
    //                                 'horizontal' => Alignment::HORIZONTAL_CENTER,
    //                                 'wrapText' => true,
    //                             ],
    //                             'font' => ['bold' => true],
    //                         ]);


    //                 }


                // Mesclagem horizontal dinâmica
                foreach ($this->arayMesclagem as $intervalo) {
                    $sheet->mergeCells($intervalo);
                    $sheet->getStyle($intervalo)->applyFromArray([
                        'alignment' => [
                            'horizontal' => Alignment::HORIZONTAL_CENTER,
                            'vertical' => Alignment::VERTICAL_CENTER,
                            'wrapText' => true,
                            'shrinkToFit' => true,
                        ],
                        'font' => [
                            'bold' => true,
                            'size' => 12,
                        ],
                    ]);
                }



// LINHA DE dOCENTES


for($x=1; $x<=2;$x++){


for($i=0;$i<count($this->cabecalho[0]);$i++){

$celula=$this->colunas[$i].(count($this->linhas)+9+$x);
    $sheet->getStyle($celula)->applyFromArray([
        'alignment' => [
            'horizontal' => Alignment::HORIZONTAL_CENTER,
            'vertical' => Alignment::VERTICAL_CENTER,
            'wrapText' => true,
            'shrinkToFit' => true,
        ],
        'font' => [
            'bold' => true,
            'size' => 12,
        ],
        'borders' => [
            'outline' => [
                'borderStyle' => Border::BORDER_THIN,
                'color' => ['argb' => 'FF000000'],
            ],
        ],
    ]);

}
}




$linhaAssinaturaDoc = count($this->linhas) + 10;
for (  $x=0; $x<count($this->cabecalho[0]);$x++ ) {
   $colLetra= $this->colunas[$x];
    $celula = "{$colLetra}{$linhaAssinaturaDoc}";


     if($x>2 &&$x<(count($this->cabecalho[0])-2)):
    $sheet->setCellValue($celula,$this->arayprofessores[$x]??null);
    $sheet->getStyle($celula)->applyFromArray([
        'alignment' => [
            'horizontal' => Alignment::HORIZONTAL_CENTER,
            'vertical' => Alignment::VERTICAL_CENTER,
        ],
        'font' => [
            'bold' => true,
            'size' =>7,
        ],
        'borders' => [
            'outline' => [
                'borderStyle' => Border::BORDER_THIN,
                'color' => ['argb' => 'FF000000'],
            ],
        ],
    ]);

	endif;
}



$linhaTopo = 2;
$colFinal = $ultimaColuna;

// Células individuais
$celAssinatura = "{$colFinal}{$linhaTopo}";
$celLinha = "{$colFinal}" . ($linhaTopo + 1);
$celNome = "{$colFinal}" . ($linhaTopo + 2);
$celNivel = "{$colFinal}" . ($linhaTopo + 3);

// Conteúdo


$visto="Visto do Diretor";
if($this->dadosDirecao["Director"]["sexo"]=="F"){
 $visto="Visto da Diretora";
}
$sheet->setCellValue($celAssinatura,  $visto);
$sheet->setCellValue($celLinha, "__________________________");
$sheet->setCellValue($celNome, "(".$this->dadosDirecao["Director"]["Nome"].")");
$sheet->setCellValue($celNivel, "(".$this->dadosDirecao["Director"]["nivel"].")");

// Estilo para cada linha
$sheet->getStyle($celAssinatura)->applyFromArray([
    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
    'font' => ['bold' => true, 'size' => 11],
]);

$sheet->getStyle($celLinha)->applyFromArray([
    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
    'font' => ['bold' => false, 'size' => 11],
]);

$sheet->getStyle($celNome)->applyFromArray([
    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
    'font' => ['italic' => true, 'size' => 11],
]);
$sheet->getStyle($celNivel)->applyFromArray([
    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
    'font' => ['italic' => true, 'size' => 11],
]);

// Moldura em volta das três células
$intervaloDiretor = "{$colFinal}{$linhaTopo}:{$colFinal}" . ($linhaTopo + 3);
$sheet->getStyle($intervaloDiretor)->applyFromArray([
    'borders' => [
        'outline' => [
            'borderStyle' => Border::BORDER_MEDIUM,
            'color' => ['argb' => 'FF000000'],
        ],
    ],
    'fill' => [
        'fillType' => Fill::FILL_SOLID,
        'startColor' => ['argb' => 'FFFDFDFD'],
    ],
]);

// Ajuste de altura e largura
$sheet->getRowDimension($linhaTopo)->setRowHeight(20);
$sheet->getRowDimension($linhaTopo + 1)->setRowHeight(20);
$sheet->getRowDimension($linhaTopo + 2)->setRowHeight(20);
$sheet->getColumnDimension($colFinal)->setWidth(30);


// 🔻 Rodapé final: Assinatura do Pedagógico
$linhaPedagogico = count($this->linhas) + 20;
$linhaPedagogico2 = count($this->linhas) + 21;
$linhaPedagogico3 = count($this->linhas) + 22;
$linhaPedagogico4 = count($this->linhas) + 23;
// $sheet->setCellValue("A{$linhaPedagogico}", 'Assinatura do Pedagógico');

$visto2="Visto do Director Adjunto";
if($this->dadosDirecao["pedagogico"]["sexo"]=="F"){
 $visto2="Visto da Directora Adjunta";
}


// dd($this->dadosDirecao["pedagogico"]);
$Letra1=$this->colunas[3];
$Letra2=($this->colunas[Count($this->cabecalho[0])-2]);
$sheet->setCellValue("{$Letra1}{$linhaPedagogico}", $visto2);
$sheet->setCellValue("{$Letra1}{$linhaPedagogico2}", '__________________________');
$sheet->setCellValue("{$Letra1}{$linhaPedagogico3}","(". $this->dadosDirecao["pedagogico"]["Nome"].")");
$sheet->setCellValue("{$Letra1}{$linhaPedagogico4}","(". $this->dadosDirecao["pedagogico"]["nivel"].")");
$sheet->mergeCells("{$Letra1}{$linhaPedagogico}:{$Letra2}{$linhaPedagogico}");
$sheet->mergeCells("{$Letra1}{$linhaPedagogico4}:{$Letra2}{$linhaPedagogico4}");
$sheet->mergeCells("{$Letra1}{$linhaPedagogico3}:{$Letra2}{$linhaPedagogico3}");
$sheet->mergeCells("{$Letra1}{$linhaPedagogico2}:{$Letra2}{$linhaPedagogico2}");




$sheet->getStyle("{$Letra1}{$linhaPedagogico}:{$Letra2}{$linhaPedagogico}")->applyFromArray([
    'alignment' => [
        'horizontal' => Alignment::HORIZONTAL_CENTER,
        'vertical' => Alignment::VERTICAL_CENTER,
    ],
    'font' => [
        'bold' => true,
        'size' => 11,
    ],
]);

$sheet->getStyle("{$Letra1}{$linhaPedagogico2}:{$Letra2}{$linhaPedagogico2}")->applyFromArray([
    'alignment' => [
        'horizontal' => Alignment::HORIZONTAL_CENTER,
        'vertical' => Alignment::VERTICAL_CENTER,
    ],
    'font' => [
        'bold' => true,
        'size' => 11,
    ],
]);
$sheet->getStyle("{$Letra1}{$linhaPedagogico3}:{$Letra2}{$linhaPedagogico3}")->applyFromArray([
    'alignment' => [
        'horizontal' => Alignment::HORIZONTAL_CENTER,
        'vertical' => Alignment::VERTICAL_CENTER,
    ],
    'font' => [
        'bold' => true,
        'size' => 11,
    ],
]);
$sheet->getStyle("{$Letra1}{$linhaPedagogico4}:{$Letra2}{$linhaPedagogico4}")->applyFromArray([
    'alignment' => [
        'horizontal' => Alignment::HORIZONTAL_CENTER,
        'vertical' => Alignment::VERTICAL_CENTER,
    ],
    'font' => [
        'bold' => true,
        'size' => 11,
    ],
]);


                foreach ($this->variavelmeslagemFooter as $intervalo) {
    $sheet->mergeCells($intervalo);
    $sheet->getStyle($intervalo)->applyFromArray([
        'alignment' => [
            'horizontal' => Alignment::HORIZONTAL_CENTER,
            'vertical' => Alignment::VERTICAL_CENTER,
            'wrapText' => true,
            'shrinkToFit' => true,
        ],
        'font' => [
            'bold' => true,
            'size' => 12,
        ],
        'borders' => [
            'outline' => [
                'borderStyle' => Border::BORDER_THIN,
                'color' => ['argb' => 'FF000000'],
            ],
        ],
    ]);
}

                // Ajuste de largura para colunas mescladas
                foreach ($this->arayMesclagemLetras as $letra) {
                    $sheet->getColumnDimension($letra)->setWidth(30); // valor ajustável
                }

                // Título institucional

                 $totalColunas = count($this->cabecalho[1]);
                //  dd($ultimaColuna);
                $ultimaColuna = Coordinate::stringFromColumnIndex($totalColunas);
                 $intervaloMergi='A6:'.$ultimaColuna."6";
                 $intervaloMergi2='A7:'.$ultimaColuna."7";
                // dd($intervaloMergi);
                $sheet->mergeCells('A1:D1');
                 $sheet->mergeCells($intervaloMergi);
                 $sheet->mergeCells($intervaloMergi2);
                $sheet->setCellValue('A1', 'Pauta Anual-'.$this->anolectivoDados["anolectivo"]);
                $sheet->setCellValue('A6', $this->anolectivoDados["escola"]);
                $sheet->setCellValue('A7', $this->anolectivoDados["Nome"]);
                $sheet->getStyle('A1')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 14],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                        'wrapText' => true,
                    ],
                ]);
                 $sheet->getStyle('A6')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 12],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                        'wrapText' => true,
                    ],
                ]);$sheet->getStyle('A7')->applyFromArray([
                    'font' => [ 'size' => 12,'italic'=>true],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                        'wrapText' => true,
                    ],
                ]);
                $sheet->getRowDimension(1)->setRowHeight(30);
            },
        ];
    }
}
