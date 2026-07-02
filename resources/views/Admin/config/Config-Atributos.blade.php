
<?php
use App\http\controllers\Admin\configuraceosController;
$funcao = new configuraceosController();
$dados= $funcao->getLogoMarca();
$nomeEm=$dados->TIpoSistema;
?>

@extends('layouts.admin-Lti')
@section('title','-Historico')
@section('content')

<section class="content">

<ol class="breadcrumb">
<li class="breadcrumb-item"><a href="#"><span>{{ $dados->TIpoSistema }}</span></a></li>
<li class="breadcrumb-item active"><a><span><b>Config </b></span></a></li>
<li class="breadcrumb-item "><a><span><b>Atributos </b></span></a></li>
</ol>

<div class="row py-xl-3 col-md-12"  >
<div class="col-md-3">
<div class="card shadow-none">
    <div class="card-body">
<table id="example">
    <thead>
      <tr>
        <th>  Nome</th>
        <th> ac&ccedil;&otilde;es
        </th>
    </thead>

    <tbody>
    @foreach ( $categoria as   $categoriaItem)

<tr>
 <td>  {{ $categoriaItem->Descricao }}
 </td>
 <td>
 </td>

</tr>
    @endforeach
<tbody>
</table>
    </div>

</div>
</div>





<div class="col-md-6">
<div class="card  ">
    <div class="card-body">
        <center>
<label> Registar nova Categoria </label>
        </center>
        <div class="form-group">
            <label>Nome da Categoria </label>
<input type="text" class="form-control">
        </div>



    </div>

</div>
</div>





<div class="col-md-3 ">
    <div class="card  shadow-none">
        <div class="card-body">
            <center>
    <label> Lista dos Atributos </label>
            </center>
            <div class="form-group">

   <table id="example2">
    <thead>
        <tr>
        <th>
            Nome
        </th>
        <th>
            ac&ccedil;&otilde;es
        </th>
        </tr>
    </thead>

    <tbody>

@foreach ($atributos as  $atributosItem)


        <tr>
            <td>
{{ $atributosItem->Descricao }}
            </td>
            <td>
                cvcv
            </td>
        </tr>
        @endforeach
    </tbody>
   </table>
            </div>



        </div>

    </div>
    </div>
</div>
</section>


@push("scripts")




<script src="{{ asset('Datatable/js/jquery-3.5.1.js')}}"></script>
<script src="{{ asset('Datatable/js/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('Datatable/js/dataTables.buttons.min.js')}}"></script>
<script src="{{ asset('Datatable/js/buttons.flash.min.js')}}"></script>
<script src="{{ asset('Datatable/js/jszip.min.js')}}"></script>
<script src="{{ asset('Datatable/js/pdfmake.min.js')}}"></script>
<script src="{{ asset('Datatable/js/vfs_fonts.js')}}"></script>
<script src="{{ asset('Datatable/js/buttons.html5.min.js')}}"></script>
<script src="{{ asset('Datatable/js/buttons.print.min.js')}}"></script>
<script src="{{ asset('Datatable/js/buttons.colVis.min.js')}}"></script>
<script>
$(document).ready(function() {
  var urlindex ='{{Route('cliente.index')}}';
  var urlstore ='{{Route('cliente.store')}}';
  var token ='{{Session::token()}}';


    $(".recibo").click(function(){

         printDiv(parseInt($(this).attr("id")));
    });

        $('#example').DataTable( {



            "paging": true,
            "lengthChange": false,
            "searching": true,
            "ordering": true,
            "info": false,
            "autoWidth": true,
            "lengthMenu": [[5,], [5]],
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
          }

        } );






        $('#example2').DataTable( {

"paging": true,
"lengthChange": false,
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
}

    } );

})

    </script>
    <script>
function printDiv(dados) {


	  //var urldadoPrint ='{{Route('Venda.show','+dados+')}}';

			  $.ajax({
               url:'/estoque/Venda/'+dados+'/show',
               type: 'GET',

               success: function(response){


		var a = window.open('', '', 'height=500, width=500');
			a.document.write(''+response+'');
			a.document.close();
			a.print();

               }
           });


		}



</script>

<script src="{{ asset('MyJs/registoDeFornecedor.js')}}"></script>
@endpush

@push('style')
            <link rel="stylesheet" href="{{ asset('perfilView/assets/bootstrap/css/bootstrap.min.css')}}">
            <link rel="stylesheet" href="{{ asset('perfilView/assets/fonts/ionicons.min.css')}}">
            <link rel="stylesheet" href="{{ asset('perfilView/assets/css/styles.min.css')}}">
            @endpush
@endsection
