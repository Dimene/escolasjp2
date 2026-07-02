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

        @foreach($grupo['meses'] as $item)
            @php



$dadoscaregado=DB::table('outros_pagamentosview')
->where("aluno_classe_id",$item->id??null)
->where("mes_id",$item->mes_id??null)
->where("tipoPagamento_id",$item->tipo_pagamento_id??null)
->first();

//  dd($dadoscaregado,$item);

                $valor = $item->valorDescricao;
                $estado = $item->Estado ?? 'Data limite: '.$item->limite;

               $estadoValor = $dadoscaregado->Estado ?? '';

if ($estadoValor == "Pago" || $estadoValor == "activo") {
    $estado = "pago";
}
                else{


                if($item->multaflag){
                    $valor += ($item->multa / 100) * $valor;
                    $estado = $dadoscaregado->estado ?? 'Vencido';
                }}

                  $total=$total+$valor;

            @endphp
            <tr>
                <td>{{ $item->mes }}</td>
                <td>{{ number_format($valor,2,',','.') }} MT</td>
                <td>{{ $item->Entidade }}</td>
                <td>{{ $item->referencia }}</td>
                <td>{{ $estado }}</td>
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
