@php
    // Verifica se está em alguma página de Finanças (base ou subpastas)
    $isFinancas = Request::is('Financas') || Request::is('Financas/*');

    // Verifica se está no Dashboard financeiro
    $isDashboard = Request::routeIs('dashboard.financeiro');

    // Verifica se está no submenu "Referências Bancárias" (qualquer rota que comece com Financas/Banco)
    $isBanco = Request::is('Financas/Banco*') || Request::routeIs('Financas.index');
    
    $isfinacas = Gate::check('Dashabord-Financas') || Gate::check('Visualizar-Referencias') || Gate::check('Criar-Referencias');
@endphp

@if($isfinacas)
<li class="nav-item has-treeview {{ $isFinancas || $isDashboard ? 'menu-open' : '' }}">
    <a href="#" class="nav-link {{ $isFinancas || $isDashboard ? 'active' : '' }}">
        <i class="nav-icon fa fa-money"></i>
        <p>
            Gestão de Finanças
            <i class="right fa fa-angle-left"></i>
        </p>
    </a>

    <ul class="nav nav-treeview">
        @if(Gate::check('Dashabord-Financas'))
        {{-- Dashboard Financeiro --}}
        <li class="nav-item">
            <a href="{{ route('dashboard.financeiro') }}"
               class="nav-link {{ $isDashboard ? 'active' : '' }}">
                <i class="fa fa-eye nav-icon"></i>
                <p>Dashboard</p>
            </a>
        </li>
        @endif

        {{-- Referências Bancárias (submenu) --}}
        @if(Gate::check('Visualizar-Referencias') || Gate::check('Criar-Referencias'))
        <li class="nav-item has-treeview {{ $isBanco ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ $isBanco ? 'active' : '' }}">
                <i class="nav-icon fa fa-bank"></i>
                <p>
                    Referências Bancárias
                    <i class="right fa fa-angle-left"></i>
                </p>
            </a>

            <ul class="nav nav-treeview">
                @if(Gate::check('Visualizar-Referencias') || Gate::check('Criar-Referencias'))
                <li class="nav-item">
                    <a href="{{ route('Financas.index') }}"
                       class="nav-link {{ Request::routeIs('Financas.index') ? 'active' : '' }}">
                        <i class="fa fa-eye nav-icon"></i>
                        <p>Visualizar</p>
                    </a>
                </li>
                @endif
            </ul>
        </li>
        @endif
    </ul>
</li>
@endif