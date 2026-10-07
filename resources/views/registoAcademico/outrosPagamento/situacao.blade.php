@php
    use Illuminate\Support\Str;

    // ---- Pré-processamento (uma varredura só) ----
    $totalRegistros = $dados->count();
    $totalAlunos    = $dados->unique('aluno_classe_id')->count();

    $pagos          = $dados->where('Estado', 'Pago');
    $naoPagos       = $dados->where('Estado', '!=', 'Pago');

    $totalPagos     = $pagos->count();
    $alunosPagos    = $pagos->unique('aluno_classe_id')->count();

    $totalNaoPagos  = $naoPagos->count();
    $alunosNaoPagos = $naoPagos->unique('aluno_classe_id')->count();

    // Percentagens para as barras de progresso
    $pctPagos       = $totalRegistros > 0 ? round(($totalPagos / $totalRegistros) * 100) : 0;
    $pctNaoPagos    = $totalRegistros > 0 ? round(($totalNaoPagos / $totalRegistros) * 100) : 0;

    // Agrupamento por turma
    $porTurma       = $dados->groupBy('turma_id');
@endphp

<div class="container-fluid py-3">

    {{-- ============ CARDS DE RESUMO ============ --}}
    <div class="row g-3 mb-4">

        {{-- Esperados --}}
        <div class="col-12 col-md-4">
            <div class="card border-0 shadow-sm h-100 card-stat" style="border-left: 6px solid #6c757d !important;">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-uppercase text-muted small fw-bold mb-1">Esperados</div>
                        <div class="h3 mb-0 fw-bold text-dark">{{ $totalRegistros }}</div>
                        <div class="small text-muted mt-1">
                            <i class="fa fa-users me-1"></i>
                            {{ $totalAlunos }} {{ Str::plural('aluno', $totalAlunos) }}
                        </div>
                    </div>
                    <div class="icon-circle bg-secondary bg-opacity-10 text-secondary">
                        <i class="fa fa-clipboard-list fa-lg"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- Pagos --}}
        <div class="col-12 col-md-4">
            <div class="card border-0 shadow-sm h-100 card-stat" style="border-left: 6px solid #198754 !important;">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div class="w-100">
                        <div class="text-uppercase text-muted small fw-bold mb-1">Pagos</div>
                        <div class="h3 mb-0 fw-bold text-success">{{ $totalPagos }}</div>
                        <div class="small text-muted mt-1">
                            <i class="fa fa-users me-1"></i>
                            {{ $alunosPagos }} {{ Str::plural('aluno', $alunosPagos) }}
                        </div>
                        <div class="progress mt-2" style="height: 6px;">
                            <div class="progress-bar bg-success" role="progressbar"
                                 style="width: {{ $pctPagos }}%"
                                 aria-valuenow="{{ $pctPagos }}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    <div class="icon-circle bg-success bg-opacity-10 text-success ms-3">
                        <i class="fa fa-check-circle fa-lg"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- Não pagos --}}
        <div class="col-12 col-md-4">
            <div class="card border-0 shadow-sm h-100 card-stat" style="border-left: 6px solid #dc3545 !important;">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div class="w-100">
                        <div class="text-uppercase text-muted small fw-bold mb-1">Não Pagos</div>
                        <div class="h3 mb-0 fw-bold text-danger">{{ $totalNaoPagos }}</div>
                        <div class="small text-muted mt-1">
                            <i class="fa fa-users me-1"></i>
                            {{ $alunosNaoPagos }} {{ Str::plural('aluno', $alunosNaoPagos) }}
                        </div>
                        <div class="progress mt-2" style="height: 6px;">
                            <div class="progress-bar bg-danger" role="progressbar"
                                 style="width: {{ $pctNaoPagos }}%"
                                 aria-valuenow="{{ $pctNaoPagos }}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    <div class="icon-circle bg-danger bg-opacity-10 text-danger ms-3">
                        <i class="fa fa-times-circle fa-lg"></i>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- ============ TABELA POR TURMA ============ --}}
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
            <h6 class="mb-0 fw-bold text-secondary">
                <i class="fa fa-table me-2"></i>Resumo por Turma
            </h6>
            <span class="badge bg-secondary">{{ $porTurma->count() }} {{ Str::plural('turma', $porTurma->count()) }}</span>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-3">Turma</th>
                            <th class="text-center">Nr Alunos</th>
                            <th class="text-center">Pagos</th>
                            <th class="text-center">Não Pagos</th>
                            <th class="text-center" style="width: 100px;">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($porTurma as $turmaId => $itens)
                            @php
                                $alunosTurma   = $itens->unique('aluno_classe_id')->count();
                                $pagosTurma    = $itens->where('Estado', 'Pago')->count();
                                $naoPagosTurma = $itens->where('Estado', '!=', 'Pago')->count();
                                $nomeTurma     = $itens->first()->turma ?? 'Sem Turma';
                            @endphp
                            <tr>
                                <td class="ps-3 fw-semibold">{{ $nomeTurma }}</td>
                                <td class="text-center">
                                    <span class="badge bg-secondary bg-opacity-10 text-secondary">
                                        {{ $alunosTurma }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-success bg-opacity-10 text-success">
                                        {{ $pagosTurma }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-danger bg-opacity-10 text-danger">
                                        {{ $naoPagosTurma }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <button
    type="button"
    class="btn btn-sm btn-outline-primary"
    title="Imprimir detalhado"
    onclick="abrirReciboPDF(@js(route('outrosPagamento.detalhada', [
        'ano'    => $ano,
        'classe' => $classe,
        'tipo'   => $tipo,
        'turma'  => $turmaId,
    ])), {{$turmaId}})">
    <i class="fa fa-print"></i>
</button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">
                                    <i class="fa fa-inbox fa-2x d-block mb-2 opacity-50"></i>
                                    Sem dados para apresentar.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>


@include('Componetes.frame-imprimir')

{{-- ============ ESTILOS AUXILIARES ============ --}}
@push('styles')
<style>
    .card-stat {
        transition: transform .15s ease, box-shadow .15s ease;
    }
    .card-stat:hover {
        transform: translateY(-2px);
        box-shadow: 0 .5rem 1rem rgba(0,0,0,.08) !important;
    }
    .icon-circle {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .table > :not(caption) > * > * {
        padding-top: .75rem;
        padding-bottom: .75rem;
    }
</style>
@endpush


@push('scripts')

@endpush