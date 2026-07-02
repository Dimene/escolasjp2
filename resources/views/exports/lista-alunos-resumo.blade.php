{{-- resources/views/exports/lista-alunos-resumo.blade.php --}}
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Lista de Alunos</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th {
            background-color: #1E3A8A;
            color: white;
            font-weight: bold;
            padding: 8px;
            text-align: left;
        }
        td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h2>Lista de Alunos Matriculados</h2>
    <p>Data de emissão: {{ date('d/m/Y H:i') }}</p>
    
    <table>
        <thead>
            <tr>
                <th>Nº</th>
                <th>Nome do Aluno</th>
                <th>Classe</th>
                <th>Ano Lectivo</th>
                <th>Data Nascimento</th>
                <th>Sexo</th>
                <th>Encarregado</th>
            </tr>
        </thead>
        <tbody>
            @foreach($alunos as $index => $aluno)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $aluno->nome_aluno }}</td>
                <td>{{ $aluno->classe->Descricao ?? 'N/A' }}</td>
                <td>{{ $aluno->anoLectivo->anolectivo ?? 'N/A' }}</td>
                <td>{{ $aluno->data_nascimento ? $aluno->data_nascimento->format('d/m/Y') : 'N/A' }}</td>
                <td>{{ $aluno->sexo_aluno == 'M' ? 'Masculino' : 'Feminino' }}</td>
                <td>{{ $aluno->nome_encarregado ?? 'N/A' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <p>Total de alunos: {{ count($alunos) }}</p>
</body>
</html>