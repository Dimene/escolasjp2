@extends('layouts.admin-Lti')
@section('title', 'Minsalidades')
@section('content')

<link  rel="stylesheet" href="jquery.dataTables.min.css"/>
<link  rel="stylesheet"  href="buttons.dataTables.min.css"/>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid ">
      <div class="row mb-2">
        <div class="col-sm-4">
          <h3 class="m-0 text-dark"></h3>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Registo Académico</a></li>
            <li class="breadcrumb-item active"> Alunos inscritos </li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <div class="content  container-fluid col-md-8">
    <div class=" container  no-border no-shadow card-body" style="background-color: #fff">



        <table id="listadosalunos" class="display no-shadow table-responsive container-fluid" >
            <thead>
            <tr>
                <th>Nr.</th>
                <th >nome</th>

                <th>Tipo</th>
                <th>{{ carbon\Carbon::now()->monthName }}</th>
                <th>Acções</th>
                </tr>
            </thead>
            <tbody>

                @foreach($alunosInscritos->all() as $key => $valuealunosInscritos)

            <tr>
                <td>{{ $key+1 }}</td>
                <td>{{ $valuealunosInscritos->nome }}</td>

                <td>@if( $valuealunosInscritos->Tipo=="N")

                    {{ "Normal" }}
                    @else
                    {{ "Bolseiro" }}
                    @endif

                </td>

<td>


      nao pago

</td>

                <td  class="">


                    <a class="btn btn-outline-primary"   target="_blink"
                     href="{{ Route('mensalida.show', $valuealunosInscritos->id) }}"><i class="fa fa-upload" title="pagar mensalidade"> </i></a>
                    <a  class="btn btn-primary" title="visualizar mensalidades"  href="{{ Route('mensalida.edit', $valuealunosInscritos->id) }}"><i class="fa fa-eye"></i></a>



                </td>
            </tr>
                @endforeach
            </tbody>

            <tfoot>
            <tr>
                <th>Nr.</th>
                <th>nome</th>

                <th>Tipo</th>
                <th>{{ carbon\Carbon::now()->monthName }}</th>

                <th>Acções</th>
                </tr>
            </tfoot>
                </table>




</div>



  </div>
</div>




<script src="{{ asset('Datatable/js/jquery-3.5.1.js')}}"></script>
<script src="{{ asset('Datatable/js/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('Datatable/js/dataTables.buttons.min.js')}}"></script>
<script src="{{ asset('Datatable/js/buttons.flash.min.js')}}"></script>
<script src="{{ asset('Datatable/js/jszip.min.js')}}"></script>
<script src="{{ asset('Datatable/js/pdfmake.min.js')}}"></script>
<script src="{{ asset('Datatable/js/vfs_fonts.js')}}"></script>
<script src="{{ asset('Datatable/js/buttons.html5.min.js')}}"></script>
<script src="{{ asset('Datatable/js/buttons.print.min.js')}}"></script>

	<script>


	$(document).ready(function() {
        $('#listadosalunos').DataTable( {
            dom: 'Bfrtip',

            buttons: [

                 'copy', 'csv', 'excel', 'pdf','print'
            ],


            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": false,
            "autoWidth": true,
            "lengthMenu": [[5, 10, 25, 50, -1], [5,10, 25, 50, "All"]],
            language: {
              "lengthMenu": "visualizar _MENU_ ",
              "zeroRecords": "Nada foi encontado",
              "info": "mostrara pagina por pagina",
              "processing":     "processando..",
              "infoEmpty": "Nada tem ",
              "infoFiltered": "(filtered from _MAX_ total records)",
              "loadingRecords": "processando...",
              "search":         "pesquisar:",
              "paginate": {
          "first":      "primera",
          "last":       "ultima",
          "next":       "proxima",
          "previous":   " Anterior"
        },
          },
            initComplete: function () {
                this.api().columns([1,2,3,4,]).every( function () {
                    var column = this;
                    var select = $('<select  class="SelectorSerach"><option value=""></option></select>')
                        .appendTo( $(column.footer()).empty() )
                        .on( 'change', function () {
                            var val = $.fn.dataTable.util.escapeRegex(
                                $(this).val()
                            );

                            column
                                .search( val ? '^'+val+'$' : '', true, false )
                                .draw();
                        } );

                    column.data().unique().sort().each( function ( d, j ) {
                        select.append( '<option value="'+d+'">'+d+'</option>' )
                    } );
                } );
            }
        } );
    } );

    </script>

    @endsection
