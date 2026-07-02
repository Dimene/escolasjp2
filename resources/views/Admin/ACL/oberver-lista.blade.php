@php
    use App\Models\registoAcademico\tipos_pagamentos;
    use Illuminate\Support\Facades\DB;
    use Carbon\Carbon;
@endphp

<style>
    .operations-container {
        /* background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); */
        border-radius: 20px;
        padding: 20px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.1);
    }

    .operations-card {
        background: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 5px 20px rgba(0,0,0,0.08);
    }

    .operations-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 20px;
        border-bottom: none;
    }

    .operations-header h4 {
        margin: 0;
        font-weight: 600;
    }

    .operations-header small {
        opacity: 0.9;
        font-size: 0.85rem;
    }

    .badge-action {
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 100%;
        display: inline-block;
    }

    .badge-create { background: linear-gradient(135deg, #10b981, #059669); color: white; }
    .badge-update { background: linear-gradient(135deg, #f59e0b, #d97706); color: white; }
    .badge-delete { background: linear-gradient(135deg, #ef4444, #dc2626); color: white; }
    .badge-view { background: linear-gradient(135deg, #3b82f6, #2563eb); color: white; }
    .badge-default { background: linear-gradient(135deg, #6b7280, #4b5563); color: white; }

    .info-row {
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .info-row:hover {
        background: linear-gradient(90deg, #f3f4f6, #e5e7eb);
        transform: translateX(5px);
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .detail-link {
        background: linear-gradient(135deg, #667eea, #764ba2);
        border: none;
        transition: all 0.3s ease;
    }

    .detail-link:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
    }

    .empty-state {
        text-align: center;
        padding: 60px 20px;
        background: white;
        border-radius: 15px;
    }

    .empty-state i {
        font-size: 64px;
        color: #d1d5db;
        margin-bottom: 20px;
    }

    .empty-state h4 {
        color: #6b7280;
        margin-bottom: 10px;
    }

    .empty-state p {
        color: #9ca3af;
    }

    /* Garantir que as larguras das colunas sejam respeitadas */
    #lista_operacoes {
        table-layout: fixed;
        width: 100%;
    }

    #lista_operacoes thead th,
    #lista_operacoes tbody td,
    #lista_operacoes tfoot th {
        vertical-align: middle;
    }

    /* Para telas menores, ajustar o comportamento */
    @media (max-width: 768px) {
        #lista_operacoes {
            table-layout: auto;
        }

        #lista_operacoes thead th,
        #lista_operacoes tbody td,
        #lista_operacoes tfoot th {
            min-width: 100px;
        }

        .btn .d-none {
            display: inline !important;
        }
    }

    /* Tooltip customizado */
    [data-toggle="tooltip"] {
        cursor: help;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .operations-card {
        animation: fadeInUp 0.5s ease;
    }

    .dataTables_wrapper {
        padding: 20px;
    }

    .dataTables_filter input {
        border-radius: 20px;
        padding: 8px 15px;
        border: 1px solid #e5e7eb;
        transition: all 0.3s ease;
    }

    .dataTables_filter input:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        outline: none;
    }

    .dt-buttons button {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        border: none;
        border-radius: 8px;
        padding: 6px 12px;
        margin: 0 3px;
        transition: all 0.3s ease;
    }

    .dt-buttons button:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
    }
</style>

<div class="operations-container">
    <div class="operations-card">


        @if(!empty($oberveroperacoes) && count($oberveroperacoes) > 0)
        <div class="table-responsive">
            <table id="lista_operacoes" class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th width="10%"><i class="fas fa-tag"></i> Área</th>
                        <th width="10%"><i class="fas fa-cog"></i> Operação</th>
                        <th width="10%"><i class="far fa-calendar-alt"></i> Data</th>
                        <th width="10%"><i class="fas fa-user"></i> Registo</th>
                        {{-- <th width="10%"><i class="fas fa-eye"></i> Ações</th> --}}
                    </tr>
                </thead>
                <tbody>
                    @foreach($oberveroperacoes as $key => $value)
                    <tr class="info-row">
                        <!-- Área -->
                        <td width="10%">
                            @php
                                $areaIcon = [
                                    'user' => 'fa-user',
                                    'Aluno' => 'fa-graduation-cap',
                                    'pagamento' => 'fa-money-bill-wave',
                                    'default' => 'fa-folder'
                                ];
                                $icon = $areaIcon[$value->model] ?? $areaIcon['default'];
                            @endphp
                            <div class="d-flex align-items-center">
                                <i class="fas {{ $icon }} text-primary me-2"></i>
                                <span class="text-truncate" style="max-width: 100px;" title="{{ $value->model ?? 'N/A' }}">
                                    {{ $value->model ?? 'N/A' }}
                                </span>
                            </div>
                        </td>

                        <!-- Operação -->
                        <td width="10%">
                            @php
                                $actionClass = '';
                                $actionIcon = '';
                                switch($value->action) {
                                    case 'create':
                                        $actionClass = 'badge-create';
                                        $actionIcon = 'fa-plus-circle';
                                        $actionText = 'Criado';
                                        break;
                                    case 'update':
                                        $actionClass = 'badge-update';
                                        $actionIcon = 'fa-edit';
                                        $actionText = 'Atualizado';
                                        break;
                                    case 'delete':
                                        $actionClass = 'badge-delete';
                                        $actionIcon = 'fa-trash-alt';
                                        $actionText = 'Eliminado';
                                        break;
                                    case 'view':
                                        $actionClass = 'badge-view';
                                        $actionIcon = 'fa-eye';
                                        $actionText = 'Visualizado';
                                        break;
                                    default:
                                        $actionClass = 'badge-default';
                                        $actionIcon = 'fa-info-circle';
                                        $actionText = ucfirst($value->action ?? 'N/A');
                                }
                            @endphp
                            <span class="badge-action {{ $actionClass }}">
                                <i class="fas {{ $actionIcon }}"></i>
                                {{ $actionText }}
                            </span>
                        </td>

                        <!-- Data -->
                        <td width="10%">
                            <div class="small">
                                <div class="text-nowrap">
                                    <i class="far fa-clock text-muted me-1"></i>
                                    <span title="{{ $value->created_at }}" class="fw-semibold">
                                        {{ $value->created_at ? Carbon::parse($value->created_at)->format('d/m/Y') : 'N/A' }}
                                    </span>
                                </div>
                                <div class="text-muted" style="font-size: 0.7rem;">
                                    {{ $value->created_at ? Carbon::parse($value->created_at)->format('H:i:s') : '' }}
                                </div>
                            </div>
                        </td>

                        <!-- Registo -->
                        <td width="10%">
                            @php
                                $displayText = '';
                                $displayIcon = 'fa-user-circle';
                                $hasError = false;

                                if($value->model == "user" && isset($value->usuarios)) {
                                    $displayText = $value->usuarios->name;
                                    $displayIcon = 'fa-user-check';
                                }
                                elseif($value->model == "Aluno") {
                                    $dado = DB::table("alunosescritos")->where("idAlunoclasse", $value->register)->first();
                                    if($dado) {
                                        $displayText = $dado->nome;
                                        $displayIcon = 'fa-graduation-cap';
                                    } else {
                                        $displayText = 'ID: ' . $value->register;
                                        $displayIcon = 'fa-exclamation-triangle';
                                        $hasError = true;
                                    }
                                }
                                elseif($value->model && tipos_pagamentos::where("Descricao", $value->model)->exists()) {
                                    $tipoPagamento = tipos_pagamentos::where("Descricao", $value->model)->first();
                                    if($tipoPagamento && $tipoPagamento->id > 2) {
                                        $dado = DB::table("outros_pagamentosview")
                                            ->where("aluno_classe_id", $value->register)
                                            ->whereDate("updated_at", Carbon::parse($value->created_at))
                                            ->first();
                                        if($dado) {
                                            $displayText = $dado->nome;
                                            $displayIcon = 'fa-money-bill-wave';
                                        } else {
                                            $displayText = 'ID: ' . $value->register;
                                            $displayIcon = 'fa-exclamation-circle';
                                            $hasError = true;
                                        }
                                    } else {
                                        $displayText = $value->model;
                                        $displayIcon = 'fa-tag';
                                    }
                                }
                                else {
                                    $displayText = $value->model ?? 'N/A';
                                    $displayIcon = 'fa-question-circle';
                                }
                            @endphp
                            <div class="d-flex align-items-center">
                                <i class="fas {{ $displayIcon }} {{ $hasError ? 'text-danger' : 'text-success' }} me-2"></i>
                                <div class="text-truncate" style="max-width: 100px;" title="{{ $displayText }}">
                                    @if($hasError)
                                        <span class="text-danger">{{ $displayText }}</span>
                                    @else
                                        {{ $displayText }}
                                    @endif
                                </div>
                            </div>
                            @if($hasError)
                                <div class="text-danger small mt-1" style="font-size: 0.65rem;">
                                    <i class="fas fa-info-circle"></i> Registo não encontrado
                                </div>
                            @endif
                        </td>

                        <!-- Ações -->
                        {{-- <td width="10%">
                            <a href="/admin/RegistoOperacoes/detalhes/{{ $value->register }}"
                               id="maisdetalhes-{{ $loop->index }}"
                               class="btn detail-link btn-sm text-white w-100"
                               data-toggle="tooltip"
                               data-placement="top"
                               title="Ver detalhes da operação">
                                <i class="fas fa-info-circle"></i>
                                <span class="d-none d-md-inline">Detalhes</span>
                            </a>
                        </td> --}}
                    </tr>
                    @endforeach
                </tbody>
                <tfoot class="table-light">
                    <tr>
                        <th width="10%">Área</th>
                        <th width="10%">Operação</th>
                        <th width="10%">Data</th>
                        <th width="10%">Registo</th>
                        {{-- <th width="10%">Ações</th> --}}
                    </tr>
                </tfoot>
            </table>
        </div>
        @else
        <div class="empty-state">
            <i class="fas fa-inbox"></i>
            <h4>Nenhuma operação registada</h4>
            <p>Não há atividades para mostrar no momento.</p>
            <small class="text-muted">As operações aparecerão aqui quando houver atividades no sistema.</small>
        </div>
        @endif
    </div>
</div>

<script>
    $(document).ready(function() {
        // Inicializar tooltips
        $('[data-toggle="tooltip"]').tooltip();

        @if(!empty($oberveroperacoes) && count($oberveroperacoes) > 0)
        if ($('#lista_operacoes tbody tr').length > 0) {
            $('#lista_operacoes').DataTable({
                dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'Bf>>" +
                     "<'row'<'col-sm-12'tr>>" +
                     "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                buttons: [
                    {
                        extend: 'copy',
                        text: '<i class="fas fa-copy"></i> Copiar',
                        className: 'btn-sm'
                    },
                    {
                        extend: 'csv',
                        text: '<i class="fas fa-file-csv"></i> CSV',
                        className: 'btn-sm'
                    },
                    {
                        extend: 'excel',
                        text: '<i class="fas fa-file-excel"></i> Excel',
                        className: 'btn-sm'
                    },
                    {
                        extend: 'pdf',
                        text: '<i class="fas fa-file-pdf"></i> PDF',
                        className: 'btn-sm'
                    },
                    {
                        extend: 'print',
                        text: '<i class="fas fa-print"></i> Imprimir',
                        className: 'btn-sm'
                    },
                    {
                        extend: 'colvis',
                        text: '<i class="fas fa-columns"></i> Colunas',
                        className: 'btn-sm'
                    }
                ],
                "paging": true,
                "pageLength": 5,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "lengthMenu": [
                    [5, 25, 50, 100, -1],
                    [5, 25, 50, 100, "Todos"]
                ],
                language: {
                    "lengthMenu": "Mostrar _MENU_ registros por página",
                    "zeroRecords": "Nenhum registro encontrado",
                    "info": "Mostrando página _PAGE_ de _PAGES_",
                    "infoEmpty": "Nenhum registro disponível",
                    "infoFiltered": "(filtrado de _MAX_ registros totais)",
                    "search": "Pesquisar:",
                    "searchPlaceholder": "Digite para buscar...",
                    "loadingRecords": "Carregando...",
                    "processing": "Processando...",
                    "paginate": {
                        "first": "« Primeira",
                        "last": "Última »",
                        "next": "Próxima ›",
                        "previous": "‹ Anterior"
                    },
                    "aria": {
                        "sortAscending": ": ativar para ordenar coluna ascendente",
                        "sortDescending": ": ativar para ordenar coluna descendente"
                    }
                },
                order: [[2, 'desc']],
                initComplete: function() {
                    this.api().columns([0,1,2]).every(function() {
                        var column = this;
                        var select = $('<select class="form-select form-select-sm mt-2"><option value="">Todos</option></select>')
                            .appendTo($(column.footer()).empty())
                            .on('change', function() {
                                var val = $.fn.dataTable.util.escapeRegex($(this).val());
                                column.search(val ? '^' + val + '$' : '', true, false).draw();
                            });

                        column.data().unique().sort().each(function(d, j) {
                            if (d) {
                                var text = typeof d === 'string' ? d : $(d).text();
                                if (text && text.trim()) {
                                    select.append('<option >' + text.trim() + '</option>');
                                }
                            }
                        });
                    });
                }
            });

            $('.dt-buttons').addClass('mb-3');
            $('.dataTables_filter').addClass('mb-3');
        }
        @endif

        $('.info-row').hide().fadeIn(500);
    });
</script>

<!-- Certifique-se de ter os estilos do Bootstrap, FontAwesome e DataTables carregados -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css">

<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.colVis.min.js"></script>
