</table>
<table style="" class="tableP ">
    <tr>
        <th>DATA</th>
        <th>
            <table class="tablef">
                <tr>
                    <th style="width:100px">Classe </th>
                    <th style="width:135px">Modal.pagamento</th>
                    <th style="width:70px">Nr.Alunos</th>
                    <th style="width:71px">Nr.Meses</th>
                    <th style="width:103px">Mensalidades</th>
                    <th style="width:100px;background-color:RGBA(0,0,0,0.20)">Subtotal</th>
                    <th style="width:100px">Multas</th>
                    <th style="width:100px ">Multas a pagar</th>
                    <th style="width:100px;background-color:RGBA(0,0,0,0.20)">Subtotal</th>
                    <th style="width:140px">Total</th>

                </tr>
            </table>

        </th>

    </tr>


    @foreach ($dados_pagamento as $dados_pagamentoItem)
        <?php $elementoPercoridoCntafor = 0;
        
        $ubtoalMensalidades = 0;
        $subtotaldeMultas = 0;
        $saize = 0;
        
        ?>
        <tr>
            <td>{{ Carbon\carbon::create('' . $dados_pagamentoItem['Data'] . '')->format('d/M/Y') }}</td>

            <td>

                <table class="tablef ">
                    @foreach ($dados_pagamentoItem['Classes'] as $classeItem)
                        <tr>


                            <td class="tdf" style="width:100px"> {{ $classeItem['classe'] }}</td>
                            <td style="width:135px">
                                <table class="tablef" style="">


                                    <tr>
                                        <td style="width:135px">M-Pesa</td>
                                    </tr>
                                    <tr>
                                        <td style="width:135px">Banco</td>
                                    </tr>
                                    <tr>
                                        <td style="width:135px">Outros</td>
                                    </tr>



                                </table>

                            </td>
                            <td class="tdf" style="width:70px"> {{ $classeItem['classeTamanho'] }}</td>
                            <td>
                                <table class="tablef">
                                    <tr>
                                        <td style="width:70px"style="border: 1px solid black;">
                                            {{ $classeItem['alunosTotalMpesa'] }}</td>
                                    </tr>
                                    <tr>
                                        <td style="width:70px"style=" border: 1px solid black;">
                                            {{ $classeItem['alunosTotalBanco'] }}</td>
                                    </tr>
                                    <tr>
                                        <td style="width:70px"style=" border: 1px solid black;">
                                            {{ $classeItem['outros'] }}</td>
                                    </tr>

                                </table>
                            </td>


                            <td>
                                <table class="tablef">
                                    <tr>
                                        <td style="width:100px"style="border: 1px solid black;">
                                            {{ $classeItem['valorDescricaosMpesa'] }}<span>,00MT</span></td>
                                    </tr>
                                    <tr>
                                        <td style="width:100px"style="border: 1px solid black;">
                                            {{ $classeItem['valorDescricaosBanco'] }}<span>,00MT</span></td>
                                    </tr>
                                    <tr>
                                        <td style="width:100px"style="border: 1px solid black;">
                                            {{ $classeItem['valorDescricaosOutro'] }}<span>,00MT</span></td>
                                    </tr>
                                </table>
                            </td>

                            <td style="width:100px"style="border: 1px solid black;">

                                <table class="tablef" style="background-color:RGBA(0,0,0,0.20)">
                                    <tr>
                                        <td style="width:100px"style="border: 1px solid black;">
                                            {{ $classeItem['valorDescricaosMpesa'] * $classeItem['alunosTotalMpesa'] }}<span>,00MT</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width:100px"style="border: 1px solid black;">
                                            {{ $classeItem['valorDescricaosBanco'] * $classeItem['alunosTotalBanco'] }}<span>,00MT</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width:100px"style="border: 1px solid black;">
                                            {{ $classeItem['valorDescricaosOutro'] * $classeItem['outros'] }}<span>,00MT</span>
                                        </td>
                                    </tr>
                                </table>
                                <?php $ubtoalMensalidades = $ubtoalMensalidades + ($classeItem['valorDescricaosMpesa'] * $classeItem['alunosTotalMpesa'] + $classeItem['valorDescricaosBanco'] * $classeItem['alunosTotalBanco'] + $classeItem['valorDescricaosOutro'] * $classeItem['outros']); ?>
                            </td>
                            <td>
                                <table class="tablef">
                                    <tr>
                                        <td style="width:100px"style="border: 1px solid black;">
                                            {{ $classeItem['MultaMpesa'] }}</td>
                                    </tr>
                                    <tr>
                                        <td style="width:100px"style="border: 1px solid black;">
                                            {{ $classeItem['MultaBanco'] }}</td>
                                    </tr>
                                    <tr>
                                        <td style="width:100px"style="border: 1px solid black;">
                                            {{ $classeItem['MultaOutro'] }}</td>
                                    </tr>
                                </table>
                            </td>

                            <td>
                                <table class="tablef">
                                    <tr>
                                        <td style="width:100px"style="border: 1px solid black;">
                                            {{ $classeItem['valorMultaMpesa'] }}<span>,00MT</span></td>
                                    </tr>
                                    <tr>
                                        <td style="width:100px"style="border: 1px solid black;">
                                            {{ $classeItem['valorMultaBanco'] }}<span>,00MT</span></td>
                                    </tr>
                                    <tr>
                                        <td style="width:100px"style="border: 1px solid black;">
                                            {{ $classeItem['valorMultaOutro'] }}<span>,00MT</span></td>
                                    </tr>
                                </table>
                            </td>

                            <td>
                                <table class="tablef" style="background-color:RGBA(0,0,0,0.20)">
                                    <tr>
                                        <td style="width:100px"style="border: 1px solid black;">
                                            {{ $classeItem['valorMultaMpesa'] * $classeItem['MultaMpesa'] }}<span>,00MT</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width:100px"style="border: 1px solid black;">
                                            {{ $classeItem['valorMultaBanco'] * $classeItem['MultaBanco'] }}<span>,00MT</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width:100px"style="border: 1px solid black;">
                                            {{ $classeItem['valorMultaOutro'] * $classeItem['MultaOutro'] }}<span>,00MT</span>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <td>
                                <?php $subtotaldeMultas = $subtotaldeMultas + $classeItem['valorMultaMpesa'] * $classeItem['MultaMpesa'] + $classeItem['valorMultaBanco'] * $classeItem['MultaBanco'] + $classeItem['valorMultaOutro'] * $classeItem['MultaOutro']; ?>

                                <table class="tablef">
                                    <tr>
                                        <td style="width:130px"style="border: 1px solid black;">
                                            {{ $classeItem['valorMultaMpesa'] * $classeItem['MultaMpesa'] + $classeItem['valorDescricaosMpesa'] * $classeItem['alunosTotalMpesa'] }}<span>,00MT</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width:130px"style="border: 1px solid black;">
                                            {{ $classeItem['valorMultaBanco'] * $classeItem['MultaBanco'] + $classeItem['valorDescricaosBanco'] * $classeItem['alunosTotalBanco'] }}<span>,00MT</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width:130px"style="border: 1px solid black;">
                                            {{ $classeItem['valorMultaOutro'] * $classeItem['MultaOutro'] + $classeItem['valorDescricaosOutro'] * $classeItem['outros'] }}<span>,00MT</span>
                                        </td>
                                    </tr>
                                </table>

                                <?php ?>
                            </td>



                        </tr>
                    @endforeach
                </table>


            </td>

        <tr>
            <td>TOTAL Diario </td>
            <td>

                <table>
                    <td style="width:592px;">{{ $ubtoalMensalidades }}</td>
                    <td style="width:307px;">{{ $subtotaldeMultas }}</td>
                    <td style="width:129px;">{{ $ubtoalMensalidades + $subtotaldeMultas }}</td>
                </table>
            </td>


        </tr>
    @endforeach
</table>

<style>
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
