<?php

namespace App\Http\Controllers;

use App\Repositories\PagamentoRepository;
use App\Services\RelatorioService;
use Illuminate\Http\Request;
use Carbon\Carbon;

class RelatorioPagamentosController extends Controller
{
    protected $pagamentoRepository;
    protected $relatorioService;

    public function __construct(
        PagamentoRepository $pagamentoRepository,
        RelatorioService $relatorioService
    ) {
        $this->pagamentoRepository = $pagamentoRepository;
        $this->relatorioService = $relatorioService;
    }

    public function index(Request $request)
    {
        // Validação dos parâmetros
        $request->validate([
            'ano' => 'required|integer|exists:ano_lectivos,id',
            'classe' => 'nullable|integer|exists:classes,id',
            'data_inicio' => 'required|date',
            'data_fim' => 'required|date|after_or_equal:data_inicio',
            'tipo_pagamento' => 'required|integer|exists:tipo_pagamentos,id',
            'formato' => 'nullable|in:html,pdf,excel'
        ]);

        $filtros = [
            'ano' => $request->ano,
            'classe' => $request->classe ?? 0,
            'data_inicio' => Carbon::parse($request->data_inicio)->startOfDay(),
            'data_fim' => Carbon::parse($request->data_fim)->endOfDay(),
            'tipo_pagamento' => $request->tipo_pagamento,
            'formato' => $request->formato ?? 'html'
        ];

        // Buscar dados do relatório
        $relatorio = $this->relatorioService->gerarRelatorioPagamentos($filtros);

        // Retornar no formato solicitado
        return $this->responderRelatorio($relatorio, $filtros['formato']);
    }

    protected function responderRelatorio($relatorio, $formato)
    {
        switch ($formato) {
            case 'pdf':
                return $this->gerarPDF($relatorio);
            case 'excel':
                return $this->gerarExcel($relatorio);
            default:
                return view('relatorios.pagamentos.index', $relatorio);
        }
    }
}
