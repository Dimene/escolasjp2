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
    // Evita N×M where() dentro do loop (ganho enorme de performance)
    $mapa = [];
    foreach ($dados as $item) {
        $mapa[$item->aluno_classe_id][$item->mes_id] = $item;
    }

    $totalAlunos = $alunos->count();
    $totalMeses  = count($meses);

    $primeiro = $dados->first();
@endphp

<div class="container-fluid py-3">
@include("Componetes.cabecalho")

    {{-- ============ CABEÇALHO ============ --}}
    <div class="card border-0 shadow-sm mb-3">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
              <center> 
                <div>
                    <h5 class="mb-1 fw-bold text-secondary">
                        <i class="fa fa-file-invoice-dollar me-2"></i>
                        Historico de {{ $primeiro->tipodepagamentoDescricao ?? '—' }}
                    </h5>
                    <div class="text-muted small">
                        <span class="me-3">
                            <i class="fa fa-graduation-cap me-1"></i>
                            Classe: <b>{{ $primeiro->classe ?? '—' }}</b>
                        </span>
                        <span class="me-3">
                            <i class="fa fa-calendar me-1"></i>
                            Ano: <b>{{ $primeiro->anolectivo ?? '—' }}</b>
                        </span>
                        @if($turma)
                            <span>
                                <i class="fa fa-users me-1"></i>
                                Turma: <b>{{ $primeiro->turma ?? '—' }}</b>
                            </span>
                        @endif
                    </div>
                </div>
                 </center> 
                <div class="text-end">
                    <div class="badge bg-secondary bg-opacity-10 text-secondary fs-6">
                        {{ $totalAlunos }} {{ Str::plural('aluno', $totalAlunos) }}
                    </div>
                    <div class="badge bg-primary bg-opacity-10 text-primary fs-6">
                        {{ $totalMeses }} {{ Str::plural('mês', $totalMeses) }}
                    </div>
                </div>
            </div>
           
        </div>
    </div>

    {{-- ============ TABELA ============ --}}
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle mb-0 relatorio-pagamentos">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center" style="width: 50px;">#</th>
                            <th style="min-width: 220px;">Nome do Aluno</th>
                            @foreach ($meses as $mesId => $mesNome)
                                <th class="text-center text-nowrap" style="min-width: 110px;">
                                    {{ $mesNome }}
                                </th>
                            @endforeach
                            <th class="text-center" style="width: 90px;">Resumo</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($alunos as $i => $aluno)
                            @php
                                $pagosAluno = 0;
                                $devidoAluno = 0;
                            @endphp
                            <tr>
                                <td class="text-center text-muted">{{ $i + 1 }}</td>
                                <td class="fw-semibold">{{ $aluno->nome }}</td>

                                @foreach ($meses as $mesId => $mesNome)
                                    @php
                                        $reg = $mapa[$aluno->aluno_classe_id][$mesId] ?? null;
                                        $estado = $reg->Estado ?? null;

                                        if ($estado === 'Pago') {
                                            $pagosAluno++;
                                        } elseif ($reg) {

                                            $MULTA=0;
                                            if(carbon::parse($reg->data_Fim)<carbon::now()){
                                                $MULTA=($reg->valorDescricao*($reg->multaP/100));
                                            }
                                            $devidoAluno += ($reg->valorDescricao ?? 0) + ($MULTA ?? 0);
                                        }
                                    @endphp
                                    <td class="text-center">
                                        @if ($estado === 'Pago')
                                            <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-2 py-1">
                                                <i class="fa fa-check me-1"></i>Pago
                                            </span>
                                            <div class="small text-success mt-1 fw-semibold">
                                                {{ number_format(($reg->valorDescricao ?? 0) + ($reg->Multa ?? 0), 2, ',', '.') }}
                                            </div>
                                        @elseif ($reg)
                                            <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 px-2 py-1">
                                                <i class="fa fa-times me-1"></i>{{ $estado }}
                                            </span>
                                           
                                        @else
                                            <span class="text-muted small">—</span>
                                        @endif
                                    </td>
                                @endforeach

                                {{-- Coluna de resumo do aluno --}}
                                <td class="text-center">
                                    @if ($pagosAluno === $totalMeses)
                                        <span class="badge bg-success">
                                            <i class="fa fa-check-circle me-1"></i>OK
                                        </span>
                                    @else
                                        <span class="badge bg-warning text-dark">
                                            {{ $pagosAluno }}/{{ $totalMeses }}
                                        </span>
                                        @if($devidoAluno > 0)
                                            <div class="small text-danger mt-1 fw-semibold">
                                                {{ number_format($devidoAluno, 2, ',', '.') }}
                                            </div>
                                        @endif
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ $totalMeses + 3 }}" class="text-center text-muted py-4">
                                    <i class="fa fa-inbox fa-2x d-block mb-2 opacity-50"></i>
                                    Nenhum aluno encontrado para esta turma.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                    {{-- Rodapé com totais por mês --}}
                    @if ($totalAlunos > 0)
                        <tfoot class="table-light fw-bold">
                            <tr>
                                <td colspan="2" class="text-end">Total pago por mês →</td>
                                @foreach ($meses as $mesId => $mesNome)
                                    @php
                                        $totalMes = $dados->where('mes_id', $mesId)
                                                          ->where('Estado', 'Pago')
                                                          ->sum(fn ($r) => ($r->valorDescricao ?? 0) + ($r->Multa ?? 0));
                                        $countMes = $dados->where('mes_id', $mesId)
                                                          ->where('Estado', 'Pago')
                                                          ->count();
                                    @endphp
                                    <td class="text-center">
                                        <div class="text-success">{{ number_format($totalMes, 2, ',', '.') }}</div>
                                        <div class="small text-muted fw-normal">{{ $countMes }} pago(s)</div>
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
    .table-light{
        background-color: rgba(0, 0, 0, 0.904);
        color: #ffff;
    }
    .bg-success{
        background-color: #198754;
        color: #ffff;
         padding: 2px 5px;
        border-radius: 4px;
    }
    .bg-danger{
        background-color: #be505b;
        color: #ffff;
        padding: 2px 5px;
        border-radius: 4px;
    }
  table > tbody > tr > td,
table > tbody > tr > th {
    border-bottom: 1px solid #dee2eb;
}
table > tbody > tr:nth-child(2n) {      /* pares */
    background-color: #ffffff;
}

table > tbody > tr:nth-child(2n+1) {    /* ímpares */
    background-color: #f8f9fa;
}
</style>