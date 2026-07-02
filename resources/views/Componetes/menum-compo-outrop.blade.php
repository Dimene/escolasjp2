

@php
    $tipospagamentos= DB::table('outros_pagamentosview')

        ->where('tipo_janela', 2)
        ->select('outros_pagamentosview.tipo_pagamento_id', 'outros_pagamentosview.tipoPagamento', 'outros_pagamentosview.icon')
        ->distinct()
        ->get();


@endphp



@if(!empty($tipospagamentos->first()))

    @if (Gate::check('relatoriopagamentos-outrospagamentos') ||
                                Gate::check('efetuar-outrospagamentos') ||
                                Gate::check('configuar-outrospagamentos') ||
                                Gate::check('RelatorioGenerico-outrospagamentos'))
                            <li class="nav-item has-treeview  @if (
                                $_SERVER['REQUEST_URI'] == '/RegistoAcademico/outrosPagamento/index' ||
                                    $_SERVER['REQUEST_URI'] ==
                                        '/RegistoAcademico/outrosPagamento/Relatorio/detalhado/' .
                                            (int) $dadourl[5] .
                                            '/' .
                                            (int) $dadourl[6] .
                                            '/' .
                                            (int) $dadourl[7] .
                                            '/' .
                                            (int) $dadourl[8] .
                                            '/' .
                                            (int) $dadourl[9] .
                                            '' ||
                                    $_SERVER['REQUEST_URI'] == '/RegistoAcademico/outrosPagamento/Relatorio' ||
                                    $_SERVER['REQUEST_URI'] == '/RegistoAcademico/outrosPagamento/pagamentos' ||
                                    $_SERVER['REQUEST_URI'] == '/RegistoAcademico/outrosPagamento/Relatorio/pagamentos' ||
                                    $_SERVER['REQUEST_URI'] == '/RegistoAcademico/outrosPagamento/mostrar') menu-open @endif">
                                <a href="#" class="nav-link @if (
                                    $_SERVER['REQUEST_URI'] ==
                                        '/RegistoAcademico/outrosPagamento/Relatorio/detalhado/' .
                                            (int) $dadourl[5] .
                                            '/' .
                                            (int) $dadourl[6] .
                                            '/' .
                                            (int) $dadourl[7] .
                                            '/' .
                                            (int) $dadourl[8] .
                                            '/' .
                                            (int) $dadourl[9] .
                                            '' ||
                                        $_SERVER['REQUEST_URI'] == '/RegistoAcademico/outrosPagamento/index' ||
                                        $_SERVER['REQUEST_URI'] == '/RegistoAcademico/outrosPagamento/Relatorio' ||
                                        $_SERVER['REQUEST_URI'] == '/RegistoAcademico/outrosPagamento/pagamentos' ||
                                        $_SERVER['REQUEST_URI'] == '/RegistoAcademico/outrosPagamento/Relatorio/pagamentos' ||
                                        $_SERVER['REQUEST_URI'] == '/RegistoAcademico/outrosPagamento/mostrar') active @endif">
                                    <i class="fa fa-users fa fa-tachometer-alt"></i>
                                    <p>
                                        Outros pagamnetos
                                        <i class="right fa fa-angle-left"></i>
                                    </p>




                                </a>

                                <ul class="nav nav-treeview">

                                    @can('efetuar-outrospagamentos')
                                        {{--  //mensalidadesselecionar  --}}
                                        <li class="nav-item">
                                            <a class="nav-link @if ($_SERVER['REQUEST_URI'] == '/RegistoAcademico/outrosPagamento/mostrar') active @endif"
                                                href="{{ Route('outrosPagamento.show') }}" class="nav-link">
                                                <i class="fa fa-money nav-icon"></i>
                                                <p>Pagamento </p>
                                            </a>
                                        </li>
                                    @endcan

                                    @can('RelatorioGenerico-outrospagamentos')

                                <li class="nav-item">
                                    <a href="{{ Route('outrosPagamento.Relatorio') }}"
                                        class="nav-link  @if (
                                            $_SERVER['REQUEST_URI'] ==
                                                '/RegistoAcademico/outrosPagamento/Relatorio/detalhado/' .
                                                    (int) $dadourl[5] .
                                                    '/' .
                                                    (int) $dadourl[6] .
                                                    '/' .
                                                    (int) $dadourl[7] .
                                                    '/' .
                                                    (int) $dadourl[8] .
                                                    '/' .
                                                    (int) $dadourl[9] .
                                                    '' || $_SERVER['REQUEST_URI'] == '/RegistoAcademico/outrosPagamento/Relatorio') active @endif">
                                        <i class="fa fa-money nav-icon"></i>
                                        <p>Relatorio Generico </p>
                                    </a>
                                </li>
                            @endcan
                            @can('Relatoriopagamentos-outrospagamentos')

                    <li class="nav-item">
                        <a href="{{ Route('outrosPagamento.pagamentosIndex') }}"
                            class="nav-link  @if ($_SERVER['REQUEST_URI'] == '/RegistoAcademico/outrosPagamento/Relatorio/pagamentos') active @endif">
                            <i class="fa fa-money nav-icon"></i>
                            <p>Relatorio de Pagamento</p>
                        </a>
                    </li>
                @endcan



        </ul>
        </li>
        @endif
        @endif








