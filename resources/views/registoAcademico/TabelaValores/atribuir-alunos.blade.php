@extends('layouts.admin-Lti')
@section('title', 'Tabela de Valores por Ano Lectivo')
@section('content')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- DataTables -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<!-- SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    .content-wrapper { background: #f0f2f5; }

    .nav-tabs { border-bottom: none; gap: 0.5rem; }
    .nav-tabs .nav-link { border: none; padding: 0.75rem 1.8rem; font-weight: 600; border-radius: 0.75rem 0.75rem 0 0; color: #4a5568; background: #edf2f7; transition: all 0.3s ease; }
    .nav-tabs .nav-link i { margin-right: 0.5rem; }
    .nav-tabs .nav-link:hover { background: #e2e8f0; color: #4f46e5; }
    .nav-tabs .nav-link.active { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3); }

    .nav-tabs2 { border-bottom: 1px solid #e2e8f0; background: white; padding: 0.5rem 0 0 1rem; border-radius: 0.75rem 0.75rem 0 0; }
    .nav-tabs2 .nav-link { border: none; padding: 0.5rem 1.2rem; margin-right: 0.25rem; border-radius: 0.5rem 0.5rem 0 0; color: #4a5568; font-weight: 500; transition: all 0.2s ease; }
    .nav-tabs2 .nav-link i { margin-right: 0.4rem; }
    .nav-tabs2 .nav-link:hover { background: #f7fafc; color: #4f46e5; }
    .nav-tabs2 .nav-link.active { color: #4f46e5; border-bottom: 3px solid #4f46e5; background: white; font-weight: 600; }

    .card-tabela { background: white; border-radius: 0.75rem; box-shadow: 0 1px 3px rgba(0,0,0,0.05); overflow: hidden; margin-top: 1rem; }
    .card-tabela .card-body { padding: 0; }

    .dataTables_wrapper { padding: 1rem; }
    .dataTables_wrapper .dataTables_filter input { border-radius: 2rem; border: 1px solid #e2e8f0; padding: 0.5rem 1rem; padding-left: 2rem; background: white url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="%23667eea" stroke-width="2"><circle cx="10" cy="10" r="7"/><line x1="21" y1="21" x2="15" y2="15"/></svg>') no-repeat 0.7rem center; background-size: 1rem; }

    .table-alunos { margin: 0 !important; }
    .table-alunos thead th { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; font-weight: 600; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px; padding: 1rem; border: none; }
    .table-alunos tbody tr:hover { background: #f7fafc; }
    .table-alunos tbody td { padding: 0.8rem 1rem; vertical-align: middle; border-bottom: 1px solid #edf2f7; }
    .table-alunos tfoot th { background: #f8fafc; padding: 0.5rem; border-top: 2px solid #e2e8f0; }
    .table-alunos tfoot select, .table-alunos tfoot input { width: 100%; padding: 0.4rem 0.6rem; border-radius: 0.5rem; border: 1px solid #e2e8f0; font-size: 0.75rem; }

    .badge-gerada { background: linear-gradient(135deg, #48bb78 0%, #38a169 100%); color: white; padding: 0.25rem 0.75rem; border-radius: 2rem; font-size: 0.7rem; display: inline-flex; align-items: center; gap: 0.3rem; }
    .badge-pendente { background: linear-gradient(135deg, #f56565 0%, #e53e3e 100%); color: white; padding: 0.25rem 0.75rem; border-radius: 2rem; font-size: 0.7rem; display: inline-flex; align-items: center; gap: 0.3rem; }

    .checkbox-aluno { width: 18px; height: 18px; cursor: pointer; accent-color: #667eea; }
    .checkbox-aluno:disabled { cursor: not-allowed; opacity: 0.6; }
    .checkbox-topo { width: 18px; height: 18px; cursor: pointer; accent-color: #667eea; }

    .ano-content { animation: fadeInUp 0.4s ease-out; }
    @keyframes fadeInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }

    .mass-actions-bar { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 0.75rem 1rem; border-radius: 0.5rem; margin-bottom: 1rem; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 0.5rem; }
    .selection-info { background: rgba(255,255,255,0.2); padding: 0.3rem 0.8rem; border-radius: 2rem; font-size: 0.8rem; }
    .btn-mass { background: white; color: #667eea; border: none; padding: 0.3rem 1rem; border-radius: 0.5rem; font-size: 0.75rem; font-weight: 600; transition: all 0.2s ease; }
    .btn-mass:hover { transform: translateY(-2px); box-shadow: 0 2px 8px rgba(0,0,0,0.2); }
    .btn-mass-danger { background: #f56565; color: white; }
    .btn-mass-danger:hover { background: #e53e3e; }

    /* Estilos da Barra de Progresso */
    .progress-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0,0,0,0.8);
        z-index: 10000;
        display: none;
        justify-content: center;
        align-items: center;
    }

    .progress-container {
        background: white;
        padding: 2rem;
        border-radius: 1rem;
        min-width: 400px;
        box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        animation: slideInUp 0.3s ease;
    }

    @keyframes slideInUp {
        from {
            transform: translateY(50px);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    .progress-title {
        font-size: 1.3rem;
        font-weight: 700;
        margin-bottom: 1.5rem;
        color: #4a5568;
        text-align: center;
    }

    .progress-stats {
        font-size: 1rem;
        color: #718096;
        margin: 1rem 0;
        text-align: center;
    }

    .progress {
        height: 35px;
        border-radius: 20px;
        background: #edf2f7;
        overflow: hidden;
        margin: 1rem 0;
    }

    .progress-bar {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        transition: width 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 0.9rem;
        color: white;
    }

    .progress-detail {
        margin-top: 1rem;
        padding: 0.5rem;
        background: #f7fafc;
        border-radius: 0.5rem;
        font-size: 0.9rem;
    }

    .success-badge {
        color: #48bb78;
        font-weight: 600;
    }

    .error-badge {
        color: #f56565;
        font-weight: 600;
    }

    .current-processing {
        margin-top: 0.5rem;
        font-size: 0.85rem;
        color: #667eea;
        font-weight: 500;
    }
</style>
 <div class="breadcrumb-modern animate-fadeInUp">
        <ol class="breadcrumb" style="background: transparent; margin: 0; padding: 0;">
            <li class="breadcrumb-item">
                <a href="#"><i class="fa fa-cogs"></i> Gestão de Administrativa</a>
            </li>

 <li class="breadcrumb-item">
                <a href="#"><i class="fa fa-sliders"></i>  Configuracoes</a>
            </li>

            <li class="breadcrumb-item active">
                <i class="fa fa-table"></i> <b>Tabela de  Valores</b>
            </li>
        </ol>
    </div>
<div class="container-fluid px-0">

    <!-- Tabs Ano -->
    <ul class="nav nav-tabs">
        @foreach($anolectivo as $value)
            <li class="nav-item">
                <a class="nav-link ano-link @if($value->anolectivo == date('Y')) active @endif"
                   href="#"
                   data-ano-id="{{ $value->id }}">
                    <i class="fa fa-calendar"></i>
                    {{ $value->anolectivo }}
                    @if($value->anolectivo == date('Y'))
                        <span class="badge bg-white text-dark ms-1" style="font-size: 0.6rem;">Actual</span>
                    @endif
                </a>
            </li>
        @endforeach
    </ul>

    <!-- Conteúdo por Ano -->
    @foreach($anolectivo as $value)
        <div class="ano-content" id="ano-{{ $value->id }}"
             style="display: {{ $value->anolectivo == date('Y') ? 'block' : 'none' }};">

            @php
                $tipos = $dados->where('anolectivo_id', $value->id)->unique('tipo');
            @endphp

            @if($tipos->where('tipo', '>', 2)->count() > 0)
                <!-- Tabs Tipo -->
                <ul class="nav nav-tabs2 mt-3">
                    @foreach($tipos->where("tipo",">",2) as $item)
                        <li class="nav-item">
                            <a class="nav-link tipo-link @if($loop->first) active @endif"
                               href="#"
                               data-ano-id="{{ $value->id }}"
                               data-tipo-id="{{ $item->id }}">
                                <i class="fa fa-credit-card"></i>
                                {{ $item->Descricao }}
                            </a>
                        </li>
                    @endforeach
                </ul>

                <!-- Barra de Ações em Massa -->
                <div class="mass-actions-bar" id="massActionsBar-{{ $value->id }}" style="display: none;">
                    <div class="selection-info">
                        <i class="fa fa-check-square-o"></i>
                        <span id="selectedCount-{{ $value->id }}">0</span> selecionado(s)
                    </div>
                    <div class="d-flex gap-2">
                        <button class="btn-mass" onclick="marcarTodosPagina('{{ $value->id }}')">
                            <i class="fa fa-check-square-o"></i> Marcar todos da página
                        </button>
                        <button class="btn-mass" onclick="desmarcarTodosPagina('{{ $value->id }}')">
                            <i class="fa fa-square-o"></i> Desmarcar todos
                        </button>
                        <button class="btn-mass btn-mass-danger" onclick="gerarSelecionados('{{ $value->id }}')">
                            <i class="fa fa-file-pdf-o"></i> Gerar Pagamentos
                        </button>
                    </div>
                </div>

                <!-- Tabela -->
                <div class="card-tabela">
                    <div class="card-body">
                        <table class="table table-alunos" id="tabela-{{ $value->id }}">
                            <thead>
                                <tr>
                                    <th width="50">
                                        <input type="checkbox" id="checkAllTopo-{{ $value->id }}" class="checkbox-topo">
                                    </th>
                                    <th width="110"><i class="fa fa-toggle-on"></i> Estado</th>
                                    <th width="60"><i class="fa fa-hashtag"></i> ID</th>
                                    <th><i class="fa fa-user"></i> Nome</th>
                                    <th width="120"><i class="fa fa-graduation-cap"></i> Classe</th>
                                    <th width="120"><i class="fa fa-users"></i> Turma</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th></th>
                                    <th>Estado</th>
                                    <th>ID</th>
                                    <th>Nome</th>
                                    <th>Classe</th>
                                    <th>Turma</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-5">
                                        <i class="fa fa-spinner fa-spin fa-2x"></i>
                                        <p class="mt-2">A carregar dados...</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            @else
                <div class="alert alert-info mt-3 text-center">
                    <i class="fa fa-info-circle"></i>
                    Nenhum tipo de pagamento configurado para {{ $value->anolectivo }}
                </div>
            @endif
        </div>
    @endforeach

</div>

<!-- Overlay da Barra de Progresso -->
<div id="progressOverlay" class="progress-overlay">
    <div class="progress-container">
        <div class="progress-title">
            <i class="fa fa-spinner fa-spin"></i>
            Processando Pagamentos
        </div>
        <div class="progress-stats">
            <strong><span id="progressCurrent">0</span> de <span id="progressTotal">0</span></strong> alunos processados
        </div>
        <div class="progress">
            <div id="progressBar" class="progress-bar" style="width: 0%">0%</div>
        </div>
        <div class="progress-detail">
            <div><i class="fa fa-check-circle text-success"></i> <strong>Sucessos:</strong> <span id="successCount" class="success-badge">0</span></div>
            <div><i class="fa fa-exclamation-circle text-danger"></i> <strong>Falhas:</strong> <span id="errorCount" class="error-badge">0</span></div>
        </div>
        <div id="currentProcessing" class="current-processing">
            <i class="fa fa-clock-o"></i> Aguardando início...
        </div>
    </div>
</div>

<script>
var tables = {};

$(document).ready(function(){

    // Trocar ANO
    $(document).on('click', '.ano-link', function(e){
        e.preventDefault();

        $('.ano-link').removeClass('active');
        $(this).addClass('active');

        let anoId = $(this).data('ano-id');

        $('.ano-content').fadeOut(200);
        $('#ano-'+anoId).fadeIn(300);

        let primeiroTipo = $('#ano-'+anoId+' .tipo-link:first');
        if(primeiroTipo.length){
            setTimeout(() => primeiroTipo.click(), 100);
        }
    });

    // Trocar TIPO
    $(document).on('click', '.tipo-link', function(e){
        e.preventDefault();

        let parent = $(this).closest('.ano-content');
        let anoId = $(this).data('ano-id');
        let tipoId = $(this).data('tipo-id');

        parent.find('.tipo-link').removeClass('active');
        $(this).addClass('active');

        carregarTabela(anoId, tipoId);
    });

    // Função para carregar tabela
    function carregarTabela(anoId, tipoId){
        let tabelaId = '#tabela-'+anoId;

        if($.fn.DataTable.isDataTable(tabelaId)){
            $(tabelaId).DataTable().destroy();
        }

        $(tabelaId+' tbody').html('<tr><td colspan="6" class="text-center"><i class="fa fa-spinner fa-spin fa-2x"></i><p>Carregando...</p></td></tr>');

        tables[anoId] = $(tabelaId).DataTable({
            processing: true,
            responsive: true,
            language: {
                url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/pt-BR.json",
                search: "🔍 Pesquisar:",
                lengthMenu: "📄 Mostrar _MENU_ registros",
                info: "📊 Mostrando _START_ a _END_ de _TOTAL_",
                paginate: {
                    first: "⏮",
                    last: "⏭",
                    next: "▶",
                    previous: "◀"
                }
            },
            ajax: {
                url: '/RegistoAcademico/configuracoes/tabela-valores/buscar',
                data: {
                    ano_id: anoId,
                    tipo_id: tipoId
                },
                dataSrc: function(json){
                    return json.data || json;
                },
                error: function(){
                    $(tabelaId+' tbody').html('<tr><td colspan="6" class="text-center text-danger"><i class="fa fa-exclamation-triangle"></i> Erro ao carregar dados</td></tr>');
                }
            },

            columns: [
                {
                    data: 'id',
                    orderable: false,
                    render: function(data, type, row){
                        let estado = row.estado;
                        let nome = row.nome;
                        let bloqueio = row.bloqueio;
                        let isGerada = (estado ==='Gerado');

                        let disabled = bloqueio==='Bloqueado'?'disabled' : '';
                        let checked = isGerada ? 'checked' : '';
                        return `<input type="checkbox" class="checkbox-aluno" data-id="${data}"  data-nome="${nome}"   ${checked} data-ano="${anoId}" ${disabled}>`;
                    },
                    className: 'text-center'
                },
                {
                    data: 'estado',
                    render: function(data){
                        let isGerada = (data ==='Gerado');
                        if(isGerada){
                            return '<span class="badge-gerada"><i class="fa fa-check-circle"></i>'+ (data || '—')+'</span>';
                        } else {
                            return '<span class="badge-pendente"><i class="fa fa-clock-o"></i>'+(data || '—')+'</span>';
                        }
                    },
                    className: 'text-center'
                },
                { data: 'id', className: 'text-center fw-bold' },
                {
                    data: 'nome',
                    render: function(data){
                        return '<i class="fa fa-user-circle-o text-primary" style="margin-right: 0.5rem;"></i>' + (data || '—');
                    }
                },
                {
                    data: 'classe',
                    render: function(data){
                        return '<span class="badge bg-info text-white">' + (data || '—') + '</span>';
                    }
                },
                {
                    data: 'turma',
                    // render: function(data){
                    //     return '<i class="fa fa-group text-success" style="margin-right: 0.3rem;"></i> ' + (data || '—');
                    // }
                }
            ],
            order: [[2, 'asc']],
            pageLength: 15,
            lengthMenu: [[10, 15, 25, 50, -1], [10, 15, 25, 50, "Todos"]],
            drawCallback: function(){
                atualizarContagemSelecionados(anoId);
                atualizarEstadoCheckboxTopo(anoId);

                $(tabelaId + ' .checkbox-aluno').off('change').on('change', function(){
                    atualizarContagemSelecionados(anoId);
                    atualizarEstadoCheckboxTopo(anoId);
                });
            },
            initComplete: function(){
                let api = this.api();

                api.columns().every(function(index){
                    if(index === 0) return;

                    let column = this;
                    let footer = $(column.footer());

                    footer.empty();

                    let valores = column.data().unique().sort();

                    if(valores.length > 0){
                        let select = $('<select class="form-select"><option value="">📋 Todos</option></select>')
                            .appendTo(footer)
                            .on('change', function(){
                                let val = $.fn.dataTable.util.escapeRegex($(this).val());
                                column.search(val ? '^'+val+'$' : '', true, false).draw();
                                setTimeout(() => {
                                    atualizarContagemSelecionados(anoId);
                                    atualizarEstadoCheckboxTopo(anoId);
                                }, 100);
                            });

                        valores.each(function(d){
                            let texto = $('<div>').html(d).text().trim();
                            if(texto !== '' && texto !== '—'){
                                select.append('<option value="'+texto+'">'+texto+'</option>');
                            }
                        });
                    } else {
                        footer.html('<span class="text-muted">—</span>');
                    }
                });
            }
        });

        setTimeout(() => {
            $('#checkAllTopo-'+anoId).off('change').on('change', function(){
                let isChecked = $(this).prop('checked');
                let tabelaId = '#tabela-'+anoId;
                $(tabelaId + ' tbody tr:visible .checkbox-aluno:not(:disabled)').prop('checked', isChecked);
                atualizarContagemSelecionados(anoId);
            });
        }, 100);
    }

    // Atualizar contagem de selecionados
    function atualizarContagemSelecionados(anoId){
        let tabelaId = '#tabela-'+anoId;
        let selecionados = $(tabelaId + ' .checkbox-aluno:checked:not(:disabled)').length;
        $('#selectedCount-'+anoId).text(selecionados);

        if(selecionados > 0){
            $('#massActionsBar-'+anoId).slideDown(200);
        } else {
            $('#massActionsBar-'+anoId).slideUp(200);
        }
    }

    // Atualizar estado do checkbox do topo
    function atualizarEstadoCheckboxTopo(anoId){
        let tabelaId = '#tabela-'+anoId;
        let chkTopo = $('#checkAllTopo-'+anoId);
        let totalVisiveis = $(tabelaId + ' tbody tr:visible .checkbox-aluno:not(:disabled)').length;
        let selecionadosVisiveis = $(tabelaId + ' tbody tr:visible .checkbox-aluno:checked:not(:disabled)').length;

        if(totalVisiveis === 0){
            chkTopo.prop('checked', false);
            chkTopo.prop('indeterminate', false);
        } else if(selecionadosVisiveis === totalVisiveis){
            chkTopo.prop('checked', true);
            chkTopo.prop('indeterminate', false);
        } else if(selecionadosVisiveis > 0 && selecionadosVisiveis < totalVisiveis){
            chkTopo.prop('checked', false);
            chkTopo.prop('indeterminate', true);
        } else {
            chkTopo.prop('checked', false);
            chkTopo.prop('indeterminate', false);
        }
    }

    // Marcar todos da página
    window.marcarTodosPagina = function(anoId){
        let tabelaId = '#tabela-'+anoId;
        $(tabelaId + ' tbody tr:visible .checkbox-aluno:not(:disabled)').prop('checked', true);
        atualizarContagemSelecionados(anoId);
        atualizarEstadoCheckboxTopo(anoId);

        Swal.fire({
            icon: 'success',
            title: 'Marcados!',
            text: 'Todos os alunos visíveis foram selecionados.',
            timer: 1500,
            showConfirmButton: false
        });
    }

    // Desmarcar todos da página
    window.desmarcarTodosPagina = function(anoId){
        let tabelaId = '#tabela-'+anoId;
        $(tabelaId + ' tbody tr:visible .checkbox-aluno:not(:disabled)').prop('checked', false);
        atualizarContagemSelecionados(anoId);
        atualizarEstadoCheckboxTopo(anoId);

        Swal.fire({
            icon: 'info',
            title: 'Desmarcados!',
            text: 'Todos os alunos visíveis foram desmarcados.',
            timer: 1500,
            showConfirmButton: false
        });
    }

    // Gerar referências dos selecionados
    window.gerarSelecionados = function(anoId){
        let tabelaId = '#tabela-'+anoId;
        let selecionados = [];
        let nomes = [];

        $(tabelaId + ' .checkbox-aluno:checked:not(:disabled)').each(function(){
            selecionados.push($(this).data('id'));
            nomes.push($(this).data('nome'));
        });

        if(selecionados.length === 0){
            Swal.fire({
                icon: 'warning',
                title: 'Atenção!',
                text: 'Selecione pelo menos um aluno pendente.'
            });
            return;
        }

        Swal.fire({
            title: 'Confirmar',
            text: `Deseja Adicionar o Pagamento para ${selecionados.length} aluno(s)?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Sim, gerar',
            cancelButtonText: 'Cancelar',
            confirmButtonColor: '#667eea'
        }).then((result) => {
            if(result.isConfirmed){
                processarComBarraProgresso(selecionados,nomes ,anoId);
            }
        });
    }

    // Processar com barra de progresso
    async function processarComBarraProgresso(alunos,nomes, anoId){
        // Mostrar overlay
        $('#progressOverlay').fadeIn(300);

        let total = alunos.length;
        let sucessos = 0;
        let erros = 0;
        let tipoId = $('#ano-'+anoId+' .tipo-link.active').data('tipo-id');

        // Resetar estatísticas
        $('#progressTotal').text(total);
        $('#progressCurrent').text('0');
        $('#successCount').text('0');
        $('#errorCount').text('0');
        $('#progressBar').css('width', '0%').text('0%');
        $('#currentProcessing').html('<i class="fa fa-clock-o"></i> Iniciando processamento...');

        // Processar sequencialmente
        for(let i = 0; i < total; i++){
            let alunoId = alunos[i];
            let nome = nomes[i];
            let percentual = Math.round(((i + 1) / total) * 100);

            // Atualizar progresso
            $('#progressCurrent').text(i + 1);
            $('#progressBar').css('width', percentual + '%').text(percentual + '%');
            $('#currentProcessing').html(`<i class="fa fa-spinner fa-spin"></i> Processando aluno: ${nome}...`);

            try {
                let resultado = await $.ajax({
                    url: '{{ url("/RegistoAcademico/configuracoes/tabela-valores/registar_pagamentos") }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        tipo_id: tipoId,
                        id: alunoId
                    },
                    timeout: 30000
                });

                if(resultado.success){
                    sucessos++;
                    $('#successCount').text(sucessos);
                    $('#currentProcessing').html(`<i class="fa fa-check-circle text-success"></i> Aluno ${alunoId} processado com sucesso!`);
                } else {
                    erros++;
                    $('#errorCount').text(erros);
                    $('#currentProcessing').html(`<i class="fa fa-exclamation-circle text-danger"></i> Erro no aluno ${alunoId}: ${resultado.message || 'Falha desconhecida'}`);
                }
            } catch(error) {
                erros++;
                $('#errorCount').text(erros);
                let msg = error.responseJSON?.message || error.statusText || 'Erro de conexão';
                $('#currentProcessing').html(`<i class="fa fa-exclamation-circle text-danger"></i> Erro no aluno ${alunoId}: ${msg}`);
                console.error(`Erro no aluno ${alunoId}:`, error);
            }

            // Delay para não sobrecarregar
            await new Promise(resolve => setTimeout(resolve, 200));
        }

        // Finalizar
        setTimeout(() => {
            $('#progressOverlay').fadeOut(300);

            let mensagem = '';
            let icone = 'success';

            if(erros === 0){
                mensagem = `<div style="text-align: center">
                    <i class="fa fa-check-circle" style="font-size: 3rem; color: #48bb78;"></i>
                    <p style="margin-top: 1rem;"><strong>${sucessos}</strong> de <strong>${total}</strong>  geradas com sucesso!</p>
                </div>`;
            } else if(sucessos === 0){
                mensagem = `<div style="text-align: center">
                    <i class="fa fa-times-circle" style="font-size: 3rem; color: #f56565;"></i>
                    <p style="margin-top: 1rem;"><strong>Falha</strong> ao gerar todas as ${erros} Pagamento.</p>
                </div>`;
                icone = 'error';
            } else {
                mensagem = `<div style="text-align: center">
                    <i class="fa fa-exclamation-triangle" style="font-size: 3rem; color: #ed8936;"></i>
                    <p style="margin-top: 1rem;"><strong>${sucessos}</strong> sucessos, <strong>${erros}</strong> falhas</p>
                </div>`;
                icone = 'warning';
            }

            Swal.fire({
                icon: icone,
                title: 'Processamento Concluído',
                html: mensagem,
                confirmButtonColor: '#667eea'
            }).then(() => {
                let tipoId = $('#ano-'+anoId+' .tipo-link.active').data('tipo-id');
                carregarTabela(anoId, tipoId);
            });
        }, 300);
    }

    // Iniciar automaticamente
    setTimeout(() => {
        $('.ano-link.active').click();
    }, 200);

});
</script>

@endsection
