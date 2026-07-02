<!DOCTYPE html>
<html>

<head>
    <title>Relatório Excel com Imagem</title>
</head>

<body>

    <table>
        <thead>
            <tr style="background-color: rgba(79, 201, 140, 0.603); border-block-color: rgba(0,0,0,0.128)">
                <th rowspan="2">Nr</th>
                <th rowspan="2">Nome</th>
                <th rowspan="2">Sexo</th>
                @foreach ((object) $Saida['Disciplina'] as $classe_disciplinasItem)
                    <th colspan="{{ count($Saida['trimestres']) + 1 }}">
                        {{ $classe_disciplinasItem['Descricao'] }}</th>
                @endforeach
                <th rowspan="2">MA</th>
                <th rowspan="2">Resultado</th>
            </tr>
            <tr style="background-color: rgba(79, 201, 140, 0.603); border-block-color: rgba(0,0,0,0.128)">
                @foreach ($Saida['Disciplina'] as $keyC => $classe_disciplinasItem)
                    @foreach ($Saida['trimestres'] as $divisoesItem)
                        <th>{{ $divisoesItem['divisao'] }}NF</th>
                    @endforeach
                    <th>MF</th>
                @endforeach
            </tr>
        </thead>
        <tbody>

            @foreach ($Saida['dados'] as $key => $dadoItem)
                <tr>
                    @foreach ($dadoItem as $key2 => $item)
                        <?php $i = 0; ?>
                        <td @if ($key2 > 2) @if ($key % (count($Saida['trimestres']) + 1) == 0) 
                           style="background-color:rgba(0,0,0,0.128)"
                            
                            @else 
                            <?php $i++; ?> @endif
                            @endif>
                            {{ $item }}</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
