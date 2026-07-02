<php $conf=DB::table("config")->first();
    ?>

    <body class="card" style="font-size:12px; font-family:consolas">


        <div class="row">

            <div class="col float-rigth">
                <b> <span style="float:right; font-size:17px; border:2px solid black; padding:10px; ">
                        {{ '00' . $dadosmes->mes_id . $dadosmes->aluno_classe_id }}
                    </span>
                </b>
            </div>
            <div class="col">

                <div class="container-fluid"
                    style="height: 100px;width: 173px; allign: center;  border-radius: 60px;margin-bottom: 100px;">
                    @include('Componetes.cabecalho')

                </div>
                <div class="col-md-12">

                    <p><b>Taxa de Mensalidade :</b>{{ $dadoTabelavalores->valorDescricao }},00 MT</p>

                    <?php $ano = Carbon\carbon::now()->year;
                    
                    $datalimite = $ano . '-' . $dadosmes->mes_id . '-10';
                    
                    $dtapaga = Carbon\carbon::create($dadosmes->data_pagamento);
                    
                    //$diasIni=Carbon\carbon::create($datalimite);
                    $dias = 'mais de 10';
                    
                    ?>


                    @if (Carbon\carbon::now() > Carbon\carbon::create($datalimite))
                        @if ($dadosmes->Multa > 0)
                            <p><b>Multa por Atraso de: {{ $dias }}
                                    Dias</b>{{ $dadoTabelavalores->valorDescricao * 0.33333333}},00 MT</p>
                            <p><b>Total:</b>{{ $dadoTabelavalores->valorDescricao * 0.33333333 + $dadoTabelavalores->valorDescricao }},00
                                MT</p>
                        @endif

                    @endif


                    <p style="font-size: 13px"><b>Nome: </b> <span>{{ $dadosmes->nome }}</span></p>
                    <p><b> Classe: </b> <span>{{ $dadosmes->classe }} </span></p>
                    <p><b> Mês :</b> <span>{{ $dadosmes->mes }} </span></p>


                    <center>

                        <?php
                        $data = '';
                        if (empty($dadosmes->data_pagamento)):
                            $dia = Carbon\carbon::now()->format('d');
                            $mes = Carbon\carbon::now()->monthName;
                            $ano = Carbon\carbon::now()->format('y');
                            $data = 'Aos  ' . $dia . ' de ' . $mes . ' de 20' . $ano;
                        else:
                            $dia = Carbon\carbon::create($dadosmes->data_pagamento)->format('d');
                            $mes = Carbon\carbon::create($dadosmes->data_pagamento)->monthName;
                            $ano = Carbon\carbon::create($dadosmes->data_pagamento)->format('Y');
                            $data = 'Aos  ' . $dia . ' de ' . $mes . ' de ' . $ano;
                        endif;
                        ?>
                        <p>{{ $data }}</p>

                        Assinatura do Funcionário<br>
                        _______________________
                        <br>
                        ({{ Auth()->user()->name }})
                        <Center>
                </div>
            </div>


    </body>

    <hr>





    <body class="card" style="font-size:12px;">


        <div class="row">

            <div class="col float-rigth">
                <b> <span style="float:right; font-size:17px; border:2px solid black; padding:10px; ">
                        {{ '00' . $dadosmes->mes_id . $dadosmes->aluno_classe_id }}
                    </span>
                </b>
            </div>
            <div class="col">
                @include('Componetes.cabecalho')
            </div>
        </div>

        <div class=" ">
            <div class="col-md-12 ">



                <p><b>Taxa de Mensalidade :</b>{{ $dadoTabelavalores->valorDescricao }},00 MT</p>

                <?php $ano = Carbon\carbon::now()->year;
                
                $datalimite = $ano . '-' . $dadosmes->mes_id . '-10';
                
                ?>


                @if (Carbon\carbon::now() > Carbon\carbon::create($datalimite))
                    @if ($dadosmes->Multa > 0)
                        <p><b>Multa por Atraso de: {{ $dias }}
                                Dias</b>{{ $dadoTabelavalores->valorDescricao * 0.1 }},00 MT</p>
                        <p><b>Total:</b>{{ $dadoTabelavalores->valorDescricao * 0.1 + $dadoTabelavalores->valorDescricao }},00
                            MT</p>
                    @endif

                @endif


                <p style="font-size: 13px"><b>Nome: </b> <span>{{ $dadosmes->nome }}</span></p>
                <p><b> Classe: </b> <span>{{ $dadosmes->classe }} </span></p>
                <p><b> Mês :</b> <span>{{ $dadosmes->mes }} </span></p>


                <center>

                    <?php
                    $data = '';
                    if (empty($dadosmes->data_pagamento)):
                        $dia = Carbon\carbon::now()->format('d');
                        $mes = Carbon\carbon::now()->monthName;
                        $ano = Carbon\carbon::now()->format('y');
                        $data = 'Aos  ' . $dia . ' de ' . $mes . ' de 20' . $ano;
                    else:
                        $dia = Carbon\carbon::create($dadosmes->data_pagamento)->format('d');
                        $mes = Carbon\carbon::create($dadosmes->data_pagamento)->monthName;
                        $ano = Carbon\carbon::create($dadosmes->data_pagamento)->format('Y');
                        $data = 'Aos  ' . $dia . ' de ' . $mes . ' de ' . $ano;
                    endif;
                    ?>
                    <p>{{ $data }}</p>

                    Assinatura do Funcionário<br>
                    _______________________
                    <br>
                    ({{ Auth()->user()->name }})
                    <Center>
            </div>
        </div>


    </body>
