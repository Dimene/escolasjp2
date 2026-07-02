<?php

namespace App\Exports;

use App\Models\registoAcademico\anolectivo;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class ModeloImportacaoPagamentos implements WithEvents
{
    // Constantes de configuração
    private const HEADER_BACKGROUND = '1E3A8A';
    private const HEADER_FONT_COLOR = 'FFFFFF';
    private const HEADER_FONT_SIZE = 12;
    private const MAX_ROWS = 100;
     private $subdomain="";
    private const FIXED_COLUMNS = 7;

    private const COLUNAS_FIXAS = [
        'A' => 'ID Aluno',
        'B' => 'Nome do Aluno',
        'C' => 'Sexo',
        'D' => 'Data de Nascimento',
        'E' => 'Classe',
        'F' => 'Tipo Pagamento',
        'G' => 'Multa',
    ];

    private const LARGURAS_FIXAS = [
        'A' => 12, 'B' => 35, 'C' => 12, 'D' => 15,
        'E' => 15, 'F' => 20, 'G' => 15,
    ];

    private const LARGURAS_PAGAMENTO = 12;
    private const LARGURAS_RESTANTES = [
        15, 20, 20, 10, 10, 18, 18, 15,
        15, 25, 25, 20, 25, 20, 25, 12,
        18, 20, 15, 15, 15
    ];

    private $anoLectivo;
    private $tiposPagamento = [];
    private $inicioPagamentos = 7;
    private $quantidadeTipos = 0;

    public function __construct($ano)
    {
        $this->anoLectivo = $ano;
         $request = request();
    $host = $request->getHost();
    $this->subdomain = explode('.', $host)[0];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $linhaHeader = 8;

                $dados = $this->carregarDadosBanco();

                $this->adicionarLogoECabecalho($sheet, $dados['nomeEscola'], $dados['anoLectivo']);

                $ultimaColuna = $this->criarCabecalhoTabela($sheet, $dados['tipos'], $linhaHeader);

                $this->estilizarCabecalho($sheet, $linhaHeader, $ultimaColuna);
                $this->definirLarguraColunas($sheet);
                $this->fixarColunas($sheet, $linhaHeader);

                $sheet->freezePane('H' . ($linhaHeader + 1));

                $this->configurarFormatoData($sheet, $linhaHeader);
                $this->criarSheetListas($event, $dados, $sheet, $linhaHeader);
            }
        ];
    }

    private function carregarDadosBanco(): array
    {
        $anolectivo = anolectivo::find($this->anoLectivo);

        if (!$anolectivo) {
            throw new \Exception("Ano lectivo não encontrado: {$this->anoLectivo}");
        }

        $this->tiposPagamento = DB::table("detalhestabelavaores")
            ->where("anolectivo_id", $anolectivo->id)
            ->where("tipo", ">", 2)
            ->pluck('Descricao')
            ->unique()
            ->values()
            ->filter() // Remove valores null/empty
            ->toArray();

        $this->quantidadeTipos = count($this->tiposPagamento);
        $this->inicioPagamentos = self::FIXED_COLUMNS + 1;

        $nomeEscola = DB::table("config")->value('nome') ?? "ESCOLA";

        return [
            'anoLectivo' => $anolectivo->anolectivo,
            'nomeEscola' => $nomeEscola,
            'tipos' => $this->tiposPagamento,
            'metodos' => DB::table("metodo_pagamento")->pluck('Descricao')->filter()->toArray(),
            'classes' => DB::table("classes")->pluck('Descricao')->filter()->toArray(),
            'paises' => DB::table("paises")->pluck('nome')->filter()->toArray(),
            'provincias' => DB::table("provincias")->pluck('nome')->filter()->toArray(),
            'distritos' => DB::table("distritos")->pluck('nome')->filter()->toArray(),
            'religioes' => DB::table("religiaes")->pluck('nome')->filter()->toArray(),
            'doencas' => DB::table("doencas")->pluck('nome')->filter()->toArray(),
            'graus' => DB::table("grauparentestos")->pluck('Descricao')->filter()->toArray(),
            'profissoes' => DB::table("profissaos")->pluck('Descricao')->filter()->toArray(),
        ];
    }

    private function adicionarLogoECabecalho(Worksheet $sheet, string $nomeEscola, string $anolectivo): void
    {
        $this->adicionarLogo($sheet);

        $sheet->setCellValue('D1', $nomeEscola);
        $sheet->mergeCells('D1:I1');
        $sheet->getStyle('D1')->applyFromArray([
            'font' => ['bold' => true, 'size' => 24, 'color' => ['argb' => self::HEADER_BACKGROUND]],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER]
        ]);
        $sheet->getRowDimension(1)->setRowHeight(40);

        $sheet->setCellValue('D2', 'FICHA DE REGISTO DE ALUNOS');
        $sheet->mergeCells('D2:I2');
        $sheet->getStyle('D2')->applyFromArray([
            'font' => ['bold' => true, 'size' => 18, 'color' => ['argb' => '2C3E50']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER]
        ]);

        $sheet->setCellValue('D3', 'Ano Letivo: ' . $anolectivo);
        $sheet->mergeCells('D3:E3');
        $sheet->setCellValue('F3', 'Data de Emissão: ' . date('d/m/Y H:i'));
        $sheet->mergeCells('F3:I3');
        $sheet->getStyle('D3:F3')->getFont()->setBold(true);

        $sheet->setCellValue('A4', '');
        $sheet->mergeCells('A4:I4');
        $sheet->getStyle('A4:I4')->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()->setARGB(self::HEADER_BACKGROUND);
        $sheet->getRowDimension(4)->setRowHeight(5);

        for ($i = 5; $i <= 7; $i++) {
            $sheet->setCellValue('A' . $i, '');
            $sheet->mergeCells('A' . $i . ':I' . $i);
            $sheet->getRowDimension($i)->setRowHeight(5);
        }
    }

    private function adicionarLogo(Worksheet $sheet): void
    {
        $logoPath = public_path('/storage/'. $this->subdomain.'/logoMarca/logoTipo.png');

        if (file_exists($logoPath)) {
            try {
                $drawing = new Drawing();
                $drawing->setName('Logo Escola');
                $drawing->setDescription('Logo da Escola');
                $drawing->setPath($logoPath);
                $drawing->setHeight(100);
                $drawing->setOffsetX(10);
                $drawing->setOffsetY(5);
                $drawing->setCoordinates('A1');
                $drawing->setWorksheet($sheet);
            } catch (\Exception $e) {
                // Silently continue
            }
        }
    }

    private function criarCabecalhoTabela(Worksheet $sheet, array $tipos, int $linhaHeader): string
    {
        $coluna = 1;

        foreach (self::COLUNAS_FIXAS as $colLetra => $titulo) {
            $sheet->setCellValue($colLetra . $linhaHeader, $titulo);
            $coluna++;
        }

        $this->inicioPagamentos = $coluna;
        foreach ($tipos as $tipo) {
            $colLetra = Coordinate::stringFromColumnIndex($coluna);
            $sheet->setCellValue($colLetra . $linhaHeader, $tipo);
            $coluna++;
        }

        $colunasRestantes = $this->getColunasRestantes();
        foreach ($colunasRestantes as $titulo) {
            $colLetra = Coordinate::stringFromColumnIndex($coluna);
            $sheet->setCellValue($colLetra . $linhaHeader, $titulo);
            $coluna++;
        }

        return Coordinate::stringFromColumnIndex($coluna - 1);
    }

    private function getColunasRestantes(): array
    {
        return [
            'Religião', 'Bairro', 'Rua / Avenida', 'Quarteirão', 'Casa Nº',
            'Natural de', 'Província', 'País', 'Estado de Saúde', 'Doenças',
            'Nome Pai', 'Profissão Pai', 'Nome Mãe', 'Profissão Mãe',
            'Nome Encarregado', 'Sexo Encarregado', 'Grau Parentesco', 'Profissão Encarregado',
            'Contacto 1', 'Contacto 2', 'Contacto 3'
        ];
    }

    private function estilizarCabecalho(Worksheet $sheet, int $linhaHeader, string $ultimaColuna): void
    {
        $range = "A{$linhaHeader}:{$ultimaColuna}{$linhaHeader}";

        $sheet->getStyle($range)->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => self::HEADER_FONT_SIZE,
                'color' => ['argb' => self::HEADER_FONT_COLOR]
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['argb' => self::HEADER_BACKGROUND]
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => '000000']
                ]
            ]
        ]);

        $sheet->getRowDimension($linhaHeader)->setRowHeight(35);
    }

    private function fixarColunas(Worksheet $sheet, int $linhaHeader): void
    {
        $totalColunasFixas = self::FIXED_COLUMNS + $this->quantidadeTipos + count($this->getColunasRestantes());

        for ($col = 1; $col <= $totalColunasFixas; $col++) {
            $colLetra = Coordinate::stringFromColumnIndex($col);
            $range = "{$colLetra}{$linhaHeader}:{$colLetra}" . self::MAX_ROWS;

            $sheet->getStyle($range)->applyFromArray([
                'borders' => [
                    'outline' => [
                        'borderStyle' => Border::BORDER_MEDIUM,
                        'color' => ['argb' => '18171B']
                    ]
                ]
            ]);
        }
    }

    private function configurarFormatoData(Worksheet $sheet, int $linhaHeader): void
    {
        for ($row = $linhaHeader + 1; $row <= self::MAX_ROWS; $row++) {
            $cell = "D{$row}";

            $sheet->getStyle($cell)
                ->getNumberFormat()
                ->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);

            $validation = $sheet->getCell($cell)->getDataValidation();
            $validation->setType(DataValidation::TYPE_DATE)
                ->setErrorStyle(DataValidation::STYLE_STOP)
                ->setAllowBlank(true)
                ->setShowInputMessage(true)
                ->setShowErrorMessage(true)
                ->setErrorTitle('Data inválida')
                ->setError('Por favor, insira uma data válida no formato DD/MM/AAAA')
                ->setPromptTitle('Data de Nascimento')
                ->setPrompt('Insira a data no formato DD/MM/AAAA');
        }
    }

    private function definirLarguraColunas(Worksheet $sheet): void
    {
        foreach (self::LARGURAS_FIXAS as $col => $width) {
            $sheet->getColumnDimension($col)->setWidth($width);
        }

        for ($i = 0; $i < $this->quantidadeTipos; $i++) {
            $colLetra = Coordinate::stringFromColumnIndex($this->inicioPagamentos + $i);
            $sheet->getColumnDimension($colLetra)->setWidth(self::LARGURAS_PAGAMENTO);
        }

        $colunaAtual = $this->inicioPagamentos + $this->quantidadeTipos;
        foreach (self::LARGURAS_RESTANTES as $width) {
            $colLetra = Coordinate::stringFromColumnIndex($colunaAtual);
            $sheet->getColumnDimension($colLetra)->setWidth($width);
            $colunaAtual++;
        }
    }

    private function criarSheetListas($event, array $dados, Worksheet $sheet, int $linhaHeader): void
    {
        $spreadsheet = $event->sheet->getParent();

        if ($spreadsheet->sheetNameExists('Listas')) {
            $spreadsheet->removeSheetByIndex(
                $spreadsheet->getIndex($spreadsheet->getSheetByName('Listas'))
            );
        }

        $listasSheet = new Worksheet($spreadsheet, 'Listas');
        $spreadsheet->addSheet($listasSheet);

        // Filtrar valores vazios/nulos das listas
        $listas = [
            'sexo' => ['Masculino', 'Feminino'],
            'estado_saude' => ['Sem Doença', 'Com Doença'],
            'sim_nao' => ['Sim', 'Não'],
            'metodos' => array_filter($dados['metodos']),
            'classes' => array_filter($dados['classes']),
            'paises' => array_filter($dados['paises']),
            'provincias' => array_filter($dados['provincias']),
            'distritos' => array_filter($dados['distritos']),
            'religioes' => array_filter($dados['religioes']),
            'doencas' => array_filter($dados['doencas']),
            'graus' => array_filter($dados['graus']),
            'profissoes' => array_filter($dados['profissoes']),
        ];

        $linhaAtual = 1;
        foreach ($listas as $nome => $valores) {
            if (empty($valores)) {
                continue;
            }

            $listasSheet->setCellValue('A' . $linhaAtual, "=== " . strtoupper($nome) . " ===");
            $listasSheet->getStyle('A' . $linhaAtual)->getFont()->setBold(true);
            $linhaAtual++;

            foreach ($valores as $valor) {
                if (!empty($valor)) {
                    $listasSheet->setCellValue('A' . $linhaAtual, $valor);
                    $linhaAtual++;
                }
            }
            $linhaAtual++;
        }

        $this->aplicarValidacoes($sheet, $listasSheet, $listas, $linhaHeader);
        $listasSheet->setSheetState(Worksheet::SHEETSTATE_HIDDEN);
    }

    private function aplicarValidacoes(Worksheet $sheet, Worksheet $listasSheet, array $listas, int $linhaHeader): void
    {
        $mapeamento = $this->getMapeamentoValidacoes();

        for ($row = $linhaHeader + 1; $row <= self::MAX_ROWS; $row++) {
            foreach ($mapeamento as $colLetra => $listaNome) {
                if (isset($listas[$listaNome]) && !empty($listas[$listaNome])) {
                    $this->criarValidacao($sheet, $colLetra . $row, $listasSheet, $listas[$listaNome]);
                }
            }

            $this->aplicarValidacaoSimNao($sheet, $row);
        }
    }

    private function getMapeamentoValidacoes(): array
    {
        $offset = $this->inicioPagamentos + $this->quantidadeTipos;

        return [
            'C' => 'sexo',
            'E' => 'classes',
            'F' => 'metodos',
            'G' => 'sim_nao',
            Coordinate::stringFromColumnIndex($offset) => 'religioes',
            Coordinate::stringFromColumnIndex($offset + 8) => 'estado_saude',
            Coordinate::stringFromColumnIndex($offset + 9) => 'doencas',
            Coordinate::stringFromColumnIndex($offset + 11) => 'profissoes',
            Coordinate::stringFromColumnIndex($offset + 13) => 'profissoes',
            Coordinate::stringFromColumnIndex($offset + 17) => 'profissoes',
            Coordinate::stringFromColumnIndex($offset + 15) => 'sexo',
            Coordinate::stringFromColumnIndex($offset + 16) => 'graus',
            Coordinate::stringFromColumnIndex($offset + 5) => 'distritos',
            Coordinate::stringFromColumnIndex($offset + 6) => 'provincias',
            Coordinate::stringFromColumnIndex($offset + 7) => 'paises',
        ];
    }

    private function aplicarValidacaoSimNao(Worksheet $sheet, int $row): void
    {
        for ($col = $this->inicioPagamentos; $col < $this->inicioPagamentos + $this->quantidadeTipos; $col++) {
            $colLetra = Coordinate::stringFromColumnIndex($col);
            $this->criarValidacaoSimNao($sheet, $colLetra . $row);
        }
    }

    /**
     * Criar validação de lista - CORRIGIDO
     */
    private function criarValidacao(Worksheet $sheet, string $cell, Worksheet $listasSheet, array $valores): void
    {
        // Verificar se a lista está vazia
        if (empty($valores) || !is_array($valores)) {
            return;
        }

        // Filtrar valores nulos/vazios
        $valoresFiltrados = array_filter($valores, function($valor) {
            return !empty($valor) && is_string($valor);
        });

        if (empty($valoresFiltrados)) {
            return;
        }

        try {
            // Pegar o primeiro valor válido
            $primeiroValor = reset($valoresFiltrados);

            if (empty($primeiroValor)) {
                return;
            }

            $linhaInicio = $this->encontrarLinhaLista($listasSheet, $primeiroValor);

            if ($linhaInicio === 0) {
                return;
            }

            $validation = $sheet->getCell($cell)->getDataValidation();
            $validation->setType(DataValidation::TYPE_LIST)
                ->setErrorStyle(DataValidation::STYLE_STOP)
                ->setAllowBlank(true)
                ->setShowDropDown(true)
                ->setFormula1("=Listas!\$A\${$linhaInicio}:\$A\$" . ($linhaInicio + count($valoresFiltrados) - 1));
        } catch (\Exception $e) {
            // Log silencioso
        }
    }

    /**
     * Criar validação Sim/Não
     */
    private function criarValidacaoSimNao(Worksheet $sheet, string $cell): void
    {
        try {
            $validation = $sheet->getCell($cell)->getDataValidation();
            $validation->setType(DataValidation::TYPE_LIST)
                ->setErrorStyle(DataValidation::STYLE_STOP)
                ->setAllowBlank(true)
                ->setShowDropDown(true)
                ->setFormula1('"Sim,Não"');
        } catch (\Exception $e) {
            // Log silencioso
        }
    }

    /**
     * Encontrar linha de início de uma lista - CORRIGIDO
     */
    private function encontrarLinhaLista(Worksheet $listasSheet, string $valor): int
    {
        // Verificar se o valor é válido
        if (empty($valor) || !is_string($valor)) {
            return 0;
        }

        $highestRow = $listasSheet->getHighestRow();

        for ($row = 1; $row <= $highestRow; $row++) {
            $cellValue = $listasSheet->getCell('A' . $row)->getValue();

            // Comparar apenas se ambos são strings
            if (is_string($cellValue) && trim($cellValue) === trim($valor)) {
                return $row;
            }
        }

        return 0; // Retorna 0 se não encontrar
    }
}
