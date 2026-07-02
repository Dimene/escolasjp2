<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DataTables Editor Example</title>
    <!-- DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">

    <!-- DataTables Editor CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/editor/2.0.10/css/editor.dataTables.min.css">

</head>

<body>
    <table id="tabela" class="display" style="width:100%">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Idade</th>
                <th>Data Nascimento</th>
                <th>Posição</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
    <script src="{{ asset('Datatable/js/jquery-3.5.1.js') }}"></script>
    <script src="{{ asset('Datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('Datatable/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('Datatable/js/buttons.flash.min.js') }}"></script>
    <script src="{{ asset('Datatable/js/jszip.min.js') }}"></script>
    <script src="{{ asset('Datatable/js/pdfmake.min.js') }}"></script>
    <script src="{{ asset('Datatable/js/vfs_fonts.js') }}"></script>
    <script src="{{ asset('Datatable/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('Datatable/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('Datatable/js/buttons.colVis.min.js') }}"></script>
    <script src="https://unpkg.com/mathjs/lib/browser/math.js"></script>

    <script src="{{ asset('MyJs/math.js') }}"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/3.0.1/js/dataTables.buttons.js">
    </script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/select/2.0.0/js/dataTables.select.js">
    </script>
    <script type="text/javascript" charset="utf8"
        src="https://cdn.datatables.net/datetime/1.5.2/js/dataTables.dateTime.min.js"></script>

    <!-- DataTables Editor JavaScript -->
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/editor/2.0.10/js/dataTables.editor.js">
    </script>
    <script>
        $(document).ready(function() {
            var editor = new $.fn.dataTable.Editor({
                ajax: "/RegistoAcademico/notas/disciplinas/notasTrimestrais/ajax/dados/371",
                table: "#tabela",
                fields: [{
                        label: "Nome:",
                        name: "nome"
                    },
                    {
                        label: "Idade:",
                        name: "idade"
                    },
                    {
                        label: "Data Nascimento:",
                        name: "Datadenascimento"
                    },
                    {
                        label: "Posição:",
                        name: "posicao"
                    }
                ]
            });

            const table = $("#tabela").DataTable({
                ajax: "/RegistoAcademico/notas/disciplinas/notasTrimestrais/ajax/dados/371",
                columns: [{
                        data: "nome"
                    },
                    {
                        data: "idade"
                    },
                    {
                        data: "Datadenascimento"
                    },
                    {
                        data: "posicao"
                    }
                ],
                select: true,
                buttons: [{
                        extend: "create",
                        editor: editor
                    },
                    {
                        extend: "edit",
                        editor: editor
                    },
                    {
                        extend: "remove",
                        editor: editor
                    }
                ],
                order: [
                    [1, 'asc']
                ]
            });
        });
    </script>
</body>

</html>
