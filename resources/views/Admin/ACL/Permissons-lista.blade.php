@extends('layouts.admin-Lti')
@section('title', 'Administração - Permissões do Sistema')

@section('content')
<style>
    /* Animações e Keyframes */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fadeInLeft {
        from {
            opacity: 0;
            transform: translateX(-30px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes scaleIn {
        from {
            opacity: 0;
            transform: scale(0.9);
        }
        to {
            opacity: 1;
            transform: scale(1);
        }
    }

    @keyframes shimmer {
        0% {
            background-position: -1000px 0;
        }
        100% {
            background-position: 1000px 0;
        }
    }

    .animate-fadeInUp {
        animation: fadeInUp 0.6s ease-out;
    }

    .animate-fadeInLeft {
        animation: fadeInLeft 0.5s ease-out;
    }

    .animate-scaleIn {
        animation: scaleIn 0.4s ease-out;
    }

    /* Breadcrumb Moderno */
    .breadcrumb-modern {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 12px 20px;
        border-radius: 12px;
        margin-bottom: 20px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }

    .breadcrumb-modern .breadcrumb-item {
        color: rgba(255,255,255,0.9);
    }

    .breadcrumb-modern .breadcrumb-item a {
        color: white;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .breadcrumb-modern .breadcrumb-item a:hover {
        color: #ffd700;
        transform: translateX(3px);
        display: inline-block;
    }

    .breadcrumb-modern .breadcrumb-item.active {
        color: #ffd700;
        font-weight: bold;
    }

    /* Card Principal */
    .card-modern {
        border: none;
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.1);
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .card-modern:hover {
        box-shadow: 0 15px 50px rgba(0,0,0,0.15);
    }

    .card-modern .card-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 20px 25px;
        border-bottom: none;
    }

    .card-modern .card-header h3 {
        margin: 0;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .card-modern .card-header h3:before {
        content: "🔐";
        font-size: 24px;
    }

    .card-modern .card-body {
        padding: 25px;
        background: #f8f9fa;
    }

    /* Formulário Moderno */
    .form-modern {
        background: white;
        border-radius: 15px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
    }

    .form-modern:hover {
        box-shadow: 0 8px 25px rgba(0,0,0,0.12);
    }

    .form-modern .form-group label {
        font-weight: 600;
        color: #333;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .form-modern .form-control {
        border: 2px solid #e0e0e0;
        border-radius: 12px;
        padding: 10px 15px;
        transition: all 0.3s ease;
    }

    .form-modern .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102,126,234,0.25);
    }

    /* Botões Modernos */
    .btn-modern {
        border-radius: 12px;
        padding: 10px 25px;
        font-weight: 600;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
    }

    .btn-modern:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    }

    .btn-primary-modern {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    .btn-primary-modern:hover {
        background: linear-gradient(135deg, #5a67d8 0%, #6b46c1 100%);
    }

    .btn-success-modern {
        background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
        color: white;
    }

    .btn-danger-modern {
        background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
        color: white;
    }

    /* Cards de Permissões */
    .permission-card {
        background: white;
        border-radius: 15px;
        overflow: hidden;
        transition: all 0.3s ease;
        margin-bottom: 20px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        animation: fadeInLeft 0.5s ease-out;
    }

    .permission-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0,0,0,0.15);
    }

    .permission-card .card-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 15px 20px;
        border-bottom: none;
    }

    .permission-card .card-header .card-title {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
    }

    .permission-card .card-header .card-title p {
        margin: 0;
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }

    .permission-card .card-header a {
        color: white;
        text-decoration: none;
        transition: all 0.3s ease;
        padding: 5px 10px;
        border-radius: 8px;
    }

    .permission-card .card-header a:hover {
        background: rgba(255,255,255,0.2);
        transform: scale(1.05);
    }

    .permission-card .card-header a i {
        margin-right: 5px;
    }

    .permission-card .card-body {
        padding: 20px;
        min-height: 200px;
        max-height: 250px;
        overflow-y: auto;
    }

    .permission-card .card-body ul {
        padding-left: 0;
        margin: 0;
    }

    .permission-card .card-body ul li {
        padding: 8px 12px;
        margin: 5px 0;
        background: #f8f9fa;
        border-radius: 8px;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .permission-card .card-body ul li:hover {
        background: linear-gradient(135deg, #f5f7fa 0%, #e9ecef 100%);
        transform: translateX(5px);
    }

    .permission-card .card-body ul li:before {
        content: "✓";
        color: #28a745;
        font-weight: bold;
    }

    .permission-card .card-footer {
        background: #f8f9fa;
        padding: 15px;
        text-align: center;
        border-top: 1px solid #e0e0e0;
    }

    /* Badges */
    .badge-count {
        background: rgba(255,255,255,0.2);
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 12px;
        margin-left: 10px;
    }

    /* Alertas Modernos */
    .alert-modern {
        border-radius: 12px;
        border: none;
        padding: 15px 20px;
        margin-bottom: 20px;
        animation: scaleIn 0.4s ease-out;
    }

    /* Scrollbar Personalizada */
    .permission-card .card-body::-webkit-scrollbar {
        width: 6px;
    }

    .permission-card .card-body::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    .permission-card .card-body::-webkit-scrollbar-thumb {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 10px;
    }

    /* Loading Skeleton */
    .skeleton {
        background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
        background-size: 1000px 100%;
        animation: shimmer 2s infinite;
        border-radius: 8px;
    }

    /* Responsividade */
    @media (max-width: 768px) {
        .permission-card .card-header .card-title p {
            flex-direction: column;
            align-items: flex-start;
        }

        .form-modern .row {
            flex-direction: column;
        }

        .form-modern .col {
            margin-bottom: 15px;
        }

        .btn-modern {
            width: 100%;
            margin-top: 10px;
        }
    }

    /* Loading Overlay */
    .loading-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0,0,0,0.7);
        display: none;
        justify-content: center;
        align-items: center;
        z-index: 9999;
    }

    .loading-spinner {
        width: 50px;
        height: 50px;
        border: 5px solid #f3f3f3;
        border-top: 5px solid #667eea;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    /* Tooltip Customizado */
    [data-tooltip] {
        position: relative;
        cursor: pointer;
    }

    [data-tooltip]:before {
        content: attr(data-tooltip);
        position: absolute;
        bottom: 100%;
        left: 50%;
        transform: translateX(-50%);
        background: #333;
        color: white;
        padding: 5px 10px;
        border-radius: 8px;
        font-size: 12px;
        white-space: nowrap;
        opacity: 0;
        pointer-events: none;
        transition: all 0.3s ease;
        z-index: 1000;
    }

    [data-tooltip]:hover:before {
        opacity: 1;
        transform: translateX(-50%) translateY(-5px);
    }
</style>

<div class="loading-overlay" id="loadingOverlay">
    <div class="loading-spinner"></div>
</div>

<section class="content">

<div class="">

{{-- HEADER --}}
<div class="content-header">
    <div class="container-fluid">
    <!-- Breadcrumb Moderno -->
    <div class="breadcrumb-modern animate-fadeInUp">
        <ol class="breadcrumb" style="background: transparent; margin: 0; padding: 0;">
            <li class="breadcrumb-item">
                <a href="#"><i class="fa fa-dashboard"></i> Dashboard</a>
            </li>
            <li class="breadcrumb-item">
                <a href="#"><i class="fa fa-shield-alt"></i> Administração</a>
            </li>
            <li class="breadcrumb-item active">
                <i class="fa fa-key"></i> <b>Gestão de Permissões</b>
            </li>
        </ol>
    </div>

    <div class="container-fluid container">
        <div class="row justify">
            <div class="col">
                <!-- Card Principal -->
                <div class="card-modern animate-fadeInUp">
                    <div class="card-header">
                        <h3>
                            <i class="fa fa-lock"></i>
                            Lista de Funções do Sistema
                            <span class="badge-count">{{ count($Funcois) }} Funções</span>
                        </h3>
                    </div>

                    <div class="card-body">
                        <!-- Alertas -->
                        <div class="col-12">
                            @include('include.mensage-alerta')
                        </div>

                        <!-- Botão Criar Nova Função -->
                        <div class="text-right mb-3">
                            <button class="btn btn-primary-modern btn-modern" id="AddicionarNovafuncao" data-tooltip="Criar uma nova função no sistema">
                                <i class="fa fa-plus-circle"></i>
                                <i class="fa fa-key"></i>
                                Criar Nova Função
                            </button>
                        </div>

                        <!-- Formulário de Cadastro/Edição -->
                        <div class="form-modern corpoAddicionarNovafuncao"
                             @if(isset($update)) style="display: block;"
                             @else style="display: none;"
                             @endif>

                            @if(isset($update))
                                <form class="form-horizontal" role="form" method="POST" action="{{ route('Admin.permisson.atualizar', $update->id) }}">
                                    {!! method_field('PUT') !!}
                            @else
                                <form class="form-horizontal" role="form" method="POST" action="{{ route('Admin.permissons.guardar') }}">
                            @endif
                            {{ csrf_field() }}

                            <div class="row">
                                <div class="col-md-5 col-sm-12">
                                    <div class="form-group">
                                        <label for="nomeFuncao">
                                            <i class="fa fa-tag"></i>
                                            <strong>Nome da Função</strong>
                                        </label>
                                        <input class="form-control"
                                               required="true"
                                               type="text"
                                               name="nomeFuncao"
                                               placeholder="Ex: Administrador, Editor, Visualizador..."
                                               autocomplete="on"
                                               @if(isset($update)) value="{{ $update->name }}"
                                               @else value="{{ old('nomeFuncao') }}"
                                               @endif>
                                        <small class="text-muted">Nome único identificador da função</small>
                                    </div>
                                </div>

                                <div class="col-md-5 col-sm-12">
                                    <div class="form-group">
                                        <label for="DiscricaoFuncao">
                                            <i class="fa fa-align-left"></i>
                                            <strong>Descrição da Função</strong>
                                        </label>
                                        <input class="form-control"
                                               required="true"
                                               type="text"
                                               name="DiscricaoFuncao"
                                               placeholder="Ex: Acesso total ao sistema, Apenas leitura..."
                                               autocomplete="on"
                                               @if(isset($update)) value="{{ $update->label }}"
                                               @else value="{{ old('DiscricaoFuncao') }}"
                                               @endif>
                                        <small class="text-muted">Descrição amigável para exibição</small>
                                    </div>
                                </div>

                                <div class="col-md-2 col-sm-12">
                                    <button type="submit" class="btn btn-primary-modern btn-modern" style="margin-top: 32px; width: 100%;">
                                        <i class="fa fa-{{ isset($update) ? 'save' : 'plus' }}"></i>
                                        {{ isset($update) ? 'Atualizar Função' : 'Criar Função' }}
                                    </button>
                                </div>
                            </div>

                            @if(isset($update))
                            <div class="row mt-2">
                                <div class="col-12 text-right">
                                    <a href="{{ route('Admin.permissons.lista') }}" class="btn btn-secondary btn-modern">
                                        <i class="fa fa-times"></i> Cancelar Edição
                                    </a>
                                </div>
                            </div>
                            @endif

                            </form>
                        </div>

                        <!-- Lista de Permissões -->
                        <div class="row mt-4">
                            @forelse($Funcois as $Funcoes)
                            <div class="col-md-6 col-lg-4">
                                <div class="permission-card animate-scaleIn">
                                    <div class="card-header">
                                        <div class="card-title">
                                            <p>
                                                <i class="fa fa-shield-alt"></i>
                                                <strong>{{ $Funcoes->label }}</strong>
                                                <small class="badge-count">{{ $Funcoes->permission->count() }} permissões</small>
                                            </p>
                                            <p>
                                                @if($Funcoes->name != 'Admin')
                                                <a href="{{ route('Admin.permissons.edit', $Funcoes->id) }}"
                                                   class="btn-edit"
                                                   data-tooltip="Editar função">
                                                    <i class="fa fa-edit"></i> Editar
                                                </a>
                                                <a href="{{ route('Admin.permissons.apagar', $Funcoes->id) }}"
                                                   class="btn-delete"
                                                   data-tooltip="Apagar função"
                                                   onclick="return confirm('Tem certeza que deseja apagar esta função?')">
                                                    <i class="fa fa-trash"></i> Apagar
                                                </a>
                                                @else
                                                <span class="badge" style="background: rgba(255,255,255,0.2); padding: 5px 10px; border-radius: 8px;">
                                                    <i class="fa fa-star"></i> Sistema
                                                </span>
                                                @endif
                                            </p>
                                        </div>
                                    </div>

                                    <div class="card-body">
                                        @if($Funcoes->permission->count() > 0)
                                        <ul style="list-style: none;">
                                            @foreach($Funcoes->permission as $permisso)
                                            <li>
                                                <i class="fa fa-check-circle" style="color: #28a745;"></i>
                                                {{ $permisso->label }}
                                            </li>
                                            @endforeach
                                        </ul>
                                        @else
                                        <div class="text-center text-muted">
                                            <i class="fa fa-info-circle"></i>
                                            <p>Nenhuma permissão atribuída</p>
                                        </div>
                                        @endif
                                    </div>

                                    <div class="card-footer">
                                        <a class="btn btn-success-modern btn-modern"
                                           href="{{ route('Admin.permisson.papel', $Funcoes->id) }}"
                                           style="display: inline-block; width: auto;">
                                            <i class="fa fa-plus-circle"></i>
                                            Adicionar Privilégios
                                            <i class="fa fa-arrow-right"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="col-12">
                                <div class="alert alert-info alert-modern text-center">
                                    <i class="fa fa-info-circle fa-2x"></i>
                                    <h4>Nenhuma função encontrada</h4>
                                    <p>Clique em "Criar Nova Função" para adicionar a primeira função do sistema.</p>
                                </div>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
</section>

@push('script')
<script>
$(document).ready(function() {
    // Toggle do formulário com animação
    $("#AddicionarNovafuncao").click(function() {
        $(".corpoAddicionarNovafuncao").slideToggle(400, function() {
            if ($(this).is(":visible")) {
                $(this).css('display', 'block');
            }
        });
    });

    // Animação de entrada dos cards
    $(".permission-card").each(function(index) {
        $(this).css('animation-delay', (index * 0.05) + 's');
    });

    // Confirmação para apagar
    $('.btn-delete').click(function(e) {
        if (!confirm('⚠️ Atenção!\n\nTem certeza que deseja apagar esta função?\n\nEsta ação não pode ser desfeita.')) {
            e.preventDefault();
            return false;
        }
    });

    // Loading effect para submits
    $('form').submit(function() {
        if ($(this).valid !== false) {
            $('#loadingOverlay').fadeIn(300);
        }
    });

    // Tooltips dinâmicos
    $('[data-tooltip]').each(function() {
        $(this).attr('title', $(this).data('tooltip'));
    });

    // Feedback visual para botões
    $('.btn-modern').click(function(e) {
        let btn = $(this);
        if (!btn.hasClass('no-feedback')) {
            btn.css('transform', 'scale(0.95)');
            setTimeout(() => {
                btn.css('transform', '');
            }, 150);
        }
    });

    // Mensagem de sucesso após submit (se houver)
    @if(session('success'))
    showNotification('{{ session('success') }}', 'success');
    @endif

    @if(session('error'))
    showNotification('{{ session('error') }}', 'error');
    @endif
});

// Função para mostrar notificações
function showNotification(message, type = 'success') {
    const bgColor = type === 'success' ? 'linear-gradient(135deg, #43e97b 0%, #38f9d7 100%)' : 'linear-gradient(135deg, #fa709a 0%, #fee140 100%)';
    const icon = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle';

    const notification = $(`
        <div style="position: fixed; top: 20px; right: 20px; z-index: 10000; animation: fadeInLeft 0.3s ease-out;">
            <div style="background: ${bgColor}; color: white; padding: 15px 25px; border-radius: 12px; box-shadow: 0 10px 25px rgba(0,0,0,0.2); display: flex; align-items: center; gap: 10px;">
                <i class="fa ${icon}" style="font-size: 20px;"></i>
                <span>${message}</span>
                <i class="fa fa-times" style="cursor: pointer; margin-left: 10px;" onclick="$(this).closest('div').fadeOut()"></i>
            </div>
        </div>
    `);

    $('body').append(notification);

    setTimeout(() => {
        notification.fadeOut(300, () => notification.remove());
    }, 5000);
}

// Loading global hide
$(window).on('load', function() {
    $('#loadingOverlay').fadeOut(300);
});
</script>
@endpush

@endsection
