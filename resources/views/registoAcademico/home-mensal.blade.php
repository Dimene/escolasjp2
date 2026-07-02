<?php

$dadosInfo = session()->get('nomeEm');
$avatar = session()->get('infosession')[0]->avatar;

?>
@extends('layouts.admin-Lti')
@section('title', $tipode . ' ' . $tipodepagamentodados->Descricao . ' de ' . $data1 . ' a ' . $data2 . ' Usuario:' .
    auth()->user()->name)

@section('content')

<section class="content">
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid shadow-no">
                <div class="row mb-2">
                    <div class="col-sm-6">

                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Histórico</li>
                            <li class="breadcrumb-item active">{{ $tipode }}</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class=" col-md-12">
            <div class="card px-3  no-shadow">
                <div class="card-body">
                    <h5 class="card-title"> <h3>{{ $tipode }} de {{ $tipodepagamentodados->Descricao }}</h3></h5>

                    <table id="listadosalunos" class="tabledisplay no-shadow table table-light container-fluid display responsive nowrap ">
                        <thead>
                            <tr>
                                <th>Nr</th>
                                <th>Nome</th>
                                <th>Classe</th>
                                <th>Mês</th>
                                <th>Preço</th>
                                <th>Multa</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($colect as $key => $dadosItem)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $dadosItem['nome'] }}</td>
                                    <td>{{ $dadosItem['classe'] }}</td>
                                    <td>{{ $dadosItem['meses'] }}</td>
                                    <td>{{ $dadosItem['dadosValor'] }}</td>
                                    <td>{{ $dadosItem['Multa'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th></th>
                                <th>
                                    <select class="form-control filter-column" data-column="1">
                                        <option value="">Todos</option>
                                    </select>
                                </th>
                                <th>
                                    <select class="form-control filter-column" data-column="2">
                                        <option value="">Todos</option>
                                    </select>
                                </th>
                                <th>
                                    <select class="form-control filter-column" data-column="3">
                                        <option value="">Todos</option>
                                    </select>
                                </th>
                                <th id="totalPreco" style="text-align:right"></th>
                                <th id="totalMulta" style="text-align:right"></th>
                            </tr>
                        </tfoot>
                    </table>

                </div>
            </div>
        </div>
    </div>
</section>

@push('script')
  <!-- JS do DataTables Responsive -->

  <!-- jQuery -->
  {{--  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>  --}}
  <!-- JS do DataTables -->
  {{--  <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>  --}}
  <!-- JS do DataTables Responsive -->
  <script src="{{ asset('Admin-LTE/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('Datatable/js/dataTables.responsive.min.js') }}"></script>
<script>
    $('#listadosalunos').DataTable({
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'copy',
                text: '<i class="fa fa-copy"></i> Copiar',
                className: 'btn btn-primary'
            },
            {
                extend: 'csv',
                text: '<i class="fa fa-csv-o"></i> CSV',
                className: 'btn btn-success',
                customize: function(csv) {
                    // Adiciona apenas os valores no CSV
                    let footerData = [];
                    $('#listadosalunos tfoot th').each(function() {
                        footerData.push($(this).text().trim());
                    });
                    // Somente os valores de preço e multa
                    return csv + '\n' + footerData[3] + ',' + footerData[4];
                }
            },
            {
                extend: 'excel',
                text: '<i class="fa fa-file-excel"></i> Excel',
                className: 'btn btn-info',
                customize: function(xlsx) {
                    let sheet = xlsx.xl.worksheets['sheet1.xml'];
                    let lastRow = $('row', sheet).last();
                    let footerData = [];
                    $('#listadosalunos tfoot th').each(function() {
                        footerData.push($(this).text().trim());
                    });
                    // Somente os valores de preço e multa
                    let footerRow = `<row>${footerData[3]} | ${footerData[4]}</row>`;
                    lastRow.after(footerRow);
                }
            },
            {
                extend: 'pdf',
                text: '<i class="fa fa-file-pdf"></i> PDF',
                className: 'btn btn-danger',
                customize: function(doc) {
                    let footerData = [];
                    $('#listadosalunos tfoot th').each(function() {
                        footerData.push($(this).text().trim());
                    });
                    // Somente os valores de preço e multa
                    let footerRow = footerData[3] + ' | ' + footerData[4];
                    doc.content[1].table.body.push([footerRow.split('|')]);
                }
            },
            {
                extend: 'print',
                text: '<i class="fa fa-print"></i> Imprimir',
                className: 'btn btn-warning',
                customize: function(win) {
                    $(win.document.body).find('table').append($(document).find('#listadosalunos tfoot').clone());
                    $(win.document.body).find('tfoot').css({
                        'font-weight': 'bold',
                        'text-align': 'right'
                    });
                }
            }
        ],
        responsive: true,
        paging: true,
        lengthChange: true,
        searching: true,
        ordering: true,
        info: true,
        autoWidth: true,
        lengthMenu: [
            [10, 25, 50, 100, -1],
            [10, 25, 50, 100, "All"]
        ],
        language: {
            lengthMenu: "Visualizar _MENU_",
            zeroRecords: "Nada foi encontrado",
            info: "Mostrando página _PAGE_ de _PAGES_",
            processing: "Processando...",
            infoEmpty: "Nada disponível",
            infoFiltered: "(filtrado de _MAX_ registros totais)",
            loadingRecords: "Carregando...",
            search: "Pesquisar:",
            paginate: {
                first: "Primeira",
                last: "Última",
                next: "Próxima",
                previous: "Anterior"
            }
        },
        initComplete: function() {
            this.api().columns([1, 2, 3]).every(function() {
                var column = this;
                var select = $('.filter-column[data-column="' + column.index() + '"]');

                column.data().unique().sort().each(function(d, j) {
                    select.append('<option value="' + d + '">' + d + '</option>');
                });

                select.on('change', function() {
                    var val = $.fn.dataTable.util.escapeRegex($(this).val());
                    column.search(val ? '^' + val + '$' : '', true, false).draw();
                });
            });
        },
        footerCallback: function(row, data, start, end, display) {
            var api = this.api();

            var intVal = function(i) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '') * 1 :
                    typeof i === 'number' ? i : 0;
            };

            // Cálculo do total para as colunas Preço e Multa
            var totalPreco = api
                .column(4, { page: 'current' })
                .data()
                .reduce(function(a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

            var totalMulta = api
                .column(5, { page: 'current' })
                .data()
                .reduce(function(a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

            // Exibindo os valores totais no rodapé
            $(api.column(4).footer()).html('MT ' + totalPreco.toFixed(2));
            $(api.column(5).footer()).html('MT ' + totalMulta.toFixed(2));
        }
    });
</script>


@endpush
@endsection
