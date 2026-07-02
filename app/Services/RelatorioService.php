<?php

namespace App\Services;

use App\Repositories\PagamentoRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class RelatorioService
{
    protected $pagamentoRepository;

    public function __construct(PagamentoRepository $pagamentoRepository)
    {
        $this->pagamentoRepository = $pagamentoRepository;
    }

    public function gerarRelatorioPagamentos(array $filtros)
    {
        $cacheKey = $this->gerarChaveCache($filtros);

        return Cache::remember($cacheKey, 300, function () use ($filtros) {
            return $this->processarRelatorio($filtros);
        });
    }

    protected function processarRelatorio(array $filtros)
    {
        // 1. Dados agrupados por data
        $dadosPorData = $this->pagamentoRepository->getPagamentosAgrupadosPorData($filtros);

        // 2. Detalhes por data e classe
        $detalhes = $this->pagamentoRepository->getDetalhesPagamentos($filtros);

        // 3. Métodos de pagamento por data/classe
        $metodosDetalhados = $this->pagamentoRepository->getMetodosPagamentoDetalhados($filtros);

        // 4. Totais consolidados
        $totais = $this->calcularTotais($detalhes);

        // 5. Estatísticas adicionais
        $estatisticas = $this->calcularEstatisticas($detalhes, $metodosDetalhados);

        return [
            'dadosPorData' => $dadosPorData,
            'detalhes' => $detalhes,
            'metodosDetalhados' => $metodosDetalhados,
            'totais' => $totais,
            'estatisticas' => $estatisticas,
            'filtros' => $filtros,
            'periodo' => [
                'inicio' => Carbon::parse($filtros['data_inicio'])->format('d/m/Y'),
                'fim' => Carbon::parse($filtros['data_fim'])->format('d/m/Y')
            ]
        ];
    }

    protected function calcularTotais($detalhes)
    {
        $totais = [
            'total_alunos' => 0,
            'total_valor' => 0,
            'total_multa' => 0,
            'total_geral' => 0,
            'total_dias' => 0,
            'total_classes' => 0
        ];

        foreach ($detalhes as $data => $classes) {
            foreach ($classes as $classe => $dados) {
                $totais['total_alunos'] += $dados['nr_alunos'] ?? 0;
                $totais['total_valor'] += $dados['subtotal'] ?? 0;
                $totais['total_multa'] += $dados['multas'] ?? 0;
            }
            $totais['total_dias']++;
            $totais['total_classes'] += count($classes);
        }

        $totais['total_geral'] = $totais['total_valor'] + $totais['total_multa'];

        return $totais;
    }

    protected function calcularEstatisticas($detalhes, $metodosDetalhados)
    {
        $estatisticas = [
            'metodos_pagamento' => [],
            'media_diaria' => 0,
            'media_por_classe' => 0,
            'classe_maior_valor' => null,
            'dia_maior_movimento' => null
        ];

        // Calcular estatísticas por método de pagamento
        foreach ($metodosDetalhados as $data => $classes) {
            foreach ($classes as $classe => $metodos) {
                foreach ($metodos as $metodo => $dados) {
                    if (!isset($estatisticas['metodos_pagamento'][$metodo])) {
                        $estatisticas['metodos_pagamento'][$metodo] = [
                            'quantidade' => 0,
                            'valor_total' => 0,
                            'multa_total' => 0,
                            'porcentagem' => 0
                        ];
                    }

                    $estatisticas['metodos_pagamento'][$metodo]['quantidade'] += $dados['quantidade'] ?? 0;
                    $estatisticas['metodos_pagamento'][$metodo]['valor_total'] += $dados['valor'] ?? 0;
                    $estatisticas['metodos_pagamento'][$metodo]['multa_total'] += $dados['multa'] ?? 0;
                }
            }
        }

        // Calcular porcentagens
        $totalGeral = array_sum(array_column($estatisticas['metodos_pagamento'], 'valor_total'));
        foreach ($estatisticas['metodos_pagamento'] as &$metodo) {
            $metodo['porcentagem'] = $totalGeral > 0
                ? round(($metodo['valor_total'] / $totalGeral) * 100, 2)
                : 0;
        }

        return $estatisticas;
    }

    protected function gerarChaveCache(array $filtros)
    {
        return sprintf(
            'relatorio_pagamentos_%s_%s_%s_%s_%s',
            $filtros['ano'],
            $filtros['classe'],
            $filtros['data_inicio']->format('Ymd'),
            $filtros['data_fim']->format('Ymd'),
            $filtros['tipo_pagamento']
        );
    }
}
