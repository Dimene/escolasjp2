<nav class="main-header navbar navbar-expand {{ session('dadoslayout')->nav_header }} navbar-light border-bottom fixed-top">
    <div class="container-fluid">

        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="/" class="nav-link">Home</a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="#" class="nav-link">Sobre nós</a>
            </li>
            <li class="nav-item d-none d-sm-inline-block FazerBackup">
                <a href="#" class="nav-link">Backup</a>
            </li>
        </ul>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">

            @guest
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                </li>
            @endguest

            @auth
                @php
                    $notificacoesNaoLidas = auth()->user()->unreadNotifications;
                    $notificacoesLidas = auth()->user()->readNotifications;
                @endphp

                <!-- Notificações -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle position-relative" href="#" role="button"
                       data-toggle="dropdown" aria-expanded="false" aria-label="Notificações">
                        <i class="fa fa-bell"></i>
                        @if($notificacoesNaoLidas->count())
                            <span class="badge badge-danger rounded-pill position-absolute"
                                  style="top:0; right:0;">
                                {{ $notificacoesNaoLidas->count() }}
                            </span>
                        @endif
                    </a>

                    <div class="dropdown-menu dropdown-menu-right">
                        <span class="dropdown-header">🔔 Não lidas</span>
                        @forelse ($notificacoesNaoLidas as $n)
                            <a class="dropdown-item  " href="{{ Route("BDNotificao.show",$n->id) }}" >
                                {{ $n->data['titulo'] ?? 'Despesa pendente para aprovação' }}

                            </a>
                        @empty
                            <span class="dropdown-item text-muted">Sem novas notificações</span>
                        @endforelse

                        @if($notificacoesLidas->count())
                            <div class="dropdown-divider"></div>
                            <span class="dropdown-header">📬 Lidas</span>
                            @foreach ($notificacoesLidas as $n)
                                <div class="dropdown-item d-flex justify-content-between align-items-center lida">
                                    <span>{{ $n->data['titulo'] ?? 'Despesa lida' }}</span>
                                    <form method="POST" action="#">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-link text-danger" title="Apagar notificação">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </li>

                <!-- Usuário -->
                <li class="nav-item d-flex align-items-center">
                    <i class="fa fa-user-circle-o mr-2"></i> {{ auth()->user()->name }}
                </li>

                <!-- Logout -->
                <li class="nav-item">
                    <a class="nav-link text-danger" href="{{ route('logout') }}"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fa fa-power-off"></i> Sair
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>

                <!-- Control Sidebar -->
                <li class="nav-item">
                    <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#">
                        <i class="fa fa-th-large"></i>
                    </a>
                </li>
            @endauth

        </ul>
    </div>
</nav>

{{-- Bootstrap 4 --> --}}
   <script src="{{ asset('Admin-LTE/plugins/jquery/jquery.min.js') }}"></script>
     <script src="{{ asset('Admin-LTE/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script>

    // Abrir
$('.nav-item.dropdown > .nav-link').dropdown('show');

// Fechar
$('.nav-item.dropdown > .nav-link').dropdown('hide');
</script>



<style>

    /* Força cor visível nas notificações */
.dropdown-menu .dropdown-item {
    color: #212529 !important;   /* preto padrão Bootstrap */
}

.dropdown-menu .dropdown-item:hover {
    background-color: #f8f9fa;   /* cinza claro no hover */
    color: #000 !important;
}
    </style>
