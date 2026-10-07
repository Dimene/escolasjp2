    <link rel="stylesheet" href="{{ asset('Admin-LTE/plugins/colorpicker/bootstrap-colorpicker.min.css') }}">
@php
    use Illuminate\Support\Str;
    use Carbon\Carbon;

    // ---- Alunos únicos (todos, não só não pagos) ----
    $alunos = $dados->unique('aluno_classe_id')->sortBy('nome')->values();

    // ---- Meses ordenados: [mes_id => 'Nome do Mês'] ----
    $meses = $dados->unique('mes_id')
                   ->sortBy('mes_id')
                   ->pluck('mes', 'mes_id')
                   ->toArray();

    // ---- Pré-indexa por [aluno_classe_id][mes_id] => registro ----
    $mapa = [];
    foreach ($dados as $item) {
        $mapa[$item->aluno_classe_id][$item->mes_id] = $item;
    }

    $totalAlunos = $alunos->count();
    $totalMeses  = count($meses);

    $primeiro = $dados->first();
@endphp

<div class="container-fluid py-4 relatorio-pagamentos-shell">

    {{-- ============ CABEÇALHO ============ --}}
    <div class="card border-0 shadow-lg mb-4 relatorio-header-card">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="icon-badge">
                        <i class="fa fa-file-invoice-dollar"></i>
                    </div>
                    <div>
                        <h4 class="mb-1 fw-bold gradient-title">
                            Relatório de Pagamentos
                        </h4>
                        <div class="text-muted small meta-line">
                            <span class="meta-pill">
                                <i class="fa fa-graduation-cap"></i>
                                Classe: <b>{{ $primeiro->classe ?? '—' }}</b>
                            </span>
                            <span class="meta-pill">
                                <i class="fa fa-calendar"></i>
                                Ano: <b>{{ $primeiro->anolectivo ?? '—' }}</b>
                            </span>
                            @if($turma)
                                <span class="meta-pill">
                                    <i class="fa fa-users"></i>
                                    Turma: <b>{{ $primeiro->turma ?? '—' }}</b>
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="d-flex flex-wrap gap-3">
                    <div class="mini-stat secondary">
                        <span class="value">{{ $totalAlunos }}</span>
                        <span class="label">{{ Str::plural('aluno', $totalAlunos) }}</span>
                    </div>
                    <div class="mini-stat primary">
                        <span class="value">{{ $totalMeses }}</span>
                        <span class="label">{{ Str::plural('mês', $totalMeses) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ============ TABELA ============ --}}
    <div class="card border-0 shadow-lg relatorio-card-table">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-middle mb-0 relatorio-pagamentos">
                    <thead>
                        <tr>
                            <th style="min-width: 220px;">Nome do Aluno</th>
                            @foreach ($meses as $mesId => $mesNome)
                                <th class="text-center text-nowrap" style="min-width: 110px;">
                                    {{ $mesNome }}
                                </th>
                            @endforeach
                            <th class="text-center" style="width: 120px;">Resumo</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($alunos as $i => $aluno)
                            @php
                                $pagosAluno = 0;
                                $devidoAluno = 0;
                                $linhaPar = ($i % 2 === 0);
                            @endphp
                            <tr class="row-aluno {{ $linhaPar ? 'linha-par' : 'linha-impar' }}">
                                <td class="fw-semibold aluno-nome">
                                    <div class="d-flex align-items-center gap-2">
                                        
                                        <span>{{ $aluno->nome }}</span>
                                    </div>
                                </td>

                                @foreach ($meses as $mesId => $mesNome)
                                    @php
                                        $reg = $mapa[$aluno->aluno_classe_id][$mesId] ?? null;
                                        $estado = $reg->Estado ?? null;

                                        if ($estado === 'Pago') {
                                            $pagosAluno++;
                                        } elseif ($reg) {
                                            $devidoAluno += ($reg->valorDescricao ?? 0) + ($reg->Multa ?? 0);
                                        }
                                    @endphp
                                    <td class="text-center cell-estado">
                                        @if ($estado === 'Pago')
                                            <span class="badge-status badge-pago">
                                                <i class="fa fa-check"></i> Pago
                                            </span>
                                            <div class="valor valor-pago">
                                                {{ number_format(($reg->valorDescricao ?? 0) + ($reg->Multa ?? 0), 2, ',', '.') }}
                                            </div>
                                        @elseif ($reg)
                                            <span class="badge-status badge-pendente">
                                                <i class="fa fa-clock"></i> {{ $estado }}
                                            </span>
                                            @if(($reg->valorDescricao ?? 0) > 0)
                                                <div class="valor valor-pendente">
                                                    {{ number_format(($reg->valorDescricao ?? 0) + ($reg->Multa ?? 0), 2, ',', '.') }}
                                                </div>
                                            @endif
                                        @else
                                            <span class="text-muted small">—</span>
                                        @endif
                                    </td>
                                @endforeach

                                <td class="text-center resumo-cell">
                                    @if ($pagosAluno === $totalMeses)
                                        <span class="badge-resumo resumo-ok">
                                            <i class="fa fa-check-circle"></i> OK
                                        </span>
                                    @else
                                        <span class="badge-resumo resumo-pendente">
                                            {{ $pagosAluno }}/{{ $totalMeses }}
                                        </span>
                                        @if($devidoAluno > 0)
                                            <div class="valor valor-pendente mt-1">
                                                {{ number_format($devidoAluno, 2, ',', '.') }}
                                            </div>
                                        @endif
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ $totalMeses + 2 }}" class="text-center py-5 empty-state">
                                    <div class="empty-icon">
                                        <i class="fa fa-inbox"></i>
                                    </div>
                                    <p class="text-muted mb-0 mt-3">Nenhum aluno encontrado para esta turma.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                    @if ($totalAlunos > 0)
                        <tfoot>
                            <tr>
                                <td class="text-end total-label">
                                    <i class="fa fa-coins me-1"></i> Total pago por mês
                                </td>
                                @foreach ($meses as $mesId => $mesNome)
                                    @php
                                        $totalMes = $dados->where('mes_id', $mesId)
                                                          ->where('Estado', 'Pago')
                                                          ->sum(fn ($r) => ($r->valorDescricao ?? 0) + ($r->Multa ?? 0));
                                        $countMes = $dados->where('mes_id', $mesId)
                                                          ->where('Estado', 'Pago')
                                                          ->count();
                                    @endphp
                                    <td class="text-center total-mes-cell">
                                        <div class="total-valor">{{ number_format($totalMes, 2, ',', '.') }}</div>
                                        <div class="total-count">{{ $countMes }} pago(s)</div>
                                    </td>
                                @endforeach
                                <td></td>
                            </tr>
                        </tfoot>
                    @endif
                </table>
            </div>
        </div>
    </div>
</div>


<style>
    /* ============ SHELL ============ */
    .relatorio-pagamentos-shell {
        background: linear-gradient(180deg, #f8fafd 0%, #eef4ff 100%);
        min-height: 100vh;
    }

    /* ============ HEADER ============ */
    .relatorio-header-card {
        background: linear-gradient(135deg, #ffffff 0%, #f0f6ff 100%);
        border-radius: 18px !important;
        border: 1px solid rgba(82, 112, 200, 0.10) !important;
        overflow: hidden;
        position: relative;
    }

    .relatorio-header-card::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 4px;
        background: linear-gradient(90deg, #0d6efd, #5ea8ff, #a78bfa);
    }

    .gradient-title {
        background: linear-gradient(135deg, #0d6efd, #4f46e5);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .icon-badge {
        width: 56px;
        height: 56px;
        border-radius: 16px;
        display: grid;
        place-items: center;
        background: linear-gradient(135deg, #0d6efd, #5ea8ff);
        color: #fff;
        box-shadow: 0 10px 22px rgba(13, 110, 253, 0.28);
        font-size: 1.3rem;
        flex-shrink: 0;
    }

    .meta-line {
        display: flex;
        flex-wrap: wrap;
        gap: .4rem;
        line-height: 1.6;
    }

    .meta-pill {
        display: inline-flex;
        align-items: center;
        gap: .35rem;
        background: rgba(13, 110, 253, 0.06);
        color: #4b5563;
        padding: .25rem .65rem;
        border-radius: 999px;
        font-size: .78rem;
        border: 1px solid rgba(13, 110, 253, 0.08);
    }

    .meta-pill i {
        color: #0d6efd;
        font-size: .72rem;
    }

    /* ============ MINI STATS ============ */
    .mini-stat {
        min-width: 120px;
        border-radius: 14px;
        padding: .7rem 1rem;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        border: 1px solid rgba(0, 0, 0, 0.05);
        transition: transform .2s ease, box-shadow .2s ease;
    }

    .mini-stat:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 18px rgba(0, 0, 0, 0.06);
    }

    .mini-stat.primary {
        background: linear-gradient(135deg, rgba(13, 110, 253, 0.10), rgba(94, 168, 255, 0.06));
        color: #0d6efd;
    }

    .mini-stat.secondary {
        background: linear-gradient(135deg, rgba(108, 117, 125, 0.10), rgba(108, 117, 125, 0.04));
        color: #495057;
    }

    .mini-stat .value {
        font-size: 1.3rem;
        line-height: 1.1;
    }

    .mini-stat .label {
        font-size: .7rem;
        opacity: .75;
        text-transform: uppercase;
        letter-spacing: .5px;
    }

    /* ============ TABELA ============ */
    .relatorio-card-table {
        border-radius: 18px !important;
        overflow: hidden;
        border: 1px solid rgba(13, 110, 253, 0.08) !important;
    }

    .relatorio-pagamentos thead th {
        font-size: .78rem;
        text-transform: uppercase;
        letter-spacing: .6px;
        vertical-align: middle;
        background: linear-gradient(180deg, #f9fafc 0%, #eef2f9 100%);
        color: #495057;
        border-bottom: 1px solid rgba(15, 23, 42, 0.08);
        padding: 1rem .75rem;
        font-weight: 700;
    }

    .relatorio-pagamentos tbody td {
        vertical-align: middle;
        padding: .85rem .65rem;
        border-color: rgba(15, 23, 42, 0.06);
    }

    /* ============ LINHAS INTERCALADAS (ZEBRADO) ============ */
    .relatorio-pagamentos tbody tr.linha-par {
        background-color: #ffffff;
    }

    .relatorio-pagamentos tbody tr.linha-impar {
        background-color: #f4f8ff;
    }

    .relatorio-pagamentos tbody tr.linha-par:hover,
    .relatorio-pagamentos tbody tr.linha-impar:hover {
        background-color: rgba(13, 110, 253, 0.07);
    }

    .aluno-nome {
        background: transparent;
    }

    /* ============ AVATAR ============ */
    .avatar-initial {
        width: 32px;
        height: 32px;
        border-radius: 10px;
        display: grid;
        place-items: center;
        background: linear-gradient(135deg, #0d6efd, #5ea8ff);
        color: #fff;
        font-weight: 700;
        font-size: .82rem;
        flex-shrink: 0;
        box-shadow: 0 4px 10px rgba(13, 110, 253, 0.20);
    }

    /* ============ BADGES DE ESTADO ============ */
    .badge-status {
        display: inline-flex;
        align-items: center;
        gap: .3rem;
        font-size: .72rem;
        font-weight: 600;
        padding: .3rem .7rem;
        border-radius: 999px;
        letter-spacing: .2px;
        white-space: nowrap;
    }

    .badge-pago {
        background: linear-gradient(135deg, rgba(25, 135, 84, 0.14), rgba(25, 135, 84, 0.06));
        color: #146c43;
        border: 1px solid rgba(25, 135, 84, 0.25);
    }

    .badge-pendente {
        background: linear-gradient(135deg, rgba(220, 53, 69, 0.14), rgba(220, 53, 69, 0.06));
        color: #b02a37;
        border: 1px solid rgba(220, 53, 69, 0.25);
    }

    /* ============ VALORES ============ */
    .valor {
        font-size: .74rem;
        font-weight: 700;
        margin-top: .3rem;
    }

    .valor-pago { color: #146c43; }
    .valor-pendente { color: #b02a37; }

    /* ============ RESUMO ============ */
    .badge-resumo {
        display: inline-flex;
        align-items: center;
        gap: .3rem;
        font-size: .74rem;
        font-weight: 700;
        padding: .35rem .8rem;
        border-radius: 999px;
        letter-spacing: .3px;
    }

    .resumo-ok {
        background: linear-gradient(135deg, #198754, #28a745);
        color: #fff;
        box-shadow: 0 4px 12px rgba(25, 135, 84, 0.28);
    }

    .resumo-pendente {
        background: linear-gradient(135deg, #ffc107, #ffb300);
        color: #4a3400;
        box-shadow: 0 4px 12px rgba(255, 193, 7, 0.28);
    }

    /* ============ RODAPÉ ============ */
    .relatorio-pagamentos tfoot td {
        background: linear-gradient(180deg, #f9fafc 0%, #eef2f9 100%);
        border-top: 2px solid rgba(13, 110, 253, 0.15);
        padding: 1rem .75rem;
    }

    .total-label {
        color: #4b5563;
        font-weight: 700;
        font-size: .8rem;
        letter-spacing: .3px;
    }

    .total-mes-cell {
        background: rgba(13, 110, 253, 0.03) !important;
    }

    .total-valor {
        color: #146c43;
        font-weight: 800;
        font-size: .85rem;
    }

    .total-count {
        font-size: .7rem;
        color: #6b7280;
        font-weight: 500;
        margin-top: .15rem;
    }

    /* ============ EMPTY STATE ============ */
    .empty-state {
        background: rgba(148, 163, 184, 0.04);
    }

    .empty-icon {
        width: 70px;
        height: 70px;
        margin: 0 auto;
        border-radius: 50%;
        display: grid;
        place-items: center;
        background: rgba(148, 163, 184, 0.12);
        color: #94a3b8;
        font-size: 1.8rem;
    }

    /* ============ RESPONSIVO ============ */
    @media (max-width: 768px) {
        .meta-line {
            flex-direction: column;
            gap: .3rem;
        }

        .mini-stat {
            min-width: 90px;
            padding: .5rem .8rem;
        }

        .mini-stat .value {
            font-size: 1.1rem;
        }

        .avatar-initial {
            width: 28px;
            height: 28px;
            font-size: .75rem;
        }
    }

    /* ============ PRINT ============ */
    @media print {
        .card {
            box-shadow: none !important;
            border: 1px solid #ddd !important;
        }
        .badge-status, .badge-resumo {
            border: 1px solid #ccc !important;
            box-shadow: none !important;
        }
        .relatorio-pagamentos-shell {
            background: white !important;
        }
        .avatar-initial {
            background: #555 !important;
            box-shadow: none !important;
        }
        .relatorio-pagamentos tbody tr.linha-par {
            background-color: #ffffff !important;
        }
        .relatorio-pagamentos tbody tr.linha-impar {
            background-color: #f4f8ff !important;
        }
    }
</style>
