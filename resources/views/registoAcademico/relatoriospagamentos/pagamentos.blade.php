<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">


    <table class="table ">

        <tbody>
            <thead>
                <th>Data </th>
                <th>Classe </th>
                <th>Modal.pagamento</th>
                <th>Nr.Alunos</th>
                <th>Nr.{{ session()->get('pagamentos') }}es</th>
                <th>Mensalidades</th>
                <th style="background-color:RGBA(0,0,0,0.20)">Subtotal</th>
                <th>Multas</th>
                <th>Multas a pagar</th>
                <th style="background-color:RGBA(0,0,0,0.20)">Subtotal</th>
                <th>Total</th>

                </tr>
                <?php $xcontrol = 0;
                
                $xx = 0;
                
                $qtdademetodos = count($metodosPagamentos);
                $subtotoaltotalMensalidade = 0;
                $subtotoaltotalMulta = 0;
                ?>
            </thead>
            @foreach ($collet as $key1 => $collectIntem)
                <?php
                $xcontrol++;
                
                ?>

                @foreach ($collectIntem as $key => $value)
                    <?php $xx++;
                    
                    ?>
                    <tr>
					
					
                    <td @if ($xx < $qtdademetodos * $classessizeS + 1) style="border-bottom: none; border-top: none" @endif
                        @if ($xx == $qtdademetodos * $classessizeS) )style="border-bottom: 1px solid black;" @endif
                        @if ($xx == $qtdademetodos * $classessizeS) )style="border-top: none;" @endif>
                        @if ($classessizeS == 1)
                            @if ($xx == 2)
                                {{ $value->data_pagamento }}
                            @endif
                        @elseif($xx == ($qtdademetodos * $classessizeS) / 2)
                            {{ $value->data_pagamento }}
                        @endif
                    </td>
                    <td @if ($key > 0) style="border-bottom: none; border-top: none" @endif
                        @if ($key == 0) style="border-bottom: none;" @endif>
                        @if ($key == 2)
                            {{ $value->classes }}
                        @endif
                    </td>
                    <td>{{ $value->tipopagamento }}</td>
                    <td @if ($key > 0) style="border-bottom: none; border-top: none" @endif
                        @if ($key == 0) style="border-bottom: none;" @endif>
                        @if ($key == 2)
                            {{ $value->NUmerAlunos }}
                        @endif
                    </td>
                    <td>{{ $value->NUmerMeses }}</td>

                    <td @if ($key > 0) style="border-bottom: none; border-top: none" @endif
                        @if ($key == 0) style="border-bottom: none;" @endif>
                        @if ($key == 2)
                            {{ $value->Mensaldade }}
                        @endif
                    </td>
                    <td style="background-color:RGBA(0,0,0,0.20)">{{ $value->subtotalmensalidade }}</td>
                    <td>{{ $value->NUmerMulta }}</td>
                    <td @if ($key > 0) style="border-bottom: none; border-top: none" @endif
                        @if ($key == 0) style="border-bottom: none;" @endif>
                        @if ($key == 2)
                            {{ $value->Multavalor }}
                        @endif
                    </td>
                    <td style="background-color:RGBA(0,0,0,0.20)">{{ $value->SubtotalMultas }}</td>
                    <td>{{ $value->SubtotalMultas + $value->subtotalmensalidade }}</td>

                    <?php $subtotoaltotalMensalidade = $subtotoaltotalMensalidade + $value->subtotalmensalidade; ?>
                    <?php $subtotoaltotalMulta = $subtotoaltotalMulta + $value->SubtotalMultas; ?>
                    </tr>


                    @if ($xx == ($qtdademetodos * $classessizeS))
                        <tr style="background-color:RGBA(0,0,0,0.50)">
                            <td colspan="6">TOTAL</td>

                            <td colspan="3">{{ $subtotoaltotalMensalidade }} </td>


                            <td>{{ $subtotoaltotalMulta }}</td>
                            <td>{{ $subtotoaltotalMulta + $subtotoaltotalMensalidade }}</td>
                        </tr>
                    @endif

                    <?php if ($xx == $qtdademetodos * $classessizeS) {
                        $xx = 0;
                        $subtotoaltotalMensalidade = 0;
                        $subtotoaltotalMulta = 0;
                    } ?>
                @endforeach
            @endforeach
        </tbody>
    </table>
</head>

<body>

</body>

</html>

<style>
    table {
        border: 1px solid black;
    }

    td,
    th {
        border: 1px solid black;
    }

    .tableP {
        border-collapse: collapse;
        margin: auto;
    }

    .tablef {
        border-collapse: collapse;
        margin: -1px;

    }

    .tdf {
        border-botton: 1px solid black;
    }
</style>
