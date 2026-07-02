<!-- Ícone da página -->
<link rel="icon" type="image/png" href="{{ asset('storage/logoMarca/' . $avatar) }}" style="border-radius: 50%">

<!-- Navbar topo -->
<nav style="position: fixed;" class="main-header navbar navbar-expand {{ session()->get('dadoslayout')->nav_header }} navbar-light border-bottom col-md-10 col-sm-12 col-lg-10">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="/" class="nav-link"><i class="fa fa-home"></i> Home</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="#" class="nav-link"><i class="fa fa-info-circle"></i> Sobre nós</a>
        </li>
    </ul>

    <ul class="navbar-nav ml-auto">
        @guest
            <li class="nav-item">
                <a class="nav-link" href="{{ route('login') }}"><i class="fa fa-sign-in"></i> Login</a>
            </li>
        @else
            <span class="nav-link"><i class="fa fa-user-circle"></i> {{ auth()->user()->name }}</span>
            <a class="nav-link text-danger" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fa fa-power-off"></i> Sair
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
        @endguest

        @if (Auth::user())
            <li class="nav-item">
                <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#"><i class="fa fa-th-large"></i></a>
            </li>
        @endif
    </ul>
</nav>

<!-- Menu lateral -->
<nav class="mt-2" style="background-color: #e9ecef">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

        <!-- Histórico -->
        <li class="nav-item">
            <a href="/" class="nav-link {{ request()->is('/') || request()->is('home') ? 'active' : '' }}">
                <i class="nav-icon fa fa-history"></i>
                <p>Histórico</p>
            </a>
        </li>

        <!-- Gestão de Compras -->
        @can("Visualizar-Menu-Stoque")
        <li class="nav-item has-treeview {{ request()->is('Stoque/produto*') || request()->is('Stoque/compra*') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ request()->is('Stoque/produto*') || request()->is('Stoque/compra*') ? 'active' : '' }}">
                <i class="nav-icon fa fa-boxes"></i>
                <p>Gestão de Compras <i class="right fa fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ route('produto.create') }}" class="nav-link {{ request()->is('Stoque/produto/create') ? 'active' : '' }}">
                        <i class="fa fa-plus-circle nav-icon"></i>
                        <p>Adicionar Produto</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('produto.index') }}" class="nav-link {{ request()->is('Stoque/produto') ? 'active' : '' }}">
                        <i class="fa fa-list nav-icon"></i>
                        <p>Visualizar Produtos</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('compra.index') }}" class="nav-link {{ request()->is('Stoque/compra') ? 'active' : '' }}">
                        <i class="fa fa-shopping-basket nav-icon"></i>
                        <p>Visualizar Compras</p>
                    </a>
                </li>
            </ul>
        </li>
        @endcan

        <!-- Gestão de Vendas -->
        @can("Visualizar-Menu-Venda")
        <li class="nav-item has-treeview {{ request()->is('Stoque/loja*') || request()->is('Stoque/Venda*') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ request()->is('Stoque/loja*') || request()->is('Stoque/Venda*') ? 'active' : '' }}">
                <i class="nav-icon fa fa-cash-register"></i>
                <p>Gestão de Vendas <i class="right fa fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ route('loja.index') }}" class="nav-link {{ request()->is('Stoque/loja') ? 'active' : '' }}">
                        <i class="fa fa-file-invoice-dollar nav-icon"></i>
                        <p>Faturação</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('Venda.index') }}" class="nav-link {{ request()->is('Stoque/Venda') ? 'active' : '' }}">
                        <i class="fa fa-chart-line nav-icon"></i>
                        <p>Vendas</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('loja.create') }}" class="nav-link {{ request()->is('Stoque/loja/create') ? 'active' : '' }}">
                        <i class="fa fa-store nav-icon"></i>
                        <p>Adicionar Farmácia</p>
                    </a>
                </li>
            </ul>
        </li>
        @endcan

        <!-- Administração -->
        @can('Visualizar-Admin')
        <li class="nav-item has-treeview {{ request()->is('admin/*') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ request()->is('admin/*') ? 'active' : '' }}">
                <i class="nav-icon fa fa-tools"></i>
                <p>Administração <i class="right fa fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="/admin/permissons/lista" class="nav-link {{ request()->is('admin/permissons/lista') ? 'active' : '' }}">
                        <i class="fa fa-lock nav-icon"></i>
                        <p>Lista de Privilégios</p>
                    </a>
                </li>
                <li class="nav-item has-treeview {{ request()->is('admin/Usuarios*') || request()->is('admin/funcionarios') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fa fa-user-cog"></i>
                        <p>Usuários <i class="right fa fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('Usuarios.index') }}" class="nav-link {{ request()->is('admin/Usuarios') ? 'active' : '' }}">
                                <i class="fa fa-user nav-icon"></i>
                                <p>Lista de Usuários</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('Usuarios.create') }}" class="nav-link {{ request()->is('admin/Usuarios/create') ? 'active' : '' }}">
                                <i class="fa fa-user-plus nav-icon"></i>
                                <p>Registrar Usuário</p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </li>
        @endcan
    </ul>
</nav>
