@if($dadosTabela->count() > 0)
<table>
    <thead>
        <tr>
            <th>Mês</th>
            <th>Valor</th>
            <th>Entidade</th>
            <th>Referência</th>
            <th>Situação</th>
        </tr>
    </thead>
    <tbody>

  @foreach($dadosTabela as $grupo)
    @if(!empty($grupo['meses']) && optional($grupo['meses']->first())->tipo > 2)

        @if($tipoExibido !== ($grupo['Tipo'] ?? 'Outros Pagamentos'))
            <tr class="grupo">
                <td colspan="5">{{ $grupo['Tipo'] ?? 'Outros Pagamentos' }}</td>
            </tr>

            @php
                $tipoExibido = $grupo['Tipo'] ?? 'Outros Pagamentos';
            @endphp
        @endif

        @php
            $linhas = collect();

            foreach ($grupo['meses'] as $item) {
                $dadosCarregado = DB::table('outros_pagamentosview')
                    ->where('aluno_classe_id', $item->id ?? null)
                    ->where('mes_id', $item->mes_id ?? null)
                    ->where('tipoPagamento_id', $item->tipo_pagamento_id ?? null)
                    ->first();

                $valor = $item->valorDescricao;
                $estado = $item->Estado ?? 'Data limite: '.$item->limite;
                $estadoValor = $dadosCarregado->Estado ?? '';

                if ($estadoValor == 'Pago' || $estadoValor == 'activo') {
                    $estado = 'pago';
                } elseif ($item->multaflag) {
                    $valor += ($item->multa / 100) * $valor;
                    $estado = $dadosCarregado->estado ?? 'Vencido';
                }

                $total += $valor;
                $linhas->push([
                    'item' => $item,
                    'valor' => $valor,
                    'estado' => $estado,
                ]);
            }

            $contagemReferencias = [];
            $somasReferencias = [];
            $ultimosIndicesReferencias = [];

            foreach ($linhas as $indice => $linha) {
                $referencia = $linha['item']->referencia ?? null;
                if ($referencia === null || $referencia === '') {
                    continue;
                }

                $contagemReferencias[$referencia] = ($contagemReferencias[$referencia] ?? 0) + 1;
                $somasReferencias[$referencia] = ($somasReferencias[$referencia] ?? 0) + $linha['valor'];
                $ultimosIndicesReferencias[$referencia] = $indice;
            }
        @endphp

        @foreach($linhas as $indice => $linha)
            @php
                $item = $linha['item'];
                $referencia = $item->referencia ?? null;
                $referenciaRepetida = $referencia !== null
                    && $referencia !== ''
                    && ($contagemReferencias[$referencia] ?? 0) > 1;
                $ultimaOcorrenciaReferencia = $referenciaRepetida
                    && $ultimosIndicesReferencias[$referencia] === $indice;
            @endphp
            <tr>
                <td>{{ $item->mes }}</td>
                <td>
                    {{ number_format($linha['valor'], 2, ',', '.') }} MT
                    @if($ultimaOcorrenciaReferencia)
                        <br><strong>Total da referência: {{ number_format($somasReferencias[$referencia], 2, ',', '.') }} MT</strong>
                    @endif
                </td>
                <td>{{ !$referenciaRepetida || $ultimaOcorrenciaReferencia ? $item->Entidade : '' }}</td>
                <td>{{ !$referenciaRepetida || $ultimaOcorrenciaReferencia ? $referencia : '' }}</td>
                <td>{{ $linha['estado'] }}</td>
            </tr>
        @endforeach

    @endif
@endforeach
<tr>
    <th  colspan="4">Total
    </th>
    <th>
     {{ number_format($total,2,',','.') }} MT
    </th>
</tr>

    </tbody>
</table>

@endif
