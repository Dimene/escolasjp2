{{-- resources/views/exports/aluno-cadastro-excel.blade.php --}}
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Ficha de Cadastro de Aluno</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            font-size: 11px;
        }
        .header {
            font-size: 18px;
            font-weight: bold;
            color: #1E3A8A;
            text-align: center;
            margin-bottom: 20px;
        }
        .section-title {
            background-color: #2C3E50;
            color: white;
            font-weight: bold;
            padding: 5px;
            margin-top: 15px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        td {
            padding: 5px;
            border: 1px solid #ddd;
        }
        .label {
            font-weight: bold;
            background-color: #f8f9fa;
        }
    </style>
</head>
<body>
    <table>
        <tr>
            <td colspan="8" style="text-align: center; font-size: 18px; font-weight: bold; color: #1E3A8A;">
                FICHA DE CADASTRO DE ALUNO
            </td>
        </tr>
        <tr>
            <td colspan="3"><strong>ESCOLA:</strong> {{ $dadosAluno['escola_nome'] ?? '__________________________________' }}</td>
            <td colspan="3"><strong>ANO LECTIVO:</strong> {{ $dadosAluno['ano_lectivo_nome'] ?? date('Y') }}</td>
            <td colspan="2"><strong>DATA:</strong> {{ date('d/m/Y H:i') }}</td>
        </tr>
        
        {{-- DADOS DO ALUNO --}}
        <tr style="background-color: #2C3E50; color: white;">
            <td colspan="8"><strong>1. DADOS DO ALUNO</strong></td>
        </tr>
        <tr>
            <td><strong>Ano Lectivo:</strong></td>
            <td colspan="2">{{ $dadosAluno['ano_lectivo_nome'] ?? '_________________' }}</td>
            <td><strong>Classe:</strong></td>
            <td colspan="4">{{ $dadosAluno['classe_nome'] ?? '_________________' }}</td>
        </tr>
        <tr>
            <td><strong>Nome do Aluno:</strong></td>
            <td colspan="7">{{ $dadosAluno['nome_aluno'] ?? '________________________________________' }}</td>
        </tr>
        <tr>
            <td><strong>Data Nascimento:</strong></td>
            <td>{{ $dadosAluno['data_nascimento'] ?? '__/__/____' }}</td>
            <td><strong>Sexo:</strong></td>
            <td>{{ isset($dadosAluno['sexo_aluno']) ? ($dadosAluno['sexo_aluno'] == 'M' ? 'Masculino' : 'Feminino') : '_________' }}</td>
            <td><strong>Religião:</strong></td>
            <td colspan="3">{{ $dadosAluno['religiao_nome'] ?? '_________' }}</td>
        </tr>
        
        {{-- ENDEREÇO --}}
        <tr style="background-color: #27AE60; color: white;">
            <td colspan="8"><strong>2. ENDEREÇO</strong></td>
        </tr>
        <tr>
            <td><strong>Bairro:</strong></td>
            <td colspan="3">{{ $dadosAluno['bairro'] ?? '______________________' }}</td>
            <td><strong>Rua/Avenida:</strong></td>
            <td colspan="3">{{ $dadosAluno['rua_avenida'] ?? '______________________' }}</td>
        </tr>
        <tr>
            <td><strong>Quarteirão:</strong></td>
            <td>{{ $dadosAluno['quarteirao'] ?? '_________' }}</td>
            <td><strong>Casa Nº:</strong></td>
            <td colspan="5">{{ $dadosAluno['casa_numero'] ?? '_________' }}</td>
        </tr>
        
        {{-- NATURALIDADE --}}
        <tr style="background-color: #E67E22; color: white;">
            <td colspan="8"><strong>3. NATURALIDADE</strong></td>
        </tr>
        <tr>
            <td><strong>Natural de:</strong></td>
            <td colspan="3">{{ $dadosAluno['naturalidade'] ?? '__________________' }}</td>
            <td><strong>Província:</strong></td>
            <td colspan="3">{{ $dadosAluno['provincia'] ?? '__________________' }}</td>
        </tr>
        <tr>
            <td><strong>País:</strong></td>
            <td colspan="7">{{ $dadosAluno['pais'] ?? 'Moçambique' }}</td>
        </tr>
        
        {{-- SAÚDE --}}
        <tr style="background-color: #C0392B; color: white;">
            <td colspan="8"><strong>4. SAÚDE</strong></td>
        </tr>
        <tr>
            <td><strong>Estado de Saúde:</strong></td>
            <td colspan="7">{{ isset($dadosAluno['estado_saude']) ? ($dadosAluno['estado_saude'] == 'sim' ? 'Com Doença' : 'Sem Doença') : '_________' }}</td>
        </tr>
        @if(isset($dadosAluno['doencas']) && is_array($dadosAluno['doencas']) && count(array_filter($dadosAluno['doencas'])) > 0)
        <tr>
            <td><strong>Doenças:</strong></td>
            <td colspan="7">{{ implode(', ', array_filter($dadosAluno['doencas'])) }}</td>
        </tr>
        @endif
        
        {{-- FILIAÇÃO --}}
        <tr style="background-color: #8E44AD; color: white;">
            <td colspan="8"><strong>5. FILIAÇÃO</strong></td>
        </tr>
        <tr>
            <td><strong>Pai:</strong></td>
            <td colspan="4">{{ $dadosAluno['nome_pai'] ?? '__________________________________' }}</td>
            <td><strong>Profissão:</strong></td>
            <td colspan="2">{{ $dadosAluno['profissao_pai'] ?? '__________________' }}</td>
        </tr>
        <tr>
            <td><strong>Mãe:</strong></td>
            <td colspan="4">{{ $dadosAluno['nome_mae'] ?? '__________________________________' }}</td>
            <td><strong>Profissão:</strong></td>
            <td colspan="2">{{ $dadosAluno['profissao_mae'] ?? '__________________' }}</td>
        </tr>
        
        {{-- ENCARREGADO --}}
        <tr style="background-color: #16A085; color: white;">
            <td colspan="8"><strong>6. ENCARREGADO DE EDUCAÇÃO</strong></td>
        </tr>
        <tr>
            <td><strong>Nome:</strong></td>
            <td colspan="7">{{ $dadosAluno['nome_encarregado'] ?? '________________________________________' }}</td>
        </tr>
        <tr>
            <td><strong>Sexo:</strong></td>
            <td>{{ isset($dadosAluno['sexo_encarregado']) ? ($dadosAluno['sexo_encarregado'] == 'M' ? 'Masculino' : 'Feminino') : '_________' }}</td>
            <td><strong>Parentesco:</strong></td>
            <td>{{ $dadosAluno['grau_parentesco_nome'] ?? '_________' }}</td>
            <td><strong>Profissão:</strong></td>
            <td colspan="3">{{ $dadosAluno['profissao_encarregado'] ?? '_________' }}</td>
        </tr>
        <tr>
            <td><strong>Contactos:</strong></td>
            <td colspan="7">
                @php
                    $contactos = isset($dadosAluno['contacto']) ? 
                        (is_array($dadosAluno['contacto']) ? implode(' | ', array_filter($dadosAluno['contacto'])) : $dadosAluno['contacto']) 
                        : '_________________  |  _________________  |  _________________';
                @endphp
                {{ $contactos }}
            </td>
        </tr>
        
        {{-- PAGAMENTOS --}}
        <tr style="background-color: #D35400; color: white;">
            <td colspan="8"><strong>7. PAGAMENTOS</strong></td>
        </tr>
        <tr style="background-color: #3498DB; color: white;">
            <td colspan="2"><strong>Tipo de Pagamento</strong></td>
            <td><strong>Valor</strong></td>
            <td><strong>Parcelas</strong></td>
            <td colspan="4"><strong>Status</strong></td>
        </tr>
        @if(isset($dadosAluno['pagamentos']) && count($dadosAluno['pagamentos']) > 0)
            @foreach($dadosAluno['pagamentos'] as $pagamento)
            <tr>
                <td colspan="2">{{ $pagamento['finalidade'] ?? 'Mensalidade' }}</td>
                <td>{{ number_format($pagamento['valor'] ?? 0, 2, ',', '.') }} MT</td>
                <td>{{ $pagamento['parcelas'] ?? '1' }}</td>
                <td colspan="4">{{ $pagamento['status'] ?? 'Pendente' }}</td>
            </tr>
            @endforeach
        @else
            <tr>
                <td colspan="8">Nenhum pagamento configurado</td>
            </tr>
        @endif
        
        {{-- ASSINATURAS --}}
        <tr>
            <td colspan="8" style="border: none;">&nbsp;</td>
        </tr>
        <tr>
            <td>__________________________</td>
            <td>__________________________</td>
            <td colspan="4">__________________________</td>
        </tr>
        <tr>
            <td>Assinatura do Aluno</td>
            <td>Assinatura do Encarregado</td>
            <td colspan="4">Assinatura da Escola</td>
        </tr>
        <tr>
            <td colspan="8" style="font-style: italic;">Documento gerado em: {{ date('d/m/Y H:i:s') }}</td>
        </tr>
    </table>
</body>
</html>