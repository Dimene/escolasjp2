@extends('layouts.admin-Lti')

@section('title', 'Visualizar Notificação')

@section('content')
<section class="content">
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid shadow-no">
                <div class="row">
                    <div class="col-sm-6"></div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Notificação</a></li>
                            <li class="breadcrumb-item active">Visualizar</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="container mt-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="fa fa-bell"></i> Detalhes da Notificação
                        </h5>
                        <a href="{{ route('BDNotificao.index') }}" class="btn btn-light btn-sm">
                            <i class="fa fa-arrow-left"></i> Voltar
                        </a>
                    </div>

                    <div class="card-body">
                        <p class="lead">
                            {{ $notificacao->data['mensagem'] ?? 'Sem mensagem disponível' }}
                        </p>

                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><strong>ID:</strong> {{ $notificacao->id }}</li>
                            <li class="list-group-item"><strong>Data de criação:</strong> {{ $notificacao->created_at->format('d/m/Y H:i') }}</li>
                            <li class="list-group-item">
                                <strong>Status:</strong>
                                @if($notificacao->read_at)
                                    <span class="badge badge-success">Lida</span>
                                @else
                                    <span class="badge badge-warning">Não lida</span>
                                @endif
                            </li>
                        </ul>
                    </div>

                    <div class="card-footer d-flex justify-content-between">
                        <!-- Marcar como lida -->
                        @if(!$notificacao->read_at)
                            <a href="{{ route('BDNotificao.edit', $notificacao->id) }}" class="btn btn-success">
                                <i class="fa fa-check"></i> Marcar como lida
                            </a>
                        @endif

                        <!-- Apagar -->
                        <form action="{{ route('BDNotificao.destroy', $notificacao->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger">
                                <i class="fa fa-trash"></i> Apagar
                            </button>
                        </form>




                        <!-- Botão para disparar o AJAX -->
<button type="button" class="btn btn-info" id="btnResponder-{{ $notificacao->id }}">
    <i class="fa fa-reply"></i> Responder
</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Formulário oculto para responder -->
    <form id="notificacao-{{ $notificacao->id }}"
          action="{{ $notificacao->data['link'] }}"
          method="POST"
          class="d">
        @csrf


        <input type="hidden" name="notificacaoId"  value="{{ $notificacao->id }}">
        <input type="hidden" name="estado"  value="{{ $notificacao->data['estado'] }}">
        @php
            // Decodifica como array associativo
            $dados = json_decode($notificacao->data['dados'], true);
        @endphp

        @foreach($dados as $key => $value)
            @if(is_array($value))
                @foreach($value as $value2)
                    <input type="hidden" name="{{ $key }}[]" value="{{ $value2}}">
                @endforeach
            @else
            @if($key!="_token")
                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                @endif
            @endif
        @endforeach
    </form>






<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function () {
    $('#btnResponder-{{ $notificacao->id }}').on('click', function (e) {
        e.preventDefault();

        let form = $('#notificacao-{{ $notificacao->id }}');
        let url = form.attr('action');
        let data = form.serialize(); // 🔑 serializa todos os inputs

        $.ajax({
            url: url,
            type: 'POST',
            data: data,
           success: function (response) {
    Swal.fire({
        title: 'Sucesso!',
        text: 'Resposta enviada com sucesso!',
        icon: 'success',
        confirmButtonText: 'OK'
    }).then(() => {
           // 🔄 Atualiza a página depois do usuário clicar em "OK"
        location.reload();
    });
},
error: function (xhr) {
    Swal.fire({
        title: 'Erro!',
        text: 'Não foi possível enviar a resposta.',
        icon: 'error',
        confirmButtonText: 'Tentar novamente'
    });
}
        });
    });
});
</script>
</section>
@endsection
