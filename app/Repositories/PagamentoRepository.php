<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class PagamentoRepository
{
    public function getPagamentosAgrupadosPorData(array $filtros)
    {
        $query = DB::table('relatoriograficoview')
            ->select([
                DB::raw('DATE(data_pagamento) as data_formatada'),
                DB::raw('COUNT(DISTINCT classe_id) as total_classes'),
                DB::raw("GROUP_CONCAT(DISTINCT classe ORDER BY classe SEPARATOR ', ') as classes"),
                DB::raw('COUNT(DISTINCT aluno_classe_id) as total_alunos'),
                DB::raw('SUM(valorDescricao) as valor_total'),
                DB::raw('SUM(IFNULL(Multa, 0)) as multa_total')
            ])
            ->where('tipo_pagamento_id', $filtros['tipo_pagamento'])
            ->where('anolectivo_id', $filtros['ano'])
            ->whereBetween('data_pagamento', [
                $filtros['data_inicio'],
                $filtros['data_fim']
            ]);

        if ($filtros['classe'] != 0) {
            $query->where('classe_id', $filtros['classe']);
        }

        return $query->groupBy(DB::raw('DATE(data_pagamento)'))
            ->orderBy('data_formatada')
            ->get()
            ->keyBy('data_formatada');
    }

    public function getDetalhesPagamentos(array $filtros)
    {
        $query = DB::table('relatoriograficoview')
            ->select([
                DB::raw('DATE(data_pagamento) as data'),
                'classe',
                DB::raw('COUNT(DISTINCT aluno_classe_id) as nr_alunos'),
                DB::raw('SUM(valorDescricao) as subtotal'),
                DB::raw('SUM(IFNULL(Multa, 0)) as multas'),
                DB::raw("GROUP_CONCAT(DISTINCT CONCAT(metodoPagDesc, ' (', metodopaga_id, ')') SEPARATOR '; ') as metodos_ids")
            ])
            ->where('tipo_pagamento_id', $filtros['tipo_pagamento'])
            ->where('anolectivo_id', $filtros['ano'])
            ->whereBetween('data_pagamento', [
                $filtros['data_inicio'],
                $filtros['data_fim']
            ]);

        if ($filtros['classe'] != 0) {
            $query->where('classe_id', $filtros['classe']);
        }

        return $query->groupBy(DB::raw('DATE(data_pagamento)'), 'classe')
            ->orderBy('data')
            ->orderBy('classe')
            ->get()
            ->groupBy(['data', 'classe']);
    }

    public function getMetodosPagamentoDetalhados(array $filtros)
    {
        $query = DB::table('relatoriograficoview')
            ->select([
                DB::raw('DATE(data_pagamento) as data'),
                'classe',
                'metodoPagDesc',
                'metodopaga_id',
                DB::raw('COUNT(DISTINCT aluno_classe_id) as quantidade'),
                DB::raw('SUM(valorDescricao) as valor'),
                DB::raw('SUM(IFNULL(Multa, 0)) as multa')
            ])
            ->where('tipo_pagamento_id', $filtros['tipo_pagamento'])
            ->where('anolectivo_id', $filtros['ano'])
            ->whereBetween('data_pagamento', [
                $filtros['data_inicio'],
                $filtros['data_fim']
            ]);

        if ($filtros['classe'] != 0) {
            $query->where('classe_id', $filtros['classe']);
        }

        return $query->groupBy(
                DB::raw('DATE(data_pagamento)'),
                'classe',
                'metodoPagDesc',
                'metodopaga_id'
            )
            ->orderBy('data')
            ->orderBy('classe')
            ->orderBy('metodoPagDesc')
            ->get()
            ->groupBy(['data', 'classe', 'metodoPagDesc'])
            ->map(function ($items, $key) {
                return $items->first(); // Como agrupamos, pegamos o primeiro
            });
    }
}
