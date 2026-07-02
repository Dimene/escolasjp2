@extends('layouts.admin-Lti')

@section('title', 'Lista de Notificações')

@section('content')
<section class="content">
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid shadow-no">
                <div class="row">
                    <div class="col-sm-6">
                        <h4><i class="fa fa-bell"></i> Notificações</h4>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Notificação</a></li>
                            <li class="breadcrumb-item active">Lista</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    🔔 Não lidas
                </div>
                <div class="card-body">
                    @forelse ($notificacoesNaoLidas as $n)
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span>{{ $n->data['mensagem'] ?? 'Despesa pendente para aprovação' }}</span>
                            <div>
                                <a href="{{ route('BDNotificao.show', $n->id) }}" class="btn btn-info btn-sm">
                                    <i class="fa fa-eye"></i> Ver
                                </a>
                                <form action="{{ route('BDNotificao.destroy', $n->id) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-danger btn-sm">
                                        <i class="fa fa-trash"></i> Apagar
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted">Sem novas notificações</p>
                    @endforelse
                </div>
            </div>

            @if($notificacoesLidas->count())
                <div class="card shadow-sm mt-4">
                    <div class="card-header bg-secondary text-white">
                        📬 Lidas
                    </div>
                    <div class="card-body">
                        @foreach ($notificacoesLidas as $n)
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-muted">{{ $n->data['mensagem'] ?? 'Despesa lida' }}</span>
                                <div>
                                    <a href="{{ route('BDNotificao.show', $n->id) }}" class="btn btn-info btn-sm">
                                        <i class="fa fa-eye"></i> Ver
                                    </a>
                                    <form action="{{ route('BDNotificao.destroy', $n->id) }}" method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-danger btn-sm">
                                            <i class="fa fa-trash"></i> Apagar
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</section>
@endsection