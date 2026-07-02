<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Events\BeforeSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Color;

class NotasDisciplinaExport implements WithDrawings, FromArray, WithCustomStartCell, WithHeadings, WithStyles, WithEvents
{
    protected array $cabecalho;
    protected array $dadosturma;
    protected int $quantidadeLinhas;
    protected int $tamanhoCabecalho;
    protected string $idDisciplina;
    protected object $dadosEscola;
    protected object $turmas;

    public function __construct(
        array $cabecalho,
        array $dadosTurma,
        string $idDisciplina,
        object $dadosEscola,
        object $turmas
    ) {
        $this->cabecalho = $cabecalho;
        $this->dadosturma = $dadosTurma;
        $this->quantidadeLinhas = count($dadosTurma);
        $this->tamanhoCabecalho = count($cabecalho);
        $this->idDisciplina = $idDisciplina;
        $this->dadosEscola = $dadosEscola;
        $this->turmas = $turmas;
    }

    public function drawings(): Drawing
    {
        $config = DB::table('config')->first();
        $host = request()->getHost();
        $subdomain = explode('.', $host)[0];

        $drawing = new Drawing();
        $drawing->setName('Logo da Escola');
        $drawing->setDescription('Logo institucional');
        $drawing->setPath(public_path('storage/' . $subdomain . '/logoMarca/' . $config->avatar));
        $drawing->setHeight(100);
        $drawing->setOffsetX(280);
        $drawing->setOffsetY(5);
        $drawing->setCoordinates('C3');



        return $drawing;
    }

    public function startCell(): string
    {
        return 'A8';
    }

    public function headings(): array
    {
        $professor = $this->turmas->professor[0]->name ?? "________________________________";
$infoTurma = "Caderneta da disciplina de {$this->idDisciplina}, {$professor}";
          $infoDetalhes = sprintf(
            'Turma: %s da %s, Ano lectivo %s',
            $this->turmas->Descricao,
            $this->turmas->classeturma->Descricao,
            $this->turmas->anolectivo->anolectivo
        );

        return [
            [$this->dadosEscola->nome],
            [$infoTurma],
            [$infoDetalhes],
            $this->cabecalho
        ];
    }

    public function array(): array
    {
        return $this->dadosturma;
    }

    public function styles(Worksheet $sheet): void
    {
        $ultimaLinha = $this->quantidadeLinhas + 11;

        $this->aplicarEstilosGerais($sheet);
        $this->aplicarEstilosCabecalho($sheet);
        $this->aplicarEstilosTabela($sheet, $ultimaLinha);
        $this->aplicarEstilosColunas($sheet, $ultimaLinha);
    }

    private function aplicarEstilosGerais(Worksheet $sheet): void
    {
        $letras = range('A', 'Z');
        $ultimaColuna = $letras[$this->tamanhoCabecalho];

        // Mesclar células do cabeçalho
        $sheet->mergeCells("A8:{$ultimaColuna}8");
        $sheet->mergeCells("A9:{$ultimaColuna}9");
        $sheet->mergeCells("A10:{$ultimaColuna}10");

        // Estilo centralizado para cabeçalhos
        $styleCentralizado = [
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
        ];

        $sheet->getStyle('A8:H8')->applyFromArray($styleCentralizado);
        $sheet->getStyle('A9:H9')->applyFromArray($styleCentralizado);
        $sheet->getStyle('A10:H10')->applyFromArray($styleCentralizado);

        // Formatar linhas do título
        for ($x = 8; $x < 11; $x++) {
            $sheet->getStyle('A' . $x)
                ->getFont()
                ->setBold(true)
                ->setSize(12);
        }
    }

    private function aplicarEstilosCabecalho(Worksheet $sheet): void
    {
        $letras = range('A', 'Z');
        $ultimaColunaCabecalho = $letras[count($this->cabecalho) - 1];

        $styleCabecalho = [
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'color' => ['argb' => '636464'],
            ],
            'font' => [
                'bold' => true,
                'color' => ['argb' => Color::COLOR_WHITE],
            ],
        ];

        $sheet->getStyle("A11:{$ultimaColunaCabecalho}11")->applyFromArray($styleCabecalho);
        $sheet->getColumnDimension('A')->setAutoSize(true);
    }

    private function aplicarEstilosTabela(Worksheet $sheet, int $ultimaLinha): void
    {
        $letras = range('A', 'Z');
        $ultimaColuna = $letras[count($this->cabecalho) - 1];

        // Estilo de bordas para as linhas horizontais
        $styleBordasLinhas = [
            'borders' => [
                'bottom' => ['borderStyle' => Border::BORDER_MEDIUM],
                'top' => ['borderStyle' => Border::BORDER_MEDIUM],
            ],
        ];

        // Aplicar bordas horizontais em todas as linhas da tabela
        for ($x = 10; $x <= $ultimaLinha; $x++) {
            $sheet->getStyle("A{$x}:{$ultimaColuna}{$x}")->applyFromArray($styleBordasLinhas);
        }

        // Estilo especial para coluna de média
        if (end($this->cabecalho) === "@Media") {
            $ultimaLetra = $letras[count($this->cabecalho) - 1];

            $styleMedia = [
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'color' => ['argb' => 'BEC4C0'],
                ],
                'font' => ['bold' => true],
            ];

            $sheet->getStyle("{$ultimaLetra}12:{$ultimaLetra}{$ultimaLinha}")
                ->applyFromArray($styleMedia);
        }
    }

    private function aplicarEstilosColunas(Worksheet $sheet, int $ultimaLinha): void
    {
        $quantidadeColunas = count($this->cabecalho);
        $letras = range('A', 'Z');

        $styleBordasColunas = [
            'borders' => [
                'left' => ['borderStyle' => Border::BORDER_MEDIUM],
                'right' => ['borderStyle' => Border::BORDER_MEDIUM],
            ],
        ];

        $styleBordasFinas = [
            'borders' => [
                'left' => ['borderStyle' => Border::BORDER_THIN],
                'right' => ['borderStyle' => Border::BORDER_THIN],
            ],
        ];

        // Aplicar bordas verticais em todas as colunas desde o cabeçalho até o final dos dados
        for ($x = 0; $x <= $quantidadeColunas; $x++) {
            $coluna = $letras[$x];
            $style = $x < $quantidadeColunas ? $styleBordasColunas : $styleBordasFinas;

            // Aplicar bordas da linha 11 (cabeçalho) até a última linha de dados
            $sheet->getStyle("{$coluna}11:{$coluna}{$ultimaLinha}")->applyFromArray($style);
        }

        // Ajustar largura da coluna B
        $larguraColunaB = (13 - $this->tamanhoCabecalho) * 8.43;
        $sheet->getColumnDimension('C')
            ->setWidth($larguraColunaB)
            ->setAutoSize(false);
    }

    public function registerEvents(): array
    {
        return [
            BeforeSheet::class => function (BeforeSheet $event) {
                $event->sheet->getPageSetup()
                    ->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
            },
            AfterSheet::class => function (AfterSheet $event) {
            /** @var Worksheet $sheet */
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
        },

        ];
    }
}
