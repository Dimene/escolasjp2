<?php
$conf = DB::table('config')->first();
?>

<body class="col" style="font-size:14px; font-family:consolas">
    <div class="col" style="font-size:14px; font-family:consolas">
        @include('Componetes.cabecalho')
    </div>









    <ul style="list-style:none; font-size:12px">


        <li><span class=""><b>Nome do Aluno:</b> </span><span class="profile-right">{{ $aluno->nome }}</span> </li>
        <li><span class=""><b>Sexo:</b> </span><span class="profile-right">{{ $aluno->sexo }}</span> </li>


        <li><span class="font-400"><b>Tipo:</b> </span><span class="profile-right">
                @if ($aluno->Tipo == 'B')
                    {{ 'Bolseiro' }}
                @else
                    {{ 'Normal' }}
                @endif
            </span> </li>

        <li><span class="font-400"><b>Ano Lectivo :</b> </span><span class="">
                {{ $aluno->anolectivo }}</span> </li>
        <li><span class="font-400"><b>Classe que frequentada :</b> </span><span class="profile-right">
                {{ $aluno->classe }}</span> </li>




    </ul>









    <!-- /.row -->
    <!-- /.container-fluid -->




    <center><b>Situação das {{ session()->get('formadepagamentos') }} </b></center>




    <table class="table table-light  table-striped" width="100%" style="font-size:12px;">
        <thead>
            <tr>

                <th>{{ session()->get('formadepagamentos') }}</th>
                <th>Estado</th>
                <th> Multa </th>
                <th>Taxa mensal </th>
                <th>Total</th>


            </tr>
        </thead>
        <tbody>
            <?php
            $AnualMulta = 0;
            $Anual = 0;
            ?>
            @foreach ($Valores_pago as $key => $Valores_pagoItem)
                <?php
                $valormensal = 0;
                $valorMulta = 0;
                if ($Valores_pagoItem->Estado == 'Pago'):
                    $valormensal = $Valores_pagoItem->valorDescricao;
                    $valorMulta = $Valores_pagoItem->Multa;

                    $AnualMulta = $valorMulta + $AnualMulta;
                    $Anual = $valormensal + $Anual;
                endif;

                ?>
                <tr @if ($key % 2 == 0) style="background-color:#F0F0F1" @endif>

                    <td id="nome_mes">{{ $Valores_pagoItem->mes }}<sup>o</sup></td>
                    <td>{{ $Valores_pagoItem->Estado }}</td>

                    <td>{{ $valorMulta }},00MT</td>
                    <td>{{ $valormensal }},00MT</td>
                    <td>{{ $valormensal + $valorMulta }},00MT</td>

                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <th> TOtal </th>
            <th> </th>
            <th> {{ $AnualMulta }},00MT</th>
            <th> {{ $Anual }},00MT</th>
            <th>{{ $AnualMulta + $Anual }},00MT </th>
        </tfoot>

    </table>


    <?php $ano = Carbon\carbon::now()->year;

    $datalimite = Carbon\carbon::now()->day . ' de ' . Carbon\carbon::now()->monthName . '  de ' . Carbon\carbon::now()->year;

    // dd($atraso);

    ?>

    <center>

        <p>{{ $datalimite }}</p>
        Assinatura do Funcionário<br>
        _______________________
        <br>
        ({{ Auth()->user()->name }})

    </center>


    </div>
    </div>
</body>
